<?php
/**
 * Front page — hero video, promise strip, services preview,
 * why-us pillars, testimonials, CTA banner.
 */

get_header();
?>

<section id="hero">
  <div class="hero-bg">
    <!--
      Video sized via .hero-bg video CSS (object-fit: cover, centered).
      If the video fails to load, the gradient background underneath
      shows through. Replace src with a self-hosted file for production.
    -->
    <video id="heroVideo" autoplay muted loop playsinline preload="auto">
      <source src="https://www.pexels.com/download/video/3209829/" type="video/mp4">
    </video>
  </div>
  <div class="hero-overlay"></div>
  <div class="hero-content">
    <p class="hero-eyebrow">South Jersey's Trusted Financial Partner</p>
    <h1 class="hero-title">Your Wealth.<br><em>Your Legacy.</em><br>Our Purpose.</h1>
    <p class="hero-sub">Helping individuals, families, and business owners make conscious, deliberate financial decisions — not leaving things to chance.</p>
    <div class="hero-actions">
      <a class="btn btn-green" href="<?php echo esc_url( ffp_url( 'contact' ) ); ?>">Schedule a Consultation</a>
      <a class="btn btn-outline-light" href="<?php echo esc_url( ffp_url( 'solutions' ) ); ?>">Explore Our Solutions</a>
    </div>
  </div>
  <div class="hero-scroll-hint" data-scroll-to="home-purpose">
    <div class="scroll-line"></div>
    <span>Scroll</span>
  </div>
</section>

<!-- Purpose -->
<div class="section purpose-strip" id="home-purpose">
  <div class="section-inner">
    <p class="eyebrow reveal">Our Promise</p>
    <h2 class="display-title reveal d1" style="color:var(--white)">Caring for <em style="color:var(--tan)">people</em><br>comes first</h2>
    <p class="body-copy reveal d2" style="color:rgba(255,255,255,0.6); max-width:480px">Our founder made a promise before entering financial services: help people first, make money second. That commitment shapes every recommendation we make and every relationship we build.</p>
    <a class="btn btn-outline-light reveal d3" style="margin-top:1.8rem" href="<?php echo esc_url( ffp_url( 'about' ) ); ?>">Meet the Team</a>
  </div>
  <blockquote class="purpose-quote reveal d2">"Help people first,<br>make money second."</blockquote>
</div>

<!-- Services Preview -->
<div class="section" style="background:var(--bg-off)">
  <div class="section-inner">
    <p class="eyebrow reveal">What We Do</p>
    <h2 class="display-title reveal d1">Solutions built around <em>your life</em></h2>
    <p class="body-copy reveal d2" style="max-width:520px">From retirement income to estate protection, our guidance spans the full spectrum of your financial life — always personalized, always independent.</p>
    <?php
    // Numbering and anchors mirror the six sections on /solutions/.
    $ffp_services = [
      [ 'financial-planning',    'Financial Planning',      'Goal-driven strategy with built-in accountability. A comprehensive roadmap tailored to where you are and where you want to go.' ],
      [ 'investment-management', 'Investment Management',   'Long-term, disciplined investment philosophy built around your risk tolerance and time horizon — not short-term speculation.' ],
      [ 'business-succession',   'Business Succession',     "Whether you're building or preparing to transition, we help business owners create wealth strategies and exit plans with confidence." ],
      [ 'estate-insurance',      'Estate & Insurance',      'Coordinate insurance and estate planning to protect what matters most and preserve your legacy for the people you care about.' ],
      [ 'retirement-income',     'Retirement Income',       "Turn savings into sustainable, predictable income. We design plans that let you live the life you've worked toward — on your terms." ],
      [ '401k-plan-services',    '401(k) Plan Services',    'Specialized 401(k) solutions through RPk — high-quality, cost-effective retirement plan management for businesses of all sizes.' ],
    ];
    ?>
    <div class="svc-index">
      <?php foreach ( $ffp_services as $i => $svc ) :
        // Photo slot: drop assets/img/home/{anchor}.jpg to replace the tile.
        $thumb = ffp_image_url( 'home/' . $svc[0] );
        ?>
        <a class="svc-row reveal<?php echo ' d' . min( 3, $i % 3 + 1 ); ?>" href="<?php echo esc_url( ffp_url( 'solutions' ) . '#' . $svc[0] ); ?>">
          <?php if ( $thumb ) : ?>
            <span class="svc-thumb svc-thumb-photo" style="background-image:url('<?php echo esc_url( $thumb ); ?>')"></span>
          <?php else : ?>
            <span class="svc-thumb svc-thumb-<?php echo esc_attr( chr( 97 + ( $i % 3 ) ) ); ?>"><?php echo esc_html( sprintf( '%02d', $i + 1 ) ); ?></span>
          <?php endif; ?>
          <div class="svc-main">
            <p class="svc-kicker"><?php echo esc_html( sprintf( '%02d', $i + 1 ) ); ?> — Solution</p>
            <h3><?php echo esc_html( $svc[1] ); ?></h3>
            <p><?php echo esc_html( $svc[2] ); ?></p>
          </div>
          <span class="svc-arrow" aria-hidden="true">→</span>
        </a>
      <?php endforeach; ?>
    </div>
    <div style="text-align:center;margin-top:2.5rem">
      <a class="btn btn-green reveal d3" href="<?php echo esc_url( ffp_url( 'solutions' ) ); ?>">View All Solutions</a>
    </div>
  </div>
