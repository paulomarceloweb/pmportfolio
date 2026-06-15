<?php
/**
 * PMPortfolio — Hreflang
 *
 * Gera as tags hreflang no <head>.
 * Informa ao Google que o site existe em PT-BR e EN-US.
 *
 * Tags geradas:
 *   <link rel="alternate" hreflang="pt-BR" href="...">
 *   <link rel="alternate" hreflang="en-US" href="...">
 *   <link rel="alternate" hreflang="x-default" href="...">
 *
 * Por que x-default?
 * Indica qual versão exibir para usuários de outros idiomas.
 * Usamos PT-BR como padrão (x-default).
 *
 * Como funciona a URL EN?
 * PT: https://site.com/sobre/
 * EN: https://site.com/en/about/
 *
 * No momento usamos uma convenção simples de prefixo /en/.
 * Quando o módulo multilíngue for construído, usaremos
 * os meta fields _translation_post_id para URLs exatas.
 *
 * @package PMPortfolio\SEO
 */

namespace PMPortfolio\SEO;

defined( 'ABSPATH' ) || exit;

class Hreflang {

	/**
	 * @param array $context Contexto SEO calculado pelo SEO_Manager.
	 */
	public function __construct( private array $context ) {}

	/**
	 * Renderiza as tags hreflang.
	 * Não renderiza em 404, busca ou quando não há canonical.
	 */
	public function render(): void {

		$canonical = $this->context['canonical'] ?? '';
		$type      = $this->context['type']      ?? '';

		// Não faz sentido em páginas sem URL canônica
		if ( empty( $canonical ) || in_array( $type, [ '404', 'search' ], true ) ) {
			return;
		}

		$url_pt = $canonical;
		$url_en = $this->build_en_url( $canonical );

		echo '<link rel="alternate" hreflang="pt-BR" href="' . esc_url( $url_pt ) . '">' . "\n";
		echo '<link rel="alternate" hreflang="en-US" href="' . esc_url( $url_en ) . '">' . "\n";
		echo '<link rel="alternate" hreflang="x-default" href="' . esc_url( $url_pt ) . '">' . "\n";
	}

	/**
	 * Constrói a URL equivalente em inglês.
	 *
	 * Lógica simples por enquanto:
	 * https://site.com/sobre/ → https://site.com/en/sobre/
	 *
	 * Quando o módulo multilíngue estiver pronto,
	 * usaremos _translation_post_id para a URL real.
	 *
	 * @param  string $pt_url URL em PT-BR.
	 * @return string         URL equivalente em EN.
	 */
	private function build_en_url( string $pt_url ): string {
		$home = home_url( '/' );

		// Remove o home_url do início para pegar só o path
		$path = str_replace( $home, '', $pt_url );

		// Adiciona /en/ no início
		return $home . 'en/' . $path;
	}
}