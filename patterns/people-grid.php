<?php
/**
 * Title: People Sections Starter
 * Slug: anee-ollie-child/people-grid
 * Categories: anee-sections, anee-pages
 * Inserter: yes
 */
$anee_headshot_placeholder = esc_url( get_stylesheet_directory_uri() . '/assets/images/headshot-placeholder.svg' );
?>
<!-- wp:group {"align":"wide","className":"anee-section-shell anee-people-directory","style":{"spacing":{"margin":{"bottom":"2.2rem"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignwide anee-section-shell anee-people-directory" style="margin-bottom:2.2rem"><!-- wp:heading {"fontSize":"xl"} -->
<h2 class="wp-block-heading has-xl-font-size">People</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"style":{"color":{"text":"var:preset|color|muted"}}} -->
<p class="has-text-color" style="color:var(--wp--preset--color--muted)">The Boies Group is a Stanford lab. Stanford members are shown by default, while Cambridge collaborators and past members are available below as expandable sections.</p>
<!-- /wp:paragraph -->

<!-- wp:group {"className":"anee-people-section anee-people-section-default","style":{"spacing":{"margin":{"top":"2rem"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group anee-people-section anee-people-section-default" style="margin-top:2rem"><!-- wp:heading {"level":3,"fontSize":"lg"} -->
<h3 class="wp-block-heading has-lg-font-size">Stanford</h3>
<!-- /wp:heading -->

<!-- wp:columns {"align":"wide","className":"anee-people-card-grid"} -->
<div class="wp-block-columns alignwide anee-people-card-grid"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"anee-profile-card","layout":{"type":"constrained"}} -->
<div class="wp-block-group anee-profile-card"><!-- wp:image {"url":"<?php echo $anee_headshot_placeholder; ?>","sizeSlug":"medium","linkDestination":"none","className":"anee-headshot-upload","style":{"border":{"radius":"22px"}}} -->
<figure class="wp-block-image size-medium has-custom-border anee-headshot-upload"><img src="<?php echo $anee_headshot_placeholder; ?>" alt="Replace with Adam Boies headshot" style="border-radius:22px"/></figure>
<!-- /wp:image -->

<!-- wp:heading {"level":4} -->
<h4 class="wp-block-heading">Adam Boies</h4>
<!-- /wp:heading -->

<!-- wp:paragraph {"style":{"color":{"text":"var:preset|color|cardinal"},"typography":{"fontWeight":"600"}}} -->
<p class="has-text-color" style="color:var(--wp--preset--color--cardinal);font-weight:600">Professor, Stanford Mechanical Engineering</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><a href="mailto:aboies@stanford.edu">aboies@stanford.edu</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"anee-profile-card","layout":{"type":"constrained"}} -->
<div class="wp-block-group anee-profile-card"><!-- wp:image {"url":"<?php echo $anee_headshot_placeholder; ?>","sizeSlug":"medium","linkDestination":"none","className":"anee-headshot-upload","style":{"border":{"radius":"22px"}}} -->
<figure class="wp-block-image size-medium has-custom-border anee-headshot-upload"><img src="<?php echo $anee_headshot_placeholder; ?>" alt="Replace with Stanford member headshot" style="border-radius:22px"/></figure>
<!-- /wp:image -->

<!-- wp:heading {"level":4} -->
<h4 class="wp-block-heading">Stanford member</h4>
<!-- /wp:heading -->

<!-- wp:paragraph {"style":{"color":{"text":"var:preset|color|cardinal"},"typography":{"fontWeight":"600"}}} -->
<p class="has-text-color" style="color:var(--wp--preset--color--cardinal);font-weight:600">Role / program</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>stanford-email@stanford.edu</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"anee-profile-card","layout":{"type":"constrained"}} -->
<div class="wp-block-group anee-profile-card"><!-- wp:image {"url":"<?php echo $anee_headshot_placeholder; ?>","sizeSlug":"medium","linkDestination":"none","className":"anee-headshot-upload","style":{"border":{"radius":"22px"}}} -->
<figure class="wp-block-image size-medium has-custom-border anee-headshot-upload"><img src="<?php echo $anee_headshot_placeholder; ?>" alt="Replace with Stanford member headshot" style="border-radius:22px"/></figure>
<!-- /wp:image -->

<!-- wp:heading {"level":4} -->
<h4 class="wp-block-heading">Stanford member</h4>
<!-- /wp:heading -->

<!-- wp:paragraph {"style":{"color":{"text":"var:preset|color|cardinal"},"typography":{"fontWeight":"600"}}} -->
<p class="has-text-color" style="color:var(--wp--preset--color--cardinal);font-weight:600">Role / program</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>stanford-email@stanford.edu</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->

<!-- wp:details {"className":"anee-people-panel"} -->
<details class="wp-block-details anee-people-panel"><summary>Cambridge</summary><!-- wp:columns {"align":"wide","className":"anee-people-card-grid"} -->
<div class="wp-block-columns alignwide anee-people-card-grid"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"anee-profile-card","layout":{"type":"constrained"}} -->
<div class="wp-block-group anee-profile-card"><!-- wp:image {"url":"<?php echo $anee_headshot_placeholder; ?>","sizeSlug":"medium","linkDestination":"none","className":"anee-headshot-upload","style":{"border":{"radius":"22px"}}} -->
<figure class="wp-block-image size-medium has-custom-border anee-headshot-upload"><img src="<?php echo $anee_headshot_placeholder; ?>" alt="Replace with Cambridge member headshot" style="border-radius:22px"/></figure>
<!-- /wp:image -->

<!-- wp:heading {"level":4} -->
<h4 class="wp-block-heading">Cambridge member</h4>
<!-- /wp:heading -->

<!-- wp:paragraph {"style":{"color":{"text":"var:preset|color|cardinal"},"typography":{"fontWeight":"600"}}} -->
<p class="has-text-color" style="color:var(--wp--preset--color--cardinal);font-weight:600">Role / program</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"anee-profile-card","layout":{"type":"constrained"}} -->
<div class="wp-block-group anee-profile-card"><!-- wp:image {"url":"<?php echo $anee_headshot_placeholder; ?>","sizeSlug":"medium","linkDestination":"none","className":"anee-headshot-upload","style":{"border":{"radius":"22px"}}} -->
<figure class="wp-block-image size-medium has-custom-border anee-headshot-upload"><img src="<?php echo $anee_headshot_placeholder; ?>" alt="Replace with Cambridge member headshot" style="border-radius:22px"/></figure>
<!-- /wp:image -->

<!-- wp:heading {"level":4} -->
<h4 class="wp-block-heading">Cambridge member</h4>
<!-- /wp:heading -->

<!-- wp:paragraph {"style":{"color":{"text":"var:preset|color|cardinal"},"typography":{"fontWeight":"600"}}} -->
<p class="has-text-color" style="color:var(--wp--preset--color--cardinal);font-weight:600">Role / program</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></details>
<!-- /wp:details -->

<!-- wp:details {"className":"anee-people-panel"} -->
<details class="wp-block-details anee-people-panel"><summary>Past Members</summary><!-- wp:list {"className":"anee-people-list"} -->
<ul class="anee-people-list"><li>Name, role, years, current destination</li><li>Name, role, years, current destination</li><li>Name, role, years, current destination</li></ul>
<!-- /wp:list --></details>
<!-- /wp:details --></div>
<!-- /wp:group -->
