<?php
/**
 * PMPortfolio — Schema JSON-LD
 *
 * Gera dados estruturados Schema.org no formato JSON-LD.
 * Permite que o Google exiba rich results nos resultados de busca.
 *
 * @graph gerado por página:
 *
 *   Todas as páginas:
 *     WebSite     → nome, URL, SearchAction
 *     Person      → Paulo Marcelo, jobTitle, sameAs (redes sociais)
 *     BreadcrumbList → trilha de navegação
 *
 *   Página de serviço:
 *     + Service   → nome, descrição, preço
 *
 *   Post do blog:
 *     + Article   → autor, data, imagem
 *
 *   Portfólio (case study):
 *     + CreativeWork → nome, descrição, cliente
 *
 * Por que JSON-LD em vez de microdata?
 * Google recomenda JSON-LD. É mais fácil de manter porque
 * fica separado do HTML — não mistura dados com markup.
 *
 * @package PMPortfolio\SEO
 */

namespace PMPortfolio\SEO;

use PMPortfolio\Admin\Settings_API;

defined( 'ABSPATH' ) || exit;

class Schema {

	/**
	 * @param array $context Contexto SEO calculado pelo SEO_Manager.
	 */
	public function __construct( private array $context ) {}

	/**
	 * Renderiza o bloco JSON-LD no <head>.
	 */
	public function render(): void {

		$graph = [];

		// Sempre presente em todas as páginas
		$graph[] = $this->build_website();
		$graph[] = $this->build_person();

		// BreadcrumbList — em todas exceto home
		$breadcrumb = $this->build_breadcrumb();
		if ( $breadcrumb ) {
			$graph[] = $breadcrumb;
		}

		// Schema específico por tipo de página
		$type = $this->context['type'] ?? '';
		$post = $this->context['post'] ?? null;

		if ( $type === 'single' && $post ) {
			$post_type = $this->context['post_type'] ?? '';

			if ( $post_type === 'servico' ) {
				$specific = $this->build_service( $post );
			} elseif ( $post_type === 'portfolio' ) {
				$specific = $this->build_creative_work( $post );
			} else {
				$specific = $this->build_article( $post );
			}

			if ( $specific ) {
				$graph[] = $specific;
			}
		}

		// Remove nulls do array
		$graph = array_filter( $graph );

		if ( empty( $graph ) ) {
			return;
		}

		$schema = [
			'@context' => 'https://schema.org',
			'@graph'   => array_values( $graph ),
		];

		echo '<script type="application/ld+json">' . "\n";
		echo wp_json_encode( $schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT );
		echo "\n" . '</script>' . "\n";
	}

	/**
	 * Schema WebSite — presente em todas as páginas.
	 * Habilita o SearchAction para Google Search Console.
	 */
	private function build_website(): array {
		return [
			'@type'           => 'WebSite',
			'@id'             => home_url( '/#website' ),
			'url'             => home_url( '/' ),
			'name'            => get_bloginfo( 'name' ),
			'description'     => get_bloginfo( 'description' ),
			'inLanguage'      => [ 'pt-BR', 'en-US' ],
			'potentialAction' => [
				'@type'       => 'SearchAction',
				'target'      => [
					'@type'       => 'EntryPoint',
					'urlTemplate' => home_url( '/?s={search_term_string}' ),
				],
				'query-input' => 'required name=search_term_string',
			],
		];
	}

	/**
	 * Schema Person — Paulo Marcelo.
	 * Vincula o site à pessoa com sameAs para redes sociais.
	 */
	private function build_person(): array {

		$same_as = array_filter( [
			Settings_API::get( 'social_linkedin' ),
			Settings_API::get( 'social_github' ),
			Settings_API::get( 'social_twitter' ),
			Settings_API::get( 'social_instagram' ),
			Settings_API::get( 'social_youtube' ),
		] );

		$schema = [
			'@type'       => 'Person',
			'@id'         => home_url( '/#person' ),
			'name'        => get_bloginfo( 'name' ),
			'url'         => home_url( '/' ),
			'jobTitle'    => 'Software Engineer',
			'description' => get_bloginfo( 'description' ),
		];

		$avatar = Settings_API::get( 'avatar' );
		if ( $avatar ) {
			$schema['image'] = [
				'@type' => 'ImageObject',
				'url'   => $avatar,
			];
		}

		if ( ! empty( $same_as ) ) {
			$schema['sameAs'] = array_values( $same_as );
		}

		return $schema;
	}

