<?php
/**
 * Template Name: Custom Home Page
 *
 * @package Destination Hotel Booking
 * @subpackage destination_hotel_booking
 */

get_header(); ?>

<main id="tp_content" role="main">
	<?php do_action( 'destination_hotel_booking_before_slider' ); ?>

	<?php get_template_part( 'template-parts/home/slider' ); ?>
	<?php do_action( 'destination_hotel_booking_after_slider' ); ?>

	<?php get_template_part( 'template-parts/home/our-hotels' ); ?>
	<?php do_action( 'destination_hotel_booking_after_our-hotels' ); ?>

	<?php get_template_part( 'template-parts/home/home-content' ); ?>
	<?php do_action( 'destination_hotel_booking_after_home_content' ); ?>
</main>

<?php get_footer();