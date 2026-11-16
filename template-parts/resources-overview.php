<?php
/**
 * Resources overview — an editorial table of contents instead of the
 * old tile grid: one generous row per category with description,
 * item counts, and a hairline divider.
 */
?>

<div class="page-hero resources-hero">
  <div class="page-hero-inner">
    <p class="eyebrow">Resources</p>
    <h1 class="display-title">Tools to <em>empower</em> you</h1>
    <p class="body-copy page-hero-copy">A curated collection of calculators, educational articles, and tools to help you better understand and manage every dimension of your financial life.</p>
  </div>
</div>

<div class="section">
  <div class="section-inner">

    <div class="res-index">
      <?php $i = 0; foreach ( ffp_categories() as $slug => $cat ) : $i++;
        $photo = ffp_image_url( 'cats/' . $slug );
        ?>
        <a class="res-index-row<?php echo $photo ? ' has-photo' : ''; ?> reveal" href="<?php echo esc_url( ffp_category_url( $slug ) ); ?>">
          <?php if ( $photo ) : ?>
            <span class="res-index-img" style="background-image:url('<?php echo esc_url( $photo ); ?>')"></span>
          <?php else : ?>
            <span class="res-index-num"><?php echo esc_html( sprintf( '%02d', $i ) ); ?></span>
          <?php endif; ?>
          <div class="res-index-main">
            <p class="res-index-kicker"><?php echo esc_html( sprintf( '%02d', $i ) ); ?></p>
            <h2><?php echo esc_html( $cat['label'] ); ?></h2>
            <p><?php echo esc_html( $cat['summary'] ); ?></p>
          </div>
          <span class="res-index-count"><?php echo esc_html( ffp_category_count_label( $slug ) ); ?></span>
          <span class="res-index-arrow" aria-hidden="true">→</span>
        </a>
      <?php endforeach; ?>
    </div>

    <div class="res-quick">
      <?php if ( FFP_SHOW_CALCULATORS ) : ?>
        <a class="res-quick-row reveal" href="<?php echo esc_url( ffp_url( 'resources/calculators' ) ); ?>">
          <div>
            <h3>All Calculators</h3>
            <p>Every interactive calculator we offer, organized by category.</p>
          </div>
          <span class="res-index-arrow" aria-hidden="true">→</span>
        </a>
      <?php endif; ?>
      <a class="res-quick-row reveal d1" href="<?php echo esc_url( ffp_url( 'resources/videos' ) ); ?>">
        <div>
          <h3>All Videos</h3>
          <p>Short, informative videos from our team covering key financial topics at a glance.</p>
        </div>
        <span class="res-index-arrow" aria-hidden="true">→</span>
      </a>
      <a class="res-quick-row reveal d2" href="https://brokercheck.finra.org/" target="_blank" rel="noopener">
        <div>
          <h3>FINRA BrokerCheck <span class="ext-mark">↗</span></h3>
          <p>Verify the background and credentials of your financial professional through FINRA's official portal.</p>
        </div>
        <span class="res-index-arrow" aria-hidden="true">→</span>
      </a>
    </div>

  </div>
</div>
