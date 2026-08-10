<div class="mini-cart-box aside-box <?php echo esc_attr($style); ?> <?php echo esc_attr($active_cart_default); ?>">
    <a href="<?php echo esc_url( get_permalink( get_option('woocommerce_cart_page_id') ) ); ?>" 
       class="mini-cart-link" 
       aria-expanded="false" 
       aria-controls="t888-minicart-panel">
        <span class="cart-number"><?php echo esc_html(WC()->cart ? WC()->cart->get_cart_contents_count() : 0); ?></span>
        <i class="lab la-opencart title24"></i>
    </a>
</div>
