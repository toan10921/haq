<?php

/**
 * Created by khangtrinh.
 * User: khangtrinh
 * Date: 13/06/2024
 * Time: 04:20 PM
 */

namespace Elementor;

use Elementor\Widget_Base;

// if (!defined('ABSPATH')) {
//     exit; // Exit if accessed directly
// }

class T888_Slider extends T888_Widget_Base
{

    /**
     * Get widget name.
     *
     * Retrieve the widget name.
     *
     * @return string Widget name.
     */
    public function get_name()
    {
        return 't888-slider';
    }

    /**
     * Get widget title.
     *
     * Retrieve the widget title.
     *
     * @return string Widget title.
     */
    public function get_title()
    {
        return 'Swiper Slider';
    }

    /**
     * Get widget icon.
     *
     * Retrieve the widget icon.
     *
     * @return string Widget icon.
     */
    public function get_icon()
    {
        return 'fas fa-desktop';
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
        return ['elementor-t888-slider', 'swiper'];
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
        return ['elementor-t888-slider', 'e-swiper'];
    }


    /**
     * Get widget categories.
     *
     * Retrieve the list of categories the widget belongs to.
     *
     * @return array Widget categories.
     */
    public function get_categories()
    {
        return ['t888-elements'];
    }

    /**
     * Get button sizes.
     *
     * Retrieve the list of button sizes.
     *
     * @return array Button sizes.
     */
    public static function get_button_sizes()
    {
        return [
            'xs' => __('Extra Small', 'nebon'),
            'sm' => __('Small', 'nebon'),
            'md' => __('Medium', 'nebon'),
            'lg' => __('Large', 'nebon'),
            'xl' => __('Extra Large', 'nebon'),
        ];
    }

