<?php if (!empty($accordion_items)) : ?>
    <div class="t888-accordion-wrapper">
        <?php foreach ($accordion_items as $index => $item) :
            $item_id = 't888-accordion-' . $widget_id . '-' . $index;
            ?>
            <div class="t888-accordion-item">
                <button class="t888-accordion-title" aria-expanded="false" aria-controls="<?php echo esc_attr($item_id); ?>">
                    <span class="t888-accordion-heading"><?php echo esc_html($item['title']); ?></span>
                    <span class="t888-accordion-icon">
                        <i class="las la-plus"></i>
                    </span>
                </button>
                <div id="<?php echo esc_attr($item_id); ?>" class="t888-accordion-content" hidden>
                    <div class="t888-accordion-inner">
                        <?php echo wp_kses_post($item['content']); ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
