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

  /* ═══════════ SOLUTIONS SUB-NAV SCROLLSPY ═══════════ */
  const subnav = document.getElementById('solSubnav');
  if (subnav) {
    const links = subnav.querySelectorAll('a[data-section]');
    const sections = Array.from(links)
      .map((a) => document.getElementById(a.dataset.section))
      .filter(Boolean);

    const setActive = (id) => {
      links.forEach((a) => a.classList.toggle('active', a.dataset.section === id));
    };

    const spy = new IntersectionObserver((entries) => {
      entries.forEach((e) => {
        if (e.isIntersecting) setActive(e.target.id);
      });
    }, { rootMargin: '-35% 0px -55% 0px' });
    sections.forEach((s) => spy.observe(s));

    // Keep the active pill scrolled into view inside the sub-nav strip.
    links.forEach((a) => {
      a.addEventListener('click', () => {
        a.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
      });
    });
  }

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

  /* ═══════════ CONTACT FORM ═══════════ */
  const form = document.getElementById('fortuneContactForm');
  if (form) {
    form.addEventListener('submit', async (e) => {
      e.preventDefault();
      const btn = document.getElementById('fortuneSubmitBtn');
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
        body.append('action', 'fortune_contact');
        body.append('nonce', fortuneData.nonce);

        const res = await fetch(fortuneData.ajaxUrl, { method: 'POST', body });
        const data = await res.json();

        if (data.success) {
          feedback(data.data.message, true);
          form.reset();
          btn.textContent = 'Message Sent';
        } else {
          feedback((data.data && data.data.message) || 'Something went wrong. Please call us directly.', false);
          btn.textContent = 'Send Message';
          btn.disabled = false;
        }
      } catch (err) {
        feedback('Network error. Please call (856) 454-5005.', false);
        btn.textContent = 'Send Message';
        btn.disabled = false;
      }
    });

    function feedback(msg, success) {
      let fb = document.getElementById('fortune-form-feedback');
      if (!fb) {
        fb = document.createElement('p');
        fb.id = 'fortune-form-feedback';
        document.getElementById('fortuneSubmitBtn').insertAdjacentElement('afterend', fb);
      }
      fb.textContent = msg;
      fb.className = success ? 'form-feedback ok' : 'form-feedback err';
    }
  }

  /* ═══════════ HERO VIDEO FALLBACK ═══════════ */
  const vid = document.querySelector('#hero .hero-bg video');
  if (vid) {
    vid.addEventListener('error', () => { vid.style.display = 'none'; });
    vid.addEventListener('loadedmetadata', () => {
      const p = vid.play();
      if (p && p.catch) p.catch(() => { /* autoplay blocked — gradient shows */ });
    });
  }
})();
