<?php

/**
 * PMPortfolio — home.php
 * Template do archive do blog. URL: /blog/
 * @package PMPortfolio
 */

defined('ABSPATH') || exit;

use PMPortfolio\Multilingual\Language_Manager;

get_header();
?>

<main id="main-content" role="main">

    <!-- BREADCRUMB -->
    <div class="pm-bc">
        <div class="container-xl d-flex align-items-center">
            <a class="pm-bc-link" href="<?php echo esc_url(home_url('/')); ?>">
                <?php echo esc_html(Language_Manager::t('início', 'home')); ?>
            </a>
            <span class="pm-bc-sep">/</span>
            <span class="pm-bc-cur"><?php echo esc_html(Language_Manager::t('blog', 'blog')); ?></span>
        </div>
    </div>

    <!-- HERO -->
    <div style="background:var(--pm-bg0);padding:3.5rem 0 2.5rem;border-bottom:1px solid var(--pm-b2)">
        <div class="container-xl">
            <div class="pm-eyebrow mb-2">
                <?php echo esc_html(Language_Manager::t('blog técnico', 'tech blog')); ?>
            </div>
            <h1 class="mb-2" style="font-size:clamp(2rem,3.5vw,2.8rem)">
                <?php if (Language_Manager::is('en')) : ?>
                    Articles on <span style="color:var(--pm-gold)">dev & architecture</span>
                <?php else : ?>
                    Artigos sobre <span style="color:var(--pm-gold)">dev & arquitetura</span>
                <?php endif; ?>
            </h1>
            <p style="font-size:14px;max-width:52ch;color:var(--pm-t2);font-weight:300">
                <?php echo esc_html(Language_Manager::t(
                    'PHP avançado, WordPress internals, performance, SEO técnico e reflexões sobre engenharia de software.',
                    'Advanced PHP, WordPress internals, performance, technical SEO and software engineering insights.'
                )); ?>
            </p>
        </div>
    </div>

    <!-- POSTS -->
    <div style="background:var(--pm-bg0);padding:3rem 0 5rem">
        <div class="container-xl">
            <div class="row g-4">

                <!-- COLUNA PRINCIPAL -->
                <div class="col-lg-8">

                    <?php if (have_posts()) : ?>

                        <?php
                        $first = true;
                        while (have_posts()) : the_post();
                            $words   = str_word_count(strip_tags(get_the_content()));
                            $minutes = max(1, (int) ceil($words / 200));

                            if ($first) :
                                $first = false;
                        ?>

                                <a href="<?php echo esc_url(get_permalink()); ?>"
                                    style="text-decoration:none;display:block;margin-bottom:1.5rem">
                                    <div style="background:var(--pm-bgc);border:1px solid var(--pm-b2);border-radius:var(--pm-rl);overflow:hidden;transition:all .25s"
                                        onmouseover="this.style.borderColor='var(--pm-b1)';this.style.transform='translateY(-2px)'"
                                        onmouseout="this.style.borderColor='var(--pm-b2)';this.style.transform='none'">

                                        <div style="aspect-ratio:21/9;background:linear-gradient(135deg,var(--pm-bg2),var(--pm-bg3));position:relative;display:flex;align-items:center;justify-content:center;overflow:hidden">
                                            <?php if (has_post_thumbnail()) : ?>
                                                <?php the_post_thumbnail('pm-blog', [
                                                    'style'    => 'width:100%;height:100%;object-fit:cover;position:absolute;inset:0',
                                                    'loading'  => 'eager',
                                                    'decoding' => 'async',
                                                    'alt'      => esc_attr(get_the_title()),
                                                ]); ?>
                                            <?php else : ?>
                                                <span style="font-family:var(--pm-fm);font-size:2.5rem;color:var(--pm-gold);opacity:.3">{ }</span>
                                            <?php endif; ?>
                                            <div style="position:absolute;top:12px;right:12px;padding:3px 10px;background:var(--pm-gold);color:var(--pm-tinv);font-family:var(--pm-fm);font-size:9px;border-radius:3px;letter-spacing:.04em;font-weight:600">
                                                <?php echo esc_html(Language_Manager::t('destaque', 'featured')); ?>
                                            </div>
                                            <?php $cats = get_the_category();
                                            if ($cats) : ?>
                                                <div style="position:absolute;top:12px;left:12px">
                                                    <span class="pm-tag pm-tag-php"><?php echo esc_html($cats[0]->name); ?></span>
                                                </div>
                                            <?php endif; ?>
                                        </div>

                                        <div style="padding:1.5rem 1.75rem">
                                            <div class="d-flex align-items-center gap-1 pm-meta mb-2">
                                                <span><?php echo esc_html(get_the_date()); ?></span>
                                                <span class="pm-meta-dot">·</span>
                                                <span><?php echo esc_html($minutes); ?> <?php echo esc_html(Language_Manager::t('min de leitura', 'min read')); ?></span>
                                            </div>
                                            <h2 style="font-family:var(--pm-fd);font-size:1.4rem;font-weight:800;color:var(--pm-t1);letter-spacing:-.02em;line-height:1.2;margin-bottom:.75rem">
                                                <?php the_title(); ?>
                                            </h2>
                                            <p style="font-size:14px;color:var(--pm-t2);font-weight:300;line-height:1.75;margin-bottom:1.25rem;max-width:62ch">
                                                <?php echo esc_html(get_the_excerpt()); ?>
                                            </p>
                                            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2"
                                                style="border-top:1px solid var(--pm-b2);padding-top:1rem">
                                                <div class="d-flex align-items-center gap-2">
                                                    <div style="width:28px;height:28px;border-radius:50%;background:var(--pm-goldm);border:1px solid var(--pm-goldb);display:flex;align-items:center;justify-content:center;font-family:var(--pm-fm);font-size:10px;color:var(--pm-gold)">PM</div>
                                                    <span style="font-family:var(--pm-fm);font-size:10px;color:var(--pm-t2)"><?php echo esc_html(get_bloginfo('name')); ?></span>
                                                </div>
                                                <span style="font-family:var(--pm-fm);font-size:10px;color:var(--pm-gold);letter-spacing:.04em">
                                                    <?php echo esc_html(Language_Manager::t('ler artigo →', 'read article →')); ?>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </a>

                            <?php else : ?>

                                <a href="<?php echo esc_url(get_permalink()); ?>"
                                    style="text-decoration:none;display:block">
                                    <div style="background:var(--pm-bgc);border:1px solid var(--pm-b2);border-radius:var(--pm-rl);overflow:hidden;display:flex;transition:all .2s;margin-bottom:.75rem"
                                        onmouseover="this.style.borderColor='var(--pm-b1)';this.style.transform='translateX(3px)'"
                                        onmouseout="this.style.borderColor='var(--pm-b2)';this.style.transform='none'">

                                        <div style="width:110px;min-height:100%;background:var(--pm-bg2);display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:1.5rem;overflow:hidden;position:relative">
                                            <?php if (has_post_thumbnail()) : ?>
                                                <?php the_post_thumbnail('pm-thumb', [
                                                    'style'    => 'width:100%;height:100%;object-fit:cover;position:absolute;inset:0',
                                                    'loading'  => 'lazy',
                                                    'decoding' => 'async',
                                                    'alt'      => esc_attr(get_the_title()),
                                                ]); ?>
                                            <?php else : ?>
                                                <span style="color:var(--pm-gold);opacity:.4">{ }</span>
                                            <?php endif; ?>
                                        </div>

                                        <div style="padding:.9rem 1.1rem;flex:1">
                                            <?php $cats = get_the_category();
                                            if ($cats) : ?>
                                                <div style="margin-bottom:.4rem">
                                                    <span class="pm-tag pm-tag-php" style="font-size:8px"><?php echo esc_html($cats[0]->name); ?></span>
                                                </div>
                                            <?php endif; ?>
                                            <div style="font-family:var(--pm-fd);font-size:13px;font-weight:700;color:var(--pm-t1);letter-spacing:-.01em;line-height:1.35;margin-bottom:.3rem">
                                                <?php the_title(); ?>
                                            </div>
                                            <p style="font-size:11px;color:var(--pm-t2);font-weight:300;line-height:1.65;margin-bottom:.4rem">
                                                <?php echo esc_html(wp_trim_words(get_the_excerpt(), 15, '...')); ?>
                                            </p>
                                            <div class="pm-meta d-flex align-items-center">
                                                <span><?php echo esc_html(get_the_date()); ?></span>
                                                <span class="pm-meta-dot">·</span>
                                                <span><?php echo esc_html($minutes); ?> <?php echo esc_html(Language_Manager::t('min', 'min')); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </a>

                            <?php endif; ?>
                        <?php endwhile; ?>

                        <div class="d-flex justify-content-center mt-4">
                            <?php
                            the_posts_pagination([
                                'mid_size'  => 2,
                                'prev_text' => '← ' . Language_Manager::t('anterior', 'previous'),
                                'next_text' => Language_Manager::t('próxima', 'next') . ' →',
                            ]);
                            ?>
                        </div>

                    <?php else : ?>

                        <div style="text-align:center;padding:4rem 0">
                            <p style="font-family:var(--pm-fm);font-size:12px;color:var(--pm-t3);letter-spacing:.06em">
                                <?php echo esc_html(Language_Manager::t('Nenhum artigo publicado ainda.', 'No articles published yet.')); ?>
                            </p>
                            <p style="font-size:13px;color:var(--pm-t2);margin-top:.5rem">
                                <?php echo esc_html(Language_Manager::t(
                                    'Em breve novos artigos sobre PHP, WordPress e arquitetura.',
                                    'Coming soon: articles about PHP, WordPress and architecture.'
                                )); ?>
                            </p>
                        </div>

                    <?php endif; ?>

                </div>

                <!-- SIDEBAR -->
                <div class="col-lg-4 d-flex flex-column gap-4">

                    <!-- NEWSLETTER -->
                    <div style="background:var(--pm-bgc);border:1px solid var(--pm-b2);border-radius:var(--pm-rl);overflow:hidden">
                        <div style="padding:.8rem 1.1rem;border-bottom:1px solid var(--pm-b2);background:var(--pm-bg2)">
                            <span style="font-family:var(--pm-fd);font-size:12px;font-weight:700;color:var(--pm-t1)">
                                <?php echo esc_html(Language_Manager::t('newsletter', 'newsletter')); ?>
                            </span>
                        </div>
                        <div style="padding:1rem 1.1rem">
                            <p style="font-size:12px;line-height:1.65;margin-bottom:.75rem;color:var(--pm-t2)">
                                <?php echo esc_html(Language_Manager::t('Conteúdo técnico toda semana. Sem spam.', 'Technical content every week. No spam.')); ?>
                            </p>
                            <input type="email" class="pm-mc-input-sm mb-2" id="sw-email"
                                placeholder="<?php echo esc_attr(Language_Manager::t('seu@email.com', 'your@email.com')); ?>">
                            <button class="pm-btn-p w-100 justify-content-center" style="font-size:12px"
                                onclick="pmMcSubmit('sw-email','sw-wrap','sw-ok')">
                                <?php echo esc_html(Language_Manager::t('Inscrever', 'Subscribe')); ?>
                            </button>
                            <p id="sw-ok" style="display:none;font-family:var(--pm-fm);font-size:11px;color:var(--pm-teal);margin-top:6px"></p>
                        </div>
                    </div>

                    <!-- ARTIGOS RECENTES -->
                    <div style="background:var(--pm-bgc);border:1px solid var(--pm-b2);border-radius:var(--pm-rl);overflow:hidden">
                        <div style="padding:.8rem 1.1rem;border-bottom:1px solid var(--pm-b2);background:var(--pm-bg2)">
                            <span style="font-family:var(--pm-fd);font-size:12px;font-weight:700;color:var(--pm-t1)">
                                <?php echo esc_html(Language_Manager::t('artigos recentes', 'recent articles')); ?>
                            </span>
                        </div>
                        <div style="padding:1rem 1.1rem;display:flex;flex-direction:column;gap:.75rem">
                            <?php
                            $recentes = new WP_Query([
                                'post_type'      => 'post',
                                'posts_per_page' => 4,
                                'post_status'    => 'publish',
                                'no_found_rows'  => true,
                            ]);
                            while ($recentes->have_posts()) : $recentes->the_post();
                            ?>
                                <a href="<?php echo esc_url(get_permalink()); ?>"
                                    style="display:flex;align-items:flex-start;gap:.75rem;text-decoration:none;transition:opacity .15s"
                                    onmouseover="this.style.opacity='.7'" onmouseout="this.style.opacity='1'">
                                    <div style="width:44px;height:44px;background:var(--pm-bg2);border-radius:var(--pm-r);flex-shrink:0;display:flex;align-items:center;justify-content:center;overflow:hidden;position:relative">
                                        <?php if (has_post_thumbnail()) : ?>
                                            <?php the_post_thumbnail('thumbnail', [
                                                'style'   => 'width:100%;height:100%;object-fit:cover;position:absolute;inset:0',
                                                'loading' => 'lazy',
                                                'alt'     => '',
                                            ]); ?>
                                        <?php else : ?>
                                            <span style="color:var(--pm-gold);opacity:.4;font-size:.9rem">{ }</span>
                                        <?php endif; ?>
                                    </div>
                                    <div>
                                        <div style="font-size:12px;color:var(--pm-t1);font-weight:500;line-height:1.35">
                                            <?php echo esc_html(wp_trim_words(get_the_title(), 8, '...')); ?>
                                        </div>
                                        <div style="font-family:var(--pm-fm);font-size:9px;color:var(--pm-t3);letter-spacing:.04em;margin-top:2px">
                                            <?php echo esc_html(get_the_date()); ?>
                                        </div>
                                    </div>
                                </a>
                            <?php endwhile;
                            wp_reset_postdata(); ?>
                        </div>
                    </div>

                    <!-- CATEGORIAS -->
                    <div style="background:var(--pm-bgc);border:1px solid var(--pm-b2);border-radius:var(--pm-rl);overflow:hidden">
                        <div style="padding:.8rem 1.1rem;border-bottom:1px solid var(--pm-b2);background:var(--pm-bg2)">
                            <span style="font-family:var(--pm-fd);font-size:12px;font-weight:700;color:var(--pm-t1)">
                                <?php echo esc_html(Language_Manager::t('categorias', 'categories')); ?>
                            </span>
                        </div>
                        <div style="padding:1rem 1.1rem;display:flex;flex-wrap:wrap;gap:.5rem">
                            <?php
                            $cats = get_categories(['hide_empty' => true]);
                            foreach ($cats as $cat) :
                            ?>
                                <a href="<?php echo esc_url(get_category_link($cat->term_id)); ?>"
                                    class="pm-cloud-tag" style="text-decoration:none">
                                    <?php echo esc_html($cat->name); ?>
                                    <span style="color:var(--pm-t3);font-size:9px">(<?php echo esc_html($cat->count); ?>)</span>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

</main>

<?php get_footer(); ?>