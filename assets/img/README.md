# Drop-in image slots

Templates look up images here via `ffp_image_url()` (inc/template-tags.php).
Add a file with one of these names — `.svg`, `.png`, `.webp`, `.jpg`, or
`.jpeg` — and the matching slot activates automatically. No code changes
needed. Until a file exists, the slot renders a styled placeholder
(palette gradient tile) or nothing at all.

| File (any supported extension) | Where it appears |
|---|---|
| `logo-tree` | Currently unused spare (transparent dark-silhouette tree), kept for future use. |
| `logo-tree-toolbar` | Header nav + footer — replaces the green "F" circle next to the wordmark. Square, transparent background (works over the hero too), rendered at 42px. |
| `logo-tree-og` | Transparent full-color logo, used as a one-color CSS-mask watermark in two ways: tan-tinted in-block mark on dark bands (home "Our Promise" strip, home CTA banner, About/Insights/Contact heroes — toggle per block via the `tree-watermark` class) and sage-tinted fixed fullscreen mark behind the Solutions pages. |
| `home/why` | Home — the large 4:5 visual in the "Why Fortune Financial" section (replaces the gradient panel; cropped cover, the floating stat cards stay on top). |
| `home/financial-planning` | Home — services index tile 01 (square, ~210px source or larger) |
| `home/investment-management` | Home — services index tile 02 |
| `home/business-succession` | Home — services index tile 03 |
| `home/estate-insurance` | Home — services index tile 04 |
| `home/retirement-income` | Home — services index tile 05 |
| `home/401k-plan-services` | Home — services index tile 06 |
| `team/kevin-gianfortune` | About + bio page — Kevin's photo (square crop, ≥600px) |
| `team/walter-eife` | About + bio page — Walt's photo |
| `team/steve-melchiorre` | About + bio page — Steve's photo |
| `team/james-owens` | About + bio page — James's photo |
| `team/liz-gianfortune` | About + bio page — Liz's photo |

Square crops work best for the service tiles; they render at 104px
(76px on small phones), so anything ≥300px square is plenty.

NOTE: the six `home/{slug}.webp` files are the gradient icon tiles for
the homepage services list — 1024px masters rendered to WebP (bitmap
because Safari handles filter-heavy SVG backgrounds unreliably). The
editable vector sources are in `src/*.svg`; re-render with e.g.
`qlmanage -t -s 1024` and convert. `.webp` wins over `.jpg` in the
slot lookup, so to swap an icon for a real photo later, delete the
`.webp` and drop in the `.jpg`.
