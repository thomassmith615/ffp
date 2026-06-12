<?php
/**
 * Individual team member bio — /about/{slug}/
 *
 * Args:
 *   member  team member array (from ffp_get_team_member(), validated upstream)
 */

$member = $args['member'];
$photo  = ffp_image_url( 'team/' . $member['slug'] );
?>

<div class="section single-wrap">
  <div class="section-inner">
    <article class="single-article member-article">
      <?php ffp_breadcrumbs( [
        [ 'label' => 'About', 'url' => ffp_url( 'about' ) ],
        [ 'label' => 'Team' ],
        [ 'label' => $member['name'] ],
      ] ); ?>

      <div class="member-header">
        <div class="member-photo">
          <?php if ( $photo ) : ?>
            <img src="<?php echo esc_url( $photo ); ?>" alt="<?php echo esc_attr( $member['name'] ); ?>" />
          <?php else : ?>
            <div class="team-photo-placeholder"><div class="initials"><?php echo esc_html( $member['initials'] ); ?></div><div class="ph-label">Add Photo</div></div>
          <?php endif; ?>
        </div>
        <div class="member-header-text">
          <p class="single-kind"><?php echo esc_html( $member['role'] ); ?></p>
          <h1 class="single-title member-name"><?php echo esc_html( $member['name'] ); ?></h1>
          <div class="member-contact">
            <?php if ( ! empty( $member['phone'] ) ) : ?>
              <a href="tel:<?php echo esc_attr( $member['phone'] ); ?>"><?php echo esc_html( $member['phone_label'] ); ?></a>
            <?php endif; ?>
            <?php if ( ! empty( $member['email'] ) ) : ?>
              <a href="mailto:<?php echo esc_attr( $member['email'] ); ?>"><?php echo esc_html( $member['email'] ); ?></a>
            <?php endif; ?>
          </div>
        </div>
      </div>

      <?php if ( ! empty( $member['intro'] ) ) : ?>
        <div class="member-intro"><?php echo wp_kses_post( $member['intro'] ); ?></div>
      <?php endif; ?>

      <div class="single-body"><?php echo wp_kses_post( $member['bio'] ); ?></div>

      <div class="single-cta">
        <h3>Start a conversation</h3>
        <p>Schedule a no-pressure introductory call and take the first step toward financial clarity.</p>
        <a class="btn btn-green" href="<?php echo esc_url( ffp_url( 'contact' ) ); ?>">Schedule a Meeting</a>
      </div>

      <div class="member-back">
        <a class="view-all-link" href="<?php echo esc_url( ffp_url( 'about' ) ); ?>">← Meet the Whole Team</a>
      </div>
    </article>
  </div>
</div>
