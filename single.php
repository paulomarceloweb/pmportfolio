<?php

/**
 * PMPortfolio — single.php
 * Template de post individual do blog.
 * URL: /blog/nome-do-post/
 * @package PMPortfolio
 */

defined('ABSPATH') || exit;

use PMPortfolio\Multilingual\Language_Manager;

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
            <a class="pm-bc-link" href="<?php echo esc_url(home_url('/')); ?>">
                <?php echo esc_html(Language_Manager::t('início', 'home')); ?>
            </a>
            <span class="pm-bc-sep">/</span>
            <a class="pm-bc-link" href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>">
                <?php echo esc_html(Language_Manager::t('blog', 'blog')); ?>
            </a>
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
                                            class="pm-tag pm-tag-php" style="text-decoration:none">
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
                                    <?php
                                    $avatar = \PMPortfolio\Admin\Settings_API::get('avatar');
                                    if ($avatar) :
                                    ?>
                                        <img src="<?php echo esc_url($avatar); ?>"
                                            alt="Paulo Marcelo"
                                            style="width:32px;height:32px;border-radius:50%;object-fit:cover;border:1px solid var(--pm-goldb);flex-shrink:0">
                                    <?php else : ?>
                                        <div style="width:32px;height:32px;border-radius:50%;background:var(--pm-goldm);border:1px solid var(--pm-goldb);display:flex;align-items:center;justify-content:center;font-family:var(--pm-fm);font-size:11px;color:var(--pm-gold)">PM</div>
                                    <?php endif; ?>
                                    <div>
                                        <div style="font-size:13px;font-weight:500;color:var(--pm-t1)">Paulo Marcelo</div>
                                        <div style="font-family:var(--pm-fm);font-size:10px;color:var(--pm-t3);letter-spacing:.04em">WordPress Developer</div>
                                    </div>
                                </div>
                                <div style="width:1px;height:26px;background:var(--pm-b2)"></div>
                                <span class="pm-meta"><?php echo esc_html(get_the_date()); ?></span>
                                <div style="width:1px;height:26px;background:var(--pm-b2)"></div>
                                <span class="pm-meta">
                                    <?php echo esc_html($minutes); ?> <?php echo esc_html(Language_Manager::t('min de leitura', 'min read')); ?>
                                </span>
                                <?php if (get_the_modified_date() !== get_the_date()) : ?>
                                    <div style="width:1px;height:26px;background:var(--pm-b2)"></div>
                                    <span style="font-family:var(--pm-fm);font-size:10px;color:var(--pm-gold);letter-spacing:.04em">
                                        <?php echo esc_html(Language_Manager::t('atualizado:', 'updated:')); ?> <?php echo esc_html(get_the_modified_date()); ?>
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
                        <?php $tags = get_the_tags();
                        if ($tags) : ?>
                            <div class="d-flex align-items-center flex-wrap gap-2 mt-4 pt-4"
                                style="border-top:1px solid var(--pm-b2)">
                                <span style="font-family:var(--pm-fm);font-size:10px;color:var(--pm-t3);letter-spacing:.06em;text-transform:uppercase">
                                    <?php echo esc_html(Language_Manager::t('tags:', 'tags:')); ?>
                                </span>
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
                                <?php echo esc_html(Language_Manager::t('gostou? compartilhe o artigo', 'enjoyed it? share this article')); ?>
                            </span>
                            <div class="d-flex gap-2">
                                <button class="pm-share-btn"
                                    style="padding:5px 14px;background:var(--pm-bg2);border:1px solid var(--pm-b2);border-radius:var(--pm-r);font-family:var(--pm-fm);font-size:10px;color:var(--pm-t2);cursor:pointer;transition:all .15s;letter-spacing:.04em"
                                    onclick="var t=this;navigator.clipboard&&navigator.clipboard.writeText(location.href);t.textContent='<?php echo esc_js(Language_Manager::t('copiado!', 'copied!')); ?>';setTimeout(function(){t.textContent='<?php echo esc_js(Language_Manager::t('copiar link', 'copy link')); ?>'},1500)">
                                    <?php echo esc_html(Language_Manager::t('copiar link', 'copy link')); ?>
                                </button>
                                <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(get_permalink()); ?>&text=<?php echo urlencode(get_the_title()); ?>"
                                    target="_blank" rel="noopener noreferrer"
                                    style="padding:5px 14px;background:var(--pm-bg2);border:1px solid var(--pm-b2);border-radius:var(--pm-r);font-family:var(--pm-fm);font-size:10px;color:var(--pm-t2);text-decoration:none;transition:all .15s;letter-spacing:.04em">
                                    Twitter/X
                                </a>
                                <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo urlencode(get_permalink()); ?>&title=<?php echo urlencode(get_the_title()); ?>"
                                    target="_blank" rel="noopener noreferrer"
                                    style="padding:5px 14px;background:var(--pm-bg2);border:1px solid var(--pm-b2);border-radius:var(--pm-r);font-family:var(--pm-fm);font-size:10px;color:var(--pm-t2);text-decoration:none;transition:all .15s;letter-spacing:.04em">
                                    LinkedIn
                                </a>
                            </div>
                        </div>

                        <!-- AUTHOR BOX -->
                        <div style="background:var(--pm-bgc);border:1px solid var(--pm-b2);border-radius:var(--pm-rl);padding:1.4rem;display:flex;gap:1rem;margin-top:1.5rem">
                            <?php if ($avatar) : ?>
                                <img src="<?php echo esc_url($avatar); ?>"
                                    alt="Paulo Marcelo"
                                    style="width:52px;height:52px;border-radius:50%;object-fit:cover;border:2px solid var(--pm-goldb);flex-shrink:0">
                            <?php else : ?>
                                <div style="width:52px;height:52px;border-radius:50%;background:var(--pm-goldm);border:2px solid var(--pm-goldb);display:flex;align-items:center;justify-content:center;font-family:var(--pm-fm);font-size:15px;color:var(--pm-gold);flex-shrink:0">PM</div>
                            <?php endif; ?>
                            <div>
                                <div style="font-family:var(--pm-fd);font-size:15px;font-weight:700;color:var(--pm-t1);letter-spacing:-.01em;margin-bottom:2px">
                                    Paulo Marcelo Gonçalves
                                </div>
                                <div style="font-family:var(--pm-fm);font-size:10px;color:var(--pm-gold);letter-spacing:.04em;margin-bottom:.5rem">
                                    <?php echo esc_html(Language_Manager::t('WordPress Developer · Marketing Tech Leader', 'WordPress Developer · Marketing Tech Leader')); ?>
                                </div>
                                <p style="font-size:13px;line-height:1.7;color:var(--pm-t2);font-weight:300">
                                    <?php echo esc_html(wp_trim_words(get_bloginfo('description'), 20, '...')); ?>
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
                                    <?php echo esc_html(Language_Manager::t('artigos relacionados', 'related articles')); ?>
                                </h3>
                                <div class="row g-3">
                                    <?php while ($related->have_posts()) : $related->the_post(); ?>
                                        <div class="col-6">
                                            <a href="<?php echo esc_url(get_permalink()); ?>"
                                                style="text-decoration:none;display:block;background:var(--pm-bgc);border:1px solid var(--pm-b2);border-radius:var(--pm-rl);overflow:hidden;transition:all .2s"
                                                onmouseover="this.style.borderColor='var(--pm-b1)';this.style.transform='translateY(-2px)'"
                                                onmouseout="this.style.borderColor='var(--pm-b2)';this.style.transform='none'">
                                                <div style="aspect-ratio:16/9;background:var(--pm-bg2);display:flex;align-items:center;justify-content:center;overflow:hidden;position:relative">
                                                    <?php if (has_post_thumbnail()) : ?>
                                                        <?php the_post_thumbnail('pm-blog', [
                                                            'style'   => 'width:100%;height:100%;object-fit:cover;position:absolute;inset:0',
                                                            'loading' => 'lazy',
                                                            'alt'     => '',
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
                    <div style="position:sticky;top:72px;display:flex;flex-direction:column;gap:1rem">

                        <!-- TOC -->
                        <div style="background:var(--pm-bgc);border:1px solid var(--pm-b2);border-radius:var(--pm-rl);overflow:hidden">
                            <div style="padding:.85rem 1.1rem;border-bottom:1px solid var(--pm-b2);background:var(--pm-bg2);display:flex;align-items:center;justify-content:space-between">
                                <span style="font-family:var(--pm-fd);font-size:12px;font-weight:700;color:var(--pm-t1)">
                                    <?php echo esc_html(Language_Manager::t('neste artigo', 'in this article')); ?>
                                </span>
                                <span style="font-family:var(--pm-fm);font-size:10px;color:var(--pm-gold);letter-spacing:.04em" id="toc-prog">0%</span>
                            </div>
                            <div id="toc-list" style="padding:.35rem 0;max-height:60vh;overflow-y:auto">
                                <p style="font-family:var(--pm-fm);font-size:10px;color:var(--pm-t3);padding:.5rem 1.1rem;letter-spacing:.04em">
                                    <?php echo esc_html(Language_Manager::t('carregando...', 'loading...')); ?>
                                </p>
                            </div>
                        </div>

                        <!-- AUTHOR CARD -->
                        <div style="background:var(--pm-bgc);border:1px solid var(--pm-b2);border-radius:var(--pm-rl);padding:1.1rem">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <?php if ($avatar) : ?>
                                    <img src="<?php echo esc_url($avatar); ?>"
                                        alt="Paulo Marcelo"
                                        style="width:40px;height:40px;border-radius:50%;object-fit:cover;border:2px solid var(--pm-goldb);flex-shrink:0">
                                <?php else : ?>
                                    <div style="width:40px;height:40px;border-radius:50%;background:var(--pm-goldm);border:2px solid var(--pm-goldb);display:flex;align-items:center;justify-content:center;font-family:var(--pm-fm);font-size:13px;color:var(--pm-gold);flex-shrink:0">PM</div>
                                <?php endif; ?>
                                <div>
                                    <div style="font-family:var(--pm-fd);font-size:13px;font-weight:700;color:var(--pm-t1)">Paulo Marcelo</div>
                                    <div style="font-family:var(--pm-fm);font-size:9px;color:var(--pm-gold);letter-spacing:.04em">WordPress Developer</div>
                                </div>
                            </div>
                            <p style="font-size:11px;line-height:1.65;color:var(--pm-t2);font-weight:300;margin:0">
                                <?php echo esc_html(wp_trim_words(get_bloginfo('description'), 20, '...')); ?>
                            </p>
                        </div>

                        <!-- COMPARTILHAR -->
                        <div style="background:var(--pm-bgc);border:1px solid var(--pm-b2);border-radius:var(--pm-rl);padding:1rem 1.1rem">
                            <div style="font-family:var(--pm-fd);font-size:11px;font-weight:700;color:var(--pm-t1);margin-bottom:.6rem">
                                <?php echo esc_html(Language_Manager::t('compartilhar', 'share')); ?>
                            </div>
                            <div class="d-flex flex-column gap-2">
                                <button onclick="var t=this;navigator.clipboard&&navigator.clipboard.writeText(location.href);t.textContent='✓ <?php echo esc_js(Language_Manager::t('link copiado!', 'link copied!')); ?>';setTimeout(function(){t.textContent='⎘ <?php echo esc_js(Language_Manager::t('copiar link', 'copy link')); ?>'},1500)"
                                    style="padding:6px 12px;background:var(--pm-bg2);border:1px solid var(--pm-b2);border-radius:var(--pm-r);font-family:var(--pm-fm);font-size:10px;color:var(--pm-t2);cursor:pointer;text-align:left;transition:all .15s;letter-spacing:.03em">
                                    ⎘ <?php echo esc_html(Language_Manager::t('copiar link', 'copy link')); ?>
                                </button>
                                <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(get_permalink()); ?>&text=<?php echo urlencode(get_the_title()); ?>"
                                    target="_blank" rel="noopener noreferrer"
                                    style="padding:6px 12px;background:var(--pm-bg2);border:1px solid var(--pm-b2);border-radius:var(--pm-r);font-family:var(--pm-fm);font-size:10px;color:var(--pm-t2);text-decoration:none;transition:all .15s;letter-spacing:.03em">
                                    𝕏 Twitter / X
                                </a>
                                <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo urlencode(get_permalink()); ?>&title=<?php echo urlencode(get_the_title()); ?>"
                                    target="_blank" rel="noopener noreferrer"
                                    style="padding:6px 12px;background:var(--pm-bg2);border:1px solid var(--pm-b2);border-radius:var(--pm-r);font-family:var(--pm-fm);font-size:10px;color:var(--pm-t2);text-decoration:none;transition:all .15s;letter-spacing:.03em">
                                    in LinkedIn
                                </a>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

</main>

<script>
    document.addEventListener('DOMContentLoaded', function() {

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

        var content = document.querySelector('.pm-art-content');
        var list = document.getElementById('toc-list');
        if (!content || !list) return;

        var headings = content.querySelectorAll('h2, h3');
        if (!headings.length) {
            list.innerHTML = '<p style="font-family:var(--pm-fm);font-size:10px;color:var(--pm-t3);padding:.75rem 1.1rem;letter-spacing:.04em"><?php echo esc_js(Language_Manager::t('Sem seções neste artigo.', 'No sections in this article.')); ?></p>';
            return;
        }

        list.innerHTML = '';
        var tocItems = [];

        headings.forEach(function(h, i) {
            if (!h.id) h.id = 'sec-' + i;

            var isH3 = h.tagName === 'H3';
            var text = h.textContent.trim();
            var label = text.length > 48 ? text.slice(0, 48) + '…' : text;

            var a = document.createElement('a');
            a.href = '#' + h.id;
            a.dataset.id = h.id;
            a.textContent = label;
            a.title = text;
            a.style.cssText = [
                'display:block',
                'padding:' + (isH3 ? '.3rem 1.1rem .3rem 1.9rem' : '.4rem 1.1rem'),
                'font-family:var(--pm-fm)',
                'font-size:' + (isH3 ? '10px' : '11px'),
                'color:var(--pm-t3)',
                'cursor:pointer',
                'transition:all .15s',
                'letter-spacing:.02em',
                'border-left:2px solid transparent',
                'text-decoration:none',
                'line-height:1.4',
                isH3 ? 'font-weight:300' : 'font-weight:500',
            ].join(';');

            a.addEventListener('click', function(e) {
                e.preventDefault();
                document.getElementById(h.id).scrollIntoView({
                    behavior: 'smooth'
                });
            });

            list.appendChild(a);
            tocItems.push({
                el: h,
                link: a
            });
        });

        function updateActive() {
            var scrollY = window.scrollY;
            var active = null;
            tocItems.forEach(function(item) {
                var top = item.el.getBoundingClientRect().top + scrollY - 100;
                if (scrollY >= top) active = item;
            });
            tocItems.forEach(function(item) {
                var isActive = item === active;
                item.link.style.color = isActive ? 'var(--pm-gold)' : 'var(--pm-t3)';
                item.link.style.borderLeft = isActive ? '2px solid var(--pm-gold)' : '2px solid transparent';
                item.link.style.background = isActive ? 'var(--pm-goldm)' : 'transparent';
                item.link.style.fontWeight = isActive ? '600' : (item.el.tagName === 'H3' ? '300' : '500');
            });
        }

        window.addEventListener('scroll', updateActive, {
            passive: true
        });
        updateActive();

    });
</script>

<?php get_footer(); ?>