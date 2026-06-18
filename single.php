<?php

/**
 * PMPortfolio — single.php
 *
 * Template de post individual do blog.
 * URL: /blog/nome-do-post/
 *
 * @package PMPortfolio
 */

defined('ABSPATH') || exit;

get_header();

if (! have_posts()) {
    get_footer();
    return;
}

the_post();

$words   = str_word_count(strip_tags(get_the_content()));
$minutes = max(1, (int) ceil($words / 200));
$cats    = get_the_category();
?>

<div class="pm-read-bar" style="position:fixed;top:60px;left:0;right:0;height:2px;background:var(--pm-bg2);z-index:98">
    <div class="pm-read-bar-fill" id="read-fill" style="height:100%;background:var(--pm-gold);width:0%;transition:width .1s linear"></div>
</div>

<main id="main-content" role="main">

    <!-- BREADCRUMB -->
    <div class="pm-bc">
        <div class="container-xl d-flex align-items-center">
            <a class="pm-bc-link" href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('início', 'pmportfolio'); ?></a>
            <span class="pm-bc-sep">/</span>
            <a class="pm-bc-link" href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>"><?php esc_html_e('blog', 'pmportfolio'); ?></a>
            <span class="pm-bc-sep">/</span>
            <span class="pm-bc-cur"><?php echo esc_html(wp_trim_words(get_the_title(), 5, '...')); ?></span>
        </div>
    </div>

    <div style="background:var(--pm-bg0);padding:3rem 0 5rem">
        <div class="container-xl">
            <div class="row g-5">

                <!-- ARTIGO -->
                <div class="col-lg-8">
                    <article>

                        <!-- HEADER -->
                        <header class="mb-4">
                            <?php if ($cats) : ?>
                                <div class="d-flex flex-wrap gap-2 mb-3">
                                    <?php foreach (array_slice($cats, 0, 3) as $cat) : ?>
                                        <a href="<?php echo esc_url(get_category_link($cat->term_id)); ?>"
                                            class="pm-tag pm-tag-php"
                                            style="text-decoration:none">
                                            <?php echo esc_html($cat->name); ?>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>

                            <h1 style="font-size:clamp(1.7rem,3vw,2.5rem);line-height:1.1;margin-bottom:1rem">
                                <?php the_title(); ?>
                            </h1>

                            <div class="d-flex align-items-center flex-wrap gap-3">
                                <div class="d-flex align-items-center gap-2">
                                    <div style="width:32px;height:32px;border-radius:50%;background:var(--pm-goldm);border:1px solid var(--pm-goldb);display:flex;align-items:center;justify-content:center;font-family:var(--pm-fm);font-size:11px;color:var(--pm-gold)">
                                        PM
                                    </div>
                                    <div>
                                        <div style="font-size:13px;font-weight:500;color:var(--pm-t1)"><?php echo esc_html(get_bloginfo('name')); ?></div>
                                        <div style="font-family:var(--pm-fm);font-size:10px;color:var(--pm-t3);letter-spacing:.04em">Software Engineer</div>
                                    </div>
                                </div>
                                <div style="width:1px;height:26px;background:var(--pm-b2)"></div>
                                <span class="pm-meta"><?php echo esc_html(get_the_date()); ?></span>
                                <div style="width:1px;height:26px;background:var(--pm-b2)"></div>
                                <span class="pm-meta"><?php echo esc_html($minutes); ?> <?php esc_html_e('min de leitura', 'pmportfolio'); ?></span>
                                <?php if (get_the_modified_date() !== get_the_date()) : ?>
                                    <div style="width:1px;height:26px;background:var(--pm-b2)"></div>
                                    <span style="font-family:var(--pm-fm);font-size:10px;color:var(--pm-gold);letter-spacing:.04em">
                                        <?php esc_html_e('atualizado:', 'pmportfolio'); ?> <?php echo esc_html(get_the_modified_date()); ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </header>

                        <!-- THUMBNAIL -->
                        <?php if (has_post_thumbnail()) : ?>
                            <div style="aspect-ratio:21/9;border-radius:var(--pm-rl);overflow:hidden;border:1px solid var(--pm-b2);margin-bottom:2.5rem">
                                <?php the_post_thumbnail('pm-hero', [
                                    'style'    => 'width:100%;height:100%;object-fit:cover;display:block',
                                    'loading'  => 'eager',
                                    'decoding' => 'async',
                                    'alt'      => esc_attr(get_the_title()),
                                ]); ?>
                            </div>
                        <?php endif; ?>

                        <!-- CONTEÚDO -->
                        <div class="pm-art-content">
                            <?php the_content(); ?>
                        </div>

                        <!-- TAGS -->
                        <?php
                        $tags = get_the_tags();
                        if ($tags) :
                        ?>
                            <div class="d-flex align-items-center flex-wrap gap-2 mt-4 pt-4"
                                style="border-top:1px solid var(--pm-b2)">
                                <span style="font-family:var(--pm-fm);font-size:10px;color:var(--pm-t3);letter-spacing:.06em;text-transform:uppercase"><?php esc_html_e('tags:', 'pmportfolio'); ?></span>
                                <?php foreach ($tags as $tag) : ?>
                                    <a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>"
                                        class="pm-stag" style="text-decoration:none">
                                        <?php echo esc_html($tag->name); ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                        <!-- SHARE -->
                        <div style="background:var(--pm-bgc);border:1px solid var(--pm-b2);border-radius:var(--pm-rl);padding:1.1rem 1.25rem;display:flex;align-items:center;flex-wrap:wrap;gap:.75rem;margin-top:1.5rem">
                            <span style="font-family:var(--pm-fm);font-size:11px;color:var(--pm-t3);letter-spacing:.05em;flex:1">
                                <?php esc_html_e('gostou? compartilhe o artigo', 'pmportfolio'); ?>
                            </span>
                            <div class="d-flex gap-2">
                                <button class="pm-share-btn"
                                    style="padding:5px 14px;background:var(--pm-bg2);border:1px solid var(--pm-b2);border-radius:var(--pm-r);font-family:var(--pm-fm);font-size:10px;color:var(--pm-t2);cursor:pointer;transition:all .15s;letter-spacing:.04em"
                                    onclick="navigator.clipboard&&navigator.clipboard.writeText(location.href);this.textContent='copiado!';setTimeout(()=>this.textContent='copiar link',1500)">
                                    <?php esc_html_e('copiar link', 'pmportfolio'); ?>
                                </button>
                                <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(get_permalink()); ?>&text=<?php echo urlencode(get_the_title()); ?>"
                                    target="_blank" rel="noopener noreferrer"
                                    style="padding:5px 14px;background:var(--pm-bg2);border:1px solid var(--pm-b2);border-radius:var(--pm-r);font-family:var(--pm-fm);font-size:10px;color:var(--pm-t2);cursor:pointer;transition:all .15s;letter-spacing:.04em;text-decoration:none">
                                    Twitter/X
                                </a>
                                <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo urlencode(get_permalink()); ?>&title=<?php echo urlencode(get_the_title()); ?>"
                                    target="_blank" rel="noopener noreferrer"
                                    style="padding:5px 14px;background:var(--pm-bg2);border:1px solid var(--pm-b2);border-radius:var(--pm-r);font-family:var(--pm-fm);font-size:10px;color:var(--pm-t2);cursor:pointer;transition:all .15s;letter-spacing:.04em;text-decoration:none">
                                    LinkedIn
                                </a>
                            </div>
                        </div>

                        <!-- AUTHOR BOX -->
                        <div style="background:var(--pm-bgc);border:1px solid var(--pm-b2);border-radius:var(--pm-rl);padding:1.4rem;display:flex;gap:1rem;margin-top:1.5rem">
                            <div style="width:52px;height:52px;border-radius:50%;background:var(--pm-goldm);border:2px solid var(--pm-goldb);display:flex;align-items:center;justify-content:center;font-family:var(--pm-fm);font-size:15px;color:var(--pm-gold);flex-shrink:0">
                                PM
                            </div>
                            <div>
                                <div style="font-family:var(--pm-fd);font-size:15px;font-weight:700;color:var(--pm-t1);letter-spacing:-.01em;margin-bottom:2px">
                                    <?php echo esc_html(get_bloginfo('name')); ?>
                                </div>
                                <div style="font-family:var(--pm-fm);font-size:10px;color:var(--pm-gold);letter-spacing:.04em;margin-bottom:.5rem">
                                    Software Engineer · WordPress Architect
                                </div>
                                <p style="font-size:13px;line-height:1.7;color:var(--pm-t2);font-weight:300">
                                    <?php echo esc_html(get_bloginfo('description')); ?>
                                </p>
                            </div>
                        </div>

                        <!-- POSTS RELACIONADOS -->
                        <?php
                        $related = new WP_Query([
                            'post_type'      => 'post',
                            'posts_per_page' => 2,
                            'post__not_in'   => [get_the_ID()],
                            'orderby'        => 'rand',
                            'no_found_rows'  => true,
                        ]);

                        if ($related->have_posts()) :
                        ?>
                            <div class="mt-5 pt-4" style="border-top:1px solid var(--pm-b2)">
                                <h3 style="font-size:1rem;margin-bottom:1.25rem;font-family:var(--pm-fd);color:var(--pm-t1)">
                                    <?php esc_html_e('artigos relacionados', 'pmportfolio'); ?>
                                </h3>
                                <div class="row g-3">
                                    <?php while ($related->have_posts()) : $related->the_post(); ?>
                                        <div class="col-6">
                                            <a href="<?php echo esc_url(get_permalink()); ?>"
                                                style="text-decoration:none;display:block;background:var(--pm-bgc);border:1px solid var(--pm-b2);border-radius:var(--pm-rl);overflow:hidden;transition:all .2s"
                                                onmouseover="this.style.borderColor='var(--pm-b1)';this.style.transform='translateY(-2px)'"
                                                onmouseout="this.style.borderColor='var(--pm-b2)';this.style.transform='none'">
                                                <div style="aspect-ratio:16/9;background:var(--pm-bg2);display:flex;align-items:center;justify-content:center;font-size:1.5rem;overflow:hidden;position:relative">
                                                    <?php if (has_post_thumbnail()) : ?>
                                                        <?php the_post_thumbnail('pm-blog', [
                                                            'style'    => 'width:100%;height:100%;object-fit:cover;position:absolute;inset:0',
                                                            'loading'  => 'lazy',
                                                            'alt'      => '',
                                                        ]); ?>
                                                    <?php else : ?>
                                                        <span style="color:var(--pm-gold);opacity:.3">{ }</span>
                                                    <?php endif; ?>
                                                </div>
                                                <div style="padding:.75rem 1rem">
                                                    <div style="font-family:var(--pm-fd);font-size:12px;font-weight:700;color:var(--pm-t1);letter-spacing:-.01em;line-height:1.35;margin-bottom:4px">
                                                        <?php echo esc_html(wp_trim_words(get_the_title(), 8, '...')); ?>
                                                    </div>
                                                    <span class="pm-meta"><?php echo esc_html(get_the_date()); ?></span>
                                                </div>
                                            </a>
                                        </div>
                                    <?php endwhile;
                                    wp_reset_postdata(); ?>
                                </div>
                            </div>
                        <?php endif; ?>

                    </article>
                </div>

                <!-- TOC SIDEBAR -->
                <div class="col-lg-4 d-none d-lg-block">
                    <div style="position:sticky;top:72px">
                        <div style="background:var(--pm-bgc);border:1px solid var(--pm-b2);border-radius:var(--pm-rl);overflow:hidden">
                            <div style="padding:.85rem 1.1rem;border-bottom:1px solid var(--pm-b2);background:var(--pm-bg2);display:flex;align-items:center;justify-content:space-between">
                                <span style="font-family:var(--pm-fd);font-size:12px;font-weight:700;color:var(--pm-t1)"><?php esc_html_e('neste artigo', 'pmportfolio'); ?></span>
                                <span style="font-family:var(--pm-fm);font-size:10px;color:var(--pm-gold);letter-spacing:.04em" id="toc-prog">0%</span>
                            </div>
                            <div id="toc-list" style="padding:.5rem 0">
                                <!-- Gerado via JS com base nos H2/H3 do artigo -->
                                <p style="font-family:var(--pm-fm);font-size:10px;color:var(--pm-t3);padding:.5rem 1.1rem;letter-spacing:.04em">
                                    <?php esc_html_e('carregando...', 'pmportfolio'); ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</main>

