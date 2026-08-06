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
		<nav id="boies-primary-menu" class="boies-nav" aria-label="<?php esc_attr_e( 'Primary navigation', 'boies-group' ); ?>">
			<?php boies_primary_menu(); ?>
		</nav>
		<button class="boies-nav-toggle" type="button" aria-expanded="false" aria-controls="boies-primary-menu">
			<span></span><span></span><span></span><span class="screen-reader-text"><?php esc_html_e( 'Toggle navigation', 'boies-group' ); ?></span>
		</button>
	</div>
</header>
