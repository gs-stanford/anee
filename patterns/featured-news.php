<?php
/**
 * Title: Featured News Strip
 * Slug: anee-ollie-child/featured-news
 * Categories: anee-sections, anee-pages
 * Inserter: yes
 */
?>
<!-- wp:group {"align":"wide","className":"anee-section-shell","style":{"spacing":{"margin":{"bottom":"2.4rem"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignwide anee-section-shell" style="margin-bottom:2.4rem"><!-- wp:columns {"align":"wide"} -->
<div class="wp-block-columns alignwide"><!-- wp:column {"width":"32%"} -->
<div class="wp-block-column" style="flex-basis:32%"><!-- wp:paragraph {"className":"anee-eyebrow"} -->
<p class="anee-eyebrow">Latest updates</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"fontSize":"xl"} -->
<h2 class="wp-block-heading has-xl-font-size">Keep the homepage fresh without turning it into a generic blog.</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"style":{"color":{"text":"var:preset|color|muted"}}} -->
<p class="has-text-color" style="color:var(--wp--preset--color--muted)">This pattern pulls the latest three posts so the homepage shows activity while staying research-first.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><a href="/blog/">See all news</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"68%"} -->
<div class="wp-block-column" style="flex-basis:68%"><!-- wp:query {"queryId":12,"query":{"perPage":3,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","inherit":false},"layout":{"type":"default"}} -->
<div class="wp-block-query"><!-- wp:post-template {"layout":{"type":"grid","columnCount":3}} -->
<!-- wp:group {"className":"anee-post-card","layout":{"type":"constrained"}} -->
<div class="wp-block-group anee-post-card"><!-- wp:post-featured-image {"isLink":true,"aspectRatio":"16/9","style":{"border":{"radius":"20px"}}} /-->

<!-- wp:post-date {"style":{"typography":{"fontSize":"0.82rem","letterSpacing":"0.12em","textTransform":"uppercase"},"color":{"text":"var:preset|color|muted"}}} /-->

<!-- wp:post-title {"isLink":true,"fontSize":"lg"} /-->

<!-- wp:post-excerpt {"excerptLength":16,"moreText":"Read more"} /--></div>
<!-- /wp:group -->
<!-- /wp:post-template --></div>
<!-- /wp:query --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->
