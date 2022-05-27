<?php
/**
* Loads all the components related to customizer 
*
* @since Gutener Medical 1.0.0
*/

function gutener_medical_default_styles(){

	// begin style block
	$css = '<style>';

	# Colors
	$site_primary_color = get_theme_mod( 'site_primary_color', '#dd9933' ); // 130947
	$site_hover_color = get_theme_mod( 'site_hover_color', '#086abd' );
	$notification_bar_button_background_color = get_theme_mod( 'notification_bar_button_background_color', '#130947' );
	$css .= '
		/* Primary Background */
		.section-title:before, .button-primary, body.woocommerce span.onsale, body.woocommerce-page span.onsale, body .woocommerce.widget_price_filter .ui-slider .ui-slider-handle, #offcanvas-menu .header-btn-wrap .header-btn .button-primary {
			background-color: '. esc_attr( $site_primary_color ) .';
		}
		/* Primary Border */		
		.post .entry-content .entry-header .cat-links a, .attachment .entry-content .entry-header .cat-links a, .wrap-coming-maintenance-mode .content .button-container .button-primary {
			border-color: '. esc_attr( $site_primary_color ) .';
		}
		/* Primary Color */
	 	blockquote:before, .post .entry-content .entry-header .cat-links a, .attachment .entry-content .entry-header .cat-links a, .post .entry-meta a:before, .attachment .entry-meta a:before, .single .entry-container .cat-links:before, .post .entry-meta .tag-links:before {
			color: '. esc_attr( $site_primary_color ) .';
		}
	';

	$css .= '
		.notification-bar .button-primary {
			background-color: '. esc_attr( $notification_bar_button_background_color ) .';
		}
	';

	/* Site Tagline */
	if( get_theme_mod( 'disable_site_tagline_border', true ) ){
	$css .= '
		.site-header .site-branding .site-description:before, 
		.site-header .site-branding .site-description:after {
			display: none;
		}
		.site-header .site-branding .site-description, 
		.site-header .site-branding .site-description {
			padding-left: 0;
			padding-right: 0;
		}
	';
	}

	#Header Image Height
	$header_image_height = get_theme_mod( 'header_image_height', 120 );
	$css .= '
		@media only screen and (min-width: 992px) {
			.site-header:not(.sticky-header) .header-image-wrap {
				height: '. esc_attr( $header_image_height ) .'px;
				width: 100%;
				position: relative;
			}
		}
	';

	#Bottom Footer image width
	if( get_theme_mod( 'footer_layout', 'footer_two' ) == 'footer_one' ){
		$bottom_footer_image_width = get_theme_mod( 'bottom_footer_image_width', 270 );
		$css .= '
			.bottom-footer-image-wrap > a {
				max-width: '. esc_attr( $bottom_footer_image_width ) .'px;
				overflow: hidden;
				display: inline-block;
			}
		';
	}

	# Slider category color
	$slider_post_category_color 	= get_theme_mod( 'slider_post_category_color', '#ebebeb' );
	$slider_post_meta_icon_color 	= get_theme_mod( 'slider_post_meta_icon_color', '#ebebeb' );
	$separate_hover_color_for_main_slider = get_theme_mod( 'separate_hover_color_for_main_slider', '' );
	$separate_hover_color_for_main_slider = $separate_hover_color_for_main_slider ? $separate_hover_color_for_main_slider : $site_hover_color;
	$css .= '
		.banner-content .entry-content .entry-header .cat-links a {
			color: '. esc_attr( $slider_post_category_color) .';
			border-color: '. esc_attr( $slider_post_category_color) .';
		}
		.section-banner .banner-content .entry-meta a:before {
			color: '. esc_attr( $slider_post_meta_icon_color ) .';
		}
		.section-banner .banner-content .entry-meta a:hover:before, 
		.section-banner .banner-content .entry-meta a:focus:before, 
		.section-banner .banner-content .entry-meta a:active:before {
			color: '. esc_attr( $separate_hover_color_for_main_slider ) .';
		}
	';

    # Highlighted Posts
	$highlight_post_category_bgcolor = get_theme_mod( 'highlight_post_category_bgcolor', '' );
	$highlight_post_category_bgcolor = $highlight_post_category_bgcolor ? $highlight_post_category_bgcolor : $site_primary_color;
    $highlight_post_category_color 	 = get_theme_mod( 'highlight_post_category_color', '#FFFFFF' );
    $highlight_post_meta_color 		 = get_theme_mod( 'highlight_post_meta_color', '#FFFFFF' );
    $highlight_post_meta_icon_color  = get_theme_mod( 'highlight_post_meta_icon_color', '#FFFFFF' );
    $highlight_post_hover_color 	 = get_theme_mod( 'highlight_post_hover_color', '' );
    $highlight_post_hover_color 	 = $highlight_post_hover_color ? $highlight_post_hover_color : $site_hover_color;
    $css .= '
    	.highlight-posts-layout-one .highlight-posts-content .highlight-posts-title a:hover:after, 
    	.highlight-posts-layout-one .highlight-posts-content .highlight-posts-title a:focus:after, 
    	.highlight-posts-layout-one .highlight-posts-content .highlight-posts-title a:active:after {
    		background-color: '. esc_attr( $highlight_post_hover_color ) .';
    	}
    ';

    $css .= '
		.highlight-posts-content .cat-links a {
    		color: '. esc_attr( $highlight_post_category_color ) .';
    	}
    	.highlight-posts-layout-one .highlight-posts-content .cat-links a {
    		background-color: '. esc_attr( $highlight_post_category_bgcolor ) .';
    	}
    	.highlight-posts-layout-one .highlight-posts-content .cat-links a:hover,
    	.highlight-posts-layout-one .highlight-posts-content .cat-links a:focus,
    	.highlight-posts-layout-one .highlight-posts-content .cat-links a:active {
    		background-color: '. esc_attr( $highlight_post_hover_color ) .';
    		color: #FFFFFF;
    	}
    ';

    $css .= '
    	.post .highlight-posts-content .entry-meta a {
    		color: '. esc_attr( $highlight_post_meta_color ) .';
    	}
    	.post .highlight-posts-content .entry-meta a:before {
    		color: '. esc_attr( $highlight_post_meta_icon_color ) .';
    	}
    	.post .highlight-posts-content .entry-meta a:hover, 
    	.post .highlight-posts-content .entry-meta a:focus, 
    	.post .highlight-posts-content .entry-meta a:active,
    	.post .highlight-posts-content .entry-meta a:hover:before, 
    	.post .highlight-posts-content .entry-meta a:focus:before, 
    	.post .highlight-posts-content .entry-meta a:active:before {
    		color: '. esc_attr( $highlight_post_hover_color ) .';
    	}
    ';
    #Blog Page Colors
    $blog_post_title_color 		= get_theme_mod( 'blog_post_title_color', '#101010' );
    $blog_post_category_color 	= get_theme_mod( 'blog_post_category_color', '#130947' );
    $blog_post_meta_icon_color 	= get_theme_mod( 'blog_post_meta_icon_color', '' );
    $blog_post_meta_icon_color 	= $blog_post_meta_icon_color ? $blog_post_meta_icon_color : $site_primary_color;
    $blog_post_hover_color 		= get_theme_mod( 'blog_post_hover_color', '' );
    $blog_post_hover_color 		= $blog_post_hover_color ? $blog_post_hover_color : $site_hover_color;
    $css .= '
    	#primary article .entry-title {
    		color: '. esc_attr( $blog_post_title_color ) .';
    	}
    	#primary article .entry-content .entry-header .cat-links a,
    	#primary article .attachment .entry-content .entry-header .cat-links a {
    		color: '. esc_attr( $blog_post_category_color ) .';
    	}
    	#primary article .entry-content .entry-header .cat-links a {
    		border-color: '. esc_attr( $blog_post_category_color ) .';
    	}
    	#primary article .entry-content .entry-header .cat-links a:hover,
    	#primary article .entry-content .entry-header .cat-links a:focus,
    	#primary article .entry-content .entry-header .cat-links a:active {
    		color: '. esc_attr( $blog_post_hover_color ) .';
    		border-color: '. esc_attr( $blog_post_hover_color ) .';
    	}
    	#primary article .entry-meta a:hover:before,
    	#primary article .entry-meta a:focus:before,
    	#primary article .entry-meta a:active:before {
    		color: '. esc_attr( $blog_post_hover_color ) .';
    	}
    	#primary article .entry-meta a:before {
    		color: '. esc_attr( $blog_post_meta_icon_color ) .';
    	}
    ';

    # Featured Posts Colors
	$feature_post_title_color 		= get_theme_mod( 'feature_post_title_color', '#030303' );
    $feature_post_category_bgcolor  = get_theme_mod( 'feature_post_category_bgcolor', '#1f1f1f' );
    $feature_post_category_color 	= get_theme_mod( 'feature_post_category_color', '#FFFFFF' );
    $feature_post_meta_icon_color 	= get_theme_mod( 'feature_post_meta_icon_color', '' );
    $feature_post_meta_icon_color 	= $feature_post_meta_icon_color ? $feature_post_meta_icon_color : $site_primary_color;
    $feature_post_hover_color 		= get_theme_mod( 'feature_post_hover_color', '' );
    $feature_post_hover_color 	 	= $feature_post_hover_color ? $feature_post_hover_color : $site_hover_color;
    $css .= '
    	.feature-post-slider .post .entry-content .entry-title {
    		color: '. esc_attr( $feature_post_title_color ) .';
    	}
    	.feature-post-slider .post .cat-links a {
    		background-color: '. esc_attr( $feature_post_category_bgcolor ) .';
    	}
    	.feature-post-slider .post .cat-links a {
    		color: '. esc_attr( $feature_post_category_color ) .';
    	}
    	.feature-post-slider .post .cat-links a:hover,
    	.feature-post-slider .post .cat-links a:focus,
    	.feature-post-slider .post .cat-links a:active {
    		background-color: '. esc_attr( $feature_post_hover_color ) .';
    		color: #FFFFFF;
    	}
    	.feature-post-slider .post .entry-meta a:before {
    		color: '. esc_attr( $feature_post_meta_icon_color ) .';
    	}
    	.feature-post-slider .post .entry-meta a:hover:before,
    	.feature-post-slider .post .entry-meta a:focus:before,
    	.feature-post-slider .post .entry-meta a:active:before {
    		color: '. esc_attr( $feature_post_hover_color ) .';
    	}
    ';

	// end style block
	$css .= '</style>';

	// return generated & compressed CSS
	echo str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $css); 
}
add_action( 'wp_head', 'gutener_medical_default_styles', 99 );