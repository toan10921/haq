<?php

namespace Elementor;

class T888_Image_Compare extends T888_Widget_Base
{
    public function get_name()
    {
        return 't888-image-compare';
    }

    public function get_title()
    {
        return __('Image Compare', 'nebon');
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
        return ['twentytwenty', 'elementor-t888-image-compare'];
    }


    public function get_style_depends()
    {
        return ['elementor-t888-image-compare'];
    }

    protected function _register_controls()
    {
        $this->start_controls_section(
            'section_images',
            [
                'label' => __('Compare Images', 'nebon'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'before_image',
            [
                'label'   => __('Before Image', 'nebon'),
                'type'    => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->add_control(
            'after_image',
            [
                'label'   => __('After Image', 'nebon'),
                'type'    => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->add_control(
            'before_label',
            [
                'label'   => __('Before Label', 'nebon'),
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => __('Before', 'nebon'),
            ]
        );

        $this->add_control(
            'after_label',
            [
                'label'   => __('After Label', 'nebon'),
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => __('After', 'nebon'),
            ]
        );



        $this->end_controls_section();
    }

    protected function render()
    {
        parent::render();
        $settings =  $this->get_element_settings();
        $style = isset($settings['style']) ? $settings['style'] : 'style1';
        tech888f_get_template_elementor_widget('t888-image-compare', $style, $settings, true);
    }
}
