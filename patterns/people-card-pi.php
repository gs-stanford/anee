<?php
/**
 * Title: PI People Card
 * Slug: anee-ollie-child/people-card-pi
 * Categories: anee-sections, anee-pages
 * Keywords: people, member, PI, profile, bio
 * Inserter: yes
 */
$anee_headshot_placeholder = esc_url( get_stylesheet_directory_uri() . '/assets/images/headshot-placeholder.svg' );
?>
<!-- wp:group {"className":"anee-pi-feature","layout":{"type":"constrained"}} -->
<div class="wp-block-group anee-pi-feature"><!-- wp:group {"className":"anee-profile-card anee-pi-card","layout":{"type":"constrained"}} -->
<div class="wp-block-group anee-profile-card anee-pi-card"><!-- wp:image {"url":"<?php echo $anee_headshot_placeholder; ?>","sizeSlug":"medium","linkDestination":"none","className":"anee-headshot-upload","style":{"border":{"radius":"22px"}}} -->
<figure class="wp-block-image size-medium has-custom-border anee-headshot-upload"><img src="<?php echo $anee_headshot_placeholder; ?>" alt="Replace with PI headshot" style="border-radius:22px"/></figure>
<!-- /wp:image -->

<!-- wp:heading {"level":4} -->
<h4 class="wp-block-heading">Adam Boies</h4>
<!-- /wp:heading -->

<!-- wp:paragraph {"style":{"color":{"text":"var:preset|color|cardinal"},"typography":{"fontWeight":"600"}}} -->
<p class="has-text-color" style="color:var(--wp--preset--color--cardinal);font-weight:600">Professor, Stanford Mechanical Engineering</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><a href="mailto:aboies@stanford.edu">aboies@stanford.edu</a></p>
<!-- /wp:paragraph -->

<!-- wp:details {"className":"anee-profile-bio"} -->
<details class="wp-block-details anee-profile-bio"><summary>Bio</summary><!-- wp:paragraph -->
<p>Add the PI bio here.</p>
<!-- /wp:paragraph --></details>
<!-- /wp:details --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
