<?php

namespace T888Core\PostType;

if (!class_exists('HeaderPageController')) {
    class HeaderPageController
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
                'name'               => esc_html__('Header Page', 'nebon'),
                'singular_name'      => esc_html__('Header Page', 'nebon'),
                'menu_name'          => esc_html__('Header Page', 'nebon'),
                'name_admin_bar'     => esc_html__('Header Page', 'nebon'),
                'add_new'            => esc_html__('Add New', 'nebon'),
                'add_new_item'       => esc_html__('Add New Header Page', 'nebon'),
                'new_item'           => esc_html__('New Header Page', 'nebon'),
                'edit_item'          => esc_html__('Edit Header Page', 'nebon'),
                'view_item'          => esc_html__('View Header Page', 'nebon'),
                'all_items'          => esc_html__('All Header Page', 'nebon'),
                'search_items'       => esc_html__('Search Header Page', 'nebon'),
                'parent_item_colon'  => esc_html__('Parent Header Page:', 'nebon'),
                'not_found'          => esc_html__('No Header Page found.', 'nebon'),
                'not_found_in_trash' => esc_html__('No Header Page found in Trash.', 'nebon')
            );

            $args = array(
                'labels'             => $labels,
                'public'             => true,
                'publicly_queryable' => true,
                'show_ui'            => true,
                'show_in_menu'       => true,
                'query_var'          => true,
                'rewrite'            => array('slug' => 'header_item'),
                'capability_type'    => 'post',
                'has_archive'        => false,
                'hierarchical'       => false,
                'menu_position'      => null,
                'menu_icon'          => 'dashicons-layout',
                'supports'           => array('title', 'editor', 'revisions')
            );

            t888_reg_post_type('header_item', $args);

            // Add elementor support
            add_post_type_support('header_item', 'elementor');
        }
    }

    HeaderPageController::_init();
}
