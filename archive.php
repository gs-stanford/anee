<?php
/**
 * Archive template.
 *
 * @package boies-group
 */

get_header();
?>

<main id="main" class="boies-main boies-page">
	<section class="boies-page-article">
		<header class="boies-page-header">
			<h1><?php the_archive_title(); ?></h1>
			<?php the_archive_description( '<p>', '</p>' ); ?>
		</header>

		<div class="boies-post-grid">
			<?php
			if ( have_posts() ) :
				while ( have_posts() ) :
					the_post();
					?>
					<article id="post-<?php the_ID(); ?>" <?php post_class( 'boies-post-card' ); ?>>
						<p class="boies-section-label"><?php echo esc_html( get_the_date() ); ?></p>
						<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
						<?php the_excerpt(); ?>
					</article>
					<?php
				endwhile;
			else :
				?>
				<p><?php esc_html_e( 'No posts found.', 'boies-group' ); ?></p>
				<?php
			endif;
			?>
		</div>

		<?php the_posts_pagination(); ?>
	</section>
</main>

<?php
get_footer();
