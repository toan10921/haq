<?php

namespace Elementor;

// if (!defined('ABSPATH')) {
//     exit;
// }

class T888_Social_List extends T888_Widget_Base
{
    /**
     * Get widget name.
     *
     * Retrieve the widget name.
     *
     * @return string Widget name.
     */
    public function get_name()
    {
        return 't888-social-list';
    }

    /**
     * Get widget title.
     *
     * Retrieve the widget title.
     *
     * @return string Widget title.
     */
    public function get_title()
    {
        return __('Social', 'nebon');
    }

    /**
     * Get widget icon.
     *
     * Retrieve the widget icon.
     *
     * @return string Widget icon.
     */
    public function get_icon()
    {
        return 'fas fa-share-alt';
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
        return ['elementor-t888-social-list'];
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
        return ['elementor-t888-social-list'];
    }
    /**
     * Get widget categories.
     *
     * Retrieve the list of categories the widget belongs to.
     *
     * @return array Widget categories.
     */
    public function get_categories()
    {
        return ['t888-elements'];
    }

    /**
     * Register controls.
     *
     * Add input fields to allow the user to customize the widget settings.
     */
   protected function _register_controls()
{
    $this->start_controls_section(
        'section_social_icons',
        [
            'label' => __('Social Icons', 'nebon'),
        ]
    );

    $this->add_control(
        'title',
        [
            'label' => __('Title', 'nebon'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => __('Connect with us', 'nebon'),
        ]
    );

    $repeater = new \Elementor\Repeater();

    $repeater->add_control(
        'icon',
        [
            'label' => __('Icon', 'nebon'),
            'type' => \Elementor\Controls_Manager::ICONS,
            'label_block' => true,
            'default' => [
                'value' => 'las la-rainbow',
                'library' => 'lineawesome',
            ],
        ]
    );

    $repeater->add_control(
        'link',
        [
            'label' => __('Link', 'nebon'),
            'type' => \Elementor\Controls_Manager::URL,
            'placeholder' => __('https://your-link.com', 'nebon'),
            'show_external' => true,
            'default' => [
                'url' => '#',
                'is_external' => true,
            ],
        ]
    );

    $this->add_control(
        'icons',
        [
            'label' => __('Icons List', 'nebon'),
            'type' => \Elementor\Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls(),
            'default' => [
                [
                    'icon' => [
                        'value' => 'lab la-facebook-f',
                        'library' => 'lineawesome',
                    ],
                    'link' => [
                        'url' => '#',
                        'is_external' => true,
                    ],
                ],
                [
                    'icon' => [
                        'value' => 'lab la-instagram',
                        'library' => 'lineawesome',
                    ],
                    'link' => [
                        'url' => '#',
                        'is_external' => true,
                    ],
                ],
            ],
            'title_field' => '{{{ icon.value }}}',
        ]
    );
    $this->add_control(
        'style',
        [
            'label' => __('Style', 'nebon'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'style1',
            'options' => [
                'style1' => __('Style 1', 'nebon'),
                'style2' => __('Style 2', 'nebon'),
                'style3' => __('Style 3', 'nebon'),
            ],
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
        tech888f_get_template_elementor_widget('t888-social-list', $style, $settings, true);
    }
}
