<?php
namespace Elementor;

if (!defined('ABSPATH')) {
    exit;
}

class Bird_Mega_Menu_Home2 extends T888_Widget_Base
{
    public function get_name()
    {
        return 'bird-mega-menu-home2';
    }

    public function get_title()
    {
        return __('Bird Mega Menu Home 2', 'nebon');
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
            'section_content',
            [
                'label' => __('Content', 'nebon'),
            ]
        );

        $this->add_control(
            'menu_title',
            [
                'label' => __('Menu Title', 'nebon'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Food', 'nebon'),
            ]
        );

        $this->add_control(
            'bird_image',
            [
                'label' => __('Bird Image', 'nebon'),
                'type' => Controls_Manager::MEDIA,
            ]
        );

        $item_repeater = new Repeater();
        $item_repeater->add_control(
            'text',
            [
                'label' => __('Text', 'nebon'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Bird Bath', 'nebon'),
                'label_block' => true,
            ]
        );

        $item_repeater->add_control(
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
            'menu_items',
            [
                'label' => __('Items', 'nebon'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $item_repeater->get_controls(),
                'default' => [
                    ['text' => __('Bird Bath', 'nebon')],
                    ['text' => __('Bird Cage Tidies', 'nebon')],
                    ['text' => __('Bird Cages', 'nebon')],
                    ['text' => __('Bird Feeding', 'nebon')],
                    ['text' => __('Bird Food & Treats', 'nebon')],
                    ['text' => __('Bird Health & Wellbeing', 'nebon')],
                    ['text' => __('Bird Other', 'nebon')],
                    ['text' => __('Bird Perches', 'nebon')],
                    ['text' => __('Bird Toys', 'nebon')],
                    ['text' => __('Shop All Bird Cages Accessories', 'nebon')],
                    ['text' => __('Shop All Bird', 'nebon')],
                ],
                'title_field' => '{{{ text }}}',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_banner',
            [
                'label' => __('Banner', 'nebon'),
            ]
        );

        $this->add_control(
            'banner_eyebrow',
            [
                'label' => __('Eyebrow', 'nebon'),
                'type' => Controls_Manager::TEXT,
                'default' => __('STARTS NOW', 'nebon'),
            ]
        );

        $this->add_control(
            'banner_discount_style',
            [
                'label' => __('Discount Style', 'nebon'),
                'type' => Controls_Manager::SELECT,
                'default' => 'text',
                'options' => [
                    'text' => __('Style 1 - Text %', 'nebon'),
                    'image' => __('Style 2 - Image %', 'nebon'),
                ],
            ]
        );

        $this->add_control(
            'banner_discount_value',
            [
                'label' => __('Discount Number', 'nebon'),
                'type' => Controls_Manager::TEXT,
                'default' => __('50', 'nebon'),
                'condition' => [
                    'banner_discount_style' => 'text',
                ],
            ]
        );

        $this->add_control(
            'banner_discount_unit',
            [
                'label' => __('Discount Unit', 'nebon'),
                'type' => Controls_Manager::TEXT,
                'default' => __('%', 'nebon'),
                'condition' => [
                    'banner_discount_style' => 'text',
                ],
            ]
        );

        $this->add_control(
            'banner_discount_unit_image',
            [
                'label' => __('Discount Unit Image', 'nebon'),
                'type' => Controls_Manager::MEDIA,
                'condition' => [
                    'banner_discount_style' => 'text',
                ],
            ]
        );

        $this->add_control(
            'banner_discount_label',
            [
                'label' => __('Discount Label', 'nebon'),
                'type' => Controls_Manager::TEXT,
                'default' => __('OFF', 'nebon'),
                'condition' => [
                    'banner_discount_style' => 'text',
                ],
            ]
        );

        $this->add_control(
            'banner_discount_image',
            [
                'label' => __('Discount Image', 'nebon'),
                'type' => Controls_Manager::MEDIA,
                'condition' => [
                    'banner_discount_style' => 'image',
                ],
            ]
        );

        $this->add_control(
            'banner_title',
            [
                'label' => __('Sale Title', 'nebon'),
                'type' => Controls_Manager::TEXT,
                'default' => __('HOLIDAY SALE', 'nebon'),
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
                'default' => '#efe4b5',
            ]
        );

        $this->add_control(
            'banner_overlay_image',
            [
                'label' => __('Banner Overlay Image', 'nebon'),
                'type' => Controls_Manager::MEDIA,
                'description' => __('Optional decorative image inside the banner.', 'nebon'),
            ]
        );

        $this->add_control(
            'banner_text_color',
            [
                'label' => __('Banner Text Color', 'nebon'),
                'type' => Controls_Manager::COLOR,
                'default' => '#111111',
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

        $this->end_controls_section();
    }

    protected function render()
    {
        parent::render();
        $settings = $this->get_element_settings();
        tech888f_get_template_elementor_widget('bird-mega-menu-home2', 'bird-mega-menu-home2', $settings, true);
    }
}
