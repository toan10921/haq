<?php
$feature_items = isset($items) && is_array($items) ? $items : [];
$feature_style = isset($layout_style) && $layout_style === 'style2' ? 'style2' : 'style1';
?>

<?php if (!empty($feature_items)): ?>
    <div class="t888-service-features t888-service-features--<?php echo esc_attr($feature_style); ?>">
        <div class="t888-service-features-grid">
            <?php foreach ($feature_items as $index => $item): ?>
                <article class="t888-service-feature-card<?php echo !empty($item['_id']) ? ' elementor-repeater-item-' . esc_attr($item['_id']) : ''; ?>">
                    <?php if ($feature_style === 'style1'): ?>
                        <div class="t888-service-feature-icon" aria-hidden="true">
                            <?php if (($item['icon_type'] ?? 'icon') === 'image' && !empty($item['image']['url'])): ?>
                                <span class="t888-service-feature-image" style="--t888-service-icon: url('<?php echo esc_url($item['image']['url']); ?>');"></span>
                            <?php elseif (!empty($item['icon']['value'])): ?>
                                <?php \Elementor\Icons_Manager::render_icon($item['icon'], ['aria-hidden' => 'true']); ?>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <div class="t888-service-feature-content">
                        <?php if (!empty($item['title'])): ?>
                            <h3 class="t888-service-feature-title"><?php echo esc_html($item['title']); ?></h3>
                        <?php endif; ?>

                        <?php if ($feature_style === 'style2'): ?>
                            <div class="t888-service-feature-middle">
                                <div class="t888-service-feature-icon" aria-hidden="true">
                                    <?php if (($item['icon_type'] ?? 'icon') === 'image' && !empty($item['image']['url'])): ?>
                                        <span class="t888-service-feature-image" style="--t888-service-icon: url('<?php echo esc_url($item['image']['url']); ?>');"></span>
                                    <?php elseif (!empty($item['icon']['value'])): ?>
                                        <?php \Elementor\Icons_Manager::render_icon($item['icon'], ['aria-hidden' => 'true']); ?>
                                    <?php endif; ?>
                                </div>

                                <span class="t888-service-feature-number" aria-hidden="true">
                                    <?php echo esc_html(sprintf('%02d', $index + 1)); ?>
                                </span>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($item['description'])): ?>
                            <p class="t888-service-feature-description"><?php echo esc_html($item['description']); ?></p>
                        <?php endif; ?>
                    </div>

                    <?php if ($feature_style === 'style1'): ?>
                        <span class="t888-service-feature-number" aria-hidden="true">
                            <?php echo esc_html(sprintf('%02d', $index + 1)); ?>
                        </span>
                    <?php endif; ?>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>
