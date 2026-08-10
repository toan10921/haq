<?php
$banner_items = is_array($banner_items ?? null) ? $banner_items : [];
?>

<div class="t888-banner-ads-wrap t888-banner-ads">
    <?php foreach ($banner_items as $ad_item): ?>
        <?php
        $item_id = $ad_item['_id'] ?? uniqid();
        $type    = $ad_item['item_type'] ?? 'text';
        $classes = 'banner-layer elementor-repeater-item-' . $item_id . ' type-' . $type;

        // Inline fallback for position:absolute so overlay works before CSS loads
        $inline = '';
        if (($ad_item['position'] ?? 'relative') === 'absolute') {
            $inline = 'position: absolute;';
        }
        ?>
        <div class="<?php echo esc_attr($classes); ?>"<?php echo $inline ? ' style="' . esc_attr($inline) . '"' : ''; ?>>

            <?php if ($type === 'text'): ?>
                <div class="ad-text-el">
                    <?php echo wp_kses_post($ad_item['text_content'] ?? ''); ?>
                </div>

            <?php elseif ($type === 'image' && !empty($ad_item['image']['url'])):
                $has_link = !empty($ad_item['link']['url']);
                if ($has_link) {
                    $target = !empty($ad_item['link']['is_external']) ? ' target="_blank"' : '';
                    $rel    = !empty($ad_item['link']['nofollow']) ? ' rel="nofollow"' : '';
                    echo '<a href="' . esc_url($ad_item['link']['url']) . '" class="ad-img-el"' . $target . $rel . ' style="display:block;">';
                } else {
                    echo '<div class="ad-img-el">';
                }
            ?>
                <img src="<?php echo esc_url($ad_item['image']['url']); ?>"
                     alt="<?php echo esc_attr__('Banner Image', 'nebon'); ?>"
                     style="max-width: 100%; display: block;">
            <?php
                echo $has_link ? '</a>' : '</div>';

            elseif ($type === 'button'):
                $target = !empty($ad_item['link']['is_external']) ? ' target="_blank"' : '';
                $rel    = !empty($ad_item['link']['nofollow']) ? ' rel="nofollow"' : '';
                $href   = !empty($ad_item['link']['url']) ? esc_url($ad_item['link']['url']) : '#';
            ?>
                <a href="<?php echo $href; ?>" class="ad-btn"<?php echo $target . $rel; ?>>
                    <?php echo esc_html($ad_item['button_text'] ?? ''); ?>
                </a>

            <?php endif; ?>

        </div>
    <?php endforeach; ?>
</div>
