<?php

namespace T888Core\PostType;

if (!class_exists('TeamMemberController')) {
    class TeamMemberController
    {
        public static function init()
        {
            add_action('init', [__CLASS__, 'register']);
        }

        public static function register()
        {
            $labels = [
                'name'          => __('Team Members', 'nebon'),
                'singular_name' => __('Team Member', 'nebon'),
                'add_new_item'  => __('Add New Team Member', 'nebon'),
                'edit_item'     => __('Edit Team Member', 'nebon'),
                'all_items'     => __('All Team Members', 'nebon'),
            ];

            $args = [
                'labels'             => $labels,
                'public'             => true,
                'publicly_queryable' => true,
                'show_ui'            => true,
                'show_in_menu'       => true,
                'show_in_rest'       => true,
                'has_archive'        => true,
                'rewrite'            => ['slug' => 'team'],
                'menu_icon'          => 'dashicons-groups',
                'supports'           => [
                    'title',
                    'editor',
                    'thumbnail',
                    'excerpt',
                    'revisions',
                ],
            ];

            register_post_type('team_member', $args);
            add_post_type_support('team_member', 'elementor');
        }
    }

    TeamMemberController::init();
}