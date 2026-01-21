<?php

/*
Plugin Name: Hotel Booking – Kbizsoft
Plugin URI: https://kbizsoft.com
Description: Custom hotel booking plugin for KBizSoft projects.
Version: 1.0.0
Requires at least: 5.2
Requires PHP: 7.4
Author: KBizSoft
Author URI: https://kbizsoft.com
License: GPLv2 or later
Text Domain: kbizsoft-hotel-booking
Domain Path: /languages
Update URI: false
*/

if ( ! function_exists( 'is_plugin_active' ) ) {
	require_once ABSPATH . 'wp-admin/includes/plugin.php';
}

$mphbActive = is_plugin_active( 'motopress-hotel-booking/motopress-hotel-booking.php' );

if ( $mphbActive || class_exists( 'HotelBookingPlugin' ) ) { // Second check required when activating Premium version

	add_action( 'admin_notices', 'mphb_show_multiple_instances_notice' );

} else {

	define( 'MPHB_PLUGIN_FILE', __FILE__ );
	define( 'MPHB_IS_LITE', true );

	require plugin_dir_path( __FILE__ ) . 'plugin.php';

	function mphb_plugin_action_links( $links ) {

		$links[] = '<a'
			. ' id="mphb-upgrade-plugin-link"'
			. ' href="' . esc_url( admin_url( 'admin.php?page=mphb_premium' ) ) . '"'
			. ' style="color: #008000;"'
			. '>' . __( 'Upgrade', 'motopress-hotel-booking' ) . '</a>';

		return $links;
	}

	add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'mphb_plugin_action_links' );
}

add_filter('site_transient_update_plugins', function ($value) {
    if (isset($value->response['my-plugin/my-plugin.php'])) {
        unset($value->response['my-plugin/my-plugin.php']);
    }
    return $value;
});
