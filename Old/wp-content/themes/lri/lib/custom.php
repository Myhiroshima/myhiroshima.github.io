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
            SERVICES_NAVIGATION_MENU => __( 'Services navigation' ),
            USER_MENU => __( 'User menu' )
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
 * Renders the minimsed services menu at the top of the services pages other than the main page.
 * This is the Global Research & Marketing | Consulting ... menu.
 */
function get_services_menu($menu_name){

    if ( ( $locations = get_nav_menu_locations() ) && isset( $locations[ $menu_name ] ) ) {
        $menu = wp_get_nav_menu_object( $locations[ $menu_name ] );

        $menu_items = wp_get_nav_menu_items($menu->term_id);

        $menu_list = '<ul id="menu-' . $menu_name . '">';

        foreach ( (array) $menu_items as $key => $menu_item ) {
            $title = $menu_item->title;
            $url = $menu_item->url;
            if($menu_item->menu_item_parent != 0){
                $style = (get_the_ID() == $menu_item->object_id) ? "service active" : "service";

                $menu_list .= '<li class="'.$style.'"><a href="' . $url . '">' . $title . '</a></li>';
            } else {
                if ( menu_item_has_children($menu_item->ID) == 0 )
                {
                    $menu_list .= '<li class="main"><a href="' . $url . '">' . $title . '</a></li>';
                    $menu_list .= '<li class="spacer"></li>';
                } else {
                    $menu_list .= '<li class="main">' . $title . '</li>';
                }

            }
        }
        $menu_list .= '</ul>';
    } else {
        $menu_list = '<ul><li>Menu "' . $menu_name . '" not defined.</li></ul>';
    }
    // $menu_list now ready to output
    echo $menu_list;
}

/**
 * Front page get services section.
 * @param $menu_name
 */
function get_services_section($menu_name){

    if ( ( $locations = get_nav_menu_locations() ) && isset( $locations[ $menu_name ] ) ) {
        $menu = wp_get_nav_menu_object( $locations[ $menu_name ] );

        $menu_items = wp_get_nav_menu_items($menu->term_id);

        $menu_list = '<div id="menu-' . $menu_name . '" class="row">';

        foreach ( (array) $menu_items as $key => $menu_item ) {
            if($menu_item->menu_item_parent == 0){
                $title = $menu_item->title;
                $url = $menu_item->url;
                if(!menu_item_has_children($menu_item->ID)){
                    $menu_list .= '<div class="col-sm-4 right-separator">';
                    $menu_list .= '<h3 class="single"><a href="' . $url . '">' . $title . '</a></h3>';
                    $menu_list .= '<p class="single-text">'. apply_filters('the_content', get_post_field('post_content', $menu_item->object_id)) .'</p>';
                } else {
                    $menu_list .= '<div class="col-sm-8">';
                    $menu_list .= '<h3>' . $title . '</h3>';

                    $menu_list .= '<div class="row">';
                    $submenu_items = wp_get_nav_menu_items($menu->term_id);

                    $total_cells = 0;
                    foreach ( (array) $submenu_items as $key => $submenu_item ) {
                        if($submenu_item->menu_item_parent == $menu_item->ID){
                            $total_cells++;
                        }
                    }

                    $column_width = intval(12 / $total_cells);

                    foreach ( (array) $submenu_items as $key => $submenu_item ) {
                        if($submenu_item->menu_item_parent == $menu_item->ID){
                            $submenu_title = $submenu_item->title;
                            $submenu_url = $submenu_item->url;
                            $menu_list .= '<div class="col-sm-'. $column_width .'">';

                            $menu_list .= '<h4><a href="' . $submenu_url . '">' . $submenu_title . '</a></h4>';
                            $menu_list .= '<p>'. apply_filters('the_content', get_post_field('post_content', $submenu_item->object_id)) .'</p>';
                            $menu_list .= '</div>';
                        }
                    }

                    $menu_list .= '</div>';
                }

                $menu_list .= '</div>';
            } else {
                continue;
            }
        }
        $menu_list .= '</div>';
    } else {
        $menu_list = '<p>Menu "' . $menu_name . '" not defined.</p>';
    }
    echo $menu_list;
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
        'name' => __( 'Publications left', 'sidebar-publications-left' ),
        'id' => 'sidebar-publications-left',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => "</aside>",
        'before_title' => '<div class="widget-title">',
        'after_title' => '</div>',
    ) );

    register_sidebar( array(
        'name' => __( 'Publications right', 'sidebar-publications-right' ),
        'id' => 'sidebar-publications-right',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => "</aside>",
        'before_title' => '<div class="widget-title">',
        'after_title' => '</div>',
    ) );
}
add_action( 'widgets_init', 'template_widgets_init' );

