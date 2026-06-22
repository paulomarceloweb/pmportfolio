<?php

/**
 * PMPortfolio — Blog Preview Section
 *
 * Exibe os 3 posts mais recentes do blog na home.
 *
 * @package PMPortfolio
 */

defined('ABSPATH') || exit;

use PMPortfolio\Multilingual\Language_Manager;

$query = new WP_Query([
    'post_type'      => 'post',
    'post_status'    => 'publish',
    'posts_per_page' => 3,
    'no_found_rows'  => true,
]);

if (! $query->have_posts()) {
    return;
}
?>

<hr class="pm-hr m-0" aria-hidden="true">

<section style="background:var(--pm-bg1);border-top:1px solid var(--pm-b2);padding:5rem 0"
    aria-label="<?php echo esc_attr(Language_Manager::t('Blog', 'Blog')); ?>">
    <div class="container-xl">

        <div class="d-flex align-items-end justify-content-between flex-wrap gap-3 mb-5">
            <div>
                <div class="pm-eyebrow mb-2">
                    <?php echo esc_html(Language_Manager::t('blog técnico', 'tech blog')); ?>
                </div>
                <h2 style="font-size:clamp(1.8rem,3vw,2.4rem)">
                    <?php echo esc_html(Language_Manager::t('Últimos ', 'Latest ')); ?>
                    <span style="color:var(--pm-gold)">
                        <?php echo esc_html(Language_Manager::t('artigos', 'articles')); ?>
                    </span>
                </h2>
            </div>
            <a href="<?php echo esc_url(home_url(Language_Manager::is('en') ? '/en/blog/' : '/blog/')); ?>"
                class="pm-btn-s">
                <?php echo esc_html(Language_Manager::t('Ver todos os artigos →', 'View all articles →')); ?>
            </a>
        </div>

        <div class="row g-4">
            <?php while ($query->have_posts()) : $query->the_post();
                $words   = str_word_count(strip_tags(get_the_content()));
                $minutes = max(1, (int) ceil($words / 200));
                $cats    = get_the_category();
            ?>
                <div class="col-md-4">
                    <a href="<?php echo esc_url(get_permalink()); ?>"
                        style="text-decoration:none;display:block;height:100%">
                        <div style="background:var(--pm-bgc);border:1px solid var(--pm-b2);border-radius:var(--pm-rl);overflow:hidden;transition:all .25s;height:100%;display:flex;flex-direction:column"
                            onmouseover="this.style.borderColor='var(--pm-b1)';this.style.transform='translateY(-4px)'"
                            onmouseout="this.style.borderColor='var(--pm-b2)';this.style.transform='none'">

                            <!-- THUMBNAIL -->
                            <div style="aspect-ratio:16/9;background:linear-gradient(135deg,var(--pm-bg2),var(--pm-bg3));position:relative;display:flex;align-items:center;justify-content:center;overflow:hidden;flex-shrink:0">
                                <?php if (has_post_thumbnail()) : ?>
                                    <?php the_post_thumbnail('pm-blog', [
                                        'style'    => 'width:100%;height:100%;object-fit:cover;position:absolute;inset:0',
                                        'loading'  => 'lazy',
                                        'decoding' => 'async',
                                        'alt'      => esc_attr(get_the_title()),
                                    ]); ?>
                                <?php else : ?>
                                    <span style="font-family:var(--pm-fm);font-size:2rem;color:var(--pm-gold);opacity:.3">{ }</span>
                                <?php endif; ?>
                                <?php if ($cats) : ?>
                                    <div style="position:absolute;top:10px;left:10px">
                                        <span class="pm-tag pm-tag-php" style="font-size:9px">
                                            <?php echo esc_html($cats[0]->name); ?>
                                        </span>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- BODY -->
                            <div style="padding:1.1rem 1.25rem;display:flex;flex-direction:column;flex:1">
                                <div class="pm-meta d-flex align-items-center gap-1 mb-2">
                                    <span><?php echo esc_html(get_the_date()); ?></span>
                                    <span class="pm-meta-dot">·</span>
                                    <span>
                                        <?php echo esc_html($minutes); ?>
                                        <?php echo esc_html(Language_Manager::t('min', 'min')); ?>
                                    </span>
                                </div>
                                <div style="font-family:var(--pm-fd);font-size:14px;font-weight:700;color:var(--pm-t1);letter-spacing:-.01em;line-height:1.35;margin-bottom:.5rem">
                                    <?php the_title(); ?>
                                </div>
                                <p style="font-size:12px;color:var(--pm-t2);font-weight:300;line-height:1.65;margin-bottom:1rem;flex:1">
                                    <?php echo esc_html(wp_trim_words(get_the_excerpt(), 18, '...')); ?>
                                </p>
                                <span style="font-family:var(--pm-fm);font-size:10px;color:var(--pm-gold);letter-spacing:.04em;margin-top:auto">
                                    <?php echo esc_html(Language_Manager::t('ler artigo →', 'read article →')); ?>
                                </span>
                            </div>

                        </div>
                    </a>
                </div>
            <?php endwhile;
            wp_reset_postdata(); ?>
        </div>

    </div>
</section>