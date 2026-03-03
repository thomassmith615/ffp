<div id="page-resources" class="page-view">
  <div class="resources-hero page-hero">
    <div class="page-hero-inner">
      <p class="eyebrow">Resources</p>
      <h1 class="display-title">Tools to <em>empower</em> you</h1>
      <p class="body-copy" style="max-width:500px;margin-top:0.6rem">A curated collection of calculators, educational articles, and tools to help you better understand and manage every dimension of your financial life.</p>
    </div>
  </div>

  <div class="section">
    <div class="section-inner">
      <!-- Top-level tabs -->
      <div class="resources-tabs">
        <button class="res-tab active" data-res="overview" onclick="setResTab('overview')">Overview</button>
        <button class="res-tab" data-res="retirement" onclick="setResTab('retirement')">Retirement</button>
        <button class="res-tab" data-res="investment" onclick="setResTab('investment')">Investment</button>
        <button class="res-tab" data-res="estate" onclick="setResTab('estate')">Estate</button>
        <button class="res-tab" data-res="insurance" onclick="setResTab('insurance')">Insurance</button>
        <button class="res-tab" data-res="tax" onclick="setResTab('tax')">Tax</button>
        <button class="res-tab" data-res="lifestyle" onclick="setResTab('lifestyle')">Lifestyle</button>
        <button class="res-tab" data-res="calc" onclick="setResTab('calc')">All Calculators</button>
        <button class="res-tab" data-res="videos" onclick="setResTab('videos')">All Videos</button>
      </div>

      <!-- OVERVIEW PANEL -->
      <div class="res-panel active" id="panel-overview">
        <div class="resource-cards">
          <div class="resource-card reveal" onclick="setResTab('retirement')"><h4>Retirement</h4><p>Income strategies, Social Security, IRAs, RMDs, and planning for the life you've worked toward.</p></div>
          <div class="resource-card reveal d1" onclick="setResTab('investment')"><h4>Investment</h4><p>Portfolio fundamentals, compound interest, risk tolerance, college savings, and more.</p></div>
          <div class="resource-card reveal d2" onclick="setResTab('estate')"><h4>Estate</h4><p>Wills, trusts, net worth, and estate tax — protecting what you've built for the people you love.</p></div>
          <div class="resource-card reveal d3" onclick="setResTab('insurance')"><h4>Insurance</h4><p>Life insurance needs, disability income, long-term care — understanding your coverage gaps.</p></div>
          <div class="resource-card reveal d4" onclick="setResTab('tax')"><h4>Tax</h4><p>Federal income tax, capital gains, Social Security taxation, and year-end planning resources.</p></div>
          <div class="resource-card reveal d5" onclick="setResTab('lifestyle')"><h4>Lifestyle</h4><p>Buying vs. leasing, mortgage decisions, debt vs. investing — financial choices that shape daily life.</p></div>
          <div class="resource-card reveal" onclick="setResTab('calc')"><h4>All Calculators</h4><p>Every interactive calculator we offer, organized by category.</p></div>
          <div class="resource-card reveal d1" onclick="setResTab('videos')"><h4>All Videos</h4><p>Short, informative videos from our team covering key financial topics at a glance.</p></div>
          <a href="https://brokercheck.finra.org/" target="_blank" class="resource-card reveal d2"><h4>FINRA BrokerCheck</h4><p>Verify the background and credentials of your financial professional through FINRA's official portal.</p></a>
        </div>
      </div>

      <!-- RETIREMENT PANEL -->
      <div class="res-panel" id="panel-retirement">
        <div class="res-category-header">
          <h2>Retirement</h2>
          <p>Planning for retirement is about much more than saving — it's about building a sustainable income strategy that lasts as long as you do. We help you coordinate every piece of the puzzle.</p>
        </div>
        <div class="res-split">
          <div class="res-split-img"><div class="res-split-img-inner">R</div></div>
          <div class="res-split-text">
            <h3>Making Your Savings Work for You</h3>
            <p>Retirement income planning requires coordinating Social Security, pensions, IRA distributions, and investment portfolios into a coherent strategy. We help you model scenarios and stress-test your plan against inflation and healthcare costs.</p>
          </div>
        </div>
        <div class="cat-tabs">
          <button class="cat-tab active" onclick="setCatTab('retirement','articles')">Articles</button>
          <button class="cat-tab" onclick="setCatTab('retirement','calculators')">Calculators</button>
          <button class="cat-tab" onclick="setCatTab('retirement','videos')">Videos</button>
        </div>
        <div class="cat-panel active" id="retirement-articles">
          <ul class="linked-list">
            <li><span>'Tis the Season of RMDs</span><span class="ll-arrow">›</span></li>
            <li><span>Social Security: When Should You Claim?</span><span class="ll-arrow">›</span></li>
            <li><span>Inflation and Your Retirement</span><span class="ll-arrow">›</span></li>
            <li><span>The 4% Rule — Is It Still Valid?</span><span class="ll-arrow">›</span></li>
            <li><span>Roth vs. Traditional: Which Is Right for You?</span><span class="ll-arrow">›</span></li>
          </ul>
          <span class="view-all-link" onclick="setResTab('calc')">View All Retirement Calculators →</span>
        </div>
        <div class="cat-panel" id="retirement-calculators">
          <ul class="linked-list">
            <li><span>Saving for Retirement</span><span class="ll-arrow">›</span></li>
            <li><span>My Retirement Savings</span><span class="ll-arrow">›</span></li>
            <li><span>Roth 401(k) vs. Traditional 401(k)</span><span class="ll-arrow">›</span></li>
            <li><span>Inflation &amp; Retirement</span><span class="ll-arrow">›</span></li>
            <li><span>Potential Income from an IRA</span><span class="ll-arrow">›</span></li>
            <li><span>Estimate Your RMD</span><span class="ll-arrow">›</span></li>
            <li><span>A Look at Systematic Withdrawals</span><span class="ll-arrow">›</span></li>
            <li><span>Annuity Comparison</span><span class="ll-arrow">›</span></li>
          </ul>
          <span class="view-all-link" onclick="setResTab('calc')">View All Calculators →</span>
        </div>
        <div class="cat-panel" id="retirement-videos">
          <ul class="linked-list">
            <li><span>Retirement Income 101</span><span class="ll-arrow">›</span></li>
            <li><span>Understanding Required Minimum Distributions</span><span class="ll-arrow">›</span></li>
          </ul>
          <span class="view-all-link" onclick="setResTab('videos')">View All Videos →</span>
        </div>
        <div style="margin-top:2.5rem;padding-top:2rem;border-top:1px solid rgba(190,189,174,0.4)">
          <p style="font-size:0.9rem;font-weight:300;color:rgba(57,52,30,0.65);margin-bottom:1rem">Have a retirement planning question?</p>
          <button class="btn btn-green" onclick="goTo('contact')">Talk to Our Team</button>
        </div>
      </div>

      <!-- INVESTMENT PANEL -->
      <div class="res-panel" id="panel-investment">
        <div class="res-category-header">
          <h2>Investment</h2>
          <p>Sound investing is less about picking winners and more about building a disciplined, diversified strategy that matches your goals and temperament — and sticking with it.</p>
        </div>
        <div class="res-split">
          <div class="res-split-img"><div class="res-split-img-inner">I</div></div>
          <div class="res-split-text">
            <h3>A Long-Term Perspective</h3>
            <p>Markets will fluctuate, headlines will alarm, and emotion will tempt you to act. Our investment philosophy is built on evidence-based principles, appropriate diversification, and the discipline to stay the course when it matters most.</p>
          </div>
        </div>
        <div class="cat-tabs">
          <button class="cat-tab active" onclick="setCatTab('investment','articles')">Articles</button>
          <button class="cat-tab" onclick="setCatTab('investment','calculators')">Calculators</button>
          <button class="cat-tab" onclick="setCatTab('investment','videos')">Videos</button>
        </div>
        <div class="cat-panel active" id="investment-articles">
          <ul class="linked-list">
            <li><span>Investing Through Election Cycles</span><span class="ll-arrow">›</span></li>
            <li><span>Investment Classroom: Bond Basics</span><span class="ll-arrow">›</span></li>
            <li><span>Understanding Asset Allocation</span><span class="ll-arrow">›</span></li>
            <li><span>The Power of Compounding</span><span class="ll-arrow">›</span></li>
            <li><span>Dollar-Cost Averaging Explained</span><span class="ll-arrow">›</span></li>
          </ul>
          <span class="view-all-link">View All Investment Articles →</span>
        </div>
        <div class="cat-panel" id="investment-calculators">
          <ul class="linked-list">
            <li><span>Taxable vs. Tax-Deferred Savings</span><span class="ll-arrow">›</span></li>
            <li><span>How Compound Interest Works</span><span class="ll-arrow">›</span></li>
            <li><span>What Is My Risk Tolerance?</span><span class="ll-arrow">›</span></li>
            <li><span>What Is the Dividend Yield?</span><span class="ll-arrow">›</span></li>
            <li><span>Impact of Taxes and Inflation</span><span class="ll-arrow">›</span></li>
            <li><span>Saving for College</span><span class="ll-arrow">›</span></li>
            <li><span>Contributing to an IRA?</span><span class="ll-arrow">›</span></li>
          </ul>
          <span class="view-all-link" onclick="setResTab('calc')">View All Calculators →</span>
        </div>
        <div class="cat-panel" id="investment-videos">
          <ul class="linked-list">
            <li><span>What Is Diversification?</span><span class="ll-arrow">›</span></li>
            <li><span>Market Volatility — What to Do</span><span class="ll-arrow">›</span></li>
          </ul>
          <span class="view-all-link" onclick="setResTab('videos')">View All Videos →</span>
        </div>
        <div style="margin-top:2.5rem;padding-top:2rem;border-top:1px solid rgba(190,189,174,0.4)">
          <button class="btn btn-green" onclick="goTo('contact')">Discuss Your Portfolio</button>
        </div>
      </div>

      <!-- ESTATE PANEL -->
      <div class="res-panel" id="panel-estate">
        <div class="res-category-header">
          <h2>Estate Planning</h2>
          <p>Estate planning is about making sure your assets go where you intend, when you intend, with as little friction and tax burden as possible. It's one of the most important gifts you can give your family.</p>
        </div>
        <div class="res-split">
          <div class="res-split-img"><div class="res-split-img-inner">E</div></div>
          <div class="res-split-text">
            <h3>Protecting Your Legacy</h3>
            <p>A proper estate plan coordinates your will, trusts, beneficiary designations, and insurance to ensure a seamless transition of wealth. We work alongside your estate attorney to make sure every piece aligns.</p>
          </div>
        </div>
        <div class="cat-tabs">
          <button class="cat-tab active" onclick="setCatTab('estate','articles')">Articles</button>
          <button class="cat-tab" onclick="setCatTab('estate','calculators')">Calculators</button>
          <button class="cat-tab" onclick="setCatTab('estate','videos')">Videos</button>
        </div>
        <div class="cat-panel active" id="estate-articles">
          <ul class="linked-list">
            <li><span>Year-End Charitable Gifting and You</span><span class="ll-arrow">›</span></li>
            <li><span>Understanding the Estate Tax</span><span class="ll-arrow">›</span></li>
            <li><span>Beneficiary Designations: Don't Overlook Them</span><span class="ll-arrow">›</span></li>
            <li><span>Trusts 101: Which Type Is Right for You?</span><span class="ll-arrow">›</span></li>
          </ul>
          <span class="view-all-link">View All Estate Articles →</span>
        </div>
        <div class="cat-panel" id="estate-calculators">
          <ul class="linked-list">
            <li><span>What Is My Life Expectancy?</span><span class="ll-arrow">›</span></li>
            <li><span>What Is My Current Net Worth?</span><span class="ll-arrow">›</span></li>
            <li><span>What's My Potential Estate Tax?</span><span class="ll-arrow">›</span></li>
          </ul>
          <span class="view-all-link" onclick="setResTab('calc')">View All Calculators →</span>
        </div>
        <div class="cat-panel" id="estate-videos">
          <ul class="linked-list">
            <li><span>What Is a Trust?</span><span class="ll-arrow">›</span></li>
            <li><span>Estate Planning Basics</span><span class="ll-arrow">›</span></li>
          </ul>
          <span class="view-all-link" onclick="setResTab('videos')">View All Videos →</span>
        </div>
        <div style="margin-top:2.5rem;padding-top:2rem;border-top:1px solid rgba(190,189,174,0.4)">
          <button class="btn btn-green" onclick="goTo('contact')">Talk Estate Planning</button>
        </div>
      </div>

      <!-- INSURANCE PANEL -->
      <div class="res-panel" id="panel-insurance">
        <div class="res-category-header">
          <h2>Insurance</h2>
          <p>The right insurance coverage isn't about fear — it's about protecting the financial plan you've worked hard to build. We assess your needs across life, disability, and long-term care.</p>
        </div>
        <div class="res-split">
          <div class="res-split-img"><div class="res-split-img-inner">P</div></div>
          <div class="res-split-text">
            <h3>Closing the Gaps</h3>
            <p>Most people are either underinsured or paying for coverage they don't need. We conduct a comprehensive insurance review to identify where you're exposed and where you're over-paying.</p>
          </div>
        </div>
        <div class="cat-tabs">
          <button class="cat-tab active" onclick="setCatTab('insurance','articles')">Articles</button>
          <button class="cat-tab" onclick="setCatTab('insurance','calculators')">Calculators</button>
          <button class="cat-tab" onclick="setCatTab('insurance','videos')">Videos</button>
        </div>
        <div class="cat-panel active" id="insurance-articles">
          <ul class="linked-list">
            <li><span>How Much Life Insurance Do You Really Need?</span><span class="ll-arrow">›</span></li>
            <li><span>Long-Term Care: Planning Before You Need It</span><span class="ll-arrow">›</span></li>
            <li><span>Disability Insurance: Your Most Overlooked Asset</span><span class="ll-arrow">›</span></li>
            <li><span>Term vs. Permanent Life Insurance</span><span class="ll-arrow">›</span></li>
          </ul>
          <span class="view-all-link">View All Insurance Articles →</span>
        </div>
        <div class="cat-panel" id="insurance-calculators">
          <ul class="linked-list">
            <li><span>Assess Your Life Insurance Needs</span><span class="ll-arrow">›</span></li>
            <li><span>Lifetime of Earnings</span><span class="ll-arrow">›</span></li>
            <li><span>Disability Income</span><span class="ll-arrow">›</span></li>
            <li><span>Long-Term Care Needs</span><span class="ll-arrow">›</span></li>
          </ul>
          <span class="view-all-link" onclick="setResTab('calc')">View All Calculators →</span>
        </div>
        <div class="cat-panel" id="insurance-videos">
          <ul class="linked-list">
            <li><span>Life Insurance Basics</span><span class="ll-arrow">›</span></li>
            <li><span>Understanding Long-Term Care</span><span class="ll-arrow">›</span></li>
          </ul>
          <span class="view-all-link" onclick="setResTab('videos')">View All Videos →</span>
        </div>
        <div style="margin-top:2.5rem;padding-top:2rem;border-top:1px solid rgba(190,189,174,0.4)">
          <button class="btn btn-green" onclick="goTo('contact')">Review My Coverage</button>
        </div>
      </div>

      <!-- TAX PANEL -->
      <div class="res-panel" id="panel-tax">
        <div class="res-category-header">
          <h2>Tax Planning</h2>
          <p>Our tax center was designed to help you access the resources you may need to prepare for the upcoming tax season — and plan proactively throughout the year.</p>
        </div>
        <div class="res-split">
          <div class="res-split-img"><div class="res-split-img-inner">T</div></div>
          <div class="res-split-text">
            <h3>Year-Round Tax Awareness</h3>
            <p>The best tax planning happens throughout the year, not just in April. From Roth conversions to capital gains harvesting, we help you incorporate tax efficiency into every financial decision.</p>
          </div>
        </div>
        <div class="cat-tabs">
          <button class="cat-tab active" onclick="setCatTab('tax','articles')">Articles</button>
          <button class="cat-tab" onclick="setCatTab('tax','calculators')">Calculators</button>
          <button class="cat-tab" onclick="setCatTab('tax','videos')">Videos</button>
        </div>
        <div class="cat-panel active" id="tax-articles">
          <ul class="linked-list">
            <li><span>Roth Conversions: Is Now the Right Time?</span><span class="ll-arrow">›</span></li>
            <li><span>Year-End Tax Planning Checklist</span><span class="ll-arrow">›</span></li>
            <li><span>Capital Gains: Short vs. Long-Term</span><span class="ll-arrow">›</span></li>
            <li><span>Tax-Loss Harvesting Explained</span><span class="ll-arrow">›</span></li>
          </ul>
          <span class="view-all-link">View All Tax Articles →</span>
        </div>
        <div class="cat-panel" id="tax-calculators">
          <ul class="linked-list">
            <li><span>Federal Income Tax</span><span class="ll-arrow">›</span></li>
            <li><span>Capital Gains Tax Estimator</span><span class="ll-arrow">›</span></li>
            <li><span>Social Security Taxes</span><span class="ll-arrow">›</span></li>
            <li><span>Tax Freedom Day</span><span class="ll-arrow">›</span></li>
            <li><span>Home Mortgage Deduction</span><span class="ll-arrow">›</span></li>
            <li><span>Comparing Investments (Tax Impact)</span><span class="ll-arrow">›</span></li>
          </ul>
          <span class="view-all-link" onclick="setResTab('calc')">View All Calculators →</span>
        </div>
        <div class="cat-panel" id="tax-videos">
          <ul class="linked-list">
            <li><span>What Is a Roth Conversion?</span><span class="ll-arrow">›</span></li>
            <li><span>Tax Planning for Retirees</span><span class="ll-arrow">›</span></li>
          </ul>
          <span class="view-all-link" onclick="setResTab('videos')">View All Videos →</span>
        </div>
        <p style="font-size:0.8rem;font-weight:300;line-height:1.7;color:rgba(57,52,30,0.5);margin-top:2rem;max-width:640px">The information in this material is not intended as tax or legal advice. It may not be used for the purpose of avoiding any federal tax penalties. Please consult legal or tax professionals for specific information regarding your individual situation.</p>
      </div>

      <!-- LIFESTYLE PANEL -->
      <div class="res-panel" id="panel-lifestyle">
        <div class="res-category-header">
          <h2>Lifestyle</h2>
          <p>The biggest financial decisions in life often don't feel like "finance" — they're about the car you drive, the home you own, and the debt you carry. We help you think through them clearly.</p>
        </div>
        <div class="res-split">
          <div class="res-split-img"><div class="res-split-img-inner">L</div></div>
          <div class="res-split-text">
            <h3>Everyday Money, Long-Term Impact</h3>
            <p>Small financial decisions compound over time. Whether you're weighing buying vs. renting, considering refinancing, or deciding between paying off debt and investing, the right framework can make a significant difference.</p>
          </div>
        </div>
        <div class="cat-tabs">
          <button class="cat-tab active" onclick="setCatTab('lifestyle','articles')">Articles</button>
          <button class="cat-tab" onclick="setCatTab('lifestyle','calculators')">Calculators</button>
          <button class="cat-tab" onclick="setCatTab('lifestyle','videos')">Videos</button>
        </div>
        <div class="cat-panel active" id="lifestyle-articles">
          <ul class="linked-list">
            <li><span>Keeping Up with the Joneses</span><span class="ll-arrow">›</span></li>
            <li><span>Mortgages in Retirement</span><span class="ll-arrow">›</span></li>
            <li><span>Saving for College 101</span><span class="ll-arrow">›</span></li>
            <li><span>Pay Yourself First</span><span class="ll-arrow">›</span></li>
            <li><span>Building a Solid Financial Foundation</span><span class="ll-arrow">›</span></li>
            <li><span>What If Your Kids Decide Against College?</span><span class="ll-arrow">›</span></li>
          </ul>
          <span class="view-all-link">View All Lifestyle Articles →</span>
        </div>
        <div class="cat-panel" id="lifestyle-calculators">
          <ul class="linked-list">
            <li><span>Should I Buy or Lease an Auto?</span><span class="ll-arrow">›</span></li>
            <li><span>Should I Pay Off Debt or Invest?</span><span class="ll-arrow">›</span></li>
            <li><span>How Much Home Can I Afford?</span><span class="ll-arrow">›</span></li>
            <li><span>Can I Refinance My Mortgage?</span><span class="ll-arrow">›</span></li>
            <li><span>Comparing Mortgage Terms</span><span class="ll-arrow">›</span></li>
            <li><span>Bi-Weekly Payments</span><span class="ll-arrow">›</span></li>
            <li><span>Interested in a Fuel Efficient Car?</span><span class="ll-arrow">›</span></li>
          </ul>
          <span class="view-all-link" onclick="setResTab('calc')">View All Calculators →</span>
        </div>
        <div class="cat-panel" id="lifestyle-videos">
          <ul class="linked-list">
            <li><span>Surprise! You've Got Money!</span><span class="ll-arrow">›</span></li>
            <li><span>Paying Off a Credit Card — Smart Strategies</span><span class="ll-arrow">›</span></li>
          </ul>
          <span class="view-all-link" onclick="setResTab('videos')">View All Videos →</span>
        </div>
        <div style="margin-top:2.5rem;padding-top:2rem;border-top:1px solid rgba(190,189,174,0.4)">
          <button class="btn btn-green" onclick="goTo('contact')">Talk to Our Team</button>
        </div>
      </div>

      <!-- ALL CALCULATORS PANEL -->
      <div class="res-panel" id="panel-calc">
        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(min(100%,320px),1fr));gap:2rem">
          <div class="calc-section">
            <div class="calc-section-title">Retirement</div>
            <ul class="calc-list">
              <li><span>A Look at Systematic Withdrawals</span><span class="calc-arrow">›</span></li>
              <li><span>Saving for Retirement</span><span class="calc-arrow">›</span></li>
              <li><span>My Retirement Savings</span><span class="calc-arrow">›</span></li>
              <li><span>Roth 401(k) vs. Traditional 401(k)</span><span class="calc-arrow">›</span></li>
              <li><span>Inflation &amp; Retirement</span><span class="calc-arrow">›</span></li>
              <li><span>Potential Income from an IRA</span><span class="calc-arrow">›</span></li>
              <li><span>Estimate Your RMD</span><span class="calc-arrow">›</span></li>
              <li><span>Self-Employed Retirement Plans</span><span class="calc-arrow">›</span></li>
              <li><span>Annuity Comparison</span><span class="calc-arrow">›</span></li>
            </ul>
          </div>
          <div class="calc-section">
            <div class="calc-section-title">Investment</div>
            <ul class="calc-list">
              <li><span>Taxable vs. Tax-Deferred Savings</span><span class="calc-arrow">›</span></li>
              <li><span>How Compound Interest Works</span><span class="calc-arrow">›</span></li>
              <li><span>What Is My Risk Tolerance?</span><span class="calc-arrow">›</span></li>
              <li><span>What Is the Dividend Yield?</span><span class="calc-arrow">›</span></li>
              <li><span>Impact of Taxes and Inflation</span><span class="calc-arrow">›</span></li>
              <li><span>Saving for College</span><span class="calc-arrow">›</span></li>
              <li><span>Contributing to an IRA?</span><span class="calc-arrow">›</span></li>
            </ul>
            <div class="calc-section-title" style="margin-top:1.5rem">Estate</div>
            <ul class="calc-list">
              <li><span>What Is My Life Expectancy?</span><span class="calc-arrow">›</span></li>
              <li><span>What Is My Current Net Worth?</span><span class="calc-arrow">›</span></li>
              <li><span>What's My Potential Estate Tax?</span><span class="calc-arrow">›</span></li>
            </ul>
          </div>
          <div class="calc-section">
            <div class="calc-section-title">Insurance</div>
            <ul class="calc-list">
              <li><span>Assess Your Life Insurance Needs</span><span class="calc-arrow">›</span></li>
              <li><span>Lifetime of Earnings</span><span class="calc-arrow">›</span></li>
              <li><span>Disability Income</span><span class="calc-arrow">›</span></li>
              <li><span>Long-Term Care Needs</span><span class="calc-arrow">›</span></li>
            </ul>
            <div class="calc-section-title" style="margin-top:1.5rem">Tax</div>
            <ul class="calc-list">
              <li><span>Federal Income Tax</span><span class="calc-arrow">›</span></li>
              <li><span>Capital Gains Tax Estimator</span><span class="calc-arrow">›</span></li>
              <li><span>Comparing Investments</span><span class="calc-arrow">›</span></li>
              <li><span>Social Security Taxes</span><span class="calc-arrow">›</span></li>
              <li><span>Tax Freedom Day</span><span class="calc-arrow">›</span></li>
              <li><span>Home Mortgage Deduction</span><span class="calc-arrow">›</span></li>
            </ul>
          </div>
          <div class="calc-section">
            <div class="calc-section-title">Lifestyle &amp; Money</div>
            <ul class="calc-list">
              <li><span>What Is My Current Cash Flow?</span><span class="calc-arrow">›</span></li>
              <li><span>Paying Off a Credit Card</span><span class="calc-arrow">›</span></li>
              <li><span>Historical Inflation</span><span class="calc-arrow">›</span></li>
              <li><span>Interested in a Fuel Efficient Car?</span><span class="calc-arrow">›</span></li>
              <li><span>Should I Buy or Lease an Auto?</span><span class="calc-arrow">›</span></li>
              <li><span>Should I Pay Off Debt or Invest?</span><span class="calc-arrow">›</span></li>
              <li><span>How Much Home Can I Afford?</span><span class="calc-arrow">›</span></li>
              <li><span>Can I Refinance My Mortgage?</span><span class="calc-arrow">›</span></li>
              <li><span>Comparing Mortgage Terms</span><span class="calc-arrow">›</span></li>
              <li><span>Bi-Weekly Payments</span><span class="calc-arrow">›</span></li>
            </ul>
          </div>
        </div>
      </div>

      <!-- ALL VIDEOS PANEL -->
      <div class="res-panel" id="panel-videos">
        <div class="res-category-header">
          <h2>All Videos</h2>
          <p>Short, informative videos from our team covering key financial topics. Content added regularly.</p>
        </div>
        <ul class="linked-list">
          <li><span>Retirement Income 101</span><span class="ll-arrow">›</span></li>
          <li><span>Understanding Required Minimum Distributions</span><span class="ll-arrow">›</span></li>
          <li><span>Surprise! You've Got Money!</span><span class="ll-arrow">›</span></li>
          <li><span>What Is Diversification?</span><span class="ll-arrow">›</span></li>
          <li><span>Market Volatility — What to Do</span><span class="ll-arrow">›</span></li>
          <li><span>Life Insurance Basics</span><span class="ll-arrow">›</span></li>
          <li><span>Understanding Long-Term Care</span><span class="ll-arrow">›</span></li>
          <li><span>What Is a Trust?</span><span class="ll-arrow">›</span></li>
          <li><span>What Is a Roth Conversion?</span><span class="ll-arrow">›</span></li>
          <li><span>Tax Planning for Retirees</span><span class="ll-arrow">›</span></li>
          <li><span>Estate Planning Basics</span><span class="ll-arrow">›</span></li>
        </ul>
      </div>

    </div>
  </div>
  <?php get_template_part('partials/shared', 'footer'); ?>
</div>