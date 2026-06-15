<?php
/**
 * PMPortfolio — Page Sobre
 *
 * Template da página Sobre.
 * URL: /sobre/
 *
 * Para usar: crie uma página no WordPress com slug 'sobre'
 * e este template será aplicado automaticamente.
 *
 * @package PMPortfolio
 */

defined( 'ABSPATH' ) || exit;

use PMPortfolio\Admin\Settings_API;

get_header();

$avatar  = Settings_API::get( 'avatar' );
$email   = Settings_API::get( 'email' );
$contato = home_url( '/contato/' );
?>

<main id="main-content" role="main">

	<!-- BREADCRUMB -->
	<div class="pm-bc">
		<div class="container-xl d-flex align-items-center">
			<a class="pm-bc-link" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'início', 'pmportfolio' ); ?></a>
			<span class="pm-bc-sep">/</span>
			<span class="pm-bc-cur"><?php esc_html_e( 'sobre', 'pmportfolio' ); ?></span>
		</div>
	</div>

	<!-- HERO -->
	<div class="pm-sobre-hero" style="background:var(--pm-bg0);padding:4rem 0 3rem;border-bottom:1px solid var(--pm-b2);position:relative;overflow:hidden">
		<div class="pm-hero-grid" aria-hidden="true"></div>
		<div class="pm-hero-orb" aria-hidden="true"></div>
		<div class="container-xl position-relative" style="z-index:1">
			<div class="row align-items-center g-5">

				<!-- FOTO -->
				<div class="col-lg-4 d-none d-lg-block">
					<div class="position-relative">
						<div style="width:100%;aspect-ratio:3/4;background:var(--pm-bg2);border:1px solid var(--pm-b1);border-radius:var(--pm-rl);overflow:hidden;display:flex;align-items:center;justify-content:center">
							<?php if ( $avatar ) : ?>
								<img src="<?php echo esc_url( $avatar ); ?>"
								     alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>"
								     style="width:100%;height:100%;object-fit:cover"
								     loading="eager"
								     decoding="async">
							<?php else : ?>
								<span style="font-family:var(--pm-fm);font-size:10px;color:var(--pm-t3);letter-spacing:.08em;text-transform:uppercase">
									<?php esc_html_e( 'foto do perfil', 'pmportfolio' ); ?>
								</span>
							<?php endif; ?>
						</div>
						<!-- Badge anos -->
						<div style="position:absolute;bottom:-1rem;right:-1rem;background:var(--pm-bgc);border:1px solid var(--pm-b1);border-radius:var(--pm-rl);padding:.9rem 1.1rem">
							<div style="font-family:var(--pm-fd);font-size:1.5rem;font-weight:800;color:var(--pm-t1);line-height:1">
								8<span style="color:var(--pm-gold)">+</span>
							</div>
							<div style="font-family:var(--pm-fm);font-size:9px;color:var(--pm-t3);letter-spacing:.06em;text-transform:uppercase;margin-top:2px">
								<?php esc_html_e( 'anos de código', 'pmportfolio' ); ?>
							</div>
						</div>
					</div>
				</div>

				<!-- TEXTO -->
				<div class="col-lg-8">
					<div class="pm-eyebrow mb-2"><?php esc_html_e( 'sobre mim', 'pmportfolio' ); ?></div>
					<h1 style="font-size:clamp(2rem,3.5vw,3rem);line-height:1.1;margin-bottom:1rem">
						<?php esc_html_e( 'Engenheiro que ', 'pmportfolio' ); ?>
						<span style="color:var(--pm-gold)"><?php esc_html_e( 'pensa em sistemas', 'pmportfolio' ); ?></span>
					</h1>
					<p style="font-size:15px;line-height:1.85;max-width:58ch;margin-bottom:1.5rem;color:var(--pm-t2);font-weight:300">
						<?php esc_html_e( 'Trabalho na interseção entre arquitetura técnica robusta e produto que as pessoas realmente usam. Não entrego apenas código — entrego soluções que escalam.', 'pmportfolio' ); ?>
					</p>
					<p style="font-size:15px;line-height:1.85;max-width:58ch;margin-bottom:2rem;color:var(--pm-t2);font-weight:300">
						<?php esc_html_e( 'Com foco em WordPress, PHP 8 e ecosistema moderno, construo desde temas premium performáticos até APIs e integrações complexas.', 'pmportfolio' ); ?>
					</p>
					<!-- Status disponível -->
					<div class="d-flex align-items-center gap-2 mb-3">
						<span class="pm-dot-live"></span>
						<span style="font-family:var(--pm-fm);font-size:10px;color:var(--pm-t3);letter-spacing:.06em">
							<?php esc_html_e( 'disponível para novos projetos', 'pmportfolio' ); ?>
						</span>
					</div>
					<div class="d-flex gap-2 flex-wrap">
						<a href="#" class="pm-btn-p"><?php esc_html_e( 'Baixar currículo →', 'pmportfolio' ); ?></a>
						<a href="<?php echo esc_url( $contato ); ?>" class="pm-btn-s"><?php esc_html_e( 'Entrar em contato', 'pmportfolio' ); ?></a>
					</div>
				</div>

			</div>
		</div>
	</div>

	<!-- NÚMEROS -->
	<div style="background:var(--pm-bg1);border-bottom:1px solid var(--pm-b2);padding:2.5rem 0">
		<div class="container-xl">
			<div class="row g-0" style="border:1px solid var(--pm-b2);border-radius:var(--pm-rl);overflow:hidden">
				<?php
				$stats = [
					[ 'num' => '47+', 'label' => __( 'projetos entregues', 'pmportfolio' ) ],
					[ 'num' => '8+',  'label' => __( 'anos de experiência', 'pmportfolio' ) ],
					[ 'num' => '32+', 'label' => __( 'clientes satisfeitos', 'pmportfolio' ) ],
					[ 'num' => '4+',  'label' => __( 'países atendidos', 'pmportfolio' ) ],
				];
				foreach ( $stats as $i => $stat ) :
					$border = $i < 3 ? 'border-right:1px solid var(--pm-b2);' : '';
				?>
				<div class="col-6 col-md-3" style="background:var(--pm-bg1);<?php echo $border; ?>padding:1.5rem;text-align:center">
					<div style="font-family:var(--pm-fd);font-size:2rem;font-weight:800;color:var(--pm-t1);line-height:1">
						<?php echo esc_html( $stat['num'] ); ?>
					</div>
					<div style="font-family:var(--pm-fm);font-size:9px;color:var(--pm-t3);letter-spacing:.06em;text-transform:uppercase;margin-top:4px">
						<?php echo esc_html( $stat['label'] ); ?>
					</div>
				</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>

	<!-- SKILLS + EXPERIÊNCIA -->
	<div style="background:var(--pm-bg0);padding:4rem 0;border-bottom:1px solid var(--pm-b2)">
		<div class="container-xl">
			<div class="row g-5">

				<!-- SKILL BARS -->
				<div class="col-lg-6">
					<div class="pm-eyebrow mb-3"><?php esc_html_e( 'habilidades', 'pmportfolio' ); ?></div>
					<h2 style="font-size:1.8rem;margin-bottom:2rem">
						<?php esc_html_e( 'Stack & ', 'pmportfolio' ); ?>
						<span style="color:var(--pm-gold)"><?php esc_html_e( 'especialidades', 'pmportfolio' ); ?></span>
					</h2>

					<?php
					$skill_groups = [
						__( 'Back-end', 'pmportfolio' ) => [
							[ 'PHP 8.2',          95 ],
							[ 'WordPress',        98 ],
							[ 'MySQL / MariaDB',  88 ],
							[ 'Laravel',          80 ],
						],
						__( 'Front-end & Build', 'pmportfolio' ) => [
							[ 'JavaScript ES6+',  85 ],
							[ 'CSS / Bootstrap 5',92 ],
							[ 'Vite 5',           87 ],
						],
					];
					foreach ( $skill_groups as $group_title => $skills ) :
					?>
					<div class="mb-4">
						<div class="pm-skill-group-title"><?php echo esc_html( $group_title ); ?></div>
						<?php foreach ( $skills as $skill ) : ?>
						<div class="pm-skill-row">
							<div class="pm-skill-label">
								<span><?php echo esc_html( $skill[0] ); ?></span>
								<span class="pm-skill-pct"><?php echo esc_html( $skill[1] ); ?>%</span>
							</div>
							<div class="pm-skill-bar-track">
								<div class="pm-skill-bar-fill" data-w="<?php echo esc_attr( $skill[1] ); ?>"></div>
							</div>
						</div>
						<?php endforeach; ?>
					</div>
					<?php endforeach; ?>

					<div style="font-family:var(--pm-fd);font-size:13px;font-weight:700;color:var(--pm-t1);margin-bottom:.75rem">
						<?php esc_html_e( 'Outras ferramentas', 'pmportfolio' ); ?>
					</div>
					<div class="d-flex flex-wrap gap-2">
						<?php
						$tools = [ 'Git', 'Docker', 'Linux', 'Redis', 'REST API', 'SEO Técnico', 'Figma', 'WooCommerce' ];
						foreach ( $tools as $tool ) :
						?>
							<span class="pm-stag"><?php echo esc_html( $tool ); ?></span>
						<?php endforeach; ?>
					</div>
				</div>

				<!-- TIMELINE EXPERIÊNCIA -->
				<div class="col-lg-6">
					<div class="pm-eyebrow mb-3"><?php esc_html_e( 'experiência', 'pmportfolio' ); ?></div>
					<h2 style="font-size:1.8rem;margin-bottom:2rem">
						<?php esc_html_e( 'Trajetória ', 'pmportfolio' ); ?>
						<span style="color:var(--pm-gold)"><?php esc_html_e( 'profissional', 'pmportfolio' ); ?></span>
					</h2>

					<div class="pm-tl">
						<?php
						$timeline = [
							[
								'period'  => __( '2022 — presente', 'pmportfolio' ),
								'role'    => __( 'Engenheiro de Software Freelance', 'pmportfolio' ),
								'company' => __( 'Autônomo · Remoto', 'pmportfolio' ),
								'desc'    => __( 'Desenvolvimento de temas WordPress premium, sistemas SaaS e integrações complexas para clientes no Brasil e exterior.', 'pmportfolio' ),
								'active'  => true,
							],
							[
								'period'  => __( '2019 — 2022', 'pmportfolio' ),
								'role'    => __( 'Desenvolvedor Full-Stack Sênior', 'pmportfolio' ),
								'company' => __( 'Agência Digital · São Paulo', 'pmportfolio' ),
								'desc'    => __( 'Liderava o time de desenvolvimento e arquitetura de soluções WordPress para clientes enterprise.', 'pmportfolio' ),
								'active'  => false,
							],
							[
								'period'  => __( '2016 — 2019', 'pmportfolio' ),
								'role'    => __( 'Desenvolvedor PHP Pleno', 'pmportfolio' ),
								'company' => __( 'Startup FinTech · Campinas', 'pmportfolio' ),
								'desc'    => __( 'APIs REST, integrações com gateways financeiros e dashboards em PHP e Vue.js.', 'pmportfolio' ),
								'active'  => false,
							],
						];
						foreach ( $timeline as $item ) :
							$dot_class = $item['active'] ? 'pm-tl-dot active-dot' : 'pm-tl-dot old';
							$per_class = $item['active'] ? 'pm-tl-period' : 'pm-tl-period old';
						?>
						<div class="pm-tl-item">
							<div class="<?php echo esc_attr( $dot_class ); ?>"></div>
							<div class="<?php echo esc_attr( $per_class ); ?>"><?php echo esc_html( $item['period'] ); ?></div>
							<div class="pm-tl-role"><?php echo esc_html( $item['role'] ); ?></div>
							<div class="pm-tl-company"><?php echo esc_html( $item['company'] ); ?></div>
							<p class="pm-tl-desc"><?php echo esc_html( $item['desc'] ); ?></p>
						</div>
						<?php endforeach; ?>
					</div>
				</div>

			</div>
		</div>
	</div>

	<!-- VALORES -->
	<div style="background:var(--pm-bg1);border-bottom:1px solid var(--pm-b2);padding:4rem 0">
		<div class="container-xl">
			<div class="row mb-4">
				<div class="col-lg-6">
					<div class="pm-eyebrow mb-2"><?php esc_html_e( 'valores', 'pmportfolio' ); ?></div>
					<h2 style="font-size:1.8rem">
						<?php esc_html_e( 'Como eu ', 'pmportfolio' ); ?>
						<span style="color:var(--pm-gold)"><?php esc_html_e( 'trabalho', 'pmportfolio' ); ?></span>
					</h2>
				</div>
			</div>
			<div class="row g-4">
				<?php
				$valores = [
					[ '🏗️', __( 'Arquitetura primeiro', 'pmportfolio' ), __( 'Antes de escrever código, penso na estrutura. Sistemas bem arquitetados escalam sem dívida técnica.', 'pmportfolio' ) ],
					[ '📖', __( 'Código legível', 'pmportfolio' ),       __( 'Escrevo código que outro dev consegue entender em 5 minutos. Nomear bem é tão importante quanto a lógica.', 'pmportfolio' ) ],
					[ '📦', __( 'Entregas incrementais', 'pmportfolio' ),__( 'Nada de big bang. Prefiro entregas menores e frequentes com feedback real no meio do processo.', 'pmportfolio' ) ],
					[ '🔍', __( 'Resultado mensurável', 'pmportfolio' ), __( 'Cada entrega tem métricas. Lighthouse, conversão, tempo de carregamento — preciso saber que funcionou.', 'pmportfolio' ) ],
				];
				foreach ( $valores as $v ) :
				?>
				<div class="col-sm-6 col-lg-3">
					<div style="background:var(--pm-bgc);border:1px solid var(--pm-b2);border-radius:var(--pm-rl);padding:1.5rem;height:100%;transition:all .2s">
						<div style="font-size:1.6rem;margin-bottom:.75rem"><?php echo $v[0]; // phpcs:ignore ?></div>
						<div style="font-family:var(--pm-fd);font-size:14px;font-weight:700;color:var(--pm-t1);letter-spacing:-.01em;margin-bottom:.4rem"><?php echo esc_html( $v[1] ); ?></div>
						<p style="font-size:13px;color:var(--pm-t2);font-weight:300;line-height:1.7"><?php echo esc_html( $v[2] ); ?></p>
					</div>
				</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>

	<!-- CTA -->
	<div style="background:var(--pm-bg1);border-top:1px solid var(--pm-b1);padding:4rem 0;text-align:center">
		<div class="container-xl">
			<div class="row justify-content-center">
				<div class="col-lg-6">
					<div class="pm-eyebrow mb-3 justify-content-center"><?php esc_html_e( 'vamos trabalhar juntos', 'pmportfolio' ); ?></div>
					<h2 class="mb-3" style="font-size:clamp(1.6rem,2.5vw,2.2rem)">
						<?php esc_html_e( 'Tem um projeto? ', 'pmportfolio' ); ?>
						<span style="color:var(--pm-gold)"><?php esc_html_e( 'Me conta.', 'pmportfolio' ); ?></span>
					</h2>
					<p class="mb-4"><?php esc_html_e( 'Respondo em até 24h. Sem compromisso inicial.', 'pmportfolio' ); ?></p>
					<a href="<?php echo esc_url( $contato ); ?>" class="pm-btn-p">
						<?php esc_html_e( 'Entrar em contato →', 'pmportfolio' ); ?>
					</a>
				</div>
			</div>
		</div>
	</div>

</main>

<?php get_footer(); ?>