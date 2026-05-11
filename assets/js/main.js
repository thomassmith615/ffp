/* ═══════════════════════════════════════════════════════
   Fortune Financial Planning — main.js
   WordPress-integrated SPA with deep-link routing.

   URL structure:
     /                                  → home
     /about                             → about
     /solutions                         → solutions
     /insights                          → insights grid
     /insights/{slug}                   → single insight article
     /resources                         → resources overview
     /resources/{category}              → category page
     /resources/{category}/{tab}        → category with tab active
     /resources/article/{slug}          → single article
     /resources/calculator/{slug}       → single calculator
     /resources/video/{slug}            → single video
     /contact                           → contact

   window.fortuneData is injected by wp_localize_script()
   in functions.php and contains: ajaxUrl, nonce, homeUrl, themeUrl
═══════════════════════════════════════════════════════ */

/* ═══════════ ROUTE DEFINITIONS ═══════════ */
const TOP_PAGES = ['home', 'about', 'solutions', 'insights', 'resources', 'contact'];
const RES_CATEGORIES = ['overview', 'retirement', 'investment', 'estate', 'insurance', 'tax', 'lifestyle', 'calc', 'videos'];
const RES_TABS = ['articles', 'calculators', 'videos'];

/* ═══════════ HELPERS ═══════════ */
function _basePath() {
  if (typeof fortuneData !== 'undefined' && fortuneData.homeUrl) {
    try {
      return new URL(fortuneData.homeUrl).pathname.replace(/\/?$/, '/');
    } catch (e) { /* ignore */ }
  }
  return '/';
}

function _stripBase(pathname) {
  const base = _basePath();
  let p = pathname;
  if (base !== '/' && p.indexOf(base) === 0) p = p.slice(base.length - 1);
  return p.replace(/\/+$/, '').replace(/^\/+/, '');
}

/**
 * Parse window.location.pathname into a structured route object.
 *
 *   { page, category, tab, kind, slug }
 *
 *   page     — top-level page slug (home|about|solutions|insights|resources|contact)
 *   category — for /resources/{category}, the category slug
 *   tab      — for /resources/{category}/{tab}, the inner tab (articles|calculators|videos)
 *   kind     — for /resources/{kind}/{slug}, one of 'article'|'calculator'|'video'
 *   slug     — article/calculator/video/insight slug
 */
function parseRoute(pathname) {
  const raw = _stripBase(pathname);
  if (!raw) return { page: 'home' };

  const segs = raw.split('/').map(s => s.toLowerCase());
  const top  = segs[0];

  if (!TOP_PAGES.includes(top)) return { page: 'home' };

  const route = { page: top };

  if (top === 'resources' && segs[1]) {
    // /resources/article/{slug}, /resources/calculator/{slug}, /resources/video/{slug}
    if (['article', 'calculator', 'video'].includes(segs[1]) && segs[2]) {
      route.kind = segs[1];
      route.slug = segs[2];
    } else if (RES_CATEGORIES.includes(segs[1])) {
      route.category = segs[1];
      if (segs[2] && RES_TABS.includes(segs[2])) route.tab = segs[2];
    }
  }

  if (top === 'insights' && segs[1]) {
    route.slug = segs[1];
  }

  return route;
}

/**
 * Build a URL from a route object. Inverse of parseRoute.
 */
function buildUrl(route) {
  let base = (typeof fortuneData !== 'undefined' && fortuneData.homeUrl)
    ? fortuneData.homeUrl.replace(/\/$/, '')
    : window.location.origin;

  if (!route || route.page === 'home') return base + '/';

  let path = '/' + route.page;

  if (route.page === 'resources') {
    if (route.kind && route.slug) {
      path += '/' + route.kind + '/' + route.slug;
    } else if (route.category && route.category !== 'overview') {
      path += '/' + route.category;
      if (route.tab) path += '/' + route.tab;
    }
  } else if (route.page === 'insights' && route.slug) {
    path += '/' + route.slug;
  }

  return base + path;
}

/* ═══════════ STATE ═══════════ */
let currentRoute = { page: 'home' };

/* ═══════════ ROUTER ═══════════ */
/**
 * Navigate to a route. Accepts either:
 *   - a string slug ('about') for back-compat with existing onclick handlers
 *   - a full route object { page, category, tab, kind, slug }
 *
 * @param {string|object} target
 * @param {boolean} pushState — push to browser history? (false on popstate / initial)
 */
function goTo(target, pushState = true) {
  // String → route object
  const route = (typeof target === 'string') ? { page: target } : Object.assign({}, target);
  if (!TOP_PAGES.includes(route.page)) route.page = 'home';

  // Switch top-level view
  TOP_PAGES.forEach(p => {
    const el = document.getElementById('page-' + p);
    if (el) el.classList.remove('active');
  });
  const activeEl = document.getElementById('page-' + route.page);
  if (activeEl) activeEl.classList.add('active');

  currentRoute = route;

  // Hydrate sub-views (resources tab, single article view, etc.)
  hydrateSubView(route);

  // Scroll behavior — keep at top for full page changes, smooth-scroll into view for single items
  window.scrollTo({ top: 0, behavior: 'instant' });

  // Update nav active state
  document.querySelectorAll('.nav-links a[data-page]').forEach(a => {
    a.classList.toggle('active', a.dataset.page === route.page);
  });

  updateNavStyle();
  setTimeout(triggerReveals, 60);

  if (pushState) {
    const url = buildUrl(route);
    window.history.pushState(route, '', url);
  }
}

/**
 * After the top-level view is shown, set up any sub-state:
 *  - Resources: open the right tab and inner cat tab, or render a single item.
 *  - Insights:  render a single insight if slug present.
 */
