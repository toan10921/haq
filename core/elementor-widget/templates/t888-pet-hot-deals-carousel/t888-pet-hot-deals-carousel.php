<?php
$title = $title ?? 'HOT DEALS:';
$sale_deadline = $sale_deadline ?? '';
$auto_loop = $auto_loop ?? '';
$auto_loop_days = (float)($auto_loop_days ?? 5);
$auto_loop_hours = (float)($auto_loop_hours ?? 0);
$columns = $columns ?? '5';
$slider_autoplay = ($slider_autoplay ?? 'yes') === 'yes' ? 'yes' : 'no';
$slider_autoplay_delay = max(1, (int)($slider_autoplay_delay ?? 3));
$product_style = $product_style ?? 'style6';
$show_nav_arrows = ($show_nav_arrows ?? 'yes') === 'yes';
$product_card_style = $style6_product_style ?? 'hotdeals';
$product_ids_raw = is_array($sale_products ?? null) ? $sale_products : [];
$product_ids = array_filter(array_map('intval', $product_ids_raw));

if ($product_style === 'style6') {
    if ($product_card_style === 'standard') {
        $product_template = 'woocommerce/loop/grid/grid-pet-category-horizontal';
    } elseif ($product_card_style === 'pet-category') {
        $product_template = 'woocommerce/loop/grid/grid-pet-category';
    } else {
        $product_template = 'woocommerce/loop/grid/grid-hotdeals';
    }
} else {
    $product_template = 'woocommerce/loop/grid/grid-pet-category';
}

$deadline_timestamp = !empty($sale_deadline) ? strtotime($sale_deadline) : time() + 86400 * 9 + 3600 * 20 + 60 * 7 + 14; 

if ($auto_loop === 'yes') {
    $now = time();
    $duration_seconds = ($auto_loop_days * 86400) + ($auto_loop_hours * 3600);
    if ($duration_seconds > 0 && $now >= $deadline_timestamp) {
        $diff = $now - $deadline_timestamp;
        $loops_passed = floor($diff / $duration_seconds) + 1;
        $deadline_timestamp += $loops_passed * $duration_seconds;
    }
}

$unique_id = uniqid('countdown_');
?>

<div class="t888-pet-hot-deals-module product-style-<?php echo esc_attr($product_style); ?>">
    <div class="hot-deals-header">
        <div class="header-left">
            <h3 class="hot-deals-title">
                <?php echo esc_html($title); ?>
            </h3>
            <div class="hot-deals-countdown t888-countdown" id="<?php echo esc_attr($unique_id); ?>" data-deadline="<?php echo esc_attr($deadline_timestamp); ?>">
                <div class="cd-item">
                    <span class="days">00</span>
                    <span class="cd-label">days</span>
                </div>
                <div class="cd-item">
                    <span class="hours">00</span>
                    <span class="cd-label">hurs</span>
                </div>
                <div class="cd-item">
                    <span class="mins">00</span>
                    <span class="cd-label">mins</span>
                </div>
                <div class="cd-item">
                    <span class="secs">00</span>
                    <span class="cd-label">secs</span>
                </div>
            </div>
        </div>
        <?php if ($show_nav_arrows) : ?>
            <div class="header-nav">
                <button class="nav-prev"><i class="las la-angle-left"></i></button>
                <button class="nav-next"><i class="las la-angle-right"></i></button>
            </div>
        <?php endif; ?>
    </div>

    <div
        class="hot-deals-products swiper swiper-pet-hot-deals"
        data-columns="<?php echo esc_attr($columns); ?>"
        data-autoplay="<?php echo esc_attr($slider_autoplay); ?>"
        data-autoplay-delay="<?php echo esc_attr($slider_autoplay_delay); ?>"
    >
        <div class="swiper-wrapper">
            <?php 
            if (!empty($product_ids)):
                foreach ($product_ids as $product_id): 
                    $product = wc_get_product($product_id);
                    if (!$product || !$product->is_visible()) continue;
                    ?>
                    <div class="swiper-slide product-item-wrap">
                        <?php
                        t888f_get_template($product_template, '', [
                            'product'         => $product,
                            'size'            => 'woocommerce_thumbnail',
                            'style'           => 'default',
                            'show_badge_sale' => $show_badge_sale ?? 'yes',
                            'show_badge_new'  => $show_badge_new ?? 'yes',
                            'show_badge_hot'  => $show_badge_hot ?? 'yes',
                        ], true);
                        ?>
                    </div>
                    <?php 
                endforeach; 
            else:
                echo '<p>' . __('Please select products in the widget settings.', 'nebon') . '</p>';
            endif; 
            ?>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var timerElem = document.getElementById('<?php echo esc_js($unique_id); ?>');
    if (!timerElem) return;

    var deadline = parseInt(timerElem.getAttribute('data-deadline'), 10) * 1000;
    
    function updateClock() {
        var t = deadline - new Date().getTime();
        if (t < 0) {
            <?php if ($auto_loop === 'yes'): ?>
                var duration = <?php echo ($auto_loop_days * 86400 + $auto_loop_hours * 3600) * 1000; ?>;
                if (duration > 0) {
                    var diff = new Date().getTime() - deadline;
                    var loops = Math.floor(diff / duration) + 1;
                    deadline += loops * duration;
                    timerElem.setAttribute('data-deadline', deadline / 1000);
                    t = deadline - new Date().getTime();
                } else {
                    return;
                }
            <?php else: ?>
                return;
            <?php endif; ?>
        }
        
        var days = Math.floor(t / (1000 * 60 * 60 * 24));
        var hours = Math.floor((t % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((t % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((t % (1000 * 60)) / 1000);
        
        timerElem.querySelector('.days').innerText = ('0' + days).slice(-2);
        timerElem.querySelector('.hours').innerText = ('0' + hours).slice(-2);
        timerElem.querySelector('.mins').innerText = ('0' + minutes).slice(-2);
        timerElem.querySelector('.secs').innerText = ('0' + seconds).slice(-2);
    }
    
    updateClock();
    setInterval(updateClock, 1000);
});
</script>
