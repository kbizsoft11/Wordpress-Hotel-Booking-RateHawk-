<?php
/**
 * Template Name: Hotel Search Results
 *
 * Usage:
 * - Put this file in your active theme folder.
 * - Create a WP Page and set its template to "Hotel Search Results".
 * - Update your search form's action to point to site_url('/hotel-search/') (or change below).
 */

/* Prevent direct access */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header(); ?>
<div class="box-image-page">
  	<div class="single-page-img"></div>
  	 <div class="box-text">
    	<h2>
		    <?php 
		    $destination_hotel_booking_blog_title = get_theme_mod('destination_hotel_booking_edit_blog_page_title', __('Hotels', 'destination-hotel-booking')); 
		    echo esc_html($destination_hotel_booking_blog_title); 
		    ?>
		</h2>
		<?php 
		$destination_hotel_booking_edit_blog_page_description = get_theme_mod('destination_hotel_booking_edit_blog_page_description', '');

		if (!empty($destination_hotel_booking_edit_blog_page_description)) : ?>
		    <p class="blog-description"><?php echo esc_html($destination_hotel_booking_edit_blog_page_description); ?></p>
		<?php endif; ?>
    </div> 
</div>
 
<?php
/* ---------- Configuration ---------- */
$creds = worldota_get_creds();
$hotelApiKeyId = $creds['key_id'] ?? '';
$hotelApiKey   = $creds['key']    ?? '';
$api_base = rtrim( $creds['api_url'] ?? '' );

$IMAGE_SIZE_TOKEN = '1024x768';
$DETAIL_CACHE_TTL = HOUR_IN_SECONDS;
$PER_PAGE = 3; // results per page (change to taste)

/* ---------- Helpers (self-contained) ---------- */
if (! function_exists('decode_api_response')) {
    function decode_api_response($resp) {
        if (is_string($resp)) {
            $json = json_decode($resp, true);
            return (json_last_error() === JSON_ERROR_NONE) ? $json : null;
        } elseif (is_object($resp)) {
            return json_decode(json_encode($resp), true);
        } elseif (is_array($resp)) {
            return $resp;
        }
        return null;
    }
}

if (! function_exists('hp_get_gallery_from_api')) {
    function hp_get_gallery_from_api(array $data): array {
        $out = array();
        if ( empty($data) || ! is_array($data) ) return $out;

        if ( ! empty($data['images']) && is_array($data['images']) ) {
            foreach ($data['images'] as $img) {
                if (is_string($img) && trim($img) !== '') $out[] = $img;
            }
        }

        // Unique & trimmed
        $clean = array();
        foreach ($out as $u) {
            $u = trim((string)$u);
            if ($u === '') continue;
            if (! in_array($u, $clean, true)) $clean[] = $u;
        }
        return $clean;
    }
}

if (! function_exists('hp_normalize_host')) {
    function hp_normalize_host(string $template_url, string $targetHost = 'cdn.worldota.net'): string {
        $template_url = trim($template_url);
        if ($template_url === '') return $template_url;

        $template_url = preg_replace('#https?://(?:storage-cache|storage)\.p\.ostrovok\.ru#i', 'https://' . $targetHost, $template_url);
        $template_url = preg_replace('#https?://p\.ostrovok\.ru#i', 'https://' . $targetHost, $template_url);

        if (! preg_match('#^https?://#i', $template_url)) {
            $template_url = 'https://' . ltrim($template_url, '/');
        }

        return $template_url;
    }
}

if (! function_exists('hp_build_srcset_from_template')) {
    function hp_build_srcset_from_template(string $template_url, array $src_tokens, string $image_host_fix = 'cdn.worldota.net'): string {
        $template_url = trim($template_url);
        if ($template_url === '') return '';

        $template_url = hp_normalize_host($template_url, $image_host_fix);
        $parts = array();
        foreach ($src_tokens as $token => $descriptor) {
            $url = str_replace('{size}', $token, $template_url);
            if (filter_var($url, FILTER_VALIDATE_URL)) {
                $parts[] = $url . ' ' . $descriptor;
            }
        }
        return implode(', ', $parts);
    }
}

/* ---------- src tokens ---------- */
$src_tokens = array(
    '320x175'   => '320w',
    '640x350'   => '640w',
    '1024x768'  => '1024w',
    '1920x1080' => '1920w',
);

