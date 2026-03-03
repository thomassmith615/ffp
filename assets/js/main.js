/* ═══════════════════════════════════════════════════════
   Fortune Financial Planning — main.js
   WordPress-integrated version with URL routing.

   URL structure:
     /           → home
     /about      → about
     /solutions  → solutions
     /insights   → insights
     /resources  → resources
     /contact    → contact

   Trailing slashes are normalized automatically.
   window.fortuneData is injected by wp_localize_script()
   in functions.php and contains: ajaxUrl, nonce, homeUrl, themeUrl
═══════════════════════════════════════════════════════ */

/* ═══════════ ROUTING HELPERS ═══════════ */
const pages = ['home', 'about', 'solutions', 'insights', 'resources', 'contact'];

/**
 * Given the current window.location.pathname, figure out which page slug
 * we should show. Strips the WordPress base path and trailing slashes.
 *
 * Examples (all → 'about'):
 *   /about
 *   /about/
 *   /fortune/about
 *   /fortune/about/
 */
function slugFromPath(pathname) {
  // Get the WP base path so sub-directory installs work.
  // fortuneData.homeUrl = 'https://site.com' or 'https://site.com/subdir'
  let basePath = '/';
  if (typeof fortuneData !== 'undefined' && fortuneData.homeUrl) {
    try {
      basePath = new URL(fortuneData.homeUrl).pathname.replace(/\/?$/, '/');
    } catch (e) { /* ignore */ }
  }

  // Strip base path prefix, strip leading/trailing slashes
  let slug = pathname
    .replace(/\/$/, '')            // remove trailing slash
    .replace(basePath, '/')        // remove WP base path
    .replace(/^\/+/, '')           // remove leading slashes
    .split('/')[0]                 // take first path segment only
    .toLowerCase();

  return pages.includes(slug) ? slug : 'home';
}

/**
 * Build a full URL for a given page slug.
 */
function urlForPage(slug) {
  let base = (typeof fortuneData !== 'undefined' && fortuneData.homeUrl)
    ? fortuneData.homeUrl.replace(/\/$/, '')
    : window.location.origin;

  return slug === 'home' ? base + '/' : base + '/' + slug;
}

/* ═══════════ VIEW ROUTER ═══════════ */
let currentPage = 'home';

/**
 * Navigate to a page.
 * @param {string} page   - page slug
 * @param {boolean} pushState - push to browser history? (false when called from popstate)
 */
function goTo(page, pushState = true) {
  if (!pages.includes(page)) page = 'home';

  pages.forEach(p => document.getElementById('page-' + p).classList.remove('active'));
  document.getElementById('page-' + page).classList.add('active');
  currentPage = page;

  window.scrollTo({ top: 0, behavior: 'instant' });

  // Update nav active state
  document.querySelectorAll('.nav-links a[data-page]').forEach(a => {
    a.classList.toggle('active', a.dataset.page === page);
  });

  updateNavStyle();
  setTimeout(triggerReveals, 60);

  // Push URL into browser history
  if (pushState) {
    const url = urlForPage(page);
    window.history.pushState({ page }, '', url);
  }
}

/* ═══════════ BROWSER BACK / FORWARD ═══════════ */
window.addEventListener('popstate', (e) => {
  const page = (e.state && e.state.page) ? e.state.page : slugFromPath(window.location.pathname);
  goTo(page, false); // don't pushState again on popstate
});

/* ═══════════ NAV ═══════════ */
function updateNavStyle() {
  const nav = document.getElementById('mainNav');
  if (currentPage !== 'home') {
    nav.classList.add('solid'); nav.classList.remove('scrolled');
  } else {
    nav.classList.remove('solid');
    nav.classList.toggle('scrolled', window.scrollY > 40);
  }
}
window.addEventListener('scroll', () => {
  if (currentPage === 'home') {
    document.getElementById('mainNav').classList.toggle('scrolled', window.scrollY > 40);
  }
}, { passive: true });

/* ═══════════ HAMBURGER ═══════════ */
const ham = document.getElementById('ham');
const drawer = document.getElementById('drawer');
ham.addEventListener('click', () => { ham.classList.toggle('open'); drawer.classList.toggle('open'); });
function closeDrawer() { ham.classList.remove('open'); drawer.classList.remove('open'); }

/* ═══════════ SCROLL REVEAL ═══════════ */
function triggerReveals() {
  const els = document.querySelectorAll('.page-view.active .reveal:not(.in)');
  if (!els.length) return;
  const observer = new IntersectionObserver(entries => {
    entries.forEach(e => {
      if (e.isIntersecting) { e.target.classList.add('in'); observer.unobserve(e.target); }
    });
  }, { threshold: 0.08 });
  els.forEach(el => observer.observe(el));
}

