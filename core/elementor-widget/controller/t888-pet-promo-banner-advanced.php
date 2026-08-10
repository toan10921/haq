<?php
namespace Elementor;

class T888_Pet_Promo_Banner_Advanced extends T888_Widget_Base
{
    public function get_name()
    {
        return 't888-pet-promo-banner-advanced';
    }

    public function get_title()
    {
        return __('Pet Promo Banner Advanced', 'nebon');
    }

    public function get_icon()
    {
        return 'eicon-image-box';
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
            'bg_color',
            [
                'label' => __('Background Color', 'nebon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#8a7ba3',
            ]
        );

        $this->add_control(
            'top_subtitle',
            [
                'label' => __('Top Subtitle', 'nebon'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('CAT BETSELLERS', 'nebon'),
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => __('Title', 'nebon'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('ONLY: <sup>$</sup>1.99', 'nebon'),
            ]
        );

        $this->add_control(
            'button_text',
            [
                'label' => __('Button Text', 'nebon'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('SHOP NOW', 'nebon'),
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

        $this->add_control(
            'image_1',
            [
                'label' => __('Main Image', 'nebon'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->add_control(
            'image_2',
            [
                'label' => __('Secondary Image', 'nebon'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => '',
                ],
            ]
        );

        $this->add_control(
            'icon_class',
            [
                'label' => __('Icon Class', 'nebon'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'las la-seedling',
                'description' => __('Enter the Line Awesome class, e.g., las la-seedling', 'nebon'),
            ]
        );

        $this->end_controls_section();

        // ---------------------------
        // Content Style Tab
        // ---------------------------
        $this->start_controls_section(
            'content_style_section',
            [
                'label' => __('Content Layout', 'nebon'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'content_padding',
            [
                'label' => __('Banner Padding', 'nebon'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .t888-pet-promo-banner-advanced' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        
        $this->add_responsive_control(
            'banner_height',
            [
                'label' => __('Banner Min Height', 'nebon'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'vh'],
                'range' => [
                    'px' => ['min' => 100, 'max' => 1000],
                ],
                'selectors' => [
                    '{{WRAPPER}} .t888-pet-promo-banner-advanced' => 'min-height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'subtitle_heading',
            [
                'label' => __('Subtitle', 'nebon'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'subtitle_color',
            [
                'label' => __('Subtitle Color', 'nebon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} h5.promo-subtitle' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'subtitle_typography',
                'label' => __('Subtitle Typography', 'nebon'),
                'selector' => '{{WRAPPER}} h5.promo-subtitle',
            ]
        );

        $this->add_responsive_control(
            'subtitle_margin',
            [
                'label' => __('Subtitle Margin', 'nebon'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} h5.promo-subtitle' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'title_heading',
            [
                'label' => __('Title', 'nebon'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => __('Title Color', 'nebon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} p.promo-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => __('Title Typography', 'nebon'),
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
            ]
        );

        $this->add_control(
            'btn_heading',
            [
                'label' => __('Button', 'nebon'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'button_bg_color',
            [
                'label' => __('Button Background Color', 'nebon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .promo-button' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_text_color',
            [
                'label' => __('Button Text Color', 'nebon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .promo-button' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'button_typography',
                'label' => __('Button Typography', 'nebon'),
                'selector' => '{{WRAPPER}} .promo-button',
            ]
        );

        $this->add_responsive_control(
            'button_padding',
            [
                'label' => __('Button Padding', 'nebon'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .promo-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'button_margin',
            [
                'label' => __('Button Margin', 'nebon'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .promo-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // ---------------------------
        // Images Positioning Tab
        // ---------------------------
        $this->start_controls_section(
            'images_style_section',
            [
                'label' => __('Images Positioning', 'nebon'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        // IMAGE 1
        $this->add_control(
            'img1_heading',
            [
                'label' => __('Main Image Styling', 'nebon'),
                'type' => \Elementor\Controls_Manager::HEADING,
            ]
        );

        $this->add_responsive_control(
            'img1_width',
            [
                'label' => __('Width', 'nebon'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => ['min' => 0, 'max' => 800],
                    '%' => ['min' => 0, 'max' => 100],
                ],
                'selectors' => [
                    '{{WRAPPER}} .promo-img-1 img' => 'width: {{SIZE}}{{UNIT}}; height: auto;',
                ],
            ]
        );

        $this->add_responsive_control(
            'img1_top',
            [
                'label' => __('Top Position', 'nebon'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => ['px' => ['min' => -500, 'max' => 500], '%' => ['min' => -100, 'max' => 100]],
                'selectors' => ['{{WRAPPER}} .promo-img-1' => 'top: {{SIZE}}{{UNIT}}; bottom: auto;'],
            ]
        );

        $this->add_responsive_control(
            'img1_bottom',
            [
                'label' => __('Bottom Position', 'nebon'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => ['px' => ['min' => -500, 'max' => 500], '%' => ['min' => -100, 'max' => 100]],
                'selectors' => ['{{WRAPPER}} .promo-img-1' => 'bottom: {{SIZE}}{{UNIT}}; top: auto;'],
            ]
        );

        $this->add_responsive_control(
            'img1_left',
            [
                'label' => __('Left Position', 'nebon'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => ['px' => ['min' => -500, 'max' => 500], '%' => ['min' => -100, 'max' => 100]],
                'selectors' => ['{{WRAPPER}} .promo-img-1' => 'left: {{SIZE}}{{UNIT}}; right: auto;'],
            ]
        );

        $this->add_responsive_control(
            'img1_right',
            [
                'label' => __('Right Position', 'nebon'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => ['px' => ['min' => -500, 'max' => 500], '%' => ['min' => -100, 'max' => 100]],
                'selectors' => ['{{WRAPPER}} .promo-img-1' => 'right: {{SIZE}}{{UNIT}}; left: auto;'],
            ]
        );
        $this->add_control(
            'img1_zindex',
            [
                'label' => __('Z-Index', 'nebon'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 3,
                'selectors' => [
                    '{{WRAPPER}} .promo-img-1' => 'z-index: {{VALUE}};',
                ],
            ]
        );

        // IMAGE 2
        $this->add_control(
            'img2_heading',
            [
                'label' => __('Secondary Image Styling', 'nebon'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'img2_width',
            [
                'label' => __('Width', 'nebon'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => ['min' => 0, 'max' => 800],
                    '%' => ['min' => 0, 'max' => 100],
                ],
                'selectors' => [
                    '{{WRAPPER}} .promo-img-2 img' => 'width: {{SIZE}}{{UNIT}}; height: auto;',
                ],
            ]
        );

        $this->add_responsive_control(
            'img2_top',
            [
                'label' => __('Top Position', 'nebon'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => ['px' => ['min' => -500, 'max' => 500], '%' => ['min' => -100, 'max' => 100]],
                'selectors' => ['{{WRAPPER}} .promo-img-2' => 'top: {{SIZE}}{{UNIT}}; bottom: auto;'],
            ]
        );

        $this->add_responsive_control(
            'img2_bottom',
            [
                'label' => __('Bottom Position', 'nebon'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => ['px' => ['min' => -500, 'max' => 500], '%' => ['min' => -100, 'max' => 100]],
                'selectors' => ['{{WRAPPER}} .promo-img-2' => 'bottom: {{SIZE}}{{UNIT}}; top: auto;'],
            ]
        );

        $this->add_responsive_control(
            'img2_left',
            [
                'label' => __('Left Position', 'nebon'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => ['px' => ['min' => -500, 'max' => 500], '%' => ['min' => -100, 'max' => 100]],
                'selectors' => ['{{WRAPPER}} .promo-img-2' => 'left: {{SIZE}}{{UNIT}}; right: auto;'],
            ]
        );

        $this->add_responsive_control(
            'img2_right',
            [
                'label' => __('Right Position', 'nebon'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => ['px' => ['min' => -500, 'max' => 500], '%' => ['min' => -100, 'max' => 100]],
                'selectors' => ['{{WRAPPER}} .promo-img-2' => 'right: {{SIZE}}{{UNIT}}; left: auto;'],
            ]
        );
        $this->add_control(
            'img2_zindex',
            [
                'label' => __('Z-Index', 'nebon'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 4,
                'selectors' => [
                    '{{WRAPPER}} .promo-img-2' => 'z-index: {{VALUE}};',
                ],
            ]
        );

        // IMAGE 3
        $this->add_control(
            'img3_heading',
            [
                'label' => __('Icon Styling', 'nebon'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label' => __('Color', 'nebon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#a8d16f',
                'selectors' => [
                    '{{WRAPPER}} .promo-icon' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_size',
            [
                'label' => __('Size', 'nebon'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => ['min' => 10, 'max' => 200],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 60,
                ],
                'selectors' => [
                    '{{WRAPPER}} .promo-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'img3_top',
            [
                'label' => __('Top Position', 'nebon'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => ['px' => ['min' => -500, 'max' => 500], '%' => ['min' => -100, 'max' => 100]],
                'selectors' => ['{{WRAPPER}} .promo-icon' => 'top: {{SIZE}}{{UNIT}}; bottom: auto;'],
            ]
        );

        $this->add_responsive_control(
            'img3_bottom',
            [
                'label' => __('Bottom Position', 'nebon'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => ['px' => ['min' => -500, 'max' => 500], '%' => ['min' => -100, 'max' => 100]],
                'selectors' => ['{{WRAPPER}} .promo-icon' => 'bottom: {{SIZE}}{{UNIT}}; top: auto;'],
            ]
        );

        $this->add_responsive_control(
            'img3_left',
            [
                'label' => __('Left Position', 'nebon'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => ['px' => ['min' => -500, 'max' => 500], '%' => ['min' => -100, 'max' => 100]],
                'selectors' => ['{{WRAPPER}} .promo-icon' => 'left: {{SIZE}}{{UNIT}}; right: auto;'],
            ]
        );

        $this->add_responsive_control(
            'img3_right',
            [
                'label' => __('Right Position', 'nebon'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => ['px' => ['min' => -500, 'max' => 500], '%' => ['min' => -100, 'max' => 100]],
                'selectors' => ['{{WRAPPER}} .promo-icon' => 'right: {{SIZE}}{{UNIT}}; left: auto;'],
            ]
        );
        $this->add_control(
            'img3_zindex',
            [
                'label' => __('Z-Index', 'nebon'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 2,
                'selectors' => [
                    '{{WRAPPER}} .promo-icon' => 'z-index: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        parent::render();
        $settings = $this->get_element_settings();
        tech888f_get_template_elementor_widget('t888-pet-promo-banner-advanced', 't888-pet-promo-banner-advanced', $settings, true);
    }
}
