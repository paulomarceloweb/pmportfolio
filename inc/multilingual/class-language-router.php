<?php

/**
 * PMPortfolio — Language Router
 *
 * Detecta URLs /en/ e configura o WordPress para
 * servir o conteúdo no idioma correto.
 *
 * @package PMPortfolio\Multilingual
 */

namespace PMPortfolio\Multilingual;

defined('ABSPATH') || exit;

class Language_Router
{

    public function register(): void
    {
        add_action('init',                 [$this, 'add_rewrite_rules']);
        add_filter('request',              [$this, 'filter_request']);
        add_action('wp',                   [$this, 'set_language_from_url']);
        add_filter('document_title_parts', [$this, 'maybe_translate_title']);
        add_filter('redirect_canonical',   [$this, 'prevent_en_redirect'], 10, 2);
        add_filter('query_vars',           [$this, 'register_query_vars']);
    }

    /**
     * Registra query vars customizadas.
     */
    public function register_query_vars(array $vars): array
    {
        $vars[] = 'pm_lang';
        $vars[] = 'portfolio';
        $vars[] = 'servico';
        return $vars;
    }

    /**
     * Impede o WordPress de redirecionar URLs /en/*.
     */
    public function prevent_en_redirect(string $redirect_url, string $requested_url): string|false
    {
        $path     = parse_url($requested_url, PHP_URL_PATH) ?? '';
        $home     = parse_url(home_url('/'), PHP_URL_PATH) ?? '/';
        $relative = '/' . ltrim(str_replace(rtrim($home, '/'), '', $path), '/');

        if (str_starts_with($relative, '/en')) {
            return false;
        }

        return $redirect_url;
    }

    /**
     * Adiciona regras de rewrite para URLs /en/*.
     */
    public function add_rewrite_rules(): void
    {

        // HOME /en/
        add_rewrite_rule(
            '^en/?$',
            'index.php?pm_lang=en&page_id=' . get_option('page_on_front'),
            'top'
        );

        // BLOG /en/blog/
        add_rewrite_rule(
            '^en/blog/?$',
            'index.php?pm_lang=en&page_id=' . get_option('page_for_posts'),
            'top'
        );

        // PORTFOLIO ARCHIVE /en/portfolio/
        add_rewrite_rule(
            '^en/portfolio/?$',
            'index.php?pm_lang=en&post_type=portfolio',
            'top'
        );

        // PORTFOLIO SINGLE /en/portfolio/slug/
        add_rewrite_rule(
            '^en/portfolio/([^/]+)/?$',
            'index.php?pm_lang=en&portfolio=$matches[1]&post_type=portfolio',
            'top'
        );

        // SERVIÇOS ARCHIVE /en/servicos/
        add_rewrite_rule(
            '^en/servicos/?$',
            'index.php?pm_lang=en&post_type=servico',
            'top'
        );

        // SERVIÇO SINGLE /en/servicos/slug/
        add_rewrite_rule(
            '^en/servicos/([^/]+)/?$',
            'index.php?pm_lang=en&servico=$matches[1]&post_type=servico',
            'top'
        );

        // POST SINGLE /en/slug/
        add_rewrite_rule(
            '^en/([^/]+)/?$',
            'index.php?pm_lang=en&name=$matches[1]',
            'top'
        );

        // SOBRE /en/sobre/
        add_rewrite_rule(
            '^en/sobre/?$',
            'index.php?pm_lang=en&pagename=sobre',
            'top'
        );

        // CONTATO /en/contato/
        add_rewrite_rule(
            '^en/contato/?$',
            'index.php?pm_lang=en&pagename=contato',
            'top'
        );

        // Query var
        add_rewrite_tag('%pm_lang%', '([a-z]{2})');
    }

    /**
     * Detecta idioma a partir da URL.
     */
    public function set_language_from_url(): void
    {
        $lang = get_query_var('pm_lang', '');
        if ($lang === 'en') {
            Language_Manager::set('en');
        } else {
            Language_Manager::get();
        }
    }

    /**
     * Filtra a query para resolver CPTs pelo post_name.
     */
    public function filter_request(array $query_vars): array
    {

        if (! isset($query_vars['pm_lang']) || $query_vars['pm_lang'] !== 'en') {
            return $query_vars;
        }

        Language_Manager::set('en');

        // Portfolio single
        if (isset($query_vars['portfolio'])) {
            $query_vars['name']      = $query_vars['portfolio'];
            $query_vars['post_type'] = 'portfolio';
            unset($query_vars['portfolio']);
            return $query_vars;
        }

        // Servico single
        if (isset($query_vars['servico'])) {
            $query_vars['name']      = $query_vars['servico'];
            $query_vars['post_type'] = 'servico';
            unset($query_vars['servico']);
            return $query_vars;
        }

        // Se veio como name, verifica se é página estática
        if (isset($query_vars['name']) && ! isset($query_vars['post_type'])) {
            $slug = $query_vars['name'];
            $page = get_page_by_path($slug);
            if ($page) {
                // É uma página estática — usa pagename
                $query_vars['pagename'] = $slug;
                unset($query_vars['name']);
            }
            // Se não é página, mantém como name (post do blog)
        }

        return $query_vars;
    }

    /**
     * Traduz o título quando no modo inglês.
     */
    public function maybe_translate_title(array $title): array
    {

        if (! Language_Manager::is('en')) {
            return $title;
        }

        if (is_singular()) {
            $title_en = get_post_meta(get_the_ID(), '_seo_title_en', true);
            if ($title_en) {
                $title['title'] = $title_en;
            }
        }

        return $title;
    }
}
