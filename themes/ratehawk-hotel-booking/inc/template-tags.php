<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Destination Hotel Booking
 * @subpackage destination_hotel_booking
 */

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function destination_hotel_booking_categorized_blog() {
	$destination_hotel_booking_category_count = get_transient( 'destination_hotel_booking_categories' );

	if ( false === $destination_hotel_booking_category_count ) {
		// Create an array of all the categories that are attached to posts.
		$destination_hotel_booking_categories = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,
			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$destination_hotel_booking_category_count = count( $destination_hotel_booking_categories );

		set_transient( 'destination_hotel_booking_categories', $destination_hotel_booking_category_count );
	}

	// Allow viewing case of 0 or 1 categories in post preview.
	if ( is_preview() ) {
		return true;
	}

	return $destination_hotel_booking_category_count > 1;
}

if ( ! function_exists( 'destination_hotel_booking_the_custom_logo' ) ) :
/**
 * Displays the optional custom logo.
 *
 * Does nothing if the custom logo is not available.
 *
 * @since Destination Hotel Booking
 */
function destination_hotel_booking_the_custom_logo() {
	if ( function_exists( 'the_custom_logo' ) ) {
		the_custom_logo();
	}
}
endif;

/**
 * Flush out the transients used in destination_hotel_booking_categorized_blog.
 */
function destination_hotel_booking_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'destination_hotel_booking_categories' );
}
add_action( 'edit_category', 'destination_hotel_booking_category_transient_flusher' );
add_action( 'save_post',     'destination_hotel_booking_category_transient_flusher' );