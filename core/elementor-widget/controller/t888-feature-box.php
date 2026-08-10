<?php

namespace Elementor;

class T888_Feature_Box extends T888_Widget_Base
{

    public function get_name()
    {
        return 't888-feature-box';
    }

    public function get_title()
    {
        return __('Feature Box', 'nebon');
    }

    public function get_icon()
    {
        return 'eicon-info-circle';
    }

    public function get_categories()
    {
        return ['t888-elements'];
    }

    public function get_script_depends()
    {
        return [];
    }

    public function get_style_depends()
    {
        return [];
    }

    protected function _register_controls()
    {
        // === Content Section ===
        $this->start_controls_section('section_content', [
            'label' => __('Content', 'nebon'),
        ]);

        $this->add_control('title_1', [
            'label' => __('Title Line 1', 'nebon'),
            'type' => Controls_Manager::TEXT,
            'default' => __('Clean I.Q.', 'nebon'),
        ]);

        $this->add_control('title_2', [
            'label' => __('Title Line 2', 'nebon'),
            'type' => Controls_Manager::TEXT,
            'default' => __('Clean Intelligence Quality', 'nebon'),
        ]);

        $this->add_control('description', [
            'label' => __('Description', 'nebon'),
            'type' => Controls_Manager::TEXTAREA,
            'default' => __('Our completely clean thinking means we go beyond merely clean ingredients...', 'nebon'),
        ]);

        $this->add_control('button_text', [
            'label' => __('Button Text', 'nebon'),
            'type' => Controls_Manager::TEXT,
            'default' => __('Discover Now', 'nebon'),
        ]);

        $this->add_control('button_link', [
            'label' => __('Button Link', 'nebon'),
            'type' => Controls_Manager::URL,
            'default' => ['url' => '#'],
        ]);

        $this->end_controls_section();

        // === Left Column Features ===
        $this->start_controls_section('section_left_features', [
            'label' => __('Left Features', 'nebon'),
        ]);

        $this->add_control('left_features', [
            'label' => __('Left Items', 'nebon'),
            'type' => Controls_Manager::REPEATER,
            'fields' => [
                [
                    'name' => 'title',
                    'label' => __('Title', 'nebon'),
                    'type' => Controls_Manager::TEXT,
                    'default' => __('Clean Standard', 'nebon'),
                ],
                [
                    'name' => 'description',
                    'label' => __('Description', 'nebon'),
                    'type' => Controls_Manager::TEXTAREA,
                    'default' => __('Description goes here', 'nebon'),
                ],
                [
                    'name' => 'icon_class',
                    'label' => __('Line Awesome Icon Class', 'nebon'),
                    'type' => Controls_Manager::TEXT,
                    'default' => 'las la-check',
                ],
            ],
            'default' => [],
            'title_field' => '{{{ title }}}',
        ]);

        $this->end_controls_section();

        // === Right Column Features ===
        $this->start_controls_section('section_right_features', [
            'label' => __('Right Features', 'nebon'),
        ]);

        $this->add_control('right_features', [
            'label' => __('Right Items', 'nebon'),
            'type' => Controls_Manager::REPEATER,
            'fields' => [
                [
                    'name' => 'title',
                    'label' => __('Title', 'nebon'),
                    'type' => Controls_Manager::TEXT,
                    'default' => __('Clean Technology', 'nebon'),
                ],
                [
                    'name' => 'description',
                    'label' => __('Description', 'nebon'),
                    'type' => Controls_Manager::TEXTAREA,
                    'default' => __('Description goes here', 'nebon'),
                ],
                [
                    'name' => 'icon_class',
                    'label' => __('Line Awesome Icon Class', 'nebon'),
                    'type' => Controls_Manager::TEXT,
                    'default' => 'las la-check',
                ],
            ],
            'default' => [],
            'title_field' => '{{{ title }}}',
        ]);

        $this->end_controls_section();
        // === Style Section ===
        $this->start_controls_section('section_style', [
            'label' => __('Style', 'nebon'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);
        $this->add_control('style', [
            'label' => __('Select Style', 'nebon'),
            'type' => Controls_Manager::SELECT,
            'default' => 'style1',
            'options' => [
                'style1' => __('Style 1', 'nebon'),
                'style2' => __('Style 2', 'nebon'),
            ],
        ]);
        $this->end_controls_section();
    }

    protected function render()
    {
        parent::render();
        $settings =  $this->get_element_settings();
        $style = isset($settings['style']) ? $settings['style'] : 'style1';
        tech888f_get_template_elementor_widget('t888-feature-box', $style, $settings, true);
    }
}
