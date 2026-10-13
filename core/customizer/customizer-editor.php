<?php

namespace T888Core;

if (class_exists('WP_Customize_Control')) {
    class WP_Customize_Editor_Control extends \WP_Customize_Control
    {
        public $type = 't888_editor';
        public $rows = 12;

        public function enqueue()
        {
            wp_enqueue_editor();
            wp_add_inline_style(
                'customize-controls',
                '.t888-customize-editor-wrap,.t888-customize-editor-wrap .wp-editor-wrap{max-width:100%;}'
            );
        }

        public function render_content()
        {
            $editor_id = $this->id . '_editor';
            ?>
            <label>
                <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
                <?php if (!empty($this->description)) : ?>
                    <span class="description customize-control-description"><?php echo wp_kses_post($this->description); ?></span>
                <?php endif; ?>
            </label>
            <div class="t888-customize-editor-wrap" data-setting="<?php echo esc_attr($this->id); ?>">
                <?php
                wp_editor(
                    $this->value(),
                    $editor_id,
                    array(
                        'textarea_name' => $editor_id,
                        'textarea_rows' => $this->rows,
                        'media_buttons' => true,
                        'teeny' => false,
                        'quicktags' => true,
                        'tinymce' => array(
                            'wpautop' => true,
                        ),
                    )
                );
                ?>
            </div>
            <script>
            (function($) {
                var settingId = <?php echo wp_json_encode($this->id); ?>;
                var editorId = <?php echo wp_json_encode($editor_id); ?>;

                function syncToSetting() {
                    var value = '';
                    if (typeof tinymce !== 'undefined') {
                        var editor = tinymce.get(editorId);
                        if (editor && !editor.isHidden()) {
                            value = editor.getContent();
                        } else {
                            value = $('#' + editorId).val();
                        }
                    } else {
                        value = $('#' + editorId).val();
                    }

                    wp.customize(settingId, function(setting) {
                        setting.set(value);
                    });
                }

                $(document).on('tinymce-editor-init', function(event, editor) {
                    if (editor.id === editorId) {
                        editor.on('change keyup undo redo SetContent', syncToSetting);
                    }
                });

                $(document).on('change keyup', '#' + editorId, syncToSetting);
            })(jQuery);
            </script>
            <?php
        }
    }
}
