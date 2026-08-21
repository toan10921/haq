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
            'condition' => [
                'style!' => 'style3',
            ],
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
                'style3' => __('Style 3 - Get In Touch', 'nebon'),
            ]
        ]);

        $this->add_control('style3_button_text', [
            'label' => __('Button Text', 'nebon'),
            'type' => Controls_Manager::TEXT,
            'default' => __('Get In Touch', 'nebon'),
            'placeholder' => __('Enter button text', 'nebon'),
            'label_block' => true,
            'condition' => [
                'style' => 'style3',
            ],
        ]);

        $this->add_control('style3_icon', [
            'label' => __('Icon', 'nebon'),
            'type' => Controls_Manager::ICONS,
            'default' => [
                'value' => 'fas fa-arrow-right',
                'library' => 'fa-solid',
            ],
            'condition' => [
                'style' => 'style3',
            ],
        ]);

        $this->end_controls_section();

        $this->start_controls_section('section_style3_style', [
            'label' => __('Style 3 Button', 'nebon'),
            'tab' => Controls_Manager::TAB_STYLE,
            'condition' => [
                'style' => 'style3',
            ],
        ]);

        $this->add_responsive_control('style3_alignment', [
            'label' => __('Alignment', 'nebon'),
            'type' => Controls_Manager::CHOOSE,
            'options' => [
                'flex-start' => [
                    'title' => __('Left', 'nebon'),
                    'icon' => 'eicon-text-align-left',
                ],
                'center' => [
                    'title' => __('Center', 'nebon'),
                    'icon' => 'eicon-text-align-center',
                ],
                'flex-end' => [
                    'title' => __('Right', 'nebon'),
                    'icon' => 'eicon-text-align-right',
                ],
            ],
            'default' => 'flex-start',
            'selectors' => [
                '{{WRAPPER}} .t888-button-style3-wrap' => 'justify-content: {{VALUE}};',
            ],
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'style3_typography',
            'selector' => '{{WRAPPER}} .t888-button.style3',
        ]);

        $this->start_controls_tabs('style3_color_tabs');

        $this->start_controls_tab('style3_normal_tab', [
            'label' => __('Normal', 'nebon'),
        ]);

        $this->add_control('style3_text_color', [
            'label' => __('Text Color', 'nebon'),
            'type' => Controls_Manager::COLOR,
            'default' => '#ffffff',
            'selectors' => [
                '{{WRAPPER}} .t888-button.style3' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('style3_background_color', [
            'label' => __('Background Color', 'nebon'),
            'type' => Controls_Manager::COLOR,
            'default' => '#ea5501',
            'selectors' => [
                '{{WRAPPER}} .t888-button.style3' => '--t888-button-style3-primary: {{VALUE}}; background-color: {{VALUE}};',
            ],
        ]);

        $this->end_controls_tab();

        $this->start_controls_tab('style3_hover_tab', [
            'label' => __('Hover', 'nebon'),
        ]);

        $this->add_control('style3_hover_text_color', [
            'label' => __('Text Color', 'nebon'),
            'type' => Controls_Manager::COLOR,
            'default' => '#ffffff',
            'selectors' => [
                '{{WRAPPER}} .t888-button.style3:hover, {{WRAPPER}} .t888-button.style3:focus' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('style3_hover_background_color', [
            'label' => __('Background Color', 'nebon'),
            'type' => Controls_Manager::COLOR,
            'default' => '#ff5c00',
            'selectors' => [
                '{{WRAPPER}} .t888-button.style3' => '--t888-button-style3-hover: {{VALUE}};',
                '{{WRAPPER}} .t888-button.style3:hover, {{WRAPPER}} .t888-button.style3:focus' => 'background-color: {{VALUE}};',
            ],
        ]);

        $this->add_control('style3_hover_border_color', [
            'label' => __('Border Color', 'nebon'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .t888-button.style3:hover, {{WRAPPER}} .t888-button.style3:focus' => 'border-color: {{VALUE}};',
            ],
        ]);

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_group_control(Group_Control_Border::get_type(), [
            'name' => 'style3_border',
            'selector' => '{{WRAPPER}} .t888-button.style3',
            'separator' => 'before',
        ]);

        $this->add_control('style3_border_radius', [
            'label' => __('Border Radius', 'nebon'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%', 'em'],
            'default' => [
                'top' => 2,
                'right' => 2,
                'bottom' => 2,
                'left' => 2,
                'unit' => 'px',
                'isLinked' => true,
            ],
            'selectors' => [
                '{{WRAPPER}} .t888-button.style3' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->add_responsive_control('style3_width', [
            'label' => __('Width', 'nebon'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px', '%'],
            'range' => [
                'px' => ['min' => 80, 'max' => 800],
                '%' => ['min' => 1, 'max' => 100],
            ],
            'default' => [
                'unit' => 'px',
                'size' => 200,
            ],
            'selectors' => [
                '{{WRAPPER}} .t888-button.style3' => 'width: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->add_responsive_control('style3_height', [
            'label' => __('Minimum Height', 'nebon'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px', 'em'],
            'range' => [
                'px' => ['min' => 30, 'max' => 300],
                'em' => ['min' => 1, 'max' => 20],
            ],
            'default' => [
                'unit' => 'px',
                'size' => 58,
            ],
            'selectors' => [
                '{{WRAPPER}} .t888-button.style3' => 'min-height: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->add_responsive_control('style3_padding', [
            'label' => __('Padding', 'nebon'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', '%'],
            'selectors' => [
                '{{WRAPPER}} .t888-button.style3' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->add_responsive_control('style3_icon_spacing', [
            'label' => __('Icon Spacing', 'nebon'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => ['min' => 0, 'max' => 100],
            ],
            'default' => [
                'unit' => 'px',
                'size' => 14,
            ],
            'selectors' => [
                '{{WRAPPER}} .t888-button.style3 .t888-button__icon' => 'margin-left: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->add_responsive_control('style3_icon_size', [
            'label' => __('Icon Size', 'nebon'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => ['min' => 8, 'max' => 80],
            ],
            'default' => [
                'unit' => 'px',
                'size' => 16,
            ],
            'selectors' => [
                '{{WRAPPER}} .t888-button.style3 .t888-button__icon' => 'font-size: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .t888-button.style3 .t888-button__icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->add_group_control(Group_Control_Box_Shadow::get_type(), [
            'name' => 'style3_box_shadow',
            'selector' => '{{WRAPPER}} .t888-button.style3',
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
