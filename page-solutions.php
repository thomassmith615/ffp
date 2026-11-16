<?php
/**
 * Solutions — full-page left/right viewer at /solutions/, full solution
 * pages at /solutions/{slug}/ (validated in inc/routing.php). Content
 * lives in data/solutions.php; panel images in assets/img/solutions/.
 *
 * Each viewer panel shows the solution's verbatim first paragraph; the
 * complete client-approved copy lives on the individual page. On
 * screens under 860px the viewer degrades to a vertical scroll of the
 * same panels (no pager).
 */

$ffp_slug = get_query_var( 'ffp_slug' );

get_header();

$ffp_logo = ffp_image_url( 'logo-tree-og' );
if ( $ffp_logo ) :
?>
  <div class="sol-watermark" aria-hidden="true" style="-webkit-mask-image:url('<?php echo esc_url( $ffp_logo ); ?>');mask-image:url('<?php echo esc_url( $ffp_logo ); ?>')"></div>
<?php
endif;

if ( $ffp_slug ) {
	get_template_part( 'template-parts/single', 'solution', [
		'solution' => ffp_get_solution( $ffp_slug ),
	] );
	get_footer();
	return;
}

$ffp_solutions = ffp_solutions();
$ffp_total     = count( $ffp_solutions );
?>

<div class="page-hero solutions-hero sol-layer">
  <div class="page-hero-inner">
    <p class="eyebrow">Solutions</p>
    <h1 class="display-title">Guidance built around <em>your full financial life</em></h1>
    <p class="body-copy page-hero-copy">From retirement income to estate protection, we address every dimension of your financial world — independently, comprehensively, and always with your goals at the center.</p>
  </div>
</div>

<div class="sol-viewer sol-layer" id="solViewer">
  <div class="sol-viewer-track" id="solViewerTrack">
    <?php $i = 0; foreach ( $ffp_solutions as $slug => $sol ) : $i++;
      $img = ffp_image_url( 'solutions/' . $slug );
      ?>
      <article class="sol-panel">
        <div class="sol-panel-img" <?php echo $img ? 'style="background-image:url(\'' . esc_url( $img ) . '\')"' : ''; ?>>
          <span class="sol-panel-num"><?php echo esc_html( sprintf( '%02d', $i ) ); ?></span>
        </div>
        <div class="sol-panel-body">
          <p class="eyebrow">Solution <?php echo esc_html( sprintf( '%02d', $i ) ); ?> — of <?php echo esc_html( sprintf( '%02d', $ffp_total ) ); ?></p>
          <h2 class="sol-panel-title"><?php echo esc_html( $sol['title'] ); ?></h2>
          <p class="body-copy sol-panel-copy"><?php echo esc_html( $sol['copy'][0] ); ?></p>
          <p class="sol-topics"><?php echo esc_html( implode( '  ·  ', $sol['topics'] ) ); ?></p>
          <a class="btn btn-green sol-panel-link" href="<?php echo esc_url( ffp_solution_url( $slug ) ); ?>">Explore This Solution</a>
        </div>
      </article>
    <?php endforeach; ?>
  </div>

  <div class="sol-viewer-nav" aria-hidden="false">
    <button class="sol-viewer-arrow" id="solPrev" type="button" aria-label="Previous solution">←</button>
    <span class="sol-viewer-count" id="solViewerCount">01 / <?php echo esc_html( sprintf( '%02d', $ffp_total ) ); ?></span>
    <button class="sol-viewer-arrow" id="solNext" type="button" aria-label="Next solution">→</button>
  </div>
</div>

<div class="section sol-layer sol-index-cta-wrap">
  <div class="section-inner" style="text-align:center">
    <p class="body-copy reveal" style="margin-bottom:1.2rem">Not sure where to start? A 15-minute call is all it takes.</p>
    <a class="btn btn-green reveal d1" href="<?php echo esc_url( ffp_url( 'contact' ) ); ?>">Schedule a Free Introduction</a>
  </div>
</div>

<?php get_footer(); ?>
