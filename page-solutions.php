<?php
/**
 * Solutions — numbered index at /solutions/, full solution pages at
 * /solutions/{slug}/ (validated in inc/routing.php). Content lives in
 * data/solutions.php.
 *
 * The og tree logo renders fixed behind both the index and the
 * individual pages as a one-color (sage) mask watermark.
 * (logo-tree.png stays in assets/img as an unused spare.)
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
?>

<div class="page-hero solutions-hero">
  <div class="page-hero-inner">
    <p class="eyebrow">Solutions</p>
    <h1 class="display-title">Guidance built around <em>your full financial life</em></h1>
    <p class="body-copy page-hero-copy">From retirement income to estate protection, we address every dimension of your financial world — independently, comprehensively, and always with your goals at the center.</p>
  </div>
</div>

<div class="section sol-layer">
  <div class="section-inner">
    <div class="sol-index">
      <?php $i = 0; foreach ( ffp_solutions() as $slug => $sol ) : $i++; ?>
        <a class="sol-index-row reveal d<?php echo esc_attr( ( $i - 1 ) % 3 + 1 ); ?>" href="<?php echo esc_url( ffp_solution_url( $slug ) ); ?>">
          <span class="sol-index-num"><?php echo esc_html( sprintf( '%02d', $i ) ); ?></span>
          <div class="sol-index-main">
            <h2><?php echo esc_html( $sol['title'] ); ?></h2>
            <p><?php echo esc_html( $sol['teaser'] ); ?></p>
          </div>
          <span class="res-index-arrow" aria-hidden="true">→</span>
        </a>
      <?php endforeach; ?>
    </div>

    <div class="sol-index-cta">
      <p class="body-copy reveal">Not sure where to start? A 15-minute call is all it takes.</p>
      <a class="btn btn-green reveal d1" href="<?php echo esc_url( ffp_url( 'contact' ) ); ?>">Schedule a Free Introduction</a>
    </div>
  </div>
</div>

<?php get_footer(); ?>
