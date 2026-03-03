# Fortune Financial Planning — WordPress Theme

A custom, production-deployed WordPress theme for [Fortune Financial Planning](https://www.fortunefinancialplanning.com) (existing site), a South Jersey fiduciary advisory firm affiliated with LPL Financial.

New site: https://jowens8f0b95cf44-vbywr.wpcomstaging.com/

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
| Routing | Client-side SPA router with `history.pushState` |
| Fonts | Google Fonts — Cormorant Garamond + DM Sans |
| Backend | PHP 8, WordPress AJAX API, WP REST API |
| Auth | WordPress nonce-based CSRF protection |
| Email | `wp_mail()` + WP Mail SMTP |

---

## Features

**SPA Routing**
- Client-side router maps `/about`, `/solutions`, etc. to a single WordPress template
- Deep-link support — any URL loads the correct view directly
- `history.pushState` / `popstate` for native back/forward navigation
- WordPress rewrite rules + `template_include` filter ensure server-side 200 responses for all SPA routes
- Subdirectory install support via `fortuneData.homeUrl`

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
- Dynamic `<title>` tag per SPA route via `pre_get_document_title` filter
- Theme activation flushes rewrite rules automatically

---

## Project Structure

```
ffp/
├── style.css                   # Theme metadata (WordPress requirement)
├── index.php                   # SPA shell — loads all page partials
├── header.php                  # <head>, nav, mobile drawer
├── footer.php                  # wp_footer() hook
├── functions.php               # Theme setup, enqueue, AJAX, CPTs, REST API
├── assets/
│   ├── css/main.css            # All styles (~900 lines, no preprocessor)
│   └── js/main.js              # Router, slider, forms, reveal (~350 lines)
└── partials/
    ├── page-home.php           # Hero, services preview, testimonials, CTA
    ├── page-about.php          # Team grid with placeholder/photo support
    ├── page-solutions.php      # Swipeable 6-slide solution showcase
    ├── page-insights.php       # Article grid + dynamic WP REST expansion
    ├── page-resources.php      # Tabbed resource center (8 categories)
    ├── page-contact.php        # AJAX contact form
    └── shared-footer.php       # Shared footer with live copyright year
```

---

## WordPress Installation

1. Zip the `ffp/` folder and upload via **Appearance → Themes → Add New → Upload Theme**
2. Activate the theme — rewrite rules flush automatically on activation
3. Go to **Pages → Add New**, create a page titled "Home", publish it
4. Go to **Settings → Reading** → set homepage to the static "Home" page
5. Install **WP Mail SMTP** and configure your mail provider for reliable contact form delivery
6. Add articles via **Insights → Add New** in the WP admin sidebar

---

## Local Development

No build step required. Open `index.html` in a browser for a static preview, or run a standard local WordPress environment (LocalWP, MAMP, etc.) and drop the theme into `wp-content/themes/`.

---

## Notes

- The SPA router handles subdirectory WordPress installs — `fortuneData.homeUrl` (injected via `wp_localize_script`) is used to strip the base path before slug matching
- Trailing slash redirects are handled server-side via `template_redirect` to prevent "Forbidden" responses on directory-style URLs
- LPL Financial compliance disclosures are included in the footer and resource pages as required
- All user-supplied data rendered in JS goes through a custom `_esc()` function to prevent XSS
