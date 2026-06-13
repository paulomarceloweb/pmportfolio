<?php

/**
 * PMPortfolio — Asset Manager
 *
 * Gerencia o enfileiramento de CSS e JS.
 * Princípio central: cada página carrega APENAS o que precisa.
 *
 * Estrutura:
 *   Global (toda página): Bootstrap CDN + design-system.css + global.css + global.js
 *   Por página:           home.css/js · blog.css/js · portfolio.css/js · etc.
 *
 * @package PMPortfolio\Core
 */

namespace PMPortfolio\Core;

defined('ABSPATH') || exit;

class Asset_Manager
{

    /**
     * Registra os hooks de enfileiramento.
     */
    public function register(): void
    {
        add_action('wp_enqueue_scripts', [$this, 'enqueue_global']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_per_page']);
        add_action('wp_enqueue_scripts', [$this, 'dequeue_unwanted']);
        add_action('wp_head',            [$this, 'preconnect_fonts'], 1);
    }

    /**
     * Assets globais — carregados em TODAS as páginas do frontend.
     */
    public function enqueue_global(): void
    {

        // Bootstrap 5.3 CSS via CDN
        // null como versão = sem ?ver= na URL (CDN tem cache próprio)
        wp_enqueue_style(
            'bootstrap',
            'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css',
            [],
            null
        );

        // Design System — todas as CSS Variables dark/light
        wp_enqueue_style(
            'pm-design-system',
            PMPORTFOLIO_URI . '/assets/css/design-system.css',
            ['bootstrap'],
            PMPORTFOLIO_VERSION
        );

        // Global CSS — navbar, footer, botões, componentes compartilhados
        wp_enqueue_style(
            'pm-global',
            PMPORTFOLIO_URI . '/assets/css/global.css',
            ['pm-design-system'],
            PMPORTFOLIO_VERSION
        );

        // Bootstrap JS via CDN (bundle já inclui o Popper.js)
        wp_enqueue_script(
            'bootstrap',
            'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js',
            [],
            null,
            true // true = carrega no rodapé, antes de </body>
        );

        // Global JS — theme toggle, lang switch, FAQ accordion, form
        wp_enqueue_script(
            'pm-global',
            PMPORTFOLIO_URI . '/assets/js/global.js',
            ['bootstrap'],
            PMPORTFOLIO_VERSION,
            true
        );
    }

    /**
     * Assets por página — cada template carrega apenas o seu.
     *
     * Por que isso importa para performance?
     * Um visitante na página de contato não precisa carregar
     * o CSS do portfólio ou o JS do blog. Cada kb a menos
     * é tempo de carregamento reduzido.
     */
    public function enqueue_per_page(): void
    {

        // HOME — front-page.php
        if (is_front_page()) {
            $this->enqueue_page('home');
            return;
        }

        // BLOG — lista de posts (home.php)
        if (is_home() || is_category() || is_tag()) {
            $this->enqueue_page('blog');
            return;
        }

        // SINGLE POST — artigo individual
        if (is_singular('post')) {
            $this->enqueue_page('blog', 'blog-single');
            return;
        }

        // PORTFÓLIO — archive (lista de projetos)
        if (is_post_type_archive('portfolio')) {
            $this->enqueue_page('portfolio');
            return;
        }

        // PORTFÓLIO — single (case study)
        if (is_singular('portfolio')) {
            $this->enqueue_page('portfolio', 'portfolio-single');
            return;
        }

        // SERVIÇOS — archive (lista de serviços)
        if (is_post_type_archive('servico')) {
            $this->enqueue_page('servicos');
            return;
        }

        // SERVIÇO — single (página do serviço)
        if (is_singular('servico')) {
            $this->enqueue_page('servicos', 'servico-single');
            return;
        }

        // SOBRE — página estática
        if (is_page('sobre') || is_page('about')) {
            $this->enqueue_page('sobre');
            return;
        }

        // CONTATO — página estática
        if (is_page('contato') || is_page('contact')) {
            $this->enqueue_page('contato');
            return;
        }
    }

    /**
     * Remove scripts e estilos que o WordPress adiciona
     * automaticamente mas que este tema não utiliza.
     */
    public function dequeue_unwanted(): void
    {

        // jQuery — não usamos no frontend deste tema
        // Obs: continua disponível no wp-admin
        wp_deregister_script('jquery');
        wp_deregister_script('jquery-core');
        wp_deregister_script('jquery-migrate');

        // CSS do editor Gutenberg — não usamos blocos no frontend
        wp_dequeue_style('wp-block-library');
        wp_dequeue_style('wp-block-library-theme');
        wp_dequeue_style('global-styles');
    }

    /**
     * Adiciona preconnect para Google Fonts no início do <head>.
     * Isso avisa o browser para abrir a conexão com o servidor
     * de fontes antes mesmo de encontrar o link da fonte —
     * reduz latência no carregamento das fontes.
     */
    public function preconnect_fonts(): void
    {
        echo '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
        echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
        echo '<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;700;800&family=JetBrains+Mono:wght@400;500&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;1,9..40,300&display=swap" rel="stylesheet">' . "\n";
    }

    /**
     * Helper privado: enfileira CSS e JS de uma página específica.
     *
     * @param string      $css_handle  Handle e nome do arquivo CSS (sem extensão)
     * @param string|null $js_handle   Handle e nome do arquivo JS (sem extensão)
     *                                 Se null, usa o mesmo nome do CSS
     */
    private function enqueue_page(string $css_handle, ?string $js_handle = null): void
    {

        $js_handle = $js_handle ?? $css_handle;

        // CSS da página — só enfileira se o arquivo existir
        $css_path = PMPORTFOLIO_DIR . "/assets/css/{$css_handle}.css";
        if (file_exists($css_path)) {
            wp_enqueue_style(
                "pm-{$css_handle}",
                PMPORTFOLIO_URI . "/assets/css/{$css_handle}.css",
                ['pm-global'],
                PMPORTFOLIO_VERSION
            );
        }

        // JS da página — só enfileira se o arquivo existir
        $js_path = PMPORTFOLIO_DIR . "/assets/js/{$js_handle}.js";
        if (file_exists($js_path)) {
            wp_enqueue_script(
                "pm-{$js_handle}",
                PMPORTFOLIO_URI . "/assets/js/{$js_handle}.js",
                ['pm-global'],
                PMPORTFOLIO_VERSION,
                true
            );
        }
    }
}
