<?php

namespace T888Core;

/**
 * Trait BlogPostTrait
 * 
 * Provides methods for handling blog post styles.
 */
trait BlogPostTrait
{
    /**
     * Get available blog styles.
     * 
     * @return array The available blog styles.
     */
    public function get_blog_styles()
    {
        return array(
            'list' => esc_html__('List', 'nebon'),
            'grid' => esc_html__('Grid', 'nebon'),
        );
    }

    /**
     * Get the default blog style.
     * 
     * @return string The default blog style.
     */
    public function get_blog_default_style()
    {
        return 'list';
    }

    /**
     * Get the default blog list item style.
     * 
     * @return string The default blog list item style.
     */
    public function get_blog_list_item_default_style()
    {
        return 'choose_one';
    }

    /**
     * Get available blog list item styles.
     * 
     * @return array The available blog list item styles.
     */
    public function get_blog_list_item_styles()
    {
        return array(
            'choose_one' => esc_html__('Choose one', 'nebon'),
            'default' => esc_html__('Default', 'nebon'),
            'style2' => esc_html__('Style 2', 'nebon'),
        );
    }

    /**
     * Get the default blog grid item style.
     * 
     * @return string The default blog grid item style.
     */
    public function get_blog_grid_item_default_style()
    {
        return 'choose_one';
    }

    /**
     * Get available blog grid item styles.
     * 
     * @return array The available blog grid item styles.
     */
    public function get_blog_grid_item_styles()
    {
        return array(
            'choose_one' => esc_html__('Choose one', 'nebon'),
            'default' => esc_html__('Default', 'nebon'),
            'style2' => esc_html__('Style 2', 'nebon'),
        );
    }

    /**
     * Get a list of post types.
     * 
     * @param string $post_type The post type.
     * @param bool $type Whether to include an empty option.
     * @return array The list of post types.
     */
    static function _tech888f_list_post_type($post_type = 'page', $type = true)
    {
        global $post;
        $post_temp = $post;
        $page_list = array();
        if ($type) {
            $page_list[] = array();
        } else $page_list[] = esc_html__('-- Choose One --', 'nebon');

        if (is_admin()) {
            $pages = get_posts(array('post_type' => $post_type, 'posts_per_page' => -1, 'orderby' => 'title', 'order' => 'ASC'));
            if (!empty($pages)) {
                if (is_array($pages) & count($pages) > 0) {
                    foreach ($pages as $page) {
                        $page_list[$page->ID] =  $page->post_title;
                    }
                }
            }
        }
        return $page_list;
    }
}
