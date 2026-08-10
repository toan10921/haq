<div class="t888-feature-box-wrapper">
    <div class="t888-feature-box-container">
        <div class="t888-feature-box-column t888-feature-box-left">
            <?php foreach ($left_features as $item): ?>
                <div class="t888-feature-box-item">
                    
                    <div class="t888-feature-box-content">
                        <h3><?php echo esc_html($item['title']); ?></h3>
                        <p><?php echo esc_html($item['description']); ?></p>
                    </div>
                    <div class="t888-feature-box-icon">
                        <i class="<?php echo esc_attr($item['icon_class']); ?>"></i>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="t888-feature-box-center">
            <h2 class="t888-feature-box-title-1"><?php echo esc_html($title_1); ?></h2>
            <h3 class="t888-feature-box-title-2"><?php echo esc_html($title_2); ?></h3>
            <div class="t888-feature-box-description">
                <?php echo esc_html($description); ?>
            </div>
            <?php if (!empty($button_text) && !empty($button_link['url'])): ?>
                <div class="t888-feature-box-button">
                    <a href="<?php echo esc_url($button_link['url']); ?>" class="t888-button">
                        <?php echo esc_html($button_text); ?>
                    </a>
                </div>
            <?php endif; ?>
        </div>

        <div class="t888-feature-box-column t888-feature-box-right">
            <?php foreach ($right_features as $item): ?>
                <div class="t888-feature-box-item">
                    <div class="t888-feature-box-icon">
                        <i class="<?php echo esc_attr($item['icon_class']); ?>"></i>
                    </div>
                    <div class="t888-feature-box-content">
                        <h3><?php echo esc_html($item['title']); ?></h3>
                        <p><?php echo esc_html($item['description']); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>