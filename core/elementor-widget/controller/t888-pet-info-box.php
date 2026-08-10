<?php
namespace Elementor;

class T888_Pet_Info_Box extends T888_Widget_Base
{
    public function get_name()
    {
        return 't888-pet-info-box';
    }

    public function get_title()
    {
        return __('Pet Info Box', 'nebon');
    }

    public function get_icon()
    {
        return 'eicon-info-box';
    }

    public function get_categories()
    {
        return ['t888-elements'];
    }

    protected function _register_controls()
    {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Content', 'nebon'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'icon',
            [
                'label' => __('Icon', 'nebon'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-truck',
                    'library' => 'solid',
                ],
            ]
        );
        $this->add_control(
            'icon_color',
            [
                'label' => __('Icon Color', 'nebon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#c8605f',
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => __('Title', 'nebon'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('FREE SHIPPING & RETURN', 'nebon'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'description',
            [
                'label' => __('Description', 'nebon'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => __('No one rejects, dislikes.', 'nebon'),
            ]
        );

        $this->add_control(
            'hide_divider',
            [
                'label' => __('Hide Left Divider', 'nebon'),
                'description' => __('Turn this on for the FIRST info box in your row to remove the left vertical line.', 'nebon'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Hide', 'nebon'),
                'label_off' => __('Show', 'nebon'),
                'return_value' => 'yes',
                'default' => '',
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        parent::render();
        $settings = $this->get_element_settings();
        tech888f_get_template_elementor_widget('t888-pet-info-box', 't888-pet-info-box', $settings, true);
    }
}
