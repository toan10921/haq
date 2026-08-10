<?php
namespace Elementor;

class T888_Pet_Sale_Banner extends T888_Widget_Base
{
    public function get_name()
    {
        return 't888-pet-sale-banner';
    }

    public function get_title()
    {
        return __('Pet Sale Banner', 'nebon');
    }

    public function get_icon()
    {
        return 'eicon-banner';
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
            'layout_style',
            [
                'label' => __('Layout Style', 'nebon'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'style1',
                'options' => [
                    'style1' => __('Style 1 (Big Text -> Title -> Subtitle)', 'nebon'),
                    'style2' => __('Style 2 (Title -> Subtitle -> Big Text)', 'nebon'),
                ],
            ]
        );

        $this->add_control(
            'bg_image',
            [
                'label' => __('Background Image', 'nebon'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => '',
                ],
            ]
        );

        $this->add_control(
            'right_image',
            [
                'label' => __('Right Image (Pet)', 'nebon'),
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
                'default' => '#563e8c',
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
            'discount',
            [
                'label' => __('Big Text (e.g. UPTO 30% or $419.00)', 'nebon'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('UPTO 30%', 'nebon'),
            ]
        );

        $this->add_control(
            'subtitle',
            [
                'label' => __('Title (Serif font - e.g. PET PRODUCTS)', 'nebon'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('PET PRODUCTS', 'nebon'),
            ]
        );

        $this->add_control(
            'top_label',
            [
                'label' => __('Subtitle (e.g. EVERY FURRY)', 'nebon'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('EVERY FURRY', 'nebon'),
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

        $this->end_controls_section();

        // Style section for sizing and positioning
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
                    '{{WRAPPER}} .t888-pet-sale-banner__content' => 'max-width: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .t888-pet-sale-banner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'banner_min_height',
            [
                'label' => __('Min Height (px)', 'nebon'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 150,
                        'max' => 600,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .t888-pet-sale-banner' => 'min-height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Image position styling
        $this->start_controls_section(
            'image_style_section',
            [
                'label' => __('Image Positioning', 'nebon'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'image_width',
            [
                'label' => __('Image Width', 'nebon'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => ['min' => 0, 'max' => 800],
                    '%' => ['min' => 0, 'max' => 100],
                ],
                'selectors' => [
                    '{{WRAPPER}} .t888-pet-sale-banner__image' => 'width: {{SIZE}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->add_responsive_control(
            'image_right',
            [
                'label' => __('Distance from Right', 'nebon'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => ['min' => -100, 'max' => 200],
                ],
                'selectors' => [
                    '{{WRAPPER}} .t888-pet-sale-banner__image' => 'right: {{SIZE}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        parent::render();
        $settings = $this->get_element_settings();
        tech888f_get_template_elementor_widget('t888-pet-sale-banner', 't888-pet-sale-banner', $settings, true);
    }
}
