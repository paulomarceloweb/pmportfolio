<?php

/**
 * PMPortfolio — SEO Meta Box
 *
 * Meta box de SEO no editor de posts/páginas/CPTs.
 * Permite definir título, descrição e visualizar
 * como o post aparece no Google e redes sociais.
 *
 * Campos salvos:
 *   _seo_title       → título SEO customizado
 *   _seo_description → descrição SEO customizada
 *   _seo_title_en    → título SEO em inglês
 *   _seo_noindex     → noindex manual
 *
 * @package PMPortfolio\SEO
 */

namespace PMPortfolio\SEO;

use PMPortfolio\Admin\Settings_API;

defined('ABSPATH') || exit;

class SEO_Meta_Box
{

    /**
     * Post types que recebem a meta box.
     */
    private array $post_types = ['post', 'page', 'portfolio', 'servico'];

    /**
     * Registra os hooks.
     */
    public function register(): void
    {
        add_action('add_meta_boxes', [$this, 'add']);
        add_action('save_post',      [$this, 'save'], 10, 2);
        add_action('admin_head',     [$this, 'styles']);
        add_action('admin_footer',   [$this, 'scripts']);
    }

    /**
     * Adiciona a meta box em todos os post types suportados.
     */
    public function add(): void
    {
        foreach ($this->post_types as $post_type) {
            add_meta_box(
                'pm_seo',
                '🔍 SEO — PMPortfolio',
                [$this, 'render'],
                $post_type,
                'normal',
                'high'
            );
        }
    }

