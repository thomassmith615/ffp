# Fortune Financial Planning — WordPress Theme

A custom WordPress theme for [Fortune Financial Planning](https://fortunefinancialplanning.com), a South Jersey fiduciary advisory firm affiliated with LPL Financial.

**v2.0** rebuilds the theme as a traditional, fully server-rendered multi-template WordPress theme. The v1.x single-page-app shell (all pages in one `index.php`, JS show/hide router, content stored in JavaScript) is gone — every view is now a real URL rendered by PHP.

> Site copy is placeholder wording pending final content from FFP. Colors, fonts, and light theme are locked to the FFP palette.

---

## Tech Stack

| Layer | Details |
|---|---|
| CMS | WordPress 6.x (custom theme, no page builder) |
| Frontend | Server-rendered PHP templates, vanilla JS for progressive enhancement only |
| Routing | WordPress rewrite rules + custom query vars (no client-side router) |
| Content | PHP content library (`data/resources.php`) + `insight` custom post type |
| Fonts | Google Fonts — Cormorant Garamond + DM Sans |
| Email | `wp_mail()` via admin-ajax (pair with WP Mail SMTP in production) |

---

## URL Structure

Every view is a shareable, server-rendered URL with a proper `<title>`, meta description, canonical link, and Open Graph tags:

| URL | View |
|---|---|
| `/` | Home |
| `/about/` | About / team directory |
| `/about/{slug}/` | Individual team member bio (e.g. `/about/kevin-gianfortune/`) |
| `/solutions/` | Solutions index |
| `/solutions/{slug}/` | Individual solution page (e.g. `/solutions/retirement-income/`) |
| `/insights/` | Insights editorial feed |
| `/insights/{slug}/` | Single insight (static library or `insight` post) |
| `/resources/` | Resources index |
| `/resources/{category}/` | Category — retirement, investment, estate, insurance, tax, lifestyle |
| `/resources/{category}/{tab}/` | Category with calculators or videos tab open |
| `/resources/calculators/` | All calculators, grouped by category |
| `/resources/videos/` | All videos |
| `/resources/article/{slug}/` | Single article (breadcrumbs, share toolbar, related reading) |
| `/resources/calculator/{slug}/` | Single calculator |
| `/resources/video/{slug}/` | Single video |
| `/contact/` | Contact form |

Unknown slugs return genuine 404s. The legacy `/resources/calc` URL 301-redirects to `/resources/calculators/`.

---

## Project Structure

```
ffp/
├── style.css                    Theme metadata
├── functions.php                Slim bootstrap — requires the inc/ modules
├── header.php / footer.php      Site chrome (server-rendered nav state, full footer)
├── front-page.php               Home
├── page-about.php               About (auto-applies to the "about" page slug)
├── page-solutions.php           Solutions — editorial sections + sticky anchor sub-nav
├── page-insights.php            Insights — feed and single views
├── page-resources.php           Resources — dispatches overview / category / single
├── 404.php / index.php          Not-found + generic fallback
├── inc/
│   ├── setup.php                Theme supports, activation (auto-creates pages, flushes rewrites), assets
│   ├── library.php              Content library access + URL builders (ffp_* helpers)
│   ├── routing.php              Rewrite rules, route validation, titles, social meta
│   ├── post-types.php           insight / team_member / testimonial CPTs
│   ├── contact.php              Contact form AJAX handler
│   └── template-tags.php        Breadcrumbs, share buttons, list renderers
├── data/
│   └── resources.php            ALL site content: articles, calculators, videos, categories
├── template-parts/
│   ├── resources-overview.php   Editorial index of categories
│   ├── resources-category.php   Category view with tab URLs
│   ├── resources-all-calculators.php / resources-all-videos.php
│   ├── single-item.php          Single article/calculator/video shell
│   └── single-post.php          Single `insight` post shell
├── assets/
│   ├── css/main.css             All styles
│   └── js/main.js               Drawer, reveal, scrollspy, share, contact AJAX (~200 lines)
└── blueprint.json               WordPress Playground config for local preview
```

---

## How Routing Works

1. `inc/routing.php` registers rewrite rules that map deep paths onto the Resources/Insights *pages* with extra query vars (`ffp_category`, `ffp_tab`, `ffp_kind`, `ffp_slug`).
2. The page templates read those vars and render the right view server-side.
3. Routes are validated on the `wp` hook — unknown slugs/categories become real 404s.
4. `redirect_canonical` is suppressed for routed URLs so WP doesn't bounce them back to the bare page permalink.
5. Rewrite rules are flushed automatically on theme activation. If routes ever 404 after editing the rules, re-save **Settings → Permalinks** once.

`insight` posts created in WP admin publish at `/insights/{post-slug}/` through the same route (the template checks the static library first, then falls back to a CPT lookup).

---

## Adding Content

**Articles / calculators / videos** — add an entry to `data/resources.php`. Items with a `body` are routable and linkable everywhere automatically (category lists, counts, related reading, the Insights feed if `insight_tag` is set). Items without a `body` are listed as "coming soon".

**Insights via WP admin** — Insights → Add New. Title, content, excerpt, and an Insight Category. The post appears in the feed automatically and publishes at `/insights/{slug}/`.

**Team members / testimonials** — CPTs are registered for future admin management; the About page currently uses static markup.

---

## Local Development

No build step. Preview in WordPress Playground:

```bash
npx @wp-playground/cli@latest server \
  --blueprint=blueprint.json \
  --mount=.:/wordpress/wp-content/themes/ffp \
  --site-options.theme=ffp
```

(or any local WP — LocalWP, MAMP — with the theme dropped into `wp-content/themes/`).

## Production Install

1. Zip the theme folder and upload via **Appearance → Themes → Add New → Upload Theme**
2. Activate — pages (Home, About, Solutions, Insights, Resources, Contact) are created automatically, the front page is assigned, and rewrite rules flush
3. Install **WP Mail SMTP** and connect a mail provider so the contact form delivers reliably
4. Replace the hero video source in `front-page.php` with a self-hosted file

---

## Notes

- LPL Financial compliance disclosures are included in the footer and the tax resource category as required.
- Single articles include a share toolbar (copy link via clipboard/Web Share API, LinkedIn intent, mailto).
- The hero video uses `object-fit: cover`; if it fails to load, the gradient background shows through.
- Dynamic titles/descriptions for routed views come from the content library via `document_title_parts` — no slug-humanizing.
