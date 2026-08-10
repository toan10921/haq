<?php

namespace Elementor;

class T888_Hot_Deals extends T888_Widget_Base
{

    public function get_name()
    {
        return 't888-hot-deals';
    }

    public function get_title()
    {
        return __('Hot Deals', 'nebon');
    }

    public function get_icon()
    {
        return 'fas fa-clock';
    }

    public function get_categories()
    {
        return ['t888-elements'];
    }

    public function get_script_depends()
    {
        return ['elementor-t888-hot-deals'];
    }

    public function get_style_depends()
    {
        return ['elementor-t888-hot-deals'];
    }

    protected function _register_controls()
    {
        $this->start_controls_section(
            'section_content',
            [
                'label' => __('Hot Deals', 'nebon'),
            ]
        );
        $this->add_control(
            'style',
            [
                'label'   => __('Style', 'nebon'),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 'style1',
                'options' => [
                    'style1' => __('Style 1', 'nebon'),
                    'style2' => __('Style 2', 'nebon'),
                ],
            ]
        );
        $this->add_control(
            'background_image',
            [
                'label' => __('Background Image', 'nebon'),
                'type' => \Elementor\Controls_Manager::MEDIA,

                'condition' => [
                    'style' => 'style2',
                ],
            ]
      
        );
        $this->add_control(
            'title',
            [
                'label' => __('Title', 'nebon'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Hot Deals', 'nebon'),
                'placeholder' => __('Enter title', 'nebon'),
                'condition' => [
                    'style' => 'style2',
                ],
            ]
        );
        $this->add_control(
            'subtitle',
            [
                'label' => __('Subtitle', 'nebon'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('We always have weekly discount programs. Customers receive additional surprise offers such as free shipping, ', 'nebon'),
                'placeholder' => __('Enter subtitle', 'nebon'),
                'condition' => [
                    'style' => 'style2',
                ],
            ]
        );

        $this->add_control(
            'sale_deadline',
            [
                'label' => __('Sale Deadline (for style 2)', 'nebon'),
                'type' => \Elementor\Controls_Manager::DATE_TIME,
                'default' => '',
                'description' => __('After this time, the hot deals section will be hidden.', 'nebon'),
                'condition' => [
                    'style' => 'style2',
                ],
            ]
        );

        $sale_products = get_posts([
            'post_type'   => 'product',
            'post_status' => 'publish',
            'numberposts' => -1,
            'meta_query'  => [
                'relation' => 'AND',
                [
                    'key'     => '_sale_price',
                    'value'   => 0,
                    'compare' => '>',
                    'type'    => 'NUMERIC',
                ],
                [
                    'key'     => '_sale_price_dates_to',
                    'value'   => time(),
                    'compare' => '>=',
                ],
            ],
        ]);

        $sale_products_style2 = get_posts([
            'post_type'   => 'product',
            'post_status' => 'publish',
            'numberposts' => -1,
            'meta_query'  => [
                [
                    'key'     => '_sale_price',
                    'value'   => 0,
                    'compare' => '>',
                    'type'    => 'NUMERIC',
                ],
            ],
        ]);
        $options = [];
        foreach ($sale_products as $p) {
            $options[$p->ID] = '#' . $p->ID . ' - ' . $p->post_title;
        }
        $options2 = [];
        foreach ($sale_products_style2 as $p) {
            $options2[$p->ID] = '#' . $p->ID . ' - ' . $p->post_title;
        }
        $this->add_control(
            'sale_products',
            [
                'label'       => __('Select products with active scheduled discounts', 'nebon'),
                'type'        => \Elementor\Controls_Manager::SELECT2,
                'options'     => $options,
                'multiple'    => true,
                'label_block' => true,
                'description' => __('Only products that are on sale and have a valid sale schedule are shown here.', 'nebon'),
                'condition'   => ['style' => 'style1'],
            ]
        );
        $this->add_control(
            'sale_products_style2',
            [
                'label'       => __('Select discounted products (no schedule required)', 'nebon'),
                'type'        => \Elementor\Controls_Manager::SELECT2,
                'options'     => $options2,
                'multiple'    => true,
                'label_block' => true,
                'condition'   => ['style' => 'style2'],
            ]
        );
        $this->add_control(
            'columns',
            [
                'label' => __('Columns per row', 'nebon'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '4',
                'options' => [
                    '2' => '2 Columns',
                    '3' => '3 Columns',
                    '4' => '4 Columns',
                    '5' => '5 Columns',
                ],
                'condition' => [
                    'style' => 'style1',
                ],
            ]
        );

        $this->add_control(
            'link_button',
            [
                'label' => __('Link Button', 'nebon'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => __('https://your-link.com', 'nebon'),
                'default' => [
                    'url' => '',
                    'is_external' => true,
                    'nofollow' => true,
                ],
            ]
        );
        $this->add_control(
            'button_text',
            [
                'label' => __('Button Text', 'nebon'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Shop All', 'nebon'),
                'placeholder' => __('Enter button text', 'nebon'),
            ]
        );
        $this->add_control(
            'infinitive_sale',
            [
                'label' => __('Infinite Deal (Auto loop 10 days)', 'nebon'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'nebon'),
                'label_off' => __('No', 'nebon'),
                'return_value' => 'yes',
                'default' => '',
                // 'condition' => [
                //     'style' => 'style1',
                // ],
            ]
        );

        $this->end_controls_section();
    }



    protected function render()
    {
        parent::render();
        $settings =  $this->get_element_settings();
        $style = isset($settings['style']) ? $settings['style'] : 'style1';

        tech888f_get_template_elementor_widget('t888-hot-deals', $style, $settings, true);
    }
}
