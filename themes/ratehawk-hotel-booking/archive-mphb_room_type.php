<?php
/**
 * Template for Hotel Room Archive (mphb_room_type)
 *
 * @package Destination Hotel Booking
 * @subpackage destination_hotel_booking
 */

get_header(); ?>

<div class="box-image-page">
    <div class="single-page-img"></div>
     <div class="box-text">
        <?php if ( have_posts() ) : ?>
            <div class="page-header">
                <?php
                    the_archive_title( '<h2 class="page-title">', '</h2>' );
                    the_archive_description( '<div class="taxonomy-description">', '</div>' );
                ?>
            </div>
        <?php endif; ?>  
    </div> 
</div>

<div class="container hotel-archive">
        <!-- Main Content -->
        <main id="primary" class="site-main content-area">
            
            <header class="page-header">
                <h1 class="page-title"><?php post_type_archive_title(); ?></h1>
            </header>

            <?php if ( have_posts() ) : ?>
                <div class="room-list">
                    <?php while ( have_posts() ) : the_post(); ?>
                        <article id="post-<?php the_ID(); ?>" <?php post_class('room-item'); ?>>

                            <!-- Thumbnail -->
                            <?php if ( has_post_thumbnail() ) : ?>
                                <div class="room-thumbnail">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail( 'medium' ); ?>
                                    </a>
                                </div>
                            <?php endif; ?>

                            <!-- Title -->
                            <h2 class="room-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h2>

                            <!-- Excerpt -->
                            <div class="room-excerpt">
                                <?php the_excerpt(); ?>
                            </div>

                            <!-- Price -->
                            <div class="room-price">
                                <?php mphb_tmpl_the_room_type_default_price(); ?>
                            </div>

                            <!-- Booking Button -->
                            <div class="room-booking">
                                <a href="<?php the_permalink(); ?>" class="btn btn-primary">
                                    <?php esc_html_e( 'View Details & Book', 'destination-hotel-booking' ); ?>
                                </a>
                            </div>
                        </article>
                    <?php endwhile; ?>
                </div>

                <?php the_posts_navigation(); ?>

            <?php else : ?>
                <p><?php esc_html_e( 'No rooms found.', 'destination-hotel-booking' ); ?></p>
            <?php endif; ?>

        </main>
</div><!-- .container -->

<?php get_footer(); ?>
