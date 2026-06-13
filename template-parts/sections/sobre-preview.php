<?php

/**
 * PMPortfolio — Sobre Preview Section
 *
 * Resumo da página sobre na home.
 * Foto, bio curta, skills e CTA para a página completa.
 *
 * @package PMPortfolio
 */

defined('ABSPATH') || exit;
?>

<hr class="pm-hr m-0" aria-hidden="true">

<section style="background:var(--pm-bg0);padding:5rem 0"
    id="sobre"
    aria-label="<?php esc_attr_e('Sobre mim', 'pmportfolio'); ?>">
    <div class="container-xl">
        <div class="row align-items-center g-5">

            <!-- FOTO -->
            <div class="col-lg-5 d-none d-lg-block">
                <div class="position-relative">
                    <div class="pm-sobre-img">
                        <span style="font-family:var(--pm-fm);font-size:10px;color:var(--pm-t3);letter-spacing:.08em;text-transform:uppercase">
                            <?php esc_html_e('foto do perfil', 'pmportfolio'); ?>
                        </span>
                    </div>
                    <div class="pm-sobre-badge position-absolute" style="bottom:-1rem;right:-1rem">
                        <div style="font-family:var(--pm-fd);font-size:1.5rem;font-weight:800;color:var(--pm-t1);line-height:1">
                            8<span style="color:var(--pm-gold)">+</span>
                        </div>
                        <div style="font-family:var(--pm-fm);font-size:9px;color:var(--pm-t3);letter-spacing:.06em;text-transform:uppercase;margin-top:2px" id="sp-badge">
                            <?php esc_html_e('anos de código', 'pmportfolio'); ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TEXTO -->
            <div class="col-lg-7">

                <div class="pm-eyebrow mb-3" id="sp-ey">
                    <?php esc_html_e('sobre mim', 'pmportfolio'); ?>
                </div>

                <h2 class="mb-3" style="font-size:clamp(1.8rem,3vw,2.4rem)" id="sp-h">
                    <?php esc_html_e('Engenheiro que ', 'pmportfolio'); ?>
                    <span style="color:var(--pm-gold)">
                        <?php esc_html_e('pensa em sistemas', 'pmportfolio'); ?>
                    </span>
                </h2>

                <p class="mb-3" id="sp-p1">
                    <?php esc_html_e('Trabalho na interseção entre arquitetura técnica robusta e produto que as pessoas realmente usam. Não entrego apenas código — entrego soluções que escalam.', 'pmportfolio'); ?>
                </p>

                <p class="mb-4" id="sp-p2">
                    <?php esc_html_e('Com foco em WordPress, PHP 8 e ecosistema moderno, construo desde temas premium performáticos até APIs e integrações complexas.', 'pmportfolio'); ?>
                </p>

                <!-- Skills -->
                <div class="d-flex flex-wrap gap-2 mb-4">
                    <?php
                    $skills = ['PHP 8.2', 'WordPress', 'MySQL', 'JavaScript ES6+', 'Bootstrap 5', 'REST API', 'Git', 'SEO Técnico'];
                    foreach ($skills as $skill) :
                    ?>
                        <span class="pm-stag"><?php echo esc_html($skill); ?></span>
                    <?php endforeach; ?>
                </div>

                <a href="<?php echo esc_url(home_url('/sobre/')); ?>"
                    class="pm-btn-p"
                    id="sp-btn">
                    <?php esc_html_e('Conhecer minha história →', 'pmportfolio'); ?>
                </a>

            </div>
        </div>
    </div>
</section>