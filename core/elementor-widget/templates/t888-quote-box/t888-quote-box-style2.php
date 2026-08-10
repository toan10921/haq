<div class="t888-quote-box-wrapper style-2">
    <div class="t888-quote-box-main">

        <!-- Left Column: Image -->
        <div class="t888-quote-left">
            <div class="t888-quote-image">
                <img src="<?php echo esc_url($image['url']); ?>" alt="Quote Image" />
            </div>
        </div>

        <!-- Right Column: Content -->
        <div class="t888-quote-right">
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

            <?php if (!empty($bottom_title) || !empty($bottom_text)) : ?>
                <div class="t888-quote-bottom-box">
                    <?php if (!empty($bottom_title)) : ?>
                        <h4 class="t888-bottom-title"><?php echo esc_html($bottom_title); ?></h4>
                    <?php endif; ?>

                    <?php if (!empty($bottom_text)) : ?>
                        <div class="t888-bottom-text">
                            <?php echo wp_kses_post($bottom_text); ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>

    </div>
</div>
