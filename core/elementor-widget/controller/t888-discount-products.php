<?php

namespace Elementor;

class T888_Discount_Products extends T888_Widget_Base
{

    public function get_name()
    {
        return 't888-discount-products';
    }

    public function get_title()
    {
        return __('Discount Products', 'nebon');
    }

    public function get_icon()
    {
        return 'eicon-products';
    }

    public function get_categories()
    {
        return ['t888-elements'];
    }

    public function get_script_depends()
    {
        return ['elementor-t888-discount-products', 'swiper'];
    }

    public function get_style_depends()
    {
        return ['elementor-t888-discount-products', 'e-swiper'];
    }

    protected function _register_controls()
    {

        $this->start_controls_section(
            'layout_section',
            [
                'label' => __('Layout Options', 'nebon'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        // Upload background image
        $this->add_control(
            'background_image',
            [
                'label' => __('Background Image', 'nebon'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );

        // Background position (desktop)
        $this->add_control(
            'background_position',
            [
                'label' => __('Background Position (Desktop)', 'nebon'),
                'type' => Controls_Manager::SELECT,
                'default' => 'right center',
                'options' => [
                    'left top' => 'Left Top',
                    'left center' => 'Left Center',
                    'left bottom' => 'Left Bottom',
                    'center top' => 'Center Top',
                    'center bottom' => 'Center Bottom',
                    'center center' => 'Center Center',
                    'right top' => 'Right Top',
                    'right center' => 'Right Center',
                    'right bottom' => 'Right Bottom',
                ],
            ]
        );

        // Background position (mobile)
        $this->add_control(
            'background_position_mobile',
            [
                'label' => __('Background Position (Mobile)', 'nebon'),
                'type' => Controls_Manager::SELECT,
                'default' => 'left center',
                'options' => [

                    'left top' => 'Left Top',
                    'left center' => 'Left Center',
                    'left bottom' => 'Left Bottom',
                    'center top' => 'Center Top',
                    'center bottom' => 'Center Bottom',
                    'center center' => 'Center Center',
                    'right top' => 'Right Top',
                    'right center' => 'Right Center',
                    'right bottom' => 'Right Bottom',

                ],
            ]
        );

        $this->end_controls_section();

        // SECTION: Left Titles
        $this->start_controls_section(
            'left_titles_section',
            [
                'label' => __('Left Titles', 'nebon'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'left_title_1',
            [
                'label' => __('Left Title Line 1', 'nebon'),
                'type' => Controls_Manager::TEXT,
                'default' => __('CREAM FACE', 'nebon'),
            ]
        );

        $this->add_control(
            'left_title_2',
            [
                'label' => __('Left Title Line 2', 'nebon'),
                'type' => Controls_Manager::TEXT,
                'default' => __('DAY & NIGHT', 'nebon'),
            ]
        );

        $this->add_control(
            'left_title_3',
            [
                'label' => __('Left Title Line 3', 'nebon'),
                'type' => Controls_Manager::TEXT,
                'default' => __('HIGH-QUALITY PRODUCTS', 'nebon'),
            ]
        );

        $this->end_controls_section();

        // SECTION: Right Titles
        $this->start_controls_section(
            'right_titles_section',
            [
                'label' => __('Right Titles', 'nebon'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'right_title_1',
            [
                'label' => __('Right Title Line 1', 'nebon'),
                'type' => Controls_Manager::TEXT,
                'default' => __('DISCOUNT OF THE WEEK', 'nebon'),
            ]
        );

        $this->add_control(
            'right_title_2',
            [
                'label' => __('Right Title Line 2', 'nebon'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Shop Sale Off', 'nebon'),
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        // $this->enque_styles();
        // $this->enque_scripts();

        // $settings = $this->get_settings_for_display();
        // $style = isset($settings['style']) ? $settings['style'] : 'style1';

        // $template_map = [
        //     'style1' => 't888-discount-products.php', // Default
        //     'style2' => 't888-discount-products-style2.php',
        // ];

        // $template_file = isset($template_map[$style]) ? $template_map[$style] : $template_map['style1'];

        // $template_path = dirname(__FILE__) . '/../templates/t888-discount-products/' . $template_file;

        // if (file_exists($template_path)) {
        //     include $template_path;
        // } else {
        //     include dirname(__FILE__) . '/../templates/t888-discount-products/t888-discount-products.php';
        // }
          parent::render();
        $settings =  $this->get_element_settings();
        $style = isset($settings['style']) ? $settings['style'] : 'style1';
        tech888f_get_template_elementor_widget('t888-discount-products', $style, $settings, true);
    }
}
