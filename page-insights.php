<?php
/**
 * Insights — editorial feed at /insights/, single article at
 * /insights/{slug}/ (static library entry or `insight` post; the slug
 * is validated in inc/routing.php, so unknown slugs 404 before this
 * template runs).
 */

$ffp_slug = get_query_var( 'ffp_slug' );

get_header();

if ( $ffp_slug ) :
	$item = ffp_get_item( $ffp_slug );

	if ( ffp_item_is_routable( $item ) ) {
		get_template_part( 'template-parts/single', 'item', [
			'item'    => $item,
			'context' => 'insights',
		] );
	} else {
		get_template_part( 'template-parts/single', 'post', [
			'post' => ffp_get_insight_post( $ffp_slug ),
		] );
	}

else :
	$feed     = ffp_get_insights();
	$featured = array_shift( $feed );

	// Topical thumbnail for a feed entry, keyed off its tag label.
	// Dedicated images (assets/img/insights/tags/) so nothing on the
	// site repeats a photo used elsewhere.
	$ffp_tag_img = function ( $tag ) {
		$map = [
			'Investing'  => 'insights/tags/investing',
			'Retirement' => 'insights/tags/retirement',
			'Tax'        => 'insights/tags/tax',
			'Planning'   => 'insights/tags/planning',
			'Debt'       => 'insights/tags/debt',
		];
		return ffp_image_url( $map[ $tag ] ?? 'insights/tags/planning' );
	};

	$hero_img = ffp_image_url( 'heroes/insights' );
	?>

	<div class="page-hero page-hero-dark insights-hero<?php echo $hero_img ? ' page-hero-img' : ' tree-watermark'; ?>"<?php echo $hero_img ? ' style="--hero-img:url(\'' . esc_url( $hero_img ) . '\')"' : ''; ?>>
	  <div class="page-hero-inner">
	    <p class="eyebrow">Insights</p>
	    <h1 class="display-title">Financial know-how, <em>simplified</em></h1>
	    <p class="body-copy page-hero-copy">We break down complex financial topics — investing, retirement, planning — into clear, actionable ideas you can actually use.</p>
	  </div>
	</div>

	<div class="section">
	  <div class="section-inner">

	    <?php if ( $featured ) : $fimg = $ffp_tag_img( $featured['tag'] ); ?>
	      <article class="insight-feature reveal">
	        <div class="insight-feature-main">
	          <p class="feed-tag"><?php echo esc_html( $featured['tag'] ); ?> · Latest</p>
	          <h2 class="insight-feature-title">
	            <a href="<?php echo esc_url( ffp_insight_url( $featured['slug'] ) ); ?>"><?php echo esc_html( $featured['title'] ); ?></a>
	          </h2>
	          <p class="insight-feature-dek"><?php echo esc_html( $featured['dek'] ); ?></p>
	          <p class="feed-meta">
	            <?php echo esc_html( $featured['author'] . ' · ' . $featured['date'] . ( $featured['read_time'] ? ' · ' . $featured['read_time'] : '' ) ); ?>
	            <a class="feed-read" href="<?php echo esc_url( ffp_insight_url( $featured['slug'] ) ); ?>">Read the article →</a>
	          </p>
	        </div>
	        <?php if ( $fimg ) : ?>
	          <a class="insight-feature-img" href="<?php echo esc_url( ffp_insight_url( $featured['slug'] ) ); ?>" style="background-image:url('<?php echo esc_url( $fimg ); ?>')" aria-hidden="true" tabindex="-1"></a>
	        <?php endif; ?>
	      </article>
	    <?php endif; ?>

	    <div class="insight-feed">
	      <?php foreach ( $feed as $i => $entry ) : $timg = $ffp_tag_img( $entry['tag'] ); ?>
	        <a class="insight-row reveal<?php echo ' d' . min( 3, $i % 3 + 1 ); ?>" href="<?php echo esc_url( ffp_insight_url( $entry['slug'] ) ); ?>">
	          <?php if ( $timg ) : ?>
	            <span class="insight-row-img" style="background-image:url('<?php echo esc_url( $timg ); ?>')"></span>
	          <?php endif; ?>
	          <div class="insight-row-main">
	            <p class="insight-row-meta"><span class="feed-tag"><?php echo esc_html( $entry['tag'] ); ?></span> <span class="feed-date"><?php echo esc_html( $entry['date'] ); ?></span></p>
	            <h3><?php echo esc_html( $entry['title'] ); ?></h3>
	            <p><?php echo esc_html( $entry['dek'] ); ?></p>
	            <span class="feed-meta"><?php echo esc_html( $entry['author'] . ( $entry['read_time'] ? ' · ' . $entry['read_time'] : '' ) ); ?></span>
	          </div>
	          <span class="insight-row-arrow" aria-hidden="true">→</span>
	        </a>
	      <?php endforeach; ?>
	    </div>

	  </div>
	</div>

	<div class="newsletter-band">
	  <div class="newsletter-band-inner">
	    <div>
	      <p class="eyebrow reveal">Newsletter</p>
	      <h2 class="newsletter-title reveal d1">Stay informed — join our newsletter</h2>
	      <p class="body-copy reveal d2">Financial tips for life's biggest questions. Helpful guidance and updates from our team — no noise, just value.</p>
	    </div>
	    <a class="btn btn-green reveal d2" href="<?php echo esc_url( ffp_url( 'contact' ) ); ?>">Subscribe</a>
	  </div>
	</div>

<?php
endif;

get_footer();
