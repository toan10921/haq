<?php

/**
 * Variable product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/variable.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.6.0
 */

defined('ABSPATH') || exit;

global $product;

$attribute_keys  = array_keys($attributes);
$variations_json = wp_json_encode($available_variations);
$variations_attr = function_exists('wc_esc_json') ? wc_esc_json($variations_json) : _wp_specialchars($variations_json, ENT_QUOTES, 'UTF-8', true);

do_action('woocommerce_before_add_to_cart_form'); ?>

<form class="variations_form cart" action="<?php echo esc_url(apply_filters('woocommerce_add_to_cart_form_action', $product->get_permalink())); ?>" method="post" enctype='multipart/form-data' data-product_id="<?php echo absint($product->get_id()); ?>" data-product_variations="<?php echo esc_attr($variations_attr); // WPCS: XSS ok. 
                                                                                                                                                                                                                                                                                            ?>">
    <?php do_action('woocommerce_before_variations_form'); ?>

    <?php if (empty($available_variations) && false !== $available_variations) : ?>
        <p class="stock out-of-stock"><?php echo esc_html(apply_filters('woocommerce_out_of_stock_message', __('This product is currently out of stock and unavailable.', 'nebon'))); ?></p>
    <?php else : ?>
        <div class="variations">
            <?php foreach ($attributes as $attribute_name => $options) : ?>
                <?php
                $attr = Tech888f_Woocommerce_Attributes::tech888f_get_tax_attribute($attribute_name);
                if (isset($attr->attribute_type)) {
                    $el_class = $attr->attribute_type;
                } else {
                    $el_class = '';
                }

                $selected = isset($_REQUEST['attribute_' . sanitize_title($attribute_name)]) ? wc_clean(stripslashes(urldecode($_REQUEST['attribute_' . sanitize_title($attribute_name)]))) : $product->get_variation_default_attribute($attribute_name);
                ?>

                <div class="detail-attr attr-<?php echo sanitize_title($attribute_name) . ' type-' . esc_attr($el_class); ?>">
                    <label for="<?php echo sanitize_title($attribute_name); ?>" class="title-atttr"><?php echo wc_attribute_label($attribute_name); ?>:</label>

                    <select id="<?php echo sanitize_title($attribute_name); ?>" name="attribute_<?php echo sanitize_title($attribute_name); ?>" data-attribute_name="attribute_<?php echo sanitize_title($attribute_name); ?>" style="display: none;">
                        <option value=""><?php echo esc_html__('Select', 'nebon'); ?></option>
                        <?php foreach ($options as $option) : ?>
                            <option value="<?php echo esc_attr($option); ?>" <?php selected($selected, $option); ?>><?php echo esc_html(apply_filters('woocommerce_variation_option_name', $option)); ?></option>
                        <?php endforeach; ?>
                    </select>

                    <div class="variation-buttons">
                        <?php foreach ($options as $option) : ?>
                            <?php
                            $option_name = apply_filters('woocommerce_variation_option_name', $option);
                            $selected_class = $selected === $option ? ' selected' : '';

                            $is_color = sanitize_title($attribute_name) === 'pa_color';
                            $color = '';

                            if ($is_color) {
                                $term = get_term_by('slug', $option, 'pa_color');
                                if ($term && !is_wp_error($term)) {
                                    $color = get_term_meta($term->term_id, 'color', true);
                                }
                            }
                            ?>

                            <?php if ($is_color && $color): ?>
                                <div class="variation-color-item">
                                    <button type="button"
                                        class="variation-button color-swatch <?php echo esc_attr($selected_class); ?>"
                                        data-value="<?php echo esc_attr($option); ?>"
                                        title="<?php echo esc_attr($option_name); ?>"
                                        style="background-color: <?php echo esc_attr($color); ?>;">
                                    </button>
                                </div>
                            <?php else: ?>
                                <button type="button"
                                    class="variation-button btn-variation<?php echo esc_attr($selected_class); ?>"
                                    data-value="<?php echo esc_attr($option); ?>"
                                    title="<?php echo esc_attr($option_name); ?>">
                                    <?php echo esc_html($option_name); ?>
                                </button>
                            <?php endif; ?>

                        <?php endforeach; ?>
                    </div>


                </div>


            <?php endforeach; ?>
        </div>
        <div class="clear-variation-wrap">
    <button type="button" class="reset_variations"><?php esc_html_e('Clear', 'nebon'); ?></button>
</div>

        <div class="reset_variations_alert screen-reader-text" role="alert" aria-live="polite" aria-relevant="all"></div>
        <?php do_action('woocommerce_after_variations_table'); ?>

        <div class="single_variation_wrap">
            <?php
            /**
             * Hook: woocommerce_before_single_variation.
             */
            do_action('woocommerce_before_single_variation');
            
            /**
             * Hook: woocommerce_single_variation. Used to output the cart button and placeholder for variation data.
             *
             * @since 2.4.0
             * @hooked woocommerce_single_variation - 10 Empty div for variation data.
             * @hooked woocommerce_single_variation_add_to_cart_button - 20 Qty and cart button.
             */
            do_action('woocommerce_single_variation');

            /**
             * Hook: woocommerce_after_single_variation.
             */
            do_action('woocommerce_after_single_variation');
            ?>
        </div>
    <?php endif; ?>

    <?php do_action('woocommerce_after_variations_form'); ?>
</form>

<?php
do_action('woocommerce_after_add_to_cart_form');

?>
