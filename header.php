<?php
// @package PMPortfolio

defined('ABSPATH') || exit;
?>
<?php
$lang_attr = \PMPortfolio\Multilingual\Language_Manager::is('en') ? 'en-US' : 'pt-BR';
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> data-theme="dark" data-bs-theme="dark" lang="<?php echo esc_attr($lang_attr); ?>">

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?php wp_head(); ?>

    <script>
        (function() {
            var saved = localStorage.getItem('pmportfolio-theme');
            var system = window.matchMedia('(prefers-color-scheme: dark)').matches ?
                'dark' :
                'light';
            var theme = saved || system;

            document.documentElement.dataset.theme = theme;
            document.documentElement.setAttribute('data-bs-theme', theme);
        })();
    </script>
</head>

<body <?php body_class(); ?>>

    <?php wp_body_open(); ?>

    <a class="pm-skip" href="#main-content">
        <?php esc_html_e('Ir para o conteúdo', 'pmportfolio'); ?>
    </a>

    <?php

    get_template_part('template-parts/components/navbar');