function hydrateSubView(route) {
  // Insights — single article view
  if (route.page === 'insights') {
    renderInsightSingle(route.slug || null);
  }

  // Resources — handle category tab / inner tab / single item
  if (route.page === 'resources') {
    if (route.kind && route.slug) {
      // Single article / calculator / video
      renderResourceSingle(route.kind, route.slug);
    } else {
      // Hide any single-item view
      hideResourceSingle();
      const cat = route.category || 'overview';
      _activateResTab(cat);
      if (route.tab) _activateCatTab(cat, route.tab);
    }
  }
}

/* ═══════════ BROWSER BACK / FORWARD ═══════════ */
window.addEventListener('popstate', (e) => {
  const route = (e.state && e.state.page) ? e.state : parseRoute(window.location.pathname);
  goTo(route, false);
});

/* ═══════════ NAV STYLING ═══════════ */
function updateNavStyle() {
  const nav = document.getElementById('mainNav');
  if (!nav) return;
  if (currentRoute.page !== 'home') {
    nav.classList.add('solid'); nav.classList.remove('scrolled');
  } else {
    nav.classList.remove('solid');
    nav.classList.toggle('scrolled', window.scrollY > 40);
  }
}
window.addEventListener('scroll', () => {
  if (currentRoute.page === 'home') {
    const nav = document.getElementById('mainNav');
    if (nav) nav.classList.toggle('scrolled', window.scrollY > 40);
  }
}, { passive: true });

/* ═══════════ HAMBURGER ═══════════ */
const ham = document.getElementById('ham');
const drawer = document.getElementById('drawer');
if (ham) ham.addEventListener('click', () => { ham.classList.toggle('open'); drawer.classList.toggle('open'); });
function closeDrawer() { if (ham) ham.classList.remove('open'); if (drawer) drawer.classList.remove('open'); }

/* ═══════════ SCROLL REVEAL ═══════════ */
function triggerReveals() {
  const els = document.querySelectorAll('.page-view.active .reveal:not(.in)');
  if (!els.length) return;
  const observer = new IntersectionObserver(entries => {
    entries.forEach(e => {
      if (e.isIntersecting) { e.target.classList.add('in'); observer.unobserve(e.target); }
    });
  }, { threshold: 0.08 });
  els.forEach(el => observer.observe(el));
}

/* ═══════════ SOLUTIONS SLIDER ═══════════ */
let currentSlide = 0;
const slideData = [
  { num: '01', label: 'Financial Planning',    bg: 'linear-gradient(145deg, #2e2a14 0%, #5b7747 100%)' },
  { num: '02', label: 'Investment Management', bg: 'linear-gradient(145deg, #1e2e1a 0%, #4a6039 100%)' },
  { num: '03', label: 'Business Succession',   bg: 'linear-gradient(145deg, #2a1e14 0%, #6b5a3e 100%)' },
  { num: '04', label: 'Estate & Insurance',    bg: 'linear-gradient(145deg, #1a1e2a 0%, #3e4a6b 100%)' },
  { num: '05', label: 'Retirement Income',     bg: 'linear-gradient(145deg, #14201a 0%, #3e6b5a 100%)' },
  { num: '06', label: '401(k) Plan Services',  bg: 'linear-gradient(145deg, #201a14 0%, #6b5a3e 100%)' },
];

function goSlide(idx) {
  const slides = document.querySelectorAll('.sol-slide');
  const dots   = document.querySelectorAll('.sol-dot');
  if (!slides.length) return;
  slides[currentSlide].classList.remove('active');
  dots[currentSlide].classList.remove('active');
  currentSlide = (idx + slideData.length) % slideData.length;
  slides[currentSlide].classList.add('active');
  dots[currentSlide].classList.add('active');
  const numEl = document.getElementById('solVisualNum');
  const labelEl = document.getElementById('solVisualLabel');
  const visEl = document.getElementById('solVisual');
  if (numEl) numEl.textContent = slideData[currentSlide].num;
  if (labelEl) labelEl.textContent = slideData[currentSlide].label;
  if (visEl) visEl.style.background = slideData[currentSlide].bg;
}
function stepSlide(dir) { goSlide(currentSlide + dir); }

(function initSliderSwipe() {
  let startX = 0;
  document.addEventListener('DOMContentLoaded', () => {
    const slider = document.getElementById('solSlider');
    if (!slider) return;
    slider.addEventListener('touchstart', e => { startX = e.touches[0].clientX; }, { passive: true });
    slider.addEventListener('touchend', e => {
      const dx = e.changedTouches[0].clientX - startX;
      if (Math.abs(dx) > 50) stepSlide(dx < 0 ? 1 : -1);
    }, { passive: true });
  });
})();

/* ═══════════════════════════════════════════════════════
   RESOURCE TABS — internal helpers (don't push history)
═══════════════════════════════════════════════════════ */
function _activateResTab(id) {
  document.querySelectorAll('.res-tab').forEach(btn => {
    btn.classList.toggle('active', btn.dataset.res === id);
  });
  document.querySelectorAll('.res-panel').forEach(p => p.classList.remove('active'));
  const panel = document.getElementById('panel-' + id);
  if (panel) panel.classList.add('active');
  setTimeout(triggerReveals, 60);
}

function _activateCatTab(category, tab) {
  const panel = document.getElementById('panel-' + category);
  if (!panel) return;
  panel.querySelectorAll('.cat-tab').forEach(btn => {
    btn.classList.toggle('active', btn.dataset.tab === tab);
  });
  panel.querySelectorAll('.cat-panel').forEach(p => p.classList.remove('active'));
  const catPanel = document.getElementById(category + '-' + tab);
  if (catPanel) catPanel.classList.add('active');
}

/* Public versions — these push to history so URL updates */
function setResTab(id) {
  if (currentRoute.page !== 'resources') {
    goTo({ page: 'resources', category: id === 'overview' ? null : id });
    return;
  }
  goTo({ page: 'resources', category: id === 'overview' ? null : id });
}

function setCatTab(category, tab) {
  goTo({ page: 'resources', category, tab });
}

