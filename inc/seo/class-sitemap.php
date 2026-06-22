<?php

/**
 * PMPortfolio — Sitemap XML
 *
 * Gera sitemap XML dinâmico sem plugin.
 * Acessível em: /sitemap.xml
 *
 * Inclui:
 *   - Páginas estáticas
 *   - Posts do blog
 *   - CPT Portfolio
 *   - CPT Serviço
 *   - URLs /en/ equivalentes
 *
 * @package PMPortfolio\SEO
 */

namespace PMPortfolio\SEO;

defined('ABSPATH') || exit;

class Sitemap
{

    /**
     * Registra os hooks do sitemap.
     */
    public function register(): void
    {
        add_action('init',          [$this, 'add_rewrite_rule']);
        add_filter('query_vars',    [$this, 'add_query_var']);
        add_action('template_redirect', [$this, 'render']);
    }

    /**
     * Adiciona regra de rewrite para /sitemap.xml
     */
    public function add_rewrite_rule(): void
    {
        add_rewrite_rule('^sitemap\.xml$', 'index.php?pm_sitemap=1', 'top');
    }

    /**
     * Registra a query var.
     */
    public function add_query_var(array $vars): array
    {
        $vars[] = 'pm_sitemap';
        return $vars;
    }

    /**
     * Renderiza o sitemap XML.
     */
    public function render(): void
    {

        if (! get_query_var('pm_sitemap')) {
            return;
        }

        // Desativa qualquer output anterior
        if (ob_get_level()) {
            ob_end_clean();
        }

        header('Content-Type: application/xml; charset=UTF-8');
        header('X-Robots-Tag: noindex, follow');

        $urls = $this->collect_urls();

        echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"' . "\n";
        echo '        xmlns:xhtml="http://www.w3.org/1999/xhtml">' . "\n";

        foreach ($urls as $url) {
            echo "\t<url>\n";
            echo "\t\t<loc>" . esc_url($url['loc']) . "</loc>\n";

            if (! empty($url['lastmod'])) {
                echo "\t\t<lastmod>" . esc_html($url['lastmod']) . "</lastmod>\n";
            }

            if (! empty($url['changefreq'])) {
                echo "\t\t<changefreq>" . esc_html($url['changefreq']) . "</changefreq>\n";
            }

            if (! empty($url['priority'])) {
                echo "\t\t<priority>" . esc_html($url['priority']) . "</priority>\n";
            }

            // hreflang alternates
            if (! empty($url['alternates'])) {
                foreach ($url['alternates'] as $lang => $alt_url) {
                    echo "\t\t<xhtml:link rel=\"alternate\" hreflang=\"{$lang}\" href=\"" . esc_url($alt_url) . "\"/>\n";
                }
                // x-default aponta para PT
                echo "\t\t<xhtml:link rel=\"alternate\" hreflang=\"x-default\" href=\"" . esc_url($url['loc']) . "\"/>\n";
            }

            echo "\t</url>\n";
        }

        echo '</urlset>';
        exit;
    }

