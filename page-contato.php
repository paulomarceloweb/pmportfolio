<?php

/**
 * PMPortfolio — Page Contato
 * URL: /contato/
 * @package PMPortfolio
 */

defined('ABSPATH') || exit;

use PMPortfolio\Admin\Settings_API;
use PMPortfolio\Multilingual\Language_Manager;

get_header();

$email    = Settings_API::get('email',    'p.marcelo92@gmail.com');
$whatsapp = Settings_API::get('whatsapp', '');
$address  = Settings_API::get('address',  'Sengés, PR — Brasil');
$linkedin = Settings_API::get('social_linkedin', '');
$github   = Settings_API::get('social_github',   '');
$twitter  = Settings_API::get('social_twitter',  '');

$wa_url = $whatsapp
	? 'https://wa.me/' . preg_replace('/\D/', '', $whatsapp)
	: '#';
?>

<main id="main-content" role="main">

	<!-- BREADCRUMB -->
	<div class="pm-bc">
		<div class="container-xl d-flex align-items-center">
			<a class="pm-bc-link" href="<?php echo esc_url(home_url('/')); ?>">
				<?php echo esc_html(Language_Manager::t('início', 'home')); ?>
			</a>
			<span class="pm-bc-sep">/</span>
			<span class="pm-bc-cur"><?php echo esc_html(Language_Manager::t('contato', 'contact')); ?></span>
		</div>
	</div>

	<!-- HERO -->
	<div style="background:var(--pm-bg0);padding:4rem 0 3rem;border-bottom:1px solid var(--pm-b2);position:relative;overflow:hidden">
		<div class="pm-hero-grid" aria-hidden="true"></div>
		<div class="container-xl position-relative" style="z-index:1">
			<div class="row align-items-center g-4">
				<div class="col-lg-7">
					<div class="pm-eyebrow mb-2">
						<?php echo esc_html(Language_Manager::t('contato', 'contact')); ?>
					</div>
					<h1 style="font-size:clamp(2rem,3.5vw,3rem);line-height:1.1;margin-bottom:1rem">
						<?php if (Language_Manager::is('en')) : ?>
							Let's <span style="color:var(--pm-gold)">talk</span>
						<?php else : ?>
							Vamos <span style="color:var(--pm-gold)">conversar</span>
						<?php endif; ?>
					</h1>
					<p style="font-size:15px;max-width:52ch;line-height:1.85;color:var(--pm-t2);font-weight:300">
						<?php echo esc_html(Language_Manager::t(
							'Disponível para projetos freelance, consultorias e posições remotas. Escolha o canal que preferir — respondo em até 24h.',
							'Available for freelance projects, consulting and remote positions. Choose your preferred channel — I reply within 24h.'
						)); ?>
					</p>
				</div>
				<div class="col-lg-5 d-none d-lg-flex justify-content-end">
					<div style="background:var(--pm-goldm);border:1px solid var(--pm-goldb);border-radius:var(--pm-rl);padding:1.25rem;max-width:280px;width:100%">
						<div class="d-flex align-items-center gap-2 mb-2">
							<span class="pm-dot-live"></span>
							<div style="font-family:var(--pm-fd);font-size:13px;font-weight:700;color:var(--pm-t1)">
								<?php echo esc_html(Language_Manager::t('Disponível para projetos', 'Available for projects')); ?>
							</div>
						</div>
						<p style="font-size:12px;color:var(--pm-t2);font-weight:300;line-height:1.6;margin:0">
							<?php echo esc_html(Language_Manager::t(
								'Aceitando novos clientes. Agenda limitada — entre em contato para garantir sua vaga.',
								'Accepting new clients. Limited availability — get in touch to secure your spot.'
							)); ?>
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- CANAIS RÁPIDOS -->
	<div style="background:var(--pm-bg1);border-bottom:1px solid var(--pm-b2);padding:1.5rem 0">
		<div class="container-xl">
			<div class="row g-3">

				<div class="col-md-4">
					<a href="mailto:<?php echo esc_attr($email); ?>"
						style="background:var(--pm-bgc);border:1px solid var(--pm-b2);border-radius:var(--pm-rl);padding:1.25rem;display:flex;align-items:center;gap:1rem;transition:all .2s;text-decoration:none"
						onmouseover="this.style.borderColor='var(--pm-b1)'" onmouseout="this.style.borderColor='var(--pm-b2)'">
						<div style="width:40px;height:40px;border-radius:var(--pm-r);background:var(--pm-goldm);display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0">✉️</div>
						<div>
							<div style="font-family:var(--pm-fm);font-size:9px;color:var(--pm-t3);letter-spacing:.07em;text-transform:uppercase;margin-bottom:2px">
								<?php echo esc_html(Language_Manager::t('e-mail', 'email')); ?>
							</div>
							<div style="font-size:13px;font-weight:500;color:var(--pm-t1)"><?php echo esc_html($email); ?></div>
							<div style="font-family:var(--pm-fm);font-size:10px;color:var(--pm-t3);letter-spacing:.04em;margin-top:1px">
								<?php echo esc_html(Language_Manager::t('resposta em até 24h', 'reply within 24h')); ?>
							</div>
						</div>
						<span style="margin-left:auto;font-family:var(--pm-fm);font-size:12px;color:var(--pm-t3)">→</span>
					</a>
				</div>

				<?php if ($whatsapp) : ?>
					<div class="col-md-4">
						<a href="<?php echo esc_url($wa_url); ?>"
							target="_blank" rel="noopener noreferrer"
							style="background:var(--pm-bgc);border:1px solid var(--pm-b2);border-radius:var(--pm-rl);padding:1.25rem;display:flex;align-items:center;gap:1rem;transition:all .2s;text-decoration:none"
							onmouseover="this.style.borderColor='var(--pm-b1)'" onmouseout="this.style.borderColor='var(--pm-b2)'">
							<div style="width:40px;height:40px;border-radius:var(--pm-r);background:var(--pm-tealm);display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0">💬</div>
							<div>
								<div style="font-family:var(--pm-fm);font-size:9px;color:var(--pm-t3);letter-spacing:.07em;text-transform:uppercase;margin-bottom:2px">WhatsApp</div>
								<div style="font-size:13px;font-weight:500;color:var(--pm-t1)"><?php echo esc_html($whatsapp); ?></div>
								<div style="font-family:var(--pm-fm);font-size:10px;color:var(--pm-t3);letter-spacing:.04em;margin-top:1px">
									<?php echo esc_html(Language_Manager::t('seg–sex, 9h–18h', 'mon–fri, 9am–6pm')); ?>
								</div>
							</div>
							<span style="margin-left:auto;font-family:var(--pm-fm);font-size:12px;color:var(--pm-t3)">→</span>
						</a>
					</div>
				<?php endif; ?>

				<div class="col-md-4">
					<div style="background:var(--pm-bgc);border:1px solid var(--pm-b2);border-radius:var(--pm-rl);padding:1.25rem;display:flex;align-items:center;gap:1rem">
						<div style="width:40px;height:40px;border-radius:var(--pm-r);background:var(--pm-purplem);display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0">📅</div>
						<div>
							<div style="font-family:var(--pm-fm);font-size:9px;color:var(--pm-t3);letter-spacing:.07em;text-transform:uppercase;margin-bottom:2px">
								<?php echo esc_html(Language_Manager::t('agendar chamada', 'schedule a call')); ?>
							</div>
							<div style="font-size:13px;font-weight:500;color:var(--pm-t1)">Calendly</div>
							<div style="font-family:var(--pm-fm);font-size:10px;color:var(--pm-t3);letter-spacing:.04em;margin-top:1px">
								<?php echo esc_html(Language_Manager::t('30 min · gratuito', '30 min · free')); ?>
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>

	<!-- FORMULÁRIO + SIDEBAR -->
	<div style="background:var(--pm-bg0);padding:3rem 0 5rem">
		<div class="container-xl">
			<div class="row g-5">

				<!-- FORMULÁRIO -->
				<div class="col-lg-8">

					<div class="pm-eyebrow mb-3">
						<?php echo esc_html(Language_Manager::t('formulário de contato', 'contact form')); ?>
					</div>

					<div style="background:var(--pm-bgc);border:1px solid var(--pm-b2);border-radius:var(--pm-rl);padding:2rem;position:relative;overflow:hidden">
						<div style="position:absolute;top:0;left:0;right:0;height:2px;background:linear-gradient(90deg,transparent,var(--pm-gold),transparent)"></div>

						<div id="contact-form">
							<!-- Honeypot anti-spam -->
							<div style="display:none!important" aria-hidden="true">
								<input type="text" name="website" tabindex="-1" autocomplete="off">
							</div>

							<div class="row g-3">
								<div class="col-md-6">
									<label class="pm-field-label" for="f-name">
										<?php echo esc_html(Language_Manager::t('nome', 'name')); ?> <span>*</span>
									</label>
									<input type="text" class="pm-input" id="f-name"
										placeholder="<?php echo esc_attr(Language_Manager::t('Seu nome completo', 'Your full name')); ?>">
								</div>
								<div class="col-md-6">
									<label class="pm-field-label" for="f-email">
										<?php echo esc_html(Language_Manager::t('e-mail', 'email')); ?> <span>*</span>
									</label>
									<input type="email" class="pm-input" id="f-email" placeholder="your@email.com">
								</div>
								<div class="col-md-6">
									<label class="pm-field-label" for="f-company">
										<?php echo esc_html(Language_Manager::t('empresa', 'company')); ?>
									</label>
									<input type="text" class="pm-input" id="f-company"
										placeholder="<?php echo esc_attr(Language_Manager::t('Nome da empresa (opcional)', 'Company name (optional)')); ?>">
								</div>
								<div class="col-md-6">
									<label class="pm-field-label" for="f-service">
										<?php echo esc_html(Language_Manager::t('serviço de interesse', 'service of interest')); ?> <span>*</span>
									</label>
									<select class="pm-input pm-select" id="f-service">
										<option value=""><?php echo esc_html(Language_Manager::t('Selecione um serviço', 'Select a service')); ?></option>
										<option value="tema"><?php echo esc_html(Language_Manager::t('Tema WordPress Premium', 'Premium WordPress Theme')); ?></option>
										<option value="perf"><?php echo esc_html(Language_Manager::t('Otimização & Performance', 'Optimization & Performance')); ?></option>
										<option value="mkt"><?php echo esc_html(Language_Manager::t('Marketing Tech & Integrações', 'Marketing Tech & Integrations')); ?></option>
										<option value="seo"><?php echo esc_html(Language_Manager::t('SEO Técnico', 'Technical SEO')); ?></option>
										<option value="cons"><?php echo esc_html(Language_Manager::t('Consultoria Técnica', 'Technical Consulting')); ?></option>
										<option value="outro"><?php echo esc_html(Language_Manager::t('Outro', 'Other')); ?></option>
									</select>
								</div>
								<div class="col-12">
									<label class="pm-field-label" for="f-message">
										<?php echo esc_html(Language_Manager::t('mensagem', 'message')); ?> <span>*</span>
									</label>
									<textarea class="pm-input pm-textarea" id="f-message"
										placeholder="<?php echo esc_attr(Language_Manager::t('Descreva seu projeto, objetivos e qualquer detalhe relevante...', 'Describe your project, goals and any relevant details...')); ?>"></textarea>
								</div>
								<div class="col-12">
									<div id="form-error" class="pm-form-error"></div>
									<div class="d-flex align-items-center gap-3 flex-wrap mt-2">
										<button class="pm-btn-p" onclick="pmSubmitForm()" id="f-submit">
											<?php echo esc_html(Language_Manager::t('Enviar mensagem →', 'Send message →')); ?>
										</button>
										<p style="font-family:var(--pm-fm);font-size:10px;color:var(--pm-t3);letter-spacing:.04em;line-height:1.5;margin:0">
											<?php echo esc_html(Language_Manager::t('🔒 Seus dados são protegidos. Sem spam.', '🔒 Your data is protected. No spam.')); ?>
										</p>
									</div>
								</div>
							</div>
						</div>

						<div class="pm-form-success" id="form-success"></div>

					</div>

					<!-- FAQ -->
					<div class="mt-5">
						<div class="pm-eyebrow mb-3">
							<?php echo esc_html(Language_Manager::t('dúvidas rápidas', 'quick questions')); ?>
						</div>
						<div style="background:var(--pm-bgc);border:1px solid var(--pm-b2);border-radius:var(--pm-rl);padding:.5rem 1.25rem">
							<?php
							$faqs = [
								[
									Language_Manager::t('Em quanto tempo você responde?', 'How quickly do you reply?'),
									Language_Manager::t(
										'Em até 24h em dias úteis. Para urgências, WhatsApp é o canal mais rápido.',
										'Within 24h on business days. For urgent matters, WhatsApp is the fastest channel.'
									),
								],
								[
									Language_Manager::t('Atende clientes fora do Brasil?', 'Do you work with international clients?'),
									Language_Manager::t(
										'Sim. Atendo remotamente em português e inglês. Já trabalhei com clientes em Portugal, EUA e Argentina.',
										'Yes. I work remotely in Portuguese and English. I have worked with clients in Portugal, USA and Argentina.'
									),
								],
								[
									Language_Manager::t('Precisa assinar contrato?', 'Is a contract required?'),
									Language_Manager::t(
										'Sim, sempre. Um contrato protege tanto o cliente quanto o desenvolvedor — escopo, prazo e pagamentos ficam claros para todos.',
										'Yes, always. A contract protects both the client and the developer — scope, timeline and payments are clear for everyone.'
									),
								],
							];
							foreach ($faqs as $faq) :
							?>
								<div class="pm-faq-item">
									<button class="pm-faq-q" onclick="pmToggleFaq(this)">
										<span><?php echo esc_html($faq[0]); ?></span>
										<span class="pm-faq-icon">+</span>
									</button>
									<div class="pm-faq-a">
										<p><?php echo esc_html($faq[1]); ?></p>
									</div>
								</div>
							<?php endforeach; ?>
						</div>
					</div>

				</div>

				<!-- SIDEBAR -->
				<div class="col-lg-4">
					<div style="position:sticky;top:72px;display:flex;flex-direction:column;gap:1.25rem">

						<!-- INFORMAÇÕES -->
						<div style="background:var(--pm-bgc);border:1px solid var(--pm-b2);border-radius:var(--pm-rl);overflow:hidden">
							<div style="padding:.85rem 1.1rem;border-bottom:1px solid var(--pm-b2);background:var(--pm-bg2)">
								<span style="font-family:var(--pm-fd);font-size:12px;font-weight:700;color:var(--pm-t1)">
									<?php echo esc_html(Language_Manager::t('informações', 'information')); ?>
								</span>
							</div>
							<div style="padding:1rem 1.1rem">
								<?php
								$info = [
									['📍', Language_Manager::t('localização', 'location'),     $address],
									['🌐', Language_Manager::t('idiomas', 'languages'),         Language_Manager::t('Português · English', 'Portuguese · English')],
									['⏱️', Language_Manager::t('fuso horário', 'timezone'),     'GMT-3 (BRT)'],
									['💼', Language_Manager::t('modalidade', 'work mode'),       Language_Manager::t('Remoto · Worldwide', 'Remote · Worldwide')],
								];
								foreach ($info as $row) :
								?>
									<div style="display:flex;align-items:flex-start;gap:10px;padding:.5rem 0;border-bottom:1px solid var(--pm-b3)">
										<span style="font-size:14px;flex-shrink:0;margin-top:1px;width:20px;text-align:center"><?php echo $row[0]; // phpcs:ignore 
																																?></span>
										<div>
											<div style="font-family:var(--pm-fm);font-size:9px;color:var(--pm-t3);letter-spacing:.06em;text-transform:uppercase"><?php echo esc_html($row[1]); ?></div>
											<div style="font-size:13px;color:var(--pm-t1);margin-top:1px"><?php echo esc_html($row[2]); ?></div>
										</div>
									</div>
								<?php endforeach; ?>
							</div>
						</div>

						<!-- REDES SOCIAIS -->
						<?php if ($linkedin || $github || $twitter) : ?>
							<div>
								<div style="font-family:var(--pm-fd);font-size:12px;font-weight:700;color:var(--pm-t1);margin-bottom:.75rem">
									<?php echo esc_html(Language_Manager::t('redes & perfis', 'networks & profiles')); ?>
								</div>
								<div class="d-flex flex-column gap-2">
									<?php if ($linkedin) : ?>
										<a href="<?php echo esc_url($linkedin); ?>" target="_blank" rel="noopener noreferrer"
											style="display:flex;align-items:center;gap:10px;padding:.65rem 1rem;background:var(--pm-bg2);border:1px solid var(--pm-b2);border-radius:var(--pm-r);text-decoration:none;transition:all .15s"
											onmouseover="this.style.borderColor='var(--pm-b1)'" onmouseout="this.style.borderColor='var(--pm-b2)'">
											<div style="width:28px;height:28px;border-radius:4px;background:#0077b5;display:flex;align-items:center;justify-content:center;font-family:var(--pm-fm);font-size:11px;font-weight:700;color:#fff;flex-shrink:0">LI</div>
											<div>
												<div style="font-family:var(--pm-fd);font-size:12px;font-weight:700;color:var(--pm-t1)">LinkedIn</div>
												<div style="font-family:var(--pm-fm);font-size:10px;color:var(--pm-t3);letter-spacing:.04em">/in/pmarcelo</div>
											</div>
											<span style="margin-left:auto;font-size:10px;color:var(--pm-t3)">→</span>
										</a>
									<?php endif; ?>
									<?php if ($github) : ?>
										<a href="<?php echo esc_url($github); ?>" target="_blank" rel="noopener noreferrer"
											style="display:flex;align-items:center;gap:10px;padding:.65rem 1rem;background:var(--pm-bg2);border:1px solid var(--pm-b2);border-radius:var(--pm-r);text-decoration:none;transition:all .15s"
											onmouseover="this.style.borderColor='var(--pm-b1)'" onmouseout="this.style.borderColor='var(--pm-b2)'">
											<div style="width:28px;height:28px;border-radius:4px;background:#1a1a2e;display:flex;align-items:center;justify-content:center;font-family:var(--pm-fm);font-size:11px;font-weight:700;color:#fff;flex-shrink:0">GH</div>
											<div>
												<div style="font-family:var(--pm-fd);font-size:12px;font-weight:700;color:var(--pm-t1)">GitHub</div>
												<div style="font-family:var(--pm-fm);font-size:10px;color:var(--pm-t3);letter-spacing:.04em">@paulomarceloweb</div>
											</div>
											<span style="margin-left:auto;font-size:10px;color:var(--pm-t3)">→</span>
										</a>
									<?php endif; ?>
									<?php if ($twitter) : ?>
										<a href="<?php echo esc_url($twitter); ?>" target="_blank" rel="noopener noreferrer"
											style="display:flex;align-items:center;gap:10px;padding:.65rem 1rem;background:var(--pm-bg2);border:1px solid var(--pm-b2);border-radius:var(--pm-r);text-decoration:none;transition:all .15s"
											onmouseover="this.style.borderColor='var(--pm-b1)'" onmouseout="this.style.borderColor='var(--pm-b2)'">
											<div style="width:28px;height:28px;border-radius:4px;background:#1a1a1a;display:flex;align-items:center;justify-content:center;font-family:var(--pm-fm);font-size:11px;font-weight:700;color:#fff;flex-shrink:0">X</div>
											<div>
												<div style="font-family:var(--pm-fd);font-size:12px;font-weight:700;color:var(--pm-t1)">Twitter / X</div>
												<div style="font-family:var(--pm-fm);font-size:10px;color:var(--pm-t3);letter-spacing:.04em">@paulomarcelo</div>
											</div>
											<span style="margin-left:auto;font-size:10px;color:var(--pm-t3)">→</span>
										</a>
									<?php endif; ?>
								</div>
							</div>
						<?php endif; ?>

					</div>
				</div>

			</div>
		</div>
	</div>

</main>

<?php get_footer(); ?>