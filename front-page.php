<?php
/**
 * Custom homepage.
 *
 * @package boies-group
 */

get_header();

$hero_video       = boies_theme_mod( 'hero_video_url' );
$hero_poster      = boies_theme_mod( 'hero_poster_url' );
$goals_image      = boies_theme_mod( 'goals_image_url' );
$show_page_blocks = (bool) boies_theme_mod( 'show_editor_content' );
$has_page_content = false;

if ( have_posts() ) {
	the_post();
	$has_page_content = trim( wp_strip_all_tags( get_the_content() ) ) !== '';
	rewind_posts();
}
?>

<main id="main" class="boies-main boies-home">
	<section class="boies-hero" aria-label="<?php esc_attr_e( 'Homepage hero', 'boies-group' ); ?>">
		<div class="boies-hero__media" aria-hidden="true">
			<?php if ( $hero_video ) : ?>
				<video class="boies-hero__video" autoplay muted loop playsinline <?php echo $hero_poster ? 'poster="' . esc_url( $hero_poster ) . '"' : ''; ?>>
					<source src="<?php echo esc_url( $hero_video ); ?>" type="video/mp4">
				</video>
			<?php endif; ?>
			<div class="boies-hero__fallback"></div>
			<div class="boies-hero__wash"></div>
		</div>

		<div class="boies-hero__inner">
			<p class="boies-kicker"><?php echo esc_html( boies_theme_mod( 'hero_kicker' ) ); ?></p>
			<h2><?php echo esc_html( boies_theme_mod( 'hero_title' ) ); ?></h2>
			<p class="boies-hero__dek"><?php echo esc_html( boies_theme_mod( 'hero_subtitle' ) ); ?></p>
			<div class="boies-actions">
				<a class="boies-button boies-button--flame" href="<?php echo esc_url( boies_theme_mod( 'hero_primary_url' ) ); ?>"><?php echo esc_html( boies_theme_mod( 'hero_primary_label' ) ); ?></a>
				<a class="boies-button boies-button--ghost" href="<?php echo esc_url( boies_theme_mod( 'hero_secondary_url' ) ); ?>"><?php echo esc_html( boies_theme_mod( 'hero_secondary_label' ) ); ?></a>
			</div>
		</div>
	</section>

	<section class="boies-section boies-goals">
		<div class="boies-goals__copy">
			<p class="boies-section-label"><?php echo esc_html( boies_theme_mod( 'goals_label' ) ); ?></p>
			<h2><?php echo esc_html( boies_theme_mod( 'goals_title' ) ); ?></h2>
			<p><?php echo esc_html( boies_theme_mod( 'goals_body' ) ); ?></p>
		</div>
		<div class="boies-goals__visual">
			<?php if ( $goals_image ) : ?>
				<img src="<?php echo esc_url( $goals_image ); ?>" alt="<?php esc_attr_e( 'Boies Group research visual', 'boies-group' ); ?>">
			<?php else : ?>
				<div class="boies-orbital-visual" aria-hidden="true">
					<span></span><span></span><span></span><span></span>
				</div>
			<?php endif; ?>
		</div>
	</section>

	<section id="capabilities" class="boies-section boies-capabilities">
		<div class="boies-section__intro">
			<p class="boies-section-label"><?php esc_html_e( 'Capabilities', 'boies-group' ); ?></p>
			<h2><?php esc_html_e( 'From aerosol synthesis to deployment-scale measurement.', 'boies-group' ); ?></h2>
		</div>
		<div class="boies-capability-grid">
			<article>
				<span><?php esc_html_e( '01', 'boies-group' ); ?></span>
				<h3><?php esc_html_e( 'Aerosol metrology', 'boies-group' ); ?></h3>
				<p><?php esc_html_e( 'Instrumentation and modeling for particles, emissions, air quality, and evolving gas-phase systems.', 'boies-group' ); ?></p>
			</article>
			<article>
				<span><?php esc_html_e( '02', 'boies-group' ); ?></span>
				<h3><?php esc_html_e( 'Nanocarbon synthesis', 'boies-group' ); ?></h3>
				<p><?php esc_html_e( 'Aerosol and flow-based methods for carbon nanotubes, catalysts, and self-assembled materials.', 'boies-group' ); ?></p>
			</article>
			<article>
				<span><?php esc_html_e( '03', 'boies-group' ); ?></span>
				<h3><?php esc_html_e( 'Energy systems', 'boies-group' ); ?></h3>
				<p><?php esc_html_e( 'Materials and diagnostics for batteries, storage, combustion, transportation, and environmental technologies.', 'boies-group' ); ?></p>
			</article>
		</div>
	</section>

	<?php if ( $show_page_blocks && $has_page_content ) : ?>
		<section class="boies-section boies-editor-content">
			<?php
			while ( have_posts() ) :
				the_post();
				the_content();
			endwhile;
			?>
		</section>
	<?php endif; ?>
</main>

<?php
get_footer();
