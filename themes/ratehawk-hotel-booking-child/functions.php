<?php
// Enqueue parent and child styles properly
add_action( 'wp_enqueue_scripts', 'parentname_child_enqueue_styles' );
function parentname_child_enqueue_styles() {
    // Enqueue parent style
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );

    // Enqueue child style, dependent on parent-style
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( 'parent-style' ),
        wp_get_theme()->get('Version') // child theme version
    );
}


/* ----------------------------
 * Create one MPHB room from a WorldOTA room_group
 * - Creates post of type 'mphb_room'
 * - Links to parent accommodation using 'mphb_room_type_id' meta key
 * - Uses price data from search/hp endpoint if available
 * ---------------------------- */
if ( ! function_exists( 'ota_create_room_from_group' ) ) {
    function ota_create_room_from_group( $hotel_post_id, $hotel_title, $hotel_terms = array(), $room_group = array(), $parent_hotel_data = array(), $parent_price_data = null ) { // Added parent_price_data parameter
        if ( empty( $room_group ) || ! is_array( $room_group ) ) {
            return new WP_Error( 'invalid_room_group', 'Invalid room group data' );
        }

        $room_name = isset( $room_group['name'] ) ? sanitize_text_field( $room_group['name'] ) : ( $hotel_title . ' Room ' . (int) ( $room_group['room_group_id'] ?? time() ) );
        $post_type = 'mphb_room'; // Explicitly set to mphb_room

        // Build content
        $content = '';
        if ( ! empty( $room_group['name_struct']['main_name'] ) ) {
            $content .= wp_kses_post( $room_group['name_struct']['main_name'] ) . "\n\n";
        }
        if ( ! empty( $room_group['room_amenities'] ) && is_array( $room_group['room_amenities'] ) ) {
            $content .= "Amenities: " . implode( ', ', $room_group['room_amenities'] ) . "\n\n";
        }
        $content .= "Imported from WorldOTA (room_group_id: " . intval( $room_group['room_group_id'] ?? 0 ) . ")\n";
        $content .= "Part of Hotel: " . esc_html( $hotel_title ) . " (ID: " . esc_html( get_post_field( 'post_name', $hotel_post_id ) /* Uses slug */ ) . ")\n";

        // Determine capacity/size/price
        $rg_ext = $room_group['rg_ext'] ?? array();
        $adults = ( ! empty( $rg_ext['capacity'] ) && intval($rg_ext['capacity']) > 0 ) ? intval( $rg_ext['capacity'] ) : 2;
        $children = 0;
        $size = ( isset( $room_group['size'] ) && is_numeric( $room_group['size'] ) && $room_group['size'] > 0 ) ? floatval( $room_group['size'] ) : 35.0;

        // Determine base price
        // 1. Try to find a matching rate in the parent_price_data (from search/hp)
        $base_price = 0.0;
        $matching_rate_data = null;
        if ( $parent_price_data && ! empty( $parent_price_data['rates'] ) && is_array( $parent_price_data['rates'] ) ) {
            foreach ( $parent_price_data['rates'] as $rate ) {
                // Match based on room name or rg_ext details if possible
                // A simple match could be based on the room name from info matching the room_name from search/hp
                if ( isset( $rate['room_name'] ) && isset( $room_group['name'] ) && 
                     strpos( $rate['room_name'], $room_group['name'] ) !== false ) { // Basic name matching
                    if ( ! empty( $rate['payment_options']['payment_types'][0]['show_amount'] ) ) {
                         $base_price = floatval( $rate['payment_options']['payment_types'][0]['show_amount'] );
                         $matching_rate_data = $rate; // Store the matching rate data
                         break;
                    }
                }
            }
        }

        // 2. If no match found in search/hp data, fall back to info endpoint heuristic
        if ( $base_price <= 0.0 && ! empty( $room_group['price']['amount'] ) ) {
            $base_price = floatval( $room_group['price']['amount'] );
        }
        if ( $base_price <= 0.0 && ! empty( $parent_hotel_data['metapolicy_struct']['meal'][0]['price'] ) ) {
            $base_price = floatval( $parent_hotel_data['metapolicy_struct']['meal'][0]['price'] );
        }

        // Insert room post
        $new_room_id = wp_insert_post( array(
            'post_title'   => $room_name,
            'post_content' => $content,
            'post_type'    => $post_type, // 'mphb_room'
            'post_status'  => 'publish',
        ), true );

        if ( is_wp_error( $new_room_id ) ) return $new_room_id;

     
        update_post_meta( $new_room_id, 'mphb_room_type_id', strval( $hotel_post_id ) ); 

    
        update_post_meta( $new_room_id, 'mphb_adults_capacity', strval( max(1, (int)$adults ) ) );
        update_post_meta( $new_room_id, 'mphb_children_capacity', strval( max(0, (int)$children ) ) );
        update_post_meta( $new_room_id, 'mphb_total_capacity', strval( (int)$adults + (int)$children ) );
        update_post_meta( $new_room_id, 'mphb_size', strval( $size ) );
        update_post_meta( $new_room_id, '_mphb_base_price', number_format( (float)$base_price, 2, '.', '' ) ); // Store the determined price

        // Copy categories & facilities from parent (if provided)
        if ( ! empty( $hotel_terms['categories'] ) ) {
            wp_set_object_terms( $new_room_id, $hotel_terms['categories'], 'mphb_room_type_category', false );
        }
        if ( ! empty( $hotel_terms['facilities'] ) ) {
            wp_set_object_terms( $new_room_id, $hotel_terms['facilities'], 'mphb_room_type_facility', false );
        }

        // Attach room-group images (if available in the room_group)
        $room_images = array();
        if ( ! empty( $room_group['images'] ) && is_array( $room_group['images'] ) ) {
            $room_images = $room_group['images'];
        } elseif ( ! empty( $room_group['images_ext'] ) && is_array( $room_group['images_ext'] ) ) {
            foreach ( $room_group['images_ext'] as $ie ) {
                if ( ! empty( $ie['url'] ) ) $room_images[] = $ie['url'];
            }
        }

        $gallery_ids = array();
        $creds = worldota_get_creds(); // Get image prefix for sideloading
        $image_prefix = $creds['image_prefix'] ?? '';
        foreach ( $room_images as $idx => $template ) {
            $url = str_replace( '{size}', '1024x768', $template );
            $content_pos = strpos( $url, 'content/' );
            if ( $content_pos !== false && ! empty( $image_prefix ) ) {
                $content_path = substr( $url, $content_pos );
                $url = rtrim( $image_prefix, '/' ) . '/' . ltrim( $content_path, '/' );
            }
            $attach = ota_sideload_image( $url, $new_room_id, "Room group image for {$room_name}" );
            if ( is_wp_error( $attach ) ) {
                error_log("OTA Sideloading Error for room {$room_name} image {$url}: " . $attach->get_error_message());
                continue;
            }

            if ( $idx === 0 ) set_post_thumbnail( $new_room_id, $attach );
            else $gallery_ids[] = $attach;
        }
        if ( ! empty( $gallery_ids ) ) {
            update_post_meta( $new_room_id, '_mphb_gallery_items', $gallery_ids );
            $gallery_ids_string = implode( ',', $gallery_ids );
            update_post_meta( $new_room_id, 'mphb_gallery', $gallery_ids_string );
        }

        // Mark imported room group and store related data
        if ( ! empty( $room_group['room_group_id'] ) ) {
            update_post_meta( $new_room_id, '_imported_from_worldota_roomgroup', intval( $room_group['room_group_id'] ) );
            update_post_meta( $new_room_id, '_imported_from_worldota_parent_hotel_id', strval( get_post_field( 'post_name', $hotel_post_id ) /* Use slug */ ) );
            update_post_meta( $new_room_id, '_imported_from_worldota_parent_post_id', $hotel_post_id ); // Store the actual post ID
        }

        // Store the raw room_group data from info endpoint
        update_post_meta( $new_room_id, '_worldota_room_group_data_info', $room_group );

        // Store the matching rate data from search/hp endpoint (if found)
        if ( $matching_rate_data ) {
            update_post_meta( $new_room_id, '_worldota_room_rate_data_search', $matching_rate_data );
        }

        // Store the price source info
        update_post_meta( $new_room_id, '_worldota_room_price_source', $matching_rate_data ? 'search_hp' : 'info_endpoint_fallback' );
        update_post_meta( $new_room_id, '_worldota_room_price_fallback_amount', number_format( (float) ( ( ! empty( $room_group['price']['amount'] ) ? floatval( $room_group['price']['amount'] ) : 0.0 ) ?: ( ! empty( $parent_hotel_data['metapolicy_struct']['meal'][0]['price'] ) ? floatval( $parent_hotel_data['metapolicy_struct']['meal'][0]['price'] ) : 0.0 ) ), 2, '.', '' ) );

        return (int) $new_room_id;
    }
}



/* ----------------------------
 * Robust sideload helper
 * ---------------------------- */
