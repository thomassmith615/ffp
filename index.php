<?php
/**
 * Generic fallback template (WordPress requires index.php).
 * Every real view has a dedicated template: front-page.php,
 * page-{slug}.php, 404.php. This renders whatever the loop holds.
 */

get_header();
?>

<div class="section single-wrap">
  <div class="section-inner">
    <?php if ( have_posts() ) : ?>
      <?php while ( have_posts() ) : the_post(); ?>
        <article <?php post_class( 'single-article' ); ?>>
          <div class="single-header">
            <h1 class="single-title"><?php the_title(); ?></h1>
          </div>
          <div class="single-body"><?php the_content(); ?></div>
        </article>
      <?php endwhile; ?>
    <?php else : ?>
      <div class="single-not-found">
        <p class="eyebrow">Nothing here</p>
        <h1 class="display-title">No content found.</h1>
        <p class="body-copy"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Return home</a></p>
      </div>
    <?php endif; ?>
  </div>
</div>

<?php get_footer(); ?>
