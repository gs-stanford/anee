<?php
/**
 * Fallback template.
 *
 * @package boies-group
 */

if ( is_singular() ) {
	get_template_part( 'page' );
	return;
}

get_template_part( 'archive' );
