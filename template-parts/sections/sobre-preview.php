<?php

/**
 * PMPortfolio — Sobre Preview Section
 * @package PMPortfolio
 */

defined('ABSPATH') || exit;

use PMPortfolio\Admin\Settings_API;
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

                    <?php $avatar = Settings_API::get('avatar'); ?>

                    <div style="width:100%;aspect-ratio:3/4;background:var(--pm-bg2);border:1px solid var(--pm-b1);border-radius:var(--pm-rl);overflow:hidden;display:flex;align-items:center;justify-content:center">
                        <?php if ($avatar) : ?>
                            <img src="<?php echo esc_url($avatar); ?>"
                                alt="Paulo Marcelo Gonçalves"
                                style="width:100%;height:100%;object-fit:cover;display:block"
                                loading="lazy"
                                decoding="async">
                        <?php else : ?>
                            <span style="font-family:var(--pm-fm);font-size:10px;color:var(--pm-t3);letter-spacing:.08em;text-transform:uppercase">
                                foto do perfil
                            </span>
                        <?php endif; ?>
                    </div>

                    <!-- Badge -->
                    <div style="position:absolute;bottom:-1rem;right:-1rem;background:var(--pm-bgc);border:1px solid var(--pm-b1);border-radius:var(--pm-rl);padding:.9rem 1.1rem">
                        <div style="font-family:var(--pm-fd);font-size:1.5rem;font-weight:800;color:var(--pm-t1);line-height:1">
                            5<span style="color:var(--pm-gold)">+</span>
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
                    Desenvolvedor que
                    <span style="color:var(--pm-gold)">une código e resultado</span>
                </h2>

                <p class="mb-3" id="sp-p1">
                    Sou um WordPress Developer Full-Stack com uma combinação rara: escrevo código limpo e escalável <strong>e</strong> entendo o que gera conversão.
                </p>

                <p class="mb-4" id="sp-p2">
                    Liderando a tecnologia de marketing do <strong>Grupo Motta</strong> — 10+ empresas, 50+ filiais — com PHP 8, Vite e OOP.
                </p>

                <!-- Skills -->
                <div class="d-flex flex-wrap gap-2 mb-4">
                    <?php
                    $skills = ['PHP 8', 'WordPress', 'Vite 5', 'JavaScript ES6+', 'GTM', 'Meta Ads', 'Google Ads', 'SEO Técnico'];
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