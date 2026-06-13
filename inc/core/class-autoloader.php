<?php

/**
 * PMPortfolio — Autoloader
 *
 * Registra um autoloader PSR-4 sem Composer.
 * Carrega classes automaticamente pelo namespace.
 *
 * Convenção de mapeamento:
 *   PMPortfolio\Core\Theme      →  inc/core/class-theme.php
 *   PMPortfolio\SEO\Meta_Tags   →  inc/seo/class-meta-tags.php
 *   PMPortfolio\CPT\Portfolio   →  inc/cpt/class-portfolio.php
 *
 * @package PMPortfolio\Core
 */

namespace PMPortfolio\Core;

defined('ABSPATH') || exit;

class Autoloader
{

    /**
     * Caminho absoluto para a pasta /inc/
     * Exemplo: C:/wamp64/www/pmportfolio/wp-content/themes/pmportfolio/inc/
     *
     * @var string
     */
    private string $base_dir;

    /**
     * Prefixo de namespace deste tema.
     * Apenas classes que começam com PMPortfolio\ serão resolvidas aqui.
     *
     * @var string
     */
    private string $prefix = 'PMPortfolio\\';

    /**
     * @param string $base_dir Caminho absoluto para /inc/
     */
    public function __construct(string $base_dir)
    {
        // rtrim garante que não haja barra duplicada no final
        $this->base_dir = rtrim($base_dir, '/\\') . DIRECTORY_SEPARATOR;
    }

    /**
     * Registra este autoloader no PHP via spl_autoload_register.
     *
     * Após isso, toda vez que o PHP encontrar uma classe não carregada
     * que comece com PMPortfolio\, ele chamará o método load() abaixo.
     */
    public function register(): void
    {
        spl_autoload_register([$this, 'load']);
    }

    /**
     * Tenta carregar o arquivo da classe requisitada.
     * Chamado automaticamente pelo PHP.
     *
     * @param string $class Nome completo da classe com namespace.
     *                      Ex: PMPortfolio\Core\Theme
     */
    private function load(string $class): void
    {

        // Ignora classes que não pertencem a este tema
        if (! str_starts_with($class, $this->prefix)) {
            return;
        }

        // Remove o prefixo: PMPortfolio\Core\Theme → Core\Theme
        $relative = substr($class, strlen($this->prefix));

        // Converte namespace relativo em caminho de arquivo
        $file = $this->resolve($relative);

        // Carrega o arquivo se existir
        if (file_exists($file)) {
            require_once $file;
        }
    }

    /**
     * Converte namespace relativo em caminho absoluto de arquivo.
     *
     * Exemplos:
     *   Core\Theme      →  inc/core/class-theme.php
     *   SEO\Meta_Tags   →  inc/seo/class-meta-tags.php
     *   CPT\Portfolio   →  inc/cpt/class-portfolio.php
     *
     * @param  string $relative Namespace sem o prefixo PMPortfolio\
     * @return string           Caminho absoluto do arquivo
     */
    private function resolve(string $relative): string
    {

        // Separa as partes: ['Core', 'Theme'] ou ['SEO', 'Meta_Tags']
        $parts = explode('\\', $relative);

        // A última parte é o nome da classe
        $class_name = array_pop($parts);

        // As partes anteriores formam o subdiretório (em lowercase)
        $sub_dir = ! empty($parts)
            ? strtolower(implode(DIRECTORY_SEPARATOR, $parts)) . DIRECTORY_SEPARATOR
            : '';

        // Nome do arquivo: Meta_Tags → class-meta-tags.php
        $file_name = 'class-' . strtolower(
            str_replace('_', '-', $class_name)
        ) . '.php';

        return $this->base_dir . $sub_dir . $file_name;
    }
}
