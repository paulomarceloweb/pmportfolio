<?php

/**
 * PMPortfolio — Navbar Component
 *
 * Navegação principal do site.
 * Usa wp_nav_menu() com Walker Bootstrap 5 customizado.
 *
 * @package PMPortfolio
 */

defined('ABSPATH') || exit;
?>

<nav class="navbar navbar-expand-lg pm-navbar sticky-top"
    aria-label="<?php esc_attr_e('Navegação principal', 'pmportfolio'); ?>">
    <div class="container-xl">

        <!-- LOGO -->
        <a class="navbar-brand d-flex align-items-center gap-2"
            href="<?php echo esc_url(home_url('/')); ?>"
            aria-label="<?php echo esc_attr(get_bloginfo('name')); ?>">
            <div class="pm-logo-mark" aria-hidden="true">PM</div>
            <span class="pm-logo-text ms-2">
                <?php echo esc_html(get_bloginfo('name')); ?><span>.</span>
            </span>
        </a>

        <!-- TOGGLE MOBILE -->
        <button class="navbar-toggler border-0"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#pmNav"
            aria-controls="pmNav"
            aria-expanded="false"
            aria-label="<?php esc_attr_e('Abrir menu', 'pmportfolio'); ?>"
            style="color:var(--pm-t2)">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- MENU -->
        <div class="collapse navbar-collapse" id="pmNav">

            <?php
            wp_nav_menu([
                'theme_location' => 'primary',
                'menu_class'     => 'navbar-nav mx-auto gap-1',
                'container'      => false,
                'fallback_cb'    => false,
                'walker'         => new \PMPortfolio\Core\Nav_Walker(),
            ]);
            ?>

            <!-- AÇÕES: IDIOMA + TEMA -->
            <div class="d-flex align-items-center gap-2">

                <?php
                // Detecta idioma diretamente pela URL — não depende do hook wp
                $request_uri  = $_SERVER['REQUEST_URI'] ?? '/';
                $home_path    = rtrim(parse_url(home_url('/'), PHP_URL_PATH) ?? '/', '/');
                $relative     = '/' . ltrim(substr($request_uri, strlen($home_path)), '/');
                $relative     = strtok($relative, '?');
                $current_lang = str_starts_with($relative, '/en/') || $relative === '/en' ? 'en' : 'pt';

                if ($current_lang === 'en') {
                    $en_url = home_url($relative);
                    $pt_url = home_url(preg_replace('#^/en(/|$)#', '/', $relative));
                } else {
                    $pt_url = home_url($relative);
                    $en_url = home_url('/en' . $relative);
                }
                ?>

                <div class="pm-lang-wrap"
                    role="group"
                    aria-label="<?php esc_attr_e('Selecionar idioma', 'pmportfolio'); ?>">
                    <a class="pm-lang-btn <?php echo $current_lang === 'pt' ? 'on' : ''; ?>"
                        href="<?php echo esc_url($pt_url); ?>"
                        data-lang="pt"
                        aria-label="Português"
                        hreflang="pt-BR">PT</a>
                    <a class="pm-lang-btn <?php echo $current_lang === 'en' ? 'on' : ''; ?>"
                        href="<?php echo esc_url($en_url); ?>"
                        data-lang="en"
                        aria-label="English"
                        hreflang="en-US">EN</a>
                </div>

                <button class="pm-theme-btn"
                    id="pm-theme-btn"
                    onclick="pmToggleTheme()"
                    aria-label="<?php esc_attr_e('Alternar tema claro/escuro', 'pmportfolio'); ?>">
                    ☽
                </button>

            </div>
        </div>
    </div>
</nav>