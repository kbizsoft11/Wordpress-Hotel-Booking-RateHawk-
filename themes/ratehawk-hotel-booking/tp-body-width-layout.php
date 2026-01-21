<?php

$destination_hotel_booking_tp_theme_css = '';

$destination_hotel_booking_theme_lay = get_theme_mod( 'destination_hotel_booking_tp_body_layout_settings','Full');
if($destination_hotel_booking_theme_lay == 'Container'){
$destination_hotel_booking_tp_theme_css .='body{';
$destination_hotel_booking_tp_theme_css .='max-width: 1140px; width: 100%; padding-right: 15px; padding-left: 15px; margin-right: auto; margin-left: auto;';
$destination_hotel_booking_tp_theme_css .='}';
$destination_hotel_booking_tp_theme_css .='@media screen and (max-width:575px){';
$destination_hotel_booking_tp_theme_css .='body{';
	$destination_hotel_booking_tp_theme_css .='max-width: 100%; padding-right:0px; padding-left: 0px';
$destination_hotel_booking_tp_theme_css .='} }';
$destination_hotel_booking_tp_theme_css .='.scrolled{';
$destination_hotel_booking_tp_theme_css .='width: auto; left:0; right:0;';
$destination_hotel_booking_tp_theme_css .='}';
}else if($destination_hotel_booking_theme_lay == 'Container Fluid'){
$destination_hotel_booking_tp_theme_css .='body{';
$destination_hotel_booking_tp_theme_css .='width: 100%;padding-right: 15px;padding-left: 15px;margin-right: auto;margin-left: auto;';
$destination_hotel_booking_tp_theme_css .='}';
$destination_hotel_booking_tp_theme_css .='@media screen and (max-width:575px){';
$destination_hotel_booking_tp_theme_css .='body{';
	$destination_hotel_booking_tp_theme_css .='max-width: 100%; padding-right:0px; padding-left:0px';
$destination_hotel_booking_tp_theme_css .='} }';
$destination_hotel_booking_tp_theme_css .='.scrolled{';
$destination_hotel_booking_tp_theme_css .='width: auto; left:0; right:0;';
$destination_hotel_booking_tp_theme_css .='}';
}else if($destination_hotel_booking_theme_lay == 'Full'){
$destination_hotel_booking_tp_theme_css .='body{';
$destination_hotel_booking_tp_theme_css .='max-width: 100%;';
$destination_hotel_booking_tp_theme_css .='}';
}

$destination_hotel_booking_scroll_position = get_theme_mod( 'destination_hotel_booking_scroll_top_position','Right');
if($destination_hotel_booking_scroll_position == 'Right'){
$destination_hotel_booking_tp_theme_css .='#return-to-top{';
$destination_hotel_booking_tp_theme_css .='right: 20px;';
$destination_hotel_booking_tp_theme_css .='}';
}else if($destination_hotel_booking_scroll_position == 'Left'){
$destination_hotel_booking_tp_theme_css .='#return-to-top{';
$destination_hotel_booking_tp_theme_css .='left: 20px;';
$destination_hotel_booking_tp_theme_css .='}';
}else if($destination_hotel_booking_scroll_position == 'Center'){
$destination_hotel_booking_tp_theme_css .='#return-to-top{';
$destination_hotel_booking_tp_theme_css .='right: 50%;left: 50%;';
$destination_hotel_booking_tp_theme_css .='}';
}

// related post
$destination_hotel_booking_related_post_mob = get_theme_mod('destination_hotel_booking_related_post_mob', true);
$destination_hotel_booking_related_post = get_theme_mod('destination_hotel_booking_remove_related_post', true);
$destination_hotel_booking_tp_theme_css .= '.related-post-block {';
if ($destination_hotel_booking_related_post == false) {
    $destination_hotel_booking_tp_theme_css .= 'display: none;';
}
$destination_hotel_booking_tp_theme_css .= '}';
$destination_hotel_booking_tp_theme_css .= '@media screen and (max-width: 575px) {';
if ($destination_hotel_booking_related_post == false || $destination_hotel_booking_related_post_mob == false) {
    $destination_hotel_booking_tp_theme_css .= '.related-post-block { display: none; }';
}
$destination_hotel_booking_tp_theme_css .= '}';

