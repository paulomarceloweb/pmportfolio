<?php

/**
 * PMPortfolio — SEO Manager
 *
 * Coordena todo o sistema de SEO do tema.
 * Calcula o contexto da página uma única vez por request
 * e distribui para os módulos especializados.
 *
 * Contexto calculado:
 *   - Tipo de página (home, single, archive, etc.)
 *   - Post atual (se aplicável)
 *   - Título SEO
 *   - Descrição SEO
 *   - URL canônica
 *   - Imagem OG
 *
 * @package PMPortfolio\SEO
 */

namespace PMPortfolio\SEO;

use PMPortfolio\Admin\Settings_API;

defined('ABSPATH') || exit;

class SEO_Manager
{

	/**
	 * Contexto calculado da página atual.
	 * Compartilhado com todos os módulos SEO.
	 *
	 * @var array
	 */
	private array $context = [];

	/**
	 * Registra os hooks do sistema de SEO.
	 */
	public function register(): void
	{

		// Remove o <title> padrão do WordPress
		// Vamos gerar o nosso próprio com mais controle
		remove_action('wp_head', '_wp_render_title_tag', 1);

		// Calcula o contexto antes de qualquer output
		add_action('wp', [$this, 'build_context']);

		// Injeta todas as meta tags no <head>
		add_action('wp_head', [$this, 'render_all'], 1);
	}

	/**
	 * Constrói o contexto SEO da página atual.
	 * Chamado no hook 'wp' — após o WordPress identificar
	 * qual página está sendo carregada, mas antes de qualquer output.
	 */
	public function build_context(): void
	{

		global $post;

		$separator   = Settings_API::get('title_separator', '—');
		$site_name   = get_bloginfo('name');
		$og_image    = Settings_API::get('og_image');
		$robots      = Settings_API::get('robots_default', 'index, follow');

		// ── HOME ──────────────────────────────────────────
		if (is_front_page()) {
			$this->context = [
				'type'        => 'home',
				'title'       => $site_name . ' ' . $separator . ' ' . get_bloginfo('description'),
				'description' => get_bloginfo('description'),
				'canonical'   => home_url('/'),
				'og_type'     => 'website',
				'og_image'    => $og_image,
				'robots'      => $robots,
				'post'        => null,
			];
			return;
		}

		// ── SINGLE POST ───────────────────────────────────
		if (is_singular() && $post) {

			$seo_title = get_post_meta($post->ID, '_seo_title', true);
			$title     = $seo_title
				? $seo_title . ' ' . $separator . ' ' . $site_name
				: get_the_title($post) . ' ' . $separator . ' ' . $site_name;

			$seo_desc = get_post_meta($post->ID, '_seo_description', true);
			if ($seo_desc) {
				$description = $seo_desc;
			} elseif ($post->post_excerpt) {
				$description = wp_strip_all_tags($post->post_excerpt);
			} else {
				$description = wp_trim_words(
					wp_strip_all_tags($post->post_content),
					30,
					'...'
				);
			}

			// noindex manual via meta box ← ADICIONA AQUI
			$seo_noindex = get_post_meta($post->ID, '_seo_noindex', true);
			if ($seo_noindex) {
				$robots = 'noindex, nofollow';
			}

			$thumb_id = get_post_thumbnail_id($post->ID);
			$thumb    = $thumb_id
				? wp_get_attachment_image_url($thumb_id, 'pm-portfolio')
				: $og_image;

			$this->context = [
				'type'        => 'single',
				'post_type'   => get_post_type($post),
				'title'       => $title,
				'description' => $description,
				'canonical'   => get_permalink($post),
				'og_type'     => 'article',
				'og_image'    => $thumb,
				'robots'      => $robots,
				'post'        => $post,
			];
			return;
		}

		// ── ARCHIVE CPT ───────────────────────────────────
		if (is_post_type_archive()) {
			$post_type_obj = get_queried_object();
			$label         = $post_type_obj->labels->name ?? '';

			$this->context = [
				'type'        => 'archive',
				'title'       => $label . ' ' . $separator . ' ' . $site_name,
				'description' => $post_type_obj->description ?? get_bloginfo('description'),
				'canonical'   => get_post_type_archive_link(get_post_type()),
				'og_type'     => 'website',
				'og_image'    => $og_image,
				'robots'      => $robots,
				'post'        => null,
			];
			return;
		}

		// ── CATEGORIA / TAG ───────────────────────────────
		if (is_category() || is_tag() || is_tax()) {
			$term = get_queried_object();

			$this->context = [
				'type'        => 'taxonomy',
				'title'       => $term->name . ' ' . $separator . ' ' . $site_name,
				'description' => $term->description ?: get_bloginfo('description'),
				'canonical'   => get_term_link($term),
				'og_type'     => 'website',
				'og_image'    => $og_image,
				'robots'      => $robots,
				'post'        => null,
			];
			return;
		}

		// ── BUSCA ─────────────────────────────────────────
		if (is_search()) {
			$this->context = [
				'type'        => 'search',
				'title'       => __('Busca', 'pmportfolio') . ' ' . $separator . ' ' . $site_name,
				'description' => '',
				'canonical'   => '',
				'og_type'     => 'website',
				'og_image'    => $og_image,
				'robots'      => 'noindex, follow', // busca nunca indexada
				'post'        => null,
			];
			return;
		}

		// ── 404 ───────────────────────────────────────────
		if (is_404()) {
			$this->context = [
				'type'        => '404',
				'title'       => '404 ' . $separator . ' ' . $site_name,
				'description' => '',
				'canonical'   => '',
				'og_type'     => 'website',
				'og_image'    => $og_image,
				'robots'      => 'noindex, nofollow', // 404 nunca indexado
				'post'        => null,
			];
			return;
		}

		// ── FALLBACK ──────────────────────────────────────
		$this->context = [
			'type'        => 'default',
			'title'       => $site_name,
			'description' => get_bloginfo('description'),
			'canonical'   => home_url('/'),
			'og_type'     => 'website',
			'og_image'    => $og_image,
			'robots'      => $robots,
			'post'        => null,
		];
	}

	/**
	 * Renderiza todas as meta tags no <head>.
	 * Delega para cada módulo especializado.
	 */
	public function render_all(): void
	{

		if (empty($this->context)) {
			return;
		}

		echo "\n<!-- PMPortfolio SEO -->\n";

		(new Meta_Tags($this->context))->render();
		(new Open_Graph($this->context))->render();
		(new Twitter_Cards($this->context))->render();
		(new Hreflang($this->context))->render();
		(new Schema($this->context))->render();

		echo "<!-- /PMPortfolio SEO -->\n\n";
	}

	/**
	 * Retorna o contexto atual.
	 * Útil para uso em templates via filtro ou action.
	 *
	 * @return array
	 */
	public function get_context(): array
	{
		return $this->context;
	}
}
