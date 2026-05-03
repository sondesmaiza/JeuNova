/* ============================================================
   JeuNova Responsable — responsable.js
   Scroll reveal, sidebar overlay, active nav link, confirm delete, topbar shadow
   Inspiré de admin.js
   ============================================================ */

document.addEventListener('DOMContentLoaded', () => {

  /* ─── 1. Scroll Reveal (.fade-up) ─────────────────────── */
  const fadeEls = document.querySelectorAll('.fade-up');
  if (fadeEls.length) {
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(e => {
        if (e.isIntersecting) {
          e.target.classList.add('appeared');
          observer.unobserve(e.target);
        }
      });
    }, { threshold: 0.1 });
    fadeEls.forEach(el => observer.observe(el));
  }

  /* ─── 2. Sidebar Mobile : overlay ─────────────────────── */
  const sidebar  = document.getElementById('sidebar');
  const toggle   = document.getElementById('sidebarToggle');

  if (sidebar && toggle) {
    // Créer l'overlay dynamiquement
    const overlay = document.createElement('div');
    overlay.className = 'sidebar-overlay';
    overlay.id = 'sidebarOverlay';
    document.body.appendChild(overlay);

    toggle.addEventListener('click', () => {
      sidebar.classList.toggle('show');
      overlay.style.display = sidebar.classList.contains('show') ? 'block' : 'none';
    });
    overlay.addEventListener('click', () => {
      sidebar.classList.remove('show');
      overlay.style.display = 'none';
    });
  }

  /* ─── 3. Marquer le lien actif dans la sidebar ─────────── */
  const currentPath = window.location.pathname;
  document.querySelectorAll('.sidebar .nav-item > a').forEach(link => {
    const href = link.getAttribute('href') || '';
    if (href && currentPath.endsWith(href.split('/').pop())) {
      link.classList.add('active');
    }
  });

  /* ─── 4. Animation entrée des stat-cards ──────────────── */
  document.querySelectorAll('.stat-card').forEach((card, i) => {
    card.style.animationDelay = `${i * 0.07}s`;
    card.style.animation = 'cardSlideIn 0.5s var(--ease-smooth) both';
  });

  /* ─── 5. Confirmation suppression (boutons delete) ─────── */
  document.querySelectorAll('a[href*="delete"]').forEach(btn => {
    btn.addEventListener('click', e => {
      if (!confirm('Êtes-vous sûr de vouloir supprimer cet élément ?')) {
        e.preventDefault();
      }
    });
  });

  /* ─── 6. Topbar : ombre au scroll ─────────────────────── */
  const topbar = document.querySelector('.navbar-top');
  if (topbar) {
    window.addEventListener('scroll', () => {
      if (window.scrollY > 8) {
        topbar.style.boxShadow = '0 8px 30px rgba(0,0,0,0.06)';
      } else {
        topbar.style.boxShadow = '0 4px 20px rgba(0,0,0,0.03)';
      }
    }, { passive: true });
  }
});