// slider btn
$destination_hotel_booking_slider_buttom_mob = get_theme_mod('destination_hotel_booking_slider_buttom_mob', true);
$destination_hotel_booking_slider_button = get_theme_mod('destination_hotel_booking_slider_button', true);
$destination_hotel_booking_tp_theme_css .= '#main-slider .more-btn {';
if ($destination_hotel_booking_slider_button == false) {
    $destination_hotel_booking_tp_theme_css .= 'display: none;';
}
$destination_hotel_booking_tp_theme_css .= '}';
$destination_hotel_booking_tp_theme_css .= '@media screen and (max-width: 575px) {';
if ($destination_hotel_booking_slider_button == false || $destination_hotel_booking_slider_buttom_mob == false) {
    $destination_hotel_booking_tp_theme_css .= '#main-slider .more-btn { display: none; }';
}
$destination_hotel_booking_tp_theme_css .= '}';

//return to header mobile               
$destination_hotel_booking_return_to_header_mob = get_theme_mod('destination_hotel_booking_return_to_header_mob', true);
$destination_hotel_booking_return_to_header = get_theme_mod('destination_hotel_booking_return_to_header', true);
$destination_hotel_booking_tp_theme_css .= '.return-to-header{';
if ($destination_hotel_booking_return_to_header == false) {
    $destination_hotel_booking_tp_theme_css .= 'display: none;';
}
$destination_hotel_booking_tp_theme_css .= '}';
$destination_hotel_booking_tp_theme_css .= '@media screen and (max-width: 575px) {';
if ($destination_hotel_booking_return_to_header == false || $destination_hotel_booking_return_to_header_mob == false) {
    $destination_hotel_booking_tp_theme_css .= '.return-to-header{ display: none; }';
}
$destination_hotel_booking_tp_theme_css .= '}';

//blog description              
$destination_hotel_booking_mobile_blog_description = get_theme_mod('destination_hotel_booking_mobile_blog_description', true);
$destination_hotel_booking_tp_theme_css .= '@media screen and (max-width: 575px) {';
if ($destination_hotel_booking_mobile_blog_description == false) {
    $destination_hotel_booking_tp_theme_css .= '.blog-description{ display: none; }';
}
$destination_hotel_booking_tp_theme_css .= '}';


$destination_hotel_booking_footer_widget_image = get_theme_mod('destination_hotel_booking_footer_widget_image');
if($destination_hotel_booking_footer_widget_image != false){
$destination_hotel_booking_tp_theme_css .='#footer{';
$destination_hotel_booking_tp_theme_css .='background: url('.esc_attr($destination_hotel_booking_footer_widget_image).');';
$destination_hotel_booking_tp_theme_css .='}';
}

//Social icon Font size
$destination_hotel_booking_social_icon_fontsize = get_theme_mod('destination_hotel_booking_social_icon_fontsize');
$destination_hotel_booking_tp_theme_css .='.social-media a i{';
$destination_hotel_booking_tp_theme_css .='font-size: '.esc_attr($destination_hotel_booking_social_icon_fontsize).'px;';
$destination_hotel_booking_tp_theme_css .='}';

// site title and tagline font size option
$destination_hotel_booking_site_title_font_size = get_theme_mod('destination_hotel_booking_site_title_font_size', ''); {
$destination_hotel_booking_tp_theme_css .='.logo h1 a, .logo p a{';
$destination_hotel_booking_tp_theme_css .='font-size: '.esc_attr($destination_hotel_booking_site_title_font_size).'px !important;';
$destination_hotel_booking_tp_theme_css .='}';
}

$destination_hotel_booking_site_tagline_font_size = get_theme_mod('destination_hotel_booking_site_tagline_font_size', '');{
$destination_hotel_booking_tp_theme_css .='.logo p{';
$destination_hotel_booking_tp_theme_css .='font-size: '.esc_attr($destination_hotel_booking_site_tagline_font_size).'px;';
$destination_hotel_booking_tp_theme_css .='}';
}

$destination_hotel_booking_related_product = get_theme_mod('destination_hotel_booking_related_product',true);
if($destination_hotel_booking_related_product == false){
$destination_hotel_booking_tp_theme_css .='.related.products{';
	$destination_hotel_booking_tp_theme_css .='display: none;';
$destination_hotel_booking_tp_theme_css .='}';
}

