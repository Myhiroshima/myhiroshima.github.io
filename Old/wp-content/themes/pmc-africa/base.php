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
                if(!is_front_page() && !is_page('services')) :
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
  <?php
  $show_sidebars = false;

  if(is_front_page() || is_page('about-us') || is_page('services')){
      $show_sidebars = true;
  }


  ?>
  <div class="wrap container" role="document">
    <div class="content row">
        <?php if($show_sidebars) : ?>
        <div class="col-md-3">

            <?php
            if(is_front_page()){
                dynamic_sidebar('sidebar-front-page-left');
            } else if(is_page('about-us')) {
                dynamic_sidebar('sidebar-about-page-left');
            } else if (is_page('services')){
                dynamic_sidebar('sidebar-services-page-left');
            }

            ?>
        </div>
        <?php endif; ?>
        <main class="main <?php if($show_sidebars): ?> col-md-6 <?php else: ?> col-md-12 <?php endif; ?>" role="main">
            <?php include roots_template_path(); ?>
        </main><!-- /.main -->
        <?php if($show_sidebars) : ?>
        <div class="col-md-3">
            <?php
            if(is_front_page()){
                dynamic_sidebar('sidebar-front-page-right');
            } else if(is_page('about-us')) {
                dynamic_sidebar('sidebar-about-page-right');
            } else if (is_page('services')){
                dynamic_sidebar('sidebar-services-page-right');
            }

            ?>
        </div>
        <?php endif; ?>
    </div><!-- /.content -->
        <div class="content row">
          <div class="footer-sidebar col-md-12">
              <?php dynamic_sidebar('sidebar-front-page-bottom'); ?>
          </div>
      </div>
  </div><!-- /.wrap -->

  <?php get_template_part('templates/footer'); ?>

</body>
</html>
