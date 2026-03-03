<div id="page-solutions" class="page-view">
  <div class="solutions-hero page-hero">
    <div class="solutions-hero-inner">
      <p class="eyebrow">Solutions</p>
      <h1 class="display-title">Guidance built around <em>your full financial life</em></h1>
      <p class="body-copy" style="max-width:540px;margin-top:0.6rem">From retirement income to estate protection, we address every dimension of your financial world — independently, comprehensively, and always with your goals at the center.</p>
    </div>
  </div>

  <div class="section" style="padding-top:2rem">
    <div class="section-inner" style="max-width:var(--max-w);margin:0 auto">
      <div class="solutions-slider-wrap reveal">
        <div class="solutions-slider" id="solSlider">
          <!-- Left visual panel -->
          <div class="sol-visual" id="solVisual">
            <div class="sol-visual-pattern"></div>
            <div class="sol-visual-num" id="solVisualNum">01</div>
            <div class="sol-visual-label" id="solVisualLabel">Financial Planning</div>
          </div>
          <!-- Right content -->
          <div class="sol-content-wrap" id="solContentWrap">
            <div class="sol-slide active" data-index="0">
              <h3>Financial Planning</h3>
              <p>A comprehensive financial plan isn't just a document — it's a living strategy built around your specific goals, timeline, and risk tolerance. We create clear roadmaps with built-in accountability systems, so progress is measurable and adjustments happen proactively. Whether you're early in your career, mid-life, or approaching a major transition, we provide the structure and guidance you need.</p>
              <div class="sol-tags"><span class="sol-tag">Goal Setting</span><span class="sol-tag">Cash Flow</span><span class="sol-tag">Net Worth</span><span class="sol-tag">Accountability</span></div>
            </div>
            <div class="sol-slide" data-index="1">
              <h3>Investment Management</h3>
              <p>We build and manage diversified investment portfolios aligned with your long-term philosophy, not short-term noise. Rather than chasing performance or moving money constantly, we focus on disciplined, evidence-based strategies that let compounding do the work. We'll help you understand your true risk tolerance and design an allocation you can stay committed to through market cycles.</p>
              <div class="sol-tags"><span class="sol-tag">Portfolios</span><span class="sol-tag">Risk Analysis</span><span class="sol-tag">Diversification</span><span class="sol-tag">Rebalancing</span></div>
            </div>
            <div class="sol-slide" data-index="2">
              <h3>Business Succession</h3>
              <p>Business owners face a unique set of financial challenges — and opportunities. We help you build personal wealth while running your business, design compensation and benefits structures that make tax sense, and plan a succession strategy well before you need it. Whether you're transitioning to family, partners, or a third-party buyer, we'll make sure you're financially prepared.</p>
              <div class="sol-tags"><span class="sol-tag">Exit Planning</span><span class="sol-tag">Buy-Sell</span><span class="sol-tag">Key Person</span><span class="sol-tag">Business Valuation</span></div>
            </div>
            <div class="sol-slide" data-index="3">
              <h3>Estate &amp; Insurance</h3>
              <p>Your estate plan is more than a will — it's a comprehensive strategy for passing wealth, minimizing taxes, and protecting the people you love. We coordinate with estate attorneys and CPAs to ensure your financial plan and legal documents align. On the insurance side, we analyze your existing coverage and identify gaps across life, disability, long-term care, and liability.</p>
              <div class="sol-tags"><span class="sol-tag">Wills &amp; Trusts</span><span class="sol-tag">Life Insurance</span><span class="sol-tag">LTC</span><span class="sol-tag">Disability</span></div>
            </div>
            <div class="sol-slide" data-index="4">
              <h3>Retirement Income Planning</h3>
              <p>Accumulating assets is only half the challenge — converting them into sustainable income is where the real planning begins. We design retirement income strategies that coordinate Social Security, pension distributions, IRA withdrawals, and investment income. We model different scenarios so you can see exactly how your plan holds up through market downturns, inflation, and healthcare costs.</p>
              <div class="sol-tags"><span class="sol-tag">Social Security</span><span class="sol-tag">RMDs</span><span class="sol-tag">Roth Conversion</span><span class="sol-tag">Income Ladders</span></div>
            </div>
            <div class="sol-slide" data-index="5">
              <h3>401(k) Plan Services — RPk</h3>
              <p>Through Retirement Plan (k)onsultant (RPk), Walt Eife provides specialized, high-quality 401(k) plan management for businesses. RPk's exclusive focus means deep expertise — from plan design and investment selection to participant education and fiduciary oversight. Simple, supportive, and cost-effective, with your employees' retirements as the priority.</p>
              <div class="sol-tags"><span class="sol-tag">Plan Design</span><span class="sol-tag">ERISA</span><span class="sol-tag">Employee Ed.</span><span class="sol-tag">Fiduciary</span></div>
            </div>
          </div>
        </div>
      </div>

      <!-- Nav -->
      <div class="sol-nav" style="margin-top:1.5rem;padding:0">
        <div class="sol-dots" id="solDots">
          <button class="sol-dot active" onclick="goSlide(0)"></button>
          <button class="sol-dot" onclick="goSlide(1)"></button>
          <button class="sol-dot" onclick="goSlide(2)"></button>
          <button class="sol-dot" onclick="goSlide(3)"></button>
          <button class="sol-dot" onclick="goSlide(4)"></button>
          <button class="sol-dot" onclick="goSlide(5)"></button>
        </div>
        <div class="sol-arrows">
          <button class="sol-arrow" onclick="stepSlide(-1)" aria-label="Previous">&#8592;</button>
          <button class="sol-arrow" onclick="stepSlide(1)" aria-label="Next">&#8594;</button>
        </div>
      </div>

      <div style="text-align:center;margin-top:3rem">
        <p style="font-size:0.94rem;font-weight:300;color:rgba(57,52,30,0.65);margin-bottom:1.2rem">Not sure where to start? A 15-minute call is all it takes.</p>
        <button class="btn btn-green" onclick="goTo('contact')">Schedule a Free Introduction</button>
      </div>
    </div>
  </div>
  <?php get_template_part('partials/shared', 'footer'); ?>
</div>