<?php
/**
 * Fortune Financial Planning — solutions.
 *
 * Each solution is a row on the /solutions/ index and a full page at
 * /solutions/{slug}/. The Employer Sponsored Plans copy is
 * client-approved wording (Walt) and must not be edited; the other
 * five are placeholder copy pending final wording.
 *
 * Fields:
 *   title   page + index row title
 *   teaser  one-liner shown on the index row (first sentence of copy)
 *   copy    full page paragraphs
 *   topics  small-caps topic list shown on the page
 */

if ( ! defined( 'ABSPATH' ) ) exit;

return [

	'financial-planning' => [
		'title'  => 'Financial Planning',
		'teaser' => "A comprehensive financial plan isn't just a document — it's a living strategy built around your specific goals, timeline, and risk tolerance.",
		'copy'   => [
			"A comprehensive financial plan isn't just a document — it's a living strategy built around your specific goals, timeline, and risk tolerance. We create clear roadmaps with built-in accountability systems, so progress is measurable and adjustments happen proactively. Whether you're early in your career, mid-life, or approaching a major transition, we provide the structure and guidance you need.",
		],
		'topics' => [ 'Goal Setting', 'Cash Flow', 'Net Worth', 'Accountability' ],
	],

	'investment-management' => [
		'title'  => 'Investment Management',
		'teaser' => 'We build and manage diversified investment portfolios aligned with your long-term philosophy, not short-term noise.',
		'copy'   => [
			"We build and manage diversified investment portfolios aligned with your long-term philosophy, not short-term noise. Rather than chasing performance or moving money constantly, we focus on disciplined, evidence-based strategies that let compounding do the work. We'll help you understand your true risk tolerance and design an allocation you can stay committed to through market cycles.",
		],
		'topics' => [ 'Portfolios', 'Risk Analysis', 'Diversification', 'Rebalancing' ],
	],

	'business-succession' => [
		'title'  => 'Business Succession',
		'teaser' => 'Business owners face a unique set of financial challenges — and opportunities.',
		'copy'   => [
			"Business owners face a unique set of financial challenges — and opportunities. We help you build personal wealth while running your business, design compensation and benefits structures that make tax sense, and plan a succession strategy well before you need it. Whether you're transitioning to family, partners, or a third-party buyer, we'll make sure you're financially prepared.",
		],
		'topics' => [ 'Exit Planning', 'Buy-Sell', 'Key Person', 'Business Valuation' ],
	],

	'estate-insurance' => [
		'title'  => 'Estate & Insurance',
		'teaser' => "Your estate plan is more than a will — it's a comprehensive strategy for passing wealth, minimizing taxes, and protecting the people you love.",
		'copy'   => [
			"Your estate plan is more than a will — it's a comprehensive strategy for passing wealth, minimizing taxes, and protecting the people you love. We coordinate with estate attorneys and CPAs to ensure your financial plan and legal documents align. On the insurance side, we analyze your existing coverage and identify gaps across life, disability, long-term care, and liability.",
		],
		'topics' => [ 'Wills & Trusts', 'Life Insurance', 'LTC', 'Disability' ],
	],

	'retirement-income' => [
		'title'  => 'Retirement Income Planning',
		'teaser' => 'Accumulating assets is only half the challenge — converting them into sustainable income is where the real planning begins.',
		'copy'   => [
			"Accumulating assets is only half the challenge — converting them into sustainable income is where the real planning begins. We design retirement income strategies that coordinate Social Security, pension distributions, IRA withdrawals, and investment income. We model different scenarios so you can see exactly how your plan holds up through market downturns, inflation, and healthcare costs.",
		],
		'topics' => [ 'Social Security', 'RMDs', 'Roth Conversion', 'Income Ladders' ],
	],

	'401k-plan-services' => [
		// Client-approved wording (Walt) — do not edit title or copy.
		'title'  => 'Employer Sponsored Plans – Retirement Plan (k)onsulting',
		'teaser' => 'Retirement Plan (k)onsulting (RPk) focuses exclusively on retirement plan consulting for businesses.',
		'copy'   => [
			'Retirement Plan (k)onsulting (RPk) focuses exclusively on retirement plan consulting for businesses. Because our practice is dedicated to 401(k) and retirement plan consulting, we are able to provide focused guidance, ongoing support, and administrative assistance tailored to the needs of plan sponsors and participants.',
			'Managing a retirement plan can be complex and time-consuming. We work with business owners, HR professionals, plan committees, and service providers to navigate the administrative responsibilities that come with sponsoring a retirement plan. Our goal is to help simplify the process so your organization can focus on its broader business objectives.',
			'As a member of the Retirement Plan Advisory Group (PRAG), a national consortium of retirement plan specialists, RP(k) has access to additional resources, tools, and industry expertise. Through this membership, RPk provides cutting edge tools and software coupled with 20+ years of practical experience to help us manage your fiduciary responsibilities and adhere to ERISA’s rigorous standards.',
		],
		'topics' => [ 'Plan Design', 'ERISA', 'Employee Ed.', 'Fiduciary' ],
	],

];
