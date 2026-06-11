<?php
/**
 * Single library item (article / calculator / video), server-rendered
 * with breadcrumbs, share toolbar, CTA, and related reading.
 *
 * Args:
 *   item     library item array (from ffp_get_item(), already validated)
 *   context  'resources' | 'insights' — controls breadcrumbs + share URL
 */

$item    = $args['item'];
$context = $args['context'] ?? 'resources';

$kind_labels = [ 'article' => 'Article', 'calculator' => 'Calculator', 'video' => 'Video' ];
$kind_label  = $kind_labels[ $item['kind'] ] ?? 'Article';

$category  = $item['category'] ? ffp_get_category( $item['category'] ) : null;
$cat_label = $category['label'] ?? ( $item['insight_tag'] ?? '' );

if ( 'insights' === $context ) {
	$share_url = ffp_insight_url( $item['slug'] );
	$crumbs    = [
		[ 'label' => 'Insights', 'url' => ffp_url( 'insights' ) ],
		[ 'label' => $cat_label ?: 'Article' ],
	];
	$kind_line = 'Insight' . ( $cat_label ? ' · ' . $cat_label : '' );
} else {
	$share_url = ffp_resource_url( $item );
	$crumbs    = [ [ 'label' => 'Resources', 'url' => ffp_url( 'resources' ) ] ];
	if ( $category ) {
		$crumbs[] = [ 'label' => $category['label'], 'url' => ffp_category_url( $item['category'] ) ];
	}
	$crumbs[]  = [ 'label' => $kind_label ];
	$kind_line = $kind_label . ( $cat_label ? ' · ' . $cat_label : '' );
}

// Related reading: other full articles from the same category.
$related = [];
if ( 'resources' === $context && $item['category'] ) {
	foreach ( ffp_get_items( $item['category'], 'article' ) as $candidate ) {
		if ( $candidate['slug'] !== $item['slug'] && ffp_item_is_routable( $candidate ) ) {
			$related[] = $candidate;
		}
		if ( count( $related ) >= 3 ) break;
	}
}
?>

<div class="section single-wrap">
  <div class="section-inner">
    <article class="single-article">
      <?php ffp_breadcrumbs( $crumbs ); ?>

      <div class="single-header">
        <p class="single-kind"><?php echo esc_html( $kind_line ); ?></p>
        <h1 class="single-title"><?php echo esc_html( $item['title'] ); ?></h1>
        <?php if ( ! empty( $item['author'] ) ) : ?>
          <p class="single-meta">By <?php echo esc_html( $item['author'] ); ?> · <?php echo esc_html( $item['date'] ?? '' ); ?><?php echo ! empty( $item['read_time'] ) ? ' · ' . esc_html( $item['read_time'] ) : ''; ?></p>
        <?php endif; ?>
        <?php if ( ! empty( $item['excerpt'] ) ) : ?>
          <p class="single-dek"><?php echo esc_html( $item['excerpt'] ); ?></p>
        <?php endif; ?>
      </div>

      <div class="single-body"><?php echo wp_kses_post( $item['body'] ); ?></div>

      <?php ffp_share_buttons( $share_url, $item['title'], $kind_label ); ?>

      <div class="single-cta">
        <h3>Have a question on this topic?</h3>
        <p>Reach out and we'll help you think through how this applies to your specific situation.</p>
        <a class="btn btn-green" href="<?php echo esc_url( ffp_url( 'contact' ) ); ?>">Schedule a Conversation</a>
      </div>

      <?php if ( $related ) : ?>
        <div class="single-related">
          <h4 class="single-related-heading">More from <?php echo esc_html( $cat_label ); ?></h4>
          <div class="single-related-grid">
            <?php foreach ( $related as $rel ) : ?>
              <a class="related-card" href="<?php echo esc_url( ffp_resource_url( $rel ) ); ?>">
                <div class="related-kind"><?php echo esc_html( $cat_label ); ?> · Article</div>
                <div class="related-title"><?php echo esc_html( $rel['title'] ); ?></div>
                <div class="related-meta"><?php echo esc_html( ( $rel['author'] ?? '' ) . ( ! empty( $rel['date'] ) ? ' · ' . $rel['date'] : '' ) ); ?></div>
              </a>
            <?php endforeach; ?>
          </div>
        </div>
      <?php endif; ?>
    </article>
  </div>
</div>