//menu font size
$destination_hotel_booking_menu_font_size = get_theme_mod('destination_hotel_booking_menu_font_size', '');{
$destination_hotel_booking_tp_theme_css .='.main-navigation a, .main-navigation li.page_item_has_children:after, .main-navigation li.menu-item-has-children:after{';
	$destination_hotel_booking_tp_theme_css .='font-size: '.esc_attr($destination_hotel_booking_menu_font_size).'px;';
$destination_hotel_booking_tp_theme_css .='}';
}

// menu text transform
$destination_hotel_booking_menu_text_tranform = get_theme_mod( 'destination_hotel_booking_menu_text_tranform','');
if($destination_hotel_booking_menu_text_tranform == 'Uppercase'){
$destination_hotel_booking_tp_theme_css .='.main-navigation a {';
	$destination_hotel_booking_tp_theme_css .='text-transform: uppercase;';
$destination_hotel_booking_tp_theme_css .='}';
}else if($destination_hotel_booking_menu_text_tranform == 'Lowercase'){
$destination_hotel_booking_tp_theme_css .='.main-navigation a {';
	$destination_hotel_booking_tp_theme_css .='text-transform: lowercase;';
$destination_hotel_booking_tp_theme_css .='}';
}
else if($destination_hotel_booking_menu_text_tranform == 'Capitalize'){
$destination_hotel_booking_tp_theme_css .='.main-navigation a {';
	$destination_hotel_booking_tp_theme_css .='text-transform: capitalize;';
$destination_hotel_booking_tp_theme_css .='}';
}

//sale position
$destination_hotel_booking_scroll_position = get_theme_mod( 'destination_hotel_booking_sale_tag_position','right');
if($destination_hotel_booking_scroll_position == 'right'){
$destination_hotel_booking_tp_theme_css .='.woocommerce ul.products li.product .onsale{';
    $destination_hotel_booking_tp_theme_css .='right: 25px !important;';
$destination_hotel_booking_tp_theme_css .='}';
}else if($destination_hotel_booking_scroll_position == 'left'){
$destination_hotel_booking_tp_theme_css .='.woocommerce ul.products li.product .onsale{';
    $destination_hotel_booking_tp_theme_css .='left: 25px !important; right: auto !important;';
$destination_hotel_booking_tp_theme_css .='}';
}

//Font Weight
$destination_hotel_booking_menu_font_weight = get_theme_mod( 'destination_hotel_booking_menu_font_weight','');
if($destination_hotel_booking_menu_font_weight == '100'){
$destination_hotel_booking_tp_theme_css .='.main-navigation a{';
    $destination_hotel_booking_tp_theme_css .='font-weight: 100;';
$destination_hotel_booking_tp_theme_css .='}';
}else if($destination_hotel_booking_menu_font_weight == '200'){
$destination_hotel_booking_tp_theme_css .='.main-navigation a{';
    $destination_hotel_booking_tp_theme_css .='font-weight: 200;';
$destination_hotel_booking_tp_theme_css .='}';
}else if($destination_hotel_booking_menu_font_weight == '300'){
$destination_hotel_booking_tp_theme_css .='.main-navigation a{';
    $destination_hotel_booking_tp_theme_css .='font-weight: 300;';
$destination_hotel_booking_tp_theme_css .='}';
}else if($destination_hotel_booking_menu_font_weight == '400'){
$destination_hotel_booking_tp_theme_css .='.main-navigation a{';
    $destination_hotel_booking_tp_theme_css .='font-weight: 400;';
$destination_hotel_booking_tp_theme_css .='}';
}else if($destination_hotel_booking_menu_font_weight == '500'){
$destination_hotel_booking_tp_theme_css .='.main-navigation a{';
    $destination_hotel_booking_tp_theme_css .='font-weight: 500;';
$destination_hotel_booking_tp_theme_css .='}';
}else if($destination_hotel_booking_menu_font_weight == '600'){
$destination_hotel_booking_tp_theme_css .='.main-navigation a{';
    $destination_hotel_booking_tp_theme_css .='font-weight: 600;';
$destination_hotel_booking_tp_theme_css .='}';
}else if($destination_hotel_booking_menu_font_weight == '700'){
$destination_hotel_booking_tp_theme_css .='.main-navigation a{';
    $destination_hotel_booking_tp_theme_css .='font-weight: 700;';
$destination_hotel_booking_tp_theme_css .='}';
}else if($destination_hotel_booking_menu_font_weight == '800'){
$destination_hotel_booking_tp_theme_css .='.main-navigation a{';
    $destination_hotel_booking_tp_theme_css .='font-weight: 800;';
$destination_hotel_booking_tp_theme_css .='}';
}else if($destination_hotel_booking_menu_font_weight == '900'){
$destination_hotel_booking_tp_theme_css .='.main-navigation a{';
    $destination_hotel_booking_tp_theme_css .='font-weight: 900;';
$destination_hotel_booking_tp_theme_css .='}';
}

