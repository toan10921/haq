<?php

namespace Elementor;

class T888_Accordion extends T888_Widget_Base
{

    public function get_name()
    {
        return 't888-accordion';
    }

    public function get_title()
    {
        return __('Accordion', 'nebon');
    }

    public function get_icon()
    {
        return 'eicon-accordion';
    }

    public function get_categories()
    {
        return ['t888-elements'];
    }

    public function get_script_depends()
    {
        return ['elementor-t888-accordion'];
    }

    public function get_style_depends()
    {
        return ['elementor-t888-accordion'];
    }

    protected function _register_controls()
    {
        $this->start_controls_section(
            'section_content',
            [
                'label' => __('Accordion Items', 'nebon'),
            ]
        );

        $this->add_control(
            'accordion_items',
            [
                'label' => __('Items', 'nebon'),
                'type' => Controls_Manager::REPEATER,
                'fields' => [
                    [
                        'name' => 'title',
                        'label' => __('Title', 'nebon'),
                        'type' => Controls_Manager::TEXT,
                        'default' => __('Accordion Title', 'nebon'),
                        'label_block' => true,
                    ],
                    [
                        'name' => 'content',
                        'label' => __('Content', 'nebon'),
                        'type' => Controls_Manager::TEXTAREA,
                        'default' => __('Accordion content goes here.', 'nebon'),
                        'rows' => 6,
                    ],
                ],
                'default' => [
                    ['title' => __('Item 1', 'nebon'), 'content' => __('Content for item 1', 'nebon')],
                    ['title' => __('Item 2', 'nebon'), 'content' => __('Content for item 2', 'nebon')],
                ],
                'title_field' => '{{{ title }}}',
            ]
        );

        $this->end_controls_section();

        // Style Tab
        $this->start_controls_section(
            'section_style',
            [
                'label' => __('Style', 'nebon'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => __('Title Color', 'nebon'),
                'type' => Controls_Manager::COLOR,
                'default' => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .t888-accordion-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label' => __('Title Typography', 'nebon'),
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .t888-accordion-title',
                'fields_options' => [
                    'typography' => ['default' => 'custom'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => 18,
                        ],
                    ],
                    'line_height' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => 30,
                        ],
                    ],
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
            'content_color',
            [
                'label' => __('Content Color', 'nebon'),
                'type' => Controls_Manager::COLOR,
                'default' => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .t888-accordion-content' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label' => __('Content Typography', 'nebon'),
                'name' => 'content_typography',
                'selector' => '{{WRAPPER}} .t888-accordion-content',
                'fields_options' => [
                    'typography' => ['default' => 'custom'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => 14,
                        ],
                    ],
                    'line_height' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => 30,
                        ],
                    ],
                    'font_family' => [
                        'default' => 'Poppins',
                    ],
                    'font_weight' => [
                        'default' => '400',
                    ],
                ],
            ]
        );
        $this->end_controls_section();
    }
    
    protected function render()
    {
        parent::render();
        $settings = $this->get_element_settings();
        $style = isset($settings['style']) ? $settings['style'] : 'style1';

        // Add widget ID to the settings array
        $settings['widget_id'] = $this->get_id();

        tech888f_get_template_elementor_widget('t888-accordion', $style, $settings, true);
    }
}
