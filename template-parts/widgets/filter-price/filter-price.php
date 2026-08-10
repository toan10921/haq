<?php
extract($data);
if (!defined('ABSPATH')) exit;

global $wpdb;

$min_price = 0;
$max_price = ceil($wpdb->get_var("
    SELECT MAX(CAST(meta_value AS UNSIGNED)) 
    FROM $wpdb->postmeta 
    WHERE meta_key = '_price' 
    AND meta_value > 0
"));

$current_min = isset($_GET['min_price']) ? intval($_GET['min_price']) : $min_price;
$current_max = isset($_GET['max_price']) ? intval($_GET['max_price']) : $max_price;
?>

<div class="custom-price-filter">
    <h5 class="widget-title"><?php echo esc_html($title); ?></h5>
    <div id="price-range"></div>
    <div class="price-filter-container">
        <p>Price: $<span id="price-min-value"><?php echo esc_html($current_min); ?></span> — $<span id="price-max-value"><?php echo esc_html($current_max); ?></span></p>
        <button type="button" class="button" id="apply-price-filter"><?php esc_html_e('FILTER', 'nebon'); ?></button>
    </div>
    <input type="hidden" id="price-min" value="<?php echo esc_attr($current_min); ?>">
    <input type="hidden" id="price-max" value="<?php echo esc_attr($current_max); ?>">
    <input type="hidden" id="price-max-limit" value="<?php echo esc_attr($max_price); ?>">
</div>