/*------------- Blog Page------------------*/
$destination_hotel_booking_post_image_round = get_theme_mod('destination_hotel_booking_post_image_round', 0);
if($destination_hotel_booking_post_image_round != false){
    $destination_hotel_booking_tp_theme_css .='.blog .box-image img{';
        $destination_hotel_booking_tp_theme_css .='border-radius: '.esc_attr($destination_hotel_booking_post_image_round).'px;';
    $destination_hotel_booking_tp_theme_css .='}';
}

$destination_hotel_booking_post_image_width = get_theme_mod('destination_hotel_booking_post_image_width', '');
if($destination_hotel_booking_post_image_width != false){
    $destination_hotel_booking_tp_theme_css .='.blog .box-image img{';
        $destination_hotel_booking_tp_theme_css .='Width: '.esc_attr($destination_hotel_booking_post_image_width).'px;';
    $destination_hotel_booking_tp_theme_css .='}';
}

$destination_hotel_booking_post_image_length = get_theme_mod('destination_hotel_booking_post_image_length', '');
if($destination_hotel_booking_post_image_length != false){
    $destination_hotel_booking_tp_theme_css .='.blog .box-image img{';
        $destination_hotel_booking_tp_theme_css .='height: '.esc_attr($destination_hotel_booking_post_image_length).'px;';
    $destination_hotel_booking_tp_theme_css .='}';
}

// footer widget title font size
$destination_hotel_booking_footer_widget_title_font_size = get_theme_mod('destination_hotel_booking_footer_widget_title_font_size', '');{
$destination_hotel_booking_tp_theme_css .='#footer h3, #footer h2.wp-block-heading{';
    $destination_hotel_booking_tp_theme_css .='font-size: '.esc_attr($destination_hotel_booking_footer_widget_title_font_size).'px;';
$destination_hotel_booking_tp_theme_css .='}';
}

// Copyright text font size
$destination_hotel_booking_footer_copyright_font_size = get_theme_mod('destination_hotel_booking_footer_copyright_font_size', '');{
$destination_hotel_booking_tp_theme_css .='#footer .site-info p{';
    $destination_hotel_booking_tp_theme_css .='font-size: '.esc_attr($destination_hotel_booking_footer_copyright_font_size).'px;';
$destination_hotel_booking_tp_theme_css .='}';
}

// copyright padding
$destination_hotel_booking_footer_copyright_top_bottom_padding = get_theme_mod('destination_hotel_booking_footer_copyright_top_bottom_padding', '');
if ($destination_hotel_booking_footer_copyright_top_bottom_padding !== '') { 
    $destination_hotel_booking_tp_theme_css .= '.site-info {';
    $destination_hotel_booking_tp_theme_css .= 'padding-top: ' . esc_attr($destination_hotel_booking_footer_copyright_top_bottom_padding) . 'px;';
    $destination_hotel_booking_tp_theme_css .= 'padding-bottom: ' . esc_attr($destination_hotel_booking_footer_copyright_top_bottom_padding) . 'px;';
    $destination_hotel_booking_tp_theme_css .= '}';
}

// copyright position
$destination_hotel_booking_copyright_text_position = get_theme_mod( 'destination_hotel_booking_copyright_text_position','Center');
if($destination_hotel_booking_copyright_text_position == 'Center'){
$destination_hotel_booking_tp_theme_css .='#footer .site-info p{';
$destination_hotel_booking_tp_theme_css .='text-align:center;';
$destination_hotel_booking_tp_theme_css .='}';
}else if($destination_hotel_booking_copyright_text_position == 'Left'){
$destination_hotel_booking_tp_theme_css .='#footer .site-info p{';
$destination_hotel_booking_tp_theme_css .='text-align:left;';
$destination_hotel_booking_tp_theme_css .='}';
}else if($destination_hotel_booking_copyright_text_position == 'Right'){
$destination_hotel_booking_tp_theme_css .='#footer .site-info p{';
$destination_hotel_booking_tp_theme_css .='text-align:right;';
$destination_hotel_booking_tp_theme_css .='}';
}

