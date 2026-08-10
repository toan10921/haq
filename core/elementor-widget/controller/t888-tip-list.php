<?php

namespace Elementor;

// if (!defined('ABSPATH')) {
//     exit;
// }

class T888_Tip_List extends T888_Widget_Base
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
        return 't888-tip-list';
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
        return __('Tip List', 'nebon');
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
        return 'fas fa-lightbulb';
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
        return ['elementor-t888-tip-list'];
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
        return ['elementor-t888-tip-list'];
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
                'label' => __('Tips List', 'nebon'),
            ]
        );

        // Repeater list
        $repeater = new Repeater();

        $repeater->add_control(
            'tip_title',
            [
                'label' => __('Tip Title (bold)', 'nebon'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Title here', 'nebon'),
            ]
        );

        $repeater->add_control(
            'tip_description',
            [
                'label' => __('Tip Description', 'nebon'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Description here', 'nebon'),
            ]
        );

        $this->add_control(
            'tips_list',
            [
                'label' => __('Tips', 'nebon'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [],
                'title_field' => '{{{ tip_title }}}',
            ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
            'section_number_style',
            [
                'label' => __('Number Style', 'nebon'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'number_style',
            [
                'label' => __('Style', 'nebon'),
                'type' => Controls_Manager::SELECT,
                'default' => 'bordered',
                'options' => [
                    'bordered' => __('Bordered Circle', 'nebon'),
                    'filled'   => __('Filled Background', 'nebon'),
                ],
            ]
        );

        $this->add_control(
            'number_bg_color',
            [
                'label' => __('Background Color', 'nebon'),
                'type' => Controls_Manager::COLOR,
                'default' => '#b88166',
                'selectors' => [
                    '{{WRAPPER}} .t888-tip-item .tip-number' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'number_style' => 'filled',
                ],
            ]
        );

        $this->add_control(
            'number_border_color',
            [
                'label' => __('Border Color', 'nebon'),
                'type' => Controls_Manager::COLOR,
                'default' => '#e3e3e3',
                'selectors' => [
                    '{{WRAPPER}} .t888-tip-item .tip-number' => 'border-color: {{VALUE}};',
                ],
                'condition' => [
                    'number_style' => 'bordered',
                ],
            ]
        );

        $this->add_control(
            'number_text_color_filled',
            [
                'label'     => __('Text Color (Filled)', 'nebon'),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'condition' => [
                    'number_style' => 'filled',
                ],
                'selectors' => [
                    '{{WRAPPER}} .t888-tip-item.style-filled .tip-number' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Màu chữ khi dùng style bordered
        $this->add_control(
            'number_text_color_bordered',
            [
                'label'     => __('Text Color (Bordered)', 'nebon'),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#000000',
                'condition' => [
                    'number_style' => 'bordered',
                ],
                'selectors' => [
                    '{{WRAPPER}} .t888-tip-item.style-bordered .tip-number' => 'color: {{VALUE}};',
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
        tech888f_get_template_elementor_widget('t888-tip-list', $style, $settings, true);
    }
}
