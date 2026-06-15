<?php
/**
 * PMPortfolio — Archive Portfolio
 *
 * Lista todos os projetos do CPT 'portfolio'.
 * URL: /portfolio/
 *
 * @package PMPortfolio
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<main id="main-content" role="main">

	<!-- BREADCRUMB -->
	<div class="pm-bc">
		<div class="container-xl d-flex align-items-center">
			<a class="pm-bc-link" href="<?php echo esc_url( home_url( '/' ) ); ?>">
				<?php esc_html_e( 'início', 'pmportfolio' ); ?>
			</a>
			<span class="pm-bc-sep">/</span>
			<span class="pm-bc-cur">
				<?php esc_html_e( 'portfólio', 'pmportfolio' ); ?>
			</span>
		</div>
	</div>

	<!-- HERO -->
	<div class="pm-pf-hero" style="background:var(--pm-bg0);padding:3.5rem 0 2.5rem;border-bottom:1px solid var(--pm-b2)">
		<div class="container-xl">
			<div class="row align-items-end g-4">
				<div class="col-lg-7">
					<div class="pm-eyebrow mb-2">
						<?php esc_html_e( 'portfólio', 'pmportfolio' ); ?>
					</div>
					<h1 class="mb-2" style="font-size:clamp(2rem,3.5vw,2.8rem)">
						<?php esc_html_e( 'Projetos que ', 'pmportfolio' ); ?>
						<span style="color:var(--pm-gold)">
							<?php esc_html_e( 'entregam resultado', 'pmportfolio' ); ?>
						</span>
					</h1>
					<p style="font-size:14px;max-width:54ch;color:var(--pm-t2);font-weight:300">
						<?php esc_html_e( 'Do briefing ao deploy — sistemas que escalam, convertem e se mantêm.', 'pmportfolio' ); ?>
					</p>
				</div>
				<div class="col-lg-5 d-none d-lg-flex justify-content-end align-items-end gap-3 pb-1">
					<div style="text-align:center">
						<div style="font-family:var(--pm-fd);font-size:1.8rem;font-weight:800;color:var(--pm-t1);line-height:1">47<span style="color:var(--pm-gold)">+</span></div>
						<div style="font-family:var(--pm-fm);font-size:9px;color:var(--pm-t3);letter-spacing:.08em;text-transform:uppercase"><?php esc_html_e( 'projetos', 'pmportfolio' ); ?></div>
					</div>
					<div style="width:1px;height:32px;background:var(--pm-b2)"></div>
					<div style="text-align:center">
						<div style="font-family:var(--pm-fd);font-size:1.8rem;font-weight:800;color:var(--pm-t1);line-height:1">8<span style="color:var(--pm-gold)">+</span></div>
						<div style="font-family:var(--pm-fm);font-size:9px;color:var(--pm-t3);letter-spacing:.08em;text-transform:uppercase"><?php esc_html_e( 'anos', 'pmportfolio' ); ?></div>
					</div>
					<div style="width:1px;height:32px;background:var(--pm-b2)"></div>
					<div style="text-align:center">
						<div style="font-family:var(--pm-fd);font-size:1.8rem;font-weight:800;color:var(--pm-t1);line-height:1">32<span style="color:var(--pm-gold)">+</span></div>
						<div style="font-family:var(--pm-fm);font-size:9px;color:var(--pm-t3);letter-spacing:.08em;text-transform:uppercase"><?php esc_html_e( 'clientes', 'pmportfolio' ); ?></div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- GRID DE PROJETOS -->
	<div style="background:var(--pm-bg0);padding:3rem 0 5rem">
		<div class="container-xl">

			<?php if ( have_posts() ) : ?>

				<div class="row g-4">
					<?php
					$symbols = [ '{ }', '</>', '⬡', '◎', '⬢', '⊞' ];
					$colors  = [ 'var(--pm-gold)', 'var(--pm-teal)', 'var(--pm-purple)', 'var(--pm-gold)', 'var(--pm-teal)', 'var(--pm-purple)' ];
					$idx = 0;
					while ( have_posts() ) : the_post();
						$cliente = get_post_meta( get_the_ID(), '_portfolio_cliente', true );
						$stack   = get_post_meta( get_the_ID(), '_portfolio_stack', true );
						$desc    = get_post_meta( get_the_ID(), '_portfolio_descricao_curta', true ) ?: get_the_excerpt();
						$stack_tags = $stack ? array_map( 'trim', explode( ',', $stack ) ) : [];
						$symbol  = $symbols[ $idx % count( $symbols ) ];
						$color   = $colors[ $idx % count( $colors ) ];
						$idx++;
					?>
					<div class="col-md-6 col-lg-4">
						<div class="pm-port-card"
						     style="background:var(--pm-bgc);border:1px solid var(--pm-b2);border-radius:var(--pm-rl);overflow:hidden;transition:all .25s;cursor:pointer;height:100%"
						     onclick="window.location='<?php echo esc_url( get_permalink() ); ?>'">

							<div style="aspect-ratio:16/9;background:linear-gradient(135deg,var(--pm-bg2),var(--pm-bg3));position:relative;display:flex;align-items:center;justify-content:center;overflow:hidden">
								<?php if ( has_post_thumbnail() ) : ?>
									<?php the_post_thumbnail( 'pm-portfolio', [
										'style'    => 'width:100%;height:100%;object-fit:cover;position:absolute;inset:0',
										'loading'  => 'lazy',
										'decoding' => 'async',
										'alt'      => esc_attr( get_the_title() ),
									] ); ?>
								<?php else : ?>
									<span style="font-family:var(--pm-fm);font-size:2rem;color:<?php echo esc_attr( $color ); ?>;opacity:.5"><?php echo esc_html( $symbol ); ?></span>
								<?php endif; ?>
								<div class="pm-port-overlay" style="position:absolute;inset:0;background:rgba(10,10,15,.7);display:flex;align-items:center;justify-content:center;opacity:0;transition:opacity .25s">
									<span style="padding:8px 20px;background:var(--pm-gold);color:var(--pm-tinv);font-family:var(--pm-fd);font-size:12px;font-weight:700;border-radius:var(--pm-r)"><?php esc_html_e( 'ver case study →', 'pmportfolio' ); ?></span>
								</div>
							</div>

							<div style="padding:1.1rem 1.25rem">
								<?php if ( $cliente ) : ?>
								<div style="font-family:var(--pm-fm);font-size:10px;color:var(--pm-t3);letter-spacing:.05em;margin-bottom:.3rem">// <?php echo esc_html( $cliente ); ?></div>
								<?php endif; ?>
								<div style="font-family:var(--pm-fd);font-size:14px;font-weight:700;color:var(--pm-t1);letter-spacing:-.01em;line-height:1.3;margin-bottom:.4rem"><?php the_title(); ?></div>
								<?php if ( $desc ) : ?>
								<p style="font-size:12px;color:var(--pm-t2);font-weight:300;line-height:1.65;margin-bottom:.75rem"><?php echo esc_html( $desc ); ?></p>
								<?php endif; ?>
								<?php if ( ! empty( $stack_tags ) ) : ?>
								<div style="display:flex;flex-wrap:wrap;gap:4px">
									<?php foreach ( array_slice( $stack_tags, 0, 4 ) as $t ) : ?>
										<span style="padding:2px 7px;background:var(--pm-bg2);border-radius:3px;font-family:var(--pm-fm);font-size:9px;color:var(--pm-t3)"><?php echo esc_html( $t ); ?></span>
									<?php endforeach; ?>
								</div>
								<?php endif; ?>
								<a href="<?php echo esc_url( get_permalink() ); ?>" style="display:inline-flex;align-items:center;gap:4px;font-family:var(--pm-fm);font-size:10px;color:var(--pm-gold);letter-spacing:.04em;margin-top:.75rem;text-decoration:none"><?php esc_html_e( 'ver projeto →', 'pmportfolio' ); ?></a>
							</div>
						</div>
					</div>
					<?php endwhile; ?>
				</div>

				<!-- PAGINAÇÃO -->
				<div class="d-flex justify-content-center mt-5">
					<?php
					the_posts_pagination( [
						'mid_size'  => 2,
						'prev_text' => '← ' . __( 'anterior', 'pmportfolio' ),
						'next_text' => __( 'próxima', 'pmportfolio' ) . ' →',
					] );
					?>
				</div>

			<?php else : ?>

				<div class="text-center py-5">
					<p style="color:var(--pm-t3);font-family:var(--pm-fm);font-size:12px;letter-spacing:.06em">
						<?php esc_html_e( 'Nenhum projeto encontrado.', 'pmportfolio' ); ?>
					</p>
				</div>

			<?php endif; ?>

		</div>
	</div>

</main>

<style>
.pm-port-card:hover { border-color:var(--pm-b1)!important; transform:translateY(-4px); }
.pm-port-card:hover .pm-port-overlay { opacity:1!important; }
</style>

<?php get_footer(); ?>