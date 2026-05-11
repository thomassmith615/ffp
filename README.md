# Fortune Financial Planning — WordPress Theme

A custom, production-deployed WordPress theme for [Fortune Financial Planning](https://fortunefinancialplanning.com), a South Jersey fiduciary advisory firm affiliated with LPL Financial.

Built from scratch as a single-page application (SPA) inside WordPress — no page builder, no template framework.

---

## Live Site

> fortunefinancialplanning.com

---

## Tech Stack

| Layer | Details |
|---|---|
| CMS | WordPress 6.x (custom theme, no page builder) |
| Frontend | Vanilla JS, CSS custom properties, no framework |
| Routing | Client-side SPA router with `history.pushState`, deep-link support |
| Fonts | Google Fonts — Cormorant Garamond + DM Sans |
| Backend | PHP 8, WordPress AJAX API, WP REST API |
| Auth | WordPress nonce-based CSRF protection |
| Email | `wp_mail()` + WP Mail SMTP |

---

## URL Structure (v1.1)

Every meaningful view has its own shareable URL:

| URL | View |
|---|---|
| `/` | Home |
| `/about` | About / Team |
| `/solutions` | Solutions slider |
| `/insights` | Insights index |
| `/insights/{slug}` | Single insight article |
| `/resources` | Resources overview |
| `/resources/{category}` | Category tab (retirement, investment, estate, insurance, tax, lifestyle, calc, videos) |
| `/resources/{category}/{tab}` | Category + inner tab (articles / calculators / videos) |
| `/resources/article/{slug}` | Single article view (with share buttons) |
| `/resources/calculator/{slug}` | Single calculator view |
| `/resources/video/{slug}` | Single video view |
| `/contact` | Contact form |

Trailing slashes are normalized server-side. Every view returns HTTP 200 — copy/paste any URL into a chat or LinkedIn post and it loads correctly.

---

## Features

**Deep-Link SPA Routing**
- Client-side router with `history.pushState` / `popstate` for native back/forward navigation
- Every article, calculator, and video has its own URL — shareable on LinkedIn, email, SMS, anywhere
- WordPress rewrite rules + `template_include` filter ensure server-side 200 responses for all SPA routes
- Subdirectory install support via `fortuneData.homeUrl`
- Right-click "Copy Link Address" on any nav element works correctly (real `href` attributes)

**Single-Article View**
- Breadcrumb trail: Resources → Category → Article
- Built-in share toolbar: copy link (clipboard API), LinkedIn post, email
- Related-articles grid drawn from the same category
- Inline CTA box with link to /contact

**Contact Form**
- WordPress AJAX handler (`wp_ajax_fortune_contact`) with nonce verification
- Sanitized with `sanitize_text_field`, `sanitize_email`, `sanitize_textarea_field`
- `wp_mail()` delivery with Reply-To header
- Inline success/error feedback injected into the DOM without a page reload

**Insights / Blog**
- Custom post type (`insight`) with custom taxonomy (`insight_category`)
- REST API endpoint at `/wp-json/fortune/v1/insights` with pagination and category filtering
- "Show All" button fetches additional posts dynamically; gracefully falls back to static HTML if the API is unavailable

**Solutions Slideshow**
- Touch/swipe support via `touchstart` / `touchend`
- CSS transitions between slides with no JS animation library

**Scroll Reveal**
- `IntersectionObserver`-based reveal system for staggered entrance animations
- Trigger delay classes (`d1`–`d5`) for sequenced reveals per section

**Custom Post Types**
- `insight` — blog/articles with REST API support
- `team_member` — advisor profiles
- `testimonial` — client reviews (non-public, admin-only)

**Performance & SEO**
- Removes WordPress emoji scripts, generator tag, RSD/WLW links from `<head>`
- Dynamic `<title>` tag per SPA route via `pre_get_document_title` filter (nested: "Article — Category — Resources · Site")
- Theme activation flushes rewrite rules automatically

---

## Project Structure

```
ffp/
├── style.css                   # Theme metadata (WordPress requirement)
├── index.php                   # SPA shell — loads all page partials
├── header.php                  # <head>, nav, mobile drawer (routed links)
├── footer.php                  # wp_footer() hook
├── functions.php               # Theme setup, enqueue, rewrites, AJAX, CPTs, REST API
├── assets/
│   ├── css/main.css            # All styles (~1100 lines, single-article view included)
│   └── js/main.js              # Router, slider, forms, reveal, RESOURCE_LIBRARY (~900 lines)
└── partials/
    ├── page-home.php           # Hero (with object-fit:cover video fix), services, testimonials, CTA
    ├── page-about.php          # Team grid with placeholder/photo support
    ├── page-solutions.php      # Swipeable 6-slide solution showcase
    ├── page-insights.php       # Article grid + single-article host + dynamic WP REST expansion
    ├── page-resources.php      # Tabbed resource center (8 categories) + single-article host
    ├── page-contact.php        # AJAX contact form
    └── shared-footer.php       # Shared footer with routed topic links + live copyright year
```

---

## WordPress Installation

1. Zip the `ffp/` folder and upload via **Appearance → Themes → Add New → Upload Theme**
2. Activate the theme — rewrite rules flush automatically on activation
3. Go to **Settings → Permalinks** and click **Save Changes** once to make absolutely sure the rules are written
4. Go to **Pages → Add New**, create a page titled "Home", publish it
5. Go to **Settings → Reading** → set homepage to the static "Home" page
6. Install **WP Mail SMTP** and configure your mail provider for reliable contact form delivery
7. Add articles via **Insights → Add New** in the WP admin sidebar

---

## Adding New Articles

The fastest way is to add to the in-JS `RESOURCE_LIBRARY` (in `assets/js/main.js`):

```js
'my-new-article-slug': {
  title: 'My New Article Title',
  category: 'retirement',          // retirement|investment|estate|insurance|tax|lifestyle
  kind: 'article',                 // article|calculator|video
  author: 'Kevin J. Gianfortune',
  date: 'Jan 15, 2025',
  dek: 'One-sentence summary shown under the title.',
  body: `
    <p>First paragraph...</p>
    <h2>A Subheading</h2>
    <p>More content...</p>
    <blockquote>An optional pullquote.</blockquote>
  `
},
```

Then add a matching `<li data-resource-slug="my-new-article-slug" data-resource-kind="article">` entry in the appropriate category panel of `partials/page-resources.php`.

For longer-term content management, you can also create new posts under the `insight` custom post type in WP admin — they appear automatically in the Insights page via the REST API.

---

## Sharing & Social

When a user views any article, the share toolbar offers:
- **Copy Link** — copies the canonical URL to clipboard with a "Copied!" confirmation
- **LinkedIn** — opens LinkedIn's share intent prefilled with the article URL
- **Email** — opens the default mail client with subject and link prefilled

LinkedIn link example for a blog post:
```
https://www.linkedin.com/sharing/share-offsite/?url=https://fortunefinancialplanning.com/resources/article/social-security-when-to-claim
```

---

## Local Development

No build step required. Open `index.html` in a browser for a static preview, or run a standard local WordPress environment (LocalWP, MAMP, etc.) and drop the theme into `wp-content/themes/`.

---

## Notes

- The SPA router handles subdirectory WordPress installs — `fortuneData.homeUrl` (injected via `wp_localize_script`) is used to strip the base path before slug matching
- Trailing slash redirects are handled server-side via `template_redirect` to prevent "Forbidden" responses on directory-style URLs
- LPL Financial compliance disclosures are included in the footer and resource pages as required
- All user-supplied data rendered in JS goes through a custom `_esc()` function to prevent XSS
- The hero video uses `object-fit: cover` to scale and center properly at any aspect ratio; if the video fails to load, the gradient background underneath shows through gracefully
