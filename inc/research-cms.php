<?php
/**
 * WordPress-managed research network.
 *
 * @package boies-group
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

const BOIES_RESEARCH_SEED_VERSION = 1;

/**
 * Register the private editorial records used by the public research map.
 */
function boies_register_research_content_types() {
	$types = array(
		'boies_theme'   => array(
			'singular' => __( 'Research Theme', 'boies-group' ),
			'plural'   => __( 'Research Themes', 'boies-group' ),
			'supports' => array( 'title', 'editor', 'excerpt', 'thumbnail', 'page-attributes' ),
		),
		'boies_project' => array(
			'singular' => __( 'Research Project', 'boies-group' ),
			'plural'   => __( 'Research Projects', 'boies-group' ),
			'supports' => array( 'title', 'editor', 'excerpt', 'page-attributes' ),
		),
		'boies_person'  => array(
			'singular' => __( 'Researcher', 'boies-group' ),
			'plural'   => __( 'Researchers', 'boies-group' ),
			'supports' => array( 'title', 'editor', 'excerpt', 'page-attributes' ),
		),
	);

	foreach ( $types as $post_type => $config ) {
		register_post_type(
			$post_type,
			array(
				'labels' => array(
					'name'               => $config['plural'],
					'singular_name'      => $config['singular'],
					'add_new'            => __( 'Add New', 'boies-group' ),
					'add_new_item'       => sprintf( __( 'Add %s', 'boies-group' ), $config['singular'] ),
					'edit_item'          => sprintf( __( 'Edit %s', 'boies-group' ), $config['singular'] ),
					'new_item'           => sprintf( __( 'New %s', 'boies-group' ), $config['singular'] ),
					'view_item'          => sprintf( __( 'View %s', 'boies-group' ), $config['singular'] ),
					'search_items'       => sprintf( __( 'Search %s', 'boies-group' ), $config['plural'] ),
					'not_found'          => sprintf( __( 'No %s found.', 'boies-group' ), strtolower( $config['plural'] ) ),
					'not_found_in_trash' => sprintf( __( 'No %s found in Trash.', 'boies-group' ), strtolower( $config['plural'] ) ),
				),
				'public'              => false,
				'publicly_queryable'  => false,
				'exclude_from_search' => true,
				'show_ui'             => true,
				'show_in_menu'        => 'boies-research-network',
				'show_in_nav_menus'   => false,
				'show_in_rest'        => true,
				'supports'            => $config['supports'],
				'capability_type'     => 'page',
				'map_meta_cap'        => true,
				'has_archive'         => false,
				'rewrite'             => false,
				'query_var'           => false,
			)
		);
	}
}
add_action( 'init', 'boies_register_research_content_types', 5 );

/**
 * Add a single editorial home for the network records.
 */
function boies_research_admin_menu() {
	add_menu_page(
		__( 'Research Network', 'boies-group' ),
		__( 'Research Network', 'boies-group' ),
		'edit_pages',
		'boies-research-network',
		'boies_research_admin_page',
		'dashicons-share-alt2',
		21
	);
}
add_action( 'admin_menu', 'boies_research_admin_menu', 9 );

/**
 * Render the research-network dashboard.
 */
