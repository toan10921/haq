<div class="t888-shop-toolbar">
    <?php if (($show_result ?? 'yes') === 'yes'): ?>
        <p class="t888-shop-toolbar__result" aria-live="polite"><?php echo esc_html($result_text); ?></p>
    <?php endif; ?>

    <?php if (($show_sorting ?? 'yes') === 'yes'): ?>
        <form class="t888-shop-toolbar__form" method="get" action="<?php echo esc_url($form_action); ?>">
            <?php foreach ($_GET as $key => $value):
                if (in_array($key, ['orderby', 'product-page', 'paged'], true) || is_array($value))
                    continue; ?>
                <input type="hidden" name="<?php echo esc_attr($key); ?>"
                    value="<?php echo esc_attr(sanitize_text_field(wp_unslash($value))); ?>">
            <?php endforeach; ?>
            <label class="screen-reader-text"
                for="t888-orderby-<?php echo esc_attr($widget_id ?? wp_unique_id()); ?>"><?php esc_html_e('Product order', 'nebon'); ?></label>
            <select id="t888-orderby-<?php echo esc_attr($widget_id ?? wp_unique_id()); ?>"
                class="t888-shop-toolbar__select" name="orderby" onchange="this.form.submit()">
                <?php foreach ([
                    'menu_order' => __('Thứ tự mặc định', 'nebon'),
                    'popularity' => __('Theo mức độ phổ biến', 'nebon'),
                    'rating' => __('Theo điểm đánh giá', 'nebon'),
                    'date' => __('Mới nhất', 'nebon'),
                    'price' => __('Giá từ thấp đến cao', 'nebon'),
                    'price-desc' => __('Giá từ cao đến thấp', 'nebon'),
                    'title' => __('Theo tên: A đến Z', 'nebon'),
                    'title-desc' => __('Theo tên: Z đến A', 'nebon'),
                ] as $value => $label): ?>
                    <option value="<?php echo esc_attr($value); ?>" <?php selected($current_orderby, $value); ?>>
                        <?php echo esc_html($label); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </form>
    <?php endif; ?>
</div>