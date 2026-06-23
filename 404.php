<?php

/**
 * PMPortfolio — 404
 *
 * Página de erro 404 — não encontrado.
 * Recebe noindex automático pelo SEO_Manager.
 *
 * @package PMPortfolio
 */

defined('ABSPATH') || exit;

use PMPortfolio\Multilingual\Language_Manager;

get_header();
?>

<main id="main-content" role="main">

	<div style="background:var(--pm-bg0);min-height:calc(100vh - 120px);display:flex;align-items:center">
		<div class="container-xl">
			<div class="row justify-content-center text-center">
				<div class="col-lg-6">

					<div style="font-family:var(--pm-fd);font-size:clamp(6rem,15vw,10rem);font-weight:800;line-height:1;color:var(--pm-bg2);margin-bottom:-.5rem" aria-hidden="true">
						404
					</div>

					<div class="pm-eyebrow mb-3 justify-content-center">
						<?php echo esc_html(Language_Manager::t('página não encontrada', 'page not found')); ?>
					</div>

					<h1 style="font-size:clamp(1.6rem,3vw,2.2rem);margin-bottom:1rem">
						<?php echo esc_html(Language_Manager::t('Esta página não existe', 'This page does not exist')); ?>
						<span style="color:var(--pm-gold)">
							<?php echo esc_html(Language_Manager::t('(ainda).', '(yet).')); ?>
						</span>
					</h1>

					<p style="font-size:15px;color:var(--pm-t2);font-weight:300;line-height:1.85;margin-bottom:2rem;max-width:42ch;margin-left:auto;margin-right:auto">
						<?php echo esc_html(Language_Manager::t(
							'A URL que você acessou não existe ou foi movida. Mas não se preocupe — o restante do site está funcionando perfeitamente.',
							"The URL you accessed doesn't exist or has been moved. Don't worry — the rest of the site is working perfectly."
						)); ?>
					</p>

					<div class="d-flex gap-3 justify-content-center flex-wrap">
						<a href="<?php echo esc_url(home_url(Language_Manager::is('en') ? '/en/' : '/')); ?>"
							class="pm-btn-p">
							<?php echo esc_html(Language_Manager::t('← Voltar para o início', '← Back to home')); ?>
						</a>
						<a href="<?php echo esc_url(home_url(Language_Manager::is('en') ? '/en/portfolio/' : '/portfolio/')); ?>"
							class="pm-btn-s">
							<?php echo esc_html(Language_Manager::t('Ver portfólio', 'View portfolio')); ?>
						</a>
					</div>

					<!-- Links rápidos -->
					<div class="mt-5" style="padding-top:2rem;border-top:1px solid var(--pm-b2)">
						<p style="font-family:var(--pm-fm);font-size:10px;color:var(--pm-t3);letter-spacing:.08em;text-transform:uppercase;margin-bottom:1rem">
							<?php echo esc_html(Language_Manager::t('ou explore', 'or explore')); ?>
						</p>
						<div class="d-flex gap-2 justify-content-center flex-wrap">
							<a href="<?php echo esc_url(home_url(Language_Manager::is('en') ? '/en/servicos/' : '/servicos/')); ?>"
								class="pm-btn-ghost">
								<?php echo esc_html(Language_Manager::t('serviços', 'services')); ?>
							</a>
							<a href="<?php echo esc_url(home_url(Language_Manager::is('en') ? '/en/sobre/' : '/sobre/')); ?>"
								class="pm-btn-ghost">
								<?php echo esc_html(Language_Manager::t('sobre', 'about')); ?>
							</a>
							<a href="<?php echo esc_url(home_url(Language_Manager::is('en') ? '/en/contato/' : '/contato/')); ?>"
								class="pm-btn-ghost">
								<?php echo esc_html(Language_Manager::t('contato', 'contact')); ?>
							</a>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>

</main>

<?php get_footer(); ?>