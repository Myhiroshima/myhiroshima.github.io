<?php
/**
 * Variable product add to cart
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce, $product, $post;
?>

<?php do_action( 'woocommerce_before_add_to_cart_form' ); ?>

<form class="variations_form cart" method="post" enctype='multipart/form-data' data-product_id="<?php echo $post->ID; ?>" data-product_variations="<?php echo esc_attr( json_encode( $available_variations ) ) ?>">
	<?php if ( ! empty( $available_variations ) ) { ?>
		<table class="variations" cellspacing="0">
			<tbody>
				<?php $loop = 0; foreach ( $attributes as $name => $options ) : $loop++; ?>
					<tr>
						<td class="label"><label for="<?php echo sanitize_title($name); ?>"><?php echo wc_attribute_label( $name ); ?></label></td>
						<td class="value">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="input-group">
                                        <select class="form-control" id="<?php echo esc_attr( sanitize_title( $name ) ); ?>" name="attribute_<?php echo sanitize_title( $name ); ?>">
                                            <option value=""><?php echo __( 'Choose an option', 'woocommerce' ) ?>&hellip;</option>
                                            <?php
                                            if ( is_array( $options ) ) {

                                                if ( isset( $_REQUEST[ 'attribute_' . sanitize_title( $name ) ] ) ) {
                                                    $selected_value = $_REQUEST[ 'attribute_' . sanitize_title( $name ) ];
                                                } elseif ( isset( $selected_attributes[ sanitize_title( $name ) ] ) ) {
                                                    $selected_value = $selected_attributes[ sanitize_title( $name ) ];
                                                } else {
                                                    $selected_value = '';
                                                }

                                                // Get terms if this is a taxonomy - ordered
                                                if ( taxonomy_exists( $name ) ) {

                                                    $orderby = wc_attribute_orderby( $name );

                                                    switch ( $orderby ) {
                                                        case 'name' :
                                                            $args = array( 'orderby' => 'name', 'hide_empty' => false, 'menu_order' => false );
                                                            break;
                                                        case 'id' :
                                                            $args = array( 'orderby' => 'id', 'order' => 'ASC', 'menu_order' => false, 'hide_empty' => false );
                                                            break;
                                                        case 'menu_order' :
                                                            $args = array( 'menu_order' => 'ASC', 'hide_empty' => false );
                                                            break;
                                                    }

                                                    $terms = get_terms( $name, $args );

                                                    foreach ( $terms as $term ) {
                                                        if ( ! in_array( $term->slug, $options ) )
                                                            continue;

                                                        echo '<option value="' . esc_attr( $term->slug ) . '" ' . selected( sanitize_title( $selected_value ), sanitize_title( $term->slug ), false ) . '>' . apply_filters( 'woocommerce_variation_option_name', $term->name ) . '</option>';
                                                    }
                                                } else {

                                                    foreach ( $options as $option ) {
                                                        echo '<option value="' . esc_attr( sanitize_title( $option ) ) . '" ' . selected( sanitize_title( $selected_value ), sanitize_title( $option ), false ) . '>' . esc_html( apply_filters( 'woocommerce_variation_option_name', $option ) ) . '</option>';
                                                    }

                                                }
                                            }
                                            ?>
                                        </select>
                                      <span class="input-group-btn"><?php
                                          if ( sizeof( $attributes ) == $loop )
                                              echo '<button class="btn btn-default reset_variations" type="button">Clear</button>';
                                          ?>

                                      </span>
                                    </div><!-- /input-group -->
                                </div><!-- /.col-lg-6 -->
                            </div><!-- /.row -->



                             </td>
					</tr>
		        <?php endforeach;?>
			</tbody>
		</table>

		<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

        <div class="row">
            <div class="col-md-12 single_variation_wrap" style="display:none;">
                <div class="row">
                    <div class="col-md-1 col-md-offset-2">
                        <span class="lead">Price:</span>
                    </div>
                    <div class="col-md-3">
                        <?php
                            $show_single_price = false;

                        foreach($available_variations as $variation){
                            if(!$variation['price_html']){
                                $show_single_price = true;
                                break;
                            }
                        }
                        ?>
                        <?php if(!$show_single_price) : ?>

                        <div class="single_variation">
                        </div>
                        <?php else: ?>
                            <div class="single_price">
                                <span class="price"><span class="amount">
                                    <?php echo $product->get_price_html(); ?>
                                </span></span>
                            </div>
                        <?php endif; ?>

                    </div>
                    <div class="col-md-6">
                        <?php do_action( 'woocommerce_before_single_variation' ); ?>


                        <div class="variations_button">
                            <?php woocommerce_quantity_input(); ?>
                            <button type="submit" class="single_add_to_cart_button button alt"><?php echo $product->single_add_to_cart_text(); ?></button>
                        </div>

                        <input type="hidden" name="add-to-cart" value="<?php echo $product->id; ?>" />
                        <input type="hidden" name="product_id" value="<?php echo esc_attr( $post->ID ); ?>" />
                        <input type="hidden" name="variation_id" value="" />

                        <?php do_action( 'woocommerce_after_single_variation' ); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <small>VAT and/or postage will be charged where applicable.</small>
                    </div>
                </div>
                </div>
        </div>

		<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>

	<?php } else { ?>

		<p class="stock out-of-stock"><?php _e( 'This product is currently out of stock and unavailable.', 'woocommerce' ); ?></p>

	<?php } ?>

</form>

<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>
