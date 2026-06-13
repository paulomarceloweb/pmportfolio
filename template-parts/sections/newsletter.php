<?php

/**
 * PMPortfolio — Newsletter Section
 *
 * Formulário de inscrição na newsletter via Mailchimp.
 * A integração real com Mailchimp será feita via wp_ajax.
 *
 * @package PMPortfolio
 */

defined('ABSPATH') || exit;
?>

<hr class="pm-hr m-0" aria-hidden="true">

<section style="background:var(--pm-bg0);border-top:1px solid var(--pm-b2);padding:4rem 0"
    aria-label="<?php esc_attr_e('Newsletter', 'pmportfolio'); ?>">
    <div class="container-xl">
        <div class="row justify-content-center text-center">
            <div class="col-lg-6">

                <div class="pm-eyebrow mb-3 justify-content-center" id="mc-ey">
                    <?php esc_html_e('newsletter', 'pmportfolio'); ?>
                </div>

                <h3 class="mb-2" style="font-size:1.4rem" id="mc-h">
                    <?php esc_html_e('Conteúdo técnico na sua caixa de entrada', 'pmportfolio'); ?>
                </h3>

                <p class="mb-4" id="mc-p">
                    <?php esc_html_e('PHP avançado, WordPress internals, performance — sem spam, sem papo furado.', 'pmportfolio'); ?>
                </p>

                <div class="d-flex gap-2 justify-content-center" style="max-width:460px;margin:0 auto" id="mc-wrap">
                    <input type="email"
                        class="pm-mc-input"
                        id="mc-email"
                        placeholder="<?php esc_attr_e('seu@email.com', 'pmportfolio'); ?>"
                        aria-label="<?php esc_attr_e('Seu e-mail', 'pmportfolio'); ?>">
                    <button class="pm-btn-p"
                        onclick="pmMcSubmit('mc-email','mc-wrap','mc-ok')"
                        id="mc-btn"
                        style="padding:10px 20px">
                        <?php esc_html_e('Inscrever', 'pmportfolio'); ?>
                    </button>
                </div>

                <p style="font-family:var(--pm-fm);font-size:10px;color:var(--pm-t3);margin-top:.75rem;letter-spacing:.03em" id="mc-note">
                    <?php esc_html_e('✦ sem spam · cancele quando quiser · via Mailchimp', 'pmportfolio'); ?>
                </p>

                <p id="mc-ok"
                    style="display:none;font-family:var(--pm-fm);font-size:12px;color:var(--pm-teal);margin-top:.5rem"
                    role="status"
                    aria-live="polite">
                </p>

            </div>
        </div>
    </div>
</section>