function boies_research_admin_page() {
	if ( ! current_user_can( 'edit_pages' ) ) {
		return;
	}

	$sections = array(
		'boies_theme'   => array( __( 'Research Themes', 'boies-group' ), __( 'Edit the six high-level research areas, their descriptions, display order, and background images.', 'boies-group' ) ),
		'boies_project' => array( __( 'Research Projects', 'boies-group' ), __( 'Add active projects, write the descriptions shown in the pop-downs, and connect each project to one or more themes.', 'boies-group' ) ),
		'boies_person'  => array( __( 'Researchers', 'boies-group' ), __( 'Connect people to themes and projects. Add a People-page URL only when that person has a published profile.', 'boies-group' ) ),
	);
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Research Network', 'boies-group' ); ?></h1>
		<p><?php esc_html_e( 'The public Research page is generated directly from these WordPress records. No JSON file or Obsidian export is required.', 'boies-group' ); ?></p>
		<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(260px,1fr));gap:16px;max-width:1050px;margin-top:24px;">
			<?php foreach ( $sections as $post_type => $section ) : ?>
				<?php $counts = wp_count_posts( $post_type ); ?>
				<div class="card" style="max-width:none;margin:0;">
					<h2><?php echo esc_html( $section[0] ); ?></h2>
					<p><?php echo esc_html( $section[1] ); ?></p>
					<p><strong><?php echo esc_html( (string) ( $counts->publish ?? 0 ) ); ?></strong> <?php esc_html_e( 'published', 'boies-group' ); ?></p>
					<p>
						<a class="button button-primary" href="<?php echo esc_url( admin_url( 'edit.php?post_type=' . $post_type ) ); ?>"><?php esc_html_e( 'Manage', 'boies-group' ); ?></a>
						<a class="button" href="<?php echo esc_url( admin_url( 'post-new.php?post_type=' . $post_type ) ); ?>"><?php esc_html_e( 'Add New', 'boies-group' ); ?></a>
					</p>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
	<?php
}

/**
 * Retrieve published relationship choices in editorial order.
 */
function boies_research_choices( $post_type ) {
	return get_posts(
		array(
			'post_type'      => $post_type,
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'orderby'        => array( 'menu_order' => 'ASC', 'title' => 'ASC' ),
			'order'          => 'ASC',
		)
	);
}

/**
 * Add relationship and display controls to the editor.
 */
function boies_research_meta_boxes() {
	add_meta_box(
		'boies-theme-display',
		__( 'Theme Display', 'boies-group' ),
		'boies_theme_display_meta_box',
		'boies_theme',
		'side',
		'default'
	);

	add_meta_box(
		'boies-project-themes',
		__( 'Connected Research Themes', 'boies-group' ),
		'boies_project_themes_meta_box',
		'boies_project',
		'side',
		'default'
	);

	add_meta_box(
		'boies-researcher-connections',
		__( 'Research Connections', 'boies-group' ),
		'boies_researcher_connections_meta_box',
		'boies_person',
		'normal',
		'default'
	);
}
add_action( 'add_meta_boxes', 'boies_research_meta_boxes' );

/**
 * Shared nonce field for research metadata.
 */
function boies_research_nonce_field() {
	wp_nonce_field( 'boies_research_meta', 'boies_research_meta_nonce' );
}

/**
 * Theme image-position control.
 */
function boies_theme_display_meta_box( $post ) {
	boies_research_nonce_field();
	$position = get_post_meta( $post->ID, '_boies_image_position', true );
	$position = $position ? $position : 'center';
	$options  = array(
		'center'       => __( 'Center', 'boies-group' ),
		'center top'   => __( 'Center top', 'boies-group' ),
		'center bottom' => __( 'Center bottom', 'boies-group' ),
		'left center'  => __( 'Left center', 'boies-group' ),
		'right center' => __( 'Right center', 'boies-group' ),
	);
	?>
	<p><?php esc_html_e( 'Use the Featured image panel to choose this theme\'s public background image.', 'boies-group' ); ?></p>
	<p>
		<label for="boies-image-position"><strong><?php esc_html_e( 'Image focal position', 'boies-group' ); ?></strong></label><br>
		<select id="boies-image-position" name="boies_image_position" style="width:100%;margin-top:6px;">
			<?php foreach ( $options as $value => $label ) : ?>
				<option value="<?php echo esc_attr( $value ); ?>" <?php selected( $position, $value ); ?>><?php echo esc_html( $label ); ?></option>
			<?php endforeach; ?>
		</select>
	</p>
	<p><?php esc_html_e( 'Use the Order field in Page Attributes to control where the theme appears.', 'boies-group' ); ?></p>
	<?php
}

/**
 * Render checkbox relationships.
 */
function boies_research_checkbox_list( $name, $choices, $selected_ids ) {
	if ( empty( $choices ) ) {
		echo '<p>' . esc_html__( 'Publish the related records first.', 'boies-group' ) . '</p>';
		return;
	}

	echo '<div style="display:grid;gap:8px;">';
	foreach ( $choices as $choice ) {
		printf(
			'<label><input type="checkbox" name="%1$s[]" value="%2$d" %3$s> %4$s</label>',
			esc_attr( $name ),
			(int) $choice->ID,
			checked( in_array( (int) $choice->ID, $selected_ids, true ), true, false ),
			esc_html( get_the_title( $choice ) )
		);
	}
	echo '</div>';
}

