<?php

/**
 * PMPortfolio — Nav Walker
 *
 * Walker customizado para gerar markup Bootstrap 5
 * compatível com o wp_nav_menu() do WordPress.
 *
 * @package PMPortfolio\Core
 */

namespace PMPortfolio\Core;

defined('ABSPATH') || exit;

class Nav_Walker extends \Walker_Nav_Menu
{

    public function start_el(&$output, $data_object, $depth = 0, $args = null, $current_object_id = 0)
    {

        $item    = $data_object;
        $classes = empty($item->classes) ? [] : (array) $item->classes;
        $classes[] = 'nav-item';

        // ── DETECTA SE É O ITEM ATIVO ────────────────────────
        $is_current = in_array('current-menu-item',    $classes, true)
            || in_array('current-menu-ancestor', $classes, true);

        // Fallback para URLs /en/ — o WordPress não detecta automaticamente
        if (! $is_current && ! empty($item->url)) {
            $request_uri = $_SERVER['REQUEST_URI'] ?? '/';
            $home_path   = rtrim(parse_url(home_url('/'), PHP_URL_PATH) ?? '/', '/');
            $relative    = '/' . ltrim(substr($request_uri, strlen($home_path)), '/');
            $relative    = strtok($relative, '?');

            // Remove /en/ para comparar com URL do menu
            $relative_clean = preg_replace('#^/en/#', '/', $relative);
            if ($relative_clean === '/en') $relative_clean = '/';

            // Path do item sem domínio e sem /en/
            $item_path  = parse_url($item->url, PHP_URL_PATH) ?? '';
            $item_clean = '/' . ltrim(str_replace($home_path, '', $item_path), '/');
            $item_clean = rtrim($item_clean, '/') . '/';
            $item_clean = preg_replace('#^/en/#', '/', $item_clean);
            if ($item_clean === '//') $item_clean = '/';

            $relative_normalized = rtrim($relative_clean, '/') . '/';
            if ($relative_normalized === '//') $relative_normalized = '/';

            if ($relative_normalized === $item_clean) {
                $is_current = true;
            }
        }

        // ── URL DO ITEM ───────────────────────────────────────
        $url = empty($item->url) ? '#' : $item->url;

        // Se estamos em /en/, adiciona prefixo /en/ nos links do menu
        // Isso garante que ao navegar em /en/, os links permanecem em /en/
        $home_path_en = rtrim(parse_url(home_url('/'), PHP_URL_PATH) ?? '/', '/');
        $request_en   = strtok($_SERVER['REQUEST_URI'] ?? '/', '?');
        $relative_en  = '/' . ltrim(substr($request_en, strlen($home_path_en)), '/');

        if (preg_match('#^/en(\/|$)#', $relative_en) && $url !== '#') {
            $item_path = parse_url($url, PHP_URL_PATH) ?? '';
            $item_rel  = '/' . ltrim(str_replace($home_path_en, '', $item_path), '/');

            // Só adiciona /en/ se ainda não tiver
            if (! preg_match('#^/en(\/|$)#', $item_rel)) {
                $url = home_url('/en' . $item_rel);
            }
        }

        // ── GERA O HTML ───────────────────────────────────────
        $class_str      = implode(' ', array_filter(array_unique($classes)));
        $link_classes   = ['nav-link', $is_current ? 'active' : ''];
        $link_class_str = implode(' ', array_filter($link_classes));
        $aria_current   = $is_current ? ' aria-current="page"' : '';
        $title          = apply_filters('the_title', $item->title, $item->ID);

        $output .= '<li class="' . esc_attr($class_str) . '">';
        $output .= '<a class="' . esc_attr($link_class_str) . '" href="' . esc_url($url) . '"' . $aria_current . '>';
        $output .= esc_html($title);
        $output .= '</a>';
    }

    public function end_el(&$output, $data_object, $depth = 0, $args = null)
    {
        $output .= '</li>';
    }

    public function start_lvl(&$output, $depth = 0, $args = null) {}
    public function end_lvl(&$output, $depth = 0, $args = null) {}
}
