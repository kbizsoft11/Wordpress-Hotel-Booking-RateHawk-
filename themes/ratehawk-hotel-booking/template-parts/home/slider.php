<?php
/**
 * Template part for displaying slider section
 *
 * @package Destination Hotel Booking
 * @subpackage destination_hotel_booking
 */

// Show slider only if 'destination_hotel_booking_slider_arrows' is enabled
if ( get_theme_mod('destination_hotel_booking_slider_arrows', true) ) : ?>
  <div id="slider" class="mb-md-0 mb-3">
    <div class="main-sliders">
      <?php
        $destination_hotel_booking_slider_image   = get_theme_mod( 'destination_hotel_booking_slider_image' );
        $destination_hotel_booking_slider_heading = get_theme_mod( 'destination_hotel_booking_slider_heading' );
        $destination_hotel_booking_slider_text    = get_theme_mod( 'destination_hotel_booking_slider_text' );

        if ( $destination_hotel_booking_slider_image ) : ?>
            <div class="main-slider-inner-box">
                <img src="<?php echo esc_url( $destination_hotel_booking_slider_image ); ?>"
                     alt="__( 'Slider Image', 'destination-hotel-booking' ) ); ?>">
                <div class="main-slider-content-box">
                    <div class="main-inner-text" >
                        <?php if ( $destination_hotel_booking_slider_text ) : ?>
                            <p class="slider-content" style="color:#ffffff;"><?php echo esc_html( $destination_hotel_booking_slider_text ); ?></p>
                        <?php endif; ?>
                        <?php if ( $destination_hotel_booking_slider_heading ) : ?>
                            <h1 style="color:#ffffff;"><?php echo esc_html( $destination_hotel_booking_slider_heading ); ?></h1>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
      <?php if ( get_theme_mod( 'destination_hotel_booking_slider_form_hide_show', true ) != '' ) { ?>
        <div class="main-form-div">
          <div class="form-sec-slider">
            <?php echo do_shortcode('[mphb_availability_search]'); ?>
          </div>
        </div>
      <?php } ?>
    </div>
  </div>
<?php endif; ?>