/**
 * Project-to-theme relationships.
 */
function boies_project_themes_meta_box( $post ) {
	boies_research_nonce_field();
	$selected = array_map( 'intval', (array) get_post_meta( $post->ID, '_boies_theme_ids', true ) );
	boies_research_checkbox_list( 'boies_theme_ids', boies_research_choices( 'boies_theme' ), $selected );
}

/**
 * Researcher profile and network relationships.
 */
function boies_researcher_connections_meta_box( $post ) {
	boies_research_nonce_field();
	$profile_url      = get_post_meta( $post->ID, '_boies_profile_url', true );
	$selected_themes  = array_map( 'intval', (array) get_post_meta( $post->ID, '_boies_theme_ids', true ) );
	$selected_projects = array_map( 'intval', (array) get_post_meta( $post->ID, '_boies_project_ids', true ) );
	?>
	<p>
		<label for="boies-profile-url"><strong><?php esc_html_e( 'Published People-page profile URL (optional)', 'boies-group' ); ?></strong></label><br>
		<input id="boies-profile-url" type="url" name="boies_profile_url" value="<?php echo esc_attr( $profile_url ); ?>" class="widefat" placeholder="<?php echo esc_attr( home_url( '/people/' ) ); ?>">
		<span class="description"><?php esc_html_e( 'Leave blank when this person does not have a public People-page entry. Their name will remain visible but will not be clickable.', 'boies-group' ); ?></span>
	</p>
	<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:24px;margin-top:20px;">
		<div>
			<h3><?php esc_html_e( 'Research Themes', 'boies-group' ); ?></h3>
			<?php boies_research_checkbox_list( 'boies_theme_ids', boies_research_choices( 'boies_theme' ), $selected_themes ); ?>
		</div>
		<div>
			<h3><?php esc_html_e( 'Research Projects', 'boies-group' ); ?></h3>
			<?php boies_research_checkbox_list( 'boies_project_ids', boies_research_choices( 'boies_project' ), $selected_projects ); ?>
		</div>
	</div>
	<?php
}

/**
 * Sanitize relationship IDs against the expected record type.
 */
function boies_research_valid_ids( $raw_ids, $post_type ) {
	$valid = array();
	foreach ( array_map( 'absint', (array) $raw_ids ) as $post_id ) {
		if ( $post_id && $post_type === get_post_type( $post_id ) && 'publish' === get_post_status( $post_id ) ) {
			$valid[] = $post_id;
		}
	}
	return array_values( array_unique( $valid ) );
}

/**
 * Save research-network metadata.
 */
function boies_save_research_meta( $post_id, $post ) {
	if (
		! isset( $_POST['boies_research_meta_nonce'] ) ||
		! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['boies_research_meta_nonce'] ) ), 'boies_research_meta' ) ||
		( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) ||
		wp_is_post_revision( $post_id ) ||
		! current_user_can( 'edit_post', $post_id )
	) {
		return;
	}

	if ( 'boies_theme' === $post->post_type ) {
		$allowed  = array( 'center', 'center top', 'center bottom', 'left center', 'right center' );
		$position = isset( $_POST['boies_image_position'] ) ? sanitize_text_field( wp_unslash( $_POST['boies_image_position'] ) ) : 'center';
		update_post_meta( $post_id, '_boies_image_position', in_array( $position, $allowed, true ) ? $position : 'center' );
	}

	if ( 'boies_project' === $post->post_type || 'boies_person' === $post->post_type ) {
		$theme_ids = isset( $_POST['boies_theme_ids'] ) ? wp_unslash( $_POST['boies_theme_ids'] ) : array();
		update_post_meta( $post_id, '_boies_theme_ids', boies_research_valid_ids( $theme_ids, 'boies_theme' ) );
	}

	if ( 'boies_person' === $post->post_type ) {
		$project_ids = isset( $_POST['boies_project_ids'] ) ? wp_unslash( $_POST['boies_project_ids'] ) : array();
		$profile_url = isset( $_POST['boies_profile_url'] ) ? esc_url_raw( wp_unslash( $_POST['boies_profile_url'] ) ) : '';
		update_post_meta( $post_id, '_boies_project_ids', boies_research_valid_ids( $project_ids, 'boies_project' ) );
		update_post_meta( $post_id, '_boies_profile_url', $profile_url );
	}
}
add_action( 'save_post', 'boies_save_research_meta', 10, 2 );

