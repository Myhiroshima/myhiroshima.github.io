<?php global $product; ?>
<li>
    <a href="<?php echo esc_url( get_permalink( $product->id ) ); ?>" title="<?php echo esc_attr( $product->get_title() ); ?>">
        <?php echo $product->get_title(); ?>
    </a>
    <a href="<?php echo esc_url( get_permalink( $product->id ) ); ?>" title="<?php echo esc_attr( $product->get_title() ); ?>">
        <?php echo $product->get_image(); ?>
    </a>
    <?php echo strip_tags($product->post_content); ?>
    <?php echo $product->post->post_excerpt; ?>
</li>