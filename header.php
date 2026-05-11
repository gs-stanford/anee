<?php
/**
 * Site header.
 *
 * @package boies-group
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="boies-skip-link" href="#main"><?php esc_html_e( 'Skip to content', 'boies-group' ); ?></a>

<header class="boies-site-header" role="banner">
	<div class="boies-site-header__inner">
		<?php boies_brand_markup(); ?>

		<nav class="boies-nav" aria-label="<?php esc_attr_e( 'Primary navigation', 'boies-group' ); ?>">
			<?php boies_primary_menu(); ?>
		</nav>
	</div>
</header>