/**
 * Make the Research Network list screens useful at a glance.
 */
function boies_theme_admin_columns( $columns ) {
	return array(
		'cb'          => $columns['cb'],
		'boies_image' => __( 'Image', 'boies-group' ),
		'title'       => __( 'Research Theme', 'boies-group' ),
		'boies_order' => __( 'Order', 'boies-group' ),
		'date'        => $columns['date'],
	);
}
add_filter( 'manage_boies_theme_posts_columns', 'boies_theme_admin_columns' );

function boies_project_admin_columns( $columns ) {
	return array(
		'cb'           => $columns['cb'],
		'title'        => __( 'Research Project', 'boies-group' ),
		'boies_themes' => __( 'Themes', 'boies-group' ),
		'date'         => $columns['date'],
	);
}
add_filter( 'manage_boies_project_posts_columns', 'boies_project_admin_columns' );

function boies_person_admin_columns( $columns ) {
	return array(
		'cb'               => $columns['cb'],
		'title'            => __( 'Researcher', 'boies-group' ),
		'boies_themes'     => __( 'Themes', 'boies-group' ),
		'boies_projects'   => __( 'Projects', 'boies-group' ),
		'boies_profile_url' => __( 'People Profile', 'boies-group' ),
		'date'             => $columns['date'],
	);
}
add_filter( 'manage_boies_person_posts_columns', 'boies_person_admin_columns' );

/**
 * Render titles for relationship IDs in an admin column.
 */
function boies_research_admin_relationships( $post_id, $meta_key ) {
	$titles = array();
	foreach ( array_map( 'absint', (array) get_post_meta( $post_id, $meta_key, true ) ) as $related_id ) {
		$title = get_the_title( $related_id );
		if ( $title ) {
			$titles[] = $title;
		}
	}

	if ( empty( $titles ) ) {
		esc_html_e( 'None', 'boies-group' );
		return;
	}

	echo esc_html( implode( ', ', $titles ) );
}

function boies_research_admin_column_content( $column, $post_id ) {
	if ( 'boies_image' === $column ) {
		$image = get_the_post_thumbnail( $post_id, array( 72, 48 ), array( 'style' => 'width:72px;height:48px;object-fit:cover;border-radius:4px;' ) );
		echo $image ? wp_kses_post( $image ) : esc_html__( 'Not set', 'boies-group' );
	}

	if ( 'boies_order' === $column ) {
		echo esc_html( (string) get_post_field( 'menu_order', $post_id ) );
	}

	if ( 'boies_themes' === $column ) {
		boies_research_admin_relationships( $post_id, '_boies_theme_ids' );
	}

	if ( 'boies_projects' === $column ) {
		boies_research_admin_relationships( $post_id, '_boies_project_ids' );
	}

	if ( 'boies_profile_url' === $column ) {
		$url = get_post_meta( $post_id, '_boies_profile_url', true );
		if ( $url ) {
			printf( '<a href="%1$s" target="_blank" rel="noopener noreferrer">%2$s</a>', esc_url( $url ), esc_html__( 'Open profile', 'boies-group' ) );
		} else {
			esc_html_e( 'Not linked', 'boies-group' );
		}
	}
}
add_action( 'manage_boies_theme_posts_custom_column', 'boies_research_admin_column_content', 10, 2 );
add_action( 'manage_boies_project_posts_custom_column', 'boies_research_admin_column_content', 10, 2 );
add_action( 'manage_boies_person_posts_custom_column', 'boies_research_admin_column_content', 10, 2 );

/**
 * Plain-text description used by the public map.
 */
