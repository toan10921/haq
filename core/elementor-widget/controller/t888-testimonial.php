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
                ]
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