if ( ! function_exists( 'ota_sideload_image' ) ) {
    function ota_sideload_image( $file_url, $post_id = 0, $desc = '' ) {
        if ( empty( $file_url ) ) {
            return new WP_Error( 'no_url', 'No image URL provided' );
        }
        if ( ! function_exists( 'media_handle_sideload' ) ) {
            require_once ABSPATH . 'wp-admin/includes/file.php';
            require_once ABSPATH . 'wp-admin/includes/media.php';
            require_once ABSPATH . 'wp-admin/includes/image.php';
        }
        // Download remote file to temp
        $tmp = download_url( $file_url );
        if ( is_wp_error( $tmp ) ) {
            return new WP_Error( 'download_failed', 'download_url failed: ' . $tmp->get_error_message() );
        }
        // Prepare file array
        $file_array = array();
        $file_array['name']     = basename( parse_url( $file_url, PHP_URL_PATH ) );
        $file_array['tmp_name'] = $tmp;
        // Sideload
        $attach_id = media_handle_sideload( $file_array, $post_id, $desc );
        // Ensure cleanup
        @unlink( $tmp );
        if ( is_wp_error( $attach_id ) ) {
            return $attach_id;
        }
        // Generate/update attachment metadata (thumbnails, etc.)
        $file = get_attached_file( $attach_id );
        if ( file_exists( $file ) ) {
            $meta = wp_generate_attachment_metadata( $attach_id, $file );
            wp_update_attachment_metadata( $attach_id, $meta );
        }
        return $attach_id;
    }
}

/* ----------------------------
 * Helper function to fetch prices using search/hp
 * ---------------------------- */
if ( ! function_exists( 'ota_fetch_hotel_prices' ) ) {
    function ota_fetch_hotel_prices( $hotel_id, $checkin, $checkout, $adults = 2, $children = 0, $lang = 'en', $currency = 'USD' ) {
        if ( empty( $hotel_id ) ) {
            return new WP_Error( 'missing_id', 'Missing hotel ID' );
        }

        $creds = worldota_get_creds();
        $key_id = $creds['key_id'] ?? '';
        $key    = $creds['key'] ?? '';
        $endpoint_base = rtrim( $creds['api_url'] ?? '' );
        $endpoint = $endpoint_base . '/api/b2b/v3/search/hp/';
        $image_prefix = $creds['image_prefix'] ?? '';

        if ( empty( $key_id ) || empty( $key ) ) {
            return new WP_Error( 'missing_creds', 'Missing WorldOTA credentials' );
        }

        // Default to tomorrow if no dates provided
        if ( empty( $checkin ) ) {
            $checkin = date('Y-m-d', strtotime('+1 day'));
        }
        if ( empty( $checkout ) ) {
            $checkout = date('Y-m-d', strtotime($checkin . ' +2 day'));
        } 

        // Prepare guests array
        $guests = array(
            array(
                'adults' => max(1, intval($adults)),
                'children' => array_fill(max(0, intval($children)),0, 0) // Assuming age 0 for simplicity
            )
        );

        // Prepare payload for search/hp
        $search_payload = array(
            'id' => $hotel_id,
            'checkin' => $checkin,
            'checkout' => $checkout,
            'language' => $lang,
            'currency' => $currency,
            'residency' => 'us', 
            'guests' => $guests,
        );

        $payload = wp_json_encode( $search_payload );

        // Make the API call
        $resp = wp_remote_post( $endpoint, array(
            'headers' => array(
                'Authorization' => 'Basic ' . base64_encode( $key_id . ':' . $key ),
                'Accept'        => 'application/json',
                'Content-Type'  => 'application/json; charset=utf-8',
            ),
            'body' => $payload,
            'timeout' => 15, // Slightly higher timeout for search
        ) );

        if ( is_wp_error( $resp ) ) {
            return $resp;
        }

        $code = wp_remote_retrieve_response_code( $resp );
        $body = wp_remote_retrieve_body( $resp );

        if ( $code !== 200 ) {
            return new WP_Error( 'api_error_search', 'Search API returned HTTP ' . $code . ' - ' . wp_trim_words( $body, 30 ) );
        }

        $api_data = json_decode( $body, true );
        if ( json_last_error() !== JSON_ERROR_NONE ) {
            return new WP_Error( 'json_error_search', json_last_error_msg() );
        }

        if ( empty( $api_data['data'] ) || empty( $api_data['data']['hotels'] ) ) {
            return new WP_Error( 'no_prices_data', 'Search API returned no price data for hotel: ' . $hotel_id );
        }

        $hotel_data = null;
        foreach ( $api_data['data']['hotels'] as $hotel ) {
            if ( $hotel['id'] === $hotel_id ) {
                $hotel_data = $hotel;
                break;
            }
        }

        if ( ! $hotel_data ) {
            return new WP_Error( 'hotel_not_found_in_search', 'Hotel ID ' . $hotel_id . ' not found in search results.' );
        }

        return $hotel_data; // Returns the hotel data block from search/hp containing rates
    }
}




