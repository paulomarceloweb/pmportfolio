/* PMPortfolio — home.js */

var HOME_STRINGS = {
  pt: {
    // Hero
    "h-status": "disponível para projetos remotos",
    "h-desc":
      "Desenvolvo <strong>ecossistemas WordPress de alta performance</strong> — do zero ao deploy. Full-Stack Developer e Marketing Tech Leader com foco em <strong>código que converte</strong>.",
    "h-btn1": "Ver portfólio →",
    "h-btn2": "Falar comigo",
    "h-s1": "empresas",
    "h-s2": "anos de exp.",
    "h-s3": "filiais",

    // Stats section
    st1: "no Grupo Motta",
    st2: "anos com WordPress",
    st3: "atendidas",
    st4: "score PageSpeed",

    // Sobre preview
    "sp-ey": "sobre mim",
    "sp-badge": "anos de código",
    "sp-h":
      'Desenvolvedor que <span style="color:var(--pm-gold)">une código e resultado</span>',
    "sp-p1":
      "Sou um WordPress Developer Full-Stack com uma combinação rara: escrevo código limpo e escalável <strong>e</strong> entendo o que gera conversão.",
    "sp-p2":
      "Liderando a tecnologia de marketing do <strong>Grupo Motta</strong> — 10+ empresas, 50+ filiais — com PHP 8, Vite e OOP.",
    "sp-btn": "Conhecer minha história →",

    // Serviços
    "sv-ey": "serviços",
    "sv-h":
      'O que posso <span style="color:var(--pm-gold)">fazer por você</span>',
    "sv1-title": "Tema WordPress Premium",
    "sv1-desc":
      "Desenvolvimento de temas do zero — modulares, bilíngues, com SEO técnico avançado e performance Lighthouse 95+.",
    "sv1-price": "a partir de <strong>R$ 3.500</strong>",
    "sv2-title": "Otimização & Performance",
    "sv2-desc":
      "Auditoria completa e refactoring focado em Core Web Vitals, cache, lazy loading e eliminação de bloqueios de renderização.",
    "sv2-price": "a partir de <strong>R$ 1.200</strong>",
    "sv3-title": "Marketing Tech & Integrações",
    "sv3-desc":
      "GTM, pixels de conversão, automações com Mailchimp, Google Ads e Meta Ads integrados ao seu WordPress.",
    "sv3-price": "a partir de <strong>R$ 1.500</strong>",

    // Portfólio
    "pt-ey": "portfólio",
    "pt-h": 'Projetos <span style="color:var(--pm-gold)">em destaque</span>',
    "pf-all": "todos",
    "pt-more": "Ver todos os projetos →",

    // CTA
    "cta-ey": "vamos trabalhar juntos",
    "cta-h":
      'Tem um projeto? <span style="color:var(--pm-gold)">Vamos conversar.</span>',
    "cta-p":
      "Disponível para projetos freelance, consultorias e posições remotas. Respondo em até 24h.",
    "cta-b1": "Enviar mensagem →",
    "cta-b2": "Ver portfólio",

    // Newsletter
    "mc-ey": "newsletter",
    "mc-h": "Conteúdo técnico na sua caixa de entrada",
    "mc-p":
      "WordPress, PHP 8, performance e marketing tech — sem spam, sem enrolação.",
    "mc-note": "✦ sem spam · cancele quando quiser · via Mailchimp",
    "mc-btn": "Inscrever",
  },

  en: {
    // Hero
    "h-status": "available for remote projects",
    "h-desc":
      "I build <strong>high-performance WordPress ecosystems</strong> — from scratch to deploy. Full-Stack Developer and Marketing Tech Leader focused on <strong>code that converts</strong>.",
    "h-btn1": "View portfolio →",
    "h-btn2": "Get in touch",
    "h-s1": "companies",
    "h-s2": "years exp.",
    "h-s3": "branches",

    // Stats section
    st1: "in Grupo Motta",
    st2: "years with WordPress",
    st3: "locations served",
    st4: "PageSpeed score",

    // Sobre preview
    "sp-ey": "about me",
    "sp-badge": "years of code",
    "sp-h":
      'Developer who <span style="color:var(--pm-gold)">bridges code and growth</span>',
    "sp-p1":
      "I'm a Full-Stack WordPress Developer with a rare combination: I write clean, scalable code <strong>and</strong> understand what drives conversions.",
    "sp-p2":
      "Leading marketing technology at <strong>Grupo Motta</strong> — 10+ companies, 50+ branches — using PHP 8, Vite and OOP.",
    "sp-btn": "Learn my story →",

    // Services
    "sv-ey": "services",
    "sv-h": 'What I can <span style="color:var(--pm-gold)">do for you</span>',
    "sv1-title": "Premium WordPress Theme",
    "sv1-desc":
      "Theme development from scratch — modular, bilingual, with advanced technical SEO and Lighthouse 95+ performance.",
    "sv1-price": "starting at <strong>$700</strong>",
    "sv2-title": "Optimization & Performance",
    "sv2-desc":
      "Full audit and refactoring focused on Core Web Vitals, caching, lazy loading and render-blocking elimination.",
    "sv2-price": "starting at <strong>$240</strong>",
    "sv3-title": "Marketing Tech & Integrations",
    "sv3-desc":
      "GTM, conversion pixels, Mailchimp automations, Google Ads and Meta Ads integrated into your WordPress.",
    "sv3-price": "starting at <strong>$300</strong>",

    // Portfolio
    "pt-ey": "portfolio",
    "pt-h": 'Featured <span style="color:var(--pm-gold)">projects</span>',
    "pf-all": "all",
    "pt-more": "View all projects →",

    // CTA
    "cta-ey": "let's work together",
    "cta-h":
      'Have a project? <span style="color:var(--pm-gold)">Let\'s talk.</span>',
    "cta-p":
      "Available for freelance projects, consulting and remote positions. I reply within 24h.",
    "cta-b1": "Send message →",
    "cta-b2": "View portfolio",

    // Newsletter
    "mc-ey": "newsletter",
    "mc-h": "Technical content in your inbox",
    "mc-p":
      "WordPress, PHP 8, performance and marketing tech — no spam, no fluff.",
    "mc-note": "✦ no spam · unsubscribe anytime · via Mailchimp",
    "mc-btn": "Subscribe",
  },
};

var TYPED_STRINGS = {
  pt: [
    "WordPress Developer",
    "Marketing Tech Leader",
    "Dev Full-Stack",
    "PHP 8 Specialist",
  ],
  en: [
    "WordPress Developer",
    "Marketing Tech Leader",
    "Full-Stack Dev",
    "PHP 8 Specialist",
  ],
};

function pmApplyLang(lang) {
  var S = HOME_STRINGS[lang] || HOME_STRINGS.pt;
  Object.keys(S).forEach(function (id) {
    var el = document.getElementById(id);
    if (el) el.innerHTML = S[id];
  });
}

document.addEventListener("DOMContentLoaded", function () {
  var lang = /\/en(\/|$)/.test(window.location.pathname) ? "en" : "pt";

  pmApplyLang(lang);
  pmTypewriter("typed", TYPED_STRINGS[lang] || TYPED_STRINGS.pt);

  var origSetLang = window.pmSetLang;
  if (typeof origSetLang === "function") {
    window.pmSetLang = function (l) {
      origSetLang(l);
      pmApplyLang(l);
      pmTypewriter("typed", TYPED_STRINGS[l] || TYPED_STRINGS.pt);
    };
  }
});
