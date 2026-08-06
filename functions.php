<?php
/**
 * Theme bootstrap for The Boies Group.
 *
 * @package boies-group
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once get_stylesheet_directory() . '/inc/research-cms.php';

function boies_theme_defaults() {
	return array(
		'hero_video_url'       => 'https://videos.files.wordpress.com/vTtAYNzS/boies_hero.mp4',
		'hero_poster_url'      => 'https://videos.files.wordpress.com/vTtAYNzS/boies_hero_mp4_hd_1080p.original.jpg',
		'hero_kicker'          => 'Stanford Mechanical Engineering',
		'hero_title'           => 'The Boies Group',
		'hero_subtitle'        => 'Aerosol and Nanotechnology for Energy and the Environment (ANEE)',
		'hero_primary_label'   => 'Explore research',
		'hero_primary_url'     => home_url( '/research/' ),
		'hero_secondary_label' => 'Meet the group',
		'hero_secondary_url'   => home_url( '/people/' ),
		'goals_label'          => 'Our Goals',
		'goals_title'          => 'Aerosols, nanotechnology, energy, and the environment.',
		'goals_body'           => 'The Aerosol and Nanotechnology for Energy and the Environment (ANEE) group focuses on developing energy and environmental technologies through aerosol and nano-scale approaches that can either synthesize or measure aerosols, nanoparticles, or pollution. We have dedicated interests in sustainable nanocarbons, energy storage, and self-assembled materials, as well as metrology and modeling approaches to understand new phenomena related to the structure, evolution, dynamics, and impacts of gas-phase nanoparticles. The applications of our research extend from engineered nanoparticles, catalysts and carbon nanotubes for energy applications to transportation emissions, batteries and air quality.',
		'goals_image_url'      => '',
		'capabilities_label'   => 'Capabilities',
		'capabilities_title'   => 'From aerosol synthesis to deployment-scale measurement.',
		'capabilities_body'    => 'A practical view of the experimental platforms, diagnostics, and materials workflows that support research across the lab.',
		'capabilities_image_url' => '',
		'capability_1_number'  => '01',
		'capability_1_title'   => 'Aerosol metrology',
		'capability_1_body'    => 'Instrumentation and modeling for particles, emissions, air quality, and evolving gas-phase systems.',
		'capability_2_number'  => '02',
		'capability_2_title'   => 'Nanocarbon synthesis',
		'capability_2_body'    => 'Aerosol and flow-based methods for carbon nanotubes, catalysts, and self-assembled materials.',
		'capability_3_number'  => '03',
		'capability_3_title'   => 'Energy systems',
		'capability_3_body'    => 'Materials and diagnostics for batteries, storage, combustion, transportation, and environmental technologies.',
		'research_label'       => 'Research network',
		'research_title'       => 'Follow the connections behind the work.',
		'research_body'        => 'Explore how research themes, active projects, experimental methods, and group members connect across the lab.',
		'contact_email'        => 'aboies@stanford.edu',
		'show_editor_content'  => false,
	);
}

function boies_theme_mod( $key ) {
	$defaults = boies_theme_defaults();
	return get_theme_mod( 'boies_' . $key, $defaults[ $key ] ?? '' );
}

function boies_setup() {
	load_theme_textdomain( 'boies-group', get_stylesheet_directory() . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );
	add_theme_support(
		'html5',
		array(
			'caption',
			'comment-form',
			'comment-list',
			'gallery',
			'navigation-widgets',
			'search-form',
			'style',
			'script',
		)
	);
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 92,
			'width'       => 280,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);
	add_theme_support( 'editor-styles' );
	add_editor_style( 'assets/css/anee.css' );

	register_nav_menus(
		array(
			'primary' => __( 'Primary Menu', 'boies-group' ),
			'footer'  => __( 'Footer Menu', 'boies-group' ),
		)
	);
}
add_action( 'after_setup_theme', 'boies_setup' );

function boies_enqueue_assets() {
	$theme_version = wp_get_theme()->get( 'Version' );
	$root_css_path = get_stylesheet_directory() . '/style.css';
	$css_path      = get_stylesheet_directory() . '/assets/css/anee.css';
	$site_js_path     = get_stylesheet_directory() . '/assets/js/site.js';
	$people_js_path   = get_stylesheet_directory() . '/assets/js/people-cards.js';
	$research_js_path = get_stylesheet_directory() . '/assets/js/research-network.js';

	wp_enqueue_style(
		'boies-fonts',
		'https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=Space+Grotesk:wght@400;500;600;700&display=swap',
		array(),
		null
	);

	wp_enqueue_style(
		'boies-root',
		get_stylesheet_uri(),
		array( 'boies-fonts' ),
		file_exists( $root_css_path ) ? (string) filemtime( $root_css_path ) : $theme_version
	);

	wp_enqueue_style(
		'boies-theme-assets',
		get_stylesheet_directory_uri() . '/assets/css/anee.css',
		array( 'boies-root' ),
		file_exists( $css_path ) ? (string) filemtime( $css_path ) : $theme_version
	);

	wp_enqueue_script(
		'boies-site',
		get_stylesheet_directory_uri() . '/assets/js/site.js',
		array(),
		file_exists( $site_js_path ) ? (string) filemtime( $site_js_path ) : $theme_version,
		true
	);

	if ( is_page( 'people' ) ) {
		wp_enqueue_script(
			'boies-people-cards',
			get_stylesheet_directory_uri() . '/assets/js/people-cards.js',
			array(),
			file_exists( $people_js_path ) ? (string) filemtime( $people_js_path ) : $theme_version,
			true
		);
	}

	if ( is_page( 'research' ) ) {
		wp_enqueue_script(
			'boies-research-network',
			get_stylesheet_directory_uri() . '/assets/js/research-network.js',
			array(),
			file_exists( $research_js_path ) ? (string) filemtime( $research_js_path ) : $theme_version,
			true
		);

		wp_localize_script(
			'boies-research-network',
			'BoiesResearch',
			array(
				'dataUrl' => rest_url( 'boies/v1/research-network' ),
			)
		);
	}
}
add_action( 'wp_enqueue_scripts', 'boies_enqueue_assets' );

/**
 * Detect the publications route even when WordPress assigns that page as the
 * Posts page. In that configuration WordPress reports the request as the blog
 * home rather than a normal page, so is_page() alone cannot select our view.
 */
