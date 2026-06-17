<?php

/**
 * PMPortfolio — Nav Walker
 *
 * Walker customizado para gerar markup Bootstrap 5
 * compatível com o wp_nav_menu() do WordPress.
 *
 * Gera:
 *   <li class="nav-item">
 *     <a class="nav-link active" href="...">link</a>
 *   </li>
 *
 * @package PMPortfolio\Core
 */

namespace PMPortfolio\Core;

defined('ABSPATH') || exit;

class Nav_Walker extends \Walker_Nav_Menu
{

    /**
     * Abre o elemento <li>.
     */
    public function start_el(&$output, $data_object, $depth = 0, $args = null, $current_object_id = 0)
    {

        $item = $data_object;

        // Classes do item
        $classes   = empty($item->classes) ? [] : (array) $item->classes;
        $classes[] = 'nav-item';

        // Verifica se é o item atual
        $is_current = in_array('current-menu-item', $classes, true)
            || in_array('current-menu-ancestor', $classes, true);

        $class_str = implode(' ', array_filter(array_unique($classes)));

        $output .= '<li class="' . esc_attr($class_str) . '">';

        // Classes do link
        $link_classes   = ['nav-link'];
        $link_classes[] = $is_current ? 'active' : '';
        $link_class_str = implode(' ', array_filter($link_classes));

        // Atributos de acessibilidade
        $aria_current = $is_current ? ' aria-current="page"' : '';

        // URL e título
        $url   = empty($item->url) ? '#' : $item->url;
        $title = apply_filters('the_title', $item->title, $item->ID);

        $output .= '<a class="' . esc_attr($link_class_str) . '" href="' . esc_url($url) . '"' . $aria_current . '>';
        $output .= esc_html($title);
        $output .= '</a>';
    }

    /**
     * Fecha o elemento <li>.
     */
    public function end_el(&$output, $data_object, $depth = 0, $args = null)
    {
        $output .= '</li>';
    }

    /**
     * Abre o submenu <ul> — não usamos submenus neste tema.
     */
    public function start_lvl(&$output, $depth = 0, $args = null) {}

    /**
     * Fecha o submenu <ul>.
     */
    public function end_lvl(&$output, $depth = 0, $args = null) {}
}
