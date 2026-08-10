<?php

namespace Elementor;

class T888_Product_Hotspot extends T888_Widget_Base
{
    public function get_name()
    {
        return 't888-product-hotspot';
    }

    public function get_title()
    {
        return __('Product Hotspot', 'nebon');
    }

    public function get_icon()
    {
        return 'fas fa-fire';
    }

    public function get_categories()
    {
        return ['t888-elements'];
    }

    public function get_script_depends()
    {
        return ['elementor-t888-product-hotspot'];
    }

    public function get_style_depends()
    {
        return ['elementor-t888-product-hotspot'];
    }

    protected function _register_controls()
    {
        // Section: Image and hotspots
        $this->start_controls_section(
            'section_content',
            [
                'label' => __('Hotspot Settings', 'nebon'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
    
        // Image background
        $this->add_control(
            'main_image',
            [
                'label' => __('Background Image', 'nebon'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );
        $this->add_control(
            'background_position',
            [
                'label' => __('Background Position (Desktop)', 'nebon'),
                'type' => Controls_Manager::SELECT,
                'default' => 'center center',
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
        // Repeater for hotspots
        $repeater = new \Elementor\Repeater();
    
        // Select WooCommerce product
        $repeater->add_control(
            'product_id',
            [
                'label' => __('Select Product', 'nebon'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'options' => $this->get_woocommerce_products(),
                'label_block' => true,
            ]
        );
    
        // Top position
        $repeater->add_control(
            'position_top',
            [
                'label' => __('Top (px)', 'nebon'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 100,
            ]
        );
    
        // Left position
        $repeater->add_control(
            'position_left',
            [
                'label' => __('Left (px)', 'nebon'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 100,
            ]
        );
    
        $this->add_control(
            'hotspots',
            [
                'label' => __('Hotspot Items', 'nebon'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'title_field' => __('Hotspot at {{ position_top }}px / {{ position_left }}px', 'nebon'),
            ]
        );
    
        $this->end_controls_section();
    }

    private function get_woocommerce_products()
    {
        if (!class_exists('WooCommerce')) {
            return [];
        }
    
        $products = wc_get_products([
            'limit' => -1,
            'status' => 'publish',
        ]);
    
        $options = [];
    
        foreach ($products as $product) {
            $options[$product->get_id()] = $product->get_name();
        }
    
        return $options;
    }
    
    protected function render()
    {
        parent::render();
        $settings =  $this->get_element_settings();
        $style = isset($settings['style']) ? $settings['style'] : 'style1';
        tech888f_get_template_elementor_widget('t888-product-hotspot', $style, $settings, true);
    }
}
