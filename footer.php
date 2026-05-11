<?php
/**
 * Site footer.
 *
 * @package boies-group
 */
?>
<footer class="boies-site-footer" role="contentinfo">
	<div class="boies-site-footer__inner">
		<div class="boies-site-footer__brand">
			<p class="boies-site-footer__title"><?php esc_html_e( 'The Boies Group', 'boies-group' ); ?></p>
		</div>

		<nav class="boies-site-footer__nav" aria-label="<?php esc_attr_e( 'Footer navigation', 'boies-group' ); ?>">
			<p class="boies-footer-label"><?php esc_html_e( 'Explore', 'boies-group' ); ?></p>
			<?php boies_footer_menu(); ?>
		</nav>

		<div class="boies-site-footer__contact">
			<p class="boies-footer-label"><?php esc_html_e( 'Contact', 'boies-group' ); ?></p>
			<p>
				<?php esc_html_e( 'Stanford University', 'boies-group' ); ?><br>
				<?php esc_html_e( 'Mechanical Engineering', 'boies-group' ); ?><br>
				<a href="mailto:<?php echo esc_attr( boies_theme_mod( 'contact_email' ) ); ?>"><?php echo esc_html( boies_theme_mod( 'contact_email' ) ); ?></a>
			</p>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
