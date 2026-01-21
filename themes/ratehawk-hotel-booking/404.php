<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package Destination Hotel Booking
 * @subpackage destination_hotel_booking
 */

get_header(); ?>

<div class="box-image-page">
  	<div class="single-page-img"></div>
  	 <div class="box-text">
    	<h2><?php esc_html_e( '404', 'destination-hotel-booking' ); ?></h2>  
    </div> 
</div>

<div class="container">
	<main id="tp_content" role="main">
		<div id="primary" class="content-area">
			<section class="error-404 not-found">
				<h1 class="page-title text-center pt-3"><?php echo esc_html(get_theme_mod('destination_hotel_booking_edit_404_title',__('Oops! That page can&rsquo;t be found.','destination-hotel-booking')));?></h1>
				<div class="page-content text-center">
					<p class="py-3"><?php echo esc_html(get_theme_mod('destination_hotel_booking_edit_404_text',__('It looks like nothing was found at this location. Maybe try a search?','destination-hotel-booking')));?></p>
					<?php get_search_form(); ?>
				</div>
			</section>
		</div>
	</main>
</div>

<?php get_footer();