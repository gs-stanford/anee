<?php
/**
 * Interactive research network.
 *
 * @package boies-group
 */

get_header();
?>

<main id="main" class="boies-main boies-research-page">
	<header class="boies-research-hero">
		<div>
			<p class="boies-section-label"><?php esc_html_e( 'Research network', 'boies-group' ); ?></p>
			<h1><?php esc_html_e( 'Connected work, not isolated projects.', 'boies-group' ); ?></h1>
		</div>
		<p><?php esc_html_e( 'Select a research theme to trace the active projects and people behind it. The map is generated from the lab\'s shared research vault and links every researcher back to their profile.', 'boies-group' ); ?></p>
	</header>

	<section class="boies-network" data-research-network aria-labelledby="research-map-title">
		<div class="boies-network-toolbar">
			<div>
				<p class="boies-section-label"><?php esc_html_e( 'Interactive map', 'boies-group' ); ?></p>
				<h2 id="research-map-title"><?php esc_html_e( 'Explore the lab', 'boies-group' ); ?></h2>
			</div>
			<button type="button" data-network-reset><?php esc_html_e( 'View all research', 'boies-group' ); ?></button>
		</div>

		<p class="boies-network-status" data-network-status aria-live="polite"></p>

		<div class="boies-network-layout">
			<div class="boies-network-canvas">
				<svg viewBox="0 0 1400 860" role="img" aria-labelledby="research-map-title research-map-description" preserveAspectRatio="xMidYMid meet"></svg>
				<p id="research-map-description" class="screen-reader-text"><?php esc_html_e( 'An interactive diagram connecting research themes, active projects, and Boies Group researchers.', 'boies-group' ); ?></p>
				<div class="boies-network-mobile" aria-label="<?php esc_attr_e( 'Research themes', 'boies-group' ); ?>"></div>
			</div>

			<aside class="boies-network-detail" aria-live="polite">
				<p class="boies-network-detail__prompt"><?php esc_html_e( 'Select a research theme to reveal its active projects and people.', 'boies-group' ); ?></p>
			</aside>
		</div>
	</section>
</main>

<?php
get_footer();
