<?php
/**
 * About — firm mission + team directory at /about/, individual bio
 * pages at /about/{slug}/ (validated in inc/routing.php).
 *
 * Mission copy and all bios are client-approved wording (data/team.php)
 * and must not be edited.
 */

$ffp_slug = get_query_var( 'ffp_slug' );

get_header();

if ( $ffp_slug ) {
	get_template_part( 'template-parts/single', 'member', [
		'member' => ffp_get_team_member( $ffp_slug ),
	] );
	get_footer();
	return;
}
?>

<div class="about-hero page-hero-dark">
  <div class="about-hero-inner">
    <div>
      <p class="eyebrow">About Us</p>
      <h1 class="display-title about-title">Beyond business.<br><em>Our purpose.</em></h1>
      <p class="body-copy">Our reasons for becoming financial professionals are deeply personal. We repeatedly saw friends and family struggling to find the help they needed. We're here to change that.</p>
    </div>
    <div class="about-hero-right">
      <div class="about-values">
        <div class="about-value"><div class="about-value-line"></div><span>Fiduciary &amp; Fee-Based</span></div>
        <div class="about-value"><div class="about-value-line"></div><span>LPL Financial — Member FINRA &amp; SIPC</span></div>
        <div class="about-value"><div class="about-value-line"></div><span>Serving NJ, PA, FL, GA, MA &amp; more</span></div>
        <div class="about-value"><div class="about-value-line"></div><span>Comprehensive, education-first planning</span></div>
        <div class="about-value"><div class="about-value-line"></div><span>Family-run · community-focused</span></div>
      </div>
    </div>
  </div>
</div>

<div class="section" style="background:var(--bg-off)">
  <div class="section-inner mission-block">
    <p class="eyebrow reveal">About Us</p>
    <h2 class="display-title reveal d1">"Help people first,<br><em>make money second."</em></h2>
    <p class="mission-attr reveal d1">— Joseph P. Gianfortune, founder's father</p>
    <p class="body-copy reveal d2">Our commitment to providing personalized service and fiduciary care begins with a promise our founder made to his father before entering the financial services industry. We serve as a resource for a wide range of financial questions and concerns throughout life's many stages.</p>
    <p class="body-copy reveal d3" style="margin-top:1rem">Our approach is straightforward and transparent, and our guidance is personalized to your unique circumstances. We use a structured process and accountability framework to help implement and monitor recommendations.</p>
    <a class="btn btn-green reveal d3" style="margin-top:1.8rem" href="<?php echo esc_url( ffp_url( 'contact' ) ); ?>">Schedule a Meeting</a>
  </div>
</div>

<div class="section">
  <div class="section-inner">
    <p class="eyebrow reveal">The Fortune Family</p>
    <h2 class="display-title reveal d1">People you can <em>count on</em></h2>
    <div class="team-grid">
      <?php $i = 0; foreach ( ffp_team() as $slug => $member ) : $i++;
        $photo = ffp_image_url( 'team/' . $slug ); // drop assets/img/team/{slug}.jpg
        $bio_url = ffp_member_url( $slug );
        ?>
        <div class="team-card reveal d<?php echo esc_attr( ( $i - 1 ) % 3 + 1 ); ?>">
          <a class="team-photo" href="<?php echo esc_url( $bio_url ); ?>">
            <?php if ( $photo ) : ?>
              <img src="<?php echo esc_url( $photo ); ?>" alt="<?php echo esc_attr( $member['name'] ); ?>" />
            <?php else : ?>
              <div class="team-photo-placeholder"><div class="initials"><?php echo esc_html( $member['initials'] ); ?></div><div class="ph-label">Add Photo</div></div>
            <?php endif; ?>
          </a>
          <div class="team-body">
            <div class="team-name"><a href="<?php echo esc_url( $bio_url ); ?>"><?php echo esc_html( $member['name'] ); ?></a></div>
            <div class="team-role"><?php echo esc_html( $member['role'] ); ?></div>
            <p class="team-bio"><?php echo esc_html( $member['teaser'] ); ?></p>
            <div class="team-links">
              <?php if ( ! empty( $member['phone'] ) ) : ?>
                <a class="team-link" href="tel:<?php echo esc_attr( $member['phone'] ); ?>"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.7 12.07 19.79 19.79 0 01.67 3.5 2 2 0 012.65 1.32h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L6.91 9a16 16 0 006.08 6.08l1.93-1.93a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 16.92z"/></svg><?php echo esc_html( $member['phone_label'] ); ?></a>
              <?php endif; ?>
              <?php if ( ! empty( $member['email'] ) ) : ?>
                <a class="team-link" href="mailto:<?php echo esc_attr( $member['email'] ); ?>"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg><?php echo esc_html( $member['email_label'] ); ?></a>
              <?php endif; ?>
              <a class="team-link team-link-bio" href="<?php echo esc_url( $bio_url ); ?>">Full Bio<span class="team-link-arrow">›</span></a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>

<?php get_footer(); ?>
