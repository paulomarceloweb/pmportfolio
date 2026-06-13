<?php

/**
 * @package PMPortfolio\CPT
 */

namespace PMPortfolio\CPT;

defined('ABSPATH') || exit;

class Portfolio
{


    const POST_TYPE = 'portfolio';

    /**
     * Registra o CPT e as taxonomias.
     */
    public function register(): void
    {
        $this->register_post_type();
        $this->register_taxonomies();
    }

    /**
     * Registra o Custom Post Type 'portfolio'.
     */
    private function register_post_type(): void
    {

        $labels = [
            'name'               => __('Portfólio',           'pmportfolio'),
            'singular_name'      => __('Projeto',             'pmportfolio'),
            'add_new'            => __('Novo Projeto',        'pmportfolio'),
            'add_new_item'       => __('Adicionar Projeto',   'pmportfolio'),
            'edit_item'          => __('Editar Projeto',      'pmportfolio'),
            'new_item'           => __('Novo Projeto',        'pmportfolio'),
            'view_item'          => __('Ver Projeto',         'pmportfolio'),
            'search_items'       => __('Buscar Projetos',     'pmportfolio'),
            'not_found'          => __('Nenhum projeto encontrado.', 'pmportfolio'),
            'not_found_in_trash' => __('Nenhum projeto na lixeira.', 'pmportfolio'),
            'menu_name'          => __('Portfólio',           'pmportfolio'),
        ];

        $args = [
            'labels'              => $labels,


            'public'              => true,

            'show_in_rest'        => true,

            'has_archive'         => 'portfolio',


            'rewrite'             => [
                'slug'       => 'portfolio',
                'with_front' => false,
            ],


            'supports'            => [
                'title',
                'editor',
                'thumbnail',
                'excerpt',
                'custom-fields',
            ],

            // Ícone do menu no painel — dashicons.wordpress.com
            'menu_icon'           => 'dashicons-portfolio',
            'menu_position'       => 5,

            // Capacidades baseadas nos posts comuns
            'capability_type'     => 'post',

            // Excluir da busca padrão do WordPress
            'exclude_from_search' => false,
        ];

        register_post_type(self::POST_TYPE, $args);
    }

    /**
     * Registra as taxonomias do portfólio.
     */
    private function register_taxonomies(): void
    {

        // CATEGORIA — hierárquica
        register_taxonomy(
            'portfolio_categoria',
            self::POST_TYPE,
            [
                'labels'            => [
                    'name'          => __('Categorias',          'pmportfolio'),
                    'singular_name' => __('Categoria',           'pmportfolio'),
                    'add_new_item'  => __('Nova Categoria',      'pmportfolio'),
                    'edit_item'     => __('Editar Categoria',    'pmportfolio'),
                    'search_items'  => __('Buscar Categorias',   'pmportfolio'),
                ],
                'hierarchical'      => true,  // como categorias
                'show_in_rest'      => true,  // habilita REST API
                'show_admin_column' => true,  // mostra coluna na lista do admin
                'rewrite'           => ['slug' => 'portfolio/categoria'],
            ]
        );

        // TECNOLOGIA — plana (flat)
        register_taxonomy(
            'portfolio_tecnologia',
            self::POST_TYPE,
            [
                'labels'            => [
                    'name'          => __('Tecnologias',         'pmportfolio'),
                    'singular_name' => __('Tecnologia',          'pmportfolio'),
                    'add_new_item'  => __('Nova Tecnologia',     'pmportfolio'),
                    'edit_item'     => __('Editar Tecnologia',   'pmportfolio'),
                    'search_items'  => __('Buscar Tecnologias',  'pmportfolio'),
                ],
                'hierarchical'      => false, // como tags
                'show_in_rest'      => true,
                'show_admin_column' => true,
                'rewrite'           => ['slug' => 'portfolio/tecnologia'],
            ]
        );
    }
}
