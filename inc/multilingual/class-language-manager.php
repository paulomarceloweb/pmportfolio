<?php

/**
 * PMPortfolio — Language Manager
 *
 * Gerencia o estado do idioma atual da requisição.
 * Detecta o idioma em cascata:
 *   1. URL começa com /en/
 *   2. Cookie pmportfolio-lang
 *   3. Accept-Language do browser
 *   4. Fallback: pt
 *
 * Uso nos templates:
 *   Language_Manager::get()           → 'pt' ou 'en'
 *   Language_Manager::is('en')        → true/false
 *   Language_Manager::t('PT', 'EN')   → texto no idioma atual
 *
 * @package PMPortfolio\Multilingual
 */

namespace PMPortfolio\Multilingual;

defined('ABSPATH') || exit;

class Language_Manager
{

    /**
     * Idioma atual da requisição.
     * Calculado uma única vez e cacheado.
     *
     * @var string|null
     */
    private static ?string $current = null;

    /**
     * Idiomas suportados pelo tema.
     *
     * @var array
     */
    private static array $supported = ['pt', 'en'];

    /**
     * Detecta e retorna o idioma atual.
     * Resultado é cacheado na propriedade estática.
     *
     * @return string 'pt' ou 'en'
     */
    public static function get(): string
    {

        if (self::$current !== null) {
            return self::$current;
        }

        self::$current = self::detect();
        return self::$current;
    }

    /**
     * Verifica se o idioma atual é o especificado.
     *
     * @param  string $lang Idioma para verificar ('pt' ou 'en')
     * @return bool
     */
    public static function is(string $lang): bool
    {
        return self::get() === $lang;
    }

    /**
     * Retorna o texto no idioma atual.
     * Helper para traduções inline nos templates.
     *
     * Uso:
     *   echo Language_Manager::t( 'Sobre', 'About' );
     *
     * @param  string $pt Texto em português
     * @param  string $en Texto em inglês
     * @return string
     */
    public static function t(string $pt, string $en): string
    {
        return self::is('en') ? $en : $pt;
    }

    /**
     * Define o idioma manualmente.
     * Usado pelo Language_Router após detectar a URL.
     *
     * @param string $lang
     */
    public static function set(string $lang): void
    {
        if (in_array($lang, self::$supported, true)) {
            self::$current = $lang;
        }
    }

    /**
     * Retorna a URL equivalente no outro idioma.
     *
     * PT → EN: /sobre/    → /en/sobre/
     * EN → PT: /en/sobre/ → /sobre/
     *
     * Quando houver posts vinculados (_translation_id),
     * usará a URL real da tradução.
     *
     * @param  string|null $url URL atual (null = URL da requisição)
     * @return string           URL no idioma alternativo
     */
    public static function alternate_url(?string $url = null): string
    {

        // Pega o path relativo da URL atual (sem o domínio)
        $request_uri = $url ?? ($_SERVER['REQUEST_URI'] ?? '/');

        // Path base do WordPress (ex: /pmportfolio/)
        $home_path = rtrim(parse_url(home_url('/'), PHP_URL_PATH) ?? '/', '/');

        // Remove o path base para ter só o path relativo
        // /pmportfolio/sobre/ → /sobre/
        $relative = '/' . ltrim(
            substr($request_uri, strlen($home_path)),
            '/'
        );

        if (self::is('en')) {
            // EN → PT: remove /en/ do início
            // /en/about/ → /about/
            $clean = preg_replace('#^/en(/|$)#', '/', $relative);
            return home_url($clean);
        } else {
            // PT → EN: adiciona /en/ no início
            // /sobre/ → /en/sobre/
            return home_url('/en' . $relative);
        }
    }

    /**
     * Lógica de detecção do idioma.
     *
     * @return string
     */
    private static function detect(): string
    {

        // 1. URL começa com /en/
        $request_uri = $_SERVER['REQUEST_URI'] ?? '';
        $home_path   = parse_url(home_url('/'), PHP_URL_PATH) ?? '/';

        // Remove o path base do WordPress da URI
        $path = '/' . ltrim(
            str_replace(rtrim($home_path, '/'), '', $request_uri),
            '/'
        );

        if (str_starts_with($path, '/en/') || $path === '/en') {
            return 'en';
        }

        // 2. Cookie do usuário
        $cookie = isset($_COOKIE['pmportfolio-lang'])
            ? sanitize_key($_COOKIE['pmportfolio-lang'])
            : '';

        if (in_array($cookie, self::$supported, true)) {
            return $cookie;
        }

        // 3. Accept-Language do browser
        $accept = $_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? '';
        if (str_contains($accept, 'en') && ! str_contains($accept, 'pt')) {
            return 'en';
        }

        // 4. Fallback
        return 'pt';
    }
}