    /**
     * Coleta todas as URLs do site.
     *
     * @return array
     */
    private function collect_urls(): array
    {

        $urls = [];

        // ── HOME ──────────────────────────────────────────
        $urls[] = [
            'loc'        => home_url('/'),
            'changefreq' => 'weekly',
            'priority'   => '1.0',
            'alternates' => [
                'pt-BR' => home_url('/'),
                'en-US' => home_url('/en/'),
            ],
        ];

        // ── PÁGINAS ESTÁTICAS ─────────────────────────────
        $pages = get_pages(['post_status' => 'publish']);
        foreach ($pages as $page) {

            // Pula páginas de sistema
            if (in_array($page->ID, [
                get_option('page_on_front'),
                get_option('page_for_posts'),
            ], true)) {
                continue;
            }

            $url     = get_permalink($page);
            $slug    = $page->post_name;
            $en_url  = home_url('/en/' . $slug . '/');
            $lastmod = get_the_modified_date('c', $page);

            $urls[] = [
                'loc'        => $url,
                'lastmod'    => $lastmod,
                'changefreq' => 'monthly',
                'priority'   => '0.8',
                'alternates' => [
                    'pt-BR' => $url,
                    'en-US' => $en_url,
                ],
            ];
        }

        // ── BLOG ──────────────────────────────────────────
        $blog_url = get_permalink(get_option('page_for_posts'));
        if ($blog_url) {
            $urls[] = [
                'loc'        => $blog_url,
                'changefreq' => 'daily',
                'priority'   => '0.9',
                'alternates' => [
                    'pt-BR' => $blog_url,
                    'en-US' => home_url('/en/blog/'),
                ],
            ];
        }

        // ── POSTS DO BLOG ─────────────────────────────────
        $posts = get_posts([
            'post_type'      => 'post',
            'post_status'    => 'publish',
            'posts_per_page' => -1,
            'fields'         => 'ids',
        ]);

        foreach ($posts as $post_id) {
            $url     = get_permalink($post_id);
            $lastmod = get_the_modified_date('c', $post_id);
            $slug    = get_post_field('post_name', $post_id);

            $urls[] = [
                'loc'        => $url,
                'lastmod'    => $lastmod,
                'changefreq' => 'monthly',
                'priority'   => '0.7',
                'alternates' => [
                    'pt-BR' => $url,
                    'en-US' => home_url('/en/' . $slug . '/'),
                ],
            ];
        }

        // ── PORTFOLIO ─────────────────────────────────────
        $portfolio_archive = get_post_type_archive_link('portfolio');
        if ($portfolio_archive) {
            $urls[] = [
                'loc'        => $portfolio_archive,
                'changefreq' => 'weekly',
                'priority'   => '0.9',
                'alternates' => [
                    'pt-BR' => $portfolio_archive,
                    'en-US' => home_url('/en/portfolio/'),
                ],
            ];
        }

        $portfolios = get_posts([
            'post_type'      => 'portfolio',
            'post_status'    => 'publish',
            'posts_per_page' => -1,
            'fields'         => 'ids',
        ]);

        foreach ($portfolios as $post_id) {
            $url     = get_permalink($post_id);
            $lastmod = get_the_modified_date('c', $post_id);
            $slug    = get_post_field('post_name', $post_id);

            $urls[] = [
                'loc'        => $url,
                'lastmod'    => $lastmod,
                'changefreq' => 'monthly',
                'priority'   => '0.8',
                'alternates' => [
                    'pt-BR' => $url,
                    'en-US' => home_url('/en/portfolio/' . $slug . '/'),
                ],
            ];
        }

        // ── SERVIÇOS ──────────────────────────────────────
        $servico_archive = get_post_type_archive_link('servico');
        if ($servico_archive) {
            $urls[] = [
                'loc'        => $servico_archive,
                'changefreq' => 'weekly',
                'priority'   => '0.9',
                'alternates' => [
                    'pt-BR' => $servico_archive,
                    'en-US' => home_url('/en/servicos/'),
                ],
            ];
        }

        $servicos = get_posts([
            'post_type'      => 'servico',
            'post_status'    => 'publish',
            'posts_per_page' => -1,
            'fields'         => 'ids',
        ]);

        foreach ($servicos as $post_id) {
            $url     = get_permalink($post_id);
            $lastmod = get_the_modified_date('c', $post_id);
            $slug    = get_post_field('post_name', $post_id);

            $urls[] = [
                'loc'        => $url,
                'lastmod'    => $lastmod,
                'changefreq' => 'monthly',
                'priority'   => '0.8',
                'alternates' => [
                    'pt-BR' => $url,
                    'en-US' => home_url('/en/servicos/' . $slug . '/'),
                ],
            ];
        }

        return $urls;
    }
}
