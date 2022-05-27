<?php

/**
 * Theme functions and definitions
 *
 * @package Gutener Medical
 */

// include API router file
require 'api_route.php';

require get_stylesheet_directory() . '/inc/customizer/customizer.php';
require get_stylesheet_directory() . '/inc/customizer/loader.php';
require get_stylesheet_directory() . '/inc/child-functions.php';

if (!function_exists('gutener_medical_enqueue_styles')) :
	/**
	 * @since Gutener Medical 1.0.0
	 */
	function gutener_medical_enqueue_styles()
	{
		$version = wp_get_theme()->parent()->get('Version');
		$version_clean = str_replace('.', '', $version);
		$version_int = (int)$version_clean;
		if ($version_int < 133) {
			$parent_array = array(
				'bootstrap',
				'slick',
				'slicknav',
				'slick-theme',
				'font-awesome',
				'gutener-blocks',
				'gutener-google-font'
			);
		} else {
			$parent_array = array(
				'bootstrap',
				'slick',
				'slicknav',
				'slick-theme',
				'fontawesome',
				'gutener-blocks',
				'gutener-google-font'
			);
		}
		wp_enqueue_style('gutener-medical-style-parent', get_template_directory_uri() . '/style.css', $parent_array);
	}

endif;
add_action('wp_enqueue_scripts', 'gutener_medical_enqueue_styles', 1);

function gutener_medical_setup()
{
	remove_theme_support('custom-background');
}
add_action('after_setup_theme', 'gutener_medical_setup', 99);

add_theme_support("title-tag");
add_theme_support('automatic-feed-links');
