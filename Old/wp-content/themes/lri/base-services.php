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
            if(!is_front_page()) :
                $page_headline = get_post_meta(get_the_ID(), 'page_headline', true);
                if ($page_headline) : ?>
                <p><?php echo $page_headline; ?></p>
                <?php endif; ?>
        <?php else : ?>
                <h2><?php bloginfo('name'); ?></h2>
                <p class="page-headline-small-text">
                    <?php bloginfo('description'); ?>
                </p>
        <?php endif; ?>
        </div>
    </div>
  </div>
  <?php if (has_nav_menu('services_navigation')) : ?>
          <?php if(is_front_page()) : ?>
            <div class="container services-dark-section">
                <?php get_services_section(SERVICES_NAVIGATION_MENU); ?>
            </div>
          <?php else: ?>
          <div class="container services-dark-menu">
            <?php get_services_menu(SERVICES_NAVIGATION_MENU); ?>
          </div>
          <?php endif; ?>
  <?php else: ?>
      <div class="container bottom-bar"></div>
  <?php endif; ?>
  <div class="wrap container" role="document">
  <?php if(is_front_page()) : ?>
    <div class="content row">
        <aside class="col-md-4 sidebar <?php echo roots_sidebar_class(); ?>" role="complementary">
            <?php dynamic_sidebar('sidebar-primary'); ?>
        </aside><!-- /.sidebar -->
        <main class="main col-md-8" role="main">
            <?php include roots_template_path(); ?>
        </main><!-- /.main -->
    </div><!-- /.content -->
    <div class="content row">
      <div class="col-md-12">
        <?php dynamic_sidebar('sidebar-front-page-bottom'); ?>
      </div>
    </div>
  <?php else: ?>
      <div class="content row">
          <main class="main col-md-12" role="main">
              <?php include roots_template_path(); ?>
          </main><!-- /.main -->
      </div><!-- /.content -->
  <?php endif; ?>
  </div><!-- /.wrap -->
  <?php get_template_part('templates/footer'); ?>

</body>
</html>
