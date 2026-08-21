<?php
namespace Elementor;

if (!defined('ABSPATH')) {
    exit;
}

class T888_Service_Features extends T888_Widget_Base
{
    public function get_name()
    {
        return 't888-service-features';
    }

    public function get_title()
    {
        return esc_html__('Service Features', 'nebon');
    }

    public function get_icon()
    {
        return 'eicon-info-box';
    }

    public function get_categories()
    {
        return ['t888-elements'];
    }

    public function enque_styles()
    {
        parent::enque_styles();

        $font_awesome_path = get_template_directory() . '/assets/css/libs/font-awesome.min.css';

        if (file_exists($font_awesome_path)) {
            wp_enqueue_style(
                't888-service-features-font-awesome',
                get_template_directory_uri() . '/assets/css/libs/font-awesome.min.css',
                [],
                filemtime($font_awesome_path),
                'all'
            );
        }
    }

    protected function _register_controls()
    {
        $this->start_controls_section(
            'section_content',
            ['label' => esc_html__('Feature Cards', 'nebon')]
        );

        $this->add_control(
            'layout_style',
            [
                'label' => esc_html__('Style', 'nebon'),
                'type' => Controls_Manager::SELECT,
                'default' => 'style1',
                'options' => [
                    'style1' => esc_html__('Style 1', 'nebon'),
                    'style2' => esc_html__('Style 2 - Process Steps', 'nebon'),
                ],
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'title',
            [
                'label' => esc_html__('Title', 'nebon'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Industrial Ideas', 'nebon'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'description',
            [
                'label' => esc_html__('Description', 'nebon'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => esc_html__('Add a short description for this service or feature.', 'nebon'),
            ]
        );

        $repeater->add_control(
            'icon_type',
            [
                'label' => esc_html__('Icon Type', 'nebon'),
                'type' => Controls_Manager::SELECT,
                'default' => 'icon',
                'options' => [
                    'icon' => esc_html__('Icon', 'nebon'),
                    'image' => esc_html__('Image', 'nebon'),
                ],
            ]
        );

        $repeater->add_control(
            'icon',
            [
                'label' => esc_html__('Icon', 'nebon'),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-lightbulb',
                    'library' => 'solid',
                ],
                'condition' => ['icon_type' => 'icon'],
            ]
        );

        $repeater->add_control(
            'image',
            [
                'label' => esc_html__('Image', 'nebon'),
                'type' => Controls_Manager::MEDIA,
                'condition' => ['icon_type' => 'image'],
            ]
        );

        $this->add_control(
            'items',
            [
                'label' => esc_html__('Feature Items', 'nebon'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'title' => esc_html__('Industrial Ideas', 'nebon'),
                        'description' => esc_html__('Creative industrial solutions developed for modern production needs.', 'nebon'),
                        'icon' => ['value' => 'fas fa-lightbulb', 'library' => 'solid'],
                    ],
                    [
                        'title' => esc_html__('Expert Engineers', 'nebon'),
                        'description' => esc_html__('Experienced engineers provide reliable advice for every project.', 'nebon'),
                        'icon' => ['value' => 'fas fa-user-cog', 'library' => 'solid'],
                    ],
                    [
                        'title' => esc_html__('Modern Equipment', 'nebon'),
                        'description' => esc_html__('Modern equipment delivers consistent and efficient performance.', 'nebon'),
                        'icon' => ['value' => 'fas fa-robot', 'library' => 'solid'],
                    ],
                    [
                        'title' => esc_html__('Project Support', 'nebon'),
                        'description' => esc_html__('Responsive support keeps your project moving from start to finish.', 'nebon'),
                        'icon' => ['value' => 'fas fa-headset', 'library' => 'solid'],
                    ],
                ],
                'title_field' => '{{{ title }}}',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_card_style',
            [
                'label' => esc_html__('Cards', 'nebon'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'card_background',
            [
                'label' => esc_html__('Background', 'nebon'),
                'type' => Controls_Manager::COLOR,
                'default' => '#f5f5f5',
                'selectors' => [
                    '{{WRAPPER}} .t888-service-features--style1 .t888-service-feature-card' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'card_hover_background',
            [
                'label' => esc_html__('Hover Background', 'nebon'),
                'type' => Controls_Manager::COLOR,
                'default' => '#f45100',
                'selectors' => [
                    '{{WRAPPER}} .t888-service-features--style1 .t888-service-feature-card:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'card_gap',
            [
                'label' => esc_html__('Gap', 'nebon'),
                'type' => Controls_Manager::SLIDER,
                'range' => ['px' => ['min' => 0, 'max' => 80]],
                'default' => ['size' => 30, 'unit' => 'px'],
                'selectors' => [
                    '{{WRAPPER}} .t888-service-features--style1 .t888-service-features-grid' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'card_min_height',
            [
                'label' => esc_html__('Minimum Height', 'nebon'),
                'type' => Controls_Manager::SLIDER,
                'range' => ['px' => ['min' => 180, 'max' => 600]],
                'default' => ['size' => 320, 'unit' => 'px'],
                'selectors' => [
                    '{{WRAPPER}} .t888-service-features--style1 .t888-service-feature-card' => 'min-height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'card_padding',
            [
                'label' => esc_html__('Padding', 'nebon'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .t888-service-features--style1 .t888-service-feature-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_content_style',
            [
                'label' => esc_html__('Content', 'nebon'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label' => esc_html__('Icon Color', 'nebon'),
                'type' => Controls_Manager::COLOR,
                'default' => '#f45100',
                'selectors' => [
                    '{{WRAPPER}} .t888-service-feature-icon' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_size',
            [
                'label' => esc_html__('Icon Size', 'nebon'),
                'type' => Controls_Manager::SLIDER,
                'range' => ['px' => ['min' => 20, 'max' => 120]],
                'default' => ['size' => 56, 'unit' => 'px'],
                'selectors' => [
                    '{{WRAPPER}} .t888-service-feature-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .t888-service-feature-icon svg, {{WRAPPER}} .t888-service-feature-image' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__('Title Color', 'nebon'),
                'type' => Controls_Manager::COLOR,
                'default' => '#090909',
                'selectors' => [
                    '{{WRAPPER}} .t888-service-feature-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .t888-service-feature-title',
            ]
        );

        $this->add_control(
            'description_color',
            [
                'label' => esc_html__('Description Color', 'nebon'),
                'type' => Controls_Manager::COLOR,
                'default' => '#555555',
                'selectors' => [
                    '{{WRAPPER}} .t888-service-feature-description' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'description_typography',
                'selector' => '{{WRAPPER}} .t888-service-feature-description',
            ]
        );

        $this->add_control(
            'hover_text_color',
            [
                'label' => esc_html__('Hover Text & Icon Color', 'nebon'),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .t888-service-features--style1 .t888-service-feature-card:hover .t888-service-feature-icon, {{WRAPPER}} .t888-service-features--style1 .t888-service-feature-card:hover .t888-service-feature-title, {{WRAPPER}} .t888-service-features--style1 .t888-service-feature-card:hover .t888-service-feature-description' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .t888-service-features--style1 .t888-service-feature-card:hover .t888-service-feature-icon svg' => 'color: {{VALUE}}; fill: {{VALUE}};',
                    '{{WRAPPER}} .t888-service-features--style1 .t888-service-feature-card:hover .t888-service-feature-icon svg [stroke]:not([stroke="none"])' => 'stroke: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        parent::render();
        $settings = $this->get_settings_for_display();
        tech888f_get_template_elementor_widget('t888-service-features', '', $settings, true);
    }
}
