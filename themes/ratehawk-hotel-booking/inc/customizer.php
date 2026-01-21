<?php
/**
 * Destination Hotel Booking: Customizer
 *
 * @package Destination Hotel Booking
 * @subpackage destination_hotel_booking
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function Destination_Hotel_Booking_Customize_register( $wp_customize ) {

	// Pro Version
    class destination_hotel_booking_Customize_Pro_Version extends WP_Customize_Control {
        public $type = 'pro_options';

        public function render_content() {
            echo '<span>Unlock Premium <strong>'. esc_html( $this->label ) .'</strong>? </span>';
            echo '<a href="'. esc_url($this->description) .'" target="_blank">';
                echo '<span class="dashicons dashicons-info"></span>';
                echo '<strong> '. esc_html( DESTINATION_HOTEL_BOOKING_BUY_TEXT,'destination-hotel-booking' ) .'<strong></a>';
            echo '</a>';
        }
    }

    // Custom Controls
    function destination_hotel_booking_sanitize_custom_control( $input ) {
        return $input;
    }

	require get_parent_theme_file_path('/inc/controls/range-slider-control.php');

	require get_parent_theme_file_path('/inc/controls/icon-changer.php');
	
	// Register the custom control type.
	$wp_customize->register_control_type( 'Destination_Hotel_Booking_Toggle_Control' );
	
	//Register the sortable control type.
	$wp_customize->register_control_type( 'Destination_Hotel_Booking_Control_Sortable' );

	//add home page setting pannel
	$wp_customize->add_panel( 'destination_hotel_booking_panel_id', array(
	    'priority' => 10,
	    'capability' => 'edit_theme_options',
	    'theme_supports' => '',
	    'title' => __( 'Custom Home page', 'destination-hotel-booking' ),
	    'description' => __( 'Description of what this panel does.', 'destination-hotel-booking' ),
	) );
	
	//TP GENRAL OPTION
	$wp_customize->add_section('destination_hotel_booking_tp_general_settings',array(
        'title' => __('TP General Option', 'destination-hotel-booking'),
        'priority' => 1,
        'panel' => 'destination_hotel_booking_panel_id'
    ) );

    $wp_customize->add_setting('destination_hotel_booking_tp_body_layout_settings',array(
        'default' => 'Full',
        'sanitize_callback' => 'destination_hotel_booking_sanitize_choices'
	));
    $wp_customize->add_control('destination_hotel_booking_tp_body_layout_settings',array(
        'type' => 'radio',
        'label'     => __('Body Layout Setting', 'destination-hotel-booking'),
        'description'   => __('This option work for complete body, if you want to set the complete website in container.', 'destination-hotel-booking'),
        'section' => 'destination_hotel_booking_tp_general_settings',
        'choices' => array(
            'Full' => __('Full','destination-hotel-booking'),
            'Container' => __('Container','destination-hotel-booking'),
            'Container Fluid' => __('Container Fluid','destination-hotel-booking')
        ),
	) );

    // Add Settings and Controls for Post Layout
	$wp_customize->add_setting('destination_hotel_booking_sidebar_post_layout',array(
        'default' => 'right',
        'sanitize_callback' => 'destination_hotel_booking_sanitize_choices'
	));
	$wp_customize->add_control('destination_hotel_booking_sidebar_post_layout',array(
        'type' => 'radio',
        'label'     => __('Post Sidebar Position', 'destination-hotel-booking'),
        'description'   => __('This option work for blog page, blog single page, archive page and search page.', 'destination-hotel-booking'),
        'section' => 'destination_hotel_booking_tp_general_settings',
        'choices' => array(
            'full' => __('Full','destination-hotel-booking'),
            'left' => __('Left','destination-hotel-booking'),
            'right' => __('Right','destination-hotel-booking'),
            'three-column' => __('Three Columns','destination-hotel-booking'),
            'four-column' => __('Four Columns','destination-hotel-booking'),
            'grid' => __('Grid Layout','destination-hotel-booking')
        ),
	) );

	// Add Settings and Controls for post sidebar Layout
	$wp_customize->add_setting('destination_hotel_booking_sidebar_single_post_layout',array(
        'default' => 'right',
        'sanitize_callback' => 'destination_hotel_booking_sanitize_choices'
	));
	$wp_customize->add_control('destination_hotel_booking_sidebar_single_post_layout',array(
        'type' => 'radio',
        'label'     => __('Single Post Sidebar Position', 'destination-hotel-booking'),
        'description'   => __('This option work for single blog page', 'destination-hotel-booking'),
        'section' => 'destination_hotel_booking_tp_general_settings',
        'choices' => array(
            'full' => __('Full','destination-hotel-booking'),
            'left' => __('Left','destination-hotel-booking'),
            'right' => __('Right','destination-hotel-booking'),
        ),
	) );

	// Add Settings and Controls for Page Layout
	$wp_customize->add_setting('destination_hotel_booking_sidebar_page_layout',array(
        'default' => 'right',
        'sanitize_callback' => 'destination_hotel_booking_sanitize_choices'
	));
	$wp_customize->add_control('destination_hotel_booking_sidebar_page_layout',array(
        'type' => 'radio',
        'label'     => __('Page Sidebar Position', 'destination-hotel-booking'),
        'description'   => __('This option work for pages.', 'destination-hotel-booking'),
        'section' => 'destination_hotel_booking_tp_general_settings',
        'choices' => array(
            'full' => __('Full','destination-hotel-booking'),
            'left' => __('Left','destination-hotel-booking'),
            'right' => __('Right','destination-hotel-booking')
        ),
	) );

	$wp_customize->add_setting( 'destination_hotel_booking_sticky', array(
		'default'           => false,
		'transport'         => 'refresh',
		'sanitize_callback' => 'destination_hotel_booking_sanitize_checkbox',
	) );
	$wp_customize->add_control( new Destination_Hotel_Booking_Toggle_Control( $wp_customize, 'destination_hotel_booking_sticky', array(
		'label'       => esc_html__( 'Show Sticky Header', 'destination-hotel-booking' ),
		'section'     => 'destination_hotel_booking_tp_general_settings',
		'type'        => 'toggle',
		'settings'    => 'destination_hotel_booking_sticky',
	) ) );

	//tp typography option
	$destination_hotel_booking_font_array = array(
		''                       => 'No Fonts',
		'Abril Fatface'          => 'Abril Fatface',
		'Acme'                   => 'Acme',
		'Anton'                  => 'Anton',
		'Architects Daughter'    => 'Architects Daughter',
		'Arimo'                  => 'Arimo',
		'Arsenal'                => 'Arsenal',
		'Arvo'                   => 'Arvo',
		'Alegreya'               => 'Alegreya',
		'Alfa Slab One'          => 'Alfa Slab One',
		'Averia Serif Libre'     => 'Averia Serif Libre',
		'Bangers'                => 'Bangers',
		'Boogaloo'               => 'Boogaloo',
		'Bad Script'             => 'Bad Script',
		'Bitter'                 => 'Bitter',
		'Bree Serif'             => 'Bree Serif',
		'BenchNine'              => 'BenchNine',
		'Cabin'                  => 'Cabin',
		'Cardo'                  => 'Cardo',
		'Courgette'              => 'Courgette',
		'Cherry Swash'           => 'Cherry Swash',
		'Cormorant Garamond'     => 'Cormorant Garamond',
		'Crimson Text'           => 'Crimson Text',
		'Cuprum'                 => 'Cuprum',
		'Cookie'                 => 'Cookie',
		'Chewy'                  => 'Chewy',
		'Days One'               => 'Days One',
		'Dosis'                  => 'Dosis',
		'Droid Sans'             => 'Droid Sans',
		'Economica'              => 'Economica',
		'Fredoka One'            => 'Fredoka One',
		'Fjalla One'             => 'Fjalla One',
		'Francois One'           => 'Francois One',
		'Frank Ruhl Libre'       => 'Frank Ruhl Libre',
		'Gloria Hallelujah'      => 'Gloria Hallelujah',
		'Great Vibes'            => 'Great Vibes',
		'Handlee'                => 'Handlee',
		'Hammersmith One'        => 'Hammersmith One',
		'Inconsolata'            => 'Inconsolata',
		'Indie Flower'           => 'Indie Flower',
		'Inter'                  => 'Inter',
		'IM Fell English SC'     => 'IM Fell English SC',
		'Julius Sans One'        => 'Julius Sans One',
		'Josefin Slab'           => 'Josefin Slab',
		'Josefin Sans'           => 'Josefin Sans',
		'Kanit'                  => 'Kanit',
		'Karla'                  => 'Karla',
		'Lobster'                => 'Lobster',
		'Lato'                   => 'Lato',
		'Lora'                   => 'Lora',
		'Libre Baskerville'      => 'Libre Baskerville',
		'Lobster Two'            => 'Lobster Two',
		'Manrope'           	 => 'Manrope',
		'Merriweather'           => 'Merriweather',
		'Monda'                  => 'Monda',
		'Montserrat'             => 'Montserrat',
		'Muli'                   => 'Muli',
		'Marck Script'           => 'Marck Script',
		'Noto Serif'             => 'Noto Serif',
		'Open Sans'              => 'Open Sans',
		'Overpass'               => 'Overpass',
		'Overpass Mono'          => 'Overpass Mono',
		'Oxygen'                 => 'Oxygen',
		'Oxanium'                => 'Oxanium',
		'Orbitron'               => 'Orbitron',
		'Patua One'              => 'Patua One',
		'Pacifico'               => 'Pacifico',
		'Padauk'                 => 'Padauk',
		'Playball'               => 'Playball',
		'Playfair Display'       => 'Playfair Display',
		'PT Sans'                => 'PT Sans',
		'Philosopher'            => 'Philosopher',
		'Permanent Marker'       => 'Permanent Marker',
		'Poiret One'             => 'Poiret One',
		'Quicksand'              => 'Quicksand',
		'Quattrocento Sans'      => 'Quattrocento Sans',
		'Raleway'                => 'Raleway',
		'Rubik'                  => 'Rubik',
		'Rokkitt'                => 'Rokkitt',
		'Roboto Serif'           => 'Roboto Serif',
		'Russo One'              => 'Russo One',
		'Righteous'              => 'Righteous',
		'Satisfy'                => 'Satisfy',
		'Slabo'                  => 'Slabo',
		'Source Sans Pro'        => 'Source Sans Pro',
		'Shadows Into Light Two' => 'Shadows Into Light Two',
		'Shadows Into Light'     => 'Shadows Into Light',
		'Sacramento'             => 'Sacramento',
		'Shrikhand'              => 'Shrikhand',
		'Tangerine'              => 'Tangerine',
		'Ubuntu'                 => 'Ubuntu',
		'VT323'                  => 'VT323',
		'Varela Round'           => 'Varela Round',
		'Vampiro One'            => 'Vampiro One',
		'Vollkorn'               => 'Vollkorn',
		'Volkhov'                => 'Volkhov',
		'Yanone Kaffeesatz'      => 'Yanone Kaffeesatz'
	);

	$wp_customize->add_section('destination_hotel_booking_typography_option',array(
		'title'         => __('TP Typography Option', 'destination-hotel-booking'),
		'priority' => 1,
		'panel' => 'destination_hotel_booking_panel_id'
   	));

   	$wp_customize->add_setting('destination_hotel_booking_heading_font_family', array(
		'default'           => '',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'destination_hotel_booking_sanitize_choices',
	));
	$wp_customize->add_control(	'destination_hotel_booking_heading_font_family', array(
		'section' => 'destination_hotel_booking_typography_option',
		'label'   => __('heading Fonts', 'destination-hotel-booking'),
		'type'    => 'select',
		'choices' => $destination_hotel_booking_font_array,
	));

	$wp_customize->add_setting('destination_hotel_booking_body_font_family', array(
		'default'           => '',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'destination_hotel_booking_sanitize_choices',
	));
	$wp_customize->add_control(	'destination_hotel_booking_body_font_family', array(
		'section' => 'destination_hotel_booking_typography_option',
		'label'   => __('Body Fonts', 'destination-hotel-booking'),
		'type'    => 'select',
		'choices' => $destination_hotel_booking_font_array,
	));

	//TP Preloader Option
	$wp_customize->add_section('destination_hotel_booking_prelaoder_option',array(
		'title'         => __('TP Preloader Option', 'destination-hotel-booking'),
		'priority' => 1,
		'panel' => 'destination_hotel_booking_panel_id'
	) );

	$wp_customize->add_setting( 'destination_hotel_booking_preloader_show_hide', array(
		'default'           => false,
		'transport'         => 'refresh',
		'sanitize_callback' => 'destination_hotel_booking_sanitize_checkbox',
	) );
	$wp_customize->add_control( new Destination_Hotel_Booking_Toggle_Control( $wp_customize, 'destination_hotel_booking_preloader_show_hide', array(
		'label'       => esc_html__( 'Show / Hide Preloader Option', 'destination-hotel-booking' ),
		'section'     => 'destination_hotel_booking_prelaoder_option',
		'type'        => 'toggle',
		'settings'    => 'destination_hotel_booking_preloader_show_hide',
	) ) );

	$wp_customize->add_setting( 'destination_hotel_booking_tp_preloader_color1_option', array(
	    'default' => '',
	    'sanitize_callback' => 'sanitize_hex_color'
  	));
  	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'destination_hotel_booking_tp_preloader_color1_option', array(
			'label'     => __('Preloader First Ring Color', 'destination-hotel-booking'),
	    'description' => __('It will change the complete theme preloader ring 1 color in one click.', 'destination-hotel-booking'),
	    'section' => 'destination_hotel_booking_prelaoder_option',
	    'settings' => 'destination_hotel_booking_tp_preloader_color1_option',
  	)));

  	$wp_customize->add_setting( 'destination_hotel_booking_tp_preloader_color2_option', array(
	    'default' => '',
	    'sanitize_callback' => 'sanitize_hex_color'
  	));
  	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'destination_hotel_booking_tp_preloader_color2_option', array(
			'label'     => __('Preloader Second Ring Color', 'destination-hotel-booking'),
	    'description' => __('It will change the complete theme preloader ring 2 color in one click.', 'destination-hotel-booking'),
	    'section' => 'destination_hotel_booking_prelaoder_option',
	    'settings' => 'destination_hotel_booking_tp_preloader_color2_option',
  	)));

  	$wp_customize->add_setting( 'destination_hotel_booking_tp_preloader_bg_color_option', array(
	    'default' => '',
	    'sanitize_callback' => 'sanitize_hex_color'
  	));
  	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'destination_hotel_booking_tp_preloader_bg_color_option', array(
			'label'     => __('Preloader Background Color', 'destination-hotel-booking'),
	    'description' => __('It will change the complete theme preloader bg color in one click.', 'destination-hotel-booking'),
	    'section' => 'destination_hotel_booking_prelaoder_option',
	    'settings' => 'destination_hotel_booking_tp_preloader_bg_color_option',
  	)));

  	// Pro Version
    $wp_customize->add_setting( 'destination_hotel_booking_preloader_pro_version_logo', array(
        'sanitize_callback' => 'destination_hotel_booking_sanitize_custom_control'
    ));
    $wp_customize->add_control( new destination_hotel_booking_Customize_Pro_Version ( $wp_customize,'destination_hotel_booking_preloader_pro_version_logo', array(
        'section'     => 'destination_hotel_booking_prelaoder_option',
        'type'        => 'pro_options',
        'label'       => esc_html__( 'Features ', 'destination-hotel-booking' ),
        'description' => esc_url( DESTINATION_HOTEL_BOOKING_PRO_THEME_URL ),
        'priority'    => 100
    )));


	//TP Color Option
	$wp_customize->add_section('destination_hotel_booking_color_option',array(
     'title'         => __('TP Color Option', 'destination-hotel-booking'),
     'priority' => 1,
     'panel' => 'destination_hotel_booking_panel_id'
    ) );
    
	$wp_customize->add_setting( 'destination_hotel_booking_tp_color_option_first', array(
	    'default' => '',
	    'sanitize_callback' => 'sanitize_hex_color'
  	));
  	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'destination_hotel_booking_tp_color_option_first', array(
			'label'     => __('Theme First Color', 'destination-hotel-booking'),
	    'description' => __('It will change the complete theme color in one click.', 'destination-hotel-booking'),
	    'section' => 'destination_hotel_booking_color_option',
	    'settings' => 'destination_hotel_booking_tp_color_option_first',
  	)));

	//TP Blog Option
	$wp_customize->add_section('destination_hotel_booking_blog_option',array(
        'title' => __('TP Blog Option', 'destination-hotel-booking'),
        'priority' => 1,
        'panel' => 'destination_hotel_booking_panel_id'
    ) );

    $wp_customize->add_setting('destination_hotel_booking_edit_blog_page_title',array(
		'default'=> __('Home','destination-hotel-booking'),
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('destination_hotel_booking_edit_blog_page_title',array(
		'label'	=> __('Change Blog Page Title','destination-hotel-booking'),
		'section'=> 'destination_hotel_booking_blog_option',
		'type'=> 'text'
	));

	$wp_customize->add_setting('destination_hotel_booking_edit_blog_page_description',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('destination_hotel_booking_edit_blog_page_description',array(
		'label'	=> __('Add Blog Page Description','destination-hotel-booking'),
		'section'=> 'destination_hotel_booking_blog_option',
		'type'=> 'text'
	));

	/** Meta Order */
    $wp_customize->add_setting('blog_meta_order', array(
        'default' => array('date', 'author', 'comment','category', 'time'),
        'sanitize_callback' => 'destination_hotel_booking_sanitize_sortable',
    ));
    $wp_customize->add_control(new Destination_Hotel_Booking_Control_Sortable($wp_customize, 'blog_meta_order', array(
    	'label' => esc_html__('Meta Order', 'destination-hotel-booking'),
        'description' => __('Drag & Drop post items to re-arrange the order and also hide and show items as per the need by clicking on the eye icon.', 'destination-hotel-booking') ,
        'section' => 'destination_hotel_booking_blog_option',
        'choices' => array(
            'date' => __('date', 'destination-hotel-booking') ,
            'author' => __('author', 'destination-hotel-booking') ,
            'comment' => __('comment', 'destination-hotel-booking') ,
            'category' => __('category', 'destination-hotel-booking') ,
            'time' => __('time', 'destination-hotel-booking') ,
        ) ,
    )));

    $wp_customize->add_setting( 'destination_hotel_booking_excerpt_count', array(
		'default'              => 35,
		'type'                 => 'theme_mod',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'destination_hotel_booking_sanitize_number_range',
		'sanitize_js_callback' => 'absint',
	) );
	$wp_customize->add_control( 'destination_hotel_booking_excerpt_count', array(
		'label'       => esc_html__( 'Edit Excerpt Limit','destination-hotel-booking' ),
		'section'     => 'destination_hotel_booking_blog_option',
		'type'        => 'number',
		'input_attrs' => array(
			'step'             => 2,
			'min'              => 0,
			'max'              => 50,
		),
	) );

	$wp_customize->add_setting('destination_hotel_booking_show_first_caps',array(
        'default' => false,
        'sanitize_callback' => 'destination_hotel_booking_sanitize_checkbox',
    ));
	$wp_customize->add_control( 'destination_hotel_booking_show_first_caps',array(
		'label' => esc_html__('First Cap (First Capital Letter)', 'destination-hotel-booking'),
		'type' => 'checkbox',
		'section' => 'destination_hotel_booking_blog_option',
	));

    $wp_customize->add_setting('destination_hotel_booking_read_more_text',array(
		'default'=> __('Read More','destination-hotel-booking'),
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('destination_hotel_booking_read_more_text',array(
		'label'	=> __('Edit Button Text','destination-hotel-booking'),
		'section'=> 'destination_hotel_booking_blog_option',
		'type'=> 'text'
	));

	$wp_customize->add_setting('destination_hotel_booking_post_image_round', array(
	  'default' => '0',
      'sanitize_callback' => 'destination_hotel_booking_sanitize_number_range',
	));
	$wp_customize->add_control(new Destination_Hotel_Booking_Range_Slider($wp_customize, 'destination_hotel_booking_post_image_round', array(
       'section' => 'destination_hotel_booking_blog_option',
      'label' => esc_html__('Edit Post Image Border Radius', 'destination-hotel-booking'),
      'input_attrs' => array(
        'min' => 0,
        'max' => 180,
        'step' => 1
    )
	)));

	$wp_customize->add_setting('destination_hotel_booking_post_image_width', array(
	  'default' => '',
      'sanitize_callback' => 'destination_hotel_booking_sanitize_number_range',
	));
	$wp_customize->add_control(new Destination_Hotel_Booking_Range_Slider($wp_customize, 'destination_hotel_booking_post_image_width', array(
       'section' => 'destination_hotel_booking_blog_option',
      'label' => esc_html__('Edit Post Image Width', 'destination-hotel-booking'),
      'input_attrs' => array(
        'min' => 0,
        'max' => 367,
        'step' => 1
    )
	)));

	$wp_customize->add_setting('destination_hotel_booking_post_image_length', array(
	  'default' => '',
      'sanitize_callback' => 'destination_hotel_booking_sanitize_number_range',
	));
	$wp_customize->add_control(new Destination_Hotel_Booking_Range_Slider($wp_customize, 'destination_hotel_booking_post_image_length', array(
       'section' => 'destination_hotel_booking_blog_option',
      'label' => esc_html__('Edit Post Image height', 'destination-hotel-booking'),
      'input_attrs' => array(
        'min' => 0,
        'max' => 900,
        'step' => 1
    )
	)));
	
	$wp_customize->add_setting( 'destination_hotel_booking_remove_read_button', array(
		'default'           => true,
		'transport'         => 'refresh',
		'sanitize_callback' => 'destination_hotel_booking_sanitize_checkbox',
	) );
	$wp_customize->add_control( new Destination_Hotel_Booking_Toggle_Control( $wp_customize, 'destination_hotel_booking_remove_read_button', array(
		'label'       => esc_html__( 'Show / Hide Read More Button', 'destination-hotel-booking' ),
		'section'     => 'destination_hotel_booking_blog_option',
		'type'        => 'toggle',
		'settings'    => 'destination_hotel_booking_remove_read_button',
	) ) );

	$wp_customize->add_setting( 'destination_hotel_booking_remove_tags', array(
		'default'           => true,
		'transport'         => 'refresh',
		'sanitize_callback' => 'destination_hotel_booking_sanitize_checkbox',
	) );
	$wp_customize->add_control( new Destination_Hotel_Booking_Toggle_Control( $wp_customize, 'destination_hotel_booking_remove_tags', array(
		'label'       => esc_html__( 'Show / Hide Tags Option', 'destination-hotel-booking' ),
		'section'     => 'destination_hotel_booking_blog_option',
		'type'        => 'toggle',
		'settings'    => 'destination_hotel_booking_remove_tags',
	) ) );

	$wp_customize->add_setting( 'destination_hotel_booking_remove_category', array(
		'default'           => true,
		'transport'         => 'refresh',
		'sanitize_callback' => 'destination_hotel_booking_sanitize_checkbox',
	) );
	$wp_customize->add_control( new Destination_Hotel_Booking_Toggle_Control( $wp_customize, 'destination_hotel_booking_remove_category', array(
		'label'       => esc_html__( 'Show / Hide Category Option', 'destination-hotel-booking' ),
		'section'     => 'destination_hotel_booking_blog_option',
		'type'        => 'toggle',
		'settings'    => 'destination_hotel_booking_remove_category',
	) ) );

	$wp_customize->add_setting( 'destination_hotel_booking_remove_comment', array(
	 'default'           => true,
	 'transport'         => 'refresh',
	 'sanitize_callback' => 'destination_hotel_booking_sanitize_checkbox',
 	) );

	$wp_customize->add_control( new Destination_Hotel_Booking_Toggle_Control( $wp_customize, 'destination_hotel_booking_remove_comment', array(
	 'label'       => esc_html__( 'Show / Hide Comment Form', 'destination-hotel-booking' ),
	 'section'     => 'destination_hotel_booking_blog_option',
	 'type'        => 'toggle',
	 'settings'    => 'destination_hotel_booking_remove_comment',
	) ) );

	$wp_customize->add_setting( 'destination_hotel_booking_remove_related_post', array(
	 'default'           => true,
	 'transport'         => 'refresh',
	 'sanitize_callback' => 'destination_hotel_booking_sanitize_checkbox',
 	) );
	$wp_customize->add_control( new Destination_Hotel_Booking_Toggle_Control( $wp_customize, 'destination_hotel_booking_remove_related_post', array(
	 'label'       => esc_html__( 'Show / Hide Related Post', 'destination-hotel-booking' ),
	 'section'     => 'destination_hotel_booking_blog_option',
	 'type'        => 'toggle',
	 'settings'    => 'destination_hotel_booking_remove_related_post',
	) ) );

	$wp_customize->add_setting('destination_hotel_booking_related_post_heading',array(
		'default'=> __('Related Posts','destination-hotel-booking'),
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('destination_hotel_booking_related_post_heading',array(
		'label'	=> __('Edit Section Title','destination-hotel-booking'),
		'section'=> 'destination_hotel_booking_blog_option',
		'type'=> 'text'
	));

	$wp_customize->add_setting( 'destination_hotel_booking_related_post_per_page', array(
		'default'              => 3,
		'type'                 => 'theme_mod',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'destination_hotel_booking_sanitize_number_range',
		'sanitize_js_callback' => 'absint',
	) );
	$wp_customize->add_control( 'destination_hotel_booking_related_post_per_page', array(
		'label'       => esc_html__( 'Related Post Per Page','destination-hotel-booking' ),
		'section'     => 'destination_hotel_booking_blog_option',
		'type'        => 'number',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 3,
			'max'              => 9,
		),
	) );

	$wp_customize->add_setting( 'destination_hotel_booking_related_post_per_columns', array(
		'default'              => 3,
		'type'                 => 'theme_mod',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'destination_hotel_booking_sanitize_number_range',
		'sanitize_js_callback' => 'absint',
	) );
	$wp_customize->add_control( 'destination_hotel_booking_related_post_per_columns', array(
		'label'       => esc_html__( 'Related Post Per Row','destination-hotel-booking' ),
		'section'     => 'destination_hotel_booking_blog_option',
		'type'        => 'number',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 4,
		),
	) );

	$wp_customize->add_setting('destination_hotel_booking_post_layout',array(
        'default' => 'image-content',
        'sanitize_callback' => 'destination_hotel_booking_sanitize_choices'
	));
	$wp_customize->add_control('destination_hotel_booking_post_layout',array(
        'type' => 'radio',
        'label'     => __('Post Layout', 'destination-hotel-booking'),
        'section' => 'destination_hotel_booking_blog_option',
        'choices' => array(
            'image-content' => __('Media-Content','destination-hotel-booking'),
            'content-image' => __('Content-Media','destination-hotel-booking'),
        ),
	) );

	//MENU TYPOGRAPHY
	$wp_customize->add_section( 'destination_hotel_booking_menu_typography', array(
    	'title'      => __( 'Menu Typography', 'destination-hotel-booking' ),
    	'priority' => 2,
		'panel' => 'destination_hotel_booking_panel_id'
	) );

	$wp_customize->add_setting('destination_hotel_booking_menu_font_family', array(
		'default'           => '',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'destination_hotel_booking_sanitize_choices',
	));
	$wp_customize->add_control(	'destination_hotel_booking_menu_font_family', array(
		'section' => 'destination_hotel_booking_menu_typography',
		'label'   => __('Menu Fonts', 'destination-hotel-booking'),
		'type'    => 'select',
		'choices' => $destination_hotel_booking_font_array,
	));

	$wp_customize->add_setting('destination_hotel_booking_menu_font_weight',array(
        'default' => '',
        'sanitize_callback' => 'destination_hotel_booking_sanitize_choices'
	));
	$wp_customize->add_control('destination_hotel_booking_menu_font_weight',array(
     'type' => 'radio',
     'label'     => __('Font Weight', 'destination-hotel-booking'),
     'section' => 'destination_hotel_booking_menu_typography',
     'type' => 'select',
     'choices' => array(
         '100' => __('100','destination-hotel-booking'),
         '200' => __('200','destination-hotel-booking'),
         '300' => __('300','destination-hotel-booking'),
         '400' => __('400','destination-hotel-booking'),
         '500' => __('500','destination-hotel-booking'),
         '600' => __('600','destination-hotel-booking'),
         '700' => __('700','destination-hotel-booking'),
         '800' => __('800','destination-hotel-booking'),
         '900' => __('900','destination-hotel-booking')
     ),
	) );

	$wp_customize->add_setting('destination_hotel_booking_menu_text_tranform',array(
		'default' => '',
		'sanitize_callback' => 'destination_hotel_booking_sanitize_choices'
 	));
 	$wp_customize->add_control('destination_hotel_booking_menu_text_tranform',array(
		'type' => 'select',
		'label' => __('Menu Text Transform','destination-hotel-booking'),
		'section' => 'destination_hotel_booking_menu_typography',
		'choices' => array(
		   'Uppercase' => __('Uppercase','destination-hotel-booking'),
		   'Lowercase' => __('Lowercase','destination-hotel-booking'),
		   'Capitalize' => __('Capitalize','destination-hotel-booking'),
		),
	) );

	$wp_customize->add_setting('destination_hotel_booking_menu_font_size', array(
	  'default' => '',
      'sanitize_callback' => 'destination_hotel_booking_sanitize_number_range',
	));
	$wp_customize->add_control(new Destination_Hotel_Booking_Range_Slider($wp_customize, 'destination_hotel_booking_menu_font_size', array(
        'section' => 'destination_hotel_booking_menu_typography',
        'label' => esc_html__('Font Size', 'destination-hotel-booking'),
        'input_attrs' => array(
          'min' => 0,
          'max' => 20,
          'step' => 1
    )
	)));

	$wp_customize->add_setting('destination_hotel_booking_menus_item_style',array(
		'default' => '',
		'transport' => 'refresh',
		'sanitize_callback' => 'destination_hotel_booking_sanitize_choices'
	));
	$wp_customize->add_control('destination_hotel_booking_menus_item_style',array(
		'type' => 'select',
		'section' => 'destination_hotel_booking_menu_typography',
		'label' => __('Menu Hover Effect','destination-hotel-booking'),
		'choices' => array(
			'None' => __('None','destination-hotel-booking'),
			'Zoom In' => __('Zoom In','destination-hotel-booking'),
		),
	) );

	$wp_customize->add_setting( 'destination_hotel_booking_menu_color', array(
	    'default' => '',
	    'sanitize_callback' => 'sanitize_hex_color'
  	));
  	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'destination_hotel_booking_menu_color', array(
			'label'     => __('Change Menu Color', 'destination-hotel-booking'),
	    'section' => 'destination_hotel_booking_menu_typography',
	    'settings' => 'destination_hotel_booking_menu_color',
  	)));

  	// Pro Version
    $wp_customize->add_setting( 'destination_hotel_booking_menu_pro_version_logo', array(
        'sanitize_callback' => 'destination_hotel_booking_sanitize_custom_control'
    ));
    $wp_customize->add_control( new destination_hotel_booking_Customize_Pro_Version ( $wp_customize,'destination_hotel_booking_menu_pro_version_logo', array(
        'section'     => 'destination_hotel_booking_menu_typography',
        'type'        => 'pro_options',
        'label'       => esc_html__( 'Features ', 'destination-hotel-booking' ),
        'description' => esc_url( DESTINATION_HOTEL_BOOKING_PRO_THEME_URL ),
        'priority'    => 100
    )));

  	// header detail
	$wp_customize->add_section( 'destination_hotel_booking_header_sec', array(
    	'title'      => __( 'Header Details', 'destination-hotel-booking' ),
    	'description' => __( 'Add your Contact details here', 'destination-hotel-booking' ),
		'panel' => 'destination_hotel_booking_panel_id',
      'priority' => 2,
	) );

	$wp_customize->add_setting('destination_hotel_booking_product_section_btn_link1', array(
		'default'=> '',
		'sanitize_callback'	=> 'esc_url_raw'
	));
	$wp_customize->add_control('destination_hotel_booking_product_section_btn_link1', array(
		'label'	=> esc_html__('Add User URL ','destination-hotel-booking'),
		'section'=> 'destination_hotel_booking_header_sec',
		'type'=> 'url'
	));

	/*Main Header Button Text*/
	$wp_customize->add_setting(
		'destination_hotel_booking_header_button_text',
		array(
			'capability'        => 'edit_theme_options',
			'transport'         => 'refresh',
			'default'           => 'Book A Room',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'destination_hotel_booking_header_button_text',
		array(
			'label'       => __('Edit Button Text ', 'destination-hotel-booking'),
			'section'     => 'destination_hotel_booking_header_sec',
			'type'        => 'text',
		)
	);

	/*Main Header Button Link*/
	$wp_customize->add_setting(
		'destination_hotel_booking_header_button_link',
		array(
			'capability'        => 'edit_theme_options',
			'transport'         => 'refresh',
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		'destination_hotel_booking_header_button_link',
		array(
			'label'       => __('Edit Button Link ', 'destination-hotel-booking'),
			'section'     => 'destination_hotel_booking_header_sec',
			'type'        => 'url',
		)
	);

	// Pro Version
    $wp_customize->add_setting( 'destination_hotel_booking_header_pro_version_logo', array(
        'sanitize_callback' => 'destination_hotel_booking_sanitize_custom_control'
    ));
    $wp_customize->add_control( new destination_hotel_booking_Customize_Pro_Version ( $wp_customize,'destination_hotel_booking_header_pro_version_logo', array(
        'section'     => 'destination_hotel_booking_header_sec',
        'type'        => 'pro_options',
        'label'       => esc_html__( 'Features ', 'destination-hotel-booking' ),
        'description' => esc_url( DESTINATION_HOTEL_BOOKING_PRO_THEME_URL ),
        'priority'    => 100
    )));

	// Banner/Slider Section
	$wp_customize->add_section( 'destination_hotel_booking_slider_section' , array(
	    'title'      => __( 'Banner Section', 'destination-hotel-booking' ),
	    'priority'   => 3,
	    'panel'      => 'destination_hotel_booking_panel_id'
	) );

	// Show/Hide Banner Setting
	$wp_customize->add_setting( 'destination_hotel_booking_slider_arrows', array(
	    'default'           => true,
	    'transport'         => 'refresh',
	    'sanitize_callback' => 'destination_hotel_booking_sanitize_checkbox',
	) );

	$wp_customize->add_control( new Destination_Hotel_Booking_Toggle_Control( $wp_customize, 'destination_hotel_booking_slider_arrows', array(
	    'label'       => esc_html__( 'Show / Hide Banner', 'destination-hotel-booking' ),
	    'section'     => 'destination_hotel_booking_slider_section',
	    'priority'    => 1,
	    'type'        => 'toggle',
	    'settings'    => 'destination_hotel_booking_slider_arrows',
	) ) );

	/*Main Slider Image*/
	$wp_customize->add_setting(
		'destination_hotel_booking_slider_image',
		array(
			'capability'    => 'edit_theme_options',
	        'default'       => '',
	        'transport'     => 'postMessage',
	        'sanitize_callback' => 'esc_url_raw',
    	)
    );
	$wp_customize->add_control( 
		new WP_Customize_Image_Control( $wp_customize, 
			'destination_hotel_booking_slider_image', 
			array(
		        'label' => __('Add Banner Image', 'destination-hotel-booking'),
		        'description' => __('Add Banner image.', 'destination-hotel-booking'),
		        'section' => 'destination_hotel_booking_slider_section',
			)
		)
	);

	/*Main Slider Content*/
	$wp_customize->add_setting(
		'destination_hotel_booking_slider_text',
		array(
			'capability'        => 'edit_theme_options',
			'transport'         => 'refresh',
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'destination_hotel_booking_slider_text',
		array(
			'label'       => __('Add Slider Top Title', 'destination-hotel-booking'),
			'section'     => 'destination_hotel_booking_slider_section',
			'type'        => 'text',
		)
	);

	/*Main Slider Heading*/
	$wp_customize->add_setting(
		'destination_hotel_booking_slider_heading',
		array(
			'capability'        => 'edit_theme_options',
			'transport'         => 'refresh',
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'destination_hotel_booking_slider_heading',
		array(
			'label'       => __('Add Heading', 'destination-hotel-booking'),
			'section'     => 'destination_hotel_booking_slider_section',
			'type'        => 'text',
		)
	);


	// Show/Hide Slider Form Setting
	$wp_customize->add_setting( 'destination_hotel_booking_slider_form_hide_show', array(
	    'default'           => true,
	    'transport'         => 'refresh',
	    'sanitize_callback' => 'destination_hotel_booking_sanitize_checkbox'
	) );

	$wp_customize->add_control( new Destination_Hotel_Booking_Toggle_Control( $wp_customize, 'destination_hotel_booking_slider_form_hide_show', array(
	    'label'     => esc_html__( 'Show / Hide Slider Form', 'destination-hotel-booking' ),
	    'section'   => 'destination_hotel_booking_slider_section'
	) ) );

    //Slider height
    $wp_customize->add_setting('destination_hotel_booking_slider_img_height',array(
        'default'=> '',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    $wp_customize->add_control('destination_hotel_booking_slider_img_height',array(
        'label' => __('Slider Height','destination-hotel-booking'),
        'description'   => __('Add slider height in px(eg. 700px).','destination-hotel-booking'),
        'section'=> 'destination_hotel_booking_slider_section',
        'type'=> 'text'
    ));

    // Pro Version
    $wp_customize->add_setting( 'destination_hotel_booking_slider_pro_version_logo', array(
        'sanitize_callback' => 'destination_hotel_booking_sanitize_custom_control'
    ));
    $wp_customize->add_control( new destination_hotel_booking_Customize_Pro_Version ( $wp_customize,'destination_hotel_booking_slider_pro_version_logo', array(
        'section'     => 'destination_hotel_booking_slider_section',
        'type'        => 'pro_options',
        'label'       => esc_html__( 'Features ', 'destination-hotel-booking' ),
        'description' => esc_url( DESTINATION_HOTEL_BOOKING_PRO_THEME_URL ),
        'priority'    => 100
    )));

	/*=========================================
	service Section
	=========================================*/
	// Service Section Settings
	$wp_customize->add_section('destination_hotel_booking_second_section', array(
	  'title' => __('Book Your Stay & Relex Section', 'destination-hotel-booking'),
	  'panel' => 'destination_hotel_booking_panel_id',
	  'priority' => 4,
	));

	$wp_customize->add_setting( 'destination_hotel_booking_cat_sec', array(
		'default'           => true,
		'transport'         => 'refresh',
		'sanitize_callback' => 'destination_hotel_booking_sanitize_checkbox',
	) );
	$wp_customize->add_control( new Destination_Hotel_Booking_Toggle_Control( $wp_customize, 'destination_hotel_booking_cat_sec', array(
		'label'       => esc_html__( 'Show / Hide Product Category Section', 'destination-hotel-booking' ),
		'section'     => 'destination_hotel_booking_second_section',
		'type'        => 'toggle',
		'settings'    => 'destination_hotel_booking_cat_sec',
	) ) );

    /*Product Section Heading*/
    $wp_customize->add_setting(
        'destination_hotel_booking_event_text',
        array(
            'capability'        => 'edit_theme_options',
            'transport'         => 'refresh',
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
        )
    );
    $wp_customize->add_control(
        'destination_hotel_booking_event_text',
        array(
            'label'       => __('Add Section Heading', 'destination-hotel-booking'),
            'section'     => 'destination_hotel_booking_second_section',
            'type'        => 'text',
        )
    );

	// Section heading text
	$wp_customize->add_setting('destination_hotel_booking_small_title', array(
	    'default'           => '',
	    'sanitize_callback' => 'sanitize_text_field',
	));

	$wp_customize->add_control('destination_hotel_booking_small_title', array(
	    'label'   => esc_html__('Add Section Content', 'destination-hotel-booking'),
	    'section' => 'destination_hotel_booking_second_section',
	    'type'    => 'text',
	));

	// Add Setting
    $wp_customize->add_setting( 'destination_hotel_booking_selected_category', array(
        'default'           => '',
        'sanitize_callback' => 'absint',
    ) );
    $wp_customize->add_control( new Destination_Hotel_Booking_WP_Customize_Taxonomy_Control( $wp_customize, 'destination_hotel_booking_selected_category', array(
        'label'       => __( 'Select Room Category', 'destination-hotel-booking' ),
        'description' => __( 'Choose a category of rooms to display.', 'destination-hotel-booking' ),
        'section'     => 'destination_hotel_booking_second_section',
        'settings'    => 'destination_hotel_booking_selected_category',
        'taxonomy'    => 'mphb_room_type_category',
    ) ) );

    // Pro Version
    $wp_customize->add_setting( 'destination_hotel_booking_about_pro_version_logo', array(
        'sanitize_callback' => 'destination_hotel_booking_sanitize_custom_control'
    ));
    $wp_customize->add_control( new destination_hotel_booking_Customize_Pro_Version ( $wp_customize,'destination_hotel_booking_about_pro_version_logo', array(
        'section'     => 'destination_hotel_booking_second_section',
        'type'        => 'pro_options',
        'label'       => esc_html__( 'Features ', 'destination-hotel-booking' ),
        'description' => esc_url( DESTINATION_HOTEL_BOOKING_PRO_THEME_URL ),
    )));

	//footer
	$wp_customize->add_section('destination_hotel_booking_footer_section',array(
		'title'	=> __('Footer Widget Settings','destination-hotel-booking'),
		'panel' => 'destination_hotel_booking_panel_id',
		'priority' => 4,
	));
	$wp_customize->add_setting('destination_hotel_booking_footer_columns',array(
		'default'	=> 4,
		'sanitize_callback'	=> 'destination_hotel_booking_sanitize_number_absint'
	));
	$wp_customize->add_control('destination_hotel_booking_footer_columns',array(
		'label'	=> __('Footer Widget Columns','destination-hotel-booking'),
		'section'	=> 'destination_hotel_booking_footer_section',
		'setting'	=> 'destination_hotel_booking_footer_columns',
		'type'	=> 'number',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 4,
		),
	));
	$wp_customize->add_setting( 'destination_hotel_booking_tp_footer_bg_color_option', array(
		'default' => '#151515',
		'sanitize_callback' => 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'destination_hotel_booking_tp_footer_bg_color_option', array(
		'label'     => __('Footer Widget Background Color', 'destination-hotel-booking'),
		'description' => __('It will change the complete footer widget backgorund color.', 'destination-hotel-booking'),
		'section' => 'destination_hotel_booking_footer_section',
		'settings' => 'destination_hotel_booking_tp_footer_bg_color_option',
	)));

	$wp_customize->add_setting('destination_hotel_booking_footer_widget_image',array(
		'default'	=> '',
		'sanitize_callback'	=> 'esc_url_raw',
	));
	$wp_customize->add_control( new WP_Customize_Image_Control($wp_customize,'destination_hotel_booking_footer_widget_image',array(
       'label' => __('Footer Widget Background Image','destination-hotel-booking'),
       'section' => 'destination_hotel_booking_footer_section'
	)));

	//footer widget title font size
	$wp_customize->add_setting('destination_hotel_booking_footer_widget_title_font_size',array(
		'default'	=> '',
		'sanitize_callback'	=> 'destination_hotel_booking_sanitize_number_absint'
	));
	$wp_customize->add_control('destination_hotel_booking_footer_widget_title_font_size',array(
		'label'	=> __('Change Footer Widget Title Font Size in PX','destination-hotel-booking'),
		'section'	=> 'destination_hotel_booking_footer_section',
	    'setting'	=> 'destination_hotel_booking_footer_widget_title_font_size',
		'type'	=> 'number',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 0,
			'max'              => 50,
		),
	));

	$wp_customize->add_setting( 'destination_hotel_booking_footer_widget_title_color', array(
	    'default' => '',
	    'sanitize_callback' => 'sanitize_hex_color'
  	));
  	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'destination_hotel_booking_footer_widget_title_color', array(
			'label'     => __('Change Footer Widget Title Color', 'destination-hotel-booking'),
	    'section' => 'destination_hotel_booking_footer_section',
	    'settings' => 'destination_hotel_booking_footer_widget_title_color',
  	)));
  	
	$wp_customize->add_setting( 'destination_hotel_booking_return_to_header', array(
		'default'           => true,
		'transport'         => 'refresh',
		'sanitize_callback' => 'destination_hotel_booking_sanitize_checkbox',
	) );
	$wp_customize->add_control( new Destination_Hotel_Booking_Toggle_Control( $wp_customize, 'destination_hotel_booking_return_to_header', array(
		'label'       => esc_html__( 'Show / Hide Return to header', 'destination-hotel-booking' ),
		'section'     => 'destination_hotel_booking_footer_section',
		'type'        => 'toggle',
		'settings'    => 'destination_hotel_booking_return_to_header',
	) ) );

	$wp_customize->add_setting('destination_hotel_booking_return_icon',array(
		'default'	=> 'fas fa-arrow-up',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new Destination_Hotel_Booking_Icon_Changer(
       $wp_customize,'destination_hotel_booking_return_icon',array(
		'label'	=> __('Return to header Icon','destination-hotel-booking'),
		'transport' => 'refresh',
		'section'	=> 'destination_hotel_booking_footer_section',
		'type'		=> 'destination-hotel-booking-icon'
	)));

    // Add Settings and Controls for Scroll top
	$wp_customize->add_setting('destination_hotel_booking_scroll_top_position',array(
        'default' => 'Right',
        'sanitize_callback' => 'destination_hotel_booking_sanitize_choices'
	));
	$wp_customize->add_control('destination_hotel_booking_scroll_top_position',array(
        'type' => 'radio',
        'label'     => __('Scroll to top Position', 'destination-hotel-booking'),
        'description'   => __('This option work for scroll to top', 'destination-hotel-booking'),
        'section' => 'destination_hotel_booking_footer_section',
        'choices' => array(
            'Right' => __('Right','destination-hotel-booking'),
            'Left' => __('Left','destination-hotel-booking'),
            'Center' => __('Center','destination-hotel-booking')
        ),
	) );

	// Pro Version
    $wp_customize->add_setting( 'destination_hotel_booking_footer_widget_pro_version_logo', array(
        'sanitize_callback' => 'destination_hotel_booking_sanitize_custom_control'
    ));
    $wp_customize->add_control( new destination_hotel_booking_Customize_Pro_Version ( $wp_customize,'destination_hotel_booking_footer_widget_pro_version_logo', array(
        'section'     => 'destination_hotel_booking_footer_section',
        'type'        => 'pro_options',
        'label'       => esc_html__( 'Features ', 'destination-hotel-booking' ),
        'description' => esc_url( DESTINATION_HOTEL_BOOKING_PRO_THEME_URL ),
        'priority'    => 100
    )));

	//footer
	$wp_customize->add_section('destination_hotel_booking_footer_copyright_section',array(
		'title'	=> __('Footer Copyright Settings','destination-hotel-booking'),
		'description'	=> __('Add copyright text.','destination-hotel-booking'),
		'panel' => 'destination_hotel_booking_panel_id',
		'priority' => 5,
	));

	$wp_customize->add_setting('destination_hotel_booking_footer_text',array(
		'default' => __( 'Destination Hotel Booking WordPress Theme', 'destination-hotel-booking' ),
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('destination_hotel_booking_footer_text',array(
		'label'	=> __('Copyright Text','destination-hotel-booking'),
		'section'	=> 'destination_hotel_booking_footer_copyright_section',
		'type'		=> 'text'
	));

	$wp_customize->add_setting('destination_hotel_booking_footer_copyright_font_size',array(
		'default'	=> '',
		'sanitize_callback'	=> 'destination_hotel_booking_sanitize_number_absint'
	));
	$wp_customize->add_control('destination_hotel_booking_footer_copyright_font_size',array(
		'label'	=> __('Change Footer Copyright Font Size in PX','destination-hotel-booking'),
		'section'	=> 'destination_hotel_booking_footer_copyright_section',
	    'setting'	=> 'destination_hotel_booking_footer_copyright_font_size',
		'type'	=> 'number',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 0,
			'max'              => 50,
		),
	));

	$wp_customize->add_setting( 'destination_hotel_booking_footer_copyright_text_color', array(
	    'default' => '',
	    'sanitize_callback' => 'sanitize_hex_color'
  	));
  	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'destination_hotel_booking_footer_copyright_text_color', array(
			'label'     => __('Change Footer Copyright Text Color', 'destination-hotel-booking'),
	    'section' => 'destination_hotel_booking_footer_copyright_section',
	    'settings' => 'destination_hotel_booking_footer_copyright_text_color',
  	)));

  	$wp_customize->add_setting('destination_hotel_booking_footer_copyright_top_bottom_padding',array(
		'default'	=> '',
		'sanitize_callback'	=> 'destination_hotel_booking_sanitize_number_absint'
	));
	$wp_customize->add_control('destination_hotel_booking_footer_copyright_top_bottom_padding',array(
		'label'	=> __('Change Footer Copyright Padding in PX','destination-hotel-booking'),
		'section'	=> 'destination_hotel_booking_footer_copyright_section',
	    'setting'	=> 'destination_hotel_booking_footer_copyright_top_bottom_padding',
		'type'	=> 'number',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 0,
			'max'              => 50,
		),
	));

	// Add Settings and Controls for Scroll top
	$wp_customize->add_setting('destination_hotel_booking_copyright_text_position',array(
        'default' => 'Center',
        'sanitize_callback' => 'destination_hotel_booking_sanitize_choices'
	));
	$wp_customize->add_control('destination_hotel_booking_copyright_text_position',array(
        'type' => 'radio',
        'label'     => __('Copyright Text Position', 'destination-hotel-booking'),
        'description'   => __('This option work for Copyright', 'destination-hotel-booking'),
        'section' => 'destination_hotel_booking_footer_copyright_section',
        'choices' => array(
            'Right' => __('Right','destination-hotel-booking'),
            'Left' => __('Left','destination-hotel-booking'),
            'Center' => __('Center','destination-hotel-booking')
        ),
	) );

	// Pro Version
    $wp_customize->add_setting( 'destination_hotel_booking_copyright_pro_version_logo', array(
        'sanitize_callback' => 'destination_hotel_booking_sanitize_custom_control'
    ));
    $wp_customize->add_control( new destination_hotel_booking_Customize_Pro_Version ( $wp_customize,'destination_hotel_booking_copyright_pro_version_logo', array(
        'section'     => 'destination_hotel_booking_footer_copyright_section',
        'type'        => 'pro_options',
        'label'       => esc_html__( 'Features ', 'destination-hotel-booking' ),
        'description' => esc_url( DESTINATION_HOTEL_BOOKING_PRO_THEME_URL ),
        'priority'    => 100
    )));

	//Mobile resposnsive
	$wp_customize->add_section('destination_hotel_booking_mobile_media_option',array(
		'title'         => __('Mobile Responsive media', 'destination-hotel-booking'),
		'description' => __('Control will not function if the toggle in the main settings is off.', 'destination-hotel-booking'),
		'priority' => 5,
		'panel' => 'destination_hotel_booking_panel_id'
	) );

	$wp_customize->add_setting( 'destination_hotel_booking_mobile_blog_description', array(
		'default'           => true,
		'transport'         => 'refresh',
		'sanitize_callback' => 'destination_hotel_booking_sanitize_checkbox',
	) );
	$wp_customize->add_control( new Destination_Hotel_Booking_Toggle_Control( $wp_customize, 'destination_hotel_booking_mobile_blog_description', array(
		'label'       => esc_html__( 'Show / Hide Blog Page Description', 'destination-hotel-booking' ),
		'section'     => 'destination_hotel_booking_mobile_media_option',
		'type'        => 'toggle',
		'settings'    => 'destination_hotel_booking_mobile_blog_description',
	) ) );

	$wp_customize->add_setting( 'destination_hotel_booking_return_to_header_mob', array(
		'default'           => true,
		'transport'         => 'refresh',
		'sanitize_callback' => 'destination_hotel_booking_sanitize_checkbox',
	) );
	$wp_customize->add_control( new Destination_Hotel_Booking_Toggle_Control( $wp_customize, 'destination_hotel_booking_return_to_header_mob', array(
		'label'       => esc_html__( 'Show / Hide Return to header', 'destination-hotel-booking' ),
		'section'     => 'destination_hotel_booking_mobile_media_option',
		'type'        => 'toggle',
		'settings'    => 'destination_hotel_booking_return_to_header_mob',
	) ) );

	$wp_customize->add_setting( 'destination_hotel_booking_slider_buttom_mob', array(
		'default'           => true,
		'transport'         => 'refresh',
		'sanitize_callback' => 'destination_hotel_booking_sanitize_checkbox',
	) );
	$wp_customize->add_control( new Destination_Hotel_Booking_Toggle_Control( $wp_customize, 'destination_hotel_booking_slider_buttom_mob', array(
		'label'       => esc_html__( 'Show / Hide Slider Button', 'destination-hotel-booking' ),
		'section'     => 'destination_hotel_booking_mobile_media_option',
		'type'        => 'toggle',
		'settings'    => 'destination_hotel_booking_slider_buttom_mob',
	) ) );

	$wp_customize->add_setting( 'destination_hotel_booking_related_post_mob', array(
		'default'           => true,
		'transport'         => 'refresh',
		'sanitize_callback' => 'destination_hotel_booking_sanitize_checkbox',
	) );
	$wp_customize->add_control( new Destination_Hotel_Booking_Toggle_Control( $wp_customize, 'destination_hotel_booking_related_post_mob', array(
		'label'       => esc_html__( 'Show / Hide Related Post', 'destination-hotel-booking' ),
		'section'     => 'destination_hotel_booking_mobile_media_option',
		'type'        => 'toggle',
		'settings'    => 'destination_hotel_booking_related_post_mob',
	) ) );

	//Slider height
    $wp_customize->add_setting('destination_hotel_booking_slider_img_height_responsive',array(
        'default'=> '',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    $wp_customize->add_control('destination_hotel_booking_slider_img_height_responsive',array(
        'label' => __('Slider Height','destination-hotel-booking'),
        'description'   => __('Add slider height in px(eg. 700px).','destination-hotel-booking'),
        'section'=> 'destination_hotel_booking_mobile_media_option',
        'type'=> 'text'
    ));

    // Pro Version
    $wp_customize->add_setting( 'destination_hotel_booking_responsive_pro_version_logo', array(
        'sanitize_callback' => 'destination_hotel_booking_sanitize_custom_control'
    ));
    $wp_customize->add_control( new destination_hotel_booking_Customize_Pro_Version ( $wp_customize,'destination_hotel_booking_responsive_pro_version_logo', array(
        'section'     => 'destination_hotel_booking_mobile_media_option',
        'type'        => 'pro_options',
        'label'       => esc_html__( 'Features ', 'destination-hotel-booking' ),
        'description' => esc_url( DESTINATION_HOTEL_BOOKING_PRO_THEME_URL ),
        'priority'    => 100
    )));
	
	$wp_customize->get_setting( 'blogname' )->transport          = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport   = 'postMessage';

	//site Title
	$wp_customize->selective_refresh->add_partial( 'blogname', array(
		'selector' => '.site-title a',
		'render_callback' => 'Destination_Hotel_Booking_Customize_partial_blogname',
	) );

	$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
		'selector' => '.site-description',
		'render_callback' => 'Destination_Hotel_Booking_Customize_partial_blogdescription',
	) );

	$wp_customize->add_setting( 'destination_hotel_booking_site_title', array(
		'default'           => true,
		'transport'         => 'refresh',
		'sanitize_callback' => 'destination_hotel_booking_sanitize_checkbox',
	) );
	$wp_customize->add_control( new Destination_Hotel_Booking_Toggle_Control( $wp_customize, 'destination_hotel_booking_site_title', array(
		'label'       => esc_html__( 'Show / Hide Site Title', 'destination-hotel-booking' ),
		'section'     => 'title_tagline',
		'type'        => 'toggle',
		'settings'    => 'destination_hotel_booking_site_title',
	) ) );

	// logo site title size
	$wp_customize->add_setting('destination_hotel_booking_site_title_font_size',array(
		'default'	=> '',
		'sanitize_callback'	=> 'destination_hotel_booking_sanitize_number_absint'
	));
	$wp_customize->add_control('destination_hotel_booking_site_title_font_size',array(
		'label'	=> __('Site Title Font Size in PX','destination-hotel-booking'),
		'section'	=> 'title_tagline',
		'setting'	=> 'destination_hotel_booking_site_title_font_size',
		'type'	=> 'number',
		'input_attrs' => array(
		    'step'             => 1,
			'min'              => 0,
			'max'              => 30,
			),
	));

	$wp_customize->add_setting( 'destination_hotel_booking_site_tagline_color', array(
	    'default' => '',
	    'sanitize_callback' => 'sanitize_hex_color'
  	));
  	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'destination_hotel_booking_site_tagline_color', array(
			'label'     => __('Change Site Title Color', 'destination-hotel-booking'),
	    'section' => 'title_tagline',
	    'settings' => 'destination_hotel_booking_site_tagline_color',
  	)));

	$wp_customize->add_setting( 'destination_hotel_booking_site_tagline', array(
		'default'           => false,
		'transport'         => 'refresh',
		'sanitize_callback' => 'destination_hotel_booking_sanitize_checkbox',
	) );
	$wp_customize->add_control( new Destination_Hotel_Booking_Toggle_Control( $wp_customize, 'destination_hotel_booking_site_tagline', array(
		'label'       => esc_html__( 'Show / Hide Site Tagline', 'destination-hotel-booking' ),
		'section'     => 'title_tagline',
		'type'        => 'toggle',
		'settings'    => 'destination_hotel_booking_site_tagline',
	) ) );

	// logo site tagline size
	$wp_customize->add_setting('destination_hotel_booking_site_tagline_font_size',array(
		'default'	=> '',
		'sanitize_callback'	=> 'destination_hotel_booking_sanitize_number_absint'
	));
	$wp_customize->add_control('destination_hotel_booking_site_tagline_font_size',array(
		'label'	=> __('Site Tagline Font Size in PX','destination-hotel-booking'),
		'section'	=> 'title_tagline',
		'setting'	=> 'destination_hotel_booking_site_tagline_font_size',
		'type'	=> 'number',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 0,
			'max'              => 30,
		),
	));

	$wp_customize->add_setting( 'destination_hotel_booking_logo_tagline_color', array(
	    'default' => '',
	    'sanitize_callback' => 'sanitize_hex_color'
  	));
  	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'destination_hotel_booking_logo_tagline_color', array(
			'label'     => __('Change Site Tagline Color', 'destination-hotel-booking'),
	    'section' => 'title_tagline',
	    'settings' => 'destination_hotel_booking_logo_tagline_color',
  	)));

    $wp_customize->add_setting('destination_hotel_booking_logo_width',array(
	   'default' => 80,
	   'sanitize_callback'	=> 'destination_hotel_booking_sanitize_number_absint'
	));
	$wp_customize->add_control('destination_hotel_booking_logo_width',array(
		'label'	=> esc_html__('Here You Can Customize Your Logo Size','destination-hotel-booking'),
		'section'	=> 'title_tagline',
		'type'		=> 'number'
	));

	$wp_customize->add_setting('destination_hotel_booking_per_columns',array(
		'default'=> 3,
		'sanitize_callback'	=> 'destination_hotel_booking_sanitize_number_absint'
	));
	$wp_customize->add_control('destination_hotel_booking_per_columns',array(
		'label'	=> __('Product Per Row','destination-hotel-booking'),
		'section'=> 'woocommerce_product_catalog',
		'type'=> 'number'
	));

	$wp_customize->add_setting('destination_hotel_booking_product_per_page',array(
		'default'=> 9,
		'sanitize_callback'	=> 'destination_hotel_booking_sanitize_number_absint'
	));
	$wp_customize->add_control('destination_hotel_booking_product_per_page',array(
		'label'	=> __('Product Per Page','destination-hotel-booking'),
		'section'=> 'woocommerce_product_catalog',
		'type'=> 'number'
	));

	$wp_customize->add_setting( 'destination_hotel_booking_product_sidebar', array(
		'default'           => true,
		'transport'         => 'refresh',
		'sanitize_callback' => 'destination_hotel_booking_sanitize_checkbox',
	) );
	$wp_customize->add_control( new Destination_Hotel_Booking_Toggle_Control( $wp_customize, 'destination_hotel_booking_product_sidebar', array(
		'label'       => esc_html__( 'Show / Hide Shop Page Sidebar', 'destination-hotel-booking' ),
		'section'     => 'woocommerce_product_catalog',
		'type'        => 'toggle',
		'settings'    => 'destination_hotel_booking_product_sidebar',
	) ) );
	$wp_customize->add_setting('destination_hotel_booking_sale_tag_position',array(
        'default' => 'right',
        'sanitize_callback' => 'destination_hotel_booking_sanitize_choices'
	));
	$wp_customize->add_control('destination_hotel_booking_sale_tag_position',array(
        'type' => 'radio',
        'label'     => __('Sale Badge Position', 'destination-hotel-booking'),
        'description'   => __('This option work for Archieve Products', 'destination-hotel-booking'),
        'section' => 'woocommerce_product_catalog',
        'choices' => array(
            'left' => __('Left','destination-hotel-booking'),
            'right' => __('Right','destination-hotel-booking'),
        ),
	) );
	$wp_customize->add_setting( 'destination_hotel_booking_single_product_sidebar', array(
		'default'           => true,
		'transport'         => 'refresh',
		'sanitize_callback' => 'destination_hotel_booking_sanitize_checkbox',
	) );
	$wp_customize->add_control( new Destination_Hotel_Booking_Toggle_Control( $wp_customize, 'destination_hotel_booking_single_product_sidebar', array(
		'label'       => esc_html__( 'Show / Hide Product Page Sidebar', 'destination-hotel-booking' ),
		'section'     => 'woocommerce_product_catalog',
		'type'        => 'toggle',
		'settings'    => 'destination_hotel_booking_single_product_sidebar',
	) ) );

	$wp_customize->add_setting( 'destination_hotel_booking_related_product', array(
		'default'           => true,
		'transport'         => 'refresh',
		'sanitize_callback' => 'destination_hotel_booking_sanitize_checkbox',
	) );
	$wp_customize->add_control( new Destination_Hotel_Booking_Toggle_Control( $wp_customize, 'destination_hotel_booking_related_product', array(
		'label'       => esc_html__( 'Show / Hide related product', 'destination-hotel-booking' ),
		'section'     => 'woocommerce_product_catalog',
		'type'        => 'toggle',
		'settings'    => 'destination_hotel_booking_related_product',
	) ) );

	
	//Page template settings
	$wp_customize->add_panel( 'destination_hotel_booking_page_panel_id', array(
	    'priority' => 10,
	    'capability' => 'edit_theme_options',
	    'theme_supports' => '',
	    'title' => __( 'Page Template Settings', 'destination-hotel-booking' ),
	    'description' => __( 'Description of what this panel does.', 'destination-hotel-booking' ),
	) );

	// 404 PAGE
	$wp_customize->add_section('destination_hotel_booking_404_page_section',array(
		'title'         => __('404 Page', 'destination-hotel-booking'),
		'description'   => __('Here you can customize 404 Page content.', 'destination-hotel-booking'),
		'panel' => 'destination_hotel_booking_page_panel_id'
	) );

	$wp_customize->add_setting('destination_hotel_booking_edit_404_title',array(
		'default'=> __('Oops! That page cant be found.','destination-hotel-booking'),
		'sanitize_callback'	=> 'sanitize_text_field',
	));
	$wp_customize->add_control('destination_hotel_booking_edit_404_title',array(
		'label'	=> __('Edit Title','destination-hotel-booking'),
		'section'=> 'destination_hotel_booking_404_page_section',
		'type'=> 'text',
	));

	$wp_customize->add_setting('destination_hotel_booking_edit_404_text',array(
		'default'=> __('It looks like nothing was found at this location. Maybe try a search?','destination-hotel-booking'),
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('destination_hotel_booking_edit_404_text',array(
		'label'	=> __('Edit Text','destination-hotel-booking'),
		'section'=> 'destination_hotel_booking_404_page_section',
		'type'=> 'text'
	));

	// Search Results
	$wp_customize->add_section('destination_hotel_booking_no_result_section',array(
		'title'         => __('Search Results', 'destination-hotel-booking'),
		'description'  => __('Here you can customize Search Result content.', 'destination-hotel-booking'),
		'panel' => 'destination_hotel_booking_page_panel_id'
	) );

	$wp_customize->add_setting('destination_hotel_booking_edit_no_result_title',array(
		'default'=> __('Nothing Found','destination-hotel-booking'),
		'sanitize_callback'	=> 'sanitize_text_field',
	));
	$wp_customize->add_control('destination_hotel_booking_edit_no_result_title',array(
		'label'	=> __('Edit Title','destination-hotel-booking'),
		'section'=> 'destination_hotel_booking_no_result_section',
		'type'=> 'text',
	));

	$wp_customize->add_setting('destination_hotel_booking_edit_no_result_text',array(
		'default'=> __('Sorry, but nothing matched your search terms. Please try again with some different keywords.','destination-hotel-booking'),
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('destination_hotel_booking_edit_no_result_text',array(
		'label'	=> __('Edit Text','destination-hotel-booking'),
		'section'=> 'destination_hotel_booking_no_result_section',
		'type'=> 'text'
	));

	 // Header Image Height
    $wp_customize->add_setting(
        'destination_hotel_booking_header_image_height',
        array(
            'default'           => 500,
            'sanitize_callback' => 'absint',
        )
    );
    $wp_customize->add_control(
        'destination_hotel_booking_header_image_height',
        array(
            'label'       => esc_html__( 'Header Image Height', 'destination-hotel-booking' ),
            'section'     => 'header_image',
            'type'        => 'number',
            'description' => esc_html__( 'Control the height of the header image. Default is 350px.', 'destination-hotel-booking' ),
            'input_attrs' => array(
                'min'  => 220,
                'max'  => 1000,
                'step' => 1,
            ),
        )
    );

    // Header Background Position
    $wp_customize->add_setting(
        'destination_hotel_booking_header_background_position',
        array(
            'default'           => 'center',
            'sanitize_callback' => 'sanitize_text_field',
        )
    );
    $wp_customize->add_control(
        'destination_hotel_booking_header_background_position',
        array(
            'label'       => esc_html__( 'Header Background Position', 'destination-hotel-booking' ),
            'section'     => 'header_image',
            'type'        => 'select',
            'choices'     => array(
                'top'    => esc_html__( 'Top', 'destination-hotel-booking' ),
                'center' => esc_html__( 'Center', 'destination-hotel-booking' ),
                'bottom' => esc_html__( 'Bottom', 'destination-hotel-booking' ),
            ),
            'description' => esc_html__( 'Choose how you want to position the header image.', 'destination-hotel-booking' ),
        )
    );

    // Header Image Parallax Effect
    $wp_customize->add_setting(
        'destination_hotel_booking_header_background_attachment',
        array(
            'default'           => 1,
            'sanitize_callback' => 'absint',
        )
    );
    $wp_customize->add_control(
        'destination_hotel_booking_header_background_attachment',
        array(
            'label'       => esc_html__( 'Header Image Parallax', 'destination-hotel-booking' ),
            'section'     => 'header_image',
            'type'        => 'checkbox',
            'description' => esc_html__( 'Add a parallax effect on page scroll.', 'destination-hotel-booking' ),
        )
    );

        //Opacity
	$wp_customize->add_setting('destination_hotel_booking_header_banner_opacity_color',array(
       'default'              => '0.5',
       'sanitize_callback' => 'destination_hotel_booking_sanitize_choices'
	));
    $wp_customize->add_control( 'destination_hotel_booking_header_banner_opacity_color', array(
		'label'       => esc_html__( 'Header Image Opacity','destination-hotel-booking' ),
		'section'     => 'header_image',
		'type'        => 'select',
		'settings'    => 'destination_hotel_booking_header_banner_opacity_color',
		'choices' => array(
           '0' =>  esc_attr(__('0','destination-hotel-booking')),
           '0.1' =>  esc_attr(__('0.1','destination-hotel-booking')),
           '0.2' =>  esc_attr(__('0.2','destination-hotel-booking')),
           '0.3' =>  esc_attr(__('0.3','destination-hotel-booking')),
           '0.4' =>  esc_attr(__('0.4','destination-hotel-booking')),
           '0.5' =>  esc_attr(__('0.5','destination-hotel-booking')),
           '0.6' =>  esc_attr(__('0.6','destination-hotel-booking')),
           '0.7' =>  esc_attr(__('0.7','destination-hotel-booking')),
           '0.8' =>  esc_attr(__('0.8','destination-hotel-booking')),
           '0.9' =>  esc_attr(__('0.9','destination-hotel-booking'))
		), 
	) );

   $wp_customize->add_setting( 'destination_hotel_booking_header_banner_image_overlay', array(
	    'default'   => true,
	    'transport' => 'refresh',
	    'sanitize_callback' => 'destination_hotel_booking_sanitize_checkbox',
	));
	$wp_customize->add_control( new Destination_Hotel_Booking_Toggle_Control( $wp_customize, 'destination_hotel_booking_header_banner_image_overlay', array(
	    'label'   => esc_html__( 'Show / Hide Header Image Overlay', 'destination-hotel-booking' ),
	    'section' => 'header_image',
	)));

    $wp_customize->add_setting('destination_hotel_booking_header_banner_image_ooverlay_color', array(
		'default'           => '#000',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'destination_hotel_booking_header_banner_image_ooverlay_color', array(
		'label'    => __('Header Image Overlay Color', 'destination-hotel-booking'),
		'section'  => 'header_image',
	)));

    $wp_customize->add_setting(
        'destination_hotel_booking_header_image_title_font_size',
        array(
            'default'           => 40,
            'sanitize_callback' => 'absint',
        )
    );
    $wp_customize->add_control(
        'destination_hotel_booking_header_image_title_font_size',
        array(
            'label'       => esc_html__( 'Change Header Image Title Font Size', 'destination-hotel-booking' ),
            'section'     => 'header_image',
            'type'        => 'number',
            'description' => esc_html__( 'Control the font Size of the header image title. Default is 40px.', 'destination-hotel-booking' ),
            'input_attrs' => array(
                'min'  => 10,
                'max'  => 200,
                'step' => 1,
            ),
        )
    );

	$wp_customize->add_setting( 'destination_hotel_booking_header_image_title_text_color', array(
	    'default' => '',
	    'sanitize_callback' => 'sanitize_hex_color'
  	));
  	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'destination_hotel_booking_header_image_title_text_color', array(
			'label'     => __('Change Header Image Title Color', 'destination-hotel-booking'),
	    'section' => 'header_image',
	    'settings' => 'destination_hotel_booking_header_image_title_text_color',
  	)));

}
add_action( 'customize_register', 'Destination_Hotel_Booking_Customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @since Destination Hotel Booking 1.0
 * @see Destination_Hotel_Booking_Customize_register()
 *
 * @return void
 */
function Destination_Hotel_Booking_Customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @since Destination Hotel Booking 1.0
 * @see Destination_Hotel_Booking_Customize_register()
 *
 * @return void
 */
function Destination_Hotel_Booking_Customize_partial_blogdescription() {
	bloginfo( 'description' );
}

if ( ! defined( 'DESTINATION_HOTEL_BOOKING_PRO_THEME_NAME' ) ) {
	define( 'DESTINATION_HOTEL_BOOKING_PRO_THEME_NAME', esc_html__( 'Hotel Booking Pro', 'destination-hotel-booking'));
}
if ( ! defined( 'DESTINATION_HOTEL_BOOKING_PRO_THEME_URL' ) ) {
	define( 'DESTINATION_HOTEL_BOOKING_PRO_THEME_URL', esc_url('https://www.themespride.com/products/hotel-wordpress-theme', 'destination-hotel-booking'));
}


if ( ! defined( 'DESTINATION_HOTEL_BOOKING_DOCS_URL' ) ) {
	define( 'DESTINATION_HOTEL_BOOKING_DOCS_URL', esc_url('https://page.themespride.com/demo/docs/destination-hotel-booking-lite/'));
}
if ( ! defined( 'DESTINATION_HOTEL_BOOKING_TEXT' ) ) {
    define( 'DESTINATION_HOTEL_BOOKING_TEXT', __( 'Destination Hotel Booking Pro','destination-hotel-booking' ));
}
if ( ! defined( 'DESTINATION_HOTEL_BOOKING_BUY_TEXT' ) ) {
    define( 'DESTINATION_HOTEL_BOOKING_BUY_TEXT', __( 'Upgrade Pro','destination-hotel-booking' ));
}

add_action( 'customize_register', function( $manager ) {

// Load custom sections.
load_template( trailingslashit( get_template_directory() ) . '/inc/section-pro.php' );

    $manager->register_section_type( destination_hotel_booking_Button::class );

    $manager->add_section(
        new destination_hotel_booking_Button( $manager, 'destination_hotel_booking_pro', [
            'title'       => esc_html( DESTINATION_HOTEL_BOOKING_TEXT,'destination-hotel-booking' ),
            'priority'    => 0,
            'button_text' => __( 'GET PREMIUM', 'destination-hotel-booking' ),
            'button_url'  => esc_url( DESTINATION_HOTEL_BOOKING_PRO_THEME_URL )
        ] )
    );

    // Register sections.
	$manager->add_section(
		new destination_hotel_booking_Customize_Section_Pro(
			$manager,
			'destination_hotel_booking_documentation',
			array(
				'priority'   => 500,
				'title'    => esc_html__( 'Theme Documentation', 'destination-hotel-booking' ),
				'pro_text' => esc_html__( 'Click Here', 'destination-hotel-booking' ),
				'pro_url'  => esc_url( DESTINATION_HOTEL_BOOKING_DOCS_URL, 'destination-hotel-booking'),
			)
		)
	);

} );

/**
 * Singleton class for handling the theme's customizer integration.
 *
 * @since  1.0.0
 * @access public
 */
final class Destination_Hotel_Booking_Customize {

	/**
	 * Returns the instance.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return object
	 */
	public static function get_instance() {

		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new self;
			$instance->setup_actions();
		}

		return $instance;
	}

	/**
	 * Constructor method.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function __construct() {}

	/**
	 * Sets up initial actions.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function setup_actions() {

		// Register panels, sections, settings, controls, and partials.
		add_action( 'customize_register', array( $this, 'sections' ) );

		// Register scripts and styles for the controls.
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue_control_scripts' ), 0 );
	}

	/**
	 * Sets up the customizer sections.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  object  $manager
	 * @return void
	 */
	public function sections( $manager ) {

		// Load custom sections.
		load_template( trailingslashit( get_template_directory() ) . '/inc/section-pro.php' );

		// Register custom section types.
		$manager->register_section_type( 'Destination_Hotel_Booking_Customize_Section_Pro' );

		// Register sections.
		$manager->add_section(
			new Destination_Hotel_Booking_Customize_Section_Pro(
				$manager,
				'destination_hotel_booking_section_pro',
				array(
					'priority'   => 9,
					'title'    => DESTINATION_HOTEL_BOOKING_PRO_THEME_NAME,
					'pro_text' => esc_html__( 'Upgrade Pro', 'destination-hotel-booking' ),
					'pro_url'  => esc_url( DESTINATION_HOTEL_BOOKING_PRO_THEME_URL, 'destination-hotel-booking' ),
				)
			)
		);

	}
	/**
	 * Loads theme customizer CSS.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function enqueue_control_scripts() {

		wp_enqueue_script( 'destination-hotel-booking-customize-controls', trailingslashit( esc_url( get_template_directory_uri() ) ) . '/assets/js/customize-controls.js', array( 'customize-controls' ) );

		wp_enqueue_style( 'destination-hotel-booking-customize-controls', trailingslashit( esc_url( get_template_directory_uri() ) ) . '/assets/css/customize-controls.css' );
	}
}

// Doing this customizer thang!
Destination_Hotel_Booking_Customize::get_instance();