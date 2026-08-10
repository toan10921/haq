<?php
if (!class_exists('tech888f_SocialIconsWidget')) {
    class tech888f_SocialIconsWidget extends WP_Widget
    {

        protected $default = array();
        protected $widget_name = 'social-icons';
        protected $version = '1.0.0';
        protected $registered = false;

        function __construct()
        {
            parent::__construct(
                'tech888f_social_icons_widget',
                esc_html__('7up Social Icons Widget', 'nebon'),
                array('description' => esc_html__('Display social media icons with links.', 'nebon'))
            );

            $this->default = array(
                'title'     => '',
                'social_icons' => array(),
                'social_urls' => array(),
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

            if ($this->is_preview()) {
                add_action('wp_enqueue_scripts', array($this, 'enqueue_preview_scripts'));
            }

            parent::_register_one($number); // Call the parent method to ensure proper registration
        }

        public function enqueue_admin_scripts()
        {
            wp_enqueue_style('widget-' . $this->widget_name, get_template_directory_uri() . '/core/widget/assets/css/' . $this->widget_name . '.css', array(), $this->version, 'all');
            wp_enqueue_style('font-awesome-widget', get_template_directory_uri() . '/customizer-repeater/css/font-awesome.min.css', array(), $this->version, 'all');
            wp_enqueue_script('widget-' . $this->widget_name, get_template_directory_uri() . '/core/widget/assets/js/' . $this->widget_name . '.js', ['jquery'], $this->version, true);
        }

        /**
         * Enqueue preview scripts.
         *
         * These scripts normally are enqueued just-in-time when a widget is rendered.
         * In the customizer, however, widgets can be dynamically added and rendered via
         * selective refresh, and so it is important to unconditionally enqueue them in
         * case a widget does get added.
         *
         * @since 4.8.0
         */
        public function enqueue_preview_scripts() {}


        function widget($args, $instance)
        {
            echo apply_filters( 'tech888f_output_content', $args['before_widget'] ?? '' );
            $title = !empty($instance['title']) ? $instance['title'] : '';

            $social_icons = !empty($instance['social_icons']) ? $instance['social_icons'] : [];
            $social_urls = !empty($instance['social_urls']) ? $instance['social_urls'] : [];
            // merge social icons and social urls
            $icons = [];
            foreach ($social_icons as $key => $icon) {
                $icons[] = array(
                    'icon' => $icon,
                    'link' => isset($social_urls[$key]) ? $social_urls[$key] : '',
                );
            }

            tech888f_get_template_widget('social-icons', '', array(
                'icons' => $icons,
                'args' => $args,
                'title' => $title,
            ), true);

            echo apply_filters( 'tech888f_output_content', $args['after_widget'] ?? '' );
        }

        function update($new_instance, $old_instance)
        {

            $instance = $old_instance;

            // Sanitize the title input
            $instance['title'] = !empty($new_instance['title']) ? sanitize_text_field($new_instance['title']) : '';

            // Sanitize the social URLs array
            if (isset($new_instance['social_urls']) && is_array($new_instance['social_urls'])) {
                $instance['social_urls'] = array_map('esc_url_raw', $new_instance['social_urls']);
            } else {
                $instance['social_urls'] = [];
            }

            // Sanitize the social icons array
            if (isset($new_instance['social_icons']) && is_array($new_instance['social_icons'])) {
                $instance['social_icons'] = array_map('sanitize_text_field', $new_instance['social_icons']);
            } else {
                $instance['social_icons'] = [];
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
            <div class="iconpicker-popover-container">
                <?php
                $social_icons = !empty($instance['social_icons']) ? $instance['social_icons'] : [];
                $social_urls = !empty($instance['social_urls']) ? $instance['social_urls'] : [];
                if (count($social_icons) > 0) {
                    foreach ($social_icons as $key => $icon) {
                ?>
                        <div class="iconpicker-popover popover bottomLeft iconpicker-visible">
                            <div class="arrow"></div>
                            <p class="popover-title">
                                <input type="search" class="form-control iconpicker-search" value="<?php echo esc_attr($icon); ?>" name="<?php echo esc_attr($this->get_field_name('social_icons')); ?>[]" placeholder="Type to filter">
                            </p>
                            <div class="popover-content" style="display: none;">
                                <div class="iconpicker">
                                    <div class="iconpicker-items">
                                        <i data-type="iconpicker-item" title=".fa-brands fa-facebook fa-fw" class="fa-brands fa-facebook fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-twitter fa-fw" class="fa-brands fa-twitter fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-instagram fa-fw" class="fa-brands fa-instagram fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-tiktok fa-fw" class="fa-brands fa-tiktok fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-linkedin fa-fw" class="fa-brands fa-linkedin fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-github fa-fw" class="fa-brands fa-github fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-discord fa-fw" class="fa-brands fa-discord fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-youtube fa-fw" class="fa-brands fa-youtube fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-wordpress fa-fw" class="fa-brands fa-wordpress fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-slack fa-fw" class="fa-brands fa-slack fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-figma fa-fw" class="fa-brands fa-figma fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-apple fa-fw" class="fa-brands fa-apple fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-google fa-fw" class="fa-brands fa-google fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-stripe fa-fw" class="fa-brands fa-stripe fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-algolia fa-fw" class="fa-brands fa-algolia fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-docker fa-fw" class="fa-brands fa-docker fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-windows fa-fw" class="fa-brands fa-windows fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-paypal fa-fw" class="fa-brands fa-paypal fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-stack-overflow fa-fw" class="fa-brands fa-stack-overflow fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-kickstarter fa-fw" class="fa-brands fa-kickstarter fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-dribbble fa-fw" class="fa-brands fa-dribbble fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-dropbox fa-fw" class="fa-brands fa-dropbox fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-squarespace fa-fw" class="fa-brands fa-squarespace fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-android fa-fw" class="fa-brands fa-android fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-shopify fa-fw" class="fa-brands fa-shopify fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-medium fa-fw" class="fa-brands fa-medium fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-codepen fa-fw" class="fa-brands fa-codepen fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-cloudflare fa-fw" class="fa-brands fa-cloudflare fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-airbnb fa-fw" class="fa-brands fa-airbnb fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-vimeo fa-fw" class="fa-brands fa-vimeo fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-whatsapp fa-fw" class="fa-brands fa-whatsapp fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-intercom fa-fw" class="fa-brands fa-intercom fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-usps fa-fw" class="fa-brands fa-usps fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-wix fa-fw" class="fa-brands fa-wix fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-line fa-fw" class="fa-brands fa-line fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-behance fa-fw" class="fa-brands fa-behance fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-openid fa-fw" class="fa-brands fa-openid fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-product-hunt fa-fw" class="fa-brands fa-product-hunt fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-internet-explorer fa-fw" class="fa-brands fa-internet-explorer fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-pagelines fa-fw" class="fa-brands fa-pagelines fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-teamspeak fa-fw" class="fa-brands fa-teamspeak fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-html5 fa-fw" class="fa-brands fa-html5 fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-telegram fa-fw" class="fa-brands fa-telegram fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-pinterest fa-fw" class="fa-brands fa-pinterest fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-dashcube fa-fw" class="fa-brands fa-dashcube fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-ideal fa-fw" class="fa-brands fa-ideal fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-salesforce fa-fw" class="fa-brands fa-salesforce fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-readme fa-fw" class="fa-brands fa-readme fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-free-code-camp fa-fw" class="fa-brands fa-free-code-camp fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-soundcloud fa-fw" class="fa-brands fa-soundcloud fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-square-twitter fa-fw" class="fa-brands fa-square-twitter fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-accessible-icon fa-fw" class="fa-brands fa-accessible-icon fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-cc-visa fa-fw" class="fa-brands fa-cc-visa fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-goodreads-g fa-fw" class="fa-brands fa-goodreads-g fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-google-play fa-fw" class="fa-brands fa-google-play fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-react fa-fw" class="fa-brands fa-react fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-wikipedia-w fa-fw" class="fa-brands fa-wikipedia-w fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-square-js fa-fw" class="fa-brands fa-square-js fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-java fa-fw" class="fa-brands fa-java fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-square-pinterest fa-fw" class="fa-brands fa-square-pinterest fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-python fa-fw" class="fa-brands fa-python fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-skype fa-fw" class="fa-brands fa-skype fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-linux fa-fw" class="fa-brands fa-linux fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-node fa-fw" class="fa-brands fa-node fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-rebel fa-fw" class="fa-brands fa-rebel fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-etsy fa-fw" class="fa-brands fa-etsy fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-discourse fa-fw" class="fa-brands fa-discourse fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-amazon fa-fw" class="fa-brands fa-amazon fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-glide-g fa-fw" class="fa-brands fa-glide-g fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-gitlab fa-fw" class="fa-brands fa-gitlab fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-spotify fa-fw" class="fa-brands fa-spotify fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-think-peaks fa-fw" class="fa-brands fa-think-peaks fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-microsoft fa-fw" class="fa-brands fa-microsoft fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-elementor fa-fw" class="fa-brands fa-elementor fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-pied-piper fa-fw" class="fa-brands fa-pied-piper fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-square-youtube fa-fw" class="fa-brands fa-square-youtube fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-cc-mastercard fa-fw" class="fa-brands fa-cc-mastercard fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-facebook-messenger fa-fw" class="fa-brands fa-facebook-messenger fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-atlassian fa-fw" class="fa-brands fa-atlassian fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-playstation fa-fw" class="fa-brands fa-playstation fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-fly fa-fw" class="fa-brands fa-fly fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-meetup fa-fw" class="fa-brands fa-meetup fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-twitch fa-fw" class="fa-brands fa-twitch fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-waze fa-fw" class="fa-brands fa-waze fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-zhihu fa-fw" class="fa-brands fa-zhihu fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-yoast fa-fw" class="fa-brands fa-yoast fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-yelp fa-fw" class="fa-brands fa-yelp fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-yarn fa-fw" class="fa-brands fa-yarn fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-yandex-international fa-fw" class="fa-brands fa-yandex-international fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-yandex fa-fw" class="fa-brands fa-yandex fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-yammer fa-fw" class="fa-brands fa-yammer fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-yahoo fa-fw" class="fa-brands fa-yahoo fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-y-combinator fa-fw" class="fa-brands fa-y-combinator fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-xing fa-fw" class="fa-brands fa-xing fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-xbox fa-fw" class="fa-brands fa-xbox fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-x-twitter fa-fw" class="fa-brands fa-x-twitter fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-wpressr fa-fw" class="fa-brands fa-wpressr fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-wpforms fa-fw" class="fa-brands fa-wpforms fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-wpexplorer fa-fw" class="fa-brands fa-wpexplorer fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-wpbeginner fa-fw" class="fa-brands fa-wpbeginner fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-wordpress-simple fa-fw" class="fa-brands fa-wordpress-simple fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-wolf-pack-battalion fa-fw" class="fa-brands fa-wolf-pack-battalion fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-wodu fa-fw" class="fa-brands fa-wodu fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-wizards-of-the-coast fa-fw" class="fa-brands fa-wizards-of-the-coast fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-wirsindhandwerk fa-fw" class="fa-brands fa-wirsindhandwerk fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-whmcs fa-fw" class="fa-brands fa-whmcs fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-weixin fa-fw" class="fa-brands fa-weixin fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-weibo fa-fw" class="fa-brands fa-weibo fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-weebly fa-fw" class="fa-brands fa-weebly fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-webflow fa-fw" class="fa-brands fa-webflow fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-web-awesome fa-fw" class="fa-brands fa-web-awesome fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-watchman-monitoring fa-fw" class="fa-brands fa-watchman-monitoring fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-vuejs fa-fw" class="fa-brands fa-vuejs fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-vnv fa-fw" class="fa-brands fa-vnv fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-vk fa-fw" class="fa-brands fa-vk fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-vine fa-fw" class="fa-brands fa-vine fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-vimeo-v fa-fw" class="fa-brands fa-vimeo-v fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-viber fa-fw" class="fa-brands fa-viber fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-viadeo fa-fw" class="fa-brands fa-viadeo fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-viacoin fa-fw" class="fa-brands fa-viacoin fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-vaadin fa-fw" class="fa-brands fa-vaadin fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-ussunnah fa-fw" class="fa-brands fa-ussunnah fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-usb fa-fw" class="fa-brands fa-usb fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-upwork fa-fw" class="fa-brands fa-upwork fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-ups fa-fw" class="fa-brands fa-ups fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-untappd fa-fw" class="fa-brands fa-untappd fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-unsplash fa-fw" class="fa-brands fa-unsplash fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-unity fa-fw" class="fa-brands fa-unity fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-uniregistry fa-fw" class="fa-brands fa-uniregistry fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-uncharted fa-fw" class="fa-brands fa-uncharted fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-umbraco fa-fw" class="fa-brands fa-umbraco fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-uikit fa-fw" class="fa-brands fa-uikit fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-ubuntu fa-fw" class="fa-brands fa-ubuntu fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-uber fa-fw" class="fa-brands fa-uber fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-typo3 fa-fw" class="fa-brands fa-typo3 fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-tumblr fa-fw" class="fa-brands fa-tumblr fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-trello fa-fw" class="fa-brands fa-trello fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-trade-federation fa-fw" class="fa-brands fa-trade-federation fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-threads fa-fw" class="fa-brands fa-threads fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-themeisle fa-fw" class="fa-brands fa-themeisle fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-themeco fa-fw" class="fa-brands fa-themeco fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-the-red-yeti fa-fw" class="fa-brands fa-the-red-yeti fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-tencent-weibo fa-fw" class="fa-brands fa-tencent-weibo fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-symfony fa-fw" class="fa-brands fa-symfony fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-swift fa-fw" class="fa-brands fa-swift fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-suse fa-fw" class="fa-brands fa-suse fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-supple fa-fw" class="fa-brands fa-supple fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-superpowers fa-fw" class="fa-brands fa-superpowers fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-stumbleupon-circle fa-fw" class="fa-brands fa-stumbleupon-circle fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-stumbleupon fa-fw" class="fa-brands fa-stumbleupon fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-studiovinari fa-fw" class="fa-brands fa-studiovinari fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-stubber fa-fw" class="fa-brands fa-stubber fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-stripe-s fa-fw" class="fa-brands fa-stripe-s fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-strava fa-fw" class="fa-brands fa-strava fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-sticker-mule fa-fw" class="fa-brands fa-sticker-mule fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-steam-symbol fa-fw" class="fa-brands fa-steam-symbol fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-steam fa-fw" class="fa-brands fa-steam fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-staylinked fa-fw" class="fa-brands fa-staylinked fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-stackpath fa-fw" class="fa-brands fa-stackpath fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-stack-exchange fa-fw" class="fa-brands fa-stack-exchange fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-square-xing fa-fw" class="fa-brands fa-square-xing fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-square-x-twitter fa-fw" class="fa-brands fa-square-x-twitter fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-square-whatsapp fa-fw" class="fa-brands fa-square-whatsapp fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-square-web-awesome-stroke fa-fw" class="fa-brands fa-square-web-awesome-stroke fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-square-web-awesome fa-fw" class="fa-brands fa-square-web-awesome fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-square-vimeo fa-fw" class="fa-brands fa-square-vimeo fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-square-viadeo fa-fw" class="fa-brands fa-square-viadeo fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-square-upwork fa-fw" class="fa-brands fa-square-upwork fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-square-tumblr fa-fw" class="fa-brands fa-square-tumblr fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-square-threads fa-fw" class="fa-brands fa-square-threads fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-square-steam fa-fw" class="fa-brands fa-square-steam fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-square-snapchat fa-fw" class="fa-brands fa-square-snapchat fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-square-reddit fa-fw" class="fa-brands fa-square-reddit fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-square-pied-piper fa-fw" class="fa-brands fa-square-pied-piper fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-square-odnoklassniki fa-fw" class="fa-brands fa-square-odnoklassniki fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-square-letterboxd fa-fw" class="fa-brands fa-square-letterboxd fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-square-lastfm fa-fw" class="fa-brands fa-square-lastfm fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-square-instagram fa-fw" class="fa-brands fa-square-instagram fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-square-hacker-news fa-fw" class="fa-brands fa-square-hacker-news fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-square-google-plus fa-fw" class="fa-brands fa-square-google-plus fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-square-gitlab fa-fw" class="fa-brands fa-square-gitlab fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-square-github fa-fw" class="fa-brands fa-square-github fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-square-git fa-fw" class="fa-brands fa-square-git fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-square-font-awesome-stroke fa-fw" class="fa-brands fa-square-font-awesome-stroke fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-square-font-awesome fa-fw" class="fa-brands fa-square-font-awesome fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-square-facebook fa-fw" class="fa-brands fa-square-facebook fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-square-dribbble fa-fw" class="fa-brands fa-square-dribbble fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-square-bluesky fa-fw" class="fa-brands fa-square-bluesky fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-square-behance fa-fw" class="fa-brands fa-square-behance fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-speaker-deck fa-fw" class="fa-brands fa-speaker-deck fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-speakap fa-fw" class="fa-brands fa-speakap fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-space-awesome fa-fw" class="fa-brands fa-space-awesome fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-sourcetree fa-fw" class="fa-brands fa-sourcetree fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-snapchat fa-fw" class="fa-brands fa-snapchat fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-slideshare fa-fw" class="fa-brands fa-slideshare fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-skyatlas fa-fw" class="fa-brands fa-skyatlas fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-sketch fa-fw" class="fa-brands fa-sketch fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-sitrox fa-fw" class="fa-brands fa-sitrox fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-sith fa-fw" class="fa-brands fa-sith fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-sistrix fa-fw" class="fa-brands fa-sistrix fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-simplybuilt fa-fw" class="fa-brands fa-simplybuilt fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-signal-messenger fa-fw" class="fa-brands fa-signal-messenger fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-shopware fa-fw" class="fa-brands fa-shopware fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-shoelace fa-fw" class="fa-brands fa-shoelace fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-shirtsinbulk fa-fw" class="fa-brands fa-shirtsinbulk fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-servicestack fa-fw" class="fa-brands fa-servicestack fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-sellsy fa-fw" class="fa-brands fa-sellsy fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-sellcast fa-fw" class="fa-brands fa-sellcast fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-searchengin fa-fw" class="fa-brands fa-searchengin fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-scribd fa-fw" class="fa-brands fa-scribd fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-screenpal fa-fw" class="fa-brands fa-screenpal fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-schlix fa-fw" class="fa-brands fa-schlix fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-sass fa-fw" class="fa-brands fa-sass fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-safari fa-fw" class="fa-brands fa-safari fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-rust fa-fw" class="fa-brands fa-rust fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-rockrms fa-fw" class="fa-brands fa-rockrms fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-rocketchat fa-fw" class="fa-brands fa-rocketchat fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-rev fa-fw" class="fa-brands fa-rev fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-resolving fa-fw" class="fa-brands fa-resolving fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-researchgate fa-fw" class="fa-brands fa-researchgate fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-replyd fa-fw" class="fa-brands fa-replyd fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-renren fa-fw" class="fa-brands fa-renren fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-redhat fa-fw" class="fa-brands fa-redhat fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-reddit-alien fa-fw" class="fa-brands fa-reddit-alien fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-reddit fa-fw" class="fa-brands fa-reddit fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-red-river fa-fw" class="fa-brands fa-red-river fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-reacteurope fa-fw" class="fa-brands fa-reacteurope fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-ravelry fa-fw" class="fa-brands fa-ravelry fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-raspberry-pi fa-fw" class="fa-brands fa-raspberry-pi fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-r-project fa-fw" class="fa-brands fa-r-project fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-quora fa-fw" class="fa-brands fa-quora fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-quinscape fa-fw" class="fa-brands fa-quinscape fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-qq fa-fw" class="fa-brands fa-qq fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-pushed fa-fw" class="fa-brands fa-pushed fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-pixiv fa-fw" class="fa-brands fa-pixiv fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-pix fa-fw" class="fa-brands fa-pix fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-pinterest-p fa-fw" class="fa-brands fa-pinterest-p fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-pied-piper-pp fa-fw" class="fa-brands fa-pied-piper-pp fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-pied-piper-hat fa-fw" class="fa-brands fa-pied-piper-hat fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-pied-piper-alt fa-fw" class="fa-brands fa-pied-piper-alt fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-php fa-fw" class="fa-brands fa-php fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-phoenix-squadron fa-fw" class="fa-brands fa-phoenix-squadron fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-phoenix-framework fa-fw" class="fa-brands fa-phoenix-framework fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-phabricator fa-fw" class="fa-brands fa-phabricator fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-periscope fa-fw" class="fa-brands fa-periscope fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-perbyte fa-fw" class="fa-brands fa-perbyte fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-patreon fa-fw" class="fa-brands fa-patreon fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-palfed fa-fw" class="fa-brands fa-palfed fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-page4 fa-fw" class="fa-brands fa-page4 fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-padlet fa-fw" class="fa-brands fa-padlet fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-osi fa-fw" class="fa-brands fa-osi fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-orcid fa-fw" class="fa-brands fa-orcid fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-optin-monster fa-fw" class="fa-brands fa-optin-monster fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-opera fa-fw" class="fa-brands fa-opera fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-opensuse fa-fw" class="fa-brands fa-opensuse fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-opencart fa-fw" class="fa-brands fa-opencart fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-old-republic fa-fw" class="fa-brands fa-old-republic fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-odysee fa-fw" class="fa-brands fa-odysee fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-odnoklassniki fa-fw" class="fa-brands fa-odnoklassniki fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-octopus-deploy fa-fw" class="fa-brands fa-octopus-deploy fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-nutritionix fa-fw" class="fa-brands fa-nutritionix fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-ns8 fa-fw" class="fa-brands fa-ns8 fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-npm fa-fw" class="fa-brands fa-npm fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-node-js fa-fw" class="fa-brands fa-node-js fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-nimblr fa-fw" class="fa-brands fa-nimblr fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-nfc-symbol fa-fw" class="fa-brands fa-nfc-symbol fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-nfc-directional fa-fw" class="fa-brands fa-nfc-directional fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-neos fa-fw" class="fa-brands fa-neos fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-napster fa-fw" class="fa-brands fa-napster fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-monero fa-fw" class="fa-brands fa-monero fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-modx fa-fw" class="fa-brands fa-modx fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-mizuni fa-fw" class="fa-brands fa-mizuni fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-mixer fa-fw" class="fa-brands fa-mixer fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-mixcloud fa-fw" class="fa-brands fa-mixcloud fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-mix fa-fw" class="fa-brands fa-mix fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-mintbit fa-fw" class="fa-brands fa-mintbit fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-microblog fa-fw" class="fa-brands fa-microblog fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-meta fa-fw" class="fa-brands fa-meta fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-mendeley fa-fw" class="fa-brands fa-mendeley fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-megaport fa-fw" class="fa-brands fa-megaport fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-medrt fa-fw" class="fa-brands fa-medrt fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-medapps fa-fw" class="fa-brands fa-medapps fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-mdb fa-fw" class="fa-brands fa-mdb fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-maxcdn fa-fw" class="fa-brands fa-maxcdn fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-mastodon fa-fw" class="fa-brands fa-mastodon fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-markdown fa-fw" class="fa-brands fa-markdown fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-mandalorian fa-fw" class="fa-brands fa-mandalorian fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-mailchimp fa-fw" class="fa-brands fa-mailchimp fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-magento fa-fw" class="fa-brands fa-magento fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-lyft fa-fw" class="fa-brands fa-lyft fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-linode fa-fw" class="fa-brands fa-linode fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-linkedin-in fa-fw" class="fa-brands fa-linkedin-in fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-letterboxd fa-fw" class="fa-brands fa-letterboxd fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-less fa-fw" class="fa-brands fa-less fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-leanpub fa-fw" class="fa-brands fa-leanpub fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-lastfm fa-fw" class="fa-brands fa-lastfm fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-laravel fa-fw" class="fa-brands fa-laravel fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-korvue fa-fw" class="fa-brands fa-korvue fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-kickstarter-k fa-fw" class="fa-brands fa-kickstarter-k fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-keycdn fa-fw" class="fa-brands fa-keycdn fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-keybase fa-fw" class="fa-brands fa-keybase fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-kaggle fa-fw" class="fa-brands fa-kaggle fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-jxl fa-fw" class="fa-brands fa-jxl fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-jsfiddle fa-fw" class="fa-brands fa-jsfiddle fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-js fa-fw" class="fa-brands fa-js fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-joomla fa-fw" class="fa-brands fa-joomla fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-joget fa-fw" class="fa-brands fa-joget fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-jira fa-fw" class="fa-brands fa-jira fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-jenkins fa-fw" class="fa-brands fa-jenkins fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-jedi-order fa-fw" class="fa-brands fa-jedi-order fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-itunes-note fa-fw" class="fa-brands fa-itunes-note fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-itunes fa-fw" class="fa-brands fa-itunes fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-itch-io fa-fw" class="fa-brands fa-itch-io fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-ioxhost fa-fw" class="fa-brands fa-ioxhost fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-invision fa-fw" class="fa-brands fa-invision fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-instalod fa-fw" class="fa-brands fa-instalod fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-imdb fa-fw" class="fa-brands fa-imdb fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-hubspot fa-fw" class="fa-brands fa-hubspot fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-houzz fa-fw" class="fa-brands fa-houzz fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-hotjar fa-fw" class="fa-brands fa-hotjar fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-hornbill fa-fw" class="fa-brands fa-hornbill fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-hooli fa-fw" class="fa-brands fa-hooli fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-hive fa-fw" class="fa-brands fa-hive fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-hire-a-helper fa-fw" class="fa-brands fa-hire-a-helper fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-hips fa-fw" class="fa-brands fa-hips fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-hashnode fa-fw" class="fa-brands fa-hashnode fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-hackerrank fa-fw" class="fa-brands fa-hackerrank fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-hacker-news fa-fw" class="fa-brands fa-hacker-news fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-gulp fa-fw" class="fa-brands fa-gulp fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-guilded fa-fw" class="fa-brands fa-guilded fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-grunt fa-fw" class="fa-brands fa-grunt fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-gripfire fa-fw" class="fa-brands fa-gripfire fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-grav fa-fw" class="fa-brands fa-grav fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-gratipay fa-fw" class="fa-brands fa-gratipay fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-google-wallet fa-fw" class="fa-brands fa-google-wallet fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-google-scholar fa-fw" class="fa-brands fa-google-scholar fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-google-plus-g fa-fw" class="fa-brands fa-google-plus-g fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-google-plus fa-fw" class="fa-brands fa-google-plus fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-google-pay fa-fw" class="fa-brands fa-google-pay fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-google-drive fa-fw" class="fa-brands fa-google-drive fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-goodreads fa-fw" class="fa-brands fa-goodreads fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-golang fa-fw" class="fa-brands fa-golang fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-gofore fa-fw" class="fa-brands fa-gofore fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-glide fa-fw" class="fa-brands fa-glide fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-gitter fa-fw" class="fa-brands fa-gitter fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-gitkraken fa-fw" class="fa-brands fa-gitkraken fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-github-alt fa-fw" class="fa-brands fa-github-alt fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-git-alt fa-fw" class="fa-brands fa-git-alt fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-git fa-fw" class="fa-brands fa-git fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-gg-circle fa-fw" class="fa-brands fa-gg-circle fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-gg fa-fw" class="fa-brands fa-gg fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-get-pocket fa-fw" class="fa-brands fa-get-pocket fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-galactic-senate fa-fw" class="fa-brands fa-galactic-senate fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-galactic-republic fa-fw" class="fa-brands fa-galactic-republic fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-fulcrum fa-fw" class="fa-brands fa-fulcrum fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-freebsd fa-fw" class="fa-brands fa-freebsd fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-foursquare fa-fw" class="fa-brands fa-foursquare fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-forumbee fa-fw" class="fa-brands fa-forumbee fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-fort-awesome-alt fa-fw" class="fa-brands fa-fort-awesome-alt fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-fort-awesome fa-fw" class="fa-brands fa-fort-awesome fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-fonticons-fi fa-fw" class="fa-brands fa-fonticons-fi fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-fonticons fa-fw" class="fa-brands fa-fonticons fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-font-awesome fa-fw" class="fa-brands fa-font-awesome fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-flutter fa-fw" class="fa-brands fa-flutter fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-flipboard fa-fw" class="fa-brands fa-flipboard fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-flickr fa-fw" class="fa-brands fa-flickr fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-firstdraft fa-fw" class="fa-brands fa-firstdraft fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-first-order-alt fa-fw" class="fa-brands fa-first-order-alt fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-first-order fa-fw" class="fa-brands fa-first-order fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-firefox-browser fa-fw" class="fa-brands fa-firefox-browser fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-firefox fa-fw" class="fa-brands fa-firefox fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-files-pinwheel fa-fw" class="fa-brands fa-files-pinwheel fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-fedora fa-fw" class="fa-brands fa-fedora fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-fedex fa-fw" class="fa-brands fa-fedex fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-fantasy-flight-games fa-fw" class="fa-brands fa-fantasy-flight-games fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-facebook-f fa-fw" class="fa-brands fa-facebook-f fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-expeditedssl fa-fw" class="fa-brands fa-expeditedssl fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-evernote fa-fw" class="fa-brands fa-evernote fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-ethereum fa-fw" class="fa-brands fa-ethereum fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-erlang fa-fw" class="fa-brands fa-erlang fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-envira fa-fw" class="fa-brands fa-envira fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-empire fa-fw" class="fa-brands fa-empire fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-ember fa-fw" class="fa-brands fa-ember fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-ello fa-fw" class="fa-brands fa-ello fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-edge-legacy fa-fw" class="fa-brands fa-edge-legacy fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-edge fa-fw" class="fa-brands fa-edge fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-ebay fa-fw" class="fa-brands fa-ebay fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-earlybirds fa-fw" class="fa-brands fa-earlybirds fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-dyalog fa-fw" class="fa-brands fa-dyalog fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-drupal fa-fw" class="fa-brands fa-drupal fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-draft2digital fa-fw" class="fa-brands fa-draft2digital fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-dochub fa-fw" class="fa-brands fa-dochub fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-digital-ocean fa-fw" class="fa-brands fa-digital-ocean fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-digg fa-fw" class="fa-brands fa-digg fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-diaspora fa-fw" class="fa-brands fa-diaspora fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-dhl fa-fw" class="fa-brands fa-dhl fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-deviantart fa-fw" class="fa-brands fa-deviantart fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-dev fa-fw" class="fa-brands fa-dev fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-deskpro fa-fw" class="fa-brands fa-deskpro fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-deploydog fa-fw" class="fa-brands fa-deploydog fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-delicious fa-fw" class="fa-brands fa-delicious fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-deezer fa-fw" class="fa-brands fa-deezer fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-debian fa-fw" class="fa-brands fa-debian fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-dart-lang fa-fw" class="fa-brands fa-dart-lang fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-dailymotion fa-fw" class="fa-brands fa-dailymotion fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-d-and-d-beyond fa-fw" class="fa-brands fa-d-and-d-beyond fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-d-and-d fa-fw" class="fa-brands fa-d-and-d fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-cuttlefish fa-fw" class="fa-brands fa-cuttlefish fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-css3-alt fa-fw" class="fa-brands fa-css3-alt fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-css3 fa-fw" class="fa-brands fa-css3 fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-css fa-fw" class="fa-brands fa-css fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-critical-role fa-fw" class="fa-brands fa-critical-role fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-creative-commons-zero fa-fw" class="fa-brands fa-creative-commons-zero fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-creative-commons-share fa-fw" class="fa-brands fa-creative-commons-share fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-creative-commons-sampling-plus fa-fw" class="fa-brands fa-creative-commons-sampling-plus fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-creative-commons-sampling fa-fw" class="fa-brands fa-creative-commons-sampling fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-creative-commons-sa fa-fw" class="fa-brands fa-creative-commons-sa fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-creative-commons-remix fa-fw" class="fa-brands fa-creative-commons-remix fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-creative-commons-pd-alt fa-fw" class="fa-brands fa-creative-commons-pd-alt fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-creative-commons-pd fa-fw" class="fa-brands fa-creative-commons-pd fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-creative-commons-nd fa-fw" class="fa-brands fa-creative-commons-nd fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-creative-commons-nc-jp fa-fw" class="fa-brands fa-creative-commons-nc-jp fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-creative-commons-nc-eu fa-fw" class="fa-brands fa-creative-commons-nc-eu fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-creative-commons-nc fa-fw" class="fa-brands fa-creative-commons-nc fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-creative-commons-by fa-fw" class="fa-brands fa-creative-commons-by fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-creative-commons fa-fw" class="fa-brands fa-creative-commons fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-cpanel fa-fw" class="fa-brands fa-cpanel fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-cotton-bureau fa-fw" class="fa-brands fa-cotton-bureau fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-contao fa-fw" class="fa-brands fa-contao fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-connectdevelop fa-fw" class="fa-brands fa-connectdevelop fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-confluence fa-fw" class="fa-brands fa-confluence fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-codiepie fa-fw" class="fa-brands fa-codiepie fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-cmplid fa-fw" class="fa-brands fa-cmplid fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-cloudversify fa-fw" class="fa-brands fa-cloudversify fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-cloudsmith fa-fw" class="fa-brands fa-cloudsmith fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-cloudscale fa-fw" class="fa-brands fa-cloudscale fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-chromecast fa-fw" class="fa-brands fa-chromecast fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-chrome fa-fw" class="fa-brands fa-chrome fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-centos fa-fw" class="fa-brands fa-centos fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-centercode fa-fw" class="fa-brands fa-centercode fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-cc-stripe fa-fw" class="fa-brands fa-cc-stripe fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-cc-paypal fa-fw" class="fa-brands fa-cc-paypal fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-cc-jcb fa-fw" class="fa-brands fa-cc-jcb fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-cc-discover fa-fw" class="fa-brands fa-cc-discover fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-cc-diners-club fa-fw" class="fa-brands fa-cc-diners-club fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-cc-apple-pay fa-fw" class="fa-brands fa-cc-apple-pay fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-cc-amex fa-fw" class="fa-brands fa-cc-amex fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-cc-amazon-pay fa-fw" class="fa-brands fa-cc-amazon-pay fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-canadian-maple-leaf fa-fw" class="fa-brands fa-canadian-maple-leaf fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-buysellads fa-fw" class="fa-brands fa-buysellads fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-buy-n-large fa-fw" class="fa-brands fa-buy-n-large fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-buromobelexperte fa-fw" class="fa-brands fa-buromobelexperte fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-buffer fa-fw" class="fa-brands fa-buffer fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-btc fa-fw" class="fa-brands fa-btc fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-brave-reverse fa-fw" class="fa-brands fa-brave-reverse fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-brave fa-fw" class="fa-brands fa-brave fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-bots fa-fw" class="fa-brands fa-bots fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-bootstrap fa-fw" class="fa-brands fa-bootstrap fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-bluetooth-b fa-fw" class="fa-brands fa-bluetooth-b fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-bluetooth fa-fw" class="fa-brands fa-bluetooth fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-bluesky fa-fw" class="fa-brands fa-bluesky fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-blogger-b fa-fw" class="fa-brands fa-blogger-b fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-blogger fa-fw" class="fa-brands fa-blogger fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-blackberry fa-fw" class="fa-brands fa-blackberry fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-black-tie fa-fw" class="fa-brands fa-black-tie fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-bity fa-fw" class="fa-brands fa-bity fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-bitcoin fa-fw" class="fa-brands fa-bitcoin fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-bitbucket fa-fw" class="fa-brands fa-bitbucket fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-bimobject fa-fw" class="fa-brands fa-bimobject fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-bilibili fa-fw" class="fa-brands fa-bilibili fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-battle-net fa-fw" class="fa-brands fa-battle-net fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-bandcamp fa-fw" class="fa-brands fa-bandcamp fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-aws fa-fw" class="fa-brands fa-aws fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-aviato fa-fw" class="fa-brands fa-aviato fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-avianex fa-fw" class="fa-brands fa-avianex fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-autoprefixer fa-fw" class="fa-brands fa-autoprefixer fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-audible fa-fw" class="fa-brands fa-audible fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-asymmetrik fa-fw" class="fa-brands fa-asymmetrik fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-artstation fa-fw" class="fa-brands fa-artstation fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-apple-pay fa-fw" class="fa-brands fa-apple-pay fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-apper fa-fw" class="fa-brands fa-apper fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-app-store-ios fa-fw" class="fa-brands fa-app-store-ios fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-app-store fa-fw" class="fa-brands fa-app-store fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-angular fa-fw" class="fa-brands fa-angular fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-angrycreative fa-fw" class="fa-brands fa-angrycreative fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-angellist fa-fw" class="fa-brands fa-angellist fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-amilia fa-fw" class="fa-brands fa-amilia fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-amazon-pay fa-fw" class="fa-brands fa-amazon-pay fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-alipay fa-fw" class="fa-brands fa-alipay fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-affiliatetheme fa-fw" class="fa-brands fa-affiliatetheme fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-adversal fa-fw" class="fa-brands fa-adversal fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-adn fa-fw" class="fa-brands fa-adn fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-accusoft fa-fw" class="fa-brands fa-accusoft fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-500px fa-fw" class="fa-brands fa-500px fa-fw"></i>
                                        <i data-type="iconpicker-item" title=".fa-brands fa-42-group fa-fw" class="fa-brands fa-42-group fa-fw"></i>
                                    </div> <!-- /.iconpicker-items -->
                                </div> <!-- /.iconpicker -->
                            </div> <!-- /.popover-content -->
                            <p class="url-input-wrap">
                                <input type="url" class="form-control" value="<?php echo esc_attr($social_urls[$key]) ?>" name="<?php echo esc_attr($this->get_field_name('social_urls')); ?>[]" placeholder="URL" value="">
                                <button type="button" class="remove-item">remove</button>
                            </p>
                        </div>
                    <?php
                    }
                } else {
                    ?>
                    <div class="iconpicker-popover popover bottomLeft iconpicker-visible">
                        <div class="arrow"></div>
                        <p class="popover-title">
                            <input type="search" class="form-control iconpicker-search" name="<?php echo esc_attr($this->get_field_name('social_icons')); ?>[]" placeholder="Type to filter">
                        </p>
                        <div class="popover-content" style="display: none;">
                            <div class="iconpicker">
                                <div class="iconpicker-items">
                                    <i data-type="iconpicker-item" title=".fa-brands fa-facebook fa-fw" class="fa-brands fa-facebook fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-twitter fa-fw" class="fa-brands fa-twitter fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-instagram fa-fw" class="fa-brands fa-instagram fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-tiktok fa-fw" class="fa-brands fa-tiktok fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-linkedin fa-fw" class="fa-brands fa-linkedin fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-github fa-fw" class="fa-brands fa-github fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-discord fa-fw" class="fa-brands fa-discord fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-youtube fa-fw" class="fa-brands fa-youtube fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-wordpress fa-fw" class="fa-brands fa-wordpress fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-slack fa-fw" class="fa-brands fa-slack fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-figma fa-fw" class="fa-brands fa-figma fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-apple fa-fw" class="fa-brands fa-apple fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-google fa-fw" class="fa-brands fa-google fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-stripe fa-fw" class="fa-brands fa-stripe fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-algolia fa-fw" class="fa-brands fa-algolia fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-docker fa-fw" class="fa-brands fa-docker fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-windows fa-fw" class="fa-brands fa-windows fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-paypal fa-fw" class="fa-brands fa-paypal fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-stack-overflow fa-fw" class="fa-brands fa-stack-overflow fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-kickstarter fa-fw" class="fa-brands fa-kickstarter fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-dribbble fa-fw" class="fa-brands fa-dribbble fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-dropbox fa-fw" class="fa-brands fa-dropbox fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-squarespace fa-fw" class="fa-brands fa-squarespace fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-android fa-fw" class="fa-brands fa-android fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-shopify fa-fw" class="fa-brands fa-shopify fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-medium fa-fw" class="fa-brands fa-medium fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-codepen fa-fw" class="fa-brands fa-codepen fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-cloudflare fa-fw" class="fa-brands fa-cloudflare fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-airbnb fa-fw" class="fa-brands fa-airbnb fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-vimeo fa-fw" class="fa-brands fa-vimeo fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-whatsapp fa-fw" class="fa-brands fa-whatsapp fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-intercom fa-fw" class="fa-brands fa-intercom fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-usps fa-fw" class="fa-brands fa-usps fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-wix fa-fw" class="fa-brands fa-wix fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-line fa-fw" class="fa-brands fa-line fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-behance fa-fw" class="fa-brands fa-behance fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-openid fa-fw" class="fa-brands fa-openid fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-product-hunt fa-fw" class="fa-brands fa-product-hunt fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-internet-explorer fa-fw" class="fa-brands fa-internet-explorer fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-pagelines fa-fw" class="fa-brands fa-pagelines fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-teamspeak fa-fw" class="fa-brands fa-teamspeak fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-html5 fa-fw" class="fa-brands fa-html5 fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-telegram fa-fw" class="fa-brands fa-telegram fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-pinterest fa-fw" class="fa-brands fa-pinterest fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-dashcube fa-fw" class="fa-brands fa-dashcube fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-ideal fa-fw" class="fa-brands fa-ideal fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-salesforce fa-fw" class="fa-brands fa-salesforce fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-readme fa-fw" class="fa-brands fa-readme fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-free-code-camp fa-fw" class="fa-brands fa-free-code-camp fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-soundcloud fa-fw" class="fa-brands fa-soundcloud fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-square-twitter fa-fw" class="fa-brands fa-square-twitter fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-accessible-icon fa-fw" class="fa-brands fa-accessible-icon fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-cc-visa fa-fw" class="fa-brands fa-cc-visa fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-goodreads-g fa-fw" class="fa-brands fa-goodreads-g fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-google-play fa-fw" class="fa-brands fa-google-play fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-react fa-fw" class="fa-brands fa-react fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-wikipedia-w fa-fw" class="fa-brands fa-wikipedia-w fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-square-js fa-fw" class="fa-brands fa-square-js fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-java fa-fw" class="fa-brands fa-java fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-square-pinterest fa-fw" class="fa-brands fa-square-pinterest fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-python fa-fw" class="fa-brands fa-python fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-skype fa-fw" class="fa-brands fa-skype fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-linux fa-fw" class="fa-brands fa-linux fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-node fa-fw" class="fa-brands fa-node fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-rebel fa-fw" class="fa-brands fa-rebel fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-etsy fa-fw" class="fa-brands fa-etsy fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-discourse fa-fw" class="fa-brands fa-discourse fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-amazon fa-fw" class="fa-brands fa-amazon fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-glide-g fa-fw" class="fa-brands fa-glide-g fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-gitlab fa-fw" class="fa-brands fa-gitlab fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-spotify fa-fw" class="fa-brands fa-spotify fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-think-peaks fa-fw" class="fa-brands fa-think-peaks fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-microsoft fa-fw" class="fa-brands fa-microsoft fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-elementor fa-fw" class="fa-brands fa-elementor fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-pied-piper fa-fw" class="fa-brands fa-pied-piper fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-square-youtube fa-fw" class="fa-brands fa-square-youtube fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-cc-mastercard fa-fw" class="fa-brands fa-cc-mastercard fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-facebook-messenger fa-fw" class="fa-brands fa-facebook-messenger fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-atlassian fa-fw" class="fa-brands fa-atlassian fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-playstation fa-fw" class="fa-brands fa-playstation fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-fly fa-fw" class="fa-brands fa-fly fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-meetup fa-fw" class="fa-brands fa-meetup fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-twitch fa-fw" class="fa-brands fa-twitch fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-waze fa-fw" class="fa-brands fa-waze fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-zhihu fa-fw" class="fa-brands fa-zhihu fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-yoast fa-fw" class="fa-brands fa-yoast fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-yelp fa-fw" class="fa-brands fa-yelp fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-yarn fa-fw" class="fa-brands fa-yarn fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-yandex-international fa-fw" class="fa-brands fa-yandex-international fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-yandex fa-fw" class="fa-brands fa-yandex fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-yammer fa-fw" class="fa-brands fa-yammer fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-yahoo fa-fw" class="fa-brands fa-yahoo fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-y-combinator fa-fw" class="fa-brands fa-y-combinator fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-xing fa-fw" class="fa-brands fa-xing fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-xbox fa-fw" class="fa-brands fa-xbox fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-x-twitter fa-fw" class="fa-brands fa-x-twitter fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-wpressr fa-fw" class="fa-brands fa-wpressr fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-wpforms fa-fw" class="fa-brands fa-wpforms fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-wpexplorer fa-fw" class="fa-brands fa-wpexplorer fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-wpbeginner fa-fw" class="fa-brands fa-wpbeginner fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-wordpress-simple fa-fw" class="fa-brands fa-wordpress-simple fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-wolf-pack-battalion fa-fw" class="fa-brands fa-wolf-pack-battalion fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-wodu fa-fw" class="fa-brands fa-wodu fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-wizards-of-the-coast fa-fw" class="fa-brands fa-wizards-of-the-coast fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-wirsindhandwerk fa-fw" class="fa-brands fa-wirsindhandwerk fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-whmcs fa-fw" class="fa-brands fa-whmcs fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-weixin fa-fw" class="fa-brands fa-weixin fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-weibo fa-fw" class="fa-brands fa-weibo fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-weebly fa-fw" class="fa-brands fa-weebly fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-webflow fa-fw" class="fa-brands fa-webflow fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-web-awesome fa-fw" class="fa-brands fa-web-awesome fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-watchman-monitoring fa-fw" class="fa-brands fa-watchman-monitoring fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-vuejs fa-fw" class="fa-brands fa-vuejs fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-vnv fa-fw" class="fa-brands fa-vnv fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-vk fa-fw" class="fa-brands fa-vk fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-vine fa-fw" class="fa-brands fa-vine fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-vimeo-v fa-fw" class="fa-brands fa-vimeo-v fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-viber fa-fw" class="fa-brands fa-viber fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-viadeo fa-fw" class="fa-brands fa-viadeo fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-viacoin fa-fw" class="fa-brands fa-viacoin fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-vaadin fa-fw" class="fa-brands fa-vaadin fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-ussunnah fa-fw" class="fa-brands fa-ussunnah fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-usb fa-fw" class="fa-brands fa-usb fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-upwork fa-fw" class="fa-brands fa-upwork fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-ups fa-fw" class="fa-brands fa-ups fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-untappd fa-fw" class="fa-brands fa-untappd fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-unsplash fa-fw" class="fa-brands fa-unsplash fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-unity fa-fw" class="fa-brands fa-unity fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-uniregistry fa-fw" class="fa-brands fa-uniregistry fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-uncharted fa-fw" class="fa-brands fa-uncharted fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-umbraco fa-fw" class="fa-brands fa-umbraco fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-uikit fa-fw" class="fa-brands fa-uikit fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-ubuntu fa-fw" class="fa-brands fa-ubuntu fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-uber fa-fw" class="fa-brands fa-uber fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-typo3 fa-fw" class="fa-brands fa-typo3 fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-tumblr fa-fw" class="fa-brands fa-tumblr fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-trello fa-fw" class="fa-brands fa-trello fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-trade-federation fa-fw" class="fa-brands fa-trade-federation fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-threads fa-fw" class="fa-brands fa-threads fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-themeisle fa-fw" class="fa-brands fa-themeisle fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-themeco fa-fw" class="fa-brands fa-themeco fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-the-red-yeti fa-fw" class="fa-brands fa-the-red-yeti fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-tencent-weibo fa-fw" class="fa-brands fa-tencent-weibo fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-symfony fa-fw" class="fa-brands fa-symfony fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-swift fa-fw" class="fa-brands fa-swift fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-suse fa-fw" class="fa-brands fa-suse fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-supple fa-fw" class="fa-brands fa-supple fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-superpowers fa-fw" class="fa-brands fa-superpowers fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-stumbleupon-circle fa-fw" class="fa-brands fa-stumbleupon-circle fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-stumbleupon fa-fw" class="fa-brands fa-stumbleupon fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-studiovinari fa-fw" class="fa-brands fa-studiovinari fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-stubber fa-fw" class="fa-brands fa-stubber fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-stripe-s fa-fw" class="fa-brands fa-stripe-s fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-strava fa-fw" class="fa-brands fa-strava fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-sticker-mule fa-fw" class="fa-brands fa-sticker-mule fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-steam-symbol fa-fw" class="fa-brands fa-steam-symbol fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-steam fa-fw" class="fa-brands fa-steam fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-staylinked fa-fw" class="fa-brands fa-staylinked fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-stackpath fa-fw" class="fa-brands fa-stackpath fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-stack-exchange fa-fw" class="fa-brands fa-stack-exchange fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-square-xing fa-fw" class="fa-brands fa-square-xing fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-square-x-twitter fa-fw" class="fa-brands fa-square-x-twitter fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-square-whatsapp fa-fw" class="fa-brands fa-square-whatsapp fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-square-web-awesome-stroke fa-fw" class="fa-brands fa-square-web-awesome-stroke fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-square-web-awesome fa-fw" class="fa-brands fa-square-web-awesome fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-square-vimeo fa-fw" class="fa-brands fa-square-vimeo fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-square-viadeo fa-fw" class="fa-brands fa-square-viadeo fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-square-upwork fa-fw" class="fa-brands fa-square-upwork fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-square-tumblr fa-fw" class="fa-brands fa-square-tumblr fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-square-threads fa-fw" class="fa-brands fa-square-threads fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-square-steam fa-fw" class="fa-brands fa-square-steam fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-square-snapchat fa-fw" class="fa-brands fa-square-snapchat fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-square-reddit fa-fw" class="fa-brands fa-square-reddit fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-square-pied-piper fa-fw" class="fa-brands fa-square-pied-piper fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-square-odnoklassniki fa-fw" class="fa-brands fa-square-odnoklassniki fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-square-letterboxd fa-fw" class="fa-brands fa-square-letterboxd fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-square-lastfm fa-fw" class="fa-brands fa-square-lastfm fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-square-instagram fa-fw" class="fa-brands fa-square-instagram fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-square-hacker-news fa-fw" class="fa-brands fa-square-hacker-news fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-square-google-plus fa-fw" class="fa-brands fa-square-google-plus fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-square-gitlab fa-fw" class="fa-brands fa-square-gitlab fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-square-github fa-fw" class="fa-brands fa-square-github fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-square-git fa-fw" class="fa-brands fa-square-git fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-square-font-awesome-stroke fa-fw" class="fa-brands fa-square-font-awesome-stroke fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-square-font-awesome fa-fw" class="fa-brands fa-square-font-awesome fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-square-facebook fa-fw" class="fa-brands fa-square-facebook fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-square-dribbble fa-fw" class="fa-brands fa-square-dribbble fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-square-bluesky fa-fw" class="fa-brands fa-square-bluesky fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-square-behance fa-fw" class="fa-brands fa-square-behance fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-speaker-deck fa-fw" class="fa-brands fa-speaker-deck fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-speakap fa-fw" class="fa-brands fa-speakap fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-space-awesome fa-fw" class="fa-brands fa-space-awesome fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-sourcetree fa-fw" class="fa-brands fa-sourcetree fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-snapchat fa-fw" class="fa-brands fa-snapchat fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-slideshare fa-fw" class="fa-brands fa-slideshare fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-skyatlas fa-fw" class="fa-brands fa-skyatlas fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-sketch fa-fw" class="fa-brands fa-sketch fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-sitrox fa-fw" class="fa-brands fa-sitrox fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-sith fa-fw" class="fa-brands fa-sith fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-sistrix fa-fw" class="fa-brands fa-sistrix fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-simplybuilt fa-fw" class="fa-brands fa-simplybuilt fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-signal-messenger fa-fw" class="fa-brands fa-signal-messenger fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-shopware fa-fw" class="fa-brands fa-shopware fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-shoelace fa-fw" class="fa-brands fa-shoelace fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-shirtsinbulk fa-fw" class="fa-brands fa-shirtsinbulk fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-servicestack fa-fw" class="fa-brands fa-servicestack fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-sellsy fa-fw" class="fa-brands fa-sellsy fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-sellcast fa-fw" class="fa-brands fa-sellcast fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-searchengin fa-fw" class="fa-brands fa-searchengin fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-scribd fa-fw" class="fa-brands fa-scribd fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-screenpal fa-fw" class="fa-brands fa-screenpal fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-schlix fa-fw" class="fa-brands fa-schlix fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-sass fa-fw" class="fa-brands fa-sass fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-safari fa-fw" class="fa-brands fa-safari fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-rust fa-fw" class="fa-brands fa-rust fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-rockrms fa-fw" class="fa-brands fa-rockrms fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-rocketchat fa-fw" class="fa-brands fa-rocketchat fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-rev fa-fw" class="fa-brands fa-rev fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-resolving fa-fw" class="fa-brands fa-resolving fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-researchgate fa-fw" class="fa-brands fa-researchgate fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-replyd fa-fw" class="fa-brands fa-replyd fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-renren fa-fw" class="fa-brands fa-renren fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-redhat fa-fw" class="fa-brands fa-redhat fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-reddit-alien fa-fw" class="fa-brands fa-reddit-alien fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-reddit fa-fw" class="fa-brands fa-reddit fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-red-river fa-fw" class="fa-brands fa-red-river fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-reacteurope fa-fw" class="fa-brands fa-reacteurope fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-ravelry fa-fw" class="fa-brands fa-ravelry fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-raspberry-pi fa-fw" class="fa-brands fa-raspberry-pi fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-r-project fa-fw" class="fa-brands fa-r-project fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-quora fa-fw" class="fa-brands fa-quora fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-quinscape fa-fw" class="fa-brands fa-quinscape fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-qq fa-fw" class="fa-brands fa-qq fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-pushed fa-fw" class="fa-brands fa-pushed fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-pixiv fa-fw" class="fa-brands fa-pixiv fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-pix fa-fw" class="fa-brands fa-pix fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-pinterest-p fa-fw" class="fa-brands fa-pinterest-p fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-pied-piper-pp fa-fw" class="fa-brands fa-pied-piper-pp fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-pied-piper-hat fa-fw" class="fa-brands fa-pied-piper-hat fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-pied-piper-alt fa-fw" class="fa-brands fa-pied-piper-alt fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-php fa-fw" class="fa-brands fa-php fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-phoenix-squadron fa-fw" class="fa-brands fa-phoenix-squadron fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-phoenix-framework fa-fw" class="fa-brands fa-phoenix-framework fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-phabricator fa-fw" class="fa-brands fa-phabricator fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-periscope fa-fw" class="fa-brands fa-periscope fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-perbyte fa-fw" class="fa-brands fa-perbyte fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-patreon fa-fw" class="fa-brands fa-patreon fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-palfed fa-fw" class="fa-brands fa-palfed fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-page4 fa-fw" class="fa-brands fa-page4 fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-padlet fa-fw" class="fa-brands fa-padlet fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-osi fa-fw" class="fa-brands fa-osi fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-orcid fa-fw" class="fa-brands fa-orcid fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-optin-monster fa-fw" class="fa-brands fa-optin-monster fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-opera fa-fw" class="fa-brands fa-opera fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-opensuse fa-fw" class="fa-brands fa-opensuse fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-opencart fa-fw" class="fa-brands fa-opencart fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-old-republic fa-fw" class="fa-brands fa-old-republic fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-odysee fa-fw" class="fa-brands fa-odysee fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-odnoklassniki fa-fw" class="fa-brands fa-odnoklassniki fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-octopus-deploy fa-fw" class="fa-brands fa-octopus-deploy fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-nutritionix fa-fw" class="fa-brands fa-nutritionix fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-ns8 fa-fw" class="fa-brands fa-ns8 fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-npm fa-fw" class="fa-brands fa-npm fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-node-js fa-fw" class="fa-brands fa-node-js fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-nimblr fa-fw" class="fa-brands fa-nimblr fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-nfc-symbol fa-fw" class="fa-brands fa-nfc-symbol fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-nfc-directional fa-fw" class="fa-brands fa-nfc-directional fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-neos fa-fw" class="fa-brands fa-neos fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-napster fa-fw" class="fa-brands fa-napster fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-monero fa-fw" class="fa-brands fa-monero fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-modx fa-fw" class="fa-brands fa-modx fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-mizuni fa-fw" class="fa-brands fa-mizuni fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-mixer fa-fw" class="fa-brands fa-mixer fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-mixcloud fa-fw" class="fa-brands fa-mixcloud fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-mix fa-fw" class="fa-brands fa-mix fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-mintbit fa-fw" class="fa-brands fa-mintbit fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-microblog fa-fw" class="fa-brands fa-microblog fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-meta fa-fw" class="fa-brands fa-meta fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-mendeley fa-fw" class="fa-brands fa-mendeley fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-megaport fa-fw" class="fa-brands fa-megaport fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-medrt fa-fw" class="fa-brands fa-medrt fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-medapps fa-fw" class="fa-brands fa-medapps fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-mdb fa-fw" class="fa-brands fa-mdb fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-maxcdn fa-fw" class="fa-brands fa-maxcdn fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-mastodon fa-fw" class="fa-brands fa-mastodon fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-markdown fa-fw" class="fa-brands fa-markdown fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-mandalorian fa-fw" class="fa-brands fa-mandalorian fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-mailchimp fa-fw" class="fa-brands fa-mailchimp fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-magento fa-fw" class="fa-brands fa-magento fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-lyft fa-fw" class="fa-brands fa-lyft fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-linode fa-fw" class="fa-brands fa-linode fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-linkedin-in fa-fw" class="fa-brands fa-linkedin-in fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-letterboxd fa-fw" class="fa-brands fa-letterboxd fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-less fa-fw" class="fa-brands fa-less fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-leanpub fa-fw" class="fa-brands fa-leanpub fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-lastfm fa-fw" class="fa-brands fa-lastfm fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-laravel fa-fw" class="fa-brands fa-laravel fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-korvue fa-fw" class="fa-brands fa-korvue fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-kickstarter-k fa-fw" class="fa-brands fa-kickstarter-k fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-keycdn fa-fw" class="fa-brands fa-keycdn fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-keybase fa-fw" class="fa-brands fa-keybase fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-kaggle fa-fw" class="fa-brands fa-kaggle fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-jxl fa-fw" class="fa-brands fa-jxl fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-jsfiddle fa-fw" class="fa-brands fa-jsfiddle fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-js fa-fw" class="fa-brands fa-js fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-joomla fa-fw" class="fa-brands fa-joomla fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-joget fa-fw" class="fa-brands fa-joget fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-jira fa-fw" class="fa-brands fa-jira fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-jenkins fa-fw" class="fa-brands fa-jenkins fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-jedi-order fa-fw" class="fa-brands fa-jedi-order fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-itunes-note fa-fw" class="fa-brands fa-itunes-note fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-itunes fa-fw" class="fa-brands fa-itunes fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-itch-io fa-fw" class="fa-brands fa-itch-io fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-ioxhost fa-fw" class="fa-brands fa-ioxhost fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-invision fa-fw" class="fa-brands fa-invision fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-instalod fa-fw" class="fa-brands fa-instalod fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-imdb fa-fw" class="fa-brands fa-imdb fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-hubspot fa-fw" class="fa-brands fa-hubspot fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-houzz fa-fw" class="fa-brands fa-houzz fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-hotjar fa-fw" class="fa-brands fa-hotjar fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-hornbill fa-fw" class="fa-brands fa-hornbill fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-hooli fa-fw" class="fa-brands fa-hooli fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-hive fa-fw" class="fa-brands fa-hive fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-hire-a-helper fa-fw" class="fa-brands fa-hire-a-helper fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-hips fa-fw" class="fa-brands fa-hips fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-hashnode fa-fw" class="fa-brands fa-hashnode fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-hackerrank fa-fw" class="fa-brands fa-hackerrank fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-hacker-news fa-fw" class="fa-brands fa-hacker-news fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-gulp fa-fw" class="fa-brands fa-gulp fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-guilded fa-fw" class="fa-brands fa-guilded fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-grunt fa-fw" class="fa-brands fa-grunt fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-gripfire fa-fw" class="fa-brands fa-gripfire fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-grav fa-fw" class="fa-brands fa-grav fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-gratipay fa-fw" class="fa-brands fa-gratipay fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-google-wallet fa-fw" class="fa-brands fa-google-wallet fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-google-scholar fa-fw" class="fa-brands fa-google-scholar fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-google-plus-g fa-fw" class="fa-brands fa-google-plus-g fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-google-plus fa-fw" class="fa-brands fa-google-plus fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-google-pay fa-fw" class="fa-brands fa-google-pay fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-google-drive fa-fw" class="fa-brands fa-google-drive fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-goodreads fa-fw" class="fa-brands fa-goodreads fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-golang fa-fw" class="fa-brands fa-golang fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-gofore fa-fw" class="fa-brands fa-gofore fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-glide fa-fw" class="fa-brands fa-glide fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-gitter fa-fw" class="fa-brands fa-gitter fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-gitkraken fa-fw" class="fa-brands fa-gitkraken fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-github-alt fa-fw" class="fa-brands fa-github-alt fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-git-alt fa-fw" class="fa-brands fa-git-alt fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-git fa-fw" class="fa-brands fa-git fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-gg-circle fa-fw" class="fa-brands fa-gg-circle fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-gg fa-fw" class="fa-brands fa-gg fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-get-pocket fa-fw" class="fa-brands fa-get-pocket fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-galactic-senate fa-fw" class="fa-brands fa-galactic-senate fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-galactic-republic fa-fw" class="fa-brands fa-galactic-republic fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-fulcrum fa-fw" class="fa-brands fa-fulcrum fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-freebsd fa-fw" class="fa-brands fa-freebsd fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-foursquare fa-fw" class="fa-brands fa-foursquare fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-forumbee fa-fw" class="fa-brands fa-forumbee fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-fort-awesome-alt fa-fw" class="fa-brands fa-fort-awesome-alt fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-fort-awesome fa-fw" class="fa-brands fa-fort-awesome fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-fonticons-fi fa-fw" class="fa-brands fa-fonticons-fi fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-fonticons fa-fw" class="fa-brands fa-fonticons fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-font-awesome fa-fw" class="fa-brands fa-font-awesome fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-flutter fa-fw" class="fa-brands fa-flutter fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-flipboard fa-fw" class="fa-brands fa-flipboard fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-flickr fa-fw" class="fa-brands fa-flickr fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-firstdraft fa-fw" class="fa-brands fa-firstdraft fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-first-order-alt fa-fw" class="fa-brands fa-first-order-alt fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-first-order fa-fw" class="fa-brands fa-first-order fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-firefox-browser fa-fw" class="fa-brands fa-firefox-browser fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-firefox fa-fw" class="fa-brands fa-firefox fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-files-pinwheel fa-fw" class="fa-brands fa-files-pinwheel fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-fedora fa-fw" class="fa-brands fa-fedora fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-fedex fa-fw" class="fa-brands fa-fedex fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-fantasy-flight-games fa-fw" class="fa-brands fa-fantasy-flight-games fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-facebook-f fa-fw" class="fa-brands fa-facebook-f fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-expeditedssl fa-fw" class="fa-brands fa-expeditedssl fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-evernote fa-fw" class="fa-brands fa-evernote fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-ethereum fa-fw" class="fa-brands fa-ethereum fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-erlang fa-fw" class="fa-brands fa-erlang fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-envira fa-fw" class="fa-brands fa-envira fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-empire fa-fw" class="fa-brands fa-empire fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-ember fa-fw" class="fa-brands fa-ember fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-ello fa-fw" class="fa-brands fa-ello fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-edge-legacy fa-fw" class="fa-brands fa-edge-legacy fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-edge fa-fw" class="fa-brands fa-edge fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-ebay fa-fw" class="fa-brands fa-ebay fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-earlybirds fa-fw" class="fa-brands fa-earlybirds fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-dyalog fa-fw" class="fa-brands fa-dyalog fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-drupal fa-fw" class="fa-brands fa-drupal fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-draft2digital fa-fw" class="fa-brands fa-draft2digital fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-dochub fa-fw" class="fa-brands fa-dochub fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-digital-ocean fa-fw" class="fa-brands fa-digital-ocean fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-digg fa-fw" class="fa-brands fa-digg fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-diaspora fa-fw" class="fa-brands fa-diaspora fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-dhl fa-fw" class="fa-brands fa-dhl fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-deviantart fa-fw" class="fa-brands fa-deviantart fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-dev fa-fw" class="fa-brands fa-dev fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-deskpro fa-fw" class="fa-brands fa-deskpro fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-deploydog fa-fw" class="fa-brands fa-deploydog fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-delicious fa-fw" class="fa-brands fa-delicious fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-deezer fa-fw" class="fa-brands fa-deezer fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-debian fa-fw" class="fa-brands fa-debian fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-dart-lang fa-fw" class="fa-brands fa-dart-lang fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-dailymotion fa-fw" class="fa-brands fa-dailymotion fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-d-and-d-beyond fa-fw" class="fa-brands fa-d-and-d-beyond fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-d-and-d fa-fw" class="fa-brands fa-d-and-d fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-cuttlefish fa-fw" class="fa-brands fa-cuttlefish fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-css3-alt fa-fw" class="fa-brands fa-css3-alt fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-css3 fa-fw" class="fa-brands fa-css3 fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-css fa-fw" class="fa-brands fa-css fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-critical-role fa-fw" class="fa-brands fa-critical-role fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-creative-commons-zero fa-fw" class="fa-brands fa-creative-commons-zero fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-creative-commons-share fa-fw" class="fa-brands fa-creative-commons-share fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-creative-commons-sampling-plus fa-fw" class="fa-brands fa-creative-commons-sampling-plus fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-creative-commons-sampling fa-fw" class="fa-brands fa-creative-commons-sampling fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-creative-commons-sa fa-fw" class="fa-brands fa-creative-commons-sa fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-creative-commons-remix fa-fw" class="fa-brands fa-creative-commons-remix fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-creative-commons-pd-alt fa-fw" class="fa-brands fa-creative-commons-pd-alt fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-creative-commons-pd fa-fw" class="fa-brands fa-creative-commons-pd fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-creative-commons-nd fa-fw" class="fa-brands fa-creative-commons-nd fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-creative-commons-nc-jp fa-fw" class="fa-brands fa-creative-commons-nc-jp fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-creative-commons-nc-eu fa-fw" class="fa-brands fa-creative-commons-nc-eu fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-creative-commons-nc fa-fw" class="fa-brands fa-creative-commons-nc fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-creative-commons-by fa-fw" class="fa-brands fa-creative-commons-by fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-creative-commons fa-fw" class="fa-brands fa-creative-commons fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-cpanel fa-fw" class="fa-brands fa-cpanel fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-cotton-bureau fa-fw" class="fa-brands fa-cotton-bureau fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-contao fa-fw" class="fa-brands fa-contao fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-connectdevelop fa-fw" class="fa-brands fa-connectdevelop fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-confluence fa-fw" class="fa-brands fa-confluence fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-codiepie fa-fw" class="fa-brands fa-codiepie fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-cmplid fa-fw" class="fa-brands fa-cmplid fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-cloudversify fa-fw" class="fa-brands fa-cloudversify fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-cloudsmith fa-fw" class="fa-brands fa-cloudsmith fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-cloudscale fa-fw" class="fa-brands fa-cloudscale fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-chromecast fa-fw" class="fa-brands fa-chromecast fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-chrome fa-fw" class="fa-brands fa-chrome fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-centos fa-fw" class="fa-brands fa-centos fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-centercode fa-fw" class="fa-brands fa-centercode fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-cc-stripe fa-fw" class="fa-brands fa-cc-stripe fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-cc-paypal fa-fw" class="fa-brands fa-cc-paypal fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-cc-jcb fa-fw" class="fa-brands fa-cc-jcb fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-cc-discover fa-fw" class="fa-brands fa-cc-discover fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-cc-diners-club fa-fw" class="fa-brands fa-cc-diners-club fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-cc-apple-pay fa-fw" class="fa-brands fa-cc-apple-pay fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-cc-amex fa-fw" class="fa-brands fa-cc-amex fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-cc-amazon-pay fa-fw" class="fa-brands fa-cc-amazon-pay fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-canadian-maple-leaf fa-fw" class="fa-brands fa-canadian-maple-leaf fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-buysellads fa-fw" class="fa-brands fa-buysellads fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-buy-n-large fa-fw" class="fa-brands fa-buy-n-large fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-buromobelexperte fa-fw" class="fa-brands fa-buromobelexperte fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-buffer fa-fw" class="fa-brands fa-buffer fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-btc fa-fw" class="fa-brands fa-btc fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-brave-reverse fa-fw" class="fa-brands fa-brave-reverse fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-brave fa-fw" class="fa-brands fa-brave fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-bots fa-fw" class="fa-brands fa-bots fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-bootstrap fa-fw" class="fa-brands fa-bootstrap fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-bluetooth-b fa-fw" class="fa-brands fa-bluetooth-b fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-bluetooth fa-fw" class="fa-brands fa-bluetooth fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-bluesky fa-fw" class="fa-brands fa-bluesky fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-blogger-b fa-fw" class="fa-brands fa-blogger-b fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-blogger fa-fw" class="fa-brands fa-blogger fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-blackberry fa-fw" class="fa-brands fa-blackberry fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-black-tie fa-fw" class="fa-brands fa-black-tie fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-bity fa-fw" class="fa-brands fa-bity fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-bitcoin fa-fw" class="fa-brands fa-bitcoin fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-bitbucket fa-fw" class="fa-brands fa-bitbucket fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-bimobject fa-fw" class="fa-brands fa-bimobject fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-bilibili fa-fw" class="fa-brands fa-bilibili fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-battle-net fa-fw" class="fa-brands fa-battle-net fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-bandcamp fa-fw" class="fa-brands fa-bandcamp fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-aws fa-fw" class="fa-brands fa-aws fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-aviato fa-fw" class="fa-brands fa-aviato fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-avianex fa-fw" class="fa-brands fa-avianex fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-autoprefixer fa-fw" class="fa-brands fa-autoprefixer fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-audible fa-fw" class="fa-brands fa-audible fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-asymmetrik fa-fw" class="fa-brands fa-asymmetrik fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-artstation fa-fw" class="fa-brands fa-artstation fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-apple-pay fa-fw" class="fa-brands fa-apple-pay fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-apper fa-fw" class="fa-brands fa-apper fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-app-store-ios fa-fw" class="fa-brands fa-app-store-ios fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-app-store fa-fw" class="fa-brands fa-app-store fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-angular fa-fw" class="fa-brands fa-angular fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-angrycreative fa-fw" class="fa-brands fa-angrycreative fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-angellist fa-fw" class="fa-brands fa-angellist fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-amilia fa-fw" class="fa-brands fa-amilia fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-amazon-pay fa-fw" class="fa-brands fa-amazon-pay fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-alipay fa-fw" class="fa-brands fa-alipay fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-affiliatetheme fa-fw" class="fa-brands fa-affiliatetheme fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-adversal fa-fw" class="fa-brands fa-adversal fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-adn fa-fw" class="fa-brands fa-adn fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-accusoft fa-fw" class="fa-brands fa-accusoft fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-500px fa-fw" class="fa-brands fa-500px fa-fw"></i>
                                    <i data-type="iconpicker-item" title=".fa-brands fa-42-group fa-fw" class="fa-brands fa-42-group fa-fw"></i>
                                </div> <!-- /.iconpicker-items -->
                            </div> <!-- /.iconpicker -->
                        </div> <!-- /.popover-content -->
                        <p class="url-input-wrap">
                            <input type="url" class="form-control" name="<?php echo esc_attr($this->get_field_name('social_urls')); ?>[]" placeholder="URL" value="">
                            <button type="button" class="remove-item">remove</button>
                        </p>
                    </div>
                <?php
                }

                ?>
            </div>
            <button type="button" class="button button-secondary btn-add-social">
                <?php esc_html_e('Add Social', 'nebon'); ?>
            </button>
<?php
        }
    }

    // tech888f_SocialIconsWidget::_init();
    // register_widget('tech888f_SocialIconsWidget');
    add_action('widgets_init', function () {
        if (function_exists('tech888f_reg_widget'))
            tech888f_reg_widget('tech888f_SocialIconsWidget');
    });
}
?>