function boies_research_description( $post ) {
	$text = $post->post_excerpt ? $post->post_excerpt : $post->post_content;
	$text = wp_strip_all_tags( strip_shortcodes( $text ), true );
	return trim( html_entity_decode( $text, ENT_QUOTES, get_bloginfo( 'charset' ) ) );
}

/**
 * Convert a research record into the frontend's stable node ID.
 */
function boies_research_node_id( $post, $prefix ) {
	return $prefix . '-' . $post->post_name;
}

/**
 * Add an edge once.
 */
function boies_research_add_edge( &$edges, &$seen, $source, $target, $relation ) {
	$key = $relation . '|' . $source . '|' . $target;
	if ( isset( $seen[ $key ] ) ) {
		return;
	}
	$seen[ $key ] = true;
	$edges[]       = array(
		'source'   => $source,
		'target'   => $target,
		'relation' => $relation,
	);
}

/**
 * Public REST payload consumed by the research map.
 */
function boies_research_network_rest_response() {
	$themes      = boies_research_choices( 'boies_theme' );
	$projects    = boies_research_choices( 'boies_project' );
	$people      = boies_research_choices( 'boies_person' );
	$nodes       = array();
	$edges       = array();
	$seen        = array();
	$theme_ids   = array();
	$project_ids = array();

	foreach ( $themes as $theme ) {
		$node_id                 = boies_research_node_id( $theme, 'topic' );
		$theme_ids[ $theme->ID ] = $node_id;
		$image_url               = get_the_post_thumbnail_url( $theme, 'large' );
		if ( ! $image_url ) {
			$image_url = get_post_meta( $theme->ID, '_boies_fallback_image_url', true );
		}
		$nodes[] = array(
			'id'            => $node_id,
			'type'          => 'topic',
			'label'         => get_the_title( $theme ),
			'description'   => boies_research_description( $theme ),
			'imageUrl'      => esc_url_raw( $image_url ),
			'imagePosition' => get_post_meta( $theme->ID, '_boies_image_position', true ) ?: 'center',
		);
	}

	foreach ( $projects as $project ) {
		$node_id                    = boies_research_node_id( $project, 'project' );
		$project_ids[ $project->ID ] = $node_id;
		$nodes[] = array(
			'id'          => $node_id,
			'type'        => 'project',
			'label'       => get_the_title( $project ),
			'description' => boies_research_description( $project ),
		);
	}

	foreach ( $people as $person ) {
		$nodes[] = array(
			'id'          => boies_research_node_id( $person, 'person' ),
			'type'        => 'person',
			'label'       => get_the_title( $person ),
			'description' => boies_research_description( $person ),
			'url'         => esc_url_raw( get_post_meta( $person->ID, '_boies_profile_url', true ) ),
		);
	}

	foreach ( $projects as $project ) {
		$project_node = $project_ids[ $project->ID ];
		foreach ( array_map( 'intval', (array) get_post_meta( $project->ID, '_boies_theme_ids', true ) ) as $theme_id ) {
			if ( isset( $theme_ids[ $theme_id ] ) ) {
				boies_research_add_edge( $edges, $seen, $theme_ids[ $theme_id ], $project_node, 'project' );
			}
		}
	}

	foreach ( $people as $person ) {
		$person_node = boies_research_node_id( $person, 'person' );
		foreach ( array_map( 'intval', (array) get_post_meta( $person->ID, '_boies_theme_ids', true ) ) as $theme_id ) {
			if ( isset( $theme_ids[ $theme_id ] ) ) {
				boies_research_add_edge( $edges, $seen, $theme_ids[ $theme_id ], $person_node, 'researcher' );
			}
		}
		foreach ( array_map( 'intval', (array) get_post_meta( $person->ID, '_boies_project_ids', true ) ) as $project_id ) {
			if ( isset( $project_ids[ $project_id ] ) ) {
				boies_research_add_edge( $edges, $seen, $project_ids[ $project_id ], $person_node, 'researcher' );
			}
		}
	}

	$response = rest_ensure_response(
		array(
			'nodes' => $nodes,
			'edges' => $edges,
		)
	);
	$response->header( 'Cache-Control', 'no-cache, must-revalidate, max-age=0' );
	return $response;
}

/**
 * Register the public read-only endpoint.
 */
