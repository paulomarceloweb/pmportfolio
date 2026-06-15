<?php
/**
 * PMPortfolio — Page Contato
 *
 * Template da página de contato.
 * URL: /contato/
 *
 * @package PMPortfolio
 */

defined( 'ABSPATH' ) || exit;

use PMPortfolio\Admin\Settings_API;

get_header();

$email    = Settings_API::get( 'email',    'paulo@exemplo.com' );
$whatsapp = Settings_API::get( 'whatsapp', '' );
$address  = Settings_API::get( 'address',  'Brasil' );
$linkedin = Settings_API::get( 'social_linkedin', '' );
$github   = Settings_API::get( 'social_github',   '' );
$twitter  = Settings_API::get( 'social_twitter',  '' );

$wa_url = $whatsapp
	? 'https://wa.me/' . preg_replace( '/\D/', '', $whatsapp )
	: '#';
?>

<main id="main-content" role="main">

	<!-- BREADCRUMB -->
	<div class="pm-bc">
		<div class="container-xl d-flex align-items-center">
			<a class="pm-bc-link" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'início', 'pmportfolio' ); ?></a>
			<span class="pm-bc-sep">/</span>
			<span class="pm-bc-cur"><?php esc_html_e( 'contato', 'pmportfolio' ); ?></span>
		</div>
	</div>

	<!-- HERO -->
	<div style="background:var(--pm-bg0);padding:4rem 0 3rem;border-bottom:1px solid var(--pm-b2);position:relative;overflow:hidden">
		<div class="pm-hero-grid" aria-hidden="true"></div>
		<div class="container-xl position-relative" style="z-index:1">
			<div class="row align-items-center g-4">
				<div class="col-lg-7">
					<div class="pm-eyebrow mb-2"><?php esc_html_e( 'contato', 'pmportfolio' ); ?></div>
					<h1 style="font-size:clamp(2rem,3.5vw,3rem);line-height:1.1;margin-bottom:1rem">
						<?php esc_html_e( 'Vamos ', 'pmportfolio' ); ?>
						<span style="color:var(--pm-gold)"><?php esc_html_e( 'conversar', 'pmportfolio' ); ?></span>
					</h1>
					<p style="font-size:15px;max-width:52ch;line-height:1.85;color:var(--pm-t2);font-weight:300">
						<?php esc_html_e( 'Estou disponível para projetos freelance, consultorias e posições em produto. Escolha o canal que preferir — respondo em até 24h.', 'pmportfolio' ); ?>
					</p>
				</div>
				<div class="col-lg-5 d-none d-lg-flex justify-content-end">
					<div style="background:var(--pm-goldm);border:1px solid var(--pm-goldb);border-radius:var(--pm-rl);padding:1.25rem;max-width:280px;width:100%">
						<div class="d-flex align-items-center gap-2 mb-2">
							<span class="pm-dot-live"></span>
							<div style="font-family:var(--pm-fd);font-size:13px;font-weight:700;color:var(--pm-t1)"><?php esc_html_e( 'Disponível para projetos', 'pmportfolio' ); ?></div>
						</div>
						<p style="font-size:12px;color:var(--pm-t2);font-weight:300;line-height:1.6;margin:0">
							<?php esc_html_e( 'Aceitando novos clientes. Agenda limitada — entre em contato para garantir sua vaga.', 'pmportfolio' ); ?>
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
					<a href="mailto:<?php echo esc_attr( $email ); ?>"
					   style="background:var(--pm-bgc);border:1px solid var(--pm-b2);border-radius:var(--pm-rl);padding:1.25rem;display:flex;align-items:center;gap:1rem;transition:all .2s;text-decoration:none"
					   onmouseover="this.style.borderColor='var(--pm-b1)'" onmouseout="this.style.borderColor='var(--pm-b2)'">
						<div style="width:40px;height:40px;border-radius:var(--pm-r);background:var(--pm-goldm);display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0">✉️</div>
						<div>
							<div style="font-family:var(--pm-fm);font-size:9px;color:var(--pm-t3);letter-spacing:.07em;text-transform:uppercase;margin-bottom:2px"><?php esc_html_e( 'e-mail', 'pmportfolio' ); ?></div>
							<div style="font-family:var(--pm-fb);font-size:13px;font-weight:500;color:var(--pm-t1)"><?php echo esc_html( $email ); ?></div>
							<div style="font-family:var(--pm-fm);font-size:10px;color:var(--pm-t3);letter-spacing:.04em;margin-top:1px"><?php esc_html_e( 'resposta em até 24h', 'pmportfolio' ); ?></div>
						</div>
						<span style="margin-left:auto;font-family:var(--pm-fm);font-size:12px;color:var(--pm-t3)">→</span>
					</a>
				</div>

				<?php if ( $whatsapp ) : ?>
				<div class="col-md-4">
					<a href="<?php echo esc_url( $wa_url ); ?>"
					   target="_blank" rel="noopener noreferrer"
					   style="background:var(--pm-bgc);border:1px solid var(--pm-b2);border-radius:var(--pm-rl);padding:1.25rem;display:flex;align-items:center;gap:1rem;transition:all .2s;text-decoration:none"
					   onmouseover="this.style.borderColor='var(--pm-b1)'" onmouseout="this.style.borderColor='var(--pm-b2)'">
						<div style="width:40px;height:40px;border-radius:var(--pm-r);background:var(--pm-tealm);display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0">💬</div>
						<div>
							<div style="font-family:var(--pm-fm);font-size:9px;color:var(--pm-t3);letter-spacing:.07em;text-transform:uppercase;margin-bottom:2px"><?php esc_html_e( 'whatsapp', 'pmportfolio' ); ?></div>
							<div style="font-family:var(--pm-fb);font-size:13px;font-weight:500;color:var(--pm-t1)"><?php echo esc_html( $whatsapp ); ?></div>
							<div style="font-family:var(--pm-fm);font-size:10px;color:var(--pm-t3);letter-spacing:.04em;margin-top:1px"><?php esc_html_e( 'seg–sex, 9h–18h', 'pmportfolio' ); ?></div>
						</div>
						<span style="margin-left:auto;font-family:var(--pm-fm);font-size:12px;color:var(--pm-t3)">→</span>
					</a>
				</div>
				<?php endif; ?>

				<div class="col-md-4">
					<div style="background:var(--pm-bgc);border:1px solid var(--pm-b2);border-radius:var(--pm-rl);padding:1.25rem;display:flex;align-items:center;gap:1rem">
						<div style="width:40px;height:40px;border-radius:var(--pm-r);background:var(--pm-purplem);display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0">📅</div>
						<div>
							<div style="font-family:var(--pm-fm);font-size:9px;color:var(--pm-t3);letter-spacing:.07em;text-transform:uppercase;margin-bottom:2px"><?php esc_html_e( 'agendar chamada', 'pmportfolio' ); ?></div>
							<div style="font-family:var(--pm-fb);font-size:13px;font-weight:500;color:var(--pm-t1)">Calendly</div>
							<div style="font-family:var(--pm-fm);font-size:10px;color:var(--pm-t3);letter-spacing:.04em;margin-top:1px"><?php esc_html_e( '30 min · gratuito', 'pmportfolio' ); ?></div>
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

					<div class="pm-eyebrow mb-3"><?php esc_html_e( 'formulário de contato', 'pmportfolio' ); ?></div>

					<div style="background:var(--pm-bgc);border:1px solid var(--pm-b2);border-radius:var(--pm-rl);padding:2rem;position:relative;overflow:hidden">
						<div style="position:absolute;top:0;left:0;right:0;height:2px;background:linear-gradient(90deg,transparent,var(--pm-gold),transparent)"></div>

						<div id="contact-form">
							<!-- Honeypot anti-spam -->
							<div style="display:none!important" aria-hidden="true">
								<input type="text" name="website" tabindex="-1" autocomplete="off">
							</div>

							<div class="row g-3">
								<div class="col-md-6">
									<label class="pm-field-label" for="f-name"><?php esc_html_e( 'nome', 'pmportfolio' ); ?> <span>*</span></label>
									<input type="text" class="pm-input" id="f-name" placeholder="<?php esc_attr_e( 'Seu nome completo', 'pmportfolio' ); ?>">
								</div>
								<div class="col-md-6">
									<label class="pm-field-label" for="f-email"><?php esc_html_e( 'e-mail', 'pmportfolio' ); ?> <span>*</span></label>
									<input type="email" class="pm-input" id="f-email" placeholder="seu@email.com">
								</div>
								<div class="col-md-6">
									<label class="pm-field-label" for="f-company"><?php esc_html_e( 'empresa', 'pmportfolio' ); ?></label>
									<input type="text" class="pm-input" id="f-company" placeholder="<?php esc_attr_e( 'Nome da empresa (opcional)', 'pmportfolio' ); ?>">
								</div>
								<div class="col-md-6">
									<label class="pm-field-label" for="f-service"><?php esc_html_e( 'serviço de interesse', 'pmportfolio' ); ?> <span>*</span></label>
									<select class="pm-input pm-select" id="f-service">
										<option value=""><?php esc_html_e( 'Selecione um serviço', 'pmportfolio' ); ?></option>
										<option value="tema"><?php esc_html_e( 'Tema WordPress Premium', 'pmportfolio' ); ?></option>
										<option value="perf"><?php esc_html_e( 'Otimização & Performance', 'pmportfolio' ); ?></option>
										<option value="api"><?php esc_html_e( 'API & Integrações', 'pmportfolio' ); ?></option>
										<option value="seo"><?php esc_html_e( 'SEO Técnico', 'pmportfolio' ); ?></option>
										<option value="cons"><?php esc_html_e( 'Consultoria Técnica', 'pmportfolio' ); ?></option>
										<option value="outro"><?php esc_html_e( 'Outro', 'pmportfolio' ); ?></option>
									</select>
								</div>
								<div class="col-12">
									<label class="pm-field-label" for="f-message"><?php esc_html_e( 'mensagem', 'pmportfolio' ); ?> <span>*</span></label>
									<textarea class="pm-input pm-textarea" id="f-message" placeholder="<?php esc_attr_e( 'Descreva seu projeto, objetivos e qualquer detalhe relevante...', 'pmportfolio' ); ?>"></textarea>
								</div>
								<div class="col-12">
									<div id="form-error" class="pm-form-error"></div>
									<div class="d-flex align-items-center gap-3 flex-wrap mt-2">
										<button class="pm-btn-p" onclick="pmSubmitForm()" id="f-submit">
											<?php esc_html_e( 'Enviar mensagem →', 'pmportfolio' ); ?>
										</button>
										<p style="font-family:var(--pm-fm);font-size:10px;color:var(--pm-t3);letter-spacing:.04em;line-height:1.5;margin:0">
											<?php esc_html_e( '🔒 Seus dados são protegidos. Sem spam.', 'pmportfolio' ); ?>
										</p>
									</div>
								</div>
							</div>
						</div>

						<div class="pm-form-success" id="form-success"></div>

					</div>

					<!-- FAQ -->
					<div class="mt-5">
						<div class="pm-eyebrow mb-3"><?php esc_html_e( 'dúvidas rápidas', 'pmportfolio' ); ?></div>
						<div style="background:var(--pm-bgc);border:1px solid var(--pm-b2);border-radius:var(--pm-rl);padding:.5rem 1.25rem">
							<?php
							$faqs = [
								[
									__( 'Em quanto tempo você responde?', 'pmportfolio' ),
									__( 'Em até 24h em dias úteis. Para urgências, WhatsApp é o canal mais rápido.', 'pmportfolio' ),
								],
								[
									__( 'Atende clientes fora do Brasil?', 'pmportfolio' ),
									__( 'Sim. Atendo remotamente em português e inglês. Já trabalhei com clientes em Portugal, EUA e Argentina.', 'pmportfolio' ),
								],
								[
									__( 'Precisa assinar contrato?', 'pmportfolio' ),
									__( 'Sim, sempre. Um contrato protege tanto o cliente quanto o desenvolvedor — escopo, prazo e pagamentos ficam claros para todos.', 'pmportfolio' ),
								],
							];
							foreach ( $faqs as $faq ) :
							?>
							<div class="pm-faq-item">
								<button class="pm-faq-q" onclick="pmToggleFaq(this)">
									<span><?php echo esc_html( $faq[0] ); ?></span>
									<span class="pm-faq-icon">+</span>
								</button>
								<div class="pm-faq-a">
									<p><?php echo esc_html( $faq[1] ); ?></p>
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
								<span style="font-family:var(--pm-fd);font-size:12px;font-weight:700;color:var(--pm-t1)"><?php esc_html_e( 'informações', 'pmportfolio' ); ?></span>
							</div>
							<div style="padding:1rem 1.1rem">
								<?php
								$info = [
									[ '📍', __( 'localização', 'pmportfolio' ), $address ],
									[ '🌐', __( 'idiomas', 'pmportfolio' ),    __( 'Português · English', 'pmportfolio' ) ],
									[ '⏱️', __( 'fuso horário', 'pmportfolio' ),'GMT-3 (BRT)' ],
									[ '💼', __( 'modalidade', 'pmportfolio' ),  __( 'Remoto · Worldwide', 'pmportfolio' ) ],
								];
								foreach ( $info as $row ) :
								?>
								<div style="display:flex;align-items:flex-start;gap:10px;padding:.5rem 0;border-bottom:1px solid var(--pm-b3)">
									<span style="font-size:14px;flex-shrink:0;margin-top:1px;width:20px;text-align:center"><?php echo $row[0]; // phpcs:ignore ?></span>
									<div>
										<div style="font-family:var(--pm-fm);font-size:9px;color:var(--pm-t3);letter-spacing:.06em;text-transform:uppercase"><?php echo esc_html( $row[1] ); ?></div>
										<div style="font-size:13px;color:var(--pm-t1);margin-top:1px"><?php echo esc_html( $row[2] ); ?></div>
									</div>
								</div>
								<?php endforeach; ?>
							</div>
						</div>

						<!-- REDES SOCIAIS -->
						<?php if ( $linkedin || $github || $twitter ) : ?>
						<div>
							<div style="font-family:var(--pm-fd);font-size:12px;font-weight:700;color:var(--pm-t1);margin-bottom:.75rem"><?php esc_html_e( 'redes & perfis', 'pmportfolio' ); ?></div>
							<div class="d-flex flex-column gap-2">
								<?php if ( $linkedin ) : ?>
								<a href="<?php echo esc_url( $linkedin ); ?>" target="_blank" rel="noopener noreferrer"
								   style="display:flex;align-items:center;gap:10px;padding:.65rem 1rem;background:var(--pm-bg2);border:1px solid var(--pm-b2);border-radius:var(--pm-r);text-decoration:none;transition:all .15s"
								   onmouseover="this.style.borderColor='var(--pm-b1)'" onmouseout="this.style.borderColor='var(--pm-b2)'">
									<div style="width:28px;height:28px;border-radius:4px;background:#0077b5;display:flex;align-items:center;justify-content:center;font-family:var(--pm-fm);font-size:11px;font-weight:700;color:#fff;flex-shrink:0">LI</div>
									<div>
										<div style="font-family:var(--pm-fd);font-size:12px;font-weight:700;color:var(--pm-t1)">LinkedIn</div>
										<div style="font-family:var(--pm-fm);font-size:10px;color:var(--pm-t3);letter-spacing:.04em">/in/paulomarcelo</div>
									</div>
									<span style="margin-left:auto;font-family:var(--pm-fm);font-size:10px;color:var(--pm-t3)">→</span>
								</a>
								<?php endif; ?>
								<?php if ( $github ) : ?>
								<a href="<?php echo esc_url( $github ); ?>" target="_blank" rel="noopener noreferrer"
								   style="display:flex;align-items:center;gap:10px;padding:.65rem 1rem;background:var(--pm-bg2);border:1px solid var(--pm-b2);border-radius:var(--pm-r);text-decoration:none;transition:all .15s"
								   onmouseover="this.style.borderColor='var(--pm-b1)'" onmouseout="this.style.borderColor='var(--pm-b2)'">
									<div style="width:28px;height:28px;border-radius:4px;background:#1a1a2e;display:flex;align-items:center;justify-content:center;font-family:var(--pm-fm);font-size:11px;font-weight:700;color:#fff;flex-shrink:0">GH</div>
									<div>
										<div style="font-family:var(--pm-fd);font-size:12px;font-weight:700;color:var(--pm-t1)">GitHub</div>
										<div style="font-family:var(--pm-fm);font-size:10px;color:var(--pm-t3);letter-spacing:.04em">@paulomarcelo</div>
									</div>
									<span style="margin-left:auto;font-family:var(--pm-fm);font-size:10px;color:var(--pm-t3)">→</span>
								</a>
								<?php endif; ?>
								<?php if ( $twitter ) : ?>
								<a href="<?php echo esc_url( $twitter ); ?>" target="_blank" rel="noopener noreferrer"
								   style="display:flex;align-items:center;gap:10px;padding:.65rem 1rem;background:var(--pm-bg2);border:1px solid var(--pm-b2);border-radius:var(--pm-r);text-decoration:none;transition:all .15s"
								   onmouseover="this.style.borderColor='var(--pm-b1)'" onmouseout="this.style.borderColor='var(--pm-b2)'">
									<div style="width:28px;height:28px;border-radius:4px;background:#1a1a1a;display:flex;align-items:center;justify-content:center;font-family:var(--pm-fm);font-size:11px;font-weight:700;color:#fff;flex-shrink:0">X</div>
									<div>
										<div style="font-family:var(--pm-fd);font-size:12px;font-weight:700;color:var(--pm-t1)">Twitter / X</div>
										<div style="font-family:var(--pm-fm);font-size:10px;color:var(--pm-t3);letter-spacing:.04em">@paulomarcelo</div>
									</div>
									<span style="margin-left:auto;font-family:var(--pm-fm);font-size:10px;color:var(--pm-t3)">→</span>
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