<?php
/**
 * Single Product tabs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/tabs.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.8.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Filter tabs and allow third parties to add their own.
 *
 * Each tab is an array containing title, callback and priority.
 *
 * @see woocommerce_default_product_tabs()
 */
$product_tabs = apply_filters( 'woocommerce_product_tabs', array() );

if ( ! empty( $product_tabs ) ) :

    $meta_tab_style = get_post_meta(get_the_ID(), 'product_tab_style', true);
    $tab_style = $meta_tab_style ? $meta_tab_style : get_theme_mod('product_tab_style_general', 'tab_style_horizontal');

    if ( $tab_style === 'tab_style_accordion' ) : ?>
        
        <!-- Accordion Tab Layout -->
        <div class="woocommerce-tabs accordion-tabs container">
            <?php foreach ( $product_tabs as $key => $product_tab ) : ?>
                <div class="accordion-tab-item">
                    <div class="accordion-tab-title" id="tab-title-<?php echo esc_attr( $key ); ?>" aria-expanded="false">
                        <h4><?php echo wp_kses_post( apply_filters( 'woocommerce_product_' . $key . '_tab_title', $product_tab['title'], $key ) ); ?></h4>
                        <span class="accordion-toggle-icon"><i class="las la-plus"></i></span>
                    </div>
                    <div class="accordion-tab-content" id="tab-<?php echo esc_attr( $key ); ?>">
                        <?php
                        if ( isset( $product_tab['callback'] ) ) {
                            call_user_func( $product_tab['callback'], $key, $product_tab );
                        }
                        ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    <?php else : ?>
        
        <!-- Default Horizontal Tab Layout -->
        <div class="woocommerce-tabs wc-tabs-wrapper container">
            <ul class="tabs wc-tabs" role="tablist">
                <?php foreach ( $product_tabs as $key => $product_tab ) : ?>
                    <li class="<?php echo esc_attr( $key ); ?>_tab" id="tab-title-<?php echo esc_attr( $key ); ?>" role="tab" aria-controls="tab-<?php echo esc_attr( $key ); ?>">
                        <a href="#tab-<?php echo esc_attr( $key ); ?>">
                            <?php echo wp_kses_post( apply_filters( 'woocommerce_product_' . $key . '_tab_title', $product_tab['title'], $key ) ); ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
            <?php foreach ( $product_tabs as $key => $product_tab ) : ?>
                <div class="woocommerce-Tabs-panel woocommerce-Tabs-panel--<?php echo esc_attr( $key ); ?> panel entry-content wc-tab" id="tab-<?php echo esc_attr( $key ); ?>" role="tabpanel" aria-labelledby="tab-title-<?php echo esc_attr( $key ); ?>">
                    <?php
                    if ( isset( $product_tab['callback'] ) ) {
                        call_user_func( $product_tab['callback'], $key, $product_tab );
                    }
                    ?>
                </div>
            <?php endforeach; ?>
        </div>

    <?php endif;

endif;
?>