/* ---------- Read & sanitize incoming params ---------- */
/* Accept both mphb_ and generic param names (compat with your form) */
$search = isset( $_GET['mphb_destination'] ) ? sanitize_text_field( wp_unslash( $_GET['mphb_destination'] ) )
        : ( isset( $_GET['search'] ) ? sanitize_text_field( wp_unslash( $_GET['search'] ) ) : '' );

$check_in = isset( $_GET['mphb_check_in_date'] ) ? sanitize_text_field( wp_unslash( $_GET['mphb_check_in_date'] ) )
          : ( isset($_GET['check_in_time']) ? sanitize_text_field( wp_unslash( $_GET['check_in_time'] ) ) : '' );

$check_out = isset( $_GET['mphb_check_out_date'] ) ? sanitize_text_field( wp_unslash( $_GET['mphb_check_out_date'] ) )
           : ( isset($_GET['check_out_time']) ? sanitize_text_field( wp_unslash( $_GET['check_out_time'] ) ) : '' );

$adults = isset($_GET['mphb_adults']) ? intval($_GET['mphb_adults']) : ( isset($_GET['adults']) ? intval($_GET['adults']) : 1 );
$children = isset($_GET['mphb_children']) ? intval($_GET['mphb_children']) : ( isset($_GET['children']) ? intval($_GET['children']) : 0 );

$lang_code = isset($_GET['lang']) ? sanitize_text_field( wp_unslash($_GET['lang']) ) : 'en';
$lang = explode('-', $lang_code)[0];
if (!session_id()) {
    session_start();
}
$_SESSION['booking_check_in'] = $check_in;
$_SESSION['booking_check_out'] = $check_out;
$_SESSION['booking_adults'] = $adults;
$_SESSION['booking_children'] = $children;

/* Attributes: mphb_attributes[name]=value */
$attributes = array();
if ( isset($_GET['mphb_attributes']) && is_array($_GET['mphb_attributes']) ) {
    foreach ($_GET['mphb_attributes'] as $k => $v) {
        $attributes[sanitize_text_field($k)] = sanitize_text_field(wp_unslash($v));
    }
}

/* ---------- Pagination (robust detection) ---------- */
$paged = 1;
if ( get_query_var('paged') ) {
    $paged = absint( get_query_var('paged') );
} elseif ( get_query_var('page') ) {
    $paged = absint( get_query_var('page') );
} elseif ( isset($_GET['paged']) ) {
    $paged = max(1, intval($_GET['paged']));
}
$per_page = $PER_PAGE;

/* ---------- Render area ---------- */
?>

<!-- Rooms Section Begin -->
<section class="rooms-section spad yuiyuiyuiyuiyui">
  <div class="container">
    <div class="row">

<?php

$hasSearch = ( $search !== '' ) || ( $check_in !== '' ) || ( $check_out !== '' );

