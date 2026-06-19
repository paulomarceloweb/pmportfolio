/* PMPortfolio — global.js */

/* ── THEME ── */
function pmInitTheme() {
  var saved = localStorage.getItem("pmportfolio-theme");
  var prefer = window.matchMedia("(prefers-color-scheme:dark)").matches
    ? "dark"
    : "light";
  var theme = saved || prefer;
  document.documentElement.dataset.theme = theme;
  document.documentElement.setAttribute("data-bs-theme", theme);
}

function pmToggleTheme() {
  var current = document.documentElement.dataset.theme;
  var next = current === "dark" ? "light" : "dark";
  document.documentElement.dataset.theme = next;
  document.documentElement.setAttribute("data-bs-theme", next);
  localStorage.setItem("pmportfolio-theme", next);
  var btn = document.getElementById("pm-theme-btn");
  if (btn) btn.textContent = next === "dark" ? "☽" : "☀";
}

/* ── LANGUAGE ── */

// Detecta idioma pela URL — fonte de verdade
var PM_LANG = (function () {
  var path = window.location.pathname;
  // Funciona em qualquer subdiretório ou raiz
  // Verifica se /en/ está presente em qualquer posição do path
  return /\/en(\/|$)/.test(path) ? "en" : "pt";
})();

function pmSetLang(l) {
  // Navegação real para URL do idioma em vez de troca JS
  var path = window.location.pathname;
  var basePath = "/pmportfolio";
  var relative = path.replace(basePath, "") || "/";

  if (l === "en") {
    // PT → EN: adiciona /en/
    if (relative !== "/en" && relative.indexOf("/en/") !== 0) {
      window.location.href = basePath + "/en" + relative;
    }
  } else {
    // EN → PT: remove /en/
    if (relative.indexOf("/en/") === 0) {
      window.location.href = basePath + relative.replace("/en", "");
    } else if (relative === "/en" || relative === "/en/") {
      window.location.href = basePath + "/";
    }
  }
}

/* ── FAQ ── */
function pmToggleFaq(btn) {
  var answer = btn.nextElementSibling;
  var isOpen = answer.classList.contains("open");
  document.querySelectorAll(".pm-faq-a").forEach(function (el) {
    el.classList.remove("open");
  });
  document.querySelectorAll(".pm-faq-q").forEach(function (el) {
    el.classList.remove("open");
  });
  if (!isOpen) {
    answer.classList.add("open");
    btn.classList.add("open");
  }
}

/* ── SKILL BARS ── */
function pmAnimateSkillBars() {
  var bars = document.querySelectorAll(".pm-skill-bar-fill");
  if (!bars.length) return;

  function animateBar(bar) {
    bar.style.transition = "none";
    bar.style.width = "0%";
    bar.offsetHeight;
    bar.style.transition = "width 1.2s cubic-bezier(0.4, 0, 0.2, 1)";
    setTimeout(function () {
      bar.style.width = (bar.dataset.w || "0") + "%";
    }, 50);
  }

  if ("IntersectionObserver" in window) {
    var obs = new IntersectionObserver(
      function (entries) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting) {
            animateBar(entry.target);
            obs.unobserve(entry.target);
          }
        });
      },
      { threshold: 0.3 },
    );
    bars.forEach(function (bar) {
      bar.style.width = "0%";
      obs.observe(bar);
    });
  } else {
    bars.forEach(function (bar) {
      animateBar(bar);
    });
  }
}

/* ── COUNTER ANIMATION ── */
function pmAnimateCounters() {
  var counters = document.querySelectorAll(".pm-stat-big, .pm-stat-num");
  if (!counters.length) return;
  if (!("IntersectionObserver" in window)) return;

  var obs = new IntersectionObserver(
    function (entries) {
      entries.forEach(function (entry) {
        if (!entry.isIntersecting) return;

        var el = entry.target;
        var numNode = el.childNodes[0];
        var text = numNode ? numNode.textContent.trim() : el.textContent.trim();
        var match = text.match(/^(\d+)(.*)$/);
        if (!match) return;

        var target = parseInt(match[1], 10);
        var suffix = match[2] || "";
        var steps = 45;
        var step = 0;
        var duration = 1400;

        var timer = setInterval(function () {
          step++;
          var ease = 1 - Math.pow(1 - step / steps, 3);
          var current = Math.round(target * ease);

          if (numNode && el.querySelector("em")) {
            numNode.textContent = current;
          } else {
            el.textContent = current + suffix;
          }

          if (step >= steps) {
            clearInterval(timer);
            if (numNode && el.querySelector("em")) {
              numNode.textContent = target;
            } else {
              el.textContent = target + suffix;
            }
          }
        }, duration / steps);

        obs.unobserve(el);
      });
    },
    { threshold: 0.5 },
  );

  counters.forEach(function (el) {
    obs.observe(el);
  });
}

