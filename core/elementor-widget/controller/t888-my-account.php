<?php

namespace Elementor;

class T888_My_Account extends T888_Widget_Base
{
    protected static $need_footer_overlay = false;
    protected static $footer_hook_added   = false;
    public function __construct(array $data = [], array $args = null)
    {
        parent::__construct($data, $args);
  

    }

     public function enque_scripts()
    {
        parent::enque_scripts();

        wp_localize_script('elementor-t888-my-account', 't888_ajax_object', [
            'ajax_url' => admin_url('admin-ajax.php'),
        ]);
    }

    public function get_name()
    {
        return 't888-my-account';
    }

    public function get_title()
    {
        return __('My Account', 'nebon');
    }

    public function get_icon()
    {
        return 'eicon-my-account';
    }

    public function get_categories()
    {
        return ['t888-elements'];
    }
    
    public function get_style_depends()
    {
        return [];
    }

    public function get_script_depends()
    {
        return [];
    }

    protected function _register_controls()
    {
        // Content Section
        $this->start_controls_section(
            'section_menu_content',
            [
                'label' => __('My Account Content', 'nebon'),
            ]
        );

        $this->add_control(
            'style' ,
            [
                'label' => __('Style', 'nebon'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'style1' => __('Style 1 - Header 1', 'nebon'),
                    'style2' => __('Style 2', 'nebon'),
                ],
                'default' => 'style1',
            ]
        );

        $this->add_control(
            'redirect_url_type',
            [
                'label' => __('Redirect URL Type', 'nebon'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'default' => __('Default - Keep current url', 'nebon'),
                    'custom' => __('Custom - Go to Specific URL', 'nebon'),
                ],
                'default' => 'default',
            ]
        );

        $this->add_control(
            'redirect_url',
            [
                'label' => __('Redirect URL', 'nebon'),
                'type' => Controls_Manager::URL,
                'placeholder' => esc_url(get_permalink(get_option('woocommerce_myaccount_page_id'))),
                'default' => [
                    'url' => esc_url(get_permalink(get_option('woocommerce_myaccount_page_id'))),
                    'is_external' => false,
                    'nofollow' => false,
                ],
                'condition' => [
                    'redirect_url_type' => 'custom',
                ],
            ]
        );

        $this->end_controls_section();
    }

  

    protected function render()
    {
        parent::render();
        $settings = $this->get_element_settings();
        $settings['widget_id'] = $this->get_id();
        
        $style = isset($settings['style']) ? $settings['style'] : 'style1';
        $redirect_url_type = $settings['redirect_url_type'] == 'custom' ? $settings['redirect_url']['url'] : 'default';
        $settings['redirect_url'] = $redirect_url_type == 'custom' ? $settings['redirect_url']['url'] : esc_url( get_current_url() );
        self::$need_footer_overlay = true;
        if (! self::$footer_hook_added) {
            add_action('wp_footer', [__CLASS__, 'print_account_overlay'], 99);
            self::$footer_hook_added = true;
        }
        tech888f_get_template_elementor_widget('t888-my-account', $style, $settings, true);
    }
    public static function print_account_overlay()
    {
        if (! self::$need_footer_overlay) return;

        t888f_get_template('my-account/overlay-content-myaccount', get_post_format(), [], true);
    }
}