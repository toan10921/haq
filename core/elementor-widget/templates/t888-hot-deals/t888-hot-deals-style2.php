<?php
if (!defined('ABSPATH')) exit;
$background_image = $background_image ?? '';
$title       = $title ?? '';
$subtitle    = $subtitle ?? '';
$deadline    = $sale_deadline ?? '';
$product_ids_raw = $sale_products_style2 ?? [];

$product_ids = is_array($product_ids_raw)
    ? array_filter(array_map('intval', $product_ids_raw))
    : [];

if (empty($product_ids)) return;

$now = time();
$infinitive_sale = $infinitive_sale ?? '';
$deadline_ts = 0;
$loop_days = 10;

if (!empty($deadline)) {
    $tz = wp_timezone();
    $dt = date_create_immutable($deadline, $tz);
    $deadline_ts = $dt ? $dt->getTimestamp() : strtotime($deadline);

    if ($infinitive_sale === 'yes' && $deadline_ts > 0 && $deadline_ts <= $now) {
        $period = $loop_days * DAY_IN_SECONDS;
        $steps  = (int) ceil(($now - $deadline_ts) / $period);
        $deadline_ts += max(1, $steps) * $period; 
    }
} elseif ($infinitive_sale === 'yes') {
    $deadline_ts = $now + ($loop_days * DAY_IN_SECONDS);
}

if (!$deadline_ts || ($now >= $deadline_ts && $infinitive_sale !== 'yes')) return;



$products = wc_get_products([
    'include' => $product_ids,
    'orderby' => 'post__in',
    'limit'   => count($product_ids),
]);

if (empty($products)) return;
?>

<div class="t888-hot-deals style2">
    <?php if ($background_image || $title || $subtitle || $deadline_ts || $button_text): ?>
        <div class="hot-deals-top" <?php if ($background_image): ?>style="background-image: url('<?php echo esc_url($background_image['url']); ?>');" <?php endif; ?>>
            <div class="container">
                <div class="hot-deals-top-content">
                    <?php if ($title): ?>
                        <h3 class="hot-deals-title"><?php echo esc_html($title); ?></h3>
                    <?php endif; ?>

                    <?php if ($subtitle): ?>
                        <div class="hot-deals-subtitle"><?php echo esc_html($subtitle); ?></div>
                    <?php endif; ?>

                    <?php if ($deadline_ts): ?>
                        <div class="hot-deals-countdown"
                            data-deadline="<?php echo esc_attr($deadline_ts * 1000); ?>"
                            data-loop-days="<?php echo esc_attr($infinitive_sale === 'yes' ? $loop_days : 0); ?>">
                            <div class="deal-time"><span class="time-number">00</span><span class="time-label">day</span></div>
                            <div class="deal-time"><span class="time-number">00</span><span class="time-label">hour</span></div>
                            <div class="deal-time"><span class="time-number">00</span><span class="time-label">mins</span></div>
                            <div class="deal-time"><span class="time-number">00</span><span class="time-label">secs</span></div>
                        </div>


                    <?php endif; ?>

                    <?php if (!empty($button_text) && !empty($link_button['url'])): ?>
                        <a class="hot-deals-button button" href="<?php echo esc_url($link_button['url']); ?>" target="<?php echo esc_attr($link_button['is_external'] ? '_blank' : '_self'); ?>" rel="<?php echo esc_attr($link_button['nofollow'] ? 'nofollow' : ''); ?>">
                            <?php echo esc_html($button_text); ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <div class="container">
        <div class="hot-deals-products products list">
            <?php foreach ($products as $product): ?>
                <?php
                if (!$product || !$product->is_visible()) continue;
                global $post;
                $post = get_post($product->get_id());
                setup_postdata($post);
                ?>
                <div class="product-item">
                    <?php
                    t888f_get_template('woocommerce/loop/list/list-2', '', [
                        'product'     => $product,
                        'size'        => get_theme_mod('show_single_size_extra_display', 'woocommerce_thumbnail'),
                        'style'       => get_theme_mod('single_item_style_extra_display', 'default'),
                    ], true);
                    ?>
                </div>
            <?php endforeach; ?>
            <?php wp_reset_postdata(); ?>
        </div>
    </div>
</div>