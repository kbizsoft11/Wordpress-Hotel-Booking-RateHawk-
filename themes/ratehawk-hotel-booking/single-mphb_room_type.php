<?php
if ( ! session_id() ) {
    @session_start();
}

get_header(); ?>

<!-- <div class="box-image-page">
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
</div> -->

<div class="hotel-single">
    <div class="container">
        <main id="primary" class="site-main content-area">
            <?php while ( have_posts() ) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                    <header class="entry-header">
                        <h1 class="entry-title"><?php the_title(); ?></h1>
                    </header>

                    <div class="main-single-cotent">
                        <!-- LEFT:  -->
                        <div class="left-content">
                            <?php if ( has_post_thumbnail() ) : ?>
                                <span class="room-thumbnail"><?php the_post_thumbnail( 'large' ); ?></span>
                            <?php else: ?>
                                <span class="room-thumbnail">
                                    <img src="https://ratehawk.scalon.in/wp-content/themes/destination-hotel-booking/assets/images/sliderimage.png" alt="Default Image" />
                                </span>
                            <?php endif; ?>

                            <span class="room-price"><?php mphb_tmpl_the_room_type_default_price(); ?></span>
<!-- Highlights Section -->
<div class="highlights-container">
  <h2>Highlights</h2>
  <div class="highlights-list">
    <div class="highlight-item">
      <img src="https://cdn6.agoda.net/images/property/highlights/like.svg" alt="Great for activities" class="icon" />
      <p>Great for activities</p>
    </div>
    <div class="highlight-item">
      <img src="https://cdn6.agoda.net/images/property/highlights/SafetyFeatures.svg" alt="Great for activities" class="icon" />
      <p>Hygiene Plus</p>
    </div>
    <div class="highlight-item">
      <img src="https://cdn6.agoda.net/images/property/highlights/transfer.svg" alt="Great for activities" class="icon" />
      <p>Airport transfer</p>
    </div>
    <div class="highlight-item">
      <img src="https://cdn6.agoda.net/images/property/highlights/door.svg" alt="Great for activities" class="icon" />
      <p>Front desk [24-hour] </p>
    </div>
    <div class="highlight-item">
      <img src="https://cdn6.agoda.net/images/property/highlights/like.svg" alt="Great for activities" class="icon" />
      <p>Free WI-FI in rooms</p>
    </div>
  </div>
</div>

                            <div class="entry-content">
                                <?php the_content(); ?>
                            </div>
                        </div>

                        <!-- RIGHT: Booking Form -->
                        <div class="right-content">
                            <span class="room-booking-form">
                                <?php echo do_shortcode( '[mphb_availability id="' . get_the_ID() . '"]' ); ?>
                            </span>
                        </div>
                    </div>
                </article>
            <?php endwhile; ?>
        </main>
    </div>
</div>
<style>
    .icon {
  width: 28px;
  height: 28px;
  margin-bottom: 8px;
}

    .highlights-container {
  border: 1px solid #ddd;
  padding: 8px 8px;
  border-radius: 6px;
  max-width: 900px;
  font-family: Arial, sans-serif;
}

.highlights-container h3 {
  font-weight: bold;
  margin-bottom: 15px;
}

.highlights-list {
  display: flex;
  gap: 30px;
}

.highlight-item {
  display: flex;
  flex-direction: column;
  align-items: center;
  width: 140px;
  text-align: center;
  font-size: 14px;
  cursor: default;
  user-select: none;
}

.icon {
  font-size: 28px;
  margin-bottom: 8px;
}

/* Small info icon styling */
.info {
  font-size: 14px;
  color: #555;
  margin-left: 4px;
  vertical-align: middle;
  cursor: help;
}

/* Responsive */
@media (max-width: 600px) {
  .highlights-list {
    flex-direction: column;
    align-items: flex-start;
  }
  
  .highlight-item {
    width: 100%;
    flex-direction: row;
    align-items: center;
    gap: 10px;
    text-align: left;
    margin-bottom: 12px;
  }
  
  .icon {
    font-size: 22px;
    margin-bottom: 0;
  }
}

</style>
<?php get_footer(); 
