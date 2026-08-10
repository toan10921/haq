<?php

namespace Elementor;

class T888_History_Timeline extends T888_Widget_Base
{
    
    public function get_name()
    {
        return 't888-history-timeline';
    }

    public function get_title()
    {
        return __('History timeline', 'nebon');
    }

    public function get_icon()
    {
        return 'fas fa-timeline';
    }

    public function get_categories()
    {
        return ['t888-elements'];
    }

    public function get_script_depends()
    {
        return ['elementor-t888-history-timeline'];
    }

    public function get_style_depends()
    {
        return ['elementor-t888-history-timeline'];
    }

    protected function _register_controls()
    {
        // Section: General Content
        $this->start_controls_section(
            'section_content',
            [
                'label' => __('Content', 'nebon'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
    
        // Main heading
        $this->add_control(
            'heading',
            [
                'label' => __('Main Title', 'nebon'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Our History', 'nebon'),
                'label_block' => true,
            ]
        );
    
        // Intro paragraph
        $this->add_control(
            'intro_text',
            [
                'label' => __('Introduction', 'nebon'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => __('Beauty is a total experience...', 'nebon'),
                'rows' => 5,
            ]
        );
    
        // Repeater for timeline items
        $repeater = new \Elementor\Repeater();
    
        $repeater->add_control(
            'year',
            [
                'label' => __('Year', 'nebon'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '2008',
            ]
        );
    
        $repeater->add_control(
            'title',
            [
                'label' => __('Title', 'nebon'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Nebon skincare', 'nebon'),
            ]
        );
    
        $repeater->add_control(
            'description',
            [
                'label' => __('Description', 'nebon'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => __('At its core, Nebon humanizes skincare...', 'nebon'),
                'rows' => 5,
            ]
        );
    
        $this->add_control(
            'timeline_items',
            [
                'label' => __('Timeline Entries', 'nebon'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [],
                'title_field' => '{{{ year }}} — {{{ title }}}',
            ]
        );
    
        $this->end_controls_section();
    }
    

    



    protected function render()
    {
        parent::render();
        $settings =  $this->get_element_settings();
        $style = isset($settings['style']) ? $settings['style'] : 'style1';
        tech888f_get_template_elementor_widget('t888-history-timeline', $style, $settings, true);
    }
}
