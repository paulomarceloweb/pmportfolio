<?php

/**
 * PMPortfolio — Stats Section
 * @package PMPortfolio
 */

defined('ABSPATH') || exit;

use PMPortfolio\Multilingual\Language_Manager;
?>

<hr class="pm-hr m-0" aria-hidden="true">

<section style="background:var(--pm-bg1);border-top:1px solid var(--pm-b2);border-bottom:1px solid var(--pm-b2);padding:3rem 0"
	aria-label="<?php echo esc_attr(Language_Manager::t('Números', 'Numbers')); ?>">
	<div class="container-xl">
		<div class="pm-stats-grid">
			<div class="row g-0">

				<div class="col-6 col-md-3 pm-stat-item">
					<div class="pm-stat-lbl2">// <?php echo esc_html(Language_Manager::t('empresas', 'companies')); ?></div>
					<div class="pm-stat-big">10<em>+</em></div>
					<div class="pm-stat-desc" id="st1"><?php echo esc_html(Language_Manager::t('no Grupo Motta', 'in Grupo Motta')); ?></div>
				</div>

				<div class="col-6 col-md-3 pm-stat-item">
					<div class="pm-stat-lbl2">// <?php echo esc_html(Language_Manager::t('experiência', 'experience')); ?></div>
					<div class="pm-stat-big">5<em>+</em></div>
					<div class="pm-stat-desc" id="st2"><?php echo esc_html(Language_Manager::t('anos com WordPress', 'years with WordPress')); ?></div>
				</div>

				<div class="col-6 col-md-3 pm-stat-item">
					<div class="pm-stat-lbl2">// <?php echo esc_html(Language_Manager::t('filiais', 'branches')); ?></div>
					<div class="pm-stat-big">50<em>+</em></div>
					<div class="pm-stat-desc" id="st3"><?php echo esc_html(Language_Manager::t('atendidas', 'locations served')); ?></div>
				</div>

				<div class="col-6 col-md-3 pm-stat-item">
					<div class="pm-stat-lbl2">// <?php echo esc_html(Language_Manager::t('performance', 'performance')); ?></div>
					<div class="pm-stat-big">98<em>/100</em></div>
					<div class="pm-stat-desc" id="st4"><?php echo esc_html(Language_Manager::t('score PageSpeed', 'PageSpeed score')); ?></div>
				</div>

			</div>
		</div>
	</div>
</section>