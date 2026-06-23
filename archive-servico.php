<?php

/**
 * PMPortfolio — Archive Serviço
 * URL: /servicos/
 * @package PMPortfolio
 */

defined('ABSPATH') || exit;

use PMPortfolio\Multilingual\Language_Manager;

get_header();
?>

<main id="main-content" role="main">

	<!-- BREADCRUMB -->
	<div class="pm-bc">
		<div class="container-xl d-flex align-items-center">
			<a class="pm-bc-link" href="<?php echo esc_url(home_url('/')); ?>">
				<?php echo esc_html(Language_Manager::t('início', 'home')); ?>
			</a>
			<span class="pm-bc-sep">/</span>
			<span class="pm-bc-cur"><?php echo esc_html(Language_Manager::t('serviços', 'services')); ?></span>
		</div>
	</div>

	<!-- HERO -->
	<div style="background:var(--pm-bg0);padding:3.5rem 0 2.5rem;border-bottom:1px solid var(--pm-b2)">
		<div class="container-xl">
			<div class="pm-eyebrow mb-2">
				<?php echo esc_html(Language_Manager::t('serviços', 'services')); ?>
			</div>
			<h1 class="mb-3" style="font-size:clamp(2rem,3.5vw,2.8rem)">
				<?php if (Language_Manager::is('en')) : ?>
					Solutions that <span style="color:var(--pm-gold)">actually work</span>
				<?php else : ?>
					Soluções que <span style="color:var(--pm-gold)">resolvem de verdade</span>
				<?php endif; ?>
			</h1>
			<p style="font-size:14px;max-width:52ch;color:var(--pm-t2);font-weight:300">
				<?php echo esc_html(Language_Manager::t(
					'Cada serviço foi desenhado para entregar resultado mensurável — não apenas código.',
					'Every service is designed to deliver measurable results — not just code.'
				)); ?>
			</p>
		</div>
	</div>

	<!-- GRID -->
	<div style="background:var(--pm-bg0);padding:3rem 0 5rem">
		<div class="container-xl">

			<?php if (have_posts()) : ?>

				<div class="row g-4">
					<?php
					$icons        = ['🏗️', '⚡', '📈', '🔍', '🛡️', '💡'];
					$icon_classes = ['pm-sv-icon-gold', 'pm-sv-icon-teal', 'pm-sv-icon-purple', 'pm-sv-icon-gold', 'pm-sv-icon-teal', 'pm-sv-icon-purple'];
					$idx = 0;
					while (have_posts()) : the_post();
						$preco    = get_post_meta(get_the_ID(), '_servico_preco', true);
						$prazo    = get_post_meta(get_the_ID(), '_servico_prazo', true);
						$desc     = get_post_meta(get_the_ID(), '_servico_descricao_curta', true) ?: get_the_excerpt();
						$bens     = get_post_meta(get_the_ID(), '_servico_beneficios', true);
						$bens_arr = $bens ? array_filter(array_map('trim', explode("\n", $bens))) : [];
						$icon       = $icons[$idx % count($icons)];
						$icon_class = $icon_classes[$idx % count($icon_classes)];
						$idx++;
					?>
						<div class="col-md-6 col-lg-4">
							<div style="background:var(--pm-bgc);border:1px solid var(--pm-b2);border-radius:var(--pm-rl);padding:2rem;height:100%;display:flex;flex-direction:column;transition:all .28s;cursor:pointer"
								onclick="window.location='<?php echo esc_url(get_permalink()); ?>'">

								<div class="<?php echo esc_attr($icon_class); ?>"
									style="width:44px;height:44px;border-radius:var(--pm-r);display:flex;align-items:center;justify-content:center;font-size:20px;margin-bottom:1.25rem;flex-shrink:0">
									<?php echo $icon; // phpcs:ignore 
									?>
								</div>

								<div style="font-family:var(--pm-fd);font-size:16px;font-weight:700;color:var(--pm-t1);letter-spacing:-.01em;margin-bottom:.5rem">
									<?php the_title(); ?>
								</div>

								<?php if ($desc) : ?>
									<p style="font-size:13px;color:var(--pm-t2);font-weight:300;line-height:1.75;margin-bottom:1rem;flex:1">
										<?php echo esc_html($desc); ?>
									</p>
								<?php endif; ?>

								<?php if (! empty($bens_arr)) : ?>
									<div style="display:flex;flex-direction:column;gap:.4rem;margin-bottom:1.25rem">
										<?php foreach (array_slice($bens_arr, 0, 4) as $b) : ?>
											<div style="display:flex;align-items:flex-start;gap:8px;font-size:12px;color:var(--pm-t2);font-weight:300;line-height:1.5">
												<span style="color:var(--pm-gold);font-family:var(--pm-fm);font-size:10px;flex-shrink:0;margin-top:2px">✓</span>
												<?php echo esc_html($b); ?>
											</div>
										<?php endforeach; ?>
									</div>
								<?php endif; ?>

								<div style="padding-top:1.25rem;border-top:1px solid var(--pm-b2);display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:.5rem;margin-top:auto">
									<div>
										<?php if ($preco) : ?>
											<div style="font-family:var(--pm-fm);font-size:10px;color:var(--pm-t3);letter-spacing:.04em">
												<?php echo esc_html($preco); ?>
											</div>
										<?php endif; ?>
										<?php if ($prazo) : ?>
											<div style="font-family:var(--pm-fm);font-size:9px;color:var(--pm-t3);letter-spacing:.04em;margin-top:2px">
												<?php echo esc_html($prazo); ?>
											</div>
										<?php endif; ?>
									</div>
									<a href="<?php echo esc_url(get_permalink()); ?>"
										style="font-family:var(--pm-fm);font-size:10px;color:var(--pm-gold);letter-spacing:.04em;text-decoration:none">
										<?php echo esc_html(Language_Manager::t('ver detalhes →', 'see details →')); ?>
									</a>
								</div>

							</div>
						</div>
					<?php endwhile; ?>
				</div>

			<?php else : ?>
				<p style="color:var(--pm-t3);font-family:var(--pm-fm);font-size:12px;text-align:center;padding:3rem 0">
					<?php echo esc_html(Language_Manager::t('Nenhum serviço encontrado.', 'No services found.')); ?>
				</p>
			<?php endif; ?>

		</div>
	</div>

</main>

<style>
	div[onclick]:hover {
		border-color: var(--pm-b1) !important;
		transform: translateY(-4px);
	}
</style>

<?php get_footer(); ?>