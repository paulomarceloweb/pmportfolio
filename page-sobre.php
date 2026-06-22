<?php

/**
 * PMPortfolio — Page Sobre
 * URL: /sobre/
 * @package PMPortfolio
 */

defined('ABSPATH') || exit;

use PMPortfolio\Admin\Settings_API;
use PMPortfolio\Multilingual\Language_Manager;

get_header();

$avatar  = Settings_API::get('avatar');
$contato = home_url(Language_Manager::is('en') ? '/en/contato/' : '/contato/');
?>

<main id="main-content" role="main">

	<!-- BREADCRUMB -->
	<div class="pm-bc">
		<div class="container-xl d-flex align-items-center">
			<a class="pm-bc-link" href="<?php echo esc_url(home_url('/')); ?>">
				<?php echo esc_html(Language_Manager::t('início', 'home')); ?>
			</a>
			<span class="pm-bc-sep">/</span>
			<span class="pm-bc-cur"><?php echo esc_html(Language_Manager::t('sobre', 'about')); ?></span>
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
							<?php if ($avatar) : ?>
								<img src="<?php echo esc_url($avatar); ?>"
									alt="Paulo Marcelo Gonçalves"
									style="width:100%;height:100%;object-fit:cover"
									loading="eager" decoding="async">
							<?php else : ?>
								<span style="font-family:var(--pm-fm);font-size:10px;color:var(--pm-t3);letter-spacing:.08em;text-transform:uppercase">
									Paulo Marcelo
								</span>
							<?php endif; ?>
						</div>
						<div style="position:absolute;bottom:-1rem;right:-1rem;background:var(--pm-bgc);border:1px solid var(--pm-b1);border-radius:var(--pm-rl);padding:.9rem 1.1rem">
							<div style="font-family:var(--pm-fd);font-size:1.5rem;font-weight:800;color:var(--pm-t1);line-height:1">
								5<span style="color:var(--pm-gold)">+</span>
							</div>
							<div style="font-family:var(--pm-fm);font-size:9px;color:var(--pm-t3);letter-spacing:.06em;text-transform:uppercase;margin-top:2px">
								<?php echo esc_html(Language_Manager::t('anos de código', 'years of code')); ?>
							</div>
						</div>
					</div>
				</div>

				<!-- TEXTO -->
				<div class="col-lg-8">
					<div class="pm-eyebrow mb-2">
						<?php echo esc_html(Language_Manager::t('sobre mim', 'about me')); ?>
					</div>
					<h1 style="font-size:clamp(2rem,3.5vw,3rem);line-height:1.1;margin-bottom:1rem">
						<?php if (Language_Manager::is('en')) : ?>
							Developer who <span style="color:var(--pm-gold)">bridges code and growth</span>
						<?php else : ?>
							Desenvolvedor que <span style="color:var(--pm-gold)">une código e resultado</span>
						<?php endif; ?>
					</h1>
					<?php if (Language_Manager::is('en')) : ?>
						<p style="font-size:15px;line-height:1.85;max-width:58ch;margin-bottom:1.5rem;color:var(--pm-t2);font-weight:300">
							I'm a Full-Stack WordPress Developer and Marketing Tech Leader with a rare combination: I write clean, scalable code <strong>and</strong> understand what drives conversions. I don't just deliver systems — I deliver solutions that grow businesses.
						</p>
						<p style="font-size:15px;line-height:1.85;max-width:58ch;margin-bottom:2rem;color:var(--pm-t2);font-weight:300">
							Currently leading the marketing technology of a 10+ company holding in Brazil, I architect custom WordPress ecosystems from scratch using PHP 8, Vite, and OOP — while managing a cross-functional team of 7+ professionals.
						</p>
					<?php else : ?>
						<p style="font-size:15px;line-height:1.85;max-width:58ch;margin-bottom:1.5rem;color:var(--pm-t2);font-weight:300">
							Sou um Desenvolvedor WordPress Full-Stack e Marketing Tech Leader com uma combinação rara: escrevo código limpo e escalável <strong>e</strong> entendo o que gera conversão. Não entrego apenas sistemas — entrego soluções que fazem negócios crescerem.
						</p>
						<p style="font-size:15px;line-height:1.85;max-width:58ch;margin-bottom:2rem;color:var(--pm-t2);font-weight:300">
							Atualmente liderando a tecnologia de marketing de um grupo com mais de 10 empresas no Brasil, arquiteto ecossistemas WordPress customizados do zero com PHP 8, Vite e OOP — enquanto gerencio uma equipe multidisciplinar de 7+ profissionais.
						</p>
					<?php endif; ?>
					<div class="d-flex align-items-center gap-2 mb-3">
						<span class="pm-dot-live"></span>
						<span style="font-family:var(--pm-fm);font-size:10px;color:var(--pm-t3);letter-spacing:.06em">
							<?php echo esc_html(Language_Manager::t('disponível para projetos remotos', 'available for remote projects')); ?>
						</span>
					</div>
					<div class="d-flex gap-2 flex-wrap">
						<a href="#" class="pm-btn-p">
							<?php echo esc_html(Language_Manager::t('Baixar currículo →', 'Download resume →')); ?>
						</a>
						<a href="<?php echo esc_url($contato); ?>" class="pm-btn-s">
							<?php echo esc_html(Language_Manager::t('Entrar em contato', 'Get in touch')); ?>
						</a>
					</div>
				</div>

			</div>
		</div>
	</div>

	<!-- NÚMEROS -->
	<div style="background:var(--pm-bg1);border-bottom:1px solid var(--pm-b2);padding:2.5rem 0">
		<div class="container-xl">
			<div class="pm-stats-grid">
				<div class="row g-0">
					<div class="col-6 col-md-3 pm-stat-item">
						<div class="pm-stat-lbl2">// <?php echo esc_html(Language_Manager::t('empresas', 'companies')); ?></div>
						<div class="pm-stat-big">10<em>+</em></div>
						<div class="pm-stat-desc"><?php echo esc_html(Language_Manager::t('no grupo Motta', 'in Grupo Motta')); ?></div>
					</div>
					<div class="col-6 col-md-3 pm-stat-item">
						<div class="pm-stat-lbl2">// <?php echo esc_html(Language_Manager::t('equipe', 'team')); ?></div>
						<div class="pm-stat-big">7<em>+</em></div>
						<div class="pm-stat-desc"><?php echo esc_html(Language_Manager::t('profissionais gerenciados', 'professionals managed')); ?></div>
					</div>
					<div class="col-6 col-md-3 pm-stat-item">
						<div class="pm-stat-lbl2">// <?php echo esc_html(Language_Manager::t('unidades', 'branches')); ?></div>
						<div class="pm-stat-big">50<em>+</em></div>
						<div class="pm-stat-desc"><?php echo esc_html(Language_Manager::t('filiais atendidas', 'locations served')); ?></div>
					</div>
					<div class="col-6 col-md-3 pm-stat-item">
						<div class="pm-stat-lbl2">// <?php echo esc_html(Language_Manager::t('stack', 'stack')); ?></div>
						<div class="pm-stat-big">5<em>+</em></div>
						<div class="pm-stat-desc"><?php echo esc_html(Language_Manager::t('anos com WordPress', 'years with WordPress')); ?></div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- SKILLS + EXPERIÊNCIA -->
	<div style="background:var(--pm-bg0);padding:4rem 0;border-bottom:1px solid var(--pm-b2)">
		<div class="container-xl">
			<div class="row g-5">

				<!-- SKILL BARS -->
				<div class="col-lg-6">
					<div class="pm-eyebrow mb-3"><?php echo esc_html(Language_Manager::t('habilidades', 'skills')); ?></div>
					<h2 style="font-size:1.8rem;margin-bottom:2rem">
						<?php echo esc_html(Language_Manager::t('Stack & ', 'Stack & ')); ?>
						<span style="color:var(--pm-gold)">
							<?php echo esc_html(Language_Manager::t('especialidades', 'specialties')); ?>
						</span>
					</h2>

					<?php
					$skill_groups = [
						Language_Manager::t('Back-end & CMS', 'Back-end & CMS') => [
							['PHP 8',             92],
							['WordPress',         95],
							['MySQL',             85],
							['REST API',          88],
						],
						Language_Manager::t('Front-end & Build', 'Front-end & Build') => [
							['HTML / CSS',        90],
							['JavaScript ES6+',   82],
							['Vite 5',            80],
							['React / Next.js',   70],
						],
						Language_Manager::t('Marketing Tech', 'Marketing Tech') => [
							['GTM & Meta Pixel',  90],
							['Google & Meta Ads', 85],
							['SEO Técnico',       88],
						],
					];
					foreach ($skill_groups as $group_title => $skills) :
					?>
						<div class="mb-4">
							<div class="pm-skill-group-title"><?php echo esc_html($group_title); ?></div>
							<?php foreach ($skills as $skill) : ?>
								<div class="pm-skill-row">
									<div class="pm-skill-label">
										<span><?php echo esc_html($skill[0]); ?></span>
										<span class="pm-skill-pct"><?php echo esc_html($skill[1]); ?>%</span>
									</div>
									<div class="pm-skill-bar-track">
										<div class="pm-skill-bar-fill" data-w="<?php echo esc_attr($skill[1]); ?>"></div>
									</div>
								</div>
							<?php endforeach; ?>
						</div>
					<?php endforeach; ?>

					<div class="pm-skill-group-title mb-2">
						<?php echo esc_html(Language_Manager::t('Ferramentas & Design', 'Tools & Design')); ?>
					</div>
					<div class="d-flex flex-wrap gap-2">
						<?php
						$tools = ['Docker', 'Git / GitHub', 'Figma', 'Photoshop', 'Illustrator', 'Mailchimp', 'ACF PRO'];
						foreach ($tools as $tool) :
						?>
							<span class="pm-stag"><?php echo esc_html($tool); ?></span>
						<?php endforeach; ?>
					</div>
				</div>

				<!-- TIMELINE -->
				<div class="col-lg-6">
					<div class="pm-eyebrow mb-3"><?php echo esc_html(Language_Manager::t('experiência', 'experience')); ?></div>
					<h2 style="font-size:1.8rem;margin-bottom:2rem">
						<?php echo esc_html(Language_Manager::t('Trajetória ', 'Professional ')); ?>
						<span style="color:var(--pm-gold)">
							<?php echo esc_html(Language_Manager::t('profissional', 'journey')); ?>
						</span>
					</h2>

					<div class="pm-tl">
						<?php
						$timeline = [
							[
								'period'  => Language_Manager::t('2020 — presente', '2020 — present'),
								'role'    => Language_Manager::t('Marketing Tech Leader & Lead WordPress Developer', 'Marketing Tech Leader & Lead WordPress Developer'),
								'company' => Language_Manager::t('Grupo Motta · Sengés, PR', 'Grupo Motta · Brazil'),
								'desc'    => Language_Manager::t(
									'Liderança estratégica e técnica do marketing de um grupo com 10+ empresas. Arquitetei uma plataforma WordPress multi-localização com PHP 8 e ACF PRO centralizando 50+ filiais. Gerencio equipe multidisciplinar de 7+ profissionais.',
									'Strategic and technical leadership of marketing across a 10+ company holding. Architected a multi-location WordPress platform with PHP 8 and ACF PRO centralizing 50+ branches. Managing a cross-functional team of 7+ professionals.'
								),
								'active'  => true,
								'hidden'  => false,
							],
							[
								'period'  => Language_Manager::t('2019 — 2020', '2019 — 2020'),
								'role'    => Language_Manager::t('Web Developer & Designer', 'Web Developer & Designer'),
								'company' => Language_Manager::t('Freelance · Remoto', 'Freelance · Remote'),
								'desc'    => Language_Manager::t(
									'Desenvolvimento de temas WordPress customizados e identidades visuais para clientes locais e regionais. Foco em performance, SEO técnico e conversão.',
									'Custom WordPress theme development and visual identity design for local and regional clients. Focus on performance, technical SEO and conversion.'
								),
								'active'  => false,
								'hidden'  => false,
							],
							[
								'period'  => Language_Manager::t('2018 — 2019', '2018 — 2019'),
								'role'    => Language_Manager::t('Designer Gráfico & Web', 'Graphic & Web Designer'),
								'company' => Language_Manager::t('Agência Local · PR', 'Local Agency · PR, Brazil'),
								'desc'    => Language_Manager::t(
									'Criação de identidades visuais, materiais gráficos e sites WordPress para clientes de diferentes segmentos usando Adobe Creative Cloud.',
									'Visual identity creation, graphic materials and WordPress sites for clients across different segments using Adobe Creative Cloud.'
								),
								'active'  => false,
								'hidden'  => true,
							],
						];

						foreach ($timeline as $item) :
							$dot_class = $item['active'] ? 'pm-tl-dot active-dot' : 'pm-tl-dot old';
							$per_class = $item['active'] ? 'pm-tl-period' : 'pm-tl-period old';
							$hidden    = $item['hidden'] ? 'pm-tl-hidden' : '';
						?>
							<div class="pm-tl-item <?php echo esc_attr($hidden); ?>">
								<div class="<?php echo esc_attr($dot_class); ?>"></div>
								<div class="<?php echo esc_attr($per_class); ?>"><?php echo esc_html($item['period']); ?></div>
								<div class="pm-tl-role"><?php echo esc_html($item['role']); ?></div>
								<div class="pm-tl-company"><?php echo esc_html($item['company']); ?></div>
								<p class="pm-tl-desc"><?php echo esc_html($item['desc']); ?></p>
							</div>
						<?php endforeach; ?>
					</div>

					<button class="pm-btn-ghost mt-3" id="pm-tl-more" onclick="pmToggleTimeline(this)">
						<span><?php echo esc_html(Language_Manager::t('ver mais experiências', 'see more experience')); ?></span>
						<span style="font-size:10px">↓</span>
					</button>
				</div>

			</div>
		</div>
	</div>

	<!-- VALORES -->
	<div style="background:var(--pm-bg1);border-bottom:1px solid var(--pm-b2);padding:4rem 0">
		<div class="container-xl">
			<div class="row mb-4">
				<div class="col-lg-6">
					<div class="pm-eyebrow mb-2"><?php echo esc_html(Language_Manager::t('valores', 'values')); ?></div>
					<h2 style="font-size:1.8rem">
						<?php echo esc_html(Language_Manager::t('Como eu ', 'How I ')); ?>
						<span style="color:var(--pm-gold)">
							<?php echo esc_html(Language_Manager::t('trabalho', 'work')); ?>
						</span>
					</h2>
				</div>
			</div>
			<div class="row g-4">
				<?php
				$valores = [
					[
						'🏗️',
						Language_Manager::t('Arquitetura primeiro', 'Architecture first'),
						Language_Manager::t(
							'Antes de escrever código, projeto a estrutura. Sistemas bem arquitetados escalam sem acumular dívida técnica.',
							'Before writing code, I design the structure. Well-architected systems scale without accumulating technical debt.'
						),
					],
					[
						'📈',
						Language_Manager::t('Código que converte', 'Code that converts'),
						Language_Manager::t(
							'Cada decisão técnica tem impacto no negócio. Desenvolvo com olho em performance, UX e métricas de conversão.',
							'Every technical decision has business impact. I develop with an eye on performance, UX and conversion metrics.'
						),
					],
					[
						'🤝',
						Language_Manager::t('Liderança técnica', 'Technical leadership'),
						Language_Manager::t(
							'Gerencio equipes e projetos com clareza. Comunicação direta, escopo claro e entregas previsíveis.',
							'I manage teams and projects with clarity. Direct communication, clear scope and predictable deliveries.'
						),
					],
					[
						'🔍',
						Language_Manager::t('Resultado mensurável', 'Measurable results'),
						Language_Manager::t(
							'Cada entrega tem métricas. Lighthouse, conversão, tempo de carregamento — preciso saber que funcionou.',
							'Every delivery has metrics. Lighthouse, conversion, load time — I need to know it worked.'
						),
					],
				];
				foreach ($valores as $v) :
				?>
					<div class="col-sm-6 col-lg-3">
						<div style="background:var(--pm-bgc);border:1px solid var(--pm-b2);border-radius:var(--pm-rl);padding:1.5rem;height:100%;transition:all .2s">
							<div style="font-size:1.6rem;margin-bottom:.75rem"><?php echo $v[0]; // phpcs:ignore 
																				?></div>
							<div style="font-family:var(--pm-fd);font-size:14px;font-weight:700;color:var(--pm-t1);letter-spacing:-.01em;margin-bottom:.4rem"><?php echo esc_html($v[1]); ?></div>
							<p style="font-size:13px;color:var(--pm-t2);font-weight:300;line-height:1.7"><?php echo esc_html($v[2]); ?></p>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>

	<!-- EDUCAÇÃO -->
	<div style="background:var(--pm-bg0);border-bottom:1px solid var(--pm-b2);padding:4rem 0">
		<div class="container-xl">
			<div class="pm-eyebrow mb-3"><?php echo esc_html(Language_Manager::t('educação & certificações', 'education & certifications')); ?></div>
			<div class="row g-3">
				<?php
				$edu = [
					[
						'🎓',
						Language_Manager::t('PHP Moderno & OOP', 'Modern PHP & OOP'),
						'UpInside Treinamentos',
					],
					[
						'🎓',
						Language_Manager::t('Arquitetura de Software & Design Patterns', 'Software Architecture & Design Patterns'),
						Language_Manager::t('Estudo autodirigido', 'Self-directed study'),
					],
					[
						'🎓',
						Language_Manager::t('Desenvolvimento WordPress Avançado', 'Advanced WordPress Development'),
						Language_Manager::t('Frameworks baseados em projetos', 'Project-based frameworks'),
					],
				];
				foreach ($edu as $e) :
				?>
					<div class="col-md-4">
						<div style="background:var(--pm-bgc);border:1px solid var(--pm-b2);border-radius:var(--pm-rl);padding:1.25rem;display:flex;gap:.75rem;align-items:flex-start">
							<span style="font-size:1.4rem;flex-shrink:0"><?php echo $e[0]; // phpcs:ignore 
																			?></span>
							<div>
								<div style="font-family:var(--pm-fd);font-size:13px;font-weight:700;color:var(--pm-t1);margin-bottom:2px"><?php echo esc_html($e[1]); ?></div>
								<div style="font-family:var(--pm-fm);font-size:10px;color:var(--pm-t3);letter-spacing:.04em"><?php echo esc_html($e[2]); ?></div>
							</div>
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
					<div class="pm-eyebrow mb-3 justify-content-center">
						<?php echo esc_html(Language_Manager::t('vamos trabalhar juntos', "let's work together")); ?>
					</div>
					<h2 class="mb-3" style="font-size:clamp(1.6rem,2.5vw,2.2rem)">
						<?php echo esc_html(Language_Manager::t('Tem um projeto? ', 'Have a project? ')); ?>
						<span style="color:var(--pm-gold)">
							<?php echo esc_html(Language_Manager::t('Me conta.', "Let's talk.")); ?>
						</span>
					</h2>
					<p class="mb-4">
						<?php echo esc_html(Language_Manager::t('Respondo em até 24h. Sem compromisso inicial.', 'I reply within 24h. No commitment required.')); ?>
					</p>
					<a href="<?php echo esc_url($contato); ?>" class="pm-btn-p">
						<?php echo esc_html(Language_Manager::t('Entrar em contato →', 'Get in touch →')); ?>
					</a>
				</div>
			</div>
		</div>
	</div>

</main>

<?php get_footer(); ?>