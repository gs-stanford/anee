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
$capabilities_image = boies_theme_mod( 'capabilities_image_url' );
$show_page_blocks = (bool) boies_theme_mod( 'show_editor_content' );
$has_page_content = false;
$capability_cards = array(
	array(
		'number' => boies_theme_mod( 'capability_1_number' ),
		'title'  => boies_theme_mod( 'capability_1_title' ),
		'body'   => boies_theme_mod( 'capability_1_body' ),
	),
	array(
		'number' => boies_theme_mod( 'capability_2_number' ),
		'title'  => boies_theme_mod( 'capability_2_title' ),
		'body'   => boies_theme_mod( 'capability_2_body' ),
	),
	array(
		'number' => boies_theme_mod( 'capability_3_number' ),
		'title'  => boies_theme_mod( 'capability_3_title' ),
		'body'   => boies_theme_mod( 'capability_3_body' ),
	),
);

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

	<section id="capabilities" class="boies-section boies-capabilities">
		<div class="boies-capabilities__lead">
			<div class="boies-section__intro">
				<p class="boies-section-label"><?php echo esc_html( boies_theme_mod( 'capabilities_label' ) ); ?></p>
				<h2><?php echo esc_html( boies_theme_mod( 'capabilities_title' ) ); ?></h2>
				<p><?php echo esc_html( boies_theme_mod( 'capabilities_body' ) ); ?></p>
			</div>
			<div class="boies-capabilities__visual <?php echo $capabilities_image ? '' : 'boies-capabilities__visual--empty'; ?>" aria-hidden="<?php echo $capabilities_image ? 'false' : 'true'; ?>">
				<?php if ( $capabilities_image ) : ?>
					<img src="<?php echo esc_url( $capabilities_image ); ?>" alt="<?php esc_attr_e( 'Boies Group capabilities visual', 'boies-group' ); ?>">
				<?php else : ?>
					<span></span><span></span><span></span>
				<?php endif; ?>
			</div>
		</div>
		<div class="boies-capability-grid">
			<?php foreach ( $capability_cards as $card ) : ?>
				<article>
					<span><?php echo esc_html( $card['number'] ); ?></span>
					<h3><?php echo esc_html( $card['title'] ); ?></h3>
					<p><?php echo esc_html( $card['body'] ); ?></p>
				</article>
			<?php endforeach; ?>
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
