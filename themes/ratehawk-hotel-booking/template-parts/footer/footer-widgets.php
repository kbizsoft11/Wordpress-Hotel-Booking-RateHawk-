<?php
/**
 * Displays footer widgets if assigned
 *
 * @package Destination Hotel Booking
 * @subpackage destination_hotel_booking
 */
?>
<?php

// Determine the number of columns dynamically for the footer (you can replace this with your logic).
$destination_hotel_booking_no_of_footer_col = get_theme_mod('destination_hotel_booking_footer_columns', 4); // Change this value as needed.

// Calculate the Bootstrap class for large screens (col-lg-X) for footer.
$destination_hotel_booking_col_lg_footer_class = 'col-lg-' . (12 / $destination_hotel_booking_no_of_footer_col);

// Calculate the Bootstrap class for medium screens (col-md-X) for footer.
$destination_hotel_booking_col_md_footer_class = 'col-md-' . (12 / $destination_hotel_booking_no_of_footer_col);
?>
<div class="container">
    <aside class="widget-area row py-2 pt-3" role="complementary" aria-label="<?php esc_attr_e( 'Footer', 'destination-hotel-booking' ); ?>">
        <?php
        $destination_hotel_booking_default_widgets = array(
            1 => 'search',
            2 => 'archives',
            3 => 'meta',
            4 => 'categories'
        );

        for ($destination_hotel_booking_i = 1; $destination_hotel_booking_i <= $destination_hotel_booking_no_of_footer_col; $destination_hotel_booking_i++) :
            $destination_hotel_booking_lg_class = esc_attr($destination_hotel_booking_col_lg_footer_class);
            $destination_hotel_booking_md_class = esc_attr($destination_hotel_booking_col_md_footer_class);
            echo '<div class="col-12 ' . $destination_hotel_booking_lg_class . ' ' . $destination_hotel_booking_md_class . '">';

            if (is_active_sidebar('footer-' . $destination_hotel_booking_i)) {
                dynamic_sidebar('footer-' . $destination_hotel_booking_i);
            } else {
                // Display default widget content if not active.
                switch ($destination_hotel_booking_default_widgets[$destination_hotel_booking_i] ?? '') {
                    case 'search':
                        ?>
                        <!--<aside class="widget" role="complementary" aria-label="<?php esc_attr_e('Search', 'destination-hotel-booking'); ?>">
                            <h3 class="widget-title"><?php esc_html_e('Search', 'destination-hotel-booking'); ?></h3>
                            <?php get_search_form(); ?>
                        </aside>-->
                       <div class="kb-demo-inner">
            <span class="kb-demo-text">
                This is a demo site for preview purposes only. Purchase the plugin to use it on your own website.
            </span>

            <div class="kb-demo-actions">
                <a href="https://store.kbizsoft.com/ratehawk-api-integration-with-woocommerce.html" target="_blank" class="kb-demo-btn">
                    Buy Plugin
                </a>
                <!-- <button class="kb-demo-close" aria-label="Close demo notice">
					<svg width="14" height="14" viewBox="0 0 24 24" fill="none">
						<path d="M6 6L18 18M6 18L18 6"
							  stroke="currentColor"
							  stroke-width="2"
							  stroke-linecap="round"/>
					</svg>
				</button> -->

            </div>
        </div>
                        <?php
                        break;

                    case 'archives':
                        ?>
                        <aside class="widget" role="complementary" aria-label="<?php esc_attr_e('Archives', 'destination-hotel-booking'); ?>">
                            <h3 class="widget-title"><?php esc_html_e('Archives', 'destination-hotel-booking'); ?></h3>
                            <ul><?php wp_get_archives(['type' => 'monthly']); ?></ul>
                        </aside>
                        <?php
                        break;

                    case 'meta':
                        ?>
                        <aside class="widget" role="complementary" aria-label="<?php esc_attr_e('Meta', 'destination-hotel-booking'); ?>">
                            <h3 class="widget-title"><?php esc_html_e('Meta', 'destination-hotel-booking'); ?></h3>
                            <ul>
                                <?php wp_register(); ?>
                                <li><?php wp_loginout(); ?></li>
                                <?php wp_meta(); ?>
                            </ul>
                        </aside>
                        <?php
                        break;

                    case 'categories':
                        ?>
                        <aside class="widget" role="complementary" aria-label="<?php esc_attr_e('Categories', 'destination-hotel-booking'); ?>">
                            <h3 class="widget-title"><?php esc_html_e('Categories', 'destination-hotel-booking'); ?></h3>
                            <ul><?php wp_list_categories(['title_li' => '']); ?></ul>
                        </aside>
                        <?php
                        break;
                }
            }

            echo '</div>';
        endfor;
        ?>
    </aside>
</div>