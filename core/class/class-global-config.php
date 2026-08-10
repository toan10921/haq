<?php
/**
 * Created by Visual Studio Code.
 * User: toanngo92
 * Date: 2/2/2019
 * Time: 7:33 PM
 */

namespace T888Core;

/**
 * Class GlobalConfig
 *
 * Singleton class to manage global configuration.
 *
 * @package T888Core
 */
class GlobalConfig
{
    /**
     * @var GlobalConfig|null The single instance of the class.
     */
    private static $instance = null;

    /**
     * @var array The global configuration array.
     */
    public static $global_config;

    /**
     * GlobalConfig constructor.
     * Private to prevent direct instantiation.
     */
    private function __construct()
    {
        $this->init();
    }

    /**
     * Get the single instance of the class.
     *
     * @return GlobalConfig The single instance of the class.
     */
    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new GlobalConfig();
        }
        return self::$instance;
    }

    /**
     * Initialize the global configuration.
     *
     * @return void
     */
    private function init()
    {
        $global_config = array(
            'require-plugin' => array(
                array(
                    'name'      => 't888-helper',
                    'slug'      => 't888-helper',
                    'source'    => get_template_directory() . '/core/plugins/t888-helper.zip',
                    'required'  => true,
                    'version'   => '1.0.0',
                    'force_activation'   => false,
                    'force_deactivation' => false,
                    'external_url'       => '',
                ),
                // woocommerce
                array(
                    'name'      => 'woocommerce',
                    'slug'      => 'woocommerce',
                    'required'  => true,
                    'version'   => '3.5.4',
                    'force_activation'   => false,
                    'force_deactivation' => false,
                    'external_url'       => '',
                ),
                // elementor
                array(
                    'name'      => 'elementor',
                    'slug'      => 'elementor',
                    'required'  => true,
                    'version'   => '2.4.6',
                    'force_activation'   => false,
                    'force_deactivation' => false,
                    'external_url'       => '',
                ),

                // contact form 7
                array(
                    'name'      => 'contact-form-7',
                    'slug'      => 'contact-form-7',
                    'required'  => true,
                    'version'   => '5.0.5',
                    'force_activation'   => false,
                    'force_deactivation' => false,
                    'external_url'       => '',
                ),

                // YITH WooCommerce Wishlist
                array(
                    'name'      => 'yith-woocommerce-wishlist',
                    'slug'      => 'yith-woocommerce-wishlist',
                    'required'  => true,
                    'version'   => '4.1.0',
                    'force_activation'   => false,
                    'force_deactivation' => false,
                    'external_url'       => '',
                ),
                // YITH WooCommerce Compare
                array(
                    'name'      => 'yith-woocommerce-compare',
                    'slug'      => 'yith-woocommerce-compare',
                    'required'  => true,
                    'version'   => '2.47.0',
                    'force_activation'   => false,
                    'force_deactivation' => false,
                    'external_url'       => '',
                ),
                // mailchimp for wordpress
                array(
                    'name'      => 'mailchimp-for-wp',
                    'slug'      => 'mailchimp-for-wp',
                    'required'  => true,
                    'version'   => '4.8.2',
                    'force_activation'   => false,
                    'force_deactivation' => false,
                    'external_url'       => '',
                ),
                array(
                    'name'      => 'slider-revolution',
                    'slug'      => 'slider-revolution',
                    'source'    => get_template_directory() . '/core/plugins/slider-revolution.zip',
                    'required'  => true,
                    'version'   => '1.0.0',
                    'force_activation'   => false,
                    'force_deactivation' => false,
                    'external_url'       => '',
                ),
            ),
            'require-plugin-begin' => array(
                array(
                    'name'      => 't888-helper',
                    'slug'      => 't888-helper',
                    'source'    => get_template_directory() . '/core/plugins/t888-helper.zip',
                    'required'  => true,
                    'version'   => '1.0.0',
                    'force_activation'   => false,
                    'force_deactivation' => false,
                    'external_url'       => '',
                ),
                array(
                    'name'      => 'slider-revolution',
                    'slug'      => 'slider-revolution',
                    'source'    => get_template_directory() . '/core/plugins/slider-revolution.zip',
                    'required'  => true,
                    'version'   => '1.0.0',
                    'force_activation'   => false,
                    'force_deactivation' => false,
                    'external_url'       => '',
                ),
                array(
                    'name'      => 'elementor',
                    'slug'      => 'elementor',
                    'required'  => true,
                    'version'   => '2.4.6',
                    'force_activation'   => false,
                    'force_deactivation' => false,
                    'external_url'       => '',
                ),
                array(
                    'name'      => 'woocommerce',
                    'slug'      => 'woocommerce',
                    'required'  => true,
                    'version'   => '3.5.4',
                    'force_activation'   => false,
                    'force_deactivation' => false,
                    'external_url'       => '',
                ),
                 // metabox
                 array(
                    'name'      => 'meta-box',
                    'slug'      => 'meta-box',
                    'required'  => true,
                    'version'   => '4.15.8',
                    'force_activation'   => false,
                    'force_deactivation' => false,
                    'external_url'       => '',
                ),

                // contact form 7
                array(
                    'name'      => 'contact-form-7',
                    'slug'      => 'contact-form-7',
                    'required'  => true,
                    'version'   => '5.0.5',
                    'force_activation'   => false,
                    'force_deactivation' => false,
                    'external_url'       => '',
                ),

                // YITH WooCommerce Wishlist
                array(
                    'name'      => 'yith-woocommerce-wishlist',
                    'slug'      => 'yith-woocommerce-wishlist',
                    'required'  => true,
                    'version'   => '4.1.0',
                    'force_activation'   => false,
                    'force_deactivation' => false,
                    'external_url'       => '',
                ),
                // YITH WooCommerce Compare
                array(
                    'name'      => 'yith-woocommerce-compare',
                    'slug'      => 'yith-woocommerce-compare',
                    'required'  => true,
                    'version'   => '2.47.0',
                    'force_activation'   => false,
                    'force_deactivation' => false,
                    'external_url'       => '',
                ),
                // mailchimp for wordpress
                array(
                    'name'      => 'mailchimp-for-wp',
                    'slug'      => 'mailchimp-for-wp',
                    'required'  => true,
                    'version'   => '4.8.2',
                    'force_activation'   => false,
                    'force_deactivation' => false,
                    'external_url'       => '',
                ),
            )
        );
        self::$global_config = $global_config;
    }
}

// Initialize the singleton instance
GlobalConfig::getInstance();