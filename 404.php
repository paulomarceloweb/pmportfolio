<?php
/**
 * PMPortfolio — 404
 *
 * Página de erro 404 — não encontrado.
 * Recebe noindex automático pelo SEO_Manager.
 *
 * @package PMPortfolio
 */

defined( 'ABSPATH' ) || exit;

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
						<?php esc_html_e( 'página não encontrada', 'pmportfolio' ); ?>
					</div>

					<h1 style="font-size:clamp(1.6rem,3vw,2.2rem);margin-bottom:1rem">
						<?php esc_html_e( 'Esta página não existe', 'pmportfolio' ); ?>
						<span style="color:var(--pm-gold)"> <?php esc_html_e( '(ainda).', 'pmportfolio' ); ?></span>
					</h1>

					<p style="font-size:15px;color:var(--pm-t2);font-weight:300;line-height:1.85;margin-bottom:2rem;max-width:42ch;margin-left:auto;margin-right:auto">
						<?php esc_html_e( 'A URL que você acessou não existe ou foi movida. Mas não se preocupe — o restante do site está funcionando perfeitamente.', 'pmportfolio' ); ?>
					</p>

					<div class="d-flex gap-3 justify-content-center flex-wrap">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="pm-btn-p">
							<?php esc_html_e( '← Voltar para o início', 'pmportfolio' ); ?>
						</a>
						<a href="<?php echo esc_url( home_url( '/portfolio/' ) ); ?>" class="pm-btn-s">
							<?php esc_html_e( 'Ver portfólio', 'pmportfolio' ); ?>
						</a>
					</div>

					<!-- Links rápidos -->
					<div class="mt-5" style="padding-top:2rem;border-top:1px solid var(--pm-b2)">
						<p style="font-family:var(--pm-fm);font-size:10px;color:var(--pm-t3);letter-spacing:.08em;text-transform:uppercase;margin-bottom:1rem">
							<?php esc_html_e( 'ou explore', 'pmportfolio' ); ?>
						</p>
						<div class="d-flex gap-2 justify-content-center flex-wrap">
							<a href="<?php echo esc_url( home_url( '/servicos/' ) ); ?>" class="pm-btn-ghost"><?php esc_html_e( 'serviços', 'pmportfolio' ); ?></a>
							<a href="<?php echo esc_url( home_url( '/sobre/' ) ); ?>" class="pm-btn-ghost"><?php esc_html_e( 'sobre', 'pmportfolio' ); ?></a>
							<a href="<?php echo esc_url( home_url( '/contato/' ) ); ?>" class="pm-btn-ghost"><?php esc_html_e( 'contato', 'pmportfolio' ); ?></a>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>

</main>

<?php get_footer(); ?>