/* ═══════════════════════════════════════════════════════
   RESOURCES — ARTICLE / CALCULATOR / VIDEO STORE
   Slug-keyed library of full content for deep-linked items.
   Add new entries here to make them shareable as URLs.
═══════════════════════════════════════════════════════ */
const RESOURCE_LIBRARY = {
  // ─── RETIREMENT ARTICLES ────────────────────────────────
  'tis-the-season-of-rmds': {
    kind: 'article', category: 'retirement', categoryLabel: 'Retirement',
    title: "'Tis the Season of RMDs",
    author: 'Stephen Melchiorre', date: 'Dec 11, 2023', readTime: '5 min read',
    excerpt: "For financial professionals, the end of the year isn't just for holidays — it's required minimum distribution season.",
    body: `
      <p>For many retirees, December isn't just about holidays — it's the deadline for taking Required Minimum Distributions (RMDs) from tax-deferred retirement accounts. Missing the deadline carries one of the steepest penalties in the tax code: up to 25% of the amount you should have withdrawn.</p>
      <h3>What Triggers an RMD?</h3>
      <p>Under current law, you generally must begin RMDs from traditional IRAs, 401(k)s, and most other tax-deferred accounts beginning the year you turn 73. The SECURE 2.0 Act pushed this back from age 72, with another step up to age 75 scheduled for 2033.</p>
      <h3>Calculating Your RMD</h3>
      <p>Your RMD is calculated by dividing the prior year-end balance of each account by a life expectancy factor from the IRS Uniform Lifetime Table. Most account custodians will calculate this for you — but ultimately the responsibility falls on you to take the distribution.</p>
      <h3>Strategies to Consider</h3>
      <p>A Qualified Charitable Distribution (QCD) lets account holders 70½ or older direct up to $105,000 (2024 limit) from an IRA directly to charity, satisfying RMD requirements while excluding the amount from taxable income. For some clients, Roth conversions in the years before RMDs kick in can dramatically reduce the size of future required withdrawals.</p>
      <p><em>This is general information, not tax advice. Talk with us and your tax professional about your specific situation.</em></p>
    `
  },
  'social-security-when-to-claim': {
    kind: 'article', category: 'retirement', categoryLabel: 'Retirement',
    title: 'Social Security: When Should You Claim?',
    author: 'Walter Eife', date: 'Jun 2, 2023', readTime: '7 min read',
    excerpt: 'One of the most consequential decisions in retirement planning — and one of the most personal.',
    body: `
      <p>You can claim Social Security as early as 62 or as late as 70. The difference between those two endpoints can amount to a 77% swing in your monthly benefit — for the rest of your life.</p>
      <h3>The Three Anchors</h3>
      <p><strong>Age 62</strong> — earliest eligibility. Benefits are reduced ~30% from your "full retirement age" amount.</p>
      <p><strong>Full Retirement Age (FRA)</strong> — between 66 and 67 depending on birth year. You receive 100% of your calculated benefit.</p>
      <p><strong>Age 70</strong> — every year you delay past FRA adds 8% to your benefit. There's no advantage to waiting past 70.</p>
      <h3>What Should Drive Your Decision?</h3>
      <p>Three factors matter most: your health and likely longevity, whether you're still working, and how much you depend on the benefit. There's no universal "right" answer — but there is a right answer for your situation, and we can model it.</p>
    `
  },
  'inflation-and-your-retirement': {
    kind: 'article', category: 'retirement', categoryLabel: 'Retirement',
    title: 'Inflation and Your Retirement',
    author: 'Kevin J. Gianfortune', date: 'Mar 15, 2023', readTime: '4 min read',
    excerpt: 'Why the silent erosion of purchasing power may be the biggest risk to a 30-year retirement.',
    body: `
      <p>At 3% annual inflation, the purchasing power of $100,000 today is roughly $55,000 in 20 years. That's the math no retirement plan can ignore.</p>
      <p>The traditional view of retirement as a "safe" phase — pile up bonds and CDs, draw 4% — works less and less well in a world where retirement may span 25 to 30 years. Inflation hedging, growth-oriented allocations, and inflation-linked income streams (Social Security, TIPS, dividend-growth stocks) all play a role in a modern retirement plan.</p>
    `
  },

  // ─── INVESTMENT ARTICLES ────────────────────────────────
  'investing-through-election-cycles': {
    kind: 'article', category: 'investment', categoryLabel: 'Investment',
    title: 'Investing Through Election Cycles',
    author: 'James Owens', date: 'Sep 11, 2024', readTime: '6 min read',
    excerpt: 'What history tells us about markets during election years — and what it means for your portfolio.',
    body: `
      <p>Every four years, anxious investors ask the same question: should I move to cash until the election is over? The historical data is clear: market timing around elections is a losing strategy.</p>
      <h3>The Data</h3>
      <p>Looking back over the last century, U.S. equity markets have delivered positive returns in election years roughly 75% of the time — regardless of which party won. Going to cash and missing even the best 10 days of a decade can cut your returns nearly in half.</p>
      <h3>What Actually Matters</h3>
      <p>The composition of Congress, the trajectory of interest rates, and corporate earnings have historically had far more influence on returns than the identity of the President. Tune out the noise. Stay invested. Rebalance on schedule.</p>
    `
  },
  'investment-classroom-bond-basics': {
    kind: 'article', category: 'investment', categoryLabel: 'Investment',
    title: 'Investment Classroom: Bond Basics',
    author: 'Kevin J. Gianfortune', date: 'Nov 3, 2023', readTime: '5 min read',
    excerpt: 'A loan to a corporation or government — and a critical building block of diversified portfolios.',
    body: `
      <p>When you buy a bond, you're lending money. The issuer agrees to pay you interest at a fixed rate (the "coupon") and return the principal at a specified date (the "maturity").</p>
      <h3>Why Hold Bonds?</h3>
      <p>Bonds historically provide three benefits to a portfolio: income, stability, and diversification. When equity markets fall, high-quality bonds have often held their value or appreciated, cushioning the overall portfolio.</p>
      <h3>The Risks</h3>
      <p>Interest rate risk: when rates rise, existing bond prices fall. Credit risk: the issuer may default. Inflation risk: a fixed coupon loses purchasing power over time. Understanding these tradeoffs is the foundation of bond investing.</p>
    `
  },

  // ─── ESTATE ARTICLES ────────────────────────────────────
  'year-end-charitable-gifting': {
    kind: 'article', category: 'estate', categoryLabel: 'Estate',
    title: 'Year-End Charitable Gifting and You',
    author: 'Kevin J. Gianfortune', date: 'Nov 20, 2023', readTime: '4 min read',
    excerpt: 'Smart gifting strategies that maximize impact for charity and minimize taxes for you.',
    body: `
      <p>Year-end charitable giving offers some of the most powerful tax-planning levers available — but only if you act before December 31st.</p>
      <h3>Donate Appreciated Securities</h3>
      <p>Giving long-held appreciated stock directly to charity lets you deduct the full fair-market value and avoid capital gains tax entirely. The charity, being tax-exempt, can sell the position without owing tax either. It's one of the most efficient gifts available.</p>
      <h3>Donor-Advised Funds</h3>
      <p>A donor-advised fund (DAF) lets you take the deduction in a high-income year while spreading the actual gifts over time. Particularly useful in years with unusual income events — business sales, Roth conversions, large bonuses.</p>
    `
  },

  // ─── INSURANCE ARTICLES ─────────────────────────────────
  'how-much-life-insurance': {
    kind: 'article', category: 'insurance', categoryLabel: 'Insurance',
    title: 'How Much Life Insurance Do You Really Need?',
    author: 'Cael Evans', date: 'Aug 28, 2023', readTime: '5 min read',
    excerpt: 'The right amount of life insurance is rarely a round number — and rarely what an agent suggests.',
    body: `
      <p>"Ten times your income" is the rule of thumb you'll hear most often. It's a fine starting point — but a poor finishing point.</p>
      <h3>Needs-Based Analysis</h3>
      <p>A proper life insurance analysis looks at the specific financial obligations your death would create or accelerate: outstanding mortgage, future college costs, spousal income replacement to a defined age, final expenses. Then it credits existing resources: retirement accounts, employer life insurance, surviving spouse's earning capacity.</p>
      <p>The result is rarely a round multiple of income. It's a specific dollar figure tied to your specific situation.</p>
    `
  },

  // ─── TAX ARTICLES ───────────────────────────────────────
  'roth-conversions-timing': {
    kind: 'article', category: 'tax', categoryLabel: 'Tax',
    title: 'Roth Conversions: Is Now the Right Time?',
    author: 'Kevin J. Gianfortune', date: 'Apr 18, 2023', readTime: '6 min read',
    excerpt: 'With tax rates in flux, the math on Roth conversions changes every year.',
    body: `
      <p>A Roth conversion moves money from a traditional IRA (where it grows tax-deferred and is taxed at withdrawal) to a Roth IRA (where it grows tax-free and is withdrawn tax-free). The tradeoff: you pay income tax on the converted amount today.</p>
      <h3>When the Math Works</h3>
      <p>Conversions tend to make sense when your current tax bracket is lower than the one you expect in retirement, or when you want to reduce future RMDs (Roth IRAs aren't subject to lifetime RMDs for the original owner).</p>
      <h3>Partial Conversions</h3>
      <p>Few people benefit from converting a large IRA all at once. Multi-year partial conversions — "filling up" the lower tax brackets each year — are usually more efficient. The window between retirement and RMD age is often prime conversion territory.</p>
    `
  },

  // ─── LIFESTYLE ARTICLES ─────────────────────────────────
  'keeping-up-with-the-joneses': {
    kind: 'article', category: 'lifestyle', categoryLabel: 'Lifestyle',
    title: 'Keeping Up with the Joneses',
    author: 'Stephen Melchiorre', date: 'Jul 12, 2023', readTime: '4 min read',
    excerpt: 'The biggest threat to your financial plan might be the lifestyle of the people around you.',
    body: `
      <p>"The Joneses" used to be your neighbors. Today, thanks to social media, they're everyone — and they all seem to be on vacation, driving newer cars, and renovating their kitchens.</p>
      <p>Lifestyle creep is the silent killer of long-term wealth. Every salary bump quietly raises your baseline expenses, and the savings rate that felt generous at 30 feels impossible at 45.</p>
      <h3>The Fix</h3>
      <p>Automate first. Save before you see the money. Tie new income to new savings rather than new spending. And remember: the people whose lifestyles you envy may be deeply in debt for the privilege of displaying them.</p>
    `
  },
  'mortgages-in-retirement': {
    kind: 'article', category: 'lifestyle', categoryLabel: 'Lifestyle',
    title: 'Mortgages in Retirement',
    author: 'Walter Eife', date: 'May 8, 2023', readTime: '5 min read',
    excerpt: 'Should you pay off the house before retiring? The right answer is more nuanced than you might think.',
    body: `
      <p>Conventional wisdom says: enter retirement debt-free. But a low-rate, fixed-payment mortgage in a high-inflation environment is a different beast than a credit card balance — and paying it off may not be the optimal move.</p>
      <h3>The Real Question</h3>
      <p>What's the after-tax cost of your mortgage, and what's the realistic after-tax return on the money you'd use to pay it off? When mortgage rates are 3%, paying off becomes a "guaranteed 3% return" — which is unattractive compared to most diversified portfolios over 10+ year horizons. At 7%, the math flips.</p>
    `
  },

  // ─── CALCULATORS (stub entries — link to fuller tools later) ─────
  'saving-for-retirement': {
    kind: 'calculator', category: 'retirement', categoryLabel: 'Retirement',
    title: 'Saving for Retirement',
    excerpt: 'Estimate whether your current savings rate will meet your retirement income goals.',
    body: `<p>This calculator is being built into the site. In the meantime, let's run the numbers together — we use professional planning software that models taxes, inflation, and market volatility year by year.</p>`
  },
  'compound-interest': {
    kind: 'calculator', category: 'investment', categoryLabel: 'Investment',
    title: 'How Compound Interest Works',
    excerpt: 'Visualize the long-term power of time and compounding on a regular savings habit.',
    body: `<p>Coming soon. The short answer: a 25-year-old who saves $500/month at a 7% return retires with roughly $1.3M at 65. A 35-year-old saving the same amount accumulates roughly $610K. Time matters more than amount.</p>`
  },
  'estate-tax': {
    kind: 'calculator', category: 'estate', categoryLabel: 'Estate',
    title: "What's My Potential Estate Tax?",
    excerpt: 'Estimate federal and state estate tax exposure based on your net worth.',
    body: `<p>The 2024 federal estate tax exemption is $13.61M per individual ($27.22M per married couple), but this is scheduled to roughly halve at the end of 2025 unless Congress acts. State exemptions vary widely — New Jersey has no estate tax but a state inheritance tax; Pennsylvania has an inheritance tax on most heirs.</p>`
  },

  // ─── VIDEOS (stub) ──────────────────────────────────────
  'retirement-income-101': {
    kind: 'video', category: 'retirement', categoryLabel: 'Retirement',
    title: 'Retirement Income 101',
    excerpt: 'A walkthrough of the core building blocks of a sustainable retirement income strategy.',
    body: `<p>Video coming soon. In the meantime, the topics we cover: Social Security claiming, pension elections, the bucket strategy, the bond ladder, and the 4% rule (and why it's more guideline than gospel).</p>`
  },
};

