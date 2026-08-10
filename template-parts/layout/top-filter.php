<?php

/**
 * Template part for displaying the top filter in WooCommerce archive pages.
 *
 * @package Nebon
 * @version 1.0.0
 * @param $posts_per_page int Number of posts per page.
 * @param $show_number_filter string Whether to show the number filter.
 * @param $show_type_filter string Whether to show the type filter.
 * @param $current_url string The current URL for filtering.
 * @param $show_custom_ordering_dropdown string Whether to show the custom ordering dropdown.
 * @param $layout_styles array Styles available for the layout.
 * @param $per_page_options array Options for posts per page.
 * @param $style string Current style of the shop.
 * @param $paged int Current page number.
 * @param $total int Total number of products.
 * @param $start int Starting index of the products being displayed.
 * @param $end int Ending index of the products being displayed.
 */
if (!defined('ABSPATH')) {
    exit;
}
// if the filters are not enabled, return early
if ($show_number_filter === 'off' && $show_type_filter === 'off' && $show_custom_ordering_dropdown === 'off') {
    return;
}
?>
<div class="show-filter d-flex align-items-center">
    <div class="show-filter-left d-flex align-items-center">
        <button type="button" class="btn-toggle-filter">
            <i class="las la-filter"></i> <?php esc_html_e('Filter', 'nebon'); ?>
        </button>
        <?php if ($show_number_filter === 'on') : ?>
            <div class="show-per-page">
                <span><?php esc_html_e('Show:', 'nebon'); ?></span>
                <?php foreach ($per_page_options as $option) :
                    $active = ($option == $posts_per_page) ? 'active' : '';
                    $url = add_query_arg([
                        'posts_per_page' => $option,
                    ], $current_url);
                ?>
                    <a href="<?php echo esc_url($url); ?>" class="<?php echo esc_attr($active); ?>">
                        <?php echo esc_html($option); ?>
                    </a>
                    <?php if ($option !== end($per_page_options)) echo ' / '; ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if ($show_type_filter === 'on'): ?>
            <div class="view-style d-flex">
                <?php foreach ($layout_styles as $style_key => $icon) :
                    $active = ($style_key == $style) ? 'active' : '';
                    $url = add_query_arg([
                        'view' => $style_key,
                    ], $current_url);
                ?>
                    <a href="<?php echo esc_url($url); ?>" class="view-<?php echo esc_attr($style_key); ?> <?php echo esc_attr($active); ?>">
                        <i class="<?php echo esc_attr($icon); ?>"></i>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif;  ?>

    </div>

    <div class="show-filter-right d-flex align-items-center">
        <?php if ($show_custom_ordering_dropdown === 'on'): ?>
            <p class="show-number">
                <?php if ($total > 0): ?>
                    <?php esc_html_e('Showing', 'nebon'); ?>
                    <?php echo esc_html($start . '-' . $end); ?>
                    <?php esc_html_e('of', 'nebon'); ?>
                    <?php echo esc_html($total); ?>
                    <?php esc_html_e('results', 'nebon'); ?>
                <?php else: ?>
                    <?php esc_html_e('No products found', 'nebon'); ?>
                <?php endif; ?>
            </p>
            <?php
            if (is_shop() || is_product_category() || is_product_tag()) {
                do_action('t888f_custom_woocommerce_ordering');
            } else {
                t888f_get_template(
                    'woocommerce/shop-structure/order-filter',
                    '',
                    [
                        'current_orderby' => $current_orderby,
                        'orderby_options' => $orderby_options
                    ],
                    true
                );
            }


            ?>
        <?php endif; ?>
    </div>
</div>