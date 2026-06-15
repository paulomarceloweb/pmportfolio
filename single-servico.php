<?php
/**
 * PMPortfolio — Single Serviço
 *
 * Página individual de um serviço do CPT 'servico'.
 * URL: /servicos/nome-do-servico/
 *
 * @package PMPortfolio
 */

defined( 'ABSPATH' ) || exit;

get_header();

if ( ! have_posts() ) { get_footer(); return; }
the_post();

$preco     = get_post_meta( get_the_ID(), '_servico_preco',            true );
$prazo     = get_post_meta( get_the_ID(), '_servico_prazo',            true );
$desc      = get_post_meta( get_the_ID(), '_servico_descricao_curta',  true ) ?: get_the_excerpt();
$bens      = get_post_meta( get_the_ID(), '_servico_beneficios',       true );
$cta_text  = get_post_meta( get_the_ID(), '_servico_cta_texto',        true ) ?: __( 'Solicitar orçamento →', 'pmportfolio' );
$cta_url   = get_post_meta( get_the_ID(), '_servico_cta_url',          true ) ?: home_url( '/contato/' );
$bens_arr  = $bens ? array_filter( array_map( 'trim', explode( "\n", $bens ) ) ) : [];
?>

<main id="main-content" role="main">

	<!-- BREADCRUMB -->
	<div class="pm-bc">
		<div class="container-xl d-flex align-items-center">
			<a class="pm-bc-link" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'início', 'pmportfolio' ); ?></a>
			<span class="pm-bc-sep">/</span>
			<a class="pm-bc-link" href="<?php echo esc_url( get_post_type_archive_link( 'servico' ) ); ?>"><?php esc_html_e( 'serviços', 'pmportfolio' ); ?></a>
			<span class="pm-bc-sep">/</span>
			<span class="pm-bc-cur"><?php the_title(); ?></span>
		</div>
	</div>

	<!-- HERO -->
	<div style="background:var(--pm-bg0);padding:3.5rem 0 3rem;border-bottom:1px solid var(--pm-b2);position:relative;overflow:hidden">
		<div class="pm-hero-grid" aria-hidden="true"></div>
		<div class="pm-hero-orb" aria-hidden="true"></div>
		<div class="container-xl position-relative" style="z-index:1">
			<div class="row align-items-center g-4">
				<div class="col-lg-8">
					<h1 style="font-size:clamp(1.8rem,3.5vw,3rem);line-height:1.1;margin-bottom:1rem"><?php the_title(); ?></h1>
					<?php if ( $desc ) : ?>
					<p style="font-size:15px;max-width:54ch;line-height:1.85;color:var(--pm-t2);font-weight:300"><?php echo esc_html( $desc ); ?></p>
					<?php endif; ?>
				</div>
				<div class="col-lg-4 d-none d-lg-flex flex-column align-items-end gap-2">
					<a href="<?php echo esc_url( $cta_url ); ?>" class="pm-btn-p"><?php echo esc_html( $cta_text ); ?></a>
				</div>
			</div>
		</div>
	</div>

	<!-- CONTEÚDO + SIDEBAR -->
	<div style="background:var(--pm-bg0);padding:3rem 0 5rem">
		<div class="container-xl">
			<div class="row g-5">

				<!-- CONTEÚDO -->
				<div class="col-lg-8">

					<?php if ( ! empty( $bens_arr ) ) : ?>
					<div style="padding:0 0 2rem;border-bottom:1px solid var(--pm-b2);margin-bottom:2rem">
						<div style="font-family:var(--pm-fm);font-size:10px;color:var(--pm-gold);letter-spacing:.1em;text-transform:uppercase;margin-bottom:.75rem">// <?php esc_html_e( 'o que está incluso', 'pmportfolio' ); ?></div>
						<div style="display:grid;grid-template-columns:1fr 1fr;gap:.5rem">
							<?php foreach ( $bens_arr as $b ) : ?>
							<div style="display:flex;align-items:flex-start;gap:8px;font-size:13px;color:var(--pm-t2);font-weight:300;line-height:1.5">
								<span style="color:var(--pm-teal);font-family:var(--pm-fm);font-size:11px;flex-shrink:0;margin-top:1px">✓</span>
								<?php echo esc_html( $b ); ?>
							</div>
							<?php endforeach; ?>
						</div>
					</div>
					<?php endif; ?>

					<?php if ( get_the_content() ) : ?>
					<div class="pm-art-content">
						<?php the_content(); ?>
					</div>
					<?php endif; ?>

				</div>

				<!-- SIDEBAR -->
				<div class="col-lg-4">
					<div style="position:sticky;top:72px;display:flex;flex-direction:column;gap:1.25rem">

						<!-- PREÇO -->
						<div style="background:var(--pm-bgc);border:1px solid var(--pm-b1);border-radius:var(--pm-rl);overflow:hidden;position:relative">
							<div style="content:'';position:absolute;top:0;left:0;right:0;height:2px;background:linear-gradient(90deg,transparent,var(--pm-gold),transparent)"></div>
							<div style="padding:1.25rem 1.5rem;background:var(--pm-bg2);border-bottom:1px solid var(--pm-b2);text-align:center">
								<?php if ( $preco ) : ?>
								<div style="font-family:var(--pm-fm);font-size:10px;color:var(--pm-t3);letter-spacing:.06em;text-transform:uppercase;margin-bottom:.3rem"><?php esc_html_e( 'a partir de', 'pmportfolio' ); ?></div>
								<div style="font-family:var(--pm-fd);font-size:2.2rem;font-weight:800;color:var(--pm-gold);line-height:1"><?php echo esc_html( $preco ); ?></div>
								<?php endif; ?>
								<?php if ( $prazo ) : ?>
								<div style="font-family:var(--pm-fm);font-size:10px;color:var(--pm-t3);letter-spacing:.04em;margin-top:.3rem"><?php echo esc_html( $prazo ); ?></div>
								<?php endif; ?>
							</div>
							<div style="padding:1.25rem 1.5rem">
								<a href="<?php echo esc_url( $cta_url ); ?>" class="pm-btn-p w-100 justify-content-center" style="font-size:12px"><?php echo esc_html( $cta_text ); ?></a>
								<div style="background:var(--pm-goldm);border:1px solid var(--pm-goldb);border-radius:var(--pm-r);padding:.75rem 1rem;display:flex;align-items:center;gap:8px;margin-top:1rem">
									<span style="font-size:16px">🛡️</span>
									<p style="font-family:var(--pm-fm);font-size:10px;color:var(--pm-t2);letter-spacing:.03em;line-height:1.5;margin:0">
										<strong style="color:var(--pm-t1)"><?php esc_html_e( 'Garantia:', 'pmportfolio' ); ?></strong>
										<?php esc_html_e( 'Lighthouse mínimo 90/100 ou refaço sem custo.', 'pmportfolio' ); ?>
									</p>
								</div>
							</div>
						</div>

					</div>
				</div>

			</div>
		</div>
	</div>

</main>

<?php get_footer(); ?>