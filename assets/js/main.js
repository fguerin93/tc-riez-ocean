/**
 * TC Riez Océan — front JS.
 * - Scroll state sur la nav
 * - Menu mobile (burger)
 * - Reveal on scroll
 */

(function () {
  'use strict';

  /* ───────── NAV SCROLL ───────── */
  const hdr = document.getElementById('hdr');
  if (hdr) {
    const onScroll = () => {
      if (window.scrollY > 50) {
        hdr.style.cssText = 'background:rgba(14,27,46,.97);border-bottom:1px solid rgba(230,51,41,.22)';
      } else {
        hdr.style.cssText = 'background:linear-gradient(to bottom,rgba(14,27,46,.92),transparent)';
      }
    };
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
  }

  /* ───────── MOBILE MENU ───────── */
  const brg   = document.getElementById('brg');
  const mmenu = document.getElementById('mmenu');

  if (brg && mmenu) {
    let open = false;

    const openMenu = () => {
      open = true;
      mmenu.classList.replace('closed', 'open');
      brg.classList.add('x');
      brg.setAttribute('aria-expanded', 'true');
      document.body.style.overflow = 'hidden';
    };
    const closeMenu = () => {
      open = false;
      mmenu.classList.replace('open', 'closed');
      brg.classList.remove('x');
      brg.setAttribute('aria-expanded', 'false');
      document.body.style.overflow = '';
    };

    brg.addEventListener('click', () => (open ? closeMenu() : openMenu()));

    mmenu.querySelectorAll('[data-close]').forEach((el) => {
      el.addEventListener('click', closeMenu);
    });

    // Close with Escape.
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape' && open) closeMenu();
    });
  }

  /* ───────── REVEAL ON SCROLL ───────── */
  const els = document.querySelectorAll('.reveal');
  if (els.length && 'IntersectionObserver' in window) {
    const obs = new IntersectionObserver(
      (entries) => {
        entries.forEach((e) => {
          if (e.isIntersecting) {
            const idx = Array.from(e.target.parentElement?.children || []).indexOf(e.target);
            setTimeout(() => e.target.classList.add('on'), Math.min(idx * 90, 270));
            obs.unobserve(e.target);
          }
        });
      },
      { threshold: 0.08, rootMargin: '0px 0px -20px 0px' }
    );
    els.forEach((el) => obs.observe(el));
  } else {
    // Fallback : tout visible.
    els.forEach((el) => el.classList.add('on'));
  }
})();
