# Fortune Financial — Partials Folder

## What's in here

```
partials/
├── page-home.php        ← Home page SPA view (hero, services, why, testimonials, CTA)
├── page-about.php       ← About page (hero, mission, team grid)
├── page-solutions.php   ← Solutions slider (swipeable, 6 slides)
├── page-insights.php    ← Insights grid (6 static + WP REST API expansion)
├── page-resources.php   ← Resources (all category tabs: retirement, investment, estate...)
├── page-contact.php     ← Contact page with WP AJAX form
├── shared-footer.php    ← Shared footer, called via get_template_part() in each page
└── main.js              ← Updated JS — WP AJAX contact form + REST API insights loader
```

---

## How to deploy these

### 1. Copy partials into your theme

Place the entire `partials/` folder inside your `fortune-financial-theme/` directory:

```
fortune-financial-theme/
├── partials/            ← PASTE THIS FOLDER HERE
│   ├── page-home.php
│   ├── page-about.php
│   └── ...
├── assets/
│   ├── css/main.css
│   └── js/main.js       ← REPLACE this with the main.js from this folder
├── functions.php
├── header.php
├── footer.php
├── index.php
└── style.css
```

**Important:** Replace `assets/js/main.js` with the `main.js` from this partials folder.
It has the same router and UI code but adds:
- Real WP AJAX contact form submission
- REST API call for "Show All" on the Insights page
- XSS-safe dynamic card rendering

### 2. The index.php already calls these

Your `index.php` already has:
```php
get_template_part( 'partials/page', 'home' );
get_template_part( 'partials/page', 'about' );
// ... etc
```
So once the files are in place, WordPress will include them automatically.

### 3. The shared footer

Each partial ends with:
```php
<?php get_template_part( 'partials/shared', 'footer' ); ?>
```
This pulls in `shared-footer.php` which outputs the footer HTML with a live `<?php echo date('Y'); ?>`
for the copyright year so it auto-updates every January.

---

## WordPress-specific things done to each partial

### All pages
- `<div id="footer-xxx"></div>` slots replaced with `<?php get_template_part('partials/shared', 'footer'); ?>`
- Copyright year uses `<?php echo esc_html( date('Y') ); ?>` in the footer

### page-insights.php
- PHP doc block explains the static → dynamic fallback strategy
- "Show All" button calls `showAllInsightsWP()` instead of `showAllInsights()`
- `showAllInsightsWP()` hits `/wp-json/fortune/v1/insights` (registered in functions.php)
- If WP isn't available or fewer than 7 posts exist, it gracefully falls back to showing the hidden static `.extra-insight` cards
- New insights added in WP Admin → Insights → Add New will automatically appear

### page-contact.php
- PHP doc block explains the AJAX flow
- Form fields now have `id` attributes (`ff-first`, `ff-last`, `ff-email`, `ff-phone`, `ff-topic`, `ff-message`) so JS can read them
- Submit button calls `fortuneSubmitForm(event)` instead of `alert()`
- Success/error feedback message injected below the button
- Non-WP fallback: if `window.fortuneData` isn't available, shows a manual contact prompt

### main.js
- `fortuneSubmitForm()` — posts to WP AJAX (`admin-ajax.php`) using the `fortune_contact` action and nonce from `window.fortuneData`
- `showAllInsightsWP()` — fetches from REST API, builds cards dynamically, falls back to static HTML
- All dynamic content goes through `_esc()` to prevent XSS
- `_formFeedback()` shows green/red inline message after submission

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
2. Fill in: Title, content (body), excerpt (short summary shown on card), author, and Insight Category
3. Publish
4. On the live site, clicking "Show All Articles" will now pull and display your WP posts

The first 6 articles shown on the page are always the static HTML cards (your original content).
WP posts load on top of those when "Show All" is clicked.

Once you have enough WP content, you can replace the static cards with a PHP `WP_Query` loop in
`page-insights.php` — ask for help with that when you're ready.
