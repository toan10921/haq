<?php
namespace Elementor;

class T888_Pet_Promo_Banner extends T888_Widget_Base
{
    public function get_name()
    {
        return 't888-pet-promo-banner';
    }

    public function get_title()
    {
        return __('Pet Promo Banner', 'nebon');
    }
    public function get_icon()
    {
        return 'eicon-image';
    }

    public function get_categories()
    {
        return ['t888-elements'];
    }

    protected function _register_controls()
    {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Content', 'nebon'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'bg_image',
            [
                'label' => __('Background Image', 'nebon'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->add_control(
            'right_image',
            [
                'label' => __('Right Image', 'nebon'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => '',
                ],
            ]
        );

        $this->add_control(
            'bg_color',
            [
                'label' => __('Background Color', 'nebon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#a18374',
            ]
        );

        $this->add_control(
            'text_color',
            [
                'label' => __('Text Color', 'nebon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
            ]
        );

        $this->add_control(
            'button_bg_color',
            [
                'label' => __('Button Background Color', 'nebon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
            ]
        );

        $this->add_control(
            'button_text_color',
            [
                'label' => __('Button Text Color', 'nebon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#000000',
            ]
        );

        $this->add_control(
            'top_subtitle',
            [
                'label' => __('Top Subtitle', 'nebon'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('FOOD FOR CAT', 'nebon'),
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => __('Title', 'nebon'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('THE BEST FOOD FOR YOUR PET', 'nebon'),
            ]
        );

        $this->add_control(
            'big_text',
            [
                'label' => __('Big Text', 'nebon'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => __('100%', 'nebon'),
            ]
        );

        $this->add_control(
            'button_text',
            [
                'label' => __('Button Text', 'nebon'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('ORGANIC', 'nebon'),
            ]
        );

        $this->add_control(
            'button_link',
            [
                'label' => __('Button Link', 'nebon'),
                'type' => \Elementor\Controls_Manager::URL,
                'default' => [
                    'url' => '#',
                    'is_external' => false,
                    'nofollow' => false,
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'content_style_section',
            [
                'label' => __('Content Layout', 'nebon'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'content_max_width',
            [
                'label' => __('Content Max Width (%)', 'nebon'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['%'],
                'range' => [
                    '%' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .promo-content' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'content_padding',
            [
                'label' => __('Banner Padding', 'nebon'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .t888-pet-promo-banner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Right Image Position Section...
        $this->start_controls_section(
            'right_image_style_section',
            [
                'label' => __('Right Image Styling', 'nebon'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'right_image_width',
            [
                'label' => __('Image Width', 'nebon'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => ['min' => 0, 'max' => 800],
                    '%' => ['min' => 0, 'max' => 100],
                ],
                'selectors' => [
                    '{{WRAPPER}} .promo-right-image img' => 'width: {{SIZE}}{{UNIT}} !important; height: auto !important; max-height: none !important;',
                ],
            ]
        );

        $this->add_responsive_control(
            'right_image_top',
            [
                'label' => __('Distance from TOP', 'nebon'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => ['min' => -200, 'max' => 500],
                    '%' => ['min' => -50, 'max' => 100],
                ],
                'selectors' => [
                    '{{WRAPPER}} .promo-right-image' => 'top: {{SIZE}}{{UNIT}} !important; bottom: auto !important;',
                ],
            ]
        );

        $this->add_responsive_control(
            'right_image_bottom',
            [
                'label' => __('Distance from BOTTOM', 'nebon'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => ['min' => -200, 'max' => 500],
                    '%' => ['min' => -50, 'max' => 100],
                ],
                'selectors' => [
                    '{{WRAPPER}} .promo-right-image' => 'bottom: {{SIZE}}{{UNIT}} !important; top: auto !important;',
                ],
            ]
        );

        $this->add_responsive_control(
            'right_image_right',
            [
                'label' => __('Distance from RIGHT', 'nebon'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vw'],
                'range' => [
                    'px' => ['min' => -200, 'max' => 500],
                    '%' => ['min' => -50, 'max' => 100],
                ],
                'selectors' => [
                    '{{WRAPPER}} .promo-right-image' => 'right: {{SIZE}}{{UNIT}} !important; left: auto !important;',
                ],
            ]
        );

        $this->add_responsive_control(
            'right_image_left',
            [
                'label' => __('Distance from LEFT', 'nebon'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vw'],
                'range' => [
                    'px' => ['min' => -200, 'max' => 500],
                    '%' => ['min' => -50, 'max' => 100],
                ],
                'selectors' => [
                    '{{WRAPPER}} .promo-right-image' => 'left: {{SIZE}}{{UNIT}} !important; right: auto !important;',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'typography_section',
            [
                'label' => __('Typography', 'nebon'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'subtitle_typography',
                'label' => __('Top Subtitle', 'nebon'),
                'selector' => '{{WRAPPER}} h5.promo-subtitle',
            ]
        );

        $this->add_responsive_control(
            'subtitle_margin',
            [
                'label' => __('Top Subtitle Margin', 'nebon'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} h5.promo-subtitle' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'after',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => __('Title', 'nebon'),
                'selector' => '{{WRAPPER}} p.promo-title',
            ]
        );

        $this->add_responsive_control(
            'title_margin',
            [
                'label' => __('Title Margin', 'nebon'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} p.promo-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'after',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'big_text_typography',
                'label' => __('Big Text', 'nebon'),
                'selector' => '{{WRAPPER}} h2.promo-big-text',
            ]
        );

        $this->add_responsive_control(
            'big_text_margin',
            [
                'label' => __('Big Text Margin', 'nebon'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} h2.promo-big-text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'after',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'button_typography',
                'label' => __('Button Text', 'nebon'),
                'selector' => '{{WRAPPER}} .promo-button',
            ]
        );

        $this->add_responsive_control(
            'button_margin',
            [
                'label' => __('Button Margin', 'nebon'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .promo-button-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'after',
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        parent::render();
        $settings = $this->get_element_settings();
        tech888f_get_template_elementor_widget('t888-pet-promo-banner', 't888-pet-promo-banner', $settings, true);
    }
}
