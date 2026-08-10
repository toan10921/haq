<?php
namespace Elementor;

if (!defined('ABSPATH')) {
    exit;
}

class Fish_Mega_Menu_Home2 extends T888_Widget_Base
{
    public function get_name()
    {
        return 'fish-mega-menu-home2';
    }

    public function get_title()
    {
        return __('Fish Mega Menu Home 2', 'nebon');
    }

    public function get_icon()
    {
        return 'eicon-menu-bar';
    }

    public function get_categories()
    {
        return ['t888-elements'];
    }

    protected function _register_controls()
    {
        $this->start_controls_section(
            'section_banner',
            [
                'label' => __('Banner', 'nebon'),
            ]
        );

        $this->add_control(
            'banner_heading',
            [
                'label' => __('Heading', 'nebon'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Shop everything for fish', 'nebon'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'banner_discount',
            [
                'label' => __('Discount Text', 'nebon'),
                'type' => Controls_Manager::TEXT,
                'default' => __('50% Off', 'nebon'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'banner_button_text',
            [
                'label' => __('Button Text', 'nebon'),
                'type' => Controls_Manager::TEXT,
                'default' => __('SHOP NOW', 'nebon'),
            ]
        );

        $this->add_control(
            'banner_button_link',
            [
                'label' => __('Button Link', 'nebon'),
                'type' => Controls_Manager::URL,
                'default' => [
                    'url' => '#',
                ],
            ]
        );

        $this->add_control(
            'banner_background',
            [
                'label' => __('Banner Background', 'nebon'),
                'type' => Controls_Manager::COLOR,
                'default' => '#b96a3f',
            ]
        );

        $this->add_control(
            'banner_background_image',
            [
                'label' => __('Banner Background Image', 'nebon'),
                'type' => Controls_Manager::MEDIA,
            ]
        );

        $this->add_control(
            'banner_text_color',
            [
                'label' => __('Banner Text Color', 'nebon'),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
            ]
        );

        $this->add_control(
            'button_background',
            [
                'label' => __('Button Background', 'nebon'),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
            ]
        );

        $this->add_control(
            'button_text_color',
            [
                'label' => __('Button Text Color', 'nebon'),
                'type' => Controls_Manager::COLOR,
                'default' => '#111111',
            ]
        );

        $this->add_control(
            'fish_image',
            [
                'label' => __('Fish Image', 'nebon'),
                'type' => Controls_Manager::MEDIA,
                'description' => __('Leave empty to use the built-in fish illustration.', 'nebon'),
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_links',
            [
                'label' => __('Links', 'nebon'),
            ]
        );

        $this->add_control(
            'shop_title',
            [
                'label' => __('Section Title', 'nebon'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Fish shop', 'nebon'),
            ]
        );

        $column_repeater = new Repeater();
        $column_repeater->add_control(
            'text',
            [
                'label' => __('Text', 'nebon'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Air Pumps and Filtration', 'nebon'),
                'label_block' => true,
            ]
        );

        $column_repeater->add_control(
            'link',
            [
                'label' => __('Link', 'nebon'),
                'type' => Controls_Manager::URL,
                'default' => [
                    'url' => '#',
                ],
            ]
        );

        $this->add_control(
            'column_1_items',
            [
                'label' => __('Column 1 Items', 'nebon'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $column_repeater->get_controls(),
                'default' => [
                    ['text' => __('Air Pumps and Filtration', 'nebon')],
                    ['text' => __('Aquarium Lights', 'nebon')],
                    ['text' => __('Fish Aquarium and Stands', 'nebon')],
                    ['text' => __('Fish Books and Stationary', 'nebon')],
                ],
                'title_field' => '{{{ text }}}',
            ]
        );

        $this->add_control(
            'column_2_items',
            [
                'label' => __('Column 2 Items', 'nebon'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $column_repeater->get_controls(),
                'default' => [
                    ['text' => __('Fish Cleaning and Maintenance', 'nebon')],
                    ['text' => __('Fish Food', 'nebon')],
                    ['text' => __('Fish Health Treatments', 'nebon')],
                    ['text' => __('Gravel & Decor', 'nebon')],
                ],
                'title_field' => '{{{ text }}}',
            ]
        );

        $this->add_control(
            'column_3_items',
            [
                'label' => __('Column 3 Items', 'nebon'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $column_repeater->get_controls(),
                'default' => [
                    ['text' => __('Heaters', 'nebon')],
                    ['text' => __('Shop All Fish Tank Accessories', 'nebon')],
                    ['text' => __('Shop All Fish Heating & Accessories', 'nebon')],
                    ['text' => __('Shop All Fish', 'nebon')],
                ],
                'title_field' => '{{{ text }}}',
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        parent::render();
        $settings = $this->get_element_settings();
        tech888f_get_template_elementor_widget('fish-mega-menu-home2', 'fish-mega-menu-home2', $settings, true);
    }
}
