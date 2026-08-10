<?php
/**
 * Template for Footer Newsletter Widget
 */
$title_text = $title ?? '';
$desc_text = $description ?? '';
$image_url = !empty($image['url']) ? $image['url'] : '';
$bg_pattern_url = !empty($bg_pattern['url']) ? $bg_pattern['url'] : '';
$input_placeholder = $placeholder ?? 'Enter your Email ID';
$submit_btn_text = $button_text ?? 'SUBMIT NOW';
?>

<div class="footer-newsletter-widget">
    <div class="footer-newsletter-inner">
        <?php if ($image_url): ?>
            <div class="newsletter-image">
                <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($title_text); ?>">
            </div>
        <?php
endif; ?>

        <div class="footer-newsletter-content">
            <?php if ($title_text): ?>
                <h2 class="newsletter-title"><?php echo esc_html($title_text); ?></h2>
            <?php
endif; ?>
            
            <?php if ($desc_text): ?>
                <p class="newsletter-desc"><?php echo esc_html($desc_text); ?></p>
            <?php
endif; ?>

            <div class="newsletter-form">
                <form action="#" method="post">
                    <div class="form-group">
                        <input type="email" name="email" placeholder="<?php echo esc_attr($input_placeholder); ?>" required>
                        <button type="submit"><?php echo esc_html($submit_btn_text); ?></button>
                    </div>
                </form>
            </div>
        </div>
        
        <?php if ($bg_pattern_url): ?>
            <div class="footer-newsletter-paw-bg" style="background-image: url('<?php echo esc_url($bg_pattern_url); ?>');">
            </div>
        <?php
else: ?>
            <div class="footer-newsletter-paw-bg">
                <i class="fas fa-paw"></i>
                <i class="fas fa-paw"></i>
                <i class="fas fa-paw"></i>
            </div>
        <?php
endif; ?>
    </div>
</div>
