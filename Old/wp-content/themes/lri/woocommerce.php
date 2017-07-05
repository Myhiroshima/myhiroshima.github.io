<?php if (is_shop()): ?>
    <?php get_template_part('templates/page', 'publications'); ?>
<?php else : ?>
<?php if (!is_product()) get_template_part('templates/page', 'header'); ?>
<?php get_template_part('templates/single', 'product'); ?>
<?php endif; ?>