/**
 * Show a single article/calculator/video in place of the resources tab content.
 */
function renderResourceSingle(kind, slug) {
  const data = RESOURCE_LIBRARY[slug];
  const container = document.getElementById('resourceSingleHost');
  if (!container) return;

  // Hide all panels and show the single host
  document.querySelectorAll('.res-panel').forEach(p => p.classList.remove('active'));
  document.querySelectorAll('.res-tab').forEach(b => b.classList.remove('active'));
  container.style.display = 'block';

  if (!data || data.kind !== kind) {
    container.innerHTML = `
      <div class="single-not-found">
        <p class="eyebrow">Not Found</p>
        <h2 class="display-title">We couldn't find that ${_esc(kind)}.</h2>
        <p class="body-copy">It may have been moved or renamed. Browse our full resource library to find what you're looking for.</p>
        <div style="margin-top:1.5rem;display:flex;gap:0.75rem;flex-wrap:wrap">
          <a class="btn btn-green" data-route href="${buildUrl({ page: 'resources' })}">Back to Resources</a>
          <a class="btn btn-outline-dark" data-route href="${buildUrl({ page: 'contact' })}">Ask Our Team</a>
        </div>
      </div>`;
    _wireRouteLinks(container);
    return;
  }

  const shareUrl = buildUrl({ page: 'resources', kind, slug });
  const kindLabel = kind === 'article' ? 'Article' : kind === 'calculator' ? 'Calculator' : 'Video';

  container.innerHTML = `
    <article class="single-article">
      <nav class="single-crumbs">
        <a data-route href="${buildUrl({ page: 'resources' })}">Resources</a>
        <span class="crumb-sep">/</span>
        <a data-route href="${buildUrl({ page: 'resources', category: data.category })}">${_esc(data.categoryLabel)}</a>
        <span class="crumb-sep">/</span>
        <span class="crumb-current">${_esc(kindLabel)}</span>
      </nav>

      <div class="single-header">
        <p class="single-kind">${_esc(kindLabel)} · ${_esc(data.categoryLabel)}</p>
        <h1 class="single-title">${_esc(data.title)}</h1>
        ${data.author ? `<p class="single-meta">By ${_esc(data.author)} · ${_esc(data.date || '')} ${data.readTime ? '· ' + _esc(data.readTime) : ''}</p>` : ''}
        ${data.excerpt ? `<p class="single-dek">${_esc(data.excerpt)}</p>` : ''}
      </div>

      <div class="single-body">${data.body || ''}</div>

      <div class="single-share">
        <div class="single-share-label">Share this ${_esc(kindLabel.toLowerCase())}</div>
        <div class="single-share-buttons">
          <button class="share-btn" onclick="shareUrl('${_esc(shareUrl)}', '${_esc(data.title)}', this)">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" width="14" height="14"><path d="M10 13a5 5 0 007.54.54l3-3a5 5 0 00-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 00-7.54-.54l-3 3a5 5 0 007.07 7.07l1.71-1.71"/></svg>
            Copy link
          </button>
          <a class="share-btn" target="_blank" rel="noopener"
             href="https://www.linkedin.com/sharing/share-offsite/?url=${encodeURIComponent(shareUrl)}">
            <svg viewBox="0 0 24 24" fill="currentColor" width="14" height="14"><path d="M19 3a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h14zM8 17v-7H6v7h2zm-1-8.1a1.15 1.15 0 100-2.3 1.15 1.15 0 000 2.3zM18 17v-4.1c0-2-1.1-2.9-2.5-2.9-1.2 0-1.8.7-2.1 1.1V10h-2v7h2v-3.9c0-.2 0-.4.1-.5.2-.4.5-.9 1.2-.9.9 0 1.3.7 1.3 1.7V17h2z"/></svg>
            LinkedIn
          </a>
          <a class="share-btn" target="_blank" rel="noopener"
             href="mailto:?subject=${encodeURIComponent(data.title)}&body=${encodeURIComponent('Thought you might find this useful: ' + shareUrl)}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" width="14" height="14"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
            Email
          </a>
        </div>
      </div>

      <div class="single-cta">
        <h3>Have a question on this topic?</h3>
        <p>Reach out and we'll help you think through how this applies to your specific situation.</p>
        <a class="btn btn-green" data-route href="${buildUrl({ page: 'contact' })}">Schedule a Conversation</a>
      </div>

      ${_relatedHTML(data.category, slug)}
    </article>
  `;

  _wireRouteLinks(container);
  setTimeout(triggerReveals, 60);
}

