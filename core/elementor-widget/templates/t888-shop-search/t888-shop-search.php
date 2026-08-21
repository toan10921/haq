<div class="t888-shop-search" data-live-search="<?php echo esc_attr(($live_search ?? 'yes') === 'yes' ? 'yes' : 'no'); ?>" data-min-characters="<?php echo esc_attr(max(1, (int) ($minimum_characters ?? 1))); ?>" data-delay="<?php echo esc_attr(max(100, (int) ($typing_delay ?? 350))); ?>">
    <form class="t888-shop-search__form" role="search" method="get" action="<?php echo esc_url($form_action); ?>">
        <input class="t888-shop-search__input" type="search" name="product_search" value="<?php echo esc_attr($search_value); ?>" placeholder="<?php echo esc_attr($placeholder ?? ''); ?>" autocomplete="off">
        <?php foreach ($_GET as $key => $value) :
            if (in_array($key, ['product_search', 's', 'post_type', 'product-page', 'paged'], true) || is_array($value)) continue; ?>
            <input type="hidden" name="<?php echo esc_attr($key); ?>" value="<?php echo esc_attr(sanitize_text_field(wp_unslash($value))); ?>">
        <?php endforeach; ?>
        <button class="t888-shop-search__button" type="submit" aria-label="<?php echo esc_attr($button_label ?? __('Search products', 'nebon')); ?>">
            <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="6.5"/><path d="m16 16 4 4"/></svg>
        </button>
    </form>
    <span class="t888-shop-search__status screen-reader-text" aria-live="polite"></span>
</div>
