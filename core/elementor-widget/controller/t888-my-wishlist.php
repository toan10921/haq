<?php

namespace Elementor;

class T888_My_Wishlist extends T888_Widget_Base
{
    public function get_name()
    {
        return 't888-my-wishlist';
    }

    public function get_title()
    {
        return __('My Wishlist', 'nebon');
    }

    public function get_icon()
    {
        return 'eicon-favorite';
    }

    public function get_categories()
    {
        return ['t888-elements'];
    }
    
    public function get_style_depends()
    {
        return [];
    }

    public function get_script_depends()
    {
        return [];
    }

    protected function _register_controls()
    {
        // Content Section
        $this->start_controls_section(
            'section_menu_content',
            [
                'label' => __('My Wishlist Content', 'nebon'),
            ]
        );

        $this->add_control(
            'style' ,
            [
                'label' => __('Style', 'nebon'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'style1' => __('Style 1 - Header 1', 'nebon'),
                    'style2' => __('Style 2', 'nebon'),
                ],
                'default' => 'style1',
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        parent::render();
        $settings = $this->get_settings_for_display();
        $settings['widget_id'] = $this->get_id();
        
        $style = isset($settings['style']) ? $settings['style'] : 'style1';
        
        tech888f_get_template_elementor_widget('t888-my-wishlist', $style, $settings, true);
    }
}