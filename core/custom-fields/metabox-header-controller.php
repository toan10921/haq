<?php

/**
 * Created by PhpStorm.
 * User: toanngo92
 * Date: 2/11/2019
 * Time: 2:39 PM
 */

namespace T888Core;


/**
 * Class MetaboxHeaderController
 * 
 * This class handles the metaboxes for pages in the WordPress admin.
 */
class MetaboxHeaderController
{
    /**
     * @var MetaboxHeaderController|null The single instance of the class.
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
    public function register_meta_boxes($meta_boxes){
      $meta_boxes[] = array(
            'title' => esc_html__('Page Settings', 'nebon'),
            'id' => 'custom-page-options',
            'post_types' => array('header_item'),
            'context' => 'normal',
            'priority' => 'low',
            'fields' => array(
                [
                   'name' =>  'Sticky Header Menu',
                   'id'   => 'sticky_header',
                     'type' => 'checkbox',
                     'std'  => 0,
                     'desc' => esc_html__('Enable sticky header menu. If you create a new header, please add the class "sticky-on" to the section you want to make sticky.', 'nebon'),
                ],
            
                [
                    'name'  => 'Page Assets File',
                    'id'    => 'page_assets_file',
                    'type'  => 'text',
                    'std'   => '',
                    'desc'  => esc_html__('Enter the file name of page assets file', 'nebon'),
                ],
               
            ),
        );
        return $meta_boxes;
    }
}

MetaboxHeaderController::getInstance();