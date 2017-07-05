<div class="page-header border-bottom">
<?php
    $args = array(
        'child_of' => get_the_ID(),
        'parent' => get_the_ID(),
        'depth' => 0,
        'sort_column' => 'menu_order',
        'sort_order' => 'asc'
    );
    $children_array = get_pages( $args ); ?>
    <?php if ($children_array) : ?>
    <?php $children = count($children_array); ?>
        <?php if ($children == 2) : ?>
            <div class="row">
              <ul class="list-inline">
            <?php foreach($children_array as $page) :
                ?>
                <li class="col-sm-6">
                      <h3><?php echo $page->post_title; ?></h3>
                      <p><?php
                          $content = $page->post_content;
                          $content = apply_filters('the_content',$content);
                          echo substr(strip_tags($content), 0, 500); ?>...</p>
                    <div class="link pull-right"><a href="#post-<?php echo $page->ID; ?>"
                                         title="<?php echo $page->post_title; ?>">Read more</a></div>
                  </li>
            <?php endforeach; ?>
              </ul>
            </div>
        <?php elseif($children == 3): ?>
            <div class="row">
                <ul class="list-inline">
                <?php foreach($children_array as $page) : ?>
                    <li class="col-sm-4">
                        <h3><?php echo $page->post_title; ?></h3>
                        <p><?php
                            $content = $page->post_content;
                            $content = apply_filters('the_content',$content);
                            echo substr(strip_tags($content), 0, 500); ?>...</p>
                        <div class="link pull-right"><a href="#post-<?php echo $page->ID; ?>"
                                             title="<?php echo $page->post_title; ?>">Read more</a></div>
                    </li>
                <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
    <?php else: ?>
    <h1>
        <?php echo roots_title(); ?>
    </h1>
    <?php endif; ?>
</div>
