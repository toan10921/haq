<?php

namespace Elementor;

// if (!defined('ABSPATH')) {
//     exit;
// }

class T888_Video extends T888_Widget_Base
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
        return 't888-video';
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
        return __('Video', 'nebon');
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
        return 'fas fa-video';
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
        return ['elementor-t888-video'];
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
        return ['elementor-t888-video'];
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
     * Enqueue widget-specific styles
     */

    private function extract_youtube_id($url)
    {
        preg_match('/[\\?\\&]v=([^\\?\\&]+)/', $url, $matches);
        return $matches[1] ?? '';
    }


    /**
     * Register controls.
     *
     * Add input fields to allow the user to customize the widget settings.
     */
    protected function _register_controls()
    {
        $this->start_controls_section(
            'section_content',
            [
                'label' => __('Video Settings', 'nebon'),
            ]
        );

        $this->add_control(
            'video_type',
            [
                'label' => __('Video Source', 'nebon'),
                'type' => Controls_Manager::SELECT,
                'default' => 'youtube',
                'options' => [
                    'youtube' => __('YouTube Link', 'nebon'),
                    'upload'  => __('Upload File', 'nebon'),
                ],
            ]
        );

        $this->add_control(
            'youtube_link',
            [
                'label' => __('YouTube URL', 'nebon'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => __('https://www.youtube.com/watch?v=abc123', 'nebon'),
                'condition' => [
                    'video_type' => 'youtube',
                ],
            ]
        );

        $this->add_control(
            'uploaded_video',
            [
                'label' => __('Upload Video File', 'nebon'),
                'type' => Controls_Manager::MEDIA,
                'media_type' => 'video',
                'condition' => [
                    'video_type' => 'upload',
                ],
            ]
        );

        // Autoplay
        $this->add_control(
            'autoplay',
            [
                'label' => __('Autoplay', 'nebon'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'nebon'),
                'label_off' => __('No', 'nebon'),
                'return_value' => 'yes',
                'default' => '',
            ]
        );

        // Mute
        $this->add_control(
            'mute',
            [
                'label' => __('Mute', 'nebon'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'nebon'),
                'label_off' => __('No', 'nebon'),
                'return_value' => 'yes',
                'default' => '',
            ]
        );

        // Loop
        $this->add_control(
            'loop',
            [
                'label' => __('Loop', 'nebon'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'nebon'),
                'label_off' => __('No', 'nebon'),
                'return_value' => 'yes',
                'default' => '',
            ]
        );


        // Overlay image
        $this->add_control(
            'overlay_image',
            [
                'label' => __('Overlay Image', 'nebon'),
                'type' => Controls_Manager::MEDIA,
                'media_type' => 'image',
                'description' => __('Optional overlay image shown before play.', 'nebon'),
            ]
        );

        $this->add_control(
            'style',
            [
                'label' => __('Style', 'nebon'),
                'type' => Controls_Manager::SELECT,
                'default' => 'style1',
                'options' => [
                    'style1' => __('Style 1', 'nebon'),
                    'style2' => __('Style 2', 'nebon'),
                ],

            ]
        );




        $this->end_controls_section();
    }

    /**
     * Render widget output on the frontend.
     */
    protected function render()
    {
        // $this->enque_styles();
        // $this->enque_scripts();
        parent::render();
        $settings = $this->get_settings_for_display();

        wp_localize_script("elementor-" . $this->get_name(), 't888VideoSettings', [
            'videoType' => $settings['video_type'],
            'youtubeID' => $this->extract_youtube_id($settings['youtube_link']),
            'uploadedVideo' => !empty($settings['uploaded_video']['url']) ? $settings['uploaded_video']['url'] : '',
            'autoplay' => $settings['autoplay'] === 'yes' ? 1 : 0,
            'mute' => $settings['mute'] === 'yes' ? 1 : 0,
            'loop' => $settings['loop'] === 'yes' ? 1 : 0,
        ]);

        $style = isset($settings['style']) ? $settings['style'] : 'style1';
        tech888f_get_template_elementor_widget('t888-video', $style, $settings, true);
    }
}