function boies_is_publications_request() {
	if ( is_page( array( 'boies-publications', 'publications' ) ) ) {
		return true;
	}

	$request_path = isset( $_SERVER['REQUEST_URI'] )
		? (string) wp_parse_url( wp_unslash( $_SERVER['REQUEST_URI'] ), PHP_URL_PATH )
		: '';
	$home_path    = (string) wp_parse_url( home_url( '/' ), PHP_URL_PATH );

	$request_path = trim( $request_path, '/' );
	$home_path    = trim( $home_path, '/' );

	if ( $home_path && 0 === strpos( $request_path, $home_path . '/' ) ) {
		$request_path = substr( $request_path, strlen( $home_path ) + 1 );
	}

	return (bool) preg_match( '#^(boies-publications|publications)(?:/page/[0-9]+)?$#', $request_path );
}

/**
 * Keep the code-designed Research and Publications views active even if an
 * older WordPress page template remains selected in the database.
 */
function boies_page_template_override( $template ) {
	$theme_dir = get_stylesheet_directory();

	if ( is_page( 'research' ) ) {
		return $theme_dir . '/page-research.php';
	}

	if ( boies_is_publications_request() ) {
		return $theme_dir . '/page-boies-publications.php';
	}

	return $template;
}
add_filter( 'template_include', 'boies_page_template_override', 99 );

function boies_primary_menu() {
	if ( has_nav_menu( 'primary' ) ) {
		wp_nav_menu(
			array(
				'theme_location' => 'primary',
				'container'      => false,
				'menu_class'     => 'boies-nav__list',
				'fallback_cb'    => false,
				'depth'          => 1,
			)
		);
		return;
	}

	$items = array(
		array( 'Home', home_url( '/' ) ),
		array( 'People', home_url( '/people/' ) ),
		array( 'Research', home_url( '/research/' ) ),
		array( 'Capabilities', home_url( '/#capabilities' ) ),
		array( 'Publications', home_url( '/boies-publications/' ) ),
		array( 'Patents', home_url( '/patents/' ) ),
	);

	echo '<ul class="boies-nav__list">';
	foreach ( $items as $item ) {
		printf(
			'<li><a href="%s">%s</a></li>',
			esc_url( $item[1] ),
			esc_html( $item[0] )
		);
	}
	echo '</ul>';
}

function boies_footer_menu() {
	if ( has_nav_menu( 'footer' ) ) {
		wp_nav_menu(
			array(
				'theme_location' => 'footer',
				'container'      => false,
				'menu_class'     => 'boies-footer__links',
				'fallback_cb'    => false,
				'depth'          => 1,
			)
		);
		return;
	}

	$items = array(
		array( 'People', home_url( '/people/' ) ),
		array( 'Research', home_url( '/research/' ) ),
		array( 'Capabilities', home_url( '/#capabilities' ) ),
		array( 'Publications', home_url( '/boies-publications/' ) ),
		array( 'Patents', home_url( '/patents/' ) ),
	);

	echo '<ul class="boies-footer__links">';
	foreach ( $items as $item ) {
		printf(
			'<li><a href="%s">%s</a></li>',
			esc_url( $item[1] ),
			esc_html( $item[0] )
		);
	}
	echo '</ul>';
}

