<?php

/**
 * PMPortfolio — Asset Manager
 *
 * Gerencia o enfileiramento de CSS e JS.
 * Princípio central: cada página carrega APENAS o que precisa.
 *
 * Com Vite:
 *   - Em produção: lê o manifest.json e usa arquivos com hash
 *   - Em desenvolvimento: fallback para arquivos diretos sem hash
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
     * Manifest do Vite — carregado uma vez e cacheado.
     * @var array|null
     */
    private static ?array $manifest = null;

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
        wp_enqueue_style(
            'bootstrap',
            'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css',
            [],
            null
        );

        // Design System — CSS Variables dark/light
        wp_enqueue_style(
            'pm-design-system',
            $this->vite_url('assets/css/design-system.css'),
            ['bootstrap'],
            null
        );

        // Global CSS
        wp_enqueue_style(
            'pm-global',
            $this->vite_url('assets/css/global.css'),
            ['pm-design-system'],
            null
        );

        // Bootstrap JS via CDN
        wp_enqueue_script(
            'bootstrap',
            'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js',
            [],
            null,
            true
        );

        // Global JS — no <head>, sem dependências
        wp_enqueue_script(
            'pm-global',
            PMPORTFOLIO_URI . '/assets/js/global.js',
            [],
            PMPORTFOLIO_VERSION,
            false
        );
    }

    /**
     * Assets por página — cada template carrega apenas o seu.
     */
    public function enqueue_per_page(): void
    {

        if (is_front_page()) {
            $this->enqueue_page('home');
            return;
        }

        if (is_home() || is_category() || is_tag()) {
            $this->enqueue_page('blog');
            return;
        }

        if (is_singular('post')) {
            $this->enqueue_page('blog', 'blog-single');
            return;
        }

        if (is_post_type_archive('portfolio')) {
            $this->enqueue_page('portfolio');
            return;
        }

        if (is_singular('portfolio')) {
            $this->enqueue_page('portfolio', 'portfolio-single');
            return;
        }

        if (is_post_type_archive('servico')) {
            $this->enqueue_page('servicos');
            return;
        }

        if (is_singular('servico')) {
            $this->enqueue_page('servicos', 'servico-single');
            return;
        }

        if (is_page('sobre') || is_page('about')) {
            $this->enqueue_page('sobre');
            return;
        }

        if (is_page('contato') || is_page('contact')) {
            $this->enqueue_page('contato');
            return;
        }
    }

    /**
     * Remove scripts e estilos desnecessários.
     */
    public function dequeue_unwanted(): void
    {

        // Remove jQuery apenas para visitantes não logados
        if (! is_user_logged_in()) {
            wp_deregister_script('jquery');
            wp_deregister_script('jquery-core');
            wp_deregister_script('jquery-migrate');
        }

        wp_dequeue_style('wp-block-library');
        wp_dequeue_style('wp-block-library-theme');
        wp_dequeue_style('global-styles');
    }

    /**
     * Preconnect para Google Fonts.
     */
    public function preconnect_fonts(): void
    {
        echo '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
        echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
        echo '<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;700;800&family=JetBrains+Mono:wght@400;500&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;1,9..40,300&display=swap" rel="stylesheet">' . "\n";
    }

    /**
     * Helper: enfileira CSS e JS de uma página específica.
     * Usa o manifest do Vite quando disponível.
     *
     * @param string      $css_handle  Nome do arquivo CSS (sem extensão)
     * @param string|null $js_handle   Nome do arquivo JS (sem extensão)
     */
    private function enqueue_page(string $css_handle, ?string $js_handle = null): void
    {

        $js_handle = $js_handle ?? $css_handle;

        // CSS
        $css_src_key = "assets/css/{$css_handle}.css";
        $css_path    = PMPORTFOLIO_DIR . '/' . $css_src_key;

        if (file_exists($css_path)) {
            wp_enqueue_style(
                "pm-{$css_handle}",
                $this->vite_url($css_src_key),
                ['pm-global'],
                null
            );
        }

        // JS
        $js_src_key = "assets/js/{$js_handle}.js";
        $js_path    = PMPORTFOLIO_DIR . '/' . $js_src_key;

        if (file_exists($js_path)) {
            wp_enqueue_script(
                "pm-{$js_handle}",
                PMPORTFOLIO_URI . "/assets/js/{$js_handle}.js",
                [],
                PMPORTFOLIO_VERSION,
                true
            );
        }
    }

    /**
     * Lê o manifest.json gerado pelo Vite e retorna a URL
     * do arquivo com hash.
     *
     * Chaves no manifest: 'assets/css/global.css', 'assets/js/home.js'
     * Arquivo gerado:     'css/global.HASH.css', 'js/home.HASH.js'
     *
     * @param  string $src_key  Path relativo do asset (ex: 'assets/css/global.css')
     * @return string            URL com hash (produção) ou URL direta (desenvolvimento)
     */
    private function vite_url(string $src_key): string
    {

        // Carrega o manifest uma vez e cacheia na propriedade estática
        if (self::$manifest === null) {
            $manifest_path = PMPORTFOLIO_DIR . '/assets/dist/.vite/manifest.json';

            if (file_exists($manifest_path)) {
                self::$manifest = json_decode(
                    file_get_contents($manifest_path),
                    true
                ) ?? [];
            } else {
                self::$manifest = [];
            }
        }

        // Busca o arquivo no manifest pelo path original como chave
        if (isset(self::$manifest[$src_key]['file'])) {
            return PMPORTFOLIO_URI . '/assets/dist/' . self::$manifest[$src_key]['file'];
        }

        // Fallback — manifest não existe ou chave não encontrada
        // Usa o arquivo direto sem hash (modo desenvolvimento sem build)
        return PMPORTFOLIO_URI . '/' . $src_key;
    }


    /**
     * Adiciona type="module" nos scripts do Vite.
     * Necessário para ES modules gerados pelo Vite.
     */
    public function add_module_type(string $tag, string $handle): string
    {
        $vite_handles = [
            'pm-global',
            'pm-home',
            'pm-blog',
            'pm-blog-single',
            'pm-portfolio',
            'pm-portfolio-single',
            'pm-servicos',
            'pm-servico-single',
            'pm-sobre',
            'pm-contato',
        ];

        if (in_array($handle, $vite_handles, true) && self::$manifest !== null && ! empty(self::$manifest)) {
            return str_replace('<script ', '<script type="module" ', $tag);
        }

        return $tag;
    }
}
