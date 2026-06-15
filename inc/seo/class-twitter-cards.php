<?php
/**
 * PMPortfolio — Twitter Cards
 *
 * Gera as meta tags Twitter Cards no <head>.
 * Controlam como o link aparece ao ser compartilhado no X/Twitter.
 *
 * Tags geradas:
 *   twitter:card, twitter:title, twitter:description,
 *   twitter:image, twitter:site, twitter:creator
 *
 * @package PMPortfolio\SEO
 */

namespace PMPortfolio\SEO;

use PMPortfolio\Admin\Settings_API;

defined( 'ABSPATH' ) || exit;

class Twitter_Cards {

	/**
	 * @param array $context Contexto SEO calculado pelo SEO_Manager.
	 */
	public function __construct( private array $context ) {}

	/**
	 * Renderiza as meta tags Twitter Cards.
	 */
	public function render(): void {

		$title       = $this->context['title']       ?? '';
		$description = $this->context['description'] ?? '';
		$image       = $this->context['og_image']    ?? '';

		if ( empty( $title ) ) {
			return;
		}

		// Recupera o handle do Twitter das opções do tema
		$twitter_url = Settings_API::get( 'social_twitter' );
		$handle      = '';
		if ( $twitter_url ) {
			// Extrai o @handle da URL: https://twitter.com/paulomarcelo → @paulomarcelo
			$parts  = explode( '/', rtrim( $twitter_url, '/' ) );
			$handle = '@' . end( $parts );
		}

		// summary_large_image = card grande com imagem destacada
		echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
		echo '<meta name="twitter:title" content="' . esc_attr( $title ) . '">' . "\n";

		if ( $description ) {
			echo '<meta name="twitter:description" content="' . esc_attr( wp_trim_words( $description, 30, '...' ) ) . '">' . "\n";
		}

		if ( $image ) {
			echo '<meta name="twitter:image" content="' . esc_url( $image ) . '">' . "\n";
			echo '<meta name="twitter:image:alt" content="' . esc_attr( $title ) . '">' . "\n";
		}

		if ( $handle ) {
			echo '<meta name="twitter:site" content="'    . esc_attr( $handle ) . '">' . "\n";
			echo '<meta name="twitter:creator" content="' . esc_attr( $handle ) . '">' . "\n";
		}
	}
}