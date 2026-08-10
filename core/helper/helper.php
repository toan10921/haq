<?php

use T888Core\TemplateHelper;

/**
 * Get template part by function, see detail in TemplateHelper class method static _load_view_template
 * @param string $slug
 * @param string $name
 * @param array $data
 * @param bool $echo
 * @return string
 */

if (!function_exists('t888f_get_template')) {
    function t888f_get_template($view_name = '', string $slug = '', $data = array(), $echo = FALSE)
    {
        $html = TemplateHelper::_load_view_template($view_name, $slug, $data, $echo);
        if (!$echo)
            return $html;
    }
}

/**
 * Get template part for widgets
 * @param string $view_name
 * @param string|bool $slug
 * @param array $data
 * @param bool $echo
 * @return string
 */
if (!function_exists('tech888f_get_template_widget')) {
    function tech888f_get_template_widget($view_name, $slug = false, $data = array(), $echo = FALSE)
    {
        $view_name = 'widgets/' . $view_name . '/' . $view_name;
        $html = TemplateHelper::_load_view_template($view_name, $slug, $data, $echo);
        if (!$echo)
            return $html;
    }
}

if (!function_exists('tech888f_get_template_elementor_widget')) {
    function tech888f_get_template_elementor_widget($view_name, $slug = false, $data = array(), $echo = FALSE)
    {
        $view_name = $view_name . '/' . $view_name;
        $html = TemplateHelper::_load_view_template_elementor($view_name, $slug, $data, $echo);
        if (!$echo)
            return $html;
    }
}

/**
 * Get theme mod repeater and decode to array
 * @param string $name
 * @param array $default
 * @return array
 * @since 1.0
 */

if (!function_exists('get_theme_mod_repeater')) {
    function get_theme_mod_repeater($name, $default = array())
    {
        $value = get_theme_mod($name, json_encode($default));
        return json_decode($value, true);
    }
}

/**
 * Utility function to print and die
 * @param array $data
 * @param bool $die
 * @return void
 * @since 1.0
 */

if (!function_exists('dd')) {
    function dd($data, $die = true)
    {
        echo '<pre>';
        print_r($data);
        echo '</pre>';
        if ($die)
            die;
    }
}

/**
 * Utility function to print value
 * @param mixed $value
 * @return void
 */

if (!function_exists('dump')) {
    function dump($data)
    {
        echo '<pre>';
        var_dump($data);
        echo '</pre>';
    }
}

/**
 * Custom function to display breadcrumb
 * @param string $step
 * @return string
 * @since 1.0
 */

