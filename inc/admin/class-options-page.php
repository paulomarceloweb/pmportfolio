<?php

/**
 * PMPortfolio — Options Page
 *
 * Página de opções do tema no painel WordPress.
 * Acessível em: Aparência → Configurações do Tema
 *
 * Abas:
 *   geral       → contato, logo, informações básicas
 *   social      → redes sociais
 *   seo         → título, OG image padrão
 *   avancado    → scripts personalizados
 *
 * @package PMPortfolio\Admin
 */

namespace PMPortfolio\Admin;

defined('ABSPATH') || exit;

class Options_Page
{

	/**
	 * Aba ativa atual.
	 * Lida via $_GET['tab'] com fallback para 'geral'.
	 *
	 * @var string
	 */
	private string $active_tab;

	/**
	 * Definição das abas disponíveis.
	 *
	 * @var array
	 */
	private array $tabs;

	/**
	 * Registra os hooks necessários.
	 */
	public function register(): void
	{
		add_action('admin_menu', [$this, 'add_menu']);
		add_action('admin_init', [$this, 'register_settings']);
	}

	/**
	 * Adiciona o item de menu no painel.
	 * Aparece em Aparência → Configurações do Tema.
	 */
	public function add_menu(): void
	{
		add_theme_page(
			__('Configurações do Tema', 'pmportfolio'),
			__('Configurações', 'pmportfolio'),
			'manage_options',
			'pmportfolio-settings',
			[$this, 'render_page']
		);
	}

	/**
	 * Registra opções na Settings API do WordPress.
	 *
	 * LÓGICA PRINCIPAL:
	 * Quando o formulário é submetido (POST), detectamos qual aba
	 * está sendo salva via campo hidden 'pmportfolio_active_tab'.
	 * Registramos APENAS os campos daquela aba — assim os campos
	 * das outras abas não são processados nem sobrescritos com vazio.
	 *
	 * Em requisições GET (visualização), registramos tudo para que
	 * o WordPress reconheça todas as opções normalmente.
	 */
	public function register_settings(): void
	{

		$api = new Settings_API();

		// Detecta qual aba está sendo salva no submit
		// phpcs:ignore WordPress.Security.NonceVerification
		$saving_tab = isset($_POST['pmportfolio_active_tab'])
			? sanitize_key($_POST['pmportfolio_active_tab'])
			: '';

		switch ($saving_tab) {

			// ── SALVAR ABA GERAL ─────────────────────────────
			case 'geral':
				$api->register_option('email',      'sanitize_email');
				$api->register_option('phone',      'sanitize_text_field');
				$api->register_option('whatsapp',   'sanitize_text_field');
				$api->register_option('address',    'sanitize_textarea_field');
				$api->register_option('logo_light', 'esc_url_raw');
				$api->register_option('logo_dark',  'esc_url_raw');
				$api->register_option('avatar',     'esc_url_raw');
				break;

			// ── SALVAR ABA SOCIAL ────────────────────────────
			case 'social':
				$api->register_option('social_linkedin',  'esc_url_raw');
				$api->register_option('social_github',    'esc_url_raw');
				$api->register_option('social_instagram', 'esc_url_raw');
				$api->register_option('social_twitter',   'esc_url_raw');
				$api->register_option('social_youtube',   'esc_url_raw');
				break;

			// ── SALVAR ABA SEO ───────────────────────────────
			case 'seo':
				$api->register_option('title_separator', 'sanitize_text_field');
				$api->register_option('og_image',        'esc_url_raw');
				$api->register_option('robots_default',  'sanitize_text_field');
				break;

			// ── SALVAR ABA AVANÇADO ──────────────────────────
			case 'avancado':
				$api->register_option('gtm_id',         'sanitize_text_field'); // ← novo
				$api->register_option('head_scripts',   'wp_kses_post');
				$api->register_option('footer_scripts', 'wp_kses_post');
				break;

			// ── GET REQUEST (visualização) ───────────────────
			// Registra tudo para que o WordPress reconheça
			// todas as opções ao renderizar os campos.
			default:
				$api->register_option('email',            'sanitize_email');
				$api->register_option('phone',            'sanitize_text_field');
				$api->register_option('whatsapp',         'sanitize_text_field');
				$api->register_option('address',          'sanitize_textarea_field');
				$api->register_option('logo_light',       'esc_url_raw');
				$api->register_option('logo_dark',        'esc_url_raw');
				$api->register_option('avatar',           'esc_url_raw');
				$api->register_option('social_linkedin',  'esc_url_raw');
				$api->register_option('social_github',    'esc_url_raw');
				$api->register_option('social_instagram', 'esc_url_raw');
				$api->register_option('social_twitter',   'esc_url_raw');
				$api->register_option('social_youtube',   'esc_url_raw');
				$api->register_option('title_separator',  'sanitize_text_field');
				$api->register_option('og_image',         'esc_url_raw');
				$api->register_option('robots_default',   'sanitize_text_field');
				$api->register_option('head_scripts',     'wp_kses_post');
				$api->register_option('footer_scripts',   'wp_kses_post');
				$api->register_option('gtm_id', 'sanitize_text_field');
				break;
		}
	}