function hideResourceSingle() {
  const container = document.getElementById('resourceSingleHost');
  if (container) { container.style.display = 'none'; container.innerHTML = ''; }
}

function _relatedHTML(category, currentSlug) {
  const related = Object.entries(RESOURCE_LIBRARY)
    .filter(([slug, d]) => d.category === category && slug !== currentSlug && d.kind === 'article')
    .slice(0, 3);

  if (!related.length) return '';

  const cards = related.map(([slug, d]) => `
    <a class="related-card" data-route href="${buildUrl({ page: 'resources', kind: 'article', slug })}">
      <div class="related-kind">${_esc(d.categoryLabel)} · Article</div>
      <div class="related-title">${_esc(d.title)}</div>
      <div class="related-meta">${_esc(d.author || '')} ${d.date ? '· ' + _esc(d.date) : ''}</div>
    </a>
  `).join('');

  return `
    <div class="single-related">
      <h4 class="single-related-heading">More from ${_esc(related[0][1].categoryLabel)}</h4>
      <div class="single-related-grid">${cards}</div>
    </div>`;
}

/* ═══════════════════════════════════════════════════════
   INSIGHTS — single article view
   Lighter-weight version reusing the same RESOURCE_LIBRARY
   plus a small inline map of the static cards on the grid.
═══════════════════════════════════════════════════════ */
const INSIGHT_STATIC_LIBRARY = {
  'investing-through-election-cycles': RESOURCE_LIBRARY['investing-through-election-cycles'],
  'the-next-chapter-embracing-2024': {
    kind: 'article', category: 'planning', categoryLabel: 'Planning',
    title: 'The Next Chapter: Embracing 2024',
    author: 'James Owens', date: 'Jan 5, 2024', readTime: '4 min read',
    excerpt: "After years of COVID, inflation, and global uncertainty, the new year brings a chance to reflect — and reset.",
    body: `<p>The end of one year is rarely a clean line; it's a chance to take stock. We use January with our clients to revisit goals, rebalance portfolios, top off retirement contributions, and check beneficiary designations.</p><p>What changed in your life last year that should change your plan this year? That's the most valuable annual review question we ask.</p>`
  },
  'tis-the-season-of-rmds': RESOURCE_LIBRARY['tis-the-season-of-rmds'],
  'investment-classroom-bond-basics': RESOURCE_LIBRARY['investment-classroom-bond-basics'],
  'student-loans-restart': {
    kind: 'article', category: 'debt', categoryLabel: 'Debt',
    title: 'Student Loans Restart: The Economic Ripple',
    author: 'Stephen Melchiorre', date: 'Sep 26, 2023', readTime: '5 min read',
    excerpt: 'Repayment is back on — and the spillover effects extend well beyond borrowers themselves.',
    body: `<p>After more than three years of pause, federal student loan payments resumed in October 2023. The collective impact on household budgets is meaningful: roughly $70-100 billion redirected annually from discretionary spending back toward debt service.</p><p>For borrowers, the priority is understanding which income-driven repayment plan minimizes your monthly obligation while preserving forgiveness eligibility. For everyone else, the macro effect on retail spending, housing demand, and rates is worth tracking.</p>`
  },
  'building-your-emergency-fund': {
    kind: 'article', category: 'planning', categoryLabel: 'Planning',
    title: 'Building Your Emergency Fund',
    author: 'Kevin J. Gianfortune', date: 'Aug 14, 2023', readTime: '4 min read',
    excerpt: 'How much you actually need, where to keep it, and how to build it without disrupting other goals.',
    body: `<p>Three to six months of essential expenses is the standard answer, but it deserves nuance. Dual-income households with stable jobs can lean toward three; single-income households or those with variable income should aim for six or more.</p><p>The "where" matters as much as the "how much." Today's high-yield savings accounts offer 4%+ on FDIC-insured balances — there's no reason for an emergency fund to sit in a 0.01% checking account.</p>`
  },
  'social-security-when-to-claim': RESOURCE_LIBRARY['social-security-when-to-claim'],
  'roth-conversions-timing': RESOURCE_LIBRARY['roth-conversions-timing'],
};