if (!function_exists('t888f_breadcrumb')) {
    function t888f_breadcrumb($step = ' > ')
    {
        global $post;

        // Check if breadcrumb display is enabled
        $show_breadcrumb = get_theme_mod('show_breadcrumb', 'on');
        if ($show_breadcrumb !== 'on') {
            return; // Exit if breadcrumb is disabled
        }
        // if (is_front_page()) {
        //     return;
        // }
        // Get Customizer settings
        $breadcrumb_background = get_theme_mod('background_breadcrumb', '#5a4e4f');
        $breadcrumb_image = '';
        if (is_singular('post')) {
            $custom_image_id = get_post_meta(get_the_ID(), 'custom_post_breadcrumb_image', true);

            if (!empty($custom_image_id)) {
                $image_data = wp_get_attachment_image_src($custom_image_id, 'full');
                if ($image_data) {
                    $breadcrumb_image = $image_data[0];
                }
            }

            if (empty($breadcrumb_image)) {
                $breadcrumb_image = get_theme_mod('default_post_breadcrumb_image', '');
            }
        }
        if (is_singular('product')) {
            // Check custom image for single product first
            $custom_image_id = get_post_meta(get_the_ID(), 'custom_product_breadcrumb_image', true);

            if (!empty($custom_image_id)) {
                $image_data = wp_get_attachment_image_src($custom_image_id, 'full');
                if ($image_data) {
                    $breadcrumb_image = $image_data[0];
                }
            }

            if (empty($breadcrumb_image)) {
                $breadcrumb_image = get_theme_mod('default_product_breadcrumb_image', '');
            }
        }


        if (empty($breadcrumb_image)) {
            $breadcrumb_image = get_theme_mod('file', '');
        }
        $breadcrumb_opacity = floatval(get_theme_mod('opacity_background', '0'));
        if ($breadcrumb_opacity < 0)
            $breadcrumb_opacity = 0;
        if ($breadcrumb_opacity > 1)
            $breadcrumb_opacity = 1;




        $mode = get_theme_mod('breadcrumb_text_font_family', 'Philosopher'); // 'Philosopher' | 'custom_font' | 'upload_font'

        // Tham số theo từng mode
        $google_font = get_theme_mod('breadcrumb_title_custom_google_font', 'Poppins');
        $uploaded_url = (string) get_theme_mod('breadcrumb_title_uploaded_font', '');
        $weight_token = get_theme_mod('breadcrumb_title_font_weight', '700');

        // Resolve typography
        $typo = t888f_resolve_typography($mode, $google_font, $uploaded_url, $weight_token);

        $size = absint(get_theme_mod('breadcrumb_text_font_size', 36));
        $lineheight = absint(get_theme_mod('breadcrumb_text_line_height', 48));
        $color = get_theme_mod('breadcrumb_font_color', '#ffffff');
        $align = get_theme_mod('breadcrumb_title_text_align', 'left');

        // Build inline style
        $breadcrumb_title_style = sprintf(
            "color:%s; font-family:'%s', sans-serif; font-weight:%d; font-style:%s; font-size:%dpx; line-height:%dpx; text-align:%s;",
            esc_attr($color),
            esc_attr($typo['family']),
            $typo['weight'],
            esc_attr($typo['style']),
            $size,
            $lineheight,
            esc_attr($align)
        );



        // ===================== Trail styles (Breadcrumb trail) =====================
        $mode_trail = get_theme_mod('breadcrumb_text_hover_font_family', 'Poppins');
        $google_trail = get_theme_mod('breadcrumb_trail_custom_google_font', 'Poppins');
        $uploaded_trail = (string) get_theme_mod('breadcrumb_trail_uploaded_font', '');
        $weight_trail = get_theme_mod('breadcrumb_trail_font_weight', '400');


        $trail_typo = t888f_resolve_typography($mode_trail, $google_trail, $uploaded_trail, $weight_trail);

        $breadcrumb_trail_font_size = absint(get_theme_mod('breadcrumb_text_hover_font_size', 14));
        $breadcrumb_trail_line_height = absint(get_theme_mod('breadcrumb_text_hover_line_height', 36));
        $breadcrumb_trail_font_color = get_theme_mod('breadcrumb_text_hover_font_color', '#ffffff');
        $breadcrumb_trail_text_align = get_theme_mod('breadcrumb_trail_text_align', 'left');

        // Build inline style
        $breadcrumb_trail_style = sprintf(
            "color:%s; font-family:'%s', sans-serif; font-weight:%d; font-style:%s; font-size:%dpx; line-height:%dpx; text-align:%s;",
            esc_attr($breadcrumb_trail_font_color),
            esc_attr($trail_typo['family']),
            (int) $trail_typo['weight'],
            esc_attr($trail_typo['style']),
            $breadcrumb_trail_font_size,
            $breadcrumb_trail_line_height,
            esc_attr($breadcrumb_trail_text_align)
        );

        // override breadcrumb image if custom image is set
        // check if is page
        if (is_page()) {
            $custom_image_id = get_post_meta(get_the_ID(), 'custom_page_breadcrumb_image', true);
            if (!empty($custom_image_id)) {
                $image_data = wp_get_attachment_image_src($custom_image_id, 'full');
                if ($image_data) {
                    $breadcrumb_image = $image_data[0];
                }
            }
        }

        // Build inline styles for breadcrumb container
        $breadcrumb_style = "background-color: {$breadcrumb_background};";

        if (!empty($breadcrumb_image)) {
            $breadcrumb_style .= " background-image: url('{$breadcrumb_image}'); background-size: cover; background-repeat: no-repeat;";
        }




        // Build inline styles for breadcrumb text
        // $breadcrumb_text_style = "color: {$breadcrumb_font_color}; font-family: {$breadcrumb_font_family}; font-size: {$breadcrumb_font_size}px; line-height: {$breadcrumb_line_height}px;";

        // Output breadcrumb container

        $breadcrumb_class = 'breadcrumb';

        if (is_singular('post')) {
            $style = get_post_meta(get_the_ID(), 'custom_post_display_style', true);
            if ($style === 'detail2') {
                $breadcrumb_class .= ' breadcrumb-parallax';
            }


            $custom_opacity = get_post_meta(get_the_ID(), 'custom_post_breadcrumb_opacity', true);
            if ($custom_opacity !== '') {
                $breadcrumb_opacity = floatval($custom_opacity);
            }
        }
        if (is_singular('product')) {
            $custom_opacity_product = get_post_meta(get_the_ID(), 'custom_product_breadcrumb_opacity', true);
            if ($custom_opacity_product !== '') {
                $breadcrumb_opacity = floatval($custom_opacity_product);
            }
        }
        $breadcrumb_overlay_style = sprintf('background-color: rgba(0,0,0,%.2f);', $breadcrumb_opacity);

        $breadcrumb_section_class = esc_attr($breadcrumb_class);
        if (strpos($breadcrumb_class, 'breadcrumb-parallax') !== false) {
            $breadcrumb_section_class .= ' parallax';
        }
        echo '<section class="' . $breadcrumb_section_class . '" style="' . esc_attr($breadcrumb_style) . '" >';

        echo '<div class="breadcrumb-overlay" style="' . esc_attr($breadcrumb_overlay_style) . '"></div>';

        echo '<div class="container">';
        echo '<div class="row">';
        echo '<div class="col-12">';
        $title_above_breadcrumb = '';



        if (function_exists('is_shop') && is_shop()) {
            $title_above_breadcrumb = function_exists('woocommerce_page_title')
                ? woocommerce_page_title(false)
                : __('Shop', 'nebon');
        } elseif (function_exists('is_product_category') && is_product_category()) {
            $title_above_breadcrumb = single_term_title('', false);
        } elseif (function_exists('is_product_tag') && is_product_tag()) {
            $title_above_breadcrumb = sprintf(
                __('%s', 'nebon'),
                single_term_title('', false)
            );
        } elseif ((is_tax(array('product_brand', 'yith_product_brand', 'pa_brand')))) {
            $brand_term = get_queried_object();
            $title_above_breadcrumb = sprintf(
                __('%s', 'nebon'),
                $brand_term ? $brand_term->name : ''
            );
        } elseif (is_home() && !is_front_page()) {
            $posts_page_id = (int) get_option('page_for_posts');
            $title_above_breadcrumb = $posts_page_id
                ? get_the_title($posts_page_id)
                : __('Blog', 'nebon');
        } elseif (is_category()) {
            $title_above_breadcrumb = single_cat_title('', false);
        } elseif (is_tag()) {
            $title_above_breadcrumb = single_tag_title('', false);
        } elseif (is_archive()) {
            $title_above_breadcrumb = get_the_archive_title();
        } elseif (is_search()) {
            $title_above_breadcrumb = __('Search Results for: ', 'nebon') . get_search_query();
        } elseif (is_404()) {
            $title_above_breadcrumb = __('404 Not Found', 'nebon');
        } elseif (is_singular('product') || is_singular('post') || is_page()) {
            $title_above_breadcrumb = get_the_title();
        } else {
            $title_above_breadcrumb = '';
        }
        if (!empty($title_above_breadcrumb)) {
            echo '<h1 class="breadcrumb-title" style="' . esc_attr($breadcrumb_title_style) . '">'
                . esc_html($title_above_breadcrumb) . '</h1>';
        }

        echo '<nav aria-label="breadcrumb-text" style="' . esc_attr($breadcrumb_trail_style) . '">';


        // Home link
        echo '<a style="' . esc_attr($breadcrumb_trail_style) . '" href="' . esc_url(home_url('/')) . '"><i class="las la-home home-breadcrumb"></i></a>';

        $blog_url = '';
        if (get_option('page_for_posts')) {
            $blog_url = get_permalink(get_option('page_for_posts'));
        }
        if (!$blog_url) {
            $blog_url = home_url('/blog/');
        }


        $shop_url = '';
        if (function_exists('wc_get_page_id')) {
            $shop_id = wc_get_page_id('shop');
            if ($shop_id && $shop_id > 0) {
                $shop_url = get_permalink($shop_id);
            }
        }

        if (!$shop_url && function_exists('get_post_type_archive_link')) {
            $archive_link = get_post_type_archive_link('product');
            if ($archive_link) {
                $shop_url = $archive_link;
            }
        }

        if (!$shop_url) {
            $shop_url = home_url('/shop/');
        }

        // Handle different page types
        if (is_home() && !is_front_page()) {

            echo '<span>' . esc_html__('Blog', 'nebon') . '</span>';
        } elseif (is_front_page()) {
            echo '<span>' . esc_html__('Home', 'nebon') . '</span>';
        } elseif (function_exists('is_shop') && is_shop()) {

            echo apply_filters('tech888f_output_content', $step)
                . '<a style="' . esc_attr($breadcrumb_trail_style) . '" href="' . esc_url($shop_url) . '">'
                . esc_html__('Shop', 'nebon')
                . '</a>';
        } elseif (check_woocommerce_exists() && get_post_type() === 'page' && get_option('woocommerce_shop_page_id') && get_the_ID() == get_option('woocommerce_shop_page_id')) {
            echo '<span>' . esc_html__('Shop', 'nebon') . '</span>';
        } elseif (is_single()) {
            $post_type = get_post_type();
            if ($post_type === 'post') {
                echo apply_filters('tech888f_output_content', $step)
                    . '<a style="' . esc_attr($breadcrumb_trail_style) . '" href="' . esc_url($blog_url) . '">'
                    . esc_html__('Blog', 'nebon')
                    . '</a>';

                $categories = get_the_category();
                if (!empty($categories)) {
                    $primary_cat = $categories[0];
                    $breadcrumb_cats = [];
                    while ($primary_cat->category_parent != 0) {
                        $primary_cat = get_category($primary_cat->category_parent);
                        array_unshift($breadcrumb_cats, $primary_cat);
                    }
                    $breadcrumb_cats[] = $categories[0];
                    foreach ($breadcrumb_cats as $cat) {
                        echo apply_filters('tech888f_output_content', $step) . '<a style="' . esc_attr($breadcrumb_trail_style) . '" href="' . esc_url(get_category_link($cat->term_id)) . '">' . esc_html($cat->name) . '</a>';
                    }
                }
            } elseif ($post_type === 'product' && function_exists('check_woocommerce_exists')) {
                echo apply_filters('tech888f_output_content', $step)
                    . '<a style="' . esc_attr($breadcrumb_trail_style) . '" href="' . esc_url($shop_url) . '">'
                    . esc_html__('Shop', 'nebon')
                    . '</a>';

                $terms = get_the_terms($post->ID, 'product_cat');
                if (!empty($terms) && !is_wp_error($terms)) {
                    $term = $terms[0];
                    $breadcrumb_cats = [];
                    while ($term->parent != 0) {
                        $term = get_term($term->parent, 'product_cat');
                        array_unshift($breadcrumb_cats, $term);
                    }
                    $breadcrumb_cats[] = $terms[0];
                    foreach ($breadcrumb_cats as $cat) {
                        echo apply_filters('tech888f_output_content', $step) . '<a style="' . esc_attr($breadcrumb_trail_style) . '" href="' . esc_url(get_term_link($cat)) . '">' . esc_html($cat->name) . '</a>';
                    }
                }
            }
        } elseif (is_page()) {
            $has_ancestor = false;

            if ($post->post_parent) {
                $ancestors = get_post_ancestors(get_the_ID());
                $ancestors = array_reverse($ancestors);
                foreach ($ancestors as $ancestor) {
                    echo apply_filters('tech888f_output_content', $step) . '<a style="' . esc_attr($breadcrumb_trail_style) . '" href="' . esc_url(get_permalink($ancestor)) . '">' . get_the_title($ancestor) . '</a>';
                }
                $has_ancestor = true;
            }

            echo apply_filters('tech888f_output_content', $has_ancestor ? $step : '') . '<span>' . get_the_title() . '</span>';
        } elseif (is_tag()) {
            echo apply_filters('tech888f_output_content', $step)
                . '<a style="' . esc_attr($breadcrumb_trail_style) . '" href="' . esc_url($blog_url) . '">'
                . esc_html__('Blog', 'nebon')
                . '</a>';

            $tag = get_queried_object();
            echo apply_filters('tech888f_output_content', $step) . '<a style="' . esc_attr($breadcrumb_trail_style) . '" href="' . esc_url(get_tag_link($tag->term_id)) . '">' . esc_html($tag->name) . '</a>';
        } elseif (is_archive()) {
            if (is_category()) {
                echo apply_filters('tech888f_output_content', $step)
                    . '<a style="' . esc_attr($breadcrumb_trail_style) . '" href="' . esc_url($blog_url) . '">'
                    . esc_html__('Blog', 'nebon')
                    . '</a>';

                $category = get_queried_object();
                $breadcrumb_cats = [];
                while ($category->category_parent != 0) {
                    $category = get_category($category->category_parent);
                    array_unshift($breadcrumb_cats, $category);
                }
                $breadcrumb_cats[] = get_queried_object();

                foreach ($breadcrumb_cats as $index => $cat) {
                    echo apply_filters('tech888f_output_content', $step) . '<a style="' . esc_attr($breadcrumb_trail_style) . '" href="' . esc_url(get_category_link($cat->term_id)) . '">' . esc_html($cat->name) . '</a>';
                }
            } elseif (is_tax('product_cat')) {
                echo apply_filters('tech888f_output_content', $step)
                    . '<a style="' . esc_attr($breadcrumb_trail_style) . '" href="' . esc_url($shop_url) . '">'
                    . esc_html__('Shop', 'nebon')
                    . '</a>';

                $term = get_queried_object();
                $breadcrumb_terms = [];
                while ($term->parent != 0) {
                    $term = get_term($term->parent, 'product_cat');
                    array_unshift($breadcrumb_terms, $term);
                }
                $breadcrumb_terms[] = get_queried_object();

                foreach ($breadcrumb_terms as $index => $term) {
                    echo apply_filters('tech888f_output_content', $step) . '<a style="' . esc_attr($breadcrumb_trail_style) . '" href="' . esc_url(get_term_link($term)) . '">' . esc_html($term->name) . '</a>';
                }
            } elseif (is_tax('product_tag')) {
                echo apply_filters('tech888f_output_content', $step)
                    . '<a style="' . esc_attr($breadcrumb_trail_style) . '" href="' . esc_url($shop_url) . '">'
                    . esc_html__('Shop', 'nebon')
                    . '</a>';

                $tag = get_queried_object();

                echo apply_filters('tech888f_output_content', $step)
                    . '<a style="' . esc_attr($breadcrumb_trail_style) . '" href="' . esc_url(get_term_link($tag)) . '">'
                    . esc_html($tag->name)
                    . '</a>';
            } elseif (is_tax(array('product_brand', 'yith_product_brand', 'pa_brand'))) {

                echo apply_filters('tech888f_output_content', $step)
                    . '<a style="' . esc_attr($breadcrumb_trail_style) . '" href="' . esc_url($shop_url) . '">'
                    . esc_html__('Shop', 'nebon')
                    . '</a>';

                $brand_term = get_queried_object();

                echo apply_filters('tech888f_output_content', $step)
                    . '<a style="' . esc_attr($breadcrumb_trail_style) . '" href="' . esc_url(get_term_link($brand_term)) . '">'
                    . esc_html($brand_term->name)
                    . '</a>';
            }
        } elseif (is_search()) {
            echo '<span>' . esc_html__('Search Results for: ', 'nebon') . '</span>' . esc_html(get_search_query());
        } elseif (is_404()) {
            echo '<span>' . esc_html__('404 Not Found', 'nebon') . '</span>';
        }


        // Close breadcrumb container
        echo '</nav>';
        echo '</div>'; // .col-12
        echo '</div>'; // .row
        echo '</div>'; // .container
        echo '</section>';

        // Output inline style for hover effect
        echo "<style>
            .breadcrumb a { color: {$breadcrumb_trail_font_color}; text-decoration: none; }
        </style>";
    }
}


