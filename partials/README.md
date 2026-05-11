# Fortune Financial — Partials Folder

## What's in here

```
partials/
├── page-home.php        ← Home page SPA view (hero with object-fit:cover video, services, testimonials, CTA)
├── page-about.php       ← About page (hero, mission, team grid)
├── page-solutions.php   ← Solutions slider (swipeable, 6 slides)
├── page-insights.php    ← Insights grid + #insightSingleHost mount point for /insights/{slug}
├── page-resources.php   ← Resources (all category tabs) + #resourceSingleHost mount point for /resources/article/{slug}
├── page-contact.php     ← Contact page with WP AJAX form
└── shared-footer.php    ← Shared footer with routed topic deep-links (/resources/retirement, etc.)
```

---

## Deep-link routing

Each partial that hosts a single-item view has a host div the router populates:

```html
<!-- in page-resources.php -->
<div id="resourceSingleHost"></div>

<!-- in page-insights.php -->
<div id="insightSingleHost"></div>
```

When the URL matches `/insights/{slug}` or `/resources/article/{slug}` etc., the router:
1. Activates the parent page view (`page-insights` or `page-resources`)
2. Renders the single-item HTML into the host div
3. Hides the parent's normal grid/tab content while the single view is shown
4. Restores the grid when the user navigates back

This means deep-linked URLs always work as direct entries (paste into LinkedIn, email, SMS, etc.) and the back button correctly returns to the listing.

---

## Adding routed list items

In `page-resources.php`, each `<li>` in a `.linked-list` has these data attributes:

```html
<li data-resource-slug="my-article-slug" data-resource-kind="article">
  <span>My Article Title</span>
  <span class="ll-arrow">›</span>
</li>
```

The router reads these via event delegation — no per-item onclick handler needed. The matching content must exist as an entry in `RESOURCE_LIBRARY` inside `assets/js/main.js`.

For insight cards in `page-insights.php`, each "Read →" link is a real `<a href="/insights/{slug}" data-route data-insight-slug="{slug}">` that the global router intercepts.

---

## How to deploy these

### 1. Drop the entire folder over your existing install

```
wp-content/themes/ffp/   ← paste the entire folder here, overwriting
```

### 2. Flush rewrite rules

If you replaced `functions.php`:
- **Appearance → Themes** → re-activate the theme (or)
- **Settings → Permalinks** → click **Save Changes** (no actual change needed)

This makes the new routes for `/insights/{slug}`, `/resources/{cat}`, etc. resolve correctly server-side.

### 3. Confirm the contact form still works

Submit a test contact form on `/contact`. If you don't receive the email, install **WP Mail SMTP** and connect it to your mail provider (Gmail, Outlook, SendGrid, etc.).

---

## WordPress-specific things done to each partial

### All pages
- `<div id="footer-xxx"></div>` slots replaced with `<?php get_template_part('partials/shared', 'footer'); ?>`
- Copyright year uses `<?php echo esc_html( date('Y') ); ?>` in the footer
- All anchor tags use real `href` + `data-route` (right-click "Copy Link Address" works)

### page-home.php
- Hero `<video>` is now sized via CSS (`.hero-bg video { object-fit: cover; ... }`) so it fills the container and centers regardless of source aspect ratio (fixes the prior "zoomed top-left" bug)
- Hero CTAs converted from `onclick="goTo(...)"` to real `href="/contact"` etc. with `data-route`

### page-insights.php
- New `#insightSingleHost` div sits above the grid — populated when URL is `/insights/{slug}`
- Each "Read →" is a real shareable URL like `/insights/social-security-when-to-claim`
- The Newsletter card's Subscribe link routes to `/contact`

### page-resources.php
- New `#resourceSingleHost` div sits at the top of the section-inner
- Articles, calculators, and videos use `data-resource-slug` + `data-resource-kind` attributes
- The router uses event delegation on the document, so dynamically-rendered items also work

### page-contact.php
- Form fields have `id` attributes (`ff-first`, etc.) so JS can read them
- Submit button calls `fortuneSubmitForm(event)`
- Success/error feedback injected below the button
- Non-WP fallback: if `window.fortuneData` isn't available, shows a manual contact prompt

### shared-footer.php
- "Navigate" column links converted to real `href` + `data-route`
- "Topics" column uses deep-link URLs (`/resources/retirement`, `/resources/investment`, ...) rather than onclick handlers — now perfectly shareable

---

## Contact form — making email work

The form handler in `functions.php` uses `wp_mail()`. For this to actually deliver email reliably:

1. Install the plugin **WP Mail SMTP** (free)
2. Go to **WP Mail SMTP → Settings**
3. Connect it to your email provider (Gmail, Outlook, SendGrid, etc.)
4. Set the "From Email" to something like `noreply@fortunefinancialplanning.com`
5. Test it — you'll get a test email to confirm it works

Without this step, emails may land in spam or not send at all (shared hosting limitation).

---

## Adding real Insights articles

1. WP Admin → **Insights** → Add New
2. Fill in: Title, content (body), excerpt, author, Insight Category, **slug** (this is the URL segment used in `/insights/{slug}`)
3. Publish
4. On the live site, clicking "Show All Articles" pulls these via REST API

The first 6 articles shown on the page are still the static HTML cards. For each of those, the slug in `data-insight-slug` must match a key in `INSIGHT_STATIC_LIBRARY` inside `assets/js/main.js` for the single-article view to render rich content.
