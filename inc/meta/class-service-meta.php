<?php
/**
 * PMPortfolio — Service Meta Box
 *
 * Campos customizados para o CPT 'servico'.
 * Aparece no editor de serviços como "Detalhes do Serviço".
 *
 * Campos:
 *   _servico_preco            → preço ou faixa de preço
 *   _servico_prazo            → prazo de entrega
 *   _servico_em_destaque      → exibir na home?
 *   _servico_descricao_curta  → resumo para cards
 *   _servico_beneficios       → lista de benefícios/entregas
 *   _servico_cta_texto        → texto do botão CTA
 *   _servico_cta_url          → URL do botão CTA
 *
 * @package PMPortfolio\Meta
 */

namespace PMPortfolio\Meta;

defined( 'ABSPATH' ) || exit;

class Service_Meta extends Meta_Box {

	public function __construct() {
    $this->id           = 'pmportfolio_service_meta';
    $this->title        = 'Detalhes do Serviço'; // ← sem __() aqui
    $this->post_type    = 'servico';
    $this->nonce_name   = 'pmportfolio_service_nonce';
    $this->nonce_action = 'pmportfolio_service_save';
}

	/**
	 * Renderiza o HTML da meta box.
	 *
	 * @param \WP_Post $post Post atual.
	 */
	public function render( \WP_Post $post ): void {

		$this->nonce_field();

		$preco           = $this->get_meta( $post->ID, '_servico_preco' );
		$prazo           = $this->get_meta( $post->ID, '_servico_prazo' );
		$em_destaque     = get_post_meta( $post->ID, '_servico_em_destaque', true );
		$descricao_curta = $this->get_meta( $post->ID, '_servico_descricao_curta' );
		$beneficios      = $this->get_meta( $post->ID, '_servico_beneficios' );
		$cta_texto       = $this->get_meta( $post->ID, '_servico_cta_texto' );
		$cta_url         = $this->get_meta( $post->ID, '_servico_cta_url' );
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

			<!-- PREÇO -->
			<div class="pm-meta-field">
				<label for="servico_preco">
					<?php esc_html_e( 'Preço', 'pmportfolio' ); ?>
				</label>
				<input type="text"
				       id="servico_preco"
				       name="servico_preco"
				       value="<?php echo esc_attr( $preco ); ?>"
				       placeholder="<?php esc_attr_e( 'Ex: a partir de R$ 3.500', 'pmportfolio' ); ?>">
			</div>

			<!-- PRAZO -->
			<div class="pm-meta-field">
				<label for="servico_prazo">
					<?php esc_html_e( 'Prazo de Entrega', 'pmportfolio' ); ?>
				</label>
				<input type="text"
				       id="servico_prazo"
				       name="servico_prazo"
				       value="<?php echo esc_attr( $prazo ); ?>"
				       placeholder="<?php esc_attr_e( 'Ex: 4–6 semanas', 'pmportfolio' ); ?>">
			</div>

			<!-- EM DESTAQUE -->
			<div class="pm-meta-field pm-meta-full">
				<div class="pm-meta-check">
					<input type="checkbox"
					       id="servico_em_destaque"
					       name="servico_em_destaque"
					       value="1"
					       <?php checked( $em_destaque, '1' ); ?>>
					<label for="servico_em_destaque">
						<?php esc_html_e( 'Exibir em destaque na home', 'pmportfolio' ); ?>
					</label>
				</div>
			</div>

			<!-- DESCRIÇÃO CURTA -->
			<div class="pm-meta-field pm-meta-full">
				<label for="servico_descricao_curta">
					<?php esc_html_e( 'Descrição Curta', 'pmportfolio' ); ?>
					<span style="font-weight:400;color:#646970"> — <?php esc_html_e( 'usada nos cards de serviços', 'pmportfolio' ); ?></span>
				</label>
				<textarea id="servico_descricao_curta"
				          name="servico_descricao_curta"
				          placeholder="<?php esc_attr_e( 'Resumo em 1-2 frases para aparecer nos cards', 'pmportfolio' ); ?>"><?php echo esc_textarea( $descricao_curta ); ?></textarea>
			</div>

			<!-- BENEFÍCIOS -->
			<div class="pm-meta-field pm-meta-full">
				<label for="servico_beneficios">
					<?php esc_html_e( 'O que está incluso', 'pmportfolio' ); ?>
					<span style="font-weight:400;color:#646970"> — <?php esc_html_e( 'um item por linha', 'pmportfolio' ); ?></span>
				</label>
				<textarea id="servico_beneficios"
				          name="servico_beneficios"
				          style="min-height:120px"
				          placeholder="<?php esc_attr_e( "Arquitetura PSR-4 com namespaces\nSEO técnico: Schema, hreflang, canonical\nDark mode + bilíngue PT/EN\n30 dias de suporte pós-entrega", 'pmportfolio' ); ?>"><?php echo esc_textarea( $beneficios ); ?></textarea>
			</div>

		</div>

		<!-- SEÇÃO CTA -->
		<div class="pm-meta-section">
			<?php esc_html_e( 'Call to Action', 'pmportfolio' ); ?>
		</div>

		<div class="pm-meta-grid">

			<!-- CTA TEXTO -->
			<div class="pm-meta-field">
				<label for="servico_cta_texto">
					<?php esc_html_e( 'Texto do Botão', 'pmportfolio' ); ?>
				</label>
				<input type="text"
				       id="servico_cta_texto"
				       name="servico_cta_texto"
				       value="<?php echo esc_attr( $cta_texto ); ?>"
				       placeholder="<?php esc_attr_e( 'Ex: Solicitar orçamento →', 'pmportfolio' ); ?>">
			</div>

			<!-- CTA URL -->
			<div class="pm-meta-field">
				<label for="servico_cta_url">
					<?php esc_html_e( 'URL do Botão', 'pmportfolio' ); ?>
				</label>
				<input type="url"
				       id="servico_cta_url"
				       name="servico_cta_url"
				       value="<?php echo esc_attr( $cta_url ); ?>"
				       placeholder="https://exemplo.com/contato/">
			</div>

		</div>
		<?php
	}

	/**
	 * Salva os campos do serviço.
	 *
	 * @param int $post_id ID do post sendo salvo.
	 */
	public function save( int $post_id ): void {

		if ( ! $this->can_save( $post_id ) ) {
			return;
		}

		$fields = [
			'servico_preco'           => [ 'key' => '_servico_preco',           'sanitize' => 'sanitize_text_field' ],
			'servico_prazo'           => [ 'key' => '_servico_prazo',           'sanitize' => 'sanitize_text_field' ],
			'servico_descricao_curta' => [ 'key' => '_servico_descricao_curta', 'sanitize' => 'sanitize_textarea_field' ],
			'servico_beneficios'      => [ 'key' => '_servico_beneficios',      'sanitize' => 'sanitize_textarea_field' ],
			'servico_cta_texto'       => [ 'key' => '_servico_cta_texto',       'sanitize' => 'sanitize_text_field' ],
			'servico_cta_url'         => [ 'key' => '_servico_cta_url',         'sanitize' => 'esc_url_raw' ],
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

		// Checkbox
		if ( isset( $_POST['servico_em_destaque'] ) ) {
			update_post_meta( $post_id, '_servico_em_destaque', '1' );
		} else {
			delete_post_meta( $post_id, '_servico_em_destaque' );
		}
	}
}