/* ═══════════ SOLUTIONS SLIDER ═══════════ */
let currentSlide = 0;
const slideData = [
  { num: '01', label: 'Financial Planning',    bg: 'linear-gradient(145deg, #2e2a14 0%, #5b7747 100%)' },
  { num: '02', label: 'Investment Management', bg: 'linear-gradient(145deg, #1e2e1a 0%, #4a6039 100%)' },
  { num: '03', label: 'Business Succession',   bg: 'linear-gradient(145deg, #2a1e14 0%, #6b5a3e 100%)' },
  { num: '04', label: 'Estate & Insurance',    bg: 'linear-gradient(145deg, #1a1e2a 0%, #3e4a6b 100%)' },
  { num: '05', label: 'Retirement Income',     bg: 'linear-gradient(145deg, #14201a 0%, #3e6b5a 100%)' },
  { num: '06', label: '401(k) Plan Services',  bg: 'linear-gradient(145deg, #201a14 0%, #6b5a3e 100%)' },
];

function goSlide(idx) {
  const slides = document.querySelectorAll('.sol-slide');
  const dots   = document.querySelectorAll('.sol-dot');
  if (!slides.length) return;
  slides[currentSlide].classList.remove('active');
  dots[currentSlide].classList.remove('active');
  currentSlide = (idx + slideData.length) % slideData.length;
  slides[currentSlide].classList.add('active');
  dots[currentSlide].classList.add('active');
  document.getElementById('solVisualNum').textContent   = slideData[currentSlide].num;
  document.getElementById('solVisualLabel').textContent = slideData[currentSlide].label;
  document.getElementById('solVisual').style.background = slideData[currentSlide].bg;
}
function stepSlide(dir) { goSlide(currentSlide + dir); }

(function initSliderSwipe() {
  let startX = 0;
  document.addEventListener('DOMContentLoaded', () => {
    const slider = document.getElementById('solSlider');
    if (!slider) return;
    slider.addEventListener('touchstart', e => { startX = e.touches[0].clientX; }, { passive: true });
    slider.addEventListener('touchend', e => {
      const dx = e.changedTouches[0].clientX - startX;
      if (Math.abs(dx) > 50) stepSlide(dx < 0 ? 1 : -1);
    }, { passive: true });
  });
})();

/* ═══════════ RESOURCE TABS ═══════════ */
function setResTab(id) {
  if (currentPage !== 'resources') { goTo('resources'); }
  document.querySelectorAll('.res-tab').forEach(btn => {
    btn.classList.toggle('active', btn.dataset.res === id);
  });
  document.querySelectorAll('.res-panel').forEach(p => p.classList.remove('active'));
  const panel = document.getElementById('panel-' + id);
  if (panel) panel.classList.add('active');
  setTimeout(triggerReveals, 60);
}

/* ═══════════ CATEGORY INNER TABS ═══════════ */
function setCatTab(category, tab) {
  const panel = document.getElementById('panel-' + category);
  if (!panel) return;
  panel.querySelectorAll('.cat-tab').forEach((btn, i) => {
    const tabs = ['articles', 'calculators', 'videos'];
    btn.classList.toggle('active', tabs[i] === tab);
  });
  panel.querySelectorAll('.cat-panel').forEach(p => p.classList.remove('active'));
  const catPanel = document.getElementById(category + '-' + tab);
  if (catPanel) catPanel.classList.add('active');
}

/* ═══════════════════════════════════════════════════════
   INSIGHTS — SHOW ALL (WordPress REST API version)
═══════════════════════════════════════════════════════ */
let insightsLoaded = false;

async function showAllInsightsWP() {
  const btn = document.getElementById('showAllBtn');
  if (btn) { btn.textContent = 'Loading…'; btn.disabled = true; }

  if (typeof fortuneData === 'undefined') {
    _showStaticExtraInsights(); return;
  }
  if (insightsLoaded) {
    _showStaticExtraInsights(); return;
  }

  try {
    const url = fortuneData.homeUrl + '/wp-json/fortune/v1/insights?per_page=100&page=1';
    const res  = await fetch(url);
    if (!res.ok) throw new Error('REST error ' + res.status);
    const data = await res.json();

    if (data.posts && data.posts.length > 6) {
      const grid = document.getElementById('insightsGrid');
      document.querySelectorAll('.extra-insight').forEach(el => el.remove());
      data.posts.slice(6).forEach(post => {
        const card = _buildInsightCard(post);
        grid.insertBefore(card, grid.lastElementChild);
      });
      insightsLoaded = true;
    } else {
      _showStaticExtraInsights();
    }
  } catch (err) {
    console.warn('Fortune REST API unavailable, showing static cards:', err.message);
    _showStaticExtraInsights();
  }

  if (btn) btn.style.display = 'none';
  setTimeout(triggerReveals, 60);
}

