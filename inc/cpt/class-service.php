<?php

/**
 * @package PMPortfolio\CPT
 */

namespace PMPortfolio\CPT;

defined('ABSPATH') || exit;

class Service
{

    const POST_TYPE = 'servico';

    public function register(): void
    {
        $this->register_post_type();
        $this->register_taxonomies();
    }

    private function register_post_type(): void
    {

        $labels = [
            'name'               => __('Serviços',              'pmportfolio'),
            'singular_name'      => __('Serviço',               'pmportfolio'),
            'add_new'            => __('Novo Serviço',          'pmportfolio'),
            'add_new_item'       => __('Adicionar Serviço',     'pmportfolio'),
            'edit_item'          => __('Editar Serviço',        'pmportfolio'),
            'new_item'           => __('Novo Serviço',          'pmportfolio'),
            'view_item'          => __('Ver Serviço',           'pmportfolio'),
            'search_items'       => __('Buscar Serviços',       'pmportfolio'),
            'not_found'          => __('Nenhum serviço encontrado.', 'pmportfolio'),
            'not_found_in_trash' => __('Nenhum serviço na lixeira.', 'pmportfolio'),
            'menu_name'          => __('Serviços',              'pmportfolio'),
        ];

        $args = [
            'labels'          => $labels,
            'public'          => true,
            'show_in_rest'    => true,
            'has_archive'     => 'servicos',
            'rewrite'         => [
                'slug'       => 'servicos',
                'with_front' => false,
            ],
            'supports'        => [
                'title',
                'editor',
                'thumbnail',
                'excerpt',
                'custom-fields',
            ],
            'menu_icon'       => 'dashicons-hammer',
            'menu_position'   => 6,
            'capability_type' => 'post',
        ];

        register_post_type(self::POST_TYPE, $args);
    }

    private function register_taxonomies(): void
    {

        register_taxonomy(
            'servico_categoria',
            self::POST_TYPE,
            [
                'labels'            => [
                    'name'          => __('Categorias',        'pmportfolio'),
                    'singular_name' => __('Categoria',         'pmportfolio'),
                    'add_new_item'  => __('Nova Categoria',    'pmportfolio'),
                    'edit_item'     => __('Editar Categoria',  'pmportfolio'),
                    'search_items'  => __('Buscar Categorias', 'pmportfolio'),
                ],
                'hierarchical'      => true,
                'show_in_rest'      => true,
                'show_admin_column' => true,
                'rewrite'           => ['slug' => 'servicos/categoria'],
            ]
        );
    }
}