function renderInsightSingle(slug) {
  const grid = document.getElementById('insightsGrid');
  const showBtn = document.getElementById('showAllBtn');
  const single = document.getElementById('insightSingleHost');
  if (!single) return;

  if (!slug) {
    single.style.display = 'none';
    single.innerHTML = '';
    if (grid) grid.style.display = '';
    if (showBtn && showBtn.parentElement) showBtn.parentElement.style.display = '';
    return;
  }

  const data = INSIGHT_STATIC_LIBRARY[slug];
  if (grid) grid.style.display = 'none';
  if (showBtn && showBtn.parentElement) showBtn.parentElement.style.display = 'none';
  single.style.display = 'block';

  if (!data) {
    single.innerHTML = `
      <div class="single-not-found">
        <p class="eyebrow">Not Found</p>
        <h2 class="display-title">We couldn't find that article.</h2>
        <p class="body-copy">It may have been moved or renamed. Browse all Insights below.</p>
        <div style="margin-top:1.5rem">
          <a class="btn btn-green" data-route href="${buildUrl({ page: 'insights' })}">Back to Insights</a>
        </div>
      </div>`;
    _wireRouteLinks(single);
    return;
  }

  const shareUrl = buildUrl({ page: 'insights', slug });

  single.innerHTML = `
    <article class="single-article">
      <nav class="single-crumbs">
        <a data-route href="${buildUrl({ page: 'insights' })}">Insights</a>
        <span class="crumb-sep">/</span>
        <span class="crumb-current">${_esc(data.categoryLabel || 'Article')}</span>
      </nav>

      <div class="single-header">
        <p class="single-kind">Insight · ${_esc(data.categoryLabel || '')}</p>
        <h1 class="single-title">${_esc(data.title)}</h1>
        <p class="single-meta">By ${_esc(data.author)} · ${_esc(data.date)} ${data.readTime ? '· ' + _esc(data.readTime) : ''}</p>
        ${data.excerpt ? `<p class="single-dek">${_esc(data.excerpt)}</p>` : ''}
      </div>

      <div class="single-body">${data.body || ''}</div>

      <div class="single-share">
        <div class="single-share-label">Share this article</div>
        <div class="single-share-buttons">
          <button class="share-btn" onclick="shareUrl('${_esc(shareUrl)}', '${_esc(data.title)}', this)">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" width="14" height="14"><path d="M10 13a5 5 0 007.54.54l3-3a5 5 0 00-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 00-7.54-.54l-3 3a5 5 0 007.07 7.07l1.71-1.71"/></svg>
            Copy link
          </button>
          <a class="share-btn" target="_blank" rel="noopener"
             href="https://www.linkedin.com/sharing/share-offsite/?url=${encodeURIComponent(shareUrl)}">
            <svg viewBox="0 0 24 24" fill="currentColor" width="14" height="14"><path d="M19 3a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h14zM8 17v-7H6v7h2zm-1-8.1a1.15 1.15 0 100-2.3 1.15 1.15 0 000 2.3zM18 17v-4.1c0-2-1.1-2.9-2.5-2.9-1.2 0-1.8.7-2.1 1.1V10h-2v7h2v-3.9c0-.2 0-.4.1-.5.2-.4.5-.9 1.2-.9.9 0 1.3.7 1.3 1.7V17h2z"/></svg>
            LinkedIn
          </a>
          <a class="share-btn" target="_blank" rel="noopener"
             href="mailto:?subject=${encodeURIComponent(data.title)}&body=${encodeURIComponent('Thought you might find this useful: ' + shareUrl)}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" width="14" height="14"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
            Email
          </a>
        </div>
      </div>

      <div class="single-cta">
        <h3>Want to talk through this?</h3>
        <p>Reach out and we'll help you think through how this applies to your situation.</p>
        <a class="btn btn-green" data-route href="${buildUrl({ page: 'contact' })}">Schedule a Conversation</a>
      </div>
    </article>
  `;
  _wireRouteLinks(single);
  setTimeout(triggerReveals, 60);
}

