<?php

if (!class_exists('tech888f_SelectMegaPage_Widget')) {
    class tech888f_SelectMegaPage_Widget extends WP_Widget
    {
        protected $default = array();
        protected $widget_name = 'select-mega';
        protected $registered = false;

        static function _init()
        {
            add_action('widgets_init', array(__CLASS__, '_add_widget'));
        }

        static function _add_widget()
        {
            if (function_exists('tech888f_reg_widget'))
                tech888f_reg_widget('tech888f_SelectMegaPage_Widget');
        }

        function __construct()
        {
            parent::__construct(
                'tech888f_select_mega_widget',
                __('7up Select Mega Page Widget', 'nebon'),
                array('description' => __('A widget to display a selected Mega Page', 'nebon'))
            );

            $this->default = array(
                'title' => esc_html__('Mega Page Display', 'nebon'),
                'mega_page_id' => ''
            );
        }

        function widget($args, $instance)
        {
            echo apply_filters( 'tech888f_output_content', $args['before_widget'] ?? '' );

            // $title = !empty($instance['title']) ? $instance['title'] : __('Mega Page Display', 'nebon');
            $mega_page_id = !empty($instance['mega_page_id']) ? $instance['mega_page_id'] : '';

            if ($mega_page_id) {
                // Lấy nội dung của Mega Page đã chọn
                $mega_page_content = get_post_field('post_content', $mega_page_id);

                // Kiểm tra xem có sử dụng Elementor không
                if (did_action('elementor/loaded')) {
                    $mega_page_content = \Elementor\Plugin::$instance->frontend->get_builder_content_for_display($mega_page_id, true);
                }

                echo '<div class="mega-page-widget">';
                if (!empty($title)) {
                    echo '<h5 class="widget-title">' . esc_html($title) . '</h5>';
                }
                echo '<div class="mega-page-content">' . $mega_page_content . '</div>';
                echo '</div>';
            }

            echo apply_filters( 'tech888f_output_content', $args['after_widget'] ?? '' );
        }

        function update($new_instance, $old_instance)
        {
            $instance = array();
            $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
            $instance['mega_page_id'] = (!empty($new_instance['mega_page_id'])) ? intval($new_instance['mega_page_id']) : '';
            return $instance;
        }

        function form($instance)
        {
            $instance = wp_parse_args($instance, $this->default);

            // Lấy danh sách Mega Page
            $mega_pages = get_posts(array(
                'post_type' => 'mega_item',
                'numberposts' => -1
            ));
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
                <label for="<?php echo esc_attr($this->get_field_id('mega_page_id')); ?>">
                    <?php esc_html_e('Select Mega Page:', 'nebon'); ?>
                </label>
                <select class="widefat" id="<?php echo esc_attr($this->get_field_id('mega_page_id')); ?>"
                    name="<?php echo esc_attr($this->get_field_name('mega_page_id')); ?>">
                    <option value=""><?php esc_html_e('None', 'nebon'); ?></option>
                    <?php foreach ($mega_pages as $page) : ?>
                        <option value="<?php echo esc_attr($page->ID); ?>" <?php selected($instance['mega_page_id'], $page->ID); ?>>
                            <?php echo esc_html($page->post_title); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </p>
<?php
        }
    }

    tech888f_SelectMegaPage_Widget::_init();
}
