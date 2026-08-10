<?php

namespace T888Core\PostType;

if (!class_exists('MegaPageController')) {
    class MegaPageController
    {

        static function _init()
        {
            if (function_exists('t888_reg_post_type')) {
                add_action('init', array(__CLASS__, '_add_post_type'));
            }
        }

        static function _add_post_type()
        {
            $labels = array(
                'name'               => esc_html__('Mega Page', 'nebon'),
                'singular_name'      => esc_html__('Mega Page', 'nebon'),
                'menu_name'          => esc_html__('Mega Page', 'nebon'),
                'name_admin_bar'     => esc_html__('Mega Page', 'nebon'),
                'add_new'            => esc_html__('Add New', 'nebon'),
                'add_new_item'       => esc_html__('Add New Mega Page', 'nebon'),
                'new_item'           => esc_html__('New Mega Page', 'nebon'),
                'edit_item'          => esc_html__('Edit Mega Page', 'nebon'),
                'view_item'          => esc_html__('View Mega Page', 'nebon'),
                'all_items'          => esc_html__('All Mega Page', 'nebon'),
                'search_items'       => esc_html__('Search Mega Page', 'nebon'),
                'parent_item_colon'  => esc_html__('Parent Mega Page:', 'nebon'),
                'not_found'          => esc_html__('No Mega Page found.', 'nebon'),
                'not_found_in_trash' => esc_html__('No Mega Page found in Trash.', 'nebon')
            );

            $args = array(
                'labels'             => $labels,
                'public'             => true,
                'publicly_queryable' => true,
                'show_ui'            => true,
                'show_in_menu'       => true,
                'query_var'          => true,
                'rewrite'            => array('slug' => 'mega_item'),
                'capability_type'    => 'post',
                'has_archive'        => false,
                'hierarchical'       => false,
                'menu_position'      => null,
                'menu_icon'          => 'dashicons-welcome-widgets-menus',
                'supports'           => array('title', 'editor', 'revisions')
            );

            t888_reg_post_type('mega_item', $args);

            // Add elementor support
            add_post_type_support('mega_item', 'elementor');
        }
    }

    MegaPageController::_init();
}
