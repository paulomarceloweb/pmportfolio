<?php

/**
 * PMPortfolio — Newsletter Section
 * @package PMPortfolio
 */

defined('ABSPATH') || exit;

use PMPortfolio\Multilingual\Language_Manager;
?>

<section style="background:var(--pm-bg0);border-top:1px solid var(--pm-b2);padding:4rem 0"
    aria-label="<?php echo esc_attr(Language_Manager::t('Newsletter', 'Newsletter')); ?>">
    <div class="container-xl">
        <div class="row justify-content-center">
            <div class="col-lg-6 text-center">

                <div class="pm-eyebrow mb-2 justify-content-center" id="mc-ey">
                    <?php echo esc_html(Language_Manager::t('newsletter', 'newsletter')); ?>
                </div>

                <h2 class="mb-2" style="font-size:clamp(1.4rem,2vw,1.8rem)" id="mc-h">
                    <?php echo esc_html(Language_Manager::t(
                        'Conteúdo técnico na sua caixa de entrada',
                        'Technical content in your inbox'
                    )); ?>
                </h2>

                <p class="mb-4" style="font-size:13px;color:var(--pm-t2);font-weight:300" id="mc-p">
                    <?php echo esc_html(Language_Manager::t(
                        'WordPress, PHP 8, performance e marketing tech — sem spam, sem enrolação.',
                        'WordPress, PHP 8, performance and marketing tech — no spam, no fluff.'
                    )); ?>
                </p>

                <div id="mc-wrap" style="display:flex;gap:.5rem;max-width:420px;margin:0 auto">
                    <input type="email"
                        id="mc-email"
                        class="pm-mc-input"
                        placeholder="<?php echo esc_attr(Language_Manager::t('seu@email.com', 'your@email.com')); ?>">
                    <button class="pm-btn-p"
                        onclick="pmMcSubmit('mc-email','mc-wrap','mc-ok')"
                        id="mc-btn">
                        <?php echo esc_html(Language_Manager::t('Inscrever', 'Subscribe')); ?>
                    </button>
                </div>

                <p id="mc-ok" style="display:none;font-family:var(--pm-fm);font-size:11px;color:var(--pm-teal);margin-top:8px"></p>

                <p style="font-family:var(--pm-fm);font-size:10px;color:var(--pm-t3);letter-spacing:.04em;margin-top:1rem" id="mc-note">
                    <?php echo esc_html(Language_Manager::t(
                        '✦ sem spam · cancele quando quiser · via Mailchimp',
                        '✦ no spam · unsubscribe anytime · via Mailchimp'
                    )); ?>
                </p>

            </div>
        </div>
    </div>
</section>