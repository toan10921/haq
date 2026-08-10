<?php

namespace T888Core;

/**
 * Class MetaboxProductController
 * 
 * This class handles the metaboxes for products in the WordPress admin.
 */
class MetaboxProductController
{
    /**
     * @var MetaboxProductController|null The single instance of the class.
     */
    private static $instance = null;

    /**
     * MetaboxProductController constructor.
     * 
     * Initializes the metaboxes and hooks into WordPress actions and filters.
     */
    private function __construct()
    {
        add_filter('rwmb_meta_boxes', array($this, 'register_meta_boxes'));
    }

    /**
     * Get the single instance of the class.
     * 
     * @return MetaboxProductController The single instance of the class.
     */
    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Register meta boxes.
     * 
     * @param array $meta_boxes The meta boxes.
     * @return array The modified meta boxes.
     */
    public function register_meta_boxes($meta_boxes)
    {
        $meta_boxes[] = array(
            'title'      => esc_html__('Product Configuration', 'nebon'),
            'id'         => 'product_options',
            'post_types' => array('product'),
            'context'    => 'normal',
            'priority'   => 'high',
            'tabs'       => array(
                'general'  => array(
                    'label' => esc_html__('General', 'nebon'),
                ),
                'advanced' => array(
                    'label' => esc_html__('Advanced', 'nebon'),
                ),
                'custom'  => array(
                    'label' => esc_html__('Custom tab', 'nebon'),
                ),
            ),
            'tab_style'  => 'default',
            'fields'     => array(
                [
                    'name' => 'Breadcrumb Image',
                    'id'   => 'custom_product_breadcrumb_image',
                    'type' => 'image_advanced',
                    'max_file_uploads' => 1,
                    'desc' => esc_html__('Select breadcrumb image for this product (optional)', 'nebon'),
                ],
                [
                    'name'  => 'Breadcrumb Opacity',
                    'id'    => 'custom_product_breadcrumb_opacity',
                    'type'  => 'number',
                    'min'   => 0,
                    'max'   => 1,
                    'step'  => 0.05,
                    'std'   => 0,
                    'desc'  => esc_html__('Set breadcrumb overlay opacity (0 to 1)', 'nebon'),
                ],
                array(
                    'id' => 'product_thumnail_hover',
                    'name' => esc_html__('Product thumbnail hover', 'nebon'),
                    'type' => 'image_advanced',
                    'max_file_uploads' => 1,
                    'desc' => esc_html__('Upload a thumbnail image for hover effect.', 'nebon'),
                    'tab' => 'general',
                ),
                array(
                    'id'   => 'sold_in_time',
                    'name' => esc_html__('Sold in time', 'nebon'),
                    'type' => 'text',
                    'desc' => esc_html__('Input sold in time.', 'nebon'),
                ),
                array(
                    'id'    => 'product_guide',
                    'name'  => esc_html__('Product guide', 'nebon'),
                    'type'  => 'file_advanced',
                    'mime_type' => 'application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                    'max_file_uploads' => 1,
                    'desc'  => esc_html__('Upload product guide.', 'nebon'),
                    'tab'   => 'general',
                ),
                array(
                    'id'    => 'product_detail_style',
                    'name'  => esc_html__('Product detail style', 'nebon'),
                    'type'  => 'select',
                    'desc'  => esc_html__('Select style of product detail', 'nebon'),
                    'placeholder' => esc_html__('Select an Item', 'nebon'),
                    'tab'   => 'general',
                    'options' => array(
                        'normal' => esc_html__('Style1 (Swiper gallery)', 'nebon'),
                        'sticky' => esc_html__('Style2 (Fixed Info)', 'nebon'),
                    ),
                ),
                // array(
                //     'id'    => 'product_trending',
                //     'name'  => esc_html__('Product Trending', 'nebon'),
                //     'type'  => 'checkbox',
                //     'desc'  => esc_html__('Set trending for current product.', 'nebon'),
                //     'tab'   => 'general',
                // ),
                array(
                    'id'    => 'sticky_add_to_cart',
                    'name'  => esc_html__('Sticky add to cart (Simple Product only)', 'nebon'),
                    'type'  => 'select',
                    'placeholder' => esc_html__('Select an Item', 'nebon'),
                    'tab'   => 'general',
                    'options' => array(
                        'off' => esc_html__('off', 'nebon'),
                        'on'  => esc_html__('on', 'nebon'),
                    ),
                ),
                // array(
                //     'id'    => 'image_zoom',
                //     'name'  => esc_html__('Image zoom', 'nebon'),
                //     'type'  => 'select',
                //     'desc'  => esc_html__('Choose a style to display', 'nebon'),
                //     'placeholder' => esc_html__('Select an Item', 'nebon'),
                //     'tab'   => 'general',
                //     'options' => array(
                //         'none' => esc_html__('None', 'nebon'),
                //         'zoom1' => esc_html__('Zoom 1', 'nebon'),
                //         'zoom2' => esc_html__('Zoom 2', 'nebon'),
                //         'zoom3' => esc_html__('Zoom 3', 'nebon'),
                //         'zoom4' => esc_html__('Zoom 4', 'nebon'),
                //     ),
                // ),
                // array(
                //     'id'    => 'url_video',
                //     'type'  => 'url',
                //     'name'  => esc_html__('Link/URL video', 'nebon'),
                //     'desc'  => esc_html__('Input a video/audio link.', 'nebon'),
                //     'tab'   => 'general',
                // ),
                // array(
                //     'id'    => 'add_attribute_by_color',
                //     'type'  => 'group',
                //     'name'  => esc_html__('Add attribute by color', 'nebon'),
                //     'fields' => array(
                //         array(
                //             'id'   => 'add_atribute_by_color_title',
                //             'type' => 'text',
                //             'name' => esc_html__('Title', 'nebon'),
                //         ),
                //         array(
                //             'id'   => 'add_attribute_by_color_picker',
                //             'name' => esc_html__('Color', 'nebon'),
                //             'type' => 'color',
                //         ),
                //         array(
                //             'id'   => 'add_attribute_by_color_image_picker',
                //             'type' => 'file_input',
                //             'name' => esc_html__('Image', 'nebon'),
                //         ),
                //         array(
                //             'id'   => 'add_attribute_by_color_image_hover',
                //             'type' => 'file_input',
                //             'name' => esc_html__('Image Hover', 'nebon'),
                //         ),
                //     ),
                //     'clone'         => true,
                //     'default_state' => 'expanded',
                //     'collapsible'   => true,
                //     'tab'           => 'general',
                // ),
                // Tab Advanced
                // array(
                //     'id'    => 'custome_item_device',
                //     'type'  => 'text',
                //     'name'  => esc_html__('Custom item devices', 'nebon'),
                //     'tab'   => 'advanced',
                // ),
                array(
                    'id'    => 'append_content_before_product_page_custom',
                    'name'  => esc_html__('Append content before product page', 'nebon'),
                    'type'  => 'select',
                    'desc'  => esc_html__('Choose a mega page content append to before product page.', 'nebon'),
                    'placeholder' => esc_html__('Select an Item', 'nebon'),
                    'tab'   => 'advanced',
                    'options' => $this->get_mega_page_options(),
                ),

                array(
                    'id'    => 'append_content_before_product_tab_custom',
                    'name'  => esc_html__('Append content before product tab', 'nebon'),
                    'type'  => 'select',
                    'desc'  => esc_html__('Choose a mega page content append to before product tab.', 'nebon'),
                    'placeholder' => esc_html__('Select an Item', 'nebon'),
                    'tab'   => 'advanced',
                    'options' => $this->get_mega_page_options(),
                ),

                array(
                    'id'    => 'append_content_after_product_tab_custom',
                    'name'  => esc_html__('Append content after product tab', 'nebon'),
                    'type'  => 'select',
                    'desc'  => esc_html__('Choose a mega page content append to after product tab.', 'nebon'),
                    'placeholder' => esc_html__('Select an Item', 'nebon'),
                    'tab'   => 'advanced',
                    'options' => $this->get_mega_page_options(),
                ),
                array(
                    'id'    => 'append_content_after_product_page_custom',
                    'name'  => esc_html__('Append content after product page', 'nebon'),
                    'type'  => 'select',
                    'desc'  => esc_html__('Choose a mega page content append to after product page.', 'nebon'),
                    'placeholder' => esc_html__('Select an Item', 'nebon'),
                    'tab'   => 'advanced',
                    'options' => $this->get_mega_page_options(),
                ),

                array(
                    'id'    => 'product_tab_style',
                    'name'  => esc_html__('Product tab style', 'nebon'),
                    'type'  => 'select',
                    'placeholder' => esc_html__('Select an Item', 'nebon'),
                    'tab'   => 'advanced',
                    'options' => array(
                        'tab_style_horizontal' => esc_html__('Tab style horizontal', 'nebon'),
                        'tab_style_accordion' => esc_html__('Tab style accordion', 'nebon'),
                    )
                ),


                array(
                    'id'   => 'add_custom_tab_title',
                    'type' => 'text',
                    'name' => esc_html__('Title', 'nebon'),
                    'tab'   => 'custom',
                ),
                array(
                    'id'   => 'add_custom_tab_content',
                    'type' => 'textarea',
                    'name' => esc_html__('Content', 'nebon'),
                    'tab'   => 'custom',
                ),
                array(
                    'id'   => 'priority',
                    'name' => esc_html__('Priority', 'nebon'),
                    'type' => 'range',
                    'desc' => esc_html__('Choose priority value to re-order custom tab position.', 'nebon'),
                    'max'  => 60,
                    'step' => 1,
                    'tab'   => 'custom',
                ),

            ),
        );
        return $meta_boxes;
    }

    /**
     * Get mega page options.
     * 
     * @return array The mega page options.
     */
    private function get_mega_page_options()
    {
        $mega_pages = get_posts(array(
            'post_type'   => 'mega_item',
            'numberposts' => -1,
            'orderby'     => 'title',
            'order'       => 'ASC',
        ));

        $options = array();
        if ($mega_pages) {
            foreach ($mega_pages as $page) {
                $options[$page->ID] = $page->post_title; // Use ID as the key and title as the value
            }
        }

        return $options;
    }
}

MetaboxProductController::getInstance();
