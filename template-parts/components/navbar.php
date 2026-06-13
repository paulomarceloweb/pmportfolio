<?php

/**
 * PMPortfolio — Navbar Component
 *
 * Navegação principal do site.
 * Incluída via get_template_part() no header.php.
 *
 * @package PMPortfolio
 */

defined('ABSPATH') || exit;


?>

<a class="pm-skip-nav" href="#main-content" tabindex="1">
    <?php esc_html_e('Pular navegação', 'pmportfolio'); ?>
</a>

<nav class="navbar navbar-expand-lg pm-navbar sticky-top"
    aria-label="<?php esc_attr_e('Navegação principal', 'pmportfolio'); ?>">
    <div class="container-xl">

        <!-- LOGO -->
        <a class="navbar-brand d-flex align-items-center gap-2"
            href="<?php echo esc_url(home_url('/')); ?>"
            aria-label="<?php echo esc_attr(get_bloginfo('name')); ?> — <?php esc_attr_e('Início', 'pmportfolio'); ?>">
            <div class="pm-logo-mark" aria-hidden="true">PM</div>
            <span class="pm-logo-text">
                dev<span>.</span>portfolio
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
            <ul class="navbar-nav mx-auto gap-1" role="list">
                <li class="nav-item">
                    <a class="nav-link <?php echo is_front_page() ? 'active' : ''; ?>"
                        href="<?php echo esc_url(home_url('/')); ?>"
                        <?php echo is_front_page() ? 'aria-current="page"' : ''; ?>>
                        <?php esc_html_e('início', 'pmportfolio'); ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo is_home() || is_singular('post') || is_category() ? 'active' : ''; ?>"
                        href="<?php echo esc_url(home_url('/blog/')); ?>"
                        <?php echo is_home() ? 'aria-current="page"' : ''; ?>>
                        <?php esc_html_e('blog', 'pmportfolio'); ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo is_post_type_archive('servico') || is_singular('servico') ? 'active' : ''; ?>"
                        href="<?php echo esc_url(home_url('/servicos/')); ?>"
                        <?php echo is_post_type_archive('servico') ? 'aria-current="page"' : ''; ?>>
                        <?php esc_html_e('serviços', 'pmportfolio'); ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo is_post_type_archive('portfolio') || is_singular('portfolio') ? 'active' : ''; ?>"
                        href="<?php echo esc_url(home_url('/portfolio/')); ?>"
                        <?php echo is_post_type_archive('portfolio') ? 'aria-current="page"' : ''; ?>>
                        <?php esc_html_e('portfólio', 'pmportfolio'); ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo is_page('sobre') || is_page('about') ? 'active' : ''; ?>"
                        href="<?php echo esc_url(home_url('/sobre/')); ?>"
                        <?php echo is_page('sobre') ? 'aria-current="page"' : ''; ?>>
                        <?php esc_html_e('sobre', 'pmportfolio'); ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo is_page('contato') || is_page('contact') ? 'active' : ''; ?>"
                        href="<?php echo esc_url(home_url('/contato/')); ?>"
                        <?php echo is_page('contato') ? 'aria-current="page"' : ''; ?>>
                        <?php esc_html_e('contato', 'pmportfolio'); ?>
                    </a>
                </li>
            </ul>

            <!-- AÇÕES: IDIOMA + TEMA -->
            <div class="d-flex align-items-center gap-2">

                <!-- SELETOR DE IDIOMA -->
                <div class="pm-lang-wrap"
                    role="group"
                    aria-label="<?php esc_attr_e('Selecionar idioma', 'pmportfolio'); ?>">
                    <button class="pm-lang-btn on"
                        data-lang="pt"
                        onclick="pmSetLang('pt')"
                        aria-label="Português">
                        PT
                    </button>
                    <button class="pm-lang-btn"
                        data-lang="en"
                        onclick="pmSetLang('en')"
                        aria-label="English">
                        EN
                    </button>
                </div>

                <!-- TOGGLE DARK/LIGHT MODE -->
                <button class="pm-theme-btn"
                    id="pm-theme-btn"
                    onclick="pmToggleTheme()"
                    aria-label="<?php esc_attr_e('Alternar tema claro/escuro', 'pmportfolio'); ?>"
                    aria-pressed="true">
                    ☽
                </button>

            </div>
        </div>
    </div>
</nav>