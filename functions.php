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
		'openings_label'       => 'Open positions',
		'openings_title'       => 'Join the Boies Group.',
		'openings_body'        => 'Work at the intersection of aerosol science, nanotechnology, and energy systems, with fundamental research translated toward environmental and industrial impact.',
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
 * Opening pages stay normal WordPress Pages so their full copy remains editable.
 */
function boies_opening_page_slugs() {
	return array(
		'postdoctoral-scholar-methane-pyrolysis-hydrogen-and-carbon-nanotube-synthesis',
	);
}

function boies_is_opening_page( $post_id = 0 ) {
	$post_id = $post_id ? (int) $post_id : (int) get_queried_object_id();
	if ( ! $post_id || 'page' !== get_post_type( $post_id ) ) {
		return false;
	}

	$flag = get_post_meta( $post_id, '_boies_is_opening', true );
	if ( '1' === $flag ) {
		return true;
	}
	if ( '0' === $flag ) {
		return false;
	}

	return in_array( get_post_field( 'post_name', $post_id ), boies_opening_page_slugs(), true );
}

function boies_get_opening_pages() {
	$openings = get_posts(
		array(
			'post_type'      => 'page',
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'meta_key'       => '_boies_is_opening',
			'meta_value'     => '1',
			'orderby'        => array(
				'menu_order' => 'ASC',
				'title'      => 'ASC',
			),
		)
	);

	$indexed = array();
	foreach ( $openings as $opening ) {
		$indexed[ $opening->ID ] = $opening;
	}

	foreach ( boies_opening_page_slugs() as $slug ) {
		$page = get_page_by_path( $slug );
		if ( $page && 'publish' === $page->post_status && boies_is_opening_page( $page->ID ) ) {
			$indexed[ $page->ID ] = $page;
		}
	}

	$openings = array_values( $indexed );
	usort(
		$openings,
		function ( $first, $second ) {
			$order = (int) $first->menu_order <=> (int) $second->menu_order;
			return 0 !== $order ? $order : strcasecmp( $first->post_title, $second->post_title );
		}
	);

	return $openings;
}

function boies_opening_meta( $post_id, $key, $fallback = '' ) {
	$value = trim( (string) get_post_meta( $post_id, '_boies_opening_' . $key, true ) );
	if ( '' !== $value ) {
		return $value;
	}

	$known_slug = 'postdoctoral-scholar-methane-pyrolysis-hydrogen-and-carbon-nanotube-synthesis';
	if ( $known_slug === get_post_field( 'post_name', $post_id ) ) {
		$known = array(
			'type'     => 'Postdoctoral scholar',
			'timing'   => 'Anticipated start: Fall 2026',
			'deadline' => 'Review begins September 1, 2026',
			'email'    => 'PostDocApply1@ANEEstanford.com',
		);
		if ( isset( $known[ $key ] ) ) {
			return $known[ $key ];
		}
	}

	return $fallback;
}

function boies_opening_excerpt( $opening ) {
	if ( has_excerpt( $opening->ID ) ) {
		return get_the_excerpt( $opening->ID );
	}

	return wp_trim_words( wp_strip_all_tags( strip_shortcodes( $opening->post_content ) ), 34, '...' );
}

function boies_is_openings_request() {
	if ( get_query_var( 'boies_openings' ) ) {
		return true;
	}

	$request_path = isset( $_SERVER['REQUEST_URI'] )
		? (string) wp_parse_url( wp_unslash( $_SERVER['REQUEST_URI'] ), PHP_URL_PATH )
		: '';
	$home_path = (string) wp_parse_url( home_url( '/' ), PHP_URL_PATH );
	$request_path = trim( $request_path, '/' );
	$home_path    = trim( $home_path, '/' );

	if ( $home_path && 0 === strpos( $request_path, $home_path . '/' ) ) {
		$request_path = substr( $request_path, strlen( $home_path ) + 1 );
	}

	return 'openings' === $request_path;
}

function boies_register_openings_route() {
	add_rewrite_rule( '^openings/?$', 'index.php?boies_openings=1', 'top' );

	if ( '1' !== get_option( 'boies_openings_rewrite_version' ) ) {
		flush_rewrite_rules( false );
		update_option( 'boies_openings_rewrite_version', '1' );
	}
}
add_action( 'init', 'boies_register_openings_route', 20 );

function boies_openings_query_vars( $vars ) {
	$vars[] = 'boies_openings';
	return $vars;
}
add_filter( 'query_vars', 'boies_openings_query_vars' );

function boies_prepare_openings_request() {
	if ( ! boies_is_openings_request() ) {
		return;
	}

	global $wp_query;
	$wp_query->is_404 = false;
	status_header( 200 );
}
add_action( 'template_redirect', 'boies_prepare_openings_request', 1 );

