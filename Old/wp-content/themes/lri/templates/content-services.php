<div class="page-content">
<?php while (have_posts()) : the_post(); ?>
  <?php the_content(); ?>
  <?php wp_link_pages(array('before' => '<nav class="pagination">', 'after' => '</nav>')); ?>
<?php endwhile; ?>
</div>
<?php
$args = array(
    'child_of' => get_the_ID(),
    'parent' => get_the_ID(),
    'depth' => 0,
    'sort_column' => 'menu_order',
    'sort_order' => 'asc'
);
$children_array = get_pages( $args ); ?>
<?php foreach($children_array as $page) :
    ?>
    <div id="post-<?php echo $page->ID; ?>" class="page-content border-bottom">
        <h3><?php echo $page->post_title; ?></h3>
        <p><?php
            $content = $page->post_content;
            $content = apply_filters('the_content',$content);
            echo $content; ?></p>
    </div>
<?php endforeach; ?>