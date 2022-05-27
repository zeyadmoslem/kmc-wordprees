<?php
/**
 * Gutener Theme Customizer
 *
 * @package Gutener
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function gutener_customize_register( $wp_customize ) {
	// Load custom control functions.
	require get_template_directory() . '/inc/customizer/controls.php';

	// Register custom section types.
	$wp_customize->register_section_type( 'Gutener_Customize_Section_Upsell' );

	// Register sections.
	$wp_customize->add_section(
		new Gutener_Customize_Section_Upsell(
			$wp_customize,
			'theme_upsell',
			array(
				'title'    => esc_html__( 'Gutener Pro', 'gutener' ),
				'pro_text' => esc_html__( 'Upgrade To Pro', 'gutener' ),
				'pro_url'  => 'https://keonthemes.com/downloads/gutener-pro',
				'priority'  => 1,
			)
		)
	);
	//Background Color option active_callback modify
	$wp_customize->get_control('background_color')-> active_callback = 'gutener_bg_color_callback';
}
add_action( 'customize_register', 'gutener_customize_register' );

/**
 * Add getting started section for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function gutener_customize_getting_started_register( $wp_customize ) {

	include_once ABSPATH . 'wp-admin/includes/plugin.php';
	// Load custom control functions.
	require get_template_directory() . '/inc/customizer/getting-started-section.php';

	// Register custom section types.
	if ( !gutener_are_plugin_active() ){
		$wp_customize->register_section_type( 'Gutener_Customize_Getting_Started' );
		$theme_name = wp_get_theme()->get( 'Name' );
		$wp_customize->add_section(
			new Gutener_Customize_Getting_Started(
				$wp_customize,
				'theme_getting_started',
				array(
					'title'    => esc_html__( 'Getting started will install and activate the recommended plugins.', 'gutener' ),
					'gs_text' => sprintf( esc_html__( 'Get Started with %s','gutener' ), $theme_name ),
					'gs_url'  => '#',
					'priority'  => 2,
				)
			)
		);	
	}
}
add_action( 'customize_register', 'gutener_customize_getting_started_register' );

/**
 * Enqueue style for custom customize control.
 */
