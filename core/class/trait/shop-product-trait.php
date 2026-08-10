<?php

namespace T888Core;

/**
 * Trait BlogPostTrait
 * 
 * Provides methods for handling blog post styles.
 */
trait ShopProductTrait
{
    public function get_product_thumb_animation($style = 'element')
    {
        $list = apply_filters('tech888f_product_item_style', array(
            'choose_one' => esc_html__('Choose One', 'nebon'),
            // 'none-thumb' => esc_html__('None', 'nebon'),
            'default-grid-thumb' => esc_html__('Grid Style Hover - Default', 'nebon'),
            'light-soft-thumb' => esc_html__('Light Soft', 'nebon'),
            'zoom-thumb' => esc_html__('Zoom', 'nebon'),
            'rotate-thumb' => esc_html__('Rotate', 'nebon'),
            'zoomout-thumb' => esc_html__('Zoom Out', 'nebon'),
            'translate-thumb' => esc_html__('Translate', 'nebon'),
        ));
        if ($style != 'element') {
            $temp = array();
            foreach ($list as $key => $value) {
                $temp[] = array(
                    'value' => $value,
                    'label' => $key,
                );
            }
            $list = $temp;
        }
        return $list;
    }

    /**
     * Get available product styles.
     * 
     * @return array The available product styles.
     */

    public function get_list_products_styles(){
        return array(
            'grid' => esc_html__('Grid', 'nebon'),
            'list' => esc_html__('List', 'nebon'),
        );
    }

    /**
     * Get available product grid item styles.
     * 
     * @return array The available product grid item styles.
     */
    public function get_product_grid_item_styles()
    {
        return array(
            'choose_one' => esc_html__('Choose One', 'nebon'),
            'default' => esc_html__('Default', 'nebon'),
            // 'style' => esc_html__('Style 2', 'nebon'),
        );
    }

    /**
     * Get the default product list item style.
     * 
     * @return string The default product list item style.
     */
    public function get_default_product_list_item_style()
    {
        return array(
            'choose_one' => esc_html__('Choose One', 'nebon'),
            'default' => esc_html__('Default', 'nebon'),
            'style2' => esc_html__('Style 2 - HomePage Box 4', 'nebon'),
        );
    }

}
