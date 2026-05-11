<?php
/**
 * Title: People Directory Starter
 * Slug: anee-ollie-child/people-grid
 * Categories: anee-sections, anee-pages
 * Inserter: yes
 */
$anee_headshot_placeholder = esc_url( get_stylesheet_directory_uri() . '/assets/images/headshot-placeholder.svg' );
?>
<!-- wp:group {"align":"wide","className":"anee-section-shell anee-people-directory","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignwide anee-section-shell anee-people-directory"><!-- wp:heading {"fontSize":"xl"} -->
<h2 class="wp-block-heading has-xl-font-size">People</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>The Boies Group is a Stanford lab. Stanford members are shown first, with Cambridge collaborators and past members in expandable sections below.</p>
<!-- /wp:paragraph -->

<!-- wp:group {"className":"anee-people-section-default","layout":{"type":"constrained"}} -->
<div class="wp-block-group anee-people-section-default"><!-- wp:group {"className":"anee-pi-feature","layout":{"type":"constrained"}} -->
<div class="wp-block-group anee-pi-feature"><!-- wp:group {"className":"anee-profile-card anee-pi-card","layout":{"type":"constrained"}} -->
<div class="wp-block-group anee-profile-card anee-pi-card"><!-- wp:image {"url":"<?php echo $anee_headshot_placeholder; ?>","sizeSlug":"medium","linkDestination":"none","className":"anee-headshot-upload"} -->
<figure class="wp-block-image size-medium anee-headshot-upload"><img src="<?php echo $anee_headshot_placeholder; ?>" alt="Replace with Adam Boies headshot"/></figure>
<!-- /wp:image -->

<!-- wp:heading {"level":4} -->
<h4 class="wp-block-heading">Adam Boies</h4>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><strong>Professor, Stanford Mechanical Engineering</strong></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><a href="mailto:aboies@stanford.edu">aboies@stanford.edu</a></p>
<!-- /wp:paragraph -->

<!-- wp:details {"className":"anee-profile-bio"} -->
<details class="wp-block-details anee-profile-bio"><summary>Bio</summary><!-- wp:paragraph -->
<p>Add Adam's PI bio here.</p>
<!-- /wp:paragraph --></details>
<!-- /wp:details --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:heading {"level":4,"className":"anee-people-subheading"} -->
<h4 class="wp-block-heading anee-people-subheading">Stanford members</h4>
<!-- /wp:heading -->

<!-- wp:group {"className":"anee-profile-card anee-member-card","layout":{"type":"constrained"}} -->
<div class="wp-block-group anee-profile-card anee-member-card"><!-- wp:image {"url":"<?php echo $anee_headshot_placeholder; ?>","sizeSlug":"medium","linkDestination":"none","className":"anee-headshot-upload"} -->
<figure class="wp-block-image size-medium anee-headshot-upload"><img src="<?php echo $anee_headshot_placeholder; ?>" alt="Replace with Stanford member headshot"/></figure>
<!-- /wp:image -->
<!-- wp:heading {"level":4} --><h4 class="wp-block-heading">Stanford member</h4><!-- /wp:heading -->
<!-- wp:paragraph --><p><strong>Role / program</strong></p><!-- /wp:paragraph -->
<!-- wp:paragraph --><p>stanford-email@stanford.edu</p><!-- /wp:paragraph -->
<!-- wp:details {"className":"anee-profile-bio"} --><details class="wp-block-details anee-profile-bio"><summary>Bio</summary><!-- wp:paragraph --><p>Add a short member bio here.</p><!-- /wp:paragraph --></details><!-- /wp:details --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"anee-profile-card anee-member-card","layout":{"type":"constrained"}} -->
<div class="wp-block-group anee-profile-card anee-member-card"><!-- wp:image {"url":"<?php echo $anee_headshot_placeholder; ?>","sizeSlug":"medium","linkDestination":"none","className":"anee-headshot-upload"} -->
<figure class="wp-block-image size-medium anee-headshot-upload"><img src="<?php echo $anee_headshot_placeholder; ?>" alt="Replace with Stanford member headshot"/></figure>
<!-- /wp:image -->
<!-- wp:heading {"level":4} --><h4 class="wp-block-heading">Stanford member</h4><!-- /wp:heading -->
<!-- wp:paragraph --><p><strong>Role / program</strong></p><!-- /wp:paragraph -->
<!-- wp:paragraph --><p>stanford-email@stanford.edu</p><!-- /wp:paragraph -->
<!-- wp:details {"className":"anee-profile-bio"} --><details class="wp-block-details anee-profile-bio"><summary>Bio</summary><!-- wp:paragraph --><p>Add a short member bio here.</p><!-- /wp:paragraph --></details><!-- /wp:details --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"anee-profile-card anee-member-card","layout":{"type":"constrained"}} -->
<div class="wp-block-group anee-profile-card anee-member-card"><!-- wp:image {"url":"<?php echo $anee_headshot_placeholder; ?>","sizeSlug":"medium","linkDestination":"none","className":"anee-headshot-upload"} -->
<figure class="wp-block-image size-medium anee-headshot-upload"><img src="<?php echo $anee_headshot_placeholder; ?>" alt="Replace with Stanford member headshot"/></figure>
<!-- /wp:image -->
<!-- wp:heading {"level":4} --><h4 class="wp-block-heading">Stanford member</h4><!-- /wp:heading -->
<!-- wp:paragraph --><p><strong>Role / program</strong></p><!-- /wp:paragraph -->
<!-- wp:paragraph --><p>stanford-email@stanford.edu</p><!-- /wp:paragraph -->
<!-- wp:details {"className":"anee-profile-bio"} --><details class="wp-block-details anee-profile-bio"><summary>Bio</summary><!-- wp:paragraph --><p>Add a short member bio here.</p><!-- /wp:paragraph --></details><!-- /wp:details --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:details {"className":"anee-people-panel"} -->
<details class="wp-block-details anee-people-panel"><summary>Cambridge</summary><!-- wp:group {"className":"anee-profile-card anee-member-card","layout":{"type":"constrained"}} -->
<div class="wp-block-group anee-profile-card anee-member-card"><!-- wp:image {"url":"<?php echo $anee_headshot_placeholder; ?>","sizeSlug":"medium","linkDestination":"none","className":"anee-headshot-upload"} -->
<figure class="wp-block-image size-medium anee-headshot-upload"><img src="<?php echo $anee_headshot_placeholder; ?>" alt="Replace with Cambridge member headshot"/></figure>
<!-- /wp:image -->
<!-- wp:heading {"level":4} --><h4 class="wp-block-heading">Cambridge member</h4><!-- /wp:heading -->
<!-- wp:paragraph --><p><strong>Role / program</strong></p><!-- /wp:paragraph -->
<!-- wp:details {"className":"anee-profile-bio"} --><details class="wp-block-details anee-profile-bio"><summary>Bio</summary><!-- wp:paragraph --><p>Add a short Cambridge member bio here.</p><!-- /wp:paragraph --></details><!-- /wp:details --></div>
<!-- /wp:group --></details>
<!-- /wp:details -->

<!-- wp:details {"className":"anee-people-panel"} -->
<details class="wp-block-details anee-people-panel"><summary>Past Members</summary><!-- wp:list {"className":"anee-people-list"} -->
<ul class="anee-people-list"><li>Name, role, years, current destination</li><li>Name, role, years, current destination</li></ul>
<!-- /wp:list --></details>
<!-- /wp:details --></div>
<!-- /wp:group -->
