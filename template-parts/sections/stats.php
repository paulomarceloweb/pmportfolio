<?php

/**
 * PMPortfolio — Stats Section
 *
 * Faixa com números de credibilidade.
 * Fica logo abaixo do hero.
 *
 * @package PMPortfolio
 */

defined('ABSPATH') || exit;
?>

<hr class="pm-hr m-0" aria-hidden="true">

<section class="pm-sec-stats py-5"
    aria-label="<?php esc_attr_e('Números', 'pmportfolio'); ?>">
    <div class="container-xl">
        <div class="pm-stats-grid">
            <div class="row g-0">

                <div class="col-6 col-md-3 pm-stat-item">
                    <div class="pm-stat-lbl2">// <?php esc_html_e('projetos', 'pmportfolio'); ?></div>
                    <div class="pm-stat-big">47<em>+</em></div>
                    <div class="pm-stat-desc" id="st1">
                        <?php esc_html_e('entregues com sucesso', 'pmportfolio'); ?>
                    </div>
                </div>

                <div class="col-6 col-md-3 pm-stat-item">
                    <div class="pm-stat-lbl2">// <?php esc_html_e('experiência', 'pmportfolio'); ?></div>
                    <div class="pm-stat-big">8<em>+</em></div>
                    <div class="pm-stat-desc" id="st2">
                        <?php esc_html_e('anos de desenvolvimento', 'pmportfolio'); ?>
                    </div>
                </div>

                <div class="col-6 col-md-3 pm-stat-item">
                    <div class="pm-stat-lbl2">// <?php esc_html_e('clientes', 'pmportfolio'); ?></div>
                    <div class="pm-stat-big">32<em>+</em></div>
                    <div class="pm-stat-desc" id="st3">
                        <?php esc_html_e('em 4 países', 'pmportfolio'); ?>
                    </div>
                </div>

                <div class="col-6 col-md-3 pm-stat-item">
                    <div class="pm-stat-lbl2">// <?php esc_html_e('performance', 'pmportfolio'); ?></div>
                    <div class="pm-stat-big">98<em>/100</em></div>
                    <div class="pm-stat-desc" id="st4">
                        <?php esc_html_e('score PageSpeed', 'pmportfolio'); ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>