/* ── FORM ── */
function pmSubmitForm(opts) {
  var o = opts || {};
  var nameEl = document.getElementById(o.nameId || "f-name");
  var emailEl = document.getElementById(o.emailId || "f-email");
  var serviceEl = document.getElementById(o.serviceId || "f-service");
  var msgEl = document.getElementById(o.msgId || "f-message");
  var honeyEl = document.querySelector('[name="website"]');
  var errEl = document.getElementById(o.errorId || "form-error");
  var okEl = document.getElementById(o.successId || "form-success");
  var formEl = document.getElementById(o.formId || "contact-form");
  var btnEl = document.getElementById(o.submitId || "f-submit");

  if (errEl) errEl.style.display = "none";
  if (honeyEl && honeyEl.value) {
    if (errEl) {
      errEl.textContent = "Erro.";
      errEl.style.display = "block";
    }
    return;
  }

  var name = nameEl ? nameEl.value.trim() : "";
  var email = emailEl ? emailEl.value.trim() : "";
  var service = serviceEl ? serviceEl.value : "ok";
  var message = msgEl ? msgEl.value.trim() : "";

  if (!name || !email || !service || !message) {
    if (errEl) {
      errEl.textContent =
        o.errRequired || "Preencha todos os campos obrigatórios.";
      errEl.style.display = "block";
    }
    return;
  }
  if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
    if (errEl) {
      errEl.textContent = o.errEmail || "Digite um e-mail válido.";
      errEl.style.display = "block";
    }
    return;
  }

  if (btnEl) {
    btnEl.disabled = true;
    btnEl.textContent = "Enviando...";
  }

  setTimeout(function () {
    if (formEl) formEl.style.display = "none";
    if (okEl) {
      okEl.style.display = "block";
      okEl.innerHTML =
        "✓ " + (o.successMsg || "Mensagem enviada! Responderei em até 24h.");
    }
  }, 1200);
}

/* ── NEWSLETTER ── */
function pmMcSubmit(inputId, wrapId, okId, okMsg) {
  var inp = document.getElementById(inputId || "mc-email");
  if (!inp || !inp.value || !inp.value.includes("@")) return;
  var wrap = document.getElementById(wrapId || "mc-wrap");
  var ok = document.getElementById(okId || "mc-ok");
  if (wrap) wrap.style.display = "none";
  if (ok) {
    ok.style.display = "block";
    ok.textContent = okMsg || "✓ Inscrito! Verifique seu e-mail.";
  }
}

/* ── PORTFOLIO FILTER ── */
function pmFilterPortfolio(btn, cat, itemSel) {
  document.querySelectorAll(".pm-filter-btn").forEach(function (b) {
    b.classList.remove("on");
  });
  btn.classList.add("on");
  document.querySelectorAll(itemSel || ".pf-item").forEach(function (item) {
    item.style.display =
      cat === "all" || item.dataset.cat === cat ? "" : "none";
  });
}

/* ── TYPEWRITER ── */
function pmTypewriter(elId, strings, speed) {
  var el = document.getElementById(elId);
  if (!el) return;
  speed = speed || { type: 75, delete: 42, pause: 2200, next: 300 };
  var si = 0,
    ci = 0,
    del = false;
  function tick() {
    var word = strings[si % strings.length];
    if (!del) {
      el.textContent = word.slice(0, ++ci);
      if (ci === word.length) {
        del = true;
        setTimeout(tick, speed.pause);
        return;
      }
    } else {
      el.textContent = word.slice(0, --ci);
      if (ci === 0) {
        del = false;
        si++;
        setTimeout(tick, speed.next);
        return;
      }
    }
    setTimeout(tick, del ? speed.delete : speed.type);
  }
  tick();
}

/* ── INIT ── */
document.addEventListener("DOMContentLoaded", function () {
  // Tema
  var isDark = document.documentElement.dataset.theme === "dark";
  var btn = document.getElementById("pm-theme-btn");
  if (btn) btn.textContent = isDark ? "☽" : "☀";

  // Marca botão de idioma ativo baseado na URL
  document.querySelectorAll(".pm-lang-btn").forEach(function (b) {
    b.classList.toggle("on", b.dataset.lang === PM_LANG);
  });

  // Animações
  pmAnimateSkillBars();
  pmAnimateCounters();
});