/**
 * Check if WooCommerce exists
 * @return bool
 * @since 1.0
 */
if (!function_exists('check_woocommerce_exists')) {
    function check_woocommerce_exists()
    {
        return class_exists('WooCommerce');
    }
}

/**
 * Navigation paging
 * @param WP_Query|bool $query
 * @param string $style
 * @param bool $echo
 * @return string|void
 */
if (!function_exists('tech888f_paging_nav')) {
    function tech888f_paging_nav($query = null, $style = '', $echo = true)
    {
        if ($query) {
            $big = 999999999;
            $paged = (get_query_var('paged')) ? absint(get_query_var('paged')) : 1;
            $links = array(
                'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                // 'format' => '&page=%#%',
                'format' => '/page/%#%/',
                'current' => max(1, $paged),
                'total' => $query->max_num_pages,
                'end_size' => 2,
                'mid_size' => 1
            );
        } else {
            if ($GLOBALS['wp_query']->max_num_pages < 2) {
                return;
            }

            $paged = get_query_var('paged') ? intval(get_query_var('paged')) : 1;
            $pagenum_link = html_entity_decode(get_pagenum_link());
            $query_args = array();
            $url_parts = explode('?', $pagenum_link);

            if (isset($url_parts[1])) {
                wp_parse_str($url_parts[1], $query_args);
            }

            $pagenum_link = remove_query_arg(array_keys($query_args), $pagenum_link);
            $pagenum_link = trailingslashit($pagenum_link) . '%_%';

            $format = $GLOBALS['wp_rewrite']->using_index_permalinks() && !strpos($pagenum_link, 'index.php') ? 'index.php/' : '';
            $format .= $GLOBALS['wp_rewrite']->using_permalinks() ? user_trailingslashit('page/%#%', 'paged') : '?paged=%#%';

            // Set up paginated links.
            $links = array(
                'base' => $pagenum_link,
                'format' => $format,
                'total' => $GLOBALS['wp_query']->max_num_pages,
                'current' => $paged,
                'end_size' => 2,
                'mid_size' => 1,
                'add_args' => array_map('urlencode', $query_args),
            );
        }
        $data = array(
            'links' => $links,
            'style' => $style,
        );
        $html = t888f_get_template('layout/paging-navigation', $style, $data, $echo);
        if (!$echo)
            return $html;
    }
}


