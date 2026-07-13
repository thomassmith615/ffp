<?php
/**
 * Fortune Financial Planning — solutions.
 *
 * Each solution is a row on the /solutions/ index and a full page at
 * /solutions/{slug}/.
 *
 * WORDING STATUS (Jul 2026): copy for Financial Planning, Investment
 * Management, Business Succession Planning, Estate Planning, and
 * Employer Sponsored Plans is client-approved and must not be edited.
 * Retirement Income Planning is still placeholder copy pending final
 * wording. Teasers are the verbatim first sentence of each page's copy.
 * The `topics` chips are placeholder UI labels, not client copy.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

return [

	'financial-planning' => [
		'title'  => 'Financial Planning',
		'teaser' => 'Financial planning stems from a deep understanding of what matters most to you.',
		'copy'   => [
			'Financial planning stems from a deep understanding of what matters most to you. Our process begins with a conversation. We take the time to learn about your goals, priorities, concerns, and the experiences that have shaped your financial life. Just as importantly, we use this time to determine whether our approach is the right fit for your needs. We believe the strongest planning relationships are built on open communication, shared expectations, and a genuine understanding of what matters most to you.',
			"If we decide to move forward together, we'll gather information about your financial situation to develop a clearer picture of where you are today and where you would like to go. This may include discussions around retirement, investments, cash flow, insurance, estate planning considerations, business interests, or other areas that are important to your financial life. Our role is to organize these pieces into a thoughtful planning framework tailored to your unique circumstances.",
			'From there, we develop personalized recommendations and review them with you in a collaborative and educational setting. We want you to understand our recommendations, but also the considerations and reasoning behind them, so you can make informed decisions with confidence.',
			"Financial planning is an ongoing process, not a one-time solution. As your life evolves, your goals, priorities, and circumstances may change as well. Through regular communication and periodic reviews, we strive to provide guidance and support through life's many transitions.",
		],
		'topics' => [ 'Goal Setting', 'Cash Flow', 'Net Worth', 'Accountability' ],
	],

	'investment-management' => [
		'title'  => 'Investment Management',
		'teaser' => 'Investment management is an important part of a long-term financial plan.',
		'copy'   => [
			"Investment management is an important part of a long-term financial plan. In today's rapidly changing financial landscape, investors face a wide range of choices, market fluctuations, and economic uncertainty. A thoughtful investment approach begins with understanding your goals, time horizon, and comfort level with risk.",
			'At Fortune Financial Planning, we take the time to understand your financial priorities and risk tolerance before developing a personalized investment strategy. Our role is to help you navigate the complexities of investing, evaluate opportunities and risks, and build a portfolio that reflects your individual circumstances. As markets and life events change, we review and adjust strategies to help keep your plan aligned with your evolving goals.',
		],
		'topics' => [ 'Portfolios', 'Risk Analysis', 'Diversification', 'Rebalancing' ],
	],

	'business-succession' => [
		'title'  => 'Business Succession Planning',
		'teaser' => 'For many business owners, a business represents years of hard work, personal investment, and long-term commitment.',
		'copy'   => [
			'For many business owners, a business represents years of hard work, personal investment, and long-term commitment. Yet planning for future transitions is often delayed while day-to-day operations take priority. Whether your goal is to transition ownership to family members, key employees, business partners, or a third-party buyer, a thoughtful succession plan can help provide clarity and direction for the future of your business.',
			'Business succession planning involves much more than identifying a successor. It requires evaluating the value of the business, understanding ownership structures, addressing tax considerations, coordinating legal documents, and preparing for both expected and unexpected life events. A well-developed succession strategy can help business owners explore their options, establish a framework for future transitions, and align business decisions with personal and financial priorities.',
			"At Fortune Financial Planning, we work with business owners to evaluate succession planning considerations within the context of their broader financial picture. We collaborate with attorneys, accountants, valuation professionals, and other advisors to help coordinate the various components of the planning process. These components may include ownership transfer strategies, retirement planning, business valuation, risk management, charitable giving considerations, and tax-efficient planning opportunities. While every business owner's situation is unique, our goal is to help facilitate a structured planning process that supports informed decision-making and long-term preparation.",
		],
		'topics' => [ 'Exit Planning', 'Buy-Sell', 'Key Person', 'Business Valuation' ],
	],

	'estate-planning' => [
		'title'  => 'Estate Planning',
		'teaser' => 'Estate planning is an important process that helps you organize your financial affairs and provide guidance for how assets and responsibilities may be handled in the future.',
		'copy'   => [
			'Estate planning is an important process that helps you organize your financial affairs and provide guidance for how assets and responsibilities may be handled in the future. A well-considered estate plan can help clarify your wishes, identify beneficiaries, appoint guardians for minor children, and address decisions related to healthcare and financial matters.',
			'Estate planning may involve documents such as wills, trusts, powers of attorney, and healthcare directives. While we do not provide legal services or prepare estate planning documents, we can work alongside your attorney and other professional advisors to help align estate planning considerations with your overall financial plan. Our goal is to support a collaborative planning process that reflects your long-term priorities.',
		],
		'topics' => [ 'Wills & Trusts', 'Beneficiaries', 'Powers of Attorney', 'Healthcare Directives' ],
	],

	'retirement-income' => [
		// PLACEHOLDER copy — final wording not yet provided.
		'title'  => 'Retirement Income Planning',
		'teaser' => 'Accumulating assets is only half the challenge — converting them into sustainable income is where the real planning begins.',
		'copy'   => [
			"Accumulating assets is only half the challenge — converting them into sustainable income is where the real planning begins. We design retirement income strategies that coordinate Social Security, pension distributions, IRA withdrawals, and investment income. We model different scenarios so you can see exactly how your plan holds up through market downturns, inflation, and healthcare costs.",
		],
		'topics' => [ 'Social Security', 'RMDs', 'Roth Conversion', 'Income Ladders' ],
	],

	'401k-plan-services' => [
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
