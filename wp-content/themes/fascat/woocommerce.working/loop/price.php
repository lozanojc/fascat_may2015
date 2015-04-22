<?php
/**
 * Loop Price
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product;
$currency = get_woocommerce_currency_symbol();
?>

<?php if($isSale = $product->is_on_sale()){?>
        <span class="price"><span class="amount"><del><?php echo($price = $currency . ('variable' === $product->product_type ? $product->get_variation_regular_price() : $product->get_regular_price()));?></del></span></span>
        <span class="price"><span class="amount"><?php echo($currency . $product->get_price());?></span></p>
	<?php }else{?>
        <span class="price"><span class="amount"><?php echo($price = ($currency = get_woocommerce_currency_symbol()) . $product->get_price());?></span></span>
    <?php }?>

<?php//if ( $price_html = $product->get_price_html() ) : ?>
<!--	<span class="price"><?php //echo $price_html; ?></span> -->
<?php //endif; ?>
