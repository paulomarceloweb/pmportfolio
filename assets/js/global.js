/**
 * PMPortfolio — global.js
 * Compartilhado por todas as páginas
 * - Anti-flash dark mode (inline no <head> via script bloqueante)
 * - Language switcher
 * - Theme toggle
 * - FAQ accordion
 * - Form validation + honeypot
 * - Skill bars animation
 * - Newsletter Mailchimp submit
 */

/* ══════════════════════════════════════
   THEME — persiste no localStorage
══════════════════════════════════════ */
function pmInitTheme() {
  const saved = localStorage.getItem('pmportfolio-theme');
  const prefer = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
  const theme = saved || prefer;
  document.documentElement.dataset.theme = theme;
  document.documentElement.setAttribute('data-bs-theme', theme);
}

function pmToggleTheme() {
  const current = document.documentElement.dataset.theme;
  const next = current === 'dark' ? 'light' : 'dark';
  document.documentElement.dataset.theme = next;
  document.documentElement.setAttribute('data-bs-theme', next);
  localStorage.setItem('pmportfolio-theme', next);
  const btn = document.getElementById('pm-theme-btn');
  if (btn) btn.textContent = next === 'dark' ? '☽' : '☀';
}

/* ══════════════════════════════════════
   LANGUAGE — cookie + URL /en/
   No WordPress, a detecção real é feita via
   Language_Router (PHP). Aqui é só o preview.
══════════════════════════════════════ */
let PM_LANG = document.documentElement.lang === 'en-US' ? 'en' : 'pt';
let PM_STRINGS = {};

function pmSetLang(l) {
  PM_LANG = l;
  document.querySelectorAll('.pm-lang-btn').forEach(b => {
    b.classList.toggle('on', b.dataset.lang === l);
  });
  if (typeof pmApplyLang === 'function') pmApplyLang(l);
  // cookie para persistência
  document.cookie = `pmportfolio-lang=${l};path=/;max-age=31536000`;
}

/* ══════════════════════════════════════
   FAQ ACCORDION
══════════════════════════════════════ */
function pmToggleFaq(btn) {
  const answer = btn.nextElementSibling;
  const isOpen = answer.classList.contains('open');
  // fecha todos
  document.querySelectorAll('.pm-faq-a').forEach(el => el.classList.remove('open'));
  document.querySelectorAll('.pm-faq-q').forEach(el => el.classList.remove('open'));
  // abre o clicado (se estava fechado)
  if (!isOpen) {
    answer.classList.add('open');
    btn.classList.add('open');
  }
}

/* ══════════════════════════════════════
   SKILL BARS ANIMATION
   Usa IntersectionObserver para animar
   apenas quando visível
══════════════════════════════════════ */
/* ── SKILL BARS ── */
function pmAnimateSkillBars() {
  var bars = document.querySelectorAll('.pm-skill-bar-fill');
  if (!bars.length) return;

  function animateBar(bar) {
    // Força reflow antes de aplicar a largura
    // sem isso a transição CSS não dispara
    bar.style.width = '0%';
    bar.offsetHeight; // lê propriedade para forçar reflow
    setTimeout(function () {
      bar.style.width = bar.dataset.w + '%';
    }, 50);
  }

  if ('IntersectionObserver' in window) {
    var observer = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          animateBar(entry.target);
          observer.unobserve(entry.target);
        }
      });
    }, { threshold: 0.3 });

    bars.forEach(function (bar) {
      bar.style.width = '0%';
      observer.observe(bar);
    });
  } else {
    bars.forEach(function (bar) { animateBar(bar); });
  }
}

/* ══════════════════════════════════════
   FORMULÁRIO DE CONTATO
   - Validação client-side
   - Honeypot anti-spam
   - Envio simulado (no WP: wp_ajax)
══════════════════════════════════════ */
function pmSubmitForm(opts = {}) {
  const {
    nameId = 'f-name',
    emailId = 'f-email',
    serviceId = 'f-service',
    messageId = 'f-message',
    honeypotSel = '[name="website"]',
    formId = 'contact-form',
    successId = 'form-success',
    errorId = 'form-error',
    submitId = 'f-submit',
    successMsg = 'Mensagem enviada! Responderei em até 24h.',
    errRequired = 'Preencha todos os campos obrigatórios.',
    errEmail = 'Digite um e-mail válido.',
    errHoney = 'Erro de validação.',
  } = opts;

  const name = document.getElementById(nameId)?.value.trim();
  const email = document.getElementById(emailId)?.value.trim();
  const service = document.getElementById(serviceId)?.value;
  const message = document.getElementById(messageId)?.value.trim();
  const honey = document.querySelector(honeypotSel)?.value;
  const errEl = document.getElementById(errorId);

  if (errEl) errEl.style.display = 'none';

  // honeypot
  if (honey) { if (errEl) { errEl.textContent = errHoney; errEl.style.display = 'block'; } return; }

  // required
  if (!name || !email || !service || !message) {
    if (errEl) { errEl.textContent = errRequired; errEl.style.display = 'block'; } return;
  }

  // email format
  if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
    if (errEl) { errEl.textContent = errEmail; errEl.style.display = 'block'; } return;
  }

  const btn = document.getElementById(submitId);
  if (btn) { btn.disabled = true; btn.textContent = '...'; }

  // No WordPress, aqui será uma chamada fetch para wp_ajax
  // fetch(pmAjax.url, { method:'POST', body: new FormData(form) })
  setTimeout(() => {
    const formEl = document.getElementById(formId);
    if (formEl) formEl.style.display = 'none';
    const successEl = document.getElementById(successId);
    if (successEl) { successEl.style.display = 'block'; successEl.textContent = '✓ ' + successMsg; }
  }, 1200);
}

