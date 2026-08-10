<?php

if (!class_exists('tech888f_ListProduct_Widget')) {
    class tech888f_ListProduct_Widget extends WP_Widget
    {
        protected $default = array();
        protected $widget_name = 'list-product';
        protected $registered = false;

        static function _init()
        {
            add_action('widgets_init', array(__CLASS__, '_add_widget'));
        }

        static function _add_widget()
        {
            if (function_exists('tech888f_reg_widget'))
                tech888f_reg_widget('tech888f_ListProduct_Widget');
        }

        function __construct()
        {
            parent::__construct(
                'tech888f_list_product_widget',
                __('7up Custom List Product Widget', 'nebon'),
                array('description' => __('A widget to display a list of products', 'nebon'))
            );

            $this->default = array(
                'title' => esc_html__('Product List', 'nebon'),
                'number' => 3,
                'style' => 'default',
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
            echo apply_filters( 'tech888f_output_content', $args['before_widget'] ?? '' );

            $title = !empty($instance['title']) ? $instance['title'] : __('Product List', 'nebon');
            $number = !empty($instance['number']) ? (int) $instance['number'] : 5;
            $style = !empty($instance['style']) ? $instance['style'] : 'default';

            tech888f_get_template_widget('list-product', '', array(
                'title' => $title,
                'number' => $number,
                'style' => $style,
                'args'  => $args,
            ), true);

            echo apply_filters( 'tech888f_output_content', $args['after_widget'] ?? '' );
        }

        function update($new_instance, $old_instance)
        {
            $instance = array();
            $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
            $instance['number'] = (!empty($new_instance['number'])) ? (int) $new_instance['number'] : 3;
            $instance['style'] = (!empty($new_instance['style'])) ? strip_tags($new_instance['style']) : 'default';
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
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>"
                    name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text"
                    value="<?php echo esc_attr($instance['title']); ?>">
            </p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('number')); ?>">
                    <?php esc_html_e('Number of Products:', 'nebon'); ?>
                </label>
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('number')); ?>"
                    name="<?php echo esc_attr($this->get_field_name('number')); ?>" type="number" min="1"
                    value="<?php echo esc_attr($instance['number']); ?>">
            </p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('style')); ?>">
                    <?php esc_html_e('Display Style:', 'nebon'); ?>
                </label>
                <select class="widefat" id="<?php echo esc_attr($this->get_field_id('style')); ?>"
                    name="<?php echo esc_attr($this->get_field_name('style')); ?>">
                    <option value="default" <?php selected($instance['style'], 'default'); ?>><?php esc_html_e('Default', 'nebon'); ?></option>
                    <option value="top-rate" <?php selected($instance['style'], 'top-rate'); ?>><?php esc_html_e('Top Rated', 'nebon'); ?></option>
                    <option value="best-seller" <?php selected($instance['style'], 'best-seller'); ?>><?php esc_html_e('Best Seller', 'nebon'); ?></option>
                </select>
            </p>
<?php
        }
    }

    tech888f_ListProduct_Widget::_init();
}