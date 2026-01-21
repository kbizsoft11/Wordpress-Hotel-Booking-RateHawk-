<?php

if ( ! class_exists( 'HotelAPI' ) ) {

class HotelAPI
{
    private $keyId;
    private $key;
    private $apiUrl;
    private $userIp;

    /* =======================
     * CONSTRUCTOR
     * ======================= */
    public function __construct()
    {
        if ( ! function_exists( 'worldota_get_creds' ) ) {
            throw new Exception( 'worldota_get_creds() function not found.' );
        }

        $creds = worldota_get_creds();

        $this->keyId  = $creds['key_id']  ?? '';
        $this->key    = $creds['key']     ?? '';
        $this->apiUrl = rtrim( $creds['api_url'] ?? '', '/' );

        if ( ! $this->keyId || ! $this->key || ! $this->apiUrl ) {
            throw new Exception( 'Worldota API credentials are missing.' );
        }

        $this->userIp = $this->getUserIp();
    }

    /* =======================
     * HELPERS
     * ======================= */

    private function getUserIp()
    {
        if ( ! empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {
            return $_SERVER['HTTP_CLIENT_IP'];
        }
        if ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        return $_SERVER['REMOTE_ADDR'] ?? '';
    }

    private function endpoint( $path )
    {
        return $this->apiUrl . $path;
    }

    public function cleanAndFormatName( $input )
    {
        $cleaned = preg_replace( '/[^a-zA-Z\s]/', '', (string) $input );
        $cleaned = str_replace( ' ', '', $cleaned );
        return ucfirst( strtolower( $cleaned ) );
    }

    private function generateUniqueCode()
    {
        return 'kbiz' . mt_rand( 10000, 99999 );
    }

    private function generateUUID4()
    {
        $data = random_bytes( 16 );
        $data[6] = chr( ord( $data[6] ) & 0x0f | 0x40 );
        $data[8] = chr( ord( $data[8] ) & 0x3f | 0x80 );
        return vsprintf( '%s%s-%s-%s-%s-%s%s%s', str_split( bin2hex( $data ), 4 ) );
    }

    /* =======================
     * HOTEL / SEARCH
     * ======================= */

    public function getSingleHotelDetails( $hotelId, $language = 'en' )
    {
        return $this->postCurlMethod(
            $this->endpoint( '/api/b2b/v3/hotel/info/' ),
            [
                'id'       => $hotelId,
                'language' => $language,
            ]
        );
    }

    public function getProfiles()
    {
        return $this->postCurlMethod(
            $this->endpoint( '/api/b2b/v3/profiles/list/' ),
            []
        );
    }

    public function getHotelPageBooking( $hotelId, $checkin, $checkout, $adults, $children = 0, $child_ages = [] )
    {
        if ( ! is_array( $child_ages ) ) {
            $child_ages = $child_ages ? array_map( 'intval', explode( ',', $child_ages ) ) : [];
        }

        return $this->searchCurlMethod(
            $this->endpoint( '/api/b2b/v3/search/hp/' ),
            [
                'checkin'   => $checkin,
                'checkout'  => $checkout,
                'guests'    => [
                    [
                        'adults'   => (int) $adults,
                        'children' => array_map( 'intval', $child_ages ),
                    ],
                ],
                'residency' => 'gb',
                'language'  => 'en',
                'id'        => $hotelId,
                'currency'  => 'USD',
            ]
        );
    }

    /* =======================
     * MULTICOMPLETE (RESTORED)
     * ======================= */

    public function getMulticomplete( $query, $language = 'en' )
    {
        if ( empty( $query ) ) {
            return [];
        }

        return $this->postCurlMethod(
            $this->endpoint( '/api/b2b/v3/search/multicomplete/' ),
            [
                'query'    => $query,
                'language' => $language,
            ]
        );
    }

    /* =======================
     * ORDER STATUS / CANCEL
     * ======================= */

    public function orderStatus( $partner_order_id )
    {
        return $this->searchCurlMethod(
            $this->endpoint( '/api/b2b/v3/hotel/order/info/' ),
            [
                'ordering' => [
                    'ordering_type' => 'asc',
                    'ordering_by'   => 'checkin_at',
                ],
                'pagination' => [
                    'page_size'   => 1,
                    'page_number' => 1,
                ],
                'search' => [
                    'partner_order_ids' => [ $partner_order_id ],
                ],
                'language' => 'en',
            ]
        );
    }

    public function cancelOrder( $partner_order_id )
    {
        return $this->searchCurlMethod(
            $this->endpoint( '/api/b2b/v3/hotel/order/cancel/' ),
            [ 'partner_order_id' => $partner_order_id ]
        );
    }

    /* =======================
     * BOOKING FINISH
     * ======================= */

    public function getBookingFinish( $partner_order_id, $payment_data, $details )
    {
        global $wpdb;

        $table = $wpdb->prefix . 'hawk_bookings';
        $row   = $wpdb->get_row(
            $wpdb->prepare(
                "SELECT * FROM {$table} WHERE partner_order_id = %s",
                $partner_order_id
            )
        );

        $guest_info = [];

        if ( $row && $row->user_information ) {
            $info = json_decode( $row->user_information, true );

            // Primary guest
            $guest_info[] = [
                'first_name' => $this->cleanAndFormatName( $info['first_name'] ?? '' ),
                'last_name'  => $this->cleanAndFormatName( $info['last_name'] ?? '' ),
            ];

            // Additional adults
            for ( $i = 1; $i < (int) ( $info['adults'] ?? 1 ); $i++ ) {
                $guest_info[] = [
                    'first_name' => $this->cleanAndFormatName( $info[ "guestFirstName{$i}" ] ?? '' ),
                    'last_name'  => $this->cleanAndFormatName( $info[ "guestLastName{$i}" ] ?? '' ),
                ];
            }

            // Children
            for ( $i = 1; $i <= (int) ( $info['children'] ?? 0 ); $i++ ) {
                $guest_info[] = [
                    'first_name' => $this->cleanAndFormatName( $info[ "childFirstName{$i}" ] ?? '' ),
                    'last_name'  => $this->cleanAndFormatName( $info[ "childLastName{$i}" ] ?? '' ),
                    'is_child'   => true,
                    'age'        => (int) ( $info[ "childAge{$i}" ] ?? 0 ),
                ];
            }
        }

        if ( empty( $guest_info ) ) {
            $guest_info[] = [
                'first_name' => $payment_data['given_name'] ?? '',
                'last_name'  => $payment_data['last_name'] ?? '',
            ];
        }

        return $this->searchCurlMethod(
            $this->endpoint( '/api/b2b/v3/hotel/order/booking/finish/' ),
            [
                'user' => [
                    'email' => $payment_data['payer_email'] ?? '',
                    'phone' => $details['phone'] ?? '',
                ],
                'partner' => [
                    'partner_order_id' => $partner_order_id,
                ],
                'language' => 'en',
                'rooms' => [
                    [ 'guests' => $guest_info ],
                ],
                'payment_type' => $payment_data['choosenptype'] ?? [],
            ]
        );
    }

    /* =======================
     * CURL CORE
     * ======================= */

    private function searchCurlMethod( $url, $data )
    {
        $ch = curl_init( $url );
        curl_setopt_array( $ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => json_encode( $data ),
            CURLOPT_USERPWD        => $this->keyId . ':' . $this->key,
            CURLOPT_HTTPHEADER     => [ 'Content-Type: application/json' ],
        ] );

        $response = curl_exec( $ch );

        if ( curl_errno( $ch ) ) {
            throw new Exception( curl_error( $ch ) );
        }

        curl_close( $ch );
        return json_decode( $response, true );
    }

    private function postCurlMethod( $url, $data )
    {
        return $this->searchCurlMethod( $url, $data );
    }
}

}