function _showStaticExtraInsights() {
  document.querySelectorAll('.extra-insight').forEach(el => el.classList.remove('hidden'));
  const btn = document.getElementById('showAllBtn');
  if (btn) btn.style.display = 'none';
  setTimeout(triggerReveals, 60);
}

function _buildInsightCard(post) {
  const card = document.createElement('div');
  card.className = 'insight-card reveal';
  card.innerHTML = `
    <div class="insight-card-accent"></div>
    <div class="insight-card-body">
      <div class="insight-tag">${_esc(post.category)}</div>
      <h3>${_esc(post.title)}</h3>
      <p>${_esc(post.excerpt)}</p>
      <div class="insight-footer">
        <span class="insight-author">${_esc(post.author)} · ${_esc(post.date)}</span>
        <a href="${_esc(post.link)}" class="insight-read" target="_blank" rel="noopener">Read →</a>
      </div>
    </div>`;
  return card;
}

function _esc(str) {
  if (!str) return '';
  return String(str)
    .replace(/&/g, '&amp;').replace(/</g, '&lt;')
    .replace(/>/g, '&gt;').replace(/"/g, '&quot;');
}

/* ═══════════════════════════════════════════════════════
   CONTACT FORM — WordPress AJAX version
═══════════════════════════════════════════════════════ */
async function fortuneSubmitForm(e) {
  e.preventDefault();
  const btn = document.getElementById('fortuneSubmitBtn');

  const fields = {
    first_name: document.getElementById('ff-first')?.value   || '',
    last_name:  document.getElementById('ff-last')?.value    || '',
    email:      document.getElementById('ff-email')?.value   || '',
    phone:      document.getElementById('ff-phone')?.value   || '',
    topic:      document.getElementById('ff-topic')?.value   || '',
    message:    document.getElementById('ff-message')?.value || '',
  };

  if (!fields.email || !fields.email.includes('@')) {
    _formFeedback('Please enter a valid email address.', false); return;
  }

  if (typeof fortuneData === 'undefined') {
    alert('Thank you! Please call us at (856) 454-5005 or email kevin.gianfortune@lpl.com'); return;
  }

  btn.textContent = 'Sending…'; btn.disabled = true;

  try {
    const body = new FormData();
    body.append('action', 'fortune_contact');
    body.append('nonce',  fortuneData.nonce);
    Object.entries(fields).forEach(([k, v]) => body.append(k, v));

    const res  = await fetch(fortuneData.ajaxUrl, { method: 'POST', body });
    const data = await res.json();

    if (data.success) {
      _formFeedback(data.data.message, true);
      ['ff-first','ff-last','ff-email','ff-phone','ff-message'].forEach(id => {
        const el = document.getElementById(id); if (el) el.value = '';
      });
      const topic = document.getElementById('ff-topic');
      if (topic) topic.selectedIndex = 0;
    } else {
      _formFeedback(data.data?.message || 'Something went wrong. Please call us directly.', false);
      btn.textContent = 'Send Message'; btn.disabled = false;
    }
  } catch (err) {
    _formFeedback('Network error. Please call (856) 454-5005.', false);
    btn.textContent = 'Send Message'; btn.disabled = false;
  }
}

function _formFeedback(msg, success) {
  let fb = document.getElementById('fortune-form-feedback');
  if (!fb) {
    fb = document.createElement('p');
    fb.id = 'fortune-form-feedback';
    fb.style.cssText = 'font-size:0.88rem;font-weight:500;margin-top:0.75rem;padding:0.75rem 1rem;border-radius:3px;';
    const btn = document.getElementById('fortuneSubmitBtn');
    if (btn) btn.insertAdjacentElement('afterend', fb);
  }
  fb.textContent     = msg;
  fb.style.background = success ? 'rgba(91,119,71,0.12)' : 'rgba(180,60,60,0.1)';
  fb.style.color      = success ? '#3d5c2e' : '#8b2a2a';
}

/* ═══════════ INIT — deep link + first load ═══════════ */
document.addEventListener('DOMContentLoaded', () => {
  // Determine the initial page from the current URL path
  const initialPage = slugFromPath(window.location.pathname);

  // Replace the initial history entry so back/forward works from the start
  window.history.replaceState({ page: initialPage }, '', window.location.href.replace(/\/$/, '') || '/');

  // Activate the correct view without pushing another history entry
  goTo(initialPage, false);

  updateNavStyle();
});
