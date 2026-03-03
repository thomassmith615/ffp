# Fortune Financial Planning — WordPress Theme

## What's in this package

```
fortune-financial-theme/
├── style.css               ← Required by WordPress (theme metadata)
├── index.php               ← Main SPA shell template
├── header.php              ← Nav + <head> output
├── footer.php              ← Footer + wp_footer()
├── functions.php           ← Enqueues assets, registers custom post types,
│                              handles contact form, REST API
├── assets/
│   ├── css/
│   │   └── main.css        ← All site styles (extracted from index.html)
│   └── js/
│       └── main.js         ← All site JS (router, slider, tabs, etc.)
└── partials/               ← (you'll create these — see below)
    ├── page-home.php
    ├── page-about.php
    ├── page-solutions.php
    ├── page-insights.php
    ├── page-resources.php
    └── page-contact.php
```

The standalone `index.html` in the root is your **development preview** — open it in any browser, no server needed.

---

## How to install in WordPress

### Step 1 — Get WordPress
If you don't have it yet: https://wordpress.org/download/
Most web hosts (SiteGround, WP Engine, Bluehost, etc.) have a one-click WordPress installer in their control panel.

### Step 2 — Upload the theme
1. Log into your WordPress dashboard: `yourdomain.com/wp-admin`
2. Go to **Appearance → Themes → Add New → Upload Theme**
3. Zip the `fortune-financial-theme` folder (right-click → Compress/Zip)
4. Upload the zip file
5. Click **Activate**

### Step 3 — Set up the homepage
1. Go to **Pages → Add New**, title it "Home", set the Page Template to "Home (SPA)" and publish it
2. Go to **Settings → Reading** and set "Your homepage displays" to **A static page**, choosing "Home"

### Step 4 — Partials (split the HTML into PHP files)
The theme is designed so the HTML for each "page" lives in `/partials/page-home.php`, etc.
Copy the corresponding `<div id="page-home">...</div>` blocks from `index.html` into each partial file, wrapped like this:

```php
<!-- partials/page-home.php -->
<div id="page-home" class="page-view active">
  ... (paste your home HTML here) ...
</div>
```

Do this for each page: home, about, solutions, insights, resources, contact.

### Step 5 — Contact form
The theme includes a WordPress AJAX handler for the contact form. In `main.js`, the form submit button currently uses `alert()`. To wire it to WordPress:

```js
// Replace the onclick alert with this:
document.querySelector('.form-submit').addEventListener('click', async () => {
  const data = new FormData();
  data.append('action', 'fortune_contact');
  data.append('nonce', fortuneData.nonce);
  data.append('first_name', document.querySelector('input[placeholder="Jane"]').value);
  // ... add other fields
  const res = await fetch(fortuneData.ajaxUrl, { method: 'POST', body: data });
  const json = await res.json();
  alert(json.data.message);
});
```

### Step 6 — Adding Insights (blog posts)
The theme registers a custom post type called **Insights**.
- Go to **Insights → Add New** in the WP admin sidebar
- Add a title, content, excerpt, category, and author
- Publish — the REST API at `/wp-json/fortune/v1/insights` will serve them to the front end

To make the Insights page load dynamically from WordPress instead of static HTML,
update the `page-insights.php` partial to fetch from the REST API using `fortuneData.themeUrl`.

---

## Recommended plugins
- **Yoast SEO** — meta tags, sitemap
- **WP Mail SMTP** — makes the contact form email reliable
- **Wordfence** — security
- **WP Super Cache** — performance

---

## Notes
- The site uses a client-side router (`goTo()` function). This means WordPress's normal page routing isn't used for navigation — all views are rendered in the browser from one page load.
- When you're ready to add real article content, the custom post type + REST API route are already set up.
- LPL Financial compliance review may require specific disclosures on certain pages — those are already in the footer and on applicable resource pages.
