<?php
/**
 * Theme bootstrap for ANEE Ollie Child.
 *
 * @package anee-ollie-child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function anee_ollie_child_enqueue_assets() {
	$stylesheet_path = get_stylesheet_directory() . '/assets/css/anee.css';
	$stylesheet_version = file_exists( $stylesheet_path ) ? (string) filemtime( $stylesheet_path ) : wp_get_theme()->get( 'Version' );

	wp_enqueue_style(
		'anee-ollie-child-custom',
		get_stylesheet_directory_uri() . '/assets/css/anee.css',
		array(),
		$stylesheet_version
	);
}
add_action( 'wp_enqueue_scripts', 'anee_ollie_child_enqueue_assets' );

function anee_ollie_child_editor_assets() {
	add_theme_support( 'editor-styles' );
	add_editor_style( 'assets/css/anee.css' );
}
add_action( 'after_setup_theme', 'anee_ollie_child_editor_assets' );

function anee_ollie_child_register_pattern_categories() {
	register_block_pattern_category(
		'anee-sections',
		array(
			'label' => __( 'ANEE Sections', 'anee-ollie-child' ),
		)
	);

	register_block_pattern_category(
		'anee-pages',
		array(
			'label' => __( 'ANEE Pages', 'anee-ollie-child' ),
		)
	);
}
add_action( 'init', 'anee_ollie_child_register_pattern_categories' );
