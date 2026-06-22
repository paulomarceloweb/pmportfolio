<?php

/**
 * PMPortfolio — Theme
 *
 * Classe principal do tema. Ponto de orquestração.
 * Inicializa todos os módulos e registra hooks globais.
 *
 * @package PMPortfolio\Core
 */

namespace PMPortfolio\Core;

defined('ABSPATH') || exit;

class Theme
{

	/**
	 * Inicializa o tema.
	 * Chamado uma única vez no functions.php.
	 */
	public function boot(): void
	{
		$this->init_modules();
		$this->register_hooks();
	}

	/**
	 * Instancia e inicializa cada módulo do tema.
	 *
	 * Cada módulo é uma classe com responsabilidade única.
	 * Ele mesmo registra seus hooks internamente via register().
	 */
	private function init_modules(): void
	{

		(new Theme_Support())->register();
		(new Asset_Manager())->register();
		(new \PMPortfolio\CPT\CPT_Registry())->register();
		(new \PMPortfolio\Meta\Portfolio_Meta())->register();
		(new \PMPortfolio\Meta\Service_Meta())->register();
		(new \PMPortfolio\Multilingual\Language_Router())->register();

		// Sitemap e Robots — sempre registrados (verificam contexto internamente)
		(new \PMPortfolio\SEO\Sitemap())->register();
		(new \PMPortfolio\SEO\Robots())->register();

		if (! is_admin()) {
			(new \PMPortfolio\SEO\SEO_Manager())->register();
		}

		if (is_admin()) {
			(new \PMPortfolio\Admin\Options_Page())->register();
			(new \PMPortfolio\SEO\SEO_Meta_Box())->register();
		}
	}

	/**
	 * Registra hooks globais que pertencem ao tema em si,
	 * não a um módulo específico.
	 */
	private function register_hooks(): void
	{
		add_action('init',       [$this, 'clean_wp_head']);
		add_action('wp_head',    [$this, 'inject_head_scripts'], 99);
		add_action('wp_footer',  [$this, 'inject_footer_scripts'], 99);
	}

	/**
	 * Injeta scripts personalizados do painel no <head>.
	 */
	public function inject_head_scripts(): void
	{
		$scripts = \PMPortfolio\Admin\Settings_API::get('head_scripts');
		if ($scripts) {
			echo wp_kses_post($scripts) . "\n";
		}
	}

	/**
	 * Injeta scripts personalizados do painel no rodapé.
	 */
	public function inject_footer_scripts(): void
	{
		$scripts = \PMPortfolio\Admin\Settings_API::get('footer_scripts');
		if ($scripts) {
			echo wp_kses_post($scripts) . "\n";
		}
	}

	/**
	 * Remove itens desnecessários do <head> gerados pelo WordPress.
	 *
	 * Por que isso importa?
	 * - Performance: menos requisições HTTP
	 * - Segurança: não expõe a versão do WordPress
	 * - SEO: <head> mais limpo e semântico
	 */
	public function clean_wp_head(): void
	{

		// Versão do WordPress no HTML — expõe informação de segurança
		remove_action('wp_head', 'wp_generator');

		// APIs antigas que nenhum serviço moderno usa
		remove_action('wp_head', 'rsd_link');
		remove_action('wp_head', 'wlwmanifest_link');

		// Feed de comentários no <head> — desnecessário
		remove_action('wp_head', 'feed_links_extra', 3);

		// Emojis — carregam JS + CSS extras sem necessidade alguma
		remove_action('wp_head',             'print_emoji_detection_script', 7);
		remove_action('wp_print_styles',     'print_emoji_styles');
		remove_action('admin_print_scripts', 'print_emoji_detection_script');
		remove_action('admin_print_styles',  'print_emoji_styles');

		// WordPress Embed — player automático de URLs
		remove_action('wp_head', 'wp_oembed_add_discovery_links');
		wp_deregister_script('wp-embed');
	}
}
