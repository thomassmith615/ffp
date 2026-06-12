<?php
/**
 * Individual solution page — /solutions/{slug}/
 *
 * Args:
 *   solution  solution array (from ffp_get_solution(), validated upstream)
 */

$solution = $args['solution'];
$slugs    = array_keys( ffp_solutions() );
$total    = count( $slugs );
$index    = $solution['position'] - 1;
$prev     = $index > 0 ? ffp_get_solution( $slugs[ $index - 1 ] ) : null;
$next     = $index < $total - 1 ? ffp_get_solution( $slugs[ $index + 1 ] ) : null;
?>

<div class="section single-wrap sol-layer">
  <div class="section-inner">
    <article class="single-article sol-detail">
      <?php ffp_breadcrumbs( [
        [ 'label' => 'Solutions', 'url' => ffp_url( 'solutions' ) ],
        [ 'label' => $solution['title'] ],
      ] ); ?>

      <div class="single-header">
        <p class="single-kind">Solution <?php echo esc_html( sprintf( '%02d', $solution['position'] ) ); ?> — of <?php echo esc_html( sprintf( '%02d', $total ) ); ?></p>
        <h1 class="single-title"><?php echo esc_html( $solution['title'] ); ?></h1>
      </div>

      <div class="single-body">
        <?php foreach ( (array) $solution['copy'] as $para ) : ?>
          <p><?php echo esc_html( $para ); ?></p>
        <?php endforeach; ?>
      </div>

      <p class="sol-topics"><?php echo esc_html( implode( '  ·  ', $solution['topics'] ) ); ?></p>

      <div class="single-cta">
        <h3>Ready to talk it through?</h3>
        <p>Not sure where to start? A 15-minute call is all it takes.</p>
        <a class="btn btn-green" href="<?php echo esc_url( ffp_url( 'contact' ) ); ?>">Schedule a Free Introduction</a>
      </div>

      <nav class="sol-pager">
        <?php if ( $prev ) : ?>
          <a class="sol-pager-link" href="<?php echo esc_url( ffp_solution_url( $prev['slug'] ) ); ?>">
            <span class="sol-pager-dir">← Previous</span>
            <span class="sol-pager-title"><?php echo esc_html( $prev['title'] ); ?></span>
          </a>
        <?php else : ?><span></span><?php endif; ?>
        <?php if ( $next ) : ?>
          <a class="sol-pager-link sol-pager-next" href="<?php echo esc_url( ffp_solution_url( $next['slug'] ) ); ?>">
            <span class="sol-pager-dir">Next →</span>
            <span class="sol-pager-title"><?php echo esc_html( $next['title'] ); ?></span>
          </a>
        <?php endif; ?>
      </nav>

      <div class="member-back">
        <a class="view-all-link" href="<?php echo esc_url( ffp_url( 'solutions' ) ); ?>">← All Solutions</a>
      </div>
    </article>
  </div>
</div>