/**
 * Get sidebar
 * @param string $sidebar_pos value: left, right, none
 * @param string $sidebar
 * @return void
 */
if (!function_exists('t888f_get_side_bar')) {
    function t888f_get_side_bar($sidebar_pos, $sidebar, $pos)
    {
        if ($sidebar_pos == 'none')
            return;

        if ($sidebar_pos != $pos)
            return;

        if (is_active_sidebar($sidebar)):
            $style = 'default';
            $data = array(
                'sidebar_pos' => $sidebar_pos,
                'sidebar' => $sidebar,
            );
            t888f_get_template('/layout/sidebar-template', $style, $data, true);
        endif;
    }
}

/**
 * Get column class depend on sidebar position
 * @param string $sidebar_pos
 * @return string
 */

if (!function_exists('t888f_get_sibling_class_sidebar')) {
    function t888f_get_sibling_class_sidebar($sidebar_pos)
    {
        if ($sidebar_pos == 'left' || $sidebar_pos == 'right') {
            return 'col-9';
        } else {
            return 'col-12';
        }
    }
}

if (!function_exists('t888f_get_main_class_sidebar')) {
    function t888f_get_main_class_sidebar($sidebar_pos)
    {
        if ($sidebar_pos == 'left' || $sidebar_pos == 'right') {
            return 'has-sidebar' . ' ' . $sidebar_pos . '-sidebar';
        } else {
            return 'no-sidebar';
        }
    }
}

