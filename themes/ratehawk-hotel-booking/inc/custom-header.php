<?php
/**
 * Custom header implementation
 *
 * @link https://codex.wordpress.org/Custom_Headers
 *
 * @package Destination Hotel Booking
 * @subpackage destination_hotel_booking
 */

function destination_hotel_booking_custom_header_setup() {
    register_default_headers( array(
        'default-image' => array(
            'url'           => get_template_directory_uri() . '/assets/images/sliderimage.png',
            'thumbnail_url' => get_template_directory_uri() . '/assets/images/sliderimage.png',
            'description'   => __( 'Default Header Image', 'destination-hotel-booking' ),
        ),
    ) );
}
add_action( 'after_setup_theme', 'destination_hotel_booking_custom_header_setup' );

/**
 * Styles the header image based on Customizer settings.
 */
function destination_hotel_booking_header_style() {
    $destination_hotel_booking_header_image = get_header_image() ? get_header_image() : get_template_directory_uri() . '/assets/images/sliderimage.png';

    $destination_hotel_booking_height     = get_theme_mod( 'destination_hotel_booking_header_image_height', 400 );
    $destination_hotel_booking_position   = get_theme_mod( 'destination_hotel_booking_header_background_position', 'center' );
    $destination_hotel_booking_attachment = get_theme_mod( 'destination_hotel_booking_header_background_attachment', 1 ) ? 'fixed' : 'scroll';

    $destination_hotel_booking_custom_css = "
        .header-img, .single-page-img, .external-div .box-image-page img, .external-div {
            background-image: url('" . esc_url( $destination_hotel_booking_header_image ) . "');
            background-size: 100% 100%;
            height: " . esc_attr( $destination_hotel_booking_height ) . "px;
            background-position: " . esc_attr( $destination_hotel_booking_position ) . ";
            background-attachment: " . esc_attr( $destination_hotel_booking_attachment ) . ";
        }

        @media (max-width: 1000px) {
            .header-img, .single-page-img, .external-div .box-image-page img,.external-div,.featured-image{
                height: 250px !important;
            }
            .box-text h2{
                font-size: 27px;
            }
        }
    ";

    wp_add_inline_style( 'destination-hotel-booking-style', $destination_hotel_booking_custom_css );
}
add_action( 'wp_enqueue_scripts', 'destination_hotel_booking_header_style' );

/**
 * Enqueue the main theme stylesheet.
 */
function destination_hotel_booking_enqueue_styles() {
    wp_enqueue_style( 'destination-hotel-booking-style', get_stylesheet_uri() );
}
add_action( 'wp_enqueue_scripts', 'destination_hotel_booking_enqueue_styles' );