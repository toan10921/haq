<?php

namespace Elementor;

class T888_Product_Group extends T888_Widget_Base
{
    public function get_name()
    {
        return 't888-product-group';
    }

    public function get_title()
    {
        return __('Product Group', 'nebon');
    }

    public function get_icon()
    {
        return 'eicon-products';
    }

    public function get_categories()
    {
        return ['t888-elements'];
    }

    public function get_script_depends()
    {
        return ['elementor-t888-product-group'];
    }

    public function get_style_depends()
    {
        return ['elementor-t888-product-group'];
    }

    public function enque_scripts()
    {
        parent::enque_scripts();
        wp_localize_script(
            'elementor-t888-product-group',
            't888_ajax',
            [
                'ajax_url' => admin_url('admin-ajax.php'),
            ]
        );
    }

    protected function _register_controls()
    {
        $this->start_controls_section('section_content', [
            'label' => __('Settings', 'nebon'),
        ]);
        $this->add_control('title', [
            'label' => __('Title', 'nebon'),
            'type' => Controls_Manager::TEXT,
            'default' => __('ROUTINE', 'nebon'),
        ]);
        $this->add_control('heading', [
            'label' => __('Heading', 'nebon'),
            'type' => Controls_Manager::TEXT,
            'default' => __('SEBUM-REGULATING ANTI-IMPERFECTION ROUTINE', 'nebon'),
        ]);
        $product_options = $this->get_all_products();

        for ($i = 1; $i <= 4; $i++) {
            $this->add_control(
                'product_' . $i,
                [
                    'label' => __('Choose Product #', 'nebon') . $i,
                    'type' => Controls_Manager::SELECT2,
                    'label_block' => true,
                    'options' => $product_options,
                    'multiple' => false,
                ]
            );
        }

        $this->add_control('style', [
            'label' => __('Style', 'nebon'),
            'type' => Controls_Manager::SELECT,
            'default' => 'style1',
            'options' => [
                'style1' => __('Style 1', 'nebon'),
                'style2' => __('Style 2', 'nebon'),
            ],
        ]);

        $this->end_controls_section();
    }

    protected function get_all_products()
    {
        $products = wc_get_products([
            'limit' => -1,
            'status' => 'publish',
            'return' => 'ids',
            'type' => ['simple']

        ]);

        $options = [];
        foreach ($products as $product_id) {
            $product = wc_get_product($product_id);
            if ($product) {
                $options[$product_id] = $product->get_name();
            }
        }
        return $options;
    }

    protected function render()
    {
        parent::render();
        $settings =  $this->get_element_settings();
        $style = isset($settings['style']) ? $settings['style'] : 'style1';
        $products = [];
        for ($i = 1; $i <= 4; $i++) {
            $key = 'product_' . $i;
            if (!empty($settings[$key])) {
                $product = wc_get_product($settings[$key]);
                if ($product) {
                    $products[] = $product;
                }
            }
        }
        $settings['products'] = $products;
        tech888f_get_template_elementor_widget('t888-product-group', $style, $settings, true);
    }
}