/**
 * Get product by type: use for element of elementor t888-product-tabs.php line 26
 * @param string $type
 * @param array $tax_query
 * @param int $limit
 * @return WP_Query
 */
function t888_get_products_by_type($type, $filter_ids = [], $limit = 8, $paged = 1, $filter_by = 'category', $date_filter = '')
{
    $args = [
        'post_type' => 'product',
        'post_status' => 'publish',
        'posts_per_page' => (int) $limit,
        'paged' => (int) $paged,
    ];

    $normalized_filter_ids = [];
    if (is_array($filter_ids)) {
        foreach ($filter_ids as $raw_id) {
            if ($raw_id === 'all' || $raw_id === '' || $raw_id === null) {
                continue;
            }
            $id = (int) $raw_id;
            if ($id > 0) {
                $normalized_filter_ids[] = $id;
            }
        }
    } elseif ($filter_ids !== 'all' && $filter_ids !== '' && $filter_ids !== null) {
        $id = (int) $filter_ids;
        if ($id > 0) {
            $normalized_filter_ids[] = $id;
        }
    }

    if (!empty($normalized_filter_ids)) {
        if ($filter_by === 'category') {
            $args['tax_query'][] = [
                'taxonomy' => 'product_cat',
                'field' => 'term_id',
                'terms' => $normalized_filter_ids,
                'operator' => 'IN',
            ];
        } elseif ($filter_by === 'product') {
            $args['post__in'] = $normalized_filter_ids;
            $args['orderby'] = 'post__in';
        }
    }

    if (!empty($date_filter)) {
        $args['date_query'] = [
            [
                'after' => $date_filter,
            ],
        ];
    }

    switch ($type) {
        case 'bestsellers':
            $args['meta_key'] = 'total_sales';
            $args['orderby'] = 'meta_value_num';
            $args['order'] = 'DESC';
            break;
        case 'popular':
            $args['orderby'] = 'comment_count';
            $args['order'] = 'DESC';
            break;
        case 'featured':
            $args['tax_query'][] = [
                'taxonomy' => 'product_visibility',
                'field' => 'name',
                'terms' => 'featured',
                'operator' => 'IN',
            ];
            break;
        case 'sale':
            $args['post__in'] = array_merge([0], wc_get_product_ids_on_sale());
            break;
        case 'week':
            $args['meta_key'] = 'total_sales';
            $args['orderby'] = 'meta_value_num';
            $args['order'] = 'DESC';
            $args['date_query'] = [
                [
                    'after' => '1 week ago',
                    'inclusive' => true,
                ]
            ];
            break;
        case 'month':
            $args['meta_key'] = 'total_sales';
            $args['orderby'] = 'meta_value_num';
            $args['order'] = 'DESC';
            $args['date_query'] = [
                [
                    'after' => '1 month ago',
                    'inclusive' => true,
                ]
            ];
            break;
        case 'year':
            $args['meta_key'] = 'total_sales';
            $args['orderby'] = 'meta_value_num';
            $args['order'] = 'DESC';
            $args['date_query'] = [
                [
                    'after' => '1 year ago',
                    'inclusive' => true,
                ]
            ];
            break;
        case 'new':
        default:
            $args['orderby'] = 'date';
            $args['order'] = 'DESC';
            break;
    }

    return new WP_Query($args);
}

/**
 * Get youtube id from url, use for element of elementor t888-video.php line 26
 * @param string $url
 * @return string
 */
if (!function_exists('extract_youtube_id')) {
    function extract_youtube_id($url)
    {
        preg_match('/[\\?\\&]v=([^\\?\\&]+)/', $url, $matches);
        return $matches[1] ?? '';
    }
}

/**
 * animation thumbnail product template, use for product loop 
 * @param string $product_id
 * @param string $size
 * @return void 
 */
if (!function_exists('t888f_animation_thumbnail_product')) {
    function t888f_animation_thumbnail_product($product_id, $size = 'product-list-default', $animation_class = '')
    {
        $product = wc_get_product($product_id);
        if (!$product) {
            return;
        }
        $thumbnail_id = $product->get_image_id();
        $thumbnail_hover_id = get_post_meta($product_id, 'product_thumnail_hover', true);
        if (!empty($animation_class)) {
            $animation_class = sanitize_html_class($animation_class);
        } else {
            $animation_class = get_theme_mod('thumbnail_animation_general', '');
        }

        switch ($animation_class) {
            case 'rotate-thumb':
            case 'zoomout-thumb':
            case 'translate-thumb':
            case 'light-soft-thumb':
                if (empty($thumbnail_hover_id)) {
                    $thumbnail_hover_id = $thumbnail_id;
                }
            default:
                // No animation
                break;
        }
        t888f_get_template('woocommerce/product-structure/product-thumbnail', 'default', array(
            'thumbnail_id' => $thumbnail_id,
            'thumbnail_hover_id' => $thumbnail_hover_id,
            'animation_class' => $animation_class,
            'size' => $size,
        ), true);
    }
}

if (!function_exists('t888f_product_quickview')) {
    function t888f_product_quickview($product_id)
    {
        t888f_get_template('woocommerce/product-structure/product-quickview', 'default', array(
            'product_id' => $product_id,
        ), true);
    }
}

if (!function_exists('get_current_url')) {
    function get_current_url()
    {
        return add_query_arg(null, null);
    }
}

