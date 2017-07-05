<header class="banner container" role="banner">
  <div class="row">
    <div id="header" class="col-sm-2 header">

        <a class="brand" href="<?php echo home_url('/') ?>">
          <img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo.png" alt="<?php bloginfo('name'); ?>" />
        </a>
    </div>
    <div class="col-sm-10 header">
      <div class="row">
        <div class="col-sm-9">
                <?php
                    if (is_user_logged_in() && has_nav_menu(USER_MENU)) :
                        wp_nav_menu(array('theme_location' => USER_MENU, 'menu_class' => 'nav nav-menu pull-right'));
                    endif; ?>
        </div>
        <div class="col-sm-3">
            <?php global $woocommerce; ?>
            <ul class="nav nav-menu pull-right">
                <li>
                    <a href="<?php echo $woocommerce->cart->get_cart_url(); ?>" title="<?php _e('View your shopping cart', 'woothemes'); ?>">
                        <?php echo sprintf(_n('Cart: %d item', 'Cart: %d items', $woocommerce->cart->cart_contents_count, 'woothemes'), $woocommerce->cart->cart_contents_count);?> -
                        <?php echo $woocommerce->cart->get_cart_total(); ?></a>
                </li>
            </ul>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-9">
          <nav class="nav-main pull-right" role="navigation">
            <?php
              if (has_nav_menu('primary_navigation')) :
                wp_nav_menu(array('theme_location' => 'primary_navigation', 'menu_class' => 'nav nav-menu dropdown'));
              endif;
            ?>
          </nav>
        </div>
        <div class="col-sm-3 pull-right">
            <?php include('searchform.php'); ?>
        </div>
      </div>
    </div>
  </div>
</header>
