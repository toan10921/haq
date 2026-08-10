<?php

if (!class_exists('tech888f_ListPostsWidget')) {
    class tech888f_ListPostsWidget extends WP_Widget
    {


        protected $default = array();

        static function _init()
        {

            add_action('widgets_init', array(__CLASS__, '_add_widget'));
        }

        static function _add_widget()
        {
            if (function_exists('tech888f_reg_widget'))
                tech888f_reg_widget('tech888f_ListPostsWidget');
        }

        function __construct()
        {
            parent::__construct(
                false,
                esc_html__('7up List Posts ', 'nebon'),
                array('description' => esc_html__('Get List Posts by multiple format', 'nebon'),)
            );

            $this->default = array(
                'title'             => esc_html__('List Posts', 'nebon'),
                'style'             => '',
                'posts_per_page'    => 5,
                'category'          => '',
                'order'             => 'desc',
                'order_by'          => 'date',
                'post_type'         => 'post',

            );
        }

        /**
         * Get order list use for mega menu select
         * @param string|bool $current
         * @param array $extra
         * @param string $return
         * @return array|string
         */
        public function tech888f_get_order_list($current = false, $extra = array(), $return = 'array')
        {
            $default = array(
                esc_html__('None', 'nebon') => 'none',
                esc_html__('ID', 'nebon') => 'ID',
                esc_html__('Author', 'nebon') => 'author',
                esc_html__('Title', 'nebon') => 'title',
                esc_html__('Name', 'nebon') => 'name',
                esc_html__('Date', 'nebon') => 'date',
                esc_html__('Last Modified Date', 'nebon') => 'modified',
                esc_html__('Post Parent', 'nebon') => 'parent',
            );

            if (!empty($extra) and is_array($extra)) {
                $default = array_merge($default, $extra);
            }

            if ($return == "array") {
                return $default;
            } elseif ($return == 'option') {
                $html = '';
                if (!empty($default)) {
                    foreach ($default as $key => $value) {
                        $selected = selected($key, $current, false);
                        $html .= "<option {$selected} value='{$value}'>{$key}</option>";
                    }
                }
                return $html;
            }
        }



        function widget($args, $instance)
        {
            $instance = wp_parse_args($instance, $this->default);
            extract($instance);
            $style = $instance['style'];
            $instance['args'] = $args;

            $post_args = array(
                'posts_per_page' => $posts_per_page,
                'orderby' => $order_by,
                'order' => $order,

            );
            $post_query = new WP_Query($post_args);

            tech888f_get_template_widget('list-post', $style, array(
                'post_query' => $post_query,
                'args' => $args,
                'title' => $title,
            ), true);
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
            $post_types = array('post');

?>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title:', 'nebon'); ?></label>
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>">
            </p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('style')); ?>"><?php esc_html_e('Style:', 'nebon'); ?></label>
                <select class="widefat" id="<?php echo esc_attr($this->get_field_id('style')); ?>" name="<?php echo esc_attr($this->get_field_name('style')); ?>">
                    <option <?php selected('', $style) ?> value=""><?php esc_html_e("Default", "nebon") ?></option>
                    <option <?php selected('style2', $style); ?> value="style2"><?php esc_html_e("Style 2", "nebon"); ?></option>

                </select>
            </p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('posts_per_page')); ?>"><?php esc_html_e('Post Number:', 'nebon'); ?></label>
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('posts_per_page')); ?>" name="<?php echo esc_attr($this->get_field_name('posts_per_page')); ?>" type="text" value="<?php echo esc_attr($posts_per_page); ?>">
            </p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('order_by')); ?>"><?php esc_html_e('Order By:', 'nebon'); ?></label>

                <select class="widefat" id="<?php echo esc_attr($this->get_field_id('order_by')); ?>" name="<?php echo esc_attr($this->get_field_name('order_by')); ?>">
                    <?php
                    echo apply_filters( 'tech888f_output_content', $this->tech888f_get_order_list($order_by, array('post_view' => esc_html__('Post View', 'nebon')), 'option') );
                    ?>
                </select>
            </p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('order')); ?>"><?php esc_html_e('Order:', 'nebon'); ?></label>

                <select class="widefat" id="<?php echo esc_attr($this->get_field_id('order')); ?>" name="<?php echo esc_attr($this->get_field_name('order')); ?>">
                    <option <?php selected('desc', $order) ?> value="desc"><?php esc_html_e("DESC", "nebon") ?></option>
                    <option <?php selected('asc', $order) ?> value="asc"><?php esc_html_e("ASC", "nebon") ?></option>
                </select>
            </p>

<?php
        }
    }

    tech888f_ListPostsWidget::_init();
}