if ( ! function_exists( 'ota_import_hotel_by_id' ) ) {

    function ota_import_hotel_by_id( $hotel_id , $check_in , $check_out,$adults,$children , $lang = 'en', $currency = 'USD') { // Added currency parameter
        if ( empty( $hotel_id ) ) {
            return new WP_Error( 'missing_id', 'Missing hotel ID' );
        }
        $creds = worldota_get_creds();
        $key_id = $creds['key_id'] ?? '';
        $key    = $creds['key'] ?? '';
        $endpoint_base = rtrim( $creds['api_url'] ?? '' );
        $endpoint_info = $endpoint_base . '/api/b2b/v3/hotel/info/';
        $image_prefix = $creds['image_prefix'] ?? '';

        if ( empty( $key_id ) || empty( $key ) ) {
            return new WP_Error( 'missing_creds', 'Missing WorldOTA credentials' );
        }

        // 1. Fetch hotel info
        $payload_info = wp_json_encode( array( 'id' => $hotel_id, 'language' => $lang ) );
        $resp_info = wp_remote_post( $endpoint_info, array(
            'headers' => array(
                'Authorization' => 'Basic ' . base64_encode( $key_id . ':' . $key ),
                'Accept'        => 'application/json',
                'Content-Type'  => 'application/json; charset=utf-8',
            ),
            'body' => $payload_info,
            'timeout' => 30,
        ) );

        if ( is_wp_error( $resp_info ) ) return $resp_info;
        $code_info = wp_remote_retrieve_response_code( $resp_info );
        $body_info = wp_remote_retrieve_body( $resp_info );
		
		
		
        if ( $code_info !== 200 ) return new WP_Error( 'api_error_info', 'Info API returned HTTP ' . $code_info . ' - ' . wp_trim_words( $body_info, 30 ) );

        $api_data_info = json_decode( $body_info, true );
		
        if ( json_last_error() !== JSON_ERROR_NONE ) return new WP_Error( 'json_error_info', json_last_error_msg() );
        if ( empty( $api_data_info['data'] ) ) return new WP_Error( 'no_data_info', 'Info API returned no data' );

        $hotel = $api_data_info['data'];
        $price_data = ota_fetch_hotel_prices( $hotel_id, '', '', 1, 0, $lang, $currency ); 
        if ( is_wp_error( $price_data ) ) {
            error_log('OTA Price Fetch Error for hotel ' . $hotel_id . ': ' . $price_data->get_error_message());
            $price_data = null;
        }
        $title = isset( $hotel['name'] ) ? sanitize_text_field( $hotel['name'] ) : 'Imported Accommodation ' . time();
        $content = '';
        if ( ! empty( $hotel['description_struct'] ) && is_array( $hotel['description_struct'] ) ) {
            foreach ( $hotel['description_struct'] as $blk ) {
                if ( ! empty( $blk['paragraphs'][0] ) ) {
                    $content = wp_kses_post( $blk['paragraphs'][0] );
                    break;
                }
            }
        }
        if ( empty( $content ) && ! empty( $hotel['description'] ) ) {
            $content = wp_kses_post( $hotel['description'] );
        }
        $content .= "\n\nImported from WorldOTA (id: " . esc_html( $hotel_id ) . ")";
		$adults = 1;
		$children = 0;
        $size = 35;
        $base_price_from_info = 0.00; // Store base price from info endpoint

        if ( ! empty( $hotel['room_groups'] ) && is_array( $hotel['room_groups'] ) ) {
            foreach ( $hotel['room_groups'] as $rg ) {
                $rg_ext = $rg['rg_ext'] ?? array();
                if ( ! empty( $rg_ext['capacity'] ) && intval($rg_ext['capacity']) > 0 ) {
                    $adults = intval( $rg_ext['capacity'] );
                }
                if ( isset( $rg['size'] ) && is_numeric( $rg['size'] ) && $rg['size'] > 0 ) {
                    $size = floatval( $rg['size'] );
                }
                if ( ! empty( $rg['price']['amount'] ) ) {
                    $base_price_from_info = floatval( $rg['price']['amount'] ); // Store this value
                }
                if ( $adults || $size || $base_price_from_info ) break;
            }
        }

        if ( (float)$base_price_from_info <= 0 && ! empty( $hotel['metapolicy_struct']['meal'] ) && is_array( $hotel['metapolicy_struct']['meal'] ) ) {
            $first_meal = reset( $hotel['metapolicy_struct']['meal'] );
            if ( isset( $first_meal['price'] ) && is_numeric( $first_meal['price'] ) ) {
                $base_price_from_info = floatval( $first_meal['price'] ); // Store this value
            }
        }
        $total_capacity = max( 1, $adults + $children );
        $existing = get_posts( array(
            'post_type' => defined('MPHB_ROOM_POST_TYPE') ? MPHB_ROOM_POST_TYPE : 'mphb_room_type',
            'meta_key'  => '_imported_from_worldota_id',
            'meta_value'=> sanitize_text_field( $hotel_id ),
            'fields'    => 'ids',
            'posts_per_page' => 1,
        ) );
        if ( ! empty( $existing ) ) {
            $post_id = (int) $existing[0];
        } else {
            $post_type = defined('MPHB_ROOM_POST_TYPE') ? MPHB_ROOM_POST_TYPE : 'mphb_room_type';
            $post_status = 'publish';
            $post_id = wp_insert_post( array(
                'post_title'   => $title,
                'post_content' => $content,
                'post_type'    => $post_type,
                'post_status'  => $post_status,
            ), true );

            if ( is_wp_error( $post_id ) ) return $post_id;
        }
        $effective_base_price = $base_price_from_info; // Start with info endpoint value
        if ( $price_data && ! empty( $price_data['rates'] ) && is_array( $price_data['rates'] ) ) {
            $first_rate = reset( $price_data['rates'] );
            if ( ! empty( $first_rate['payment_options']['payment_types'][0]['show_amount'] ) ) {
                $effective_base_price = floatval( $first_rate['payment_options']['payment_types'][0]['show_amount'] );
            }
        }

        update_post_meta( $post_id, 'mphb_adults_capacity', strval( $adults ) );
        update_post_meta( $post_id, 'mphb_children_capacity', strval( $children ) );
        update_post_meta( $post_id, 'mphb_total_capacity', strval( $total_capacity ) );
        update_post_meta( $post_id, 'mphb_size', strval( $size ) );
        update_post_meta( $post_id, '_mphb_base_price', number_format( (float)$effective_base_price, 2, '.', '' ) ); // Use effective price

        // Store raw data responses
        update_post_meta( $post_id, '_worldota_full_response', $hotel );
        update_post_meta( $post_id, '_imported_from_worldota_id', sanitize_text_field( $hotel_id ) );
        // Store the price data fetched from search/hp
        if ( $price_data ) {
            update_post_meta( $post_id, '_worldota_price_response', $price_data );
        }
        // Store the original base price from info endpoint for reference
        update_post_meta( $post_id, '_worldota_info_base_price', number_format( (float)$base_price_from_info, 2, '.', '' ) );

        // Amenities -> mphb_room_type_facility (from info endpoint)
        $amenities_by_group = array(); // New variable to store grouped amenities
        $amenities = array(); 

        if ( ! empty( $hotel['amenity_groups'] ) && is_array( $hotel['amenity_groups'] ) ) {
            foreach ( $hotel['amenity_groups'] as $grp ) {
                $group_name = $grp['group_name'];
                $amenities_by_group[$group_name] = array(); 
                
                if ( ! empty( $grp['amenities'] ) && is_array( $grp['amenities'] ) ) {
                    foreach ( $grp['amenities'] as $a ) {
                        if ( is_string($a) && trim($a) !== '' ) {
                            $amenity = trim( $a );
                            $amenities[] = $amenity; 
                            $amenities_by_group[$group_name][] = $amenity; 
                        }
                        elseif ( is_array($a) && ! empty($a['name']) ) {
                            $amenity = trim( $a['name'] );
                            $amenities[] = $amenity; 
                            $amenities_by_group[$group_name][] = $amenity; 
                        }
                    }
                }
            }
        }

        if ( ! empty( $amenities ) ) {
            $amenities = array_values( array_unique( $amenities ) );
            foreach ( $amenities as $term_name ) {
                if ( term_exists( $term_name, 'mphb_room_type_facility' ) === 0 ) {
                    wp_insert_term( $term_name, 'mphb_room_type_facility' );
                }
            }
            wp_set_object_terms( $post_id, $amenities, 'mphb_room_type_facility', false );
        }
        update_post_meta( $post_id, '_amenities_by_group', $amenities_by_group );
        $cat_terms = array();
        if ( ! empty( $hotel['kind'] ) ) $cat_terms[] = $hotel['kind'];
        if ( empty( $cat_terms ) && ! empty( $hotel['room_groups'] ) ) {
            foreach ( $hotel['room_groups'] as $rg ) {
                if ( ! empty( $rg['name_struct']['main_name'] ) ) $cat_terms[] = $rg['name_struct']['main_name'];
            }
        }
        $cat_terms = array_values( array_unique( array_filter( array_map('trim', $cat_terms) ) ) );
        if ( ! empty( $cat_terms ) ) {
            foreach ( $cat_terms as $term_name ) {
                if ( term_exists( $term_name, 'mphb_room_type_category' ) === 0 ) {
                    wp_insert_term( $term_name, 'mphb_room_type_category' );
                }
            }
            wp_set_object_terms( $post_id, $cat_terms, 'mphb_room_type_category', false );
        }

        // Images: sideload (from info endpoint)
        if ( function_exists( 'ota_sideload_image' ) ) {
            $images = array();
            if ( ! empty( $hotel['images'] ) && is_array( $hotel['images'] ) ) {
                $images = $hotel['images'];
            } elseif ( ! empty( $hotel['images_ext'] ) && is_array( $hotel['images_ext'] ) ) {
                foreach ( $hotel['images_ext'] as $ie ) {
                    if ( ! empty( $ie['url'] ) ) $images[] = $ie['url'];
                }
            }

            $gallery_ids = array();
            foreach ( $images as $i => $img_template ) {
                $working = str_replace( '{size}', '1024x768', $img_template );
                $content_pos = strpos( $working, 'content/' );
                if ( $content_pos !== false && ! empty( $image_prefix ) ) {
                    $content_path = substr( $working, $content_pos );
                    $working = rtrim( $image_prefix, '/' ) . '/' . ltrim( $content_path, '/' );
                }

                $attach = ota_sideload_image( $working, $post_id, "WorldOTA image #{$i} for {$title}" );
                if ( is_wp_error( $attach ) ) continue;

                if ( $i === 0 ) set_post_thumbnail( $post_id, $attach );
                else $gallery_ids[] = $attach;
            }

            if ( ! empty( $gallery_ids ) ) {
                update_post_meta( $post_id, '_mphb_gallery_items', $gallery_ids );
                $gallery_ids_string = implode( ',', $gallery_ids );
                update_post_meta( $post_id, 'mphb_gallery', $gallery_ids_string );
            }
        }

        // ----------------------
        // Create or reuse a Season (mphb_season)
        // ----------------------
        $season_id = 0;
        $existing_seasons = get_posts( array(
            'post_type'      => 'mphb_season',
            'posts_per_page' => 1,
            'fields'         => 'ids',
        ) );

        if ( ! empty( $existing_seasons ) ) {
            $season_id = (int) $existing_seasons[0];
        } else {
            $today = date('Y-m-d');
            $far   = date('Y-m-d', strtotime('+5 years'));

            $season_post = wp_insert_post( array(
                'post_title'   => 'WorldOTA default season (edit dates in admin)',
                'post_type'    => 'mphb_season',
                'post_status'  => 'publish',
                'post_content' => 'Automatically created helper season for WorldOTA imported rates.',
            ), true );

            if ( ! is_wp_error( $season_post ) ) {
                $season_id = (int) $season_post;

                // These meta keys match your example and typical MPHB naming
                update_post_meta( $season_id, 'mphb_start_date', $today );
                update_post_meta( $season_id, 'mphb_end_date', $far );
                update_post_meta( $season_id, 'mphb_repeat_period', 'year' );
            }
        }

        // ----------------------
        // Create helper mphb_rate (visible in admin) and populate mphb_season_prices
        // Use price data from search/hp if available, otherwise fall back to info endpoint heuristic
        // ----------------------
        $rate_title = 'WorldOTA rate for: ' . $title;
        $rate_post = wp_insert_post( array(
            'post_title'   => $rate_title,
            'post_type'    => 'mphb_rate',
            'post_status'  => 'publish',
            'post_content' => 'Imported helper rate from WorldOTA. Rates based on search/hp endpoint data (if available).',
        ), true );

        if ( ! is_wp_error( $rate_post ) ) {
            $rate_id = (int) $rate_post;

            // Link rate -> room using the MPHB expected meta key
            update_post_meta( $rate_id, 'mphb_room_type_id', $post_id );

            // Store raw metapolicy from info endpoint for reference
            if ( ! empty( $hotel['metapolicy_struct'] ) ) {
                update_post_meta( $rate_id, '_worldota_rate_metapolicy_info', $hotel['metapolicy_struct'] );
            }

            // Store raw price data from search/hp endpoint for reference
            if ( $price_data ) {
                update_post_meta( $rate_id, '_worldota_rate_price_data_search', $price_data );
            }

            // Link to helper season id
            if ( $season_id ) {
                update_post_meta( $rate_id, '_worldota_rate_season_id', $season_id );
            }

            // Build mphb_season_prices value (array)
            // Use the effective price determined earlier (from search/hp or info)
            $season_prices_entry = array(
                'season' => (string) $season_id,
                'price'  => array(
                    'periods'            => array( 0 => 1 ), // Default period
                    'prices'             => array( 0 => (float) number_format( (float)$effective_base_price, 2, '.', '' ) ), // Use effective price
                    'base_adults'        => (int) $adults,
                    'base_children'      => (int) $children,
                    'extra_adult_prices' => array( 0 => '' ),
                    'extra_child_prices' => array( 0 => '' ),
                    'enable_variations'  => false,
                    'variations'         => array()
                )
            );

            // mphb_season_prices expects an array of these entries
            $mphb_season_prices = array();
            $mphb_season_prices[] = $season_prices_entry;

            // Save mphb_season_prices meta
            update_post_meta( $rate_id, 'mphb_season_prices', $mphb_season_prices );

            // Store the effective base price used for this rate
            update_post_meta( $rate_id, '_worldota_rate_base_price_effective', number_format( (float)$effective_base_price, 2, '.', '' ) );
            update_post_meta( $rate_id, '_worldota_rate_base_price_info', number_format( (float)$base_price_from_info, 2, '.', '' ) ); // Store info price too

            // Optional helper summary meta (from info endpoint)
            $extra_summary = array();
            if ( ! empty( $hotel['metapolicy_struct']['extra_bed'] ) ) $extra_summary['extra_bed'] = $hotel['metapolicy_struct']['extra_bed'];
            if ( ! empty( $hotel['metapolicy_struct']['children'] ) )  $extra_summary['children']  = $hotel['metapolicy_struct']['children'];
            if ( ! empty( $hotel['metapolicy_struct']['cot'] ) )       $extra_summary['cot']       = $hotel['metapolicy_struct']['cot'];

            if ( ! empty( $extra_summary ) ) update_post_meta( $rate_id, '_worldota_rate_extras_info', $extra_summary );
        }
		$hotel_terms = array(
            'categories' => $cat_terms ?? array(), // Categories from info endpoint
            'facilities' => $amenities ?? array(), // Facilities from info endpoint
        );
		
		
        if ( ! empty( $hotel['room_groups'] ) && is_array( $hotel['room_groups'] ) ) {
			update_post_meta( $post_id, '_worldota_room_groups_data', $hotel['room_groups'] );
            foreach ( $hotel['room_groups'] as $rg ) {
                ota_create_room_from_group( $post_id, $title, $hotel_terms, $rg, $hotel, $price_data ); // Pass the price_data fetched from search/hp
            }
        }
		else{
			$default_room_group = array(
        'name' => $title . ' Room',
        'room_group_id' => 'default_' . $hotel_id,
        'room_amenities' => array(),
        'rg_ext' => array(
            'capacity' => $adults // Use the adults capacity from hotel
        ),
        'name_struct' => array(
            'main_name' => $title
        )
     );
        ota_create_room_from_group( $post_id, $title, $hotel_terms, $default_room_group, $hotel, $price_data );
        update_post_meta( $post_id, '_worldota_room_groups_data', $default_room_group );
		}

        return (int) $post_id;
    }
}

