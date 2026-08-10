<?php
class Custom_Walker_Category extends Walker_Category
{
    function start_el(&$output, $category, $depth = 0, $args = array(), $id = 0)
    {
        // Xác định các danh mục hiện tại
        if (is_category()) {
            $current_category_id = get_queried_object_id();
            $current_categories = array($current_category_id);
        } elseif (is_single()) {
            $categories = get_the_category();
            $current_categories = wp_list_pluck($categories, 'term_id');
        } else {
            $current_categories = array();
        }

        // Check if the current category is in the list of current categories
        $class = in_array($category->term_id, $current_categories) ? 'current-cat' : '';

        // Create category item
        $output .= '<li class="cat-item cat-item-' . $category->term_id . ' ' . $class . '">';
        $output .= '<a href="' . esc_url(get_category_link($category->term_id)) . '">' . esc_html($category->name) . '</a>';
        $output .= '</li>';
    }
}

function custom_category_widget_args($args)
{
    $args['walker'] = new Custom_Walker_Category();
    return $args;
}

add_filter('widget_categories_args', 'custom_category_widget_args');