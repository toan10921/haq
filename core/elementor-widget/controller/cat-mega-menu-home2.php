<?php
namespace Elementor;

if (!defined('ABSPATH')) {
    exit;
}

class Cat_Mega_Menu_Home2 extends T888_Widget_Base
{
    public function get_name()
    {
        return 'cat-mega-menu-home2';
    }

    public function get_title()
    {
        return \__('cat-megaMenu-home2', 'nebon');
    }

    public function get_icon()
    {
        return 'eicon-menu-bar';
    }

    public function get_categories()
    {
        return ['t888-elements'];
    }

    public function get_style_depends()
    {
        return ['elementor-t888-pet-mega-menu'];
    }

    protected function _register_controls()
    {
        $this->start_controls_section(
            'section_left_column',
            [
                'label' => \__('Left Column', 'nebon'),
            ]
        );

        $this->add_control(
            'left_title',
            [
                'label' => \__('Title', 'nebon'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => \__('Food', 'nebon'),
            ]
        );

        $this->add_control(
            'left_image',
            [
                'label' => \__('Image', 'nebon'),
                'type' => \Elementor\Controls_Manager::MEDIA,
            ]
        );

        $left_repeater = new \Elementor\Repeater();

        $left_repeater->add_control(
            'text',
            [
                'label' => \__('Item Text', 'nebon'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => \__('Cat Dry Food', 'nebon'),
                'label_block' => true,
            ]
        );

        $left_repeater->add_control(
            'link',
            [
                'label' => \__('Item Link', 'nebon'),
                'type' => \Elementor\Controls_Manager::URL,
                'default' => [
                    'url' => '#',
                ],
            ]
        );

        $this->add_control(
            'left_items',
            [
                'label' => \__('Items', 'nebon'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $left_repeater->get_controls(),
                'default' => [
                    ['text' => \__('Cat Dry Food', 'nebon'), 'link' => ['url' => '#']],
                    ['text' => \__('Cat Grain Free Food', 'nebon'), 'link' => ['url' => '#']],
                    ['text' => \__('Fresh & Frozen Food', 'nebon'), 'link' => ['url' => '#']],
                    ['text' => \__('Vet Prescription Diet Food', 'nebon'), 'link' => ['url' => '#']],
                    ['text' => \__('Cat Wet Food', 'nebon'), 'link' => ['url' => '#']],
                    ['text' => \__('Kitten Food', 'nebon'), 'link' => ['url' => '#']],
                    ['text' => \__('Cat Food Repeat Delivery', 'nebon'), 'link' => ['url' => '#']],
                    ['text' => \__('Cat Food Value Bundles', 'nebon'), 'link' => ['url' => '#']],
                    ['text' => \__('Advance', 'nebon'), 'link' => ['url' => '#']],
                    ['text' => \__('Dine Daily', 'nebon'), 'link' => ['url' => '#']],
                    ['text' => \__('Fancy Feast', 'nebon'), 'link' => ['url' => '#']],
                    ['text' => __('Hill\'s Science Diet', 'nebon'), 'link' => ['url' => '#']],
                    ['text' => \__('Shop All Cat Food', 'nebon'), 'link' => ['url' => '#']],
                ],
                'title_field' => '{{{ text }}}',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_right_column',
            [
                'label' => \__('Right Column', 'nebon'),
            ]
        );

        $this->add_control(
            'right_title',
            [
                'label' => \__('Title', 'nebon'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => \__('Cat Health', 'nebon'),
            ]
        );

        $this->add_control(
            'right_image',
            [
                'label' => \__('Image', 'nebon'),
                'type' => \Elementor\Controls_Manager::MEDIA,
            ]
        );

        $right_repeater = new \Elementor\Repeater();

        $right_repeater->add_control(
            'text',
            [
                'label' => \__('Item Text', 'nebon'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => \__('Cat Dental & Oral Care', 'nebon'),
                'label_block' => true,
            ]
        );

        $right_repeater->add_control(
            'link',
            [
                'label' => \__('Item Link', 'nebon'),
                'type' => \Elementor\Controls_Manager::URL,
                'default' => [
                    'url' => '#',
                ],
            ]
        );

        $this->add_control(
            'right_items',
            [
                'label' => \__('Items', 'nebon'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $right_repeater->get_controls(),
                'default' => [
                    ['text' => \__('Cat Dental & Oral Care', 'nebon'), 'link' => ['url' => '#']],
                    ['text' => \__('Cat Hairball', 'nebon'), 'link' => ['url' => '#']],
                    ['text' => \__('Cat Joint Support', 'nebon'), 'link' => ['url' => '#']],
                    ['text' => \__('Cat Sensitive Skin', 'nebon'), 'link' => ['url' => '#']],
                    ['text' => \__('Cat Sensitive Stomach', 'nebon'), 'link' => ['url' => '#']],
                    ['text' => \__('Cat Stress & Anxiety', 'nebon'), 'link' => ['url' => '#']],
                    ['text' => \__('Cat Urinary Tract Health', 'nebon'), 'link' => ['url' => '#']],
                    ['text' => \__('Cat Weight Management', 'nebon'), 'link' => ['url' => '#']],
                    ['text' => \__('Cat Flea, Tick & Worm', 'nebon'), 'link' => ['url' => '#']],
                    ['text' => \__('Cat Supplements', 'nebon'), 'link' => ['url' => '#']],
                    ['text' => \__('Cat Health Repeat Delivery', 'nebon'), 'link' => ['url' => '#']],
                    ['text' => \__('Cat Health Value Bundles', 'nebon'), 'link' => ['url' => '#']],
                    ['text' => \__('PetWatch', 'nebon'), 'link' => ['url' => '#']],
                ],
                'title_field' => '{{{ text }}}',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_bottom_banner',
            [
                'label' => \__('Bottom Banner', 'nebon'),
            ]
        );

        $this->add_control(
            'bottom_banner_image',
            [
                'label' => \__('Banner Image', 'nebon'),
                'type' => \Elementor\Controls_Manager::MEDIA,
            ]
        );

        $this->add_control(
            'bottom_banner_link',
            [
                'label' => \__('Banner Link', 'nebon'),
                'type' => \Elementor\Controls_Manager::URL,
                'default' => [
                    'url' => '#',
                ],
            ]
        );

        $this->add_control(
            'box_background',
            [
                'label' => \__('Background Color', 'nebon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#eeeeee',
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        parent::render();
        $settings = $this->get_element_settings();
        tech888f_get_template_elementor_widget('cat-mega-menu-home2', 'cat-mega-menu-home2', $settings, true);
    }
}
