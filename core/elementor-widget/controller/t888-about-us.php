<?php

namespace Elementor;

class T888_About_Us extends T888_Widget_Base
{

    public function get_name()
    {
        return 't888-about-us';
    }

    public function get_title()
    {
        return __('About Us', 'nebon');
    }

    public function get_icon()
    {
        return 'fas fa-circle-user';
    }

    public function get_categories()
    {
        return ['t888-elements'];
    }

    public function get_script_depends()
    {
        return ['elementor-t888-about-us'];
    }

    public function get_style_depends()
    {
        return ['elementor-t888-about-us'];
    }

    protected function _register_controls()
    {
        $this->start_controls_section(
            'section_content',
            [
                'label' => __('Content', 'nebon'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        // Background image
        $this->add_control(
            'background_image',
            [
                'label' => __('Background Image', 'nebon'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        // Title 1
        $this->add_control(
            'title_1',
            [
                'label' => __('Main Title', 'nebon'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('WHO ARE WE?', 'nebon'),
                'label_block' => true,
            ]
        );

        // Title 2
        $this->add_control(
            'title_2',
            [
                'label' => __('Sub Title', 'nebon'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => __('EMBARK ON OUR INNOVATIVE JOURNEY OF BEAUTY AND WELL-BEING.', 'nebon'),
                'label_block' => true,
            ]
        );

        // Button text
        $this->add_control(
            'button_text',
            [
                'label' => __('Button Text', 'nebon'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('SEE OUR STORY', 'nebon'),
            ]
        );

        // Choose between link or file
        $this->add_control(
            'video_type',
            [
                'label' => __('Video Source', 'nebon'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'url' => [
                        'title' => __('Link', 'nebon'),
                        'icon' => 'eicon-link',
                    ],
                    'file' => [
                        'title' => __('Upload', 'nebon'),
                        'icon' => 'eicon-upload',
                    ],
                ],
                'default' => 'url',
                'toggle' => false,
            ]
        );

        // Video URL
        $this->add_control(
            'video_url',
            [
                'label' => __('Video URL', 'nebon'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => __('https://your-video-link.com', 'nebon'),
                'show_external' => true,
                'condition' => [
                    'video_type' => 'url',
                ],
            ]
        );

        // Video File Upload
        $this->add_control(
            'video_file',
            [
                'label' => __('Upload Video File', 'nebon'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'media_type' => 'video',
                'condition' => [
                    'video_type' => 'file',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        parent::render();
        $settings =  $this->get_settings_for_display();
        $style = isset($settings['style']) ? $settings['style'] : 'style1';
        tech888f_get_template_elementor_widget('t888-about-us', $style, $settings, true);
    }
}
