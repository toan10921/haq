<?php

namespace T888Core;

if (class_exists('WP_Customize_Color_Control')) {
    class WP_Customize_Alpha_Color_Control extends \WP_Customize_Color_Control
    {
        public $type = 'alpha-color';

        public function enqueue()
        {
            // Enqueue the default color picker and your custom script
            wp_enqueue_style('wp-color-picker');
            wp_register_script('wp-color-picker-alpha', get_template_directory_uri() . '/assets/admin/js/customize-alpha-color-picker.js', array('wp-color-picker'), '1.0.0', true);
            wp_add_inline_script(
                'wp-color-picker-alpha',
                'jQuery( function() { jQuery( ".alpha-color-picker" ).wpColorPicker(); } );'
            );
            wp_enqueue_script('wp-color-picker-alpha');

            wp_enqueue_style('wp-color-picker');
            wp_enqueue_style(
                'customize-alpha-color-picker',
                get_template_directory_uri() . '/assets/admin/css/customize-alpha-color-picker.css' // Optional custom styles
            );
        }

        public function render_content()
        {
            if (empty($this->label)) {
                return;
            }
?>
            <label>
                <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>

            </label>
            <div class="alpha-color-picker-wrapper">
                <input class="alpha-color-picker" type="text" data-alpha-enabled="true" <?php $this->link(); ?> value="<?php echo esc_attr($this->value()); ?>" />
            </div>
<?php
        }

        public static function _sanitize_rgba_color($color)
        {
            if (empty($color) || is_array($color)) {
                return 'rgba(255,255,255,1)';
            }
            if (false === strpos($color, 'rgba')) {
                return sanitize_hex_color($color); // Default sanitization for hex
            }

            // Match rgba color pattern
            $color = preg_replace('/\s+/', '', $color);
            if (preg_match('/^rgba\(\d+,\d+,\d+,(0|1|0?\.\d+)\)$/', $color)) {
                return $color;
            }

            return 'rgba(255,255,255,1)';
        }
    }
}
