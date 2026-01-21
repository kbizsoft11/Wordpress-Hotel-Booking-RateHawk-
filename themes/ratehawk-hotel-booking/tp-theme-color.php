<?php
	
	$destination_hotel_booking_tp_theme_css = '';

	// 1st color
	$destination_hotel_booking_tp_color_option_first = get_theme_mod('destination_hotel_booking_tp_color_option_first', '#FBB191');
	if ($destination_hotel_booking_tp_color_option_first) {
		$destination_hotel_booking_tp_theme_css .= ':root {';
		$destination_hotel_booking_tp_theme_css .= '--color-primary1: ' . esc_attr($destination_hotel_booking_tp_color_option_first) . ';';
		$destination_hotel_booking_tp_theme_css .= '}';
	}

	// preloader
	$destination_hotel_booking_tp_preloader_color1_option = get_theme_mod('destination_hotel_booking_tp_preloader_color1_option');
	if($destination_hotel_booking_tp_preloader_color1_option != false){
	$destination_hotel_booking_tp_theme_css .='.center1{';
		$destination_hotel_booking_tp_theme_css .='border-color: '.esc_attr($destination_hotel_booking_tp_preloader_color1_option).' !important;';
	$destination_hotel_booking_tp_theme_css .='}';
	}
	if($destination_hotel_booking_tp_preloader_color1_option != false){
	$destination_hotel_booking_tp_theme_css .='.center1 .ring::before{';
		$destination_hotel_booking_tp_theme_css .='background: '.esc_attr($destination_hotel_booking_tp_preloader_color1_option).' !important;';
	$destination_hotel_booking_tp_theme_css .='}';
	}

	$destination_hotel_booking_tp_preloader_color2_option = get_theme_mod('destination_hotel_booking_tp_preloader_color2_option');

	if($destination_hotel_booking_tp_preloader_color2_option != false){
	$destination_hotel_booking_tp_theme_css .='.center2{';
		$destination_hotel_booking_tp_theme_css .='border-color: '.esc_attr($destination_hotel_booking_tp_preloader_color2_option).' !important;';
	$destination_hotel_booking_tp_theme_css .='}';
	}
	if($destination_hotel_booking_tp_preloader_color2_option != false){
	$destination_hotel_booking_tp_theme_css .='.center2 .ring::before{';
		$destination_hotel_booking_tp_theme_css .='background: '.esc_attr($destination_hotel_booking_tp_preloader_color2_option).' !important;';
	$destination_hotel_booking_tp_theme_css .='}';
	}

	$destination_hotel_booking_tp_preloader_bg_color_option = get_theme_mod('destination_hotel_booking_tp_preloader_bg_color_option');

	if($destination_hotel_booking_tp_preloader_bg_color_option != false){
	$destination_hotel_booking_tp_theme_css .='.loader{';
		$destination_hotel_booking_tp_theme_css .='background: '.esc_attr($destination_hotel_booking_tp_preloader_bg_color_option).';';
	$destination_hotel_booking_tp_theme_css .='}';
	}

	$destination_hotel_booking_tp_footer_bg_color_option = get_theme_mod('destination_hotel_booking_tp_footer_bg_color_option');


	if($destination_hotel_booking_tp_footer_bg_color_option != false){
	$destination_hotel_booking_tp_theme_css .='#footer{';
		$destination_hotel_booking_tp_theme_css .='background: '.esc_attr($destination_hotel_booking_tp_footer_bg_color_option).';';
	$destination_hotel_booking_tp_theme_css .='}';
	}

	// logo tagline color
	$destination_hotel_booking_site_tagline_color = get_theme_mod('destination_hotel_booking_site_tagline_color');

	if($destination_hotel_booking_site_tagline_color != false){
	$destination_hotel_booking_tp_theme_css .='.logo h1 a, .logo p a, .logo p.site-title a{';
	$destination_hotel_booking_tp_theme_css .='color: '.esc_attr($destination_hotel_booking_site_tagline_color).';';
	$destination_hotel_booking_tp_theme_css .='}';
	}

	$destination_hotel_booking_logo_tagline_color = get_theme_mod('destination_hotel_booking_logo_tagline_color');
	if($destination_hotel_booking_logo_tagline_color != false){
	$destination_hotel_booking_tp_theme_css .='p.site-description{';
	$destination_hotel_booking_tp_theme_css .='color: '.esc_attr($destination_hotel_booking_logo_tagline_color).';';
	$destination_hotel_booking_tp_theme_css .='}';
	}

	// footer widget title color
	$destination_hotel_booking_footer_widget_title_color = get_theme_mod('destination_hotel_booking_footer_widget_title_color');
	if($destination_hotel_booking_footer_widget_title_color != false){
	$destination_hotel_booking_tp_theme_css .='#footer h3, #footer h2.wp-block-heading{';
	$destination_hotel_booking_tp_theme_css .='color: '.esc_attr($destination_hotel_booking_footer_widget_title_color).';';
	$destination_hotel_booking_tp_theme_css .='}';
	}

	// copyright text color
	$destination_hotel_booking_footer_copyright_text_color = get_theme_mod('destination_hotel_booking_footer_copyright_text_color');
	if($destination_hotel_booking_footer_copyright_text_color != false){
	$destination_hotel_booking_tp_theme_css .='#footer .site-info p, #footer .site-info a {';
	$destination_hotel_booking_tp_theme_css .='color: '.esc_attr($destination_hotel_booking_footer_copyright_text_color).'!important;';
	$destination_hotel_booking_tp_theme_css .='}';
	}

	// header image title color
	$destination_hotel_booking_header_image_title_text_color = get_theme_mod('destination_hotel_booking_header_image_title_text_color');
	if($destination_hotel_booking_header_image_title_text_color != false){
	$destination_hotel_booking_tp_theme_css .='.box-text h2{';
	$destination_hotel_booking_tp_theme_css .='color: '.esc_attr($destination_hotel_booking_header_image_title_text_color).';';
	$destination_hotel_booking_tp_theme_css .='}';
	}

	// menu color
	$destination_hotel_booking_menu_color = get_theme_mod('destination_hotel_booking_menu_color');
	if($destination_hotel_booking_menu_color != false){
	$destination_hotel_booking_tp_theme_css .='.main-navigation a{';
	$destination_hotel_booking_tp_theme_css .='color: '.esc_attr($destination_hotel_booking_menu_color).';';
	$destination_hotel_booking_tp_theme_css .='}';
}