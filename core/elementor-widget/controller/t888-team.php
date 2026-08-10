<?php

/**
 * Created by khangtrinh.
 * User: khangtrinh
 * Date: 13/06/2024
 * Time: 04:20 PM
 */

namespace Elementor;

// if (!defined('ABSPATH')) {
//     exit; // Exit if accessed directly
// }

class T888_Team extends T888_Widget_Base
{
    /**
     * Get widget name.
     */
    public function get_name()
    {
        return 't888-team';
    }

    /**
     * Get widget title.
     */
    public function get_title()
    {
        return __('Team', 'nebon');
    }

    /**
     * Get widget icon.
     */
    public function get_icon()
    {
        return 'fas fa-star';
    }
    /**
     * Add script depends.
     *
     * Register new script to enqueue by the handler.
     *
     * @since 1.9.0
     * @access public
     *
     * @param string $handler Depend script handler.
     */
    public function get_script_depends()
    {
        return ['elementor-t888-team', 'swiper'];
    }

    /**
     * Add style depends.
     *
     * Register new style to enqueue by the handler.
     *
     * @since 1.9.0
     * @access public
     *
     * @param string $handler Depend style handler.
     */
    public function get_style_depends()
    {
        return ['elementor-t888-team', 'e-swiper'];
    }
    /**
     * Get widget categories.
     */
    public function get_categories()
    {
        return ['t888-elements'];
    }

    /**
     * Register controls.
     */
    protected function _register_controls()
    {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Team Members', 'nebon'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'team_list',
            [
                'label' => __('Team Members', 'nebon'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => [
                    [
                        'name' => 'image',
                        'label' => __('Photo', 'nebon'),
                        'type' => \Elementor\Controls_Manager::MEDIA,
                        'default' => [
                            'url' => \Elementor\Utils::get_placeholder_image_src(),
                        ],
                    ],
                    [
                        'name' => 'image_position',
                        'label' => __('Image Position', 'nebon'),
                        'type' => \Elementor\Controls_Manager::SELECT,
                        'default' => 'center',
                        'options' => [
                            'top' => __('Top', 'nebon'),
                            'center' => __('Center', 'nebon'),
                            'bottom' => __('Bottom', 'nebon'),
                            'left' => __('Left', 'nebon'),
                            'right' => __('Right', 'nebon'),
                            'top left' => __('Top Left', 'nebon'),
                            'top right' => __('Top Right', 'nebon'),
                            'bottom left' => __('Bottom Left', 'nebon'),
                            'bottom right' => __('Bottom Right', 'nebon'),
                        ],
                    ],

                    [
                        'name' => 'name',
                        'label' => __('Name', 'nebon'),
                        'type' => \Elementor\Controls_Manager::TEXT,
                        'default' => __('Elia Durá', 'nebon'),
                    ],
                    [
                        'name' => 'position',
                        'label' => __('Position', 'nebon'),
                        'type' => \Elementor\Controls_Manager::TEXT,
                        'default' => __('CEO', 'nebon'),
                    ],
                    [
                        'name' => 'facebook',
                        'label' => __('Facebook URL', 'nebon'),
                        'type' => \Elementor\Controls_Manager::URL,
                        'default' => [
                            'url' => '',
                            'is_external' => true,
                            'nofollow' => false,
                        ],
                    ],
                    [
                        'name' => 'pinterest',
                        'label' => __('Pinterest URL', 'nebon'),
                        'type' => \Elementor\Controls_Manager::URL,
                        'default' => [
                            'url' => '',
                            'is_external' => true,
                            'nofollow' => false,
                        ],
                    ],
                    [
                        'name' => 'instagram',
                        'label' => __('Instagram URL', 'nebon'),
                        'type' => \Elementor\Controls_Manager::URL,
                        'default' => [
                            'url' => '',
                            'is_external' => true,
                            'nofollow' => false,
                        ],
                    ],
                    [
                        'name' => 'youtube',
                        'label' => __('YouTube URL', 'nebon'),
                        'type' => \Elementor\Controls_Manager::URL,
                        'default' => [
                            'url' => '',
                            'is_external' => true,
                            'nofollow' => false,
                        ],
                    ],
                    [
                        'name' => 'twitter',
                        'label' => __('Twitter URL', 'nebon'),
                        'type' => \Elementor\Controls_Manager::URL,
                    ],
                    [
                        'name' => 'linkedin',
                        'label' => __('LinkedIn URL', 'nebon'),
                        'type' => \Elementor\Controls_Manager::URL,
                        'default' => [
                            'url' => '',
                            'is_external' => true,
                            'nofollow' => false,
                        ],
                    ],
                    [
                        'name' => 'skype',
                        'label' => __('Skype URL', 'nebon'),
                        'type' => \Elementor\Controls_Manager::URL,
                        'default' => [
                            'url' => '',
                            'is_external' => true,
                            'nofollow' => false,
                        ],
                    ],
                    [
                        'name' => 'whatsapp',
                        'label' => __('WhatsApp URL', 'nebon'),
                        'type' => \Elementor\Controls_Manager::URL,
                        'default' => [
                            'url' => '',
                            'is_external' => true,
                            'nofollow' => false,
                        ],
                    ],
                    [
                        'name' => 'viber',
                        'label' => __('Viber URL', 'nebon'),
                        'type' => \Elementor\Controls_Manager::URL,
                    ],
                    [
                        'name' => 'telegram',
                        'label' => __('Telegram URL', 'nebon'),
                        'type' => \Elementor\Controls_Manager::URL,
                        'default' => [
                            'url' => '',
                            'is_external' => true,
                            'nofollow' => false,
                        ],
                    ],
                    [
                        'name' => 'snapchat',
                        'label' => __('Snapchat URL', 'nebon'),
                        'type' => \Elementor\Controls_Manager::URL,
                        'default' => [
                            'url' => '',
                            'is_external' => true,
                            'nofollow' => false,
                        ],
                    ],

                ],
                'title_field' => '{{{ name }}}',
            ]
        );

        $this->end_controls_section();
    }


    /**
     * Render widget output on the frontend.
     */
    protected function render()
    {
        parent::render();
        $settings = $this->get_settings_for_display();
        $style = isset($settings['style']) ? $settings['style'] : 'style1';
        tech888f_get_template_elementor_widget('t888-team', $style, $settings, true);
    }
}
