<?php

namespace Elementor;

class T888_Hero_Slider extends T888_Widget_Base
{
    public function get_name()
    {
        return 't888-hero-slider';
    }

    public function get_title()
    {
        return __('Industrial Hero Slider', 'nebon');
    }

    public function get_icon()
    {
        return 'eicon-slides';
    }

    public function get_categories()
    {
        return ['t888-elements'];
    }

    public function get_style_depends()
    {
        return ['t888-space-grotesk', 'elementor-t888-hero-slider'];
    }

    public function get_script_depends()
    {
        return ['t888-gsap', 'elementor-t888-hero-slider'];
    }

    public function enque_styles()
    {
        if (!wp_style_is('t888-space-grotesk', 'registered')) {
            wp_register_style(
                't888-space-grotesk',
                'https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&display=swap',
                [],
                null
            );
        }

        wp_enqueue_style('t888-space-grotesk');
        parent::enque_styles();
    }

    public function enque_scripts()
    {
        $gsap_path = get_template_directory() . '/assets/js/libs/gsap.min.js';
        if (!wp_script_is('t888-gsap', 'registered')) {
            wp_register_script(
                't888-gsap',
                get_template_directory_uri() . '/assets/js/libs/gsap.min.js',
                [],
                file_exists($gsap_path) ? filemtime($gsap_path) : '3.12.5',
                true
            );
        }

        $js_path = get_template_directory() . '/assets/js/elementor/' . $this->get_name() . '.js';
        if (file_exists($js_path)) {
            wp_register_script(
                'elementor-' . $this->get_name(),
                get_template_directory_uri() . '/assets/js/elementor/' . $this->get_name() . '.js',
                ['jquery', 't888-gsap'],
                filemtime($js_path),
                true
            );
            wp_enqueue_script('t888-gsap');
            wp_enqueue_script('elementor-' . $this->get_name());
        }
    }

