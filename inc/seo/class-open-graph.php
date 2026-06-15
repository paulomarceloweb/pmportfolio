<?php
/**
 * PMPortfolio — Open Graph
 *
 * Gera as meta tags Open Graph no <head>.
 * Usadas por LinkedIn, Facebook e WhatsApp ao compartilhar URLs.
 *
 * Tags geradas:
 *   og:title, og:description, og:type, og:url,
 *   og:image, og:image:width, og:image:height,
 *   og:locale, og:locale:alternate, og:site_name
 *
 * @package PMPortfolio\SEO
 */

namespace PMPortfolio\SEO;

defined( 'ABSPATH' ) || exit;

class Open_Graph {

	/**
	 * @param array $context Contexto SEO calculado pelo SEO_Manager.
	 */
	public function __construct( private array $context ) {}

	/**
	 * Renderiza as meta tags Open Graph.
	 */
	public function render(): void {

		$title       = $this->context['title']       ?? '';
		$description = $this->context['description'] ?? '';
		$type        = $this->context['og_type']     ?? 'website';
		$canonical   = $this->context['canonical']   ?? '';
		$image       = $this->context['og_image']    ?? '';

		if ( empty( $title ) ) {
			return;
		}

		echo '<meta property="og:title" content="'       . esc_attr( $title ) . '">' . "\n";
		echo '<meta property="og:type" content="'        . esc_attr( $type ) . '">' . "\n";
		echo '<meta property="og:site_name" content="'   . esc_attr( get_bloginfo( 'name' ) ) . '">' . "\n";
		echo '<meta property="og:locale" content="pt_BR">' . "\n";
		echo '<meta property="og:locale:alternate" content="en_US">' . "\n";

		if ( $description ) {
			echo '<meta property="og:description" content="' . esc_attr( wp_trim_words( $description, 30, '...' ) ) . '">' . "\n";
		}

		if ( $canonical ) {
			echo '<meta property="og:url" content="' . esc_url( $canonical ) . '">' . "\n";
		}

		if ( $image ) {
			echo '<meta property="og:image" content="'        . esc_url( $image ) . '">' . "\n";
			echo '<meta property="og:image:width" content="1200">' . "\n";
			echo '<meta property="og:image:height" content="630">' . "\n";
			echo '<meta property="og:image:alt" content="'    . esc_attr( $title ) . '">' . "\n";
		}
	}
}