<?php
/**
 * @version 10.1.0
 */
defined('ABSPATH') || exit;

if ($max_value && $min_value === $max_value) {
    ?>
    <div class="quantity hidden">
        <input type="hidden" id="<?php echo esc_attr($input_id); ?>" class="qty"
               name="<?php echo esc_attr($input_name); ?>" value="<?php echo esc_attr($min_value); ?>"/>
    </div>
    <?php
} else {
    ?>
    <div class="quantity">
        <button type="button" class="minus">-</span></button>
        <input
            type="number"
            id="<?php echo esc_attr($input_id); ?>"
            class="input-text qty text"
            step="<?php echo esc_attr($step); ?>"
            min="<?php echo esc_attr($min_value); ?>"
            max="<?php echo esc_attr(0 < $max_value ? $max_value : ''); ?>"
            name="<?php echo esc_attr($input_name); ?>"
            value="<?php echo esc_attr($input_value); ?>"
            title="<?php echo esc_attr_x('Qty', 'Product quantity input tooltip', 'nebon'); ?>"
            size="4"
            placeholder="<?php echo esc_attr($placeholder); ?>"
            inputmode="<?php echo esc_attr($inputmode); ?>"/>
        <button type="button" class="plus">+</button>
    </div>
    <?php
}
