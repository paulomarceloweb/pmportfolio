<?php

/**
 * PMPortfolio — Theme Support
 *
 * Registra os recursos nativos do WordPress
 * que este tema suporta e utiliza.
 *
 * @package PMPortfolio\Core
 */

namespace PMPortfolio\Core;

defined('ABSPATH') || exit;

class Theme_Support
{

    /**
     * Registra suportes via hook after_setup_theme.
     *
     * Por que after_setup_theme e não init?
     * Porque after_setup_theme roda antes do init e é
     * o momento correto para declarar capacidades do tema.
     */
    public function register(): void
    {
        add_action('after_setup_theme', [$this, 'add_supports']);
    }

    /**
     * Declara todos os suportes do tema.
     */
    public function add_supports(): void
    {

        /**
         * title-tag
         * Deixa o WordPress gerar a tag <title> automaticamente.
         * Sem isso, você teria que colocar <title> manualmente
         * no header.php — e perderia integração com plugins de SEO.
         */
        add_theme_support('title-tag');

        /**
         * post-thumbnails
         * Habilita o campo "Imagem Destacada" no editor de posts.
         * Sem isso, a caixa simplesmente não aparece.
         */
        add_theme_support('post-thumbnails');

        /**
         * html5
         * Faz o WordPress gerar HTML5 semântico nos seus
         * elementos automáticos (busca, comentários, galerias).
         */
        add_theme_support('html5', [
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'style',
            'script',
        ]);

        /**
         * custom-logo
         * Habilita o campo de logo no Customizer.
         */
        add_theme_support('custom-logo', [
            'height'      => 60,
            'width'       => 200,
            'flex-height' => true,
            'flex-width'  => true,
        ]);

        /**
         * responsive-embeds
         * Torna vídeos incorporados (YouTube, Vimeo)
         * responsivos automaticamente.
         */
        add_theme_support('responsive-embeds');

        /**
         * Menus de navegação
         * Registra as posições de menu que aparecem em
         * Aparência → Menus no painel do WordPress.
         */
        register_nav_menus([
            'primary' => __('Menu Principal', 'pmportfolio'),
            'footer'  => __('Menu Rodapé',    'pmportfolio'),
        ]);

        /**
         * Tamanhos de imagem customizados
         * O WordPress vai gerar esses cortes automaticamente
         * quando uma imagem for enviada pela mídia.
         *
         * Parâmetros: nome, largura, altura, recortar(true/false)
         */
        add_image_size('pm-hero',      1920, 1080, true);
        add_image_size('pm-portfolio', 1200, 675,  true); // 16:9
        add_image_size('pm-blog',      800,  450,  true); // 16:9
        add_image_size('pm-thumb',     400,  300,  true); // 4:3
    }
}
