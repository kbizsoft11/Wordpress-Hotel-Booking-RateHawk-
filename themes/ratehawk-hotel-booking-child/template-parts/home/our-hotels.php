<?php
/**
 * Template part for displaying the services section
 *
 * @package Destination Hotel Booking
 * @subpackage destination_hotel_booking
 */
?>
<?php if (get_theme_mod('destination_hotel_booking_cat_sec', true) != '') : ?>
    <section id="category-section" class="py-5">
      <div class="container">
        <div class="main-top-text">
          <div class="heading-expert-wrap text-center">
            <?php if ( $destination_hotel_booking_heading = get_theme_mod('destination_hotel_booking_event_text') ): ?>
              <h2><?php echo esc_html( $destination_hotel_booking_heading ); ?></h2>
            <?php endif; ?>
            <?php if ( $destination_hotel_booking_small = get_theme_mod('destination_hotel_booking_small_title') ): ?>
              <p class="post-title mb-0"><?php echo esc_html( $destination_hotel_booking_small ); ?></p>
            <?php endif; ?>
          </div>
        </div>
        <div class="house-villa-category-sec">
            <?php
            // Get selected category from Customizer
            $destination_hotel_booking_selected_cat = get_theme_mod( 'destination_hotel_booking_selected_category' );

            $destination_hotel_booking_args = array(
                'post_type'      => 'mphb_room_type',
                'posts_per_page' => 6,
            );

            if ( $destination_hotel_booking_selected_cat ) {
                $destination_hotel_booking_args['tax_query'] = array(
                    array(
                        'taxonomy' => 'mphb_room_type_category',
                        'field'    => 'term_id',
                        'terms'    => $destination_hotel_booking_selected_cat,
                    ),
                );
            }

            $destination_hotel_booking_query = new WP_Query( $destination_hotel_booking_args );

            if ( $destination_hotel_booking_query->have_posts() ) :
            while ( $destination_hotel_booking_query->have_posts() ) : $destination_hotel_booking_query->the_post();
            $destination_hotel_booking_room_id = get_the_ID();

            // Capacity (adults)
            $destination_hotel_booking_adults = get_post_meta( $destination_hotel_booking_room_id, 'mphb_adults_capacity', true );

            // Children
            $destination_hotel_booking_children = get_post_meta( $destination_hotel_booking_room_id, 'mphb_children_capacity', true );

            // Size / Area
            $destination_hotel_booking_area = get_post_meta( $destination_hotel_booking_room_id, 'mphb_size', true );

            // Location (category taxonomy)
            $destination_hotel_booking_terms = get_the_terms( $destination_hotel_booking_room_id, 'mphb_room_type_category' );
            $destination_hotel_booking_location = '';
            if ( is_array( $destination_hotel_booking_terms ) && count( $destination_hotel_booking_terms ) > 0 ) {
                $destination_hotel_booking_location = esc_html( $destination_hotel_booking_terms[0]->name );
            }
            ?>
            <div class="property-item">
                <div class="img-box">
                    <a href="<?php the_permalink(); ?>">
                        <?php 
                            if ( has_post_thumbnail() ) {
                                the_post_thumbnail( 'medium' ); 
                            } else {
                                echo '<img src="' . esc_url( get_template_directory_uri() . '/assets/images/sliderimage.png' ) . '" alt="' . esc_attr__( 'Default Image', 'destination-hotel-booking' ) . '" />';
                            }
                        ?>
                    </a>
                </div>
                <div class="post-main-detail">
                    <h3 class="property-title">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h3>
                    <?php if ( $destination_hotel_booking_location ) : ?>
                        <div class="property-location my-2">
                            <i class="fas fa-map-marker-alt"></i> <span><?php echo $destination_hotel_booking_location; ?></span>
                        </div>
                    <?php endif; ?>
                    <div class="two-col-post">
                        <div class="main-post-detail">
                            <div class="adult-children">
                                <?php// if ( $destination_hotel_booking_adults ) : ?>
                                   <!-- <div class="no-adult mb-2">
                                        <i class="far fa-user"></i> <span><?php //echo esc_html( $destination_hotel_booking_adults ); ?> <?php echo esc_html__( 'Adults', 'destination-hotel-booking' ); ?></span>
                                    </div>-->
                                <?php// endif; ?>
                                <div class="room-facility">
                                    <?php
                                    $destination_hotel_booking_facilities = get_the_terms($destination_hotel_booking_room_id, 'mphb_room_type_facility');
                                    if ($destination_hotel_booking_facilities && !is_wp_error($destination_hotel_booking_facilities)) {
                                        echo '<span class="facility-list">';
										$count = 0;
		
                                        foreach ($destination_hotel_booking_facilities as $facility) {
                                            echo '<span><i class="far fa-check-circle"></i> ' . esc_html($facility->name) . '</span>';
											 $count++;
											 if($count == 2){
												 break;
											 }
                                        }
                                        echo '</span>';
                                    }
									else{
										 echo '<span class="facility-list">';
										  echo '<span><i class="far fa-check-circle"></i> No Facilities Provided by Hotel</span>';
										  echo '<span><i class="far fa-check-circle"></i> Check hotel details</span>';
										  echo '</span>';
										 
									}
                                ?>
                                </div>
                            </div>
                           <!-- <div class="wifi-area">
                                <?php if ( $destination_hotel_booking_children ) : ?>
                                    <div class="no-children mb-2">
                                        <i class="fas fa-child"></i> <span><?php echo esc_html( $destination_hotel_booking_children ); ?> <?php echo esc_html__( 'Children', 'destination-hotel-booking' ); ?></span>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if ( $destination_hotel_booking_area ) : ?>
                                    <div class="total-area">
                                        <i class="fas fa-vector-square"></i><span><?php echo esc_html( $destination_hotel_booking_area ); ?> <?php echo esc_html__( 'm²', 'destination-hotel-booking' ); ?></span>
                                    </div>
                                <?php endif; ?>
                            </div>-->
                        </div>
                        
                    </div>
					<div class="price-meta">
                            <?php mphb_tmpl_the_room_type_default_price(); ?>
                        </div>
                    <div class="room-btn">
                        <a href="<?php echo esc_url( get_permalink() ); ?>" class="view-details-btn">
                            <?php echo esc_html__( 'View Details', 'destination-hotel-booking' ); ?>
                        </a>
                    </div>
                </div>
            </div>
            <?php
                endwhile;
                wp_reset_postdata();
            else :
                echo '<p>' . esc_html__( 'No rooms available.', 'destination-hotel-booking' ) . '</p>';
            endif;
            ?>
        </div>
      </div>
    </section>
<?php endif; ?>

