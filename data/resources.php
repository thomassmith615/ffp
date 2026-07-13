<?php
/**
 * Fortune Financial Planning — content library.
 *
 * Canonical store for every article, calculator, and video on the site,
 * plus the resource category metadata. Loaded once by inc/library.php
 * and accessed through the ffp_*() helper functions.
 *
 * Item fields:
 *   kind         article | calculator | video
 *   category     resource category key (null = insights-only content)
 *   title        display title
 *   author/date/read_time   byline metadata (articles)
 *   sort         Y-m-d date used for ordering the insights feed
 *   excerpt      one-line summary (listings + meta description)
 *   body         full HTML body. Items WITHOUT a body are stubs:
 *                listed as "coming soon" and not routable.
 *   insight_tag  if set, the item also appears in the Insights feed
 *                under this tag label
 *   insight_dek  optional longer summary used on the Insights feed
 *
 * NOTE: All copy is placeholder wording pending final content from FFP.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

return [

	/* ─────────────────────────── CATEGORIES ─────────────────────────── */

	'categories' => [
		'retirement' => [
			'label'       => 'Retirement',
			'initial'     => 'R',
			'summary'     => "Income strategies, Social Security, IRAs, RMDs, and planning for the life you've worked toward.",
			'intro'       => "Planning for retirement is about much more than saving — it's about building a sustainable income strategy that lasts as long as you do. We help you coordinate every piece of the puzzle.",
			'blurb_title' => 'Making Your Savings Work for You',
			'blurb'       => 'Retirement income planning requires coordinating Social Security, pensions, IRA distributions, and investment portfolios into a coherent strategy. We help you model scenarios and stress-test your plan against inflation and healthcare costs.',
			'cta'         => 'Talk to Our Team',
		],
		'investment' => [
			'label'       => 'Investment',
			'initial'     => 'I',
			'summary'     => 'Portfolio fundamentals, compound interest, risk tolerance, college savings, and more.',
			'intro'       => 'Sound investing is less about picking winners and more about building a disciplined, diversified strategy that matches your goals and temperament — and sticking with it.',
			'blurb_title' => 'A Long-Term Perspective',
			'blurb'       => 'Markets will fluctuate, headlines will alarm, and emotion will tempt you to act. Our investment philosophy is built on evidence-based principles, appropriate diversification, and the discipline to stay the course when it matters most.',
			'cta'         => 'Discuss Your Portfolio',
		],
		'estate' => [
			'label'       => 'Estate Planning',
			'initial'     => 'E',
			'summary'     => "Wills, trusts, net worth, and estate tax — protecting what you've built for the people you love.",
			'intro'       => "Estate planning is about making sure your assets go where you intend, when you intend, with as little friction and tax burden as possible. It's one of the most important gifts you can give your family.",
			'blurb_title' => 'Protecting Your Legacy',
			'blurb'       => 'A proper estate plan coordinates your will, trusts, beneficiary designations, and insurance to ensure a seamless transition of wealth. We work alongside your estate attorney to make sure every piece aligns.',
			'cta'         => 'Talk Estate Planning',
		],
		'insurance' => [
			'label'       => 'Insurance',
			'initial'     => 'P',
			'summary'     => 'Life insurance needs, disability income, long-term care — understanding your coverage gaps.',
			'intro'       => "The right insurance coverage isn't about fear — it's about protecting the financial plan you've worked hard to build. We assess your needs across life, disability, and long-term care.",
			'blurb_title' => 'Closing the Gaps',
			'blurb'       => "Most people are either underinsured or paying for coverage they don't need. We conduct a comprehensive insurance review to identify where you're exposed and where you're over-paying.",
			'cta'         => 'Review My Coverage',
		],
		'tax' => [
			'label'       => 'Tax Planning',
			'initial'     => 'T',
			'summary'     => 'Federal income tax, capital gains, Social Security taxation, and year-end planning resources.',
			'intro'       => 'Our tax center was designed to help you access the resources you may need to prepare for the upcoming tax season — and plan proactively throughout the year.',
			'blurb_title' => 'Year-Round Tax Awareness',
			'blurb'       => 'The best tax planning happens throughout the year, not just in April. From Roth conversions to capital gains harvesting, we help you incorporate tax efficiency into every financial decision.',
			'cta'         => 'Talk to Our Team',
			'disclaimer'  => 'The information in this material is not intended as tax or legal advice. It may not be used for the purpose of avoiding any federal tax penalties. Please consult legal or tax professionals for specific information regarding your individual situation.',
		],
		'lifestyle' => [
			'label'       => 'Lifestyle',
			'initial'     => 'L',
			'summary'     => 'Buying vs. leasing, mortgage decisions, debt vs. investing — financial choices that shape daily life.',
			'intro'       => "The biggest financial decisions in life often don't feel like \"finance\" — they're about the car you drive, the home you own, and the debt you carry. We help you think through them clearly.",
			'blurb_title' => 'Everyday Money, Long-Term Impact',
			'blurb'       => "Small financial decisions compound over time. Whether you're weighing buying vs. renting, considering refinancing, or deciding between paying off debt and investing, the right framework can make a significant difference.",
			'cta'         => 'Talk to Our Team',
		],
	],

	/* ─────────────────────────── ITEMS ─────────────────────────── */

	'items' => [

		/* ── Retirement · articles ───────────────────────────────── */

		'tis-the-season-of-rmds' => [
			'kind' => 'article', 'category' => 'retirement',
			'title' => "'Tis the Season of RMDs",
			'author' => 'Stephen Melchiorre', 'date' => 'Dec 11, 2023', 'sort' => '2023-12-11', 'read_time' => '5 min read',
			'excerpt' => "For financial professionals, the end of the year isn't just for holidays — it's required minimum distribution season.",
			'insight_tag' => 'Retirement',
			'insight_dek' => "For financial professionals, the end of the year isn't just for holidays — it's required minimum distribution season. Here's what you need to know and act on before December 31st arrives.",
			'body' => <<<'HTML'
<p>For many retirees, December isn't just about holidays — it's the deadline for taking Required Minimum Distributions (RMDs) from tax-deferred retirement accounts. Missing the deadline carries one of the steepest penalties in the tax code: up to 25% of the amount you should have withdrawn.</p>
<h3>What Triggers an RMD?</h3>
<p>Under current law, you generally must begin RMDs from traditional IRAs, 401(k)s, and most other tax-deferred accounts beginning the year you turn 73. The SECURE 2.0 Act pushed this back from age 72, with another step up to age 75 scheduled for 2033.</p>
<h3>Calculating Your RMD</h3>
<p>Your RMD is calculated by dividing the prior year-end balance of each account by a life expectancy factor from the IRS Uniform Lifetime Table. Most account custodians will calculate this for you — but ultimately the responsibility falls on you to take the distribution.</p>
<h3>Strategies to Consider</h3>
<p>A Qualified Charitable Distribution (QCD) lets account holders 70½ or older direct up to $105,000 (2024 limit) from an IRA directly to charity, satisfying RMD requirements while excluding the amount from taxable income. For some clients, Roth conversions in the years before RMDs kick in can dramatically reduce the size of future required withdrawals.</p>
<p><em>This is general information, not tax advice. Talk with us and your tax professional about your specific situation.</em></p>
HTML,
		],

		'social-security-when-to-claim' => [
			'kind' => 'article', 'category' => 'retirement',
			'title' => 'Social Security: When Should You Claim?',
			'author' => 'Walter Eife', 'date' => 'Jun 2, 2023', 'sort' => '2023-06-02', 'read_time' => '7 min read',
			'excerpt' => 'One of the most consequential decisions in retirement planning — and one of the most personal.',
			'insight_tag' => 'Retirement',
			'insight_dek' => 'The decision of when to claim Social Security is one of the most consequential in retirement planning. We break down the tradeoffs between claiming early, at full retirement age, or waiting until 70.',
			'body' => <<<'HTML'
<p>You can claim Social Security as early as 62 or as late as 70. The difference between those two endpoints can amount to a 77% swing in your monthly benefit — for the rest of your life.</p>
<h3>The Three Anchors</h3>
<p><strong>Age 62</strong> — earliest eligibility. Benefits are reduced ~30% from your "full retirement age" amount.</p>
<p><strong>Full Retirement Age (FRA)</strong> — between 66 and 67 depending on birth year. You receive 100% of your calculated benefit.</p>
<p><strong>Age 70</strong> — every year you delay past FRA adds 8% to your benefit. There's no advantage to waiting past 70.</p>
<h3>What Should Drive Your Decision?</h3>
<p>Three factors matter most: your health and likely longevity, whether you're still working, and how much you depend on the benefit. There's no universal "right" answer — but there is a right answer for your situation, and we can model it.</p>
HTML,
		],

		'inflation-and-your-retirement' => [
			'kind' => 'article', 'category' => 'retirement',
			'title' => 'Inflation and Your Retirement',
			'author' => 'Kevin J. Gianfortune', 'date' => 'Mar 15, 2023', 'sort' => '2023-03-15', 'read_time' => '4 min read',
			'excerpt' => 'Why the silent erosion of purchasing power may be the biggest risk to a 30-year retirement.',
			'body' => <<<'HTML'
<p>At 3% annual inflation, the purchasing power of $100,000 today is roughly $55,000 in 20 years. That's the math no retirement plan can ignore.</p>
<p>The traditional view of retirement as a "safe" phase — pile up bonds and CDs, draw 4% — works less and less well in a world where retirement may span 25 to 30 years. Inflation hedging, growth-oriented allocations, and inflation-linked income streams (Social Security, TIPS, dividend-growth stocks) all play a role in a modern retirement plan.</p>
HTML,
		],

		'the-4-percent-rule'   => [ 'kind' => 'article', 'category' => 'retirement', 'title' => 'The 4% Rule — Is It Still Valid?' ],
		'roth-vs-traditional'  => [ 'kind' => 'article', 'category' => 'retirement', 'title' => 'Roth vs. Traditional: Which Is Right for You?' ],

		/* ── Retirement · calculators ────────────────────────────── */

		'saving-for-retirement' => [
			'kind' => 'calculator', 'category' => 'retirement',
			'title' => 'Saving for Retirement',
			'excerpt' => 'Estimate whether your current savings rate will meet your retirement income goals.',
			'body' => <<<'HTML'
<p>This calculator is being built into the site. In the meantime, let's run the numbers together — we use professional planning software that models taxes, inflation, and market volatility year by year.</p>
HTML,
		],

		'systematic-withdrawals'      => [ 'kind' => 'calculator', 'category' => 'retirement', 'title' => 'A Look at Systematic Withdrawals' ],
		'my-retirement-savings'       => [ 'kind' => 'calculator', 'category' => 'retirement', 'title' => 'My Retirement Savings' ],
		'roth-vs-traditional-401k'    => [ 'kind' => 'calculator', 'category' => 'retirement', 'title' => 'Roth 401(k) vs. Traditional 401(k)' ],
		'inflation-and-retirement'    => [ 'kind' => 'calculator', 'category' => 'retirement', 'title' => 'Inflation & Retirement' ],
		'potential-income-from-ira'   => [ 'kind' => 'calculator', 'category' => 'retirement', 'title' => 'Potential Income from an IRA' ],
		'estimate-your-rmd'           => [ 'kind' => 'calculator', 'category' => 'retirement', 'title' => 'Estimate Your RMD' ],
		'self-employed-plans'         => [ 'kind' => 'calculator', 'category' => 'retirement', 'title' => 'Self-Employed Retirement Plans' ],
		'annuity-comparison'          => [ 'kind' => 'calculator', 'category' => 'retirement', 'title' => 'Annuity Comparison' ],

		/* NOTE: videos live in data/videos.csv, not here. */

		/* ── Investment · articles ───────────────────────────────── */

		'investing-through-election-cycles' => [
			'kind' => 'article', 'category' => 'investment',
			'title' => 'Investing Through Election Cycles',
			'author' => 'James Owens', 'date' => 'Sep 11, 2024', 'sort' => '2024-09-11', 'read_time' => '6 min read',
			'excerpt' => 'What history tells us about markets during election years — and what it means for your portfolio.',
			'insight_tag' => 'Investing',
			'insight_dek' => 'The past several U.S. presidential elections have become increasingly divisive. We explore what history tells us about markets during election years — and what it means for your long-term portfolio strategy.',
			'body' => <<<'HTML'
<p>Every four years, anxious investors ask the same question: should I move to cash until the election is over? The historical data is clear: market timing around elections is a losing strategy.</p>
<h3>The Data</h3>
<p>Looking back over the last century, U.S. equity markets have delivered positive returns in election years roughly 75% of the time — regardless of which party won. Going to cash and missing even the best 10 days of a decade can cut your returns nearly in half.</p>
<h3>What Actually Matters</h3>
<p>The composition of Congress, the trajectory of interest rates, and corporate earnings have historically had far more influence on returns than the identity of the President. Tune out the noise. Stay invested. Rebalance on schedule.</p>
HTML,
		],

		'investment-classroom-bond-basics' => [
			'kind' => 'article', 'category' => 'investment',
			'title' => 'Investment Classroom: Bond Basics',
			'author' => 'Kevin J. Gianfortune', 'date' => 'Nov 3, 2023', 'sort' => '2023-11-03', 'read_time' => '5 min read',
			'excerpt' => 'A loan to a corporation or government — and a critical building block of diversified portfolios.',
			'insight_tag' => 'Investing',
			'insight_dek' => 'Bonds are a form of fixed-income investment representing a loan to a corporation or government. We break down how they work, why they belong in diversified portfolios, and how to think about them in your plan.',
			'body' => <<<'HTML'
<p>When you buy a bond, you're lending money. The issuer agrees to pay you interest at a fixed rate (the "coupon") and return the principal at a specified date (the "maturity").</p>
<h3>Why Hold Bonds?</h3>
<p>Bonds historically provide three benefits to a portfolio: income, stability, and diversification. When equity markets fall, high-quality bonds have often held their value or appreciated, cushioning the overall portfolio.</p>
<h3>The Risks</h3>
<p>Interest rate risk: when rates rise, existing bond prices fall. Credit risk: the issuer may default. Inflation risk: a fixed coupon loses purchasing power over time. Understanding these tradeoffs is the foundation of bond investing.</p>
HTML,
		],

		'understanding-asset-allocation' => [ 'kind' => 'article', 'category' => 'investment', 'title' => 'Understanding Asset Allocation' ],
		'the-power-of-compounding'       => [ 'kind' => 'article', 'category' => 'investment', 'title' => 'The Power of Compounding' ],
		'dollar-cost-averaging'          => [ 'kind' => 'article', 'category' => 'investment', 'title' => 'Dollar-Cost Averaging Explained' ],

		/* ── Investment · calculators ────────────────────────────── */

		'compound-interest' => [
			'kind' => 'calculator', 'category' => 'investment',
			'title' => 'How Compound Interest Works',
			'excerpt' => 'Visualize the long-term power of time and compounding on a regular savings habit.',
			'body' => <<<'HTML'
<p>Coming soon. The short answer: a 25-year-old who saves $500/month at a 7% return retires with roughly $1.3M at 65. A 35-year-old saving the same amount accumulates roughly $610K. Time matters more than amount.</p>
HTML,
		],

		'taxable-vs-tax-deferred'     => [ 'kind' => 'calculator', 'category' => 'investment', 'title' => 'Taxable vs. Tax-Deferred Savings' ],
		'risk-tolerance'              => [ 'kind' => 'calculator', 'category' => 'investment', 'title' => 'What Is My Risk Tolerance?' ],
		'dividend-yield'              => [ 'kind' => 'calculator', 'category' => 'investment', 'title' => 'What Is the Dividend Yield?' ],
		'impact-of-taxes-inflation'   => [ 'kind' => 'calculator', 'category' => 'investment', 'title' => 'Impact of Taxes and Inflation' ],
		'saving-for-college'          => [ 'kind' => 'calculator', 'category' => 'investment', 'title' => 'Saving for College' ],
		'contributing-to-an-ira'      => [ 'kind' => 'calculator', 'category' => 'investment', 'title' => 'Contributing to an IRA?' ],

		/* ── Estate · articles ───────────────────────────────────── */

		'year-end-charitable-gifting' => [
			'kind' => 'article', 'category' => 'estate',
			'title' => 'Year-End Charitable Gifting and You',
			'author' => 'Kevin J. Gianfortune', 'date' => 'Nov 20, 2023', 'sort' => '2023-11-20', 'read_time' => '4 min read',
			'excerpt' => 'Smart gifting strategies that maximize impact for charity and minimize taxes for you.',
			'body' => <<<'HTML'
<p>Year-end charitable giving offers some of the most powerful tax-planning levers available — but only if you act before December 31st.</p>
<h3>Donate Appreciated Securities</h3>
<p>Giving long-held appreciated stock directly to charity lets you deduct the full fair-market value and avoid capital gains tax entirely. The charity, being tax-exempt, can sell the position without owing tax either. It's one of the most efficient gifts available.</p>
<h3>Donor-Advised Funds</h3>
<p>A donor-advised fund (DAF) lets you take the deduction in a high-income year while spreading the actual gifts over time. Particularly useful in years with unusual income events — business sales, Roth conversions, large bonuses.</p>
HTML,
		],

		'understanding-the-estate-tax' => [ 'kind' => 'article', 'category' => 'estate', 'title' => 'Understanding the Estate Tax' ],
		'beneficiary-designations'     => [ 'kind' => 'article', 'category' => 'estate', 'title' => "Beneficiary Designations: Don't Overlook Them" ],
		'trusts-101'                   => [ 'kind' => 'article', 'category' => 'estate', 'title' => 'Trusts 101: Which Type Is Right for You?' ],

		/* ── Estate · calculators ────────────────────────────────── */

		'estate-tax' => [
			'kind' => 'calculator', 'category' => 'estate',
			'title' => "What's My Potential Estate Tax?",
			'excerpt' => 'Estimate federal and state estate tax exposure based on your net worth.',
			'body' => <<<'HTML'
<p>The 2024 federal estate tax exemption is $13.61M per individual ($27.22M per married couple), but this is scheduled to roughly halve at the end of 2025 unless Congress acts. State exemptions vary widely — New Jersey has no estate tax but a state inheritance tax; Pennsylvania has an inheritance tax on most heirs.</p>
HTML,
		],

		'life-expectancy'   => [ 'kind' => 'calculator', 'category' => 'estate', 'title' => 'What Is My Life Expectancy?' ],
		'current-net-worth' => [ 'kind' => 'calculator', 'category' => 'estate', 'title' => 'What Is My Current Net Worth?' ],

		/* ── Insurance · articles ────────────────────────────────── */

		'how-much-life-insurance' => [
			'kind' => 'article', 'category' => 'insurance',
			'title' => 'How Much Life Insurance Do You Really Need?',
			'author' => 'Cael Evans', 'date' => 'Aug 28, 2023', 'sort' => '2023-08-28', 'read_time' => '5 min read',
			'excerpt' => 'The right amount of life insurance is rarely a round number — and rarely what an agent suggests.',
			'body' => <<<'HTML'
<p>"Ten times your income" is the rule of thumb you'll hear most often. It's a fine starting point — but a poor finishing point.</p>
<h3>Needs-Based Analysis</h3>
<p>A proper life insurance analysis looks at the specific financial obligations your death would create or accelerate: outstanding mortgage, future college costs, spousal income replacement to a defined age, final expenses. Then it credits existing resources: retirement accounts, employer life insurance, surviving spouse's earning capacity.</p>
<p>The result is rarely a round multiple of income. It's a specific dollar figure tied to your specific situation.</p>
HTML,
		],

		'long-term-care-planning'  => [ 'kind' => 'article', 'category' => 'insurance', 'title' => 'Long-Term Care: Planning Before You Need It' ],
		'disability-insurance'     => [ 'kind' => 'article', 'category' => 'insurance', 'title' => 'Disability Insurance: Your Most Overlooked Asset' ],
		'term-vs-permanent'        => [ 'kind' => 'article', 'category' => 'insurance', 'title' => 'Term vs. Permanent Life Insurance' ],

		/* ── Insurance · calculators ─────────────────────────────── */

		'life-insurance-needs'  => [ 'kind' => 'calculator', 'category' => 'insurance', 'title' => 'Assess Your Life Insurance Needs' ],
		'lifetime-of-earnings'  => [ 'kind' => 'calculator', 'category' => 'insurance', 'title' => 'Lifetime of Earnings' ],
		'disability-income'     => [ 'kind' => 'calculator', 'category' => 'insurance', 'title' => 'Disability Income' ],
		'long-term-care-needs'  => [ 'kind' => 'calculator', 'category' => 'insurance', 'title' => 'Long-Term Care Needs' ],

		/* ── Tax · articles ──────────────────────────────────────── */

		'roth-conversions-timing' => [
			'kind' => 'article', 'category' => 'tax',
			'title' => 'Roth Conversions: Is Now the Right Time?',
			'author' => 'Kevin J. Gianfortune', 'date' => 'Apr 18, 2023', 'sort' => '2023-04-18', 'read_time' => '6 min read',
			'excerpt' => 'With tax rates in flux, the math on Roth conversions changes every year.',
			'insight_tag' => 'Tax',
			'insight_dek' => 'With tax rates in flux, many clients are asking whether a Roth conversion makes sense. We walk through the key factors to consider and when a partial conversion strategy might be most advantageous.',
			'body' => <<<'HTML'
<p>A Roth conversion moves money from a traditional IRA (where it grows tax-deferred and is taxed at withdrawal) to a Roth IRA (where it grows tax-free and is withdrawn tax-free). The tradeoff: you pay income tax on the converted amount today.</p>
<h3>When the Math Works</h3>
<p>Conversions tend to make sense when your current tax bracket is lower than the one you expect in retirement, or when you want to reduce future RMDs (Roth IRAs aren't subject to lifetime RMDs for the original owner).</p>
<h3>Partial Conversions</h3>
<p>Few people benefit from converting a large IRA all at once. Multi-year partial conversions — "filling up" the lower tax brackets each year — are usually more efficient. The window between retirement and RMD age is often prime conversion territory.</p>
HTML,
		],

		'year-end-tax-checklist'  => [ 'kind' => 'article', 'category' => 'tax', 'title' => 'Year-End Tax Planning Checklist' ],
		'capital-gains-explained' => [ 'kind' => 'article', 'category' => 'tax', 'title' => 'Capital Gains: Short vs. Long-Term' ],
		'tax-loss-harvesting'     => [ 'kind' => 'article', 'category' => 'tax', 'title' => 'Tax-Loss Harvesting Explained' ],

		/* ── Tax · calculators ───────────────────────────────────── */

		'federal-income-tax'     => [ 'kind' => 'calculator', 'category' => 'tax', 'title' => 'Federal Income Tax' ],
		'capital-gains-tax'      => [ 'kind' => 'calculator', 'category' => 'tax', 'title' => 'Capital Gains Tax Estimator' ],
		'social-security-taxes'  => [ 'kind' => 'calculator', 'category' => 'tax', 'title' => 'Social Security Taxes' ],
		'tax-freedom-day'        => [ 'kind' => 'calculator', 'category' => 'tax', 'title' => 'Tax Freedom Day' ],
		'home-mortgage-deduction'=> [ 'kind' => 'calculator', 'category' => 'tax', 'title' => 'Home Mortgage Deduction' ],
		'comparing-investments'  => [ 'kind' => 'calculator', 'category' => 'tax', 'title' => 'Comparing Investments (Tax Impact)' ],

		/* ── Lifestyle · articles ────────────────────────────────── */

		'keeping-up-with-the-joneses' => [
			'kind' => 'article', 'category' => 'lifestyle',
			'title' => 'Keeping Up with the Joneses',
			'author' => 'Stephen Melchiorre', 'date' => 'Jul 12, 2023', 'sort' => '2023-07-12', 'read_time' => '4 min read',
			'excerpt' => 'The biggest threat to your financial plan might be the lifestyle of the people around you.',
			'body' => <<<'HTML'
<p>"The Joneses" used to be your neighbors. Today, thanks to social media, they're everyone — and they all seem to be on vacation, driving newer cars, and renovating their kitchens.</p>
<p>Lifestyle creep is the silent killer of long-term wealth. Every salary bump quietly raises your baseline expenses, and the savings rate that felt generous at 30 feels impossible at 45.</p>
<h3>The Fix</h3>
<p>Automate first. Save before you see the money. Tie new income to new savings rather than new spending. And remember: the people whose lifestyles you envy may be deeply in debt for the privilege of displaying them.</p>
HTML,
		],

		'mortgages-in-retirement' => [
			'kind' => 'article', 'category' => 'lifestyle',
			'title' => 'Mortgages in Retirement',
			'author' => 'Walter Eife', 'date' => 'May 8, 2023', 'sort' => '2023-05-08', 'read_time' => '5 min read',
			'excerpt' => 'Should you pay off the house before retiring? The right answer is more nuanced than you might think.',
			'body' => <<<'HTML'
<p>Conventional wisdom says: enter retirement debt-free. But a low-rate, fixed-payment mortgage in a high-inflation environment is a different beast than a credit card balance — and paying it off may not be the optimal move.</p>
<h3>The Real Question</h3>
<p>What's the after-tax cost of your mortgage, and what's the realistic after-tax return on the money you'd use to pay it off? When mortgage rates are 3%, paying off becomes a "guaranteed 3% return" — which is unattractive compared to most diversified portfolios over 10+ year horizons. At 7%, the math flips.</p>
HTML,
		],

		'saving-for-college-101'        => [ 'kind' => 'article', 'category' => 'lifestyle', 'title' => 'Saving for College 101' ],
		'pay-yourself-first'            => [ 'kind' => 'article', 'category' => 'lifestyle', 'title' => 'Pay Yourself First' ],
		'solid-financial-foundation'    => [ 'kind' => 'article', 'category' => 'lifestyle', 'title' => 'Building a Solid Financial Foundation' ],
		'kids-decide-against-college'   => [ 'kind' => 'article', 'category' => 'lifestyle', 'title' => 'What If Your Kids Decide Against College?' ],

		/* ── Lifestyle · calculators ─────────────────────────────── */

		'buy-or-lease-auto'      => [ 'kind' => 'calculator', 'category' => 'lifestyle', 'title' => 'Should I Buy or Lease an Auto?' ],
		'pay-off-debt-or-invest' => [ 'kind' => 'calculator', 'category' => 'lifestyle', 'title' => 'Should I Pay Off Debt or Invest?' ],
		'how-much-home'          => [ 'kind' => 'calculator', 'category' => 'lifestyle', 'title' => 'How Much Home Can I Afford?' ],
		'refinance-mortgage'     => [ 'kind' => 'calculator', 'category' => 'lifestyle', 'title' => 'Can I Refinance My Mortgage?' ],
		'comparing-mortgage-terms' => [ 'kind' => 'calculator', 'category' => 'lifestyle', 'title' => 'Comparing Mortgage Terms' ],
		'bi-weekly-payments'     => [ 'kind' => 'calculator', 'category' => 'lifestyle', 'title' => 'Bi-Weekly Payments' ],
		'fuel-efficient-car'     => [ 'kind' => 'calculator', 'category' => 'lifestyle', 'title' => 'Interested in a Fuel Efficient Car?' ],
		'current-cash-flow'      => [ 'kind' => 'calculator', 'category' => 'lifestyle', 'title' => 'What Is My Current Cash Flow?' ],
		'historical-inflation'   => [ 'kind' => 'calculator', 'category' => 'lifestyle', 'title' => 'Historical Inflation' ],

		/* ── Insights-only articles (not listed under Resources) ─── */

		'the-next-chapter-embracing-2024' => [
			'kind' => 'article', 'category' => null,
			'title' => 'The Next Chapter: Embracing 2024',
			'author' => 'James Owens', 'date' => 'Jan 5, 2024', 'sort' => '2024-01-05', 'read_time' => '4 min read',
			'excerpt' => 'After years of COVID, inflation, and global uncertainty, the new year brings a chance to reflect — and reset.',
			'insight_tag' => 'Planning',
			'insight_dek' => "It's time to take a deep breath. After years of COVID, inflation, and global uncertainty, the new year brings an opportunity to reflect on where we've been and set a clear intention for what comes next.",
			'body' => <<<'HTML'
<p>The end of one year is rarely a clean line; it's a chance to take stock. We use January with our clients to revisit goals, rebalance portfolios, top off retirement contributions, and check beneficiary designations.</p>
<p>What changed in your life last year that should change your plan this year? That's the most valuable annual review question we ask.</p>
HTML,
		],

		'student-loans-restart' => [
			'kind' => 'article', 'category' => null,
			'title' => 'Student Loans Restart: The Economic Ripple',
			'author' => 'Stephen Melchiorre', 'date' => 'Sep 26, 2023', 'sort' => '2023-09-26', 'read_time' => '5 min read',
			'excerpt' => 'Repayment is back on — and the spillover effects extend well beyond borrowers themselves.',
			'insight_tag' => 'Debt',
			'insight_dek' => 'Student loan obligations have surpassed auto loans and credit card debt for millions of Americans. We look at the economic ripple effects of the repayment restart and how to position your finances accordingly.',
			'body' => <<<'HTML'
<p>After more than three years of pause, federal student loan payments resumed in October 2023. The collective impact on household budgets is meaningful: roughly $70-100 billion redirected annually from discretionary spending back toward debt service.</p>
<p>For borrowers, the priority is understanding which income-driven repayment plan minimizes your monthly obligation while preserving forgiveness eligibility. For everyone else, the macro effect on retail spending, housing demand, and rates is worth tracking.</p>
HTML,
		],

		'building-your-emergency-fund' => [
			'kind' => 'article', 'category' => null,
			'title' => 'Building Your Emergency Fund',
			'author' => 'Kevin J. Gianfortune', 'date' => 'Aug 14, 2023', 'sort' => '2023-08-14', 'read_time' => '4 min read',
			'excerpt' => 'How much you actually need, where to keep it, and how to build it without disrupting other goals.',
			'insight_tag' => 'Planning',
			'insight_dek' => 'An emergency fund is the cornerstone of any sound financial plan. We walk through how much you actually need, where to keep it, and how to build it without disrupting your other savings goals.',
			'body' => <<<'HTML'
<p>Three to six months of essential expenses is the standard answer, but it deserves nuance. Dual-income households with stable jobs can lean toward three; single-income households or those with variable income should aim for six or more.</p>
<p>The "where" matters as much as the "how much." Today's high-yield savings accounts offer 4%+ on FDIC-insured balances — there's no reason for an emergency fund to sit in a 0.01% checking account.</p>
HTML,
		],

	],
];
