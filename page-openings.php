<?php
/**
 * Current opportunities at the Boies Group.
 *
 * @package boies-group
 */

get_header();

$openings      = boies_get_opening_pages();
$contact_email = boies_theme_mod( 'contact_email' );
$hub           = boies_openings_hub_content();
?>

<main id="main" class="boies-main boies-openings-page">
	<header class="boies-openings-hero">
		<div class="boies-openings-hero__inner">
			<p class="boies-section-label"><?php echo esc_html( $hub['hero_label'] ); ?></p>
			<h1><?php echo esc_html( $hub['hero_title'] ); ?></h1>
			<p class="boies-openings-hero__dek"><?php echo esc_html( $hub['hero_body'] ); ?></p>
		</div>
	</header>

	<section class="boies-openings-index" aria-labelledby="current-openings-title">
		<div class="boies-openings-index__head">
			<p class="boies-section-label"><?php echo esc_html( $hub['listing_label'] ); ?></p>
			<div>
				<h2 id="current-openings-title"><?php echo esc_html( $hub['listing_title'] ); ?></h2>
				<p class="boies-openings-index__intro"><?php echo esc_html( $hub['listing_body'] ); ?></p>
			</div>
		</div>

		<?php if ( $openings ) : ?>
			<div class="boies-openings-list">
				<?php foreach ( $openings as $index => $opening ) : ?>
					<?php
					$opening_type     = boies_opening_meta( $opening->ID, 'type', __( 'Open position', 'boies-group' ) );
					$opening_location = boies_opening_meta( $opening->ID, 'location' );
					$opening_timing   = boies_opening_meta( $opening->ID, 'timing' );
					$opening_deadline = boies_opening_meta( $opening->ID, 'deadline' );
					?>
					<article class="boies-openings-row">
						<span class="boies-openings-row__number" aria-hidden="true"><?php echo esc_html( str_pad( (string) ( $index + 1 ), 2, '0', STR_PAD_LEFT ) ); ?></span>
						<div class="boies-openings-row__body">
							<p class="boies-openings-row__type"><?php echo esc_html( $opening_type ); ?></p>
							<h2><a href="<?php echo esc_url( get_permalink( $opening ) ); ?>"><?php echo esc_html( get_the_title( $opening ) ); ?></a></h2>
							<p class="boies-openings-row__summary"><?php echo esc_html( boies_opening_excerpt( $opening ) ); ?></p>
							<?php if ( $opening_location || $opening_timing || $opening_deadline ) : ?>
								<ul class="boies-opening-meta" aria-label="<?php esc_attr_e( 'Position details', 'boies-group' ); ?>">
									<?php if ( $opening_location ) : ?><li><?php echo esc_html( $opening_location ); ?></li><?php endif; ?>
									<?php if ( $opening_timing ) : ?><li><?php echo esc_html( $opening_timing ); ?></li><?php endif; ?>
									<?php if ( $opening_deadline ) : ?><li><?php echo esc_html( $opening_deadline ); ?></li><?php endif; ?>
								</ul>
							<?php endif; ?>
						</div>
						<a class="boies-openings-row__action" href="<?php echo esc_url( get_permalink( $opening ) ); ?>"><?php esc_html_e( 'View position', 'boies-group' ); ?><span aria-hidden="true">&rarr;</span></a>
					</article>
				<?php endforeach; ?>
			</div>
		<?php else : ?>
			<div class="boies-openings-empty">
				<h3><?php echo esc_html( $hub['empty_title'] ); ?></h3>
				<p><?php echo esc_html( $hub['empty_body'] ); ?></p>
			</div>
		<?php endif; ?>
	</section>

	<section class="boies-openings-contact">
		<div>
			<p class="boies-section-label"><?php echo esc_html( $hub['contact_label'] ); ?></p>
			<h2><?php echo esc_html( $hub['contact_title'] ); ?></h2>
		</div>
		<p><?php echo esc_html( $hub['contact_body'] ); ?></p>
		<a class="boies-button boies-button--primary" href="mailto:<?php echo esc_attr( $contact_email ); ?>"><?php echo esc_html( $hub['contact_button'] ); ?></a>
	</section>
</main>

<?php get_footer(); ?>
