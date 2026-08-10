<?php
$left_title = $left_title ?? __('Food', 'nebon');
$right_title = $right_title ?? __('Cat Health', 'nebon');
$left_image_url = $left_image['url'] ?? '';
$right_image_url = $right_image['url'] ?? '';
$left_items = is_array($left_items ?? null) ? $left_items : [];
$right_items = is_array($right_items ?? null) ? $right_items : [];
$bottom_banner_image_url = $bottom_banner_image['url'] ?? '';
$bottom_banner_link_url = $bottom_banner_link['url'] ?? '#';
$bottom_banner_target = !empty($bottom_banner_link['is_external']) ? ' target="_blank"' : '';
$bottom_banner_nofollow = !empty($bottom_banner_link['nofollow']) ? ' rel="nofollow"' : '';
$box_background = $box_background ?? '#eeeeee';
?>

<div class="t888-pet-mega-menu" style="--pet-menu-bg: <?php echo esc_attr($box_background); ?>;">
    <div class="pet-mega-columns">
        <div class="pet-mega-column">
            <?php if ($left_image_url): ?>
                <div class="pet-mega-thumb">
                    <img src="<?php echo esc_url($left_image_url); ?>" alt="<?php echo esc_attr($left_title); ?>">
                </div>
            <?php endif; ?>

            <div class="pet-mega-content">
                <?php if (!empty($left_title)): ?>
                    <h4 class="pet-mega-title"><?php echo esc_html($left_title); ?></h4>
                <?php endif; ?>

                <?php if (!empty($left_items)): ?>
                    <ul class="pet-mega-list">
                        <?php foreach ($left_items as $item):
                            $item_text = $item['text'] ?? '';
                            $item_url = $item['link']['url'] ?? '#';
                            $item_target = !empty($item['link']['is_external']) ? ' target="_blank"' : '';
                            $item_nofollow = !empty($item['link']['nofollow']) ? ' rel="nofollow"' : '';
                            if (empty($item_text)) {
                                continue;
                            }
                        ?>
                            <li>
                                <a href="<?php echo esc_url($item_url); ?>"<?php echo $item_target . $item_nofollow; ?>>
                                    <?php echo esc_html($item_text); ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>

        <div class="pet-mega-column">
            <?php if ($right_image_url): ?>
                <div class="pet-mega-thumb">
                    <img src="<?php echo esc_url($right_image_url); ?>" alt="<?php echo esc_attr($right_title); ?>">
                </div>
            <?php endif; ?>

            <div class="pet-mega-content">
                <?php if (!empty($right_title)): ?>
                    <h4 class="pet-mega-title"><?php echo esc_html($right_title); ?></h4>
                <?php endif; ?>

                <?php if (!empty($right_items)): ?>
                    <ul class="pet-mega-list">
                        <?php foreach ($right_items as $item):
                            $item_text = $item['text'] ?? '';
                            $item_url = $item['link']['url'] ?? '#';
                            $item_target = !empty($item['link']['is_external']) ? ' target="_blank"' : '';
                            $item_nofollow = !empty($item['link']['nofollow']) ? ' rel="nofollow"' : '';
                            if (empty($item_text)) {
                                continue;
                            }
                        ?>
                            <li>
                                <a href="<?php echo esc_url($item_url); ?>"<?php echo $item_target . $item_nofollow; ?>>
                                    <?php echo esc_html($item_text); ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php if ($bottom_banner_image_url): ?>
        <div class="pet-mega-banner-wrap">
            <a class="pet-mega-banner-link" href="<?php echo esc_url($bottom_banner_link_url); ?>"<?php echo $bottom_banner_target . $bottom_banner_nofollow; ?>>
                <img class="pet-mega-banner-image" src="<?php echo esc_url($bottom_banner_image_url); ?>" alt="<?php esc_attr_e('Mega menu banner', 'nebon'); ?>">
            </a>
        </div>
    <?php endif; ?>
</div>