</div>

<!-- Why us -->
<div class="section">
  <div class="section-inner">
    <div class="why-grid">
      <div class="why-visual">
        <?php $why_img = ffp_image_url( 'home/why' ); // drop assets/img/home/why.jpg for a real photo ?>
        <div class="why-visual-inner"<?php echo $why_img ? ' style="background-image:url(\'' . esc_url( $why_img ) . '\');background-size:cover;background-position:center"' : ''; ?>></div>
        <div class="why-stat">
          <div class="s-num">25+</div>
          <div class="s-label">Years Experience</div>
        </div>
        <div class="why-stat">
          <div class="s-num">100%</div>
          <div class="s-label">Client-First Fiduciary</div>
        </div>
      </div>
      <div>
        <p class="eyebrow reveal">Why Fortune Financial</p>
        <h2 class="display-title reveal d1">An honest,<br><em>independent</em> approach</h2>
        <p class="body-copy reveal d2">We don't sell products. We build relationships. Our advice is independent, personalized, and grounded in a fiduciary commitment to always act in your best interest.</p>
        <div class="pillar-list">
          <div class="pillar reveal d1">
            <div class="pillar-num">01</div>
            <div><h4>Fiduciary Standard</h4><p>Legally and ethically bound to act in your best interest — not ours, not a firm's, not a product's.</p></div>
          </div>
          <div class="pillar reveal d2">
            <div class="pillar-num">02</div>
            <div><h4>Education-First</h4><p>We help you understand your finances so you can make confident, informed decisions at every stage.</p></div>
          </div>
          <div class="pillar reveal d3">
            <div class="pillar-num">03</div>
            <div><h4>Accountability Systems</h4><p>Regular check-ins, structured follow-through, and measurable progress toward the goals that matter most.</p></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Testimonials -->
<div class="section" style="background:var(--bg-off); padding-bottom:1rem">
  <div class="section-inner">
    <p class="eyebrow reveal" style="text-align:center">Client Stories</p>
    <h2 class="display-title reveal d1" style="text-align:center">In Their <em>Words</em></h2>
  </div>
  <div class="testi-track">
    <div class="testi-card">
      <div class="testi-stars">★★★★★</div>
      <blockquote>"At 50, I've worked with fifteen different financial advisors. Stephen stands head and shoulders above the rest — his calm confidence and remarkable sense of humor make an otherwise stressful subject approachable."</blockquote>
      <div class="testi-name">Lisa Flanagan</div>
      <div class="testi-sub">Current Client</div>
    </div>
    <div class="testi-card">
      <div class="testi-stars">★★★★★</div>
      <blockquote>"Stephen meets his clients at their level of financial literacy and helps them get comfortable preparing for retirement. My confidence in planning for my future has grown enormously."</blockquote>
      <div class="testi-name">Iris Lapsley</div>
      <div class="testi-sub">Current Client</div>
    </div>
    <div class="testi-card">
      <div class="testi-stars">★★★★★</div>
      <blockquote>"Adulting is so hard — Stephen has made it easy. You won't find a better or more reliable advisor. He treats his clients like family and goes out of his way for the people in his life."</blockquote>
      <div class="testi-name">Rachel Stewart</div>
      <div class="testi-sub">Current Client</div>
    </div>
    <div class="testi-card">
      <div class="testi-stars">★★★★★</div>
      <blockquote>"Kevin has the best interest of the client in mind at all times. He delicately and truthfully navigates planning even when emotions might cloud decision-making."</blockquote>
      <div class="testi-name">Fortune Financial Client</div>
      <div class="testi-sub">Current Client</div>
    </div>
    <div class="testi-card">
      <div class="testi-stars">★★★★★</div>
      <blockquote>"The whole team gives thoughtful and thorough guidance. They've worked with me through two retirements, a cross-country move, and numerous tax situations. Always consider the full picture."</blockquote>
      <div class="testi-name">Fortune Financial Client</div>
      <div class="testi-sub">Long-Term Client</div>
    </div>
  </div>
  <p class="testi-disclaimer">Testimonials provided by current clients. No compensation was provided. Results may vary.</p>
</div>

<!-- CTA Banner -->
<div class="cta-banner">
  <h2 class="reveal">Financial clarity is closer than you think</h2>
  <p class="reveal d1">Schedule a no-pressure 15-minute introductory call and take the first step.</p>
  <a class="btn btn-white reveal d2" href="<?php echo esc_url( ffp_url( 'contact' ) ); ?>">Schedule a Consultation</a>
</div>

<?php get_footer(); ?>
