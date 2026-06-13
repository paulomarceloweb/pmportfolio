<?php

/**
 * PMPortfolio — Footer Component
 *
 * Rodapé do site.
 * Incluído via get_template_part() no footer.php.
 *
 * @package PMPortfolio
 */

defined('ABSPATH') || exit;

$year = gmdate('Y');
?>

<hr class="pm-hr m-0" aria-hidden="true">

<footer class="pm-footer" role="contentinfo">
    <div class="container-xl">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">

            <!-- COPYRIGHT -->
            <span class="pm-footer-copy">
                © <?php echo esc_html($year); ?>
                <?php echo esc_html(get_bloginfo('name')); ?>
                ·
                <span style="color:var(--pm-gold)">
                    <?php esc_html_e('available for hire', 'pmportfolio'); ?>
                </span>
            </span>

            <!-- REDES SOCIAIS -->
            <nav aria-label="<?php esc_attr_e('Redes sociais', 'pmportfolio'); ?>"
                class="d-flex gap-2">
                <a href="https://github.com"
                    class="pm-footer-soc"
                    target="_blank"
                    rel="noopener noreferrer"
                    aria-label="GitHub">
                    gh
                </a>
                <a href="https://linkedin.com"
                    class="pm-footer-soc"
                    target="_blank"
                    rel="noopener noreferrer"
                    aria-label="LinkedIn">
                    li
                </a>
                <a href="https://twitter.com"
                    class="pm-footer-soc"
                    target="_blank"
                    rel="noopener noreferrer"
                    aria-label="Twitter / X">
                    tw
                </a>
            </nav>

        </div>
    </div>
</footer>