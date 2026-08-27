<?php
namespace Elementor;

if (!defined('ABSPATH')) {
    exit;
}

class T888_Service_Tabs extends T888_Widget_Base
{
    public function get_name()
    {
        return 't888-service-tabs';
    }

    public function get_title()
    {
        return esc_html__('T888 Service Tabs', 'nebon');
    }

    public function get_icon()
    {
        return 'eicon-tabs';
    }

    public function get_categories()
    {
        return ['t888-elements'];
    }

    protected function _register_controls()
    {
        $this->start_controls_section(
            'section_services',
            ['label' => esc_html__('Tabs', 'nebon')]
        );

        $this->add_control('style', [
            'label' => esc_html__('Style', 'nebon'),
            'type' => Controls_Manager::SELECT,
            'default' => 'style1',
            'options' => [
                'style1' => esc_html__('Style 1 - Services', 'nebon'),
                'style2' => esc_html__('Style 2 - History', 'nebon'),
            ],
        ]);

        $repeater = new Repeater();

        $repeater->add_control('tab_title', [
            'label' => esc_html__('Tab Title', 'nebon'),
            'type' => Controls_Manager::TEXT,
            'default' => esc_html__('Industrial Construction', 'nebon'),
            'label_block' => true,
        ]);

        $repeater->add_control('image', [
            'label' => esc_html__('Image', 'nebon'),
            'type' => Controls_Manager::MEDIA,
            'default' => ['url' => Utils::get_placeholder_image_src()],
        ]);

        $repeater->add_control('content_title', [
            'label' => esc_html__('Content Title', 'nebon'),
            'type' => Controls_Manager::TEXTAREA,
            'default' => esc_html__('We solve worldwide industrial every problem', 'nebon'),
            'rows' => 3,
        ]);

        $repeater->add_control('description', [
            'label' => esc_html__('Description', 'nebon'),
            'type' => Controls_Manager::TEXTAREA,
            'default' => esc_html__('Add a short description for this service.', 'nebon'),
            'rows' => 4,
        ]);

        $repeater->add_control('feature_list', [
            'label' => esc_html__('Feature List', 'nebon'),
            'description' => esc_html__('Enter one feature per line.', 'nebon'),
            'type' => Controls_Manager::TEXTAREA,
            'default' => "Manufacturing Solutions\nResearch and Development\nVehicle manufacturing",
            'rows' => 5,
        ]);

        $repeater->add_control('link_text', [
            'label' => esc_html__('Link Text', 'nebon'),
            'type' => Controls_Manager::TEXT,
            'default' => esc_html__('Xem thêm', 'nebon'),
        ]);

        $repeater->add_control('link', [
            'label' => esc_html__('Link', 'nebon'),
            'type' => Controls_Manager::URL,
            'placeholder' => 'https://example.com',
            'default' => ['url' => '#'],
        ]);

        $default_service = [
            'image' => ['url' => Utils::get_placeholder_image_src()],
            'content_title' => esc_html__('We solve worldwide industrial every problem', 'nebon'),
            'description' => esc_html__('The industry standard dummy text has supported industrial businesses for generations.', 'nebon'),
            'feature_list' => "Manufacturing Solutions\nResearch and Development\nVehicle manufacturing",
            'link_text' => esc_html__('Xem thêm', 'nebon'),
            'link' => ['url' => '#'],
        ];

        $this->add_control('services', [
            'label' => esc_html__('Tab Items', 'nebon'),
            'type' => Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls(),
            'default' => [
                array_merge($default_service, ['tab_title' => esc_html__('Industrial Construction', 'nebon')]),
                array_merge($default_service, ['tab_title' => esc_html__('High regulation industry', 'nebon')]),
                array_merge($default_service, ['tab_title' => esc_html__('Bridge Construction', 'nebon')]),
                array_merge($default_service, ['tab_title' => esc_html__('Oil & Gas Energy', 'nebon')]),
                array_merge($default_service, ['tab_title' => esc_html__('Mechanical Engineering', 'nebon')]),
                array_merge($default_service, ['tab_title' => esc_html__('Automation Industry', 'nebon')]),
            ],
            'title_field' => '{{{ tab_title }}}',
        ]);

        $this->end_controls_section();

        $this->start_controls_section('section_layout_style', [
            'label' => esc_html__('Layout', 'nebon'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_responsive_control('column_gap', [
            'label' => esc_html__('Column Gap', 'nebon'),
            'type' => Controls_Manager::SLIDER,
            'range' => ['px' => ['min' => 0, 'max' => 120]],
            'default' => ['size' => 60, 'unit' => 'px'],
            'selectors' => [
                '{{WRAPPER}} .t888-service-tabs' => 'column-gap: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .t888-service-tabs__panel' => 'column-gap: {{SIZE}}{{UNIT}};',
            ],
            'condition' => ['style' => 'style1'],
        ]);

        $this->add_responsive_control('nav_width', [
            'label' => esc_html__('Navigation Width', 'nebon'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px', '%'],
            'range' => [
                'px' => ['min' => 180, 'max' => 420],
                '%' => ['min' => 10, 'max' => 50],
            ],
            'default' => ['size' => 300, 'unit' => 'px'],
            'selectors' => [
                '{{WRAPPER}} .t888-service-tabs' => 'grid-template-columns: {{SIZE}}{{UNIT}} minmax(0, 1fr);',
            ],
            'condition' => ['style' => 'style1'],
        ]);

        $this->add_responsive_control('image_height', [
            'label' => esc_html__('Image Height', 'nebon'),
            'type' => Controls_Manager::SLIDER,
            'range' => ['px' => ['min' => 220, 'max' => 700]],
            'default' => ['size' => 405, 'unit' => 'px'],
            'selectors' => [
                '{{WRAPPER}} .t888-service-tabs__image' => 'height: {{SIZE}}{{UNIT}};',
            ],
            'condition' => ['style' => 'style1'],
        ]);

        $this->end_controls_section();

        $this->start_controls_section('section_navigation_style', [
            'label' => esc_html__('Navigation', 'nebon'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('nav_text_color', [
            'label' => esc_html__('Text Color', 'nebon'),
            'type' => Controls_Manager::COLOR,
            'default' => '#4d4d4d',
            'selectors' => [
                '{{WRAPPER}} .t888-service-tabs__tab' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('nav_background', [
            'label' => esc_html__('Background', 'nebon'),
            'type' => Controls_Manager::COLOR,
            'default' => '#ffffff',
            'selectors' => [
                '{{WRAPPER}} .t888-service-tabs__tab' => 'background-color: {{VALUE}};',
            ],
        ]);

        $this->add_control('nav_active_color', [
            'label' => esc_html__('Active Text Color', 'nebon'),
            'type' => Controls_Manager::COLOR,
            'default' => '#ffffff',
            'selectors' => [
                '{{WRAPPER}} .t888-service-tabs__tab.is-active' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('nav_active_background', [
            'label' => esc_html__('Active Background', 'nebon'),
            'type' => Controls_Manager::COLOR,
            'default' => '#f45100',
            'selectors' => [
                '{{WRAPPER}} .t888-service-tabs__tab.is-active' => 'background-color: {{VALUE}};',
            ],
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'nav_typography',
            'selector' => '{{WRAPPER}} .t888-service-tabs__tab',
        ]);

        $this->end_controls_section();

        $this->start_controls_section('section_content_style', [
            'label' => esc_html__('Content', 'nebon'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('accent_color', [
            'label' => esc_html__('Accent Color', 'nebon'),
            'type' => Controls_Manager::COLOR,
            'default' => '#f45100',
            'selectors' => [
                '{{WRAPPER}} .t888-service-tabs-section--style2' => '--t888-history-accent: {{VALUE}};',
                '{{WRAPPER}} .t888-service-tabs__check' => 'color: {{VALUE}}; border-color: {{VALUE}};',
                '{{WRAPPER}} .t888-service-tabs__link:hover' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('content_title_color', [
            'label' => esc_html__('Title Color', 'nebon'),
            'type' => Controls_Manager::COLOR,
            'default' => '#151515',
            'selectors' => [
                '{{WRAPPER}} .t888-service-tabs__title' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'content_title_typography',
            'selector' => '{{WRAPPER}} .t888-service-tabs__title',
        ]);

        $this->add_control('description_color', [
            'label' => esc_html__('Description Color', 'nebon'),
            'type' => Controls_Manager::COLOR,
            'default' => '#777777',
            'selectors' => [
                '{{WRAPPER}} .t888-service-tabs__description' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'description_typography',
            'selector' => '{{WRAPPER}} .t888-service-tabs__description',
        ]);

        $this->end_controls_section();
    }

    protected function render()
    {
        parent::render();
        $settings = $this->get_settings_for_display();
        $settings['style'] = in_array(($settings['style'] ?? 'style1'), ['style1', 'style2'], true)
            ? $settings['style']
            : 'style1';
        $settings['widget_id'] = $this->get_id();
        tech888f_get_template_elementor_widget('t888-service-tabs', '', $settings, true);
    }
}
