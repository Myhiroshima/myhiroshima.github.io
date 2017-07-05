<div class="product-categories">
<?php $product_categories = get_terms( 'product_cat', array() ); ?>
<?php if(count($product_categories) > 0): ?>
    <?php foreach($product_categories as $category): ?>
        <h3><?php echo $category->name; ?></h3>

            <?php

            $query_args = array( 'post_status' => 'publish', 'post_type' => 'product', 'tax_query' => array(
                array(
                    'taxonomy' => 'product_cat',
                    'field' => 'slug',
                    'terms' => array($category->slug)
                )));

            $r = new WP_Query($query_args);

            if ($r->have_posts()) {
                ?>
                <ul>
                    <?php while ($r->have_posts()) : $r->the_post();
                        global $product;
                        $thumbnail_size = wc_get_image_size('shop_thumbnail');
                        ?>
                        <li>
                            <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><h4><?php the_title() ?></h4></a>
                            <div class="row">
                                <div class="col-xs-8"><?php the_content(); ?></div>
                                <div class="col-xs-4">

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="thumbnail">
                                                <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                                                <?php if (has_post_thumbnail()) the_post_thumbnail('shop_thumbnail');
                                                        else
                                                        echo '<img src="'. woocommerce_placeholder_img_src() .'" alt="Placeholder" width="'. $thumbnail_size['width'] .'" height="'. $thumbnail_size['height'] .'" />'; ?>
                                                </a>
                                                <div class="caption text-center">
                                                    <p><b><?php the_post_thumbnail_caption(); ?></b></p>
                                                    <p class="description"><?php the_post_thumbnail_description(); ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-10 col-xs-offset-1">
                                    <div class="panel panel-default">
                                        <div class="panel-body">
                                            <a href="<?php the_permalink(); ?>" class="btn btn-primary btn-lg btn-block btn-danger">Buy now</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-10 col-xs-offset-1">
                                    <small>VAT and/or postage will be charged where applicable.</small>
                                </div>
                                <div id="cart" class="col-xs-12">
                                </div>
                            </div>
                        </li>
                    <?php endwhile; ?>
                </ul>
                <?php
                // Reset the global $the_post as this query will have stomped on it
                wp_reset_query();

            }
            ?>
    <?php endforeach; ?>
<?php endif; ?>
</div>