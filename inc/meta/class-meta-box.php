<?php
/**
 * PMPortfolio — Meta Box Abstract
 *
 * Classe base para todas as meta boxes do tema.
 * Define o contrato e implementa a lógica comum de:
 *   - Registro da meta box
 *   - Verificação de nonce (segurança)
 *   - Verificação de permissões
 *   - Sanitização na hora de salvar
 *
 * As classes filhas implementam:
 *   - fields(): define os campos
 *   - render(): HTML da meta box
 *   - save(): salva os campos específicos
 *
 * @package PMPortfolio\Meta
 */

namespace PMPortfolio\Meta;

defined( 'ABSPATH' ) || exit;

abstract class Meta_Box {

	/**
	 * ID único da meta box.
	 * Usado internamente pelo WordPress.
	 * Exemplo: 'pmportfolio_portfolio_meta'
	 *
	 * @var string
	 */
	protected string $id;

	/**
	 * Título visível da meta box no editor.
	 * Exemplo: 'Detalhes do Projeto'
	 *
	 * @var string
	 */
	protected string $title;

	/**
	 * Post type onde a meta box aparece.
	 * Exemplo: 'portfolio' ou 'servico'
	 *
	 * @var string
	 */
	protected string $post_type;

	/**
	 * Nome do campo nonce para segurança.
	 * Cada meta box tem seu próprio nonce.
	 *
	 * @var string
	 */
	protected string $nonce_name;

	/**
	 * Ação do nonce — string única por meta box.
	 *
	 * @var string
	 */
	protected string $nonce_action;

	/**
	 * Registra os hooks necessários para a meta box funcionar.
	 */
	public function register(): void {

		// Adiciona a meta box no editor
		add_action( 'add_meta_boxes', [ $this, 'add' ] );

		// Salva os dados quando o post é salvo
		add_action( 'save_post_' . $this->post_type, [ $this, 'save' ] );
	}

	/**
	 * Registra a meta box no WordPress.
	 * Chamado pelo hook 'add_meta_boxes'.
	 */
	public function add(): void {
    add_meta_box(
        $this->id,
        __( $this->title, 'pmportfolio' ), // ← tradução aplicada aqui, dentro do hook
        [ $this, 'render' ],
        $this->post_type,
        'normal',
        'high'
    );
}

	/**
	 * Renderiza o HTML da meta box.
	 * Implementado em cada classe filha.
	 *
	 * @param \WP_Post $post Post atual sendo editado.
	 */
	abstract public function render( \WP_Post $post ): void;

	/**
	 * Salva os campos da meta box.
	 * Implementado em cada classe filha.
	 *
	 * @param int $post_id ID do post sendo salvo.
	 */
	abstract public function save( int $post_id ): void;

	/**
	 * Verifica se o save é seguro e deve prosseguir.
	 *
	 * Verifica três condições:
	 * 1. Nonce válido — garante que o form veio do WordPress
	 * 2. Permissão — usuário pode editar este post
	 * 3. Não é autosave — WordPress salva rascunhos automaticamente
	 *
	 * @param  int  $post_id ID do post.
	 * @return bool True se pode salvar, false se deve abortar.
	 */
	protected function can_save( int $post_id ): bool {

		// Verifica o nonce
		$nonce = isset( $_POST[ $this->nonce_name ] )
			? sanitize_text_field( wp_unslash( $_POST[ $this->nonce_name ] ) )
			: '';

		if ( ! wp_verify_nonce( $nonce, $this->nonce_action ) ) {
			return false;
		}

		// Verifica permissão do usuário
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return false;
		}

		// Não salva durante autosave do WordPress
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return false;
		}

		return true;
	}

	/**
	 * Gera o campo nonce no HTML do formulário.
	 * Deve ser chamado no início do render() de cada classe filha.
	 */
	protected function nonce_field(): void {
		wp_nonce_field( $this->nonce_action, $this->nonce_name );
	}

	/**
	 * Recupera um meta value do post atual.
	 * Helper para uso no render().
	 *
	 * @param  int    $post_id  ID do post.
	 * @param  string $meta_key Chave do meta field.
	 * @return string           Valor sanitizado para exibição.
	 */
	protected function get_meta( int $post_id, string $meta_key ): string {
		return esc_attr( (string) get_post_meta( $post_id, $meta_key, true ) );
	}
}