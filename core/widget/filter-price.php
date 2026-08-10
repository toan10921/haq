<?php

if (!class_exists('tech888f_FilterPrice_Widget')) {
    class tech888f_FilterPrice_Widget extends WP_Widget
    {
        protected $default = array();
        protected $widget_name = 'filter-price';
        protected $registered = false;

        static function _init()
        {
            add_action('widgets_init', array(__CLASS__, '_add_widget'));
        }

        static function _add_widget()
        {
            if (function_exists('tech888f_reg_widget'))
                tech888f_reg_widget('tech888f_FilterPrice_Widget');
        }

        function __construct()
{
    parent::__construct(
        'tech888f_filter_price_widget',
        __('7up Custom Price Filter Widget', 'nebon'),
        array('description' => __('A widget to filter products by price', 'nebon'))
    );

    $this->default = array(
        'title' => esc_html__('Filter by Price', 'nebon'),
    );

    add_action('wp_enqueue_scripts', array($this, 'enqueue_admin_scripts')); 
}


        public function enqueue_admin_scripts()
        {
            if (get_theme_mod('shop_ajax_general', 'off') === 'on' && is_shop()) {
        return;
    }
            // $css_file = get_template_directory() . '/core/widget/assets/css/' . $this->widget_name . '.css';
            $js_file = get_template_directory() . '/core/widget/assets/js/' . $this->widget_name . '.js';

            // wp_enqueue_style(
            //     'widget-' . $this->widget_name,
            //     get_template_directory_uri() . '/core/widget/assets/css/' . $this->widget_name . '.css',
            //     array(),
            //     filemtime($css_file), 
            //     'all'
            // );

            wp_enqueue_script(
                'widget-' . $this->widget_name,
                get_template_directory_uri() . '/core/widget/assets/js/' . $this->widget_name . '.js',
                ['jquery'],
                filemtime($js_file), 
                true
            );
        }

        function widget($args, $instance)
        {
            echo apply_filters( 'tech888f_output_content', $args['before_widget'] ?? '' );

            $title = !empty($instance['title']) ? $instance['title'] : __('Filter by Price', 'nebon');

            tech888f_get_template_widget('filter-price', '', array(
                'title' => $title,
                'args'  => $args,
            ), true);

            echo apply_filters( 'tech888f_output_content', $args['after_widget'] ?? '' );
        }

        function update($new_instance, $old_instance)
        {
            $instance = array();
            $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
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
<?php
        }
    }

    tech888f_FilterPrice_Widget::_init();
}
