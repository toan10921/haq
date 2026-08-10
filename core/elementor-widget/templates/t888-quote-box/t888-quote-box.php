<?php /** @var array $settings */ ?>
<div class="t888-quote-box-wrapper">
    <div class="t888-quote-box-main">

        <!-- Left Column: Year + Image -->
        <div class="t888-quote-left reveal-left">
        <div class="t888-year-vertical reveal-up">
    <?php
    $chars = str_split(trim($year_label));
    foreach ($chars as $char) {
        echo '<div class="t888-year-char">' . esc_html($char) . '</div>';
    }
    ?>
</div>

            <div class="t888-quote-image">
                <img src="<?php echo esc_url($image['url']); ?>" alt="Quote Image" />
            </div>
        </div>

        <!-- Right Column: Logos + Content -->
        <div class="t888-quote-right reveal-right">
            <?php if (!empty($logos)): ?>
                <div class="t888-quote-logos">
                    <?php foreach ($logos as $logo): ?>
                        <div class="t888-quote-logo">
                            <img src="<?php echo esc_url($logo['logo_image']['url']); ?>" alt="<?php echo esc_attr($logo['alt']); ?>" />
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <div class="t888-quote-content">
                <div class="t888-quote-description">
                    <?php echo esc_html($description_text); ?>
                </div>

                <div class="t888-quote-text">
                    <?php echo wp_kses_post($quote_text); ?>
                </div>

                <div class="t888-quote-author">
                    <?php echo esc_html($author); ?>
                </div>
            </div>
        </div>

    </div>
</div>

