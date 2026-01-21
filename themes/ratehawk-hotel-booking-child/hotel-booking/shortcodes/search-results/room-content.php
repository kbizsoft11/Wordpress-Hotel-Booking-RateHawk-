<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( post_password_required() ) {
    $isShowGallery = $isShowImage = $isShowDetails = $isShowPrice = $isShowViewButton = $isShowBookButton = false;
}

do_action( 'mphb_sc_search_results_before_room' );

$wrapperClass = apply_filters( 'mphb_sc_search_results_room_type_class', join( ' ', mphb_tmpl_get_filtered_post_class( 'mphb-room-type' ) ) );
?>
<div class="<?php echo esc_attr( $wrapperClass ); ?> room-layout-mmt">

    <?php do_action( 'mphb_sc_search_results_room_top' ); ?>

    <div class="room-container">

        <div class="room-card-slider">
            <div class="room-slider-wrapper">
                <?php
                // Gallery images
                if ( $isShowGallery && mphb_tmpl_has_room_type_gallery() ) {
                    $gallery_images = mphb_tmpl_get_room_type_gallery_ids();
                    if ( ! empty( $gallery_images ) ) {
                        foreach ( $gallery_images as $image_id ) {
                            $image_url = wp_get_attachment_image_url( $image_id, 'large' );
                            if ( $image_url ) {
                                echo '<div class="room-slide-img"><img src="' . esc_url( $image_url ) . '" alt="Room image"></div>';
                            }
                        }
                    }
                }
                // Fallback: featured image
                elseif ( $isShowImage && has_post_thumbnail() ) {
                    $thumb_url = get_the_post_thumbnail_url( get_the_ID(), 'large' );
                    echo '<div class="room-slide-img"><img src="' . esc_url( $thumb_url ) . '" alt="Room image"></div>';
                }
                ?>
            </div>

            <!-- Arrows -->
            <button class="prev-slide" aria-label="Previous image">‹</button>
            <button class="next-slide" aria-label="Next image">›</button>
        </div>

        <!-- RIGHT: Room Content -->
        <div class="room-content">

            <!-- Title & Excerpt -->
            <?php if ( $isShowTitle ) : ?>
                <?php do_action( 'mphb_sc_search_results_render_title' ); ?>
            <?php endif; ?>
            <?php if ( $isShowExcerpt ) : ?>
                <?php do_action( 'mphb_sc_search_results_render_excerpt' ); ?>
            <?php endif; ?>

            <!-- Price & Dynamic Book Button -->
            <?php
            if ( $isShowPrice ) {
                /**
                 * @hooked \MPHB\Views\LoopRoomTypeView::renderPriceForDates - 10
                 */
                do_action( 'mphb_sc_search_results_render_price', $checkInDate, $checkOutDate );
            }

            if ( $isShowViewButton ) {
                /**
                 * @hooked \MPHB\Views\LoopRoomTypeView::renderViewDetailsButton - 10
                 */
                do_action( 'mphb_sc_search_results_render_view_button' );
            }

            if ( $isShowBookButton ) {
                /**
                 * @hooked \MPHB\Views\LoopRoomTypeView::renderBookButton - 10
                 * Outputs the dynamic Book Now button with correct room URL & dates
                 */
                do_action( 'mphb_sc_search_results_render_book_button' );
            }

            do_action( 'mphb_sc_search_results_after_info' );
            ?>

        </div>

    </div>

    <?php do_action( 'mphb_sc_search_results_room_bottom' ); ?>

</div>

<?php do_action( 'mphb_sc_search_results_after_room' ); ?>
