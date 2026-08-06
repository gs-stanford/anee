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
		<div class="boies-publications-hero__inner">
			<p class="boies-section-label"><?php esc_html_e( 'Research output', 'boies-group' ); ?></p>
			<h1><?php esc_html_e( 'Published work.', 'boies-group' ); ?></h1>
			<p><?php esc_html_e( 'Peer-reviewed publications from the Boies Group, synchronized with Adam Boies\'s research library.', 'boies-group' ); ?></p>
		</div>
	</header>

	<section class="boies-bibliography" aria-label="<?php esc_attr_e( 'Boies Group publications', 'boies-group' ); ?>">
		<div class="boies-bibliography__mount">
			<p class="boies-bibliography__loading"><?php esc_html_e( 'Loading publications...', 'boies-group' ); ?></p>
			<script src="https://bibbase.org/service/mendeley/317fdcd2-b041-3222-bca0-702f39879f87?jsonp=1"></script>
		</div>
		<noscript>
			<p><?php esc_html_e( 'JavaScript is required to load the live publication list.', 'boies-group' ); ?></p>
		</noscript>
	</section>
</main>

<?php
get_footer();
