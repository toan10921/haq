<?php

namespace Elementor;

class T888_Pet_Hotdeals_Countdown extends T888_Widget_Base
{
    public function get_name()
    {
        return 't888-pet-hotdeals-countdown';
    }


    
    public function get_title()
    {
        return __('Pet Hot Deals Countdown', 'nebon');
    }

    public function get_icon()
    {
        return 'eicon-countdown';
    }

    public function get_categories()
    {
        return ['t888-elements'];
    }

    public function get_script_depends()
    {
        return ['elementor-t888-pet-hotdeals-countdown'];
    }

    public function get_style_depends()
    {
        return ['elementor-t888-pet-hotdeals-countdown'];
    }

    protected function _register_controls()
    {
        $this->start_controls_section(
            'section_content',
            [
                'label' => __('Content', 'nebon'),
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => __('Title', 'nebon'),
                'type' => Controls_Manager::TEXT,
                'default' => __('HOT DEALS:', 'nebon'),
            ]
        );

        $this->add_control(
            'sale_deadline',
            [
                'label' => __('Sale Deadline', 'nebon'),
                'type' => Controls_Manager::DATE_TIME,
                'default' => '',
                'description' => __('Countdown timer ends at this time.', 'nebon'),
            ]
        );

        $this->add_control(
            'auto_loop',
            [
                'label' => __('Auto Loop', 'nebon'),
                'type' => Controls_Manager::SWITCHER,
                'default' => '',
                'description' => __('Automatically restart the countdown when it ends.', 'nebon'),
            ]
        );

        $this->add_control(
            'auto_loop_days',
            [
                'label' => __('Auto Loop Duration (Days)', 'nebon'),
                'type' => Controls_Manager::NUMBER,
                'default' => 5,
                'condition' => [
                    'auto_loop' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'auto_loop_hours',
            [
                'label' => __('Auto Loop Duration (Hours)', 'nebon'),
                'type' => Controls_Manager::NUMBER,
                'default' => 0,
                'condition' => [
                    'auto_loop' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_title',
            [
                'label' => __('Title', 'nebon'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => __('Color', 'nebon'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .t888-hotdeals-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .t888-hotdeals-title',
            ]
        );

        $this->add_responsive_control(
            'title_font_size',
            [
                'label' => __('Font Size', 'nebon'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => ['min' => 14, 'max' => 80],
                ],
                'selectors' => [
                    '{{WRAPPER}} .t888-hotdeals-title' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'title_line_height',
            [
                'label' => __('Line Height', 'nebon'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => ['min' => 14, 'max' => 90],
                ],
                'selectors' => [
                    '{{WRAPPER}} .t888-hotdeals-title' => 'line-height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_box',
            [
                'label' => __('Countdown Boxes', 'nebon'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'box_bg',
            [
                'label' => __('Background', 'nebon'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .t888-hotdeals-box' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'box_text_color',
            [
                'label' => __('Text Color', 'nebon'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .t888-hotdeals-box' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'box_gap',
            [
                'label' => __('Gap', 'nebon'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => ['min' => 0, 'max' => 30],
                ],
                'selectors' => [
                    '{{WRAPPER}} .t888-hotdeals-countdown' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'box_width',
            [
                'label' => __('Box Width', 'nebon'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => ['min' => 40, 'max' => 180],
                ],
                'selectors' => [
                    '{{WRAPPER}} .t888-hotdeals-box' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'box_height',
            [
                'label' => __('Box Height', 'nebon'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => ['min' => 40, 'max' => 180],
                ],
                'selectors' => [
                    '{{WRAPPER}} .t888-hotdeals-box' => 'min-height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'box_padding',
            [
                'label' => __('Box Padding', 'nebon'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .t888-hotdeals-box' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'number_typography',
                'selector' => '{{WRAPPER}} .t888-hotdeals-number',
            ]
        );

        $this->add_responsive_control(
            'number_font_size',
            [
                'label' => __('Number Font Size', 'nebon'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => ['min' => 10, 'max' => 72],
                ],
                'selectors' => [
                    '{{WRAPPER}} .t888-hotdeals-number' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'label_typography',
                'selector' => '{{WRAPPER}} .t888-hotdeals-label',
            ]
        );

        $this->add_responsive_control(
            'label_font_size',
            [
                'label' => __('Label Font Size', 'nebon'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => ['min' => 8, 'max' => 40],
                ],
                'selectors' => [
                    '{{WRAPPER}} .t888-hotdeals-label' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        parent::render();
        $settings = $this->get_element_settings();
        tech888f_get_template_elementor_widget('t888-pet-hotdeals-countdown', false, $settings, true);
    }
}

