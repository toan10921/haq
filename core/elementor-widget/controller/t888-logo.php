<?php

namespace Elementor;

class T888_Logo extends T888_Widget_Base
{
    public function __construct(array $data = [], array $args = null)
    {
        parent::__construct($data, $args);
    }
    
    public function get_name()
    {
        return 't888-logo';
    }

    public function get_title()
    {
        return __('Custom Logo', 'nebon');
    }

    public function get_icon()
    {
        return 'eicon-logo';
    }

    public function get_categories()
    {
        return ['t888-elements'];
    }
    
    public function get_style_depends() {
        return [];
    }

    public function get_script_depends() {
        return [];
    }
    
    protected function _register_controls()
    {
        $this->start_controls_section('section_logo', [
            'label' => __('Logo Settings', 'nebon'),
        ]);

        $this->add_control('logo_image', [
            'label' => __('Logo Image (140x54px)', 'nebon'),
            'type' => Controls_Manager::MEDIA,
            'default' => [
                'url' => get_template_directory_uri() . '/assets/images/logo.png',
            ],
        ]);

        $this->add_control('logo_text', [
            'label' => __('Logo Text (Allow HTML)', 'nebon'),
            'type' => Controls_Manager::WYSIWYG,
            'default' => __('nebon', 'nebon'),
            'placeholder' => __('Enter your logo text', 'nebon'),
        ]);
        

        $this->add_control('style', [
            'label' => __('Logo Style', 'nebon'),
            'type' => Controls_Manager::SELECT,
            'default' => 'style1',
            'options' => [
                'style1' => __('Style 1 - Default (Header main)', 'nebon'),
                'style2' => __('Style 2 - Footer', 'nebon'),
                'style3' => __('Style 3 - Header light background', 'nebon'),
            ]
        ]);

        $this->end_controls_section();
    }

    protected function render()
    {
        parent::render();
        $settings =  $this->get_element_settings();
        $style = isset($settings['style']) ? $settings['style'] : 'style1';
        tech888f_get_template_elementor_widget('t888-logo', $style, $settings, true);
    }
}