	/**
	 * Schema BreadcrumbList — trilha de navegação.
	 * Exibida nos resultados de busca abaixo do título.
	 */
	private function build_breadcrumb(): ?array {

		$type = $this->context['type'] ?? '';

		// Home não tem breadcrumb
		if ( $type === 'home' ) {
			return null;
		}

		$items   = [];
		$post    = $this->context['post'] ?? null;

		// Primeiro item: sempre a home
		$items[] = [
			'@type'    => 'ListItem',
			'position' => 1,
			'name'     => __( 'Início', 'pmportfolio' ),
			'item'     => home_url( '/' ),
		];

		// Segundo item: archive ou página pai
		if ( $post && $post->post_type !== 'post' ) {
			$archive_link = get_post_type_archive_link( $post->post_type );
			$post_type_obj = get_post_type_object( $post->post_type );
			if ( $archive_link && $post_type_obj ) {
				$items[] = [
					'@type'    => 'ListItem',
					'position' => 2,
					'name'     => $post_type_obj->labels->name,
					'item'     => $archive_link,
				];
			}
		}

		// Último item: página atual (sem URL — é a página atual)
		$items[] = [
			'@type'    => 'ListItem',
			'position' => count( $items ) + 1,
			'name'     => $this->context['title'] ?? '',
		];

		return [
			'@type'           => 'BreadcrumbList',
			'itemListElement' => $items,
		];
	}

	/**
	 * Schema Article — para posts do blog.
	 */
	private function build_article( \WP_Post $post ): ?array {

		return [
			'@type'            => 'Article',
			'@id'              => get_permalink( $post ) . '#article',
			'headline'         => get_the_title( $post ),
			'description'      => $this->context['description'] ?? '',
			'url'              => get_permalink( $post ),
			'datePublished'    => get_the_date( 'c', $post ),
			'dateModified'     => get_the_modified_date( 'c', $post ),
			'author'           => [ '@id' => home_url( '/#person' ) ],
			'publisher'        => [ '@id' => home_url( '/#person' ) ],
			'isPartOf'         => [ '@id' => home_url( '/#website' ) ],
			'image'            => $this->context['og_image']
				? [ '@type' => 'ImageObject', 'url' => $this->context['og_image'] ]
				: null,
			'inLanguage'       => 'pt-BR',
		];
	}

	/**
	 * Schema Service — para CPT serviço.
	 */
	private function build_service( \WP_Post $post ): ?array {

		$price = get_post_meta( $post->ID, '_servico_preco', true );

		$schema = [
			'@type'       => 'Service',
			'@id'         => get_permalink( $post ) . '#service',
			'name'        => get_the_title( $post ),
			'description' => $this->context['description'] ?? '',
			'url'         => get_permalink( $post ),
			'provider'    => [ '@id' => home_url( '/#person' ) ],
		];

		if ( $price ) {
			$schema['offers'] = [
				'@type'         => 'Offer',
				'description'   => $price,
				'priceCurrency' => 'BRL',
			];
		}

		return $schema;
	}

	/**
	 * Schema CreativeWork — para CPT portfólio.
	 */
	private function build_creative_work( \WP_Post $post ): ?array {

		$cliente = get_post_meta( $post->ID, '_portfolio_cliente', true );
		$url     = get_post_meta( $post->ID, '_portfolio_url', true );

		$schema = [
			'@type'       => 'CreativeWork',
			'@id'         => get_permalink( $post ) . '#project',
			'name'        => get_the_title( $post ),
			'description' => $this->context['description'] ?? '',
			'url'         => get_permalink( $post ),
			'creator'     => [ '@id' => home_url( '/#person' ) ],
			'dateCreated' => get_the_date( 'c', $post ),
		];

		if ( $cliente ) {
			$schema['client'] = $cliente;
		}

		if ( $url ) {
			$schema['sameAs'] = $url;
		}

		return $schema;
	}
}