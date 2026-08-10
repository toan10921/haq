<?php

if (!defined('ABSPATH')) {
    exit;
}

$raw_placeholder = isset($placeholder) ? (string) $placeholder : '';
$placeholder_text = (trim($raw_placeholder) !== '') ? $raw_placeholder : __('Search ...', 'nebon');

$selected_post_type = isset($post_type) ? (string) $post_type : 'product';
$show_cats = isset($show_categories) ? (string) $show_categories : 'yes';
$use_ajax = isset($ajax_search) ? (string) $ajax_search : 'yes';

$taxonomy = ($selected_post_type === 'product') ? 'product_cat' : 'category';
$categories = [];
if ($show_cats === 'yes') {
    $terms = get_terms([
        'taxonomy' => $taxonomy,
        'hide_empty' => false,
        'orderby' => 'name',
        'order' => 'ASC',
    ]);
    if (!is_wp_error($terms) && !empty($terms)) {
        $categories = $terms;
    }
}

?>
<div class="t888-search-form-inline-wrap style2">
    <form class="t888-search-form-inline search-form <?php echo esc_attr($use_ajax === 'yes' ? 'search-ajax' : ''); ?>" action="<?php echo esc_url(home_url('/')); ?>" method="get" role="search">
        <label class="d-none" for="t888-search-inline-input"><?php echo esc_html__('Search', 'nebon'); ?></label>
        <input id="t888-search-inline-input" name="s" type="text"
               placeholder="<?php echo esc_attr($placeholder_text); ?>"
               autocomplete="off"
               class="input-search fw-normal title14" />

        <?php if ($show_cats === 'yes' && !empty($categories)) : ?>
            <div class="custom-dropdown custom-dropdown-categories">
                <div class="custom-dropdown-toggle-search position-relative">
                    <?php esc_html_e('All Categories', 'nebon'); ?>
                </div>
                <ul class="custom-dropdown-menu-categories">
                    <?php foreach ($categories as $category) : ?>
                        <li>
                            <a data-category="<?php echo esc_attr($category->slug); ?>" href="#" class="title13">
                                <?php echo esc_html($category->name); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <select name="category" class="form-select d-none">
                <option value=""><?php esc_html_e('All Categories', 'nebon'); ?></option>
                <?php foreach ($categories as $category) : ?>
                    <option value="<?php echo esc_attr($category->slug); ?>">
                        <?php echo esc_html($category->name); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        <?php endif; ?>

        <input type="hidden" name="post_type" value="<?php echo esc_attr($selected_post_type); ?>" />

        <button type="submit" class="btn btn-primary btn-search title24 secondary d-flex align-items-center justify-content-center" aria-label="<?php echo esc_attr__('Search', 'nebon'); ?>">
            <i class="las la-search"></i>
        </button>

        <div class="list-search-results" data-search_min_length="<?php echo esc_attr__('Please enter at least 3 characters.', 'nebon'); ?>">
            <p class="text-center m-0">
                <?php echo esc_html__('Please enter key search to display results.', 'nebon'); ?>
            </p>
        </div>
    </form>
</div>
