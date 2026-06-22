<?php

/**
 * PMPortfolio — Robots.txt
 *
 * @package PMPortfolio\SEO
 */

namespace PMPortfolio\SEO;

defined('ABSPATH') || exit;

class Robots
{

    public function register(): void
    {
        // Hook nativo do WordPress para robots.txt
        add_action('do_robots', [$this, 'render_via_hook']);

        // Rewrite como fallback para subdiretório
        add_action('init',               [$this, 'add_rewrite_rule']);
        add_filter('query_vars',         [$this, 'add_query_var']);
        add_action('template_redirect',  [$this, 'maybe_render']);
    }

    public function add_rewrite_rule(): void
    {
        add_rewrite_rule('^robots\.txt$', 'index.php?pm_robots=1', 'top');
    }

    public function add_query_var(array $vars): array
    {
        $vars[] = 'pm_robots';
        return $vars;
    }

    /**
     * Renderiza via query var — funciona em subdiretório.
     */
    public function maybe_render(): void
    {
        if (! get_query_var('pm_robots')) {
            return;
        }
        header('Content-Type: text/plain; charset=UTF-8');
        echo $this->get_content();
        exit;
    }

    /**
     * Renderiza via hook do_robots — funciona na raiz.
     */
    public function render_via_hook(): void
    {
        echo $this->get_content();
    }

    /**
     * Filtro robots_txt — compatibilidade extra.
     */
    public function render(string $output, bool $public): string
    {
        return $this->get_content();
    }

    /**
     * Conteúdo do robots.txt.
     */
    private function get_content(): string
    {

        $public      = (bool) get_option('blog_public');
        $sitemap_url = home_url('/sitemap.xml');
        $home_path   = parse_url(home_url('/'), PHP_URL_PATH) ?? '/';

        if (! $public) {
            return "User-agent: *\nDisallow: /\n";
        }

        $r  = "User-agent: *\n";
        $r .= "Allow: /\n\n";
        $r .= "Disallow: {$home_path}wp-admin/\n";
        $r .= "Disallow: {$home_path}wp-includes/\n";
        $r .= "Disallow: {$home_path}wp-login.php\n";
        $r .= "Disallow: {$home_path}wp-register.php\n";
        $r .= "Disallow: {$home_path}wp-config.php\n";
        $r .= "Disallow: {$home_path}readme.html\n";
        $r .= "Disallow: {$home_path}license.txt\n\n";
        $r .= "Disallow: {$home_path}?s=\n";
        $r .= "Disallow: {$home_path}search/\n\n";
        $r .= "User-agent: GPTBot\n";
        $r .= "Disallow: /\n\n";
        $r .= "User-agent: ChatGPT-User\n";
        $r .= "Disallow: /\n\n";
        $r .= "User-agent: CCBot\n";
        $r .= "Disallow: /\n\n";
        $r .= "Sitemap: {$sitemap_url}\n";

        return $r;
    }
}
