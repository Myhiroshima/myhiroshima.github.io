<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * Override this template by copying it to yourtheme/woocommerce/content-single-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>

<?php
	/**
	 * woocommerce_before_single_product hook
	 *
	 * @hooked wc_print_notices - 10
	 */
	 do_action( 'woocommerce_before_single_product' );

	 if ( post_password_required() ) {
	 	echo get_the_password_form();
	 	return;
	 }
?>
<div itemscope itemtype="<?php echo woocommerce_get_product_schema(); ?>" id="product-<?php the_ID(); ?>" <?php post_class(); ?>>

<?php //woocommerce_breadcrumb(); ?>

    <div class="row">
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-12">
                    <div class="lead">
                        <?php the_excerpt(); ?>
                    </div>
                </div>
                <div class="col-md-12">
                    <?php woocommerce_output_product_data_tabs(); ?>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <?php woocommerce_show_product_images(); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-success">
                    <div class="panel-heading"><h4>Choose a format to purchase a copy</h4></div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-12 text-center">
                            <?php woocommerce_template_single_add_to_cart(); ?>
                            </div>
                         </div>
                    </div>
                </div>
        </div>
    </div>

<!--	--><?php
//		/**
//		 * woocommerce_after_single_product_summary hook
//		 *
//		 * @hooked woocommerce_output_product_data_tabs - 10
//		 * @hooked woocommerce_output_related_products - 20
//		 */
//		do_action( 'woocommerce_after_single_product_summary' );
//	?>

	<meta itemprop="url" content="<?php the_permalink(); ?>" />

</div><!-- #product-<?php the_ID(); ?> -->

<?php do_action( 'woocommerce_after_single_product' ); ?>
