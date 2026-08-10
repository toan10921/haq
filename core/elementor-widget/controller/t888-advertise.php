<?php

namespace Elementor;

class T888_Advertise extends T888_Widget_Base
{

    public function get_name()
    {
        return 't888-advertise';
    }

    public function get_title()
    {
        return __('Advertise', 'nebon');
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
        return ['elementor-t888-advertise'];
    }

    public function get_style_depends()
    {
        return ['elementor-t888-advertise'];
    }

    protected function _register_controls()
    {
        $this->start_controls_section(
            'section_content',
            [
                'label' => __('Content', 'nebon'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        // Title field
        $this->add_control(
            'heading',
            [
                'label' => __('Main Title', 'nebon'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('What you know makes you beautiful', 'nebon'),
                'label_block' => true,
            ]
        );

        // Repeater for image + link
        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'image',
            [
                'label' => __('Image', 'nebon'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $repeater->add_control(
            'link',
            [
                'label' => __('Link', 'nebon'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => __('https://your-link.com', 'nebon'),
                'show_external' => true,
                'default' => [
                    'url' => '',
                    'is_external' => true,
                    'nofollow' => true,
                ],
            ]
        );

        $this->add_control(
            'items',
            [
                'label' => __('Image List', 'nebon'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [],
                'title_field' => '{{{ link.url }}}',
            ]
        );

        $this->end_controls_section();
    }
    
    protected function render()
    {
        parent::render();
        $settings =  $this->get_element_settings();
        $style = isset($settings['style']) ? $settings['style'] : 'style1';
        tech888f_get_template_elementor_widget('t888-advertise', $style, $settings, true);
    }
}
