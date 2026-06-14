<?php
/**
 * PMPortfolio — Portfolio Meta Box
 *
 * Campos customizados para o CPT 'portfolio'.
 * Aparece no editor de projetos como "Detalhes do Projeto".
 *
 * Campos:
 *   _portfolio_cliente          → nome do cliente
 *   _portfolio_url              → URL do projeto no ar
 *   _portfolio_stack            → tecnologias usadas
 *   _portfolio_em_destaque      → exibir na home?
 *   _portfolio_descricao_curta  → resumo para cards
 *   _portfolio_desafio          → seção "o desafio" do case study
 *   _portfolio_solucao          → seção "a solução" do case study
 *   _portfolio_resultados       → métricas e resultados
 *
 * Por que o prefixo _ nas meta_keys?
 * Meta fields com _ no início ficam ocultos na caixa
 * "Campos Personalizados" padrão do WordPress.
 * Evita que o cliente edite acidentalmente via interface padrão.
 *
 * @package PMPortfolio\Meta
 */

namespace PMPortfolio\Meta;

defined( 'ABSPATH' ) || exit;

class Portfolio_Meta extends Meta_Box {

	public function __construct() {
    $this->id           = 'pmportfolio_portfolio_meta';
    $this->title        = 'Detalhes do Projeto'; // ← sem __() aqui
    $this->post_type    = 'portfolio';
    $this->nonce_name   = 'pmportfolio_portfolio_nonce';
    $this->nonce_action = 'pmportfolio_portfolio_save';
}