    protected function register_controls()
    {
        $this->start_controls_section('section_slides', [
            'label' => __('Slides', 'nebon'),
        ]);

        $repeater = new Repeater();

        $repeater->add_control('background_image', [
            'label' => __('Background Image', 'nebon'),
            'type' => Controls_Manager::MEDIA,
            'default' => [
                'url' => Utils::get_placeholder_image_src(),
            ],
        ]);

        $repeater->add_control('title', [
            'label' => __('Title', 'nebon'),
            'type' => Controls_Manager::TEXTAREA,
            'default' => __('Engineering a Stronger Future', 'nebon'),
            'label_block' => true,
        ]);

        $repeater->add_control('description', [
            'label' => __('Description', 'nebon'),
            'type' => Controls_Manager::TEXTAREA,
            'default' => __('Industrial solutions built with precision, experience, and a commitment to lasting performance.', 'nebon'),
            'rows' => 4,
        ]);

        $repeater->add_control('button_text', [
            'label' => __('Button Text', 'nebon'),
            'type' => Controls_Manager::TEXT,
            'default' => __('Explore More', 'nebon'),
            'label_block' => true,
        ]);

        $repeater->add_control('button_link', [
            'label' => __('Button Link', 'nebon'),
            'type' => Controls_Manager::URL,
            'placeholder' => 'https://your-link.com',
            'default' => [
                'url' => '#',
            ],
        ]);

        $repeater->add_control('play_link', [
            'label' => __('Play Video Link', 'nebon'),
            'type' => Controls_Manager::URL,
            'placeholder' => 'https://www.youtube.com/watch?v=...',
            'default' => [
                'url' => '#',
            ],
            'description' => __('Leave empty to hide the play button.', 'nebon'),
        ]);

        $this->add_control('slides', [
            'label' => __('Hero Slides', 'nebon'),
            'type' => Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls(),
            'title_field' => '{{{ title }}}',
            'default' => [
                [
                    'title' => __('Engineering a Stronger Future', 'nebon'),
                    'description' => __('Industrial solutions built with precision, experience, and a commitment to lasting performance.', 'nebon'),
                    'button_text' => __('Explore More', 'nebon'),
                    'button_link' => ['url' => '#'],
                    'play_link' => ['url' => '#'],
                    'background_image' => ['url' => Utils::get_placeholder_image_src()],
                ],
                [
                    'title' => __('Powering Industry Forward', 'nebon'),
                    'description' => __('Reliable engineering and manufacturing capabilities for the industries that move the world.', 'nebon'),
                    'button_text' => __('Explore More', 'nebon'),
                    'button_link' => ['url' => '#'],
                    'play_link' => ['url' => '#'],
                    'background_image' => ['url' => Utils::get_placeholder_image_src()],
                ],
            ],
        ]);

        $this->add_control('title_tag', [
            'label' => __('Title HTML Tag', 'nebon'),
            'type' => Controls_Manager::SELECT,
            'default' => 'h1',
            'options' => [
                'h1' => 'H1',
                'h2' => 'H2',
                'h3' => 'H3',
                'div' => 'DIV',
            ],
        ]);

        $this->end_controls_section();

        $this->start_controls_section('section_sidebar', [
            'label' => __('Contact Sidebar', 'nebon'),
        ]);

        $this->add_control('show_sidebar', [
            'label' => __('Show Sidebar', 'nebon'),
            'type' => Controls_Manager::SWITCHER,
            'label_on' => __('Show', 'nebon'),
            'label_off' => __('Hide', 'nebon'),
            'return_value' => 'yes',
            'default' => 'yes',
        ]);

        $this->add_control('sidebar_phone_label', [
            'label' => __('Phone Label', 'nebon'),
            'type' => Controls_Manager::TEXT,
            'default' => __('Call:', 'nebon'),
            'label_block' => true,
            'condition' => ['show_sidebar' => 'yes'],
        ]);

        $this->add_control('sidebar_phone', [
            'label' => __('Phone Number', 'nebon'),
            'type' => Controls_Manager::TEXT,
            'default' => '+971 55 579 261',
            'label_block' => true,
            'condition' => ['show_sidebar' => 'yes'],
        ]);

        $this->add_control('sidebar_phone_link', [
            'label' => __('Phone Link', 'nebon'),
            'type' => Controls_Manager::URL,
            'placeholder' => 'tel:+97155579261',
            'default' => ['url' => 'tel:+97155579261'],
            'condition' => ['show_sidebar' => 'yes'],
        ]);

        $this->add_control('sidebar_email_label', [
            'label' => __('Email Label', 'nebon'),
            'type' => Controls_Manager::TEXT,
            'default' => __('Email:', 'nebon'),
            'label_block' => true,
            'condition' => ['show_sidebar' => 'yes'],
        ]);

        $this->add_control('sidebar_email', [
            'label' => __('Email Address', 'nebon'),
            'type' => Controls_Manager::TEXT,
            'default' => 'support.industrie@gmail.com',
            'label_block' => true,
            'condition' => ['show_sidebar' => 'yes'],
        ]);

        $this->add_control('sidebar_email_link', [
            'label' => __('Email Link', 'nebon'),
            'type' => Controls_Manager::URL,
            'placeholder' => 'mailto:support.industrie@gmail.com',
            'default' => ['url' => 'mailto:support.industrie@gmail.com'],
            'condition' => ['show_sidebar' => 'yes'],
        ]);

        $this->add_control('sidebar_scroll_label', [
            'label' => __('Bottom Button Accessible Label', 'nebon'),
            'type' => Controls_Manager::TEXT,
            'default' => __('Scroll to content', 'nebon'),
            'label_block' => true,
            'condition' => ['show_sidebar' => 'yes'],
        ]);

        $this->add_control('sidebar_scroll_link', [
            'label' => __('Bottom Button Link', 'nebon'),
            'type' => Controls_Manager::URL,
            'placeholder' => '#main-content',
            'default' => ['url' => '#main-content'],
            'description' => __('Enter the CSS ID of the section below, for example #about.', 'nebon'),
            'condition' => ['show_sidebar' => 'yes'],
        ]);

        $this->end_controls_section();

        $this->start_controls_section('section_layout_style', [
            'label' => __('Layout', 'nebon'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_responsive_control('slider_height', [
            'label' => __('Slider Height', 'nebon'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px', 'vh'],
            'range' => [
                'px' => ['min' => 350, 'max' => 1200],
                'vh' => ['min' => 30, 'max' => 100],
            ],
            'default' => ['unit' => 'px', 'size' => 860],
            'tablet_default' => ['unit' => 'px', 'size' => 700],
            'mobile_default' => ['unit' => 'px', 'size' => 620],
            'selectors' => [
                '{{WRAPPER}} .t888-industrial-hero' => 'height: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->add_responsive_control('container_width', [
            'label' => __('Container Width', 'nebon'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range' => ['px' => ['min' => 600, 'max' => 1800]],
            'default' => ['unit' => 'px', 'size' => 1200],
            'selectors' => [
                '{{WRAPPER}} .t888-industrial-hero' => '--t888-hero-container: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->add_responsive_control('content_width', [
            'label' => __('Content Width', 'nebon'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px', '%'],
            'range' => [
                'px' => ['min' => 280, 'max' => 1100],
                '%' => ['min' => 30, 'max' => 100],
            ],
            'default' => ['unit' => 'px', 'size' => 850],
            'selectors' => [
                '{{WRAPPER}} .t888-industrial-hero__content' => 'max-width: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->add_responsive_control('content_padding', [
            'label' => __('Content Padding', 'nebon'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'default' => [
                'top' => 40, 'right' => 16, 'bottom' => 40, 'left' => 16,
                'unit' => 'px', 'isLinked' => false,
            ],
            'selectors' => [
                '{{WRAPPER}} .t888-industrial-hero__container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->add_control('overlay_color', [
            'label' => __('Overlay Color', 'nebon'),
            'type' => Controls_Manager::COLOR,
            'default' => '#000000',
            'selectors' => [
                '{{WRAPPER}} .t888-industrial-hero__overlay' => 'background-color: {{VALUE}};',
            ],
        ]);

        $this->add_control('overlay_opacity', [
            'label' => __('Overlay Opacity', 'nebon'),
            'type' => Controls_Manager::SLIDER,
            'range' => ['px' => ['min' => 0, 'max' => 1, 'step' => 0.01]],
            'default' => ['size' => 0.28],
            'selectors' => [
                '{{WRAPPER}} .t888-industrial-hero__overlay' => 'opacity: {{SIZE}};',
            ],
        ]);

        $this->end_controls_section();

        $this->start_controls_section('section_sidebar_style', [
            'label' => __('Contact Sidebar', 'nebon'),
            'tab' => Controls_Manager::TAB_STYLE,
            'condition' => ['show_sidebar' => 'yes'],
        ]);

        $this->add_responsive_control('sidebar_width', [
            'label' => __('Width', 'nebon'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range' => ['px' => ['min' => 72, 'max' => 180]],
            'default' => ['unit' => 'px', 'size' => 108],
            'selectors' => [
                '{{WRAPPER}} .t888-industrial-hero' => '--t888-hero-sidebar-width: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->add_control('sidebar_background', [
            'label' => __('Background Color', 'nebon'),
            'type' => Controls_Manager::COLOR,
            'default' => '#ffffff',
            'selectors' => [
                '{{WRAPPER}} .t888-industrial-hero__sidebar' => 'background-color: {{VALUE}};',
            ],
        ]);

        $this->add_control('sidebar_text_color', [
            'label' => __('Text Color', 'nebon'),
            'type' => Controls_Manager::COLOR,
            'default' => '#262626',
            'selectors' => [
                '{{WRAPPER}} .t888-industrial-hero__contact-link' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'sidebar_typography',
            'selector' => '{{WRAPPER}} .t888-industrial-hero__contact-link',
            'fields_options' => [
                'font_family' => ['default' => 'Space Grotesk'],
                'font_weight' => ['default' => '500'],
            ],
        ]);

        $this->add_control('sidebar_accent_color', [
            'label' => __('Button Color', 'nebon'),
            'type' => Controls_Manager::COLOR,
            'default' => '#EA5501',
            'selectors' => [
                '{{WRAPPER}} .t888-industrial-hero__sidebar-scroll' => 'background-color: {{VALUE}};',
            ],
        ]);

        $this->add_responsive_control('sidebar_button_height', [
            'label' => __('Bottom Button Height', 'nebon'),
            'type' => Controls_Manager::SLIDER,
            'range' => ['px' => ['min' => 60, 'max' => 150]],
            'default' => ['unit' => 'px', 'size' => 88],
            'selectors' => [
                '{{WRAPPER}} .t888-industrial-hero__sidebar-scroll' => 'height: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->end_controls_section();

        $this->start_controls_section('section_content_style', [
            'label' => __('Content', 'nebon'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('title_color', [
            'label' => __('Title Color', 'nebon'),
            'type' => Controls_Manager::COLOR,
            'default' => '#ffffff',
            'selectors' => [
                '{{WRAPPER}} .t888-industrial-hero__title' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'title_typography',
            'selector' => '{{WRAPPER}} .t888-industrial-hero__title',
            'fields_options' => [
                'font_family' => ['default' => 'Space Grotesk'],
                'font_weight' => ['default' => '700'],
            ],
        ]);

        $this->add_responsive_control('title_bottom_space', [
            'label' => __('Title Bottom Spacing', 'nebon'),
            'type' => Controls_Manager::SLIDER,
            'range' => ['px' => ['min' => 0, 'max' => 100]],
            'default' => ['unit' => 'px', 'size' => 24],
            'selectors' => [
                '{{WRAPPER}} .t888-industrial-hero__title-wrap' => 'margin-bottom: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->add_control('description_color', [
            'label' => __('Description Color', 'nebon'),
            'type' => Controls_Manager::COLOR,
            'default' => 'rgba(255,255,255,0.86)',
            'selectors' => [
                '{{WRAPPER}} .t888-industrial-hero__description' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'description_typography',
            'selector' => '{{WRAPPER}} .t888-industrial-hero__description',
        ]);

        $this->add_responsive_control('description_bottom_space', [
            'label' => __('Description Bottom Spacing', 'nebon'),
            'type' => Controls_Manager::SLIDER,
            'range' => ['px' => ['min' => 0, 'max' => 100]],
            'default' => ['unit' => 'px', 'size' => 38],
            'selectors' => [
                '{{WRAPPER}} .t888-industrial-hero__description-wrap' => 'margin-bottom: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->end_controls_section();

        $this->start_controls_section('section_actions_style', [
            'label' => __('Buttons', 'nebon'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'button_typography',
            'selector' => '{{WRAPPER}} .t888-industrial-hero__button',
        ]);

        $this->add_control('button_text_color', [
            'label' => __('Button Text Color', 'nebon'),
            'type' => Controls_Manager::COLOR,
            'default' => '#ffffff',
            'selectors' => [
                '{{WRAPPER}} .t888-industrial-hero__button' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('button_background', [
            'label' => __('Button Background', 'nebon'),
            'type' => Controls_Manager::COLOR,
            'default' => '#EA5501',
            'selectors' => [
                '{{WRAPPER}} .t888-industrial-hero__button' => 'background-color: {{VALUE}};',
            ],
        ]);

        $this->add_responsive_control('button_padding', [
            'label' => __('Button Padding', 'nebon'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em'],
            'default' => [
                'top' => 16, 'right' => 30, 'bottom' => 16, 'left' => 30,
                'unit' => 'px', 'isLinked' => false,
            ],
            'selectors' => [
                '{{WRAPPER}} .t888-industrial-hero__button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->add_control('play_size', [
            'label' => __('Play Button Size', 'nebon'),
            'type' => Controls_Manager::SLIDER,
            'range' => ['px' => ['min' => 40, 'max' => 120]],
            'default' => ['unit' => 'px', 'size' => 58],
            'selectors' => [
                '{{WRAPPER}} .t888-industrial-hero__play' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->end_controls_section();

        $this->start_controls_section('section_navigation_style', [
            'label' => __('Navigation', 'nebon'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('navigation_color', [
            'label' => __('Navigation Color', 'nebon'),
            'type' => Controls_Manager::COLOR,
            'default' => '#EA5501',
            'selectors' => [
                '{{WRAPPER}} .t888-industrial-hero' => '--t888-hero-accent: {{VALUE}};',
            ],
        ]);

        $this->add_control('arrow_size', [
            'label' => __('Arrow Button Size', 'nebon'),
            'type' => Controls_Manager::SLIDER,
            'range' => ['px' => ['min' => 36, 'max' => 100]],
            'default' => ['unit' => 'px', 'size' => 50],
            'selectors' => [
                '{{WRAPPER}} .t888-industrial-hero__arrow' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->add_control('bullet_size', [
            'label' => __('Bullet Size', 'nebon'),
            'type' => Controls_Manager::SLIDER,
            'range' => ['px' => ['min' => 8, 'max' => 30]],
            'default' => ['unit' => 'px', 'size' => 16],
            'selectors' => [
                '{{WRAPPER}} .t888-industrial-hero__bullet' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->end_controls_section();
    }

    protected function render()
    {
        parent::render();
        $settings = $this->get_settings_for_display();
        $settings['widget_id'] = $this->get_id();
        tech888f_get_template_elementor_widget('t888-hero-slider', false, $settings, true);
    }
}
