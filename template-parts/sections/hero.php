<?php

/**
 * PMPortfolio — Hero Section
 * @package PMPortfolio
 */

defined('ABSPATH') || exit;

use PMPortfolio\Multilingual\Language_Manager;

?>



<section class="pm-hero d-flex align-items-center"
    style="min-height:calc(100vh - 60px)"
    aria-label="<?php echo esc_attr(Language_Manager::t('Apresentação', 'Introduction')); ?>">

    <div class="pm-hero-grid" aria-hidden="true"></div>
    <div class="pm-hero-orb" aria-hidden="true"></div>
    <div class="pm-hero-orb2" aria-hidden="true"></div>

    <div class="container-xl position-relative" style="z-index:1">
        <div class="row align-items-center g-5 py-5">

            <div class="col-lg-6">

                <!-- Status -->
                <div class="d-flex align-items-center gap-2 mb-3">
                    <span class="pm-dot-live" aria-hidden="true"></span>
                    <span style="font-family:var(--pm-fm);font-size:10px;color:var(--pm-t3);letter-spacing:.06em" id="h-status">
                        <?php echo esc_html(Language_Manager::t('disponível para projetos', 'available for projects')); ?>
                    </span>
                </div>

                <!-- Nome -->
                <h1 class="pm-hero-name mb-2">
                    Paulo<br><span>Marcelo</span>
                </h1>

                <!-- Typewriter -->
                <p class="pm-hero-role mb-3" aria-live="polite">
                    <span aria-hidden="true">// </span><span id="typed"></span><span class="pm-cursor" aria-hidden="true"></span>
                </p>

                <!-- Descrição -->
                <p class="mb-4" style="font-size:15px;line-height:1.85;max-width:46ch" id="h-desc">
                    <?php if (Language_Manager::is('en')) : ?>
                        I build <strong>systems that scale</strong> — from database to pixel. Specialist in web architecture, performance and experiences that <strong>turn code into results</strong>.
                    <?php else : ?>
                        Construo <strong>sistemas que escalam</strong> — do banco de dados ao pixel. Especialista em arquitetura web, performance e experiências que <strong>convertem código em resultado</strong>.
                    <?php endif; ?>
                </p>

                <!-- CTAs -->
                <div class="d-flex flex-wrap gap-2 mb-4">
                    <a href="<?php echo esc_url(home_url(Language_Manager::is('en') ? '/en/portfolio/' : '/portfolio/')); ?>"
                        class="pm-btn-p" id="h-btn1">
                        <?php echo esc_html(Language_Manager::t('Ver portfólio →', 'View portfolio →')); ?>
                    </a>
                    <a href="<?php echo esc_url(home_url(Language_Manager::is('en') ? '/en/contact/' : '/contato/')); ?>"
                        class="pm-btn-s" id="h-btn2">
                        <?php echo esc_html(Language_Manager::t('Falar comigo', 'Get in touch')); ?>
                    </a>
                </div>

                <!-- Stats -->
                <div class="pm-hero-stats">
                    <div class="row g-4">
                        <div class="col-auto">
                            <div class="pm-stat-num">47<em>+</em></div>
                            <div class="pm-stat-lbl" id="h-s1"><?php echo esc_html(Language_Manager::t('projetos', 'projects')); ?></div>
                        </div>
                        <div class="col-auto">
                            <div class="pm-stat-num">8<em>+</em></div>
                            <div class="pm-stat-lbl" id="h-s2"><?php echo esc_html(Language_Manager::t('anos de exp.', 'years exp.')); ?></div>
                        </div>
                        <div class="col-auto">
                            <div class="pm-stat-num">32<em>+</em></div>
                            <div class="pm-stat-lbl" id="h-s3"><?php echo esc_html(Language_Manager::t('clientes', 'clients')); ?></div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Code card decorativo -->
            <div class="col-lg-6 d-none d-lg-flex justify-content-end">
                <div class="pm-code-card w-100" style="max-width:440px" aria-hidden="true">
                    <div class="pm-code-head">
                        <div class="d-flex gap-1">
                            <div style="width:10px;height:10px;border-radius:50%;background:#ff5f57"></div>
                            <div style="width:10px;height:10px;border-radius:50%;background:#ffbd2e"></div>
                            <div style="width:10px;height:10px;border-radius:50%;background:#28c840"></div>
                        </div>
                        <span style="font-family:var(--pm-fm);font-size:9px;color:var(--pm-t3)">class-theme.php</span>
                        <span class="d-flex align-items-center gap-1">
                            <span class="pm-dot-live" style="width:5px;height:5px"></span>
                            <span style="font-family:var(--pm-fm);font-size:9px;color:var(--pm-t3)">dev</span>
                        </span>
                    </div>
                    <div class="pm-code-body">
                        <div class="pm-ln"><span class="pm-ln-n">1</span><span class="syn-c">// pmportfolio — Theme Core</span></div>
                        <div class="pm-ln"><span class="pm-ln-n">2</span><span class="syn-k">namespace </span><span class="syn-cl">PMPortfolio\Core</span><span style="color:var(--pm-t3)">;</span></div>
                        <div class="pm-ln"><span class="pm-ln-n">3</span>&nbsp;</div>
                        <div class="pm-ln"><span class="pm-ln-n">4</span><span class="syn-k">class </span><span class="syn-cl">Theme</span><span style="color:var(--pm-t3)"> {</span></div>
                        <div class="pm-ln"><span class="pm-ln-n">5</span>&nbsp;&nbsp;<span class="syn-k">public function </span><span class="syn-f">boot</span><span style="color:var(--pm-t3)">(): void {</span></div>
                        <div class="pm-ln"><span class="pm-ln-n">6</span>&nbsp;&nbsp;&nbsp;&nbsp;<span style="color:var(--pm-t1)">$this</span><span style="color:var(--pm-t3)">-></span><span class="syn-f">init_modules</span><span style="color:var(--pm-t3)">();</span></div>
                        <div class="pm-ln"><span class="pm-ln-n">7</span>&nbsp;&nbsp;<span style="color:var(--pm-t3)">}</span></div>
                        <div class="pm-ln"><span class="pm-ln-n">8</span><span style="color:var(--pm-t3)">}</span><span class="pm-code-cur"></span></div>
                    </div>
                    <div class="d-flex flex-wrap gap-1 p-2" style="border-top:1px solid var(--pm-b2)">
                        <span class="pm-badge pm-badge-gold">PHP 8.2</span>
                        <span class="pm-badge pm-badge-gold">WordPress 6.4</span>
                        <span class="pm-badge pm-badge-teal">Bootstrap 5.3</span>
                        <span class="pm-badge pm-badge-purple">PSR-4</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>