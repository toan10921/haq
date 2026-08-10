<?php

namespace T888Core;

if (class_exists('WP_Customize_Control')) {
    class WP_Customize_Multiple_Checkbox_Control extends \WP_Customize_Control
    {
        public $type = 'multiple-checkbox';

        public function render_content()
        {
            if (empty($this->choices)) {
                return;
            }

            $values = $this->value(); // get value from setting
            $values = is_array($values) ? $values : explode(',', $values);

?>
            <label>
                <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
                <?php if (!empty($this->description)) { ?>
                    <span class="description customize-control-description"><?php echo esc_html($this->description); ?></span>
                <?php } ?>
            </label>
            <?php foreach ($this->choices as $value => $label) { ?>
                <label>
                    <input type="checkbox" value="<?php echo esc_attr($value); ?>"
                        name="<?php echo esc_attr($this->id); ?>[]"
                        <?php checked(in_array($value, $values)); ?>>
                    <?php echo esc_html($label); ?>
                </label><br>
            <?php } ?>
            <script>
                (function($) {
                    $(document).on('change', 'input[name^="<?php echo esc_js($this->id); ?>[]"]', function() {
                        var selected = [];
                        $('input[name^="<?php echo esc_js($this->id); ?>[]"]:checked').each(function() {
                            selected.push($(this).val());
                        });
                        wp.customize('<?php echo esc_js($this->id); ?>').set(selected);
                    });
                })(jQuery);
            </script>
<?php
        }

        /**
         * Sanitize multiple checkbox input.
         * 
         * @param mixed $input The input to sanitize.
         * @return array The sanitized input.
         */
        public static function _sanitize_multiple_checkbox($input) {
            return is_array($input) ? array_map('sanitize_text_field', $input) : array();
        }
    }
}
