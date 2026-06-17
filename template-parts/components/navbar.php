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

                <div class="pm-lang-wrap"
                    role="group"
                    aria-label="<?php esc_attr_e('Selecionar idioma', 'pmportfolio'); ?>">
                    <button class="pm-lang-btn on"
                        data-lang="pt"
                        onclick="pmSetLang('pt')"
                        aria-label="Português">PT</button>
                    <button class="pm-lang-btn"
                        data-lang="en"
                        onclick="pmSetLang('en')"
                        aria-label="English">EN</button>
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