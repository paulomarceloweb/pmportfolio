<?php
//@package PMPortfolio

defined('ABSPATH') || exit;

get_header();
?>

<main id="main-content" role="role">

    <?php

    get_template_part('template-parts/sections/hero');
    get_template_part('template-parts/sections/stats');
    get_template_part('template-parts/sections/sobre-preview');
    get_template_part('template-parts/sections/servicos-featured');
    get_template_part('template-parts/sections/portfolio-featured');
    get_template_part('template-parts/sections/blog-preview');
    get_template_part('template-parts/sections/cta');
    get_template_part('template-parts/sections/newsletter');

    ?>

</main>

<?php get_footer(); ?>