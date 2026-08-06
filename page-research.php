<?php
/**
 * Interactive research network.
 *
 * @package boies-group
 */

get_header();
?>

<main id="main" class="boies-main boies-research-page">
	<section class="boies-network" data-research-network aria-labelledby="research-map-title">
		<div class="boies-network-toolbar">
			<p class="boies-section-label"><?php esc_html_e( 'Research network', 'boies-group' ); ?></p>
			<h1 id="research-map-title"><?php esc_html_e( 'Explore the lab', 'boies-group' ); ?></h1>
			<p class="boies-network-toolbar__intro"><?php esc_html_e( 'Select a theme to expand its projects and researchers.', 'boies-group' ); ?></p>
		</div>

		<div class="boies-network-legend" aria-label="<?php esc_attr_e( 'Map key', 'boies-group' ); ?>">
			<span><i class="is-theme" aria-hidden="true"></i><?php esc_html_e( 'Research theme', 'boies-group' ); ?></span>
			<span><i class="is-project" aria-hidden="true"></i><?php esc_html_e( 'Project', 'boies-group' ); ?></span>
			<span><i class="is-person" aria-hidden="true"></i><?php esc_html_e( 'Person', 'boies-group' ); ?></span>
		</div>

		<p class="screen-reader-text" data-network-status aria-live="polite"></p>

		<div class="boies-network-explorer" data-network-explorer aria-describedby="research-map-description"></div>
		<p id="research-map-description" class="screen-reader-text"><?php esc_html_e( 'An interactive hierarchy connecting research themes, active projects, and Boies Group researchers.', 'boies-group' ); ?></p>
	</section>
</main>

<?php
get_footer();