/**
 * Create front page post types
 */
// Register Custom Post Type
function front_page_custom_post_type() {

    $labels = array(
        'name'                => _x( 'Front Page Posts', 'Post Type General Name', 'text_domain' ),
        'singular_name'       => _x( 'Front Page Post', 'Post Type Singular Name', 'text_domain' ),
        'menu_name'           => __( 'Front page posts', 'text_domain' ),
        'parent_item_colon'   => __( 'Parent Item:', 'text_domain' ),
        'all_items'           => __( 'All Items', 'text_domain' ),
        'view_item'           => __( 'View Item', 'text_domain' ),
        'add_new_item'        => __( 'Add New Front Page Post', 'text_domain' ),
        'add_new'             => __( 'Add New', 'text_domain' ),
        'edit_item'           => __( 'Edit Item', 'text_domain' ),
        'update_item'         => __( 'Update Item', 'text_domain' ),
        'search_items'        => __( 'Search Item', 'text_domain' ),
        'not_found'           => __( 'Not found', 'text_domain' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'text_domain' ),
    );
    $args = array(
        'label'               => __( 'front_page', 'text_domain' ),
        'description'         => __( 'Front page articles.', 'text_domain' ),
        'labels'              => $labels,
        'supports'            => array(	'title',
                                        'editor',
                                        'thumbnail',
                                        'revisions'
                                      ),
        'taxonomies'          => array( 'category' ),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'menu_icon'           => 'dashicons-calendar',
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'post',
    );
    register_post_type( 'front_page', $args );

}
// Hook into the 'init' action
add_action( 'init', 'front_page_custom_post_type', 0 );

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

/**
 * Create Africa database custom post type
 */
// Register Custom Post Type
function africa_database() {

    $labels = array(
        'name'                => _x( 'Africa Database Resources', 'Post Type General Name', 'text_domain' ),
        'singular_name'       => _x( 'Africa Database', 'Post Type Singular Name', 'text_domain' ),
        'menu_name'           => __( 'Africa Database', 'text_domain' ),
        'parent_item_colon'   => __( 'Parent Resource:', 'text_domain' ),
        'all_items'           => __( 'All Resources', 'text_domain' ),
        'view_item'           => __( 'View Resource', 'text_domain' ),
        'add_new_item'        => __( 'Add New Resource', 'text_domain' ),
        'add_new'             => __( 'Add New', 'text_domain' ),
        'edit_item'           => __( 'Edit Resource', 'text_domain' ),
        'update_item'         => __( 'Update Resource', 'text_domain' ),
        'search_items'        => __( 'Search Database', 'text_domain' ),
        'not_found'           => __( 'Not found', 'text_domain' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'text_domain' ),
    );
    $args = array(
        'label'               => __( 'africa_database', 'text_domain' ),
        'description'         => __( 'Database containing Africa resources', 'text_domain' ),
        'labels'              => $labels,
        'supports'            => array( 'title', 'editor', 'revisions', ),
        'taxonomies'          => array( 'ad_residence_country', 'ad_sector', 'ad_area_expertise', 'ad_countries_experience', 'ad_languages' ),
        'hierarchical'        => false,
        'public'              => false,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'menu_icon'           => 'dashicons-archive',
        'can_export'          => true,
        'has_archive'         => false,
        'exclude_from_search' => true,
        'publicly_queryable'  => true,
        'capability_type'     => 'page',
    );
    register_post_type( 'africa_database', $args );

}

// Hook into the 'init' action
add_action( 'init', 'africa_database', 0 );

//Add login/logout menu
add_filter('wp_nav_menu_items', 'add_login_logout_link', 10, 2);
function add_login_logout_link($items, $args) {

    if( $args->theme_location == 'primary_navigation') {
        //ob_start();
        //wp_loginout('index.php');
        //$loginoutlink = ob_get_contents();
        //ob_end_clean();
        if(is_user_logged_in()){
            $items .= '<li><a href="'. wp_logout_url(get_permalink()) .'" title="Logout">Logout</a></li>';
        } else {
            $items .= '<li><a href="#">Login link</a></li>';
        }
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

function show_after_cart_notice(){
    echo "<small>Note: Shipping and taxes are estimated and will be updated during Checkout based on your billing and shipping information.</small>";
}
add_filter('woocommerce_after_cart_table', 'show_after_cart_notice');

// Restrict admin access to admins
function restrict_admin()
{
    if ( ! current_user_can( 'manage_options' ) && '/wp-admin/admin-ajax.php' != $_SERVER['PHP_SELF'] ) {
        wp_redirect( site_url() );
    }
}
add_action( 'admin_init', 'restrict_admin', 1 );