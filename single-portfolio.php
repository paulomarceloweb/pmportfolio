<?php
/**
 * PMPortfolio — Single Portfolio (Case Study)
 *
 * Página individual de um projeto do CPT 'portfolio'.
 * URL: /portfolio/nome-do-projeto/
 *
 * @package PMPortfolio
 */

defined( 'ABSPATH' ) || exit;

get_header();

if ( ! have_posts() ) {
	get_footer();
	return;
}

the_post();

// Meta fields do projeto
$cliente    = get_post_meta( get_the_ID(), '_portfolio_cliente',         true );
$url        = get_post_meta( get_the_ID(), '_portfolio_url',             true );
$stack      = get_post_meta( get_the_ID(), '_portfolio_stack',           true );
$desc       = get_post_meta( get_the_ID(), '_portfolio_descricao_curta', true ) ?: get_the_excerpt();
$desafio    = get_post_meta( get_the_ID(), '_portfolio_desafio',         true );
$solucao    = get_post_meta( get_the_ID(), '_portfolio_solucao',         true );
$resultados = get_post_meta( get_the_ID(), '_portfolio_resultados',      true );

$stack_tags = $stack
	? array_map( 'trim', explode( ',', $stack ) )
	: [];
?>

<main id="main-content" role="main">

	<!-- BREADCRUMB -->
	<div class="pm-bc">
		<div class="container-xl d-flex align-items-center">
			<a class="pm-bc-link" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'início', 'pmportfolio' ); ?></a>
			<span class="pm-bc-sep">/</span>
			<a class="pm-bc-link" href="<?php echo esc_url( get_post_type_archive_link( 'portfolio' ) ); ?>"><?php esc_html_e( 'portfólio', 'pmportfolio' ); ?></a>
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
					<h1 style="font-size:clamp(1.8rem,3.5vw,3rem);line-height:1.1;margin-bottom:1rem">
						<?php the_title(); ?>
					</h1>
					<?php if ( $desc ) : ?>
					<p style="font-size:15px;max-width:54ch;line-height:1.85;color:var(--pm-t2);font-weight:300">
						<?php echo esc_html( $desc ); ?>
					</p>
					<?php endif; ?>
					<?php if ( $cliente ) : ?>
					<div class="d-flex align-items-center gap-3 mt-3">
						<span style="display:inline-flex;align-items:center;gap:8px;padding:5px 14px;background:var(--pm-bg2);border:1px solid var(--pm-b2);border-radius:20px;font-family:var(--pm-fm);font-size:10px;color:var(--pm-t2);letter-spacing:.05em">
							<?php esc_html_e( 'cliente:', 'pmportfolio' ); ?>&nbsp;<strong style="color:var(--pm-t1)"><?php echo esc_html( $cliente ); ?></strong>
						</span>
						<span style="font-family:var(--pm-fm);font-size:10px;color:var(--pm-t3);letter-spacing:.05em">
							<?php echo get_the_date( 'Y' ); ?>
						</span>
					</div>
					<?php endif; ?>
				</div>
				<?php if ( $url ) : ?>
				<div class="col-lg-4 d-none d-lg-flex justify-content-end">
					<a href="<?php echo esc_url( $url ); ?>" class="pm-btn-p" target="_blank" rel="noopener noreferrer">
						<?php esc_html_e( 'Ver site ao vivo ↗', 'pmportfolio' ); ?>
					</a>
				</div>
				<?php endif; ?>
			</div>
		</div>
	</div>

	<!-- IMAGEM PRINCIPAL -->
	<?php if ( has_post_thumbnail() ) : ?>
	<div style="background:var(--pm-bg1);border-bottom:1px solid var(--pm-b2);padding:2.5rem 0">
		<div class="container-xl">
			<div style="border-radius:var(--pm-rl);overflow:hidden;border:1px solid var(--pm-b2)">
				<?php the_post_thumbnail( 'pm-hero', [
					'style'    => 'width:100%;height:auto;display:block',
					'loading'  => 'eager',
					'decoding' => 'async',
					'alt'      => esc_attr( get_the_title() ),
				] ); ?>
			</div>
		</div>
	</div>
	<?php endif; ?>

	<!-- CONTEÚDO + SIDEBAR -->
	<div style="background:var(--pm-bg0);padding:3rem 0 5rem">
		<div class="container-xl">
			<div class="row g-5">

				<!-- CONTEÚDO PRINCIPAL -->
				<div class="col-lg-8">

					<?php if ( $desafio ) : ?>
					<div style="padding:2rem 0;border-bottom:1px solid var(--pm-b2)">
						<div style="font-family:var(--pm-fm);font-size:10px;color:var(--pm-gold);letter-spacing:.1em;text-transform:uppercase;margin-bottom:.5rem">// <?php esc_html_e( 'o desafio', 'pmportfolio' ); ?></div>
						<div style="font-size:15px;line-height:1.85;color:var(--pm-t2);font-weight:300"><?php echo nl2br( esc_html( $desafio ) ); ?></div>
					</div>
					<?php endif; ?>

					<?php if ( $solucao ) : ?>
					<div style="padding:2rem 0;border-bottom:1px solid var(--pm-b2)">
						<div style="font-family:var(--pm-fm);font-size:10px;color:var(--pm-gold);letter-spacing:.1em;text-transform:uppercase;margin-bottom:.5rem">// <?php esc_html_e( 'a solução', 'pmportfolio' ); ?></div>
						<div style="font-size:15px;line-height:1.85;color:var(--pm-t2);font-weight:300"><?php echo nl2br( esc_html( $solucao ) ); ?></div>
					</div>
					<?php endif; ?>

					<?php if ( $resultados ) : ?>
					<div style="padding:2rem 0;border-bottom:1px solid var(--pm-b2)">
						<div style="font-family:var(--pm-fm);font-size:10px;color:var(--pm-gold);letter-spacing:.1em;text-transform:uppercase;margin-bottom:.5rem">// <?php esc_html_e( 'resultados', 'pmportfolio' ); ?></div>
						<div style="font-size:15px;line-height:1.85;color:var(--pm-t2);font-weight:300"><?php echo nl2br( esc_html( $resultados ) ); ?></div>
					</div>
					<?php endif; ?>

					<?php if ( get_the_content() ) : ?>
					<div style="padding:2rem 0" class="pm-art-content">
						<?php the_content(); ?>
					</div>
					<?php endif; ?>

				</div>

				<!-- SIDEBAR -->
				<div class="col-lg-4">
					<div style="position:sticky;top:72px">
						<div style="background:var(--pm-bgc);border:1px solid var(--pm-b2);border-radius:var(--pm-rl);overflow:hidden">
							<div style="padding:.85rem 1.1rem;border-bottom:1px solid var(--pm-b2);background:var(--pm-bg2)">
								<span style="font-family:var(--pm-fd);font-size:12px;font-weight:700;color:var(--pm-t1)"><?php esc_html_e( 'detalhes do projeto', 'pmportfolio' ); ?></span>
							</div>
							<div style="padding:1rem 1.1rem">

								<?php if ( $cliente ) : ?>
								<div style="display:flex;flex-direction:column;gap:2px;padding:.6rem 0;border-bottom:1px solid var(--pm-b3)">
									<span style="font-family:var(--pm-fm);font-size:9px;color:var(--pm-t3);letter-spacing:.07em;text-transform:uppercase"><?php esc_html_e( 'cliente', 'pmportfolio' ); ?></span>
									<span style="font-size:13px;color:var(--pm-t1)"><?php echo esc_html( $cliente ); ?></span>
								</div>
								<?php endif; ?>

								<div style="display:flex;flex-direction:column;gap:2px;padding:.6rem 0;border-bottom:1px solid var(--pm-b3)">
									<span style="font-family:var(--pm-fm);font-size:9px;color:var(--pm-t3);letter-spacing:.07em;text-transform:uppercase"><?php esc_html_e( 'ano', 'pmportfolio' ); ?></span>
									<span style="font-size:13px;color:var(--pm-t1)"><?php echo esc_html( get_the_date( 'Y' ) ); ?></span>
								</div>

								<?php if ( ! empty( $stack_tags ) ) : ?>
								<div style="display:flex;flex-direction:column;gap:6px;padding:.6rem 0;border-bottom:1px solid var(--pm-b3)">
									<span style="font-family:var(--pm-fm);font-size:9px;color:var(--pm-t3);letter-spacing:.07em;text-transform:uppercase"><?php esc_html_e( 'stack', 'pmportfolio' ); ?></span>
									<div style="display:flex;flex-wrap:wrap;gap:4px">
										<?php foreach ( $stack_tags as $t ) : ?>
											<span style="padding:3px 8px;background:var(--pm-bg2);border:1px solid var(--pm-b2);border-radius:3px;font-family:var(--pm-fm);font-size:10px;color:var(--pm-t2)"><?php echo esc_html( $t ); ?></span>
										<?php endforeach; ?>
									</div>
								</div>
								<?php endif; ?>

								<?php if ( $url ) : ?>
								<div style="padding:.6rem 0">
									<a href="<?php echo esc_url( $url ); ?>" class="pm-btn-p w-100 justify-content-center" target="_blank" rel="noopener noreferrer" style="font-size:12px">
										<?php esc_html_e( 'Ver site ao vivo ↗', 'pmportfolio' ); ?>
									</a>
								</div>
								<?php endif; ?>

							</div>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>

</main>

<?php get_footer(); ?>