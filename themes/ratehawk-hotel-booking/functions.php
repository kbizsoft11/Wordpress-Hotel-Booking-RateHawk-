<?php
/**
 * Destination Hotel Booking functions and definitions
 *
 * @package Destination Hotel Booking
 * @subpackage destination_hotel_booking
 */

function destination_hotel_booking_setup() {

	load_theme_textdomain( 'destination-hotel-booking', get_template_directory() . '/languages' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'woocommerce' );
	add_theme_support( 'title-tag' );
	add_theme_support( "responsive-embeds" );
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'post-thumbnails' );
	add_image_size( 'destination-hotel-booking-featured-image', 2000, 1200, true );
	add_image_size( 'destination-hotel-booking-thumbnail-avatar', 100, 100, true );

	// Set the default content width.
	$GLOBALS['content_width'] = 525;

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'primary-menu'    => __( 'Primary Menu', 'destination-hotel-booking' ),
	) );

	// Add theme support for Custom Logo.
	add_theme_support( 'custom-logo', array(
		'width'       => 250,
		'height'      => 250,
		'flex-width'  => true,
    	'flex-height' => true,
	) );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	add_theme_support( 'custom-background', array(
		'default-color' => 'ffffff'
	) );

	/*
	 * Enable support for Post Formats.
	 *
	 * See: https://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array('image','video','gallery','audio',) );

	add_theme_support( 'html5', array('comment-form','comment-list','gallery','caption',) );

	/*
	 * This theme styles the visual editor to resemble the theme style,
	 * specifically font, colors, and column width.
 	 */
	add_editor_style( array( 'assets/css/editor-style.css', destination_hotel_booking_fonts_url() ) );

	add_theme_support( 'custom-header', apply_filters( 'destination_hotel_booking_custom_header_args', array(
        'default-text-color' => 'fff',
        'header-text'        => false,
        'width'              => 1600,
        'height'             => 400,
        'flex-width'         => true,
        'flex-height'        => true,
        'wp-head-callback'   => 'destination_hotel_booking_header_style',
        'default-image'      => get_template_directory_uri() . '/assets/images/sliderimage.png',
    ) ) );

	/**
	 * Implement the Custom Header feature.
	 */
	require get_parent_theme_file_path( '/inc/custom-header.php' );

}
add_action( 'after_setup_theme', 'destination_hotel_booking_setup' );

add_filter( 'site_transient_update_themes', function( $value ) {
    unset( $value->response['destination-hotel-booking'] );
    return $value;
});
/**
 * Register custom fonts.
 */
function destination_hotel_booking_fonts_url(){
	$destination_hotel_booking_font_url = '';
	$destination_hotel_booking_font_family = array();
	$destination_hotel_booking_font_family[] = 'Satisfy';
	$destination_hotel_booking_font_family[] = 'Instrument+Sans:ital,wght@0,400..700;1,400..700';
	$destination_hotel_booking_font_family[] = 'Barlow:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900';
	$destination_hotel_booking_font_family[] = 'Cormorant:ital,wght@0,300..700;1,300..700';
	$destination_hotel_booking_font_family[] = 'Plus Jakarta Sans:wght@0,200..800;1,200..800';
	$destination_hotel_booking_font_family[] = 'Outfit:wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,90';
	$destination_hotel_booking_font_family[] = 'Manrope:wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900';
	$destination_hotel_booking_font_family[] = 'Oxanium:wght@200;300;400;500;600;700;800';
	$destination_hotel_booking_font_family[] = 'Oswald:200,300,400,500,600,700';
	$destination_hotel_booking_font_family[] = 'Roboto Serif:wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900';
	$destination_hotel_booking_font_family[] = 'Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900';
	$destination_hotel_booking_font_family[] = 'Bad Script';
	$destination_hotel_booking_font_family[] = 'Bebas Neue';
	$destination_hotel_booking_font_family[] = 'Fjalla One';
	$destination_hotel_booking_font_family[] = 'PT Sans:ital,wght@0,400;0,700;1,400;1,700';
	$destination_hotel_booking_font_family[] = 'PT Serif:ital,wght@0,400;0,700;1,400;1,700';
	$destination_hotel_booking_font_family[] = 'Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900';
	$destination_hotel_booking_font_family[] = 'Roboto Condensed:ital,wght@0,300;0,400;0,700;1,300;1,400;1,700';
	$destination_hotel_booking_font_family[] = 'Roboto+Flex:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900';
	$destination_hotel_booking_font_family[] = 'Alex Brush';
	$destination_hotel_booking_font_family[] = 'Overpass:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900';
	$destination_hotel_booking_font_family[] = 'Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900';
	$destination_hotel_booking_font_family[] = 'Playball';
	$destination_hotel_booking_font_family[] = 'Alegreya:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,500;1,600;1,700;1,800;1,900';
	$destination_hotel_booking_font_family[] = 'Julius Sans One';
	$destination_hotel_booking_font_family[] = 'Arsenal:ital,wght@0,400;0,700;1,400;1,700';
	$destination_hotel_booking_font_family[] = 'Slabo 13px';
	$destination_hotel_booking_font_family[] = 'Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900';
	$destination_hotel_booking_font_family[] = 'Overpass Mono:wght@300;400;500;600;700';
	$destination_hotel_booking_font_family[] = 'Source Sans Pro:ital,wght@0,200;0,300;0,400;0,600;0,700;0,900;1,200;1,300;1,400;1,600;1,700;1,900';
	$destination_hotel_booking_font_family[] = 'Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900';
	$destination_hotel_booking_font_family[] = 'Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900';
	$destination_hotel_booking_font_family[] = 'Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900';
	$destination_hotel_booking_font_family[] = 'Lora:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700';
	$destination_hotel_booking_font_family[] = 'Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700';
	$destination_hotel_booking_font_family[] = 'Cabin:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700';
	$destination_hotel_booking_font_family[] = 'Arimo:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700';
	$destination_hotel_booking_font_family[] = 'Playfair Display:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,500;1,600;1,700;1,800;1,900';
	$destination_hotel_booking_font_family[] = 'Quicksand:wght@300;400;500;600;700';
	$destination_hotel_booking_font_family[] = 'Padauk:wght@400;700';
	$destination_hotel_booking_font_family[] = 'Mulish:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;0,1000;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900;1,1000';
	$destination_hotel_booking_font_family[] = 'Inconsolata:wght@200;300;400;500;600;700;800;900&family=Mulish:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;0,1000;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900;1,1000';
	$destination_hotel_booking_font_family[] = 'Bitter:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Mulish:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;0,1000;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900;1,1000';
	$destination_hotel_booking_font_family[] = 'Pacifico';
	$destination_hotel_booking_font_family[] = 'Indie Flower';
	$destination_hotel_booking_font_family[] = 'VT323';
	$destination_hotel_booking_font_family[] = 'Dosis:wght@200;300;400;500;600;700;800';
	$destination_hotel_booking_font_family[] = 'Frank Ruhl Libre:wght@300;400;500;700;900';
	$destination_hotel_booking_font_family[] = 'Fjalla One';
	$destination_hotel_booking_font_family[] = 'Figtree:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900';
	$destination_hotel_booking_font_family[] = 'Oxygen:wght@300;400;700';
	$destination_hotel_booking_font_family[] = 'Arvo:ital,wght@0,400;0,700;1,400;1,700';
	$destination_hotel_booking_font_family[] = 'Noto Serif:ital,wght@0,400;0,700;1,400;1,700';
	$destination_hotel_booking_font_family[] = 'Lobster';
	$destination_hotel_booking_font_family[] = 'Crimson Text:ital,wght@0,400;0,600;0,700;1,400;1,600;1,700';
	$destination_hotel_booking_font_family[] = 'Yanone Kaffeesatz:wght@200;300;400;500;600;700';
	$destination_hotel_booking_font_family[] = 'Anton';
	$destination_hotel_booking_font_family[] = 'Libre Baskerville:ital,wght@0,400;0,700;1,400';
	$destination_hotel_booking_font_family[] = 'Bree Serif';
	$destination_hotel_booking_font_family[] = 'Gloria Hallelujah';
	$destination_hotel_booking_font_family[] = 'Abril Fatface';
	$destination_hotel_booking_font_family[] = 'Varela Round';
	$destination_hotel_booking_font_family[] = 'Vampiro One';
	$destination_hotel_booking_font_family[] = 'Shadows Into Light';
	$destination_hotel_booking_font_family[] = 'Cuprum:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700';
	$destination_hotel_booking_font_family[] = 'Rokkitt:wght@100;200;300;400;500;600;700;800;900';
	$destination_hotel_booking_font_family[] = 'Vollkorn:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,500;1,600;1,700;1,800;1,900';
	$destination_hotel_booking_font_family[] = 'Francois One';
	$destination_hotel_booking_font_family[] = 'Orbitron:wght@400;500;600;700;800;900';
	$destination_hotel_booking_font_family[] = 'Patua One';
	$destination_hotel_booking_font_family[] = 'Acme';
	$destination_hotel_booking_font_family[] = 'Satisfy';
	$destination_hotel_booking_font_family[] = 'Josefin Slab:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,100;1,200;1,300;1,400;1,500;1,600;1,700';
	$destination_hotel_booking_font_family[] = 'Quattrocento Sans:ital,wght@0,400;0,700;1,400;1,700';
	$destination_hotel_booking_font_family[] = 'Architects Daughter';
	$destination_hotel_booking_font_family[] = 'Russo One';
	$destination_hotel_booking_font_family[] = 'Monda:wght@400;700';
	$destination_hotel_booking_font_family[] = 'Righteous';
	$destination_hotel_booking_font_family[] = 'Lobster Two:ital,wght@0,400;0,700;1,400;1,700';
	$destination_hotel_booking_font_family[] = 'Hammersmith One';
	$destination_hotel_booking_font_family[] = 'Courgette';
	$destination_hotel_booking_font_family[] = 'Permanent Marke';
	$destination_hotel_booking_font_family[] = 'Cherry Swash:wght@400;700';
	$destination_hotel_booking_font_family[] = 'Cormorant Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700';
	$destination_hotel_booking_font_family[] = 'Poiret One';
	$destination_hotel_booking_font_family[] = 'BenchNine:wght@300;400;700';
	$destination_hotel_booking_font_family[] = 'Economica:ital,wght@0,400;0,700;1,400;1,700';
	$destination_hotel_booking_font_family[] = 'Handlee';
	$destination_hotel_booking_font_family[] = 'Cardo:ital,wght@0,400;0,700;1,400';
	$destination_hotel_booking_font_family[] = 'Alfa Slab One';
	$destination_hotel_booking_font_family[] = 'Averia Serif Libre:ital,wght@0,300;0,400;0,700;1,300;1,400;1,700';
	$destination_hotel_booking_font_family[] = 'Cookie';
	$destination_hotel_booking_font_family[] = 'Chewy';
	$destination_hotel_booking_font_family[] = 'Great Vibes';
	$destination_hotel_booking_font_family[] = 'Coming Soon';
	$destination_hotel_booking_font_family[] = 'Philosopher:ital,wght@0,400;0,700;1,400;1,700';
	$destination_hotel_booking_font_family[] = 'Days One';
	$destination_hotel_booking_font_family[] = 'Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900';
	$destination_hotel_booking_font_family[] = 'Shrikhand';
	$destination_hotel_booking_font_family[] = 'Tangerine:wght@400;700';
	$destination_hotel_booking_font_family[] = 'IM Fell English SC';
	$destination_hotel_booking_font_family[] = 'Boogaloo';
	$destination_hotel_booking_font_family[] = 'Bangers';
	$destination_hotel_booking_font_family[] = 'Fredoka One';
	$destination_hotel_booking_font_family[] = 'Volkhov:ital,wght@0,400;0,700;1,400;1,700';
	$destination_hotel_booking_font_family[] = 'Shadows Into Light Two';
	$destination_hotel_booking_font_family[] = 'Marck Script';
	$destination_hotel_booking_font_family[] = 'Sacramento';
	$destination_hotel_booking_font_family[] = 'Unica One';
	$destination_hotel_booking_font_family[] = 'Dancing Script:wght@400;500;600;700';
	$destination_hotel_booking_font_family[] = 'Exo 2:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900';
	$destination_hotel_booking_font_family[] = 'Archivo:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900';
	$destination_hotel_booking_font_family[] = 'Jost:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900';
	$destination_hotel_booking_font_family[] = 'DM Serif Display:ital@0;1';
	$destination_hotel_booking_font_family[] = 'Open Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800';
	$destination_hotel_booking_font_family[] = 'Karla:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,200;1,300;1,400;1,500;1,600;1,700;1,800';

	$destination_hotel_booking_query_args = array(
		'family'	=> rawurlencode(implode('|',$destination_hotel_booking_font_family)),
	);
	$destination_hotel_booking_font_url = add_query_arg($destination_hotel_booking_query_args,'//fonts.googleapis.com/css');
	return $destination_hotel_booking_font_url;
	$contents = wptt_get_webfont_url( esc_url_raw( $destination_hotel_booking_font_url ) );
}

