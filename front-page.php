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
$openings         = boies_get_opening_pages();
$featured_opening = ! empty( $openings ) ? $openings[0] : null;
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
				<video class="boies-hero__video" autoplay muted loop playsinline preload="metadata" <?php echo $hero_poster ? 'poster="' . esc_url( $hero_poster ) . '"' : ''; ?>>
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

	<section id="openings" class="boies-section boies-home-openings">
		<div class="boies-home-openings__intro">
			<p class="boies-section-label"><?php echo esc_html( boies_theme_mod( 'openings_label' ) ); ?></p>
			<h2><?php echo esc_html( boies_theme_mod( 'openings_title' ) ); ?></h2>
			<p><?php echo esc_html( boies_theme_mod( 'openings_body' ) ); ?></p>
			<a class="boies-text-link" href="<?php echo esc_url( home_url( '/openings/' ) ); ?>"><?php esc_html_e( 'View all openings', 'boies-group' ); ?><span aria-hidden="true">&rarr;</span></a>
		</div>

		<div class="boies-home-openings__listing">
			<?php if ( $featured_opening ) : ?>
				<?php
				$opening_type     = boies_opening_meta( $featured_opening->ID, 'type', __( 'Open position', 'boies-group' ) );
				$opening_location = boies_opening_meta( $featured_opening->ID, 'location' );
				$opening_timing   = boies_opening_meta( $featured_opening->ID, 'timing' );
				$opening_deadline = boies_opening_meta( $featured_opening->ID, 'deadline' );
				?>
				<article class="boies-opening-preview">
					<div class="boies-opening-preview__top">
						<span><?php esc_html_e( 'Current opportunity', 'boies-group' ); ?></span>
						<span><?php echo esc_html( $opening_type ); ?></span>
					</div>
					<h3><a href="<?php echo esc_url( get_permalink( $featured_opening ) ); ?>"><?php echo esc_html( get_the_title( $featured_opening ) ); ?></a></h3>
					<p><?php echo esc_html( wp_strip_all_tags( boies_opening_excerpt( $featured_opening ) ) ); ?></p>
					<?php if ( $opening_location || $opening_timing || $opening_deadline ) : ?>
						<ul class="boies-opening-meta" aria-label="<?php esc_attr_e( 'Position details', 'boies-group' ); ?>">
							<?php if ( $opening_location ) : ?><li><?php echo esc_html( $opening_location ); ?></li><?php endif; ?>
							<?php if ( $opening_timing ) : ?><li><?php echo esc_html( $opening_timing ); ?></li><?php endif; ?>
							<?php if ( $opening_deadline ) : ?><li><?php echo esc_html( $opening_deadline ); ?></li><?php endif; ?>
						</ul>
					<?php endif; ?>
					<a class="boies-opening-preview__link" href="<?php echo esc_url( get_permalink( $featured_opening ) ); ?>"><?php esc_html_e( 'View position', 'boies-group' ); ?><span aria-hidden="true">&rarr;</span></a>
				</article>
			<?php else : ?>
				<article class="boies-opening-preview boies-opening-preview--empty">
					<p class="boies-opening-preview__eyebrow"><?php esc_html_e( 'No current listings', 'boies-group' ); ?></p>
					<h3><?php esc_html_e( 'Research with us.', 'boies-group' ); ?></h3>
					<p><?php esc_html_e( 'New opportunities will appear here as they become available.', 'boies-group' ); ?></p>
					<a class="boies-opening-preview__link" href="mailto:<?php echo esc_attr( boies_theme_mod( 'contact_email' ) ); ?>"><?php esc_html_e( 'Contact the group', 'boies-group' ); ?><span aria-hidden="true">&rarr;</span></a>
				</article>
			<?php endif; ?>
		</div>
	</section>

	<section class="boies-section boies-network-teaser">
		<div class="boies-network-teaser__visual" aria-hidden="true">
			<span></span><span></span><span></span><span></span><span></span><span></span>
		</div>
		<div class="boies-network-teaser__copy">
			<p class="boies-section-label"><?php echo esc_html( boies_theme_mod( 'research_label' ) ); ?></p>
			<h2><?php echo esc_html( boies_theme_mod( 'research_title' ) ); ?></h2>
			<p><?php echo esc_html( boies_theme_mod( 'research_body' ) ); ?></p>
			<a class="boies-text-link" href="<?php echo esc_url( home_url( '/research/' ) ); ?>"><?php esc_html_e( 'Open the research map', 'boies-group' ); ?><span aria-hidden="true">&rarr;</span></a>
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