if (!function_exists('t888_parse_weight_style')) {
    function t888_parse_weight_style($v, $def_weight = '400', $def_style = 'normal')
    {
        $v = trim((string) $v);
        $weight = $def_weight;
        $style = $def_style;

        if (preg_match('/^(100|200|300|400|500|600|700|800|900)(italic)?$/i', $v, $m)) {
            $weight = $m[1];
            $style = !empty($m[2]) ? 'italic' : 'normal';
        } else {
            if (in_array(strtolower($v), ['normal', 'regular'], true)) {
                $weight = '400';
                $style = 'normal';
            } elseif (strtolower($v) === 'bold') {
                $weight = '700';
                $style = 'normal';
            } elseif (strtolower($v) === 'italic') {
                $weight = '400';
                $style = 'italic';
            }
        }
        return [$weight, $style];
    }
}

add_action('wp_head', function () {

    // === MAIN MENU ===
    $menu_mode = get_theme_mod('menu_style_font_family', 'Philosopher');
    $google_main = get_theme_mod('menu_custom_google_font', 'Poppins');
    $uploaded_main = (string) get_theme_mod('menu_uploaded_font', '');
    $weight_main = get_theme_mod('menu_style_font_weight_style', '700');

    $typo_main = t888f_resolve_typography($menu_mode, $google_main, $uploaded_main, $weight_main);

    $font_color = get_theme_mod('menu_style_font_color', '#ffffff');
    $hover_color = get_theme_mod('hover_color', '#b88166');
    $bg_hover_color = get_theme_mod('background_hover_color', 'transparent');
    $font_size = (int) get_theme_mod('menu_style_font_size', 14);
    if ($font_size <= 0)
        $font_size = 14;
    $line_height = (int) get_theme_mod('menu_style_line_height', 36);
    if ($line_height <= 0)
        $line_height = 36;
    $align = get_theme_mod('menu_style_font_text_align', 'left');

    // === SUB MENU ===
    $sub_mode = get_theme_mod('menu_sub_style_font_family', 'Poppins');
    $google_sub = get_theme_mod('menu_sub_custom_google_font', 'Poppins');
    $uploaded_sub = (string) get_theme_mod('menu_sub_uploaded_font', '');
    $weight_sub = get_theme_mod('menu_sub_style_font_weight_style', '400');

    $typo_sub = t888f_resolve_typography($sub_mode, $google_sub, $uploaded_sub, $weight_sub);

    $sub_font_color = get_theme_mod('menu_sub_style_font_color', '#ffffff');
    $sub_hover_color = get_theme_mod('hover_sub_color', '#b88166');
    $sub_bg_hover_color = get_theme_mod('background_sub_hover_color', 'transparent');
    $sub_font_size = (int) get_theme_mod('menu_sub_style_font_size', 16);
    if ($sub_font_size <= 0)
        $sub_font_size = 16;
    $sub_line_height = (int) get_theme_mod('menu_sub_style_line_height', 16);
    if ($sub_line_height <= 0)
        $sub_line_height = 16;
    $sub_align = get_theme_mod('menu_sub_style_text_align', 'left');

    echo '<style id="t888-menu-customizer">
        /* === MAIN MENU === */
        .main-nav > div > ul > li > a {
            font-family: "' . esc_attr($typo_main['family']) . '", sans-serif;
            font-weight: ' . esc_attr($typo_main['weight']) . ';
            font-style: ' . esc_attr($typo_main['style']) . ';
            font-size: ' . $font_size . 'px;
            line-height: ' . $line_height . 'px;
            text-align: ' . esc_attr($align) . ';
            color: ' . esc_attr($font_color) . ';
        }
        .main-nav > div > ul > li > a:hover {
            color: ' . esc_attr($hover_color) . ';
            background-color: ' . esc_attr($bg_hover_color) . ';
        }

        /* === SUB MENU === */
        .main-nav ul.sub-menu li a {
            font-family: "' . esc_attr($typo_sub['family']) . '", sans-serif;
            font-weight: ' . esc_attr($typo_sub['weight']) . ';
            font-style: ' . esc_attr($typo_sub['style']) . ';
            font-size: ' . $sub_font_size . 'px;
            line-height: ' . $sub_line_height . 'px;
            text-align: ' . esc_attr($sub_align) . ';
            color: ' . esc_attr($sub_font_color) . ';
        }
        .main-nav ul.sub-menu li a:hover {
            color: ' . esc_attr($sub_hover_color) . ';
            background-color: ' . esc_attr($sub_bg_hover_color) . ';
        }
    </style>';
});


add_action('wp_head', function () {
    $container_width = get_theme_mod('custom_container_width', '1432');
    if (!empty($container_width)) {
        if (is_numeric($container_width)) {
            $container_width .= 'px';
        }

        echo '<style>
            .container, .site-content .container {
                max-width: ' . esc_attr($container_width) . ';
            }
        </style>';
    }
});
function t888_sanitize_list_share_social($input)
{
    $valid = array(
        'facebook',
        'pinterest',
        'instagram',
        'youtube',
        'twitter',
        'linkedin',
        'whatsapp',
        'telegram',
        'email'
    );

    if (is_string($input)) {
        $input = array($input);
    }

    if (!is_array($input)) {
        return array();
    }

    $input = array_intersect($input, $valid);
    return array_values($input);
}

/**
 * Get Google Fonts list from transient or API
 * @return array
 */
function t888_get_google_fonts_list()
{
    static $fonts;
    if (!isset($fonts)) {
        $path = get_template_directory() . '/assets/fonts/google-fonts.json';
        $data = file_exists($path) ? file_get_contents($path) : '';
        $list = json_decode($data, true);
        $fonts = [];
        if (!empty($list['items'])) {
            foreach ($list['items'] as $font) {
                $fonts[$font['family']] = $font['family'];
            }
        }
    }
    return $fonts;
}