	/**
	 * Renderiza a página de opções completa com abas.
	 */
	public function render_page(): void
	{

		if (! current_user_can('manage_options')) {
			return;
		}

		$this->tabs = [
			'geral'    => __('Geral',         'pmportfolio'),
			'social'   => __('Redes Sociais', 'pmportfolio'),
			'seo'      => __('SEO',           'pmportfolio'),
			'avancado' => __('Avançado',      'pmportfolio'),
		];

		// phpcs:ignore WordPress.Security.NonceVerification
		$this->active_tab = isset($_GET['tab'])
			// phpcs:ignore WordPress.Security.NonceVerification
			? sanitize_key($_GET['tab'])
			: 'geral';

		if (! array_key_exists($this->active_tab, $this->tabs)) {
			$this->active_tab = 'geral';
		}
?>

		<div class="wrap">

			<h1><?php echo esc_html(get_admin_page_title()); ?></h1>

			<?php
			// Mensagem de sucesso após salvar
			if (isset($_GET['settings-updated'])) { // phpcs:ignore
				add_settings_error(
					'pmportfolio_messages',
					'pmportfolio_saved',
					__('Configurações salvas com sucesso.', 'pmportfolio'),
					'updated'
				);
			}
			settings_errors('pmportfolio_messages');
			?>

			<!-- ABAS -->
			<nav class="nav-tab-wrapper"
				aria-label="<?php esc_attr_e('Abas de configuração', 'pmportfolio'); ?>">
				<?php foreach ($this->tabs as $tab_key => $tab_label) : ?>
					<a href="<?php echo esc_url(admin_url('themes.php?page=pmportfolio-settings&tab=' . $tab_key)); ?>"
						class="nav-tab <?php echo $this->active_tab === $tab_key ? 'nav-tab-active' : ''; ?>">
						<?php echo esc_html($tab_label); ?>
					</a>
				<?php endforeach; ?>
			</nav>

			<!-- FORMULÁRIO -->
			<form method="post" action="options.php" style="margin-top:20px">

				<?php
				/**
				 * settings_fields() gera nonce + option_page + action.
				 * Obrigatório para a Settings API funcionar.
				 */
				settings_fields('pmportfolio_options');

				/**
				 * Campo hidden que identifica qual aba está sendo salva.
				 * É lido em register_settings() para registrar apenas
				 * os campos da aba atual — evita sobrescrever outras abas.
				 */
				?>
				<input type="hidden"
					name="pmportfolio_active_tab"
					value="<?php echo esc_attr($this->active_tab); ?>">

				<?php
				switch ($this->active_tab) {
					case 'geral':
						$this->render_tab_geral();
						break;
					case 'social':
						$this->render_tab_social();
						break;
					case 'seo':
						$this->render_tab_seo();
						break;
					case 'avancado':
						$this->render_tab_avancado();
						break;
				}
				?>

				<?php submit_button(__('Salvar Configurações', 'pmportfolio')); ?>

			</form>
		</div>
	<?php
	}

