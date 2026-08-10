<?php

/**
 * Created by PhpStorm.
 * User: toanngo92
 * Date: 2/11/2019
 * Time: 2:39 PM
 */

namespace T888Core;


/**
 * Class MetaboxFooterController
 * 
 * This class handles the metaboxes for pages in the WordPress admin.
 */
class MetaboxFooterController
{
    /**
     * @var MetaboxFooterController|null The single instance of the class.
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
            'post_types' => array('footer_item'),
            'context' => 'normal',
            'priority' => 'low',
            'fields' => array(
            
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

MetaboxFooterController::getInstance();