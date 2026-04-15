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
	wp_enqueue_style(
		'anee-ollie-child-custom',
		get_stylesheet_directory_uri() . '/assets/css/anee.css',
		array(),
		wp_get_theme()->get( 'Version' )
	);
}
add_action( 'wp_enqueue_scripts', 'anee_ollie_child_enqueue_assets' );

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
