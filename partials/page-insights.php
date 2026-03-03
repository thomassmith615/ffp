<?php
/**
 * Insights partial — page-insights.php
 *
 * Static cards are shown on initial load (first 6).
 * The "Show All Articles" button calls the WP REST API:
 *   GET /wp-json/fortune/v1/insights?per_page=100&page=1
 * and renders additional cards dynamically.
 *
 * To add a new insight: WP Admin → Insights → Add New
 * The static cards below act as fallback / pre-seeded content.
 * Once you have live WP content, you can replace static cards
 * with a PHP loop using WP_Query on the 'insight' post type.
 */
?>
<div id="page-insights" class="page-view">
  <div class="insights-hero page-hero">
    <div class="page-hero-inner">
      <p class="eyebrow">Insights</p>
      <h1 class="display-title" style="color:var(--white)">Financial know-how, <em style="color:var(--tan)">simplified</em></h1>
      <p class="body-copy" style="color:rgba(255,255,255,0.6);max-width:500px;margin-top:0.6rem">We break down complex financial topics — investing, retirement, planning — into clear, actionable ideas you can actually use.</p>
    </div>
  </div>

  <div class="section">
    <div class="section-inner">
      <div class="insights-grid" id="insightsGrid">
        <div class="insight-card reveal">
          <div class="insight-card-accent"></div>
          <div class="insight-card-body">
            <div class="insight-tag">Investing</div>
            <h3>Investing Through Election Cycles</h3>
            <p>The past several U.S. presidential elections have become increasingly divisive. We explore what history tells us about markets during election years — and what it means for your long-term portfolio strategy.</p>
            <div class="insight-footer"><span class="insight-author">James Owens · Sep 11, 2024</span><a href="#" class="insight-read">Read →</a></div>
          </div>
        </div>
        <div class="insight-card reveal d1">
          <div class="insight-card-accent"></div>
          <div class="insight-card-body">
            <div class="insight-tag">Planning</div>
            <h3>The Next Chapter: Embracing 2024</h3>
            <p>It's time to take a deep breath. After years of COVID, inflation, and global uncertainty, the new year brings an opportunity to reflect on where we've been and set a clear intention for what comes next.</p>
            <div class="insight-footer"><span class="insight-author">James Owens · Jan 5, 2024</span><a href="#" class="insight-read">Read →</a></div>
          </div>
        </div>
        <div class="insight-card reveal d2">
          <div class="insight-card-accent"></div>
          <div class="insight-card-body">
            <div class="insight-tag">Retirement</div>
            <h3>'Tis the Season of RMDs</h3>
            <p>For financial professionals, the end of the year isn't just for holidays — it's required minimum distribution season. Here's what you need to know and act on before December 31st arrives.</p>
            <div class="insight-footer"><span class="insight-author">Stephen Melchiorre · Dec 11, 2023</span><a href="#" class="insight-read">Read →</a></div>
          </div>
        </div>
        <div class="insight-card reveal">
          <div class="insight-card-accent"></div>
          <div class="insight-card-body">
            <div class="insight-tag">Investing</div>
            <h3>Investment Classroom: Bond Basics</h3>
            <p>Bonds are a form of fixed-income investment representing a loan to a corporation or government. We break down how they work, why they belong in diversified portfolios, and how to think about them in your plan.</p>
            <div class="insight-footer"><span class="insight-author">Kevin J. Gianfortune · Nov 3, 2023</span><a href="#" class="insight-read">Read →</a></div>
          </div>
        </div>
        <div class="insight-card reveal d1">
          <div class="insight-card-accent"></div>
          <div class="insight-card-body">
            <div class="insight-tag">Debt</div>
            <h3>Student Loans Restart: The Economic Ripple</h3>
            <p>Student loan obligations have surpassed auto loans and credit card debt for millions of Americans. We look at the economic ripple effects of the repayment restart and how to position your finances accordingly.</p>
            <div class="insight-footer"><span class="insight-author">Stephen Melchiorre · Sep 26, 2023</span><a href="#" class="insight-read">Read →</a></div>
          </div>
        </div>
        <div class="insight-card reveal d2">
          <div class="insight-card-accent"></div>
          <div class="insight-card-body">
            <div class="insight-tag">Planning</div>
            <h3>Building Your Emergency Fund</h3>
            <p>An emergency fund is the cornerstone of any sound financial plan. We walk through how much you actually need, where to keep it, and how to build it without disrupting your other savings goals.</p>
            <div class="insight-footer"><span class="insight-author">Kevin J. Gianfortune · Aug 14, 2023</span><a href="#" class="insight-read">Read →</a></div>
          </div>
        </div>
        <!-- Additional articles — hidden by default -->
        <div class="insight-card reveal hidden extra-insight">
          <div class="insight-card-accent"></div>
          <div class="insight-card-body">
            <div class="insight-tag">Retirement</div>
            <h3>Social Security: When Should You Claim?</h3>
            <p>The decision of when to claim Social Security is one of the most consequential in retirement planning. We break down the tradeoffs between claiming early, at full retirement age, or waiting until 70.</p>
            <div class="insight-footer"><span class="insight-author">Walter Eife · Jun 2, 2023</span><a href="#" class="insight-read">Read →</a></div>
          </div>
        </div>
        <div class="insight-card reveal hidden extra-insight">
          <div class="insight-card-accent"></div>
          <div class="insight-card-body">
            <div class="insight-tag">Tax</div>
            <h3>Roth Conversions: Is Now the Right Time?</h3>
            <p>With tax rates in flux, many clients are asking whether a Roth conversion makes sense. We walk through the key factors to consider and when a partial conversion strategy might be most advantageous.</p>
            <div class="insight-footer"><span class="insight-author">Kevin J. Gianfortune · Apr 18, 2023</span><a href="#" class="insight-read">Read →</a></div>
          </div>
        </div>
        <div class="insight-card reveal hidden extra-insight" style="border-color:rgba(91,119,71,0.3)">
          <div class="insight-card-accent" style="background:var(--sage)"></div>
          <div class="insight-card-body">
            <div class="insight-tag">Newsletter</div>
            <h3>Stay Informed — Join Our Newsletter</h3>
            <p>Financial tips for life's biggest questions. Get helpful guidance and updates from our team — no noise, just value. New articles, videos, and insights delivered to your inbox.</p>
            <div class="insight-footer"><span class="insight-author">Fortune Financial Team</span><span class="insight-read" onclick="goTo('contact')" style="cursor:pointer">Subscribe →</span></div>
          </div>
        </div>
      </div>
      <div class="insights-show-all-wrap">
        <button class="btn btn-outline-dark" id="showAllBtn" onclick="showAllInsightsWP()">Show All Articles</button>
      </div>
    </div>
  </div>
  <?php get_template_part('partials/shared', 'footer'); ?>
</div>