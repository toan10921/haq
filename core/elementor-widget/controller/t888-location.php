<?php

namespace Elementor;

class T888_Location extends T888_Widget_Base
{
    public function get_name()
    {
        return 't888-location';
    }

    public function get_title()
    {
        return __('Location List', 'nebon');
    }

    public function get_icon()
    {
        return 'eicon-map-pin';
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
        $this->start_controls_section('section_locations', [
            'label' => __('Locations', 'nebon'),
        ]);

        $this->add_control('locations', [
            'label' => __('Location Items', 'nebon'),
            'type' => Controls_Manager::REPEATER,
            'fields' => [
                [
                    'name' => 'title',
                    'label' => __('Title', 'nebon'),
                    'type' => Controls_Manager::TEXT,
                    'default' => __('Switzerland Research & Development Center', 'nebon'),
                ],
                [
                    'name' => 'address',
                    'label' => __('Address', 'nebon'),
                    'type' => Controls_Manager::TEXTAREA,
                    'default' => __('Chemin de Champex 9, 9890 Algle, Switzerland', 'nebon'),
                ],
                [
                    'name' => 'phone',
                    'label' => __('Phone', 'nebon'),
                    'type' => Controls_Manager::TEXT,
                    'default' => __('+41 989765432', 'nebon'),
                ],
                [
                    'name' => 'email',
                    'label' => __('Email', 'nebon'),
                    'type' => Controls_Manager::TEXT,
                    'default' => __('switzerland@nebon.com', 'nebon'),
                ],
                [
                    'name' => 'weekday_hours',
                    'label' => __('Weekday Hours', 'nebon'),
                    'type' => Controls_Manager::TEXT,
                    'default' => __('Monday to Friday: from 9:00 a.m. to 8:00 p.m.', 'nebon'),
                ],
                [
                    'name' => 'saturday_hours',
                    'label' => __('Saturday Hours', 'nebon'),
                    'type' => Controls_Manager::TEXT,
                    'default' => __('Saturdays: from 9:00 a.m. to 1:00 p.m.', 'nebon'),
                ],
                [
                    'name' => 'map_link',
                    'label' => __('Map Link', 'nebon'),
                    'type' => Controls_Manager::URL,
                    'default' => ['url' => '#'],
                ],
            ],
            'title_field' => '{{{ title }}}',
        ]);

        $this->end_controls_section();
    }

    protected function render()
    {
        parent::render();
        $settings =  $this->get_element_settings();
        $style = isset($settings['style']) ? $settings['style'] : 'style1';
        tech888f_get_template_elementor_widget('t888-location', $style, $settings, true);
    }
}
