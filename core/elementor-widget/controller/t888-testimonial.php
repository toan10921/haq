<?php

/**
 * Created by khangtrinh.
 * User: khangtrinh
 * Date: 13/06/2024
 * Time: 04:20 PM
 */

namespace Elementor;

// if (!defined('ABSPATH')) {
//     exit; // Exit if accessed directly
// }

class T888_Testimonial extends T888_Widget_Base
{
    /**
     * Get widget name.
     */
    public function get_name()
    {
        return 't888-testimonial';
    }

    /**
     * Get widget title.
     */
    public function get_title()
    {
        return __('Testimonial', 'nebon');
    }

    /**
     * Get widget icon.
     */
    public function get_icon()
    {
        return 'fas fa-star';
    }
    /**
     * Add script depends.
     *
     * Register new script to enqueue by the handler.
     *
     * @since 1.9.0
     * @access public
     *
     * @param string $handler Depend script handler.
     */
    public function get_script_depends()
    {
        return ['elementor-t888-testimonial', 'swiper'];
    }

    /**
     * Add style depends.
     *
     * Register new style to enqueue by the handler.
     *
     * @since 1.9.0
     * @access public
     *
     * @param string $handler Depend style handler.
     */
    public function get_style_depends()
    {
        return ['elementor-t888-testimonial', 'e-swiper'];
    }
    /**
     * Get widget categories.
     */
    public function get_categories()
    {
        return ['t888-elements'];
    }

    /**
     * Register controls.
     */
    protected function _register_controls()
    {
        $this->start_controls_section(
            'section_content',
            [
                'label' => __('Testimonial', 'nebon'),
            ]
        );

        $this->add_control(
            'style',
            [
                'label' => __('Style', 'nebon'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '' => __('Default', 'nebon'),
                    'style2' => __('Style 2', 'nebon'),
                    'style3' => __('Style 3 - Industrial Split', 'nebon'),
                ]
            ]
        );

        $this->add_control(
            'style3_image',
            [
                'label' => __('Main Image', 'nebon'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'condition' => ['style' => 'style3'],
            ]
        );

        $this->add_control(
            'style3_eyebrow',
            [
                'label' => __('Eyebrow', 'nebon'),
                'type' => Controls_Manager::TEXT,
                'default' => __('TESTIMONIALS', 'nebon'),
                'label_block' => true,
                'condition' => ['style' => 'style3'],
            ]
        );

        $this->add_control(
            'style3_heading',
            [
                'label' => __('Heading', 'nebon'),
                'type' => Controls_Manager::TEXT,
                'default' => __('What Client Say', 'nebon'),
                'label_block' => true,
                'condition' => ['style' => 'style3'],
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'title',
            [
                'label' => __('Name', 'nebon'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Robbie', 'nebon'),
            ]
        );

        $repeater->add_control(
            'avatar',
            [
                'label' => __('Avatar', 'nebon'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $repeater->add_control(
            'quote_title',
            [
                'label' => __('Testimonial Title', 'nebon'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Best Company!', 'nebon'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'position',
            [
                'label' => __('Position', 'nebon'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Engineer', 'nebon'),
            ]
        );

        $repeater->add_control(
            'company_logo',
            [
                'label' => __('Company Logo', 'nebon'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => '',
                ],
            ]
        );

        $repeater->add_control(
            'rating',
            [
                'label' => __('Rating', 'nebon'),
                'type' => Controls_Manager::NUMBER,
                'default' => 5,
                'min' => 1,
                'max' => 5,
                'step' => 1,
            ]
        );


        $repeater->add_control(
            'content',
            [
                'label' => __('Content', 'nebon'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => __('', 'nebon'),
            ]
        );

        $this->add_control(
            'list',
            [
                'label' => __('Danh sách mục', 'nebon'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'title_field' => '{{{ title }}}',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style3_layout',
            [
                'label' => __('Style 3 Layout', 'nebon'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['style' => 'style3'],
            ]
        );

        $this->add_responsive_control(
            'style3_min_height',
            [
                'label' => __('Minimum Height', 'nebon'),
                'type' => Controls_Manager::SLIDER,
                'range' => ['px' => ['min' => 420, 'max' => 900]],
                'default' => ['size' => 635, 'unit' => 'px'],
                'selectors' => [
                    '{{WRAPPER}} .t888-testimonial-style3' => 'min-height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'style3_image_width',
            [
                'label' => __('Image Width', 'nebon'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['%'],
                'range' => ['%' => ['min' => 30, 'max' => 70]],
                'default' => ['size' => 49, 'unit' => '%'],
                'selectors' => [
                    '{{WRAPPER}} .t888-testimonial-style3' => '--t888-testimonial-image-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'style3_content_padding',
            [
                'label' => __('Content Padding', 'nebon'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'default' => [
                    'top' => 70,
                    'right' => 90,
                    'bottom' => 65,
                    'left' => 110,
                    'unit' => 'px',
                    'isLinked' => false,
                ],
                'selectors' => [
                    '{{WRAPPER}} .t888-testimonial-style3__content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style3_colors',
            [
                'label' => __('Style 3 Colors', 'nebon'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['style' => 'style3'],
            ]
        );

        $style3_colors = [
            'style3_background_color' => [__('Background', 'nebon'), '#1f1f1f', '--t888-testimonial-bg'],
            'style3_heading_color' => [__('Heading', 'nebon'), '#ffffff', '--t888-testimonial-heading'],
            'style3_text_color' => [__('Text', 'nebon'), '#c8c8c8', '--t888-testimonial-text'],
            'style3_accent_color' => [__('Accent', 'nebon'), '#f45100', '--t888-testimonial-accent'],
            'style3_divider_color' => [__('Divider', 'nebon'), '#484848', '--t888-testimonial-divider'],
        ];

        foreach ($style3_colors as $control_id => $color_data) {
            $this->add_control(
                $control_id,
                [
                    'label' => $color_data[0],
                    'type' => Controls_Manager::COLOR,
                    'default' => $color_data[1],
                    'selectors' => [
                        '{{WRAPPER}} .t888-testimonial-style3' => $color_data[2] . ': {{VALUE}};',
                    ],
                ]
            );
        }

        $this->end_controls_section();
    }

    /**
     * Render widget output on the frontend.
     */
    protected function render()
    {
        parent::render();
        $settings = $this->get_settings_for_display();
        $style = isset($settings['style']) ? $settings['style'] : 'style1';
        tech888f_get_template_elementor_widget('t888-testimonial', $style, $settings, true);
    }
}