function boies_register_research_rest_route() {
	register_rest_route(
		'boies/v1',
		'/research-network',
		array(
			'methods'             => WP_REST_Server::READABLE,
			'callback'            => 'boies_research_network_rest_response',
			'permission_callback' => '__return_true',
		)
	);
}
add_action( 'rest_api_init', 'boies_register_research_rest_route' );

/**
 * Create a seed record without overwriting later WordPress edits.
 */
function boies_research_seed_post( $post_type, $slug, $title, $description, $order ) {
	$existing = get_page_by_path( $slug, OBJECT, $post_type );
	if ( $existing ) {
		return (int) $existing->ID;
	}

	$post_id = wp_insert_post(
		array(
			'post_type'    => $post_type,
			'post_status'  => 'publish',
			'post_name'    => $slug,
			'post_title'   => $title,
			'post_content' => $description,
			'menu_order'   => $order,
		),
		true
	);

	return is_wp_error( $post_id ) ? 0 : (int) $post_id;
}

/**
 * Import a bundled theme image into Media Library once.
 */
function boies_research_seed_image( $post_id, $relative_path ) {
	$fallback_url = trailingslashit( get_stylesheet_directory_uri() ) . ltrim( $relative_path, '/' );
	if ( ! metadata_exists( 'post', $post_id, '_boies_fallback_image_url' ) ) {
		update_post_meta( $post_id, '_boies_fallback_image_url', esc_url_raw( $fallback_url ) );
	}

	if ( has_post_thumbnail( $post_id ) ) {
		return;
	}

	$existing_attachment = absint( get_post_meta( $post_id, '_boies_seed_image_attachment_id', true ) );
	if ( $existing_attachment && 'attachment' === get_post_type( $existing_attachment ) ) {
		set_post_thumbnail( $post_id, $existing_attachment );
		return;
	}

	$source_path = trailingslashit( get_stylesheet_directory() ) . ltrim( $relative_path, '/' );
	if ( ! is_readable( $source_path ) ) {
		return;
	}

	$file_data = file_get_contents( $source_path ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents
	if ( false === $file_data ) {
		return;
	}

	$upload = wp_upload_bits( basename( $source_path ), null, $file_data );
	if ( ! empty( $upload['error'] ) ) {
		return;
	}

	$file_type     = wp_check_filetype( $upload['file'] );
	$attachment_id = wp_insert_attachment(
		array(
			'post_mime_type' => $file_type['type'],
			'post_title'     => get_the_title( $post_id ) . ' research theme',
			'post_status'    => 'inherit',
		),
		$upload['file'],
		$post_id
	);

	if ( ! $attachment_id || is_wp_error( $attachment_id ) ) {
		return;
	}

	require_once ABSPATH . 'wp-admin/includes/image.php';
	$metadata = wp_generate_attachment_metadata( $attachment_id, $upload['file'] );
	if ( $metadata ) {
		wp_update_attachment_metadata( $attachment_id, $metadata );
	}
	set_post_thumbnail( $post_id, $attachment_id );
	update_post_meta( $post_id, '_boies_seed_image_attachment_id', $attachment_id );
}

/**
 * Seed the current public network once, then leave all changes to WordPress.
 */
function boies_seed_research_network() {
	if ( (int) get_option( 'boies_research_seed_version', 0 ) >= BOIES_RESEARCH_SEED_VERSION ) {
		return;
	}

	$themes = array(
		'1d-materials' => array(
			'One-dimensional materials',
			'We synthesize and characterize carbon nanotubes and other one-dimensional materials, then translate their exceptional transport and mechanical properties into macroscopic conductors, fibers, and devices.',
			'assets/images/research/one-dimensional-materials.jpg',
		),
		'autonomous-experimentation' => array(
			'Autonomous experimentation',
			'Automation, online diagnostics, and data-driven decision making help the lab navigate large synthesis spaces and accelerate the discovery of useful materials and operating conditions.',
			'assets/images/research/autonomous-experimentation.jpg',
		),
		'climate-pollution' => array(
			'Climate and pollution',
			'We measure how particles form, evolve, and affect air quality and climate, spanning aviation, transportation, wildfire, and low-cost sensing applications.',
			'assets/images/research/climate-pollution.jpg',
		),
		'energy-materials' => array(
			'Energy materials',
			'The group develops materials and diagnostics for batteries, electrochemical systems, energy storage, and cleaner energy conversion.',
			'assets/images/research/energy-materials.jpg',
		),
		'methane' => array(
			'Methane conversion',
			'We study catalytic and high-temperature pathways that convert methane into valuable solid carbon and hydrogen while improving selectivity, efficiency, and scalability.',
			'assets/images/research/methane-conversion.jpg',
		),
		'solid-carbon' => array(
			'Sustainable nanocarbon',
			'Gas-phase synthesis, reactor design, and multiscale characterization are used to produce useful carbon materials with lower emissions and stronger circular-economy potential.',
			'assets/images/research/sustainable-nanocarbon.jpg',
		),
	);

	$projects = array(
		'arpa-e-cnt' => array( 'ARPA-E CNT', 'Scalable carbon-nanotube synthesis and processing for high-performance conductors.', array( '1d-materials', 'solid-carbon' ) ),
		'astera-mars' => array( 'Astera Mars', 'Aerosol and atmospheric tools for understanding extreme and remote environments.', array( 'climate-pollution' ) ),
		'battery-synthesis-equipment' => array( 'Battery Synthesis Equipment', 'Automated equipment and diagnostics for repeatable energy-material synthesis.', array( 'energy-materials', 'autonomous-experimentation' ) ),
		'faa-boeing' => array( 'FAA-Boeing', 'Measurement and modeling of aviation emissions, particle evolution, and climate-relevant impacts.', array( 'climate-pollution' ) ),
		'kavli-1d-material' => array( 'Kavli 1D Material', 'Fundamental synthesis and characterization of one-dimensional materials.', array( '1d-materials' ) ),
		'precourt-conductors' => array( 'Precourt Conductors', 'Lightweight nanocarbon conductors for electrified energy systems.', array( '1d-materials', 'energy-materials' ) ),
		'slac-battery' => array( 'SLAC-Battery', 'Advanced battery materials and coupled electrochemical characterization.', array( 'energy-materials' ) ),
		'steer' => array( 'STEER', 'Reactor and process development for methane conversion and solid-carbon production.', array( 'methane', 'solid-carbon' ) ),
		'spark' => array( 'Spark', 'Autonomous experimentation for catalyst and reaction-space discovery.', array( 'autonomous-experimentation', 'methane' ) ),
		'sustainability-accelerator' => array( 'Sustainability Accelerator', 'Translation of laboratory materials research into scalable climate and energy solutions.', array( 'energy-materials', 'solid-carbon' ) ),
	);

	$current_profiles = array(
		'adam-boies', 'cyprien-jourdain', 'julie-pongetti', 'michael-larson', 'maddie-swint',
		'sophia-sonnert', 'gaurav-sharma', 'cheyenne-halverson', 'hao-zhang', 'omar-allahham',
		'nate-giessner', 'karime-hernandez', 'david-akanmu',
	);

	$people = array(
		'adam-boies' => array( 'Adam Boies', array(), array() ),
		'alex-hong' => array( 'Alex Hong', array(), array() ),
		'alexi-lindeman' => array( 'Alexi Lindeman', array( '1d-materials', 'energy-materials' ), array() ),
		'ali-rizal' => array( 'Ali Rizal', array( 'climate-pollution' ), array( 'faa-boeing' ) ),
		'cheyenne-halverson' => array( 'Cheyenne Halverson', array( '1d-materials', 'energy-materials' ), array( 'kavli-1d-material' ) ),
		'cyprien-jourdain' => array( 'Cyprien Jourdain', array( 'climate-pollution' ), array( 'astera-mars' ) ),
		'david-akanmu' => array( 'David Akanmu', array( 'methane', 'solid-carbon' ), array( 'steer' ) ),
		'elizabeth-fletes' => array( 'Elizabeth Fletes', array( '1d-materials', 'methane', 'solid-carbon' ), array( 'arpa-e-cnt', 'kavli-1d-material' ) ),
		'gaurav-sharma' => array( 'Gaurav Sharma', array( '1d-materials', 'methane', 'solid-carbon' ), array( 'precourt-conductors', 'kavli-1d-material' ) ),
		'gibson-clark' => array( 'Gibson Clark', array( 'solid-carbon' ), array() ),
		'hao-zhang' => array( 'Hao Zhang', array( 'autonomous-experimentation', 'climate-pollution', 'solid-carbon' ), array( 'astera-mars' ) ),
		'julie-pongetti' => array( 'Julie Pongetti', array( 'climate-pollution' ), array( 'faa-boeing' ) ),
		'karime-hernandez' => array( 'Karime Hernandez', array( 'energy-materials' ), array( 'slac-battery' ) ),
		'maddie-swint' => array( 'Maddie Swint', array( 'autonomous-experimentation', 'climate-pollution', 'methane' ), array( 'spark' ) ),
		'michael-larson' => array( 'Michael Larson', array( '1d-materials', 'energy-materials', 'methane', 'solid-carbon' ), array( 'arpa-e-cnt', 'kavli-1d-material' ) ),
		'morgan-shaffer' => array( 'Morgan Shaffer', array(), array( 'astera-mars' ) ),
		'nate-giessner' => array( 'Nate Giessner', array( '1d-materials', 'solid-carbon' ), array( 'precourt-conductors' ) ),
		'omar-allahham' => array( 'Omar Allahham', array( 'energy-materials', 'methane', 'solid-carbon' ), array( 'steer' ) ),
		'sophia-sonnert' => array( 'Sophia Sonnert', array( 'energy-materials', 'solid-carbon' ), array( 'slac-battery', 'sustainability-accelerator' ) ),
		'summer-su' => array( 'Summer Su', array(), array() ),
		'tristian' => array( 'Tristian', array(), array() ),
	);

	$theme_ids = array();
	$order     = 0;
	foreach ( $themes as $slug => $theme ) {
		$post_id = boies_research_seed_post( 'boies_theme', $slug, $theme[0], $theme[1], $order++ );
		if ( ! $post_id ) {
			return;
		}
		$theme_ids[ $slug ] = $post_id;
		if ( ! metadata_exists( 'post', $post_id, '_boies_image_position' ) ) {
			update_post_meta( $post_id, '_boies_image_position', 'center' );
		}
		boies_research_seed_image( $post_id, $theme[2] );
	}

	$project_ids = array();
	$order       = 0;
	foreach ( $projects as $slug => $project ) {
		$post_id = boies_research_seed_post( 'boies_project', $slug, $project[0], $project[1], $order++ );
		if ( ! $post_id ) {
			return;
		}
		$project_ids[ $slug ] = $post_id;
		if ( ! metadata_exists( 'post', $post_id, '_boies_theme_ids' ) ) {
			update_post_meta( $post_id, '_boies_theme_ids', array_values( array_intersect_key( $theme_ids, array_flip( $project[2] ) ) ) );
		}
	}

	$order = 0;
	foreach ( $people as $slug => $person ) {
		$post_id = boies_research_seed_post( 'boies_person', $slug, $person[0], '', $order++ );
		if ( ! $post_id ) {
			return;
		}
		if ( ! metadata_exists( 'post', $post_id, '_boies_theme_ids' ) ) {
			update_post_meta( $post_id, '_boies_theme_ids', array_values( array_intersect_key( $theme_ids, array_flip( $person[1] ) ) ) );
		}
		if ( ! metadata_exists( 'post', $post_id, '_boies_project_ids' ) ) {
			update_post_meta( $post_id, '_boies_project_ids', array_values( array_intersect_key( $project_ids, array_flip( $person[2] ) ) ) );
		}
		if ( ! metadata_exists( 'post', $post_id, '_boies_profile_url' ) && in_array( $slug, $current_profiles, true ) ) {
			update_post_meta( $post_id, '_boies_profile_url', home_url( '/people/?person=' . rawurlencode( $slug ) . '#person-' . rawurlencode( $slug ) ) );
		}
	}

	update_option( 'boies_research_seed_version', BOIES_RESEARCH_SEED_VERSION, false );
}
add_action( 'init', 'boies_seed_research_network', 20 );
