/* PMPortfolio — sobre.js */

/* ── TIMELINE VER MAIS ── */
function pmToggleTimeline(btn) {
  var hidden = document.querySelectorAll('.pm-tl-hidden');
  var isOpen = btn.dataset.open === '1';
  var spans = btn.querySelectorAll('span');

  if (!isOpen) {
    hidden.forEach(function (el) { el.classList.add('visible'); });
    btn.dataset.open = '1';
    if (spans[0]) spans[0].textContent = 'ver menos';
    if (spans[1]) spans[1].textContent = '↑';
  } else {
    hidden.forEach(function (el) { el.classList.remove('visible'); });
    btn.dataset.open = '0';
    if (spans[0]) spans[0].textContent = 'ver mais experiências';
    if (spans[1]) spans[1].textContent = '↓';
  }
}

/* ── IDIOMA ── */
function pmApplyLang(lang) {
  /* multilíngue — implementar na etapa 4 */
}

/* ── INIT ── */
document.addEventListener('DOMContentLoaded', function () {

  /* SKILL BARS */
  var bars = document.querySelectorAll('.pm-skill-bar-fill');

  if (bars.length) {
    if ('IntersectionObserver' in window) {
      var obs = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting) {
            var bar = entry.target;
            var w = bar.dataset.w || '0';

            bar.style.transition = 'none';
            bar.style.width = '0%';
            bar.offsetHeight;
            bar.style.transition = 'width 1.2s cubic-bezier(0.4, 0, 0.2, 1)';

            setTimeout(function () {
              bar.style.width = w + '%';
            }, 50);

            obs.unobserve(bar);
          }
        });
      }, { threshold: 0.2 });

      bars.forEach(function (bar) { obs.observe(bar); });

    } else {
      bars.forEach(function (bar) {
        bar.style.width = (bar.dataset.w || '0') + '%';
      });
    }
  }

  /* CONTADORES */
  if (typeof pmAnimateCounters === 'function') {
    pmAnimateCounters();
  }

});