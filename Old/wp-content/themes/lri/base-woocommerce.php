<?php get_template_part('templates/head'); ?>
<body <?php body_class(); ?>>

<!--[if lt IE 8]>
<div class="alert alert-warning">
    <?php _e('You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.', 'roots'); ?>
</div>
<![endif]-->

<?php
do_action('get_header');
// Use Bootstrap's navbar if enabled in config.php
if (current_theme_supports('bootstrap-top-navbar')) {
    get_template_part('templates/header-top-navbar');
} else {
    get_template_part('templates/header');
}
?>

<div class="wrap container" role="document">
    <div class="page-top row">
        <div class="page-headline text-right">
            <?php
            if(!is_404()) :
                if(!is_front_page()) :
                    $page_headline = get_post_meta(get_the_ID(), 'page_headline', true);
                    if ($page_headline) : ?>
                        <p><?php echo $page_headline; ?></p>
                    <?php endif; ?>
                <?php   else : ?>
                    <h2><?php bloginfo('name'); ?></h2>
                    <p class="page-headline-small-text">
                        <?php bloginfo('description'); ?>
                    </p>
                <?php   endif;
            endif; ?>
        </div>
    </div>
</div>
<div class="container bottom-bar"></div>
<div class="wrap container" role="document">
    <?php if (is_product() || is_product_category() || is_shop()) :?>
    <div class="content row">
        <div class="page-header">
            <h1>
                <?php echo roots_title(); ?>
            </h1>
        </div>
    </div>
    <?php endif; ?>
    <div class="content row">
        <?php if (!is_product()): ?>
        <div class="col-md-3">
            <?php dynamic_sidebar('sidebar-publications-left'); ?>
        </div>
        <?php endif; ?>
        <?php if (!is_product()): ?>
        <div class="col-md-7">
        <?php else: ?>
        <div class="col-md-10">
        <?php endif; ?>
            <main class="main" role="main">
                <?php include roots_template_path(); ?>
            </main><!-- /.main -->
        </div>
        <div class="col-md-2">
            <?php dynamic_sidebar('sidebar-publications-right'); ?>
        </div>
    </div><!-- /.content -->
</div><!-- /.wrap -->

<?php get_template_part('templates/footer'); ?>

</body>
</html>
