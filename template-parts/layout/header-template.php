<?php

namespace T888Core;

if (! class_exists('Header_Template')) {
    class Header_Template
    {
        private static $instance = null;

        private function __construct()
        {
            // Private constructor to prevent direct instantiation.
        }

        public static function get_instance()
        {
            if (self::$instance === null) {
                self::$instance = new self();
            }
            return self::$instance;
        }

        public function get_header_page()
        {
            $header_page  = get_theme_mod('header_page', '');

            // override heder in single page
            if (is_page()) {
                $header_page = empty(get_post_meta(get_the_ID(), 'custom_header_page', true)) ? $header_page : get_post_meta(get_the_ID(), 'custom_header_page', true);
            }

            return $header_page;
        }

        public function render()
        {
            $header_page =  $this->get_header_page();
            if (empty($header_page)) {
                TemplateHelper::_load_view_template('layout/default/header-default', '', array(), true);
                return;
            }
            $is_sticky_enabled = get_post_meta($header_page, 'sticky_header', true);
            $sticky_data_attr = $is_sticky_enabled === '1' ? 'data-enable-sticky="1"' : '';
            $content = TemplateHelper::_get_elementor_content($header_page);
            echo '<header class="header-' . esc_attr($header_page) . ' header-elementor" ' . $sticky_data_attr . '>';
            echo apply_filters('t888_template_content', $content);
            wp_reset_postdata(  );
            echo '</header>';
        }
    }
}

Header_Template::get_instance()->render();
