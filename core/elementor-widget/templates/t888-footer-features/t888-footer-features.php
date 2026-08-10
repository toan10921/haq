<?php
/**
 * Template for Footer Features Widget
 */
// The controller passes settings as individual variables and also in a $settings array.
$feature_items = isset($items) ? $items : (isset($settings['items']) ? $settings['items'] : array());
?>

<div class="footer-features-widget">
    <div class="footer-features-inner">
        <div class="features-list">
            <?php
if (!empty($feature_items)):
    foreach ($feature_items as $item):
?>
                <div class="feature-item">
                    <?php if (!empty($item['icon_type'])): ?>
                        <div class="feature-icon">
                            <?php if ($item['icon_type'] === 'icon' && !empty($item['icon'])): ?>
                                <?php
                \Elementor\Icons_Manager::render_icon($item['icon'], array('aria-hidden' => 'true'));
?>
                            <?php
            elseif ($item['icon_type'] === 'image' && !empty($item['image']['url'])): ?>
                                <img src="<?php echo esc_url($item['image']['url']); ?>" alt="<?php echo esc_attr(isset($item['title']) ? $item['title'] : ''); ?>">
                            <?php
            endif; ?>
                        </div>
                    <?php
        endif; ?>
                    
                    <div class="feature-content">
                        <?php if (!empty($item['title'])): ?>
                            <h4 class="feature-title"><?php echo esc_html($item['title']); ?></h4>
                        <?php
        endif; ?>
                        <?php if (!empty($item['description'])): ?>
                            <p class="feature-desc"><?php echo esc_html($item['description']); ?></p>
                        <?php
        endif; ?>
                    </div>
                </div>
            <?php
    endforeach;
endif;
?>
        </div>
    </div>
</div>
