<?php

namespace Elementor;

class T888_Image_Link_Box extends T888_Widget_Base
{
    public function get_name()
    {
        return 't888-image-link-box';
    }

    public function get_title()
    {
        return __('Image Link Box', 'nebon');
    }

    public function get_icon()
    {
        return 'eicon-image-box';
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
        $this->start_controls_section('section_content', [
            'label' => __('Content', 'nebon'),
        ]);

        $this->add_control('image', [
            'label' => __('Image', 'nebon'),
            'type' => Controls_Manager::MEDIA,
            'default' => [
                'url' => Utils::get_placeholder_image_src(),
            ],
        ]);

        $this->add_control('title', [
            'label' => __('Title', 'nebon'),
            'type' => Controls_Manager::TEXT,
            'default' => __('Title Here', 'nebon'),
        ]);

        $this->add_control('sub_title', [
            'label' => __('Sub Title', 'nebon'),
            'type' => Controls_Manager::TEXT,
            'default' => __('Sub title here', 'nebon'),
        ]);

        $this->add_control('button_text', [
            'label' => __('Button Text', 'nebon'),
            'type' => Controls_Manager::TEXT,
            'default' => __('Browse', 'nebon'),
        ]);

        $this->add_control('link', [
            'label' => __('Link', 'nebon'),
            'type' => Controls_Manager::URL,
            'default' => [
                'url' => '#',
            ],
        ]);

        $this->add_control('content_position', [
            'label'   => __('Content Position', 'nebon'),
            'type'    => Controls_Manager::SELECT,
            'default' => 'top',
            'options' => [
                'top'    => __('Top', 'nebon'),
                'bottom' => __('Bottom', 'nebon'),
            ],
        ]);

        $this->end_controls_section();
    }

    protected function render()
    {
       
        parent::render();
        $settings =  $this->get_element_settings();
        $style = isset($settings['style']) ? $settings['style'] : 'style1';
        tech888f_get_template_elementor_widget('t888-image-link-box', $style, $settings, true);
    }
}
