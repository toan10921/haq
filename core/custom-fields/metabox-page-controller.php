<?php
/**
 * Created by PhpStorm.
 * User: toanngo92
 * Date: 2/11/2019
 * Time: 2:39 PM
 */

namespace T888Core;

/**
 * Class MetaboxPageController
 * 
 * This class handles the metaboxes for pages in the WordPress admin.
 */
class MetaboxPageController
{
    /**
     * @var MetaboxPageController|null The single instance of the class.
     */
    private static $instance = null;

    /**
     * MetaboxPageController constructor.
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
     * @return MetaboxPageController The single instance of the class.
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
            'title' => esc_html__('Page Settings', 'nebon'),
            'id' => 'custom-page-options',
            'post_types' => array('page'),
            'context' => 'normal',
            'priority' => 'low',
            'fields' => array(
                // [
                //     'name'    => 'Page Style',
                //     'id'      => 'custom_page_display_style',
                //     'type'    => 'select',
                //     'options' => [
                //         'default'  => esc_html__('Default', 'nebon'),
                //         'parallax' => esc_html__('Page Parallax', 'nebon'),
                //     ],
                //     'std'     => 'default',
                //     'desc'    => esc_html__('Select style for page', 'nebon'),
                // ],
                [
                    'name' => 'Choose Custom Header Page',
                    'id'   => 'custom_header_page',
                    'type' => 'post',
                    'post_type' => 'header_item',
                    'field_type' => 'select_advanced',
                    'placeholder' => esc_html__('Select an Item', 'nebon'),
                    'desc' => esc_html__('Choose your Custom Header Page', 'nebon'),
                    'options' => array(
                        'query_args' => array(
                            'post_status' => 'publish',
                            'posts_per_page' => -1,
                            'orderby' => 'date',
                        ),
                    ),
                ],
                [
                    'name' => 'Choose Custom Footer Page',
                    'id'   => 'custom_footer_page',
                    'type' => 'post',
                    'post_type' => 'footer_item',
                    'field_type' => 'select_advanced',
                    'placeholder' => esc_html__('Select an Item', 'nebon'),
                    'desc' => esc_html__('Choose your Custom Footer Page', 'nebon'),
                    'options' => array(
                        'query_args' => array(
                            'post_status' => 'publish',
                            'posts_per_page' => -1,
                            'orderby' => 'date',
                        ),
                    ),
                ],
                [
                    'name'  => 'show page title',
                    'id'    => 'custom_page_show_title',
                    'type'  => 'checkbox',
                    'std'   => 1,
                    'desc'  => esc_html__('Check to show page title', 'nebon'),
                ],
                [
                    'name' => 'Breadcrumb Image',
                    'id'   => 'custom_page_breadcrumb_image',
                    'type' => 'image_advanced', 
                    'max_file_uploads' => 1,
                    'desc' => esc_html__('Select breadcrumb image for this page (optional)', 'nebon'),
                ],
                [
                    'name'  => 'Breadcrumb Opacity',
                    'id'    => 'custom_page_breadcrumb_opacity',
                    'type'  => 'number',
                    'min'   => 0,
                    'max'   => 1,
                    'step'  => 0.05,
                    'std'   => 0,
                    'desc'  => esc_html__('Set breadcrumb overlay opacity (0 to 1)', 'nebon'),
                ],
                // array(
                //     'id' => 'short_description',
                //     'name' => esc_html__('Short Description', 'nebon'),
                //     'type' => 'textarea',
                //     'rows' => 5,
                //     'desc' => esc_html__('Short description for page', 'nebon'),
                //     'placeholder' => esc_html__('Enter short description', 'nebon'),
                // ),
                array(
                    'id' => 'custom_page_sidebar_position',
                    'name' => esc_html__('Page Sidebar Position', 'nebon'),
                    'type' => 'select',
                    'placeholder' => esc_html__('Select an Item', 'nebon'),
                    'options' => array(
                        'no' => esc_html__('No Sidebar', 'nebon'),
                        'left' => esc_html__('Left Sidebar', 'nebon'),
                        'right' => esc_html__('Right Sidebar', 'nebon'),
                    ),
                ),
                [
                    'id'          => 'custom_page_sidebar_item',
                    'name'        => esc_html__('Sidebar Item', 'nebon'),
                    'type'        => 'sidebar',             
                    'field_type'  => 'select',            
                    'multiple'    => false,                
                    'placeholder' => esc_html__('Select an Item', 'nebon'),
                    'desc'        => esc_html__('Choose your Custom Page Sidebar', 'nebon'),
                    'visible'     => [
                        'when' => [
                            ['custom_page_sidebar_position', '!=', 'no'],
                        ],
                    ],
                ],
                array(
                    'id' => 'custom_page_shop_ajax_filter',
                    'name' => esc_html__('Enable Ajax Filter', 'nebon'),
                    'type' => 'checkbox',
                    'std' => 0,
                    'desc' => esc_html__('Check to enable ajax filter for shop page (Only available when use porduct list element elementor', 'nebon'),
                ),
                // fullwidth page
                array(
                    'id' => 'custom_page_fullwidth',
                    'name' => esc_html__('Fullwidth Page', 'nebon'),
                    'type' => 'checkbox',
                    'std' => 0,
                    'desc' => esc_html__('Check to make this page fullwidth', 'nebon'),
                ),
            ),
        );
        return $meta_boxes;
    }
}

MetaboxPageController::getInstance();
