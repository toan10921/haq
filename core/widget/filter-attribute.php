<?php
if (!class_exists('tech888f_FilterAttribute_Widget')) {
    class tech888f_FilterAttribute_Widget extends WP_Widget
    {
        protected $default = array();
        protected $widget_name = 'filter-attribute';
        protected $registered = false;

        static function _init()
        {
            add_action('widgets_init', array(__CLASS__, '_add_widget'));
        }

        static function _add_widget()
        {
            if (function_exists('tech888f_reg_widget'))
                tech888f_reg_widget('tech888f_FilterAttribute_Widget');
        }

        function __construct()
        {
            parent::__construct(
                'tech888f_filter_attribute_widget',
                __('7up Custom Attribute Filter Widget', 'nebon'),
                array('description' => __('A widget to filter products by attributes', 'nebon'))
            );

            $this->default = array(
                'title' => esc_html__('Filter by Attribute', 'nebon'),
                'attribute' => ''
            );

            add_action('wp_enqueue_scripts', array($this, 'enqueue_admin_scripts'));
        }

        public function enqueue_admin_scripts()
        {
            // $css_file = get_template_directory() . '/core/widget/assets/css/' . $this->widget_name . '.css';
            // $js_file = get_template_directory() . '/core/widget/assets/js/' . $this->widget_name . '.js';

            // wp_enqueue_style(
            //     'widget-' . $this->widget_name,
            //     get_template_directory_uri() . '/core/widget/assets/css/' . $this->widget_name . '.css',
            //     array(),
            //     filemtime($css_file),
            //     'all'
            // );

            // wp_enqueue_script(
            //     'widget-' . $this->widget_name,
            //     get_template_directory_uri() . '/core/widget/assets/js/' . $this->widget_name . '.js',
            //     ['jquery'],
            //     filemtime($js_file),
            //     true
            // );
        }

        function widget($args, $instance)
        {
            echo apply_filters('tech888f_output_content', $args['before_widget'] ?? '');

            $title = !empty($instance['title']) ? $instance['title'] : __('Filter by Attribute', 'nebon');
            $attribute = !empty($instance['attribute']) ? $instance['attribute'] : '';

            tech888f_get_template_widget('filter-attribute', '', array(
                'title' => $title,
                'attribute' => $attribute,
                'args'  => $args,
                'current_url' => get_current_url(),
            ), true);

            echo apply_filters('tech888f_output_content', $args['after_widget'] ?? '');
        }

        function update($new_instance, $old_instance)
        {
            $instance = array();
            $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
            $instance['attribute'] = (!empty($new_instance['attribute'])) ? strip_tags($new_instance['attribute']) : '';
            return $instance;
        }

        function form($instance)
        {
            // check if WooCommerce is active
            if (!class_exists('WooCommerce')) {
                echo '<p>' . esc_html__('WooCommerce is not active. Please activate WooCommerce to use this widget.', 'nebon') . '</p>';
                return;
            }
            $instance = wp_parse_args($instance, $this->default);
            $attributes = wc_get_attribute_taxonomies();
?>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('title')); ?>">
                    <?php esc_html_e('Title:', 'nebon'); ?>
                </label>
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>"
                    name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text"
                    value="<?php echo esc_attr($instance['title']); ?>">
            </p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('attribute')); ?>">
                    <?php esc_html_e('Select Attribute:', 'nebon'); ?>
                </label>
                <select class="widefat" id="<?php echo esc_attr($this->get_field_id('attribute')); ?>"
                    name="<?php echo esc_attr($this->get_field_name('attribute')); ?>">
                    <?php foreach ($attributes as $attr) : ?>
                        <option value="<?php echo esc_attr($attr->attribute_name); ?>" <?php selected($instance['attribute'], $attr->attribute_name); ?>>
                            <?php echo esc_html($attr->attribute_label); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </p>
<?php
        }
    }

    tech888f_FilterAttribute_Widget::_init();
}
