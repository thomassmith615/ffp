<?php
/**
 * 404 — friendly not-found page with routes back into the site.
 */

get_header();
?>

<div class="section single-wrap">
  <div class="section-inner">
    <div class="single-not-found">
      <p class="eyebrow">Not Found</p>
      <h1 class="display-title">We couldn't find that page.</h1>
      <p class="body-copy">It may have been moved or renamed. Browse our resource library or insights to find what you're looking for.</p>
      <div class="not-found-actions">
        <a class="btn btn-green" href="<?php echo esc_url( ffp_url( 'resources' ) ); ?>">Browse Resources</a>
        <a class="btn btn-outline-dark" href="<?php echo esc_url( ffp_url( 'insights' ) ); ?>">Read Insights</a>
        <a class="btn btn-outline-dark" href="<?php echo esc_url( ffp_url( 'contact' ) ); ?>">Ask Our Team</a>
      </div>
    </div>
  </div>
</div>

<?php get_footer(); ?>
