<?php 
if (isset($_GET['import-demo']) && $_GET['import-demo'] == true) {


    // Function to install and activate plugins
    function destination_hotel_booking_import_demo_content() {

         // Display the preloader only for plugin installation
        echo '<div id="plugin-loader" style="display: flex; align-items: center; justify-content: center; position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(255, 255, 255, 0.8); z-index: 9999;">
                <img src="' . esc_url(get_template_directory_uri()) . '/assets/images/loader.png" alt="Loading..." width="60" height="60" />
              </div>';

        // Define the plugins you want to install and activate
        $plugins = array(
            array(
                'slug' => 'woocommerce',
                'file' => 'woocommerce/woocommerce.php',
                'url'  => 'https://downloads.wordpress.org/plugin/woocommerce.latest-stable.zip'
            ),
            array(
                'slug' => 'motopress-hotel-booking-lite',
                'file' => 'motopress-hotel-booking-lite/motopress-hotel-booking.php',
                'url'  => 'https://downloads.wordpress.org/plugin/motopress-hotel-booking-lite.zip'
            ),
            array(
                'slug' => 'advanced-appointment-booking-scheduling',
                'file' => 'advanced-appointment-booking-scheduling/advanced-appointment-booking.php',
                'url'  => 'https://downloads.wordpress.org/plugin/advanced-appointment-booking-scheduling.zip'
            ),
        );

        // Include required files for plugin installation
        include_once(ABSPATH . 'wp-admin/includes/plugin-install.php');
        include_once(ABSPATH . 'wp-admin/includes/file.php');
        include_once(ABSPATH . 'wp-admin/includes/misc.php');
        include_once(ABSPATH . 'wp-admin/includes/class-wp-upgrader.php');

        // Loop through each plugin
        foreach ($plugins as $plugin) {
            $plugin_file = WP_PLUGIN_DIR . '/' . $plugin['file'];

            // Check if the plugin is installed
            if (!file_exists($plugin_file)) {
                // If the plugin is not installed, download and install it
                $upgrader = new Plugin_Upgrader();
                $result = $upgrader->install($plugin['url']);

                // Check for installation errors
                if (is_wp_error($result)) {
                    error_log('Plugin installation failed: ' . $plugin['slug'] . ' - ' . $result->get_error_message());
                    echo 'Error installing plugin: ' . esc_html($plugin['slug']) . ' - ' . esc_html($result->get_error_message());
                    continue;
                }
            }

            // If the plugin exists but is not active, activate it
            if (file_exists($plugin_file) && !is_plugin_active($plugin['file'])) {
                $result = activate_plugin($plugin['file']);

                // Check for activation errors
                if (is_wp_error($result)) {
                    error_log('Plugin activation failed: ' . $plugin['slug'] . ' - ' . $result->get_error_message());
                    echo 'Error activating plugin: ' . esc_html($plugin['slug']) . ' - ' . esc_html($result->get_error_message());
                }
            }
        }

        // Hide the preloader after the process is complete
        echo '<script type="text/javascript">
                document.getElementById("plugin-loader").style.display = "none";
              </script>';

        // Add filter to skip WooCommerce setup wizard after activation
        add_filter('woocommerce_prevent_automatic_wizard_redirect', '__return_true');
    }

    // Call the import function
    destination_hotel_booking_import_demo_content();

    // ------- Create Nav Menu --------
$destination_hotel_booking_menuname = 'Main Menus';
$destination_hotel_booking_bpmenulocation = 'primary-menu';
$destination_hotel_booking_menu_exists = wp_get_nav_menu_object($destination_hotel_booking_menuname);

if (!$destination_hotel_booking_menu_exists) {
    $destination_hotel_booking_menu_id = wp_create_nav_menu($destination_hotel_booking_menuname);

    // Create Home Page
    $destination_hotel_booking_home_title = 'Home';
    $destination_hotel_booking_home = array(
        'post_type' => 'page',
        'post_title' => $destination_hotel_booking_home_title,
        'post_content' => '',
        'post_status' => 'publish',
        'post_author' => 1,
        'post_slug' => 'home'
    );
    $destination_hotel_booking_home_id = wp_insert_post($destination_hotel_booking_home);

    // Assign Home Page Template
    add_post_meta($destination_hotel_booking_home_id, '_wp_page_template', 'page-template/front-page.php');

    // Update options to set Home Page as the front page
    update_option('page_on_front', $destination_hotel_booking_home_id);
    update_option('show_on_front', 'page');

    // Add Home Page to Menu
    wp_update_nav_menu_item($destination_hotel_booking_menu_id, 0, array(
        'menu-item-title' => __('Home', 'destination-hotel-booking'),
        'menu-item-classes' => 'home',
        'menu-item-url' => home_url('/'),
        'menu-item-status' => 'publish',
        'menu-item-object-id' => $destination_hotel_booking_home_id,
        'menu-item-object' => 'page',
        'menu-item-type' => 'post_type'
    ));

    // Create About Us Page with Dummy Content
    $destination_hotel_booking_about_title = 'About Us';
    $destination_hotel_booking_about_content = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam...<br>

             Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960 with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.<br> 

                There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which dont look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isnt anything embarrassing hidden in the middle of text.<br> 

                All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.';
    $destination_hotel_booking_about = array(
        'post_type' => 'page',
        'post_title' => $destination_hotel_booking_about_title,
        'post_content' => $destination_hotel_booking_about_content,
        'post_status' => 'publish',
        'post_author' => 1,
        'post_slug' => 'about-us'
    );
    $destination_hotel_booking_about_id = wp_insert_post($destination_hotel_booking_about);

    // Add About Us Page to Menu
    wp_update_nav_menu_item($destination_hotel_booking_menu_id, 0, array(
        'menu-item-title' => __('About Us', 'destination-hotel-booking'),
        'menu-item-classes' => 'about-us',
        'menu-item-url' => home_url('/about-us/'),
        'menu-item-status' => 'publish',
        'menu-item-object-id' => $destination_hotel_booking_about_id,
        'menu-item-object' => 'page',
        'menu-item-type' => 'post_type'
    ));

    // Create Services Page with Dummy Content
    $destination_hotel_booking_services_title = 'Services';
    $destination_hotel_booking_services_content = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam...<br>

             Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960 with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.<br> 

                There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which dont look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isnt anything embarrassing hidden in the middle of text.<br> 

                All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.';
    $destination_hotel_booking_services = array(
        'post_type' => 'page',
        'post_title' => $destination_hotel_booking_services_title,
        'post_content' => $destination_hotel_booking_services_content,
        'post_status' => 'publish',
        'post_author' => 1,
        'post_slug' => 'services'
    );
    $destination_hotel_booking_services_id = wp_insert_post($destination_hotel_booking_services);

    // Add Services Page to Menu
    wp_update_nav_menu_item($destination_hotel_booking_menu_id, 0, array(
        'menu-item-title' => __('Services', 'destination-hotel-booking'),
        'menu-item-classes' => 'services',
        'menu-item-url' => home_url('/services/'),
        'menu-item-status' => 'publish',
        'menu-item-object-id' => $destination_hotel_booking_services_id,
        'menu-item-object' => 'page',
        'menu-item-type' => 'post_type'
    ));

    // Create Pages Page with Dummy Content
    $destination_hotel_booking_pages_title = 'Pages';
    $destination_hotel_booking_pages_content = '<h2>Our Pages</h2>
    <p>Explore all the pages we have on our website. Find information about our services, company, and more.</p>';
    $destination_hotel_booking_pages = array(
        'post_type' => 'page',
        'post_title' => $destination_hotel_booking_pages_title,
        'post_content' => $destination_hotel_booking_pages_content,
        'post_status' => 'publish',
        'post_author' => 1,
        'post_slug' => 'pages'
    );
    $destination_hotel_booking_pages_id = wp_insert_post($destination_hotel_booking_pages);

    // Add Pages Page to Menu
    wp_update_nav_menu_item($destination_hotel_booking_menu_id, 0, array(
        'menu-item-title' => __('Pages', 'destination-hotel-booking'),
        'menu-item-classes' => 'pages',
        'menu-item-url' => home_url('/pages/'),
        'menu-item-status' => 'publish',
        'menu-item-object-id' => $destination_hotel_booking_pages_id,
        'menu-item-object' => 'page',
        'menu-item-type' => 'post_type'
    ));

    // Create Contact Page with Dummy Content
    $destination_hotel_booking_contact_title = 'Contact';
    $destination_hotel_booking_contact_content = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam...<br>

             Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960 with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.<br> 

                There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which dont look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isnt anything embarrassing hidden in the middle of text.<br> 

                All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.';
    $destination_hotel_booking_contact = array(
        'post_type' => 'page',
        'post_title' => $destination_hotel_booking_contact_title,
        'post_content' => $destination_hotel_booking_contact_content,
        'post_status' => 'publish',
        'post_author' => 1,
        'post_slug' => 'contact'
    );
    $destination_hotel_booking_contact_id = wp_insert_post($destination_hotel_booking_contact);

    // Add Contact Page to Menu
    wp_update_nav_menu_item($destination_hotel_booking_menu_id, 0, array(
        'menu-item-title' => __('Contact', 'destination-hotel-booking'),
        'menu-item-classes' => 'contact',
        'menu-item-url' => home_url('/contact/'),
        'menu-item-status' => 'publish',
        'menu-item-object-id' => $destination_hotel_booking_contact_id,
        'menu-item-object' => 'page',
        'menu-item-type' => 'post_type'
    ));

    // Set the menu location if it's not already set
    if (!has_nav_menu($destination_hotel_booking_bpmenulocation)) {
        $locations = get_theme_mod('nav_menu_locations'); // Use 'nav_menu_locations' to get locations array
        if (empty($locations)) {
            $locations = array();
        }
        $locations[$destination_hotel_booking_bpmenulocation] = $destination_hotel_booking_menu_id;
        set_theme_mod('nav_menu_locations', $locations);
    }
}

        //---Header--//
        set_theme_mod('destination_hotel_booking_product_section_btn_link1', '#');
        set_theme_mod('destination_hotel_booking_header_button_text', 'Book A Room');
        set_theme_mod('destination_hotel_booking_header_button_link', '#');
        
        // Slider Section
        set_theme_mod('destination_hotel_booking_slider_arrows', true);
        set_theme_mod('destination_hotel_booking_slider_form_hide_show', true);
        set_theme_mod('destination_hotel_booking_slider_image', get_template_directory_uri().'/assets/images/sliderimage.png');
        set_theme_mod('destination_hotel_booking_slider_text', 'OUR HOTEL');
        set_theme_mod('destination_hotel_booking_slider_heading', 'Enjoy Luxurious Kind Rooms & Services');

        /* -+-+-+-+-+-+-+-+-+--+-+-+-+-+-+-+-+-+-+- Service POST -+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-*/

        set_theme_mod('destination_hotel_booking_event_text', 'Book Your Stay & Relex');
        set_theme_mod('destination_hotel_booking_small_title', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.');

        $destination_hotel_booking_slider_title = array('Skyline Room','Premium Room','Golden Room');

foreach ($destination_hotel_booking_slider_title as $index => $room_title) {
    
    // Create a Room Type post
    $room_type_id = wp_insert_post(array(
        'post_title'   => wp_strip_all_tags($room_title),
        'post_content' => 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.',
        'post_status'  => 'publish',
        'post_type'    => 'mphb_room_type',
    ));

    if ($room_type_id) {
        // Assign Location (taxonomy)
        $location_name = '497 Evergeen Rd. Roseville';
        wp_set_object_terms($room_type_id, $location_name, 'mphb_room_type_category', true);

        // Add meta
        update_post_meta($room_type_id, 'mphb_adults_capacity', '2');
        update_post_meta($room_type_id, 'mphb_children_capacity', '1');
        update_post_meta($room_type_id, 'mphb_size', '3');

        // Upload & attach image
        $image_url = get_template_directory_uri().'/assets/images/post-img'.($index+1).'.png';
        $image_name = 'post'.($index+1).'.png';
        $upload_dir = wp_upload_dir();
        $image_data = file_get_contents($image_url);

        if ($image_data) {
            $unique_file_name = wp_unique_filename($upload_dir['path'], $image_name);
            $filename = $upload_dir['path'] . '/' . $unique_file_name;
            file_put_contents($filename, $image_data);

            $wp_filetype = wp_check_filetype($unique_file_name, null);
            $attachment = array(
                'post_mime_type' => $wp_filetype['type'],
                'post_title'     => sanitize_file_name($unique_file_name),
                'post_content'   => '',
                'post_status'    => 'inherit',
                'post_type'      => 'attachment',
            );
            $attach_id = wp_insert_attachment($attachment, $filename, $room_type_id);
            require_once(ABSPATH . 'wp-admin/includes/image.php');
            $attach_data = wp_generate_attachment_metadata($attach_id, $filename);
            wp_update_attachment_metadata($attach_id, $attach_data);
            set_post_thumbnail($room_type_id, $attach_id);
        }
    }
}


    }
?>