<?php
/**
 * Generic page template.
 *
 * @package boies-group
 */

get_header();
?>

<main id="main" class="boies-main boies-page">
	<?php
	while ( have_posts() ) :
		the_post();
		?>
		<article id="post-<?php the_ID(); ?>" <?php post_class( 'boies-page-article boies-page-article--' . sanitize_html_class( get_post_field( 'post_name', get_the_ID() ) ) ); ?>>
			<header class="boies-page-header">
				<h1><?php the_title(); ?></h1>
			</header>
			<div class="boies-page-content">
				<?php the_content(); ?>
			</div>
		</article>
		<?php
	endwhile;
	?>
</main>

<?php
get_footer();
