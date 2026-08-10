<?php
namespace Elementor;

if (!defined('ABSPATH')) {
    exit;
}

class T888_Pet_Mega_Menu extends T888_Widget_Base
{
    public function get_name()
    {
        return 't888-pet-mega-menu';
    }

    public function get_title()
    {
        return \__('dog-megaMenu-home2', 'nebon');
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
                'default' => \__('Dog Dry Food', 'nebon'),
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
                    [
                        'text' => \__('Dog Dry Food', 'nebon'),
                        'link' => ['url' => '#'],
                    ],
                    [
                        'text' => \__('Dog Grain Free Food', 'nebon'),
                        'link' => ['url' => '#'],
                    ],
                    [
                        'text' => \__('Dog Human Grade Food', 'nebon'),
                        'link' => ['url' => '#'],
                    ],
                    [
                        'text' => \__('Dog Wet Food', 'nebon'),
                        'link' => ['url' => '#'],
                    ],
                    [
                        'text' => \__('Puppy Food', 'nebon'),
                        'link' => ['url' => '#'],
                    ],
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
                'default' => \__('Pet Toys', 'nebon'),
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
                'default' => \__('Dog clean Up', 'nebon'),
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
                    [
                        'text' => \__('Dog clean Up', 'nebon'),
                        'link' => ['url' => '#'],
                    ],
                    [
                        'text' => \__('Dog Door & Gates', 'nebon'),
                        'link' => ['url' => '#'],
                    ],
                    [
                        'text' => \__('Dog Clothing', 'nebon'),
                        'link' => ['url' => '#'],
                    ],
                    [
                        'text' => \__('Dog Carriers', 'nebon'),
                        'link' => ['url' => '#'],
                    ],
                    [
                        'text' => \__('Dog Crates & Kennels', 'nebon'),
                        'link' => ['url' => '#'],
                    ],
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
        tech888f_get_template_elementor_widget('t888-pet-mega-menu', 't888-pet-mega-menu', $settings, true);
    }
}