    /**
     * Renderiza o conteúdo da meta box.
     */
    public function render(\WP_Post $post): void
    {

        wp_nonce_field('pm_seo_save', 'pm_seo_nonce');

        $title       = get_post_meta($post->ID, '_seo_title',       true);
        $description = get_post_meta($post->ID, '_seo_description', true);
        $title_en    = get_post_meta($post->ID, '_seo_title_en',    true);
        $noindex     = get_post_meta($post->ID, '_seo_noindex',     true);
        $separator   = Settings_API::get('title_separator', '—');
        $site_name   = get_bloginfo('name');

        // Preview do título
        $preview_title = $title
            ? $title . ' ' . $separator . ' ' . $site_name
            : get_the_title($post) . ' ' . $separator . ' ' . $site_name;

        // Preview da descrição
        $preview_desc = $description
            ?: wp_trim_words(wp_strip_all_tags($post->post_content), 30, '...');

        // Preview da URL
        $preview_url = get_permalink($post) ?: home_url('/' . $post->post_name . '/');
?>

        <div class="pm-seo-box">

            <!-- PREVIEW GOOGLE -->
            <div class="pm-seo-section">
                <div class="pm-seo-label">Preview — Google</div>
                <div class="pm-seo-preview">
                    <div class="pm-seo-prev-url"><?php echo esc_html($preview_url); ?></div>
                    <div class="pm-seo-prev-title" id="pm-prev-title"><?php echo esc_html($preview_title); ?></div>
                    <div class="pm-seo-prev-desc" id="pm-prev-desc"><?php echo esc_html($preview_desc ?: 'Nenhuma descrição definida.'); ?></div>
                </div>
            </div>

            <!-- CAMPOS SEO -->
            <div class="pm-seo-section">
                <div class="pm-seo-row">
                    <label class="pm-seo-label" for="pm_seo_title">
                        Título SEO
                        <span class="pm-seo-hint">Deixe vazio para usar o título do post</span>
                    </label>
                    <input type="text"
                        id="pm_seo_title"
                        name="pm_seo_title"
                        value="<?php echo esc_attr($title); ?>"
                        placeholder="<?php echo esc_attr(get_the_title($post) . ' ' . $separator . ' ' . $site_name); ?>"
                        class="pm-seo-input"
                        maxlength="60">
                    <div class="pm-seo-counter">
                        <span id="pm-title-count"><?php echo esc_html(mb_strlen($preview_title)); ?></span>/60
                        <span class="pm-seo-status" id="pm-title-status"></span>
                    </div>
                </div>

                <div class="pm-seo-row">
                    <label class="pm-seo-label" for="pm_seo_description">
                        Meta Descrição
                        <span class="pm-seo-hint">Recomendado: 120–160 caracteres</span>
                    </label>
                    <textarea id="pm_seo_description"
                        name="pm_seo_description"
                        class="pm-seo-input pm-seo-textarea"
                        maxlength="160"
                        placeholder="Descreva o conteúdo desta página de forma atrativa..."><?php echo esc_textarea($description); ?></textarea>
                    <div class="pm-seo-counter">
                        <span id="pm-desc-count"><?php echo esc_html(mb_strlen($description)); ?></span>/160
                        <span class="pm-seo-status" id="pm-desc-status"></span>
                    </div>
                </div>

                <div class="pm-seo-row">
                    <label class="pm-seo-label" for="pm_seo_title_en">
                        Título SEO — English
                        <span class="pm-seo-hint">Usado nas URLs /en/*</span>
                    </label>
                    <input type="text"
                        id="pm_seo_title_en"
                        name="pm_seo_title_en"
                        value="<?php echo esc_attr($title_en); ?>"
                        placeholder="English SEO title..."
                        class="pm-seo-input"
                        maxlength="60">
                </div>

                <div class="pm-seo-row">
                    <label class="pm-seo-check">
                        <input type="checkbox"
                            name="pm_seo_noindex"
                            value="1"
                            <?php checked($noindex, '1'); ?>>
                        <span>Não indexar esta página (noindex)</span>
                    </label>
                    <p class="pm-seo-hint" style="margin-top:4px">
                        Use para páginas de teste, rascunhos ou conteúdo duplicado.
                    </p>
                </div>
            </div>

            <!-- SCORE SIMPLES -->
            <div class="pm-seo-section">
                <div class="pm-seo-label">Score de SEO</div>
                <div class="pm-seo-score-wrap" id="pm-score-wrap">
                    <?php $this->render_score($post, $title, $description); ?>
                </div>
            </div>

        </div>
    <?php
    }

    /**
     * Renderiza o score de SEO simples.
     */
    private function render_score(\WP_Post $post, string $title, string $description): void
    {

        $checks = [];
        $score  = 0;

        // Título SEO definido
        if ($title) {
            $checks[] = ['✅', 'Título SEO customizado definido'];
            $score += 20;
        } else {
            $checks[] = ['⚠️', 'Título SEO não definido — usando título do post'];
            $score += 10;
        }

        // Tamanho do título
        $title_len = mb_strlen($title ?: get_the_title($post));
        if ($title_len >= 30 && $title_len <= 60) {
            $checks[] = ['✅', "Título com tamanho ideal ({$title_len} caracteres)"];
            $score += 20;
        } else {
            $checks[] = ['⚠️', "Título fora do tamanho ideal ({$title_len} caracteres — ideal: 30–60)"];
            $score += 5;
        }

        // Meta descrição
        $desc_len = mb_strlen($description);
        if ($description && $desc_len >= 120 && $desc_len <= 160) {
            $checks[] = ['✅', "Meta descrição ideal ({$desc_len} caracteres)"];
            $score += 20;
        } elseif ($description) {
            $checks[] = ['⚠️', "Meta descrição fora do tamanho ideal ({$desc_len} caracteres — ideal: 120–160)"];
            $score += 10;
        } else {
            $checks[] = ['❌', 'Meta descrição não definida'];
        }

        // Imagem destacada
        if (has_post_thumbnail($post->ID)) {
            $checks[] = ['✅', 'Imagem destacada definida (usada no Open Graph)'];
            $score += 20;
        } else {
            $checks[] = ['❌', 'Sem imagem destacada — Open Graph usará imagem padrão do tema'];
        }

        // Conteúdo mínimo
        $word_count = str_word_count(wp_strip_all_tags($post->post_content));
        if ($word_count >= 300) {
            $checks[] = ['✅', "Conteúdo com {$word_count} palavras"];
            $score += 20;
        } elseif ($word_count > 0) {
            $checks[] = ['⚠️', "Conteúdo com apenas {$word_count} palavras (recomendado: 300+)"];
            $score += 10;
        } else {
            $checks[] = ['⚠️', 'Conteúdo vazio — use os campos de meta para descrever o conteúdo'];
            $score += 5;
        }

        // Cor do score
        $color = $score >= 80 ? '#28a745' : ($score >= 50 ? '#ffc107' : '#dc3545');
        $label = $score >= 80 ? 'Bom' : ($score >= 50 ? 'Melhorar' : 'Fraco');

        echo '<div class="pm-seo-score" style="color:' . esc_attr($color) . '">';
        echo '<span class="pm-seo-score-num">' . esc_html($score) . '</span>';
        echo '<span class="pm-seo-score-label">/100 — ' . esc_html($label) . '</span>';
        echo '</div>';
        echo '<ul class="pm-seo-checks">';
        foreach ($checks as $check) {
            echo '<li>' . $check[0] . ' ' . esc_html($check[1]) . '</li>';
        }
        echo '</ul>';
    }

    /**
     * Salva os campos da meta box.
     */
    public function save(int $post_id, \WP_Post $post): void
    {

        // Verifica nonce
        if (
            ! isset($_POST['pm_seo_nonce']) ||
            ! wp_verify_nonce($_POST['pm_seo_nonce'], 'pm_seo_save')
        ) {
            return;
        }

        // Verifica permissão
        if (! current_user_can('edit_post', $post_id)) {
            return;
        }

        // Não salva em autosave
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        // Salva título SEO
        $title = isset($_POST['pm_seo_title'])
            ? sanitize_text_field($_POST['pm_seo_title'])
            : '';
        update_post_meta($post_id, '_seo_title', $title);

        // Salva descrição
        $description = isset($_POST['pm_seo_description'])
            ? sanitize_textarea_field($_POST['pm_seo_description'])
            : '';
        update_post_meta($post_id, '_seo_description', $description);

        // Salva título EN
        $title_en = isset($_POST['pm_seo_title_en'])
            ? sanitize_text_field($_POST['pm_seo_title_en'])
            : '';
        update_post_meta($post_id, '_seo_title_en', $title_en);

        // Salva noindex
        $noindex = isset($_POST['pm_seo_noindex']) ? '1' : '';
        update_post_meta($post_id, '_seo_noindex', $noindex);
    }

    /**
     * Estilos da meta box.
     */
    public function styles(): void
    {
        $screen = get_current_screen();
        if (! $screen || ! in_array($screen->post_type, $this->post_types, true)) {
            return;
        }
    ?>
        <style>
            .pm-seo-box {
                font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            }

            .pm-seo-section {
                padding: 12px 0;
                border-bottom: 1px solid #f0f0f0;
            }

            .pm-seo-section:last-child {
                border-bottom: none;
            }

            .pm-seo-label {
                font-size: 12px;
                font-weight: 600;
                color: #1d2327;
                text-transform: uppercase;
                letter-spacing: .04em;
                margin-bottom: 8px;
                display: block;
            }

            .pm-seo-hint {
                font-weight: 400;
                color: #787c82;
                text-transform: none;
                letter-spacing: 0;
                margin-left: 8px;
            }

            .pm-seo-row {
                margin-bottom: 12px;
            }

            .pm-seo-input {
                width: 100%;
                padding: 8px 10px;
                border: 1px solid #dcdcde;
                border-radius: 4px;
                font-size: 13px;
                box-sizing: border-box;
            }

            .pm-seo-input:focus {
                border-color: #2271b1;
                outline: none;
                box-shadow: 0 0 0 1px #2271b1;
            }

            .pm-seo-textarea {
                height: 70px;
                resize: vertical;
            }

            .pm-seo-counter {
                font-size: 11px;
                color: #787c82;
                margin-top: 4px;
            }

            .pm-seo-status {
                margin-left: 6px;
                font-weight: 600;
            }

            .pm-seo-check {
                display: flex;
                align-items: center;
                gap: 8px;
                cursor: pointer;
                font-size: 13px;
            }

            .pm-seo-preview {
                background: #fff;
                border: 1px solid #dcdcde;
                border-radius: 6px;
                padding: 14px 16px;
            }

            .pm-seo-prev-url {
                font-size: 12px;
                color: #202124;
                margin-bottom: 2px;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            .pm-seo-prev-title {
                font-size: 18px;
                color: #1a0dab;
                line-height: 1.3;
                margin-bottom: 4px;
                max-width: 600px;
            }

            .pm-seo-prev-desc {
                font-size: 13px;
                color: #4d5156;
                line-height: 1.5;
                max-width: 600px;
            }

            .pm-seo-score {
                display: flex;
                align-items: baseline;
                gap: 6px;
                margin-bottom: 10px;
            }

            .pm-seo-score-num {
                font-size: 2rem;
                font-weight: 800;
            }

            .pm-seo-score-label {
                font-size: 14px;
                font-weight: 500;
            }

            .pm-seo-checks {
                margin: 0;
                padding: 0;
                list-style: none;
                display: flex;
                flex-direction: column;
                gap: 6px;
            }

            .pm-seo-checks li {
                font-size: 12px;
                color: #3c434a;
                line-height: 1.4;
            }
        </style>
    <?php
    }

    /**
     * Scripts da meta box — preview em tempo real.
     */
    public function scripts(): void
    {
        $screen = get_current_screen();
        if (! $screen || ! in_array($screen->post_type, $this->post_types, true)) {
            return;
        }
    ?>
        <script>
            (function() {
                var titleEl = document.getElementById('pm_seo_title');
                var descEl = document.getElementById('pm_seo_description');
                var prevT = document.getElementById('pm-prev-title');
                var prevD = document.getElementById('pm-prev-desc');
                var titleCt = document.getElementById('pm-title-count');
                var descCt = document.getElementById('pm-desc-count');
                var titleSt = document.getElementById('pm-title-status');
                var descSt = document.getElementById('pm-desc-status');
                var postTitle = document.getElementById('title');
                var separator = '<?php echo esc_js(Settings_API::get('title_separator', '—')); ?>';
                var siteName = '<?php echo esc_js(get_bloginfo('name')); ?>';

                function updateTitle() {
                    if (!titleEl || !prevT) return;
                    var val = titleEl.value || (postTitle ? postTitle.value : '');
                    var full = val + ' ' + separator + ' ' + siteName;
                    prevT.textContent = full;
                    var len = full.length;
                    if (titleCt) titleCt.textContent = len;
                    if (titleSt) {
                        if (len < 30) {
                            titleSt.textContent = '— muito curto';
                            titleSt.style.color = '#dc3545';
                        } else if (len <= 60) {
                            titleSt.textContent = '— ✓ ideal';
                            titleSt.style.color = '#28a745';
                        } else {
                            titleSt.textContent = '— muito longo';
                            titleSt.style.color = '#dc3545';
                        }
                    }
                }

                function updateDesc() {
                    if (!descEl || !prevD) return;
                    var val = descEl.value;
                    prevD.textContent = val || 'Nenhuma descrição definida.';
                    var len = val.length;
                    if (descCt) descCt.textContent = len;
                    if (descSt) {
                        if (len === 0) {
                            descSt.textContent = '— não definida';
                            descSt.style.color = '#dc3545';
                        } else if (len < 120) {
                            descSt.textContent = '— muito curta';
                            descSt.style.color = '#ffc107';
                        } else if (len <= 160) {
                            descSt.textContent = '— ✓ ideal';
                            descSt.style.color = '#28a745';
                        } else {
                            descSt.textContent = '— muito longa';
                            descSt.style.color = '#dc3545';
                        }
                    }
                }

                if (titleEl) titleEl.addEventListener('input', updateTitle);
                if (postTitle) postTitle.addEventListener('input', updateTitle);
                if (descEl) descEl.addEventListener('input', updateDesc);

                updateTitle();
                updateDesc();
            })();
        </script>
<?php
    }
}
