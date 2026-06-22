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
	 * Injeta GTM + scripts personalizados no <head>.
	 */
	public function inject_head_scripts(): void
	{

		$gtm_id = \PMPortfolio\Admin\Settings_API::get('gtm_id');

		// Google Tag Manager — snippet oficial
		if ($gtm_id) {
			$gtm_id = esc_js($gtm_id);
			echo "<!-- Google Tag Manager -->\n";
			echo "<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':\n";
			echo "new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],\n";
			echo "j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=\n";
			echo "'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);\n";
			echo "})(window,document,'script','dataLayer','{$gtm_id}');</script>\n";
			echo "<!-- End Google Tag Manager -->\n\n";
		}

		// Scripts personalizados do painel
		$scripts = \PMPortfolio\Admin\Settings_API::get('head_scripts');
		if ($scripts) {
			echo wp_kses_post($scripts) . "\n";
		}
	}

	/**
	 * Injeta GTM noscript + scripts personalizados no rodapé.
	 */
	public function inject_footer_scripts(): void
	{

		$gtm_id = \PMPortfolio\Admin\Settings_API::get('gtm_id');

		// GTM noscript — obrigatório logo após o <body>
		// Como não temos acesso direto ao <body>, colocamos no wp_footer
		if ($gtm_id) {
			$gtm_id = esc_attr($gtm_id);
			echo "<!-- Google Tag Manager (noscript) -->\n";
			echo "<noscript><iframe src=\"https://www.googletagmanager.com/ns.html?id={$gtm_id}\"\n";
			echo "height=\"0\" width=\"0\" style=\"display:none;visibility:hidden\"></iframe></noscript>\n";
			echo "<!-- End Google Tag Manager (noscript) -->\n\n";
		}

		// Scripts personalizados do painel
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
