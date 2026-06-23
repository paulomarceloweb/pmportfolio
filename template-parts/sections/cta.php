<?php

/**
 * PMPortfolio — CTA Section
 * @package PMPortfolio
 */

defined('ABSPATH') || exit;

use PMPortfolio\Multilingual\Language_Manager;
?>

<hr class="pm-hr m-0" aria-hidden="true">

<section style="background:var(--pm-bg1);border-top:1px solid var(--pm-b1);padding:5rem 0;text-align:center"
    aria-label="<?php echo esc_attr(Language_Manager::t('Contato', 'Contact')); ?>">
    <div class="container-xl">
        <div class="row justify-content-center">
            <div class="col-lg-6">

                <div class="pm-eyebrow mb-3 justify-content-center" id="cta-ey">
                    <?php echo esc_html(Language_Manager::t('vamos trabalhar juntos', "let's work together")); ?>
                </div>

                <h2 class="mb-3" style="font-size:clamp(1.6rem,2.5vw,2.2rem)" id="cta-h">
                    <?php if (Language_Manager::is('en')) : ?>
                        Have a project? <span style="color:var(--pm-gold)">Let's talk.</span>
                    <?php else : ?>
                        Tem um projeto? <span style="color:var(--pm-gold)">Vamos conversar.</span>
                    <?php endif; ?>
                </h2>

                <p class="mb-4" id="cta-p">
                    <?php echo esc_html(Language_Manager::t(
                        'Disponível para projetos freelance, consultorias e posições remotas. Respondo em até 24h.',
                        'Available for freelance projects, consulting and remote positions. I reply within 24h.'
                    )); ?>
                </p>

                <div class="d-flex gap-3 justify-content-center flex-wrap">
                    <a href="<?php echo esc_url(home_url(Language_Manager::is('en') ? '/en/contato/' : '/contato/')); ?>"
                        class="pm-btn-p" id="cta-b1">
                        <?php echo esc_html(Language_Manager::t('Enviar mensagem →', 'Send message →')); ?>
                    </a>
                    <a href="<?php echo esc_url(home_url(Language_Manager::is('en') ? '/en/portfolio/' : '/portfolio/')); ?>"
                        class="pm-btn-s" id="cta-b2">
                        <?php echo esc_html(Language_Manager::t('Ver portfólio', 'View portfolio')); ?>
                    </a>
                </div>

            </div>
        </div>
    </div>
</section>