function boies_brand_markup() {
	$home_url = esc_url( home_url( '/' ) );

	if ( has_custom_logo() ) {
		printf( '<div class="boies-brand boies-brand--logo">%s</div>', get_custom_logo() );
		return;
	}

	printf(
		'<a class="boies-brand boies-brand--text" href="%s"><span>The Boies Group</span><small>Aerosol and Nanotechnology for Energy and the Environment</small></a>',
		$home_url
	);
}

function boies_register_pattern_categories() {
	register_block_pattern_category(
		'anee-sections',
		array(
			'label' => __( 'Boies Group Sections', 'boies-group' ),
		)
	);

	register_block_pattern_category(
		'anee-pages',
		array(
			'label' => __( 'Boies Group Pages', 'boies-group' ),
		)
	);
}
add_action( 'init', 'boies_register_pattern_categories' );

function boies_customize_register( $wp_customize ) {
	$wp_customize->add_section(
		'boies_homepage',
		array(
			'title'       => __( 'Boies Group Homepage', 'boies-group' ),
			'description' => __( 'Edit the custom homepage hero, goals copy, and contact details without touching code.', 'boies-group' ),
			'priority'    => 35,
		)
	);

	$text_settings = array(
		'hero_video_url'       => array( 'Hero video URL', 'url' ),
		'hero_poster_url'      => array( 'Hero poster image URL', 'url' ),
		'hero_kicker'          => array( 'Hero kicker', 'text' ),
		'hero_title'           => array( 'Hero title', 'text' ),
		'hero_subtitle'        => array( 'Hero subtitle', 'textarea' ),
		'hero_primary_label'   => array( 'Primary button label', 'text' ),
		'hero_primary_url'     => array( 'Primary button URL', 'url' ),
		'hero_secondary_label' => array( 'Secondary button label', 'text' ),
		'hero_secondary_url'   => array( 'Secondary button URL', 'url' ),
		'goals_label'          => array( 'Goals label', 'text' ),
		'goals_title'          => array( 'Goals title', 'text' ),
		'goals_body'           => array( 'Goals body', 'textarea' ),
		'goals_image_url'      => array( 'Goals image URL', 'url' ),
		'capabilities_label'   => array( 'Capabilities label', 'text' ),
		'capabilities_title'   => array( 'Capabilities title', 'text' ),
		'capabilities_body'    => array( 'Capabilities intro', 'textarea' ),
		'capabilities_image_url' => array( 'Capabilities image URL', 'url' ),
		'capability_1_number'  => array( 'Capability 1 number', 'text' ),
		'capability_1_title'   => array( 'Capability 1 title', 'text' ),
		'capability_1_body'    => array( 'Capability 1 body', 'textarea' ),
		'capability_2_number'  => array( 'Capability 2 number', 'text' ),
		'capability_2_title'   => array( 'Capability 2 title', 'text' ),
		'capability_2_body'    => array( 'Capability 2 body', 'textarea' ),
		'capability_3_number'  => array( 'Capability 3 number', 'text' ),
		'capability_3_title'   => array( 'Capability 3 title', 'text' ),
		'capability_3_body'    => array( 'Capability 3 body', 'textarea' ),
		'research_label'       => array( 'Research network label', 'text' ),
		'research_title'       => array( 'Research network title', 'text' ),
		'research_body'        => array( 'Research network intro', 'textarea' ),
		'contact_email'        => array( 'Contact email', 'email' ),
	);

	$defaults = boies_theme_defaults();

	foreach ( $text_settings as $key => $setting ) {
		$sanitize_callback = 'sanitize_text_field';
		if ( 'textarea' === $setting[1] ) {
			$sanitize_callback = 'sanitize_textarea_field';
		} elseif ( 'url' === $setting[1] ) {
			$sanitize_callback = 'esc_url_raw';
		} elseif ( 'email' === $setting[1] ) {
			$sanitize_callback = 'sanitize_email';
		}

		$wp_customize->add_setting(
			'boies_' . $key,
			array(
				'default'           => $defaults[ $key ] ?? '',
				'sanitize_callback' => $sanitize_callback,
				'transport'         => 'refresh',
			)
		);

		$wp_customize->add_control(
			'boies_' . $key,
			array(
				'label'   => $setting[0],
				'section' => 'boies_homepage',
				'type'    => $setting[1],
			)
		);
	}

	$wp_customize->add_setting(
		'boies_show_editor_content',
		array(
			'default'           => $defaults['show_editor_content'],
			'sanitize_callback' => 'rest_sanitize_boolean',
			'transport'         => 'refresh',
		)
	);

	$wp_customize->add_control(
		'boies_show_editor_content',
		array(
			'label'       => __( 'Show WordPress page content below homepage sections', 'boies-group' ),
			'description' => __( 'Leave this off for the cleaner code-designed homepage. Turn it on only if you want blocks from the Home page editor to appear below the custom sections.', 'boies-group' ),
			'section'     => 'boies_homepage',
			'type'        => 'checkbox',
		)
	);
}
add_action( 'customize_register', 'boies_customize_register' );