/* ═══════════════════════════════════════════════════════
   SHARING — copy URL to clipboard
═══════════════════════════════════════════════════════ */
async function shareUrl(url, title, btnEl) {
  // Try Web Share API first (mobile)
  if (navigator.share) {
    try { await navigator.share({ title, url }); return; }
    catch (e) { /* fall through to clipboard */ }
  }
  try {
    await navigator.clipboard.writeText(url);
    if (btnEl) {
      const original = btnEl.innerHTML;
      btnEl.innerHTML = '✓ Link copied';
      btnEl.classList.add('copied');
      setTimeout(() => { btnEl.innerHTML = original; btnEl.classList.remove('copied'); }, 2000);
    }
  } catch (e) {
    window.prompt('Copy this link:', url);
  }
}

/* ═══════════════════════════════════════════════════════
   ROUTE LINK WIRING
   Any anchor with [data-route] is intercepted so clicking it
   becomes a router navigation instead of a full page reload.
═══════════════════════════════════════════════════════ */
function _wireRouteLinks(scope) {
  const root = scope || document;
  root.querySelectorAll('a[data-route]').forEach(a => {
    if (a._routeBound) return;
    a._routeBound = true;
    a.addEventListener('click', (ev) => {
      if (ev.metaKey || ev.ctrlKey || ev.shiftKey || ev.button !== 0) return;
      ev.preventDefault();
      const route = parseRoute(new URL(a.href, window.location.origin).pathname);
      goTo(route);
    });
  });
}

/* ═══════════════════════════════════════════════════════
   INSIGHTS — SHOW ALL (WordPress REST API version)
═══════════════════════════════════════════════════════ */
let insightsLoaded = false;

async function showAllInsightsWP() {
  const btn = document.getElementById('showAllBtn');
  if (btn) { btn.textContent = 'Loading…'; btn.disabled = true; }

  if (typeof fortuneData === 'undefined') {
    _showStaticExtraInsights(); return;
  }
  if (insightsLoaded) {
    _showStaticExtraInsights(); return;
  }

  try {
    const url = fortuneData.homeUrl + '/wp-json/fortune/v1/insights?per_page=100&page=1';
    const res  = await fetch(url);
    if (!res.ok) throw new Error('REST error ' + res.status);
    const data = await res.json();

    if (data.posts && data.posts.length > 6) {
      const grid = document.getElementById('insightsGrid');
      document.querySelectorAll('.extra-insight').forEach(el => el.remove());
      data.posts.slice(6).forEach(post => {
        const card = _buildInsightCard(post);
        grid.insertBefore(card, grid.lastElementChild);
      });
      insightsLoaded = true;
    } else {
      _showStaticExtraInsights();
    }
  } catch (err) {
    console.warn('Fortune REST API unavailable, showing static cards:', err.message);
    _showStaticExtraInsights();
  }

  if (btn) btn.style.display = 'none';
  setTimeout(triggerReveals, 60);
}

function _showStaticExtraInsights() {
  document.querySelectorAll('.extra-insight').forEach(el => el.classList.remove('hidden'));
  const btn = document.getElementById('showAllBtn');
  if (btn) btn.style.display = 'none';
  setTimeout(triggerReveals, 60);
}

