<?php
if (!class_exists('tech888f_SocialIconsWidget2')) {
    class tech888f_SocialIconsWidget2 extends WP_Widget
    {

        protected $default = array();
        protected $widget_name = 'social-icons2';
        protected $version = '1.0.0';
        protected $registered = false;

        function __construct()
        {
            parent::__construct(
                'tech888f_social_icons_widget2',
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
            // wp_enqueue_style('font-awesome-widget', get_template_directory_uri() . '/customizer-repeater/css/font-awesome.min.css', array(), $this->version, 'all');
            wp_enqueue_style('line-awesome-widget', get_template_directory_uri() . '/customizer-repeater/css/line-awesome.min.css', array(), $this->version, 'all');
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
                                        <i data-type="iconpicker-item" title=".las la-facebook " class="las la-facebook "></i>
                                        <i data-type="iconpicker-item" title=".las la-twitter " class="las la-twitter "></i>
                                        <i data-type="iconpicker-item" title=".las la-instagram " class="las la-instagram "></i>
                                        <i data-type="iconpicker-item" title=".las la-tiktok " class="las la-tiktok "></i>
                                        <i data-type="iconpicker-item" title=".las la-linkedin " class="las la-linkedin "></i>
                                        <i data-type="iconpicker-item" title=".las la-github " class="las la-github "></i>
                                        <i data-type="iconpicker-item" title=".las la-discord " class="las la-discord "></i>
                                        <i data-type="iconpicker-item" title=".las la-youtube " class="las la-youtube "></i>
                                        <i data-type="iconpicker-item" title=".las la-wordpress " class="las la-wordpress "></i>
                                        <i data-type="iconpicker-item" title=".las la-slack " class="las la-slack "></i>
                                        <i data-type="iconpicker-item" title=".las la-figma " class="las la-figma "></i>
                                        <i data-type="iconpicker-item" title=".las la-apple " class="las la-apple "></i>
                                        <i data-type="iconpicker-item" title=".las la-google " class="las la-google "></i>
                                        <i data-type="iconpicker-item" title=".las la-stripe " class="las la-stripe "></i>
                                        <i data-type="iconpicker-item" title=".las la-algolia " class="las la-algolia "></i>
                                        <i data-type="iconpicker-item" title=".las la-docker " class="las la-docker "></i>
                                        <i data-type="iconpicker-item" title=".las la-windows " class="las la-windows "></i>
                                        <i data-type="iconpicker-item" title=".las la-paypal " class="las la-paypal "></i>
                                        <i data-type="iconpicker-item" title=".las la-stack-overflow " class="las la-stack-overflow "></i>
                                        <i data-type="iconpicker-item" title=".las la-kickstarter " class="las la-kickstarter "></i>
                                        <i data-type="iconpicker-item" title=".las la-dribbble " class="las la-dribbble "></i>
                                        <i data-type="iconpicker-item" title=".las la-dropbox " class="las la-dropbox "></i>
                                        <i data-type="iconpicker-item" title=".las la-squarespace " class="las la-squarespace "></i>
                                        <i data-type="iconpicker-item" title=".las la-android " class="las la-android "></i>
                                        <i data-type="iconpicker-item" title=".las la-shopify " class="las la-shopify "></i>
                                        <i data-type="iconpicker-item" title=".las la-medium " class="las la-medium "></i>
                                        <i data-type="iconpicker-item" title=".las la-codepen " class="las la-codepen "></i>
                                        <i data-type="iconpicker-item" title=".las la-cloudflare " class="las la-cloudflare "></i>
                                        <i data-type="iconpicker-item" title=".las la-airbnb " class="las la-airbnb "></i>
                                        <i data-type="iconpicker-item" title=".las la-vimeo " class="las la-vimeo "></i>
                                        <i data-type="iconpicker-item" title=".las la-whatsapp " class="las la-whatsapp "></i>
                                        <i data-type="iconpicker-item" title=".las la-intercom " class="las la-intercom "></i>
                                        <i data-type="iconpicker-item" title=".las la-usps " class="las la-usps "></i>
                                        <i data-type="iconpicker-item" title=".las la-wix " class="las la-wix "></i>
                                        <i data-type="iconpicker-item" title=".las la-line " class="las la-line "></i>
                                        <i data-type="iconpicker-item" title=".las la-behance " class="las la-behance "></i>
                                        <i data-type="iconpicker-item" title=".las la-openid " class="las la-openid "></i>
                                        <i data-type="iconpicker-item" title=".las la-product-hunt " class="las la-product-hunt "></i>
                                        <i data-type="iconpicker-item" title=".las la-internet-explorer " class="las la-internet-explorer "></i>
                                        <i data-type="iconpicker-item" title=".las la-pagelines " class="las la-pagelines "></i>
                                        <i data-type="iconpicker-item" title=".las la-teamspeak " class="las la-teamspeak "></i>
                                        <i data-type="iconpicker-item" title=".las la-html5 " class="las la-html5 "></i>
                                        <i data-type="iconpicker-item" title=".las la-telegram " class="las la-telegram "></i>
                                        <i data-type="iconpicker-item" title=".las la-pinterest " class="las la-pinterest "></i>
                                        <i data-type="iconpicker-item" title=".las la-dashcube " class="las la-dashcube "></i>
                                        <i data-type="iconpicker-item" title=".las la-ideal " class="las la-ideal "></i>
                                        <i data-type="iconpicker-item" title=".las la-salesforce " class="las la-salesforce "></i>
                                        <i data-type="iconpicker-item" title=".las la-readme " class="las la-readme "></i>
                                        <i data-type="iconpicker-item" title=".las la-free-code-camp " class="las la-free-code-camp "></i>
                                        <i data-type="iconpicker-item" title=".las la-soundcloud " class="las la-soundcloud "></i>
                                        <i data-type="iconpicker-item" title=".las la-square-twitter " class="las la-square-twitter "></i>
                                        <i data-type="iconpicker-item" title=".las la-accessible-icon " class="las la-accessible-icon "></i>
                                        <i data-type="iconpicker-item" title=".las la-cc-visa " class="las la-cc-visa "></i>
                                        <i data-type="iconpicker-item" title=".las la-goodreads-g " class="las la-goodreads-g "></i>
                                        <i data-type="iconpicker-item" title=".las la-google-play " class="las la-google-play "></i>
                                        <i data-type="iconpicker-item" title=".las la-react " class="las la-react "></i>
                                        <i data-type="iconpicker-item" title=".las la-wikipedia-w " class="las la-wikipedia-w "></i>
                                        <i data-type="iconpicker-item" title=".las la-square-js " class="las la-square-js "></i>
                                        <i data-type="iconpicker-item" title=".las la-java " class="las la-java "></i>
                                        <i data-type="iconpicker-item" title=".las la-square-pinterest " class="las la-square-pinterest "></i>
                                        <i data-type="iconpicker-item" title=".las la-python " class="las la-python "></i>
                                        <i data-type="iconpicker-item" title=".las la-skype " class="las la-skype "></i>
                                        <i data-type="iconpicker-item" title=".las la-linux " class="las la-linux "></i>
                                        <i data-type="iconpicker-item" title=".las la-node " class="las la-node "></i>
                                        <i data-type="iconpicker-item" title=".las la-rebel " class="las la-rebel "></i>
                                        <i data-type="iconpicker-item" title=".las la-etsy " class="las la-etsy "></i>
                                        <i data-type="iconpicker-item" title=".las la-discourse " class="las la-discourse "></i>
                                        <i data-type="iconpicker-item" title=".las la-amazon " class="las la-amazon "></i>
                                        <i data-type="iconpicker-item" title=".las la-glide-g " class="las la-glide-g "></i>
                                        <i data-type="iconpicker-item" title=".las la-gitlab " class="las la-gitlab "></i>
                                        <i data-type="iconpicker-item" title=".las la-spotify " class="las la-spotify "></i>
                                        <i data-type="iconpicker-item" title=".las la-think-peaks " class="las la-think-peaks "></i>
                                        <i data-type="iconpicker-item" title=".las la-microsoft " class="las la-microsoft "></i>
                                        <i data-type="iconpicker-item" title=".las la-elementor " class="las la-elementor "></i>
                                        <i data-type="iconpicker-item" title=".las la-pied-piper " class="las la-pied-piper "></i>
                                        <i data-type="iconpicker-item" title=".las la-square-youtube " class="las la-square-youtube "></i>
                                        <i data-type="iconpicker-item" title=".las la-cc-mastercard " class="las la-cc-mastercard "></i>
                                        <i data-type="iconpicker-item" title=".las la-facebook-messenger " class="las la-facebook-messenger "></i>
                                        <i data-type="iconpicker-item" title=".las la-atlassian " class="las la-atlassian "></i>
                                        <i data-type="iconpicker-item" title=".las la-playstation " class="las la-playstation "></i>
                                        <i data-type="iconpicker-item" title=".las la-fly " class="las la-fly "></i>
                                        <i data-type="iconpicker-item" title=".las la-meetup " class="las la-meetup "></i>
                                        <i data-type="iconpicker-item" title=".las la-twitch " class="las la-twitch "></i>
                                        <i data-type="iconpicker-item" title=".las la-waze " class="las la-waze "></i>
                                        <i data-type="iconpicker-item" title=".las la-zhihu " class="las la-zhihu "></i>
                                        <i data-type="iconpicker-item" title=".las la-yoast " class="las la-yoast "></i>
                                        <i data-type="iconpicker-item" title=".las la-yelp " class="las la-yelp "></i>
                                        <i data-type="iconpicker-item" title=".las la-yarn " class="las la-yarn "></i>
                                        <i data-type="iconpicker-item" title=".las la-yandex-international " class="las la-yandex-international "></i>
                                        <i data-type="iconpicker-item" title=".las la-yandex " class="las la-yandex "></i>
                                        <i data-type="iconpicker-item" title=".las la-yammer " class="las la-yammer "></i>
                                        <i data-type="iconpicker-item" title=".las la-yahoo " class="las la-yahoo "></i>
                                        <i data-type="iconpicker-item" title=".las la-y-combinator " class="las la-y-combinator "></i>
                                        <i data-type="iconpicker-item" title=".las la-xing " class="las la-xing "></i>
                                        <i data-type="iconpicker-item" title=".las la-xbox " class="las la-xbox "></i>
                                        <i data-type="iconpicker-item" title=".las la-x-twitter " class="las la-x-twitter "></i>
                                        <i data-type="iconpicker-item" title=".las la-wpressr " class="las la-wpressr "></i>
                                        <i data-type="iconpicker-item" title=".las la-wpforms " class="las la-wpforms "></i>
                                        <i data-type="iconpicker-item" title=".las la-wpexplorer " class="las la-wpexplorer "></i>
                                        <i data-type="iconpicker-item" title=".las la-wpbeginner " class="las la-wpbeginner "></i>
                                        <i data-type="iconpicker-item" title=".las la-wordpress-simple " class="las la-wordpress-simple "></i>
                                        <i data-type="iconpicker-item" title=".las la-wolf-pack-battalion " class="las la-wolf-pack-battalion "></i>
                                        <i data-type="iconpicker-item" title=".las la-wodu " class="las la-wodu "></i>
                                        <i data-type="iconpicker-item" title=".las la-wizards-of-the-coast " class="las la-wizards-of-the-coast "></i>
                                        <i data-type="iconpicker-item" title=".las la-wirsindhandwerk " class="las la-wirsindhandwerk "></i>
                                        <i data-type="iconpicker-item" title=".las la-whmcs " class="las la-whmcs "></i>
                                        <i data-type="iconpicker-item" title=".las la-weixin " class="las la-weixin "></i>
                                        <i data-type="iconpicker-item" title=".las la-weibo " class="las la-weibo "></i>
                                        <i data-type="iconpicker-item" title=".las la-weebly " class="las la-weebly "></i>
                                        <i data-type="iconpicker-item" title=".las la-webflow " class="las la-webflow "></i>
                                        <i data-type="iconpicker-item" title=".las la-web-awesome " class="las la-web-awesome "></i>
                                        <i data-type="iconpicker-item" title=".las la-watchman-monitoring " class="las la-watchman-monitoring "></i>
                                        <i data-type="iconpicker-item" title=".las la-vuejs " class="las la-vuejs "></i>
                                        <i data-type="iconpicker-item" title=".las la-vnv " class="las la-vnv "></i>
                                        <i data-type="iconpicker-item" title=".las la-vk " class="las la-vk "></i>
                                        <i data-type="iconpicker-item" title=".las la-vine " class="las la-vine "></i>
                                        <i data-type="iconpicker-item" title=".las la-vimeo-v " class="las la-vimeo-v "></i>
                                        <i data-type="iconpicker-item" title=".las la-viber " class="las la-viber "></i>
                                        <i data-type="iconpicker-item" title=".las la-viadeo " class="las la-viadeo "></i>
                                        <i data-type="iconpicker-item" title=".las la-viacoin " class="las la-viacoin "></i>
                                        <i data-type="iconpicker-item" title=".las la-vaadin " class="las la-vaadin "></i>
                                        <i data-type="iconpicker-item" title=".las la-ussunnah " class="las la-ussunnah "></i>
                                        <i data-type="iconpicker-item" title=".las la-usb " class="las la-usb "></i>
                                        <i data-type="iconpicker-item" title=".las la-upwork " class="las la-upwork "></i>
                                        <i data-type="iconpicker-item" title=".las la-ups " class="las la-ups "></i>
                                        <i data-type="iconpicker-item" title=".las la-untappd " class="las la-untappd "></i>
                                        <i data-type="iconpicker-item" title=".las la-unsplash " class="las la-unsplash "></i>
                                        <i data-type="iconpicker-item" title=".las la-unity " class="las la-unity "></i>
                                        <i data-type="iconpicker-item" title=".las la-uniregistry " class="las la-uniregistry "></i>
                                        <i data-type="iconpicker-item" title=".las la-uncharted " class="las la-uncharted "></i>
                                        <i data-type="iconpicker-item" title=".las la-umbraco " class="las la-umbraco "></i>
                                        <i data-type="iconpicker-item" title=".las la-uikit " class="las la-uikit "></i>
                                        <i data-type="iconpicker-item" title=".las la-ubuntu " class="las la-ubuntu "></i>
                                        <i data-type="iconpicker-item" title=".las la-uber " class="las la-uber "></i>
                                        <i data-type="iconpicker-item" title=".las la-typo3 " class="las la-typo3 "></i>
                                        <i data-type="iconpicker-item" title=".las la-tumblr " class="las la-tumblr "></i>
                                        <i data-type="iconpicker-item" title=".las la-trello " class="las la-trello "></i>
                                        <i data-type="iconpicker-item" title=".las la-trade-federation " class="las la-trade-federation "></i>
                                        <i data-type="iconpicker-item" title=".las la-threads " class="las la-threads "></i>
                                        <i data-type="iconpicker-item" title=".las la-themeisle " class="las la-themeisle "></i>
                                        <i data-type="iconpicker-item" title=".las la-themeco " class="las la-themeco "></i>
                                        <i data-type="iconpicker-item" title=".las la-the-red-yeti " class="las la-the-red-yeti "></i>
                                        <i data-type="iconpicker-item" title=".las la-tencent-weibo " class="las la-tencent-weibo "></i>
                                        <i data-type="iconpicker-item" title=".las la-symfony " class="las la-symfony "></i>
                                        <i data-type="iconpicker-item" title=".las la-swift " class="las la-swift "></i>
                                        <i data-type="iconpicker-item" title=".las la-suse " class="las la-suse "></i>
                                        <i data-type="iconpicker-item" title=".las la-supple " class="las la-supple "></i>
                                        <i data-type="iconpicker-item" title=".las la-superpowers " class="las la-superpowers "></i>
                                        <i data-type="iconpicker-item" title=".las la-stumbleupon-circle " class="las la-stumbleupon-circle "></i>
                                        <i data-type="iconpicker-item" title=".las la-stumbleupon " class="las la-stumbleupon "></i>
                                        <i data-type="iconpicker-item" title=".las la-studiovinari " class="las la-studiovinari "></i>
                                        <i data-type="iconpicker-item" title=".las la-stubber " class="las la-stubber "></i>
                                        <i data-type="iconpicker-item" title=".las la-stripe-s " class="las la-stripe-s "></i>
                                        <i data-type="iconpicker-item" title=".las la-strava " class="las la-strava "></i>
                                        <i data-type="iconpicker-item" title=".las la-sticker-mule " class="las la-sticker-mule "></i>
                                        <i data-type="iconpicker-item" title=".las la-steam-symbol " class="las la-steam-symbol "></i>
                                        <i data-type="iconpicker-item" title=".las la-steam " class="las la-steam "></i>
                                        <i data-type="iconpicker-item" title=".las la-staylinked " class="las la-staylinked "></i>
                                        <i data-type="iconpicker-item" title=".las la-stackpath " class="las la-stackpath "></i>
                                        <i data-type="iconpicker-item" title=".las la-stack-exchange " class="las la-stack-exchange "></i>
                                        <i data-type="iconpicker-item" title=".las la-square-xing " class="las la-square-xing "></i>
                                        <i data-type="iconpicker-item" title=".las la-square-x-twitter " class="las la-square-x-twitter "></i>
                                        <i data-type="iconpicker-item" title=".las la-square-whatsapp " class="las la-square-whatsapp "></i>
                                        <i data-type="iconpicker-item" title=".las la-square-web-awesome-stroke " class="las la-square-web-awesome-stroke "></i>
                                        <i data-type="iconpicker-item" title=".las la-square-web-awesome " class="las la-square-web-awesome "></i>
                                        <i data-type="iconpicker-item" title=".las la-square-vimeo " class="las la-square-vimeo "></i>
                                        <i data-type="iconpicker-item" title=".las la-square-viadeo " class="las la-square-viadeo "></i>
                                        <i data-type="iconpicker-item" title=".las la-square-upwork " class="las la-square-upwork "></i>
                                        <i data-type="iconpicker-item" title=".las la-square-tumblr " class="las la-square-tumblr "></i>
                                        <i data-type="iconpicker-item" title=".las la-square-threads " class="las la-square-threads "></i>
                                        <i data-type="iconpicker-item" title=".las la-square-steam " class="las la-square-steam "></i>
                                        <i data-type="iconpicker-item" title=".las la-square-snapchat " class="las la-square-snapchat "></i>
                                        <i data-type="iconpicker-item" title=".las la-square-reddit " class="las la-square-reddit "></i>
                                        <i data-type="iconpicker-item" title=".las la-square-pied-piper " class="las la-square-pied-piper "></i>
                                        <i data-type="iconpicker-item" title=".las la-square-odnoklassniki " class="las la-square-odnoklassniki "></i>
                                        <i data-type="iconpicker-item" title=".las la-square-letterboxd " class="las la-square-letterboxd "></i>
                                        <i data-type="iconpicker-item" title=".las la-square-lastfm " class="las la-square-lastfm "></i>
                                        <i data-type="iconpicker-item" title=".las la-square-instagram " class="las la-square-instagram "></i>
                                        <i data-type="iconpicker-item" title=".las la-square-hacker-news " class="las la-square-hacker-news "></i>
                                        <i data-type="iconpicker-item" title=".las la-square-google-plus " class="las la-square-google-plus "></i>
                                        <i data-type="iconpicker-item" title=".las la-square-gitlab " class="las la-square-gitlab "></i>
                                        <i data-type="iconpicker-item" title=".las la-square-github " class="las la-square-github "></i>
                                        <i data-type="iconpicker-item" title=".las la-square-git " class="las la-square-git "></i>
                                        <i data-type="iconpicker-item" title=".las la-square-font-awesome-stroke " class="las la-square-font-awesome-stroke "></i>
                                        <i data-type="iconpicker-item" title=".las la-square-font-awesome " class="las la-square-font-awesome "></i>
                                        <i data-type="iconpicker-item" title=".las la-square-facebook " class="las la-square-facebook "></i>
                                        <i data-type="iconpicker-item" title=".las la-square-dribbble " class="las la-square-dribbble "></i>
                                        <i data-type="iconpicker-item" title=".las la-square-bluesky " class="las la-square-bluesky "></i>
                                        <i data-type="iconpicker-item" title=".las la-square-behance " class="las la-square-behance "></i>
                                        <i data-type="iconpicker-item" title=".las la-speaker-deck " class="las la-speaker-deck "></i>
                                        <i data-type="iconpicker-item" title=".las la-speakap " class="las la-speakap "></i>
                                        <i data-type="iconpicker-item" title=".las la-space-awesome " class="las la-space-awesome "></i>
                                        <i data-type="iconpicker-item" title=".las la-sourcetree " class="las la-sourcetree "></i>
                                        <i data-type="iconpicker-item" title=".las la-snapchat " class="las la-snapchat "></i>
                                        <i data-type="iconpicker-item" title=".las la-slideshare " class="las la-slideshare "></i>
                                        <i data-type="iconpicker-item" title=".las la-skyatlas " class="las la-skyatlas "></i>
                                        <i data-type="iconpicker-item" title=".las la-sketch " class="las la-sketch "></i>
                                        <i data-type="iconpicker-item" title=".las la-sitrox " class="las la-sitrox "></i>
                                        <i data-type="iconpicker-item" title=".las la-sith " class="las la-sith "></i>
                                        <i data-type="iconpicker-item" title=".las la-sistrix " class="las la-sistrix "></i>
                                        <i data-type="iconpicker-item" title=".las la-simplybuilt " class="las la-simplybuilt "></i>
                                        <i data-type="iconpicker-item" title=".las la-signal-messenger " class="las la-signal-messenger "></i>
                                        <i data-type="iconpicker-item" title=".las la-shopware " class="las la-shopware "></i>
                                        <i data-type="iconpicker-item" title=".las la-shoelace " class="las la-shoelace "></i>
                                        <i data-type="iconpicker-item" title=".las la-shirtsinbulk " class="las la-shirtsinbulk "></i>
                                        <i data-type="iconpicker-item" title=".las la-servicestack " class="las la-servicestack "></i>
                                        <i data-type="iconpicker-item" title=".las la-sellsy " class="las la-sellsy "></i>
                                        <i data-type="iconpicker-item" title=".las la-sellcast " class="las la-sellcast "></i>
                                        <i data-type="iconpicker-item" title=".las la-searchengin " class="las la-searchengin "></i>
                                        <i data-type="iconpicker-item" title=".las la-scribd " class="las la-scribd "></i>
                                        <i data-type="iconpicker-item" title=".las la-screenpal " class="las la-screenpal "></i>
                                        <i data-type="iconpicker-item" title=".las la-schlix " class="las la-schlix "></i>
                                        <i data-type="iconpicker-item" title=".las la-sass " class="las la-sass "></i>
                                        <i data-type="iconpicker-item" title=".las la-safari " class="las la-safari "></i>
                                        <i data-type="iconpicker-item" title=".las la-rust " class="las la-rust "></i>
                                        <i data-type="iconpicker-item" title=".las la-rockrms " class="las la-rockrms "></i>
                                        <i data-type="iconpicker-item" title=".las la-rocketchat " class="las la-rocketchat "></i>
                                        <i data-type="iconpicker-item" title=".las la-rev " class="las la-rev "></i>
                                        <i data-type="iconpicker-item" title=".las la-resolving " class="las la-resolving "></i>
                                        <i data-type="iconpicker-item" title=".las la-researchgate " class="las la-researchgate "></i>
                                        <i data-type="iconpicker-item" title=".las la-replyd " class="las la-replyd "></i>
                                        <i data-type="iconpicker-item" title=".las la-renren " class="las la-renren "></i>
                                        <i data-type="iconpicker-item" title=".las la-redhat " class="las la-redhat "></i>
                                        <i data-type="iconpicker-item" title=".las la-reddit-alien " class="las la-reddit-alien "></i>
                                        <i data-type="iconpicker-item" title=".las la-reddit " class="las la-reddit "></i>
                                        <i data-type="iconpicker-item" title=".las la-red-river " class="las la-red-river "></i>
                                        <i data-type="iconpicker-item" title=".las la-reacteurope " class="las la-reacteurope "></i>
                                        <i data-type="iconpicker-item" title=".las la-ravelry " class="las la-ravelry "></i>
                                        <i data-type="iconpicker-item" title=".las la-raspberry-pi " class="las la-raspberry-pi "></i>
                                        <i data-type="iconpicker-item" title=".las la-r-project " class="las la-r-project "></i>
                                        <i data-type="iconpicker-item" title=".las la-quora " class="las la-quora "></i>
                                        <i data-type="iconpicker-item" title=".las la-quinscape " class="las la-quinscape "></i>
                                        <i data-type="iconpicker-item" title=".las la-qq " class="las la-qq "></i>
                                        <i data-type="iconpicker-item" title=".las la-pushed " class="las la-pushed "></i>
                                        <i data-type="iconpicker-item" title=".las la-pixiv " class="las la-pixiv "></i>
                                        <i data-type="iconpicker-item" title=".las la-pix " class="las la-pix "></i>
                                        <i data-type="iconpicker-item" title=".las la-pinterest-p " class="las la-pinterest-p "></i>
                                        <i data-type="iconpicker-item" title=".las la-pied-piper-pp " class="las la-pied-piper-pp "></i>
                                        <i data-type="iconpicker-item" title=".las la-pied-piper-hat " class="las la-pied-piper-hat "></i>
                                        <i data-type="iconpicker-item" title=".las la-pied-piper-alt " class="las la-pied-piper-alt "></i>
                                        <i data-type="iconpicker-item" title=".las la-php " class="las la-php "></i>
                                        <i data-type="iconpicker-item" title=".las la-phoenix-squadron " class="las la-phoenix-squadron "></i>
                                        <i data-type="iconpicker-item" title=".las la-phoenix-framework " class="las la-phoenix-framework "></i>
                                        <i data-type="iconpicker-item" title=".las la-phabricator " class="las la-phabricator "></i>
                                        <i data-type="iconpicker-item" title=".las la-periscope " class="las la-periscope "></i>
                                        <i data-type="iconpicker-item" title=".las la-perbyte " class="las la-perbyte "></i>
                                        <i data-type="iconpicker-item" title=".las la-patreon " class="las la-patreon "></i>
                                        <i data-type="iconpicker-item" title=".las la-palfed " class="las la-palfed "></i>
                                        <i data-type="iconpicker-item" title=".las la-page4 " class="las la-page4 "></i>
                                        <i data-type="iconpicker-item" title=".las la-padlet " class="las la-padlet "></i>
                                        <i data-type="iconpicker-item" title=".las la-osi " class="las la-osi "></i>
                                        <i data-type="iconpicker-item" title=".las la-orcid " class="las la-orcid "></i>
                                        <i data-type="iconpicker-item" title=".las la-optin-monster " class="las la-optin-monster "></i>
                                        <i data-type="iconpicker-item" title=".las la-opera " class="las la-opera "></i>
                                        <i data-type="iconpicker-item" title=".las la-opensuse " class="las la-opensuse "></i>
                                        <i data-type="iconpicker-item" title=".las la-opencart " class="las la-opencart "></i>
                                        <i data-type="iconpicker-item" title=".las la-old-republic " class="las la-old-republic "></i>
                                        <i data-type="iconpicker-item" title=".las la-odysee " class="las la-odysee "></i>
                                        <i data-type="iconpicker-item" title=".las la-odnoklassniki " class="las la-odnoklassniki "></i>
                                        <i data-type="iconpicker-item" title=".las la-octopus-deploy " class="las la-octopus-deploy "></i>
                                        <i data-type="iconpicker-item" title=".las la-nutritionix " class="las la-nutritionix "></i>
                                        <i data-type="iconpicker-item" title=".las la-ns8 " class="las la-ns8 "></i>
                                        <i data-type="iconpicker-item" title=".las la-npm " class="las la-npm "></i>
                                        <i data-type="iconpicker-item" title=".las la-node-js " class="las la-node-js "></i>
                                        <i data-type="iconpicker-item" title=".las la-nimblr " class="las la-nimblr "></i>
                                        <i data-type="iconpicker-item" title=".las la-nfc-symbol " class="las la-nfc-symbol "></i>
                                        <i data-type="iconpicker-item" title=".las la-nfc-directional " class="las la-nfc-directional "></i>
                                        <i data-type="iconpicker-item" title=".las la-neos " class="las la-neos "></i>
                                        <i data-type="iconpicker-item" title=".las la-napster " class="las la-napster "></i>
                                        <i data-type="iconpicker-item" title=".las la-monero " class="las la-monero "></i>
                                        <i data-type="iconpicker-item" title=".las la-modx " class="las la-modx "></i>
                                        <i data-type="iconpicker-item" title=".las la-mizuni " class="las la-mizuni "></i>
                                        <i data-type="iconpicker-item" title=".las la-mixer " class="las la-mixer "></i>
                                        <i data-type="iconpicker-item" title=".las la-mixcloud " class="las la-mixcloud "></i>
                                        <i data-type="iconpicker-item" title=".las la-mix " class="las la-mix "></i>
                                        <i data-type="iconpicker-item" title=".las la-mintbit " class="las la-mintbit "></i>
                                        <i data-type="iconpicker-item" title=".las la-microblog " class="las la-microblog "></i>
                                        <i data-type="iconpicker-item" title=".las la-meta " class="las la-meta "></i>
                                        <i data-type="iconpicker-item" title=".las la-mendeley " class="las la-mendeley "></i>
                                        <i data-type="iconpicker-item" title=".las la-megaport " class="las la-megaport "></i>
                                        <i data-type="iconpicker-item" title=".las la-medrt " class="las la-medrt "></i>
                                        <i data-type="iconpicker-item" title=".las la-medapps " class="las la-medapps "></i>
                                        <i data-type="iconpicker-item" title=".las la-mdb " class="las la-mdb "></i>
                                        <i data-type="iconpicker-item" title=".las la-maxcdn " class="las la-maxcdn "></i>
                                        <i data-type="iconpicker-item" title=".las la-mastodon " class="las la-mastodon "></i>
                                        <i data-type="iconpicker-item" title=".las la-markdown " class="las la-markdown "></i>
                                        <i data-type="iconpicker-item" title=".las la-mandalorian " class="las la-mandalorian "></i>
                                        <i data-type="iconpicker-item" title=".las la-mailchimp " class="las la-mailchimp "></i>
                                        <i data-type="iconpicker-item" title=".las la-magento " class="las la-magento "></i>
                                        <i data-type="iconpicker-item" title=".las la-lyft " class="las la-lyft "></i>
                                        <i data-type="iconpicker-item" title=".las la-linode " class="las la-linode "></i>
                                        <i data-type="iconpicker-item" title=".las la-linkedin-in " class="las la-linkedin-in "></i>
                                        <i data-type="iconpicker-item" title=".las la-letterboxd " class="las la-letterboxd "></i>
                                        <i data-type="iconpicker-item" title=".las la-less " class="las la-less "></i>
                                        <i data-type="iconpicker-item" title=".las la-leanpub " class="las la-leanpub "></i>
                                        <i data-type="iconpicker-item" title=".las la-lastfm " class="las la-lastfm "></i>
                                        <i data-type="iconpicker-item" title=".las la-laravel " class="las la-laravel "></i>
                                        <i data-type="iconpicker-item" title=".las la-korvue " class="las la-korvue "></i>
                                        <i data-type="iconpicker-item" title=".las la-kickstarter-k " class="las la-kickstarter-k "></i>
                                        <i data-type="iconpicker-item" title=".las la-keycdn " class="las la-keycdn "></i>
                                        <i data-type="iconpicker-item" title=".las la-keybase " class="las la-keybase "></i>
                                        <i data-type="iconpicker-item" title=".las la-kaggle " class="las la-kaggle "></i>
                                        <i data-type="iconpicker-item" title=".las la-jxl " class="las la-jxl "></i>
                                        <i data-type="iconpicker-item" title=".las la-jsfiddle " class="las la-jsfiddle "></i>
                                        <i data-type="iconpicker-item" title=".las la-js " class="las la-js "></i>
                                        <i data-type="iconpicker-item" title=".las la-joomla " class="las la-joomla "></i>
                                        <i data-type="iconpicker-item" title=".las la-joget " class="las la-joget "></i>
                                        <i data-type="iconpicker-item" title=".las la-jira " class="las la-jira "></i>
                                        <i data-type="iconpicker-item" title=".las la-jenkins " class="las la-jenkins "></i>
                                        <i data-type="iconpicker-item" title=".las la-jedi-order " class="las la-jedi-order "></i>
                                        <i data-type="iconpicker-item" title=".las la-itunes-note " class="las la-itunes-note "></i>
                                        <i data-type="iconpicker-item" title=".las la-itunes " class="las la-itunes "></i>
                                        <i data-type="iconpicker-item" title=".las la-itch-io " class="las la-itch-io "></i>
                                        <i data-type="iconpicker-item" title=".las la-ioxhost " class="las la-ioxhost "></i>
                                        <i data-type="iconpicker-item" title=".las la-invision " class="las la-invision "></i>
                                        <i data-type="iconpicker-item" title=".las la-instalod " class="las la-instalod "></i>
                                        <i data-type="iconpicker-item" title=".las la-imdb " class="las la-imdb "></i>
                                        <i data-type="iconpicker-item" title=".las la-hubspot " class="las la-hubspot "></i>
                                        <i data-type="iconpicker-item" title=".las la-houzz " class="las la-houzz "></i>
                                        <i data-type="iconpicker-item" title=".las la-hotjar " class="las la-hotjar "></i>
                                        <i data-type="iconpicker-item" title=".las la-hornbill " class="las la-hornbill "></i>
                                        <i data-type="iconpicker-item" title=".las la-hooli " class="las la-hooli "></i>
                                        <i data-type="iconpicker-item" title=".las la-hive " class="las la-hive "></i>
                                        <i data-type="iconpicker-item" title=".las la-hire-a-helper " class="las la-hire-a-helper "></i>
                                        <i data-type="iconpicker-item" title=".las la-hips " class="las la-hips "></i>
                                        <i data-type="iconpicker-item" title=".las la-hashnode " class="las la-hashnode "></i>
                                        <i data-type="iconpicker-item" title=".las la-hackerrank " class="las la-hackerrank "></i>
                                        <i data-type="iconpicker-item" title=".las la-hacker-news " class="las la-hacker-news "></i>
                                        <i data-type="iconpicker-item" title=".las la-gulp " class="las la-gulp "></i>
                                        <i data-type="iconpicker-item" title=".las la-guilded " class="las la-guilded "></i>
                                        <i data-type="iconpicker-item" title=".las la-grunt " class="las la-grunt "></i>
                                        <i data-type="iconpicker-item" title=".las la-gripfire " class="las la-gripfire "></i>
                                        <i data-type="iconpicker-item" title=".las la-grav " class="las la-grav "></i>
                                        <i data-type="iconpicker-item" title=".las la-gratipay " class="las la-gratipay "></i>
                                        <i data-type="iconpicker-item" title=".las la-google-wallet " class="las la-google-wallet "></i>
                                        <i data-type="iconpicker-item" title=".las la-google-scholar " class="las la-google-scholar "></i>
                                        <i data-type="iconpicker-item" title=".las la-google-plus-g " class="las la-google-plus-g "></i>
                                        <i data-type="iconpicker-item" title=".las la-google-plus " class="las la-google-plus "></i>
                                        <i data-type="iconpicker-item" title=".las la-google-pay " class="las la-google-pay "></i>
                                        <i data-type="iconpicker-item" title=".las la-google-drive " class="las la-google-drive "></i>
                                        <i data-type="iconpicker-item" title=".las la-goodreads " class="las la-goodreads "></i>
                                        <i data-type="iconpicker-item" title=".las la-golang " class="las la-golang "></i>
                                        <i data-type="iconpicker-item" title=".las la-gofore " class="las la-gofore "></i>
                                        <i data-type="iconpicker-item" title=".las la-glide " class="las la-glide "></i>
                                        <i data-type="iconpicker-item" title=".las la-gitter " class="las la-gitter "></i>
                                        <i data-type="iconpicker-item" title=".las la-gitkraken " class="las la-gitkraken "></i>
                                        <i data-type="iconpicker-item" title=".las la-github-alt " class="las la-github-alt "></i>
                                        <i data-type="iconpicker-item" title=".las la-git-alt " class="las la-git-alt "></i>
                                        <i data-type="iconpicker-item" title=".las la-git " class="las la-git "></i>
                                        <i data-type="iconpicker-item" title=".las la-gg-circle " class="las la-gg-circle "></i>
                                        <i data-type="iconpicker-item" title=".las la-gg " class="las la-gg "></i>
                                        <i data-type="iconpicker-item" title=".las la-get-pocket " class="las la-get-pocket "></i>
                                        <i data-type="iconpicker-item" title=".las la-galactic-senate " class="las la-galactic-senate "></i>
                                        <i data-type="iconpicker-item" title=".las la-galactic-republic " class="las la-galactic-republic "></i>
                                        <i data-type="iconpicker-item" title=".las la-fulcrum " class="las la-fulcrum "></i>
                                        <i data-type="iconpicker-item" title=".las la-freebsd " class="las la-freebsd "></i>
                                        <i data-type="iconpicker-item" title=".las la-foursquare " class="las la-foursquare "></i>
                                        <i data-type="iconpicker-item" title=".las la-forumbee " class="las la-forumbee "></i>
                                        <i data-type="iconpicker-item" title=".las la-fort-awesome-alt " class="las la-fort-awesome-alt "></i>
                                        <i data-type="iconpicker-item" title=".las la-fort-awesome " class="las la-fort-awesome "></i>
                                        <i data-type="iconpicker-item" title=".las la-fonticons-fi " class="las la-fonticons-fi "></i>
                                        <i data-type="iconpicker-item" title=".las la-fonticons " class="las la-fonticons "></i>
                                        <i data-type="iconpicker-item" title=".las la-font-awesome " class="las la-font-awesome "></i>
                                        <i data-type="iconpicker-item" title=".las la-flutter " class="las la-flutter "></i>
                                        <i data-type="iconpicker-item" title=".las la-flipboard " class="las la-flipboard "></i>
                                        <i data-type="iconpicker-item" title=".las la-flickr " class="las la-flickr "></i>
                                        <i data-type="iconpicker-item" title=".las la-firstdraft " class="las la-firstdraft "></i>
                                        <i data-type="iconpicker-item" title=".las la-first-order-alt " class="las la-first-order-alt "></i>
                                        <i data-type="iconpicker-item" title=".las la-first-order " class="las la-first-order "></i>
                                        <i data-type="iconpicker-item" title=".las la-firefox-browser " class="las la-firefox-browser "></i>
                                        <i data-type="iconpicker-item" title=".las la-firefox " class="las la-firefox "></i>
                                        <i data-type="iconpicker-item" title=".las la-files-pinwheel " class="las la-files-pinwheel "></i>
                                        <i data-type="iconpicker-item" title=".las la-fedora " class="las la-fedora "></i>
                                        <i data-type="iconpicker-item" title=".las la-fedex " class="las la-fedex "></i>
                                        <i data-type="iconpicker-item" title=".las la-fantasy-flight-games " class="las la-fantasy-flight-games "></i>
                                        <i data-type="iconpicker-item" title=".las la-facebook-f " class="las la-facebook-f "></i>
                                        <i data-type="iconpicker-item" title=".las la-expeditedssl " class="las la-expeditedssl "></i>
                                        <i data-type="iconpicker-item" title=".las la-evernote " class="las la-evernote "></i>
                                        <i data-type="iconpicker-item" title=".las la-ethereum " class="las la-ethereum "></i>
                                        <i data-type="iconpicker-item" title=".las la-erlang " class="las la-erlang "></i>
                                        <i data-type="iconpicker-item" title=".las la-envira " class="las la-envira "></i>
                                        <i data-type="iconpicker-item" title=".las la-empire " class="las la-empire "></i>
                                        <i data-type="iconpicker-item" title=".las la-ember " class="las la-ember "></i>
                                        <i data-type="iconpicker-item" title=".las la-ello " class="las la-ello "></i>
                                        <i data-type="iconpicker-item" title=".las la-edge-legacy " class="las la-edge-legacy "></i>
                                        <i data-type="iconpicker-item" title=".las la-edge " class="las la-edge "></i>
                                        <i data-type="iconpicker-item" title=".las la-ebay " class="las la-ebay "></i>
                                        <i data-type="iconpicker-item" title=".las la-earlybirds " class="las la-earlybirds "></i>
                                        <i data-type="iconpicker-item" title=".las la-dyalog " class="las la-dyalog "></i>
                                        <i data-type="iconpicker-item" title=".las la-drupal " class="las la-drupal "></i>
                                        <i data-type="iconpicker-item" title=".las la-draft2digital " class="las la-draft2digital "></i>
                                        <i data-type="iconpicker-item" title=".las la-dochub " class="las la-dochub "></i>
                                        <i data-type="iconpicker-item" title=".las la-digital-ocean " class="las la-digital-ocean "></i>
                                        <i data-type="iconpicker-item" title=".las la-digg " class="las la-digg "></i>
                                        <i data-type="iconpicker-item" title=".las la-diaspora " class="las la-diaspora "></i>
                                        <i data-type="iconpicker-item" title=".las la-dhl " class="las la-dhl "></i>
                                        <i data-type="iconpicker-item" title=".las la-deviantart " class="las la-deviantart "></i>
                                        <i data-type="iconpicker-item" title=".las la-dev " class="las la-dev "></i>
                                        <i data-type="iconpicker-item" title=".las la-deskpro " class="las la-deskpro "></i>
                                        <i data-type="iconpicker-item" title=".las la-deploydog " class="las la-deploydog "></i>
                                        <i data-type="iconpicker-item" title=".las la-delicious " class="las la-delicious "></i>
                                        <i data-type="iconpicker-item" title=".las la-deezer " class="las la-deezer "></i>
                                        <i data-type="iconpicker-item" title=".las la-debian " class="las la-debian "></i>
                                        <i data-type="iconpicker-item" title=".las la-dart-lang " class="las la-dart-lang "></i>
                                        <i data-type="iconpicker-item" title=".las la-dailymotion " class="las la-dailymotion "></i>
                                        <i data-type="iconpicker-item" title=".las la-d-and-d-beyond " class="las la-d-and-d-beyond "></i>
                                        <i data-type="iconpicker-item" title=".las la-d-and-d " class="las la-d-and-d "></i>
                                        <i data-type="iconpicker-item" title=".las la-cuttlefish " class="las la-cuttlefish "></i>
                                        <i data-type="iconpicker-item" title=".las la-css3-alt " class="las la-css3-alt "></i>
                                        <i data-type="iconpicker-item" title=".las la-css3 " class="las la-css3 "></i>
                                        <i data-type="iconpicker-item" title=".las la-css " class="las la-css "></i>
                                        <i data-type="iconpicker-item" title=".las la-critical-role " class="las la-critical-role "></i>
                                        <i data-type="iconpicker-item" title=".las la-creative-commons-zero " class="las la-creative-commons-zero "></i>
                                        <i data-type="iconpicker-item" title=".las la-creative-commons-share " class="las la-creative-commons-share "></i>
                                        <i data-type="iconpicker-item" title=".las la-creative-commons-sampling-plus " class="las la-creative-commons-sampling-plus "></i>
                                        <i data-type="iconpicker-item" title=".las la-creative-commons-sampling " class="las la-creative-commons-sampling "></i>
                                        <i data-type="iconpicker-item" title=".las la-creative-commons-sa " class="las la-creative-commons-sa "></i>
                                        <i data-type="iconpicker-item" title=".las la-creative-commons-remix " class="las la-creative-commons-remix "></i>
                                        <i data-type="iconpicker-item" title=".las la-creative-commons-pd-alt " class="las la-creative-commons-pd-alt "></i>
                                        <i data-type="iconpicker-item" title=".las la-creative-commons-pd " class="las la-creative-commons-pd "></i>
                                        <i data-type="iconpicker-item" title=".las la-creative-commons-nd " class="las la-creative-commons-nd "></i>
                                        <i data-type="iconpicker-item" title=".las la-creative-commons-nc-jp " class="las la-creative-commons-nc-jp "></i>
                                        <i data-type="iconpicker-item" title=".las la-creative-commons-nc-eu " class="las la-creative-commons-nc-eu "></i>
                                        <i data-type="iconpicker-item" title=".las la-creative-commons-nc " class="las la-creative-commons-nc "></i>
                                        <i data-type="iconpicker-item" title=".las la-creative-commons-by " class="las la-creative-commons-by "></i>
                                        <i data-type="iconpicker-item" title=".las la-creative-commons " class="las la-creative-commons "></i>
                                        <i data-type="iconpicker-item" title=".las la-cpanel " class="las la-cpanel "></i>
                                        <i data-type="iconpicker-item" title=".las la-cotton-bureau " class="las la-cotton-bureau "></i>
                                        <i data-type="iconpicker-item" title=".las la-contao " class="las la-contao "></i>
                                        <i data-type="iconpicker-item" title=".las la-connectdevelop " class="las la-connectdevelop "></i>
                                        <i data-type="iconpicker-item" title=".las la-confluence " class="las la-confluence "></i>
                                        <i data-type="iconpicker-item" title=".las la-codiepie " class="las la-codiepie "></i>
                                        <i data-type="iconpicker-item" title=".las la-cmplid " class="las la-cmplid "></i>
                                        <i data-type="iconpicker-item" title=".las la-cloudversify " class="las la-cloudversify "></i>
                                        <i data-type="iconpicker-item" title=".las la-cloudsmith " class="las la-cloudsmith "></i>
                                        <i data-type="iconpicker-item" title=".las la-cloudscale " class="las la-cloudscale "></i>
                                        <i data-type="iconpicker-item" title=".las la-chromecast " class="las la-chromecast "></i>
                                        <i data-type="iconpicker-item" title=".las la-chrome " class="las la-chrome "></i>
                                        <i data-type="iconpicker-item" title=".las la-centos " class="las la-centos "></i>
                                        <i data-type="iconpicker-item" title=".las la-centercode " class="las la-centercode "></i>
                                        <i data-type="iconpicker-item" title=".las la-cc-stripe " class="las la-cc-stripe "></i>
                                        <i data-type="iconpicker-item" title=".las la-cc-paypal " class="las la-cc-paypal "></i>
                                        <i data-type="iconpicker-item" title=".las la-cc-jcb " class="las la-cc-jcb "></i>
                                        <i data-type="iconpicker-item" title=".las la-cc-discover " class="las la-cc-discover "></i>
                                        <i data-type="iconpicker-item" title=".las la-cc-diners-club " class="las la-cc-diners-club "></i>
                                        <i data-type="iconpicker-item" title=".las la-cc-apple-pay " class="las la-cc-apple-pay "></i>
                                        <i data-type="iconpicker-item" title=".las la-cc-amex " class="las la-cc-amex "></i>
                                        <i data-type="iconpicker-item" title=".las la-cc-amazon-pay " class="las la-cc-amazon-pay "></i>
                                        <i data-type="iconpicker-item" title=".las la-canadian-maple-leaf " class="las la-canadian-maple-leaf "></i>
                                        <i data-type="iconpicker-item" title=".las la-buysellads " class="las la-buysellads "></i>
                                        <i data-type="iconpicker-item" title=".las la-buy-n-large " class="las la-buy-n-large "></i>
                                        <i data-type="iconpicker-item" title=".las la-buromobelexperte " class="las la-buromobelexperte "></i>
                                        <i data-type="iconpicker-item" title=".las la-buffer " class="las la-buffer "></i>
                                        <i data-type="iconpicker-item" title=".las la-btc " class="las la-btc "></i>
                                        <i data-type="iconpicker-item" title=".las la-brave-reverse " class="las la-brave-reverse "></i>
                                        <i data-type="iconpicker-item" title=".las la-brave " class="las la-brave "></i>
                                        <i data-type="iconpicker-item" title=".las la-bots " class="las la-bots "></i>
                                        <i data-type="iconpicker-item" title=".las la-bootstrap " class="las la-bootstrap "></i>
                                        <i data-type="iconpicker-item" title=".las la-bluetooth-b " class="las la-bluetooth-b "></i>
                                        <i data-type="iconpicker-item" title=".las la-bluetooth " class="las la-bluetooth "></i>
                                        <i data-type="iconpicker-item" title=".las la-bluesky " class="las la-bluesky "></i>
                                        <i data-type="iconpicker-item" title=".las la-blogger-b " class="las la-blogger-b "></i>
                                        <i data-type="iconpicker-item" title=".las la-blogger " class="las la-blogger "></i>
                                        <i data-type="iconpicker-item" title=".las la-blackberry " class="las la-blackberry "></i>
                                        <i data-type="iconpicker-item" title=".las la-black-tie " class="las la-black-tie "></i>
                                        <i data-type="iconpicker-item" title=".las la-bity " class="las la-bity "></i>
                                        <i data-type="iconpicker-item" title=".las la-bitcoin " class="las la-bitcoin "></i>
                                        <i data-type="iconpicker-item" title=".las la-bitbucket " class="las la-bitbucket "></i>
                                        <i data-type="iconpicker-item" title=".las la-bimobject " class="las la-bimobject "></i>
                                        <i data-type="iconpicker-item" title=".las la-bilibili " class="las la-bilibili "></i>
                                        <i data-type="iconpicker-item" title=".las la-battle-net " class="las la-battle-net "></i>
                                        <i data-type="iconpicker-item" title=".las la-bandcamp " class="las la-bandcamp "></i>
                                        <i data-type="iconpicker-item" title=".las la-aws " class="las la-aws "></i>
                                        <i data-type="iconpicker-item" title=".las la-aviato " class="las la-aviato "></i>
                                        <i data-type="iconpicker-item" title=".las la-avianex " class="las la-avianex "></i>
                                        <i data-type="iconpicker-item" title=".las la-autoprefixer " class="las la-autoprefixer "></i>
                                        <i data-type="iconpicker-item" title=".las la-audible " class="las la-audible "></i>
                                        <i data-type="iconpicker-item" title=".las la-asymmetrik " class="las la-asymmetrik "></i>
                                        <i data-type="iconpicker-item" title=".las la-artstation " class="las la-artstation "></i>
                                        <i data-type="iconpicker-item" title=".las la-apple-pay " class="las la-apple-pay "></i>
                                        <i data-type="iconpicker-item" title=".las la-apper " class="las la-apper "></i>
                                        <i data-type="iconpicker-item" title=".las la-app-store-ios " class="las la-app-store-ios "></i>
                                        <i data-type="iconpicker-item" title=".las la-app-store " class="las la-app-store "></i>
                                        <i data-type="iconpicker-item" title=".las la-angular " class="las la-angular "></i>
                                        <i data-type="iconpicker-item" title=".las la-angrycreative " class="las la-angrycreative "></i>
                                        <i data-type="iconpicker-item" title=".las la-angellist " class="las la-angellist "></i>
                                        <i data-type="iconpicker-item" title=".las la-amilia " class="las la-amilia "></i>
                                        <i data-type="iconpicker-item" title=".las la-amazon-pay " class="las la-amazon-pay "></i>
                                        <i data-type="iconpicker-item" title=".las la-alipay " class="las la-alipay "></i>
                                        <i data-type="iconpicker-item" title=".las la-affiliatetheme " class="las la-affiliatetheme "></i>
                                        <i data-type="iconpicker-item" title=".las la-adversal " class="las la-adversal "></i>
                                        <i data-type="iconpicker-item" title=".las la-adn " class="las la-adn "></i>
                                        <i data-type="iconpicker-item" title=".las la-accusoft " class="las la-accusoft "></i>
                                        <i data-type="iconpicker-item" title=".las la-500px " class="las la-500px "></i>
                                        <i data-type="iconpicker-item" title=".las la-42-group " class="las la-42-group "></i>
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
                                    <i data-type="iconpicker-item" title=".las la-facebook " class="las la-facebook "></i>
                                    <i data-type="iconpicker-item" title=".las la-twitter " class="las la-twitter "></i>
                                    <i data-type="iconpicker-item" title=".las la-instagram " class="las la-instagram "></i>
                                    <i data-type="iconpicker-item" title=".las la-tiktok " class="las la-tiktok "></i>
                                    <i data-type="iconpicker-item" title=".las la-linkedin " class="las la-linkedin "></i>
                                    <i data-type="iconpicker-item" title=".las la-github " class="las la-github "></i>
                                    <i data-type="iconpicker-item" title=".las la-discord " class="las la-discord "></i>
                                    <i data-type="iconpicker-item" title=".las la-youtube " class="las la-youtube "></i>
                                    <i data-type="iconpicker-item" title=".las la-wordpress " class="las la-wordpress "></i>
                                    <i data-type="iconpicker-item" title=".las la-slack " class="las la-slack "></i>
                                    <i data-type="iconpicker-item" title=".las la-figma " class="las la-figma "></i>
                                    <i data-type="iconpicker-item" title=".las la-apple " class="las la-apple "></i>
                                    <i data-type="iconpicker-item" title=".las la-google " class="las la-google "></i>
                                    <i data-type="iconpicker-item" title=".las la-stripe " class="las la-stripe "></i>
                                    <i data-type="iconpicker-item" title=".las la-algolia " class="las la-algolia "></i>
                                    <i data-type="iconpicker-item" title=".las la-docker " class="las la-docker "></i>
                                    <i data-type="iconpicker-item" title=".las la-windows " class="las la-windows "></i>
                                    <i data-type="iconpicker-item" title=".las la-paypal " class="las la-paypal "></i>
                                    <i data-type="iconpicker-item" title=".las la-stack-overflow " class="las la-stack-overflow "></i>
                                    <i data-type="iconpicker-item" title=".las la-kickstarter " class="las la-kickstarter "></i>
                                    <i data-type="iconpicker-item" title=".las la-dribbble " class="las la-dribbble "></i>
                                    <i data-type="iconpicker-item" title=".las la-dropbox " class="las la-dropbox "></i>
                                    <i data-type="iconpicker-item" title=".las la-squarespace " class="las la-squarespace "></i>
                                    <i data-type="iconpicker-item" title=".las la-android " class="las la-android "></i>
                                    <i data-type="iconpicker-item" title=".las la-shopify " class="las la-shopify "></i>
                                    <i data-type="iconpicker-item" title=".las la-medium " class="las la-medium "></i>
                                    <i data-type="iconpicker-item" title=".las la-codepen " class="las la-codepen "></i>
                                    <i data-type="iconpicker-item" title=".las la-cloudflare " class="las la-cloudflare "></i>
                                    <i data-type="iconpicker-item" title=".las la-airbnb " class="las la-airbnb "></i>
                                    <i data-type="iconpicker-item" title=".las la-vimeo " class="las la-vimeo "></i>
                                    <i data-type="iconpicker-item" title=".las la-whatsapp " class="las la-whatsapp "></i>
                                    <i data-type="iconpicker-item" title=".las la-intercom " class="las la-intercom "></i>
                                    <i data-type="iconpicker-item" title=".las la-usps " class="las la-usps "></i>
                                    <i data-type="iconpicker-item" title=".las la-wix " class="las la-wix "></i>
                                    <i data-type="iconpicker-item" title=".las la-line " class="las la-line "></i>
                                    <i data-type="iconpicker-item" title=".las la-behance " class="las la-behance "></i>
                                    <i data-type="iconpicker-item" title=".las la-openid " class="las la-openid "></i>
                                    <i data-type="iconpicker-item" title=".las la-product-hunt " class="las la-product-hunt "></i>
                                    <i data-type="iconpicker-item" title=".las la-internet-explorer " class="las la-internet-explorer "></i>
                                    <i data-type="iconpicker-item" title=".las la-pagelines " class="las la-pagelines "></i>
                                    <i data-type="iconpicker-item" title=".las la-teamspeak " class="las la-teamspeak "></i>
                                    <i data-type="iconpicker-item" title=".las la-html5 " class="las la-html5 "></i>
                                    <i data-type="iconpicker-item" title=".las la-telegram " class="las la-telegram "></i>
                                    <i data-type="iconpicker-item" title=".las la-pinterest " class="las la-pinterest "></i>
                                    <i data-type="iconpicker-item" title=".las la-dashcube " class="las la-dashcube "></i>
                                    <i data-type="iconpicker-item" title=".las la-ideal " class="las la-ideal "></i>
                                    <i data-type="iconpicker-item" title=".las la-salesforce " class="las la-salesforce "></i>
                                    <i data-type="iconpicker-item" title=".las la-readme " class="las la-readme "></i>
                                    <i data-type="iconpicker-item" title=".las la-free-code-camp " class="las la-free-code-camp "></i>
                                    <i data-type="iconpicker-item" title=".las la-soundcloud " class="las la-soundcloud "></i>
                                    <i data-type="iconpicker-item" title=".las la-square-twitter " class="las la-square-twitter "></i>
                                    <i data-type="iconpicker-item" title=".las la-accessible-icon " class="las la-accessible-icon "></i>
                                    <i data-type="iconpicker-item" title=".las la-cc-visa " class="las la-cc-visa "></i>
                                    <i data-type="iconpicker-item" title=".las la-goodreads-g " class="las la-goodreads-g "></i>
                                    <i data-type="iconpicker-item" title=".las la-google-play " class="las la-google-play "></i>
                                    <i data-type="iconpicker-item" title=".las la-react " class="las la-react "></i>
                                    <i data-type="iconpicker-item" title=".las la-wikipedia-w " class="las la-wikipedia-w "></i>
                                    <i data-type="iconpicker-item" title=".las la-square-js " class="las la-square-js "></i>
                                    <i data-type="iconpicker-item" title=".las la-java " class="las la-java "></i>
                                    <i data-type="iconpicker-item" title=".las la-square-pinterest " class="las la-square-pinterest "></i>
                                    <i data-type="iconpicker-item" title=".las la-python " class="las la-python "></i>
                                    <i data-type="iconpicker-item" title=".las la-skype " class="las la-skype "></i>
                                    <i data-type="iconpicker-item" title=".las la-linux " class="las la-linux "></i>
                                    <i data-type="iconpicker-item" title=".las la-node " class="las la-node "></i>
                                    <i data-type="iconpicker-item" title=".las la-rebel " class="las la-rebel "></i>
                                    <i data-type="iconpicker-item" title=".las la-etsy " class="las la-etsy "></i>
                                    <i data-type="iconpicker-item" title=".las la-discourse " class="las la-discourse "></i>
                                    <i data-type="iconpicker-item" title=".las la-amazon " class="las la-amazon "></i>
                                    <i data-type="iconpicker-item" title=".las la-glide-g " class="las la-glide-g "></i>
                                    <i data-type="iconpicker-item" title=".las la-gitlab " class="las la-gitlab "></i>
                                    <i data-type="iconpicker-item" title=".las la-spotify " class="las la-spotify "></i>
                                    <i data-type="iconpicker-item" title=".las la-think-peaks " class="las la-think-peaks "></i>
                                    <i data-type="iconpicker-item" title=".las la-microsoft " class="las la-microsoft "></i>
                                    <i data-type="iconpicker-item" title=".las la-elementor " class="las la-elementor "></i>
                                    <i data-type="iconpicker-item" title=".las la-pied-piper " class="las la-pied-piper "></i>
                                    <i data-type="iconpicker-item" title=".las la-square-youtube " class="las la-square-youtube "></i>
                                    <i data-type="iconpicker-item" title=".las la-cc-mastercard " class="las la-cc-mastercard "></i>
                                    <i data-type="iconpicker-item" title=".las la-facebook-messenger " class="las la-facebook-messenger "></i>
                                    <i data-type="iconpicker-item" title=".las la-atlassian " class="las la-atlassian "></i>
                                    <i data-type="iconpicker-item" title=".las la-playstation " class="las la-playstation "></i>
                                    <i data-type="iconpicker-item" title=".las la-fly " class="las la-fly "></i>
                                    <i data-type="iconpicker-item" title=".las la-meetup " class="las la-meetup "></i>
                                    <i data-type="iconpicker-item" title=".las la-twitch " class="las la-twitch "></i>
                                    <i data-type="iconpicker-item" title=".las la-waze " class="las la-waze "></i>
                                    <i data-type="iconpicker-item" title=".las la-zhihu " class="las la-zhihu "></i>
                                    <i data-type="iconpicker-item" title=".las la-yoast " class="las la-yoast "></i>
                                    <i data-type="iconpicker-item" title=".las la-yelp " class="las la-yelp "></i>
                                    <i data-type="iconpicker-item" title=".las la-yarn " class="las la-yarn "></i>
                                    <i data-type="iconpicker-item" title=".las la-yandex-international " class="las la-yandex-international "></i>
                                    <i data-type="iconpicker-item" title=".las la-yandex " class="las la-yandex "></i>
                                    <i data-type="iconpicker-item" title=".las la-yammer " class="las la-yammer "></i>
                                    <i data-type="iconpicker-item" title=".las la-yahoo " class="las la-yahoo "></i>
                                    <i data-type="iconpicker-item" title=".las la-y-combinator " class="las la-y-combinator "></i>
                                    <i data-type="iconpicker-item" title=".las la-xing " class="las la-xing "></i>
                                    <i data-type="iconpicker-item" title=".las la-xbox " class="las la-xbox "></i>
                                    <i data-type="iconpicker-item" title=".las la-x-twitter " class="las la-x-twitter "></i>
                                    <i data-type="iconpicker-item" title=".las la-wpressr " class="las la-wpressr "></i>
                                    <i data-type="iconpicker-item" title=".las la-wpforms " class="las la-wpforms "></i>
                                    <i data-type="iconpicker-item" title=".las la-wpexplorer " class="las la-wpexplorer "></i>
                                    <i data-type="iconpicker-item" title=".las la-wpbeginner " class="las la-wpbeginner "></i>
                                    <i data-type="iconpicker-item" title=".las la-wordpress-simple " class="las la-wordpress-simple "></i>
                                    <i data-type="iconpicker-item" title=".las la-wolf-pack-battalion " class="las la-wolf-pack-battalion "></i>
                                    <i data-type="iconpicker-item" title=".las la-wodu " class="las la-wodu "></i>
                                    <i data-type="iconpicker-item" title=".las la-wizards-of-the-coast " class="las la-wizards-of-the-coast "></i>
                                    <i data-type="iconpicker-item" title=".las la-wirsindhandwerk " class="las la-wirsindhandwerk "></i>
                                    <i data-type="iconpicker-item" title=".las la-whmcs " class="las la-whmcs "></i>
                                    <i data-type="iconpicker-item" title=".las la-weixin " class="las la-weixin "></i>
                                    <i data-type="iconpicker-item" title=".las la-weibo " class="las la-weibo "></i>
                                    <i data-type="iconpicker-item" title=".las la-weebly " class="las la-weebly "></i>
                                    <i data-type="iconpicker-item" title=".las la-webflow " class="las la-webflow "></i>
                                    <i data-type="iconpicker-item" title=".las la-web-awesome " class="las la-web-awesome "></i>
                                    <i data-type="iconpicker-item" title=".las la-watchman-monitoring " class="las la-watchman-monitoring "></i>
                                    <i data-type="iconpicker-item" title=".las la-vuejs " class="las la-vuejs "></i>
                                    <i data-type="iconpicker-item" title=".las la-vnv " class="las la-vnv "></i>
                                    <i data-type="iconpicker-item" title=".las la-vk " class="las la-vk "></i>
                                    <i data-type="iconpicker-item" title=".las la-vine " class="las la-vine "></i>
                                    <i data-type="iconpicker-item" title=".las la-vimeo-v " class="las la-vimeo-v "></i>
                                    <i data-type="iconpicker-item" title=".las la-viber " class="las la-viber "></i>
                                    <i data-type="iconpicker-item" title=".las la-viadeo " class="las la-viadeo "></i>
                                    <i data-type="iconpicker-item" title=".las la-viacoin " class="las la-viacoin "></i>
                                    <i data-type="iconpicker-item" title=".las la-vaadin " class="las la-vaadin "></i>
                                    <i data-type="iconpicker-item" title=".las la-ussunnah " class="las la-ussunnah "></i>
                                    <i data-type="iconpicker-item" title=".las la-usb " class="las la-usb "></i>
                                    <i data-type="iconpicker-item" title=".las la-upwork " class="las la-upwork "></i>
                                    <i data-type="iconpicker-item" title=".las la-ups " class="las la-ups "></i>
                                    <i data-type="iconpicker-item" title=".las la-untappd " class="las la-untappd "></i>
                                    <i data-type="iconpicker-item" title=".las la-unsplash " class="las la-unsplash "></i>
                                    <i data-type="iconpicker-item" title=".las la-unity " class="las la-unity "></i>
                                    <i data-type="iconpicker-item" title=".las la-uniregistry " class="las la-uniregistry "></i>
                                    <i data-type="iconpicker-item" title=".las la-uncharted " class="las la-uncharted "></i>
                                    <i data-type="iconpicker-item" title=".las la-umbraco " class="las la-umbraco "></i>
                                    <i data-type="iconpicker-item" title=".las la-uikit " class="las la-uikit "></i>
                                    <i data-type="iconpicker-item" title=".las la-ubuntu " class="las la-ubuntu "></i>
                                    <i data-type="iconpicker-item" title=".las la-uber " class="las la-uber "></i>
                                    <i data-type="iconpicker-item" title=".las la-typo3 " class="las la-typo3 "></i>
                                    <i data-type="iconpicker-item" title=".las la-tumblr " class="las la-tumblr "></i>
                                    <i data-type="iconpicker-item" title=".las la-trello " class="las la-trello "></i>
                                    <i data-type="iconpicker-item" title=".las la-trade-federation " class="las la-trade-federation "></i>
                                    <i data-type="iconpicker-item" title=".las la-threads " class="las la-threads "></i>
                                    <i data-type="iconpicker-item" title=".las la-themeisle " class="las la-themeisle "></i>
                                    <i data-type="iconpicker-item" title=".las la-themeco " class="las la-themeco "></i>
                                    <i data-type="iconpicker-item" title=".las la-the-red-yeti " class="las la-the-red-yeti "></i>
                                    <i data-type="iconpicker-item" title=".las la-tencent-weibo " class="las la-tencent-weibo "></i>
                                    <i data-type="iconpicker-item" title=".las la-symfony " class="las la-symfony "></i>
                                    <i data-type="iconpicker-item" title=".las la-swift " class="las la-swift "></i>
                                    <i data-type="iconpicker-item" title=".las la-suse " class="las la-suse "></i>
                                    <i data-type="iconpicker-item" title=".las la-supple " class="las la-supple "></i>
                                    <i data-type="iconpicker-item" title=".las la-superpowers " class="las la-superpowers "></i>
                                    <i data-type="iconpicker-item" title=".las la-stumbleupon-circle " class="las la-stumbleupon-circle "></i>
                                    <i data-type="iconpicker-item" title=".las la-stumbleupon " class="las la-stumbleupon "></i>
                                    <i data-type="iconpicker-item" title=".las la-studiovinari " class="las la-studiovinari "></i>
                                    <i data-type="iconpicker-item" title=".las la-stubber " class="las la-stubber "></i>
                                    <i data-type="iconpicker-item" title=".las la-stripe-s " class="las la-stripe-s "></i>
                                    <i data-type="iconpicker-item" title=".las la-strava " class="las la-strava "></i>
                                    <i data-type="iconpicker-item" title=".las la-sticker-mule " class="las la-sticker-mule "></i>
                                    <i data-type="iconpicker-item" title=".las la-steam-symbol " class="las la-steam-symbol "></i>
                                    <i data-type="iconpicker-item" title=".las la-steam " class="las la-steam "></i>
                                    <i data-type="iconpicker-item" title=".las la-staylinked " class="las la-staylinked "></i>
                                    <i data-type="iconpicker-item" title=".las la-stackpath " class="las la-stackpath "></i>
                                    <i data-type="iconpicker-item" title=".las la-stack-exchange " class="las la-stack-exchange "></i>
                                    <i data-type="iconpicker-item" title=".las la-square-xing " class="las la-square-xing "></i>
                                    <i data-type="iconpicker-item" title=".las la-square-x-twitter " class="las la-square-x-twitter "></i>
                                    <i data-type="iconpicker-item" title=".las la-square-whatsapp " class="las la-square-whatsapp "></i>
                                    <i data-type="iconpicker-item" title=".las la-square-web-awesome-stroke " class="las la-square-web-awesome-stroke "></i>
                                    <i data-type="iconpicker-item" title=".las la-square-web-awesome " class="las la-square-web-awesome "></i>
                                    <i data-type="iconpicker-item" title=".las la-square-vimeo " class="las la-square-vimeo "></i>
                                    <i data-type="iconpicker-item" title=".las la-square-viadeo " class="las la-square-viadeo "></i>
                                    <i data-type="iconpicker-item" title=".las la-square-upwork " class="las la-square-upwork "></i>
                                    <i data-type="iconpicker-item" title=".las la-square-tumblr " class="las la-square-tumblr "></i>
                                    <i data-type="iconpicker-item" title=".las la-square-threads " class="las la-square-threads "></i>
                                    <i data-type="iconpicker-item" title=".las la-square-steam " class="las la-square-steam "></i>
                                    <i data-type="iconpicker-item" title=".las la-square-snapchat " class="las la-square-snapchat "></i>
                                    <i data-type="iconpicker-item" title=".las la-square-reddit " class="las la-square-reddit "></i>
                                    <i data-type="iconpicker-item" title=".las la-square-pied-piper " class="las la-square-pied-piper "></i>
                                    <i data-type="iconpicker-item" title=".las la-square-odnoklassniki " class="las la-square-odnoklassniki "></i>
                                    <i data-type="iconpicker-item" title=".las la-square-letterboxd " class="las la-square-letterboxd "></i>
                                    <i data-type="iconpicker-item" title=".las la-square-lastfm " class="las la-square-lastfm "></i>
                                    <i data-type="iconpicker-item" title=".las la-square-instagram " class="las la-square-instagram "></i>
                                    <i data-type="iconpicker-item" title=".las la-square-hacker-news " class="las la-square-hacker-news "></i>
                                    <i data-type="iconpicker-item" title=".las la-square-google-plus " class="las la-square-google-plus "></i>
                                    <i data-type="iconpicker-item" title=".las la-square-gitlab " class="las la-square-gitlab "></i>
                                    <i data-type="iconpicker-item" title=".las la-square-github " class="las la-square-github "></i>
                                    <i data-type="iconpicker-item" title=".las la-square-git " class="las la-square-git "></i>
                                    <i data-type="iconpicker-item" title=".las la-square-font-awesome-stroke " class="las la-square-font-awesome-stroke "></i>
                                    <i data-type="iconpicker-item" title=".las la-square-font-awesome " class="las la-square-font-awesome "></i>
                                    <i data-type="iconpicker-item" title=".las la-square-facebook " class="las la-square-facebook "></i>
                                    <i data-type="iconpicker-item" title=".las la-square-dribbble " class="las la-square-dribbble "></i>
                                    <i data-type="iconpicker-item" title=".las la-square-bluesky " class="las la-square-bluesky "></i>
                                    <i data-type="iconpicker-item" title=".las la-square-behance " class="las la-square-behance "></i>
                                    <i data-type="iconpicker-item" title=".las la-speaker-deck " class="las la-speaker-deck "></i>
                                    <i data-type="iconpicker-item" title=".las la-speakap " class="las la-speakap "></i>
                                    <i data-type="iconpicker-item" title=".las la-space-awesome " class="las la-space-awesome "></i>
                                    <i data-type="iconpicker-item" title=".las la-sourcetree " class="las la-sourcetree "></i>
                                    <i data-type="iconpicker-item" title=".las la-snapchat " class="las la-snapchat "></i>
                                    <i data-type="iconpicker-item" title=".las la-slideshare " class="las la-slideshare "></i>
                                    <i data-type="iconpicker-item" title=".las la-skyatlas " class="las la-skyatlas "></i>
                                    <i data-type="iconpicker-item" title=".las la-sketch " class="las la-sketch "></i>
                                    <i data-type="iconpicker-item" title=".las la-sitrox " class="las la-sitrox "></i>
                                    <i data-type="iconpicker-item" title=".las la-sith " class="las la-sith "></i>
                                    <i data-type="iconpicker-item" title=".las la-sistrix " class="las la-sistrix "></i>
                                    <i data-type="iconpicker-item" title=".las la-simplybuilt " class="las la-simplybuilt "></i>
                                    <i data-type="iconpicker-item" title=".las la-signal-messenger " class="las la-signal-messenger "></i>
                                    <i data-type="iconpicker-item" title=".las la-shopware " class="las la-shopware "></i>
                                    <i data-type="iconpicker-item" title=".las la-shoelace " class="las la-shoelace "></i>
                                    <i data-type="iconpicker-item" title=".las la-shirtsinbulk " class="las la-shirtsinbulk "></i>
                                    <i data-type="iconpicker-item" title=".las la-servicestack " class="las la-servicestack "></i>
                                    <i data-type="iconpicker-item" title=".las la-sellsy " class="las la-sellsy "></i>
                                    <i data-type="iconpicker-item" title=".las la-sellcast " class="las la-sellcast "></i>
                                    <i data-type="iconpicker-item" title=".las la-searchengin " class="las la-searchengin "></i>
                                    <i data-type="iconpicker-item" title=".las la-scribd " class="las la-scribd "></i>
                                    <i data-type="iconpicker-item" title=".las la-screenpal " class="las la-screenpal "></i>
                                    <i data-type="iconpicker-item" title=".las la-schlix " class="las la-schlix "></i>
                                    <i data-type="iconpicker-item" title=".las la-sass " class="las la-sass "></i>
                                    <i data-type="iconpicker-item" title=".las la-safari " class="las la-safari "></i>
                                    <i data-type="iconpicker-item" title=".las la-rust " class="las la-rust "></i>
                                    <i data-type="iconpicker-item" title=".las la-rockrms " class="las la-rockrms "></i>
                                    <i data-type="iconpicker-item" title=".las la-rocketchat " class="las la-rocketchat "></i>
                                    <i data-type="iconpicker-item" title=".las la-rev " class="las la-rev "></i>
                                    <i data-type="iconpicker-item" title=".las la-resolving " class="las la-resolving "></i>
                                    <i data-type="iconpicker-item" title=".las la-researchgate " class="las la-researchgate "></i>
                                    <i data-type="iconpicker-item" title=".las la-replyd " class="las la-replyd "></i>
                                    <i data-type="iconpicker-item" title=".las la-renren " class="las la-renren "></i>
                                    <i data-type="iconpicker-item" title=".las la-redhat " class="las la-redhat "></i>
                                    <i data-type="iconpicker-item" title=".las la-reddit-alien " class="las la-reddit-alien "></i>
                                    <i data-type="iconpicker-item" title=".las la-reddit " class="las la-reddit "></i>
                                    <i data-type="iconpicker-item" title=".las la-red-river " class="las la-red-river "></i>
                                    <i data-type="iconpicker-item" title=".las la-reacteurope " class="las la-reacteurope "></i>
                                    <i data-type="iconpicker-item" title=".las la-ravelry " class="las la-ravelry "></i>
                                    <i data-type="iconpicker-item" title=".las la-raspberry-pi " class="las la-raspberry-pi "></i>
                                    <i data-type="iconpicker-item" title=".las la-r-project " class="las la-r-project "></i>
                                    <i data-type="iconpicker-item" title=".las la-quora " class="las la-quora "></i>
                                    <i data-type="iconpicker-item" title=".las la-quinscape " class="las la-quinscape "></i>
                                    <i data-type="iconpicker-item" title=".las la-qq " class="las la-qq "></i>
                                    <i data-type="iconpicker-item" title=".las la-pushed " class="las la-pushed "></i>
                                    <i data-type="iconpicker-item" title=".las la-pixiv " class="las la-pixiv "></i>
                                    <i data-type="iconpicker-item" title=".las la-pix " class="las la-pix "></i>
                                    <i data-type="iconpicker-item" title=".las la-pinterest-p " class="las la-pinterest-p "></i>
                                    <i data-type="iconpicker-item" title=".las la-pied-piper-pp " class="las la-pied-piper-pp "></i>
                                    <i data-type="iconpicker-item" title=".las la-pied-piper-hat " class="las la-pied-piper-hat "></i>
                                    <i data-type="iconpicker-item" title=".las la-pied-piper-alt " class="las la-pied-piper-alt "></i>
                                    <i data-type="iconpicker-item" title=".las la-php " class="las la-php "></i>
                                    <i data-type="iconpicker-item" title=".las la-phoenix-squadron " class="las la-phoenix-squadron "></i>
                                    <i data-type="iconpicker-item" title=".las la-phoenix-framework " class="las la-phoenix-framework "></i>
                                    <i data-type="iconpicker-item" title=".las la-phabricator " class="las la-phabricator "></i>
                                    <i data-type="iconpicker-item" title=".las la-periscope " class="las la-periscope "></i>
                                    <i data-type="iconpicker-item" title=".las la-perbyte " class="las la-perbyte "></i>
                                    <i data-type="iconpicker-item" title=".las la-patreon " class="las la-patreon "></i>
                                    <i data-type="iconpicker-item" title=".las la-palfed " class="las la-palfed "></i>
                                    <i data-type="iconpicker-item" title=".las la-page4 " class="las la-page4 "></i>
                                    <i data-type="iconpicker-item" title=".las la-padlet " class="las la-padlet "></i>
                                    <i data-type="iconpicker-item" title=".las la-osi " class="las la-osi "></i>
                                    <i data-type="iconpicker-item" title=".las la-orcid " class="las la-orcid "></i>
                                    <i data-type="iconpicker-item" title=".las la-optin-monster " class="las la-optin-monster "></i>
                                    <i data-type="iconpicker-item" title=".las la-opera " class="las la-opera "></i>
                                    <i data-type="iconpicker-item" title=".las la-opensuse " class="las la-opensuse "></i>
                                    <i data-type="iconpicker-item" title=".las la-opencart " class="las la-opencart "></i>
                                    <i data-type="iconpicker-item" title=".las la-old-republic " class="las la-old-republic "></i>
                                    <i data-type="iconpicker-item" title=".las la-odysee " class="las la-odysee "></i>
                                    <i data-type="iconpicker-item" title=".las la-odnoklassniki " class="las la-odnoklassniki "></i>
                                    <i data-type="iconpicker-item" title=".las la-octopus-deploy " class="las la-octopus-deploy "></i>
                                    <i data-type="iconpicker-item" title=".las la-nutritionix " class="las la-nutritionix "></i>
                                    <i data-type="iconpicker-item" title=".las la-ns8 " class="las la-ns8 "></i>
                                    <i data-type="iconpicker-item" title=".las la-npm " class="las la-npm "></i>
                                    <i data-type="iconpicker-item" title=".las la-node-js " class="las la-node-js "></i>
                                    <i data-type="iconpicker-item" title=".las la-nimblr " class="las la-nimblr "></i>
                                    <i data-type="iconpicker-item" title=".las la-nfc-symbol " class="las la-nfc-symbol "></i>
                                    <i data-type="iconpicker-item" title=".las la-nfc-directional " class="las la-nfc-directional "></i>
                                    <i data-type="iconpicker-item" title=".las la-neos " class="las la-neos "></i>
                                    <i data-type="iconpicker-item" title=".las la-napster " class="las la-napster "></i>
                                    <i data-type="iconpicker-item" title=".las la-monero " class="las la-monero "></i>
                                    <i data-type="iconpicker-item" title=".las la-modx " class="las la-modx "></i>
                                    <i data-type="iconpicker-item" title=".las la-mizuni " class="las la-mizuni "></i>
                                    <i data-type="iconpicker-item" title=".las la-mixer " class="las la-mixer "></i>
                                    <i data-type="iconpicker-item" title=".las la-mixcloud " class="las la-mixcloud "></i>
                                    <i data-type="iconpicker-item" title=".las la-mix " class="las la-mix "></i>
                                    <i data-type="iconpicker-item" title=".las la-mintbit " class="las la-mintbit "></i>
                                    <i data-type="iconpicker-item" title=".las la-microblog " class="las la-microblog "></i>
                                    <i data-type="iconpicker-item" title=".las la-meta " class="las la-meta "></i>
                                    <i data-type="iconpicker-item" title=".las la-mendeley " class="las la-mendeley "></i>
                                    <i data-type="iconpicker-item" title=".las la-megaport " class="las la-megaport "></i>
                                    <i data-type="iconpicker-item" title=".las la-medrt " class="las la-medrt "></i>
                                    <i data-type="iconpicker-item" title=".las la-medapps " class="las la-medapps "></i>
                                    <i data-type="iconpicker-item" title=".las la-mdb " class="las la-mdb "></i>
                                    <i data-type="iconpicker-item" title=".las la-maxcdn " class="las la-maxcdn "></i>
                                    <i data-type="iconpicker-item" title=".las la-mastodon " class="las la-mastodon "></i>
                                    <i data-type="iconpicker-item" title=".las la-markdown " class="las la-markdown "></i>
                                    <i data-type="iconpicker-item" title=".las la-mandalorian " class="las la-mandalorian "></i>
                                    <i data-type="iconpicker-item" title=".las la-mailchimp " class="las la-mailchimp "></i>
                                    <i data-type="iconpicker-item" title=".las la-magento " class="las la-magento "></i>
                                    <i data-type="iconpicker-item" title=".las la-lyft " class="las la-lyft "></i>
                                    <i data-type="iconpicker-item" title=".las la-linode " class="las la-linode "></i>
                                    <i data-type="iconpicker-item" title=".las la-linkedin-in " class="las la-linkedin-in "></i>
                                    <i data-type="iconpicker-item" title=".las la-letterboxd " class="las la-letterboxd "></i>
                                    <i data-type="iconpicker-item" title=".las la-less " class="las la-less "></i>
                                    <i data-type="iconpicker-item" title=".las la-leanpub " class="las la-leanpub "></i>
                                    <i data-type="iconpicker-item" title=".las la-lastfm " class="las la-lastfm "></i>
                                    <i data-type="iconpicker-item" title=".las la-laravel " class="las la-laravel "></i>
                                    <i data-type="iconpicker-item" title=".las la-korvue " class="las la-korvue "></i>
                                    <i data-type="iconpicker-item" title=".las la-kickstarter-k " class="las la-kickstarter-k "></i>
                                    <i data-type="iconpicker-item" title=".las la-keycdn " class="las la-keycdn "></i>
                                    <i data-type="iconpicker-item" title=".las la-keybase " class="las la-keybase "></i>
                                    <i data-type="iconpicker-item" title=".las la-kaggle " class="las la-kaggle "></i>
                                    <i data-type="iconpicker-item" title=".las la-jxl " class="las la-jxl "></i>
                                    <i data-type="iconpicker-item" title=".las la-jsfiddle " class="las la-jsfiddle "></i>
                                    <i data-type="iconpicker-item" title=".las la-js " class="las la-js "></i>
                                    <i data-type="iconpicker-item" title=".las la-joomla " class="las la-joomla "></i>
                                    <i data-type="iconpicker-item" title=".las la-joget " class="las la-joget "></i>
                                    <i data-type="iconpicker-item" title=".las la-jira " class="las la-jira "></i>
                                    <i data-type="iconpicker-item" title=".las la-jenkins " class="las la-jenkins "></i>
                                    <i data-type="iconpicker-item" title=".las la-jedi-order " class="las la-jedi-order "></i>
                                    <i data-type="iconpicker-item" title=".las la-itunes-note " class="las la-itunes-note "></i>
                                    <i data-type="iconpicker-item" title=".las la-itunes " class="las la-itunes "></i>
                                    <i data-type="iconpicker-item" title=".las la-itch-io " class="las la-itch-io "></i>
                                    <i data-type="iconpicker-item" title=".las la-ioxhost " class="las la-ioxhost "></i>
                                    <i data-type="iconpicker-item" title=".las la-invision " class="las la-invision "></i>
                                    <i data-type="iconpicker-item" title=".las la-instalod " class="las la-instalod "></i>
                                    <i data-type="iconpicker-item" title=".las la-imdb " class="las la-imdb "></i>
                                    <i data-type="iconpicker-item" title=".las la-hubspot " class="las la-hubspot "></i>
                                    <i data-type="iconpicker-item" title=".las la-houzz " class="las la-houzz "></i>
                                    <i data-type="iconpicker-item" title=".las la-hotjar " class="las la-hotjar "></i>
                                    <i data-type="iconpicker-item" title=".las la-hornbill " class="las la-hornbill "></i>
                                    <i data-type="iconpicker-item" title=".las la-hooli " class="las la-hooli "></i>
                                    <i data-type="iconpicker-item" title=".las la-hive " class="las la-hive "></i>
                                    <i data-type="iconpicker-item" title=".las la-hire-a-helper " class="las la-hire-a-helper "></i>
                                    <i data-type="iconpicker-item" title=".las la-hips " class="las la-hips "></i>
                                    <i data-type="iconpicker-item" title=".las la-hashnode " class="las la-hashnode "></i>
                                    <i data-type="iconpicker-item" title=".las la-hackerrank " class="las la-hackerrank "></i>
                                    <i data-type="iconpicker-item" title=".las la-hacker-news " class="las la-hacker-news "></i>
                                    <i data-type="iconpicker-item" title=".las la-gulp " class="las la-gulp "></i>
                                    <i data-type="iconpicker-item" title=".las la-guilded " class="las la-guilded "></i>
                                    <i data-type="iconpicker-item" title=".las la-grunt " class="las la-grunt "></i>
                                    <i data-type="iconpicker-item" title=".las la-gripfire " class="las la-gripfire "></i>
                                    <i data-type="iconpicker-item" title=".las la-grav " class="las la-grav "></i>
                                    <i data-type="iconpicker-item" title=".las la-gratipay " class="las la-gratipay "></i>
                                    <i data-type="iconpicker-item" title=".las la-google-wallet " class="las la-google-wallet "></i>
                                    <i data-type="iconpicker-item" title=".las la-google-scholar " class="las la-google-scholar "></i>
                                    <i data-type="iconpicker-item" title=".las la-google-plus-g " class="las la-google-plus-g "></i>
                                    <i data-type="iconpicker-item" title=".las la-google-plus " class="las la-google-plus "></i>
                                    <i data-type="iconpicker-item" title=".las la-google-pay " class="las la-google-pay "></i>
                                    <i data-type="iconpicker-item" title=".las la-google-drive " class="las la-google-drive "></i>
                                    <i data-type="iconpicker-item" title=".las la-goodreads " class="las la-goodreads "></i>
                                    <i data-type="iconpicker-item" title=".las la-golang " class="las la-golang "></i>
                                    <i data-type="iconpicker-item" title=".las la-gofore " class="las la-gofore "></i>
                                    <i data-type="iconpicker-item" title=".las la-glide " class="las la-glide "></i>
                                    <i data-type="iconpicker-item" title=".las la-gitter " class="las la-gitter "></i>
                                    <i data-type="iconpicker-item" title=".las la-gitkraken " class="las la-gitkraken "></i>
                                    <i data-type="iconpicker-item" title=".las la-github-alt " class="las la-github-alt "></i>
                                    <i data-type="iconpicker-item" title=".las la-git-alt " class="las la-git-alt "></i>
                                    <i data-type="iconpicker-item" title=".las la-git " class="las la-git "></i>
                                    <i data-type="iconpicker-item" title=".las la-gg-circle " class="las la-gg-circle "></i>
                                    <i data-type="iconpicker-item" title=".las la-gg " class="las la-gg "></i>
                                    <i data-type="iconpicker-item" title=".las la-get-pocket " class="las la-get-pocket "></i>
                                    <i data-type="iconpicker-item" title=".las la-galactic-senate " class="las la-galactic-senate "></i>
                                    <i data-type="iconpicker-item" title=".las la-galactic-republic " class="las la-galactic-republic "></i>
                                    <i data-type="iconpicker-item" title=".las la-fulcrum " class="las la-fulcrum "></i>
                                    <i data-type="iconpicker-item" title=".las la-freebsd " class="las la-freebsd "></i>
                                    <i data-type="iconpicker-item" title=".las la-foursquare " class="las la-foursquare "></i>
                                    <i data-type="iconpicker-item" title=".las la-forumbee " class="las la-forumbee "></i>
                                    <i data-type="iconpicker-item" title=".las la-fort-awesome-alt " class="las la-fort-awesome-alt "></i>
                                    <i data-type="iconpicker-item" title=".las la-fort-awesome " class="las la-fort-awesome "></i>
                                    <i data-type="iconpicker-item" title=".las la-fonticons-fi " class="las la-fonticons-fi "></i>
                                    <i data-type="iconpicker-item" title=".las la-fonticons " class="las la-fonticons "></i>
                                    <i data-type="iconpicker-item" title=".las la-font-awesome " class="las la-font-awesome "></i>
                                    <i data-type="iconpicker-item" title=".las la-flutter " class="las la-flutter "></i>
                                    <i data-type="iconpicker-item" title=".las la-flipboard " class="las la-flipboard "></i>
                                    <i data-type="iconpicker-item" title=".las la-flickr " class="las la-flickr "></i>
                                    <i data-type="iconpicker-item" title=".las la-firstdraft " class="las la-firstdraft "></i>
                                    <i data-type="iconpicker-item" title=".las la-first-order-alt " class="las la-first-order-alt "></i>
                                    <i data-type="iconpicker-item" title=".las la-first-order " class="las la-first-order "></i>
                                    <i data-type="iconpicker-item" title=".las la-firefox-browser " class="las la-firefox-browser "></i>
                                    <i data-type="iconpicker-item" title=".las la-firefox " class="las la-firefox "></i>
                                    <i data-type="iconpicker-item" title=".las la-files-pinwheel " class="las la-files-pinwheel "></i>
                                    <i data-type="iconpicker-item" title=".las la-fedora " class="las la-fedora "></i>
                                    <i data-type="iconpicker-item" title=".las la-fedex " class="las la-fedex "></i>
                                    <i data-type="iconpicker-item" title=".las la-fantasy-flight-games " class="las la-fantasy-flight-games "></i>
                                    <i data-type="iconpicker-item" title=".las la-facebook-f " class="las la-facebook-f "></i>
                                    <i data-type="iconpicker-item" title=".las la-expeditedssl " class="las la-expeditedssl "></i>
                                    <i data-type="iconpicker-item" title=".las la-evernote " class="las la-evernote "></i>
                                    <i data-type="iconpicker-item" title=".las la-ethereum " class="las la-ethereum "></i>
                                    <i data-type="iconpicker-item" title=".las la-erlang " class="las la-erlang "></i>
                                    <i data-type="iconpicker-item" title=".las la-envira " class="las la-envira "></i>
                                    <i data-type="iconpicker-item" title=".las la-empire " class="las la-empire "></i>
                                    <i data-type="iconpicker-item" title=".las la-ember " class="las la-ember "></i>
                                    <i data-type="iconpicker-item" title=".las la-ello " class="las la-ello "></i>
                                    <i data-type="iconpicker-item" title=".las la-edge-legacy " class="las la-edge-legacy "></i>
                                    <i data-type="iconpicker-item" title=".las la-edge " class="las la-edge "></i>
                                    <i data-type="iconpicker-item" title=".las la-ebay " class="las la-ebay "></i>
                                    <i data-type="iconpicker-item" title=".las la-earlybirds " class="las la-earlybirds "></i>
                                    <i data-type="iconpicker-item" title=".las la-dyalog " class="las la-dyalog "></i>
                                    <i data-type="iconpicker-item" title=".las la-drupal " class="las la-drupal "></i>
                                    <i data-type="iconpicker-item" title=".las la-draft2digital " class="las la-draft2digital "></i>
                                    <i data-type="iconpicker-item" title=".las la-dochub " class="las la-dochub "></i>
                                    <i data-type="iconpicker-item" title=".las la-digital-ocean " class="las la-digital-ocean "></i>
                                    <i data-type="iconpicker-item" title=".las la-digg " class="las la-digg "></i>
                                    <i data-type="iconpicker-item" title=".las la-diaspora " class="las la-diaspora "></i>
                                    <i data-type="iconpicker-item" title=".las la-dhl " class="las la-dhl "></i>
                                    <i data-type="iconpicker-item" title=".las la-deviantart " class="las la-deviantart "></i>
                                    <i data-type="iconpicker-item" title=".las la-dev " class="las la-dev "></i>
                                    <i data-type="iconpicker-item" title=".las la-deskpro " class="las la-deskpro "></i>
                                    <i data-type="iconpicker-item" title=".las la-deploydog " class="las la-deploydog "></i>
                                    <i data-type="iconpicker-item" title=".las la-delicious " class="las la-delicious "></i>
                                    <i data-type="iconpicker-item" title=".las la-deezer " class="las la-deezer "></i>
                                    <i data-type="iconpicker-item" title=".las la-debian " class="las la-debian "></i>
                                    <i data-type="iconpicker-item" title=".las la-dart-lang " class="las la-dart-lang "></i>
                                    <i data-type="iconpicker-item" title=".las la-dailymotion " class="las la-dailymotion "></i>
                                    <i data-type="iconpicker-item" title=".las la-d-and-d-beyond " class="las la-d-and-d-beyond "></i>
                                    <i data-type="iconpicker-item" title=".las la-d-and-d " class="las la-d-and-d "></i>
                                    <i data-type="iconpicker-item" title=".las la-cuttlefish " class="las la-cuttlefish "></i>
                                    <i data-type="iconpicker-item" title=".las la-css3-alt " class="las la-css3-alt "></i>
                                    <i data-type="iconpicker-item" title=".las la-css3 " class="las la-css3 "></i>
                                    <i data-type="iconpicker-item" title=".las la-css " class="las la-css "></i>
                                    <i data-type="iconpicker-item" title=".las la-critical-role " class="las la-critical-role "></i>
                                    <i data-type="iconpicker-item" title=".las la-creative-commons-zero " class="las la-creative-commons-zero "></i>
                                    <i data-type="iconpicker-item" title=".las la-creative-commons-share " class="las la-creative-commons-share "></i>
                                    <i data-type="iconpicker-item" title=".las la-creative-commons-sampling-plus " class="las la-creative-commons-sampling-plus "></i>
                                    <i data-type="iconpicker-item" title=".las la-creative-commons-sampling " class="las la-creative-commons-sampling "></i>
                                    <i data-type="iconpicker-item" title=".las la-creative-commons-sa " class="las la-creative-commons-sa "></i>
                                    <i data-type="iconpicker-item" title=".las la-creative-commons-remix " class="las la-creative-commons-remix "></i>
                                    <i data-type="iconpicker-item" title=".las la-creative-commons-pd-alt " class="las la-creative-commons-pd-alt "></i>
                                    <i data-type="iconpicker-item" title=".las la-creative-commons-pd " class="las la-creative-commons-pd "></i>
                                    <i data-type="iconpicker-item" title=".las la-creative-commons-nd " class="las la-creative-commons-nd "></i>
                                    <i data-type="iconpicker-item" title=".las la-creative-commons-nc-jp " class="las la-creative-commons-nc-jp "></i>
                                    <i data-type="iconpicker-item" title=".las la-creative-commons-nc-eu " class="las la-creative-commons-nc-eu "></i>
                                    <i data-type="iconpicker-item" title=".las la-creative-commons-nc " class="las la-creative-commons-nc "></i>
                                    <i data-type="iconpicker-item" title=".las la-creative-commons-by " class="las la-creative-commons-by "></i>
                                    <i data-type="iconpicker-item" title=".las la-creative-commons " class="las la-creative-commons "></i>
                                    <i data-type="iconpicker-item" title=".las la-cpanel " class="las la-cpanel "></i>
                                    <i data-type="iconpicker-item" title=".las la-cotton-bureau " class="las la-cotton-bureau "></i>
                                    <i data-type="iconpicker-item" title=".las la-contao " class="las la-contao "></i>
                                    <i data-type="iconpicker-item" title=".las la-connectdevelop " class="las la-connectdevelop "></i>
                                    <i data-type="iconpicker-item" title=".las la-confluence " class="las la-confluence "></i>
                                    <i data-type="iconpicker-item" title=".las la-codiepie " class="las la-codiepie "></i>
                                    <i data-type="iconpicker-item" title=".las la-cmplid " class="las la-cmplid "></i>
                                    <i data-type="iconpicker-item" title=".las la-cloudversify " class="las la-cloudversify "></i>
                                    <i data-type="iconpicker-item" title=".las la-cloudsmith " class="las la-cloudsmith "></i>
                                    <i data-type="iconpicker-item" title=".las la-cloudscale " class="las la-cloudscale "></i>
                                    <i data-type="iconpicker-item" title=".las la-chromecast " class="las la-chromecast "></i>
                                    <i data-type="iconpicker-item" title=".las la-chrome " class="las la-chrome "></i>
                                    <i data-type="iconpicker-item" title=".las la-centos " class="las la-centos "></i>
                                    <i data-type="iconpicker-item" title=".las la-centercode " class="las la-centercode "></i>
                                    <i data-type="iconpicker-item" title=".las la-cc-stripe " class="las la-cc-stripe "></i>
                                    <i data-type="iconpicker-item" title=".las la-cc-paypal " class="las la-cc-paypal "></i>
                                    <i data-type="iconpicker-item" title=".las la-cc-jcb " class="las la-cc-jcb "></i>
                                    <i data-type="iconpicker-item" title=".las la-cc-discover " class="las la-cc-discover "></i>
                                    <i data-type="iconpicker-item" title=".las la-cc-diners-club " class="las la-cc-diners-club "></i>
                                    <i data-type="iconpicker-item" title=".las la-cc-apple-pay " class="las la-cc-apple-pay "></i>
                                    <i data-type="iconpicker-item" title=".las la-cc-amex " class="las la-cc-amex "></i>
                                    <i data-type="iconpicker-item" title=".las la-cc-amazon-pay " class="las la-cc-amazon-pay "></i>
                                    <i data-type="iconpicker-item" title=".las la-canadian-maple-leaf " class="las la-canadian-maple-leaf "></i>
                                    <i data-type="iconpicker-item" title=".las la-buysellads " class="las la-buysellads "></i>
                                    <i data-type="iconpicker-item" title=".las la-buy-n-large " class="las la-buy-n-large "></i>
                                    <i data-type="iconpicker-item" title=".las la-buromobelexperte " class="las la-buromobelexperte "></i>
                                    <i data-type="iconpicker-item" title=".las la-buffer " class="las la-buffer "></i>
                                    <i data-type="iconpicker-item" title=".las la-btc " class="las la-btc "></i>
                                    <i data-type="iconpicker-item" title=".las la-brave-reverse " class="las la-brave-reverse "></i>
                                    <i data-type="iconpicker-item" title=".las la-brave " class="las la-brave "></i>
                                    <i data-type="iconpicker-item" title=".las la-bots " class="las la-bots "></i>
                                    <i data-type="iconpicker-item" title=".las la-bootstrap " class="las la-bootstrap "></i>
                                    <i data-type="iconpicker-item" title=".las la-bluetooth-b " class="las la-bluetooth-b "></i>
                                    <i data-type="iconpicker-item" title=".las la-bluetooth " class="las la-bluetooth "></i>
                                    <i data-type="iconpicker-item" title=".las la-bluesky " class="las la-bluesky "></i>
                                    <i data-type="iconpicker-item" title=".las la-blogger-b " class="las la-blogger-b "></i>
                                    <i data-type="iconpicker-item" title=".las la-blogger " class="las la-blogger "></i>
                                    <i data-type="iconpicker-item" title=".las la-blackberry " class="las la-blackberry "></i>
                                    <i data-type="iconpicker-item" title=".las la-black-tie " class="las la-black-tie "></i>
                                    <i data-type="iconpicker-item" title=".las la-bity " class="las la-bity "></i>
                                    <i data-type="iconpicker-item" title=".las la-bitcoin " class="las la-bitcoin "></i>
                                    <i data-type="iconpicker-item" title=".las la-bitbucket " class="las la-bitbucket "></i>
                                    <i data-type="iconpicker-item" title=".las la-bimobject " class="las la-bimobject "></i>
                                    <i data-type="iconpicker-item" title=".las la-bilibili " class="las la-bilibili "></i>
                                    <i data-type="iconpicker-item" title=".las la-battle-net " class="las la-battle-net "></i>
                                    <i data-type="iconpicker-item" title=".las la-bandcamp " class="las la-bandcamp "></i>
                                    <i data-type="iconpicker-item" title=".las la-aws " class="las la-aws "></i>
                                    <i data-type="iconpicker-item" title=".las la-aviato " class="las la-aviato "></i>
                                    <i data-type="iconpicker-item" title=".las la-avianex " class="las la-avianex "></i>
                                    <i data-type="iconpicker-item" title=".las la-autoprefixer " class="las la-autoprefixer "></i>
                                    <i data-type="iconpicker-item" title=".las la-audible " class="las la-audible "></i>
                                    <i data-type="iconpicker-item" title=".las la-asymmetrik " class="las la-asymmetrik "></i>
                                    <i data-type="iconpicker-item" title=".las la-artstation " class="las la-artstation "></i>
                                    <i data-type="iconpicker-item" title=".las la-apple-pay " class="las la-apple-pay "></i>
                                    <i data-type="iconpicker-item" title=".las la-apper " class="las la-apper "></i>
                                    <i data-type="iconpicker-item" title=".las la-app-store-ios " class="las la-app-store-ios "></i>
                                    <i data-type="iconpicker-item" title=".las la-app-store " class="las la-app-store "></i>
                                    <i data-type="iconpicker-item" title=".las la-angular " class="las la-angular "></i>
                                    <i data-type="iconpicker-item" title=".las la-angrycreative " class="las la-angrycreative "></i>
                                    <i data-type="iconpicker-item" title=".las la-angellist " class="las la-angellist "></i>
                                    <i data-type="iconpicker-item" title=".las la-amilia " class="las la-amilia "></i>
                                    <i data-type="iconpicker-item" title=".las la-amazon-pay " class="las la-amazon-pay "></i>
                                    <i data-type="iconpicker-item" title=".las la-alipay " class="las la-alipay "></i>
                                    <i data-type="iconpicker-item" title=".las la-affiliatetheme " class="las la-affiliatetheme "></i>
                                    <i data-type="iconpicker-item" title=".las la-adversal " class="las la-adversal "></i>
                                    <i data-type="iconpicker-item" title=".las la-adn " class="las la-adn "></i>
                                    <i data-type="iconpicker-item" title=".las la-accusoft " class="las la-accusoft "></i>
                                    <i data-type="iconpicker-item" title=".las la-500px " class="las la-500px "></i>
                                    <i data-type="iconpicker-item" title=".las la-42-group " class="las la-42-group "></i>
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
    if (function_exists('tech888f_reg_widget'))
        tech888f_reg_widget('tech888f_SocialIconsWidget2');
}
?>