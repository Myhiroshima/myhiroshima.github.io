<header class="banner container" role="banner">
  <div class="row">
    <div id="header" class="col-sm-4 header">
        <a class="brand" href="<?php echo home_url('/') ?>">
          <img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo.jpg" alt="<?php bloginfo('name'); ?>" />
        </a>
    </div>
    <div class="col-sm-8 header">
      <div class="row header-menu">
        <div class="col-sm-12">
          <nav class="nav-main pull-right" role="navigation">
            <?php
              if (has_nav_menu('primary_navigation')) :
                wp_nav_menu(array('theme_location' => 'primary_navigation', 'menu_class' => 'nav nav-menu'));
              endif;
            ?>
          </nav>
        </div>
      </div>
    </div>
  </div>
</header>
