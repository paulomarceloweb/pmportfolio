<?php

/**
 * PMPortfolio — functions.php
 *
 * Ponto de entrada do tema WordPress.
 * Este arquivo faz apenas três coisas:
 *   1. Define constantes globais
 *   2. Registra o autoloader PSR-4
 *   3. Inicializa o tema com uma linha
 *
 * Todo o código real vive em inc/
 *
 * @package PMPortfolio
 */

defined('ABSPATH') || exit;

// ─────────────────────────────────────────────────────
// 1. CONSTANTES GLOBAIS
//
// Definimos aqui para usar em qualquer arquivo do tema
// sem precisar chamar get_template_directory() toda hora.
// ─────────────────────────────────────────────────────

/** Versão do tema — usada no cache busting de assets */
define('PMPORTFOLIO_VERSION', '1.0.0');

/** Caminho absoluto no servidor: C:/wamp64/www/.../pmportfolio */
define('PMPORTFOLIO_DIR', get_template_directory());

/** URL pública do tema: http://localhost/pmportfolio/wp-content/themes/pmportfolio */
define('PMPORTFOLIO_URI', get_template_directory_uri());

/** Ambiente atual — trocar para 'production' no deploy */
define('PMPORTFOLIO_ENV', 'development');

// ─────────────────────────────────────────────────────
// 2. AUTOLOADER PSR-4
//
// Carrega classes automaticamente pelo namespace.
// PMPortfolio\Core\Theme  →  inc/core/class-theme.php
// PMPortfolio\SEO\Schema  →  inc/seo/class-schema.php
//
// Sem isso, precisaríamos de um require_once para
// cada classe — impossível de manter.
// ─────────────────────────────────────────────────────

require_once PMPORTFOLIO_DIR . '/inc/core/class-autoloader.php';

(new PMPortfolio\Core\Autoloader(PMPORTFOLIO_DIR . '/inc'))->register();

// ─────────────────────────────────────────────────────
// 3. INICIALIZAÇÃO DO TEMA
//
// Uma linha. O resto é responsabilidade da classe Theme.
// ─────────────────────────────────────────────────────

(new PMPortfolio\Core\Theme())->boot();


// DIAGNÓSTICO TEMPORÁRIO
add_action('init', function () {
    error_log('Sitemap class exists: ' . (class_exists('PMPortfolio\SEO\Sitemap') ? 'YES' : 'NO'));
    error_log('Robots class exists: ' . (class_exists('PMPortfolio\SEO\Robots') ? 'YES' : 'NO'));
});
