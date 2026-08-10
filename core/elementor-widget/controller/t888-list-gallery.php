<?php

namespace Elementor;

class T888_List_Gallery extends T888_Widget_Base
{

    public function get_name()
    {
        return 't888-list-gallery';
    }

    public function get_title()
    {
        return __('List Gallery', 'nebon');
    }

    public function get_icon()
    {
        return 'fas fa-images';
    }

    public function get_categories()
    {
        return ['t888-elements'];
    }

    public function get_script_depends()
    {
        return ['elementor-t888-list-gallery', 'swiper'];
    }

    public function get_style_depends()
    {
        return ['elementor-t888-list-gallery', 'e-swiper'];
    }

    protected function _register_controls()
    {
        $this->start_controls_section(
            'section_content',
            [
                'label' => __('Gallery Settings', 'nebon'),
            ]
        );

        $this->add_control(
            'title',
            [
                'label'   => __('Title', 'nebon'),
                'type'    => Controls_Manager::TEXT,
                'default' => __('List gallery', 'nebon'),
            ]
        );

        $repeater = new Repeater();

    $repeater->add_control('item_image', [
        'label' => __('Image', 'nebon'),
        'type'  => Controls_Manager::MEDIA,
        'default' => ['url' => Utils::get_placeholder_image_src()],
    ]);

    $repeater->add_control('item_link', [
        'label' => __('Link', 'nebon'),
        'type'  => Controls_Manager::URL,
        'placeholder' => 'https://...',
        'options' => ['is_external', 'nofollow'],
        'default' => ['url' => ''],
        'show_external' => true,
    ]);

    $this->add_control('items', [
        'label'       => __('Gallery Items', 'nebon'),
        'type'        => Controls_Manager::REPEATER,
        'fields'      => $repeater->get_controls(),
        'title_field' => __('Image Item', 'nebon'),
        'default'     => [],
    ]);



        $this->add_control(
            'gallery_style',
            [
                'label'   => __('Select Style', 'nebon'),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'style1' => __('Style 1', 'nebon'),
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
        $settings =  $this->get_element_settings();
        $style = isset($settings['style']) ? $settings['style'] : 'style1';
        tech888f_get_template_elementor_widget('t888-list-gallery', $style, $settings, true);
    }
}
