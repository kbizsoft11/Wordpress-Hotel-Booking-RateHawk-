<?php
/*
* Display Logo and contact details
*/
?>
<div class="main-header">
  <?php if (get_theme_mod('destination_hotel_booking_topbar_visibility', false)) : ?>
    <div class="top-main text-center mx-auto my-0">
      <?php if (get_theme_mod('destination_hotel_booking_top_header_text')) : ?>
        <p class="top-text m-0 py-lg-3 py-2"><?php echo esc_html(get_theme_mod('destination_hotel_booking_top_header_text')); ?></p>
      <?php endif; ?>
    </div>
  <?php endif; ?>
  <div class="headerbox">
    <div class="menubox">
      <div class="container">
        <div class="row">
          <div class="col-lg-3 col-md-4 logo-col align-self-center">
            <div class="logo my-lg-2 my-3">
              <?php if( has_custom_logo() ) destination_hotel_booking_the_custom_logo(); ?>
              <?php if(get_theme_mod('destination_hotel_booking_site_title',true) == 1){ ?>
                <?php if (is_front_page() && is_home()) : ?>
                  <h1 class="text-capitalize">
                    <a href="<?php echo esc_url(home_url('/')); ?>" rel="home"><?php bloginfo('name'); ?></a>
                  </h1> 
                <?php else : ?>
                  <p class="text-capitalize site-title mb-1">
                    <a href="<?php echo esc_url(home_url('/')); ?>" rel="home"><?php bloginfo('name'); ?></a>
                  </p>
                <?php endif; ?>
              <?php }?>
              <?php $destination_hotel_booking_description = get_bloginfo( 'description', 'display' );
              if ( $destination_hotel_booking_description || is_customize_preview() ) : ?>
                <?php if(get_theme_mod('destination_hotel_booking_site_tagline',false)){ ?>
                  <p class="site-description mb-0"><?php echo esc_html($destination_hotel_booking_description); ?></p>
                <?php }?>
              <?php endif; ?>
            </div>
          </div>
          <div class="col-lg-6 col-md-4 align-self-center">
            <?php get_template_part('template-parts/navigation/site-nav'); ?>
          </div>
           <!-- Header Details Section -->
          <div class="col-lg-3 col-md-4 align-self-center mb-md-0 mb-3">
            <div class="top-right">
              <div class="header-details">
                <?php
                // Get the link from the Customizer
                $destination_hotel_booking_product_btn_link1 = get_theme_mod( 'destination_hotel_booking_product_section_btn_link1' );

                // Only show the icon if the link is not empty
                if ( ! empty( $destination_hotel_booking_product_btn_link1 ) ) : ?>
                    <a class="viewall-btn" href="<?php echo esc_url( $destination_hotel_booking_product_btn_link1 ); ?>" aria-label="<?php echo esc_attr__( 'user', 'destination-hotel-booking' ); ?>">
                        <i class="far fa-user"></i>
                    </a>
                <?php endif; ?>
              </div>
              <div class="header-button ms-5 ms-md-4">
                  <?php 
                  $destination_hotel_booking_button_link = get_theme_mod('destination_hotel_booking_header_button_link');
                  $destination_hotel_booking_button_text = get_theme_mod('destination_hotel_booking_header_button_text', __('Book A Room', 'destination-hotel-booking'));

                  if ( $destination_hotel_booking_button_link || $destination_hotel_booking_button_text ) : ?>
                      <a href="<?php echo esc_url( $destination_hotel_booking_button_link ); ?>">
                          <?php echo esc_html( $destination_hotel_booking_button_text ); ?>
                      </a>
                  <?php endif; ?>
              </div>
            </div>
          </div>
      </div>
    </div>
  </div>
</div>