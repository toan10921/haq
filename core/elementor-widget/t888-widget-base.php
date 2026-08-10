<?php

namespace Elementor;

class T888_Widget_Base extends Widget_Base
{
    private $elm_settings = [];

    public function get_element_settings()
    {
        return $this->elm_settings;
    }

    public function __construct(array $data = [], array $args = null)
    {
        parent::__construct($data, $args);

        add_action('elementor/preview/enqueue_styles', [$this, 'enque_styles']);
        add_action('elementor/preview/enqueue_scripts', [$this, 'enque_scripts']);

        add_action('elementor/frontend/after_register_styles', [$this, 'enque_styles']);
        add_action('elementor/frontend/after_register_scripts', [$this, 'enque_scripts']);
    }

    public function get_name()
    {
        return 't888-widget-base';
    }

    public function enque_styles()
    {
        // if file not exist, return
        $css_path = get_template_directory() . "/assets/css/elementor/" . $this->get_name() . ".css";
        if (file_exists($css_path)) {
            $ver = filemtime($css_path);
            wp_register_style("elementor-" . $this->get_name(), get_template_directory_uri() . "/assets/css/elementor/" . $this->get_name() . ".css", [], $ver, 'all');
            wp_enqueue_style("elementor-" . $this->get_name());
        }
    }

    public function enque_scripts()
    {
        // if file not exist, return
        $js_path = get_template_directory() . "/assets/js/elementor/" . $this->get_name() . ".js";
        if (file_exists($js_path)) {
            $ver = filemtime($js_path);
            wp_register_script("elementor-" . $this->get_name(), get_template_directory_uri() . "/assets/js/elementor/" . $this->get_name() . ".js", ['jquery'], $ver, true);
            wp_enqueue_script("elementor-" . $this->get_name());
        }
    }

    protected function render()
    {
        $this->enque_styles();
        $this->enque_scripts();
        $this->elm_settings = $this->get_settings_for_display();
    }
}
