<?php

namespace Elementor;

class T888_Mini_Cart extends T888_Widget_Base
{
    protected static $need_footer_overlay = false;
    protected static $footer_hook_added   = false;
    public function get_name()
    {
        return 't888-mini-cart';
    }

    public function get_title()
    {
        return __('Mini Cart', 'nebon');
    }

    public function get_icon()
    {
        return 'eicon-cart';
    }

    public function get_categories()
    {
        return ['t888-elements'];
    }

    public function get_script_depends()
    {
        return [];
    }

    public function get_style_depends()
    {
        return [];
    }

    protected function _register_controls()
    {
        $this->start_controls_section('section_content', [
            'label' => __('Mini Cart Content', 'nebon'),
        ]);

        $this->add_control('style', [
            'label' => __('Style', 'nebon'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'style1',
            'options' => [
                'style1' => __('Style 1 (Default)', 'nebon'),
                'style3' => __('Style 3', 'nebon'),
            ],
        ]);

        $this->end_controls_section();
    }

    public function render()
    {
        parent::render();
        $settings =  $this->get_element_settings();
        $style = isset($settings['style']) ? $settings['style'] : 'style1';
        $active_cart_default = '';
        // logic use for click add cart in single product page and quick view
        if(isset($_POST['quantity']) && is_numeric($_POST['quantity']) && isset($_POST['add-to-cart']) && is_numeric($_POST['add-to-cart'])) {
            $active_cart_default = 'active-cart-default';
        }
        if(isset($_GET['add-to-cart']) && is_numeric($_GET['add-to-cart'])) {
            $active_cart_default = 'active-cart-default';
        }
        $settings['active_cart_default'] = $active_cart_default;
        self::$need_footer_overlay = true;

        if ( ! self::$footer_hook_added ) {
            add_action('wp_footer', [__CLASS__, 'print_minicart_overlay'], 99);
            self::$footer_hook_added = true;
        }
        tech888f_get_template_elementor_widget('t888-mini-cart', $style, $settings, true);
        
    }
    public static function print_minicart_overlay() {
        if ( ! self::$need_footer_overlay ) return;
        t888f_get_template('mini-cart/overlay-content-minicart', get_post_format(), [], true);
    }
}
