/* PMPortfolio — home.js */

var HOME_STRINGS = {
  pt: {
    'h-status': 'disponível para projetos',
    'h-desc': 'Construo <strong>sistemas que escalam</strong> — do banco de dados ao pixel. Especialista em arquitetura web, performance e experiências que <strong>convertem código em resultado</strong>.',
    'h-btn1': 'Ver portfólio →',
    'h-btn2': 'Falar comigo',
    'h-s1': 'projetos',
    'h-s2': 'anos de exp.',
    'h-s3': 'clientes',
    'st1': 'entregues com sucesso',
    'st2': 'anos de desenvolvimento',
    'st3': 'em 4 países',
    'st4': 'score PageSpeed',
    'sp-ey': 'sobre mim',
    'sp-badge': 'anos de código',
    'sp-h': 'Engenheiro que <span style="color:var(--pm-gold)">pensa em sistemas</span>',
    'sp-p1': 'Trabalho na interseção entre <strong>arquitetura técnica robusta</strong> e produto que as pessoas realmente usam.',
    'sp-p2': 'Com foco em <strong>WordPress, PHP 8 e ecosistema moderno</strong>, construo desde temas premium performáticos até APIs e integrações complexas.',
    'sp-btn': 'Conhecer minha história →',
    'sv-ey': 'serviços',
    'sv-h': 'O que posso <span style="color:var(--pm-gold)">fazer por você</span>',
    'sv1-title': 'Tema WordPress Premium',
    'sv1-desc': 'Desenvolvimento de temas do zero — modulares, bilíngues, com SEO técnico avançado e performance Lighthouse 95+.',
    'sv1-price': 'a partir de <strong>R$ 3.500</strong>',
    'sv2-title': 'Otimização & Performance',
    'sv2-desc': 'Auditoria completa e refactoring focado em Core Web Vitals, cache, lazy loading e eliminação de bloqueios.',
    'sv2-price': 'a partir de <strong>R$ 1.200</strong>',
    'sv3-title': 'API & Integrações',
    'sv3-desc': 'REST API customizada, webhooks, integrações com CRMs, gateways de pagamento e serviços de terceiros.',
    'sv3-price': 'a partir de <strong>R$ 2.000</strong>',
    'pt-ey': 'portfólio',
    'pt-h': 'Projetos <span style="color:var(--pm-gold)">em destaque</span>',
    'pf-all': 'todos',
    'pt-more': 'Ver todos os projetos →',
    'cta-ey': 'vamos trabalhar juntos',
    'cta-h': 'Tem um projeto? <span style="color:var(--pm-gold)">Vamos conversar.</span>',
    'cta-p': 'Estou disponível para projetos freelance, consultorias e posições em produto. Respondo em até 24h.',
    'cta-b1': 'Enviar mensagem →',
    'cta-b2': 'Ver portfólio',
    'mc-ey': 'newsletter',
    'mc-h': 'Conteúdo técnico na sua caixa de entrada',
    'mc-p': 'PHP avançado, WordPress internals, performance — sem spam, sem papo furado.',
    'mc-note': '✦ sem spam · cancele quando quiser · via Mailchimp',
    'mc-btn': 'Inscrever'
  },
  en: {
    'h-status': 'available for projects',
    'h-desc': 'I build <strong>systems that scale</strong> — from database to pixel. Specialist in web architecture, performance and experiences that <strong>turn code into results</strong>.',
    'h-btn1': 'View portfolio →',
    'h-btn2': 'Get in touch',
    'h-s1': 'projects',
    'h-s2': 'years exp.',
    'h-s3': 'clients',
    'st1': 'successfully delivered',
    'st2': 'years of development',
    'st3': 'across 4 countries',
    'st4': 'PageSpeed score',
    'sp-ey': 'about me',
    'sp-badge': 'years of code',
    'sp-h': 'Engineer who <span style="color:var(--pm-gold)">thinks in systems</span>',
    'sp-p1': 'I work at the intersection of <strong>robust technical architecture</strong> and products people actually use.',
    'sp-p2': 'Focused on <strong>WordPress, PHP 8 and modern ecosystem</strong>, I build from premium themes to complex APIs.',
    'sp-btn': 'Learn my story →',
    'sv-ey': 'services',
    'sv-h': 'What I can <span style="color:var(--pm-gold)">do for you</span>',
    'sv1-title': 'Premium WordPress Theme',
    'sv1-desc': 'Theme development from scratch — modular, bilingual, with advanced technical SEO and Lighthouse 95+ performance.',
    'sv1-price': 'starting at <strong>$700</strong>',
    'sv2-title': 'Optimization & Performance',
    'sv2-desc': 'Full audit and refactoring focused on Core Web Vitals, caching, lazy loading and render-blocking elimination.',
    'sv2-price': 'starting at <strong>$240</strong>',
    'sv3-title': 'API & Integrations',
    'sv3-desc': 'Custom REST API, webhooks, CRM integrations, payment gateways and third-party services.',
    'sv3-price': 'starting at <strong>$400</strong>',
    'pt-ey': 'portfolio',
    'pt-h': 'Featured <span style="color:var(--pm-gold)">projects</span>',
    'pf-all': 'all',
    'pt-more': 'View all projects →',
    'cta-ey': "let's work together",
    'cta-h': 'Have a project? <span style="color:var(--pm-gold)">Let\'s talk.</span>',
    'cta-p': 'Available for freelance, consulting and product positions. I reply within 24h.',
    'cta-b1': 'Send message →',
    'cta-b2': 'View portfolio',
    'mc-ey': 'newsletter',
    'mc-h': 'Technical content in your inbox',
    'mc-p': 'Advanced PHP, WordPress internals, performance — no spam, no fluff.',
    'mc-note': '✦ no spam · unsubscribe anytime · via Mailchimp',
    'mc-btn': 'Subscribe'
  }
};

var TYPED_STRINGS = {
  pt: ['Engenheiro de Software', 'Arquiteto WordPress', 'Dev Full-Stack', 'Especialista PHP 8'],
  en: ['Software Engineer', 'WordPress Architect', 'Full-Stack Dev', 'PHP 8 Specialist']
};

function pmApplyLang(lang) {
  var S = HOME_STRINGS[lang] || HOME_STRINGS.pt;
  Object.keys(S).forEach(function (id) {
    var el = document.getElementById(id);
    if (el) el.innerHTML = S[id];
  });
}

document.addEventListener('DOMContentLoaded', function () {
  var lang = typeof PM_LANG !== 'undefined' ? PM_LANG : 'pt';
  pmApplyLang(lang);

  // Typewriter
  if (typeof pmTypewriter === 'function') {
    pmTypewriter('typed', TYPED_STRINGS[lang] || TYPED_STRINGS.pt);
  }

  // Re-inicia typewriter ao trocar idioma
  var origSetLang = window.pmSetLang;
  if (typeof origSetLang === 'function') {
    window.pmSetLang = function (l) {
      origSetLang(l);
      pmApplyLang(l);
      pmTypewriter('typed', TYPED_STRINGS[l] || TYPED_STRINGS.pt);
    };
  }
});