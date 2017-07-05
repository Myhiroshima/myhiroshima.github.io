<div class="front-page">
<ul>
    <?php
    $args = array(
        'post_type' => 'front_page'
    );
    $slider_posts = new WP_Query($args);
    ?>

    <?php if($slider_posts->have_posts()) : ?>
            <?php while($slider_posts->have_posts()) : $slider_posts->the_post() ?>
            <?php $style = has_post_thumbnail() ? 'col-sm-6' : 'col-sm-12'; ?>
                <li>
                    <div class='row'>
                        <h3><?php the_title(); ?></h3>
                        <div class="<?php echo $style; ?>"><?php the_content(); ?></div>
                        <?php if ( has_post_thumbnail() ) : ?>
                            <div class="<?php echo $style; ?> pull-right">
                            <?php
                            $featured_image_link = get_post_meta(get_the_ID(), 'featured_image_link', true);
                            if ($featured_image_link) : ?>
                                <a href="<?php echo $featured_image_link; ?>"><?php the_post_thumbnail(); ?></a>
                            <?php else: ?>
                                <?php the_post_thumbnail(); ?>
                            <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </li>
            <?php endwhile ?>
    <?php endif ?>
</ul>
</div>