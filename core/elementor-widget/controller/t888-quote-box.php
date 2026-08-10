<?php

namespace Elementor;

class T888_Quote_Box extends T888_Widget_Base
{
    public function get_name()
    {
        return 't888-quote-box';
    }

    public function get_title()
    {
        return __('Quote Box', 'nebon');
    }

    public function get_icon()
    {
        return 'eicon-blockquote';
    }

    public function get_categories()
    {
        return ['t888-elements'];
    }

    public function get_script_depends()
    {
        return ['elementor-t888-quote-box'];
    }

    public function get_style_depends()
    {
        return ['elementor-t888-quote-box'];
    }

    protected function _register_controls()
    {
        $this->start_controls_section('section_content', [
            'label' => __('Quote Box Content', 'nebon'),
        ]);
        $this->add_control('style', [
            'label' => __('Style', 'nebon'),
            'type' => Controls_Manager::SELECT,
            'default' => 'style1',
            'options' => [
                'style1' => __('Style 1 (With Year & Logos)', 'nebon'),
                'style2' => __('Style 2 (With Bottom Box)', 'nebon'),
            ],
        ]);


        $this->add_control('year_label', [
            'label' => __('Year Label (Vertical)', 'nebon'),
            'type' => Controls_Manager::TEXT,
            'default' => '2025',
            'condition' => ['style' => 'style1'],
        ]);

        $this->add_control('image', [
            'label' => __('Main Image', 'nebon'),
            'type' => Controls_Manager::MEDIA,
            'default' => [
                'url' => Utils::get_placeholder_image_src(),
            ],
        ]);

        $this->add_control('description_text', [
            'label' => __('Top Description', 'nebon'),
            'type' => Controls_Manager::TEXTAREA,
            'default' => __('Understanding how the epidermis works and choosing the right skin care products is essential...', 'nebon'),
        ]);

        $this->add_control('quote_text', [
            'label' => __('Main Quote Text', 'nebon'),
            'type' => Controls_Manager::TEXTAREA,
            'default' => __('Natural and organic cosmetics are formulated with the skin\'s innate mechanisms in mind...', 'nebon'),
        ]);



        $this->add_control('author', [
            'label' => __('Author', 'nebon'),
            'type' => Controls_Manager::TEXT,
            'default' => 'Elodie Crocilla – CEO Nebon',
        ]);

        $this->add_control('logos', [
            'label' => __('Top Logos (optional)', 'nebon'),
            'type' => Controls_Manager::REPEATER,
            'fields' => [
                [
                    'name' => 'logo_image',
                    'label' => __('Logo Image', 'nebon'),
                    'type' => Controls_Manager::MEDIA,
                    'default' => ['url' => Utils::get_placeholder_image_src()],
                ],
                [
                    'name' => 'alt',
                    'label' => __('Alt Text', 'nebon'),
                    'type' => Controls_Manager::TEXT,
                    'default' => 'Logo',
                ],
            ],
            'default' => [],
            'title_field' => '{{{ alt }}}',
            'condition' => ['style' => 'style1'],
        ]);
        $this->add_control('bottom_title', [
            'label' => __('Bottom Box Title', 'nebon'),
            'type' => Controls_Manager::TEXT,
            'default' => __('Respect for the skin\'s microbiome', 'nebon'),
            'condition' => ['style' => 'style2'],
        ]);

        $this->add_control('bottom_text', [
            'label' => __('Bottom Box Content', 'nebon'),
            'type' => Controls_Manager::TEXTAREA,
            'default' => __('By switching to natural and organic cosmetics, ...', 'nebon'),
            'condition' => ['style' => 'style2'],
        ]);


        $this->end_controls_section();
    }

    protected function render()
    {
        parent::render();
        $settings =  $this->get_settings_for_display();
        $style = isset($settings['style']) ? $settings['style'] : 'style1';
        tech888f_get_template_elementor_widget('t888-quote-box', $style, $settings, true);
    }
}
