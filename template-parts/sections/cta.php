<?php

/**
 * PMPortfolio — CTA Section
 *
 * Call to action global da home.
 * Convida o visitante a entrar em contato.
 *
 * @package PMPortfolio
 */

defined('ABSPATH') || exit;
?>

<hr class="pm-hr m-0" aria-hidden="true">

<section style="background:var(--pm-bg1);border-top:1px solid var(--pm-b1);padding:5rem 0"
    id="contato"
    aria-label="<?php esc_attr_e('Contato', 'pmportfolio'); ?>">
    <div class="container-xl">
        <div class="row justify-content-center text-center">
            <div class="col-lg-7">

                <div class="pm-eyebrow mb-3 justify-content-center" id="cta-ey">
                    <?php esc_html_e('vamos trabalhar juntos', 'pmportfolio'); ?>
                </div>

                <h2 class="mb-3" style="font-size:clamp(1.8rem,3vw,2.6rem)" id="cta-h">
                    <?php esc_html_e('Tem um projeto? ', 'pmportfolio'); ?>
                    <span style="color:var(--pm-gold)">
                        <?php esc_html_e('Vamos conversar.', 'pmportfolio'); ?>
                    </span>
                </h2>

                <p class="mb-4" id="cta-p">
                    <?php esc_html_e('Estou disponível para projetos freelance, consultorias e posições em produto. Respondo em até 24h.', 'pmportfolio'); ?>
                </p>

                <div class="d-flex flex-wrap gap-3 justify-content-center">
                    <a href="<?php echo esc_url(home_url('/contato/')); ?>"
                        class="pm-btn-p"
                        id="cta-b1">
                        <?php esc_html_e('Enviar mensagem →', 'pmportfolio'); ?>
                    </a>
                    <a href="<?php echo esc_url(home_url('/portfolio/')); ?>"
                        class="pm-btn-s"
                        id="cta-b2">
                        <?php esc_html_e('Ver portfólio', 'pmportfolio'); ?>
                    </a>
                </div>

            </div>
        </div>
    </div>
</section>