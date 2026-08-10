<?php
/**
 * Template: Page (Singleton)
 * @package nebon
 */

namespace T888Core;

if (!defined('ABSPATH')) exit;

class Page_Template
{
    private static $instance = null;
    private $page_id;
    private $page_meta = [];

    public static function get_instance()
    {
        if (self::$instance === null) self::$instance = new self();
        return self::$instance;
    }

    private function __construct()
    {
        $this->init();
        add_filter('body_class', [$this, 'filter_body_class']);
    }

    private function __clone() {}
    public function __wakeup() {}

    private function init()
    {
        $this->page_id = get_the_ID();
        $this->load_page_meta();
    }

    private function is_product_context(): bool
    {
        if (function_exists('is_woocommerce')) {
            return is_shop() || is_product() || is_product_category() || is_product_tag();
        }
        return false;
    }

    public function filter_body_class($classes)
    {
        if (!$this->has_sidebar()) $classes[] = 'no-sidebar';
        $classes[] = $this->is_product_context() ? 'context-product' : 'context-page';
        return $classes;
    }

    private function map_customizer_pos(string $pos): string
    {
        return match ($pos) {
            'left_sidebar', 'left'   => 'left',
            'right_sidebar','right'  => 'right',
            default                  => 'no',
        };
    }

    private function get_sidebar_defaults_from_customizer(): array
    {
        $pos_mod  = get_theme_mod('sidebar_page', 'no_sidebar');                 // no_sidebar|left_sidebar|right_sidebar
        $item_mod = get_theme_mod('sidebar_select_display_in_page', 'no');       // id vùng widget

        return [
            'position' => $this->map_customizer_pos(is_string($pos_mod) ? $pos_mod : 'no_sidebar'),
            'item'     => is_string($item_mod) ? $item_mod : 'no',
        ];
    }

    /** Nạp meta trang + fallback Customizer */
    private function load_page_meta()
    {
        $defaults = $this->get_sidebar_defaults_from_customizer();

        $meta_position = get_post_meta($this->page_id, 'custom_page_sidebar_position', true);
        $meta_item     = get_post_meta($this->page_id, 'custom_page_sidebar_item', true);

        $sidebar_position = $meta_position !== '' ? $meta_position : $defaults['position'];  // left|right|no
        $sidebar_item     = $meta_item     !== '' ? $meta_item     : $defaults['item'];      // id sidebar

        if (in_array($sidebar_item, ['no', 'choose_one'], true)) {
            $sidebar_position = 'no';
        }

        $this->page_meta = [
            'show_title'       => get_post_meta($this->page_id, 'custom_page_show_title', true),
            'breadcrumb_image' => get_post_meta($this->page_id, 'custom_page_breadcrumb_image', true),
            'fullwidth'        => get_post_meta($this->page_id, 'custom_page_fullwidth', true),

            'sidebar_position' => $sidebar_position,
            'sidebar_item'     => $sidebar_item ?: 'woocommerce-sidebar',

            'shop_ajax_filter' => get_post_meta($this->page_id, 'custom_page_shop_ajax_filter', true),
        ];
    }

    public function get_meta($key) { return $this->page_meta[$key] ?? null; }

    public function has_sidebar(): bool
    {
        $position = $this->get_meta('sidebar_position');
        $sidebar_item = $this->get_meta('sidebar_item');
        return in_array($position, ['left', 'right'], true) && is_active_sidebar($sidebar_item);
    }

    public function get_container_class(): string
    {
        return $this->get_meta('fullwidth') === '1' ? 'container-fullwidth' : 'container';
    }

    public function get_main_column_class(): string
    {
        return $this->has_sidebar() ? 'col-9' : 'col-12';
    }

    public function get_ajax_id(): string
    {
        return $this->get_meta('shop_ajax_filter') === '1' ? 'products-ajax-wrapper' : 'products-not-ajax-wrapper';
    }

    public function render_sidebar($position)
    {
        $pos     = $this->get_meta('sidebar_position');
        $sidebar = $this->get_meta('sidebar_item');

        if ($pos !== $position || !is_active_sidebar($sidebar)) return;

        $classes = ['col-3'];
        $classes[] = $pos === 'left' ? 'left-sidebar col-left' : 'right-sidebar col-right';
        ?>
        <div class="<?php echo esc_attr(implode(' ', $classes)); ?>">
            <div class="filter-overlay"></div>
            <aside id="secondary" class="widget-area">
                <button type="button" class="btn-close-filter"><i class="las la-times"></i></button>
                <?php dynamic_sidebar($sidebar); ?>
            </aside>
        </div>
        <?php
    }

    public function render_page_title()
    {
        if ($this->get_meta('show_title') === '1') {
            echo '<div class="title-page"><h2 class="title48 m-0">' . esc_html(get_the_title()) . '</h2></div>';
        }
    }

    public function render_content()
    {
        while (have_posts()) : the_post();
            echo '<article id="post-' . get_the_ID() . '" class="' . esc_attr(implode(' ', get_post_class())) . '">';
            echo '<div class="entry-content">';
            $this->render_page_title();
            the_content();
            wp_link_pages(['before' => '<div class="page-links">' . esc_html__('Pages:', 'nebon'), 'after' => '</div>']);
            echo '</div></article>';
        endwhile;
    }

    public function render()
    {
        get_header();
        do_action('t888f_before_main_content'); ?>
        <div id="main" class="main-page">
            <div class="<?php echo esc_attr($this->get_container_class()); ?>">
                <div class="row">
                    <?php $this->render_sidebar('left'); ?>
                    <div id="<?php echo esc_attr($this->get_ajax_id()); ?>" class="<?php echo esc_attr($this->get_main_column_class()); ?>">
                        <?php $this->render_content(); ?>
                    </div>
                    <?php $this->render_sidebar('right'); ?>
                </div>

                <?php if (comments_open() || get_comments_number()) comments_template(); ?>
            </div>
        </div>
        <?php
        do_action('t888f_after_main_content');
        get_footer();
    }
}
Page_Template::get_instance()->render();
