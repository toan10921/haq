<?php

namespace Elementor;

// if (!defined('ABSPATH')) {
//     exit;
// }

class T888_Title extends T888_Widget_Base
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
        return 't888-title';
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
        return __('Title', 'nebon');
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
        return 'fas fa-heading';
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
        return ['elementor-t888-title'];
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
        return ['elementor-t888-title'];
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
            'title',
            [
                'label'   => __('Title', 'nebon'),
                'type'    => Controls_Manager::TEXT,
                'default' => __('Heading', 'nebon'),
            ]
        );

        $this->add_control(
            'html_tag',
            [
                'label' => __('HTML Tag', 'nebon'),
                'type' => Controls_Manager::SELECT,
                'default' => 'h3',
                'options' => [
                    'h1' => __('H1', 'nebon'),
                    'h2' => __('H2', 'nebon'),
                    'h3' => __('H3', 'nebon'),
                    'h4' => __('H4', 'nebon'),
                    'h5' => __('H5', 'nebon'),
                    'h6' => __('H6', 'nebon'),
                    'div' => __('DIV', 'nebon'),
                    'span' => __('SPAN', 'nebon'),
                    'p' => __('P', 'nebon'),
                ],
            ]
        );
        $this->add_control(
            'icon',
            [
                'label' => __('Icon', 'nebon'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'label_block' => true,
                'default' => [
                    'value' => 'las la-rainbow',
                    'library' => 'lineawesome',
                ],
                'condition' => [
                    'style' => ['style1'],
                ],
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
                ],

            ]
        );




        $this->end_controls_section();

        $this->start_controls_section(
            'section_style',
            [
                'label' => __('Style', 'nebon'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'text_align',
            [
                'label' => __('Text Alignment', 'nebon'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'nebon'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'nebon'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', 'nebon'),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .t888-heading' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => __('Title Color', 'nebon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .t888-heading .title ' => 'color: {{VALUE}} !important;',
                ],
            ]
        );
        $this->add_control(
            'line_color',
            [
                'label' => __('Line Color', 'nebon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#b88166',
                'selectors' => [
                    '{{WRAPPER}} .t888-heading .line ' => 'background-color: {{VALUE}} !important;',
                ],
                'condition' => [
                    'style' => ['style1'],
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .t888-heading .title ',
                'fields_options' => [
                    'typography' => ['default' => 'custom'],

                    'text_transform' => [
                        'default' => 'uppercase',
                    ],
                    'font_family' => [
                        'default' => 'Philosopher',
                    ],
                    'font_weight' => [
                        'default' => '700',
                    ],
                ],
            ]
        );


        $this->add_control(
            'icon_color',
            [
                'label' => __('Icon Color', 'nebon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .t888-heading i' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'style' => ['style1'],
                ],
            ]
        );


        $this->add_responsive_control(
            'icon_size',
            [
                'label' => __('Icon Size', 'nebon'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'size' => 72,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .t888-heading i' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'style' => ['style1'],
                ],
            ]
        );
        $this->add_responsive_control(
            'border_color',
            [
                'label' => __('Border Color', 'nebon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#000',
                'selectors' => [
                    '{{WRAPPER}} .t888-heading.style2 .title-wrapper .title' => 'border-color: {{VALUE}} !important;',
                ],
                'condition' => [
                    'style' => ['style2'],
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
        tech888f_get_template_elementor_widget('t888-title', $style, $settings, true);
    }
}
