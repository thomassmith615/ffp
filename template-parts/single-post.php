<?php
/**
 * Single `insight` post (created in WP admin), rendered in the same
 * article shell as library content.
 *
 * Args:
 *   post  WP_Post (already validated by inc/routing.php)
 */

$post = $args['post'];
setup_postdata( $post );

$terms     = wp_get_post_terms( $post->ID, 'insight_category', [ 'fields' => 'names' ] );
$tag       = ! is_wp_error( $terms ) && $terms ? $terms[0] : 'General';
$share_url = ffp_insight_url( $post->post_name );
?>

<div class="section single-wrap">
  <div class="section-inner">
    <article class="single-article">
      <?php ffp_breadcrumbs( [
        [ 'label' => 'Insights', 'url' => ffp_url( 'insights' ) ],
        [ 'label' => $tag ],
      ] ); ?>

      <div class="single-header">
        <p class="single-kind">Insight · <?php echo esc_html( $tag ); ?></p>
        <h1 class="single-title"><?php echo esc_html( get_the_title( $post ) ); ?></h1>
        <p class="single-meta">By <?php echo esc_html( get_the_author_meta( 'display_name', $post->post_author ) ); ?> · <?php echo esc_html( get_the_date( 'M j, Y', $post ) ); ?></p>
        <?php if ( has_excerpt( $post ) ) : ?>
          <p class="single-dek"><?php echo esc_html( get_the_excerpt( $post ) ); ?></p>
        <?php endif; ?>
      </div>

      <div class="single-body"><?php echo apply_filters( 'the_content', $post->post_content ); ?></div>

      <?php ffp_share_buttons( $share_url, get_the_title( $post ), 'article' ); ?>

      <div class="single-cta">
        <h3>Want to talk through this?</h3>
        <p>Reach out and we'll help you think through how this applies to your situation.</p>
        <a class="btn btn-green" href="<?php echo esc_url( ffp_url( 'contact' ) ); ?>">Schedule a Conversation</a>
      </div>
    </article>
  </div>
</div>

<?php wp_reset_postdata(); ?>