add_action('wp_enqueue_scripts', function () {
    if (get_theme_mod('show_breadcrumb') !== 'on')
        return;

    if (get_theme_mod('breadcrumb_text_font_family') === 'custom_font') {
        $font = get_theme_mod('breadcrumb_custom_google_font', '');
        if ($font) {
            wp_enqueue_style(
                'nebon-gf-breadcrumb',
                'https://fonts.googleapis.com/css2?family=' . rawurlencode($font) . ':wght@400;500;600;700&display=swap',
                [],
                null
            );
        }
    }
    if (get_theme_mod('breadcrumb_text_hover_font_family') === 'custom_font') {
        $font = get_theme_mod('breadcrumb_trail_custom_google_font', '');
        if ($font) {
            wp_enqueue_style(
                'nebon-gf-breadcrumb-trail',
                'https://fonts.googleapis.com/css2?family=' . rawurlencode($font) . ':wght@400;500;600;700&display=swap',
                [],
                null
            );
        }
    }
    if (get_theme_mod('menu_style_font_family') === 'custom_font') {
        $font = get_theme_mod('menu_custom_google_font', '');
        if ($font) {
            wp_enqueue_style(
                'nebon-gf-menu',
                'https://fonts.googleapis.com/css2?family=' . rawurlencode($font) . ':wght@400;500;600;700&display=swap',
                [],
                null
            );
        }
    }
    if (get_theme_mod('menu_sub_style_font_family') === 'custom_font') {
        $font = get_theme_mod('menu_sub_custom_google_font', '');
        if ($font) {
            wp_enqueue_style(
                'nebon-gf-menu-sub',
                'https://fonts.googleapis.com/css2?family=' . rawurlencode($font) . ':wght@400;500;600;700&display=swap',
                [],
                null
            );
        }
    }
    $areas = ['body', 'main_content', 'widgets'];
    $heads = ['h1', 'h2', 'h3', 'h4', 'h5', 'h6'];

    $families = [];
    foreach ($areas as $a) {
        foreach ($heads as $h) {
            if (get_theme_mod("{$a}_{$h}_font_source", 'default') === 'custom') {
                $fam = get_theme_mod("{$a}_{$h}_google_font", '');
                if ($fam)
                    $families[$fam] = true;
            }
        }
    }

    foreach (array_keys($families) as $fam) {
        wp_enqueue_style(
            't888-gf-' . md5($fam),
            'https://fonts.googleapis.com/css2?family=' . rawurlencode($fam) . ':wght@400;500;600;700&display=swap',
            [],
            null
        );
    }
});
if (!function_exists('t888_get_uploaded_font_choices')) {
    function t888_get_uploaded_font_choices()
    {
        $items = json_decode(get_theme_mod('upload_file_repeater', '[]'), true);
        $items = is_array($items) ? $items : [];
        $choices = [];

        foreach ($items as $row) {
            $url = $row['file_only_url'] ?? ($row['file_url'] ?? '');
            if (!$url)
                continue;

            $label = basename(parse_url($url, PHP_URL_PATH) ?: $url);
            $choices[$url] = $label;
        }

        if (empty($choices)) {
            $choices = ['' => __('— No uploaded fonts —', 'nebon')];
        }

        return $choices;
    }
}

if (!function_exists('t888f_guess_axis_from_filename')) {
    function t888f_guess_axis_from_filename(string $filename): array
    {
        $name = strtolower($filename);
        $style = (str_contains($name, 'italic') || str_contains($name, 'oblique') || preg_match('/\b(it|ita)\b/', $name))
            ? 'italic' : 'normal';
        $weight = 400;
        $map = [
            'thin' => 100,
            'extralight' => 200,
            'ultralight' => 200,
            'extra-light' => 200,
            'ultra-light' => 200,
            'light' => 300,
            'regular' => 400,
            'book' => 400,
            'normal' => 400,
            'medium' => 500,
            'semibold' => 600,
            'semi-bold' => 600,
            'demibold' => 600,
            'demi-bold' => 600,
            'bold' => 700,
            'extrabold' => 800,
            'extra-bold' => 800,
            'ultrabold' => 800,
            'ultra-bold' => 800,
            'black' => 900,
            'heavy' => 900,
        ];
        foreach ($map as $k => $v) {
            if (str_contains($name, $k)) {
                $weight = $v;
                break;
            }
        }
        if (preg_match('/\b(100|200|300|400|500|600|700|800|900)\b/', $name, $m)) {
            $weight = (int) $m[1];
        }
        return ['weight' => $weight, 'style' => $style];
    }
}


if (!function_exists('t888f_uploaded_family_from_row')) {
    function t888f_uploaded_family_from_row(array $row): string
    {
        $url = $row['file_only_url'] ?? ($row['file_url'] ?? '');
        if (!$url)
            return '';
        $title_raw = isset($row['title']) ? wp_strip_all_tags(html_entity_decode($row['title'])) : '';
        $title_raw = trim($title_raw);
        if ($title_raw !== '') {
            return preg_replace('/[\'"]+/', '', $title_raw);
        }
        $basename = pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_FILENAME);
        $safe_name = preg_replace('/[^a-zA-Z0-9_-]+/', '', $basename);
        return '' . $safe_name;
    }
}

if (!function_exists('t888f_parse_font_weight_style')) {
    function t888f_parse_font_weight_style($token): array
    {
        $token = is_string($token) ? strtolower(trim($token)) : '400';
        $is_italic = (strpos($token, 'italic') !== false);
        if (preg_match('/\d+/', $token, $m)) {
            $weight = (int) $m[0];
        } else {
            $weight = 400;
        }
        return ['weight' => $weight, 'style' => ($is_italic ? 'italic' : 'normal')];
    }
}

