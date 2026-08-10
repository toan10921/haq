<?php
/**
 * Single Product Price
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/price.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.0.0
 */

 if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

global $product;

if ( $product->is_type( 'grouped' ) ) {
    $child_products = $product->get_children();
    $prices = [];

    foreach ( $child_products as $child_id ) {
        $child_product = wc_get_product( $child_id );
        if ( $child_product ) {
            $prices[] = floatval( $child_product->get_price() );
        }
    }

    if ( ! empty( $prices ) ) {
        $min_price = min( $prices );
        $max_price = max( $prices );

        if ( $min_price == $max_price ) {
            echo '<p class="price">' . wc_price( $min_price ) . '</p>';
        } else {
            echo '<p class="price">' . wc_price( $min_price ) . ' - ' . wc_price( $max_price ) . '</p>';
        }
    }
} 
elseif ( $product->is_type( 'variable' ) ) {
    $prices = $product->get_variation_prices();
    if ( ! empty( $prices['price'] ) ) {
        $min_price = min( $prices['price'] );
        $max_price = max( $prices['price'] );

        if ( $min_price == $max_price ) {
            echo '<p class="price">' . wc_price( $min_price ) . '</p>';
        } else {
            echo '<p class="price">' . wc_price( $min_price ) . ' - ' . wc_price( $max_price ) . '</p>';
        }
    }
} 
else {
    echo '<p class="price">' . $product->get_price_html() . '</p>';
}