add_action( 'customize_controls_enqueue_scripts', 'gutener_custom_customize_enqueue' );
function gutener_custom_customize_enqueue() {
	wp_enqueue_style( 'gutener-customize-controls', get_template_directory_uri() . '/inc/customizer/customizer.css' );
}

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function gutener_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function gutener_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function gutener_customize_preview_js() {
	wp_enqueue_script( 'gutener-customizer', get_template_directory_uri() . '/inc/customizer/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'gutener_customize_preview_js' );

/**
 * Binds getting started js to Theme Customizer preview.
 * 
 * @since  1.4.2
 */
function gutener_customize_getting_js() {
	wp_enqueue_script( 'gutener-customizer-getting-started', get_template_directory_uri() . '/inc/getting-started/getting-started.js', array( 'customize-controls', 'jquery' ), true );
}
add_action( 'customize_controls_enqueue_scripts', 'gutener_customize_getting_js' );

/**
 * Kirki Customizer
 *
 * @return void
 */
add_action( 'init' , 'gutener_kirki_fields' );

function gutener_kirki_fields(){

	/**
	* If kirki is not installed do not run the kirki fields
	*/

	if ( !class_exists( 'Kirki' ) ) {
		return;
	}

	Kirki::add_config( 'gutener', array(
		'capability'  => 'edit_theme_options',
		'option_type' => 'theme_mod',
	) );

	// Site Identity - Title & Tagline
	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Logo Image Width', 'gutener' ),
		'type'         => 'slider',
		'settings'     => 'logo_width',
		'section'      => 'title_tagline',
		'transport'    => 'postMessage',
		'priority'     => '8',
		'default'      => 270,
		'choices'      => array(
			'min'  => 50,
			'max'  => 270,
			'step' => 5,
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Disable Site Title', 'gutener' ),
		'type'         => 'checkbox',
		'settings'     => 'disable_site_title',
		'section'      => 'title_tagline',
		'priority'     => '10',
		'default'      => false,
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Disable Site Tagline', 'gutener' ),
		'type'         => 'checkbox',
		'settings'     => 'disable_site_tagline',
		'section'      => 'title_tagline',
		'priority'     => '20',
		'default'      => false,
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Disable Site Tagline Border', 'gutener' ),
		'type'         => 'checkbox',
		'settings'     => 'disable_site_tagline_border',
		'section'      => 'title_tagline',
		'priority'     => '30',
		'default'      => true,
		'active_callback' => array(
			array(
				'setting'  => 'disable_site_tagline',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	// Colors Options
	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Body Text Color', 'gutener' ),
		'type'         => 'color',
		'settings'     => 'site_body_text_color',
		'section'      => 'colors',
		'default'      => '#333333',
		'priority'     => '20',
		'active_callback' => array(
			array(
				'setting'  => 'skin_select',
				'operator' => 'contains',
				'value'    => array( 'default', 'blackwhite' ),
			),
		),

	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'General Heading Text Color (H1 - H6)', 'gutener' ),
		'type'         => 'color',
		'settings'     => 'site_heading_text_color',
		'section'      => 'colors',
		'default'      => '#030303',
		'priority'     => '30',
		'active_callback' => array(
			array(
				'setting'  => 'skin_select',
				'operator' => 'contains',
				'value'    => array( 'default', 'blackwhite' ),
			),
		),

	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'General Link Text Color', 'gutener' ),
		'type'         => 'color',
		'settings'     => 'site_general_link_color',
		'section'      => 'colors',
		'default'      => '#a6a6a6',
		'priority'     => '35',
		'active_callback' => array(
			array(
				'setting'  => 'skin_select',
				'operator' => 'contains',
				'value'    => array( 'default', 'blackwhite' ),
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Page and Single Post Title', 'gutener' ),
		'type'         => 'color',
		'settings'     => 'header_textcolor',
		'section'      => 'colors',
		'default'      => '#101010',
		'priority'     => '40',
		'active_callback' => array(
			array(
				'setting'  => 'skin_select',
				'operator' => 'contains',
				'value'    => array( 'default', 'blackwhite' ),
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Primary Color', 'gutener' ),
		'type'         => 'color',
		'settings'     => 'site_primary_color',
		'section'      => 'colors',
		'default'      => '#f9a032',
		'priority'     => '50',
	) );
	
	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Hover Color', 'gutener' ),
		'type'         => 'color',
		'settings'     => 'site_hover_color',
		'section'      => 'colors',
		'default'     => '#086abd',
		'priority'    => '60',
	) );

	// Header Options
	Kirki::add_panel( 'header_options', array(
	    'title' => esc_html__( 'Header', 'gutener' ),
	    'priority' => '10',
	) );

	// Header Style Options
	Kirki::add_section( 'header_style_options', array(
	    'title'      => esc_html__( 'Style', 'gutener' ),
	    'panel'      => 'header_options',	   
	    'capability' => 'edit_theme_options',
	    'priority'   => '30',
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Header Layouts', 'gutener' ),
		'description' => esc_html__( 'Select layout & scroll below to change its options', 'gutener' ),
		'type'        => 'radio-image',
		'settings'    => 'header_layout',
		'section'     => 'header_style_options',
		'default'     => 'header_one',
		'choices'  => array(
			'header_one'    => get_template_directory_uri() . '/assets/images/header-layout-1.png',
			'header_two'    => get_template_directory_uri() . '/assets/images/header-layout-2.png',
			'header_three'  => get_template_directory_uri() . '/assets/images/header-layout-3.png',
		)
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Disable Top Header Section', 'gutener' ),
		'type'         => 'checkbox',
		'settings'     => 'disable_top_header_section',
		'section'      => 'header_style_options',
		'default'      => false,
	) );

	Kirki::add_field( 'gutener', array(
	    'type'        => 'custom',
	    'settings'    => 'transparent_header_separator',
	    'section'     => 'header_style_options',
	    'default'     => esc_html__( 'Transparent Header Options', 'gutener' ),
	    'active_callback' => array(
			array(
				'setting'  => 'header_layout',
				'operator' => '==',
				'value'    => 'header_three',
			),
		),
	) );

	// Header Three separate logo
	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Transparent Header Separate Logo', 'gutener' ),
		'type'         => 'image',
		'settings'     => 'header_separate_logo',
		'section'      => 'header_style_options',
		'default'      => '',
		'active_callback' => array(
			array(
				'setting'  => 'header_layout',
				'operator' => '==',
				'value'    => 'header_three',
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Transparent Header Site Title Color', 'gutener' ),
		'type'         => 'color',
		'settings'     => 'site_title_color_transparent_header',
		'section'      => 'header_style_options',
		'default'      => '',
		'active_callback' => array(
			array(
				'setting'  => 'header_layout',
				'operator' => '==',
				'value'    => 'header_three',
			),
			array(
				'setting'  => 'skin_select',
				'operator' => 'contains',
				'value'    => array( 'default', 'blackwhite' ),
			),
			array(
				'setting'  => 'disable_site_title',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Transparent Header Site Tagline Color', 'gutener' ),
		'type'         => 'color',
		'settings'     => 'site_tagline_color_transparent_header',
		'section'      => 'header_style_options',
		'default'      => '',
		'active_callback' => array(
			array(
				'setting'  => 'header_layout',
				'operator' => '==',
				'value'    => 'header_three',
			),
			array(
				'setting'  => 'skin_select',
				'operator' => 'contains',
				'value'    => array( 'default', 'blackwhite' ),
			),
			array(
				'setting'  => 'disable_site_tagline',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Transparent Top Header Background Color', 'gutener' ),
		'description'  => esc_html__( 'It can be used as a transparent background color over image.', 'gutener' ),
		'type'         => 'color',
		'settings'     => 'transparent_header_top_background_color',
		'section'      => 'header_style_options',
		'default'      => '',
		'active_callback' => array(
			array(
				'setting'  => 'header_layout',
				'operator' => '==',
				'value'    => 'header_three',
			),
			array(
				'setting'  => 'skin_select',
				'operator' => 'contains',
				'value'    => array( 'default', 'blackwhite' ),
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Transparent Top Header Text Color', 'gutener' ),
		'type'         => 'color',
		'settings'     => 'transparent_header_top_text_color',
		'section'      => 'header_style_options',
		'default'      => '',
		'active_callback' => array(
			array(
				'setting'  => 'header_layout',
				'operator' => '==',
				'value'    => 'header_three',
			),
			array(
				'setting'  => 'skin_select',
				'operator' => 'contains',
				'value'    => array( 'default', 'blackwhite' ),
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Transparent Top Header Text Link Hover Color', 'gutener' ),
		'type'         => 'color',
		'settings'     => 'top_hover_color_transparent_header',
		'section'      => 'header_style_options',
		'default'      => '',
		'active_callback' => array(
			array(
				'setting'  => 'header_layout',
				'operator' => '==',
				'value'    => 'header_three',
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Transparent Bottom Header Background Color', 'gutener' ),
		'description'  => esc_html__( 'It can be used as a transparent background color over image.', 'gutener' ),
		'type'         => 'color',
		'settings'     => 'transparent_header_bottom_background_color',
		'section'      => 'header_style_options',
		'default'      => '',
		'active_callback' => array(
			array(
				'setting'  => 'header_layout',
				'operator' => '==',
				'value'    => 'header_three',
			),
			array(
				'setting'  => 'skin_select',
				'operator' => 'contains',
				'value'    => array( 'default', 'blackwhite' ),
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Transparent Bottom Header Text Color', 'gutener' ),
		'type'         => 'color',
		'settings'     => 'content_color_transparent_header',
		'section'      => 'header_style_options',
		'default'      => '',
		'active_callback' => array(
			array(
				'setting'  => 'header_layout',
				'operator' => '==',
				'value'    => 'header_three',
			),
			array(
				'setting'  => 'skin_select',
				'operator' => 'contains',
				'value'    => array( 'default', 'blackwhite' ),
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Transparent Bottom Header Text Link Hover Color', 'gutener' ),
		'type'         => 'color',
		'settings'     => 'content_hover_color_transparent_header',
		'section'      => 'header_style_options',
		'default'      => '',
		'active_callback' => array(
			array(
				'setting'  => 'header_layout',
				'operator' => '==',
				'value'    => 'header_three',
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
	    'type'        => 'custom',
	    'settings'    => 'non_transparent_header_separator',
	    'section'     => 'header_style_options',
	    'default'     => esc_html__( 'Non Transparent Header Options', 'gutener' ),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Non Transparent Header Site Title Color', 'gutener' ),
		'type'         => 'color',
		'settings'     => 'site_title_color',
		'section'      => 'header_style_options',
		'default'      => '#030303',
		'active_callback' => array(
			array(
				'setting'  => 'skin_select',
				'operator' => 'contains',
				'value'    => array( 'default', 'blackwhite' ),
			),
			array(
				'setting'  => 'disable_site_title',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Non Transparent Header Site Tagline Color', 'gutener' ),
		'type'         => 'color',
		'settings'     => 'site_tagline_color',
		'section'      => 'header_style_options',
		'default'      => '#767676',
		'active_callback' => array(
			array(
				'setting'  => 'skin_select',
				'operator' => 'contains',
				'value'    => array( 'default', 'blackwhite' ),
			),
			array(
				'setting'  => 'disable_site_tagline',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Non Transparent Top Header Background Color', 'gutener' ),
		'type'         => 'color',
		'settings'     => 'top_header_one_background_color',
		'section'      => 'header_style_options',
		'default'      => '',
		'active_callback' => array(
			array(
				'setting'  => 'header_layout',
				'operator' => '==',
				'value'    => 'header_one',
			),
			array(
				'setting'  => 'skin_select',
				'operator' => 'contains',
				'value'    => array( 'default', 'blackwhite' ),
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Non Transparent Top Header Background Color', 'gutener' ),
		'type'         => 'color',
		'settings'     => 'top_header_two_background_color',
		'section'      => 'header_style_options',
		'default'      => '',
		'active_callback' => array(
			array(
				'setting'  => 'header_layout',
				'operator' => '==',
				'value'    => 'header_two',
			),
			array(
				'setting'  => 'skin_select',
				'operator' => 'contains',
				'value'    => array( 'default', 'blackwhite' ),
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Non Transparent Top Header Background Color', 'gutener' ),
		'description'  => esc_html__( 'It can be used as a transparent background color over image.', 'gutener' ),
		'type'         => 'color',
		'settings'     => 'top_header_three_background_color',
		'section'      => 'header_style_options',
		'default'      => '',
		'active_callback' => array(
			array(
				'setting'  => 'header_layout',
				'operator' => '==',
				'value'    => 'header_three',
			),
			array(
				'setting'  => 'skin_select',
				'operator' => 'contains',
				'value'    => array( 'default', 'blackwhite' ),
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Non Transparent Top Header Text Color', 'gutener' ),
		'type'         => 'color',
		'settings'     => 'top_header_text_color',
		'section'      => 'header_style_options',
		'default'      => '#333333',
		'active_callback' => array(
			array(
				'setting'  => 'skin_select',
				'operator' => 'contains',
				'value'    => array( 'default', 'blackwhite' ),
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Non Transparent Top Header Text Link Hover Color', 'gutener' ),
		'type'         => 'color',
		'settings'     => 'top_header_text_link_hover_color',
		'section'      => 'header_style_options',
		'default'      => '',
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Disable Top Header Section Border', 'gutener' ),
		'type'         => 'checkbox',
		'settings'     => 'disable_top_header_border',
		'section'      => 'header_style_options',
		'default'      => false,
		'active_callback' => array(
			array(
				'setting'  => 'skin_select',
				'operator' => 'contains',
				'value'    => array( 'default', 'blackwhite' ),
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Non Transparent Mid Header Background Color', 'gutener' ),
		'description'  => esc_html__( 'It can be used as a transparent background color over image.', 'gutener' ),
		'type'         => 'color',
		'settings'     => 'mid_header_background_color',
		'section'      => 'header_style_options',
		'default'      => '',
		'active_callback' => array(
			array(
				'setting'  => 'header_layout',
				'operator' => 'contains',
				'value'    => array( 'header_one' ),
			),
			array(
				'setting'  => 'skin_select',
				'operator' => 'contains',
				'value'    => array( 'default', 'blackwhite' ),
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Non Transparent Mid Text Link Hover Color', 'gutener' ),
		'type'         => 'color',
		'settings'     => 'mid_header_text_link_hover_color',
		'section'      => 'header_style_options',
		'default'      => '',
		'active_callback' => array(
			array(
				'setting'  => 'header_layout',
				'operator' => 'contains',
				'value'    => array( 'header_one' ),
			),
			array(
				'setting'  => 'disable_site_title',
				'operator' => '==',
				'value'    =>  false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Disable Mid Header Section Border', 'gutener' ),
		'type'         => 'checkbox',
		'settings'     => 'disable_mid_header_border',
		'section'      => 'header_style_options',
		'default'      => false,
		'active_callback' => array(
			array(
				'setting'  => 'header_layout',
				'operator' => 'contains',
				'value'    => array( 'header_one' ),
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Non Transparent Bottom Header Background Color', 'gutener' ),
		'type'         => 'color',
		'settings'     => 'bottom_header_one_background_color',
		'section'      => 'header_style_options',
		'default'      => '',
		'active_callback' => array(
			array(
				'setting'  => 'header_layout',
				'operator' => '==',
				'value'    => 'header_one',
			),
			array(
				'setting'  => 'skin_select',
				'operator' => 'contains',
				'value'    => array( 'default', 'blackwhite' ),
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Non Transparent Bottom Header Background Color', 'gutener' ),
		'description'  => esc_html__( 'It can be used as a transparent background color over image.', 'gutener' ),
		'type'         => 'color',
		'settings'     => 'bottom_header_two_background_color',
		'section'      => 'header_style_options',
		'default'      => '',
		'active_callback' => array(
			array(
				'setting'  => 'header_layout',
				'operator' => '==',
				'value'    => 'header_two',
			),
			array(
				'setting'  => 'skin_select',
				'operator' => 'contains',
				'value'    => array( 'default', 'blackwhite' ),
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Non Transparent Bottom Header Background Color', 'gutener' ),
		'description'  => esc_html__( 'It can be used as a transparent background color over image.', 'gutener' ),
		'type'         => 'color',
		'settings'     => 'bottom_header_three_background_color',
		'section'      => 'header_style_options',
		'default'      => '',
		'active_callback' => array(
			array(
				'setting'  => 'header_layout',
				'operator' => '==',
				'value'    => 'header_three',
			),
			array(
				'setting'  => 'skin_select',
				'operator' => 'contains',
				'value'    => array( 'default', 'blackwhite' ),
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Non Transparent Bottom Header Text Color', 'gutener' ),
		'type'         => 'color',
		'settings'     => 'bottom_header_text_color',
		'section'      => 'header_style_options',
		'default'      => '#333333',
		'active_callback' => array(
			array(
				'setting'  => 'skin_select',
				'operator' => 'contains',
				'value'    => array( 'default', 'blackwhite' ),
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Non Transparent Bottom Header Text Link Hover Color', 'gutener' ),
		'type'         => 'color',
		'settings'     => 'bottom_header_text_link_hover_color',
		'section'      => 'header_style_options',
		'default'      => '',
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Sub Menu Link Hover Color', 'gutener' ),
		'type'         => 'color',
		'settings'     => 'sub_menu_link_hover_color',
		'section'      => 'header_style_options',
		'default'      => '',
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Header Height (in px)', 'gutener' ),
		'description' => esc_html__( 'This option will only apply to Desktop. Please click on below Desktop Icon to see changes. Automatically adjust by theme default in the responsive devices.
		', 'gutener' ),
		'type'        => 'slider',
		'settings'    => 'header_image_height',
		'section'     => 'header_style_options',
		'transport'   => 'postMessage',
		'default'     => 100,
		'choices'     => array(
			'min'  => 50,
			'max'  => 1200,
			'step' => 10,
		),
	) );

	Kirki::add_field( 'gutener', array(
	    'type'        => 'custom',
	    'settings'    => 'contact_details_separator',
	    'section'     => 'header_style_options',
	    'default'     => esc_html__( 'Contact Details Options', 'gutener' ),
	) );

    // Contact Detail Options
	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Disable Contact Details', 'gutener' ),
		'type'         => 'checkbox',
		'settings'     => 'disable_contact_detail',
		'section'      => 'header_style_options',
		'default'      => false,
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Phone Number', 'gutener' ),
		'type'         => 'text',
		'settings'     => 'contact_phone',
		'section'      => 'header_style_options',
		'default'      => '',
		'active_callback' => array(
			array(
				'setting'  => 'disable_contact_detail',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Email', 'gutener' ),
		'type'         => 'text',
		'settings'     => 'contact_email',
		'section'      => 'header_style_options',
		'default'      => '',
		'active_callback' => array(
			array(
				'setting'  => 'disable_contact_detail',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Address', 'gutener' ),
		'type'         => 'text',
		'settings'     => 'contact_address',
		'section'      => 'header_style_options',
		'default'      => '',
		'active_callback' => array(
			array(
				'setting'  => 'disable_contact_detail',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
	    'type'        => 'custom',
	    'settings'    => 'header_button_separator',
	    'section'     => 'header_style_options',
	    'default'     => esc_html__( 'Header Button Options', 'gutener' ),
	    'active_callback' => array(
			array(
				'setting'  => 'header_layout',
				'operator' => 'contains',
				'value'    => array( 'header_two', 'header_three' ),
			),
		),
	) );

	// Header button
	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Disable Header Button', 'gutener' ),
		'type'        => 'checkbox',
		'settings'    => 'disable_header_button',
		'section'     => 'header_style_options',
		'default'     => false,
		'active_callback' => array(
			array(
				'setting'  => 'header_layout',
				'operator' => 'contains',
				'value'    => array( 'header_two', 'header_three' ),
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Button Type', 'gutener' ),
		'type'        => 'select',
		'settings'    => 'header_button_type',
		'section'     => 'header_style_options',
		'default'     => 'button-primary',
		'choices'  => array(
			'button-primary' => esc_html__( 'Primary Button', 'gutener' ),
			'button-outline' => esc_html__( 'Border Button', 'gutener' ),
			'button-text'    => esc_html__( 'Text Only Button', 'gutener' ),
		),
		'active_callback' => array(
			array(
				'setting'  => 'header_layout',
				'operator' => 'contains',
				'value'    => array( 'header_two', 'header_three' ),
			),
			array(
				'setting'  => 'disable_header_button',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Transparent Header Button Background Color', 'gutener' ),
		'type'         => 'color',
		'settings'     => 'transparent_header_button_background_color',
		'section'      => 'header_style_options',
		'default'      => '',
		'active_callback' => array(
			array(
				'setting'  => 'header_layout',
				'operator' => '==',
				'value'    => 'header_three',
			),
			array(
				'setting'  => 'header_button_type',
				'operator' => '==',
				'value'    => 'button-primary',
			),
			array(
				'setting'  => 'disable_header_button',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Transparent Header Button Border Color', 'gutener' ),
		'type'         => 'color',
		'settings'     => 'transparent_header_button_border_color',
		'section'      => 'header_style_options',
		'default'      => '',
		'active_callback' => array(
			array(
				'setting'  => 'header_layout',
				'operator' => '==',
				'value'    => 'header_three',
			),
			array(
				'setting'  => 'header_button_type',
				'operator' => '==',
				'value'    => 'button-outline',
			),
			array(
				'setting'  => 'disable_header_button',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Transparent Header Button Text Color', 'gutener' ),
		'type'         => 'color',
		'settings'     => 'transparent_header_button_text_color',
		'section'      => 'header_style_options',
		'default'      => '',
		'active_callback' => array(
			array(
				'setting'  => 'header_layout',
				'operator' => '==',
				'value'    => 'header_three',
			),
			array(
				'setting'  => 'disable_header_button',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Transparent Header Button Hover Color', 'gutener' ),
		'type'         => 'color',
		'settings'     => 'transparent_header_button_hover_color',
		'section'      => 'header_style_options',
		'default'      => '',
		'active_callback' => array(
			array(
				'setting'  => 'header_layout',
				'operator' => '==',
				'value'    => 'header_three',
			),
			array(
				'setting'  => 'disable_header_button',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Non Transparent Header Button Background Color', 'gutener' ),
		'type'         => 'color',
		'settings'     => 'header_button_background_color',
		'section'      => 'header_style_options',
		'default'      => '#f9a032',
		'active_callback' => array(
			array(
				'setting'  => 'header_layout',
				'operator' => 'contains',
				'value'    => array( 'header_two', 'header_three' ),
			),
			array(
				'setting'  => 'header_button_type',
				'operator' => '==',
				'value'    => 'button-primary',
			),
			array(
				'setting'  => 'disable_header_button',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Non Transparent Header Button Border Color', 'gutener' ),
		'type'         => 'color',
		'settings'     => 'header_button_border_color',
		'section'      => 'header_style_options',
		'default'      => '',
		'active_callback' => array(
			array(
				'setting'  => 'header_layout',
				'operator' => 'contains',
				'value'    => array( 'header_two', 'header_three' ),
			),
			array(
				'setting'  => 'disable_header_button',
				'operator' => '==',
				'value'    => false,
			),
			array(
				'setting'  => 'header_button_type',
				'operator' => '==',
				'value'    => 'button-outline',
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Non Transparent Header Button Text Color', 'gutener' ),
		'type'         => 'color',
		'settings'     => 'header_button_text_color',
		'section'      => 'header_style_options',
		'default'      => '#ffffff',
		'active_callback' => array(
			array(
				'setting'  => 'header_layout',
				'operator' => 'contains',
				'value'    => array( 'header_two', 'header_three' ),
			),
			array(
				'setting'  => 'disable_header_button',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Non Transparent Header Button Hover Color', 'gutener' ),
		'type'         => 'color',
		'settings'     => 'header_button_hover_color',
		'section'      => 'header_style_options',
		'default'      => '',
		'active_callback' => array(
			array(
				'setting'  => 'header_layout',
				'operator' => 'contains',
				'value'    => array( 'header_two', 'header_three' ),
			),
			array(
				'setting'  => 'disable_header_button',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Header Button Text', 'gutener' ),
		'type'         => 'text',
		'settings'     => 'header_button_text',
		'section'      => 'header_style_options',
		'default'      => '',
		'active_callback' => array(
			array(
				'setting'  => 'header_layout',
				'operator' => 'contains',
				'value'    => array( 'header_two', 'header_three' ),
			),
			array(
				'setting'  => 'disable_header_button',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Header Button Typography', 'gutener' ),
		'type'         => 'typography',
		'settings'     => 'header_buttons_font_control',
		'section'      => 'header_style_options',
		'default'  => array(
			'font-family'    => '',
			'variant'        => '600',
			'font-size'      => '14px',
			'text-transform' => 'none',
			'line-height'    => '1',
		),
		'transport'   => 'auto',
		'output'      => array(
			array(
				'element' => '.site-header .header-btn a',
			),
		),
		'active_callback' => array(
			array(
				'setting'  => 'header_layout',
				'operator' => 'contains',
				'value'    => array( 'header_two', 'header_three' ),
			),
			array(
				'setting'  => 'disable_header_button',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Button Target', 'gutener' ),
		'description' => esc_html__( 'If enabled, the page will be open in an another browser tab.', 'gutener' ),
		'type'        => 'checkbox',
		'settings'    => 'header_button_target',
		'section'     => 'header_style_options',
		'default'     => true,
		'active_callback' => array(
			array(
				'setting'  => 'header_layout',
				'operator' => 'contains',
				'value'    => array( 'header_two', 'header_three' ),
			),
			array(
				'setting'  => 'disable_header_button',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'    => esc_html__( 'Button Link', 'gutener' ),
		'type'     => 'link',
		'settings' => 'header_button_link',
		'section'  => 'header_style_options',
		'default'  => '',
		'active_callback' => array(
			array(
				'setting'  => 'header_layout',
				'operator' => 'contains',
				'value'    => array( 'header_two', 'header_three' ),
			),
			array(
				'setting'  => 'disable_header_button',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Button Border Radius (px)', 'gutener' ),
		'type'        => 'slider',
		'settings'    => 'header_button_border_radius',
		'section'     => 'header_style_options',
		'transport'   => 'postMessage',
		'default'     => 0,
		'choices'     => array(
			'min'  => 0,
			'max'  => 50,
			'step' => 1,
		),
		'active_callback' => array(
			array(
				'setting'  => 'header_layout',
				'operator' => 'contains',
				'value'    => array( 'header_two', 'header_three' ),
			),
			array(
				'setting'  => 'header_button_type',
				'operator' => 'contains',
				'value'    =>  array( 'button-primary', 'button-outline' ),
			),
			array(
				'setting'  => 'disable_header_button',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'    => esc_html__( 'Disable Search', 'gutener' ),
		'type'     => 'checkbox',
		'settings' => 'disable_search_icon',
		'section'  => 'header_style_options',
		'default'  => false,
	) );

	Kirki::add_field( 'gutener', array(
		'label'    => esc_html__( 'Disable Hamburger Widget Menu Icon', 'gutener' ),
		'type'     => 'checkbox',
		'settings' => 'disable_hamburger_menu_icon',
		'section'  => 'header_style_options',
		'default'  => false,
	) );

	// Header Media Options
	Kirki::add_section( 'header_wrap_media_options', array(
	    'title'      => esc_html__( 'Media', 'gutener' ),
	    'panel'      => 'header_options',	   
	    'capability' => 'edit_theme_options',
	    'priority'   => '30',
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Header Image Slider', 'gutener' ),
		'description' => esc_html__( 'Recommended image size 1920x550 pixel. Add only one image to make header banner.', 'gutener' ),
		'type'        => 'repeater',
		'section'     => 'header_wrap_media_options',
		'row_label' => array(
			'type'  => 'text',
		),
		'button_label' => esc_html__('Add New Image', 'gutener' ),
		'settings'     => 'header_image_slider',
		'default'      => array(
				array(
					'slider_item' 	=> '',
					)			
		),
		'fields' => array(
			'slider_item' => array(
				'label'       => esc_html__( 'Image', 'gutener' ),
				'type'        => 'image',
				'default'     => '',
				'choices'     => array(
					'save_as' => 'id',
				),
			)
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Background Image Size', 'gutener' ),
		'type'         => 'radio',
		'settings'     => 'header_image_size',
		'section'      => 'header_wrap_media_options',
		'default'      => 'cover',
		'choices'      => array(
			'cover'    => esc_html__( 'Cover', 'gutener' ),
			'pattern'  => esc_html__( 'Pattern / Repeat', 'gutener' ),
			'norepeat' => esc_html__( 'No Repeat', 'gutener' ),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Slide Effect', 'gutener' ),
		'type'        => 'select',
		'settings'    => 'header_slider_effect',
		'section'     => 'header_wrap_media_options',
		'default'     => 'fade',
		'choices'  => array(
			'fade'             => esc_html__( 'Fade', 'gutener' ),
			'horizontal-slide' => esc_html__( 'Slide', 'gutener' ),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Fade Control Time ( in sec )', 'gutener' ),
		'type'         => 'number',
		'settings'     => 'slider_header_fade_control',
		'section'      => 'header_wrap_media_options',
		'default'      => 5,
		'choices' => array(
				'min' => '3',
				'max' => '60',
				'step'=> '1',
		),
		'active_callback' => array(
			array(
				'setting'  => 'header_slider_effect',
				'operator' => '==',
				'value'    => 'fade',
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Disable Arrows', 'gutener' ),
		'type'         => 'checkbox',
		'settings'     => 'disable_header_slider_arrows',
		'section'      => 'header_wrap_media_options',
		'default'      => false,
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Disable Dots', 'gutener' ),
		'type'         => 'checkbox',
		'settings'     => 'disable_header_slider_dots',
		'section'      => 'header_wrap_media_options',
		'default'      => false,
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Disable Auto Play', 'gutener' ),
		'type'         => 'checkbox',
		'settings'     => 'disable_header_slider_autoplay',
		'section'      => 'header_wrap_media_options',
		'default'      => true,
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Auto Play Timeout ( in sec )', 'gutener' ),
		'type'         => 'number',
		'settings'     => 'slider_header_autoplay_speed',
		'section'      => 'header_wrap_media_options',
		'default'      => 4,
		'choices' => array(
				'min' => '1',
				'max' => '60',
				'step'=> '1',
		),
		'active_callback' => array(
			array(
				'setting'  => 'disable_header_slider_autoplay',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Disable Parallax Scrolling', 'gutener' ),
		'type'        => 'checkbox',
		'settings'    => 'disable_parallax_scrolling',
		'section'     => 'header_wrap_media_options',
		'default'     => true,
	) );

	// Header Elements Options
	Kirki::add_section( 'header_elements_options', array(
	    'title'      => esc_html__( 'Elements', 'gutener' ),
	    'panel'      => 'header_options',	   
	    'capability' => 'edit_theme_options',
	    'priority'   => '30',
	) );

	Kirki::add_field( 'gutener', array(
	    'type'        => 'custom',
	    'settings'    => 'fixed_header_separator',
	    'section'     => 'header_elements_options',
	    'default'     => esc_html__( 'Fixed Header Options', 'gutener' ),
	) );
	
	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Disable Fixed Header', 'gutener' ),
		'type'        => 'checkbox',
		'settings'    => 'disable_fixed_header',
		'section'     => 'header_elements_options',
		'default'     => true,
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Disable Logo', 'gutener' ),
		'type'         => 'checkbox',
		'settings'     => 'disable_fixed_header_logo',
		'section'      => 'header_elements_options',
		'default'      => false,
		'active_callback' => array(
			array(
				'setting'  => 'disable_fixed_header',
				'operator' => '==',
				'value'    => false,
			),
			array(
				'setting'  => 'header_layout',
				'operator' => 'contains',
				'value'    => array( 'header_two', 'header_three' ),
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Separate Logo for Fixed Header', 'gutener' ),
		'description'  => esc_html__( 'Image dimensions 320 by 120 pixels is recommended. It will change in fixed header only.', 'gutener' ),
		'type'         => 'image',
		'settings'     => 'fixed_header_separate_logo',
		'section'      => 'header_elements_options',
		'default'      => '',
		'choices'     => array(
			'save_as' => 'id',
		),
		'active_callback' => array(
			array(
				'setting'  => 'disable_fixed_header',
				'operator' => '==',
				'value'    => false,
			),
			array(
				'setting'  => 'disable_fixed_header_logo',
				'operator' => '==',
				'value'    => false,
			),
			array(
				'setting'  => 'header_layout',
				'operator' => 'contains',
				'value'    => array( 'header_two', 'header_three' ),
			),
		),

	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Logo Image Width', 'gutener' ),
		'type'         => 'slider',
		'settings'     => 'fixed_header_logo_width',
		'section'      => 'header_elements_options',
		'transport'    => 'postMessage',
		'default'      => 270,
		'choices'      => array(
			'min'  => 50,
			'max'  => 270,
			'step' => 5,
		),
		'active_callback' => array(
			array(
				'setting'  => 'disable_fixed_header_logo',
				'operator' => '==',
				'value'    => false,
			),
			array(
				'setting'  => 'disable_fixed_header',
				'operator' => '==',
				'value'    => false,
			),
			array(
				'setting'  => 'header_layout',
				'operator' => 'contains',
				'value'    => array( 'header_two', 'header_three' ),
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Disable Site Title', 'gutener' ),
		'type'         => 'checkbox',
		'settings'     => 'disable_fixed_header_site_title',
		'section'      => 'header_elements_options',
		'default'      => false,
		'active_callback' => array(
			array(
				'setting'  => 'disable_fixed_header',
				'operator' => '==',
				'value'    => false,
			),
			array(
				'setting'  => 'header_layout',
				'operator' => 'contains',
				'value'    => array( 'header_two', 'header_three' ),
			),
			array(
				'setting'  => 'disable_site_title',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Transparent Fixed Header Site Title Color', 'gutener' ),
		'type'         => 'color',
		'settings'     => 'site_title_color_fixed_header',
		'section'      => 'header_elements_options',
		'default'      => '',
		'active_callback' => array(
			array(
				'setting'  => 'header_layout',
				'operator' => '==',
				'value'    => 'header_three',
			),
			array(
				'setting'  => 'disable_fixed_header',
				'operator' => '==',
				'value'    => false,
			),
			array(
				'setting'  => 'disable_fixed_header_site_title',
				'operator' => '==',
				'value'    => false,
			),
			array(
				'setting'  => 'skin_select',
				'operator' => 'contains',
				'value'    => array( 'default', 'blackwhite' ),
			),
			array(
				'setting'  => 'disable_site_title',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Disable Site Tagline', 'gutener' ),
		'type'         => 'checkbox',
		'settings'     => 'disable_fixed_header_site_tagline',
		'section'      => 'header_elements_options',
		'default'      => false,
		'active_callback' => array(
			array(
				'setting'  => 'disable_fixed_header',
				'operator' => '==',
				'value'    => false,
			),
			array(
				'setting'  => 'header_layout',
				'operator' => 'contains',
				'value'    => array( 'header_two', 'header_three' ),
			),
			array(
				'setting'  => 'disable_site_tagline',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Disable Site Tagline Border', 'gutener' ),
		'type'         => 'checkbox',
		'settings'     => 'disable_fixed_header_site_tagline_border',
		'section'      => 'header_elements_options',
		'default'      => true,
		'active_callback' => array(
			array(
				'setting'  => 'disable_fixed_header',
				'operator' => '==',
				'value'    => false,
			),
			array(
				'setting'  => 'header_layout',
				'operator' => 'contains',
				'value'    => array( 'header_two', 'header_three' ),
			),
			array(
				'setting'  => 'disable_site_tagline',
				'operator' => '==',
				'value'    => false,
			),
			array(
				'setting'  => 'disable_site_tagline_border',
				'operator' => '==',
				'value'    => false,
			),
			array(
				'setting'  => 'disable_fixed_header_site_tagline',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Transparent Fixed Header Site Tagline Color', 'gutener' ),
		'type'         => 'color',
		'settings'     => 'site_tagline_color_fixed_header',
		'section'      => 'header_elements_options',
		'default'      => '',
		'active_callback' => array(
			array(
				'setting'  => 'header_layout',
				'operator' => '==',
				'value'    => 'header_three',
			),
			array(
				'setting'  => 'disable_fixed_header',
				'operator' => '==',
				'value'    => false,
			),
			array(
				'setting'  => 'disable_fixed_header_site_tagline',
				'operator' => '==',
				'value'    => false,
			),
			array(
				'setting'  => 'skin_select',
				'operator' => 'contains',
				'value'    => array( 'default', 'blackwhite' ),
			),
			array(
				'setting'  => 'disable_site_tagline',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Transparent Fixed Header Background Color', 'gutener' ),
		'type'         => 'color',
		'settings'     => 'bg_color_fixed_header',
		'section'      => 'header_elements_options',
		'default'      => '',
		'active_callback' => array(
			array(
				'setting'  => 'header_layout',
				'operator' => '==',
				'value'    => 'header_three',
			),
			array(
				'setting'  => 'disable_fixed_header',
				'operator' => '==',
				'value'    => false,
			),
			array(
				'setting'  => 'skin_select',
				'operator' => 'contains',
				'value'    => array( 'default', 'blackwhite' ),
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Transparent Fixed Header Text Color', 'gutener' ),
		'type'         => 'color',
		'settings'     => 'text_color_fixed_header',
		'section'      => 'header_elements_options',
		'default'      => '',
		'active_callback' => array(
			array(
				'setting'  => 'header_layout',
				'operator' => '==',
				'value'    => 'header_three',
			),
			array(
				'setting'  => 'disable_fixed_header',
				'operator' => '==',
				'value'    => false,
			),
			array(
				'setting'  => 'skin_select',
				'operator' => 'contains',
				'value'    => array( 'default', 'blackwhite' ),
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Transparent Fixed Header Text Hover Color', 'gutener' ),
		'type'         => 'color',
		'settings'     => 'text_hover_color_fixed_header',
		'section'      => 'header_elements_options',
		'default'      => '',
		'active_callback' => array(
			array(
				'setting'  => 'header_layout',
				'operator' => '==',
				'value'    => 'header_three',
			),
			array(
				'setting'  => 'disable_fixed_header',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Transparent Fixed Header Button Background Color', 'gutener' ),
		'type'         => 'color',
		'settings'     => 'fixed_header_button_background_color',
		'section'      => 'header_elements_options',
		'default'      => '',
		'active_callback' => array(
			array(
				'setting'  => 'header_layout',
				'operator' => '==',
				'value'    => 'header_three',
			),
			array(
				'setting'  => 'header_button_type',
				'operator' => '==',
				'value'    => 'button-primary',
			),
			array(
				'setting'  => 'disable_header_button',
				'operator' => '==',
				'value'    => false,
			),
			array(
				'setting'  => 'disable_fixed_header',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Transparent Fixed Header Button Border Color', 'gutener' ),
		'type'         => 'color',
		'settings'     => 'fixed_header_button_border_color',
		'section'      => 'header_elements_options',
		'default'      => '',
		'active_callback' => array(
			array(
				'setting'  => 'header_layout',
				'operator' => '==',
				'value'    => 'header_three',
			),
			array(
				'setting'  => 'header_button_type',
				'operator' => '==',
				'value'    => 'button-outline',
			),
			array(
				'setting'  => 'disable_header_button',
				'operator' => '==',
				'value'    => false,
			),
			array(
				'setting'  => 'disable_fixed_header',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Transparent Fixed Header Button Text Color', 'gutener' ),
		'type'         => 'color',
		'settings'     => 'fixed_header_button_text_color',
		'section'      => 'header_elements_options',
		'default'      => '',
		'active_callback' => array(
			array(
				'setting'  => 'header_layout',
				'operator' => '==',
				'value'    => 'header_three',
			),
			array(
				'setting'  => 'disable_header_button',
				'operator' => '==',
				'value'    => false,
			),
			array(
				'setting'  => 'disable_fixed_header',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Transparent Fixed Header Button Hover Color', 'gutener' ),
		'type'         => 'color',
		'settings'     => 'fixed_header_button_hover_color',
		'section'      => 'header_elements_options',
		'default'      => '',
		'active_callback' => array(
			array(
				'setting'  => 'header_layout',
				'operator' => '==',
				'value'    => 'header_three',
			),
			array(
				'setting'  => 'disable_header_button',
				'operator' => '==',
				'value'    => false,
			),
			array(
				'setting'  => 'disable_fixed_header',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	// Top Notification Options
	Kirki::add_section( 'notification_bar_options', array(
	    'title'      => esc_html__( 'Top Notification Bar', 'gutener' ),
	    'panel'      => 'header_options',
	    'capability' => 'edit_theme_options',
	    'priority'   => '40',
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Disable Header Notification Bar', 'gutener' ),
		'type'        => 'checkbox',
		'settings'    => 'disable_notification_bar',
		'section'     => 'notification_bar_options',
		'default'     => true,
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Background Color', 'gutener' ),
		'type'         => 'color',
		'settings'     => 'notification_bar_background_color',
		'section'      => 'notification_bar_options',
		'default'      => '#1a1a1a',
		'active_callback' => array(
			array(
				'setting'  => 'disable_notification_bar',
				'operator' => '==',
				'value'    => false,
			),
			array(
				'setting'  => 'skin_select',
				'operator' => 'contains',
				'value'    => array( 'default', 'blackwhite' ),
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Title Text Color', 'gutener' ),
		'type'         => 'color',
		'settings'     => 'notification_bar_title_color',
		'section'      => 'notification_bar_options',
		'default'      => '#ffffff',
		'active_callback' => array(
			array(
				'setting'  => 'disable_notification_bar',
				'operator' => '==',
				'value'    => false,
			),
			array(
				'setting'  => 'skin_select',
				'operator' => 'contains',
				'value'    => array( 'default', 'blackwhite' ),
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Section Height (in px)', 'gutener' ),
		'description' => esc_html__( 'This option will only apply to Desktop. Please click on below Desktop Icon to see changes. Automatically adjust by theme default in the responsive devices.
		', 'gutener' ),
		'type'        => 'slider',
		'settings'    => 'notification_bar_height',
		'section'     => 'notification_bar_options',
		'transport'   => 'postMessage',
		'default'     => 40,
		'choices'     => array(
			'min'  => 10,
			'max'  => 300,
			'step' => 1,
		),
		'active_callback' => array(
			array(
				'setting'  => 'disable_notification_bar',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'    => esc_html__( 'Title', 'gutener' ),
		'type'     => 'text',
		'settings' => 'notification_bar_title',
		'section'  => 'notification_bar_options',
		'default'  => '',
		'active_callback' => array(
			array(
				'setting'  => 'disable_notification_bar',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Title Typography', 'gutener' ),
		'type'         => 'typography',
		'settings'     => 'notification_bar_title_font_control',
		'section'      => 'notification_bar_options',
		'default'  => array(
			'font-family'    => '',
			'variant'        => 'regular',
			'font-size'      => '13px',
			'text-transform' => 'none',
			'line-height'    => '1.3',
		),
		'transport'   => 'auto',
		'output'      => array(
			array(
				'element' => '.notification-bar .notification-content',
			),
		),
		'active_callback' => array(
			array(
				'setting'  => 'disable_notification_bar',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Disable Notification Button', 'gutener' ),
		'type'        => 'checkbox',
		'settings'    => 'disable_notification_bar_button_one',
		'section'     => 'notification_bar_options',
		'default'     => false,
		'active_callback' => array(
			array(
				'setting'  => 'disable_notification_bar',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Button Type', 'gutener' ),
		'type'        => 'select',
		'settings'    => 'notification_bar_button_type',
		'section'     => 'notification_bar_options',
		'default'     => 'button-primary',
		'choices'  => array(
			'button-primary' => esc_html__( 'Primary Button', 'gutener' ),
			'button-outline' => esc_html__( 'Border Button', 'gutener' ),
			'button-text'    => esc_html__( 'Text Only Button', 'gutener' ),
		),
		'active_callback' => array(
			array(
				'setting'  => 'disable_notification_bar',
				'operator' => '==',
				'value'    => false,
			),
			array(
				'setting'  => 'disable_notification_bar_button_one',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Button Background Color', 'gutener' ),
		'type'         => 'color',
		'settings'     => 'notification_bar_button_background_color',
		'section'      => 'notification_bar_options',
		'default'      => '#f9a032',
		'active_callback' => array(
			array(
				'setting'  => 'disable_notification_bar',
				'operator' => '==',
				'value'    => false,
			),
			array(
				'setting'  => 'disable_notification_bar_button_one',
				'operator' => '==',
				'value'    => false,
			),
			array(
				'setting'  => 'notification_bar_button_type',
				'operator' => '==',
				'value'    => 'button-primary',
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Button Border Color', 'gutener' ),
		'type'         => 'color',
		'settings'     => 'notification_bar_button_border_color',
		'section'      => 'notification_bar_options',
		'default'      => '',
		'active_callback' => array(
			array(
				'setting'  => 'disable_notification_bar',
				'operator' => '==',
				'value'    => false,
			),
			array(
				'setting'  => 'disable_notification_bar_button_one',
				'operator' => '==',
				'value'    => false,
			),
			array(
				'setting'  => 'notification_bar_button_type',
				'operator' => '==',
				'value'    => 'button-outline',
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Button Text Color', 'gutener' ),
		'type'         => 'color',
		'settings'     => 'notification_bar_button_text_color',
		'section'      => 'notification_bar_options',
		'default'      => '#ffffff',
		'active_callback' => array(
			array(
				'setting'  => 'disable_notification_bar',
				'operator' => '==',
				'value'    => false,
			),
			array(
				'setting'  => 'disable_notification_bar_button_one',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Button Hover Color', 'gutener' ),
		'type'         => 'color',
		'settings'     => 'notification_bar_button_hover_color',
		'section'      => 'notification_bar_options',
		'default'      => '',
		'active_callback' => array(
			array(
				'setting'  => 'disable_notification_bar',
				'operator' => '==',
				'value'    => false,
			),
			array(
				'setting'  => 'disable_notification_bar_button_one',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'    => esc_html__( 'Button Text', 'gutener' ),
		'type'     => 'text',
		'settings' => 'notification_bar_button_text',
		'section'  => 'notification_bar_options',
		'default'  => '',
		'active_callback' => array(
			array(
				'setting'  => 'disable_notification_bar',
				'operator' => '==',
				'value'    => false,
			),
			array(
				'setting'  => 'disable_notification_bar_button_one',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Button Typography', 'gutener' ),
		'type'         => 'typography',
		'settings'     => 'notification_bar_buttons_font_control',
		'section'      => 'notification_bar_options',
		'default'  => array(
			'font-family'    => '',
			'variant'        => '500',
			'font-size'      => '13px',
			'text-transform' => 'none',
			'line-height'    => '1',
		),
		'transport'   => 'auto',
		'output'      => array(
			array(
				'element' => '.notification-bar .button-container a',
			),
		),
		'active_callback' => array(
			array(
				'setting'  => 'disable_notification_bar',
				'operator' => '==',
				'value'    => false,
			),
			array(
				'setting'  => 'disable_notification_bar_button_one',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Button Target', 'gutener' ),
		'description' => esc_html__( 'If enabled, the page will be open in an another browser tab.', 'gutener' ),
		'type'        => 'checkbox',
		'settings'    => 'notification_bar_button_target',
		'section'     => 'notification_bar_options',
		'default'     => true,
		'active_callback' => array(
			array(
				'setting'  => 'disable_notification_bar',
				'operator' => '==',
				'value'    => false,
			),
			array(
				'setting'  => 'disable_notification_bar_button_one',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'    => esc_html__( 'Button Link', 'gutener' ),
		'type'     => 'link',
		'settings' => 'notification_bar_button_link',
		'section'  => 'notification_bar_options',
		'default'  => '',
		'active_callback' => array(
			array(
				'setting'  => 'disable_notification_bar',
				'operator' => '==',
				'value'    => false,
			),
			array(
				'setting'  => 'disable_notification_bar_button_one',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );
	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Button Border Radius (px)', 'gutener' ),
		'type'        => 'slider',
		'settings'    => 'notification_bar_button_border_radius',
		'section'     => 'notification_bar_options',
		'transport'   => 'postMessage',
		'default'     => 0,
		'choices'     => array(
			'min'  => 0,
			'max'  => 50,
			'step' => 1,
		),
		'active_callback' => array(
			array(
				'setting'  => 'disable_notification_bar',
				'operator' => '==',
				'value'    => false,
			),
			array(
				'setting'  => 'disable_notification_bar_button_one',
				'operator' => '==',
				'value'    => false,
			),
			array(
				'setting'  => 'notification_bar_button_type',
				'operator' => 'contains',
				'value'    => array( 'button-primary', 'button-outline' ),
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'    => esc_html__( 'Disable Sticky Position', 'gutener' ),
		'type'     => 'checkbox',
		'settings' => 'disable_sticky_notification_bar',
		'section'  => 'notification_bar_options',
		'default'  => false,
		'active_callback' => array(
			array(
				'setting'  => 'disable_notification_bar',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	// Responsive
	Kirki::add_section( 'header_responsive', array(
	    'title'      => esc_html__( 'Responsive', 'gutener' ),
	    'description'    => esc_html__( 'These options will only apply to Tablet and Mobile devices. Please
	    	click on below Tablet or Mobile Icons to see changes.', 'gutener' ),
	    'capability' => 'edit_theme_options',
	    'priority'   => '80',
	    'panel'      => 'header_options',
	) );

	Kirki::add_field( 'gutener', array(
		'label'       		=> esc_html__( 'Disable Header Notification Bar', 'gutener' ),
		'type'        		=> 'checkbox',
		'settings'    		=> 'disable_mobile_notification_bar',
		'section'     		=> 'header_responsive',
		'default'     		=> true,
		'active_callback'	=> array(
			array(
				'setting'  => 'disable_notification_bar',
				'operator' => '=',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'       		=> esc_html__( 'Disable Sticky Header Notification Bar', 'gutener' ),
		'type'        		=> 'checkbox',
		'settings'    		=> 'disable_sticky_mobile_notification_bar',
		'section'     		=> 'header_responsive',
		'default'     		=> true,
		'active_callback'	=> array(
			array(
				'setting'  => 'disable_notification_bar',
				'operator' => '=',
				'value'    => false,
			),
			array(
				'setting'  => 'disable_mobile_notification_bar',
				'operator' => '=',
				'value'    => false,
			),
			array(
				'setting'  => 'disable_sticky_notification_bar',
				'operator' => '=',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Disable Top Header Menu Section', 'gutener' ),
		'type'         => 'checkbox',
		'settings'     => 'disable_mobile_top_header',
		'section'      => 'header_responsive',
		'default'      => true,
	) );

	Kirki::add_field( 'gutener', array(	
		'label'       => esc_html__( 'Top Header Menu Name', 'gutener' ),
		'type'        => 'text',
		'settings'    => 'top_bar_name',
		'section'     => 'header_responsive',
		'default'     => esc_html__( 'TOP MENU', 'gutener' ),
		'active_callback' => array(
			array(
				'setting'  => 'disable_mobile_top_header',
				'operator' => '=',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Header Menu Text', 'gutener' ),
		'type'         => 'text',
		'settings'     => 'responsive_header_menu_text',
		'section'      => 'header_responsive',
		'default'      => esc_html__( 'MENU', 'gutener' ),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Disable Top Header Section Border', 'gutener' ),
		'type'         => 'checkbox',
		'settings'     => 'disable_mobile_top_header_border',
		'section'      => 'header_responsive',
		'default'      => true,
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Disable Mid Header Section Border', 'gutener' ),
		'type'         => 'checkbox',
		'settings'     => 'disable_mobile_mid_header_border',
		'section'      => 'header_responsive',
		'default'      => false,
		'active_callback' => array(
			array(
				'setting'  => 'header_layout',
				'operator' => 'contains',
				'value'    => array( 'header_one', 'header_two' ),
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Disable Fixed Header', 'gutener' ),
		'type'        => 'checkbox',
		'settings'    => 'disable_mobile_fixed_header',
		'section'     => 'header_responsive',
		'default'     => true,
		'active_callback' => array(
			array(
				'setting'  => 'disable_fixed_header',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Disable Header Contact Details', 'gutener' ),
		'type'        => 'checkbox',
		'settings'    => 'disable_mobile_contact_details',
		'section'     => 'header_responsive',
		'default'     => false,
		'active_callback' => array(
			array(
				'setting'  => 'disable_contact_detail',
				'operator' => '==',
				'value'    => false,
			),
			array(
				'setting'  => 'disable_mobile_top_header',
				'operator' => '=',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Disable Header Search', 'gutener' ),
		'type'        => 'checkbox',
		'settings'    => 'disable_mobile_search_icon',
		'section'     => 'header_responsive',
		'default'     => false,
		'active_callback' => array(
			array(
				'setting'  => 'disable_search_icon',
				'operator' => '==',
				'value'    => false,
			),
			array(
				'setting'  => 'disable_mobile_top_header',
				'operator' => '=',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Disable Header Button', 'gutener' ),
		'type'        => 'checkbox',
		'settings'    => 'disable_mobile_header_buttons',
		'section'     => 'header_responsive',
		'default'     => false,
		'active_callback' => array(
			array(
				'setting'  => 'disable_header_button',
				'operator' => '==',
				'value'    => false,
			),
			array(
				'setting'  => 'header_layout',
				'operator' => 'contains',
				'value'    => array( 'header_two', 'header_three' ),
			),
			array(
				'setting'  => 'disable_mobile_top_header',
				'operator' => '=',
				'value'    => false,
			),
		),
	) );


	// Theme Skin Options
	Kirki::add_section( 'skins_options', array(
	    'title'      => esc_html__( 'Site Skins', 'gutener' ),
	    'description' => esc_html__( 'All color options except primary color will be overridden by the theme in dark and B&W skin.', 'gutener' ),
	    'capability' => 'edit_theme_options',
	    'priority'   => '80',
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Select Theme Skin', 'gutener' ),
		'type'        => 'select',
		'settings'    => 'skin_select',
		'section'     => 'skins_options',
		'default'     => 'default',
		'choices'  => array(
			'default'    => esc_html__( 'Default', 'gutener' ),
			'dark'       => esc_html__( 'Dark', 'gutener' ),
			'blackwhite' => esc_html__( 'Black & White', 'gutener' ),
		)
	) );

	// Social Media Options
	Kirki::add_panel( 'social_media_options', array(
	    'title'          => esc_html__( 'Social Media', 'gutener' ),
	    'priority'       => '96',
	) );

	Kirki::add_section( 'social_media_elements_options', array(
	    'title'          => esc_html__( 'Elements', 'gutener' ),
	    'capability'     => 'edit_theme_options',
	    'priority'       => '10',
	    'panel'			 => 'social_media_options',		
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Disable from Header', 'gutener' ),
		'type'         => 'checkbox',
		'settings'     => 'disable_header_social_links',
		'section'      => 'social_media_elements_options',
		'default'      => false,
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Disable from Footer', 'gutener' ),
		'type'         => 'checkbox',
		'settings'     => 'disable_footer_social_links',
		'section'      => 'social_media_elements_options',
		'default'      => false,
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Footer Social Icons Size', 'gutener' ),
		'description' => esc_html__( 'Only applicable to the footer social icons.', 'gutener' ),
		'type'        => 'slider',
		'settings'    => 'social_icons_size',
		'section'     => 'social_media_elements_options',
		'transport'   => 'postMessage',
		'default'     => 15,
		'choices'     => array(
			'min'  => 10,
			'max'  => 100,
			'step' => 1,
		),
		'active_callback' => array(
			array(
				'setting'  => 'disable_footer_social_links',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Social Links', 'gutener' ),
		'type'        => 'repeater',
		'description' => esc_html__( 'By default, Social Icons will appear in both header and footer section.', 'gutener' ),
		'section'     => 'social_media_elements_options',
		'row_label' => array(
			'type'  => 'text',
			'value' => esc_html__( 'Social Link', 'gutener' ),
		),
		'settings' => 'social_media_links',
		'default' => array(
			array(
				'icon' 		=> '',
				'link' 		=> '',
				'new_tab' 	=> false,
				),		
		),
		'fields' => array(
			'icon' => array(
				'label'       => esc_html__( 'Fontawesome Icon', 'gutener' ),
				'type'        => 'text',
				'description' => esc_html__( 'Input Icon name. For Example:- fab fa-facebook For more icons https://fontawesome.com/icons?d=gallery&m=free', 'gutener' ),
			),
			'link' => array(
				'label'       => esc_html__( 'Link', 'gutener' ),
				'type'        => 'text',
			),
			'new_tab' => array(
				'label'       => esc_html__( 'Open Link in New Window', 'gutener' ),
				'type'        => 'checkbox',
			),			
		),
		'choices' => array(
			'limit' => 20,
		),
	) );

	// Responsive
	Kirki::add_section( 'social_responsive', array(
	    'title'          => esc_html__( 'Responsive', 'gutener' ),
	    'description'    => esc_html__( 'These options will only apply to Tablet and Mobile devices. Please
	    	click on below Tablet or Mobile Icons to see changes.', 'gutener' ),
	    'capability'     => 'edit_theme_options',
	    'priority'       => '20',
	    'panel'			 => 'social_media_options',		
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Disable Social Icons from Header', 'gutener' ),
		'type'        => 'checkbox',
		'settings'    => 'disable_mobile_social_icons_header',
		'section'     => 'social_responsive',
		'default'     => false,
		'active_callback' => array(
			array(
				'setting'  => 'disable_header_social_links',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Disable Social Icons from Footer', 'gutener' ),
		'type'        => 'checkbox',
		'settings'    => 'disable_mobile_social_icons_footer',
		'section'     => 'social_responsive',
		'default'     => false,
		'active_callback' => array(
			array(
				'setting'  => 'disable_footer_social_links',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	//Typography Options
	Kirki::add_section( 'typography', array(
	    'title'          => esc_html__( 'Typography', 'gutener' ),
	    'capability'     => 'edit_theme_options',
	    'priority'       => '95',
	    'reset'          => 'typography',
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Site Title', 'gutener' ),
		'type'         => 'typography',
		'settings'     => 'site_title_font_control',
		'section'      => 'typography',
		'default'  => array(
			'font-family'    => 'Poppins',
			'variant'        => '600',
			'font-size'      => '22px',
			'text-transform' => 'none',
		),
		'transport'   => 'auto',
		'output'      => array(
			array(
				'element' => '.site-header .site-branding .site-title',
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Site Description', 'gutener' ),
		'type'         => 'typography',
		'settings'     => 'site_description_font_control',
		'section'      => 'typography',
		'default'  => array(
			'font-family'    => 'Open Sans',
			'variant'        => 'normal',
			'font-size'      => '14px',
			'text-transform' => 'none',
		),
		'transport'   => 'auto',
		'output'   => array(
			array(
				'element' => '.site-header .site-branding .site-description',
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Main Menu', 'gutener' ),
		'type'         => 'typography',
		'settings'     => 'main_menu_font_control',
		'section'      => 'typography',
		'default'  => array(
			'font-family'    => 'Open Sans',
			'font-size'      => '15px',
			'text-transform' => 'uppercase',
			'variant'        => '600',
			'line-height'    => '1.5',
		),
		'transport'   => 'auto',
		'output'   => array(
			array(
				'element' => array( '.main-navigation ul.menu li a', '.slicknav_menu .slicknav_nav li a' )
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
	    'type'        => 'custom',
	    'settings'    => 'main_menu_description_info',
	    'section'     => 'typography',
	    'default'     => esc_html__( 'Below Main Menu Description setting will work after enabling description section in the menu. Please check http://keonthemes.com/doc/gutener/ Documentation for more information.', 'gutener' ),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Main Menu Description', 'gutener' ),
		'type'         => 'typography',
		'settings'     => 'main_menu_description_font_control',
		'section'      => 'typography',
		'default'  => array(
			'font-family'    => 'Open Sans',
			'font-size'      => '11px',
			'text-transform' => 'none',
			'variant'        => 'normal',
			'line-height'    => '1.3',
		),
		'transport'   => 'auto',
		'output'   => array(
			array(
				'element' => array( '.main-navigation .menu-description, .slicknav_menu .menu-description' ),
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Body', 'gutener' ),
		'type'         => 'typography',
		'settings'     => 'body_font_control',
		'section'      => 'typography',
		'default'  => array(
			'font-family'    => 'Open Sans',
			'variant'        => 'normal',
			'font-size'      => '15px',
		),
		'transport'   => 'auto',
		'output' => array( 
			array(
				'element' => 'body',
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'General Title (H1 - H6)', 'gutener' ),
		'type'         => 'typography',
		'settings'     => 'general_title_font_control',
		'section'      => 'typography',
		'default'  => array(
			'font-family'    => 'Poppins',
			'text-transform' => 'none',
		),
		'transport'   => 'auto',
		'output'   => array(
			array(
				'element' => array( 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'span.woocommerce-Price-amount.amount', '.button-primary', '.button-outline', '.button-text', 'button', '.woocommerce a.added_to_cart', 'body.woocommerce a.button', 'input[type="submit"]', '.product-title' ),
			),
		),	
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Page & Single Post Title', 'gutener' ),
		'type'         => 'typography',
		'settings'     => 'page_title_font_control',
		'section'      => 'typography',
		'default'  => array(
			'font-family'    => 'Poppins',
			'variant'        => '600',
			'font-size'      => '48px',
			'text-transform' => 'none',
		),
		'transport'   => 'auto',
		'output'   => array(
			array(
				'element' => array( '.page-title' ),
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Homepage Section Title', 'gutener' ),
		'type'         => 'typography',
		'settings'     => 'section_title_font_control',
		'section'      => 'typography',
		'default'  => array(
			'font-family'    => 'Poppins',
			'font-size'      => '24px',
			'variant'        => '500',
			'text-transform' => 'none',
		),
		'transport'   => 'auto',
		'output'   => array(
			array(
				'element' => 'h2.section-title',
			),
		),
	) );

	// Site Layouts Options
	Kirki::add_panel( 'site_layout_options', array(
	    'title' => esc_html__( 'Site Layouts', 'gutener' ),
	    'priority' => '90',
	) );

	Kirki::add_section( 'site_layout_style_options', array(
	    'title'          => esc_html__( 'Style', 'gutener' ),
	    'panel'          => 'site_layout_options',
	    'capability'     => 'edit_theme_options',
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Site Layouts', 'gutener' ),
		'description' => esc_html__( 'Default / Box / Frame / Full / Compact / Standard', 'gutener' ),
		'type'        => 'radio-image',
		'settings'    => 'site_layout',
		'section'     => 'site_layout_style_options',
		'default'     => 'standard',
		'choices'  => array(
			'default' => get_template_directory_uri() . '/assets/images/default-layout.png',
			'box'     => get_template_directory_uri() . '/assets/images/box-layout.png',
			'frame'   => get_template_directory_uri() . '/assets/images/frame-layout.png',
			'full'    => get_template_directory_uri() . '/assets/images/full-layout.png',
			'compact' => get_template_directory_uri() . '/assets/images/compact-layout.png',
			'standard'=> get_template_directory_uri() . '/assets/images/standard-layout.png',
		),
	) );

	Kirki::add_section( 'site_layout_elements_options', array(
	    'title'          => esc_html__( 'Elements', 'gutener' ),
	    'panel'          => 'site_layout_options',
	    'capability'     => 'edit_theme_options',
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Disable Site Layouts (Box & Frame) Shadow', 'gutener' ),
		'type'         => 'checkbox',
		'settings'     => 'disable_site_layout_shadow',
		'section'      => 'site_layout_elements_options',
		'default'      => false,
		'active_callback' => array(
			array(
				'setting'  => 'site_layout',
				'operator' => 'contains',
				'value'    => array( 'box', 'frame' ),
			),
		),
	) );

	// Sidebar Options
	Kirki::add_section( 'sidebar_options', array(
	    'title'          => esc_html__( 'Sidebar', 'gutener' ),
	    'capability'     => 'edit_theme_options',
	    'priority'       => '98',
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Sidebar Layouts', 'gutener' ),
		'description' => esc_html__( 'Right / Left / Both / None', 'gutener' ),
		'type'        => 'radio-image',
		'settings'    => 'sidebar_settings',
		'section'     => 'sidebar_options',
		'default'     => 'right',
		'choices'  => array(
			'right'      => get_template_directory_uri() . '/assets/images/right-sidebar.png',
			'left'       => get_template_directory_uri() . '/assets/images/left-sidebar.png',
			'right-left' => get_template_directory_uri() . '/assets/images/right-left-sidebar.png',
			'no-sidebar' => get_template_directory_uri() . '/assets/images/no-sidebar.png',
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Widget Title Typography', 'gutener' ),
		'type'         => 'typography',
		'settings'     => 'sidebar_widget_title_font_control',
		'section'      => 'sidebar_options',
		'default'  => array(
			'font-family'    => '',
			'variant'        => '500',
			'font-size'      => '16px',
			'text-transform' => 'uppercase',
			'line-height'    => '1.4',
		),
		'transport'   => 'auto',
		'output'      => array(
			array(
				'element' => '.sidebar .widget .widget-title',
			),
		),
		'active_callback' => array(
			array(
				'setting'  => 'sidebar_settings',
				'operator' => 'contains',
				'value'    => array( 'right', 'left', 'right-left' ),
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Disable Sidebar Widget Title Border', 'gutener' ),
		'type'         => 'checkbox',
		'settings'     => 'disable_sidebar_widget_title_border',
		'section'      => 'sidebar_options',
		'default'      => false,
		'active_callback' => array(
			array(
				'setting'  => 'sidebar_settings',
				'operator' => 'contains',
				'value'    => array( 'right', 'left', 'right-left' ),
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Disable Sticky Position', 'gutener' ),
		'type'         => 'checkbox',
		'settings'     => 'disable_sticky_sidebar',
		'section'      => 'sidebar_options',
		'default'      => false,
		'active_callback' => array(
			array(
				'setting'  => 'sidebar_settings',
				'operator' => 'contains',
				'value'    => array( 'right', 'left', 'right-left' ),
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Disable Sidebar in Blog Page', 'gutener' ),
		'type'        => 'checkbox',
		'settings'    => 'disable_sidebar_blog_page',
		'section'     => 'sidebar_options',
		'default'     => false,
		'active_callback' => array(
			array(
				'setting'  => 'sidebar_settings',
				'operator' => 'contains',
				'value'    => array( 'right', 'left', 'right-left' ),
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Disable Sidebar in Single Post', 'gutener' ),
		'type'        => 'checkbox',
		'settings'    => 'disable_sidebar_single_post',
		'section'     => 'sidebar_options',
		'default'     => false,
		'active_callback' => array(
			array(
				'setting'  => 'sidebar_settings',
				'operator' => 'contains',
				'value'    => array( 'right', 'left', 'right-left' ),
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Disable Sidebar in Page', 'gutener' ),
		'type'        => 'checkbox',
		'settings'    => 'disable_sidebar_page',
		'section'     => 'sidebar_options',
		'default'     => true,
		'active_callback' => array(
			array(
				'setting'  => 'sidebar_settings',
				'operator' => 'contains',
				'value'    => array( 'right', 'left', 'right-left' ),
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Disable Sidebar in WooCommerce Page', 'gutener' ),
		'type'        => 'checkbox',
		'settings'    => 'disable_sidebar_woocommerce_page',
		'section'     => 'sidebar_options',
		'default'     => false,
		'active_callback' => array(
			array(
				'setting'  => 'sidebar_settings',
				'operator' => 'contains',
				'value'    => array( 'right', 'left', 'right-left' ),
			),
		),
	) );

	// Footer Options
	Kirki::add_panel( 'footer_options', array(
	    'title' => esc_html__( 'Footer', 'gutener' ),
	    'priority' => '110',
	) );

	// Footer Widgets Options
	Kirki::add_section( 'footer_widgets_options', array(
	    'title'          => esc_html__( 'Footer Widgets', 'gutener' ),
	    'panel'          => 'footer_options',
	    'capability'     => 'edit_theme_options',
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Disable Footer Widget Area', 'gutener' ),
		'type'         => 'checkbox',
		'settings'     => 'disable_footer_widget',
		'section'      => 'footer_widgets_options',
		'default'      => false,
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Disable Footer Widget Title Border', 'gutener' ),
		'type'         => 'checkbox',
		'settings'     => 'disable_footer_widget_title_border',
		'section'      => 'footer_widgets_options',
		'default'      => false,
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Disable Footer Widget Item List Border ', 'gutener' ),
		'type'         => 'checkbox',
		'settings'     => 'disable_footer_widget_list_item_border',
		'section'      => 'footer_widgets_options',
		'default'      => false,
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Widget Columns Layouts', 'gutener' ),
		'type'        => 'radio-image',
		'settings'    => 'top_footer_widget_columns',
		'section'     => 'footer_widgets_options',
		'default'     => 'four_columns',
		'choices'  => array(
			'four_columns'  => get_template_directory_uri() . '/assets/images/widget-layout-1.png',
			'three_columns'	=> get_template_directory_uri() . '/assets/images/widget-layout-2.png',
			'two_columns'	=> get_template_directory_uri() . '/assets/images/widget-layout-3.png',
			'one_column' 	=> get_template_directory_uri() . '/assets/images/widget-layout-4.png',
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Footer Widget Area Top Padding(in px)', 'gutener' ),
		'type'         => 'number',
		'settings'     => 'footer_widget_area_top_padding',
		'section'      => 'footer_widgets_options',
		'default'      => 0,
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Footer Widget Area Bottom Padding(in px)', 'gutener' ),
		'type'         => 'number',
		'settings'     => 'footer_widget_area_bottom_padding',
		'section'      => 'footer_widgets_options',
		'default'      => 50,
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Section Background Color', 'gutener' ),
		'description'  => esc_html__( 'It can be used as a transparent background color over image.', 'gutener' ),
		'type'         => 'color',
		'settings'     => 'top_footer_background_color',
		'section'      => 'footer_widgets_options',
		'default'      => '',
		'active_callback' => array(
			array(
				'setting'  => 'skin_select',
				'operator' => 'contains',
				'value'    => array( 'default', 'blackwhite' ),
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Widget Title Color', 'gutener' ),
		'type'         => 'color',
		'settings'     => 'top_footer_widget_title_color',
		'section'      => 'footer_widgets_options',
		'default'      => '#030303',
		'active_callback' => array(
			array(
				'setting'  => 'skin_select',
				'operator' => 'contains',
				'value'    => array( 'default', 'blackwhite' ),
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Widgets Link Color', 'gutener' ),
		'type'         => 'color',
		'settings'     => 'top_footer_widget_link_color',
		'section'      => 'footer_widgets_options',
		'default'      => '#656565',
		'active_callback' => array(
			array(
				'setting'  => 'skin_select',
				'operator' => 'contains',
				'value'    => array( 'default', 'blackwhite' ),
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Widgets Content Color', 'gutener' ),
		'type'         => 'color',
		'settings'     => 'top_footer_widget_content_color',
		'section'      => 'footer_widgets_options',
		'default'      => '#656565',
		'active_callback' => array(
			array(
				'setting'  => 'skin_select',
				'operator' => 'contains',
				'value'    => array( 'default', 'blackwhite' ),
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Widgets Link Hover Color', 'gutener' ),
		'type'         => 'color',
		'settings'     => 'top_footer_widget_link_hover_color',
		'section'      => 'footer_widgets_options',
		'default'      => '',
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Widget Title Typography', 'gutener' ),
		'type'         => 'typography',
		'settings'     => 'footer_widget_title_font_control',
		'section'      => 'footer_widgets_options',
		'default'  => array(
			'font-family'    => '',
			'variant'        => '500',
			'font-size'      => '18px',
			'text-transform' => 'none',
			'line-height'    => '1.4',
		),
		'transport'   => 'auto',
		'output'      => array(
			array(
				'element' => '.site-footer .widget .widget-title',
			),
		),
	) );

	// Footer Style Options
	Kirki::add_section( 'footer_style_options', array(
	    'title'          => esc_html__( 'Style', 'gutener' ),
	    'panel'          => 'footer_options',
	    'capability'     => 'edit_theme_options',
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Disable Bottom Footer Area', 'gutener' ),
		'type'         => 'checkbox',
		'settings'     => 'disable_bottom_footer',
		'section'      => 'footer_style_options',
		'default'      => false,
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Footer Layouts', 'gutener' ),
		'type'        => 'radio-image',
		'settings'    => 'footer_layout',
		'section'     => 'footer_style_options',
		'default'     => 'footer_one',
		'choices'  => array(
			'footer_one'   => get_template_directory_uri() . '/assets/images/footer-layout-1.png',
			'footer_two'   => get_template_directory_uri() . '/assets/images/footer-layout-2.png',
			'footer_three' => get_template_directory_uri() . '/assets/images/footer-layout-3.png',
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Bottom Footer Area Top Padding(in px)', 'gutener' ),
		'type'         => 'number',
		'settings'     => 'bottom_footer_area_top_padding',
		'section'      => 'footer_style_options',
		'default'      => 30,
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Bottom Footer Area Bottom Padding(in px)', 'gutener' ),
		'type'         => 'number',
		'settings'     => 'bottom_footer_area_bottom_padding',
		'section'      => 'footer_style_options',
		'default'      => 30,
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Background Color', 'gutener' ),
		'description'  => esc_html__( 'It can be used as a transparent background color over image.', 'gutener' ),
		'type'         => 'color',
		'settings'     => 'bottom_footer_background_color',
		'section'      => 'footer_style_options',
		'default'      => '',
		'active_callback' => array(
			array(
				'setting'  => 'skin_select',
				'operator' => 'contains',
				'value'    => array( 'default', 'blackwhite' ),
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Text Color', 'gutener' ),
		'type'         => 'color',
		'settings'     => 'bottom_footer_text_color',
		'section'      => 'footer_style_options',
		'default'      => '#656565',
		'active_callback' => array(
			array(
				'setting'  => 'skin_select',
				'operator' => 'contains',
				'value'    => array( 'default', 'blackwhite' ),
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Text Link Color', 'gutener' ),
		'type'         => 'color',
		'settings'     => 'bottom_footer_text_link_color',
		'section'      => 'footer_style_options',
		'default'      => '#383838',
		'active_callback' => array(
			array(
				'setting'  => 'skin_select',
				'operator' => 'contains',
				'value'    => array( 'default', 'blackwhite' ),
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Text Link Hover Color', 'gutener' ),
		'type'         => 'color',
		'settings'     => 'bottom_footer_text_link_hover_color',
		'section'      => 'footer_style_options',
		'default'      => '',
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Bottom Footer Typography', 'gutener' ),
		'type'         => 'typography',
		'settings'     => 'footer_style_font_control',
		'section'      => 'footer_style_options',
		'default'  => array(
			'font-family'    => 'Poppins',
			'variant'        => '400',
			'font-size'      => '14px',
			'text-transform' => 'none',
			'line-height'    => '1.6',
		),
		'transport'   => 'auto',
		'output'      => array(
			array(
				'element' => array( '.site-footer .site-info', '.site-footer .footer-menu ul li a' ),
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Select Image', 'gutener' ),
		'type'         => 'image',
		'settings'     => 'bottom_footer_image',
		'section'      => 'footer_style_options',
		'default'      => '',
		'choices'     => array(
			'save_as' => 'id',
		),
		'active_callback' => array(
			array(
				'setting'  => 'footer_layout',
				'operator' => 'contains',
				'value'    => array( 'footer_one' ),
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'    => esc_html__( 'Image Link', 'gutener' ),
		'type'     => 'link',
		'settings' => 'bottom_footer_image_link',
		'section'  => 'footer_style_options',
		'default'  => '',
		'active_callback' => array(
			array(
				'setting'  => 'footer_layout',
				'operator' => 'contains',
				'value'    => array( 'footer_one' ),
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'    => esc_html__( 'Image Target', 'gutener' ),
		'description' => esc_html__( 'If enabled, the page will be open in an another browser tab.', 'gutener' ),
		'type'     => 'checkbox',
		'settings' => 'bottom_footer_image_target',
		'section'  => 'footer_style_options',
		'default'  => true,
		'active_callback' => array(
			array(
				'setting'  => 'footer_layout',
				'operator' => 'contains',
				'value'    => array( 'footer_one' ),
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Image Width', 'gutener' ),
		'type'         => 'slider',
		'settings'     => 'bottom_footer_image_width',
		'section'      => 'footer_style_options',
		'transport'    => 'postMessage',
		'default'      => 270,
		'choices'      => array(
			'min'  => 10,
			'max'  => 1140,
			'step' => 5,
		),
		'active_callback' => array(
			array(
				'setting'  => 'footer_layout',
				'operator' => 'contains',
				'value'    => array( 'footer_one' ),
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Disable Footer Menu', 'gutener' ),
		'type'         => 'checkbox',
		'settings'     => 'disable_footer_menu',
		'section'      => 'footer_style_options',
		'default'      => false,
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Footer Text', 'gutener' ),
		'type'         => 'textarea',
		'settings'     => 'footer_text',
		'section'      => 'footer_style_options',
		'default'      => '',
		'active_callback' => array(
			array(
				'setting'  => 'disable_bottom_footer',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	// Media Footer Options
	Kirki::add_section( 'media_footer_options', array(
	    'title'          => esc_html__( 'Media', 'gutener' ),
	    'panel'          => 'footer_options',
	    'capability'     => 'edit_theme_options',
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Select Background Image', 'gutener' ),
		'description' => esc_html__( 'Recommended image size 1920x550 pixel.', 'gutener' ),
		'type'        => 'image',
		'settings'    => 'footer_image',
		'section'     => 'media_footer_options',
		'default'      => '',
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Background Image Size', 'gutener' ),
		'type'         => 'radio',
		'settings'     => 'footer_image_size',
		'section'      => 'media_footer_options',
		'default'      => 'cover',
		'choices'      => array(
			'cover'    => esc_html__( 'Cover', 'gutener' ),
			'pattern'  => esc_html__( 'Pattern / Repeat', 'gutener' ),
			'norepeat' => esc_html__( 'No Repeat', 'gutener' ),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Disable Parallax Scrolling', 'gutener' ),
		'type'        => 'checkbox',
		'settings'    => 'disable_footer_parallax_scrolling',
		'section'     => 'media_footer_options',
		'default'     => true,
	) );

	// Footer Elements Options
	Kirki::add_section( 'elements_footer_options', array(
	    'title'          => esc_html__( 'Elements', 'gutener' ),
	    'panel'          => 'footer_options',
	    'capability'     => 'edit_theme_options',
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Disable Scroll to Top', 'gutener' ),
		'type'        => 'checkbox',
		'settings'    => 'disable_scroll_top',
		'section'     => 'elements_footer_options',
		'default'     => false,
	) );

	// Instagram Options
	Kirki::add_section( 'instagram_feed_options', array(
	    'title'          => esc_html__( 'Instagram Feed', 'gutener' ),
	    'panel'          => 'footer_options',
	    'capability'     => 'edit_theme_options',
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Disable Instagram Feed', 'gutener' ),
		'type'         => 'checkbox',
		'settings'     => 'disable_instagram',
		'section'      => 'instagram_feed_options',
		'default'      => true,
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Instagram Shortcode', 'gutener' ),
		'type'         => 'text',
		'settings'     => 'insta_shortcode',
		'section'      => 'instagram_feed_options',
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Enable in Homepage Only', 'gutener' ),
		'type'         => 'checkbox',
		'settings'     => 'enable_instagram_homepage',
		'section'      => 'instagram_feed_options',
		'default'      => false,
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Disable Section Title', 'gutener' ),
		'type'         => 'checkbox',
		'settings'     => 'disable_instagram_section_title',
		'section'      => 'instagram_feed_options',
		'default'      => true,
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Section Title', 'gutener' ),
		'type'        => 'text',
		'settings'    => 'instagram_section_title',
		'section'     => 'instagram_feed_options',
		'default'     => '',
		'active_callback' => array(
			array(
				'setting'  => 'disable_instagram_section_title',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Section Title Typography', 'gutener' ),
		'type'         => 'typography',
		'settings'     => 'instagram_section_title_font_control',
		'section'      => 'instagram_feed_options',
		'default'  => array(
			'font-family'    => '',
			'variant'        => '600',
			'font-size'      => '24px',
			'text-transform' => 'none',
			'line-height'    => '1.2',
		),
		'transport'   => 'auto',
		'output'      => array(
			array(
				'element' => '.section-instagram-wrapper .section-title',
			),
		),
		'active_callback' => array(
			array(
				'setting'  => 'disable_instagram_section_title',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Disable Section Description', 'gutener' ),
		'type'         => 'checkbox',
		'settings'     => 'disable_instagram_section_description',
		'section'      => 'instagram_feed_options',
		'default'      => true,
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Section Description', 'gutener' ),
		'type'        => 'text',
		'settings'    => 'instagram_section_description',
		'section'     => 'instagram_feed_options',
		'default'     => '',
		'active_callback' => array(
			array(
				'setting'  => 'disable_instagram_section_description',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Section Description Typography', 'gutener' ),
		'type'         => 'typography',
		'settings'     => 'instagram_section_description_font_control',
		'section'      => 'instagram_feed_options',
		'default'  => array(
			'font-family'    => 'Open Sans',
			'variant'        => 'normal',
			'font-size'      => '16px',
			'text-transform' => 'none',
			'line-height'    => '1.8',
		),
		'transport'   => 'auto',
		'output'      => array(
			array(
				'element' => '.section-instagram-wrapper .section-title-wrap p',
			),
		),
		'active_callback' => array(
			array(
				'setting'  => 'disable_instagram_section_description',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Section Title and Description Alignment', 'gutener' ),
		'type'        => 'select',
		'settings'    => 'instagram_section_title_desc_alignment',
		'section'     => 'instagram_feed_options',
		'default'     => 'text-left',
		'choices'     => array(
			'text-left'	 	=> esc_html__( 'Left', 'gutener' ),
			'text-center'  	=> esc_html__( 'Center', 'gutener' ),   
			'text-right'	=> esc_html__( 'Right', 'gutener' ),
		),
		'active_callback' => array(
			array(
				array(
					'setting'  => 'disable_instagram_section_title',
					'operator' => '==',
					'value'    => false,
				),
				array(
					'setting'  => 'disable_instagram_section_description',
					'operator' => '==',
					'value'    => false,
				),
			),
		),
	) );

	// Responsive
	Kirki::add_section( 'footer_responsive', array(
	    'title'          => esc_html__( 'Responsive', 'gutener' ),
	    'description'    => esc_html__( 'These options will only apply to Tablet and Mobile devices. Please
	    	click on below Tablet or Mobile Icons to see changes.', 'gutener' ),
	    'capability'     => 'edit_theme_options',
	    'panel'			 => 'footer_options',		
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Disable Footer Widget Area', 'gutener' ),
		'type'        => 'checkbox',
		'settings'    => 'disable_responsive_footer_widget',
		'section'     => 'footer_responsive',
		'default'     => false,
		'active_callback' => array(
			array(
				'setting'  => 'disable_footer_widget',
				'operator' => '=',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Disable Scroll Top', 'gutener' ),
		'type'        => 'checkbox',
		'settings'    => 'disable_mobile_scroll_top',
		'section'     => 'footer_responsive',
		'default'     => true,
		'active_callback' => array(
			array(
				'setting'  => 'disable_scroll_top',
				'operator' => '=',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Disable Instagram Feed', 'gutener' ),
		'type'        => 'checkbox',
		'settings'    => 'disable_responsive_instagram_feed',
		'section'     => 'footer_responsive',
		'default'     => true,
		'active_callback' => array(
			array(
				'setting'  => 'disable_instagram',
				'operator' => '=',
				'value'    => false,
			),
		),
	) );

	// Blog Homepage Options
	Kirki::add_panel( 'blog_homepage_options', array(
	    'title' => esc_html__( 'Blog Homepage', 'gutener' ),
	    'priority' => '120',
	) );

	// Main Banner / Post Slider 
	Kirki::add_section( 'main_slider_options', array(
	    'title'          => esc_html__( 'Banner / Post Slider', 'gutener' ),
	    'panel'          => 'blog_homepage_options',
	    'capability'     => 'edit_theme_options',
	    'priority'       => '10',
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Disable Section', 'gutener' ),
		'type'        => 'checkbox',
		'settings'    => 'disable_main_slider',
		'section'     => 'main_slider_options',
		'default'     => false,
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Slider / Banner', 'gutener' ),
		'type'        => 'radio-buttonset',
		'settings'    => 'main_slider_controls',
		'section'     => 'main_slider_options',
		'default'     => 'slider',
		'choices'  => array(
			'slider' => esc_html__( 'Slider', 'gutener' ),
			'banner' => esc_html__( 'Banner', 'gutener' ),

		)
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Height (in px)', 'gutener' ),
		'description' => esc_html__( 'This option will only apply to Desktop. Please click on below Desktop Icon to see changes. Automatically adjust by theme default in the responsive devices.
		', 'gutener' ),
		'type'        => 'slider',
		'settings'    => 'main_slider_height',
		'section'     => 'main_slider_options',
		'transport'   => 'postMessage',
		'default'     => 550,
		'choices'     => array(
			'min'  => 50,
			'max'  => 1500,
			'step' => 10,
		),
	) );

	// Slider settings
	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Choose Category', 'gutener' ),
		'description' => esc_html__( 'Recent posts will show if any category is not chosen. Recommended posts containing feature images size with 1920x940 pixel.', 'gutener' ),
		'type'        => 'select',
		'settings'    => 'slider_category',
		'section'     => 'main_slider_options',
		'default'     => '',
		'placeholder' => esc_html__( 'Select category', 'gutener' ),
		'choices'     => gutener_get_post_categories(),
		'active_callback' => array(
			array(
				'setting'  => 'main_slider_controls',
				'operator' => '==',
				'value'    => 'slider',
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Slider Layout', 'gutener' ),
		'description' => esc_html__( 'Select layout & scroll below to change its options', 'gutener' ),
		'type'        => 'radio-image',
		'settings'    => 'main_slider_layout',
		'section'     => 'main_slider_options',
		'default'     => 'main_slider_one',
		'choices'  => array(
			'main_slider_one'    => get_template_directory_uri() . '/assets/images/slider-layout-1.png',
		),
		'active_callback' => array(
			array(
				'setting'  => 'main_slider_controls',
				'operator' => '==',
				'value'    => 'slider',
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'type'        => 'color',
		'label'       => esc_html__( 'Slider Background Color', 'gutener' ),
		'settings'    => 'background_color_main_slider',
		'section'     => 'main_slider_options',
		'default'     => '',
		'active_callback' => array(
			array(
				'setting'  => 'main_slider_controls',
				'operator' => '==',
				'value'    => 'slider',
			),
			array(
				'setting'  => 'skin_select',
				'operator' => 'contains',
				'value'    => array( 'default', 'blackwhite' ),
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Post Title Color', 'gutener' ),
		'type'         => 'color',
		'settings'     => 'slider_post_title_color',
		'section'     => 'main_slider_options',
		'default'      => '#ffffff',
		'active_callback' => array(
			array(
				'setting'  => 'main_slider_controls',
				'operator' => '==',
				'value'    => 'slider',
			),
			array(
				'setting'  => 'skin_select',
				'operator' => 'contains',
				'value'    => array( 'default', 'blackwhite' ),
			),
			array(
				'setting'  => 'hide_slider_title',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Post Category Color', 'gutener' ),
		'type'         => 'color',
		'settings'     => 'slider_post_category_color',
		'section'     => 'main_slider_options',
		'default'      => '',
		'active_callback' => array(
			array(
				'setting'  => 'main_slider_controls',
				'operator' => '==',
				'value'    => 'slider',
			),
			array(
				'setting'  => 'skin_select',
				'operator' => 'contains',
				'value'    => array( 'default', 'blackwhite' ),
			),
			array(
				'setting'  => 'hide_slider_category',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Post Meta Color', 'gutener' ),
		'type'         => 'color',
		'settings'     => 'slider_post_meta_color',
		'section'     => 'main_slider_options',
		'default'      => '#ebebeb',
		'active_callback' => array(
			array(
				'setting'  => 'main_slider_controls',
				'operator' => '==',
				'value'    => 'slider',
			),
			array(
				'setting'  => 'skin_select',
				'operator' => 'contains',
				'value'    => array( 'default', 'blackwhite' ),
			),
			array(
				array(
				'setting'  => 'hide_slider_date',
				'operator' => '==',
				'value'    => false,
				),
				array(
				'setting'  => 'hide_slider_author',
				'operator' => '==',
				'value'    => false,
				),
				array(
				'setting'  => 'hide_slider_comment',
				'operator' => '==',
				'value'    => false,
				),
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Post Meta Icon Color', 'gutener' ),
		'type'         => 'color',
		'settings'     => 'slider_post_meta_icon_color',
		'section'      => 'main_slider_options',
		'default'      => '',
		'active_callback' => array(
			array(
				'setting'  => 'main_slider_controls',
				'operator' => '==',
				'value'    => 'slider',
			),
			array(
				'setting'  => 'skin_select',
				'operator' => 'contains',
				'value'    => array( 'default', 'blackwhite' ),
			),
			array(
				array(
				'setting'  => 'hide_slider_date',
				'operator' => '==',
				'value'    => false,
				),
				array(
				'setting'  => 'hide_slider_author',
				'operator' => '==',
				'value'    => false,
				),
				array(
				'setting'  => 'hide_slider_comment',
				'operator' => '==',
				'value'    => false,
				),
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Post Text Color', 'gutener' ),
		'type'         => 'color',
		'settings'     => 'slider_post_text_color',
		'section'     => 'main_slider_options',
		'default'      => '#ffffff',
		'active_callback' => array(
			array(
				'setting'  => 'main_slider_controls',
				'operator' => '==',
				'value'    => 'slider',
			),
			array(
				'setting'  => 'skin_select',
				'operator' => 'contains',
				'value'    => array( 'default', 'blackwhite' ),
			),
			array(
				'setting'  => 'hide_slider_excerpt',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'type'        => 'color',
		'label'       => esc_html__( 'Hover Color', 'gutener' ),
		'settings'    => 'separate_hover_color_for_main_slider',
		'section'     => 'main_slider_options',
		'default'     => '',
		'active_callback' => array(
			array(
				'setting'  => 'main_slider_controls',
				'operator' => '==',
				'value'    => 'slider',
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'type'        => 'number',
		'settings'    => 'slider_image_overlay_opacity',
		'label'       => esc_html__( 'Image Overlay Opacity', 'gutener' ),
		'section'     => 'main_slider_options',
		'default'     => 4,
		'choices' => array(
			'min' => '0',
			'max' => '9',
			'step' => '1',
		),
		'active_callback' => array(
			array(
				'setting'  => 'main_slider_controls',
				'operator' => '==',
				'value'    => 'slider',
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Background Image Size', 'gutener' ),
		'type'         => 'radio',
		'settings'     => 'main_slider_image_size',
		'section'      => 'main_slider_options',
		'default'      => 'cover',
		'choices'      => array(
			'cover'    => esc_html__( 'Cover', 'gutener' ),
			'pattern'  => esc_html__( 'Pattern / Repeat', 'gutener' ),
			'norepeat' => esc_html__( 'No Repeat', 'gutener' ),
		),
		'active_callback' => array(
			array(
				'setting'  => 'main_slider_controls',
				'operator' => '==',
				'value'    => 'slider',
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Width Controls', 'gutener' ),
		'type'        => 'select',
		'settings'    => 'slider_width_controls',
		'section'     => 'main_slider_options',
		'default'     => 'full',
		'choices'  => array(
			'full'   => esc_html__( 'Full', 'gutener' ),
			'boxed'  => esc_html__( 'Boxed', 'gutener' ),
		),
		'active_callback' => array(
			array(
				'setting'  => 'main_slider_controls',
				'operator' => '==',
				'value'    => 'slider',
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Slide Effect', 'gutener' ),
		'type'        => 'select',
		'settings'    => 'main_slider_effect',
		'section'     => 'main_slider_options',
		'default'     => 'fade',
		'choices'  => array(
			'fade'             => esc_html__( 'Fade', 'gutener' ),
			'horizontal-slide' => esc_html__( 'Slide', 'gutener' ),
		),
		'active_callback' => array(
			array(
				'setting'  => 'main_slider_controls',
				'operator' => '==',
				'value'    => 'slider',
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Fade Control Time ( in sec )', 'gutener' ),
		'type'         => 'number',
		'settings'     => 'slider_fade_control',
		'section'      => 'main_slider_options',
		'default'      => 5,
		'choices' => array(
				'min' => '3',
				'max' => '60',
				'step'=> '1',
		),
		'active_callback' => array(
			array(
				'setting'  => 'main_slider_controls',
				'operator' => '==',
				'value'    => 'slider',
			),
			array(
				'setting'  => 'main_slider_effect',
				'operator' => '==',
				'value'    => 'fade',
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Content Alignment', 'gutener' ),
		'type'        => 'select',
		'settings'    => 'main_slider_content_alignment',
		'section'     => 'main_slider_options',
		'default'     => 'center',
		'choices'  => array(
			'center' => esc_html__( 'Center', 'gutener' ),
			'left'   => esc_html__( 'Left', 'gutener' ),
			'right'  => esc_html__( 'Right', 'gutener' ),
		),
		'active_callback' => array(
			array(
				'setting'  => 'main_slider_controls',
				'operator' => '==',
				'value'    => 'slider',
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Display Slider on', 'gutener' ),
		'type'        => 'select',
		'settings'    => 'display_slider_on',
		'section'     => 'main_slider_options',
		'default'     => 'blog-page-below-header',
		'choices'  => array(
			'blog-page-below-header'       => esc_html__( 'Blog Page Below Header', 'gutener' ),
			'blog-page-above-latest-posts' => esc_html__( 'Blog Page Above Latest Posts', 'gutener' ),
			'front-page-below-header'      => esc_html__( 'Front Page Below Header', 'gutener' ),
			'front-blog-page-below-header' => esc_html__( 'Front and Blog Page Below Header', 'gutener' ),
		),
		'active_callback' => array(
			array(
				'setting'  => 'main_slider_controls',
				'operator' => '==',
				'value'    => 'slider',
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Disable Arrows', 'gutener' ),
		'type'         => 'checkbox',
		'settings'     => 'disable_slider_arrows',
		'section'      => 'main_slider_options',
		'default'      => false,
		'active_callback' => array(
			array(
				'setting'  => 'main_slider_controls',
				'operator' => '==',
				'value'    => 'slider',
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Disable Dots', 'gutener' ),
		'type'         => 'checkbox',
		'settings'     => 'disable_slider_dots',
		'section'      => 'main_slider_options',
		'default'      => false,
		'active_callback' => array(
			array(
				'setting'  => 'main_slider_controls',
				'operator' => '==',
				'value'    => 'slider',
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Disable Auto Play', 'gutener' ),
		'type'         => 'checkbox',
		'settings'     => 'disable_slider_autoplay',
		'section'      => 'main_slider_options',
		'default'      => true,
		'active_callback' => array(
			array(
				'setting'  => 'main_slider_controls',
				'operator' => '==',
				'value'    => 'slider',
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Auto Play Timeout ( in sec )', 'gutener' ),
		'type'         => 'number',
		'settings'     => 'slider_autoplay_speed',
		'section'      => 'main_slider_options',
		'default'      => 4,
		'choices' => array(
				'min' => '1',
				'max' => '60',
				'step'=> '1',
		),
		'active_callback' => array(
			array(
				'setting'  => 'main_slider_controls',
				'operator' => '==',
				'value'    => 'slider',
			),
			array(
				'setting'  => 'disable_slider_autoplay',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Post View Number', 'gutener' ),
		'description'  => esc_html__( 'Number of posts to show.', 'gutener' ),
		'type'         => 'number',
		'settings'     => 'slider_posts_number',
		'section'      => 'main_slider_options',
		'default'      => 6,
		'choices' => array(
				'min' => '1',
				'max' => '20',
				'step' => '1',
		),
		'active_callback' => array(
			array(
				'setting'  => 'main_slider_controls',
				'operator' => '==',
				'value'    => 'slider',
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Disable Title', 'gutener' ),
		'type'        => 'checkbox',
		'settings'    => 'hide_slider_title',
		'section'     => 'main_slider_options',
		'default'     => false,	
		'active_callback' => array(
			array(
				'setting'  => 'main_slider_controls',
				'operator' => '==',
				'value'    => 'slider',
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Title Typography', 'gutener' ),
		'type'         => 'typography',
		'settings'     => 'main_slider_title_font_control',
		'section'      => 'main_slider_options',
		'default'  => array(
			'font-family'    => '',
			'variant'        => '600',
			'font-size'      => '50px',
			'text-transform' => 'uppercase',
			'line-height'    => '1.4',
		),
		'transport'   => 'auto',
		'output'      => array(
			array(
				'element' => '.section-banner .banner-content .entry-title',
			),
		),
		'active_callback' => array(
			array(
				'setting'  => 'main_slider_controls',
				'operator' => '==',
				'value'    => 'slider',
			),
			array(
				'setting'  => 'hide_slider_title',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Disable category', 'gutener' ),
		'type'        => 'checkbox',
		'settings'    => 'hide_slider_category',
		'section'     => 'main_slider_options',
		'default'     => false,
		'active_callback' => array(
			array(
				'setting'  => 'main_slider_controls',
				'operator' => '==',
				'value'    => 'slider',
			),
		),
	) );	

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Category Typography', 'gutener' ),
		'type'         => 'typography',
		'settings'     => 'main_slider_cat_font_control',
		'section'      => 'main_slider_options',
		'default'  => array(
			'font-family'    => '',
			'variant'        => '400',
			'font-size'      => '15px',
			'text-transform' => 'uppercase',
			'line-height'    => '1.6',
		),
		'transport'   => 'auto',
		'output'      => array(
			array(
				'element' => '.section-banner .banner-content .entry-header .cat-links a',
			),
		),
		'active_callback' => array(
			array(
				'setting'  => 'main_slider_controls',
				'operator' => '==',
				'value'    => 'slider',
			),
			array(
				'setting'  => 'hide_slider_category',
				'operator' => '==',
				'value'    => false,
				),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Disable Date', 'gutener' ),
		'type'        => 'checkbox',
		'settings'    => 'hide_slider_date',
		'section'     => 'main_slider_options',
		'default'     => false,
		'active_callback' => array(
			array(
				'setting'  => 'main_slider_controls',
				'operator' => '==',
				'value'    => 'slider',
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Disable Author', 'gutener' ),
		'type'        => 'checkbox',
		'settings'    => 'hide_slider_author',
		'section'     => 'main_slider_options',
		'default'     => false,
		'active_callback' => array(
			array(
				'setting'  => 'main_slider_controls',
				'operator' => '==',
				'value'    => 'slider',
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Disable Comments Link', 'gutener' ),
		'type'        => 'checkbox',
		'settings'    => 'hide_slider_comment',
		'section'     => 'main_slider_options',
		'default'     => false,
		'active_callback' => array(
			array(
				'setting'  => 'main_slider_controls',
				'operator' => '==',
				'value'    => 'slider',
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Meta Typography', 'gutener' ),
		'type'         => 'typography',
		'settings'     => 'main_slider_meta_font_control',
		'section'      => 'main_slider_options',
		'default'  => array(
			'font-family'    => 'Poppins',
			'variant'        => '400',
			'font-size'      => '13px',
			'text-transform' => 'capitalize',
			'line-height'    => '1.6',
		),
		'transport'   => 'auto',
		'output'      => array(
			array(
				'element' => '.section-banner .banner-content .entry-meta a',
			),
		),
		'active_callback' => array(
			array(
				'setting'  => 'main_slider_controls',
				'operator' => '==',
				'value'    => 'slider',
			),
			array(
				array(
				'setting'  => 'hide_slider_date',
				'operator' => '==',
				'value'    => false,
				),
				array(
				'setting'  => 'hide_slider_author',
				'operator' => '==',
				'value'    => false,
				),
				array(
				'setting'  => 'hide_slider_comment',
				'operator' => '==',
				'value'    => false,
				),
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Disable Excerpt', 'gutener' ),
		'type'        => 'checkbox',
		'settings'    => 'hide_slider_excerpt',
		'section'     => 'main_slider_options',
		'default'     => false,
		'active_callback' => array(
			array(
				'setting'  => 'main_slider_controls',
				'operator' => '==',
				'value'    => 'slider',
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Excerpt Typography', 'gutener' ),
		'type'         => 'typography',
		'settings'     => 'main_slider_excerpt_font_control',
		'section'      => 'main_slider_options',
		'default'  => array(
			'font-family'    => '',
			'variant'        => '400',
			'font-size'      => '15px',
			'text-transform' => 'initial',
			'line-height'    => '1.8',
		),
		'transport'   => 'auto',
		'output'      => array(
			array(
				'element' => '.section-banner .banner-content .entry-text p',
			),
		),
		'active_callback' => array(
			array(
				'setting'  => 'main_slider_controls',
				'operator' => '==',
				'value'    => 'slider',
			),
			array(
				'setting'  => 'hide_slider_excerpt',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Excerpt Length', 'gutener' ),
		'type'        => 'number',
		'settings'    => 'slider_excerpt_length',
		'section'     => 'main_slider_options',
		'default'     => 25,
		'choices' => array(
			'min' => '5',
			'max' => '100',
			'step' => '5',
		),
		'active_callback' => array(
			array(
				'setting'  => 'hide_slider_excerpt',
				'operator' => '==',
				'value'    => false,
			),
			array(
				'setting'  => 'main_slider_controls',
				'operator' => '==',
				'value'    => 'slider',
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Disable Button', 'gutener' ),
		'type'        => 'checkbox',
		'settings'    => 'hide_slider_button',
		'section'     => 'main_slider_options',
		'default'     => true,
		'active_callback' => array(
			array(
				'setting'  => 'main_slider_controls',
				'operator' => '==',
				'value'    => 'slider',
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Button Type', 'gutener' ),
		'type'        => 'select',
		'settings'    => 'slider_button_type',
		'section'     => 'main_slider_options',
		'default'     => 'button-outline',
		'choices'  => array(
			'button-primary' => esc_html__( 'Primary Button', 'gutener' ),
			'button-outline' => esc_html__( 'Border Button', 'gutener' ),
			'button-text'    => esc_html__( 'Text Only Button', 'gutener' ),
		),
		'active_callback' => array(
			array(
				'setting'  => 'main_slider_controls',
				'operator' => '==',
				'value'    => 'slider',
			),
			array(
				'setting'  => 'hide_slider_button',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Button Background Color', 'gutener' ),
		'type'         => 'color',
		'settings'     => 'slider_button_background_color',
		'section'      => 'main_slider_options',
		'default'      => '#f9a032',
		'active_callback' => array(
			array(
				'setting'  => 'main_slider_controls',
				'operator' => '==',
				'value'    => 'slider',
			),
			array(
				'setting'  => 'hide_slider_button',
				'operator' => '==',
				'value'    => false,
			),
			array(
				'setting'  => 'slider_button_type',
				'operator' => '==',
				'value'    => 'button-primary',
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Button Border Color', 'gutener' ),
		'type'         => 'color',
		'settings'     => 'slider_button_border_color',
		'section'      => 'main_slider_options',
		'default'      => '',
		'active_callback' => array(
			array(
				'setting'  => 'main_slider_controls',
				'operator' => '==',
				'value'    => 'slider',
			),
			array(
				'setting'  => 'hide_slider_button',
				'operator' => '==',
				'value'    => false,
			),
			array(
				'setting'  => 'slider_button_type',
				'operator' => '==',
				'value'    => 'button-outline',
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Button Text Color', 'gutener' ),
		'type'         => 'color',
		'settings'     => 'slider_button_text_color',
		'section'      => 'main_slider_options',
		'default'      => '#ffffff',
		'active_callback' => array(
			array(
				'setting'  => 'main_slider_controls',
				'operator' => '==',
				'value'    => 'slider',
			),
			array(
				'setting'  => 'hide_slider_button',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Button Hover Color', 'gutener' ),
		'type'         => 'color',
		'settings'     => 'slider_button_hover_color',
		'section'      => 'main_slider_options',
		'default'      => '',
		'active_callback' => array(
			array(
				'setting'  => 'main_slider_controls',
				'operator' => '==',
				'value'    => 'slider',
			),
			array(
				'setting'  => 'hide_slider_button',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Button Text', 'gutener' ),
		'type'        => 'text',
		'settings'    => 'slider_button_text',
		'section'     => 'main_slider_options',
		'default'     => '',
		'active_callback' => array(
			array(
				'setting'  => 'main_slider_controls',
				'operator' => '==',
				'value'    => 'slider',
			),
			array(
				'setting'  => 'hide_slider_button',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Slider Button Typography', 'gutener' ),
		'type'         => 'typography',
		'settings'     => 'main_slider_button_font_control',
		'section'      => 'main_slider_options',
		'default'  => array(
			'font-family'    => '',
			'variant'        => '500',
			'font-size'      => '15px',
			'text-transform' => 'capitalize',
			'line-height'    => '1',
		),
		'transport'   => 'auto',
		'output'      => array(
			array(
				'element' => '.section-banner .slide-inner .banner-content .button-container a',
			),
		),
		'active_callback' => array(
			array(
				'setting'  => 'main_slider_controls',
				'operator' => '==',
				'value'    => 'slider',
			),
			array(
				'setting'  => 'hide_slider_button',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Button Border Radius (px)', 'gutener' ),
		'type'        => 'slider',
		'settings'    => 'slider_button_border_radius',
		'section'     => 'main_slider_options',
		'transport'   => 'postMessage',
		'default'     => 0,
		'choices'     => array(
			'min'  => 0,
			'max'  => 50,
			'step' => 1,
		),
		'active_callback' => array(
			array(
				'setting'  => 'main_slider_controls',
				'operator' => '==',
				'value'    => 'slider',
			),
			array(
				'setting'  => 'hide_slider_button',
				'operator' => '==',
				'value'    => false,
			),
			array(
				'setting'  => 'slider_button_type',
				'operator' => 'contains',
				'value'    => array( 'button-primary', 'button-outline' ),
			),
		),
	) );

	// Banner settings
	Kirki::add_field( 'gutener', array(
		'type'        => 'color',
		'label'       => esc_html__( 'Banner Background Color', 'gutener' ),
		'settings'    => 'background_color_main_banner',
		'section'     => 'main_slider_options',
		'default'     => '',
		'active_callback' => array(
			array(
				'setting'  => 'main_slider_controls',
				'operator' => '==',
				'value'    => 'banner',
			),
			array(
				'setting'  => 'skin_select',
				'operator' => 'contains',
				'value'    => array( 'default', 'blackwhite' ),
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Title Color', 'gutener' ),
		'type'         => 'color',
		'settings'     => 'banner_title_color',
		'section'	   => 'main_slider_options',
		'default'      => '#ffffff',
		'active_callback' => array(
			array(
				'setting'  => 'main_slider_controls',
				'operator' => '==',
				'value'    => 'banner',
			),
			array(
				'setting'  => 'skin_select',
				'operator' => 'contains',
				'value'    => array( 'default', 'blackwhite' ),
			),
			array(
				'setting'  => 'disable_banner_title',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Subtitle Color', 'gutener' ),
		'type'         => 'color',
		'settings'     => 'banner_subtitle_color',
		'section'      => 'main_slider_options',
		'default'      => '#ffffff',
		'active_callback' => array(
			array(
				'setting'  => 'main_slider_controls',
				'operator' => '==',
				'value'    => 'banner',
			),
			array(
				'setting'  => 'skin_select',
				'operator' => 'contains',
				'value'    => array( 'default', 'blackwhite' ),
			),
			array(
				'setting'  => 'disable_banner_subtitle',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Select Image', 'gutener' ),
		'description' => esc_html__( 'Recommended image size 1920x940 pixel.', 'gutener' ),
		'type'        => 'image',
		'settings'    => 'banner_image',
		'section'     => 'main_slider_options',
		'default'	  => '',
		'active_callback' => array(
			array(
				'setting'  => 'main_slider_controls',
				'operator' => '==',
				'value'    => 'banner',
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'type'        => 'number',
		'settings'    => 'banner_image_overlay_opacity',
		'label'       => esc_html__( 'Image Overlay Opacity', 'gutener' ),
		'section'     => 'main_slider_options',
		'default'     => 4,
		'choices' => array(
			'min' => '0',
			'max' => '9',
			'step' => '1',
		),
		'active_callback' => array(
			array(
				'setting'  => 'main_slider_controls',
				'operator' => '==',
				'value'    => 'banner',
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Background Image Size', 'gutener' ),
		'type'         => 'radio',
		'settings'     => 'main_banner_image_size',
		'section'      => 'main_slider_options',
		'default'      => 'cover',
		'choices'      => array(
			'cover'    => esc_html__( 'Cover', 'gutener' ),
			'pattern'  => esc_html__( 'Pattern / Repeat', 'gutener' ),
			'norepeat' => esc_html__( 'No Repeat', 'gutener' ),
		),
		'active_callback' => array(
			array(
				'setting'  => 'main_slider_controls',
				'operator' => '==',
				'value'    => 'banner',
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Width Controls', 'gutener' ),
		'type'        => 'select',
		'settings'    => 'banner_width_controls',
		'section'     => 'main_slider_options',
		'default'     => 'full',
		'choices'  => array(
			'full'   => esc_html__( 'Full', 'gutener' ),
			'boxed'  => esc_html__( 'Boxed', 'gutener' ),
		),
		'active_callback' => array(
			array(
				'setting'  => 'main_slider_controls',
				'operator' => '==',
				'value'    => 'banner',
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Content Alignment', 'gutener' ),
		'type'        => 'select',
		'settings'    => 'main_banner_content_alignment',
		'section'     => 'main_slider_options',
		'default'     => 'center',
		'choices'  => array(
			'center' => esc_html__( 'Center', 'gutener' ),
			'left'   => esc_html__( 'Left', 'gutener' ),
			'right'  => esc_html__( 'Right', 'gutener' ),
		),
		'active_callback' => array(
			array(
				'setting'  => 'main_slider_controls',
				'operator' => '==',
				'value'    => 'banner',
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Display Banner on', 'gutener' ),
		'type'        => 'select',
		'settings'    => 'display_banner_on',
		'section'     => 'main_slider_options',
		'default'     => 'blog-page-below-header',
		'choices'  => array(
			'blog-page-below-header'       => esc_html__( 'Blog Page Below Header', 'gutener' ),
			'blog-page-above-latest-posts' => esc_html__( 'Blog Page Above Latest Posts', 'gutener' ),
			'front-page-below-header'      => esc_html__( 'Front Page Below Header', 'gutener' ),
			'front-blog-page-below-header' => esc_html__( 'Front and Blog Page Below Header', 'gutener' ),
		),
		'active_callback' => array(
			array(
				'setting'  => 'main_slider_controls',
				'operator' => '==',
				'value'    => 'banner',
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Disable Title', 'gutener' ),
		'type'        => 'checkbox',
		'settings'    => 'disable_banner_title',
		'section'     => 'main_slider_options',
		'default'     => false,
		'active_callback' => array(
			array(
				'setting'  => 'main_slider_controls',
				'operator' => '==',
				'value'    => 'banner',
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Title', 'gutener' ),
		'type'        => 'text',
		'settings'    => 'banner_title',
		'section'     => 'main_slider_options',
		'default'     => '',
		'active_callback' => array(
			array(
				'setting'  => 'main_slider_controls',
				'operator' => '==',
				'value'    => 'banner',
			),
			array(
				'setting'  => 'disable_banner_title',
				'operator' => '==',
				'value'    => false,
			),
		),
		'partial_refresh' => array(
			'banner_title' => array(
				'selector'        => '.banner_title',
				'render_callback' => 'gutener_get_banner_title',
			)
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Title Typography', 'gutener' ),
		'type'         => 'typography',
		'settings'     => 'banner_title_font_control',
		'section'      => 'main_slider_options',
		'default'  => array(
			'font-family'    => '',
			'variant'        => '600',
			'font-size'      => '50px',
			'text-transform' => 'uppercase',
			'line-height'    => '1.4',
		),
		'transport'   => 'auto',
		'output'      => array(
			array(
				'element' => '.section-banner .banner-content .entry-title',
			),
		),
		'active_callback' => array(
			array(
				'setting'  => 'main_slider_controls',
				'operator' => '==',
				'value'    => 'banner',
			),
			array(
				'setting'  => 'disable_banner_title',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Disable Subtitle', 'gutener' ),
		'type'        => 'checkbox',
		'settings'    => 'disable_banner_subtitle',
		'section'     => 'main_slider_options',
		'default'     => false,
		'active_callback' => array(
			array(
				'setting'  => 'main_slider_controls',
				'operator' => '==',
				'value'    => 'banner',
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Subtitle', 'gutener' ),
		'type'        => 'text',
		'settings'    => 'banner_subtitle',
		'section'     => 'main_slider_options',
		'default'     => '',
		'active_callback' => array(
			array(
				'setting'  => 'main_slider_controls',
				'operator' => '==',
				'value'    => 'banner',
			),
			array(
				'setting'  => 'disable_banner_subtitle',
				'operator' => '==',
				'value'    => false,
			),
		),
		'partial_refresh' => array(
			'banner_subtitle' => array(
				'selector'        => '.banner_subtitle',
				'render_callback' => 'gutener_get_banner_subtitle',
			)
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Subtitle Typography', 'gutener' ),
		'type'         => 'typography',
		'settings'     => 'main_banner_subtitle_font_control',
		'section'      => 'main_slider_options',
		'default'  => array(
			'font-family'    => '',
			'variant'        => '400',
			'font-size'      => '15px',
			'text-transform' => 'initial',
			'line-height'    => '1.8',
		),
		'transport'   => 'auto',
		'output'      => array(
			array(
				'element' => '.section-banner .banner-content .entry-subtitle',
			),
		),
		'active_callback' => array(
			array(
				'setting'  => 'main_slider_controls',
				'operator' => '==',
				'value'    => 'banner',
			),
			array(
				'setting'  => 'disable_banner_subtitle',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Disable Banner Buttons', 'gutener' ),
		'type'        => 'checkbox',
		'settings'    => 'disable_banner_buttons',
		'section'     => 'main_slider_options',
		'default'     => false,
		'active_callback' => array(
			array(
				'setting'  => 'main_slider_controls',
				'operator' => '==',
				'value'    => 'banner',
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Buttons Background Color', 'gutener' ),
		'type'         => 'color',
		'settings'     => 'banner_button_background_color',
		'section'      => 'main_slider_options',
		'default'      => '',
		'active_callback' => array(
			array(
				'setting'  => 'disable_banner_buttons',
				'operator' => '==',
				'value'    => false,
			),
			array(
				'setting'  => 'main_slider_controls',
				'operator' => '==',
				'value'    => 'banner',
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Buttons Border Color', 'gutener' ),
		'type'         => 'color',
		'settings'     => 'banner_button_border_color',
		'section'      => 'main_slider_options',
		'default'      => '',
		'active_callback' => array(
			array(
				'setting'  => 'disable_banner_buttons',
				'operator' => '==',
				'value'    => false,
			),
			array(
				'setting'  => 'main_slider_controls',
				'operator' => '==',
				'value'    => 'banner',
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Buttons Text Color', 'gutener' ),
		'type'         => 'color',
		'settings'     => 'banner_button_text_color',
		'section'      => 'main_slider_options',
		'default'      => '#ffffff',
		'active_callback' => array(
			array(
				'setting'  => 'disable_banner_buttons',
				'operator' => '==',
				'value'    => false,
			),
			array(
				'setting'  => 'main_slider_controls',
				'operator' => '==',
				'value'    => 'banner',
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Buttons Hover Color', 'gutener' ),
		'type'         => 'color',
		'settings'     => 'banner_button_hover_color',
		'section'      => 'main_slider_options',
		'default'      => '',
		'active_callback' => array(
			array(
				'setting'  => 'disable_banner_buttons',
				'operator' => '==',
				'value'    => false,
			),
			array(
				'setting'  => 'main_slider_controls',
				'operator' => '==',
				'value'    => 'banner',
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Banner Buttons', 'gutener' ),
		'type'        => 'repeater',
		'section'     => 'main_slider_options',
		'row_label' => array(
			'type'  => 'text',
			'value' => esc_html__( 'Button', 'gutener' ),
		),
		'settings' => 'main_banner_buttons',
		'default' => array(
			array(
				'text' 		=> '',
				'link'		=> '',
				'new_tab' 	=> false,
				'type' 		=> 'button-outline',
			),		
		),
		'fields' => array(
			'text' => array(
				'label'       => esc_html__( 'Text', 'gutener' ),
				'type'        => 'text',
			),
			'link' => array(
				'label'       => esc_html__( 'Link', 'gutener' ),
				'type'        => 'text',
			),
			'new_tab' => array(
				'label'       		 => esc_html__( 'Open Link in New Window', 'gutener' ),	
				'type'        		 => 'checkbox',
			),
			'type' => array(
				'label'       => esc_html__( 'Button Type', 'gutener' ),
				'type'        => 'select',
				'default'     => 'button-outline',
				'choices'  => array(
					'button-primary' => esc_html__( 'Primary Button', 'gutener' ),
					'button-outline' => esc_html__( 'Border Button', 'gutener' ),
					'button-text'    => esc_html__( 'Text Only Button', 'gutener' ),
				),
			),		
		),
		'choices' => array(
			'limit' => 10,
		),
		'active_callback' => array(
			array(
				'setting'  => 'main_slider_controls',
				'operator' => '==',
				'value'    => 'banner',
			),
			array(
				'setting'  => 'disable_banner_buttons',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Buttons Typography', 'gutener' ),
		'type'         => 'typography',
		'settings'     => 'main_banner_button_font_control',
		'section'      => 'main_slider_options',
		'default'  => array(
			'font-family'    => '',
			'variant'        => '500',
			'font-size'      => '15px',
			'text-transform' => 'capitalize',
			'line-height'    => '1',
		),
		'transport'   => 'auto',
		'output'      => array(
			array(
				'element' => '.section-banner .banner-content .button-container a',
			),
		),
		'active_callback' => array(
			array(
				'setting'  => 'main_slider_controls',
				'operator' => '==',
				'value'    => 'banner',
			),
			array(
				'setting'  => 'disable_banner_buttons',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Buttons Border Radius (px)', 'gutener' ),
		'type'        => 'slider',
		'settings'    => 'banner_button_border_radius',
		'section'     => 'main_slider_options',
		'transport'   => 'postMessage',
		'default'     => 0,
		'choices'     => array(
			'min'  => 0,
			'max'  => 50,
			'step' => 1,
		),
		'active_callback' => array(
			array(
				'setting'  => 'main_slider_controls',
				'operator' => '==',
				'value'    => 'banner',
			),
			array(
				'setting'  => 'disable_banner_buttons',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	// Highlighted Posts Options
	Kirki::add_section( 'highlight_posts_options', array(
	    'title'          => esc_html__( 'Highlighted Posts', 'gutener' ),
	    'panel'          => 'blog_homepage_options',
	    'capability'     => 'edit_theme_options',
	    'priority'       => '20',
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Disable Highlighted Posts Section', 'gutener' ),
		'type'         => 'checkbox',
		'settings'     => 'disable_highlight_posts_section',
		'section'      => 'highlight_posts_options',
		'default'      => false,
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Disable Section Title', 'gutener' ),
		'type'         => 'checkbox',
		'settings'     => 'disable_highlight_posts_section_title',
		'section'      => 'highlight_posts_options',
		'default'      => false,
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Section Title', 'gutener' ),
		'type'        => 'text',
		'settings'    => 'highlight_posts_section_title',
		'section'     => 'highlight_posts_options',
		'default'     => '',
		'active_callback' => array(
			array(
				'setting'  => 'disable_highlight_posts_section_title',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Section Title Typography', 'gutener' ),
		'type'         => 'typography',
		'settings'     => 'highlight_posts_section_title_font_control',
		'section'      => 'highlight_posts_options',
		'default'  => array(
			'font-family'    => '',
			'variant'        => '600',
			'font-size'      => '24px',
			'text-transform' => 'none',
			'line-height'    => '1.2',
		),
		'transport'   => 'auto',
		'output'      => array(
			array(
				'element' => '.section-highlight-posts-area .section-title',
			),
		),
		'active_callback' => array(
			array(
				'setting'  => 'disable_highlight_posts_section_title',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Disable Section Description', 'gutener' ),
		'type'         => 'checkbox',
		'settings'     => 'disable_highlight_posts_section_description',
		'section'      => 'highlight_posts_options',
		'default'      => true,
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Section Description', 'gutener' ),
		'type'        => 'text',
		'settings'    => 'highlight_posts_section_description',
		'section'     => 'highlight_posts_options',
		'default'     => '',
		'active_callback' => array(
			array(
				'setting'  => 'disable_highlight_posts_section_description',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Section Description Typography', 'gutener' ),
		'type'         => 'typography',
		'settings'     => 'highlight_posts_section_description_font_control',
		'section'      => 'highlight_posts_options',
		'default'  => array(
			'font-family'    => 'Open Sans',
			'variant'        => 'normal',
			'font-size'      => '16px',
			'text-transform' => 'none',
			'line-height'    => '1.8',
		),
		'transport'   => 'auto',
		'output'      => array(
			array(
				'element' => '.section-highlight-posts-area .section-title-wrap p',
			),
		),
		'active_callback' => array(
			array(
				'setting'  => 'disable_highlight_posts_section_description',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Section Title and Description Alignment', 'gutener' ),
		'type'        => 'select',
		'settings'    => 'highlight_posts_section_title_desc_alignment',
		'section'     => 'highlight_posts_options',
		'default'     => 'text-left',
		'choices'     => array(
			'text-left'	 	=> esc_html__( 'Left', 'gutener' ),
			'text-center'  	=> esc_html__( 'Center', 'gutener' ),   
			'text-right'		=> esc_html__( 'Right', 'gutener' ),
		),
		'active_callback' => array(
			array(
				array(
					'setting'  => 'disable_highlight_posts_section_title',
					'operator' => '==',
					'value'    => false,
				),
				array(
					'setting'  => 'disable_highlight_posts_section_description',
					'operator' => '==',
					'value'    => false,
				),
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Section Layout', 'gutener' ),
		'description' => esc_html__( 'Select layout & scroll below to change its options', 'gutener' ),
		'type'        => 'radio-image',
		'settings'    => 'highlight_posts_section_layouts',
		'section'     => 'highlight_posts_options',
		'default'     => 'highlighted_one',
		'choices'     => array(
			'highlighted_one'    => get_template_directory_uri() . '/assets/images/feature-post-layout-1.png',
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Post Title Color', 'gutener' ),
		'type'         => 'color',
		'settings'     => 'highlight_post_title_color',
		'section'      => 'highlight_posts_options',
		'default'      => '#FFFFFF',
		'active_callback' => array(
			array(
				'setting'  => 'skin_select',
				'operator' => 'contains',
				'value'    => array( 'default', 'blackwhite' ),
			),
			array(
				'setting'  => 'disable_highlight_posts_title',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Post Category Background Color', 'gutener' ),
		'type'         => 'color',
		'settings'     => 'highlight_post_category_bgcolor',
		'section'      => 'highlight_posts_options',
		'default'      => '',
		'active_callback' => array(
			array(
				'setting'  => 'highlight_posts_section_layouts',
				'operator' => '==',
				'value'    => 'highlighted_one',
			),
			array(
				'setting'  => 'hide_highlight_posts_category',
				'operator' => '==',
				'value'    => false,
			),
			array(
				'setting'  => 'skin_select',
				'operator' => 'contains',
				'value'    => array( 'default', 'blackwhite' ),
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Post Category Color', 'gutener' ),
		'type'         => 'color',
		'settings'     => 'highlight_post_category_color',
		'section'      => 'highlight_posts_options',
		'default'      => '#FFFFFF',
		'active_callback' => array(
			array(
				'setting'  => 'skin_select',
				'operator' => 'contains',
				'value'    => array( 'default', 'blackwhite' ),
			),
			array(
				'setting'  => 'hide_highlight_posts_category',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Post Meta Text Color', 'gutener' ),
		'type'         => 'color',
		'settings'     => 'highlight_post_meta_color',
		'section'      => 'highlight_posts_options',
		'default'      => '#FFFFFF',
		'active_callback' => array(
			array(
				'setting'  => 'skin_select',
				'operator' => 'contains',
				'value'    => array( 'default', 'blackwhite' ),
			),
			array(
				array(
				'setting'  => 'hide_highlight_posts_date',
				'operator' => '==',
				'value'    => false,
				),
				array(
				'setting'  => 'hide_highlight_posts_author',
				'operator' => '==',
				'value'    => false,
				),
				array(
				'setting'  => 'hide_highlight_posts_comment',
				'operator' => '==',
				'value'    => false,
				),
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Post Meta Icon Color', 'gutener' ),
		'type'         => 'color',
		'settings'     => 'highlight_post_meta_icon_color',
		'section'      => 'highlight_posts_options',
		'default'      => '#FFFFFF',
		'active_callback' => array(
			array(
				'setting'  => 'skin_select',
				'operator' => 'contains',
				'value'    => array( 'default', 'blackwhite' ),
			),
			array(
				array(
				'setting'  => 'hide_highlight_posts_date',
				'operator' => '==',
				'value'    => false,
				),
				array(
				'setting'  => 'hide_highlight_posts_author',
				'operator' => '==',
				'value'    => false,
				),
				array(
				'setting'  => 'hide_highlight_posts_comment',
				'operator' => '==',
				'value'    => false,
				),
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Post Hover Color', 'gutener' ),
		'type'         => 'color',
		'settings'     => 'highlight_post_hover_color',
		'section'      => 'highlight_posts_options',
		'default'      => '',
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Columns', 'gutener' ),
		'type'        => 'select',
		'settings'    => 'highlight_posts_columns',
		'section'     => 'highlight_posts_options',
		'default'     => 'three_columns',
		'placeholder' => esc_attr__( 'Select category', 'gutener' ),
		'choices'  => array(
			'one_column'    => esc_html__( '1 Column', 'gutener' ),
			'two_columns'   => esc_html__( '2 Columns', 'gutener' ),
			'three_columns' => esc_html__( '3 Columns', 'gutener' ),
			'four_columns'  => esc_html__( '4 Columns', 'gutener' ),
		)
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Choose Category', 'gutener' ),
		'description' => esc_html__( 'Recent posts will show if any category is not chosen.', 'gutener' ),
		'type'        => 'select',
		'settings'    => 'highlight_posts_category',
		'section'     => 'highlight_posts_options',
		'default'     => 'Uncategorized',
		'placeholder' => esc_html__( 'Select category', 'gutener' ), 
		'choices'     => gutener_get_post_categories()
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Highlighted Posts Overlay Opacity', 'gutener' ),
		'type'        => 'number',
		'settings'    => 'highlight_posts_overlay_opacity',
		'section'     => 'highlight_posts_options',
		'default'     => 4,
		'choices' => array(
			'min' => '0',
			'max' => '9',
			'step' => '1',
		)
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Post View Number', 'gutener' ),
		'description'  => esc_html__( 'Number of posts to show.', 'gutener' ),
		'type'         => 'number',
		'settings'     => 'highlight_posts_posts_number',
		'section'      => 'highlight_posts_options',
		'default'      => 6,
		'choices' => array(
			'min' => '1',
			'max' => '48',
			'step' => '1',
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Height (in px)', 'gutener' ),
		'description'  => esc_html__( 'This option will only apply to Desktop. Please click on below Desktop Icon to see changes. Automatically adjust by theme default in the responsive devices.
		', 'gutener' ),
		'type'         => 'slider',
		'settings'     => 'highlight_posts_height',
		'section'      => 'highlight_posts_options',
		'transport'    => 'postMessage',
		'default'      => 250,
		'choices' => array(
			'min' => '100',
			'max' => '1200',
			'step' => '10',
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Background Image Size', 'gutener' ),
		'type'         => 'radio',
		'settings'     => 'highlight_posts_image_size',
		'section'      => 'highlight_posts_options',
		'default'      => 'cover',
		'choices'      => array(
			'cover'    => esc_html__( 'Cover', 'gutener' ),
			'pattern'  => esc_html__( 'Pattern / Repeat', 'gutener' ),
			'norepeat' => esc_html__( 'No Repeat', 'gutener' ),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Posts Border Radius (px)', 'gutener' ),
		'type'        => 'slider',
		'settings'     => 'highlight_posts_radius',
		'section'      => 'highlight_posts_options',
		'transport'    => 'postMessage',
		'default'      =>  0,
		'choices'     => array(
			'min'  => 0,
			'max'  => 50,
			'step' => 1,
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Post Text Alignment', 'gutener' ),
		'type'        => 'select',
		'settings'    => 'highlight_posts_text_alignment',
		'section'     => 'highlight_posts_options',
		'default'     => 'text-center',
		'choices'     => array(
			'text-left'	 	=> esc_html__( 'Left', 'gutener' ),
			'text-center'  	=> esc_html__( 'Center', 'gutener' ),   
			'text-right'	=> esc_html__( 'Right', 'gutener' ),
		),
		'active_callback' => array(
			array(
				'setting'  => 'highlight_posts_section_layouts',
				'operator' => '==',
				'value'    => array( 'highlighted_one' ),
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Post Content Alignment', 'gutener' ),
		'type'        => 'select',
		'settings'    => 'highlight_posts_title_alignment',
		'section'     => 'highlight_posts_options',
		'default'     => 'align-center',
		'choices'     => array(
			'align-top'	 	=> esc_html__( 'Top', 'gutener' ),
			'align-center'  => esc_html__( 'Center', 'gutener' ),   
			'align-bottom'  => esc_html__( 'Bottom', 'gutener' ),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Disable Post Title', 'gutener' ),
		'type'        => 'checkbox',
		'settings'    => 'disable_highlight_posts_title',
		'section'     => 'highlight_posts_options',
		'default'     => false,
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Post Title Typography', 'gutener' ),
		'type'         => 'typography',
		'settings'     => 'highlight_posts_font_control',
		'section'      => 'highlight_posts_options',
		'default'  => array(
			'font-family'    => '',
			'variant'        => '500',
			'font-size'      => '18px',
			'text-transform' => 'uppercase',
			'line-height'    => '1.4',
		),
		'transport'   => 'auto',
		'output'      => array(
			array(
				'element' => '.post .highlight-posts-content .highlight-posts-title',
			),
		),
		'active_callback' => array(
			array(
				'setting'  => 'disable_highlight_posts_title',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Disable Post Title Divider', 'gutener' ),
		'type'        => 'checkbox',
		'settings'    => 'disable_highlight_title_divider',
		'section'     => 'highlight_posts_options',
		'default'     => false,
		'active_callback' => array(
			array(
				'setting'  => 'disable_highlight_posts_title',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Disable Posts category', 'gutener' ),
		'type'        => 'checkbox',
		'settings'    => 'hide_highlight_posts_category',
		'section'     => 'highlight_posts_options',
		'default'     => false,
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Post Category Typography', 'gutener' ),
		'type'         => 'typography',
		'settings'     => 'highlight_posts_cat_font_control',
		'section'      => 'highlight_posts_options',
		'default'  => array(
			'font-family'    => 'Poppins',
			'variant'        => '400',
			'font-size'      => '13px',
			'text-transform' => 'capitalize',
			'line-height'    => '1',
		),
		'transport'   => 'auto',
		'output'      => array(
			array(
				'element' => '.post .highlight-posts-content .cat-links a',
			),
		),
		'active_callback' => array(
			array(
				'setting'  => 'hide_highlight_posts_category',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Disable Post Date', 'gutener' ),
		'type'        => 'checkbox',
		'settings'    => 'hide_highlight_posts_date',
		'section'     => 'highlight_posts_options',
		'default'     => false,
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Disable Post Author', 'gutener' ),
		'type'        => 'checkbox',
		'settings'    => 'hide_highlight_posts_author',
		'section'     => 'highlight_posts_options',
		'default'     => false,
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Disable Post Comment', 'gutener' ),
		'type'        => 'checkbox',
		'settings'    => 'hide_highlight_posts_comment',
		'section'     => 'highlight_posts_options',
		'default'     => false,
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Post Meta Typography', 'gutener' ),
		'type'         => 'typography',
		'settings'     => 'highlight_posts_meta_font_control',
		'section'      => 'highlight_posts_options',
		'default'  => array(
			'font-family'    => 'Poppins',
			'variant'        => '400',
			'font-size'      => '13px',
			'text-transform' => 'capitalize',
			'line-height'    => '1.6',
		),
		'transport'   => 'auto',
		'output'      => array(
			array(
				'element' => '.post .highlight-posts-content .entry-meta a',
			),
		),
		'active_callback' => array(
			array(
				array(
				'setting'  => 'hide_highlight_posts_date',
				'operator' => '==',
				'value'    => false,
				),
				array(
				'setting'  => 'hide_highlight_posts_author',
				'operator' => '==',
				'value'    => false,
				),
				array(
				'setting'  => 'hide_highlight_posts_comment',
				'operator' => '==',
				'value'    => false,
				),
			),
		),
	) );

	// Latest Posts Options
	Kirki::add_section( 'latest_posts_options', array(
	    'title'          => esc_html__( 'Latest Posts', 'gutener' ),
	    'description'    => esc_html__( 'More options are available in Blog Page Section.', 'gutener' ),
	    'panel'          => 'blog_homepage_options',
	    'capability'     => 'edit_theme_options',
	    'priority'       => '30',
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Disable Latest Posts Section From Homepage', 'gutener' ),
		'type'        => 'checkbox',
		'settings'    => 'disable_latest_posts_section',
		'section'     => 'latest_posts_options',
		'default'     => false,
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Disable Section Title', 'gutener' ),
		'type'         => 'checkbox',
		'settings'     => 'disable_latest_posts_section_title',
		'section'      => 'latest_posts_options',
		'default'      => true,
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Section Title', 'gutener' ),
		'type'        => 'text',
		'settings'    => 'latest_posts_section_title',
		'section'     => 'latest_posts_options',
		'default'     => '',
		'active_callback' => array(
			array(
				'setting'  => 'disable_latest_posts_section_title',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Section Title Typography', 'gutener' ),
		'type'         => 'typography',
		'settings'     => 'latest_posts_section_title_font_control',
		'section'      => 'latest_posts_options',
		'default'  => array(
			'font-family'    => '',
			'variant'        => '600',
			'font-size'      => '24px',
			'text-transform' => 'none',
			'line-height'    => '1.2',
		),
		'transport'   => 'auto',
		'output'      => array(
			array(
				'element' => '.section-post-area .section-title-wrap .section-title',
			),
		),
		'active_callback' => array(
			array(
				'setting'  => 'disable_latest_posts_section_title',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Disable Section Description', 'gutener' ),
		'type'         => 'checkbox',
		'settings'     => 'disable_latest_posts_section_description',
		'section'      => 'latest_posts_options',
		'default'      => true,
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Section Description', 'gutener' ),
		'type'        => 'text',
		'settings'    => 'latest_posts_section_description',
		'section'     => 'latest_posts_options',
		'default'     => '',
		'active_callback' => array(
			array(
				'setting'  => 'disable_latest_posts_section_description',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Section Description Typography', 'gutener' ),
		'type'         => 'typography',
		'settings'     => 'latest_posts_section_description_font_control',
		'section'      => 'latest_posts_options',
		'default'  => array(
			'font-family'    => 'Open Sans',
			'variant'        => 'normal',
			'font-size'      => '16px',
			'text-transform' => 'none',
			'line-height'    => '1.8',
		),
		'transport'   => 'auto',
		'output'      => array(
			array(
				'element' => '.section-post-area .section-title-wrap p',
			),
		),
		'active_callback' => array(
			array(
				'setting'  => 'disable_latest_posts_section_description',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Section Title and Description Alignment', 'gutener' ),
		'type'        => 'select',
		'settings'    => 'latest_posts_section_title_desc_alignment',
		'section'     => 'latest_posts_options',
		'default'     => 'left',
		'choices'     => array(
			'left'	 	=> esc_html__( 'Left', 'gutener' ),
			'center'  	=> esc_html__( 'Center', 'gutener' ),   
			'right'		=> esc_html__( 'Right', 'gutener' ),
		),
		'active_callback' => array(
			array(
				array(
					'setting'  => 'disable_latest_posts_section_title',
					'operator' => '==',
					'value'    => false,
				),
				array(
					'setting'  => 'disable_latest_posts_section_description',
					'operator' => '==',
					'value'    => false,
				),
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Choose Category', 'gutener' ),
		'description' => esc_html__( 'Recent posts will show if any category is not chosen.', 'gutener' ),
		'type'        => 'select',
		'settings'    => 'latest_posts_category',
		'section'     => 'latest_posts_options',
		'default'     => '',
		'placeholder' => esc_html__( 'Select category', 'gutener' ), 
		'choices'     => gutener_get_post_categories()
	) );

	// Featured Posts Options
	Kirki::add_section( 'feature_posts_options', array(
	    'title'          => esc_html__( 'Featured Posts', 'gutener' ),
	    'panel'          => 'blog_homepage_options',
	    'capability'     => 'edit_theme_options',
	    'priority'       => '40',
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Disable Featured Posts Section', 'gutener' ),
		'type'         => 'checkbox',
		'settings'     => 'disable_feature_posts_section',
		'section'      => 'feature_posts_options',
		'default'      => false,
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Disable Section Title', 'gutener' ),
		'type'         => 'checkbox',
		'settings'     => 'disable_feature_posts_section_title',
		'section'      => 'feature_posts_options',
		'default'      => false,
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Section Title', 'gutener' ),
		'type'        => 'text',
		'settings'    => 'feature_posts_section_title',
		'section'     => 'feature_posts_options',
		'default'     => '',
		'active_callback' => array(
			array(
				'setting'  => 'disable_feature_posts_section_title',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Section Title Typography', 'gutener' ),
		'type'         => 'typography',
		'settings'     => 'feature_posts_section_title_font_control',
		'section'      => 'feature_posts_options',
		'default'  => array(
			'font-family'    => '',
			'variant'        => '600',
			'font-size'      => '24px',
			'text-transform' => 'none',
			'line-height'    => '1.2',
		),
		'transport'   => 'auto',
		'output'      => array(
			array(
				'element' => '.section-feature-post .section-title',
			),
		),
		'active_callback' => array(
			array(
				'setting'  => 'disable_feature_posts_section_title',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Disable Section Description', 'gutener' ),
		'type'         => 'checkbox',
		'settings'     => 'disable_feature_posts_section_description',
		'section'      => 'feature_posts_options',
		'default'      => true,
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Section Description', 'gutener' ),
		'type'        => 'text',
		'settings'    => 'feature_posts_section_description',
		'section'     => 'feature_posts_options',
		'default'     => '',
		'active_callback' => array(
			array(
				'setting'  => 'disable_feature_posts_section_description',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Section Description Typography', 'gutener' ),
		'type'         => 'typography',
		'settings'     => 'feature_posts_section_description_font_control',
		'section'      => 'feature_posts_options',
		'default'  => array(
			'font-family'    => 'Open Sans',
			'variant'        => 'normal',
			'font-size'      => '16px',
			'text-transform' => 'none',
			'line-height'    => '1.8',
		),
		'transport'   => 'auto',
		'output'      => array(
			array(
				'element' => '.section-feature-post .section-title-wrap p',
			),
		),
		'active_callback' => array(
			array(
				'setting'  => 'disable_feature_posts_section_description',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Section Title and Description Alignment', 'gutener' ),
		'type'        => 'select',
		'settings'    => 'feature_posts_section_title_desc_alignment',
		'section'     => 'feature_posts_options',
		'default'     => 'text-left',
		'choices'     => array(
			'text-left'	 	=> esc_html__( 'Left', 'gutener' ),
			'text-center'  	=> esc_html__( 'Center', 'gutener' ),   
			'text-right'	=> esc_html__( 'Right', 'gutener' ),
		),
		'active_callback' => array(
			array(
				array(
					'setting'  => 'disable_feature_posts_section_title',
					'operator' => '==',
					'value'    => false,
				),
				array(
					'setting'  => 'disable_feature_posts_section_description',
					'operator' => '==',
					'value'    => false,
				),
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Section Layout', 'gutener' ),
		'description' => esc_html__( 'Select layout & scroll below to change its options', 'gutener' ),
		'type'        => 'radio-image',
		'settings'    => 'feature_posts_section_layouts',
		'section'     => 'feature_posts_options',
		'default'     => 'feature_one',
		'choices'     => array(
			'feature_one'    => get_template_directory_uri() . '/assets/images/highlight-layout-1.png',
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Choose Category', 'gutener' ),
		'description' => esc_html__( 'Recent posts will show if any category is not chosen.', 'gutener' ),
		'type'        => 'select',
		'settings'    => 'feature_posts_category',
		'section'     => 'feature_posts_options',
		'default'     => 'Uncategorized',
		'placeholder' => esc_html__( 'Select category', 'gutener' ),
		'choices'     => gutener_get_post_categories()
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Post Title Color', 'gutener' ),
		'type'         => 'color',
		'settings'     => 'feature_post_title_color',
		'section'      => 'feature_posts_options',
		'default'      => '#030303',
		'active_callback' => array(
			array(
				'setting'  => 'skin_select',
				'operator' => 'contains',
				'value'    => array( 'default', 'blackwhite' ),
			),
			array(
				'setting'  => 'hide_feature_posts_title',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );
	
	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Post Category Background Color', 'gutener' ),
		'type'         => 'color',
		'settings'     => 'feature_post_category_bgcolor',
		'section'      => 'feature_posts_options',
		'default'      => '#1f1f1f',
		'active_callback' => array(
			array(
				'setting'  => 'skin_select',
				'operator' => 'contains',
				'value'    => array( 'default', 'blackwhite' ),
			),
			array(
				'setting'  => 'hide_feature_posts_category',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Post Category Color', 'gutener' ),
		'type'         => 'color',
		'settings'     => 'feature_post_category_color',
		'section'      => 'feature_posts_options',
		'default'      => '#FFFFFF',
		'active_callback' => array(
			array(
				'setting'  => 'skin_select',
				'operator' => 'contains',
				'value'    => array( 'default', 'blackwhite' ),
			),
			array(
				'setting'  => 'hide_feature_posts_category',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Post Meta Text Color', 'gutener' ),
		'type'         => 'color',
		'settings'     => 'feature_post_meta_color',
		'section'      => 'feature_posts_options',
		'default'      => '#7a7a7a',
		'active_callback' => array(
			array(
				'setting'  => 'skin_select',
				'operator' => 'contains',
				'value'    => array( 'default', 'blackwhite' ),
			),
			array(
				array(
				'setting'  => 'hide_feature_posts_date',
				'operator' => '==',
				'value'    => false,
				),
				array(
				'setting'  => 'hide_feature_posts_author',
				'operator' => '==',
				'value'    => false,
				),
				array(
				'setting'  => 'hide_feature_posts_comment',
				'operator' => '==',
				'value'    => false,
				),
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Post Meta Icon Color', 'gutener' ),
		'type'         => 'color',
		'settings'     => 'feature_post_meta_icon_color',
		'section'      => 'feature_posts_options',
		'default'      => '',
		'active_callback' => array(
			array(
				'setting'  => 'skin_select',
				'operator' => 'contains',
				'value'    => array( 'default', 'blackwhite' ),
			),
			array(
				array(
				'setting'  => 'hide_feature_posts_date',
				'operator' => '==',
				'value'    => false,
				),
				array(
				'setting'  => 'hide_feature_posts_author',
				'operator' => '==',
				'value'    => false,
				),
				array(
				'setting'  => 'hide_feature_posts_comment',
				'operator' => '==',
				'value'    => false,
				),
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Post Hover Color', 'gutener' ),
		'type'         => 'color',
		'settings'     => 'feature_post_hover_color',
		'section'      => 'feature_posts_options',
		'default'      => '',
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Post Border Radius (px)', 'gutener' ),
		'type'        => 'slider',
		'settings'    => 'feature_posts_radius',
		'section'     => 'feature_posts_options',
		'transport'   => 'postMessage',
		'default'     =>  0,
		'choices'     => array(
			'min'  => 0,
			'max'  => 50,
			'step' => 1,
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Slider Columns', 'gutener' ),
		'type'         => 'number',
		'settings'     => 'feature_posts_slides_show',
 		'section'      => 'feature_posts_options',
		'default'      => 3,
		'choices' => array(
			'min' => '2',
			'max' => '4',
			'step'=> '1',
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Disable Arrows', 'gutener' ),
		'type'         => 'checkbox',
		'settings'     => 'disable_feature_posts_arrows',
		'section'      => 'feature_posts_options',
		'default'      => false,
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Disable Dots', 'gutener' ),
		'type'         => 'checkbox',
		'settings'     => 'disable_feature_posts_dots',
		'section'      => 'feature_posts_options',
		'default'      => false,
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Disable Slider Auto Play', 'gutener' ),
		'type'         => 'checkbox',
		'settings'     => 'disable_feature_posts_autoplay',
		'section'      => 'feature_posts_options',
		'default'      => true,
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Slider Auto Play Timeout ( in sec )', 'gutener' ),
		'type'         => 'number',
		'settings'     => 'feature_posts_autoplay_speed',
 		'section'      => 'feature_posts_options',
		'default'      => 4,
		'choices' => array(
			'min' => '1',
			'max' => '60',
			'step'=> '1',
		),
		'active_callback' => array(
			array(
				'setting'  => 'disable_feature_posts_autoplay',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Slider Post View Number', 'gutener' ),
		'description'  => esc_html__( 'Number of posts to show.', 'gutener' ),
		'type'         => 'number',
		'settings'     => 'feature_posts_posts_number',
		'section'      => 'feature_posts_options',
		'default'      => 6,
		'choices' => array(
			'min' => '1',
			'max' => '20',
			'step' => '1',
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Disable Post category', 'gutener' ),
		'type'        => 'checkbox',
		'settings'    => 'hide_feature_posts_category',
		'section'     => 'feature_posts_options',
		'default'     => false,
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Post Category Typography', 'gutener' ),
		'type'         => 'typography',
		'settings'     => 'feature_posts_cat_font_control',
		'section'      => 'feature_posts_options',
		'default'  => array(
			'font-family'    => 'Poppins',
			'variant'        => '400',
			'font-size'      => '13px',
			'text-transform' => 'capitalize',
			'line-height'    => '1',
		),
		'transport'   => 'auto',
		'output'      => array(
			array(
				'element' => '.feature-post-slider .post-inner .cat-links a',
			),
		),
		'active_callback' => array(
			array(
				'setting'  => 'hide_feature_posts_category',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Disable Post Title', 'gutener' ),
		'type'        => 'checkbox',
		'settings'    => 'hide_feature_posts_title',
		'section'     => 'feature_posts_options',
		'default'     => false,
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Post Title Typography', 'gutener' ),
		'type'         => 'typography',
		'settings'     => 'feature_posts_title_font_control',
		'section'      => 'feature_posts_options',
		'default'  => array(
			'font-family'    => '',
			'variant'        => '500',
			'font-size'      => '18px',
			'text-transform' => 'none',
			'line-height'    => '1.4',
		),
		'transport'   => 'auto',
		'output'      => array(
			array(
				'element' => '.feature-post-slider .post-content-wrap .entry-content .entry-title',
			),
		),
		'active_callback' => array(
			array(
				'setting'  => 'hide_feature_posts_title',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Disable Post Date', 'gutener' ),
		'type'        => 'checkbox',
		'settings'    => 'hide_feature_posts_date',
		'section'     => 'feature_posts_options',
		'default'     => false,
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Disable Post Author', 'gutener' ),
		'type'        => 'checkbox',
		'settings'    => 'hide_feature_posts_author',
		'section'     => 'feature_posts_options',
		'default'     => false,
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Disable Post Comment', 'gutener' ),
		'type'        => 'checkbox',
		'settings'    => 'hide_feature_posts_comment',
		'section'     => 'feature_posts_options',
		'default'     => false,
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Post Meta Typography', 'gutener' ),
		'type'         => 'typography',
		'settings'     => 'feature_posts_meta_font_control',
		'section'      => 'feature_posts_options',
		'default'  => array(
			'font-family'    => 'Poppins',
			'variant'        => '400',
			'font-size'      => '13px',
			'text-transform' => 'capitalize',
			'line-height'    => '1.6',
		),
		'transport'   => 'auto',
		'output'      => array(
			array(
				'element' => '.feature-post-slider .post-content-wrap .entry-meta a',
			),
		),
		'active_callback' => array(
			array(
				array(
				'setting'  => 'hide_feature_posts_date',
				'operator' => '==',
				'value'    => false,
				),
				array(
				'setting'  => 'hide_feature_posts_author',
				'operator' => '==',
				'value'    => false,
				),
				array(
				'setting'  => 'hide_feature_posts_comment',
				'operator' => '==',
				'value'    => false,
				),
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Disable Post Image', 'gutener' ),
		'type'        => 'checkbox',
		'settings'    => 'hide_feature_posts_image',
		'section'     => 'feature_posts_options',
		'default'     => false,
	) );

	// Responsive
	Kirki::add_section( 'blog_page_responsive', array(
	    'title'          => esc_html__( 'Responsive', 'gutener' ),
	    'description'    => esc_html__( 'These options will only apply to Tablet and Mobile devices. Please
	    	click on below Tablet or Mobile Icons to see changes.', 'gutener' ),
	    'capability'     => 'edit_theme_options',
	    'priority'       => '50',
	    'panel'			 => 'blog_homepage_options',		
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Disable Main Slider / Banner', 'gutener' ),
		'type'        => 'checkbox',
		'settings'    => 'disable_mobile_main_slider',
		'section'     => 'blog_page_responsive',
		'default'     => false,
		'active_callback' => array(
			array(
				'setting'  => 'disable_main_slider',
				'operator' => '=',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Disable Highlighted Posts', 'gutener' ),
		'type'         => 'checkbox',
		'settings'     => 'disable_mobile_highlight_posts',
		'section'      => 'blog_page_responsive',
		'default'      => false,
		'active_callback' => array(
			array(
				'setting'  => 'disable_highlight_posts_section',
				'operator' => '=',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Disable Latest Posts', 'gutener' ),
		'type'         => 'checkbox',
		'settings'     => 'disable_mobile_latest_posts',
		'section'      => 'blog_page_responsive',
		'default'      => false,
		'active_callback' => array(
			array(
				'setting'  => 'disable_latest_posts_section',
				'operator' => '=',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Disable Featured Posts', 'gutener' ),
		'type'         => 'checkbox',
		'settings'     => 'disable_mobile_feature_posts',
		'section'      => 'blog_page_responsive',
		'default'      => false,
		'active_callback' => array(
			array(
				'setting'  => 'disable_feature_posts_section',
				'operator' => '=',
				'value'    => false,
			),
		),
	) );

	// Blog Page Options
    Kirki::add_panel( 'blog_page_options', array(
	    'title'          => esc_html__( 'Blog Page', 'gutener' ),
	    'priority'       => '130',
	) );

    // Blog Page Style Options
	Kirki::add_section( 'blog_page_style_options', array(
	    'title'      => esc_html__( 'Style', 'gutener' ),
	    'panel'      => 'blog_page_options',	   
	    'capability' => 'edit_theme_options',
	    'priority'   => '10',
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Post Layouts', 'gutener' ),
		'description' => esc_html__( 'Grid / List / Single', 'gutener' ),
		'type'        => 'radio-image',
		'settings'    => 'archive_post_layout',
		'section'     => 'blog_page_style_options',
		'default'     => 'grid',
		'choices'  => array(
			'grid'           => get_template_directory_uri() . '/assets/images/grid-layout.png',
			'list'           => get_template_directory_uri() . '/assets/images/list-layout.png',
			'single'         => get_template_directory_uri() . '/assets/images/single-layout.png',
		)
	) );

	Kirki::add_field( 'gutener', array(
		'label'       	=> esc_html__( 'Posts Border Radius (px)', 'gutener' ),
		'type'        	=> 'slider',
		'settings'     	=> 'latest_posts_radius',
		'section'      	=> 'blog_page_style_options',
		'default'      	=>  0,
		'transport'		=> 'postMessage',
		'choices'     => array(
			'min'  => 0,
			'max'  => 50,
			'step' => 1,
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Post Title Color', 'gutener' ),
		'type'         => 'color',
		'settings'     => 'blog_post_title_color',
		'section'      => 'blog_page_style_options',
		'default'      => '#101010',
		'active_callback' => array(
			array(
				'setting'  => 'skin_select',
				'operator' => 'contains',
				'value'    => array( 'default', 'blackwhite' ),
			),
			array(
				'setting'  => 'hide_post_title',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Post Category Color', 'gutener' ),
		'type'         => 'color',
		'settings'     => 'blog_post_category_color',
		'section'      => 'blog_page_style_options',
		'default'      => '#f9a032',
		'active_callback' => array(
			array(
				'setting'  => 'hide_category',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Post Meta Color', 'gutener' ),
		'type'         => 'color',
		'settings'     => 'blog_post_meta_color',
		'section'      => 'blog_page_style_options',
		'default'      => '#7a7a7a',
		'active_callback' => array(
			array(
				'setting'  => 'skin_select',
				'operator' => 'contains',
				'value'    => array( 'default', 'blackwhite' ),
			),
			array(
				array(
				'setting'  => 'hide_date',
				'operator' => '==',
				'value'    => false,
				),
				array(
				'setting'  => 'hide_author',
				'operator' => '==',
				'value'    => false,
				),
				array(
				'setting'  => 'hide_comment',
				'operator' => '==',
				'value'    => false,
				),
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Post Meta Icon Color', 'gutener' ),
		'type'         => 'color',
		'settings'     => 'blog_post_meta_icon_color',
		'section'      => 'blog_page_style_options',
		'default'      => '',
		'active_callback' => array(
			array(
				'setting'  => 'skin_select',
				'operator' => 'contains',
				'value'    => array( 'default', 'blackwhite' ),
			),
			array(
				array(
				'setting'  => 'hide_date',
				'operator' => '==',
				'value'    => false,
				),
				array(
				'setting'  => 'hide_author',
				'operator' => '==',
				'value'    => false,
				),
				array(
				'setting'  => 'hide_comment',
				'operator' => '==',
				'value'    => false,
				),
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Post Text Color', 'gutener' ),
		'type'         => 'color',
		'settings'     => 'blog_post_text_color',
		'section'      => 'blog_page_style_options',
		'default'      => '#333333',
		'active_callback' => array(
			array(
				'setting'  => 'skin_select',
				'operator' => 'contains',
				'value'    => array( 'default', 'blackwhite' ),
			),
			array(
				'setting'  => 'hide_blog_page_excerpt',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Post Hover Color', 'gutener' ),
		'type'         => 'color',
		'settings'     => 'blog_post_hover_color',
		'section'      => 'blog_page_style_options',
		'default'      => '',
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Disable Post Title', 'gutener' ),
		'type'        => 'checkbox',
		'settings'    => 'hide_post_title',
		'section'     => 'blog_page_style_options',
		'default'     => false,
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Post Title Typography', 'gutener' ),
		'type'         => 'typography',
		'settings'     => 'blog_page_title_font_control',
		'section'      => 'blog_page_style_options',
		'default'  => array(
			'font-family'    => 'Montserrat',
			'variant'        => '500',
			'font-size'      => '21px',
			'text-transform' => 'none',
			'line-height'    => '1.4',
		),
		'transport'   => 'auto',
		'output'      => array(
			array(
				'element' => '#primary article .entry-title',
			),
		),
		'active_callback' => array(
			array(
				'setting'  => 'hide_post_title',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Disable Category', 'gutener' ),
		'type'        => 'checkbox',
		'settings'    => 'hide_category',
		'section'     => 'blog_page_style_options',
		'default'     => false,
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Post Category Typography', 'gutener' ),
		'type'         => 'typography',
		'settings'     => 'blog_post_cat_font_control',
		'section'      => 'blog_page_style_options',
		'default'  => array(
			'font-family'    => '',
			'variant'        => '400',
			'font-size'      => '13px',
			'text-transform' => 'uppercase',
			'line-height'    => '1.6',
		),
		'transport'   => 'auto',
		'output'      => array(
			array(
				'element' => '#primary .post .entry-content .entry-header .cat-links a',
			),
		),
		'active_callback' => array(
			array(
				'setting'  => 'hide_category',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Disable Date', 'gutener' ),
		'type'        => 'checkbox',
		'settings'    => 'hide_date',
		'section'     => 'blog_page_style_options',
		'default'     => false,
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Disable Author', 'gutener' ),
		'type'        => 'checkbox',
		'settings'    => 'hide_author',
		'section'     => 'blog_page_style_options',
		'default'     => false,
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Disable Comments Link', 'gutener' ),
		'type'        => 'checkbox',
		'settings'    => 'hide_comment',
		'section'     => 'blog_page_style_options',
		'default'     => false,
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Post Meta Typography', 'gutener' ),
		'type'         => 'typography',
		'settings'     => 'blog_post_meta_font_control',
		'section'      => 'blog_page_style_options',
		'default'  => array(
			'font-family'    => 'Poppins',
			'variant'        => '400',
			'font-size'      => '13px',
			'text-transform' => 'capitalize',
			'line-height'    => '1.6',
		),
		'transport'   => 'auto',
		'output'      => array(
			array(
				'element' => '#primary .entry-meta',
			),
		),
		'active_callback' => array(
			array(
				array(
				'setting'  => 'hide_date',
				'operator' => '==',
				'value'    => false,
				),
				array(
				'setting'  => 'hide_author',
				'operator' => '==',
				'value'    => false,
				),
				array(
				'setting'  => 'hide_comment',
				'operator' => '==',
				'value'    => false,
				),
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Disable Excerpt', 'gutener' ),
		'type'        => 'checkbox',
		'settings'    => 'hide_blog_page_excerpt',
		'section'     => 'blog_page_style_options',
		'default'     => false,
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Post Excerpt Typography', 'gutener' ),
		'type'         => 'typography',
		'settings'     => 'blog_post_excerpt_font_control',
		'section'      => 'blog_page_style_options',
		'default'  => array(
			'font-family'    => '',
			'variant'        => '400',
			'font-size'      => '15px',
			'text-transform' => 'initial',
			'line-height'    => '1.8',
		),
		'transport'   => 'auto',
		'output'      => array(
			array(
				'element' => '#primary .entry-text p',
			),
		),
		'active_callback' => array(
			array(
				'setting'  => 'hide_blog_page_excerpt',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Excerpt Length', 'gutener' ),
		'description' => esc_html__( 'Select number of words to display in excerpt', 'gutener' ),
		'type'        => 'number',
		'settings'    => 'post_excerpt_length',
		'section'     => 'blog_page_style_options',
		'default'     => 15,
		'choices' => array(
			'min'  => '5',
			'max'  => '60',
			'step' => '5',
		),
		'active_callback' => array(
			array(
				'setting'  => 'hide_blog_page_excerpt',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Sticky Post Excerpt Length', 'gutener' ),
		'description' => esc_html__( 'Select number of words to display in excerpt', 'gutener' ),
		'type'        => 'number',
		'settings'    => 'sticky_simple_post_excerpt_length',
		'section'     => 'blog_page_style_options',
		'default'     => 40,
		'choices' => array(
			'min'  => '5',
			'max'  => '60',
			'step' => '5',
		),
		'active_callback' => array(
			array(
				'setting'  => 'hide_blog_page_excerpt',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Disable Button', 'gutener' ),
		'type'        => 'checkbox',
		'settings'    => 'hide_post_button',
		'section'     => 'blog_page_style_options',
		'default'     => true,
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Button Type', 'gutener' ),
		'type'        => 'select',
		'settings'    => 'post_button_type',
		'section'     => 'blog_page_style_options',
		'default'     => 'button-text',
		'choices'  => array(
			'button-primary' => esc_html__( 'Primary Button', 'gutener' ),
			'button-outline' => esc_html__( 'Border Button', 'gutener' ),
			'button-text'    => esc_html__( 'Text Only Button', 'gutener' ),
		),
		'active_callback' => array(
			array(
				'setting'  => 'hide_post_button',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Post Button Background Color', 'gutener' ),
		'type'         => 'color',
		'settings'     => 'blog_post_button_background_color',
		'section'      => 'blog_page_style_options',
		'default'      => '',
		'active_callback' => array(
			array(
				'setting'  => 'hide_post_button',
				'operator' => '==',
				'value'    => false,
			),
			array(
				'setting'  => 'post_button_type',
				'operator' => '==',
				'value'    => 'button-primary',
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Post Button Border Color', 'gutener' ),
		'type'         => 'color',
		'settings'     => 'blog_post_button_border_color',
		'section'      => 'blog_page_style_options',
		'default'      => '',
		'active_callback' => array(
			array(
				'setting'  => 'hide_post_button',
				'operator' => '==',
				'value'    => false,
			),
			array(
				'setting'  => 'post_button_type',
				'operator' => '==',
				'value'    => 'button-outline',
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Post Button Text Color', 'gutener' ),
		'type'         => 'color',
		'settings'     => 'blog_post_button_color',
		'section'      => 'blog_page_style_options',
		'default'      => '#333333',
		'active_callback' => array(
			array(
				'setting'  => 'hide_post_button',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Post Button Hover Color', 'gutener' ),
		'type'         => 'color',
		'settings'     => 'blog_post_button_hover_color',
		'section'      => 'blog_page_style_options',
		'default'      => '',
		'active_callback' => array(
			array(
				'setting'  => 'hide_post_button',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Button Text', 'gutener' ),
		'type'        => 'text',
		'settings'    => 'post_button_text',
		'section'     => 'blog_page_style_options',
		'default'     => '',
		'active_callback' => array(
			array(
				'setting'  => 'hide_post_button',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Post Button Typography', 'gutener' ),
		'type'         => 'typography',
		'settings'     => 'blog_post_button_font_control',
		'section'      => 'blog_page_style_options',
		'default'  => array(
			'font-family'    => '',
			'variant'        => '600',
			'font-size'      => '14px',
			'text-transform' => 'capitalize',
			'line-height'    => '1.6',
		),
		'transport'   => 'auto',
		'output'      => array(
			array(
				'element' => '#primary .post .entry-text .button-container a',
			),
		),
		'active_callback' => array(
			array(
				'setting'  => 'hide_post_button',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Button Border Radius (px)', 'gutener' ),
		'type'        => 'slider',
		'settings'    => 'post_button_border_radius',
		'section'     => 'blog_page_style_options',
		'transport'   => 'postMessage',
		'default'     => 0,
		'choices'     => array(
			'min'  => 0,
			'max'  => 50,
			'step' => 1,
		),
		'active_callback' => array(
			array(
				'setting'  => 'hide_post_button',
				'operator' => '==',
				'value'    => false,
			),
			array(
				'setting'  => 'post_button_type',
				'operator' => 'contains',
				'value'    => array( 'button-primary', 'button-outline' ),
			),
		),
	) );

	// Blog Page Elements Options
	Kirki::add_section( 'blog_page_elements_options', array(
	    'title'      => esc_html__( 'Elements', 'gutener' ),
	    'panel'      => 'blog_page_options',	   
	    'capability' => 'edit_theme_options',
	    'priority'   => '20',
	) );

	Kirki::add_field( 'gutener',  array(
		'label'       => esc_html__( 'Blog Archive Pages Title', 'gutener' ),
		'type'        => 'select',
		'settings'    => 'disable_blog_page_title',
		'section'     => 'blog_page_elements_options',
		'default'     => 'enable_all_pages',
		'choices'     => array(
			'enable_all_pages'  => esc_html__( 'Enable in all', 'gutener' ),
			'disable_all_pages' => esc_html__( 'Disable from all', 'gutener' ),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Disable Pagination', 'gutener' ),
		'type'        => 'checkbox',
		'settings'    => 'disable_pagination',
		'section'     => 'blog_page_elements_options',
		'default'     => false,
	) );

	// Single Post Options
	Kirki::add_section( 'single_post_options', array(
	    'title'          => esc_html__( 'Single Post', 'gutener' ),
	    'capability'     => 'edit_theme_options',
	    'priority'       => '140',
	) );

	Kirki::add_field( 'gutener',  array(
		'label'       => esc_html__( 'Post Title', 'gutener' ),
		'type'        => 'select',
		'settings'    => 'disable_single_post_title',
		'section'     => 'single_post_options',
		'default'     => 'enable_all_pages',
		'choices'     => array(
			'enable_all_pages'    => esc_html__( 'Enable in all', 'gutener' ),
			'disable_all_pages'   => esc_html__( 'Disable from all', 'gutener' ),
		),
	) );

	Kirki::add_field( 'gutener',  array(
		'label'       => esc_html__( 'Post Title Position', 'gutener' ),
		'type'        => 'select',
		'settings'    => 'post_title_position',
		'section'     => 'single_post_options',
		'default'     => 'below_feature_image',
		'choices'     => array(
			'below_feature_image' => esc_html__( 'Below Feature Image', 'gutener' ),
			'above_feature_image' => esc_html__( 'Top of the Page', 'gutener' ),
		),
		'active_callback' => array(
			array(
				array(
					'setting'  => 'disable_transparent_header_post',
					'operator' => '==',
					'value'    => true,
				),
				array(
					'setting'  => 'header_layout',
					'operator' => '!=',
					'value'    => 'header_three',
				),
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Feature Image', 'gutener' ),
		'type'        => 'select',
		'settings'    => 'single_feature_image',
		'section'     => 'single_post_options',
		'default'     => 'show_in_all_pages',
		'choices' => array(
			'show_in_all_pages'    => esc_html__( 'Show in all Pages', 'gutener' ),
			'disable_in_all_pages' => esc_html__( 'Disable in all Pages', 'gutener' ),
		),
		'active_callback' => array(
			array(
				array(
					'setting'  => 'disable_transparent_header_post',
					'operator' => '==',
					'value'    => true,
				),
				array(
					'setting'  => 'header_layout',
					'operator' => '!=',
					'value'    => 'header_three',
				),
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Disable Transparent Header', 'gutener' ),
		'type'        => 'checkbox',
		'settings'    => 'disable_transparent_header_post',
		'section'     => 'single_post_options',
		'default'     => true,
		'active_callback' => array(
			array(
				'setting'  => 'header_layout',
				'operator' => '==',
				'value'    => 'header_three',
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Transparent Header Banner Height (in px)', 'gutener' ),
		'type'        => 'slider',
		'settings'    => 'transparent_header_banner_post_height',
		'section'     => 'single_post_options',
		'transport'   => 'postMessage',
		'default'     => 400,
		'choices'     => array(
			'min'  => 50,
			'max'  => 1500,
			'step' => 10,
		),
		'active_callback' => array(
			array(
				'setting'  => 'header_layout',
				'operator' => '==',
				'value'    => 'header_three',
			),
			array(
				'setting'  => 'disable_transparent_header_post',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Transparent Header Banner Image Size', 'gutener' ),
		'type'         => 'radio',
		'settings'     => 'transparent_header_banner_post_size',
		'section'      => 'single_post_options',
		'default'      => 'cover',
		'choices'      => array(
			'cover'    => esc_html__( 'Cover', 'gutener' ),
			'pattern'  => esc_html__( 'Pattern / Repeat', 'gutener' ),
			'norepeat' => esc_html__( 'No Repeat', 'gutener' ),
		),
		'active_callback' => array(
			array(
				'setting'  => 'header_layout',
				'operator' => '==',
				'value'    => 'header_three',
			),
			array(
				'setting'  => 'disable_transparent_header_post',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Transparent Header Banner Overlay Opacity', 'gutener' ),
		'type'        => 'number',
		'settings'    => 'transparent_header_banner_post_opacity',
		'section'     => 'single_post_options',
		'default'     => 4,
		'choices' => array(
			'min' => '0',
			'max' => '9',
			'step' => '1',
		),
		'active_callback' => array(
			array(
				'setting'  => 'header_layout',
				'operator' => '==',
				'value'    => 'header_three',
			),
			array(
				'setting'  => 'disable_transparent_header_post',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Disable Date', 'gutener' ),
		'type'        => 'checkbox',
		'settings'    => 'hide_single_post_date',
		'section'     => 'single_post_options',
		'default'     => false,
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Disable Comments Link', 'gutener' ),
		'type'        => 'checkbox',
		'settings'    => 'hide_single_post_comment',
		'section'     => 'single_post_options',
		'default'     => false,
	) );
	
	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Disable category', 'gutener' ),
		'type'        => 'checkbox',
		'settings'    => 'hide_single_post_category',
		'section'     => 'single_post_options',
		'default'     => false,
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Disable Tag Links', 'gutener' ),
		'type'        => 'checkbox',
		'settings'    => 'hide_single_post_tag_links',
		'section'     => 'single_post_options',
		'default'     => false,
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Disable Author', 'gutener' ),
		'type'        => 'checkbox',
		'settings'    => 'hide_single_post_author',
		'section'     => 'single_post_options',
		'default'     => false,
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Author Section Title', 'gutener' ),
		'type'        => 'text',
		'settings'    => 'single_post_author_title',
		'section'     => 'single_post_options',
		'default'     => esc_html__( 'About the Author', 'gutener' ),
		'active_callback' => array(
			array(
				'setting'  => 'hide_single_post_author',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Disable Related Posts', 'gutener' ),
		'type'        => 'checkbox',
		'settings'    => 'hide_related_posts',
		'section'     => 'single_post_options',
		'default'     => false,
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Related Posts Section Title', 'gutener' ),
		'type'        => 'text',
		'settings'    => 'related_posts_title',
		'section'     => 'single_post_options',
		'default'     => esc_html__( 'You may also like these', 'gutener' ),
		'active_callback' => array(
			array(
				'setting'  => 'hide_related_posts',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Related Posts Items', 'gutener' ),
		'description' => esc_html__( 'Total number of related posts to show.', 'gutener' ),
		'type'        => 'number',
		'settings'    => 'related_posts_count',
		'section'     => 'single_post_options',
		'default'     => 4,
		'choices' => array(
			'min' => '1',
			'max' => '12',
			'step' => '1',
		),
		'active_callback' => array(
			array(
				'setting'  => 'hide_related_posts',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	// Pages Options
	Kirki::add_section( 'pages_options', array(
	    'title'          => esc_html__( 'Pages', 'gutener' ),
	    'capability'     => 'edit_theme_options',
	    'priority'       => '150',
	) );

	Kirki::add_field( 'gutener',  array(
		'label'       => esc_html__( 'Page Title', 'gutener' ),
		'type'        => 'select',
		'settings'    => 'disable_page_title',
		'section'     => 'pages_options',
		'default'     => 'disable_front_page',
		'choices'     => array(
			'disable_all_pages'   => esc_html__( 'Disable from all', 'gutener' ),
			'enable_all_pages'    => esc_html__( 'Enable in all', 'gutener' ),
			'disable_front_page'  => esc_html__( 'Disable from frontpage only', 'gutener' ),
		),
	) );

	Kirki::add_field( 'gutener',  array(
		'label'       => esc_html__( 'Page Title Position', 'gutener' ),
		'type'        => 'select',
		'settings'    => 'page_title_position',
		'section'     => 'pages_options',
		'default'     => 'below_feature_image',
		'choices'     => array(
			'below_feature_image' => esc_html__( 'Below Feature Image', 'gutener' ),
			'above_feature_image' => esc_html__( 'Top of the Page', 'gutener' ),
		),
		'active_callback' => array(
			array(
				array(
					'setting'  => 'disable_transparent_header_page',
					'operator' => '==',
					'value'    => true,
				),
				array(
					'setting'  => 'header_layout',
					'operator' => '!=',
					'value'    => 'header_three',
				),
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Feature Image', 'gutener' ),
		'type'        => 'select',
		'settings'    => 'page_feature_image',
		'section'     => 'pages_options',
		'default'     => 'show_in_all_pages',
		'choices' => array(
			'show_in_all_pages'    => esc_html__( 'Show in all Pages', 'gutener' ),
			'disable_in_all_pages' => esc_html__( 'Disable in all Pages', 'gutener' ),
			'disable_in_frontpage' => esc_html__( 'Disable in Frontpage only', 'gutener' ),
			'show_in_frontpage'    => esc_html__( 'Show in Frontpage only', 'gutener' ),
		),
		'active_callback' => array(
			array(
				array(
					'setting'  => 'disable_transparent_header_page',
					'operator' => '==',
					'value'    => true,
				),
				array(
					'setting'  => 'header_layout',
					'operator' => '!=',
					'value'    => 'header_three',
				),
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Disable Transparent Header', 'gutener' ),
		'type'        => 'checkbox',
		'settings'    => 'disable_transparent_header_page',
		'section'     => 'pages_options',
		'default'     => true,
		'active_callback' => array(
			array(
				'setting'  => 'header_layout',
				'operator' => '==',
				'value'    => 'header_three',
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Transparent Header Banner Height (in px)', 'gutener' ),
		'type'        => 'slider',
		'settings'    => 'transparent_header_banner_page_height',
		'section'     => 'pages_options',
		'transport'   => 'postMessage',
		'default'     => 400,
		'choices'     => array(
			'min'  => 50,
			'max'  => 1500,
			'step' => 10,
		),
		'active_callback' => array(
			array(
				'setting'  => 'header_layout',
				'operator' => '==',
				'value'    => 'header_three',
			),
			array(
				'setting'  => 'disable_transparent_header_page',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Transparent Header Banner Image Size', 'gutener' ),
		'type'         => 'radio',
		'settings'     => 'transparent_header_banner_page_size',
		'section'      => 'pages_options',
		'default'      => 'cover',
		'choices'      => array(
			'cover'    => esc_html__( 'Cover', 'gutener' ),
			'pattern'  => esc_html__( 'Pattern / Repeat', 'gutener' ),
			'norepeat' => esc_html__( 'No Repeat', 'gutener' ),
		),
		'active_callback' => array(
			array(
				'setting'  => 'header_layout',
				'operator' => '==',
				'value'    => 'header_three',
			),
			array(
				'setting'  => 'disable_transparent_header_page',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Transparent Header Banner Overlay Opacity', 'gutener' ),
		'type'        => 'number',
		'settings'    => 'transparent_header_banner_page_opacity',
		'section'     => 'pages_options',
		'default'     => 4,
		'choices' => array(
			'min' => '0',
			'max' => '9',
			'step' => '1',
		),
		'active_callback' => array(
			array(
				'setting'  => 'header_layout',
				'operator' => '==',
				'value'    => 'header_three',
			),
			array(
				'setting'  => 'disable_transparent_header_page',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );
	
	// 404 Error Page
	Kirki::add_section( 'error404_options', array(
	    'title'          => esc_html__( '404 Page', 'gutener' ),
	    'capability'     => 'edit_theme_options',
	    'priority'       => '160',
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Image', 'gutener' ),
		'description' => esc_html__( 'Recommended image size 360x200 pixel.', 'gutener' ),
		'type'        => 'image',
		'settings'    => 'error404_image',
		'section'     => 'error404_options',
		'default'     => '',
	) );

	// Preloader Options
	Kirki::add_section( 'preloader_options', array(
	    'title'          => esc_html__( 'Preloader', 'gutener' ),
	    'capability'     => 'edit_theme_options',
	    'priority'       => '170',
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Disable Preloading', 'gutener' ),
		'type'        => 'checkbox',
		'settings'    => 'disable_preloader',
		'section'     => 'preloader_options',
		'default'     => false,
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Preloading Animations', 'gutener' ),
		'type'        => 'select',
		'settings'    => 'preloader_animation',
		'section'     => 'preloader_options',
		'default'     => 'animation_one',
		'choices'  => array(
			'animation_white'     => esc_html__( 'White Color to Fade', 'gutener' ),
			'animation_black'     => esc_html__( 'Black Color to Fade', 'gutener' ),
			'animation_site_logo' => esc_html__( 'Site Logo', 'gutener' ),
			'animation_one'       => esc_html__( 'Animation One', 'gutener' ),
			'animation_two'       => esc_html__( 'Animation Two', 'gutener' ),
			'animation_three'     => esc_html__( 'Animation Three', 'gutener' ),
			'animation_four'      => esc_html__( 'Animation Four', 'gutener' ),
			'animation_five'      => esc_html__( 'Animation Five', 'gutener' ),
		),
		'active_callback' => array(
			array(
				'setting'  => 'disable_preloader',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Image Width', 'gutener' ),
		'type'         => 'slider',
		'settings'     => 'preloader_custom_image_width',
		'section'      => 'preloader_options',
		'transport'    => 'postMessage',
		'default'      => 40,
		'choices'      => array(
			'min'  => 10,
			'max'  => 200,
			'step' => 1,
		),
		'active_callback' => array(
			array(
				'setting'  => 'disable_preloader',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );


	// Breadcrumbs
	Kirki::add_section( 'breadcrumbs_options', array(
	    'title'          => esc_html__( 'Breadcrumbs', 'gutener' ),
	    'capability'     => 'edit_theme_options',
	    'priority'       => '180',
	) );

	Kirki::add_field( 'gutener', array(
		'label'       => esc_html__( 'Breadcrumbs', 'gutener' ),
		'type'        => 'select',
		'settings'    => 'breadcrumbs_controls',
		'section'     => 'breadcrumbs_options',
		'default'     => 'disable_in_all_pages',
		'choices'  => array(
			'disable_in_all_pages'     => esc_html__( 'Disable in all Pages Only', 'gutener' ),
			'disable_in_all_page_post' => esc_html__( 'Disable in all Pages & Posts', 'gutener' ),
			'show_in_all_page_post'    => esc_html__( 'Show in all Pages & Posts', 'gutener' ),
		)
	) );

	// WooCommerce
	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Product Display Per Page', 'gutener' ),
		'type'         => 'number',
		'settings'     => 'woocommerce_product_per_page',
		'section'      => 'woocommerce_product_catalog',
		'default'      => 9,
		'choices' => array(
			'min' => '1',
			'max' => '60',
			'step'=> '1',
		),
	) );

	Kirki::add_section( 'woocommerce_single_product', array(
	    'title'      => esc_html__( 'Single Products', 'gutener' ),
	    'panel'      => 'woocommerce',	   
	    'capability' => 'edit_theme_options',
	) );

	Kirki::add_field( 'gutener', array(
		'label'        => esc_html__( 'Disable Single Product Title', 'gutener' ),
		'type'         => 'checkbox',
		'settings'     => 'disable_single_product_title',
		'section'      => 'woocommerce_single_product',
		'default'      => false,
	) );
}