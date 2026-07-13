<?php
/**
 * Resource category view — /resources/{category}/[{tab}]
 *
 * Header + feature blurb, a pill nav across categories, understated
 * tab links (each tab is its own URL), and the hairline item list.
 *
 * Args:
 *   category  category slug (validated upstream)
 *   tab       'articles' | 'calculators' | 'videos'
 */

$category = $args['category'];
$tab      = $args['tab'];
$cat      = ffp_get_category( $category );
$counts   = ffp_category_counts( $category );

$tabs = [
	'articles'    => [ 'Articles', $counts['article'] ],
	'calculators' => [ 'Calculators', $counts['calculator'] ],
	'videos'      => [ 'Videos', $counts['video'] ],
];
$kind_for_tab = [ 'articles' => 'article', 'calculators' => 'calculator', 'videos' => 'video' ];
?>

<div class="page-hero resources-hero res-cat-hero">
  <div class="page-hero-inner">
    <?php ffp_breadcrumbs( [
      [ 'label' => 'Resources', 'url' => ffp_url( 'resources' ) ],
      [ 'label' => $cat['label'] ],
    ] ); ?>
    <h1 class="display-title"><?php echo esc_html( $cat['label'] ); ?></h1>
    <p class="body-copy page-hero-copy"><?php echo esc_html( $cat['intro'] ); ?></p>
  </div>
</div>

<nav class="res-cats-nav" aria-label="Resource categories">
  <div class="res-cats-nav-inner">
    <?php foreach ( ffp_categories() as $slug => $other ) : ?>
      <a href="<?php echo esc_url( ffp_category_url( $slug ) ); ?>" class="<?php echo $slug === $category ? 'active' : ''; ?>"><?php echo esc_html( $other['label'] ); ?></a>
    <?php endforeach; ?>
    <a href="<?php echo esc_url( ffp_url( 'resources/calculators' ) ); ?>">All Calculators</a>
    <a href="<?php echo esc_url( ffp_url( 'resources/videos' ) ); ?>">All Videos</a>
  </div>
</nav>

<div class="section">
  <div class="section-inner res-cat-layout">

    <div class="res-cat-feature reveal">
      <div class="res-split-img"><div class="res-split-img-inner"><?php echo esc_html( $cat['initial'] ); ?></div></div>
      <div class="res-cat-feature-text">
        <h3><?php echo esc_html( $cat['blurb_title'] ); ?></h3>
        <p class="body-copy"><?php echo esc_html( $cat['blurb'] ); ?></p>
      </div>
    </div>

    <div class="res-cat-content">
      <nav class="cat-switch reveal" aria-label="Content type">
        <?php foreach ( $tabs as $tab_slug => $tab_info ) : ?>
          <a href="<?php echo esc_url( ffp_category_url( $category, $tab_slug ) ); ?>" class="<?php echo $tab === $tab_slug ? 'active' : ''; ?>">
            <?php echo esc_html( $tab_info[0] ); ?> <span class="cat-switch-count"><?php echo esc_html( $tab_info[1] ); ?></span>
          </a>
        <?php endforeach; ?>
      </nav>

      <div class="reveal d1">
        <?php ffp_resource_list( ffp_get_items( $category, $kind_for_tab[ $tab ] ), 'videos' === $tab ); ?>
      </div>

      <?php if ( 'calculators' === $tab ) : ?>
        <a class="view-all-link reveal d2" href="<?php echo esc_url( ffp_url( 'resources/calculators' ) ); ?>">View All Calculators →</a>
      <?php elseif ( 'videos' === $tab ) : ?>
        <a class="view-all-link reveal d2" href="<?php echo esc_url( ffp_url( 'resources/videos' ) ); ?>">View All Videos →</a>
      <?php endif; ?>

      <?php if ( ! empty( $cat['disclaimer'] ) ) : ?>
        <p class="res-disclaimer"><?php echo esc_html( $cat['disclaimer'] ); ?></p>
      <?php endif; ?>

      <div class="res-cat-cta">
        <p>Have a question about <?php echo esc_html( strtolower( $cat['label'] ) ); ?>?</p>
        <a class="btn btn-green" href="<?php echo esc_url( ffp_url( 'contact' ) ); ?>"><?php echo esc_html( $cat['cta'] ); ?></a>
      </div>
    </div>

  </div>
</div>