/* ══════════════════════════════════════
   NEWSLETTER MAILCHIMP
   No WP: substituir por integração real
   com Mailchimp API via wp_ajax
══════════════════════════════════════ */
function pmMcSubmit(opts = {}) {
  const {
    inputId = 'mc-email',
    wrapSel = '.pm-mc-form-wrap',
    okId = 'mc-ok',
    okMsg = '✓ Inscrito! Verifique seu e-mail.',
  } = opts;

  const val = document.getElementById(inputId)?.value;
  if (!val || !val.includes('@')) return;

  const wrap = document.querySelector(wrapSel);
  if (wrap) wrap.style.display = 'none';

  const ok = document.getElementById(okId);
  if (ok) { ok.style.display = 'block'; ok.textContent = okMsg; }
}

/* ══════════════════════════════════════
   PORTFOLIO FILTER
══════════════════════════════════════ */
function pmFilterPortfolio(btn, cat, itemSel = '.pf-item') {
  document.querySelectorAll('.pm-filter-btn, .pm-pf-btn').forEach(b => b.classList.remove('on'));
  btn.classList.add('on');
  document.querySelectorAll(itemSel).forEach(item => {
    item.style.display = (cat === 'all' || item.dataset.cat === cat) ? '' : 'none';
  });
}

/* ══════════════════════════════════════
   TYPEWRITER
══════════════════════════════════════ */
function pmTypewriter(elId, strings, speed = { type: 75, delete: 42, pause: 2200, next: 300 }) {
  const el = document.getElementById(elId);
  if (!el) return;
  let si = 0, ci = 0, del = false;

  function tick() {
    const word = strings[si % strings.length];
    if (!del) {
      el.textContent = word.slice(0, ++ci);
      if (ci === word.length) { del = true; setTimeout(tick, speed.pause); return; }
    } else {
      el.textContent = word.slice(0, --ci);
      if (ci === 0) { del = false; si++; setTimeout(tick, speed.next); return; }
    }
    setTimeout(tick, del ? speed.delete : speed.type);
  }
  tick();
}


/* ── COUNTER ANIMATION ── */
function pmAnimateCounters() {
  var counters = document.querySelectorAll('.pm-stat-big, .pm-stat-num, .pm-stat-big-sobre');
  if (!counters.length) return;
  if (!('IntersectionObserver' in window)) return;

  var observer = new IntersectionObserver(function (entries) {
    entries.forEach(function (entry) {
      if (!entry.isIntersecting) return;

      var el = entry.target;
      var numNode = el.childNodes[0];
      var text = numNode ? numNode.textContent.trim() : el.textContent.trim();
      var match = text.match(/^(\d+)(.*)$/);
      if (!match) return;

      var target = parseInt(match[1], 10);
      var suffix = match[2] || '';
      var duration = 1400;
      var steps = 45;
      var step = 0;

      var timer = setInterval(function () {
        step++;
        var ease = 1 - Math.pow(1 - step / steps, 3);
        var current = Math.round(target * ease);

        if (numNode && el.querySelector('em')) {
          numNode.textContent = current;
        } else {
          el.textContent = current + suffix;
        }

        if (step >= steps) {
          clearInterval(timer);
          if (numNode && el.querySelector('em')) {
            numNode.textContent = target;
          } else {
            el.textContent = target + suffix;
          }
        }
      }, duration / steps);

      observer.unobserve(el);
    });
  }, { threshold: 0.5 });

  counters.forEach(function (el) { observer.observe(el); });
}


/* ══════════════════════════════════════
   INIT — roda no DOMContentLoaded
══════════════════════════════════════ */
document.addEventListener('DOMContentLoaded', () => {
  // Atualiza ícone do botão de tema
  const isDark = document.documentElement.dataset.theme === 'dark';
  const themeBtn = document.getElementById('pm-theme-btn');
  if (themeBtn) themeBtn.textContent = isDark ? '☽' : '☀';

  // Marca lang btn ativo
  document.querySelectorAll('.pm-lang-btn').forEach(b => {
    b.classList.toggle('on', b.dataset.lang === PM_LANG);
  });

  // Skill bars
  pmAnimateSkillBars();
  pmAnimateCounters(); // ← adiciona esta linha
});