	/**
	 * Renderiza o HTML da meta box no editor.
	 *
	 * @param \WP_Post $post Post atual.
	 */
	public function render( \WP_Post $post ): void {

		// Gera o campo nonce de segurança
		$this->nonce_field();

		// Recupera os valores salvos
		$cliente         = $this->get_meta( $post->ID, '_portfolio_cliente' );
		$url             = $this->get_meta( $post->ID, '_portfolio_url' );
		$stack           = $this->get_meta( $post->ID, '_portfolio_stack' );
		$em_destaque     = get_post_meta( $post->ID, '_portfolio_em_destaque', true );
		$descricao_curta = $this->get_meta( $post->ID, '_portfolio_descricao_curta' );
		$desafio         = $this->get_meta( $post->ID, '_portfolio_desafio' );
		$solucao         = $this->get_meta( $post->ID, '_portfolio_solucao' );
		$resultados      = $this->get_meta( $post->ID, '_portfolio_resultados' );
		?>

		<style>
			.pm-meta-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px; }
			.pm-meta-field { display: flex; flex-direction: column; gap: 4px; }
			.pm-meta-field label { font-weight: 600; font-size: 13px; color: #1e1e1e; }
			.pm-meta-field input[type="text"],
			.pm-meta-field input[type="url"],
			.pm-meta-field textarea { width: 100%; padding: 6px 8px; border: 1px solid #8c8f94; border-radius: 4px; font-size: 13px; }
			.pm-meta-field textarea { min-height: 80px; resize: vertical; }
			.pm-meta-full { grid-column: 1 / -1; }
			.pm-meta-check { display: flex; align-items: center; gap: 8px; padding: 12px; background: #f6f7f7; border-radius: 4px; }
			.pm-meta-section { margin: 16px 0 8px; padding-bottom: 6px; border-bottom: 1px solid #dcdcde; font-weight: 600; font-size: 13px; color: #3c434a; }
		</style>

		<div class="pm-meta-grid">

			<!-- CLIENTE -->
			<div class="pm-meta-field">
				<label for="portfolio_cliente">
					<?php esc_html_e( 'Cliente', 'pmportfolio' ); ?>
				</label>
				<input type="text"
				       id="portfolio_cliente"
				       name="portfolio_cliente"
				       value="<?php echo esc_attr( $cliente ); ?>"
				       placeholder="<?php esc_attr_e( 'Ex: Loja Artesanal BR', 'pmportfolio' ); ?>">
			</div>

			<!-- URL DO PROJETO -->
			<div class="pm-meta-field">
				<label for="portfolio_url">
					<?php esc_html_e( 'URL do Projeto', 'pmportfolio' ); ?>
				</label>
				<input type="url"
				       id="portfolio_url"
				       name="portfolio_url"
				       value="<?php echo esc_attr( $url ); ?>"
				       placeholder="https://exemplo.com">
			</div>

			<!-- STACK -->
			<div class="pm-meta-field pm-meta-full">
				<label for="portfolio_stack">
					<?php esc_html_e( 'Stack / Tecnologias', 'pmportfolio' ); ?>
				</label>
				<input type="text"
				       id="portfolio_stack"
				       name="portfolio_stack"
				       value="<?php echo esc_attr( $stack ); ?>"
				       placeholder="<?php esc_attr_e( 'Ex: PHP 8.2, WordPress, Vite, Bootstrap 5', 'pmportfolio' ); ?>">
			</div>

			<!-- EM DESTAQUE -->
			<div class="pm-meta-field pm-meta-full">
				<div class="pm-meta-check">
					<input type="checkbox"
					       id="portfolio_em_destaque"
					       name="portfolio_em_destaque"
					       value="1"
					       <?php checked( $em_destaque, '1' ); ?>>
					<label for="portfolio_em_destaque">
						<?php esc_html_e( 'Exibir em destaque na home', 'pmportfolio' ); ?>
					</label>
				</div>
			</div>

			<!-- DESCRIÇÃO CURTA -->
			<div class="pm-meta-field pm-meta-full">
				<label for="portfolio_descricao_curta">
					<?php esc_html_e( 'Descrição Curta', 'pmportfolio' ); ?>
					<span style="font-weight:400;color:#646970"> — <?php esc_html_e( 'usada nos cards do portfólio', 'pmportfolio' ); ?></span>
				</label>
				<textarea id="portfolio_descricao_curta"
				          name="portfolio_descricao_curta"
				          placeholder="<?php esc_attr_e( 'Resumo em 1-2 frases para aparecer nos cards', 'pmportfolio' ); ?>"><?php echo esc_textarea( $descricao_curta ); ?></textarea>
			</div>

		</div>

		<!-- SEÇÃO CASE STUDY -->
		<div class="pm-meta-section">
			<?php esc_html_e( 'Case Study', 'pmportfolio' ); ?>
		</div>

		<div class="pm-meta-grid">

			<!-- O DESAFIO -->
			<div class="pm-meta-field">
				<label for="portfolio_desafio">
					<?php esc_html_e( 'O Desafio', 'pmportfolio' ); ?>
				</label>
				<textarea id="portfolio_desafio"
				          name="portfolio_desafio"
				          placeholder="<?php esc_attr_e( 'Qual era o problema ou desafio do cliente?', 'pmportfolio' ); ?>"><?php echo esc_textarea( $desafio ); ?></textarea>
			</div>

			<!-- A SOLUÇÃO -->
			<div class="pm-meta-field">
				<label for="portfolio_solucao">
					<?php esc_html_e( 'A Solução', 'pmportfolio' ); ?>
				</label>
				<textarea id="portfolio_solucao"
				          name="portfolio_solucao"
				          placeholder="<?php esc_attr_e( 'Como você resolveu o problema?', 'pmportfolio' ); ?>"><?php echo esc_textarea( $solucao ); ?></textarea>
			</div>

			<!-- RESULTADOS -->
			<div class="pm-meta-field pm-meta-full">
				<label for="portfolio_resultados">
					<?php esc_html_e( 'Resultados e Métricas', 'pmportfolio' ); ?>
					<span style="font-weight:400;color:#646970"> — <?php esc_html_e( 'ex: +38% conversão, Lighthouse 97/100', 'pmportfolio' ); ?></span>
				</label>
				<textarea id="portfolio_resultados"
				          name="portfolio_resultados"
				          placeholder="<?php esc_attr_e( 'Ex: +38% de conversão em 60 dias, Lighthouse 97/100, -62% bounce rate', 'pmportfolio' ); ?>"><?php echo esc_textarea( $resultados ); ?></textarea>
			</div>

		</div>
		<?php
	}

	/**
	 * Salva os campos da meta box com segurança.
	 *
	 * Fluxo de segurança:
	 * 1. can_save() verifica nonce + permissão + não é autosave
	 * 2. wp_unslash() remove barras adicionadas pelo PHP
	 * 3. sanitize_*() limpa o input antes de salvar no banco
	 * 4. update_post_meta() salva ou atualiza o valor
	 *
	 * @param int $post_id ID do post sendo salvo.
	 */
	public function save( int $post_id ): void {

		if ( ! $this->can_save( $post_id ) ) {
			return;
		}

		// Helper para sanitizar e salvar cada campo
		$fields = [
			'portfolio_cliente'         => [ 'key' => '_portfolio_cliente',         'sanitize' => 'sanitize_text_field' ],
			'portfolio_url'             => [ 'key' => '_portfolio_url',             'sanitize' => 'esc_url_raw' ],
			'portfolio_stack'           => [ 'key' => '_portfolio_stack',           'sanitize' => 'sanitize_text_field' ],
			'portfolio_descricao_curta' => [ 'key' => '_portfolio_descricao_curta', 'sanitize' => 'sanitize_textarea_field' ],
			'portfolio_desafio'         => [ 'key' => '_portfolio_desafio',         'sanitize' => 'sanitize_textarea_field' ],
			'portfolio_solucao'         => [ 'key' => '_portfolio_solucao',         'sanitize' => 'sanitize_textarea_field' ],
			'portfolio_resultados'      => [ 'key' => '_portfolio_resultados',      'sanitize' => 'sanitize_textarea_field' ],
		];

		foreach ( $fields as $input_name => $config ) {
			if ( isset( $_POST[ $input_name ] ) ) {
				$value = call_user_func(
					$config['sanitize'],
					wp_unslash( $_POST[ $input_name ] )
				);
				update_post_meta( $post_id, $config['key'], $value );
			}
		}

		// Checkbox — salva 1 se marcado, deleta se desmarcado
		if ( isset( $_POST['portfolio_em_destaque'] ) ) {
			update_post_meta( $post_id, '_portfolio_em_destaque', '1' );
		} else {
			delete_post_meta( $post_id, '_portfolio_em_destaque' );
		}
	}
}