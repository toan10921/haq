<?php
namespace Elementor;

class T888_Top_Brands_Grid extends T888_Widget_Base
{
    public function get_name()
    {
        return 't888-top-brands-grid';
    }

    public function get_title()
    {
        return __('Top Brands Grid', 'nebon');
    }

    public function get_icon()
    {
        return 'eicon-gallery-grid';
    }

    public function get_categories()
    {
        return ['t888-elements'];
    }

    public function get_style_depends()
    {
        return ['elementor-t888-top-brands-grid'];
    }

    public function get_script_depends()
    {
        return [];
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
                'default' => __('TOP BRANDS', 'nebon'),
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'brand_logo',
            [
                'label' => __('Brand Logo', 'nebon'),
                'type' => Controls_Manager::MEDIA,
            ]
        );

        $repeater->add_control(
            'brand_name',
            [
                'label' => __('Brand Name', 'nebon'),
                'type' => Controls_Manager::TEXT,
                'description' => __('Used for image alt text.', 'nebon'),
                'default' => __('Brand', 'nebon'),
            ]
        );

        $repeater->add_control(
            'brand_link',
            [
                'label' => __('Brand Link', 'nebon'),
                'type' => Controls_Manager::URL,
                'placeholder' => __('https://your-link.com', 'nebon'),
            ]
        );

        $this->add_control(
            'brands',
            [
                'label' => __('Brands', 'nebon'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'title_field' => '{{{ brand_name }}}',
                'default' => array_fill(
                    0,
                    12,
                    [
                        'brand_name' => __('Brand', 'nebon'),
                    ]
                ),
            ]
        );

        $this->add_responsive_control(
            'columns',
            [
                'label' => __('Columns', 'nebon'),
                'type' => Controls_Manager::SELECT,
                'default' => '6',
                'tablet_default' => '3',
                'mobile_default' => '2',
                'options' => [
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
                    '6' => '6',
                ],
                'selectors' => [
                    '{{WRAPPER}} .t888-top-brands-grid__grid' => '--t888-top-brands-grid-columns: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_box',
            [
                'label' => __('Box', 'nebon'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'section_bg_color',
            [
                'label' => __('Background Color', 'nebon'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .t888-top-brands-grid' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'header_bg_color',
            [
                'label' => __('Header Background', 'nebon'),
                'type' => Controls_Manager::COLOR,
                'default' => '#fdbb23',
                'selectors' => [
                    '{{WRAPPER}} .t888-top-brands-grid__header' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'header_padding',
            [
                'label' => __('Header Padding', 'nebon'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .t888-top-brands-grid__header' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'grid_border_color',
            [
                'label' => __('Grid Border Color', 'nebon'),
                'type' => Controls_Manager::COLOR,
                'default' => '#e3e3e3',
                'selectors' => [
                    '{{WRAPPER}} .t888-top-brands-grid__grid' => '--t888-top-brands-grid-border: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'item_bg_color',
            [
                'label' => __('Item Background', 'nebon'),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .t888-top-brands-grid__item' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'item_min_height',
            [
                'label' => __('Item Min Height', 'nebon'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => ['min' => 80, 'max' => 300],
                ],
                'selectors' => [
                    '{{WRAPPER}} .t888-top-brands-grid__item' => 'min-height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'item_padding',
            [
                'label' => __('Item Padding', 'nebon'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .t888-top-brands-grid__item-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .t888-top-brands-grid__title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .t888-top-brands-grid__title',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_logo',
            [
                'label' => __('Logo', 'nebon'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'logo_max_width',
            [
                'label' => __('Max Width', 'nebon'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => ['min' => 40, 'max' => 280],
                    '%' => ['min' => 20, 'max' => 100],
                ],
                'selectors' => [
                    '{{WRAPPER}} .t888-top-brands-grid__logo img' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'logo_opacity',
            [
                'label' => __('Opacity', 'nebon'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    '%' => ['min' => 10, 'max' => 100],
                ],
                'size_units' => ['%'],
                'selectors' => [
                    '{{WRAPPER}} .t888-top-brands-grid__logo img' => 'opacity: calc({{SIZE}} / 100);',
                ],
            ]
        );

        $this->add_control(
            'logo_opacity_hover',
            [
                'label' => __('Hover Opacity', 'nebon'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    '%' => ['min' => 10, 'max' => 100],
                ],
                'size_units' => ['%'],
                'selectors' => [
                    '{{WRAPPER}} .t888-top-brands-grid__item:hover .t888-top-brands-grid__logo img' => 'opacity: calc({{SIZE}} / 100);',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        parent::render();
        $settings = $this->get_element_settings();
        tech888f_get_template_elementor_widget('t888-top-brands-grid', 't888-top-brands-grid', $settings, true);
    }
}