function _buildInsightCard(post) {
  const card = document.createElement('div');
  card.className = 'insight-card reveal';
  const targetUrl = post.slug
    ? buildUrl({ page: 'insights', slug: post.slug })
    : post.link;
  card.innerHTML = `
    <div class="insight-card-accent"></div>
    <div class="insight-card-body">
      <div class="insight-tag">${_esc(post.category)}</div>
      <h3>${_esc(post.title)}</h3>
      <p>${_esc(post.excerpt)}</p>
      <div class="insight-footer">
        <span class="insight-author">${_esc(post.author)} · ${_esc(post.date)}</span>
        <a href="${_esc(targetUrl)}" class="insight-read" ${post.slug ? 'data-route' : 'target="_blank" rel="noopener"'}>Read →</a>
      </div>
    </div>`;
  _wireRouteLinks(card);
  return card;
}

function _esc(str) {
  if (str == null) return '';
  return String(str)
    .replace(/&/g, '&amp;').replace(/</g, '&lt;')
    .replace(/>/g, '&gt;').replace(/"/g, '&quot;')
    .replace(/'/g, '&#39;');
}

/* ═══════════════════════════════════════════════════════
   CONTACT FORM — WordPress AJAX version
═══════════════════════════════════════════════════════ */
async function fortuneSubmitForm(e) {
  e.preventDefault();
  const btn = document.getElementById('fortuneSubmitBtn');

  const fields = {
    first_name: document.getElementById('ff-first')?.value   || '',
    last_name:  document.getElementById('ff-last')?.value    || '',
    email:      document.getElementById('ff-email')?.value   || '',
    phone:      document.getElementById('ff-phone')?.value   || '',
    topic:      document.getElementById('ff-topic')?.value   || '',
    message:    document.getElementById('ff-message')?.value || '',
  };

  if (!fields.email || !fields.email.includes('@')) {
    _formFeedback('Please enter a valid email address.', false); return;
  }

  if (typeof fortuneData === 'undefined') {
    alert('Thank you! Please call us at (856) 454-5005 or email kevin.gianfortune@lpl.com'); return;
  }

  btn.textContent = 'Sending…'; btn.disabled = true;

  try {
    const body = new FormData();
    body.append('action', 'fortune_contact');
    body.append('nonce',  fortuneData.nonce);
    Object.entries(fields).forEach(([k, v]) => body.append(k, v));

    const res  = await fetch(fortuneData.ajaxUrl, { method: 'POST', body });
    const data = await res.json();

    if (data.success) {
      _formFeedback(data.data.message, true);
      ['ff-first','ff-last','ff-email','ff-phone','ff-message'].forEach(id => {
        const el = document.getElementById(id); if (el) el.value = '';
      });
      const topic = document.getElementById('ff-topic');
      if (topic) topic.selectedIndex = 0;
    } else {
      _formFeedback(data.data?.message || 'Something went wrong. Please call us directly.', false);
      btn.textContent = 'Send Message'; btn.disabled = false;
    }
  } catch (err) {
    _formFeedback('Network error. Please call (856) 454-5005.', false);
    btn.textContent = 'Send Message'; btn.disabled = false;
  }
}

function _formFeedback(msg, success) {
  let fb = document.getElementById('fortune-form-feedback');
  if (!fb) {
    fb = document.createElement('p');
    fb.id = 'fortune-form-feedback';
    fb.style.cssText = 'font-size:0.88rem;font-weight:500;margin-top:0.75rem;padding:0.75rem 1rem;border-radius:3px;';
    const btn = document.getElementById('fortuneSubmitBtn');
    if (btn) btn.insertAdjacentElement('afterend', fb);
  }
  fb.textContent     = msg;
  fb.style.background = success ? 'rgba(91,119,71,0.12)' : 'rgba(180,60,60,0.1)';
  fb.style.color      = success ? '#3d5c2e' : '#8b2a2a';
}

/* ═══════════════════════════════════════════════════════
   VIDEO HERO — graceful fallback
   The video element is positioned absolutely with object-fit cover.
   If load fails (no autoplay permission, network issue, missing source),
   the gradient background underneath shows through automatically.
═══════════════════════════════════════════════════════ */
function _initHeroVideo() {
  const vid = document.querySelector('#hero .hero-bg video');
  if (!vid) return;
  vid.addEventListener('error', () => { vid.style.display = 'none'; });
  // Some browsers block autoplay until "loadedmetadata" is fired
  vid.addEventListener('loadedmetadata', () => {
    const playPromise = vid.play();
    if (playPromise && playPromise.catch) playPromise.catch(() => { /* autoplay blocked, that's fine */ });
  });
}

/* ═══════════════════════════════════════════════════════
   ARTICLE / CALCULATOR LIST LINK WIRING
   Static <li> items in the resource panels become deep-linkable.
   Each clickable item carries data-slug and data-kind attributes;
   we delegate clicks at the document level so this works even if
   the markup is re-rendered.
═══════════════════════════════════════════════════════ */
document.addEventListener('click', (ev) => {
  const item = ev.target.closest('[data-resource-slug]');
  if (!item) return;
  const slug = item.getAttribute('data-resource-slug');
  const kind = item.getAttribute('data-resource-kind') || 'article';
  if (!slug) return;
  ev.preventDefault();
  goTo({ page: 'resources', kind, slug });
});

/* ═══════════ INIT — deep link + first load ═══════════ */
document.addEventListener('DOMContentLoaded', () => {
  const initialRoute = parseRoute(window.location.pathname);
  window.history.replaceState(initialRoute, '', window.location.href.replace(/\/$/, '') || '/');

  // Wire all pre-existing data-route anchors
  _wireRouteLinks(document);

  // Activate the correct view without pushing another history entry
  goTo(initialRoute, false);

  updateNavStyle();
  _initHeroVideo();
});
