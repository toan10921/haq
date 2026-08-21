<aside class="t888-price-filter" data-min="<?php echo esc_attr($range_min); ?>" data-max="<?php echo esc_attr($range_max); ?>">
    <?php if (!empty($title)) : ?><h3 class="t888-price-filter__title"><?php echo esc_html($title); ?></h3><?php endif; ?>
    <form class="t888-price-filter__form" method="get" action="<?php echo esc_url(remove_query_arg(['min_price', 'max_price', 'product-page', 'paged'])); ?>">
        <?php foreach ($_GET as $key => $value) :
            if (in_array($key, ['min_price', 'max_price', 'product-page', 'paged'], true) || is_array($value)) continue; ?>
            <input type="hidden" name="<?php echo esc_attr($key); ?>" value="<?php echo esc_attr(sanitize_text_field(wp_unslash($value))); ?>">
        <?php endforeach; ?>

        <div class="t888-price-filter__slider">
            <span class="t888-price-filter__track"></span>
            <span class="t888-price-filter__range-fill"></span>
            <input class="t888-price-filter__range t888-price-filter__range--min" type="range" min="<?php echo esc_attr($range_min); ?>" max="<?php echo esc_attr($range_max); ?>" step="1" value="<?php echo esc_attr($current_min); ?>" aria-label="<?php esc_attr_e('Minimum price', 'nebon'); ?>">
            <input class="t888-price-filter__range t888-price-filter__range--max" type="range" min="<?php echo esc_attr($range_min); ?>" max="<?php echo esc_attr($range_max); ?>" step="1" value="<?php echo esc_attr($current_max); ?>" aria-label="<?php esc_attr_e('Maximum price', 'nebon'); ?>">
        </div>

        <input class="t888-price-filter__min-input" type="hidden" name="min_price" value="<?php echo esc_attr($current_min); ?>"<?php echo !empty($is_full_range) ? ' disabled' : ''; ?>>
        <input class="t888-price-filter__max-input" type="hidden" name="max_price" value="<?php echo esc_attr($current_max); ?>"<?php echo !empty($is_full_range) ? ' disabled' : ''; ?>>
        <div class="t888-price-filter__footer">
            <button class="t888-price-filter__button" type="submit"><?php echo esc_html($button_text ?? __('Filter', 'nebon')); ?></button>
            <span class="t888-price-filter__label"><?php esc_html_e('Price:', 'nebon'); ?> <b class="t888-price-filter__min-label"><?php echo esc_html($currency_symbol . number_format_i18n($current_min)); ?></b> — <b class="t888-price-filter__max-label"><?php echo esc_html($currency_symbol . number_format_i18n($current_max)); ?></b></span>
        </div>
    </form>
</aside>
