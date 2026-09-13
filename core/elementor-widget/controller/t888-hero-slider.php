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
        return ['elementor-t888-hero-slider'];
    }

    public function get_script_depends()
    {
        return ['elementor-t888-hero-slider'];
    }

    public function enque_scripts()
    {
        $js_path = get_template_directory() . '/assets/js/elementor/' . $this->get_name() . '.js';
        if (file_exists($js_path)) {
            wp_register_script(
                'elementor-' . $this->get_name(),
                get_template_directory_uri() . '/assets/js/elementor/' . $this->get_name() . '.js',
                ['jquery'],
                filemtime($js_path),
                true
            );
            wp_enqueue_script('elementor-' . $this->get_name());
        }
    }

    protected function register_controls()
    {
        $this->start_controls_section('section_slides', [
            'label' => __('Banner Slides', 'nebon'),
        ]);

        $repeater = new Repeater();

        $repeater->add_control('background_image', [
            'label' => __('Desktop Banner', 'nebon'),
            'type' => Controls_Manager::MEDIA,
            'default' => [
                'url' => Utils::get_placeholder_image_src(),
            ],
            'description' => __('Recommended: use the same aspect ratio for every desktop slide.', 'nebon'),
        ]);

        $repeater->add_control('background_image_tablet', [
            'label' => __('Tablet Banner', 'nebon'),
            'type' => Controls_Manager::MEDIA,
            'description' => __('Optional. Falls back to the desktop banner when empty.', 'nebon'),
        ]);

        $repeater->add_control('background_image_mobile', [
            'label' => __('Mobile Banner', 'nebon'),
            'type' => Controls_Manager::MEDIA,
            'description' => __('Optional. Falls back to the tablet or desktop banner when empty.', 'nebon'),
        ]);

        $repeater->add_control('image_alt', [
            'label' => __('Image Alt Text', 'nebon'),
            'type' => Controls_Manager::TEXT,
            'label_block' => true,
            'description' => __('Describe the banner text or message for screen readers.', 'nebon'),
        ]);

        $this->add_control('slides', [
            'label' => __('Banners', 'nebon'),
            'type' => Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls(),
            'title_field' => __('Banner', 'nebon') . ' {{{ _id }}}',
            'default' => [
                ['background_image' => ['url' => Utils::get_placeholder_image_src()]],
                ['background_image' => ['url' => Utils::get_placeholder_image_src()]],
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
            'default' => '#1d90fd',
            'selectors' => [
                '{{WRAPPER}} .t888-industrial-hero' => '--t888-hero-accent: {{VALUE}};',
            ],
        ]);

        $this->add_responsive_control('arrow_size', [
            'label' => __('Arrow Button Size', 'nebon'),
            'type' => Controls_Manager::SLIDER,
            'range' => ['px' => ['min' => 36, 'max' => 100]],
            'default' => ['unit' => 'px', 'size' => 50],
            'tablet_default' => ['unit' => 'px', 'size' => 44],
            'selectors' => [
                '{{WRAPPER}} .t888-industrial-hero__arrow' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
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
