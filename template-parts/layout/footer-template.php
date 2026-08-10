<?php

namespace T888Core;

if (! class_exists('Footer_Template')) {
    class Footer_Template
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

        public function get_footer_page()
        {
            $footer_page  = get_theme_mod('footer_page', '');

             // override heder in single page
            if( is_page()){
                $footer_page = empty(get_post_meta(get_the_ID(), 'custom_footer_page', true)) ? $footer_page : get_post_meta(get_the_ID(), 'custom_footer_page', true);
            }

            return $footer_page;
        }

        public function render()
        {
            $footer_page =  $this->get_footer_page();
            if (empty($footer_page)) {
                TemplateHelper::_load_view_template('layout/default/footer-default', '', array(), true);
                return;
            }

            $content = TemplateHelper::_get_elementor_content($footer_page);
            echo '<footer class="footer-' . esc_attr($footer_page) . ' footer-elementor">';
            echo apply_filters('t888_template_content', $content);
            echo '</footer>';
        }
    }
}

Footer_Template::get_instance()->render();
