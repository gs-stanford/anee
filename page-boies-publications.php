<?php
/**
 * Live publications page powered by the group's existing BibBase library.
 *
 * @package boies-group
 */

get_header();
?>

<main id="main" class="boies-main boies-publications-page">
	<header class="boies-publications-hero">
		<p class="boies-section-label"><?php esc_html_e( 'Publications', 'boies-group' ); ?></p>
		<h1><?php esc_html_e( 'Published work from the Boies Group.', 'boies-group' ); ?></h1>
		<p><?php esc_html_e( 'This bibliography is synchronized with Adam Boies\'s research library and updates independently of the WordPress page editor.', 'boies-group' ); ?></p>
	</header>

	<section class="boies-bibliography" aria-label="<?php esc_attr_e( 'Boies Group publications', 'boies-group' ); ?>">
		<div id="bibbase">
			<p class="boies-bibliography__loading"><?php esc_html_e( 'Loading publications...', 'boies-group' ); ?></p>
		</div>
		<script src="https://bibbase.org/service/mendeley/317fdcd2-b041-3222-bca0-702f39879f87?jsonp=1"></script>
		<noscript>
			<p><?php esc_html_e( 'JavaScript is required to load the live publication list.', 'boies-group' ); ?></p>
		</noscript>
	</section>
</main>

<?php
get_footer();