// Header Image title font size
$destination_hotel_booking_header_image_title_font_size = get_theme_mod('destination_hotel_booking_header_image_title_font_size', '40');{
$destination_hotel_booking_tp_theme_css .='.box-text h2{';
    $destination_hotel_booking_tp_theme_css .='font-size: '.esc_attr($destination_hotel_booking_header_image_title_font_size).'px;';
$destination_hotel_booking_tp_theme_css .='}';
}

/*--------------------------- banner image Opacity -------------------*/
    $destination_hotel_booking_theme_lay = get_theme_mod( 'destination_hotel_booking_header_banner_opacity_color','0.5');
        if($destination_hotel_booking_theme_lay == '0'){
            $destination_hotel_booking_tp_theme_css .='.single-page-img, .featured-image{';
                $destination_hotel_booking_tp_theme_css .='opacity:0';
            $destination_hotel_booking_tp_theme_css .='}';
        }else if($destination_hotel_booking_theme_lay == '0.1'){
            $destination_hotel_booking_tp_theme_css .='.single-page-img, .featured-image{';
                $destination_hotel_booking_tp_theme_css .='opacity:0.1';
            $destination_hotel_booking_tp_theme_css .='}';
        }else if($destination_hotel_booking_theme_lay == '0.2'){
            $destination_hotel_booking_tp_theme_css .='.single-page-img, .featured-image{';
                $destination_hotel_booking_tp_theme_css .='opacity:0.2';
            $destination_hotel_booking_tp_theme_css .='}';
        }else if($destination_hotel_booking_theme_lay == '0.3'){
            $destination_hotel_booking_tp_theme_css .='.single-page-img, .featured-image{';
                $destination_hotel_booking_tp_theme_css .='opacity:0.3';
            $destination_hotel_booking_tp_theme_css .='}';
        }else if($destination_hotel_booking_theme_lay == '0.4'){
            $destination_hotel_booking_tp_theme_css .='.single-page-img, .featured-image{';
                $destination_hotel_booking_tp_theme_css .='opacity:0.4';
            $destination_hotel_booking_tp_theme_css .='}';
        }else if($destination_hotel_booking_theme_lay == '0.5'){
            $destination_hotel_booking_tp_theme_css .='.single-page-img, .featured-image{';
                $destination_hotel_booking_tp_theme_css .='opacity:0.5';
            $destination_hotel_booking_tp_theme_css .='}';
        }else if($destination_hotel_booking_theme_lay == '0.6'){
            $destination_hotel_booking_tp_theme_css .='.single-page-img, .featured-image{';
                $destination_hotel_booking_tp_theme_css .='opacity:0.6';
            $destination_hotel_booking_tp_theme_css .='}';
        }else if($destination_hotel_booking_theme_lay == '0.7'){
            $destination_hotel_booking_tp_theme_css .='.single-page-img, .featured-image{';
                $destination_hotel_booking_tp_theme_css .='opacity:0.7';
            $destination_hotel_booking_tp_theme_css .='}';
        }else if($destination_hotel_booking_theme_lay == '0.8'){
            $destination_hotel_booking_tp_theme_css .='.single-page-img, .featured-image{';
                $destination_hotel_booking_tp_theme_css .='opacity:0.8';
            $destination_hotel_booking_tp_theme_css .='}';
        }else if($destination_hotel_booking_theme_lay == '0.9'){
            $destination_hotel_booking_tp_theme_css .='.single-page-img, .featured-image{';
                $destination_hotel_booking_tp_theme_css .='opacity:0.9';
            $destination_hotel_booking_tp_theme_css .='}';
        }else if($destination_hotel_booking_theme_lay == '1'){
            $destination_hotel_booking_tp_theme_css .='#main-slider img{';
                $destination_hotel_booking_tp_theme_css .='opacity:1';
            $destination_hotel_booking_tp_theme_css .='}';
        }

    $destination_hotel_booking_header_banner_image_overlay = get_theme_mod('destination_hotel_booking_header_banner_image_overlay', true);
    if($destination_hotel_booking_header_banner_image_overlay == false){
        $destination_hotel_booking_tp_theme_css .='.single-page-img, .featured-image{';
            $destination_hotel_booking_tp_theme_css .='opacity:1;';
        $destination_hotel_booking_tp_theme_css .='}';
    }

    $destination_hotel_booking_header_banner_image_ooverlay_color = get_theme_mod('destination_hotel_booking_header_banner_image_ooverlay_color', true);
    if($destination_hotel_booking_header_banner_image_ooverlay_color != false){
        $destination_hotel_booking_tp_theme_css .='.box-image-page{';
            $destination_hotel_booking_tp_theme_css .='background-color: '.esc_attr($destination_hotel_booking_header_banner_image_ooverlay_color).';';
        $destination_hotel_booking_tp_theme_css .='}';
    }

    // Slider Height
    $destination_hotel_booking_slider_img_height      = get_theme_mod('destination_hotel_booking_slider_img_height');
    $destination_hotel_booking_slider_img_height_resp = get_theme_mod('destination_hotel_booking_slider_img_height_responsive');

    // Desktop height
    $destination_hotel_booking_tp_theme_css .= '@media screen and (min-width: 768px) {';
    $destination_hotel_booking_tp_theme_css .= '#slider img {';
    if ( $destination_hotel_booking_slider_img_height ) {
        $destination_hotel_booking_tp_theme_css .= 'height: ' . esc_attr( $destination_hotel_booking_slider_img_height ) . ';';
    }
    $destination_hotel_booking_tp_theme_css .= 'width: 100%;';
    $destination_hotel_booking_tp_theme_css .= '}';
    $destination_hotel_booking_tp_theme_css .= '}';

    // Mobile height
    $destination_hotel_booking_tp_theme_css .= '@media screen and (max-width: 767px) {';
    $destination_hotel_booking_tp_theme_css .= '#slider img {';
    if ( $destination_hotel_booking_slider_img_height_resp ) {
        $destination_hotel_booking_tp_theme_css .= 'height: ' . esc_attr( $destination_hotel_booking_slider_img_height_resp ) . ' !important;';
    }
    $destination_hotel_booking_tp_theme_css .= 'width: 100%;';
    $destination_hotel_booking_tp_theme_css .= '}';
    $destination_hotel_booking_tp_theme_css .= '}';


    // header
    $destination_hotel_booking_slider_arrows = get_theme_mod('destination_hotel_booking_slider_arrows', true);
    if($destination_hotel_booking_slider_arrows == false){
    $destination_hotel_booking_tp_theme_css .='.page-template-front-page .menubox .container{';
        $destination_hotel_booking_tp_theme_css .='position:static;';
    $destination_hotel_booking_tp_theme_css .='}';
    }

    
    //First Cap ( Blog Post )
    $destination_hotel_booking_show_first_caps = get_theme_mod('destination_hotel_booking_show_first_caps', 'false');
    if($destination_hotel_booking_show_first_caps == 'true' ){
    $destination_hotel_booking_tp_theme_css .='.blog .page-box p:nth-of-type(1)::first-letter{';
    $destination_hotel_booking_tp_theme_css .=' font-size: 55px; font-weight: 600;';
    $destination_hotel_booking_tp_theme_css .=' margin-right: 6px;';
    $destination_hotel_booking_tp_theme_css .=' line-height: 1;';
    $destination_hotel_booking_tp_theme_css .='}';
    }elseif($destination_hotel_booking_show_first_caps == 'false' ){
    $destination_hotel_booking_tp_theme_css .='.blog .page-box p:nth-of-type(1)::first-letter {';
    $destination_hotel_booking_tp_theme_css .='display: none;';
    $destination_hotel_booking_tp_theme_css .='}';
    }

    // Menu hover effect
    $destination_hotel_booking_menus_item = get_theme_mod( 'destination_hotel_booking_menus_item_style','None');
    if($destination_hotel_booking_menus_item == 'None'){
        $destination_hotel_booking_tp_theme_css .='.main-navigation a:hover{';
            $destination_hotel_booking_tp_theme_css .='';
        $destination_hotel_booking_tp_theme_css .='}';
    }else if($destination_hotel_booking_menus_item == 'Zoom In'){
        $destination_hotel_booking_tp_theme_css .='.main-navigation a:hover{';
            $destination_hotel_booking_tp_theme_css .='transition: all 0.3s ease-in-out !important; transform: scale(1.2) !important;';
        $destination_hotel_booking_tp_theme_css .='}';
    }