	/**
	 * Renderiza a aba Geral.
	 */
	private function render_tab_geral(): void
	{
	?>
		<table class="form-table" role="presentation">

			<tr>
				<th scope="row">
					<label for="pmportfolio_email">
						<?php esc_html_e('E-mail de Contato', 'pmportfolio'); ?>
					</label>
				</th>
				<td>
					<input type="email"
						id="pmportfolio_email"
						name="pmportfolio_email"
						value="<?php echo esc_attr(Settings_API::get('email')); ?>"
						class="regular-text"
						placeholder="paulo@exemplo.com">
				</td>
			</tr>

			<tr>
				<th scope="row">
					<label for="pmportfolio_phone">
						<?php esc_html_e('Telefone', 'pmportfolio'); ?>
					</label>
				</th>
				<td>
					<input type="text"
						id="pmportfolio_phone"
						name="pmportfolio_phone"
						value="<?php echo esc_attr(Settings_API::get('phone')); ?>"
						class="regular-text"
						placeholder="+55 (19) 9 9999-9999">
				</td>
			</tr>

			<tr>
				<th scope="row">
					<label for="pmportfolio_whatsapp">
						<?php esc_html_e('WhatsApp', 'pmportfolio'); ?>
					</label>
				</th>
				<td>
					<input type="text"
						id="pmportfolio_whatsapp"
						name="pmportfolio_whatsapp"
						value="<?php echo esc_attr(Settings_API::get('whatsapp')); ?>"
						class="regular-text"
						placeholder="5519999999999">
					<p class="description">
						<?php esc_html_e('Número com código do país, sem espaços ou símbolos. Ex: 5519999999999', 'pmportfolio'); ?>
					</p>
				</td>
			</tr>

			<tr>
				<th scope="row">
					<label for="pmportfolio_address">
						<?php esc_html_e('Localização', 'pmportfolio'); ?>
					</label>
				</th>
				<td>
					<textarea id="pmportfolio_address"
						name="pmportfolio_address"
						rows="2"
						class="regular-text"><?php echo esc_textarea(Settings_API::get('address')); ?></textarea>
					<p class="description">
						<?php esc_html_e('Ex: Campinas, SP — Brasil', 'pmportfolio'); ?>
					</p>
				</td>
			</tr>

			<tr>
				<th scope="row">
					<label for="pmportfolio_avatar">
						<?php esc_html_e('URL da Foto de Perfil', 'pmportfolio'); ?>
					</label>
				</th>
				<td>
					<input type="url"
						id="pmportfolio_avatar"
						name="pmportfolio_avatar"
						value="<?php echo esc_attr(Settings_API::get('avatar')); ?>"
						class="large-text"
						placeholder="https://exemplo.com/foto.jpg">
					<p class="description">
						<?php esc_html_e('URL da sua foto. Recomendado: envie via Mídia e cole a URL aqui.', 'pmportfolio'); ?>
					</p>
				</td>
			</tr>

			<tr>
				<th scope="row">
					<label for="pmportfolio_logo_light">
						<?php esc_html_e('Logo — Versão Clara', 'pmportfolio'); ?>
					</label>
				</th>
				<td>
					<input type="url"
						id="pmportfolio_logo_light"
						name="pmportfolio_logo_light"
						value="<?php echo esc_attr(Settings_API::get('logo_light')); ?>"
						class="large-text"
						placeholder="https://exemplo.com/logo-light.svg">
					<p class="description">
						<?php esc_html_e('Usada no modo claro (light mode).', 'pmportfolio'); ?>
					</p>
				</td>
			</tr>

			<tr>
				<th scope="row">
					<label for="pmportfolio_logo_dark">
						<?php esc_html_e('Logo — Versão Escura', 'pmportfolio'); ?>
					</label>
				</th>
				<td>
					<input type="url"
						id="pmportfolio_logo_dark"
						name="pmportfolio_logo_dark"
						value="<?php echo esc_attr(Settings_API::get('logo_dark')); ?>"
						class="large-text"
						placeholder="https://exemplo.com/logo-dark.svg">
					<p class="description">
						<?php esc_html_e('Usada no modo escuro (dark mode).', 'pmportfolio'); ?>
					</p>
				</td>
			</tr>

		</table>
	<?php
	}

	/**
	 * Renderiza a aba Redes Sociais.
	 */
	private function render_tab_social(): void
	{

		$socials = [
			'social_linkedin'  => ['label' => 'LinkedIn',    'placeholder' => 'https://linkedin.com/in/paulomarcelo'],
			'social_github'    => ['label' => 'GitHub',      'placeholder' => 'https://github.com/paulomarcelo'],
			'social_instagram' => ['label' => 'Instagram',   'placeholder' => 'https://instagram.com/paulomarcelo'],
			'social_twitter'   => ['label' => 'Twitter / X', 'placeholder' => 'https://twitter.com/paulomarcelo'],
			'social_youtube'   => ['label' => 'YouTube',     'placeholder' => 'https://youtube.com/@paulomarcelo'],
		];
	?>
		<table class="form-table" role="presentation">
			<?php foreach ($socials as $key => $social) : ?>
				<tr>
					<th scope="row">
						<label for="pmportfolio_<?php echo esc_attr($key); ?>">
							<?php echo esc_html($social['label']); ?>
						</label>
					</th>
					<td>
						<input type="url"
							id="pmportfolio_<?php echo esc_attr($key); ?>"
							name="pmportfolio_<?php echo esc_attr($key); ?>"
							value="<?php echo esc_attr(Settings_API::get($key)); ?>"
							class="large-text"
							placeholder="<?php echo esc_attr($social['placeholder']); ?>">
					</td>
				</tr>
			<?php endforeach; ?>
		</table>
	<?php
	}

