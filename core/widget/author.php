<?php

if (!class_exists('tech888f_AuthorWidget')) {
    class tech888f_AuthorWidget extends WP_Widget
    {

        protected $default = array();
        protected $widget_name = 'author';
        protected $version = '1.0.0';
        protected $registered = false;

        static function _init()
        {
            add_action('widgets_init', array(__CLASS__, '_add_widget'));
        }

        static function _add_widget()
        {
            if (function_exists('tech888f_reg_widget'))
                tech888f_reg_widget('tech888f_AuthorWidget');
        }

        function __construct()
        {
            parent::__construct(
                false,
                __('7up Author Widget', 'nebon'),
                array(
                    'description' => __('A widget to display author information', 'nebon'),
                    'customize_selective_refresh' => true,
                    // 'show_instance_in_rest'       => true,
                )
            );

            $this->default = array(
                'title'             => '',
                'author_image'      => '',
                'link'              => '',
                'author_name'       => '',
                'author_description' => '',
            );
        }


        /**
         * Define the schema for the widget instance.
         */
        // public function get_instance_schema() {
        //     return array(
        //         'title' => array(
        //             'type' => 'string',
        //             'default' => '',
        //             'sanitize_callback' => 'sanitize_text_field',
        //             'description' => __('Title of the widget', 'nebon'),
        //         ),
        //         'author_image' => array(
        //             'type' => 'string',
        //             'default' => '',
        //             'sanitize_callback' => 'esc_url_raw',
        //             'description' => __('URL of the author image', 'nebon'),
        //         ),
        //         'link' => array(
        //             'type' => 'string',
        //             'default' => '',
        //             'sanitize_callback' => 'esc_url_raw',
        //             'description' => __('Link to the author\'s page', 'nebon'),
        //         ),
        //         'author_name' => array(
        //             'type' => 'string',
        //             'default' => '',
        //             'sanitize_callback' => 'sanitize_text_field',
        //             'description' => __('Name of the author', 'nebon'),
        //         ),
        //         'author_description' => array(
        //             'type' => 'string',
        //             'default' => '',
        //             'sanitize_callback' => 'sanitize_textarea_field',
        //             'description' => __('Description of the author', 'nebon'),
        //         ),
        //     );
        // }

        public function _register_one($number = -1)
        {
            if ($this->registered) {
                return;
            }
            $this->registered = true;

            /*
             * Note that the widgets component in the customizer will also do
             * the 'admin_print_scripts-widgets.php' action in WP_Customize_Widgets::print_scripts().
             */
            add_action('admin_print_scripts-widgets.php', array($this, 'enqueue_admin_scripts'));

            parent::_register_one($number); // Call the parent method to ensure proper registration
        }

        public function enqueue_admin_scripts()
        {
            wp_enqueue_style('widget-' . $this->widget_name, get_template_directory_uri() . '/core/widget/assets/css/' . $this->widget_name . '.css', array(), $this->version, 'all');
            wp_enqueue_script('widget-' . $this->widget_name, get_template_directory_uri() . '/core/widget/assets/js/' . $this->widget_name . '.js', ['jquery'], $this->version, true);
        }



        function widget($args, $instance)
        {
            echo apply_filters('tech888f_output_content', $args['before_widget'] ?? '');

            $title = !empty($instance['title']) ? $instance['title'] : '';
            $author_image = !empty($instance['author_image']) ? $instance['author_image'] : '';
            $link = !empty($instance['link']) ? $instance['link'] : '';
            $author_name = !empty($instance['author_name']) ? $instance['author_name'] : '';
            $author_description = !empty($instance['author_description']) ? $instance['author_description'] : '';

            tech888f_get_template_widget('author', '', array(
                'title'             => $title,
                'author_image'      => $author_image,
                'author_name'       => $author_name,
                'link'              => $link,
                'author_description' => $author_description,
                'args'              => $args,
            ), true);

            echo apply_filters('tech888f_output_content', $args['after_widget'] ?? '');
        }

        function update($new_instance, $old_instance)
        {
            $instance = array();
            $instance = wp_parse_args($instance, $this->default);
            $new_instance = wp_parse_args($new_instance, $instance);

            return $new_instance;
        }

        function form($instance)
        {
            $instance = wp_parse_args($instance, $this->default);
            extract($instance);
?>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('title')); ?>">
                    <?php esc_html_e('Title:', 'nebon'); ?>
                </label>
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>">
            </p>
            <?php
            ?>
            <div class="author-image-upload">
                <label for="<?php echo esc_attr($this->get_field_id('author_image')); ?>">
                    <?php esc_html_e('Author Image:', 'nebon'); ?>
                </label>
                <input class="widefat author-image-url" id="<?php echo esc_attr($this->get_field_id('author_image')); ?>" name="<?php echo esc_attr($this->get_field_name('author_image')); ?>" type="text" value="<?php echo esc_attr($author_image); ?>" readonly>
                <button type="button" class="button button-secondary author-widget-upload-button"><?php esc_html_e('Upload Image', 'nebon'); ?></button>
                <div class="image-preview-outer">
                    <img class="author-image-preview" src="<?php echo esc_url($author_image); ?>" style="max-width:100%; display: <?php echo esc_attr( $author_image ? 'block' : 'none' ); ?>;">
                </div>
            </div>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('link')); ?>">
                    <?php esc_html_e('Link:', 'nebon'); ?>
                </label>
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('link')); ?>" name="<?php echo esc_attr($this->get_field_name('link')); ?>" type="text" value="<?php echo esc_attr($link); ?>">
            </p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('author_name')); ?>">
                    <?php esc_html_e('Author Name:', 'nebon'); ?>
                </label>
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('author_name')); ?>" name="<?php echo esc_attr($this->get_field_name('author_name')); ?>" type="text" value="<?php echo esc_attr($author_name); ?>">
            </p>
            <?php
            ?>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('author_description')); ?>">
                    <?php esc_html_e('Author Description:', 'nebon'); ?>
                </label>
                <textarea class="widefat" id="<?php echo esc_attr($this->get_field_id('author_description')); ?>" name="<?php echo esc_attr($this->get_field_name('author_description')); ?>"><?php echo esc_textarea($author_description); ?></textarea>
            </p>
<?php
        }
    }

    tech888f_AuthorWidget::_init();
}