    /**
     * Register controls.
     *
     * Add input fields to allow the user to customize the widget settings.
     */
    protected function register_controls()
    {
        $this->start_controls_section(
            'section_slides',
            [
                'label' => __('Slides', 'nebon'),
            ]
        );

        $repeater = new Repeater();

        $repeater->start_controls_tabs('slides_repeater');

        $repeater->start_controls_tab('background', ['label' => __('Background', 'nebon')]);


        $repeater->add_control(
            'background_image',
            [
                'label' => esc_html__('Background Image', 'nebon'),
                'type' => Controls_Manager::MEDIA,
            ]
        );

        $repeater->end_controls_tab();

        $repeater->start_controls_tab('style', ['label' => __('Style', 'nebon')]);


        $repeater->add_control(
            'custom_style',
            [
                'label' => __('Custom', 'nebon'),
                'type' => Controls_Manager::SWITCHER,
                'description' => __('Set custom style that will only affect this specific slide.', 'nebon'),
            ]
        );

        $repeater->add_control(
            'horizontal_position',
            [
                'label' => __('Horizontal Position', 'nebon'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'nebon'),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'nebon'),
                        'icon' => 'eicon-h-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', 'nebon'),
                        'icon' => 'eicon-h-align-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .swiper-slide-contents' => '{{VALUE}}',
                ],
                'selectors_dictionary' => [
                    'left' => 'margin-right: auto',
                    'center' => 'margin: 0 auto',
                    'right' => 'margin-left: auto',
                ],
                'conditions' => [
                    'terms' => [
                        [
                            'name' => 'custom_style',
                            'value' => 'yes',
                        ],
                    ],
                ],
            ]
        );

        $repeater->add_control(
            'vertical_position',
            [
                'label' => __('Vertical Position', 'nebon'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'top' => [
                        'title' => __('Top', 'nebon'),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'middle' => [
                        'title' => __('Middle', 'nebon'),
                        'icon' => 'eicon-v-align-middle',
                    ],
                    'bottom' => [
                        'title' => __('Bottom', 'nebon'),
                        'icon' => 'eicon-v-align-bottom',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .swiper-slide-inner' => 'align-items: {{VALUE}}',
                ],
                'selectors_dictionary' => [
                    'top' => 'flex-start',
                    'middle' => 'center',
                    'bottom' => 'flex-end',
                ],
                'conditions' => [
                    'terms' => [
                        [
                            'name' => 'custom_style',
                            'value' => 'yes',
                        ],
                    ],
                ],
            ]
        );

        $repeater->add_control(
            'text_align',
            [
                'label' => __('Text Align', 'nebon'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'nebon'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'nebon'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', 'nebon'),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .swiper-slide-inner' => 'text-align: {{VALUE}}',
                ],
                'conditions' => [
                    'terms' => [
                        [
                            'name' => 'custom_style',
                            'value' => 'yes',
                        ],
                    ],
                ],
            ]
        );

        $repeater->add_control(
            'content_color',
            [
                'label' => __('Content Color', 'nebon'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .swiper-slide-inner .elementor-slide-heading' => 'color: {{VALUE}}',
                    '{{WRAPPER}} {{CURRENT_ITEM}} .swiper-slide-inner .elementor-slide-description' => 'color: {{VALUE}}',
                    '{{WRAPPER}} {{CURRENT_ITEM}} .swiper-slide-inner .elementor-slide-button' => 'color: {{VALUE}}; border-color: {{VALUE}}',
                ],
                'conditions' => [
                    'terms' => [
                        [
                            'name' => 'custom_style',
                            'value' => 'yes',
                        ],
                    ],
                ],
            ]
        );

        $repeater->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name' => 'repeater_text_shadow',
                'selector' => '{{WRAPPER}} {{CURRENT_ITEM}} .swiper-slide-contents',
                'conditions' => [
                    'terms' => [
                        [
                            'name' => 'custom_style',
                            'value' => 'yes',
                        ],
                    ],
                ],
            ]
        );

        $repeater->end_controls_tab();

        $repeater->end_controls_tabs();
      
            $repeater->add_control(
            'slide_badge_text',
            [
                'label' => __('Badge Text (e.g. NEW)', 'nebon'),
                'type' => Controls_Manager::TEXT,
                'default' => __('NEW', 'nebon'),
                'label_block' => true,
            ]
            );
            $repeater->add_control(
                'slide_badge_text_color',
                [
                    'label' => __('Badge Text Color', 'nebon'),
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'default' => '#ffffff',
                    'selectors' => [
                        '{{WRAPPER}} {{CURRENT_ITEM}} .slide-badge' => 'color: {{VALUE}};',
                    ],
                ]
            );
        $repeater->add_control(
            'slide_title',
            [
                'label' => __('Slide Title', 'nebon'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Your Slide Title', 'nebon'),
                'label_block' => true,
            ]
        );
        $repeater->add_control(
            'slide_title_color',
            [
                'label' => __('Slide Title Color', 'nebon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#000000',
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .slide-title' => 'color: {{VALUE}};',
                ],
            ]
        );
        $repeater->add_control(
            'slide_title2',
            [
                'label' => __('Slide Title 2', 'nebon'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Your Slide Title 2', 'nebon'),
                'label_block' => true,
            ]
        );
        $repeater->add_control(
            'slide_title2_color',
            [
                'label' => __('Slide Title 2 Color', 'nebon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#000000',
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .slide-title-2' => 'color: {{VALUE}};',
                ],
            ]
        );
        $repeater->add_control(
            'slide_description',
            [
                'label' => __('Slide Description', 'nebon'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => __('Your slide short description goes here.', 'nebon'),
                'label_block' => true,
            ]
        );
        $repeater->add_control(
            'slide_description_color',
            [
                'label' => __('Description Color', 'nebon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#000000',
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .slide-description' => 'color: {{VALUE}};',
                ],
            ]
        );
        $repeater->add_control(
            'slide_button_text',
            [
                'label' => __('Button Text', 'nebon'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Read More', 'nebon'),
                'label_block' => true,
            ]
        );
        $repeater->add_control(
            'slide_button_color',
            [
                'label' => __('Button Text Color', 'nebon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .slide-btn' => 'color: {{VALUE}};',
                ],
            ]
        );
        $repeater->add_control(
            'slide_button_bg_color',
            [
                'label' => __('Button Background Color', 'nebon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#000000',
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .slide-btn' => 'background-color: {{VALUE}};',
                ],
            ]
            );
        $repeater->add_control(
            'slide_button_link',
            [
                'label' => __('Button Link', 'nebon'),
                'type' => Controls_Manager::URL,
                'placeholder' => __('https://your-link.com', 'nebon'),
                'label_block' => true,
            ]
        );
        $repeater->add_control(
            'slide_button_text2',
            [
                'label' => __('Button Text 2', 'nebon'),
                'type' => Controls_Manager::TEXT,
                // 'default' => __('Read More', 'nebon'),
                'label_block' => true,
            ]
        );
        $repeater->add_control(
            'slide_button_color2',
            [
                'label' => __('Button Text 2 Color', 'nebon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#000000',
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .slide-btn2' => 'color: {{VALUE}};',
                ],
            ]
        );
        $repeater->add_control(
            'slide_button_bg_color2',
            [
                'label' => __('Button Background Color 2', 'nebon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .slide-btn2' => 'background-color: {{VALUE}};',
                ],
            ]
            );
        $repeater->add_control(
            'slide_button_link2',
            [
                'label' => __('Button Link 2', 'nebon'),
                'type' => Controls_Manager::URL,
                'placeholder' => __('https://your-link.com', 'nebon'),
                'label_block' => true,
            ]
        );
        $this->add_control(
            'slides',
            [
                'label' => __('Slides', 'nebon'),
                'type' => Controls_Manager::REPEATER,
                'show_label' => true,
                'fields' => $repeater->get_controls(),
                'default' => [],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_slider_options',
            [
                'label' => __('Slider Options', 'nebon'),
                'type' => Controls_Manager::SECTION,
            ]
        );

        $this->add_control(
            'navigation',
            [
                'label' => __('Navigation', 'nebon'),
                'type' => Controls_Manager::SELECT,
                'default' => 'dots',
                'options' => [
                    'both' => __('Arrows and Dots', 'nebon'),
                    'arrows' => __('Arrows', 'nebon'),
                    'dots' => __('Dots', 'nebon'),
                    'none' => __('None', 'nebon'),
                ],
                'frontend_available' => true,
            ]
        );

        $this->add_control(
            'autoplay',
            [
                'label' => __('Autoplay', 'nebon'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'frontend_available' => true,
            ]
        );

        $this->add_control(
            'pause_on_hover',
            [
                'label' => __('Pause on Hover', 'nebon'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'render_type' => 'none',
                'frontend_available' => true,
                'condition' => [
                    'autoplay!' => '',
                ],
            ]
        );

        $this->add_control(
            'pause_on_interaction',
            [
                'label' => __('Pause on Interaction', 'nebon'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'render_type' => 'none',
                'frontend_available' => true,
                'condition' => [
                    'autoplay!' => '',
                ],
            ]
        );

        $this->add_control(
            'autoplay_speed',
            [
                'label' => __('Autoplay Speed', 'nebon'),
                'type' => Controls_Manager::NUMBER,
                'default' => 5000,
                'condition' => [
                    'autoplay' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-slide' => 'transition-duration: calc({{VALUE}}ms*1.2)',
                ],
                'render_type' => 'none',
                'frontend_available' => true,
            ]
        );

        $this->add_control(
            'infinite',
            [
                'label' => __('Infinite Loop', 'nebon'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'frontend_available' => true,
            ]
        );

        $this->add_control(
            'transition',
            [
                'label' => __('Transition', 'nebon'),
                'type' => Controls_Manager::SELECT,
                'default' => 'slide',
                'options' => [
                    'slide' => __('Slide', 'nebon'),
                    'fade' => __('Fade', 'nebon'),
                ],
                'frontend_available' => true,
            ]
        );

        $this->add_control(
            'transition_speed',
            [
                'label' => __('Transition Speed', 'nebon') . ' (ms)',
                'type' => Controls_Manager::NUMBER,
                'default' => 500,
                'render_type' => 'none',
                'frontend_available' => true,
            ]
        );

        $this->add_control(
            'content_animation',
            [
                'label' => __('Content Animation', 'nebon'),
                'type' => Controls_Manager::SELECT,
                'default' => 'fadeInUp',
                'options' => [
                    '' => __('None', 'nebon'),
                    'fadeInDown' => __('Down', 'nebon'),
                    'fadeInUp' => __('Up', 'nebon'),
                    'fadeInRight' => __('Right', 'nebon'),
                    'fadeInLeft' => __('Left', 'nebon'),
                    'zoomIn' => __('Zoom', 'nebon'),
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_slides',
            [
                'label' => __('Slides', 'nebon'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'content_max_width',
            [
                'label' => __('Content Width', 'nebon'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'size_units' => ['%', 'px'],
                'default' => [
                    'size' => '100',
                    'unit' => '%',
                ],
                'tablet_default' => [
                    'unit' => '%',
                ],
                'mobile_default' => [
                    'unit' => '%',
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-slide-contents' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'slides_padding',
            [
                'label' => __('Padding', 'nebon'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .swiper-slide-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'slides_horizontal_position',
            [
                'label' => __('Horizontal Position', 'nebon'),
                'type' => Controls_Manager::CHOOSE,
                'default' => 'left',
                'options' => [
                    'left' => [
                        'title' => __('Left', 'nebon'),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'nebon'),
                        'icon' => 'eicon-h-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', 'nebon'),
                        'icon' => 'eicon-h-align-right',
                    ],
                ],
                'prefix_class' => 'elementor--h-position-',
            ]
        );

        $this->add_control(
            'slides_vertical_position',
            [
                'label' => __('Vertical Position', 'nebon'),
                'type' => Controls_Manager::CHOOSE,
                'default' => 'middle',
                'options' => [
                    'top' => [
                        'title' => __('Top', 'nebon'),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'middle' => [
                        'title' => __('Middle', 'nebon'),
                        'icon' => 'eicon-v-align-middle',
                    ],
                    'bottom' => [
                        'title' => __('Bottom', 'nebon'),
                        'icon' => 'eicon-v-align-bottom',
                    ],
                ],
                'prefix_class' => 'elementor--v-position-',
            ]
        );

        $this->add_control(
            'slides_text_align',
            [
                'label' => __('Text Align', 'nebon'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'nebon'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'nebon'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', 'nebon'),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .swiper-slide-inner' => 'text-align: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name' => 'text_shadow',
                'selector' => '{{WRAPPER}} .swiper-slide-contents',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_title',
            [
                'label' => __('Title', 'nebon'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'heading_spacing',
            [
                'label' => __('Spacing', 'nebon'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-slide-inner .elementor-slide-heading:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_control(
            'heading_color',
            [
                'label' => __('Text Color', 'nebon'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-slide-heading' => 'color: {{VALUE}}',

                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_description',
            [
                'label' => __('Description', 'nebon'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'description_spacing',
            [
                'label' => __('Spacing', 'nebon'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-slide-inner .elementor-slide-description:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_control(
            'description_color',
            [
                'label' => __('Text Color', 'nebon'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-slide-description' => 'color: {{VALUE}}',

                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_button',
            [
                'label' => __('Button', 'nebon'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'button_size',
            [
                'label' => __('Size', 'nebon'),
                'type' => Controls_Manager::SELECT,
                'default' => 'sm',
                'options' => self::get_button_sizes(),
            ]
        );

        $this->add_control(
            'button_border_width',
            [
                'label' => __('Border Width', 'nebon'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 20,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-slide-button' => 'border-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'button_border_radius',
            [
                'label' => __('Border Radius', 'nebon'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-slide-button' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('button_tabs');

        $this->start_controls_tab('normal', ['label' => __('Normal', 'nebon')]);


        $this->add_control(
            'button_text_color',
            [
                'label' => __('Text Color', 'nebon'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-slide-button' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'button_background',
                'types' => ['classic', 'gradient'],
                'exclude' => ['image'],
                'selector' => '{{WRAPPER}} .elementor-slide-button',
                'fields_options' => [
                    'background' => [
                        'default' => 'classic',
                    ],
                ],
            ]
        );

        $this->add_control(
            'button_border_color',
            [
                'label' => __('Border Color', 'nebon'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-slide-button' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab('hover', ['label' => __('Hover', 'nebon')]);


        $this->add_control(
            'button_hover_text_color',
            [
                'label' => __('Text Color', 'nebon'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-slide-button:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'button_hover_background',
                'types' => ['classic', 'gradient'],
                'exclude' => ['image'],
                'selector' => '{{WRAPPER}} .elementor-slide-button:hover',
                'fields_options' => [
                    'background' => [
                        'default' => 'classic',
                    ],
                ],
            ]
        );

        $this->add_control(
            'button_hover_border_color',
            [
                'label' => __('Border Color', 'nebon'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-slide-button:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_navigation',
            [
                'label' => __('Navigation', 'nebon'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'navigation' => ['arrows', 'dots', 'both'],
                ],
            ]
        );

        $this->add_control(
            'heading_style_arrows',
            [
                'label' => __('Arrows', 'nebon'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'navigation' => ['arrows', 'both'],
                ],
            ]
        );

        $this->add_control(
            'arrows_position',
            [
                'label' => __('Arrows Position', 'nebon'),
                'type' => Controls_Manager::SELECT,
                'default' => 'inside',
                'options' => [
                    'inside' => __('Inside', 'nebon'),
                    'outside' => __('Outside', 'nebon'),
                ],
                'prefix_class' => 'elementor-arrows-position-',
                'condition' => [
                    'navigation' => ['arrows', 'both'],
                ],
            ]
        );

        $this->add_control(
            'arrows_size',
            [
                'label' => __('Arrows Size', 'nebon'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 20,
                        'max' => 60,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-swiper-button' => 'font-size: {{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'navigation' => ['arrows', 'both'],
                ],
            ]
        );

        $this->add_control(
            'arrows_color',
            [
                'label' => __('Arrows Color', 'nebon'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-swiper-button' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'navigation' => ['arrows', 'both'],
                ],
            ]
        );

        $this->add_control(
            'heading_style_dots',
            [
                'label' => __('Dots', 'nebon'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'navigation' => ['dots', 'both'],
                ],
            ]
        );

        $this->add_control(
            'dots_position',
            [
                'label' => __('Dots Position', 'nebon'),
                'type' => Controls_Manager::SELECT,
                'default' => 'inside',
                'options' => [
                    'outside' => __('Outside', 'nebon'),
                    'inside' => __('Inside', 'nebon'),
                ],
                'prefix_class' => 'elementor-pagination-position-',
                'condition' => [
                    'navigation' => ['dots', 'both'],
                ],
            ]
        );

        $this->add_control(
            'dots_size',
            [
                'label' => __('Dots Size', 'nebon'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 5,
                        'max' => 15,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination-bullet' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}} .swiper-container-horizontal .swiper-pagination-progressbar' => 'height: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}} .swiper-pagination-fraction' => 'font-size: {{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'navigation' => ['dots', 'both'],
                ],
            ]
        );

        $this->add_control(
            'dots_color',
            [
                'label' => __('Dots Color', 'nebon'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination-bullet-active' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'navigation' => ['dots', 'both'],
                ],
            ]
        );

        $this->end_controls_section();
    }


    /**
     * Render widget output on the frontend.
     *
     * Generate the final HTML on the frontend.
     */
    protected function render()
    {
        $this->enque_styles();
        $this->enque_scripts();

        $settings = $this->get_settings();

        if (empty($settings['slides'])) {
            return;
        }

        $this->add_render_attribute('button', 'class', ['elementor-button', 'elementor-slide-button']);

        if (!empty($settings['button_size'])) {
            $this->add_render_attribute('button', 'class', 'elementor-size-' . $settings['button_size']);
        }

        $slides = [];
        $slide_count = 0;

        foreach ($settings['slides'] as $slide) {
            $image_desktop = $slide['background_image']['url'] ?? '';
            $image_mobile = $slide['background_image_mobile']['url'] ?? $image_desktop;
$slide_badge_text = $slide['slide_badge_text'] ?? '';
            $slide_title = $slide['slide_title'] ?? '';
            $slide_title2 = $slide['slide_title2'] ?? '';
            $slide_description = $slide['slide_description'] ?? '';
            $slide_button_text = $slide['slide_button_text'] ?? '';
            $slide_button_link = $slide['slide_button_link']['url'] ?? '';
            $slide_button_target = !empty($slide['slide_button_link']['is_external']) ? ' target="_blank"' : '';
            $slide_button_rel = !empty($slide['slide_button_link']['nofollow']) ? ' rel="nofollow"' : '';

            $slide_html = '';
            $slide_attributes = '';
            $slide_element = 'div';

            $slide_html .= '<' . $slide_element . ' class="swiper-slide-inner fix-img-wrap2" ' . $slide_attributes . '>';
            $slide_html .= '<div class="swiper-slide-contents fix-img-wrap1">';

            $slide_html .= '<div class="img-wrap fix-img-wrap">';
            $slide_html .= '<img class="img-lazy" style="width:100%;" data-desktop="' . esc_url($image_desktop) . '" data-mobile="' . esc_url($image_mobile) . '" src="' . esc_url($image_desktop) . '"/>';
            $slide_html .= '</div>';

            $slide_html .= '<div class="slide-content-wrapper">';
            $slide_html .= '<div class="container">';
            $slide_html .= '<div class="slide-content">';

            if (!empty($slide_badge_text)) {
                $slide_html .= '<div class="slide-badge" style="color:' . esc_attr($slide['slide_badge_text_color']) . ';">' . esc_html($slide_badge_text) . '</div>';
            }
            if (!empty($slide_title)) {
                $slide_html .= '<div class="slide-title">' . esc_html($slide_title) . '</div>';
            }
            if (!empty($slide_title2)) {
                $slide_html .= '<div class="slide-title-2">' . esc_html($slide_title2) . '</div>';
            }
            if (!empty($slide_description)) {
                $slide_html .= '<div class="slide-description">' . esc_html($slide_description) . '</div>';
            }
            if (!empty($slide_button_text)) {
                $slide_html .= '<a href="' . esc_url($slide_button_link) . '" class="slide-btn"' . $slide_button_target . $slide_button_rel . '>';
                $slide_html .= '<span>' . esc_html($slide_button_text) . '</span></a>';
            }
            if (!empty($slide['slide_button_text2'])) {
                $slide_html .= '<a href="' . esc_url($slide['slide_button_link2']['url']) . '" class="slide-btn2"' . $slide_button_target . $slide_button_rel . '>';
                $slide_html .= '<span>' . esc_html($slide['slide_button_text2']) . '</span></a>';
            }
            $slide_html .= '</div>'; // .slide-content
            $slide_html .= '</div>'; // .elementor-container
            $slide_html .= '</div>'; // .slide-content-wrapper

            $slide_html .= '</div>'; // .swiper-slide-contents
            $slide_html .= '</' . $slide_element . '>';


            // Overlay
            if (!empty($slide['background_overlay']) && $slide['background_overlay'] === 'yes') {
                $slide_html = '<div class="elementor-background-overlay"></div>' . $slide_html;
            }

            // Ken burns effect
            $ken_class = '';
            if (!empty($slide['background_ken_burns']) && $slide['background_ken_burns']) {
                $ken_class = ' elementor-ken-burns elementor-ken-burns--' . $slide['zoom_direction'];
            }
            $slide_html = '<div class="swiper-slide-bg' . esc_attr($ken_class) . '"></div>' . $slide_html;

            // Wrap slide
            $slides[] = '<div class="elementor-repeater-item-' . esc_attr($slide['_id']) . ' swiper-slide">' . $slide_html . '</div>';
            $slide_count++;
        }

        $prev = 'left';
        $next = 'right';
        $direction = 'ltr';

        if (is_rtl()) {
            $prev = 'right';
            $next = 'left';
            $direction = 'rtl';
        }

        $show_dots = in_array($settings['navigation'], ['dots', 'both']);
        $show_arrows = in_array($settings['navigation'], ['arrows', 'both']);
        $slides_count = count($settings['slides']);
?>
        <div class="elementor-swiper t888-home-slider">
            <div class="swiper-container eltech888-swiper-slider"
                dir="<?php echo esc_attr($direction); ?>"
                data-item-desktop="1"
                data-item-tablet="1"
                data-item-mobile="1"
                data-pagination="bullets"
                data-animation="<?php echo esc_attr($settings['content_animation']); ?>"
                data-autoplay="<?php echo esc_attr($settings['autoplay']); ?>"
                data-speed="<?php echo esc_attr($settings['autoplay_speed'] ?? ''); ?>"
                data-pause-on-hover="<?php echo esc_attr($settings['pause_on_hover'] ?? ''); ?>"
                data-pause-on-interaction="<?php echo esc_attr($settings['pause_on_interaction'] ?? ''); ?>"
                data-infinite="<?php echo esc_attr($settings['infinite'] ?? ''); ?>"
                data-effect="<?php echo esc_attr($settings['transition'] ?? ''); ?>"
                data-transition-speed="<?php echo esc_attr($settings['transition_speed'] ?? ''); ?>"
                data-item="1"
                data-dots="<?php echo esc_attr($show_dots); ?>"
                data-arrows="<?php echo esc_attr($show_arrows); ?>">
                <div class="swiper-wrapper elementor-slides">
                    <?php echo implode('', $slides); ?>
                </div>

                <?php if ($slides_count > 1): ?>
                    <?php if ($show_dots): ?>
                        <div class="swiper-pagination mmm t888-pagination-line"></div>
                    <?php endif; ?>
                    <?php if ($show_arrows): ?>
                        <div class="elementor-swiper-button elementor-swiper-button-prev swiper-button-prev">
                            <i class="eicon-chevron-<?php echo esc_attr($prev); ?>" aria-hidden="true"></i>
                            <span class="elementor-screen-only"><?php _e('Previous', 'nebon'); ?></span>
                        </div>
                        <div class="elementor-swiper-button elementor-swiper-button-next swiper-button-next">
                            <i class="eicon-chevron-<?php echo esc_attr($next); ?>" aria-hidden="true"></i>
                            <span class="elementor-screen-only"><?php _e('Next', 'nebon'); ?></span>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>

<?php
    }


    /**
     * Render Slides widget output in the editor.
     *
     * Written as a Backbone JavaScript template and used to generate the live preview.
     *
     * @since 2.9.0
     * @access protected
     */
    // protected function content_template() {}
}
