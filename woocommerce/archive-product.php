<?php

/**
 * The Template for displaying product archives, including the main shop page which is a post type archive.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.6.0
 */

namespace T888Core;

defined('ABSPATH') || exit;

class ArchiveShopPage
{
    private static $instance = null;

    private $sidebar_pos;
    private $sidebar;
    private $style;
    private $shop_list_item_style;
    private $shop_list_item_size;
    private $shop_grid_item_style;
    private $shop_grid_display_style;
    private $shop_grid_columns;
    private $shop_grid_item_size;
    private $shop_gap_item;
    private $shop_grid_excerpt_length;
    private $posts_per_page;
    private $shop_show_number_filter;
    private $shop_show_type_filter;
    private $slug;
    private $args;
    private $shop_show_custom_ordering_dropdown;
    private $top_filter_layout_styles = [
        'grid' => 'las la-grip-horizontal',
        'list' => 'las la-list',
    ];
    private $top_filter_per_page_options = [9, 12, 18, 24];
    private $shop_pagination_mode;
    private $enable_ajax = false;

    /**
     * ArchiveShopPage constructor.
     */
    private function __construct()
    {
        $this->sidebar_pos = get_theme_mod('sidebar_position_woo_page_general', 'left');
        $this->sidebar = get_theme_mod('sidebar_select_woo_page_general', 'woocommerce-sidebar');
        // $this->style = get_theme_mod('shop_default_item_style_general', 'list');
        $this->style = isset($_GET['view']) ? sanitize_text_field($_GET['view']) : get_theme_mod('shop_default_item_style_general', 'list');

        $this->shop_list_item_style = get_theme_mod('shop_list_item_style', 'default');
        $this->shop_list_item_size = get_theme_mod('custom_list_thumbnail_size', '');
        $this->shop_grid_item_style = get_theme_mod('grid_item_grid_setting', 'default');
        $this->shop_grid_display_style = get_theme_mod('grid_display_grid_setting', 'default');
        $this->shop_grid_columns = get_theme_mod('grid_column_grid_setting', '3');
        $this->shop_grid_item_size = get_theme_mod('custom_grid_grid_setting', '');
        $this->posts_per_page = isset($_GET['posts_per_page']) ? intval($_GET['posts_per_page']) : get_theme_mod('product_number_general', 12);
        $this->shop_show_number_filter = get_theme_mod('num_filter_general', 'on');
        $this->shop_show_type_filter = get_theme_mod('show_type_filter_general', 'on');
        $this->shop_gap_item = get_theme_mod('gap_products_general', '30');
        $this->shop_show_custom_ordering_dropdown = get_theme_mod('show_custom_ordering_dropdown', 'on');
        $this->shop_pagination_mode = get_theme_mod('shop_pagination_general', 'pagination');
        $this->enable_ajax = get_theme_mod('shop_ajax_general', 'off') === 'on';

        $this->get_curent_data_style();

        add_action('pre_get_posts', [$this, 'modify_query']);
        add_filter('paginate_links', [$this, 'clean_duplicate_query_args']);
    }

    /**
     * Get the current URL with cleaned query arguments. Fix duplicate query arguments in pagination links woocommerce shop page.
     *
     * @return string
     */
    function clean_duplicate_query_args($link)
    {
        // only process if the link contains a query string
        if (strpos($link, '?') === false) {
            return $link;
        }

        // Split the URL and fragment (#...) if present
        $fragment = '';
        if (strpos($link, '#') !== false) {
            [$link, $fragment] = explode('#', $link, 2);
            $fragment = '#' . $fragment;
        }

        // Split base and query
        $parsed_url = parse_url(html_entity_decode($link));

        if (!isset($parsed_url['query'])) {
            return $link . $fragment;
        }

        // Get the array of parameters and automatically remove duplicates
        parse_str($parsed_url['query'], $params);
        $clean_query = http_build_query($params);

        // Rebuild the clean URL
        $clean_url = $parsed_url['scheme'] . '://' . $parsed_url['host'];
        if (!empty($parsed_url['path'])) {
            $clean_url .= $parsed_url['path'];
        }
        if (!empty($clean_query)) {
            $clean_url .= '?' . $clean_query;
        }
        return esc_url($clean_url);
    }



