<?php

/**
 * Created by PhpStorm.
 * User: toanngo92
 * Date: 2/11/2019
 * Time: 2:39 PM
 */

namespace T888Core;

/**
 * Class MetaboxPostController
 * Handles the metaboxes for posts in the WordPress admin.
 */
class MetaboxPostController
{
    /** @var MetaboxPostController|null */
    private static $instance = null;

    private function __construct()
    {
        add_filter('rwmb_meta_boxes', [$this, 'register_meta_boxes']);
    }

    /** @return MetaboxPostController */
    public static function getInstance()
    {
        if (self::$instance === null) self::$instance = new self();
        return self::$instance;
    }

    /**
     * Register meta boxes.
     * @param array $meta_boxes
     * @return array
     */
    public function register_meta_boxes($meta_boxes)
    {
        $meta_boxes[] = [
            'title'      => esc_html__('Post Settings', 'nebon'),
            'id'         => 'custom-post-options',
            'post_types' => ['post'],
            'context'    => 'normal',
            'priority'   => 'low',
            'fields'     => [

                // ===== Layout =====
                [
                    'type' => 'heading',
                    'name' => esc_html__('Layout', 'nebon'),
                ],
                [
                    'name'    => esc_html__('Post Style', 'nebon'),
                    'id'      => 'custom_post_display_style',
                    'type'    => 'select',
                    'options' => [
                        'detail'  => esc_html__('Default', 'nebon'),
                        'detail2' => esc_html__('Post Parallax', 'nebon'),
                    ],
                    'std'     => 'detail',
                    'desc'    => esc_html__('Select layout style for this post.', 'nebon'),
                ],
                [
                    'name' => esc_html__('Show Featured Image', 'nebon'),
                    'id'   => 'custom_post_show_thumbnail',
                    'type' => 'checkbox',
                    'std'  => 0, // 0 = unchecked by default → featured image hidden
                    'desc' => esc_html__('Show the featured image on the single post (applies to Standard post format only).', 'nebon'),
                ],

                [
                    'id'   => 'custom_post_fullwidth',
                    'type' => 'checkbox',
                    'name' => esc_html__('Fullwidth Layout', 'nebon'),
                    'desc' => esc_html__('Enable edge-to-edge layout (no container constraint).', 'nebon'),
                    'std'  => 0,
                ],
                [
                    'id'          => 'custom_post_sidebar_position',
                    'name'        => esc_html__('Post Sidebar Position', 'nebon'),
                    'type'        => 'select',
                    'options'     => [
                        'no'    => esc_html__('No Sidebar', 'nebon'),
                        'left'  => esc_html__('Left Sidebar', 'nebon'),
                        'right' => esc_html__('Right Sidebar', 'nebon'),
                    ],
                    'std'         => 'no',
                    'placeholder' => esc_html__('Select an Item', 'nebon'),
                    'desc'        => esc_html__('Choose where the sidebar appears on this post.', 'nebon'),
                ],
                [
                    'id'          => 'custom_post_sidebar_item',
                    'type'        => 'sidebar',
                    'name'        => esc_html__('Sidebar Item', 'nebon'),
                    'field_type'  => 'select', // simple select is enough
                    'multiple'    => false,
                    'placeholder' => esc_html__('Select an Item', 'nebon'),
                    'desc'        => esc_html__('Pick the widget area to display when a sidebar is enabled.', 'nebon'),
                    // Show only when position is left or right (Meta Box "visible" API)
                    'visible'     => [
                        'when'     => [
                            ['custom_post_sidebar_position', '=', 'left'],
                            ['custom_post_sidebar_position', '=', 'right'],
                        ],
                        'relation' => 'or',
                    ],
                ],

                // ===== Breadcrumb =====
                [
                    'type' => 'heading',
                    'name' => esc_html__('Breadcrumb', 'nebon'),
                ],
                [
                    'name'             => esc_html__('Breadcrumb Image', 'nebon'),
                    'id'               => 'custom_post_breadcrumb_image',
                    'type'             => 'image_advanced',
                    'max_file_uploads' => 1,
                    'desc'             => esc_html__('Upload a custom breadcrumb background for this post (optional).', 'nebon'),
                ],
                [
                    'name'  => esc_html__('Breadcrumb Opacity', 'nebon'),
                    'id'    => 'custom_post_breadcrumb_opacity',
                    'type'  => 'number',
                    'min'   => 0,
                    'max'   => 1,
                    'step'  => 0.05,
                    'std'   => 0,
                    'desc'  => esc_html__('Overlay opacity from 0 (transparent) to 1 (solid).', 'nebon'),
                ],

                // ===== Content =====
                [
                    'type' => 'heading',
                    'name' => esc_html__('Content', 'nebon'),
                ],
                [
                    'id'          => 'short_description',
                    'name'        => esc_html__('Short Description', 'nebon'),
                    'type'        => 'textarea',
                    'rows'        => 5,
                    'placeholder' => esc_html__('Enter short description', 'nebon'),
                    'desc'        => esc_html__('Short description for post', 'nebon'),
                ],

                // ===== Media (by post formats) =====
                [
                    'type' => 'heading',
                    'name' => esc_html__('Media / Post Formats', 'nebon'),
                ],
                [
                    'id'               => 'custom_post_detail_gallery',
                    'name'             => esc_html__('Post Detail Gallery (for Gallery format)', 'nebon'),
                    'type'             => 'image_advanced',
                    'max_file_uploads' => 30,
                    'force_delete'     => false,
                    'desc'             => esc_html__('Used on single post when the Post Format is Gallery.', 'nebon'),
                ],
                [
                    'id'   => 'video_1',
                    'type' => 'video',
                    'name' => esc_html__('Upload Video (for Video format)', 'nebon'),
                ],
                [
                    'id'   => 'custom_post_content_media',
                    'name' => esc_html__('Video URL (for Video format)', 'nebon'),
                    'type' => 'text',
                    'desc' => esc_html__('Paste a video URL (YouTube, Vimeo…) to embed.', 'nebon'),
                ],
                [
                    'id'        => 'audio_11',
                    'type'      => 'file_advanced',
                    'mime_type' => 'audio',
                    'name'      => esc_html__('Upload Audio (for Audio format)', 'nebon'),
                ],
                [
                    'id'   => 'audio_embed',
                    'type' => 'text',
                    'name' => esc_html__('Audio Embed URL (for Audio format)', 'nebon'),
                    'desc' => esc_html__('URL from services like SoundCloud, Spotify…', 'nebon'),
                ],
            ],
        ];

        return $meta_boxes;
    }
}

MetaboxPostController::getInstance();
