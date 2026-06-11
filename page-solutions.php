<?php
/**
 * Solutions page.
 *
 * The old boxed slider is replaced by an editorial flow: a sticky
 * anchor sub-nav and six full-width alternating sections, each with an
 * oversized number watermark. Every solution is individually linkable
 * via its anchor (e.g. /solutions/#retirement-income).
 */

$ffp_solutions = [
	[
		'id'     => 'financial-planning',
		'title'  => 'Financial Planning',
		'copy'   => "A comprehensive financial plan isn't just a document — it's a living strategy built around your specific goals, timeline, and risk tolerance. We create clear roadmaps with built-in accountability systems, so progress is measurable and adjustments happen proactively. Whether you're early in your career, mid-life, or approaching a major transition, we provide the structure and guidance you need.",
		'topics' => [ 'Goal Setting', 'Cash Flow', 'Net Worth', 'Accountability' ],
	],
	[
		'id'     => 'investment-management',
		'title'  => 'Investment Management',
		'copy'   => "We build and manage diversified investment portfolios aligned with your long-term philosophy, not short-term noise. Rather than chasing performance or moving money constantly, we focus on disciplined, evidence-based strategies that let compounding do the work. We'll help you understand your true risk tolerance and design an allocation you can stay committed to through market cycles.",
		'topics' => [ 'Portfolios', 'Risk Analysis', 'Diversification', 'Rebalancing' ],
	],
	[
		'id'     => 'business-succession',
		'title'  => 'Business Succession',
		'copy'   => "Business owners face a unique set of financial challenges — and opportunities. We help you build personal wealth while running your business, design compensation and benefits structures that make tax sense, and plan a succession strategy well before you need it. Whether you're transitioning to family, partners, or a third-party buyer, we'll make sure you're financially prepared.",
		'topics' => [ 'Exit Planning', 'Buy-Sell', 'Key Person', 'Business Valuation' ],
	],
	[
		'id'     => 'estate-insurance',
		'title'  => 'Estate &amp; Insurance',
		'copy'   => "Your estate plan is more than a will — it's a comprehensive strategy for passing wealth, minimizing taxes, and protecting the people you love. We coordinate with estate attorneys and CPAs to ensure your financial plan and legal documents align. On the insurance side, we analyze your existing coverage and identify gaps across life, disability, long-term care, and liability.",
		'topics' => [ 'Wills & Trusts', 'Life Insurance', 'LTC', 'Disability' ],
	],
	[
		'id'     => 'retirement-income',
		'title'  => 'Retirement Income Planning',
		'copy'   => "Accumulating assets is only half the challenge — converting them into sustainable income is where the real planning begins. We design retirement income strategies that coordinate Social Security, pension distributions, IRA withdrawals, and investment income. We model different scenarios so you can see exactly how your plan holds up through market downturns, inflation, and healthcare costs.",
		'topics' => [ 'Social Security', 'RMDs', 'Roth Conversion', 'Income Ladders' ],
	],
	[
		'id'     => '401k-plan-services',
		'title'  => '401(k) Plan Services — RPk',
		'copy'   => "Through Retirement Plan (k)onsultant (RPk), Walt Eife provides specialized, high-quality 401(k) plan management for businesses. RPk's exclusive focus means deep expertise — from plan design and investment selection to participant education and fiduciary oversight. Simple, supportive, and cost-effective, with your employees' retirements as the priority.",
		'topics' => [ 'Plan Design', 'ERISA', 'Employee Ed.', 'Fiduciary' ],
	],
];

get_header();
?>

<div class="page-hero solutions-hero">
  <div class="page-hero-inner">
    <p class="eyebrow">Solutions</p>
    <h1 class="display-title">Guidance built around <em>your full financial life</em></h1>
    <p class="body-copy page-hero-copy">From retirement income to estate protection, we address every dimension of your financial world — independently, comprehensively, and always with your goals at the center.</p>
  </div>
</div>

<nav class="sol-subnav" id="solSubnav" aria-label="Solutions">
  <div class="sol-subnav-inner">
    <?php foreach ( $ffp_solutions as $i => $sol ) : ?>
      <a href="#<?php echo esc_attr( $sol['id'] ); ?>" data-section="<?php echo esc_attr( $sol['id'] ); ?>">
        <span class="sol-subnav-num"><?php echo esc_html( sprintf( '%02d', $i + 1 ) ); ?></span>
        <?php echo wp_kses_post( $sol['title'] ); ?>
      </a>
    <?php endforeach; ?>
  </div>
</nav>

<?php foreach ( $ffp_solutions as $i => $sol ) : ?>
  <section class="sol-section" id="<?php echo esc_attr( $sol['id'] ); ?>">
    <div class="sol-section-inner">
      <div class="sol-section-meta">
        <span class="sol-section-num reveal"><?php echo esc_html( sprintf( '%02d', $i + 1 ) ); ?></span>
      </div>
      <div class="sol-section-body">
        <p class="eyebrow reveal">Solution <?php echo esc_html( sprintf( '%02d', $i + 1 ) ); ?> — of 06</p>
        <h2 class="sol-section-title reveal d1"><?php echo wp_kses_post( $sol['title'] ); ?></h2>
        <p class="body-copy reveal d2"><?php echo esc_html( $sol['copy'] ); ?></p>
        <p class="sol-topics reveal d3">
          <?php echo esc_html( implode( '  ·  ', $sol['topics'] ) ); ?>
        </p>
      </div>
    </div>
  </section>
<?php endforeach; ?>

<div class="section sol-closing">
  <div class="section-inner" style="text-align:center">
    <p class="body-copy reveal" style="margin-bottom:1.2rem">Not sure where to start? A 15-minute call is all it takes.</p>
    <a class="btn btn-green reveal d1" href="<?php echo esc_url( ffp_url( 'contact' ) ); ?>">Schedule a Free Introduction</a>
  </div>
</div>

<?php get_footer(); ?>
