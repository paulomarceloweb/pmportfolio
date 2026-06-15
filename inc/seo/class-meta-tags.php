<?php
/**
 * PMPortfolio — Meta Tags
 *
 * Gera as meta tags essenciais no <head>:
 *   <title>
 *   <meta name="description">
 *   <meta name="robots">
 *   <link rel="canonical">
 *
 * @package PMPortfolio\SEO
 */

namespace PMPortfolio\SEO;

defined( 'ABSPATH' ) || exit;

class Meta_Tags {

	/**
	 * @param array $context Contexto SEO calculado pelo SEO_Manager.
	 */
	public function __construct( private array $context ) {}

	/**
	 * Renderiza as meta tags no <head>.
	 */
	public function render(): void {
		$this->render_title();
		$this->render_description();
		$this->render_robots();
		$this->render_canonical();
	}

	/**
	 * <title> — o mais importante para SEO.
	 * Formato: "Título da Página — Nome do Site"
	 */
	private function render_title(): void {
		echo '<title>' . esc_html( $this->context['title'] ) . '</title>' . "\n";
	}

	/**
	 * <meta name="description">
	 * Máximo 160 caracteres para não ser cortado nos resultados.
	 */
	private function render_description(): void {
		if ( empty( $this->context['description'] ) ) {
			return;
		}

		$desc = wp_trim_words( $this->context['description'], 30, '...' );

		echo '<meta name="description" content="' . esc_attr( $desc ) . '">' . "\n";
	}

	/**
	 * <meta name="robots">
	 * Controla indexação por mecanismos de busca.
	 * 404 e busca sempre recebem noindex automaticamente.
	 */
	private function render_robots(): void {
		if ( empty( $this->context['robots'] ) ) {
			return;
		}

		echo '<meta name="robots" content="' . esc_attr( $this->context['robots'] ) . '">' . "\n";
	}

	/**
	 * <link rel="canonical">
	 * Evita duplicate content em paginação e parâmetros de URL.
	 * Não renderiza em 404 e busca — não há URL canônica nesses casos.
	 */
	private function render_canonical(): void {
		if ( empty( $this->context['canonical'] ) ) {
			return;
		}

		echo '<link rel="canonical" href="' . esc_url( $this->context['canonical'] ) . '">' . "\n";
	}
}