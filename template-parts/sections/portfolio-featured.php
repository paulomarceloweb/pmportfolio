<?php

/**
 * PMPortfolio — Portfolio Featured Section
 *
 * Exibe os 3 projetos marcados como "em destaque" na home.
 * Busca do CPT 'portfolio' via WP_Query.
 *
 * @package PMPortfolio
 */

defined('ABSPATH') || exit;

use PMPortfolio\Multilingual\Language_Manager;

// Busca projetos em destaque
$query = new WP_Query([
	'post_type'      => 'portfolio',
	'posts_per_page' => 3,
	'post_status'    => 'publish',
	'meta_query'     => [
		[
			'key'   => '_portfolio_em_destaque',
			'value' => '1',
		],
	],
	'no_found_rows'  => true,
]);

// Fallback: 3 mais recentes
if (! $query->have_posts()) {
	$query = new WP_Query([
		'post_type'      => 'portfolio',
		'posts_per_page' => 3,
		'post_status'    => 'publish',
		'no_found_rows'  => true,
	]);
}

if (! $query->have_posts()) {
	return;
}

$symbols = ['{ }', '</>', '⬡'];
$colors  = ['var(--pm-gold)', 'var(--pm-teal)', 'var(--pm-purple)'];
$i       = 0;
?>

<hr class="pm-hr m-0" aria-hidden="true">

<section style="background:var(--pm-bg0);border-top:1px solid var(--pm-b2);padding:5rem 0"
	id="portfolio"
	aria-label="<?php echo esc_attr(Language_Manager::t('Portfólio', 'Portfolio')); ?>">
	<div class="container-xl">

		<div class="d-flex align-items-end justify-content-between flex-wrap gap-3 mb-5">
			<div>
				<div class="pm-eyebrow mb-2" id="pt-ey">
					<?php echo esc_html(Language_Manager::t('portfólio', 'portfolio')); ?>
				</div>
				<h2 style="font-size:clamp(1.8rem,3vw,2.4rem)" id="pt-h">
					<?php if (Language_Manager::is('en')) : ?>
						Featured <span style="color:var(--pm-gold)">projects</span>
					<?php else : ?>
						Projetos <span style="color:var(--pm-gold)">em destaque</span>
					<?php endif; ?>
				</h2>
			</div>
		</div>

		<div class="row g-4">
			<?php while ($query->have_posts()) : $query->the_post(); ?>

				<?php
				$cliente    = get_post_meta(get_the_ID(), '_portfolio_cliente', true);
				$stack      = get_post_meta(get_the_ID(), '_portfolio_stack', true);
				$desc       = get_post_meta(get_the_ID(), '_portfolio_descricao_curta', true);
				$url        = get_post_meta(get_the_ID(), '_portfolio_url', true);

				if (! $desc) {
					$desc = get_the_excerpt();
				}

				$stack_tags = $stack
					? array_map('trim', explode(',', $stack))
					: [];

				$symbol = $symbols[$i] ?? '{ }';
				$color  = $colors[$i]  ?? 'var(--pm-gold)';
				$i++;
				?>

				<div class="col-md-4">
					<div class="pm-port-card"
						style="background:var(--pm-bgc);border:1px solid var(--pm-b2);border-radius:var(--pm-rl);overflow:hidden;transition:all .25s;cursor:pointer;height:100%"
						onclick="window.location='<?php echo esc_url(get_permalink()); ?>'">

						<!-- THUMBNAIL -->
						<div style="aspect-ratio:16/9;background:linear-gradient(135deg,var(--pm-bg2),var(--pm-bg3));position:relative;display:flex;align-items:center;justify-content:center;overflow:hidden">

							<?php if (has_post_thumbnail()) : ?>
								<?php the_post_thumbnail('pm-portfolio', [
									'style'    => 'width:100%;height:100%;object-fit:cover;position:absolute;inset:0',
									'loading'  => 'lazy',
									'decoding' => 'async',
									'alt'      => esc_attr(get_the_title()),
								]); ?>
							<?php else : ?>
								<div style="display:flex;flex-direction:column;align-items:center;gap:8px">
									<span style="font-family:var(--pm-fm);font-size:2rem;color:<?php echo esc_attr($color); ?>;opacity:.5">
										<?php echo esc_html($symbol); ?>
									</span>
									<?php if ($cliente) : ?>
										<span style="font-family:var(--pm-fm);font-size:9px;color:var(--pm-t3);letter-spacing:.08em;text-transform:uppercase">
											<?php echo esc_html($cliente); ?>
										</span>
									<?php endif; ?>
								</div>
							<?php endif; ?>

							<!-- OVERLAY -->
							<div style="position:absolute;inset:0;background:rgba(10,10,15,.7);display:flex;align-items:center;justify-content:center;opacity:0;transition:opacity .25s"
								class="pm-port-overlay">
								<span style="padding:8px 20px;background:var(--pm-gold);color:var(--pm-tinv);font-family:var(--pm-fd);font-size:12px;font-weight:700;border-radius:var(--pm-r)">
									<?php echo esc_html(Language_Manager::t('ver case study →', 'view case study →')); ?>
								</span>
							</div>

						</div>

						<!-- BODY -->
						<div style="padding:1.1rem 1.25rem">

							<?php if ($cliente) : ?>
								<div style="font-family:var(--pm-fm);font-size:10px;color:var(--pm-t3);letter-spacing:.05em;margin-bottom:.3rem">
									// <?php echo esc_html($cliente); ?>
								</div>
							<?php endif; ?>

							<div style="font-family:var(--pm-fd);font-size:14px;font-weight:700;color:var(--pm-t1);letter-spacing:-.01em;line-height:1.3;margin-bottom:.4rem">
								<?php the_title(); ?>
							</div>

							<?php if ($desc) : ?>
								<p style="font-size:12px;color:var(--pm-t2);font-weight:300;line-height:1.65;margin-bottom:.75rem">
									<?php echo esc_html($desc); ?>
								</p>
							<?php endif; ?>

							<?php if (! empty($stack_tags)) : ?>
								<div style="display:flex;flex-wrap:wrap;gap:4px">
									<?php foreach (array_slice($stack_tags, 0, 4) as $tag_item) : ?>
										<span style="padding:2px 7px;background:var(--pm-bg2);border-radius:3px;font-family:var(--pm-fm);font-size:9px;color:var(--pm-t3)">
											<?php echo esc_html($tag_item); ?>
										</span>
									<?php endforeach; ?>
								</div>
							<?php endif; ?>

							<a href="<?php echo esc_url(get_permalink()); ?>"
								style="display:inline-flex;align-items:center;gap:4px;font-family:var(--pm-fm);font-size:10px;color:var(--pm-gold);letter-spacing:.04em;margin-top:.75rem;transition:gap .15s;text-decoration:none">
								<?php echo esc_html(Language_Manager::t('ver projeto →', 'view project →')); ?>
							</a>

						</div>
					</div>
				</div>

			<?php endwhile;
			wp_reset_postdata(); ?>
		</div>

		<div class="text-center mt-5">
			<a href="<?php echo esc_url(get_post_type_archive_link('portfolio')); ?>"
				class="pm-btn-s"
				id="pt-more">
				<?php echo esc_html(Language_Manager::t('Ver todos os projetos →', 'View all projects →')); ?>
			</a>
		</div>

	</div>
</section>

<style>
	.pm-port-card:hover {
		border-color: var(--pm-b1) !important;
		transform: translateY(-4px);
	}

	.pm-port-card:hover .pm-port-overlay {
		opacity: 1 !important;
	}
</style>