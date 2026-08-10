<?php

namespace T888Core\PostType;

if (!class_exists('FooterPageController')) {
    class FooterPageController
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
                'name'               => esc_html__('Footer Page', 'nebon'),
                'singular_name'      => esc_html__('Footer Page', 'nebon'),
                'menu_name'          => esc_html__('Footer Page', 'nebon'),
                'name_admin_bar'     => esc_html__('Footer Page', 'nebon'),
                'add_new'            => esc_html__('Add New', 'nebon'),
                'add_new_item'       => esc_html__('Add New Footer Page', 'nebon'),
                'new_item'           => esc_html__('New Footer Page', 'nebon'),
                'edit_item'          => esc_html__('Edit Footer Page', 'nebon'),
                'view_item'          => esc_html__('View Footer Page', 'nebon'),
                'all_items'          => esc_html__('All Footer Page', 'nebon'),
                'search_items'       => esc_html__('Search Footer Page', 'nebon'),
                'parent_item_colon'  => esc_html__('Parent Footer Page:', 'nebon'),
                'not_found'          => esc_html__('No Footer Page found.', 'nebon'),
                'not_found_in_trash' => esc_html__('No Footer Page found in Trash.', 'nebon')
            );

            $args = array(
                'labels'             => $labels,
                'public'             => true,
                'publicly_queryable' => true,
                'show_ui'            => true,
                'show_in_menu'       => true,
                'query_var'          => true,
                'rewrite'            => array('slug' => 'footer_item'),
                'capability_type'    => 'post',
                'has_archive'        => false,
                'hierarchical'       => false,
                'menu_position'      => null,
                'menu_icon'          => 'dashicons-editor-kitchensink',
                'supports'           => array('title', 'editor', 'revisions')
            );

            t888_reg_post_type('footer_item', $args);

            // Add elementor support
            add_post_type_support('footer_item', 'elementor');
        }
    }

    FooterPageController::_init();
}
