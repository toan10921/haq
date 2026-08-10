<?php

namespace Elementor;

// if (!defined('ABSPATH')) {
//     exit;
// }

class T888_Phone extends T888_Widget_Base
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
        return 't888-phone';
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
        return __('Phone', 'nebon');
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
        return 'fas fa-phone';
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
        return ['elementor-t888-phone'];
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
        return ['elementor-t888-phone'];
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
            'section_content',
            [
                'label' => __('Settings', 'nebon'),
            ]
        );
        $this->add_control(
            'icon',
            [
                'label' => __('Icon', 'nebon'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'label_block' => true,
                'default' => [
                    'value' => 'las la-phone',
                    'library' => 'lineawesome',
                ],
            ]
        );
        $this->add_control(
            'title',
            [
                'label'   => __('Title', 'nebon'),
                'type'    => Controls_Manager::TEXT,
                'default' => __('Call Us Now', 'nebon'),
                'condition' => [
                    'style' => ['style1', 'style3'],
                ],
            ]
        );
        $this->add_control(
            'number',
            [
                'label'   => __('Number', 'nebon'),
                'type'    => Controls_Manager::TEXT,
                'default' => __('+923.5678.790', 'nebon'),
            ]
        );


        $this->add_control(
            'style',
            [
                'label' => __('Style', 'nebon'),
                'type' => Controls_Manager::SELECT,
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
        tech888f_get_template_elementor_widget('t888-phone', $style, $settings, true);
    }
}
