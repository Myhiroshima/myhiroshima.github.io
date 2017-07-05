<footer class="content-info" role="contentinfo">
  <div class="container main-footer">
    <div class="row">
        <div class="col-lg-5">
        <?php
        if (has_nav_menu('footer_navigation')) :
            wp_nav_menu(array('theme_location' => 'footer_navigation', 'menu_class' => 'nav nav-menu-footer'));
        endif;
        ?>
        </div>
        <div class="col-lg-7">
            <p class="copyright text-right">Copyright &copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?> Ltd. All rights reserved</p>
        </div>
    </div>
  </div>
  <div id="bottom-bar" class="container bottom-bar"></div>
</footer>

<?php wp_footer(); ?>