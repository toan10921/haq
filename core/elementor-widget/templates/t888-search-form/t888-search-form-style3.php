<?php
$style           = isset($style) ? (string) $style : 'style1';
$show_categories = isset($show_categories) ? (string) $show_categories : 'yes';
$ajax_search     = isset($ajax_search) ? (string) $ajax_search : 'yes';

$raw = isset($placeholder) ? trim((string) $placeholder) : '';
$legacy_placeholders = ['What are you searching for ?', 'What are you searching for?'];
$placeholder = ($raw === '' || in_array($raw, $legacy_placeholders, true))
    ? 'Tìm kiếm sản phẩm…'
    : $raw;

$post_type  = isset($post_type) ? (string) $post_type : 'post';
$form_action = ($post_type === 'product' && function_exists('wc_get_page_permalink'))
    ? wc_get_page_permalink('shop')
    : home_url('/');
$taxonomy = ($post_type === 'product') ? 'product_cat' : 'category';
$categories = [];

if ($show_categories === 'yes') {
    $terms = get_terms([
        'taxonomy'   => $taxonomy,
        'hide_empty' => false,   
        'orderby'    => 'name',
        'order'      => 'ASC',
    ]);

    if (!is_wp_error($terms) && !empty($terms)) {
        $categories = $terms;
    }
}
?>
<div class="t888-search-form-style3">
    <form class="search-form-inline search-form <?php echo esc_attr($ajax_search === 'yes' ? 'search-ajax' : ''); ?>" action="<?php echo esc_url($form_action); ?>" method="get">
        <input name="<?php echo esc_attr($post_type === 'product' ? 'product_search' : 's'); ?>" type="search"
               placeholder="<?php echo esc_attr($placeholder); ?>"
               autocomplete="off"
               class="input-search" />

        <?php if ($show_categories === 'yes' && !empty($categories) && !is_wp_error($categories)) : ?>
            <div class="custom-dropdown custom-dropdown-categories">
                <div class="custom-dropdown-toggle-search">
                    <?php esc_html_e('Tất cả danh mục', 'nebon'); ?>
                </div>
                <ul class="custom-dropdown-menu-categories">
                    <li>
                        <a data-category="" href="#">
                            <?php esc_html_e('Tất cả danh mục', 'nebon'); ?>
                        </a>
                    </li>
                    <?php foreach ($categories as $category): ?>
                        <li>
                            <a data-category="<?php echo esc_attr($category->slug); ?>" href="#">
                                <?php echo esc_html($category->name); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <select name="<?php echo esc_attr($post_type === 'product' ? 'product_cat' : 'category_name'); ?>" class="form-select d-none">
                <option value=""><?php echo esc_html('Tất cả danh mục'); ?></option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?php echo esc_attr($category->slug); ?>">
                        <?php echo esc_html($category->name); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        <?php endif; ?>

        <input type="hidden" name="post_type" value="<?php echo esc_attr($post_type); ?>" />
        <input type="hidden" name="t888_search_form" value="1" />
        <button type="submit" class="btn-search-submit">
            <i class="las la-search"></i>
        </button>
        
        <div class="list-search-results" data-search_min_length="<?php echo esc_attr('Vui lòng nhập ít nhất 3 ký tự.'); ?>">
            <p class="text-center m-0">
                <?php echo esc_html__('Vui lòng nhập từ khóa tìm kiếm.', 'nebon'); ?>
            </p>
        </div>
    </form>
</div>
