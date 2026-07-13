/* ═══════════════════════════════════════════════════════
   Fortune Financial Planning — main.js

   Routing is server-side (see inc/routing.php); this file only
   handles progressive enhancement:

     · mobile drawer
     · transparent→solid nav on the home page
     · scroll-reveal animations
     · solutions sub-nav scrollspy
     · copy-link share buttons
     · contact form AJAX submit
     · hero video fallback

   window.fortuneData ({ ajaxUrl, nonce }) is injected by
   wp_localize_script() in inc/setup.php.
═══════════════════════════════════════════════════════ */

(function () {
  'use strict';

  /* ═══════════ MOBILE DRAWER ═══════════ */
  const ham = document.getElementById('ham');
  const drawer = document.getElementById('drawer');
  if (ham && drawer) {
    ham.addEventListener('click', () => {
      const open = drawer.classList.toggle('open');
      ham.classList.toggle('open', open);
      ham.setAttribute('aria-expanded', String(open));
    });
  }

  /* ═══════════ NAV SCROLL STATE (home only) ═══════════ */
  const nav = document.getElementById('mainNav');
  const transparentNav = nav && !document.body.classList.contains('nav-solid');
  if (transparentNav) {
    const onScroll = () => nav.classList.toggle('scrolled', window.scrollY > 40);
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
  }

  /* ═══════════ SCROLL REVEAL ═══════════ */
  const revealEls = document.querySelectorAll('.reveal');
  if (revealEls.length) {
    const observer = new IntersectionObserver((entries) => {
      entries.forEach((e) => {
        if (e.isIntersecting) {
          e.target.classList.add('in');
          observer.unobserve(e.target);
        }
      });
    }, { threshold: 0.08 });
    revealEls.forEach((el) => observer.observe(el));
  }

  /* ═══════════ SMOOTH ANCHORS (scroll hint + subnav) ═══════════ */
  document.querySelectorAll('[data-scroll-to]').forEach((el) => {
    el.addEventListener('click', () => {
      const target = document.getElementById(el.dataset.scrollTo);
      if (target) target.scrollIntoView({ behavior: 'smooth' });
    });
  });

  /* ═══════════ SHARE — COPY LINK ═══════════ */
  document.querySelectorAll('.share-btn[data-share-url]').forEach((btn) => {
    btn.addEventListener('click', async () => {
      const url = btn.dataset.shareUrl;
      const title = btn.dataset.shareTitle || document.title;

      if (navigator.share) {
        try { await navigator.share({ title, url }); return; }
        catch (e) { /* dismissed — fall through to clipboard */ }
      }
      try {
        await navigator.clipboard.writeText(url);
        const original = btn.innerHTML;
        btn.innerHTML = '✓ Link copied';
        btn.classList.add('copied');
        setTimeout(() => { btn.innerHTML = original; btn.classList.remove('copied'); }, 2000);
      } catch (e) {
        window.prompt('Copy this link:', url);
      }
    });
  });

  /* ═══════════ AJAX FORMS (contact + privacy request) ═══════════
     Both forms post to admin-ajax.php with a nonce; the wp action and
     the button's "sent" label are the only differences. */
  function wireAjaxForm(formId, action, sentLabel) {
    const form = document.getElementById(formId);
    if (!form) return;
    const btn = form.querySelector('[type="submit"]');
    const idleLabel = btn.textContent;

    const feedback = (msg, success) => {
      let fb = form.querySelector('.form-feedback');
      if (!fb) {
        fb = document.createElement('p');
        btn.insertAdjacentElement('afterend', fb);
      }
      fb.textContent = msg;
      fb.className = success ? 'form-feedback ok' : 'form-feedback err';
    };

    form.addEventListener('submit', async (e) => {
      e.preventDefault();
      const email = form.elements.email.value.trim();

      if (!email || !email.includes('@')) {
        feedback('Please enter a valid email address.', false);
        return;
      }
      if (typeof fortuneData === 'undefined') {
        feedback('Please call us at (856) 454-5005 or email kevin.gianfortune@lpl.com', false);
        return;
      }

      btn.textContent = 'Sending…';
      btn.disabled = true;

      try {
        const body = new FormData(form);
        body.append('action', action);
        body.append('nonce', fortuneData.nonce);

        const res = await fetch(fortuneData.ajaxUrl, { method: 'POST', body });
        const data = await res.json();

        if (data.success) {
          feedback(data.data.message, true);
          form.reset();
          btn.textContent = sentLabel;
        } else {
          feedback((data.data && data.data.message) || 'Something went wrong. Please call us directly.', false);
          btn.textContent = idleLabel;
          btn.disabled = false;
        }
      } catch (err) {
        feedback('Network error. Please call (856) 454-5005.', false);
        btn.textContent = idleLabel;
        btn.disabled = false;
      }
    });
  }
  wireAjaxForm('fortuneContactForm', 'fortune_contact', 'Message Sent');
  wireAjaxForm('fortunePrivacyForm', 'fortune_privacy', 'Request Sent');

  /* ═══════════ VIDEO CATALOG SEARCH (/resources/videos/) ═══════════
     Live filter over the server-rendered list. Every typed word must
     appear in the item's title, description, or category name.
     Matching is case- and punctuation-insensitive ("401k" finds
     "401(k)"). Empty categories collapse while filtering. */
  const videoSearch = document.getElementById('videoSearch');
  if (videoSearch) {
    const catalog = document.getElementById('videoCatalog');
    const countEl = document.getElementById('videoSearchCount');
    const emptyEl = document.getElementById('videoSearchEmpty');
    const sections = Array.from(catalog.querySelectorAll('.calc-section'));

    const norm = (s) => s.toLowerCase().replace(/[^a-z0-9]+/g, ' ').trim();
    const squash = (s) => s.toLowerCase().replace(/[^a-z0-9]+/g, '');

    const index = [];
    sections.forEach((section) => {
      const cat = section.querySelector('.calc-section-title').textContent;
      section.querySelectorAll('.linked-list li').forEach((li) => {
        const text = li.textContent + ' ' + cat;
        index.push({ li, section, norm: norm(text), squash: squash(text) });
      });
    });

    videoSearch.addEventListener('input', () => {
      const terms = norm(videoSearch.value).split(' ').filter(Boolean);
      let shown = 0;

      index.forEach((item) => {
        const hit = terms.every((t) => item.norm.includes(t) || item.squash.includes(squash(t)));
        item.li.hidden = !hit;
        if (hit) shown++;
      });

      sections.forEach((section) => {
        section.hidden = !Array.from(section.querySelectorAll('.linked-list li')).some((li) => !li.hidden);
      });

      countEl.textContent = terms.length ? shown + ' of ' + index.length + ' videos' : '';
      emptyEl.hidden = shown > 0;
      catalog.hidden = shown === 0;
    });
  }

  /* ═══════════ HERO VIDEO FALLBACK ═══════════
     Safari refuses autoplay in Low Power Mode / flaky networks and then
     paints its native play glyph over the paused frame. Strategy:
       1. force the muted/inline flags via properties (Safari trusts
          these more than the HTML attributes),
       2. retry play() on metadata and on the first touch/click,
       3. if it still isn't playing shortly after load, hide the video
          so the gradient shows instead of a dead player. */
  const vid = document.querySelector('#hero .hero-bg video');
  if (vid) {
    vid.muted = true;
    vid.defaultMuted = true;
    vid.setAttribute('playsinline', '');

    const tryPlay = () => {
      const p = vid.play();
      if (p && p.catch) p.catch(() => { /* blocked — retry/hide handles it */ });
    };
    const hideIfStalled = () => {
      if (vid.paused) vid.style.display = 'none';
    };

    vid.addEventListener('error', () => { vid.style.display = 'none'; });
    vid.addEventListener('loadedmetadata', tryPlay);
    vid.addEventListener('playing', () => { vid.style.display = ''; });
    document.addEventListener('touchstart', tryPlay, { once: true, passive: true });
    document.addEventListener('click', tryPlay, { once: true });

    tryPlay();
    setTimeout(hideIfStalled, 4000);
  }
})();
