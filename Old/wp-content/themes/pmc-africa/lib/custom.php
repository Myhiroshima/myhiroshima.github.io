<?php
/**
 * Custom functions
 */

define('SERVICES_NAVIGATION_MENU', 'services_navigation');
define('USER_MENU', 'user_menu');
/**
 * Register navigation menus through the site.
 */
function register_global_menus() {
    register_nav_menus(
        array(
            'footer_navigation' => __( 'Footer navigation' ),
        )
    );
}
add_action( 'init', 'register_global_menus' );


function get_current_template_name($template_path){
    $template_name = end(explode('/', substr($template_path, 0, -4)));
    return end(explode('-', $template_name));
}

/**
 * Sets the base template to a given custom template if there is one, otherwise it falls back to the default base.php.
 * @param $templates
 * @return mixed
 */
function roots_wrap_base_services($templates) {

    $template_name = get_current_template_name(get_page_template());
    array_unshift($templates, sprintf('base-%s.php', $template_name));
    return $templates;
}
add_filter('roots_wrap_base', 'roots_wrap_base_services');

function menu_item_has_children($menu_item_id){
    global $wpdb;
    return $wpdb->get_var( "SELECT COUNT(meta_id)
                                                 FROM {$wpdb->prefix}postmeta
                                                 WHERE meta_key='_menu_item_menu_item_parent'
                                                       AND meta_value='" . $menu_item_id . "'" );
}


/**
 * Register widgetized area and update sidebar with default widgets
 */
function template_widgets_init() {
    register_sidebar( array(
        'name' => __( 'Front Page Bottom Sidebar', 'sidebar-front-page-bottom' ),
        'id' => 'sidebar-front-page-bottom',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => "</aside>",
        'before_title' => '<div class="widget-title">',
        'after_title' => '</div>',
    ) );

    register_sidebar( array(
        'name' => __( 'Front page left', 'sidebar-front-page-left' ),
        'id' => 'sidebar-front-page-left',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => "</aside>",
        'before_title' => '<div class="widget-title">',
        'after_title' => '</div>',
    ) );

    register_sidebar( array(
        'name' => __( 'Front page right', 'sidebar-front-page-right' ),
        'id' => 'sidebar-front-page-right',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => "</aside>",
        'before_title' => '<div class="widget-title">',
        'after_title' => '</div>',
    ) );

    register_sidebar( array(
        'name' => __( 'About page left', 'sidebar-about-page-left' ),
        'id' => 'sidebar-about-page-left',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => "</aside>",
        'before_title' => '<div class="widget-title">',
        'after_title' => '</div>',
    ) );

    register_sidebar( array(
        'name' => __( 'About page right', 'sidebar-about-page-right' ),
        'id' => 'sidebar-about-page-right',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => "</aside>",
        'before_title' => '<div class="widget-title">',
        'after_title' => '</div>',
    ) );

    register_sidebar( array(
        'name' => __( 'Services page left', 'sidebar-services-page-left' ),
        'id' => 'sidebar-services-page-left',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => "</aside>",
        'before_title' => '<div class="widget-title">',
        'after_title' => '</div>',
    ) );

    register_sidebar( array(
        'name' => __( 'Services page right', 'sidebar-services-page-right' ),
        'id' => 'sidebar-services-page-right',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => "</aside>",
        'before_title' => '<div class="widget-title">',
        'after_title' => '</div>',
    ) );
}
add_action( 'widgets_init', 'template_widgets_init' );


/**
 * Create featured publications
 */

function the_post_thumbnail_caption() {
    global $post;

    $thumbnail_id    = get_post_thumbnail_id($post->ID);
    $thumbnail_image = get_posts(array('p' => $thumbnail_id, 'post_type' => 'attachment'));

    if ($thumbnail_image && isset($thumbnail_image[0])) {
        echo '<span>'.$thumbnail_image[0]->post_excerpt.'</span>';
    }
}

function the_post_thumbnail_description() {
    global $post;

    $thumbnail_id    = get_post_thumbnail_id($post->ID);
    $thumbnail_image = get_posts(array('p' => $thumbnail_id, 'post_type' => 'attachment'));

    if ($thumbnail_image && isset($thumbnail_image[0])) {
        echo '<span>'.$thumbnail_image[0]->post_content.'</span>';
    }
}



//Add login/logout menu
add_filter('wp_nav_menu_items', 'add_login_logout_link', 10, 2);
function add_login_logout_link($items, $args) {

    if( $args->theme_location == 'primary_navigation') {
        ob_start();
        wp_loginout('index.php');
        $loginoutlink = ob_get_contents();
        ob_end_clean();
        $items .= '<li>'. $loginoutlink .'</li>';
    }
    return $items;
}
add_filter('wp_nav_menu_items', 'add_search_form_box', 10, 2);

function add_search_form_box($items, $args) {

    if( $args->theme_location == 'primary_navigation') {
        ob_start();?>

        <form role="search" method="get" class="search-form form-inline" action="<?php echo home_url('/'); ?>">
            <div class="input-group">
                <input type="search" value="<?php if (is_search()) { echo get_search_query(); } ?>" name="s" class="search-input form-control" placeholder="<?php _e('Search', 'roots'); ?>">
                <label class="hide"><?php _e('Search for:', 'roots'); ?></label>
    <span class="input-group-btn">
      <button type="image" class="search-submit btn btn-default"></button>
    </span>
            </div>
        </form>


        <?php
        $loginoutlink = ob_get_contents();
        ob_end_clean();
        $items .= '<li class="search-form-menu">'. $loginoutlink .'</li>';
    }
    return $items;
}

//Add Hello text to top menu
add_filter('wp_nav_menu_items', 'add_greeting_to_user_menu', 10, 2);
function add_greeting_to_user_menu($items, $args) {

    if( $args->theme_location == USER_MENU && is_user_logged_in()) {


        $current_user = wp_get_current_user();
        $name = "";
        if(strlen($current_user->user_firstname . $current_user->user_firstname) == 0){
            $name = $current_user->display_name;
        } else {
            $name = sprintf('%s %s', $current_user->user_firstname, $current_user->user_lastname);
        }
        $link = '<li class="nav-menu-text">Hello ' . $name . '!</li>';
        $link .= $items;
        return $link;
    }
    return $items;
}
