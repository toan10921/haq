<?php
$style           = isset($style) ? (string) $style : 'style1';
$show_categories = isset($show_categories) ? (string) $show_categories : 'yes';
$ajax_search     = isset($ajax_search) ? (string) $ajax_search : 'yes';

$raw        = isset($placeholder) ? (string) $placeholder : '';
$placeholder= (trim($raw) !== '') ? $raw : __('What are you searching for?', 'nebon');

$post_type  = isset($post_type) ? (string) $post_type : 'post';
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
    <form class="search-form-inline search-form <?php echo esc_attr($ajax_search === 'yes' ? 'search-ajax' : ''); ?>" action="<?php echo esc_url(home_url('/')); ?>" method="get">
        <input name="s" type="text"
               placeholder="<?php echo esc_attr($placeholder); ?>"
               autocomplete="off"
               class="input-search" />

        <?php if ($show_categories === 'yes' && !empty($categories) && !is_wp_error($categories)) : ?>
            <div class="custom-dropdown custom-dropdown-categories">
                <div class="custom-dropdown-toggle-search">
                    <?php esc_html_e('All Categories', 'nebon'); ?>
                </div>
                <ul class="custom-dropdown-menu-categories">
                    <li>
                        <a data-category="" href="#">
                            <?php esc_html_e('All Categories', 'nebon'); ?>
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
            <select name="category" class="form-select d-none">
                <option value=""><?php esc_html_e('All Categories', 'nebon'); ?></option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?php echo esc_attr($category->slug); ?>">
                        <?php echo esc_html($category->name); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        <?php endif; ?>

        <input type="hidden" name="post_type" value="<?php echo esc_attr($post_type); ?>" />
        <button type="submit" class="btn-search-submit">
            <i class="las la-search"></i>
        </button>
        
        <div class="list-search-results" data-search_min_length="<?php echo esc_attr__('Please enter at least 3 characters.', 'nebon'); ?>">
            <p class="text-center m-0">
                <?php echo esc_html__('Please enter key search to display results.', 'nebon'); ?>
            </p>
        </div>
    </form>
</div>
