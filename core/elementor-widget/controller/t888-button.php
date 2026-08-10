<?php

namespace Elementor;

// if (!defined('ABSPATH')) {
//     exit;
// }

class T888_Button extends T888_Widget_Base
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
        return 't888-button';
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
        return __('Button', 'nebon');
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
        return 'fas fa-link';
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
        return ['elementor-t888-button'];
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
        return ['elementor-t888-button'];
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
        $this->start_controls_section('section_button', [
            'label' => __('Button Settings', 'nebon'),
        ]);

        $this->add_control('button_text', [
            'label' => __('Button Text', 'nebon'),
            'type' => Controls_Manager::TEXT,
            'default' => __('Click Me', 'nebon'),
            'placeholder' => __('Enter button text', 'nebon'),
        ]);

        $this->add_control('button_url', [
            'label' => __('Button URL', 'nebon'),
            'type' => Controls_Manager::URL,
            'placeholder' => __('https://your-link.com', 'nebon'),
            'default' => [
                'url' => '#',
                'is_external' => false,
                'nofollow' => false,
            ],
        ]);

        $this->add_control('style', [
            'label' => __('Button Style', 'nebon'),
            'type' => Controls_Manager::SELECT,
            'default' => 'style1',
            'options' => [
                'style1' => __('Style 1 - Default', 'nebon'),
                'style2' => __('Style 2 - Secondary', 'nebon'),
                // Add more styles as needed
            ]
        ]);

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
        tech888f_get_template_elementor_widget('t888-button', $style, $settings, true);
    }
}
