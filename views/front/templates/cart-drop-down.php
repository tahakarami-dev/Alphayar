<?php
function aac_cart_menu_shortcode()
{
    ob_start();
?>

    <div class="cart-menu-wrapper">
        <div class="cart-button cart-box-icon">
            <img src="<?php echo AAC_FRONT_ASSETS . '/images/cart.svg'; ?>" alt="سبد خرید">
            <?php if (WC()->cart->get_cart_contents_count() > 0): ?>
                <span class="cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
            <?php endif; ?>
        </div>

        <div class="cart-dropdown-card">
            <div class="cart-dropdown-header">
                <h3 class="cart-title">سبد خرید شما</h3>
                <span class="cart-total"><?php echo WC()->cart->get_cart_total(); ?></span>
            </div>

            <div class="cart-dropdown-body">
                <?php if (WC()->cart->is_empty()): ?>
                    <div class="empty-cart">سبد خرید شما خالی است</div>
                <?php else: ?>
                    <div class="cart-items">
                        <?php foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item):
                            $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
                            $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);
                            $product_permalink = $_product->is_visible() ? $_product->get_permalink($cart_item) : '';
                        ?>
                            <div class="cart-item" data-key="<?php echo esc_attr($cart_item_key); ?>">
                                <div class="cart-item-image">
                                    <?php echo $_product->get_image(); ?>
                                </div>
                                <div class="cart-item-details">
                                    <div class="cart-item-name">
                                        <?php echo esc_html($_product->get_name()); ?>
                                    </div>
                                    <div class="cart-item-price">
                                        <?php
                                        echo WC()->cart->get_product_price($_product);
                                        if ($_product->get_sale_price()) {
                                            echo '<del class="original-price">' . wc_price($_product->get_regular_price()) . '</del>';
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <?php if (!WC()->cart->is_empty()): ?>
                <div class="cart-dropdown-footer">
                    <a href="<?php echo wc_get_cart_url(); ?>" class="view-cart">مشاهده سبد خرید</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php
    return ob_get_clean();
}
add_shortcode('aac_cart_menu', 'aac_cart_menu_shortcode');
