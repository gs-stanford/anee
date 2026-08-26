<?php
/**
 * Individual, editor-managed opening.
 *
 * @package boies-group
 */

get_header();
?>

<main id="main" class="boies-main boies-opening-page">
	<?php while ( have_posts() ) : ?>
		<?php
		the_post();
		$opening_id       = get_the_ID();
		$opening_type     = boies_opening_meta( $opening_id, 'type', __( 'Open position', 'boies-group' ) );
		$opening_location = boies_opening_meta( $opening_id, 'location' );
		$opening_timing   = boies_opening_meta( $opening_id, 'timing' );
		$opening_deadline = boies_opening_meta( $opening_id, 'deadline' );
		$application_email = boies_opening_meta( $opening_id, 'email', boies_theme_mod( 'contact_email' ) );
		?>

		<header class="boies-opening-hero">
			<div class="boies-opening-hero__inner">
				<a class="boies-opening-back" href="<?php echo esc_url( home_url( '/openings/' ) ); ?>"><span aria-hidden="true">&larr;</span><?php esc_html_e( 'All openings', 'boies-group' ); ?></a>
				<p class="boies-opening-hero__type"><?php echo esc_html( $opening_type ); ?></p>
				<h1><?php the_title(); ?></h1>
				<?php if ( $opening_location || $opening_timing || $opening_deadline ) : ?>
					<ul class="boies-opening-meta" aria-label="<?php esc_attr_e( 'Position details', 'boies-group' ); ?>">
						<?php if ( $opening_location ) : ?><li><?php echo esc_html( $opening_location ); ?></li><?php endif; ?>
						<?php if ( $opening_timing ) : ?><li><?php echo esc_html( $opening_timing ); ?></li><?php endif; ?>
						<?php if ( $opening_deadline ) : ?><li><?php echo esc_html( $opening_deadline ); ?></li><?php endif; ?>
					</ul>
				<?php endif; ?>
			</div>
		</header>

		<div class="boies-opening-layout">
			<article class="boies-opening-content">
				<?php if ( has_post_thumbnail() ) : ?>
					<figure class="boies-opening-content__image">
						<?php the_post_thumbnail( 'large', array( 'loading' => 'eager' ) ); ?>
					</figure>
				<?php endif; ?>
				<?php the_content(); ?>
			</article>

			<aside class="boies-opening-apply" aria-labelledby="opening-apply-title">
				<p class="boies-opening-apply__label"><?php esc_html_e( 'Application', 'boies-group' ); ?></p>
				<h2 id="opening-apply-title"><?php esc_html_e( 'How to apply', 'boies-group' ); ?></h2>
				<dl>
					<?php if ( $opening_location ) : ?><dt><?php esc_html_e( 'Location', 'boies-group' ); ?></dt><dd><?php echo esc_html( $opening_location ); ?></dd><?php endif; ?>
					<?php if ( $opening_timing ) : ?><dt><?php esc_html_e( 'Timing', 'boies-group' ); ?></dt><dd><?php echo esc_html( $opening_timing ); ?></dd><?php endif; ?>
					<?php if ( $opening_deadline ) : ?><dt><?php esc_html_e( 'Review', 'boies-group' ); ?></dt><dd><?php echo esc_html( $opening_deadline ); ?></dd><?php endif; ?>
				</dl>
				<a class="boies-button boies-button--primary boies-opening-apply__email" href="mailto:<?php echo esc_attr( $application_email ); ?>"><?php esc_html_e( 'Apply by email', 'boies-group' ); ?></a>
				<p class="boies-opening-apply__note"><?php echo esc_html( $application_email ); ?></p>
			</aside>
		</div>
	<?php endwhile; ?>
</main>

<?php get_footer(); ?>
