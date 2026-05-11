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
	<?php
	$boies_root_css = get_stylesheet_directory() . '/style.css';
	$boies_asset_css = get_template_directory() . '/assets/css/anee.css';
	?>
	<link rel="stylesheet" href="<?php echo esc_url( get_stylesheet_uri() ); ?>?ver=<?php echo esc_attr( file_exists( $boies_root_css ) ? filemtime( $boies_root_css ) : wp_get_theme()->get( 'Version' ) ); ?>">
	<link rel="stylesheet" href="<?php echo esc_url( get_template_directory_uri() . '/assets/css/anee.css' ); ?>?ver=<?php echo esc_attr( file_exists( $boies_asset_css ) ? filemtime( $boies_asset_css ) : wp_get_theme()->get( 'Version' ) ); ?>">
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
