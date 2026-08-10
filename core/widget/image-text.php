<?php

if (!class_exists('tech888f_ImageText_Widget')) {
    class tech888f_ImageTextWidget extends WP_Widget
    {

        protected $default = array();
        protected $widget_name = 'image-text';
        protected $version = '1.0.0';
        protected $registered = false;

        static function _init()
        {
            add_action('widgets_init', array(__CLASS__, '_add_widget'));
        }

        static function _add_widget()
        {
            if (function_exists('tech888f_reg_widget'))
                tech888f_reg_widget('tech888f_ImageTextWidget');
        }

        function __construct()
        {
            parent::__construct(
                'tech888f_image_text_widget',
                __('7up Custom Banner Widget', 'nebon'),
                array('description' => __('A widget to display image and text on the image', 'nebon'))
            );

            $this->default = array(
                'title'             => '',
                'image'      => '',
                'description1' => '',
                'description2' => '',
                'description3' => '',
                'link'             => '',
            );
        }

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
            echo apply_filters( 'tech888f_output_content', $args['before_widget'] ?? '' );

            $title = !empty($instance['title']) ? $instance['title'] : '';
            $image = !empty($instance['image']) ? $instance['image'] : '';
            $link = !empty($instance['link']) ? $instance['link'] : '';
            $description1 = !empty($instance['description1']) ? $instance['description1'] : '';
            $description2 = !empty($instance['description2']) ? $instance['description2'] : '';
            $description3 = !empty($instance['description3']) ? $instance['description3'] : '';
            tech888f_get_template_widget('image-text', '', array(
                'title'             => $title,
                'image'      => $image,
                'description1' => $description1,
                'description2' => $description2,
                'description3' => $description3,
                'link'             => $link,
                'args'              => $args,
            ), true);

            echo apply_filters( 'tech888f_output_content', $args['after_widget'] ?? '' );
        }

        function update($new_instance, $old_instance)
        {
            $instance = array();
            foreach ($this->default as $key => $value) {
                $instance[$key] = (!empty($new_instance[$key])) ? strip_tags($new_instance[$key]) : '';
            }
            return $instance;
        }

        function form($instance)
        {
            $instance = wp_parse_args($instance, $this->default);
?>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('title')); ?>">
                    <?php esc_html_e('Title:', 'nebon'); ?>
                </label>
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($instance['title']); ?>">
            </p>
            <?php
            ?>
            <div class="banner-image-upload">
                <label for="<?php echo esc_attr($this->get_field_id('image')); ?>">
                    <?php esc_html_e('Image:', 'nebon'); ?>
                </label>
                <input class="widefat image-text-url" id="<?php echo esc_attr($this->get_field_id('image')); ?>" name="<?php echo esc_attr($this->get_field_name('image')); ?>" type="text" value="<?php echo esc_attr($instance['image']); ?>" readonly>
                <button class="button button-secondary image-text-widget-upload-button"><?php esc_html_e('Upload Image', 'nebon'); ?></button>
                <div class="image-preview-outer">
                    <img class="image-preview" src="<?php echo esc_url($instance['image']); ?>" style="max-width:100%; display: <?php echo esc_attr( $instance['image'] ? 'block' : 'none' ); ?>;">
                </div>
            </div>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('link')); ?>">
                    <?php esc_html_e('Link:', 'nebon'); ?>
                </label>
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('link')); ?>" name="<?php echo esc_attr($this->get_field_name('link')); ?>" type="text" value="<?php echo esc_attr($instance['link']); ?>">
            </p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('description1')); ?>">
                    <?php esc_html_e('Description 1:', 'nebon'); ?>
                </label>
                <textarea class="widefat" id="<?php echo esc_attr($this->get_field_id('description1')); ?>" name="<?php echo esc_attr($this->get_field_name('description1')); ?>"><?php echo esc_textarea($instance['description1']); ?></textarea>
            </p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('description2')); ?>">
                    <?php esc_html_e('Description 2:', 'nebon'); ?>
                </label>
                <textarea class="widefat" id="<?php echo esc_attr($this->get_field_id('description2')); ?>" name="<?php echo esc_attr($this->get_field_name('description2')); ?>"><?php echo esc_textarea($instance['description2']); ?></textarea>
            </p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('description3')); ?>">
                    <?php esc_html_e('Description 3:', 'nebon'); ?>
                </label>
                <textarea class="widefat" id="<?php echo esc_attr($this->get_field_id('description3')); ?>" name="<?php echo esc_attr($this->get_field_name('description3')); ?>"><?php echo esc_textarea($instance['description3']); ?></textarea>
            </p>
<?php
        }
    }

    tech888f_ImageTextWidget::_init();
}