if ( $hasSearch ) {

   if ( ! class_exists( 'HotelAPI' ) ) {
	
    // Child theme directory
    $child_path = get_stylesheet_directory() . '/hawkapi.php';

    // Parent theme directory (fallback)
    $parent_path = get_template_directory() . '/hawkapi.php';

    if ( file_exists( $child_path ) ) {
        require_once $child_path;
    } elseif ( file_exists( $parent_path ) ) {
        require_once $parent_path;
    }
}


    if (! class_exists('HotelAPI')) {
        echo '<div class="col-lg-12"><p style="color:#c33">Error: HotelAPI client not found. Make sure hawkapi.php (your HotelAPI class) is included.</p></div>';
    } else {
        $hotelApi = new HotelAPI( $hotelApiKeyId, $hotelApiKey );

        // Call the multisuggest / multicomplete endpoint
        $rawMult = $hotelApi->getMulticomplete( $search, $lang );
        $mult = decode_api_response( $rawMult );


        if ( empty($mult) || ! isset($mult['data']) ) {
            echo '<div class="col-lg-12"><p>Unable to retrieve suggestions from API. Try again later.</p></div>';
        } else {
            $suggestHotels = array();
            $regions = $mult['data']['regions'] ?? array();

            if (! empty($regions)) {
                // pick the first region automatically (you could let user choose if multiple)
                $region = $regions[0];
                $region_id = $region['id'] ??  null;

                if ($region_id) {
                    // Build dates ensuring YYYY-MM-DD format (fallback to short default if missing)
                    $checkin = $check_in ? date('Y-m-d', strtotime($check_in)) : date('Y-m-d', strtotime('+1 day'));
                    $checkout = $check_out ? date('Y-m-d', strtotime($check_out)) : date('Y-m-d', strtotime('+2 day'));
                    if (strtotime($checkout) <= strtotime($checkin)) {
                        $checkout = date('Y-m-d', strtotime($checkin . ' +1 day'));
                    }

                    // Build rooms array (single-room simple mapping). Expand if you support multiple rooms/ages.
                    $rooms = array();
                    $rooms[] = array(
                        'adults' => max(1, (int)$adults),
                        'children' => max(0, (int)$children),
                    );

                    $payload = array(
                        'region_id' => $region_id,
                        'checkin'   => $checkin,
                        'checkout'  => $checkout,
                        'guests'     => $rooms,           
                        'language'  => $lang,
                        'residency' => "us"
                    );

                    // Basic auth header (KEY_ID:KEY)
                    $auth = base64_encode( $hotelApiKeyId . ':' . $hotelApiKey );
                    $args = array(
                        'headers' => array(
                            'Authorization' => 'Basic ' . $auth,
                            'Content-Type'  => 'application/json',
                        ),
                        'body' => wp_json_encode( $payload ),
                        'timeout' => 20,
                    );

                    // Endpoint — update host/path if you use a different contract (sandbox/prod)
                    $endpoint = 'https://api.worldota.net/api/b2b/v3/search/serp/region/sd';

                    $resp = wp_remote_post( $endpoint, $args );
					
					/* echo"<pre>";
					print_r($resp);
					die; */

                    if ( is_wp_error( $resp ) ) {
                        echo '<div class="col-lg-12"><p>Search failed: ' . esc_html( $resp->get_error_message() ) . '</p></div>';
                        // fallback to hotels from multicomplete (if present)
                        $suggestHotels = $mult['data']['hotels'] ?? array();
                    } else {
                        $code = wp_remote_retrieve_response_code( $resp );
                        $body = wp_remote_retrieve_body( $resp );
                        $serp = decode_api_response( $body );

                        if ( $code >= 200 && $code < 300 && ! empty($serp['data']['hotels']) ) {
                            // Use hotels from SERP (these include price hints and paging metadata)
                            $suggestHotels = $serp['data']['hotels'];
                            // optional: capture meta for pagination (not used if API doesn't supply)
                            $api_meta = $serp['meta'] ?? array();
                            $api_total = $api_meta['total'] ?? null;
                        } else {
                            // fallback
                            $suggestHotels = $mult['data']['hotels'] ?? array();
                        }
                    }
                } else {
                    echo '<div class="col-lg-12"><p>Could not resolve destination to a region id.</p></div>';
                    $suggestHotels = $mult['data']['hotels'] ?? array();
                }
            } else {
                // No regions — keep original behavior (suggested hotels from multicomplete)
                $suggestHotels = $mult['data']['hotels'] ?? array();
            }

            if ( empty($suggestHotels) ) {
               echo '
            <div class="col-lg-12 text-center py-5">
                <div style="
                    max-width: 420px;
                    margin: 0 auto;
                    background: #f8f9fa;
                    border-radius: 12px;
                    padding: 40px 20px;
                    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
                ">
                    <div style="
                        width: 80px;
                        height: 80px;
                        margin: 0 auto 20px;
                        background: #e9ecef;
                        border-radius: 50%;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        font-size: 38px;
                        color: #6c757d;
                    ">
                        <i class="fa fa-search"></i>
                    </div>

                    <h4 style="color:#343a40; font-weight:600;">No Results Found</h4>
                    <p style="color:#6c757d; margin-top:10px;">
                        We couldn’t find any hotels matching your search.
                        <br>Please try different filters or keywords.
                    </p>

                    <a href="/home" class="btn btn-primary mt-3" style="border-radius: 50px; padding: 10px 25px;">
                        Back to Home
                    </a>
                </div>
            </div>
            ';

            } else {
                /* --- SERVER-SIDE PAGINATION (API does NOT provide pagination) --- */
                $total_results = count($suggestHotels);
                $total_pages = (int) max(1, ceil( $total_results / $per_page ) );

                // clamp $paged into valid range to avoid empty pages
                if ( $paged < 1 ) $paged = 1;
                if ( $paged > $total_pages ) $paged = $total_pages;

                $offset = ($paged - 1) * $per_page;
                $hotels_to_show = array_slice( $suggestHotels, $offset, $per_page );

                // If still empty, show friendly message
                if ( empty($hotels_to_show) ) {
                    echo '<div class="col-lg-12"><p>No results for this page.</p></div>';
                } else {
                    // Render only the hotels for the current page
                    foreach ( $hotels_to_show as $h ) {

                        $hotelId = isset($h['id']) && $h['id'] !== '' ? (string)$h['id'] : (isset($h['hid']) ? (string)$h['hid'] : '');
                        if ($hotelId === '') continue;

                        $transient_key = 'wo_hotel_info_' . sanitize_key((string)$hotelId . '_' . $lang);
                        $hotelDetail = get_transient($transient_key);

                        if ($hotelDetail === false) {
                            $rawDetail = $hotelApi->getSingleHotelDetails($hotelId, $lang);
                            $hotelDetail = decode_api_response($rawDetail);
                            if ($hotelDetail) {
                                set_transient($transient_key, $hotelDetail, $DETAIL_CACHE_TTL);
                            } else {
                                set_transient($transient_key, array(), 5 * MINUTE_IN_SECONDS);
                                $hotelDetail = array();
                            }
                        }

                        if ( empty($hotelDetail) || ! isset($hotelDetail['data']) ) {
                            $fallbackName = isset($h['name']) ? $h['name'] : 'Hotel';
                            ?>
                            <div class="col-lg-4 py-4">
                                <div class="room-item mmt-card">
                                    <div class="ri-pic">
                                        <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/default-hotel.jpg'); ?>" alt="<?php echo esc_attr($fallbackName); ?>">
                                    </div>
                                    <div class="ri-text">
                                        <h4><?php echo esc_html($fallbackName); ?></h4>
                                        <p>Details currently unavailable.</p>
                                        <a class="primary-btn dcsc" href="<?php echo esc_url( add_query_arg( array( 'hotel_id' => $hotelId, 'lang' => $lang ), site_url('/hotel-detail/') ) ); ?>">View deals</a>
                                    </div>
                                </div>
                            </div>
                            <?php
                            continue;
                        }

                        $data = $hotelDetail['data'];

                        // core fields
                        $hotelName   = $data['name'] ?? ($h['name'] ?? 'Hotel');
                        $address     = $data['address'] ?? '';
                        $regionName  = $data['region']['name'] ?? '';
                        $cityCountry = trim($regionName ? $regionName : ($data['postal_code'] ?? ''));
                        $starRating  = $data['star_rating'] ?? null;
                        $checkIn     = $data['check_in_time'] ?? '';
                        $checkOut    = $data['check_out_time'] ?? '';
                        $shortDesc   = '';

                        if (!empty($data['description_struct']) && is_array($data['description_struct'])) {
                            foreach ($data['description_struct'] as $block) {
                                if (!empty($block['paragraphs']) && is_array($block['paragraphs']) && !empty($block['paragraphs'][0])) {
                                    $shortDesc = wp_strip_all_tags($block['paragraphs'][0]);
                                    break;
                                }
                            }
                        }

                        // amenity chips (limit 6)
                        $amenity_chips = array();
                        if (! empty($data['amenity_groups']) && is_array($data['amenity_groups'])) {
                            foreach ($data['amenity_groups'] as $group) {
                                if (! empty($group['amenities']) && is_array($group['amenities'])) {
                                    foreach ($group['amenities'] as $amen) {
                                        if (! in_array($amen, $amenity_chips)) {
                                            $amenity_chips[] = $amen;
                                        }
                                        if (count($amenity_chips) >= 6) break 2;
                                    }
                                }
                            }
                        } else {
                            $amenity_chips[] = "Amenities data not provided by hotel.";
                        }

                        // rooms
                        $roomGroups = $data['room_groups'] ?? array();
                        $roomCount  = count($roomGroups);

                        // IMAGE selection
                        $templates = hp_get_gallery_from_api($data);
                        $imageUrl = get_template_directory_uri() . '/assets/images/sliderimage.png';
                        $srcset = '';
                        if (! empty($templates)) {
                            $main_template = hp_normalize_host($templates[0], 'cdn.worldota.net');
                            $imageUrl = str_replace('{size}', $IMAGE_SIZE_TOKEN, $main_template);
                            $srcset = hp_build_srcset_from_template($templates[0], $src_tokens, 'cdn.worldota.net');
                        }

						$starHtml = '';
						$ratingText = '';
						if ($starRating) {
							$rounded = (int) round( (float) $starRating );
							for ($i = 0; $i < 5; $i++) {
								if ($i < $rounded) $starHtml .= '<i class="fas fa-star" aria-hidden="true"></i>';
								else $starHtml .= '<i class="far fa-star" aria-hidden="true"></i>';
							}
							
							// Determine rating text based on rating value
							if ($starRating >= 4.0) {
								$ratingText = 'Excellent';
							} elseif ($starRating >= 3.0) {
								$ratingText = 'Very Good';
							} elseif ($starRating >= 1.0) {
								$ratingText = 'Good';
							} else {
								$ratingText = 'No Rating';
							}
						} else {
							for ($i = 0; $i < 5; $i++) {
								 $starHtml .= '<i class="far fa-star" aria-hidden="true"></i>';
							}
							$ratingText = 'No Rating';
						}

                        // price placeholder
                        $priceText = 'Check price';
                        if (! empty($data['metapolicy_struct']['meal'])) {
                            $priceText = 'Starting from ? �';
                        }

                        // create a nonce for the import action
                        $ota_import_nonce = wp_create_nonce( 'ota_import_action' );

                        // build the import URL (this will trigger template_redirect handler above)
                        $import_url = add_query_arg( array(
                            'ota_import' => '1',
                            'hotel_id'   => $hotelId,
                            'checkin'    => $check_in,
                            'checkout'   => $check_out,
                            'adults'     => $adults,
                            'children'   => $children,
                            'lang'       => $lang,
                            'ota_import_nonce' => $ota_import_nonce,
                        ), home_url('/') );
                        ?>
                        <div class="col-lg-12 py-3">
                            <div class="mmt-hotel-card d-flex" 
                                 style="display:flex;border:1px solid #eee;border-radius:8px;background:#fff;overflow:hidden;
                                        box-shadow:0 2px 8px rgba(0,0,0,0.08);align-items:stretch;max-width:924px;margin:auto;">
                                <!-- Image Section -->
                                <div class="mmt-image" style="flex: 0 0 350px;height: 245px;overflow:hidden;padding:16px">
                                  <a href="<?php echo esc_url( $import_url ); ?>">
                                    <img src="<?php echo esc_url($imageUrl); ?>"
                                         <?php if ($srcset): ?> 
                                         srcset="<?php echo esc_attr($srcset); ?>" sizes="(max-width: 800px) 100vw, 800px"
                                         <?php endif; ?>
                                         alt="<?php echo esc_attr($hotelName); ?>"
                                         style="width:100%;height:100%;object-fit:cover;display:block;border-radius:5px;">
                                  </a>
                                </div>

                                <!-- Meta Section -->
                                <div class="mmt-meta" style="flex:1;display:flex;justify-content:space-between;">
                                  <div style="flex:1;padding: 16px 4px;">
                                    <h3 style="margin:0 0 6px;font-size:20px;color:#000;font-weight:800;">
                                      <a href="<?php echo esc_url( $import_url ); ?>" style="color:#000;text-decoration:none;">
                                        <?php echo esc_html($hotelName); ?>
                                      </a>
                                    </h3>
                                   <!-- <div style="color:#000;font-size:14px;">
                                      <?php //if ($starHtml): ?><span class="mmt-stars"><?php// echo $starHtml; ?></span><?php //endif; ?>
                                      <span style="margin-left:8px;"><?php// echo esc_html( $address ? $address : $cityCountry ); ?></span>
                                    </div>-->
									<div style="color:#000;font-size:14px;">
  <?php if ($starHtml): ?>
    <span class="mmt-stars"><?php echo $starHtml; ?></span>
    <?php if ($ratingText): ?>
      <span style="margin-left:8px;font-weight:500;color:#000;"><?php echo esc_html($ratingText); ?></span>
    <?php endif; ?>
  <?php endif; ?>
<div style="font-weight:700;font-size:14px;">

    <i class="fas fa-map-marker-alt"></i>
    <span style="margin-left:8px;"><?php echo esc_html($address ?: $cityCountry); ?></span>


</div>
</div>
									
                                    <?php if ($shortDesc): ?>
                                      <p style="margin:8px 0;color:#444;font-size:14px;">
                                        <?php echo esc_html( wp_trim_words( $shortDesc, 30, '...' ) ); ?>
                                      </p>
                                    <?php endif; ?>

                                    <div class="mmt-amenities" style="margin-top:8px;">
                                      <?php foreach ($amenity_chips as $chip): ?>
                                        <span style="display:inline-block;background:#f1f1f1;padding:5px 10px;margin-right:6px;
                                                     margin-bottom:6px;border-radius:16px;font-size:13px;color:#333;">
                                          <?php echo esc_html($chip); ?>
                                        </span>
                                      <?php endforeach; ?>
                                    </div>
                                  </div>

                                  <!-- Price Section -->
                                  <div style="text-align:right;border-left:1px solid #e1e1e1;padding-left:16px;
                                              min-width:180px;display:flex;flex-direction:column;justify-content:space-between;padding:16px;">
                                    <div style="font-size:14px;color:#666;margin-bottom:12px;">
                                    <!--  <div><strong>Check in:</strong> <?php //echo esc_html( $checkIn ? substr( $checkIn, 0, 5 ) : '-' ); ?></div>
                                      <div><strong>Check out:</strong> <?php //echo esc_html( $checkOut ? substr( $checkOut, 0, 5 ) : '-' ); ?></div>
									  -->
									<div><strong>Check in:</strong> <?php echo esc_html( $checkIn ? date('g:i A', strtotime($checkIn)) : '-' ); ?></div>
									<div><strong>Check out:</strong> <?php echo esc_html( $checkOut ? date('g:i A', strtotime($checkOut)) : '-' ); ?></div>
                                      <div style="margin-top:6px;"><strong>Rooms:</strong> <?php echo esc_html( $roomCount ); ?></div>
                                    </div>

                                    <div style="margin-top:20px;">
                                      <div style="font-weight:700;font-size:20px;color:#000;margin-bottom:8px;">
                                        <?php echo esc_html($priceText); ?>
                                      </div>
                                      <a class="primary-btn" href="<?php echo esc_url( $import_url ); ?>" 
                                         style="display:inline-block;padding:10px 14px;background:#FBB191;color:#fff;
                                                border-radius:4px;text-decoration:none;font-weight:600;">
                                        View deals
                                      </a>
                                    </div>
                                  </div>
                                </div>
                            </div>
                        </div>
                        
						<?php
                    } // end foreach hotels
                } // end if not empty page

                // --- Pagination block (render once, outside loop) ---
                if ( $total_pages > 1 ) {

                    // Build add_args preserving original search query params, including attribute arrays
                    $add_args = array();

                    // preserve simple scalar GET params
                    foreach ( $_GET as $k => $v ) {
                        if ( $k === 'paged' ) continue; // paginate_links will add paged
                        // handle attribute arrays later below
                        if ( $k === 'mphb_attributes' ) continue;
                        if ( is_scalar( $v ) && $v !== '' ) {
                            $add_args[ $k ] = sanitize_text_field( wp_unslash( $v ) );
                        }
                    }

                    // handle mphb_attributes[...] if present in $attributes
                    if ( ! empty($attributes) && is_array($attributes) ) {
                        foreach ($attributes as $k => $v) {
                            if ($v !== '') $add_args['mphb_attributes[' . $k . ']'] = $v;
                        }
                    }

                    // Also preserve known params we explicitly used (safer)
                    if ($search !== '') $add_args['mphb_destination'] = $search;
                    if ($check_in !== '') $add_args['mphb_check_in_date'] = $check_in;
                    if ($check_out !== '') $add_args['mphb_check_out_date'] = $check_out;
                    if ($adults > 0) $add_args['mphb_adults'] = $adults;
                    if ($children >= 0) $add_args['mphb_children'] = $children;
                    if (!empty($lang_code)) $add_args['lang'] = $lang_code;

                    $big = 999999999;
                    echo '<div class="col-lg-12 d-flex justify-content-center align-items-center mb-4"><div class="room-pagination">';
                    echo paginate_links( array(
                        'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                        'format'    => ( get_option('permalink_structure') ? 'page/%#%/' : '?paged=%#%' ),
                        'current'   => max(1, $paged),
                        'total'     => $total_pages,
                        'prev_text' => '&laquo; Prev',
                        'next_text' => 'Next &raquo;',
                        'add_args'  => $add_args,
                        'type'      => 'plain',
                    ) );
                    echo '</div></div>';
                }

            } // end non-empty hotels
        } // end mult data present
    } // end HotelAPI exists
} 
?>

    </div>
  </div>
</section>

<?php
get_footer();