    /**
     * Get the singleton instance of ArchiveShopPage.
     *
     * @return ArchiveShopPage
     */
    public static function getInstance(): ArchiveShopPage
    {
        if (self::$instance == null) {
            self::$instance = new ArchiveShopPage();
        }
        return self::$instance;
    }

    /**
     * Get the current data style based on the shop style.
     *
     * @return void
     */
    public function get_curent_data_style(): void
    {
        switch ($this->style) {
            case 'grid':
            default:
                $this->slug = $this->shop_grid_item_style;
                $this->args = [
                    'display_style' => $this->shop_grid_display_style,
                    'columns' => $this->shop_grid_columns,
                    'size' => $this->shop_grid_item_size,
                ];
                break;

            case 'list':
                $this->slug = $this->shop_list_item_style;
                $this->args = [
                    'size' => $this->shop_list_item_size,
                ];
                break;
        }
    }

    /**
     * Modify WooCommerce Query
     */
    public function modify_query($query)
    {
        // todo custom any queries in this page except main query (shop loop)
    }

    /**
     * Render the archive shop page.
     *
     * @return void
     */
    public function render(): void
    {

        // Reuse the Elementor body of the Product page for Shop and every
        // product taxonomy. Some existing installations have not assigned the
        // page in WooCommerce settings, so resolve the layout from several
        // backwards-compatible candidates instead of dropping to the old
        // theme archive/sidebar.
        $shop_page_id = function_exists('wc_get_page_id') ? (int) wc_get_page_id('shop') : 0;
        $product_page = get_page_by_path('san-pham', OBJECT, 'page');
        $product_page_id = $product_page instanceof \WP_Post ? (int) $product_page->ID : 0;
        $preferred_template_id = (int) get_theme_mod('t888_product_archive_template_id', 0);
        $template_id = 0;

        foreach (array_unique([$preferred_template_id, $shop_page_id, $product_page_id, 91]) as $candidate_id) {
            $candidate_id = (int) $candidate_id;
            if (
                $candidate_id > 0
                && get_post_status($candidate_id)
                && trim((string) get_post_meta($candidate_id, '_elementor_data', true)) !== ''
            ) {
                $template_id = $candidate_id;
                break;
            }
        }

        $template_id = (int) apply_filters('t888_product_archive_template_id', $template_id);

        // The Elementor template is rendered after wp_head() on archive pages.
        // Enqueue its generated CSS before get_header() so container/grid rules
        // are available when the page is first painted.
        if (
            did_action('elementor/loaded') &&
            get_post_status($template_id) &&
            class_exists('\Elementor\Core\Files\CSS\Post')
        ) {
            $elementor_css = new \Elementor\Core\Files\CSS\Post($template_id);
            $elementor_css->enqueue();

            // Elementor 4 stores container layout rules in separate atomic CSS
            // files. Rendering a page manually does not enqueue these files, so
            // load them here to preserve flex direction and responsive widths.
            $uploads = wp_upload_dir();
            if (empty($uploads['error'])) {
                $atomic_css_dir = trailingslashit($uploads['basedir']) . 'elementor/css/';
                $atomic_css_url = trailingslashit($uploads['baseurl']) . 'elementor/css/';
                $atomic_styles = [
                    [
                        'handle' => 'base-desktop',
                        'file'   => 'base-desktop.css',
                        'media'  => 'all',
                        'deps'   => [],
                    ],
                    [
                        'handle' => 'local-' . $template_id . '-frontend-desktop',
                        'file'   => 'local-' . $template_id . '-frontend-desktop.css',
                        'media'  => 'all',
                        'deps'   => ['base-desktop'],
                    ],
                    [
                        'handle' => 'base-tablet',
                        'file'   => 'base-tablet.css',
                        'media'  => '(max-width: 1024px)',
                        'deps'   => [],
                    ],
                    [
                        'handle' => 'local-' . $template_id . '-frontend-tablet',
                        'file'   => 'local-' . $template_id . '-frontend-tablet.css',
                        'media'  => '(max-width: 1024px)',
                        'deps'   => ['base-tablet'],
                    ],
                    [
                        'handle' => 'base-mobile',
                        'file'   => 'base-mobile.css',
                        'media'  => '(max-width: 767px)',
                        'deps'   => [],
                    ],
                    [
                        'handle' => 'local-' . $template_id . '-frontend-mobile',
                        'file'   => 'local-' . $template_id . '-frontend-mobile.css',
                        'media'  => '(max-width: 767px)',
                        'deps'   => ['base-mobile'],
                    ],
                ];

                foreach ($atomic_styles as $atomic_style) {
                    $atomic_css_path = $atomic_css_dir . $atomic_style['file'];
                    if (!file_exists($atomic_css_path)) {
                        continue;
                    }

                    wp_enqueue_style(
                        $atomic_style['handle'],
                        $atomic_css_url . $atomic_style['file'],
                        $atomic_style['deps'],
                        filemtime($atomic_css_path),
                        $atomic_style['media']
                    );
                }
            }
        }

        // Build the template before wp_head() so styles registered by its
        // custom widgets are also printed in the document head.
        $elementor_content = '';
        if (
            did_action('elementor/loaded') &&
            class_exists('\Elementor\Plugin') &&
            get_post_status($template_id)
        ) {
            $elementor_content = \Elementor\Plugin::instance()
                ->frontend
                ->get_builder_content_for_display($template_id, true);
        }

        get_header('shop');

        /**
         * Hook: woocommerce_before_main_content.
         */
        do_action('woocommerce_before_main_content');

        /**
         * Hook: t888f_before_woocommerce_content
         */
        do_action('t888f_before_woocommerce_content');

        global $wp_query;
        // fix unit test
        $ajax_class = $this->enable_ajax == 'on' ? 'products-ajax-wrapper' : 'products-not-ajax-wrapper';
        $sidebar_id  = $this->sidebar;
        $has_sidebar = ($this->sidebar_pos !== 'no' && !empty($sidebar_id) && $sidebar_id !== 'choose_one');
        $layout_pos_for_class = $has_sidebar ? $this->sidebar_pos : 'no';
?>
    <?php
if (trim((string) $elementor_content) !== '') {
    echo $elementor_content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
} else {
?>
        <section id="main-content" class="main-page-default shop-page <?php echo esc_attr(t888f_get_main_class_sidebar($layout_pos_for_class)); ?>">
            <div class="container">
                <div class="row">
                    <?php if ($has_sidebar && $this->sidebar_pos === 'left') {
                        t888f_get_side_bar('left', $sidebar_id, 'left');
                    } ?>
                    <div id="<?php echo esc_attr($ajax_class); ?>" class="<?php echo t888f_get_sibling_class_sidebar($this->sidebar_pos); ?> d-flex flex-wrap col-product">
                        <?php
                        if ($wp_query->have_posts()) :
                            if (function_exists(('woocommerce_product_loop'))) {
                                if (woocommerce_product_loop()) {
                                    do_action('woocommerce_before_shop_loop');
                                }
                            }
                            $paged = max(1, get_query_var('paged', 1));
                            $total = isset($wp_query->found_posts) ? intval($wp_query->found_posts) : 0;
                            $start =  ($paged - 1) * $this->posts_per_page + 1;
                            $end = min($start + $this->posts_per_page - 1, $total);

                            $args = [
                                'style' => $this->style,
                                'posts_per_page' => $this->posts_per_page,
                                'show_number_filter' => $this->shop_show_number_filter,
                                'show_type_filter' => $this->shop_show_type_filter,
                                'show_custom_ordering_dropdown' => $this->shop_show_custom_ordering_dropdown,
                                'current_url' => get_current_url(),
                                'layout_styles' => $this->top_filter_layout_styles,
                                'per_page_options' => $this->top_filter_per_page_options,
                                'paged' => $paged,
                                'total' => $total,
                                'start' => $start,
                                'end' => $end,
                            ];

                            t888f_get_template("layout/top-filter", '', $args, true);
                        ?>
                            <div class="products <?php echo esc_attr($this->style); ?>
    <?php if ($this->style === 'grid') : ?>
        shop-layout-<?php echo esc_attr($this->shop_grid_columns); ?>-cols
    <?php endif; ?>
    gap-<?php echo esc_attr($this->shop_gap_item); ?>">


                                <?php while ($wp_query->have_posts()) : $wp_query->the_post(); ?>
                                    <div class="product-item">

                                        <?php
                                        t888f_get_template("woocommerce/loop/{$this->style}/{$this->style}", $this->slug, $this->args, true); ?>
                                    </div>
                                <?php endwhile; ?>
                            </div>

                            <?php
                            if ($this->shop_pagination_mode === 'pagination') : ?>

                                <?php
                                if (function_exists('tech888f_paging_nav')) {
                                    tech888f_paging_nav($wp_query, 'style2', true);
                                } else {
                                    if (function_exists('woocommerce_pagination')) {
                                        woocommerce_pagination();
                                    } else {
                                        echo paginate_links();
                                    }
                                }
                                ?>

                            <?php elseif ($this->shop_pagination_mode === 'loadmore') : ?>

                                <?php
                                $total_pages  = max(1, (int) ($wp_query->max_num_pages ?? 1));
                                $current_page = max(1, get_query_var('paged', 1));

                                if (!$this->enable_ajax) :
                                    if (function_exists('tech888f_paging_nav')) {
                                        tech888f_paging_nav($wp_query, 'style2', true);
                                    } elseif (function_exists('woocommerce_pagination')) {
                                        woocommerce_pagination();
                                    } else {
                                        echo paginate_links(array(
                                            'total'   => $total_pages,
                                            'current' => $current_page,
                                        ));
                                    }
                                else : ?>
                                    <div class="t888-list-loadmore-wrap shop-button"
                                        data-current-page="<?php echo esc_attr($current_page); ?>"
                                        data-max-pages="<?php echo esc_attr($total_pages); ?>">
                                        <button class="t888-list-loadmore-btn button"
                                            data-query-vars='<?php echo wp_json_encode($wp_query->query_vars); ?>'
                                            data-style="<?php echo esc_attr($this->style); ?>"
                                            data-slug="<?php echo esc_attr($this->slug); ?>">
                                            <?php esc_html_e('Load More', 'nebon'); ?>
                                        </button>
                                    </div>
                                <?php endif; ?>

                            <?php endif; ?>



                            <?php
                            /**
                             * Hook: woocommerce_after_shop_loop.
                             */
                            do_action('woocommerce_after_shop_loop');
                            ?>
                    </div>

                    <?php if ($has_sidebar && $this->sidebar_pos === 'right') {
                                t888f_get_side_bar('right', $sidebar_id, 'right');
                            } ?>
                </div>


            <?php else : ?>
                <?php
                            /**
                             * Hook: woocommerce_no_products_found.
                             */
                            do_action('woocommerce_no_products_found');
                ?>
            <?php endif; ?>
            </div>
        </section>
<?php
}
?>

<?php
        /**
         * Hook: t888f_after_woocommerce_content.
         */
        do_action('t888f_after_woocommerce_content');

        /**
         * Hook: woocommerce_after_main_content.
         */
        do_action('woocommerce_after_main_content');

        get_footer('shop');
    }
}

// Instantiate and render the archive page
ArchiveShopPage::getInstance()->render();
