<?php
/**
 * PMPortfolio — Settings API
 *
 * Abstração da WordPress Settings API.
 * Simplifica o registro de opções, seções e campos.
 *
 * Como funciona a Settings API do WordPress:
 *
 * 1. register_setting()  → registra uma opção no banco (wp_options)
 * 2. add_settings_section() → cria um agrupamento visual de campos
 * 3. add_settings_field()   → adiciona um campo dentro de uma seção
 * 4. settings_fields()      → gera o nonce no formulário
 * 5. do_settings_sections() → renderiza todas as seções e campos
 *
 * Todas as opções ficam salvas na tabela wp_options
 * e são recuperadas com get_option('nome_da_opcao').
 *
 * @package PMPortfolio\Admin
 */

namespace PMPortfolio\Admin;

defined( 'ABSPATH' ) || exit;

class Settings_API {

	/**
	 * Prefixo usado em todas as opções do tema.
	 * Evita conflito com opções de plugins.
	 * Ex: 'pmportfolio_email', 'pmportfolio_phone'
	 */
	const PREFIX = 'pmportfolio_';

	/**
	 * Recupera uma opção do tema.
	 * Helper estático para uso em qualquer template.
	 *
	 * Uso nos templates:
	 *   Settings_API::get('email')
	 *   Settings_API::get('social_linkedin')
	 *
	 * @param  string $key     Nome da opção sem o prefixo.
	 * @param  string $default Valor padrão se a opção não existir.
	 * @return string          Valor da opção.
	 */
	public static function get( string $key, string $default = '' ): string {
		return (string) get_option( self::PREFIX . $key, $default );
	}

	/**
 * Registra uma opção simples.
 *
 * Garante que NULL nunca chegue à função de sanitização —
 * converte para string vazia antes de sanitizar.
 * Necessário para PHP 8.x onde NULL em funções de string
 * gera Deprecated notice.
 *
 * @param string $key      Nome sem prefixo.
 * @param string $sanitize Função de sanitização.
 */
public function register_option( string $key, string $sanitize = 'sanitize_text_field' ): void {
    register_setting(
        'pmportfolio_options',
        self::PREFIX . $key,
        [
            'sanitize_callback' => function( $value ) use ( $sanitize ) {
                // Converte NULL ou qualquer não-string para string vazia
                // antes de passar para a função de sanitização
                $value = is_string( $value ) ? $value : '';
                return call_user_func( $sanitize, $value );
            },
        ]
    );
}
}