//================================================================================================================

function rh_is_room_booked_for_range( $hotel_id, $room_name, $checkin, $checkout ) {
    global $wpdb;
    $table = $wpdb->prefix . 'rh_bookings';

    $sql = $wpdb->prepare("
        SELECT COUNT(*) 
        FROM $table
        WHERE hotel_id = %s
          AND room_name = %s
          AND (
                (STR_TO_DATE(check_in,  '%d/%m/%Y') <= STR_TO_DATE(%s, '%Y-%m-%d')
                 AND STR_TO_DATE(check_out, '%d/%m/%Y') > STR_TO_DATE(%s, '%Y-%m-%d'))
            )
    ", $hotel_id, $room_name, $checkout, $checkin );

    return $wpdb->get_var($sql) > 0;
}

//================================================================================================================

add_action('rest_api_init', function () {
    register_rest_route('worldota/v1', '/hotel-info', array(
        'methods'  => 'POST',
        'callback' => 'get_worldota_hotel_info',
    ));
});

function get_worldota_hotel_info( WP_REST_Request $request ) {
    global $wpdb;

    $body = $request->get_json_params();

    // ---------- AUTH ----------
    $creds    = worldota_get_creds();
    $username = $creds['key_id'] ?? '';
    $password = $creds['key']    ?? '';

    if ( ! $username || ! $password ) {
        return array(
            'success' => false,
            'message' => 'Worldota credentials missing',
        );
    }

    $headers = array(
        'Authorization' => 'Basic ' . base64_encode( "$username:$password" ),
        'Content-Type'  => 'application/json',
    );

    // ---------- INPUTS ----------
    $hotelId      = isset( $body['id'] ) ? trim( $body['id'] ) : '';
    $check_in_raw = $body['check_in']  ?? '';
    $check_out_raw= $body['check_out'] ?? '';

    // Adults / children / child ages JSON body se
    $adults    = isset( $body['adults'] )   ? (int) $body['adults']   : 1;
    $children  = isset( $body['children'] ) ? (int) $body['children'] : 0;

    // front-end se kis key se aa raha ho:
    // child_ages: [5,7]  ya mphb_child_age: {1: 5, 2: 7}
    $childAgesRaw = $body['child_ages']
                    ?? $body['mphb_child_age']
                    ?? array();

    if ( ! $hotelId || ! $check_in_raw || ! $check_out_raw ) {
        return array(
            'success' => false,
            'message' => 'id, check_in, check_out required',
        );
    }

    // frontend -> "dd/mm/yyyy", API -> "Y-m-d"
    $checkin  = worldota_dmy_to_ymd( $check_in_raw );
    $checkout = worldota_dmy_to_ymd( $check_out_raw );

    if ( ! $checkin || ! $checkout ) {
        return array(
            'success' => false,
            'message' => 'Invalid date format, expected dd/mm/yyyy',
        );
    }

    // DateTime objects for overlap check
    $reqIn  = DateTime::createFromFormat( 'Y-m-d', $checkin );
    $reqOut = DateTime::createFromFormat( 'Y-m-d', $checkout );

    // ---------- 1) hotel/info ----------
    $urlInfo  = "https://api-sandbox.worldota.net/api/b2b/v3/hotel/info";
    $payload1 = wp_json_encode( array(
        'id'       => $hotelId,
        'language' => 'en',
    ) );

    $respInfo = wp_remote_post( $urlInfo, array(
        'headers' => $headers,
        'body'    => $payload1,
        'timeout' => 60,
    ) );

    if ( is_wp_error( $respInfo ) ) {
        return array(
            'success' => false,
            'message' => 'hotel/info request failed',
            'debug'   => $respInfo->get_error_message(),
        );
    }

    $jsonInfo   = json_decode( wp_remote_retrieve_body( $respInfo ), true );
    $dataInfo   = $jsonInfo['data'] ?? array();
    $roomGroups = $dataInfo['room_groups'] ?? array();

    $hotelHid      = $dataInfo['hid'] ?? null;
    $hotelStringId = $dataInfo['id']  ?? $hotelId;

    // ---------- 2) search/hp (rates + book_hash) ----------
    $urlHp = "https://api-sandbox.worldota.net/api/b2b/v3/search/hp/";

    // Child ages ko clean numeric array me convert karo
    $childrenAgesArray = array();
    if ( ! empty( $childAgesRaw ) && is_array( $childAgesRaw ) ) {
        foreach ( $childAgesRaw as $age ) {
            $childrenAgesArray[] = (int) $age;
        }
    }

    // HP payload Worldota docs ke according
    $hpPayload = array(
        "checkin"   => $checkin,
        "checkout"  => $checkout,
        "residency" => "us",  // customer residency
        "language"  => "en",
        "currency"  => "USD",
        "timeout"   => 8,
        "guests"    => array(
            array(
                "adults"   => max( 1, $adults ),
                "children" => $childrenAgesArray, // e.g. [5,7]
            ),
        ),
    );

    // ID/hid logic
    if ( is_numeric( $hotelStringId ) ) {
        $hpPayload['hid'] = (int) $hotelStringId;
    } else {
        $hpPayload['id']  = $hotelStringId;
    }

    $respHp = wp_remote_post( $urlHp, array(
        'headers' => $headers,
        'body'    => wp_json_encode( $hpPayload ),
        'timeout' => 60,
    ) );

    // roomName => cheapest NET + client + hash + daily price
    $pricesByRoom = array();
    $jsonHp       = null; // debug ke liye

    if ( ! is_wp_error( $respHp ) ) {
        $jsonHp   = json_decode( wp_remote_retrieve_body( $respHp ), true );
        $hotelsHp = $jsonHp['data']['hotels'] ?? array();

        if ( ! empty( $hotelsHp ) ) {
            $ratesHp = $hotelsHp[0]['rates'] ?? array();

            foreach ( $ratesHp as $rate ) {
                $roomName =
                    $rate['room_data_trans']['main_name']
                    ?? $rate['room_name']
                    ?? null;

                if ( ! $roomName ) {
                    continue;
                }

                $paymentTypes = $rate['payment_options']['payment_types'] ?? array();
                if ( empty( $paymentTypes ) ) {
                    continue;
                }

                $showAmountNet = (float) ( $paymentTypes[0]['show_amount'] ?? 0 );
                if ( $showAmountNet <= 0 ) {
                    continue;
                }

                $bookHash = $rate['book_hash'] ?? null; // h-...
                if ( ! $bookHash ) {
                    continue;
                }

                // 🔹 daily_prices se per-night price nikaalo
                $dailyPrices     = $rate['daily_prices'] ?? array();
                $firstDailyPrice = null;
                if ( ! empty( $dailyPrices ) && isset( $dailyPrices[0] ) ) {
                    $firstDailyPrice = (float) $dailyPrices[0];
                }

                // markup/discount helper (already defined by you)
                //$clientAmount = rh_apply_price_adjustment( $showAmountNet );
                $clientAmount = $showAmountNet;

                if (
                    ! isset( $pricesByRoom[ $roomName ] ) ||
                    $showAmountNet < $pricesByRoom[ $roomName ]['price_net']
                ) {
                    $pricesByRoom[ $roomName ] = array(
                        'price_net'      => $showAmountNet,
                        'price_client'   => $clientAmount,
                        'book_hash'      => $bookHash,
                        'daily_price'    => $firstDailyPrice, // 🔥 per-night price
                        'daily_prices'   => $dailyPrices,      // full array
                    );
                }
            }
        }
    }

    // ---------- 3) Local bookings (rh_bookings) se check ----------
    $table = $wpdb->prefix . 'rh_bookings';

    $bookings = $wpdb->get_results(
        $wpdb->prepare(
            "SELECT room_name, check_in, check_out 
             FROM $table
             WHERE hotel_id = %s",
            $hotelStringId
        )
    );

    // overlap helper
    $is_room_booked = function( $roomName ) use ( $bookings, $reqIn, $reqOut ) {

        if ( empty( $bookings ) || ! $roomName || ! $reqIn || ! $reqOut ) {
            return false;
        }

        foreach ( $bookings as $b ) {
            if ( $b->room_name !== $roomName ) {
                continue;
            }

            // DB me dd/mm/YYYY store hai
            $in  = DateTime::createFromFormat( 'd/m/Y', $b->check_in );
            $out = DateTime::createFromFormat( 'd/m/Y', $b->check_out );

            // agar kabhi format change ho jaye to fallback Y-m-d
            if ( ! $in ) {
                $in = DateTime::createFromFormat( 'Y-m-d', $b->check_in );
            }
            if ( ! $out ) {
                $out = DateTime::createFromFormat( 'Y-m-d', $b->check_out );
            }

            if ( ! $in || ! $out ) {
                continue;
            }

            // overlap: [in, out) vs [reqIn, reqOut)
            if ( $in < $reqOut && $reqIn < $out ) {
                return true;
            }
        }

        return false;
    };

    // ---------- 4) Inject prices + book_hash + is_booked ----------
    $totalRooms  = 0;
    $bookedCount = 0;

    foreach ( $roomGroups as &$rg ) {
        $rgName =
            $rg['name_struct']['main_name']
            ?? $rg['name']
            ?? null;

        if ( $rgName && isset( $pricesByRoom[ $rgName ] ) ) {
            $priceData = $pricesByRoom[ $rgName ];

            $rg['min_price_net'] = $priceData['price_net'];
            $rg['min_price']     = $priceData['price_client'];
            $rg['book_hash']     = $priceData['book_hash'];

            // 🔥 yahan daily price inject kar rahe hain
            $rg['daily_price']   = $priceData['daily_price']  ?? null;
            $rg['daily_prices']  = $priceData['daily_prices'] ?? array();
        } else {
            $rg['min_price_net'] = null;
            $rg['min_price']     = null;
            $rg['book_hash']     = null;
            $rg['daily_price']   = null;
            $rg['daily_prices']  = array();
        }

        $rg['hid']      = $hotelHid;
        $rg['hotel_id'] = $hotelStringId;

        // yahi flag front-end filter karega
        $booked = $is_room_booked( $rgName );
        $rg['is_booked'] = $booked ? true : false;

        $totalRooms++;
        if ( $booked ) {
            $bookedCount++;
        }
    }
    unset( $rg );

    $allBooked = ( $totalRooms > 0 && $bookedCount > 0 && $bookedCount >= $totalRooms );

    // 🔥 Debug info
    return array(
        'success'          => true,
        'hotel_id'         => $hotelStringId,
        'hid'              => $hotelHid,
        'checkin'          => $checkin,
        'checkout'         => $checkout,
        'rooms'            => $roomGroups,
        'all_rooms_booked' => $allBooked,

        'debug'            => array(
            'request_body'       => $body,
            'hotel_info_payload' => json_decode( $payload1, true ),
            'hotel_info_raw'     => $jsonInfo,
            'hp_payload'         => $hpPayload,
            'hp_raw'             => $jsonHp,
            // 'prices_by_room'   => $pricesByRoom, // agar aur debug chahiye to uncomment
        ),
    );
}


/****woocommerce handle the order area*****/


add_filter(
    'woocommerce_payment_complete_order_status',
    function ($status, $order_id, $order) {
		
		

        // Force Stripe orders to processing
        if ($order && $order->get_payment_method() === 'stripe') {
            return 'processing';
        }

        return $status;
    },
    10,
    3
);

add_action('woocommerce_order_status_on-hold', 'ratehawk_after_payment');
add_action('woocommerce_order_status_processing', 'ratehawk_after_payment');

function ratehawk_after_payment($order_id) {
  $order = wc_get_order($order_id);
  $payload = $order->get_meta('ratehawk_payload');
  $payload["woocommerceorder_id"] = $order_id;

  if (!$payload) return;

  $request = new WP_REST_Request('POST', '/worldota/v1/create-booking');
  $request->set_body_params($payload);

  $response = worldota_create_booking_form($request);


  if (($response['status'] ?? '') === 'ok') {
    $order->update_status('completed', 'RateHawk booking confirmed');
  } else {
    wc_create_refund([
      'order_id' => $order_id,
      'amount'   => $order->get_total(),
    ]);
    $order->update_status('refunded');
  }
}

add_action('rest_api_init', function () {
    register_rest_route('worldota/v1', '/create-wc-order', [
        'methods' => 'POST',
        'callback' => 'ratehawk_create_wc_order',
        'permission_callback' => '__return_true',
    ]);
});

function ratehawk_create_wc_order(WP_REST_Request $request) {
	$creds    = worldota_get_creds();

    $woocommerce_product_id = $creds['woocommerce_product_id'] ?? '';
	
    if (!class_exists('WooCommerce')) {
        return ['success' => false, 'message' => 'WooCommerce not active'];
    }
	
	if($woocommerce_product_id==''){
		return ['success' => false, 'message' => 'No Woo product Id Mention in RateHawk Settings:'];
	}
	
	define('RATEHAWK_PRODUCT_ID', $woocommerce_product_id);
	
    $data  = $request->get_json_params();
    $price = (float) $data['final_payment'];

    $order = wc_create_order();

	// 1️⃣ FORCE correct status
	$order->set_status('pending'); // REQUIRED

	// 2️⃣ FORCE currency
	$order->set_currency(get_woocommerce_currency());

	// 3️⃣ ADD product with price
	$order->add_product(
		wc_get_product(RATEHAWK_PRODUCT_ID),
		1,
		[
			'subtotal' => $price,
			'total'    => $price,
		]
	);

	// 4️⃣ FORCE total
	$order->set_total($price);

	// 5️⃣ FORCE payment method (THIS IS THE MAIN FIX)
	$order->set_payment_method('stripe');
	$order->set_payment_method_title('Credit Card (Stripe)');

	// 6️⃣ Save booking payload
	$order->update_meta_data('ratehawk_payload', $data);

	// 7️⃣ Calculate + save
	$order->calculate_totals();
	$order->save();


    return [
        'success' => true,
        'checkout_url' => $order->get_checkout_payment_url(),
    ];
}



/***woocommerce handle end******/

// Create bookings ===============================================================================================
// REST route ====================================================================================================
add_action('rest_api_init', function () {
    register_rest_route('worldota/v1', '/create-booking', array(
        'methods'  => 'POST',
        'callback' => 'worldota_create_booking_form',
        'permission_callback' => '__return_true',
    ));
});

function worldota_create_booking_form( WP_REST_Request $request ) {
	$body = $request->get_body_params();

	$partner_order_id = 'KBIZ-RH-' . bin2hex(random_bytes(8));

	$creds    = worldota_get_creds();
	
    $username = $creds['key_id'] ?? '';
    $password = $creds['key']    ?? '';
    $api_url = $creds['api_url']    ?? '';
   
    $book_hash = $body['book_hash']    ?? '';
    $woocommerceorder_id = $body['woocommerceorder_id']    ?? '';
    $rooms = $body['rooms']    ?? '';

    if ( ! $username || ! $password ) {
        return [
            'success' => false,
            'message' => 'Worldota credentials missing.',
        ];
    }

    $headers_api = [
        'Authorization' => 'Basic ' . base64_encode( "$username:$password" ),
        'Content-Type'  => 'application/json',
    ];
	
	

	$urlForm = "$api_url/api/b2b/v3/hotel/order/booking/form/";

    $formPayload = [
        "partner_order_id" => $partner_order_id,
        "book_hash"        => $book_hash,
        "language"         => "en",
        "user_ip"          => $_SERVER['REMOTE_ADDR'] ?? "127.0.0.1",
    ];

    $respForm = wp_remote_post( $urlForm, [
        'headers' => $headers_api,
        'body'    => json_encode( $formPayload ),
        'method'  => 'POST',
        'timeout' => 60,
    ] );


    if ( is_wp_error( $respForm ) ) {
        return [
            'success' => false,
            'step'    => 'booking_form',
            'message' => 'Error in booking/form.',
            'debug'   => $respForm->get_error_message(),
        ];
    }

    $bodyForm = wp_remote_retrieve_body( $respForm );
	
    $jsonForm = json_decode( $bodyForm, true );


	if($jsonForm['status']=="ok"){
		$urlFinish = "$api_url/api/b2b/v3/hotel/order/booking/finish/";
		
		$first_name = $body['first_name']    ?? '';
		$last_name = $body['last_name']    ?? '';
		$email = $body['email']    ?? '';
		$mobile = $body['mobile']    ?? '';
		$hotel_id = $body['hotel_id']    ?? '';
		$room_id = $body['room_id']    ?? '';
		$final_payment = $body['final_payment']    ?? '';
		$currency_code = $body['currency_code']    ?? 'USD';
		$check_in = $body['check_in']    ?? '';
		$check_out = $body['check_out']    ?? '';
		$hotel_name = $body['hotel_name']    ?? '';
		$room_name = $body['room_name']    ?? '';
		$total_nights = $body['total_nights']    ?? '';
		$total_no_guests = $body['total_no_guests']    ?? '';
		$cancellation_option = $body['cancellation_option']    ?? '';
		
		$pay_type = "deposit";
		
		
		$finishPayload = [
			"user" => [
				"email"   => $email,
				"phone"   => $mobile,
			],
			 "supplier_data"=> [
				"first_name_original"=> "Peter",
				"last_name_original"=> "Collins",
				"phone"=> "12124567880",
				"email"=> "peter.collins@example.com"
			  ],
			"partner" => [
				"partner_order_id"  => $partner_order_id,
				"comment"           => "WP site booking: {$hotel_id} / {$room_id}",
				"amount_sell_b2b2c" => (string) $final_payment,
			],
			"language" => "en",
			"rooms"    => [
				[
					"guests" => $rooms[0]["guests"]
				]
			],
			"payment_type" => [
				"type"          => $pay_type,
				"amount"        => (string) $final_payment,
				"currency_code" => $currency_code,
			],
			"return_path" => home_url( '/booking-success/' ),
		];
		
		$respFinish = wp_remote_post( $urlFinish, [
			'headers' => $headers_api,
			'body'    => json_encode( $finishPayload ),
			'method'  => 'POST',
			'timeout' => 60,
		] );
		
		$bodyFinish = wp_remote_retrieve_body( $respFinish );
		$jsonBody = json_decode( $bodyFinish, true );	
		
		if($jsonBody['status']=="ok"){
			$urlFinishStatus = "$api_url/api/b2b/v3/hotel/order/booking/finish/status/";
			$finishPayloadStatus = [
				"partner_order_id"   => $partner_order_id
			];
			$jsonBody = request_booking_finish_status(
				$urlFinishStatus,
				$headers_api,
				$partner_order_id
			);
			$order = wc_get_order($woocommerceorder_id);
			$current_user = wp_get_current_user();

			if ($current_user && $current_user->exists()) {
				$login_email = $current_user->user_email;
			} else{
				$login_email = $email;
			}
			 
			$user = get_user_by('email', $login_email);
			
			if ($user) {
				$order->set_customer_id($user->ID);

			} else {
				$user_id = wc_create_new_customer(
					$login_email,
					'',
					wp_generate_password()
				);

				if (!is_wp_error($user_id)) {
					$user = get_user_by('id', $user_id);
					$user->set_role('customer');
					$order->set_customer_id($user_id);
				}
			}

			
			$order->update_meta_data('ratehawk_partner_order_id', $partner_order_id);
			
			$order->update_meta_data('_partner_order_id', 'wc_' . $order_id);
			$order->update_meta_data('email', $email);
			$order->update_meta_data('guests', $total_no_guests);
			$order->update_meta_data('nights', $total_nights);
			$order->update_meta_data('mobile', $mobile);
			$order->update_meta_data('check_in', $check_in);
			$order->update_meta_data('check_out', $check_out);
			$order->update_meta_data('_hotel_name', $hotel_name);
			$order->update_meta_data('_room_name', $room_name);
			$order->update_meta_data('currency_code', $currency_code);
			$order->update_meta_data('cancellation_option', $cancellation_option);

			$order->save();
			
			/* echo "<pre>";print_r($jsonBody); */
			
			if (($jsonBody['status'] ?? '') === 'ok') {
				echo "Thank you for the booking confirmation";
			}
			$redirect_url = add_query_arg([
			'order_id'   => $partner_order_id,
			'status'     => 'confirmed',
			'check_in'   => $body['check_in'] ?? '',
			'check_out'  => $body['check_out'] ?? '',
			'guests'     => $body['guests'] ?? '',
			'hotel'      => $body['hotel_id'] ?? '',
			'room'       => $body['room_id'] ?? '',
			'amount'     => $final_payment,
			'currency'   => $currency_code,
		], home_url('/thank-you/'));

		wp_redirect($redirect_url);
		exit;
		}
		
		
	}

}

function request_booking_finish_status($urlFinishStatus, $headers_api, $partner_order_id) {

    static $retryCount = 0;
    static $startTime = null;

    if ($startTime === null) {
        $startTime = microtime(true); // start timer only once
    }

    $retryCount++;

    $finishPayloadStatus = [
        "partner_order_id" => $partner_order_id
    ];

    $response = wp_remote_post($urlFinishStatus, [
        'headers' => $headers_api,
        'body'    => json_encode($finishPayloadStatus),
        'timeout' => 60
    ]);

    if (is_wp_error($response)) {
        return [
            'status' => 'error',
            'message' => $response->get_error_message(),
            'retry_count' => $retryCount,
            'time_taken_sec' => round(microtime(true) - $startTime, 2)
        ];
    }

    $body     = wp_remote_retrieve_body($response);
    $jsonBody = json_decode($body, true);

    // 🔁 If still processing → recall same function
    if (($jsonBody['status'] ?? '') === 'processing') {

        sleep(1); // optional delay

        return request_booking_finish_status(
            $urlFinishStatus,
            $headers_api,
            $partner_order_id
        );
    }

    // ✅ Final response (ok / confirmed / failed)
    $jsonBody['retry_count'] = $retryCount;
    $jsonBody['time_taken_sec'] = round(microtime(true) - $startTime, 2);

    return $jsonBody;
}




/**
 * Helper: convert dd/mm/yyyy -> Y-m-d
 */
function worldota_dmy_to_ymd($str) {
    if (!$str) return null;
    $parts = explode('/', $str);
    if (count($parts) !== 3) return null;
    // d / m / Y
    $d = (int)$parts[0];
    $m = (int)$parts[1];
    $y = (int)$parts[2];
    if (!checkdate($m, $d, $y)) return null;
    return sprintf('%04d-%02d-%02d', $y, $m, $d);
}

//================================================================================================================
//================================================================================================================


add_action( 'template_redirect', function() {
    if ( empty( $_GET['ota_import'] ) ) return;
    $hotel_id = isset( $_GET['hotel_id'] ) ? sanitize_text_field( wp_unslash( $_GET['hotel_id'] ) ) : '';
    $lang = isset( $_GET['lang'] ) ? sanitize_text_field( wp_unslash( $_GET['lang'] ) ) : 'en';
	$checkin = isset( $_GET['checkin'] ) ? sanitize_text_field( wp_unslash( $_GET['checkin'] ) ) : '';
	$checkout = isset( $_GET['checkout'] ) ? sanitize_text_field( wp_unslash( $_GET['checkout'] ) ) : '';
	$adults = isset( $_GET['adults'] ) ? sanitize_text_field( wp_unslash( $_GET['adults'] ) ) : '';
	$children = isset( $_GET['children'] ) ? sanitize_text_field( wp_unslash( $_GET['children'] ) ) : '';
    $currency = isset( $_GET['currency'] ) ? sanitize_text_field( wp_unslash( $_GET['currency'] ) ) : 'USD'; // Get currency from URL
    $nonce = isset( $_GET['ota_import_nonce'] ) ? sanitize_text_field( wp_unslash( $_GET['ota_import_nonce'] ) ) : '';

    // Optional but recommended: verify nonce.
    if ( ! wp_verify_nonce( $nonce, 'ota_import_action' ) ) {
        $redirect = add_query_arg( array( 'hotel_id' => $hotel_id, 'checkin' => $checkin, 'checkout' => $checkout , 'lang' => $lang, 'currency' => $currency, 'import_error' => 'invalid_nonce' ), home_url('/hotel-detail/') );
        wp_safe_redirect( $redirect );
        exit;
    }
    if ( empty( $hotel_id ) ) {
        wp_safe_redirect( home_url() );
        exit;
    }

    @set_time_limit(120);

    // If already imported, redirect to existing
    $existing = get_posts( array(
        'post_type' => defined('MPHB_ROOM_POST_TYPE') ? MPHB_ROOM_POST_TYPE : 'mphb_room_type',
        'meta_key' => '_imported_from_worldota_id',
        'meta_value' => sanitize_text_field( $hotel_id ),
        'fields' => 'ids',
        'posts_per_page' => 1,
    ) );    


    if ( ! empty( $existing ) ) {
        $permalink = get_permalink( $existing[0] );
        if ( $permalink ) {
            wp_safe_redirect( $permalink ); 
            exit;
        }
    }

    if ( ! function_exists( 'ota_import_hotel_by_id' ) ) {
	
        $redirect = add_query_arg( array( 'hotel_id' => $hotel_id,  'checkin' => $checkin, 'checkout' => $checkout , 'lang' => $lang, 'currency' => $currency, 'import_error' => 'import_function_missing' ), home_url('/hotel-detail/') );
        wp_safe_redirect( $redirect );
        exit;
    }
    // $stattime = microtime(true);
	// error_log("checkin ".$checkin." "."checkout".$checkout);
    $result = ota_import_hotel_by_id( $hotel_id ,$checkin , $checkout , $adults,$children, $lang, $currency); // Pass currency

    if ( is_wp_error( $result ) ) {
        $redirect = add_query_arg( array( 'hotel_id' => $hotel_id,  'checkin' => $checkin, 'checkout' => $checkout , 'lang' => $lang, 'currency' => $currency, 'import_error' => urlencode( $result->get_error_message() ) ), home_url('/hotel-detail/') );
        wp_safe_redirect( $redirect );
        exit;
    }

    $new_post_id = (int) $result;
    $permalink = get_permalink( $new_post_id );

    if ( $permalink ) {
        wp_safe_redirect( $permalink );
        exit;
    } else {
        $redirect = add_query_arg( array( 'hotel_id' => $hotel_id,  'checkin' => $checkin, 'checkout' => $checkout , 'lang' => $lang, 'currency' => $currency ), home_url('/hotel-detail/') );
        wp_safe_redirect( $redirect );
        exit;
    }
} );


// Register settings and add settings page
add_action( 'admin_menu', 'worldota_settings_menu' );
add_action( 'admin_init', 'worldota_register_settings' );

function worldota_settings_menu() {
    add_options_page(
        'WorldOTA Settings',
        'RateHawk Plugin Settings',
        'manage_options',
        'worldota-settings',
        'worldota_render_settings_page'
    );
}

function worldota_register_settings() {
    register_setting( 'worldota_settings_group', 'worldota_settings', 'worldota_sanitize_settings' );

    add_settings_section(
        'worldota_section_main',
        'RateHawk Plugin Settings',
        function(){ echo '<p>Enter API credentials for sandbox and live. Pick which one should be active.</p>'; },
        'worldota-settings'
    );

    add_settings_field( 'worldota_mode', 'Active mode', 'worldota_field_mode_cb', 'worldota-settings', 'worldota_section_main' );
    add_settings_field( 'worldota_sandbox_key_id', 'Sandbox: Key ID', 'worldota_field_sandbox_key_id_cb', 'worldota-settings', 'worldota_section_main' );
    add_settings_field( 'worldota_sandbox_key', 'Sandbox: Key', 'worldota_field_sandbox_key_cb', 'worldota-settings', 'worldota_section_main' );
    add_settings_field( 'worldota_live_key_id', 'Live: Key ID', 'worldota_field_live_key_id_cb', 'worldota-settings', 'worldota_section_main' );
    add_settings_field( 'worldota_live_key', 'Live: Key', 'worldota_field_live_key_cb', 'worldota-settings', 'worldota_section_main' );
    

    // Optional: custom API URLs (if you use sandbox/prod hosts)
    add_settings_field( 'worldota_sandbox_api_url', 'Sandbox API URL', 'worldota_field_sandbox_api_url_cb', 'worldota-settings', 'worldota_section_main' );
    add_settings_field( 'worldota_live_api_url', 'Live API URL', 'worldota_field_live_api_url_cb', 'worldota-settings', 'worldota_section_main' );
	
	add_settings_field( 'worldota_woocommerce_productId', 'Woocommerce Product: Id', 'woocommerce_product_id', 'worldota-settings', 'worldota_section_main' );
}

function worldota_sanitize_settings( $input ) {
    $out = array();

    $out['mode'] = ( isset($input['mode']) && in_array($input['mode'], array('sandbox','live'), true) ) ? $input['mode'] : 'sandbox';

    $out['sandbox_key_id'] = isset($input['sandbox_key_id']) ? sanitize_text_field( $input['sandbox_key_id'] ) : '';
    $out['sandbox_key']    = isset($input['sandbox_key']) ? sanitize_text_field( $input['sandbox_key'] ) : '';

    $out['live_key_id'] = isset($input['live_key_id']) ? sanitize_text_field( $input['live_key_id'] ) : '';
    $out['live_key']    = isset($input['live_key']) ? sanitize_text_field( $input['live_key'] ) : '';

    $out['sandbox_api_url'] = isset($input['sandbox_api_url']) ? esc_url_raw( $input['sandbox_api_url'] ) : 'https://api-sandbox.worldota.net';
    $out['live_api_url']    = isset($input['live_api_url']) ? esc_url_raw( $input['live_api_url'] ) : 'https://api.worldota.net';
    $out['woocommerce_product_id']    = isset($input['woocommerce_product_id']) ? sanitize_text_field( $input['woocommerce_product_id'] ) : '';

    return $out;
}

/* Fields callbacks */
function worldota_field_mode_cb() {
    $opts = get_option('worldota_settings', array('mode'=>'sandbox'));
    $mode = $opts['mode'] ?? 'sandbox';
    ?>
    <select name="worldota_settings[mode]">
        <option value="sandbox" <?php selected( $mode, 'sandbox' ); ?>>Sandbox</option>
        <option value="live" <?php selected( $mode, 'live' ); ?>>Live</option>
    </select>
    <p class="description">Choose which environment is active. Keys for both can be stored but only the active set will be used.</p>
    <?php
}

function woocommerce_product_id() {
    $opts = get_option('worldota_settings', array());
    $val = $opts['woocommerce_product_id'] ?? '';
    printf('<input type="text" style="width:400px" name="worldota_settings[woocommerce_product_id]" value="%s">', esc_attr($val));
	echo "Note: It is used in place order while hotel booking order page.";
}

function worldota_field_sandbox_key_id_cb() {
    $opts = get_option('worldota_settings', array());
    $val = $opts['sandbox_key_id'] ?? '';
    printf('<input type="text" style="width:400px" name="worldota_settings[sandbox_key_id]" value="%s">', esc_attr($val));
}

function worldota_field_sandbox_key_cb() {
    $opts = get_option('worldota_settings', array());
    $val = $opts['sandbox_key'] ?? '';
    printf('<input type="text" style="width:400px" name="worldota_settings[sandbox_key]" value="%s">', esc_attr($val));
}

function worldota_field_live_key_id_cb() {
    $opts = get_option('worldota_settings', array());
    $val = $opts['live_key_id'] ?? '';
    printf('<input type="text" style="width:400px" name="worldota_settings[live_key_id]" value="%s">', esc_attr($val));
}

function worldota_field_live_key_cb() {
    $opts = get_option('worldota_settings', array());
    $val = $opts['live_key'] ?? '';
    printf('<input type="text" style="width:400px" name="worldota_settings[live_key]" value="%s">', esc_attr($val));
}

function worldota_field_sandbox_api_url_cb() {
    $opts = get_option('worldota_settings', array());
    $val = $opts['sandbox_api_url'] ?? 'https://api-sandbox.worldota.net';
    printf('<input type="text" style="width:400px" name="worldota_settings[sandbox_api_url]" value="%s">', esc_attr($val));
}

function worldota_field_live_api_url_cb() {
    $opts = get_option('worldota_settings', array());
    $val = $opts['live_api_url'] ?? 'https://api.worldota.net';
    printf('<input type="text" style="width:400px" name="worldota_settings[live_api_url]" value="%s">', esc_attr($val));
}

function worldota_render_settings_page() {
    ?>
    <div class="wrap">
        <h1>WorldOTA Settings</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('worldota_settings_group');
            do_settings_sections('worldota-settings');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}
/**
 * Return active WorldOTA credentials and URLs.
 * Priority order:
 * 1) If constants are defined (WORLDOTA_AUTH_USER / WORLDOTA_AUTH_PASSWORD / WORLDOTA_API_URL / WORLDOTA_IMAGE_PREFIX) use them.
 * 2) Else use options from worldota_settings (admin UI).
 * Returns array: [ 'key_id', 'key', 'api_url', 'image_prefix', 'mode' ]
 */
function worldota_get_creds() {
    // 1) constants override for backward compatibility
    $const_key_id = defined('WORLDOTA_AUTH_USER') ? WORLDOTA_AUTH_USER : ( defined('WO_KEY_ID') ? WO_KEY_ID : null );
    $const_key    = defined('WORLDOTA_AUTH_PASSWORD') ? WORLDOTA_AUTH_PASSWORD : ( defined('WO_KEY') ? WO_KEY : null );
    $const_api    = defined('WORLDOTA_API_URL') ? WORLDOTA_API_URL : null;
    $const_img    = defined('WORLDOTA_IMAGE_PREFIX') ? WORLDOTA_IMAGE_PREFIX : null;

    if ( $const_key_id && $const_key ) {
        return array(
            'key_id' => $const_key_id,
            'key' => $const_key,
            'api_url' => $const_api ?: 'https://api.worldota.net',
            'image_prefix' => $const_img ?: 'https://cdn.worldota.net/t/1024x768/',
            'mode' => 'const'
        );
    }

    // 2) options
    $opts = get_option('worldota_settings', array(
        'mode' => 'sandbox',
        'sandbox_api_url' => 'https://api-sandbox.worldota.net',
        'live_api_url' => 'https://api.worldota.net',
    ));

    $mode = $opts['mode'] ?? 'sandbox';
    $woocommerce_product_id = $opts['woocommerce_product_id'] ?? '';
	

    if ( $mode === 'live' ) {
        $key_id = $opts['live_key_id'] ?? '';
        $key = $opts['live_key'] ?? '';
        $api_url = $opts['live_api_url'] ?? 'https://api.worldota.net';
    } else {
        $key_id = $opts['sandbox_key_id'] ?? '';
        $key = $opts['sandbox_key'] ?? '';
        $api_url = $opts['sandbox_api_url'] ?? 'https://api-sandbox.worldota.net';
    }

    return array(
        'key_id' => $key_id,
        'key' => $key,
        'api_url' => rtrim( $api_url ?: ($mode === 'live' ? 'https://api.worldota.net' : 'https://api-sandbox.worldota.net'), '/' ) . '/',
        'image_prefix' => 'https://cdn.worldota.net/t/1024x768/',
        'mode' => $mode,
        'woocommerce_product_id' => $woocommerce_product_id,
    );
}

function get_hotel_coordinates() {
    global $post;
    if (!$post) return false;
    
    $full_response = get_post_meta($post->ID, '_worldota_full_response', true);
    if (empty($full_response)) return false;
    
    $data = maybe_unserialize($full_response);
    if (!is_array($data)) return false;
    
    if (isset($data['latitude']) && isset($data['longitude'])) {
        return array(
            'lat' => $data['latitude'],
            'lng' => $data['longitude'],
            'address' => $data['address'] ?? '',
            'name' => $data['name'] ?? ''
        );
    }
    
    return false;
}

//=============================================================================================
//=============================================================================================



add_action('after_setup_theme', function () {
    register_nav_menus([
        'primary_menu_guest'  => 'Main Menus – Guest',
    ]);
});



//booking cancel code

add_action('init', function () {

    if (!isset($_GET['refund_request'])) {
        return;
    }

    $order_id = absint($_GET['refund_request']);


    $order = wc_get_order($order_id);
    if (!$order) {
        wp_die('Order not found.');
    }

    // Ownership check
    if ($order->get_customer_id() !== get_current_user_id()) {
        wp_die('Unauthorized request.');
    }

    // Prevent duplicate requests
    if ($order->get_meta('_refund_requested') === 'yes') {
        wp_die('Refund already requested.');
    }

    // Save refund request meta
    $order->update_meta_data('_refund_requested', 'yes');
   
    $order->save();

    wp_safe_redirect( wp_get_referer() );
	exit;
});


//for admin area cancel booking:

function ratehawk_cancel_booking_api($partner_order_id) {

    // 1️⃣ Get credentials
    $creds    = worldota_get_creds();

    $username = $creds['key_id']  ?? '';
    $password = $creds['key']     ?? '';
    $api_url  = $creds['api_url'] ?? '';

    if (empty($username) || empty($password) || empty($api_url)) {
        return [
            'success' => false,
            'message' => 'Worldota credentials are missing or incomplete.',
        ];
    }

    // 2️⃣ Prepare headers
    $headers = [
        'Authorization' => 'Basic ' . base64_encode($username . ':' . $password),
        'Content-Type'  => 'application/json',
    ];

    // 3️⃣ Prepare payload
    $payload = [
        'partner_order_id' => $partner_order_id,
    ];

    // 4️⃣ Endpoint
    $url = trailingslashit($api_url) . 'api/b2b/v3/hotel/order/cancel/';

    // 5️⃣ Call API
    $response = wp_remote_post($url, [
        'headers' => $headers,
        'body'    => wp_json_encode($payload),
        'timeout' => 60,
    ]);

    // 6️⃣ Network / HTTP error
    if (is_wp_error($response)) {
        return [
            'success' => false,
            'message' => 'Unable to connect to Worldota cancellation API.',
            'debug'   => $response->get_error_message(),
        ];
    }

    // 7️⃣ Decode response
    $body = wp_remote_retrieve_body($response);
    $json = json_decode($body, true);

    if (!is_array($json)) {
        return [
            'success' => false,
            'message' => 'Invalid response received from Worldota.',
            'debug'   => $body,
        ];
    }

    // 8️⃣ API-level failure
    if (($json['status'] ?? '') !== 'ok') {
        return [
            'success' => false,
            'message' => $json['error'] ?? 'Booking cancellation failed.',
            'debug'   => $json,
        ];
    }

    // 9️⃣ SUCCESS 🎉
    return [
        'success' => true,
        'message' => 'Booking cancelled successfully.',
        'data'    => $json,
    ];
}



add_action('admin_post_ratehawk_approve_refund', 'ratehawk_handle_admin_refund');

function ratehawk_handle_admin_refund() {

    if (!current_user_can('manage_woocommerce')) {
        wp_die('Unauthorized');
    }

    $order_id = isset($_GET['order_id']) ? absint($_GET['order_id']) : 0;
    if (!$order_id) {
        wp_die('Missing order ID');
    }

    if (
        !isset($_GET['_wpnonce']) ||
        !wp_verify_nonce($_GET['_wpnonce'], 'ratehawk_approve_refund_' . $order_id)
    ) {
        wp_die('Invalid nonce');
    }

    $order = wc_get_order($order_id);
    if (!$order) {
        wp_die('Order not found');
    }

    // Prevent duplicate refunds
    if ($order->get_status() === 'refunded') {
        wp_safe_redirect(wp_get_referer());
        exit;
    }

    // 🔹 STEP 1: Cancel booking in Worldota
    $partner_order_id = $order->get_meta('ratehawk_partner_order_id');
	
    if (!$partner_order_id) {
        $order->add_order_note('Missing partner_order_id. Cannot cancel booking.');
        wp_safe_redirect(wp_get_referer());
        exit;
    }

    $cancel_response = ratehawk_cancel_booking_api($partner_order_id);

	if (!$cancel_response['success']) {
		$order->add_order_note(
			'RateHawk Cancellation failed: ' . $cancel_response['message']
		);
		$order->update_meta_data('_refund_completed', 'incomplete');
		$order->save();
		return;
	}
	if ($cancel_response['success']) {
		$order->update_meta_data('_refund_completed', 'complete');
		$order->add_order_note(
			'Refund Process444 successfully: ' . $cancel_response['message']
		);
		
		$order->save();
		
	}

    // 🔹 STEP 4: Redirect back to order edit page
    wp_safe_redirect(
        admin_url('post.php?post=' . $order_id . '&action=edit')
    );
    exit;
}

//add refund button to order admin:

add_action('woocommerce_admin_order_data_after_order_details', function ($order) {

    if ($order->get_meta('_refund_requested') !== 'yes') {
        return;
    }

    $order_id = $order->get_id();

    $approve_url = wp_nonce_url(
        admin_url('admin-post.php?action=ratehawk_approve_refund&order_id=' . $order_id),
        'ratehawk_approve_refund_' . $order_id
    );

    echo '<br/><p class="form-field form-field-wide wc-customer-user">Booking Cancellations Request</p><br/><a href="' . esc_url($approve_url) . '" class="button button-primary">
            Approve & Refund Booking
          </a>';
});

// remove unwanted theme booking menu from admin wp:




add_action( 'init', function () {
    add_rewrite_endpoint( 'orders', EP_ROOT | EP_PAGES );
    add_rewrite_endpoint( 'view-order', EP_ROOT | EP_PAGES );
});