<!-- Progress bar + TOC via JS -->
<script>
    document.addEventListener('DOMContentLoaded', function() {

        // PROGRESS BAR
        var fill = document.getElementById('read-fill');
        var prog = document.getElementById('toc-prog');
        if (fill) {
            window.addEventListener('scroll', function() {
                var scrollTop = window.scrollY;
                var docHeight = document.documentElement.scrollHeight - window.innerHeight;
                var pct = docHeight > 0 ? Math.round((scrollTop / docHeight) * 100) : 0;
                fill.style.width = pct + '%';
                if (prog) prog.textContent = pct + '%';
            });
        }

        // TOC — gera automaticamente com base nos H2/H3 do artigo
        var content = document.querySelector('.pm-art-content');
        var list = document.getElementById('toc-list');
        if (!content || !list) return;

        var headings = content.querySelectorAll('h2, h3');
        if (!headings.length) {
            list.innerHTML = '<p style="font-family:var(--pm-fm);font-size:10px;color:var(--pm-t3);padding:.5rem 1.1rem;letter-spacing:.04em"><?php esc_html_e("Sem seções", "pmportfolio"); ?></p>';
            return;
        }

        list.innerHTML = '';
        headings.forEach(function(h, i) {
            // Adiciona ID ao heading se não tiver
            if (!h.id) {
                h.id = 'section-' + i;
            }
            var item = document.createElement('a');
            item.href = '#' + h.id;
            item.textContent = h.textContent;
            item.style.cssText = 'display:block;padding:.4rem 1.1rem;font-family:var(--pm-fm);font-size:11px;color:var(--pm-t3);cursor:pointer;transition:all .15s;letter-spacing:.02em;border-left:2px solid transparent;text-decoration:none' + (h.tagName === 'H3' ? ';padding-left:1.75rem;font-size:10px' : '');
            item.addEventListener('mouseover', function() {
                this.style.color = 'var(--pm-t1)';
                this.style.background = 'var(--pm-bg2)';
            });
            item.addEventListener('mouseout', function() {
                this.style.color = 'var(--pm-t3)';
                this.style.background = 'transparent';
            });
            item.addEventListener('click', function(e) {
                e.preventDefault();
                document.getElementById(h.id).scrollIntoView({
                    behavior: 'smooth'
                });
            });
            list.appendChild(item);
        });

    });
</script>

<?php get_footer(); ?>