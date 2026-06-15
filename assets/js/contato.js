/**
 * PMPortfolio — contato.js
 * JS exclusivo da pagina contato
 * Depende de: global.js (carregado antes)
 */

/* Strings PT/EN — cole do preview validado */
var PAGE_STRINGS = {
  pt: {},
  en: {}
};

/* Aplica idioma — chamado por pmSetLang() no global.js */
function pmApplyLang(lang) {
  var S = PAGE_STRINGS[lang] || PAGE_STRINGS.pt;
  Object.keys(S).forEach(function(id) {
    var el = document.getElementById(id);
    if (el) el.innerHTML = S[id];
  });
}

document.addEventListener('DOMContentLoaded', function() {
  pmApplyLang(typeof PM_LANG !== 'undefined' ? PM_LANG : 'pt');
  /* TODO: init especifico de contato */
});
