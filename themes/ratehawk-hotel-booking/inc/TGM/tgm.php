<?php

require get_template_directory() . '/inc/TGM/class-tgm-plugin-activation.php';
/**
 * Recommended plugins.
 */
function destination_hotel_booking_register_recommended_plugins() {
	$plugins = array(
		array(
			'name'             => __( 'Hotel Booking Lite', 'destination-hotel-booking' ),
			'slug'             => 'motopress-hotel-booking-lite',
			'source'           => '',
			'required'         => false,
			'force_activation' => false,
		),
		array(
            'name'             => __( 'Advanced Appointment Booking & Scheduling', 'destination-hotel-booking' ),
            'slug'             => 'advanced-appointment-booking-scheduling',
            'required'         => false,
            'force_activation' => false,
        ),
	);
	$config = array();
	tgmpa( $plugins, $config );
}
add_action( 'tgmpa_register', 'destination_hotel_booking_register_recommended_plugins' );