function boies_openings_document_title( $parts ) {
	if ( boies_is_openings_request() ) {
		$parts['title'] = __( 'Openings', 'boies-group' );
	}
	return $parts;
}
add_filter( 'document_title_parts', 'boies_openings_document_title' );

/**
 * Keep the code-designed Research and Publications views active even if an
 * older WordPress page template remains selected in the database.
 */
function boies_page_template_override( $template ) {
	$theme_dir = get_stylesheet_directory();

	if ( boies_is_openings_request() ) {
		return $theme_dir . '/page-openings.php';
	}

	if ( boies_is_opening_page() ) {
		return $theme_dir . '/page-opening.php';
	}

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
		array( 'Openings', home_url( '/openings/' ) ),
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
		array( 'Openings', home_url( '/openings/' ) ),
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

/**
 * Replace legacy assigned-menu links without requiring a database migration.
 */
function boies_replace_capabilities_menu_item( $items, $args ) {
	if ( empty( $args->theme_location ) || ! in_array( $args->theme_location, array( 'primary', 'footer' ), true ) ) {
		return $items;
	}

	foreach ( $items as $item ) {
		$title = strtolower( wp_strip_all_tags( $item->title ) );
		$url   = strtolower( (string) $item->url );
		if ( 'capabilities' === $title || false !== strpos( $url, '#capabilities' ) || false !== strpos( $url, '/capabilities/' ) ) {
			$item->title = __( 'Openings', 'boies-group' );
			$item->url   = home_url( '/openings/' );
		}
	}

	return $items;
}
add_filter( 'wp_nav_menu_objects', 'boies_replace_capabilities_menu_item', 10, 2 );

function boies_opening_meta_box() {
	add_meta_box(
		'boies-opening-details',
		__( 'Opening details', 'boies-group' ),
		'boies_render_opening_meta_box',
		'page',
		'side',
		'high'
	);
}
add_action( 'add_meta_boxes_page', 'boies_opening_meta_box' );

function boies_render_opening_meta_box( $post ) {
	wp_nonce_field( 'boies_save_opening_details', 'boies_opening_nonce' );
	$fields = array(
		'type'     => __( 'Position type', 'boies-group' ),
		'location' => __( 'Location', 'boies-group' ),
		'timing'   => __( 'Timing', 'boies-group' ),
		'deadline' => __( 'Deadline', 'boies-group' ),
		'email'    => __( 'Application email', 'boies-group' ),
	);
	?>
	<p>
		<label>
			<input type="checkbox" name="boies_is_opening" value="1" <?php checked( boies_is_opening_page( $post->ID ) ); ?>>
			<?php esc_html_e( 'List this page on the Openings hub', 'boies-group' ); ?>
		</label>
	</p>
	<?php foreach ( $fields as $key => $label ) : ?>
		<p>
			<label for="boies-opening-<?php echo esc_attr( $key ); ?>"><strong><?php echo esc_html( $label ); ?></strong></label>
			<input class="widefat" id="boies-opening-<?php echo esc_attr( $key ); ?>" name="boies_opening_<?php echo esc_attr( $key ); ?>" type="<?php echo 'email' === $key ? 'email' : 'text'; ?>" value="<?php echo esc_attr( boies_opening_meta( $post->ID, $key ) ); ?>">
		</p>
	<?php endforeach; ?>
	<p class="description"><?php esc_html_e( 'The page title, excerpt, featured image, and main editor content are used automatically.', 'boies-group' ); ?></p>
	<?php
}

function boies_save_opening_details( $post_id ) {
	if ( ! isset( $_POST['boies_opening_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['boies_opening_nonce'] ) ), 'boies_save_opening_details' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( wp_is_post_revision( $post_id ) || ! current_user_can( 'edit_page', $post_id ) ) {
		return;
	}

	update_post_meta( $post_id, '_boies_is_opening', isset( $_POST['boies_is_opening'] ) ? '1' : '0' );

	foreach ( array( 'type', 'location', 'timing', 'deadline', 'email' ) as $key ) {
		$field = 'boies_opening_' . $key;
		$value = isset( $_POST[ $field ] ) ? wp_unslash( $_POST[ $field ] ) : '';
		$value = 'email' === $key ? sanitize_email( $value ) : sanitize_text_field( $value );
		if ( '' === $value ) {
			delete_post_meta( $post_id, '_boies_opening_' . $key );
		} else {
			update_post_meta( $post_id, '_boies_opening_' . $key, $value );
		}
	}
}
add_action( 'save_post_page', 'boies_save_opening_details' );

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
		'openings_label'       => array( 'Openings label', 'text' ),
		'openings_title'       => array( 'Openings title', 'text' ),
		'openings_body'        => array( 'Openings intro', 'textarea' ),
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