	/**
	 * Renderiza a aba SEO.
	 */
	private function render_tab_seo(): void
	{
	?>
		<table class="form-table" role="presentation">

			<tr>
				<th scope="row">
					<label for="pmportfolio_title_separator">
						<?php esc_html_e('Separador do Título', 'pmportfolio'); ?>
					</label>
				</th>
				<td>
					<input type="text"
						id="pmportfolio_title_separator"
						name="pmportfolio_title_separator"
						value="<?php echo esc_attr(Settings_API::get('title_separator', '—')); ?>"
						class="small-text">
					<p class="description">
						<?php esc_html_e('Caractere entre o título da página e o nome do site. Ex: Sobre — Paulo Marcelo', 'pmportfolio'); ?>
					</p>
				</td>
			</tr>

			<tr>
				<th scope="row">
					<label for="pmportfolio_og_image">
						<?php esc_html_e('Imagem OG Padrão', 'pmportfolio'); ?>
					</label>
				</th>
				<td>
					<input type="url"
						id="pmportfolio_og_image"
						name="pmportfolio_og_image"
						value="<?php echo esc_attr(Settings_API::get('og_image')); ?>"
						class="large-text"
						placeholder="https://exemplo.com/og-default.jpg">
					<p class="description">
						<?php esc_html_e('Imagem exibida ao compartilhar o site nas redes sociais. Recomendado: 1200×630px.', 'pmportfolio'); ?>
					</p>
				</td>
			</tr>

			<tr>
				<th scope="row">
					<label for="pmportfolio_robots_default">
						<?php esc_html_e('Robots Padrão', 'pmportfolio'); ?>
					</label>
				</th>
				<td>
					<select id="pmportfolio_robots_default"
						name="pmportfolio_robots_default">
						<?php
						$robots_options = [
							'index, follow'     => __('index, follow (padrão — indexar tudo)', 'pmportfolio'),
							'noindex, follow'   => __('noindex, follow (não indexar)', 'pmportfolio'),
							'index, nofollow'   => __('index, nofollow (não seguir links)', 'pmportfolio'),
							'noindex, nofollow' => __('noindex, nofollow (bloquear tudo)', 'pmportfolio'),
						];
						$current = Settings_API::get('robots_default', 'index, follow');
						foreach ($robots_options as $value => $label) :
						?>
							<option value="<?php echo esc_attr($value); ?>"
								<?php selected($current, $value); ?>>
								<?php echo esc_html($label); ?>
							</option>
						<?php endforeach; ?>
					</select>
				</td>
			</tr>

		</table>
	<?php
	}

	/**
	 * Renderiza a aba Avançado.
	 */
	private function render_tab_avancado(): void
	{
	?>
		<table class="form-table" role="presentation">

			<tr>
				<th scope="row">
					<label for="pmportfolio_head_scripts">
						<?php esc_html_e('Scripts no &lt;head&gt;', 'pmportfolio'); ?>
					</label>
				</th>
				<td>
					<textarea id="pmportfolio_head_scripts"
						name="pmportfolio_head_scripts"
						rows="5"
						class="large-text code"><?php echo esc_textarea(Settings_API::get('head_scripts')); ?></textarea>
					<p class="description">
						<?php esc_html_e('Scripts adicionados antes de </head>. Ex: Google Analytics, Tag Manager.', 'pmportfolio'); ?>
					</p>
				</td>
			</tr>

			<tr>
				<th scope="row">
					<label for="pmportfolio_footer_scripts">
						<?php esc_html_e('Scripts no Rodapé', 'pmportfolio'); ?>
					</label>
				</th>
				<td>
					<textarea id="pmportfolio_footer_scripts"
						name="pmportfolio_footer_scripts"
						rows="5"
						class="large-text code"><?php echo esc_textarea(Settings_API::get('footer_scripts')); ?></textarea>
					<p class="description">
						<?php esc_html_e('Scripts adicionados antes de </body>. Ex: chat de suporte, pixels de conversão.', 'pmportfolio'); ?>
					</p>
				</td>
			</tr>

			<tr>
				<th scope="row">
					<label for="pmportfolio_gtm_id">
						<?php esc_html_e('Google Tag Manager ID', 'pmportfolio'); ?>
					</label>
				</th>
				<td>
					<input type="text"
						id="pmportfolio_gtm_id"
						name="pmportfolio_gtm_id"
						value="<?php echo esc_attr(Settings_API::get('gtm_id')); ?>"
						class="regular-text"
						placeholder="GTM-XXXXXXX">
					<p class="description">
						<?php esc_html_e('ID do contêiner do Google Tag Manager. Ex: GTM-XXXXXXX', 'pmportfolio'); ?>
					</p>
				</td>
			</tr>

		</table>
<?php
	}
}