if (!function_exists('t888f_resolve_typography')) {
    function t888f_resolve_typography(string $mode, string $google_font, string $uploaded_url, string $weight_token): array
    {
        if ($mode === 'custom_font') {
            $family = $google_font ?: 'Poppins';
        } elseif ($mode === 'upload_font') {
            $family = 'sans-serif';
            if ($uploaded_url !== '') {
                $items = json_decode(get_theme_mod('upload_file_repeater', '[]'), true) ?: [];
                foreach ($items as $row) {
                    $row_url = $row['file_only_url'] ?? ($row['file_url'] ?? '');
                    if ($row_url && $row_url === $uploaded_url) {
                        $family = t888f_uploaded_family_from_row($row);
                        break;
                    }
                }
            }
        } else {
            $family = $mode ?: 'Philosopher';
        }

        if ($mode === 'upload_font') {
            if ($uploaded_url !== '') {
                $file_name = basename(parse_url($uploaded_url, PHP_URL_PATH));
                $ws = t888f_guess_axis_from_filename($file_name);
            } else {
                $ws = ['weight' => 400, 'style' => 'normal'];
            }
        } else {
            $ws = t888f_parse_font_weight_style($weight_token ?: '400');
        }

        return ['family' => $family, 'weight' => $ws['weight'], 'style' => $ws['style']];
    }
}

add_action('wp_head', function () {
    $items = json_decode(get_theme_mod('upload_file_repeater', '[]'), true) ?: [];
    if (empty($items))
        return;

    echo "<style id='t888-uploaded-fonts'>\n";
    foreach ($items as $row) {
        $url = $row['file_only_url'] ?? ($row['file_url'] ?? '');
        if (!$url)
            continue;

        $family = t888f_uploaded_family_from_row($row);

        $ext = strtolower(pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION));
        $format = match ($ext) {
            'woff2' => 'woff2',
            'woff' => 'woff',
            'ttf' => 'truetype',
            'otf' => 'opentype',
            default => ''
        };
        if (!$format)
            continue;

        [$weight, $style] = t888f_guess_axis_from_filename(basename($url));

        printf(
            "@font-face{font-family:'%s';src:url('%s') format('%s');font-weight:%d;font-style:%s;font-display:swap;}\n",
            esc_attr($family),
            esc_url($url),
            esc_attr($format),
            $weight,
            esc_attr($style)
        );
    }
    echo "</style>\n";
});


add_action('wp_head', function () {
    $map = [
        'body' => [
            'h1' => 'h1',
            'h2' => 'h2',
            'h3' => 'h3',
            'h4' => 'h4',
            'h5' => 'h5',
            'h6' => 'h6',
        ],
        'main_content' => [
            'h1' => '.detail-content-wrap h1, .entry-content h1, .page-content h1, .product .summary h1, .woocommerce-Tabs-panel h1',
            'h2' => '.detail-content-wrap h2, .entry-content h2, .page-content h2, .product .summary h2, .woocommerce-Tabs-panel h2',
            'h3' => '.detail-content-wrap h3, .entry-content h3, .page-content h3, .product .summary h3, .woocommerce-Tabs-panel h3',
            'h4' => '.detail-content-wrap h4, .entry-content h4, .page-content h4, .product .summary h4, .woocommerce-Tabs-panel h4',
            'h5' => '.detail-content-wrap h5, .entry-content h5, .page-content h5, .product .summary h5, .woocommerce-Tabs-panel h5',
            'h6' => '.detail-content-wrap h6, .entry-content h6, .page-content h6, .product .summary h6, .woocommerce-Tabs-panel h6',
        ],
        'widgets' => [
            'h1' => '.widget h1, .widget-title',
            'h2' => '.widget h2, .widget-title',
            'h3' => '.widget h3, .widget-title',
            'h4' => '.widget h4, .widget-title',
            'h5' => '.widget h5, .widget-title',
            'h6' => '.widget h6, .widget-title',
        ],
    ];

    $areas_order = ['body', 'main_content', 'widgets'];
    $heads = ['h1', 'h2', 'h3', 'h4', 'h5', 'h6'];

    $css = '';

    foreach ($areas_order as $a) {
        foreach ($heads as $h) {
            if (empty($map[$a][$h]))
                continue;
            $sel = $map[$a][$h];

            $src_raw = get_theme_mod("{$a}_{$h}_font_source", 'Philosopher');
            $mode = in_array($src_raw, ['custom_font', 'upload_font', 'default'], true)
                ? $src_raw
                : $src_raw;

            $google_font = get_theme_mod("{$a}_{$h}_google_font", '');
            $uploaded = (string) get_theme_mod("{$a}_{$h}_uploaded_font", '');
            $weight_tok = get_theme_mod("{$a}_{$h}_weight", '700');

            $typo = t888f_resolve_typography($mode, $google_font, $uploaded, $weight_tok);

            $fs = absint(get_theme_mod("{$a}_{$h}_size", 0));
            $lh = absint(get_theme_mod("{$a}_{$h}_line_height", 0));
            $al = sanitize_text_field(get_theme_mod("{$a}_{$h}_align", ''));
            $co = sanitize_hex_color(get_theme_mod("{$a}_{$h}_color", ''));

            $has_any =
                !empty($typo['family']) || !empty($typo['weight']) || !empty($typo['style']) ||
                !empty($fs) || !empty($lh) || !empty($al) || !empty($co);

            if (!$has_any)
                continue;

            $css .= $sel . '{';
            if (!empty($typo['family']))
                $css .= "font-family:'" . esc_attr($typo['family']) . "', sans-serif;";
            if (!empty($typo['weight']))
                $css .= "font-weight:" . esc_attr($typo['weight']) . ";";
            if (!empty($typo['style']))
                $css .= "font-style:" . esc_attr($typo['style']) . ";";
            if (!empty($fs))
                $css .= "font-size:" . intval($fs) . "px;";
            if (!empty($lh))
                $css .= "line-height:" . intval($lh) . "px;";
            if (!empty($al))
                $css .= "text-align:" . esc_attr($al) . ";";
            if (!empty($co))
                $css .= "color:" . esc_attr($co) . ";";
            $css .= "}\n";
        }
    }

    if (!empty($css)) {
        echo "<style id='t888-typography'>\n{$css}</style>";
    }
});
