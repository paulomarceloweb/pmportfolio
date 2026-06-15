<?php
/**
 * PMPortfolio — Serviços Featured Section
 *
 * Exibe os 3 serviços marcados como "em destaque" na home.
 * Busca do CPT 'servico' via WP_Query.
 *
 * @package PMPortfolio
 */

defined( 'ABSPATH' ) || exit;

// Busca serviços em destaque
$query = new WP_Query( [
	'post_type'      => 'servico',
	'posts_per_page' => 3,
	'post_status'    => 'publish',
	'meta_query'     => [
		[
			'key'   => '_servico_em_destaque',
			'value' => '1',
		],
	],
	'no_found_rows'  => true, // performance: não conta total de posts
] );

// Se não tiver em destaque, busca os 3 mais recentes
if ( ! $query->have_posts() ) {
	$query = new WP_Query( [
		'post_type'      => 'servico',
		'posts_per_page' => 3,
		'post_status'    => 'publish',
		'no_found_rows'  => true,
	] );
}

if ( ! $query->have_posts() ) {
	return; // nenhum serviço cadastrado — não renderiza a seção
}

// Ícones por posição
$icons = [ '🏗️', '⚡', '🔌' ];
$icon_classes = [ 'pm-sv-icon-gold', 'pm-sv-icon-teal', 'pm-sv-icon-purple' ];
$i = 0;
?>

<hr class="pm-hr m-0" aria-hidden="true">

<section style="background:var(--pm-bg1);border-top:1px solid var(--pm-b2);padding:5rem 0"
         id="servicos"
         aria-label="<?php esc_attr_e( 'Serviços', 'pmportfolio' ); ?>">
	<div class="container-xl">

		<div class="row mb-5">
			<div class="col-lg-6">
				<div class="pm-eyebrow mb-3" id="sv-ey">
					<?php esc_html_e( 'serviços', 'pmportfolio' ); ?>
				</div>
				<h2 style="font-size:clamp(1.8rem,3vw,2.4rem)" id="sv-h">
					<?php esc_html_e( 'O que posso ', 'pmportfolio' ); ?>
					<span style="color:var(--pm-gold)">
						<?php esc_html_e( 'fazer por você', 'pmportfolio' ); ?>
					</span>
				</h2>
			</div>
		</div>

		<div class="row g-4">
			<?php while ( $query->have_posts() ) : $query->the_post(); ?>

				<?php
				$preco = get_post_meta( get_the_ID(), '_servico_preco', true );
				$prazo = get_post_meta( get_the_ID(), '_servico_prazo', true );
				$desc  = get_post_meta( get_the_ID(), '_servico_descricao_curta', true );

				// Fallback para o excerpt se não tiver descrição curta
				if ( ! $desc ) {
					$desc = get_the_excerpt();
				}

				$icon       = $icons[ $i ]        ?? '⚙️';
				$icon_class = $icon_classes[ $i ]  ?? 'pm-sv-icon-gold';
				$i++;
				?>

			<div class="col-md-4">
				<div class="pm-srv-card" style="background:var(--pm-bgc);border:1px solid var(--pm-b2);border-radius:var(--pm-rl);padding:1.75rem;height:100%;transition:all .25s;display:flex;flex-direction:column">

					<div class="pm-srv-icon <?php echo esc_attr( $icon_class ); ?>"
					     style="width:40px;height:40px;border-radius:var(--pm-r);display:flex;align-items:center;justify-content:center;font-size:18px;margin-bottom:1.25rem">
						<?php echo $icon; // phpcs:ignore — emoji, sem XSS ?>
					</div>

					<div style="font-family:var(--pm-fd);font-size:16px;font-weight:700;color:var(--pm-t1);letter-spacing:-.01em;margin-bottom:.5rem">
						<?php the_title(); ?>
					</div>

					<?php if ( $desc ) : ?>
					<p style="font-size:13px;color:var(--pm-t2);font-weight:300;line-height:1.75;margin-bottom:1rem;flex:1">
						<?php echo esc_html( $desc ); ?>
					</p>
					<?php endif; ?>

					<?php if ( $preco || $prazo ) : ?>
					<div style="padding-top:1rem;border-top:1px solid var(--pm-b2);margin-top:auto">
						<?php if ( $preco ) : ?>
						<div style="font-family:var(--pm-fm);font-size:10px;color:var(--pm-t3);letter-spacing:.05em">
							<?php echo esc_html( $preco ); ?>
						</div>
						<?php endif; ?>
						<?php if ( $prazo ) : ?>
						<div style="font-family:var(--pm-fm);font-size:9px;color:var(--pm-t3);letter-spacing:.04em;margin-top:2px">
							<?php echo esc_html( $prazo ); ?>
						</div>
						<?php endif; ?>
					</div>
					<?php endif; ?>

					<a href="<?php echo esc_url( get_permalink() ); ?>"
					   style="display:inline-flex;align-items:center;gap:4px;font-family:var(--pm-fm);font-size:10px;color:var(--pm-gold);letter-spacing:.04em;margin-top:1rem;transition:gap .15s;text-decoration:none">
						<?php esc_html_e( 'ver detalhes →', 'pmportfolio' ); ?>
					</a>

				</div>
			</div>

			<?php endwhile; wp_reset_postdata(); ?>
		</div>

		<div class="text-center mt-5">
			<a href="<?php echo esc_url( get_post_type_archive_link( 'servico' ) ); ?>"
			   class="pm-btn-s">
				<?php esc_html_e( 'Ver todos os serviços →', 'pmportfolio' ); ?>
			</a>
		</div>

	</div>
</section>