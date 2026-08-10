<div class="custom-logo-wrapper <?php echo esc_attr($style); ?>">
    <div class="m-0 logo-wrapper site-logo">
        <a href="<?php echo esc_url(home_url('')); ?>" class="custom-logo-link">
            <?php if (!empty($logo_image['url'])) : ?>
                <img src="<?php echo esc_url($logo_image['url']); ?>" alt="<?php echo esc_attr($logo_text); ?>" class="custom-logo-img">
            <?php endif; ?>

            <?php if (!empty($logo_text)) : ?>
                <span class="custom-logo-text"><?php echo apply_filters('t888_template_content', $logo_text); ?></span>
            <?php endif; ?>
        </a>
        <div class="d-none">
            <?php echo get_bloginfo('name'); ?> <span class="site-description"><?php echo get_bloginfo('description'); ?></span>
        </div>
    </div>
</div>