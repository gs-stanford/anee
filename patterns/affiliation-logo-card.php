<?php
/**
 * Title: Affiliation Logo Card
 * Slug: anee-ollie-child/affiliation-logo-card
 * Categories: anee-sections, anee-pages
 * Keywords: affiliation, sponsor, partner, logo
 * Inserter: yes
 */
$anee_logo_placeholder = esc_url( get_stylesheet_directory_uri() . '/assets/images/logo-placeholder.svg' );
?>
<!-- wp:group {"className":"anee-logo-card","layout":{"type":"constrained"}} -->
<div class="wp-block-group anee-logo-card"><!-- wp:image {"url":"<?php echo $anee_logo_placeholder; ?>","sizeSlug":"medium","linkDestination":"none","className":"anee-logo-upload"} -->
<figure class="wp-block-image size-medium anee-logo-upload"><img src="<?php echo $anee_logo_placeholder; ?>" alt="Replace with affiliation or sponsor logo"/></figure>
<!-- /wp:image --></div>
<!-- /wp:group -->