/**
 * Register widget area.
 */
function destination_hotel_booking_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Blog Sidebar', 'destination-hotel-booking' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Add widgets here to appear in your sidebar on blog posts and archive pages.', 'destination-hotel-booking' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Page Sidebar', 'destination-hotel-booking' ),
		'id'            => 'sidebar-2',
		'description'   => __( 'Add widgets here to appear in your sidebar on pages.', 'destination-hotel-booking' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Sidebar 3', 'destination-hotel-booking' ),
		'id'            => 'sidebar-3',
		'description'   => __( 'Add widgets here to appear in your sidebar on blog posts and archive pages.', 'destination-hotel-booking' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer 1', 'destination-hotel-booking' ),
		'id'            => 'footer-1',
		'description'   => __( 'Add widgets here to appear in your footer.', 'destination-hotel-booking' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer 2', 'destination-hotel-booking' ),
		'id'            => 'footer-2',
		'description'   => __( 'Add widgets here to appear in your footer.', 'destination-hotel-booking' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer 3', 'destination-hotel-booking' ),
		'id'            => 'footer-3',
		'description'   => __( 'Add widgets here to appear in your footer.', 'destination-hotel-booking' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer 4', 'destination-hotel-booking' ),
		'id'            => 'footer-4',
		'description'   => __( 'Add widgets here to appear in your footer.', 'destination-hotel-booking' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'destination_hotel_booking_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function destination_hotel_booking_scripts() {
	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style( 'destination-hotel-booking-fonts', destination_hotel_booking_fonts_url(), array(), null );

	// Bootstrap
	wp_enqueue_style( 'bootstrap-css', get_theme_file_uri( '/assets/css/bootstrap.css' ) );

	// Theme stylesheet.
	wp_enqueue_style( 'destination-hotel-booking-style', get_stylesheet_uri() );
	require get_parent_theme_file_path( '/tp-theme-color.php' );
	wp_add_inline_style( 'destination-hotel-booking-style',$destination_hotel_booking_tp_theme_css );
	wp_style_add_data('destination-hotel-booking-style', 'rtl', 'replace');
	require get_parent_theme_file_path( '/tp-body-width-layout.php' );
	wp_add_inline_style( 'destination-hotel-booking-style',$destination_hotel_booking_tp_theme_css );
	wp_style_add_data('destination-hotel-booking-style', 'rtl', 'replace');

	// Theme block stylesheet.
	wp_enqueue_style( 'destination-hotel-booking-block-style', get_theme_file_uri( '/assets/css/blocks.css' ), array( 'destination-hotel-booking-style' ), '1.0' );

	// Fontawesome
	wp_enqueue_style( 'fontawesome-css', get_theme_file_uri( '/assets/css/fontawesome-all.css' ) );
	

	wp_enqueue_script( 'destination-hotel-booking-custom-scripts', get_template_directory_uri() . '/assets/js/destination-hotel-booking-custom.js', array('jquery'), true );


	wp_enqueue_script( 'bootstrap-js', get_theme_file_uri( '/assets/js/bootstrap.js' ), array( 'jquery' ), true );

	wp_enqueue_script( 'destination-hotel-booking-focus-nav', get_template_directory_uri() . '/assets/js/focus-nav.js', array('jquery'), true);

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	$destination_hotel_booking_body_font_family = get_theme_mod('destination_hotel_booking_body_font_family', '');

	$destination_hotel_booking_heading_font_family = get_theme_mod('destination_hotel_booking_heading_font_family', '');

	$destination_hotel_booking_menu_font_family = get_theme_mod('destination_hotel_booking_menu_font_family', '');

	$destination_hotel_booking_tp_theme_css = '
		body, p.simplep, .more-btn a{
		    font-family: '.esc_html($destination_hotel_booking_body_font_family).';
		}
		h1,h2, h3, h4, h5, h6, .menubar,.logo h1, .logo p.site-title, p.simplep a, #main-slider p.slidertop-title, .more-btn a,.wc-block-checkout__actions_row .wc-block-components-checkout-place-order-button,.wc-block-cart__submit-container a,.woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button,.woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt, #theme-sidebar button[type="submit"],
#footer button[type="submit"]{
		    font-family: '.esc_html($destination_hotel_booking_heading_font_family).';
		}
	';
	wp_add_inline_style('destination-hotel-booking-style', $destination_hotel_booking_tp_theme_css);
}
add_action( 'wp_enqueue_scripts', 'destination_hotel_booking_scripts' );

/*radio button sanitization*/
function destination_hotel_booking_sanitize_choices( $input, $setting ) {
    global $wp_customize;
    $control = $wp_customize->get_control( $setting->id );
    if ( array_key_exists( $input, $control->choices ) ) {
        return $input;
    } else {
        return $setting->default;
    }
}

// Sanitize Sortable control.
function destination_hotel_booking_sanitize_sortable( $val, $setting ) {
	if ( is_string( $val ) || is_numeric( $val ) ) {
		return array(
			esc_attr( $val ),
		);
	}
	$sanitized_value = array();
	foreach ( $val as $item ) {
		if ( isset( $setting->manager->get_control( $setting->id )->choices[ $item ] ) ) {
			$sanitized_value[] = esc_attr( $item );
		}
	}
	return $sanitized_value;
}
/* Excerpt Limit Begin */
function destination_hotel_booking_excerpt_function($excerpt_count = 35) {
    $destination_hotel_booking_excerpt = get_the_excerpt();

    $DESTINATION_HOTEL_BOOKING_TEXT_excerpt = wp_strip_all_tags($destination_hotel_booking_excerpt);

    $destination_hotel_booking_excerpt_limit = esc_attr(get_theme_mod('destination_hotel_booking_excerpt_count', $excerpt_count));

    $destination_hotel_booking_theme_excerpt = implode(' ', array_slice(explode(' ', $DESTINATION_HOTEL_BOOKING_TEXT_excerpt), 0, $destination_hotel_booking_excerpt_limit));

    return $destination_hotel_booking_theme_excerpt;
}

// Change number or products per row to 3
add_filter('loop_shop_columns', 'destination_hotel_booking_loop_columns');
if (!function_exists('destination_hotel_booking_loop_columns')) {
	function destination_hotel_booking_loop_columns() {
		$columns = get_theme_mod( 'destination_hotel_booking_per_columns', 3 );
		return $columns;
	}
}

// Category count 
function destination_hotel_booking_display_post_category_count() {
    $destination_hotel_booking_category = get_the_category();
    $destination_hotel_booking_category_count = ($destination_hotel_booking_category) ? count($destination_hotel_booking_category) : 0;
    $destination_hotel_booking_category_text = ($destination_hotel_booking_category_count === 1) ? 'category' : 'categories'; // Check for pluralization
    echo $destination_hotel_booking_category_count . ' ' . $destination_hotel_booking_category_text;
}

// === Custom Control for taxonomy dropdown ===
if ( class_exists( 'WP_Customize_Control' ) ) {
    class Destination_Hotel_Booking_WP_Customize_Taxonomy_Control extends WP_Customize_Control {
        public $type = 'dropdown-taxonomies';
        public $taxonomy = 'category';

        public function render_content() {
            $terms = get_terms( array(
                'taxonomy'   => $this->taxonomy,
                'hide_empty' => false,
            ) );

            if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
                echo '<label class="customize-control-select">';
                if ( ! empty( $this->label ) ) {
                    echo '<span class="customize-control-title">' . esc_html( $this->label ) . '</span>';
                }

                echo '<select ' . $this->get_link() . '>';
                echo '<option value="0">' . __( '&mdash; Select &mdash;', 'destination-hotel-booking' ) . '</option>';
                foreach ( $terms as $term ) {
                    printf(
                        '<option value="%s" %s>%s</option>',
                        esc_attr( $term->term_id ),
                        selected( $this->value(), $term->term_id, false ),
                        esc_html( $term->name )
                    );
                }
                echo '</select>';

                if ( ! empty( $this->description ) ) {
                    echo '<p class="description">' . esc_html( $this->description ) . '</p>';
                }

                echo '</label>';
            }
        }
    }
}

//post tag
function destination_hotel_booking_custom_tags_filter($destination_hotel_booking_tag_list) {
    // Replace the comma (,) with an empty string
    $destination_hotel_booking_tag_list = str_replace(', ', '', $destination_hotel_booking_tag_list);

    return $destination_hotel_booking_tag_list;
}
add_filter('the_tags', 'destination_hotel_booking_custom_tags_filter');

function destination_hotel_booking_custom_output_tags() {
    $destination_hotel_booking_tags = get_the_tags();

    if ($destination_hotel_booking_tags) {
        $destination_hotel_booking_tags_output = '<div class="post_tag">Tags: ';

        $destination_hotel_booking_first_tag = reset($destination_hotel_booking_tags);

        foreach ($destination_hotel_booking_tags as $tag) {
            $destination_hotel_booking_tags_output .= '<a href="' . esc_url(get_tag_link($tag)) . '" rel="tag" class="me-2">' . esc_html($tag->name) . '</a>';
            if ($tag !== $destination_hotel_booking_first_tag) {
                $destination_hotel_booking_tags_output .= ' ';
            }
        }

        $destination_hotel_booking_tags_output .= '</div>';

        echo $destination_hotel_booking_tags_output;
    }
}
//Change number of products that are displayed per page (shop page)
add_filter( 'loop_shop_per_page', 'destination_hotel_booking_per_page', 20 );
function destination_hotel_booking_per_page( $destination_hotel_booking_cols ) {
  	$destination_hotel_booking_cols = get_theme_mod( 'destination_hotel_booking_product_per_page', 9 );
	return $destination_hotel_booking_cols;
}

function destination_hotel_booking_sanitize_number_range( $number, $setting ) {

	// Ensure input is an absolute integer.
	$number = absint( $number );

	// Get the input attributes associated with the setting.
	$atts = $setting->manager->get_control( $setting->id )->input_attrs;

	// Get minimum number in the range.
	$min = ( isset( $atts['min'] ) ? $atts['min'] : $number );

	// Get maximum number in the range.
	$max = ( isset( $atts['max'] ) ? $atts['max'] : $number );

	// Get step.
	$step = ( isset( $atts['step'] ) ? $atts['step'] : 1 );

	// If the number is within the valid range, return it; otherwise, return the default
	return ( $min <= $number && $number <= $max && is_int( $number / $step ) ? $number : $setting->default );
}

function destination_hotel_booking_sanitize_checkbox( $input ) {
	// Boolean check
	return ( ( isset( $input ) && true == $input ) ? true : false );
}

function destination_hotel_booking_sanitize_number_absint( $number, $setting ) {
	// Ensure $number is an absolute integer (whole number, zero or greater).
	$number = absint( $number );

	// If the input is an absolute integer, return it; otherwise, return the default
	return ( $number ? $number : $setting->default );
}

/**
 * Use front-page.php when Front page displays is set to a static page.
 */
function destination_hotel_booking_front_page_template( $template ) {
	return is_home() ? '' : $template;
}
add_filter( 'frontpage_template','destination_hotel_booking_front_page_template' );

// logo
function destination_hotel_booking_logo_width(){

	$destination_hotel_booking_logo_width   = get_theme_mod( 'destination_hotel_booking_logo_width', 80 );

	echo "<style type='text/css' media='all'>"; ?>
		img.custom-logo{
		    width: <?php echo absint( $destination_hotel_booking_logo_width ); ?>px;
		    max-width: 100%;
		}
	<?php echo "</style>";
}

add_action( 'wp_head', 'destination_hotel_booking_logo_width' );

function destination_hotel_booking_theme_setup() {
	
	define('DESTINATION_HOTEL_BOOKING_CREDIT',__('https://www.themespride.com/products/destination-hotel-booking','destination-hotel-booking') );
	if ( ! function_exists( 'destination_hotel_booking_credit' ) ) {
		function destination_hotel_booking_credit(){
			//echo "<a href=".esc_url(DESTINATION_HOTEL_BOOKING_CREDIT)." target='_blank'>".esc_html__(get_theme_mod('destination_hotel_booking_footer_text',__('Destination Hotel Booking WordPress Theme','destination-hotel-booking')))."</a>";
		}
	}

	/**
	 * Custom template tags for this theme.
	 */
	require get_parent_theme_file_path( '/inc/template-tags.php' );

	/**
	 * Additional features to allow styling of the templates.
	 */
	require get_parent_theme_file_path( '/inc/template-functions.php' );

	/**
	 * Customizer additions.
	 */
	require get_parent_theme_file_path( '/inc/customizer.php' );

	/**
	 * Load Theme Web File
	 */
	require get_parent_theme_file_path('/inc/wptt-webfont-loader.php' );
	/**
	 * Load Theme Web File
	 */
	require get_parent_theme_file_path( '/inc/controls/customize-control-toggle.php' );
	/**
	 * load sortable file
	 */
	require get_parent_theme_file_path( '/inc/controls/sortable-control.php' );

	/**
	 * TGM Recommendation
	 */
	require get_parent_theme_file_path( '/inc/TGM/tgm.php' );

	/**
	 * About Theme Page
	 */
	require get_parent_theme_file_path( '/inc/about-theme.php' );


}
add_action( 'after_setup_theme', 'destination_hotel_booking_theme_setup' );


//Admin Enqueue for Admin
function destination_hotel_booking_admin_enqueue_scripts(){
	wp_enqueue_style('destination-hotel-booking-admin-style', get_template_directory_uri() . '/assets/css/admin.css');
	wp_register_script( 'destination-hotel-booking-admin-script', get_template_directory_uri() . '/assets/js/destination-hotel-booking-admin.js', array( 'jquery' ), '', true );

	wp_localize_script(
		'destination-hotel-booking-admin-script',
		'destination_hotel_booking',
		array(
			'admin_ajax'	=>	admin_url('admin-ajax.php'),
			'wpnonce'			=>	wp_create_nonce('destination_hotel_booking_dismissed_notice_nonce')
		)
	);
	wp_enqueue_script('destination-hotel-booking-admin-script');

    wp_localize_script( 'destination-hotel-booking-admin-script', 'destination_hotel_booking_ajax_object',
        array( 'ajax_url' => admin_url( 'admin-ajax.php' ) )
    );
}
add_action( 'admin_enqueue_scripts', 'destination_hotel_booking_admin_enqueue_scripts' );


// get started
add_action( 'wp_ajax_destination_hotel_booking_dismissed_notice_handler', 'destination_hotel_booking_ajax_notice_handler' );

function destination_hotel_booking_ajax_notice_handler() {
	if (!wp_verify_nonce($_POST['wpnonce'], 'destination_hotel_booking_dismissed_notice_nonce')) {
		exit;
	}
    if ( isset( $_POST['type'] ) ) {
        $type = sanitize_text_field( wp_unslash( $_POST['type'] ) );
        update_option( 'dismissed-' . $type, TRUE );
    }
}

add_action('after_switch_theme', 'destination_hotel_booking_setup_options');
function destination_hotel_booking_setup_options () {
    update_option('dismissed-get_started', FALSE );
}
function theme_mphb_assets() {
    wp_enqueue_style(
        'mphb-account',
        get_stylesheet_directory_uri() . '/assets/css/mphb-account.css',
        array(),
        '1.0'
    );

    wp_enqueue_script(
        'mphb-account-js',
        get_stylesheet_directory_uri() . '/assets/js/mphb-account.js',
        array( 'jquery' ),
        '1.0',
        true
    );
}
add_action( 'wp_enqueue_scripts', 'theme_mphb_assets' );



/* ----------------------------
 * Create one MPHB room from a WorldOTA room_group
 * - Creates post of type 'mphb_room'
 * - Links to parent accommodation using 'mphb_room_type_id' meta key
 * - Uses price data from search/hp endpoint if available
 * ---------------------------- */
 /*
if ( ! function_exists( 'ota_create_room_from_group' ) ) {
    function ota_create_room_from_group( $hotel_post_id, $hotel_title, $hotel_terms = array(), $room_group = array(), $parent_hotel_data = array(), $parent_price_data = null ) { // Added parent_price_data parameter
        if ( empty( $room_group ) || ! is_array( $room_group ) ) {
            return new WP_Error( 'invalid_room_group', 'Invalid room group data' );
        }

        $room_name = isset( $room_group['name'] ) ? sanitize_text_field( $room_group['name'] ) : ( $hotel_title . ' Room ' . (int) ( $room_group['room_group_id'] ?? time() ) );
        $post_type = 'mphb_room'; // Explicitly set to mphb_room

        // Build content
        $content = '';
        if ( ! empty( $room_group['name_struct']['main_name'] ) ) {
            $content .= wp_kses_post( $room_group['name_struct']['main_name'] ) . "\n\n";
        }
        if ( ! empty( $room_group['room_amenities'] ) && is_array( $room_group['room_amenities'] ) ) {
            $content .= "Amenities: " . implode( ', ', $room_group['room_amenities'] ) . "\n\n";
        }
        $content .= "Imported from WorldOTA (room_group_id: " . intval( $room_group['room_group_id'] ?? 0 ) . ")\n";
        $content .= "Part of Hotel: " . esc_html( $hotel_title ) . " (ID: " . esc_html( get_post_field( 'post_name', $hotel_post_id ) /* Uses slug *//* ) . ")\n";

      /*  // Determine capacity/size/price
        $rg_ext = $room_group['rg_ext'] ?? array();
        $adults = ( ! empty( $rg_ext['capacity'] ) && intval($rg_ext['capacity']) > 0 ) ? intval( $rg_ext['capacity'] ) : 2;
        $children = 0;
        $size = ( isset( $room_group['size'] ) && is_numeric( $room_group['size'] ) && $room_group['size'] > 0 ) ? floatval( $room_group['size'] ) : 35.0;

        // Determine base price
        // 1. Try to find a matching rate in the parent_price_data (from search/hp)
        $base_price = 0.0;
        $matching_rate_data = null;
        if ( $parent_price_data && ! empty( $parent_price_data['rates'] ) && is_array( $parent_price_data['rates'] ) ) {
            foreach ( $parent_price_data['rates'] as $rate ) {
                // Match based on room name or rg_ext details if possible
                // A simple match could be based on the room name from info matching the room_name from search/hp
                if ( isset( $rate['room_name'] ) && isset( $room_group['name'] ) && 
                     strpos( $rate['room_name'], $room_group['name'] ) !== false ) { // Basic name matching
                    if ( ! empty( $rate['payment_options']['payment_types'][0]['show_amount'] ) ) {
                         $base_price = floatval( $rate['payment_options']['payment_types'][0]['show_amount'] );
                         $matching_rate_data = $rate; // Store the matching rate data
                         break;
                    }
                }
            }
        }

        // 2. If no match found in search/hp data, fall back to info endpoint heuristic
        if ( $base_price <= 0.0 && ! empty( $room_group['price']['amount'] ) ) {
            $base_price = floatval( $room_group['price']['amount'] );
        }
        if ( $base_price <= 0.0 && ! empty( $parent_hotel_data['metapolicy_struct']['meal'][0]['price'] ) ) {
            $base_price = floatval( $parent_hotel_data['metapolicy_struct']['meal'][0]['price'] );
        }


        // Avoid duplicate room_group import
        if ( ! empty( $room_group['room_group_id'] ) ) {
            $existing = get_posts( array(
                'post_type' => $post_type, // 'mphb_room'
                'meta_query' => array( // Use meta_query for more robust searching
                    array(
                        'key' => '_imported_from_worldota_roomgroup',
                        'value' => intval( $room_group['room_group_id'] ),
                        'compare' => '='
                    )
                ),
                'fields'    => 'ids',
                'posts_per_page' => 1,
            ) );
            if ( ! empty( $existing ) ) {
                return (int) $existing[0]; // Return existing ID if found
            }
        }

        // Insert room post
        $new_room_id = wp_insert_post( array(
            'post_title'   => $room_name,
            'post_content' => $content,
            'post_type'    => $post_type, // 'mphb_room'
            'post_status'  => 'publish',
        ), true );

        if ( is_wp_error( $new_room_id ) ) return $new_room_id;

     
        update_post_meta( $new_room_id, 'mphb_room_type_id', strval( $hotel_post_id ) ); 

        // These capacity/size meta keys might be more relevant for 'mphb_room_type' than 'mphb_room'.
        // Check MPHB documentation for 'mphb_room' specific meta if needed.
        // For now, adding them as they might be used for override or specific room details.
        update_post_meta( $new_room_id, 'mphb_adults_capacity', strval( max(1, (int)$adults ) ) );
        update_post_meta( $new_room_id, 'mphb_children_capacity', strval( max(0, (int)$children ) ) );
        update_post_meta( $new_room_id, 'mphb_total_capacity', strval( (int)$adults + (int)$children ) );
        update_post_meta( $new_room_id, 'mphb_size', strval( $size ) );
        update_post_meta( $new_room_id, '_mphb_base_price', number_format( (float)$base_price, 2, '.', '' ) ); // Store the determined price

        // Copy categories & facilities from parent (if provided)
        if ( ! empty( $hotel_terms['categories'] ) ) {
            wp_set_object_terms( $new_room_id, $hotel_terms['categories'], 'mphb_room_type_category', false );
        }
        if ( ! empty( $hotel_terms['facilities'] ) ) {
            wp_set_object_terms( $new_room_id, $hotel_terms['facilities'], 'mphb_room_type_facility', false );
        }

        // Attach room-group images (if available in the room_group)
        $room_images = array();
        if ( ! empty( $room_group['images'] ) && is_array( $room_group['images'] ) ) {
            $room_images = $room_group['images'];
        } elseif ( ! empty( $room_group['images_ext'] ) && is_array( $room_group['images_ext'] ) ) {
            foreach ( $room_group['images_ext'] as $ie ) {
                if ( ! empty( $ie['url'] ) ) $room_images[] = $ie['url'];
            }
        }

        $gallery_ids = array();
        $creds = worldota_get_creds(); // Get image prefix for sideloading
        $image_prefix = $creds['image_prefix'] ?? '';
        foreach ( $room_images as $idx => $template ) {
            $url = str_replace( '{size}', '1024x768', $template );
            $content_pos = strpos( $url, 'content/' );
            if ( $content_pos !== false && ! empty( $image_prefix ) ) {
                $content_path = substr( $url, $content_pos );
                $url = rtrim( $image_prefix, '/' ) . '/' . ltrim( $content_path, '/' );
            }
            $attach = ota_sideload_image( $url, $new_room_id, "Room group image for {$room_name}" );
            if ( is_wp_error( $attach ) ) {
                error_log("OTA Sideloading Error for room {$room_name} image {$url}: " . $attach->get_error_message());
                continue;
            }

            if ( $idx === 0 ) set_post_thumbnail( $new_room_id, $attach );
            else $gallery_ids[] = $attach;
        }
        if ( ! empty( $gallery_ids ) ) {
            update_post_meta( $new_room_id, '_mphb_gallery_items', $gallery_ids );
            $gallery_ids_string = implode( ',', $gallery_ids );
            update_post_meta( $new_room_id, 'mphb_gallery', $gallery_ids_string );
        }

        // Mark imported room group and store related data
        if ( ! empty( $room_group['room_group_id'] ) ) {
            update_post_meta( $new_room_id, '_imported_from_worldota_roomgroup', intval( $room_group['room_group_id'] ) );
            update_post_meta( $new_room_id, '_imported_from_worldota_parent_hotel_id', strval( get_post_field( 'post_name', $hotel_post_id ) /* Use slug */ /*) );*/
    /*        update_post_meta( $new_room_id, '_imported_from_worldota_parent_post_id', $hotel_post_id ); // Store the actual post ID
        }

        // Store the raw room_group data from info endpoint
        update_post_meta( $new_room_id, '_worldota_room_group_data_info', $room_group );

        // Store the matching rate data from search/hp endpoint (if found)
        if ( $matching_rate_data ) {
            update_post_meta( $new_room_id, '_worldota_room_rate_data_search', $matching_rate_data );
        }

        // Store the price source info
        update_post_meta( $new_room_id, '_worldota_room_price_source', $matching_rate_data ? 'search_hp' : 'info_endpoint_fallback' );
        update_post_meta( $new_room_id, '_worldota_room_price_fallback_amount', number_format( (float) ( ( ! empty( $room_group['price']['amount'] ) ? floatval( $room_group['price']['amount'] ) : 0.0 ) ?: ( ! empty( $parent_hotel_data['metapolicy_struct']['meal'][0]['price'] ) ? floatval( $parent_hotel_data['metapolicy_struct']['meal'][0]['price'] ) : 0.0 ) ), 2, '.', '' ) );

        return (int) $new_room_id;
    }
}


/**
 * WorldOTA → MPHB import helpers
 * - ota_sideload_image()
 * - ota_create_room_from_group()
 * - ota_import_hotel_by_id() - Updated to call search/hp endpoint
 * - template_redirect handler to trigger import via URL
 *
 * Paste into your theme's functions.php or a small plugin.
 */

/* ----------------------------
 * Robust sideload helper
 * ---------------------------- */
/*if ( ! function_exists( 'ota_sideload_image' ) ) {
    function ota_sideload_image( $file_url, $post_id = 0, $desc = '' ) {
        if ( empty( $file_url ) ) {
            return new WP_Error( 'no_url', 'No image URL provided' );
        }
        if ( ! function_exists( 'media_handle_sideload' ) ) {
            require_once ABSPATH . 'wp-admin/includes/file.php';
            require_once ABSPATH . 'wp-admin/includes/media.php';
            require_once ABSPATH . 'wp-admin/includes/image.php';
        }
        // Download remote file to temp
        $tmp = download_url( $file_url );
        if ( is_wp_error( $tmp ) ) {
            return new WP_Error( 'download_failed', 'download_url failed: ' . $tmp->get_error_message() );
        }
        // Prepare file array
        $file_array = array();
        $file_array['name']     = basename( parse_url( $file_url, PHP_URL_PATH ) );
        $file_array['tmp_name'] = $tmp;
        // Sideload
        $attach_id = media_handle_sideload( $file_array, $post_id, $desc );
        // Ensure cleanup
        @unlink( $tmp );
        if ( is_wp_error( $attach_id ) ) {
            return $attach_id;
        }
        // Generate/update attachment metadata (thumbnails, etc.)
        $file = get_attached_file( $attach_id );
        if ( file_exists( $file ) ) {
            $meta = wp_generate_attachment_metadata( $attach_id, $file );
            wp_update_attachment_metadata( $attach_id, $meta );
        }
        return $attach_id;
    }
}

/* ----------------------------
 * Helper function to fetch prices using search/hp
 * ---------------------------- */
/*if ( ! function_exists( 'ota_fetch_hotel_prices' ) ) {
    function ota_fetch_hotel_prices( $hotel_id, $checkin = '', $checkout = '', $adults = 2, $children = 0, $lang = 'en', $currency = 'USD' ) {
        if ( empty( $hotel_id ) ) {
            return new WP_Error( 'missing_id', 'Missing hotel ID' );
        }

        $creds = worldota_get_creds();
        $key_id = $creds['key_id'] ?? '';
        $key    = $creds['key'] ?? '';
        $endpoint_base = rtrim( $creds['api_url'] ?? '' );
        $endpoint = $endpoint_base . '/api/b2b/v3/search/hp/';
        $image_prefix = $creds['image_prefix'] ?? '';

        if ( empty( $key_id ) || empty( $key ) ) {
            return new WP_Error( 'missing_creds', 'Missing WorldOTA credentials' );
        }

        // Default to tomorrow if no dates provided
        if ( empty( $checkin ) ) {
            $checkin = date('Y-m-d', strtotime('+1 day'));
        }
        if ( empty( $checkout ) ) {
            $checkout = date('Y-m-d', strtotime($checkin . ' +1 day'));
        }

        // Prepare guests array
        $guests = array(
            array(
                'adults' => max(1, intval($adults)),
                'children' => array_fill(max(0, intval($children)),0, 0) // Assuming age 0 for simplicity
            )
        );

        // Prepare payload for search/hp
        $search_payload = array(
            'id' => $hotel_id,
            'checkin' => $checkin,
            'checkout' => $checkout,
            'language' => $lang,
            'currency' => $currency,
            'residency' => 'us', 
            'guests' => $guests,
        );

        $payload = wp_json_encode( $search_payload );

        // Make the API call
        $resp = wp_remote_post( $endpoint, array(
            'headers' => array(
                'Authorization' => 'Basic ' . base64_encode( $key_id . ':' . $key ),
                'Accept'        => 'application/json',
                'Content-Type'  => 'application/json; charset=utf-8',
            ),
            'body' => $payload,
            'timeout' => 15, // Slightly higher timeout for search
        ) );

        if ( is_wp_error( $resp ) ) {
            return $resp;
        }

        $code = wp_remote_retrieve_response_code( $resp );
        $body = wp_remote_retrieve_body( $resp );

        if ( $code !== 200 ) {
            return new WP_Error( 'api_error_search', 'Search API returned HTTP ' . $code . ' - ' . wp_trim_words( $body, 30 ) );
        }

        $api_data = json_decode( $body, true );
        if ( json_last_error() !== JSON_ERROR_NONE ) {
            return new WP_Error( 'json_error_search', json_last_error_msg() );
        }

        if ( empty( $api_data['data'] ) || empty( $api_data['data']['hotels'] ) ) {
            return new WP_Error( 'no_prices_data', 'Search API returned no price data for hotel: ' . $hotel_id );
        }

        $hotel_data = null;
        foreach ( $api_data['data']['hotels'] as $hotel ) {
            if ( $hotel['id'] === $hotel_id ) {
                $hotel_data = $hotel;
                break;
            }
        }

        if ( ! $hotel_data ) {
            return new WP_Error( 'hotel_not_found_in_search', 'Hotel ID ' . $hotel_id . ' not found in search results.' );
        }

        return $hotel_data; // Returns the hotel data block from search/hp containing rates
    }
}

/* ----------------------------
 * Main import function: ota_import_hotel_by_id
 * - Fetches hotel info via /hotel/info/
 * - Fetches prices via /search/hp/ for default dates
 * - Creates parent accommodation post,
 * - Assigns taxonomies,
 * - Sideloads images,
 * - Creates helper season and mphb_rate with actual prices from search/hp,
 * - Stores raw search/hp response for future reference
 * ---------------------------- */
/*if ( ! function_exists( 'ota_import_hotel_by_id' ) ) {
    function ota_import_hotel_by_id( $hotel_id , $check_in , $check_out,$adults,$children , $lang = 'en', $currency = 'USD') { // Added currency parameter
        if ( empty( $hotel_id ) ) {
            return new WP_Error( 'missing_id', 'Missing hotel ID' );
        }

        $creds = worldota_get_creds();
        $key_id = $creds['key_id'] ?? '';
        $key    = $creds['key'] ?? '';
        $endpoint_base = rtrim( $creds['api_url'] ?? '' );
        $endpoint_info = $endpoint_base . '/api/b2b/v3/hotel/info/';
        $image_prefix = $creds['image_prefix'] ?? '';

        if ( empty( $key_id ) || empty( $key ) ) {
            return new WP_Error( 'missing_creds', 'Missing WorldOTA credentials' );
        }

        // 1. Fetch hotel info
        $payload_info = wp_json_encode( array( 'id' => $hotel_id, 'language' => $lang ) );
        $resp_info = wp_remote_post( $endpoint_info, array(
            'headers' => array(
                'Authorization' => 'Basic ' . base64_encode( $key_id . ':' . $key ),
                'Accept'        => 'application/json',
                'Content-Type'  => 'application/json; charset=utf-8',
            ),
            'body' => $payload_info,
            'timeout' => 30,
        ) );

        if ( is_wp_error( $resp_info ) ) return $resp_info;
        $code_info = wp_remote_retrieve_response_code( $resp_info );
        $body_info = wp_remote_retrieve_body( $resp_info );
        if ( $code_info !== 200 ) return new WP_Error( 'api_error_info', 'Info API returned HTTP ' . $code_info . ' - ' . wp_trim_words( $body_info, 30 ) );

        $api_data_info = json_decode( $body_info, true );
        if ( json_last_error() !== JSON_ERROR_NONE ) return new WP_Error( 'json_error_info', json_last_error_msg() );
        if ( empty( $api_data_info['data'] ) ) return new WP_Error( 'no_data_info', 'Info API returned no data' );

        $hotel = $api_data_info['data'];

        // 2. Fetch prices using search/hp (for default dates)
        $price_data = ota_fetch_hotel_prices( $hotel_id, $check_in, $check_out, 1, 0, $lang, $currency ); 
        if ( is_wp_error( $price_data ) ) {
            // Log the error but continue with basic info import
            error_log('OTA Price Fetch Error for hotel ' . $hotel_id . ': ' . $price_data->get_error_message());
            $price_data = null; // Set to null if fetch fails
        }

        // Title & content (from info endpoint)
        $title = isset( $hotel['name'] ) ? sanitize_text_field( $hotel['name'] ) : 'Imported Accommodation ' . time();
        $content = '';
        if ( ! empty( $hotel['description_struct'] ) && is_array( $hotel['description_struct'] ) ) {
            foreach ( $hotel['description_struct'] as $blk ) {
                if ( ! empty( $blk['paragraphs'][0] ) ) {
                    $content = wp_kses_post( $blk['paragraphs'][0] );
                    break;
                }
            }
        }
        if ( empty( $content ) && ! empty( $hotel['description'] ) ) {
            $content = wp_kses_post( $hotel['description'] );
        }
        $content .= "\n\nImported from WorldOTA (id: " . esc_html( $hotel_id ) . ")";

        // capacities / size / base price heuristics (from info endpoint)
		$adults = 1;
		$children = 0;
        $size = 35;
        $base_price_from_info = 0.00; // Store base price from info endpoint

        if ( ! empty( $hotel['room_groups'] ) && is_array( $hotel['room_groups'] ) ) {
            foreach ( $hotel['room_groups'] as $rg ) {
                $rg_ext = $rg['rg_ext'] ?? array();
                if ( ! empty( $rg_ext['capacity'] ) && intval($rg_ext['capacity']) > 0 ) {
                    $adults = intval( $rg_ext['capacity'] );
                }
                if ( isset( $rg['size'] ) && is_numeric( $rg['size'] ) && $rg['size'] > 0 ) {
                    $size = floatval( $rg['size'] );
                }
                if ( ! empty( $rg['price']['amount'] ) ) {
                    $base_price_from_info = floatval( $rg['price']['amount'] ); // Store this value
                }
                if ( $adults || $size || $base_price_from_info ) break;
            }
        }

        if ( (float)$base_price_from_info <= 0 && ! empty( $hotel['metapolicy_struct']['meal'] ) && is_array( $hotel['metapolicy_struct']['meal'] ) ) {
            $first_meal = reset( $hotel['metapolicy_struct']['meal'] );
            if ( isset( $first_meal['price'] ) && is_numeric( $first_meal['price'] ) ) {
                $base_price_from_info = floatval( $first_meal['price'] ); // Store this value
            }
        }
        $total_capacity = max( 1, $adults + $children );

        // Duplicate check: if hotel already imported, return existing post ID
        $existing = get_posts( array(
            'post_type' => defined('MPHB_ROOM_POST_TYPE') ? MPHB_ROOM_POST_TYPE : 'mphb_room_type',
            'meta_key'  => '_imported_from_worldota_id',
            'meta_value'=> sanitize_text_field( $hotel_id ),
            'fields'    => 'ids',
            'posts_per_page' => 1,
        ) );
        if ( ! empty( $existing ) ) {
            $post_id = (int) $existing[0];
        } else {
            // Insert parent accommodation
            $post_type = defined('MPHB_ROOM_POST_TYPE') ? MPHB_ROOM_POST_TYPE : 'mphb_room_type';
            $post_status = 'publish';
            $post_id = wp_insert_post( array(
                'post_title'   => $title,
                'post_content' => $content,
                'post_type'    => $post_type,
                'post_status'  => $post_status,
            ), true );

            if ( is_wp_error( $post_id ) ) return $post_id;
        }

        // Determine base price for MPHB meta
        // Prefer price from search/hp if available and valid, otherwise fall back to info endpoint heuristic
        $effective_base_price = $base_price_from_info; // Start with info endpoint value
        if ( $price_data && ! empty( $price_data['rates'] ) && is_array( $price_data['rates'] ) ) {
            $first_rate = reset( $price_data['rates'] );
            if ( ! empty( $first_rate['payment_options']['payment_types'][0]['show_amount'] ) ) {
                $effective_base_price = floatval( $first_rate['payment_options']['payment_types'][0]['show_amount'] );
            }
        }

        // MPHB meta (using effective price)
        update_post_meta( $post_id, 'mphb_adults_capacity', strval( $adults ) );
        update_post_meta( $post_id, 'mphb_children_capacity', strval( $children ) );
        update_post_meta( $post_id, 'mphb_total_capacity', strval( $total_capacity ) );
        update_post_meta( $post_id, 'mphb_size', strval( $size ) );
        update_post_meta( $post_id, '_mphb_base_price', number_format( (float)$effective_base_price, 2, '.', '' ) ); // Use effective price

        // Store raw data responses
        update_post_meta( $post_id, '_worldota_full_response', $hotel );
        update_post_meta( $post_id, '_imported_from_worldota_id', sanitize_text_field( $hotel_id ) );
        // Store the price data fetched from search/hp
        if ( $price_data ) {
            update_post_meta( $post_id, '_worldota_price_response', $price_data );
        }
        // Store the original base price from info endpoint for reference
        update_post_meta( $post_id, '_worldota_info_base_price', number_format( (float)$base_price_from_info, 2, '.', '' ) );

        // Amenities -> mphb_room_type_facility (from info endpoint)
      /*  $amenities = array();
        if ( ! empty( $hotel['amenity_groups'] ) && is_array( $hotel['amenity_groups'] ) ) {
            foreach ( $hotel['amenity_groups'] as $grp ) {
                if ( ! empty( $grp['amenities'] ) && is_array( $grp['amenities'] ) ) {
                    foreach ( $grp['amenities'] as $a ) {
                        if ( is_string($a) && trim($a) !== '' ) $amenities[] = trim( $a );
                        elseif ( is_array($a) && ! empty($a['name']) ) $amenities[] = trim( $a['name'] );
                    }
                }
            }
        }
        if ( ! empty( $amenities ) ) {
            $amenities = array_values( array_unique( $amenities ) );
            foreach ( $amenities as $term_name ) {
                if ( term_exists( $term_name, 'mphb_room_type_facility' ) === 0 ) {
                    wp_insert_term( $term_name, 'mphb_room_type_facility' );
                }
            }
            wp_set_object_terms( $post_id, $amenities, 'mphb_room_type_facility', false );
        }*/
		
	/*		$amenities_by_group = array(); // New variable to store grouped amenities
$amenities = array(); 

if ( ! empty( $hotel['amenity_groups'] ) && is_array( $hotel['amenity_groups'] ) ) {
    foreach ( $hotel['amenity_groups'] as $grp ) {
        $group_name = $grp['group_name'];
        $amenities_by_group[$group_name] = array(); 
        
        if ( ! empty( $grp['amenities'] ) && is_array( $grp['amenities'] ) ) {
            foreach ( $grp['amenities'] as $a ) {
                if ( is_string($a) && trim($a) !== '' ) {
                    $amenity = trim( $a );
                    $amenities[] = $amenity; 
                    $amenities_by_group[$group_name][] = $amenity; 
                }
                elseif ( is_array($a) && ! empty($a['name']) ) {
                    $amenity = trim( $a['name'] );
                    $amenities[] = $amenity; 
                    $amenities_by_group[$group_name][] = $amenity; 
                }
            }
        }
    }
}


if ( ! empty( $amenities ) ) {
    $amenities = array_values( array_unique( $amenities ) );
    foreach ( $amenities as $term_name ) {
        if ( term_exists( $term_name, 'mphb_room_type_facility' ) === 0 ) {
            wp_insert_term( $term_name, 'mphb_room_type_facility' );
        }
    }
    wp_set_object_terms( $post_id, $amenities, 'mphb_room_type_facility', false );
}


update_post_meta( $post_id, '_amenities_by_group', $amenities_by_group );
			
			
			
			
        // Categories -> mphb_room_type_category (from info endpoint)
        $cat_terms = array();
        if ( ! empty( $hotel['kind'] ) ) $cat_terms[] = $hotel['kind'];
        if ( empty( $cat_terms ) && ! empty( $hotel['room_groups'] ) ) {
            foreach ( $hotel['room_groups'] as $rg ) {
                if ( ! empty( $rg['name_struct']['main_name'] ) ) $cat_terms[] = $rg['name_struct']['main_name'];
            }
        }
        $cat_terms = array_values( array_unique( array_filter( array_map('trim', $cat_terms) ) ) );
        if ( ! empty( $cat_terms ) ) {
            foreach ( $cat_terms as $term_name ) {
                if ( term_exists( $term_name, 'mphb_room_type_category' ) === 0 ) {
                    wp_insert_term( $term_name, 'mphb_room_type_category' );
                }
            }
            wp_set_object_terms( $post_id, $cat_terms, 'mphb_room_type_category', false );
        }

        // Images: sideload (from info endpoint)
        if ( function_exists( 'ota_sideload_image' ) ) {
            $images = array();
            if ( ! empty( $hotel['images'] ) && is_array( $hotel['images'] ) ) {
                $images = $hotel['images'];
            } elseif ( ! empty( $hotel['images_ext'] ) && is_array( $hotel['images_ext'] ) ) {
                foreach ( $hotel['images_ext'] as $ie ) {
                    if ( ! empty( $ie['url'] ) ) $images[] = $ie['url'];
                }
            }

            $gallery_ids = array();
            foreach ( $images as $i => $img_template ) {
                $working = str_replace( '{size}', '1024x768', $img_template );
                $content_pos = strpos( $working, 'content/' );
                if ( $content_pos !== false && ! empty( $image_prefix ) ) {
                    $content_path = substr( $working, $content_pos );
                    $working = rtrim( $image_prefix, '/' ) . '/' . ltrim( $content_path, '/' );
                }

                $attach = ota_sideload_image( $working, $post_id, "WorldOTA image #{$i} for {$title}" );
                if ( is_wp_error( $attach ) ) continue;

                if ( $i === 0 ) set_post_thumbnail( $post_id, $attach );
                else $gallery_ids[] = $attach;
            }

            if ( ! empty( $gallery_ids ) ) {
                update_post_meta( $post_id, '_mphb_gallery_items', $gallery_ids );
                $gallery_ids_string = implode( ',', $gallery_ids );
                update_post_meta( $post_id, 'mphb_gallery', $gallery_ids_string );
            }
        }

        // ----------------------
        // Create or reuse a Season (mphb_season)
        // ----------------------
        $season_id = 0;
        $existing_seasons = get_posts( array(
            'post_type'      => 'mphb_season',
            'posts_per_page' => 1,
            'fields'         => 'ids',
        ) );

        if ( ! empty( $existing_seasons ) ) {
            $season_id = (int) $existing_seasons[0];
        } else {
            $today = date('Y-m-d');
            $far   = date('Y-m-d', strtotime('+5 years'));

            $season_post = wp_insert_post( array(
                'post_title'   => 'WorldOTA default season (edit dates in admin)',
                'post_type'    => 'mphb_season',
                'post_status'  => 'publish',
                'post_content' => 'Automatically created helper season for WorldOTA imported rates.',
            ), true );

            if ( ! is_wp_error( $season_post ) ) {
                $season_id = (int) $season_post;

                // These meta keys match your example and typical MPHB naming
                update_post_meta( $season_id, 'mphb_start_date', $today );
                update_post_meta( $season_id, 'mphb_end_date', $far );
                update_post_meta( $season_id, 'mphb_repeat_period', 'year' );
            }
        }

        // ----------------------
        // Create helper mphb_rate (visible in admin) and populate mphb_season_prices
        // Use price data from search/hp if available, otherwise fall back to info endpoint heuristic
        // ----------------------
        $rate_title = 'WorldOTA rate for: ' . $title;
        $rate_post = wp_insert_post( array(
            'post_title'   => $rate_title,
            'post_type'    => 'mphb_rate',
            'post_status'  => 'publish',
            'post_content' => 'Imported helper rate from WorldOTA. Rates based on search/hp endpoint data (if available).',
        ), true );

        if ( ! is_wp_error( $rate_post ) ) {
            $rate_id = (int) $rate_post;

            // Link rate -> room using the MPHB expected meta key
            update_post_meta( $rate_id, 'mphb_room_type_id', $post_id );

            // Store raw metapolicy from info endpoint for reference
            if ( ! empty( $hotel['metapolicy_struct'] ) ) {
                update_post_meta( $rate_id, '_worldota_rate_metapolicy_info', $hotel['metapolicy_struct'] );
            }

            // Store raw price data from search/hp endpoint for reference
            if ( $price_data ) {
                update_post_meta( $rate_id, '_worldota_rate_price_data_search', $price_data );
            }

            // Link to helper season id
            if ( $season_id ) {
                update_post_meta( $rate_id, '_worldota_rate_season_id', $season_id );
            }

            // Build mphb_season_prices value (array)
            // Use the effective price determined earlier (from search/hp or info)
            $season_prices_entry = array(
                'season' => (string) $season_id,
                'price'  => array(
                    'periods'            => array( 0 => 1 ), // Default period
                    'prices'             => array( 0 => (float) number_format( (float)$effective_base_price, 2, '.', '' ) ), // Use effective price
                    'base_adults'        => (int) $adults,
                    'base_children'      => (int) $children,
                    'extra_adult_prices' => array( 0 => '' ),
                    'extra_child_prices' => array( 0 => '' ),
                    'enable_variations'  => false,
                    'variations'         => array()
                )
            );

            // mphb_season_prices expects an array of these entries
            $mphb_season_prices = array();
            $mphb_season_prices[] = $season_prices_entry;

            // Save mphb_season_prices meta
            update_post_meta( $rate_id, 'mphb_season_prices', $mphb_season_prices );

            // Store the effective base price used for this rate
            update_post_meta( $rate_id, '_worldota_rate_base_price_effective', number_format( (float)$effective_base_price, 2, '.', '' ) );
            update_post_meta( $rate_id, '_worldota_rate_base_price_info', number_format( (float)$base_price_from_info, 2, '.', '' ) ); // Store info price too

            // Optional helper summary meta (from info endpoint)
            $extra_summary = array();
            if ( ! empty( $hotel['metapolicy_struct']['extra_bed'] ) ) $extra_summary['extra_bed'] = $hotel['metapolicy_struct']['extra_bed'];
            if ( ! empty( $hotel['metapolicy_struct']['children'] ) )  $extra_summary['children']  = $hotel['metapolicy_struct']['children'];
            if ( ! empty( $hotel['metapolicy_struct']['cot'] ) )       $extra_summary['cot']       = $hotel['metapolicy_struct']['cot'];

            if ( ! empty( $extra_summary ) ) update_post_meta( $rate_id, '_worldota_rate_extras_info', $extra_summary );
        }
		$hotel_terms = array(
            'categories' => $cat_terms ?? array(), // Categories from info endpoint
            'facilities' => $amenities ?? array(), // Facilities from info endpoint
        );

        if ( ! empty( $hotel['room_groups'] ) && is_array( $hotel['room_groups'] ) ) {
            foreach ( $hotel['room_groups'] as $rg ) {
                // Skip duplicate room groups based on room_group_id
                if ( ! empty( $rg['room_group_id'] ) ) {
                    $existing_rg = get_posts( array(
                        'post_type' => $post_type, 
                        'meta_query' => array( 
                            array(
                                'key' => '_imported_from_worldota_roomgroup',
                                'value' => intval($rg['room_group_id']),
                                'compare' => '='
                            )
                        ),
                        'fields' => 'ids',
                        'posts_per_page' => 1,
                    ) );
                    if ( ! empty( $existing_rg ) ) {
                        continue; // Skip if already imported
                    }
                }

                // Call the corrected function to create the room
                ota_create_room_from_group( $post_id, $title, $hotel_terms, $rg, $hotel, $price_data ); // Pass the price_data fetched from search/hp
            }
        }

        return (int) $post_id;
    }
}

/* ----------------------------
 * Public template_redirect handler to trigger import via URL
 * Example URL:
 *   /?ota_import=1&hotel_id=test_hotel_do_not_book&lang=en&currency=EUR&ota_import_nonce=<nonce>
 * Use wp_create_nonce('ota_import_action') when building the link.
 * ---------------------------- */
/*add_action( 'template_redirect', function() {
    if ( empty( $_GET['ota_import'] ) ) return;
    $hotel_id = isset( $_GET['hotel_id'] ) ? sanitize_text_field( wp_unslash( $_GET['hotel_id'] ) ) : '';
    $lang = isset( $_GET['lang'] ) ? sanitize_text_field( wp_unslash( $_GET['lang'] ) ) : 'en';
	$checkin = isset( $_GET['checkin'] ) ? sanitize_text_field( wp_unslash( $_GET['checkin'] ) ) : '';
	$checkout = isset( $_GET['checkout'] ) ? sanitize_text_field( wp_unslash( $_GET['checkout'] ) ) : '';
	$adults = isset( $_GET['adults'] ) ? sanitize_text_field( wp_unslash( $_GET['adults'] ) ) : '';
	$children = isset( $_GET['children'] ) ? sanitize_text_field( wp_unslash( $_GET['children'] ) ) : '';
    $currency = isset( $_GET['currency'] ) ? sanitize_text_field( wp_unslash( $_GET['currency'] ) ) : 'USD'; // Get currency from URL
    $nonce = isset( $_GET['ota_import_nonce'] ) ? sanitize_text_field( wp_unslash( $_GET['ota_import_nonce'] ) ) : '';

    // Optional but recommended: verify nonce.
    if ( ! wp_verify_nonce( $nonce, 'ota_import_action' ) ) {
        $redirect = add_query_arg( array( 'hotel_id' => $hotel_id, 'checkin' => $checkin, 'checkout' => $checkout , 'lang' => $lang, 'currency' => $currency, 'import_error' => 'invalid_nonce' ), home_url('/hotel-detail/') );
        wp_safe_redirect( $redirect );
        exit;
    }
    if ( empty( $hotel_id ) ) {
        wp_safe_redirect( home_url() );
        exit;
    }

    @set_time_limit(120);

    // If already imported, redirect to existing
    $existing = get_posts( array(
        'post_type' => defined('MPHB_ROOM_POST_TYPE') ? MPHB_ROOM_POST_TYPE : 'mphb_room_type',
        'meta_key' => '_imported_from_worldota_id',
        'meta_value' => sanitize_text_field( $hotel_id ),
        'fields' => 'ids',
        'posts_per_page' => 1,
    ) );
    if ( ! empty( $existing ) ) {
        $permalink = get_permalink( $existing[0] );
        if ( $permalink ) {
            wp_safe_redirect( $permalink );
            exit;
        }
    }

    if ( ! function_exists( 'ota_import_hotel_by_id' ) ) {
        $redirect = add_query_arg( array( 'hotel_id' => $hotel_id,  'checkin' => $checkin, 'checkout' => $checkout , 'lang' => $lang, 'currency' => $currency, 'import_error' => 'import_function_missing' ), home_url('/hotel-detail/') );
        wp_safe_redirect( $redirect );
        exit;
    }

    $result = ota_import_hotel_by_id( $hotel_id ,$checkin , $checkout , $adults,$children, $lang, $currency); // Pass currency

    if ( is_wp_error( $result ) ) {
        $redirect = add_query_arg( array( 'hotel_id' => $hotel_id,  'checkin' => $checkin, 'checkout' => $checkout , 'lang' => $lang, 'currency' => $currency, 'import_error' => urlencode( $result->get_error_message() ) ), home_url('/hotel-detail/') );
        wp_safe_redirect( $redirect );
        exit;
    }

    $new_post_id = (int) $result;
    $permalink = get_permalink( $new_post_id );
    if ( $permalink ) {
        wp_safe_redirect( $permalink );
        exit;
    } else {
        $redirect = add_query_arg( array( 'hotel_id' => $hotel_id,  'checkin' => $checkin, 'checkout' => $checkout , 'lang' => $lang, 'currency' => $currency ), home_url('/hotel-detail/') );
        wp_safe_redirect( $redirect );
        exit;
    }
} );


// Register settings and add settings page
add_action( 'admin_menu', 'worldota_settings_menu' );
add_action( 'admin_init', 'worldota_register_settings' );

function worldota_settings_menu() {
    add_options_page(
        'WorldOTA Settings',
        'WorldOTA',
        'manage_options',
        'worldota-settings',
        'worldota_render_settings_page'
    );
}

function worldota_register_settings() {
    register_setting( 'worldota_settings_group', 'worldota_settings', 'worldota_sanitize_settings' );

    add_settings_section(
        'worldota_section_main',
        'WorldOTA API Settings',
        function(){ echo '<p>Enter API credentials for sandbox and live. Pick which one should be active.</p>'; },
        'worldota-settings'
    );

    add_settings_field( 'worldota_mode', 'Active mode', 'worldota_field_mode_cb', 'worldota-settings', 'worldota_section_main' );
    add_settings_field( 'worldota_sandbox_key_id', 'Sandbox: Key ID', 'worldota_field_sandbox_key_id_cb', 'worldota-settings', 'worldota_section_main' );
    add_settings_field( 'worldota_sandbox_key', 'Sandbox: Key', 'worldota_field_sandbox_key_cb', 'worldota-settings', 'worldota_section_main' );
    add_settings_field( 'worldota_live_key_id', 'Live: Key ID', 'worldota_field_live_key_id_cb', 'worldota-settings', 'worldota_section_main' );
    add_settings_field( 'worldota_live_key', 'Live: Key', 'worldota_field_live_key_cb', 'worldota-settings', 'worldota_section_main' );

    // Optional: custom API URLs (if you use sandbox/prod hosts)
    add_settings_field( 'worldota_sandbox_api_url', 'Sandbox API URL', 'worldota_field_sandbox_api_url_cb', 'worldota-settings', 'worldota_section_main' );
    add_settings_field( 'worldota_live_api_url', 'Live API URL', 'worldota_field_live_api_url_cb', 'worldota-settings', 'worldota_section_main' );
}

function worldota_sanitize_settings( $input ) {
    $out = array();

    $out['mode'] = ( isset($input['mode']) && in_array($input['mode'], array('sandbox','live'), true) ) ? $input['mode'] : 'sandbox';

    $out['sandbox_key_id'] = isset($input['sandbox_key_id']) ? sanitize_text_field( $input['sandbox_key_id'] ) : '';
    $out['sandbox_key']    = isset($input['sandbox_key']) ? sanitize_text_field( $input['sandbox_key'] ) : '';

    $out['live_key_id'] = isset($input['live_key_id']) ? sanitize_text_field( $input['live_key_id'] ) : '';
    $out['live_key']    = isset($input['live_key']) ? sanitize_text_field( $input['live_key'] ) : '';

    $out['sandbox_api_url'] = isset($input['sandbox_api_url']) ? esc_url_raw( $input['sandbox_api_url'] ) : 'https://api-sandbox.worldota.net';
    $out['live_api_url']    = isset($input['live_api_url']) ? esc_url_raw( $input['live_api_url'] ) : 'https://api.worldota.net';

    return $out;
}

/* Fields callbacks *//*
function worldota_field_mode_cb() {
    $opts = get_option('worldota_settings', array('mode'=>'sandbox'));
    $mode = $opts['mode'] ?? 'sandbox';
    ?>
    <select name="worldota_settings[mode]">
        <option value="sandbox" <?php selected( $mode, 'sandbox' ); ?>>Sandbox</option>
        <option value="live" <?php selected( $mode, 'live' ); ?>>Live</option>
    </select>
    <p class="description">Choose which environment is active. Keys for both can be stored but only the active set will be used.</p>
    <?php
}

function worldota_field_sandbox_key_id_cb() {
    $opts = get_option('worldota_settings', array());
    $val = $opts['sandbox_key_id'] ?? '';
    printf('<input type="text" style="width:400px" name="worldota_settings[sandbox_key_id]" value="%s">', esc_attr($val));
}

function worldota_field_sandbox_key_cb() {
    $opts = get_option('worldota_settings', array());
    $val = $opts['sandbox_key'] ?? '';
    printf('<input type="text" style="width:400px" name="worldota_settings[sandbox_key]" value="%s">', esc_attr($val));
}

function worldota_field_live_key_id_cb() {
    $opts = get_option('worldota_settings', array());
    $val = $opts['live_key_id'] ?? '';
    printf('<input type="text" style="width:400px" name="worldota_settings[live_key_id]" value="%s">', esc_attr($val));
}

function worldota_field_live_key_cb() {
    $opts = get_option('worldota_settings', array());
    $val = $opts['live_key'] ?? '';
    printf('<input type="text" style="width:400px" name="worldota_settings[live_key]" value="%s">', esc_attr($val));
}

function worldota_field_sandbox_api_url_cb() {
    $opts = get_option('worldota_settings', array());
    $val = $opts['sandbox_api_url'] ?? 'https://api-sandbox.worldota.net';
    printf('<input type="text" style="width:400px" name="worldota_settings[sandbox_api_url]" value="%s">', esc_attr($val));
}

function worldota_field_live_api_url_cb() {
    $opts = get_option('worldota_settings', array());
    $val = $opts['live_api_url'] ?? 'https://api.worldota.net';
    printf('<input type="text" style="width:400px" name="worldota_settings[live_api_url]" value="%s">', esc_attr($val));
}

function worldota_render_settings_page() {
    ?>
    <div class="wrap">
        <h1>WorldOTA Settings</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('worldota_settings_group');
            do_settings_sections('worldota-settings');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}
/**
 * Return active WorldOTA credentials and URLs.
 * Priority order:
 * 1) If constants are defined (WORLDOTA_AUTH_USER / WORLDOTA_AUTH_PASSWORD / WORLDOTA_API_URL / WORLDOTA_IMAGE_PREFIX) use them.
 * 2) Else use options from worldota_settings (admin UI).
 * Returns array: [ 'key_id', 'key', 'api_url', 'image_prefix', 'mode' ]
 *//*
function worldota_get_creds() {
    // 1) constants override for backward compatibility
    $const_key_id = defined('WORLDOTA_AUTH_USER') ? WORLDOTA_AUTH_USER : ( defined('WO_KEY_ID') ? WO_KEY_ID : null );
    $const_key    = defined('WORLDOTA_AUTH_PASSWORD') ? WORLDOTA_AUTH_PASSWORD : ( defined('WO_KEY') ? WO_KEY : null );
    $const_api    = defined('WORLDOTA_API_URL') ? WORLDOTA_API_URL : null;
    $const_img    = defined('WORLDOTA_IMAGE_PREFIX') ? WORLDOTA_IMAGE_PREFIX : null;

    if ( $const_key_id && $const_key ) {
        return array(
            'key_id' => $const_key_id,
            'key' => $const_key,
            'api_url' => $const_api ?: 'https://api.worldota.net',
            'image_prefix' => $const_img ?: 'https://cdn.worldota.net/t/1024x768/',
            'mode' => 'const'
        );
    }

    // 2) options
    $opts = get_option('worldota_settings', array(
        'mode' => 'sandbox',
        'sandbox_api_url' => 'https://api-sandbox.worldota.net',
        'live_api_url' => 'https://api.worldota.net',
    ));

    $mode = $opts['mode'] ?? 'sandbox';

    if ( $mode === 'live' ) {
        $key_id = $opts['live_key_id'] ?? '';
        $key = $opts['live_key'] ?? '';
        $api_url = $opts['live_api_url'] ?? 'https://api.worldota.net';
    } else {
        $key_id = $opts['sandbox_key_id'] ?? '';
        $key = $opts['sandbox_key'] ?? '';
        $api_url = $opts['sandbox_api_url'] ?? 'https://api-sandbox.worldota.net';
    }

    return array(
        'key_id' => $key_id,
        'key' => $key,
        'api_url' => rtrim( $api_url ?: ($mode === 'live' ? 'https://api.worldota.net' : 'https://api-sandbox.worldota.net'), '/' ) . '/',
        'image_prefix' => 'https://cdn.worldota.net/t/1024x768/',
        'mode' => $mode,
    );
}
*/