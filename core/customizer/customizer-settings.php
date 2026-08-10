<?php

namespace T888Core;

use T888Core\WP_Customize_Alpha_Color_Control;
use WP_Customize_Upload_Control;
use WP_Customize_Color_Control;
use  WP_Customize_Media_Control;

use T888Core\BlogPostTrait;
use T888Core\ShopProductTrait;

/**
 * Class Customizer_Settings
 * 
 * Singleton class to manage customizer settings.
 */
if (! function_exists('t888_register_typo_group')) {
    function t888_register_typo_group($wp_customize, $area, $heading, $section)
    {
        $id = "{$area}_{$heading}";

        $is_default_mode = function ($src) {
            return !in_array($src, ['custom_font', 'upload_font'], true);
        };

        $wp_customize->add_setting("{$id}_font_source", [
            'default' => 'Philosopher',
            'transport' => 'refresh',
            'sanitize_callback' => function ($val) {
                $val = sanitize_text_field($val);
                if ($val === 'custom') return 'custom_font';
                if ($val === 'upload') return 'upload_font';
                return $val !== '' ? $val : 'Philosopher';
            },
        ]);

        $wp_customize->add_control("{$id}_font_source", [
            'label' => sprintf(__('Font Source (%s / %s)', 'nebon'), ucfirst($area), strtoupper($heading)),
            'section' => $section,
            'type' => 'radio',
            'choices' => [
                'Philosopher' => __('Standard Font of Theme', 'nebon'),
                'custom_font' => __('Google Font', 'nebon'),
                'upload_font' => __('Your Uploaded Font', 'nebon'),
            ],
        ]);

        $wp_customize->add_setting("{$id}_google_font", [
            'default' => 'Philosopher',
            'transport' => 'refresh',
            'sanitize_callback' => function ($val) {
                $list = array_keys(t888_get_google_fonts_list());
                return in_array($val, $list, true) ? $val : 'Philosopher';
            },
        ]);
        $wp_customize->add_control("{$id}_google_font", [
            'label' => __('Select Google Font', 'nebon'),
            'section' => $section,
            'type' => 'select',
            'choices' => t888_get_google_fonts_list(),
            'active_callback' => function () use ($area, $heading, $is_default_mode) {
                $src = get_theme_mod("{$area}_{$heading}_font_source", 'Philosopher');
                return $src === 'custom_font';
            },
        ]);

        $wp_customize->add_setting("{$id}_weight", [
            'default' => 'bold700',
            'transport' => 'refresh',
            'sanitize_callback' => 'sanitize_text_field',
        ]);
        $wp_customize->add_control("{$id}_weight", [
            'label' => __('Font Weight & Style', 'nebon'),
            'section' => $section,
            'type' => 'select',
            'choices' => [
                'normal400'        => __('Normal 400', 'nebon'),
                'bold700'          => __('Bold 700', 'nebon'),
                'normal_italic400' => __('Normal Italic 400', 'nebon'),
                'bold_italic700'   => __('Bold Italic 700', 'nebon'),
            ],
            'active_callback' => function () use ($area, $heading, $is_default_mode) {
                $src = get_theme_mod("{$area}_{$heading}_font_source", 'Philosopher');
                return $is_default_mode($src) || $src === 'custom_font';
            },
        ]);

        $wp_customize->add_setting("{$id}_uploaded_font", [
            'default' => '',
            'transport' => 'refresh',
            'sanitize_callback' => function ($val) {
                $choices = array_keys(t888_get_uploaded_font_choices());
                return in_array($val, $choices, true) ? $val : '';
            },
        ]);
        $wp_customize->add_control("{$id}_uploaded_font", [
            'label' => __('Select Your Uploaded Font', 'nebon'),
            'section' => $section,
            'type' => 'select',
            'choices' => t888_get_uploaded_font_choices(),
            'active_callback' => function () use ($area, $heading) {
                return get_theme_mod("{$area}_{$heading}_font_source", 'Philosopher') === 'upload_font';
            },
        ]);

        $wp_customize->add_setting("{$id}_align", [
            'default' => '',
            'transport' => 'refresh',
            'sanitize_callback' => 'sanitize_text_field',
        ]);
        $wp_customize->add_control("{$id}_align", [
            'label' => __('Text Align', 'nebon'),
            'section' => $section,
            'type' => 'select',
            'choices' => [
                ''        => __('Inherit', 'nebon'),
                'left'    => 'Left',
                'center'  => 'Center',
                'right'   => 'Right',
                'justify' => 'Justify',
            ],
        ]);

        $wp_customize->add_setting("{$id}_size", [
            'default' => 0,
            'transport' => 'refresh',
            'sanitize_callback' => 'absint',
        ]);
        $wp_customize->add_control("{$id}_size", [
            'label' => __('Font Size (px)', 'nebon'),
            'section' => $section,
            'type' => 'number',
        ]);

        $wp_customize->add_setting("{$id}_line_height", [
            'default' => 0,
            'transport' => 'refresh',
            'sanitize_callback' => 'absint',
        ]);
        $wp_customize->add_control("{$id}_line_height", [
            'label' => __('Line Height (px)', 'nebon'),
            'section' => $section,
            'type' => 'number',
        ]);

        $wp_customize->add_setting("{$id}_color", [
            'default' => '',
            'transport' => 'refresh',
            'sanitize_callback' => 'sanitize_hex_color',
        ]);
        $wp_customize->add_control(new WP_Customize_Color_Control(
            $wp_customize,
            "{$id}_color",
            ['label' => __('Font Color', 'nebon'), 'section' => $section]
        ));
    }
}


class Customizer_Settings
{

    use BlogPostTrait;
    use ShopProductTrait;
    /**
     * @var Customizer_Settings|null The single instance of the class.
     */
    private static $instance = null;

    /**
     * Private constructor to prevent multiple instances.
     */
    private function __construct()
    {
        // register scripts control
        add_action('customize_controls_enqueue_scripts', array($this, 't888f_customize_controls_js'));
        // register scripts preview
        add_action('customize_preview_init', array($this, 't888f_customize_preview_js'));
        add_action('customize_register', array($this, 't888f_customize_register'));
        add_action('customize_controls_enqueue_scripts', array($this, 'disable_customizer_sticky_title'));
    }

    public function get_single_product_style()
    {
        $list = array(
            'default' => esc_html__('Default', 'nebon'),
            'style2' => esc_html__('Product single 2', 'nebon'),
        );

        return $list;
    }


    /**
     * Get the single instance of the class.
     * 
     * @return Customizer_Settings The single instance of the class.
     */
    public static function get_instance()
    {
        if (self::$instance == null) {
            self::$instance = new Customizer_Settings();
        }
        return self::$instance;
    }

    // add js to customizer (left panel - control panel)
    public function t888f_customize_controls_js()
    {
        wp_enqueue_script(
            't888f-customizer',
            get_template_directory_uri() . '/assets/js/customizer.js',
            array('jquery', 'customize-preview'),
            null,
            true
        );

        // Get the default category ID
        $default_category_id = get_option('default_category');

        $default_category_url = get_category_link($default_category_id);

        wp_localize_script('t888f-customizer', 'global_var', array('url' => home_url(), 'default_category' => $default_category_url));
    }

    // add js to live site update (right panel - preview panel)
    public function t888f_customize_preview_js()
    {

        wp_register_script(
            't888f-customizer-preview',
            get_template_directory_uri() . '/assets/js/customizer-preview.js',
            array('jquery', 'customize-preview'),
            ASSETS_VER,
        );

        wp_enqueue_script('t888f-customizer-preview');
    }

    public function disable_customizer_sticky_title()
    {
        // fix sticky title in customizer
        wp_add_inline_style(
            'customize-controls',
            '.customize-section-title { position: abosolute !important; left: 0px !important; top: 0px !important; }'
        );
    }

    public function get_sidebar_widgets()
    {
        $sidebars_widgets = wp_get_sidebars_widgets();
        $ids = array_keys($sidebars_widgets);

        $ids = array_diff($ids, ['wp_inactive_widgets']);

        $assoc = !empty($ids) ? array_combine($ids, $ids) : [];
        return ['choose_one' => esc_html__('Choose One', 'nebon')] + $assoc;
    }
    public function sanitize_sidebar_choice($val)
    {
        $choices = $this->get_sidebar_widgets();

        if (is_string($val) && ctype_digit($val)) {
            $keys = array_keys($choices);        // ['choose_one','blog-sidebar','woocommerce-sidebar',...]
            $idx  = (int) $val;
            if (isset($keys[$idx])) $val = $keys[$idx];
        }

        if (!array_key_exists($val, $choices)) {
            $val = 'choose_one';
        }
        return $val;
    }

    public function get_product_grid_style($style = 'element')
    {
        $list = apply_filters('tech888f_product_grid_item_style', array(
            '' => esc_html__('Default', 'nebon'),
            // 'style2' =>  esc_html__('Product grid 2', 'nebon'),
        ));

        return $list;
    }


    public function get_product_list_style($style = 'element')
    {
        $list = apply_filters('tech888f_product_list_item_style', array(
            '' => esc_html__('Default', 'nebon'),
            // 'style2' =>  esc_html__('Product list 2', 'nebon'),
        ));

        return $list;
    }

    public function get_post_style()
    {
        $list = apply_filters('tech888f_post_item_style', array(
            'default' => esc_html__('Default - Post Related', 'nebon'),
            'style2' => esc_html__('Post style 2 - Post list', 'nebon'),
            'style3' => esc_html__('Post grid 3', 'nebon'),
        ));

        return $list;
    }

    /**
     * Callback function to check if the primary setting is enabled.
     * 
     * @param WP_Customize_Control $control The control object.
     * @param string $option_name The name of the option to check.
     * @return bool True if the setting is enabled, false otherwise.
     */
    static public function check_field_condition($control, $option_name)
    {
        // write log

        if (!$control instanceof \WP_Customize_Control) {
            return false;
        }

        if (!$control->manager instanceof \WP_Customize_Manager) {
            return false;
        }
        return !$control->manager->get_setting($option_name)->value() ? false : true;
    }

    /**
     * Callback function to check if the primary setting is enabled and value matches.
     * 
     * @param WP_Customize_Control $control The control object.
     * @param string $option_name The name of the option to check.
     * @param array|string $value The value to match.
     * @return bool True if the setting is enabled and value matches, false otherwise.
     */
    static public function check_field_condition_value($control, $option_name, $value)
    {
        if (!$control instanceof \WP_Customize_Control) {
            return false;
        }

        if (!$control->manager instanceof \WP_Customize_Manager) {
            return false;
        }

        if (is_array($value)) {
            return in_array($control->manager->get_setting($option_name)->value(), $value) ? true : false;
        }

        if (is_string($value)) {
            return $control->manager->get_setting($option_name)->value() == $value ? true : false;
        }
    }


    public function add_header_settings($wp_customize)
    {
        $wp_customize->add_setting('header_page', array(
            'default' => '',
            'sanitize_callback' => 'absint',
            'transport' => 'refresh',
        ));
        $wp_customize->add_control('header_page', array(
            'label' => __('Header Page', 'nebon'),
            'section' => 'header_section',
            'type' => 'select',
            'choices' => self::_tech888f_list_post_type('header_item', false),
        ));
    }

    public function add_footer_settings($wp_customize)
    {
        $wp_customize->add_setting('footer_page', array(
            'default' => '',
            'sanitize_callback' => 'absint',
            'transport' => 'refresh',
        ));
        $wp_customize->add_control('footer_page', array(
            'label' => __('Footer Page', 'nebon'),
            'section' => 'footer_section',
            'type' => 'select',
            'choices' => self::_tech888f_list_post_type('footer_item', false),
        ));
    }

    public function add_panels($wp_customize)
    {
        $panels = array(
            'basic_setting_panel' => array(
                'title' => __('Basic Settings', 'nebon'),
                'priority' => 160,
            ),
            'blog_post_panel' => array(
                'title' => __('Blog & Post Settings', 'nebon'),
                'priority' => 161,
            ),
            'shop_panel' => array(
                'title' => __('Shop Settings', 'nebon'),
                'priority' => 240,
            ),
            'product_panel' => array(
                'title' => __('Product Settings', 'nebon'),
                'priority' => 250,
            ),
        );

        foreach ($panels as $panel_id => $panel) {
            $wp_customize->add_panel($panel_id, $panel);
        }
    }

    public function add_sections($wp_customize)
    {
        $sections = array(
            // header section same level with panel because do not have parent panel
            'header_section' => array(
                'title' => __('Customize Header', 'nebon'),
                'description' => 'Customize header section',
                'priority' => 100,
            ),
            // footer section same level with panel because do not have parent panel
            'footer_section' => array(
                'title' => __('Customize Footer', 'nebon'),
                'description' => 'Customize footer section',
                'priority' => 101,
            ),
            'other_section' => array(
                'title' => __('Other Settings', 'nebon'),
                'panel' => 'basic_setting_panel',
                'priority' => 164,
            ),
            'breadcumb' => array(
                'title' => __('Breadcumb', 'nebon'),
                'panel' => 'basic_setting_panel',
                'priority' => 163,
            ),
            'Support' => array(
                'title' => __('Support', 'nebon'),
                'panel' => 'basic_setting_panel',
                'priority' => 162,
            ),
            'menu_setting' => array(
                'title' => __('Menu Setting', 'nebon'),
                'panel' => 'basic_setting_panel',
                'priority' => 162,
            ),
            'typography_section' => array(
                'title' => __('Typography', 'nebon'),
                'panel' => 'basic_setting_panel',
                'priority' => 160,
            ),
            'typography_body_section' => array(
                'title'    => __('Typography — Body (Global)', 'nebon'),
                'panel'    => 'basic_setting_panel',
                'priority' => 160,
            ),
            'typography_main_content_section' => array(
                'title'    => __('Typography — Main Content', 'nebon'),
                'panel'    => 'basic_setting_panel',
                'priority' => 160,
            ),
            'typography_widget_section' => array(
                'title'    => __('Typography — Widget', 'nebon'),
                'panel'    => 'basic_setting_panel',
                'priority' => 160,
            ),
            'layout_section' => array(
                'title' => __('Layout', 'nebon'),
                'panel' => 'basic_setting_panel',
            ),
            'upload_font_custom_section' => array(
                'title' => __('Upload Font', 'nebon'),
                'panel' => 'basic_setting_panel',
                'priority' => 165,
            ),
            'blog_post' => array(
                'title' => __('Blog General Settings', 'nebon'),
                'panel' => 'blog_post_panel',
                'priority' => 160,
            ),
            'blog_post_list_section' => array(
                'title' => __('List Settings', 'nebon'),
                'panel' => 'blog_post_panel',
                'priority' => 161,
            ),
            'blog_post_grid_section' => array(
                'title' => __('Grid Settings', 'nebon'),
                'panel' => 'blog_post_panel',
                'priority' => 162,
            ),
            'post_detail_section' => array(
                'title' => __('Post Detail Settings', 'nebon'),
                'panel' => 'blog_post_panel',
                'priority' => 163,
            ),
            'setting_general_shop_section' => array(
                'title' => __('General Setting Shop', 'nebon'),
                'panel' => 'shop_panel',
                'priority' => 165,
            ),
            'list_settings_shop_section' => array(
                'title' => __('List Settings', 'nebon'),
                'panel' => 'shop_panel',
                'priority' => 166,
            ),
            'grid_settings_shop_section' => array(
                'title' => __('Grid Settings', 'nebon'),
                'panel' => 'shop_panel',
                'priority' => 167,
            ),
            'advanced_settings_shop_section' => array(
                'title' => __('Advanced Settings', 'nebon'),
                'panel' => 'shop_panel',
                'priority' => 168,
            ),
            'product_setting_general' => array(
                'title' => __('General', 'nebon'),
                'panel' => 'product_panel',
                'priority' => 161,
            ),
            'product_setting_extra_display' => array(
                'title' => __('Extra Display', 'nebon'),
                'panel' => 'product_panel',
                'priority' => 162,
            ),
            'product_setting_advanced' => array(
                'title' => __('Advanced', 'nebon'),
                'panel' => 'product_panel',
                'priority' => 163,
            ),

        );

        foreach ($sections as $section_id => $section) {
            $wp_customize->add_section($section_id, $section);
        }
    }

    public function add_typography_settings($wp_customize)
    {
        $areas = [
            'body'         => 'typography_body_section',
            'main_content' => 'typography_main_content_section',
            'widgets'       => 'typography_widget_section',
        ];
        $heads = ['h1', 'h2', 'h3', 'h4', 'h5', 'h6'];

        foreach ($areas as $area_key => $section_id) {
            foreach ($heads as $h) {
                t888_register_typo_group($wp_customize, $area_key, $h, $section_id);
            }
        }
    }


    public function add_layout_settings($wp_customize)
    {
        $wp_customize->add_setting('sidebar_page', array(
            'transport' => 'refresh',
            'default' => 'no_sidebar',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control('sidebar_page', array(
            'label' => __('Sidebar Page default', 'nebon'),
            'description' => __('Set sidebar position for your default page. Left, Right, or No sidebar.', 'nebon'),
            'type' => 'select',
            'choices' => array(
                'no_sidebar' => __('No Sidebar', 'nebon'),
                'left_sidebar' => __('Left Sidebar', 'nebon'),
                'right_sidebar' => __('Right Sidebar', 'nebon'),
            ),
            'section' => 'layout_section',
        ));

        $wp_customize->add_setting('sidebar_select_display_in_page', array(
            'transport' => 'refresh',
            'default' => 'no',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control('sidebar_select_display_in_page', array(
            'label' => __('Sidebar select display in page', 'nebon'),
            'description' => __('Choose a sidebar to display.', 'nebon'),
            'type' => 'select',
            'choices' => $this->get_sidebar_widgets(),
            'section' => 'layout_section',
            'active_callback' => function ($control) {
                return $control->manager->get_setting('sidebar_page')->value() !== 'no_sidebar';
            },
        ));

        // $wp_customize->add_setting('sidebar_position_on_search_page', array(
        //     'transport' => 'refresh',
        //     'default' => 'no_sidebar',
        //     'sanitize_callback' => 'sanitize_text_field', // ← THÊM
        // ));
        // $wp_customize->add_control('sidebar_position_on_search_page', array(
        //     'label' => __('Sidebar Position on search page:', 'nebon'),
        //     'description' => __('Set sidebar position for your search page. Left, Right, or No sidebar.', 'nebon'),
        //     'type' => 'select',
        //     'choices' => array(
        //         'no_sidebar' => __('No Sidebar', 'nebon'),
        //         'left_sidebar' => __('Left', 'nebon'),
        //         'right_sidebar' => __('Right', 'nebon'),
        //     ),
        //     'section' => 'layout_section',
        // ));

        // $wp_customize->add_setting('sidebar_select_display_on_search_page', array(
        //     'transport' => 'refresh',
        //     'default' => 'choose_one',
        //     'sanitize_callback' => 'sanitize_text_field',
        // ));
        // $wp_customize->add_control('sidebar_select_display_on_search_page', array(
        //     'label' => __('Sidebar select display on search page', 'nebon'),
        //     'description' => __('Choose a sidebar to display.', 'nebon'),
        //     'type' => 'select',
        //     'choices' => $this->get_sidebar_widgets(),
        //     'section' => 'layout_section',
        //     'active_callback' => function ($control) {
        //         return $control->manager->get_setting('sidebar_position_on_search_page')->value() !== 'no_sidebar';
        //     },
        // ));

        // $wp_customize->add_setting('sidebar_position_archives', array(
        //     'transport' => 'refresh',
        //     'default' => 'no',
        //     'sanitize_callback' => 'sanitize_text_field',
        // ));
        // $wp_customize->add_control('sidebar_position_archives', array(
        //     'label' => __('Sidebar Position for Archives Page', 'nebon'),
        //     'description' => __('Set sidebar position for your archives page (category/tag/author page...). Left, Right, or No sidebar.', 'nebon'),
        //     'type' => 'select',
        //     'choices' => array(
        //         'no' => __('No Sidebar', 'nebon'),
        //         'left' => __('Left Sidebar', 'nebon'),
        //         'right' => __('Right Sidebar', 'nebon'),
        //     ),
        //     'section' => 'layout_section',
        // ));

        // $wp_customize->add_setting('sidebar_archives', array(
        //     'transport' => 'refresh',
        //     'default' => 'choose_one',
        //     'sanitize_callback' => 'sanitize_text_field',
        // ));
        // $wp_customize->add_control('sidebar_archives', array(
        //     'label' => __('Choose sidebar for Archives Page', 'nebon'),
        //     'description' => __('Choose a sidebar to display.', 'nebon'),
        //     'type' => 'select',
        //     'choices' => $this->get_sidebar_widgets(),
        //     'section' => 'layout_section',
        //     'active_callback' => function ($control) {
        //         return $control->manager->get_setting('sidebar_position_archives')->value() !== 'no';
        //     },
        // ));
    }
    public function add_upload_font_settings($wp_customize)
    {

        $wp_customize->add_setting('upload_file_repeater', array(
            'default' => '[]',
            'sanitize_callback' => 'wp_kses_post', // Changed from customizer_repeater_sanitize
            'transport' => 'refresh',
        ));
        $wp_customize->add_control(new \Customizer_Repeater(
            $wp_customize,
            'upload_file_repeater',
            array(
                'label' => __('Upload your custom font', 'nebon'),
                'section' => 'upload_font_custom_section',
                'priority' => 160,
                'customizer_repeater_upload_file_only_control' => true,
                'customizer_repeater_title_control'    => true,
            )
        ));
    }

    public function add_breadcrumb_settings($wp_customize)
    {
        // Show Breadcrumb
        $wp_customize->add_setting('show_breadcrumb', array(
            'transport' => 'refresh',
            'default' => 'off',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control('show_breadcrumb', array(
            'label' => __('Show BreadCrumb', 'nebon'),
            'description' => __('This allows you to show or hide BreadCrumb', 'nebon'),
            'type' => 'radio',
            'section' => 'breadcumb',
            'choices' => array(
                'on' => __('On', 'nebon'),
                'off' => __('Off', 'nebon'),
            ),
        ));

        // Background Breadcrumb
        $wp_customize->add_setting('background_breadcrumb', array(
            'default' => '#ffffff',
            'transport' => 'refresh',
            'sanitize_callback' =>  'sanitize_hex_color',
        ));
        $wp_customize->add_control(new WP_Customize_Color_Control(
            $wp_customize,
            'background_breadcrumb',
            array(
                'label' => __('Background Breadcrumb', 'nebon'),
                'section' => 'breadcumb',
                'alpha' => true,
                'active_callback' => function ($control) {
                    return $control->manager->get_setting('show_breadcrumb')->value() === 'on';
                },
            )
        ));

        // File Upload
        $wp_customize->add_setting('file', array(
            'default' => '',
            'transport' => 'refresh',
            'sanitize_callback' => 'esc_url_raw',
        ));
        $wp_customize->add_control(new WP_Customize_Upload_Control(
            $wp_customize,
            'file',
            array(
                'label' => __('Custom background for breadcrumb.', 'nebon'),
                'section' => 'breadcumb',
                'active_callback' => function ($control) {
                    return $control->manager->get_setting('show_breadcrumb')->value() === 'on';
                },
            )
        ));

        // Default Post Breadcrumb Image
        $wp_customize->add_setting('default_post_breadcrumb_image', array(
            'default' => '',
            'transport' => 'refresh',
            'sanitize_callback' => 'esc_url_raw',
        ));
        $wp_customize->add_control(new WP_Customize_Upload_Control(
            $wp_customize,
            'default_post_breadcrumb_image',
            array(
                'label' => __('Custom Breadcrumb Image for Posts', 'nebon'),
                'section' => 'breadcumb',
                'active_callback' => function ($control) {
                    return $control->manager->get_setting('show_breadcrumb')->value() === 'on';
                },
            )
        ));

        // Default Product Breadcrumb Image
        $wp_customize->add_setting('default_product_breadcrumb_image', array(
            'default' => '',
            'transport' => 'refresh',
            'sanitize_callback' => 'esc_url_raw',
        ));
        $wp_customize->add_control(new WP_Customize_Upload_Control(
            $wp_customize,
            'default_product_breadcrumb_image',
            array(
                'label' => __('Custom Breadcrumb Image for Product', 'nebon'),
                'section' => 'breadcumb',
                'active_callback' => function ($control) {
                    return $control->manager->get_setting('show_breadcrumb')->value() === 'on';
                },
            )
        ));

        // Opacity Background
        $wp_customize->add_setting('opacity_background', array(
            'default' => 0,
            'transport' => 'refresh',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control('opacity_background', array(
            'label'       => __('Opacity Background', 'nebon'),
            'type'        => 'number',
            'section'     => 'breadcumb',
            'input_attrs' => array('min' => 0, 'max' => 1, 'step' => 0.05),
            'active_callback' => function ($control) {
                return $control->manager->get_setting('show_breadcrumb')->value() === 'on';
            },
        ));

        // Background Repeat
        $wp_customize->add_setting('background_repeat', array(
            'transport' => 'refresh',
            'default' => '',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control('background_repeat', array(
            'label' => __('Background Repeat', 'nebon'),
            'type' => 'select',
            'section' => 'breadcumb',
            'choices' => array(
                'default' => __('Background Repeat', 'nebon'),
                'no-repeat' => __('No Repeat', 'nebon'),
                'repeat_all' => __('Repeat All', 'nebon'),
                'repeat_horizontally' => __('Repeat Horizontally', 'nebon'),
                'repeat_vertically' => __('Repeat Vertically', 'nebon'),
                'inherit' => __('Inherit', 'nebon'),
            ),
            'active_callback' => function ($control) {
                return $control->manager->get_setting('show_breadcrumb')->value() === 'on';
            },
        ));

        // Background Size
        $wp_customize->add_setting('background_size', array(
            'transport' => 'refresh',
            'default' => 'default',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control('background_size', array(
            'label' => __('Background Size', 'nebon'),
            'type' => 'select',
            'section' => 'breadcumb',
            'choices' => array(
                'default' => __('Background Size', 'nebon'),
                'cover' => __('Cover', 'nebon'),
                'contain' => __('Contain', 'nebon'),
                'inherit' => __('Inherit', 'nebon'),
            ),
            'active_callback' => function ($control) {
                return $control->manager->get_setting('show_breadcrumb')->value() === 'on';
            },
        ));

        // Background Attachment
        $wp_customize->add_setting('background_attachment', array(
            'transport' => 'refresh',
            'default' => 'default',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control('background_attachment', array(
            'label' => __('Background Attachment', 'nebon'),
            'type' => 'select',
            'section' => 'breadcumb',
            'choices' => array(
                'default' => __('Background Attachment', 'nebon'),
                'fixed' => __('Fixed', 'nebon'),
                'scroll' => __('Scroll', 'nebon'),
                'inherit' => __('Inherit', 'nebon'),
            ),
            'active_callback' => function ($control) {
                return $control->manager->get_setting('show_breadcrumb')->value() === 'on';
            },
        ));

        // Background Position
        $wp_customize->add_setting('background_position', array(
            'transport' => 'refresh',
            'default' => 'default',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control('background_position', array(
            'label' => __('Background Position', 'nebon'),
            'type' => 'select',
            'section' => 'breadcumb',
            'choices' => array(
                'default' => __('Background Position', 'nebon'),
                'left_top' => __('Left Top', 'nebon'),
                'left_center' => __('Left Center', 'nebon'),
                'left_bottom' => __('Left Bottom', 'nebon'),
                'center_top' => __('Center Top', 'nebon'),
                'center_center' => __('Center center', 'nebon'),
                'center_bottom' => __('Center bottom', 'nebon'),
                'right_top' => __('Right top', 'nebon'),
                'right_center' => __('Right center', 'nebon'),
                'right_bottom' => __('Right bottom', 'nebon'),
            ),
            'active_callback' => function ($control) {
                return $control->manager->get_setting('show_breadcrumb')->value() === 'on';
            },
        ));

        // === BREADCRUMB TEXT SETTINGS ===

        // Breadcrumb Text Font Family
        $wp_customize->add_setting('breadcrumb_text_font_family', array(
            'transport' => 'refresh',
            'default' => 'Philosopher',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control('breadcrumb_text_font_family', array(
            'label' => __('Title Font Family', 'nebon'),
            'type' => 'select',
            'section' => 'breadcumb',
            'choices' => array(
                'Philosopher' => __('Standard Font of theme', 'nebon'),
                'custom_font' => __('Google Font', 'nebon'),
                'upload_font' => __(' Your uploaded font', 'nebon'),
            ),
            'active_callback' => function ($control) {
                return $control->manager->get_setting('show_breadcrumb')->value() === 'on';
            },
        ));
        // Google Font Custom
        $wp_customize->add_setting('breadcrumb_title_custom_google_font', [
            'default'           => 'Poppins',
            'transport'         => 'refresh',
            'sanitize_callback' => function ($val) {
                $list = array_keys(t888_get_google_fonts_list());
                return in_array($val, $list, true) ? $val : 'Poppins';
            },
        ]);
        $wp_customize->add_control('breadcrumb_title_custom_google_font', [
            'label'       => __('Select Google Font', 'nebon'),
            'section'     => 'breadcumb',
            'type'        => 'select',
            'choices'     => t888_get_google_fonts_list(),
            'active_callback' => function ($control) {
                return $control->manager->get_setting('show_breadcrumb')->value() === 'on'
                    && get_theme_mod('breadcrumb_text_font_family', 'Philosopher') === 'custom_font';
            },
        ]);

        // Breadcrumb Text Font Weight Style
        $wp_customize->add_setting('breadcrumb_title_font_weight', array(
            'default' => '700',
            'transport' => 'refresh',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control('breadcrumb_title_font_weight', array(
            'label' => __('Title Font Weight & Style', 'nebon'),
            'type' => 'select',
            'section' => 'breadcumb',
            'choices' => array(
                '400' => __('Normal 400', 'nebon'),
                '700' => __('Bold 700', 'nebon'),
                '400italic' => __('Normal 400 Italic', 'nebon'),
                '700italic' => __('Bold 700 Italic', 'nebon'),
            ),
            'active_callback' => function ($control) {
                $on  = $control->manager->get_setting('show_breadcrumb')->value() === 'on';
                $ff  = get_theme_mod('breadcrumb_text_font_family', 'Philosopher');
                return $on && in_array($ff, ['Philosopher', 'custom_font'], true);
            },
        ));

        $wp_customize->add_setting('breadcrumb_title_uploaded_font', [
            'default'           => '',
            'transport'         => 'refresh',
            'sanitize_callback' => function ($val) {
                $choices = array_keys(t888_get_uploaded_font_choices());
                return in_array($val, $choices, true) ? $val : '';
            },
        ]);

        $wp_customize->add_control('breadcrumb_title_uploaded_font', [
            'label'    => __('Select your uploaded Font', 'nebon'),
            'section'  => 'breadcumb',
            'type'     => 'select',
            'choices'  => t888_get_uploaded_font_choices(),
            'active_callback' => function ($control) {
                return $control->manager->get_setting('show_breadcrumb')->value() === 'on'
                    && get_theme_mod('breadcrumb_text_font_family', 'Philosopher') === 'upload_font';
            },
        ]);

        // Breadcrumb Text Font Size
        $wp_customize->add_setting('breadcrumb_text_font_size', array(
            'transport' => 'refresh',
            'sanitize_callback' => 'absint',
        ));
        $wp_customize->add_control('breadcrumb_text_font_size', array(
            'label' => __('Title Font Size(px)', 'nebon'),
            'type' => 'number',
            'section' => 'breadcumb',
            'input_attrs' => array(
                'placeholder' => __('Size', 'nebon'),
            ),
            'active_callback' => function ($control) {
                return $control->manager->get_setting('show_breadcrumb')->value() === 'on';
            },
        ));

        // Breadcrumb Text Font Text Align
        $wp_customize->add_setting('breadcrumb_title_text_align', array(
            'default' => 'left',
            'transport' => 'refresh',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control('breadcrumb_title_text_align', array(
            'label' => __('Title Align', 'nebon'),
            'type' => 'select',
            'section' => 'breadcumb',
            'choices' => array(
                'left' => __('Left', 'nebon'),
                'center' => __('Center', 'nebon'),
                'right' => __('Right', 'nebon'),
            ),
        ));

        // Breadcrumb Text Line Height
        $wp_customize->add_setting('breadcrumb_text_line_height', array(
            'transport' => 'refresh',
            'sanitize_callback' => 'absint',
        ));
        $wp_customize->add_control('breadcrumb_text_line_height', array(
            'label' => __('Title Line Height(px)', 'nebon'),
            'type' => 'number',
            'section' => 'breadcumb',
            'input_attrs' => array(
                'placeholder' => __('Height', 'nebon'),
            ),
            'active_callback' => function ($control) {
                return $control->manager->get_setting('show_breadcrumb')->value() === 'on';
            },
        ));

        // Breadcrumb Font Color
        $wp_customize->add_setting('breadcrumb_font_color', array(
            'default' => '#ffffff',
            'transport' => 'refresh',
            'sanitize_callback' => 'sanitize_hex_color',
        ));
        $wp_customize->add_control(new  WP_Customize_Color_Control(
            $wp_customize,
            'breadcrumb_font_color',
            array(
                'label' => __('Breadcrumb Title Font Color', 'nebon'),
                'section' => 'breadcumb',
                'active_callback' => function ($control) {
                    return $control->manager->get_setting('show_breadcrumb')->value() === 'on';
                },
            )
        ));

        // === BREADCRUMB TEXT HOVER SETTINGS ===

        // Breadcrumb Text Hover Font Family
        $wp_customize->add_setting('breadcrumb_text_hover_font_family', array(
            'transport' => 'refresh',
            'default' => 'Poppins',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control('breadcrumb_text_hover_font_family', array(
            'label' => __('Trail Font Family', 'nebon'),
            'type' => 'select',
            'section' => 'breadcumb',
            'choices' => array(
                'Poppins' => __('Standard Font of Theme', 'nebon'),
                'custom_font' => __('Google Font', 'nebon'),
                'upload_font' => __('Your Uploaded Font', 'nebon'),
            ),
            'active_callback' => function ($control) {
                return $control->manager->get_setting('show_breadcrumb')->value() === 'on';
            },
        ));
        // Google Font Custom
        $wp_customize->add_setting('breadcrumb_trail_custom_google_font', [
            'default'           => 'Poppins',
            'transport'         => 'refresh',
            'sanitize_callback' => function ($val) {
                $list = array_keys(t888_get_google_fonts_list());
                return in_array($val, $list, true) ? $val : 'Poppins';
            },
        ]);
        $wp_customize->add_control('breadcrumb_trail_custom_google_font', [
            'label'       => __('Select Google Font', 'nebon'),
            'section'     => 'breadcumb',
            'type'        => 'select',
            'choices'     => t888_get_google_fonts_list(),
            'active_callback' => function ($control) {
                return $control->manager->get_setting('show_breadcrumb')->value() === 'on'
                    && get_theme_mod('breadcrumb_text_hover_font_family', 'Poppins') === 'custom_font';
            },
        ]);

        // Breadcrumb Text Hover Font Weight Style
        $wp_customize->add_setting('breadcrumb_trail_font_weight', array(
            'default' => '400',
            'transport' => 'refresh',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control('breadcrumb_trail_font_weight', array(
            'label' => __('Trail Font Weight & Style', 'nebon'),
            'type' => 'select',
            'section' => 'breadcumb',
            'choices' => array(
                '400' => __('Normal 400', 'nebon'),
                '700' => __('Bold 700', 'nebon'),
                '400italic' => __('Normal 400 Italic', 'nebon'),
                '700italic' => __('Bold 700 Italic', 'nebon'),
            ),
            'active_callback' => function ($control) {
                $on  = $control->manager->get_setting('show_breadcrumb')->value() === 'on';
                $ff  = get_theme_mod('breadcrumb_text_hover_font_family', 'Poppins');
                return $on && in_array($ff, ['Poppins', 'custom_font'], true);
            },
        ));
        $wp_customize->add_setting('breadcrumb_trail_uploaded_font', [
            'default'           => '',
            'transport'         => 'refresh',
            'sanitize_callback' => function ($val) {
                $choices = array_keys(t888_get_uploaded_font_choices());
                return in_array($val, $choices, true) ? $val : '';
            },
        ]);
        $wp_customize->add_control('breadcrumb_trail_uploaded_font', [
            'label'    => __('Select your uploaded Font', 'nebon'),
            'section'  => 'breadcumb',
            'type'     => 'select',
            'choices'  => t888_get_uploaded_font_choices(),
            'active_callback' => function ($control) {
                return $control->manager->get_setting('show_breadcrumb')->value() === 'on'
                    && get_theme_mod('breadcrumb_text_hover_font_family', 'Poppins') === 'upload_font';
            },
        ]);

        // Breadcrumb Text Hover Text Align
        $wp_customize->add_setting('breadcrumb_trail_text_align', array(
            'default' => 'left',
            'transport' => 'refresh',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control('breadcrumb_trail_text_align', array(
            'label' => __('Trail Align', 'nebon'),
            'type' => 'select',
            'section' => 'breadcumb',
            'choices' => array(
                'left' => __('Left', 'nebon'),
                'center' => __('Center', 'nebon'),
                'right' => __('Right', 'nebon'),
            ),
        ));

        // Breadcrumb Text Hover Font Size
        $wp_customize->add_setting('breadcrumb_text_hover_font_size', array(
            'transport' => 'refresh',
            'sanitize_callback' => 'absint',
        ));
        $wp_customize->add_control('breadcrumb_text_hover_font_size', array(
            'label' => __('Trail Font Size(px)', 'nebon'),
            'type' => 'number',
            'section' => 'breadcumb',
            'input_attrs' => array(
                'placeholder' => __('Size', 'nebon'),
            ),
            'active_callback' => function ($control) {
                return $control->manager->get_setting('show_breadcrumb')->value() === 'on';
            },
        ));

        // Breadcrumb Text Hover Line Height
        $wp_customize->add_setting('breadcrumb_text_hover_line_height', array(
            'transport' => 'refresh',
            'sanitize_callback' => 'absint',
        ));
        $wp_customize->add_control('breadcrumb_text_hover_line_height', array(
            'label' => __('Trail Line Height(px)', 'nebon'),
            'type' => 'number',
            'section' => 'breadcumb',
            'input_attrs' => array(
                'placeholder' => __('Height', 'nebon'),
            ),
            'active_callback' => function ($control) {
                return $control->manager->get_setting('show_breadcrumb')->value() === 'on';
            },
        ));

        // Breadcrumb Text Hover Font Color
        $wp_customize->add_setting('breadcrumb_text_hover_font_color', array(
            'default' => '#ffffff',
            'transport' => 'refresh',
            'sanitize_callback' => 'sanitize_hex_color',
        ));
        $wp_customize->add_control(new WP_Customize_Color_Control(
            $wp_customize,
            'breadcrumb_text_hover_font_color',
            array(
                'label' => __('Breadcrumb Trail Font Color', 'nebon'),
                'section' => 'breadcumb',
                'alpha' => true,
                'active_callback' => function ($control) {
                    return $control->manager->get_setting('show_breadcrumb')->value() === 'on';
                },
            )
        ));
    }

    public function add_color_settings($wp_customize): void
    {
        // Show Support
        $wp_customize->add_setting('show_support', array(
            'default' => 'off',
            'transport' => 'refresh',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control('show_support', array(
            'label' => __('Show Support', 'nebon'),
            'type' => 'radio',
            'section' => 'Support',
            'choices' => array(
                'on' => __('On', 'nebon'),
                'off' => __('Off', 'nebon'),
            ),
        ));

        // Image Intro
        $wp_customize->add_setting('image_intro', array(
            'default' => '',
            'transport' => 'refresh',
            'sanitize_callback' => 'esc_url_raw',
        ));
        $wp_customize->add_control(new WP_Customize_Upload_Control(
            $wp_customize,
            'image_intro',
            array(
                'label' => __('Image Intro', 'nebon'),
                'section' => 'Support',
                'active_callback' => function ($control) {
                    return $control->manager->get_setting('show_support')->value() === 'on';
                },
            )
        ));

        // Title Intro
        $wp_customize->add_setting('title_intro', array(
            'default' => __('Nebon - Woocomerce wordpress theme ', 'nebon'),
            'transport' => 'refresh',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control('title_intro', array(
            'label' => __('Title Intro', 'nebon'),
            'type' => 'text',
            'section' => 'Support',
            'active_callback' => function ($control) {
                return $control->manager->get_setting('show_support')->value() === 'on';
            },
        ));

        // Title Link Intro
        $wp_customize->add_setting('title_link_intro', array(
            'default' => __('Buy Now ', 'nebon'),
            'transport' => 'refresh',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control('title_link_intro', array(
            'label' => __('Title Link Intro', 'nebon'),
            'type' => 'text',
            'section' => 'Support',
            'active_callback' => function ($control) {
                return $control->manager->get_setting('show_support')->value() === 'on';
            },
        ));

        // Link Intro
        $wp_customize->add_setting('link_intro', array(
            'default' => 'https://7uptheme.net/',
            'transport' => 'refresh',
            'sanitize_callback' => 'esc_url_raw',
        ));
        $wp_customize->add_control('link_intro', array(
            'label' => __('Link Intro', 'nebon'),
            'type' => 'url',
            'section' => 'Support',
            'active_callback' => function ($control) {
                return $control->manager->get_setting('show_support')->value() === 'on';
            },
        ));

        // Main Color 1
        $wp_customize->add_setting('t888_main_color1', array(
            'default' => '#000000',
            'transport' => 'refresh',
            'sanitize_callback' => 'sanitize_hex_color',
        ));
        $wp_customize->add_control(new WP_Customize_Color_Control(
            $wp_customize,
            't888_main_color1',
            array(
                'label' => __('Main Color 1', 'nebon'),
                'section' => 'Support',
                'active_callback' => function ($control) {
                    return $control->manager->get_setting('show_support')->value() === 'on';
                },
            )
        ));

        // Main Color 1 Switch
        $wp_customize->add_setting('t888_main_color1-switch', array(
            'default' => '#ccc',
            'transport' => 'refresh',
            'sanitize_callback' => 'sanitize_hex_color',
        ));
        $wp_customize->add_control(new WP_Customize_Color_Control(
            $wp_customize,
            't888_main_color1-switch',
            array(
                'label' => __('Main Color 1 switch', 'nebon'),
                'section' => 'Support',
                'active_callback' => function ($control) {
                    return $control->manager->get_setting('show_support')->value() === 'on';
                },
            )
        ));

        // Main Color 2
        $wp_customize->add_setting('t888_main_color2', array(
            'default' => '#b88166',
            'transport' => 'refresh',
            'sanitize_callback' => 'sanitize_hex_color',
        ));
        $wp_customize->add_control(new WP_Customize_Color_Control(
            $wp_customize,
            't888_main_color2',
            array(
                'label' => __('Main Color 2', 'nebon'),
                'section' => 'Support',
                'active_callback' => function ($control) {
                    return $control->manager->get_setting('show_support')->value() === 'on';
                },
            )
        ));

        // Main Color 2 Switch
        $wp_customize->add_setting('t888_main_color2_switch', array(
            'default' => '#ffde00',
            'transport' => 'refresh',
            'sanitize_callback' => 'sanitize_hex_color',
        ));
        $wp_customize->add_control(new WP_Customize_Color_Control(
            $wp_customize,
            't888_main_color2_switch',
            array(
                'label' => __('Main Color 2 switch', 'nebon'),
                'section' => 'Support',
                'active_callback' => function ($control) {
                    return $control->manager->get_setting('show_support')->value() === 'on';
                },
            )
        ));

        // Link Support
        $wp_customize->add_setting('link_support', array(
            'default' => 'https://7uptheme.net/',
            'transport' => 'refresh',
            'sanitize_callback' => 'esc_url_raw',
        ));
        $wp_customize->add_control('link_support', array(
            'label' => __('Link Support', 'nebon'),
            'type' => 'url',
            'section' => 'Support',
            'active_callback' => function ($control) {
                return $control->manager->get_setting('show_support')->value() === 'on';
            },
        ));

        // Link Guide
        $wp_customize->add_setting('link_guide', array(
            'default' => 'https://7uptheme.net/',
            'transport' => 'refresh',
            'sanitize_callback' => 'esc_url_raw',
        ));
        $wp_customize->add_control('link_guide', array(
            'label' => __('Link Guide', 'nebon'),
            'type' => 'url',
            'section' => 'Support',
            'active_callback' => function ($control) {
                return $control->manager->get_setting('show_support')->value() === 'on';
            },
        ));

        // Left to Right
        $wp_customize->add_setting('left_to_right', array(
            'default' => 'on',
            'transport' => 'refresh',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control('left_to_right', array(
            'label' => __('Left to Right', 'nebon'),
            'type' => 'radio',
            'section' => 'Support',
            'choices' => array(
                'on' => __('On', 'nebon'),
                'off' => __('Off', 'nebon'),
            ),
            'active_callback' => function ($control) {
                return $control->manager->get_setting('show_support')->value() === 'on';
            },
        ));
    }

    public function add_menu_settings($wp_customize)
    {
        // Menu Style Font Family
        $wp_customize->add_setting('menu_style_font_family', array(
            'transport' => 'refresh',
            'default' => 'Philosopher',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control('menu_style_font_family', array(
            'label' => __('Font Family', 'nebon'),
            'section' => 'menu_setting',
            'type' => 'select',
            'choices' => array(
                'Philosopher' => __('Standard Font of Theme', 'nebon'),
                'custom_font' => __('Google Font', 'nebon'),
                'upload_font' => __('Your Uploaded Font', 'nebon'),
            ),
        ));
        // Google Font Custom
        $wp_customize->add_setting('menu_custom_google_font', [
            'default'           => 'Poppins',
            'transport'         => 'refresh',
            'sanitize_callback' => function ($val) {
                $list = array_keys(t888_get_google_fonts_list());
                return in_array($val, $list, true) ? $val : 'Poppins';
            },
        ]);
        $wp_customize->add_control('menu_custom_google_font', [
            'label'       => __('Select Google Font', 'nebon'),
            'section'     => 'menu_setting',
            'type'        => 'select',
            'choices'     => t888_get_google_fonts_list(),
            'active_callback' => function ($control) {
                return get_theme_mod('menu_style_font_family', 'Philosopher') === 'custom_font';
            },
        ]);

        // Menu Style Font Weight Style
        $wp_customize->add_setting('menu_style_font_weight_style', array(
            'transport' => 'refresh',
            'default' => 'default',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control('menu_style_font_weight_style', array(
            'label' => __('Font Weight & Style', 'nebon'),
            'section' => 'menu_setting',
            'default' => '700',
            'type' => 'select',
            'choices' => array(
                '400' => __('Normal 400', 'nebon'),
                '700' => __('Bold 700', 'nebon'),
                '400italic' => __('Normal 400 Italic', 'nebon'),
                '700italic' => __('Bold 700 Italic', 'nebon'),
            ),
            'active_callback' => function ($control) {
                $ff = get_theme_mod('menu_style_font_family', 'Philosopher');
                return in_array($ff, ['Philosopher', 'custom_font'], true);
            },
        ));
        $wp_customize->add_setting('menu_uploaded_font', [
            'default'           => '',
            'transport'         => 'refresh',
            'sanitize_callback' => function ($val) {
                $choices = array_keys(t888_get_uploaded_font_choices());
                return in_array($val, $choices, true) ? $val : '';
            },
        ]);
        $wp_customize->add_control('menu_uploaded_font', [
            'label'    => __('Select your uploaded Font', 'nebon'),
            'section'  => 'menu_setting',
            'type'     => 'select',
            'choices'  => t888_get_uploaded_font_choices(),
            'active_callback' => function ($control) {
                return get_theme_mod('menu_style_font_family', 'Philosopher') === 'upload_font';
            },
        ]);

        // Menu Style Font Text Align
        $wp_customize->add_setting('menu_style_font_text_align', array(
            'transport' => 'refresh',
            'default' => 'default',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control('menu_style_font_text_align', array(
            'label' => __('Text Align', 'nebon'),
            'section' => 'menu_setting',
            'type' => 'select',
            'choices' => array(
                'left' => __('Left', 'nebon'),
                'center' => __('Center', 'nebon'),
                'right' => __('Right', 'nebon'),
            ),
        ));

        // Menu Style Font Size
        $wp_customize->add_setting('menu_style_font_size', array(
            'transport' => 'refresh',
            'default' => 14,
            'sanitize_callback' => 'absint',
        ));
        $wp_customize->add_control('menu_style_font_size', array(
            'label' => __('Font Size(px)', 'nebon'),
            'type' => 'number',
            'section' => 'menu_setting',
            'input_attrs' => array(
                'placeholder' => __('Size', 'nebon'),
            ),
        ));

        // Menu Style Line Height
        $wp_customize->add_setting('menu_style_line_height', array(
            'transport' => 'refresh',
            'default' => 36,
            'sanitize_callback' => 'absint',
        ));
        $wp_customize->add_control('menu_style_line_height', array(
            'label' => __('Line Height(px)', 'nebon'),
            'type' => 'number',
            'section' => 'menu_setting',
            'input_attrs' => array(
                'placeholder' => __('Size', 'nebon'),
            ),
        ));

        // Menu Style Font Color
        $wp_customize->add_setting('menu_style_font_color', array(
            'default' => '#ffffff',
            'transport' => 'refresh',
            'sanitize_callback' =>  'sanitize_hex_color',
        ));
        $wp_customize->add_control(new WP_Customize_Color_Control(
            $wp_customize,
            'menu_style_font_color',
            array(
                'label' => __('Font Color', 'nebon'),
                'description' => __('Choose color', 'nebon'),
                'section' => 'menu_setting',
                'alpha' => true,
            )
        ));

        // Hover Color
        $wp_customize->add_setting('hover_color', array(
            'default' => '#ffffff',
            'transport' => 'refresh',
            'sanitize_callback' => 'sanitize_hex_color',
        ));
        $wp_customize->add_control(new WP_Customize_Color_Control(
            $wp_customize,
            'hover_color',
            array(
                'label' => __('Hover Color', 'nebon'),
                'description' => __('Choose color', 'nebon'),
                'section' => 'menu_setting',
                'alpha' => true,
            )
        ));

        // Background Hover Color
        $wp_customize->add_setting('background_hover_color', array(
            'default' => '#ffffff',
            'transport' => 'refresh',
            'sanitize_callback' => 'sanitize_hex_color',
        ));
        $wp_customize->add_control(new WP_Customize_Color_Control(
            $wp_customize,
            'background_hover_color',
            array(
                'label' => __('Background Hover Color', 'nebon'),
                'description' => __('Choose color', 'nebon'),
                'section' => 'menu_setting',
                'alpha' => true,
            )
        ));

        // === SUBMENU SETTINGS ===

        // Menu Sub Style Font Family
        $wp_customize->add_setting('menu_sub_style_font_family', array(
            'transport' => 'refresh',
            'default' => 'default',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control('menu_sub_style_font_family', array(
            'label' => __('Sub Font Family', 'nebon'),
            'section' => 'menu_setting',
            'default' => 'Poppins',
            'type' => 'select',
            'choices' => array(
                'Poppins' => __('Standard Font of Theme', 'nebon'),
                'custom_font' => __('Google Font', 'nebon'),
                'upload_font' => __('Your Uploaded Font', 'nebon'),
            ),
        ));
        // Google Font Custom
        $wp_customize->add_setting('menu_sub_custom_google_font', [
            'default'           => 'Poppins',
            'transport'         => 'refresh',
            'sanitize_callback' => function ($val) {
                $list = array_keys(t888_get_google_fonts_list());
                return in_array($val, $list, true) ? $val : 'Poppins';
            },
        ]);
        $wp_customize->add_control('menu_sub_custom_google_font', [
            'label'       => __('Select Google Font', 'nebon'),
            'section'     => 'menu_setting',
            'type'        => 'select',
            'choices'     => t888_get_google_fonts_list(),
            'active_callback' => function ($control) {
                return get_theme_mod('menu_sub_style_font_family', 'Poppins') === 'custom_font';
            },
        ]);

        // Menu Sub Style Font Weight Style
        $wp_customize->add_setting('menu_sub_style_font_weight_style', array(
            'transport' => 'refresh',
            'default' => 'default',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control('menu_sub_style_font_weight_style', array(
            'label' => __('Sub Font Weight & Style', 'nebon'),
            'section' => 'menu_setting',
            'default' => '400',
            'type' => 'select',
            'choices' => array(
                '400' => __('Normal 400', 'nebon'),
                '700' => __('Bold 700', 'nebon'),
                '400italic' => __('Normal 400 Italic', 'nebon'),
                '700italic' => __('Bold 700 Italic', 'nebon'),
            ),
            'active_callback' => function ($control) {
                $ff = get_theme_mod('menu_sub_style_font_family', 'Poppins');
                return in_array($ff, ['Poppins', 'custom_font'], true);
            },
        ));
        $wp_customize->add_setting('menu_sub_uploaded_font', [
            'default'           => '',
            'transport'         => 'refresh',
            'sanitize_callback' => function ($val) {
                $choices = array_keys(t888_get_uploaded_font_choices());
                return in_array($val, $choices, true) ? $val : '';
            },
        ]);
        $wp_customize->add_control('menu_sub_uploaded_font', [
            'label'    => __('Select your uploaded Font', 'nebon'),
            'section'  => 'menu_setting',
            'type'     => 'select',
            'choices'  => t888_get_uploaded_font_choices(),
            'active_callback' => function ($control) {
                return get_theme_mod('menu_sub_style_font_family', 'Poppins') === 'upload_font';
            },
        ]);

        // Menu Sub Style Text Align
        $wp_customize->add_setting('menu_sub_style_text_align', array(
            'transport' => 'refresh',
            'default' => 'left',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control('menu_sub_style_text_align', array(
            'label' => __('Sub Text Align', 'nebon'),
            'section' => 'menu_setting',
            'type' => 'select',
            'choices' => array(
                'left' => __('Left', 'nebon'),
                'center' => __('Center', 'nebon'),
                'right' => __('Right', 'nebon'),
            ),
        ));

        // Menu Sub Style Font Size
        $wp_customize->add_setting('menu_sub_style_font_size', array(
            'transport' => 'refresh',
            'default' => 16,
            'sanitize_callback' => 'absint',
        ));
        $wp_customize->add_control('menu_sub_style_font_size', array(
            'label' => __('Sub Font Size(px)', 'nebon'),
            'section' => 'menu_setting',
            'type' => 'number',
            'input_attrs' => array(
                'placeholder' => __('Size', 'nebon'),
            ),
        ));

        // Menu Sub Style Line Height
        $wp_customize->add_setting('menu_sub_style_line_height', array(
            'transport' => 'refresh',
            'default' => 16,
            'sanitize_callback' => 'absint',
        ));
        $wp_customize->add_control('menu_sub_style_line_height', array(
            'label' => __('Sub Line Height(px)', 'nebon'),
            'section' => 'menu_setting',
            'type' => 'number',
            'input_attrs' => array(
                'placeholder' => __('Height', 'nebon'),
            ),
        ));

        // Menu Sub Style Font Color
        $wp_customize->add_setting('menu_sub_style_font_color', array(
            'transport' => 'refresh',
            'default' => '#666666',
            'sanitize_callback' =>  'sanitize_hex_color',
        ));
        $wp_customize->add_control(new WP_Customize_Color_Control(
            $wp_customize,
            'menu_sub_style_font_color',
            array(
                'label' => __('Sub Font Color', 'nebon'),
                'section' => 'menu_setting',
                'alpha' => true,
            )
        ));

        // Hover Sub Colour
        $wp_customize->add_setting('hover_sub_color', array(
            'transport' => 'refresh',
            'default' => '#b88166',
            'sanitize_callback' => 'sanitize_hex_color',
        ));
        $wp_customize->add_control(new WP_Customize_Color_Control(
            $wp_customize,
            'hover_sub_color',
            array(
                'label' => __('Hover Sub Color', 'nebon'),
                'section' => 'menu_setting',
                'alpha' => true,
            )
        ));

        // Background Sub Hover Colour
        $wp_customize->add_setting('background_sub_hover_color', array(
            'transport' => 'refresh',
            'default' => '#ffffff',
            'sanitize_callback' => 'sanitize_hex_color',
        ));
        $wp_customize->add_control(new WP_Customize_Color_Control(
            $wp_customize,
            'background_sub_hover_color',
            array(
                'label' => __('Background Sub Hover Color', 'nebon'),
                'section' => 'menu_setting',
                'alpha' => true,
            )
        ));
    }

    public function add_other_settings($wp_customize)
    {
        // Custom Container Width
        $wp_customize->add_setting('custom_container_width', array(
            'transport' => 'refresh',
            'default' => '1432',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control('custom_container_width', array(
            'label' => __('Custom Container Width', 'nebon'),
            'description' => __('Custom Container Width', 'nebon'),
            'section' => 'other_section',
            'type' => 'text',
        ));

        // Scrolling Option
        // $wp_customize->add_setting('scrolling_option', array(
        //     'default' => 'off',
        //     'transport' => 'refresh',
        //     'sanitize_callback' => 'sanitize_text_field',
        // ));
        // $wp_customize->add_control('scrolling_option', array(
        //     'label' => __('Show scroll top button', 'nebon'),
        //     'description' => __('This allow you to show or hide scroll top button', 'nebon'),
        //     'section' => 'other_section',
        //     'type' => 'radio',
        //     'choices' => array(
        //         'on' => __('On', 'nebon'),
        //         'off' => __('Off', 'nebon'),
        //     ),
        // ));

        // Wishlist Sections Option
        // $wp_customize->add_setting('wishlist_sections_option', array(
        //     'default' => 'off',
        //     'transport' => 'refresh',
        //     'sanitize_callback' => 'sanitize_text_field',
        // ));
        // $wp_customize->add_control('wishlist_sections_option', array(
        //     'label' => __('Show wishlist notification', 'nebon'),
        //     'description' => __(' Show or hide wishlist notification when add to wishlist.', 'nebon'),
        //     'section' => 'other_section',
        //     'type' => 'radio',
        //     'choices' => array(
        //         'on' => __('On', 'nebon'),
        //         'off' => __('Off', 'nebon'),
        //     ),
        // ));

        // Body Background Options
        // $wp_customize->add_setting('body_background_options', array(
        //     'transport' => 'refresh',
        //     'default' => '#ffffff',
        //     'sanitize_callback' => 'sanitize_hex_color',
        // ));
        // $wp_customize->add_control(new WP_Customize_Color_Control(
        //     $wp_customize,
        //     'body_background_options',
        //     array(
        //         'label' => __('Body Background Color', 'nebon'),
        //         'description' => __('Change default body background.', 'nebon'),
        //         'section' => 'other_section',
        //         'alpha' => true,
        //     )
        // ));

      

        // Menu Verification Option
        // $wp_customize->add_setting('menu_verification_option', array(
        //     'default' => 'off',
        //     'transport' => 'refresh',
        //     'sanitize_callback' => 'sanitize_text_field',
        // ));
        // $wp_customize->add_control('menu_verification_option', array(
        //     'label' => __('Disabled Verify Menu', 'nebon'),
        //     'section' => 'other_section',
        //     'type' => 'radio',
        //     'choices' => array(
        //         'on' => __('On', 'nebon'),
        //         'off' => __('Off', 'nebon'),
        //     ),
        // ));

        // Preload
        $wp_customize->add_setting('preload', array(
            'default' => 'off',
            'transport' => 'refresh',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control('preload', array(
            'label' => __('Show Preload', 'nebon'),
            'description' => __('This allow you to show or hide preload.', 'nebon'),
            'type' => 'radio',
            'section' => 'other_section',
            'choices' => array(
                'on' => __('On', 'nebon'),
                'off' => __('Off', 'nebon'),
            ),
        ));

        // Background Preload
        $wp_customize->add_setting('background_preload', array(
            'default' => '#f3ebe4',
            'transport' => 'refresh',
            'sanitize_callback' => 'sanitize_hex_color',
        ));
        $wp_customize->add_control(new WP_Customize_Color_Control(
            $wp_customize,
            'background_preload',
            array(
                'label' => __('Background Preload', 'nebon'),
                'description' => __('Change default body background.', 'nebon'),
                'section' => 'other_section',
                'active_callback' => function ($control) {
                    return $control->manager->get_setting('preload')->value() === 'on';
                }
            )
        ));

        // Preload Style
        $wp_customize->add_setting('preload_style', array(
            'default' => 'style3',
            'transport' => 'refresh',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control('preload_style', array(
            'label' => __('Preload Style', 'nebon'),
            'description' => __('Choose default style for your site.', 'nebon'),
            'type' => 'select',
            'section' => 'other_section',
            'choices' => array(
                'style1' => __('Style 1', 'nebon'),
                'style2' => __('Style 2', 'nebon'),
                'style3' => __('Style 3', 'nebon'),
            ),
            'active_callback' => function ($control) {
                return $control->manager->get_setting('preload')->value() === 'on';
            }
        ));

        // Preload Image
        $wp_customize->add_setting('preload_image', array(
            'transport' => 'refresh',
            'sanitize_callback' => 'esc_url_raw',
        ));
        $wp_customize->add_control(new WP_Customize_Upload_Control(
            $wp_customize,
            'preload_image',
            array(
                'label' => __('Preload Image', 'nebon'),
                'description' => __('Upload an image to use as the preload content (only used in Style 3).', 'nebon'),
                'section' => 'other_section',
                'active_callback' => function ($control) {
                    return $control->manager->get_setting('preload')->value() === 'on'
                        && $control->manager->get_setting('preload_style')->value() === 'style3';
                }
            )
        ));

        // Custom Script
        $wp_customize->add_setting('custom_script', [
            'type'              => 'theme_mod',
            'capability'        => 'edit_theme_options',
            'transport'         => 'refresh',
            'sanitize_callback' => 't888f_sanitize_js',
        ]);
        $wp_customize->add_control('custom_script', array(
            'label' => __('Custom JavaScript', 'nebon'),
            'description' => __('Custom javascript put here. Script will be added to footer be loaded after page loaded', 'nebon'),
            'type' => 'textarea',
            'section' => 'other_section',
        ));
    }

    public function add_blog_post_settings($wp_customize)
    {
        // Blog Append Content Before
        $wp_customize->add_setting('blog_append_content_before', array(
            'transport' => 'refresh',
            'default' => 'choose_one',
            'sanitize_callback' => 'absint',
        ));
        $wp_customize->add_control('blog_append_content_before', array(
            'label' => __('Append content before post/blog/archive page', 'nebon'),
            'description' => __('Choose a mega page content append to before main content of post/blog/archive page.', 'nebon'),
            'section' => 'blog_post',
            'type' => 'select',
            'choices' => self::_tech888f_list_post_type('mega_item', false),
        ));

        // Blog Append Content After
        $wp_customize->add_setting('blog_append_content_after', array(
            'transport' => 'refresh',
            'default' => 'choose_one',
            'sanitize_callback' => 'absint',
        ));
        $wp_customize->add_control('blog_append_content_after', array(
            'label' => __('Append content after post/blog/archive page', 'nebon'),
            'description' => __('Choose a mega page content append to after main content of post/blog/archive page.', 'nebon'),
            'section' => 'blog_post',
            'type' => 'select',
            'choices' => self::_tech888f_list_post_type('mega_item', false),
        ));

        // Sidebar Blog Position
        $wp_customize->add_setting('sidebar_blog_position', array(
            'transport' => 'refresh',
            'default' => 'left',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control('sidebar_blog_position', array(
            'label' => __('Sidebar Blog', 'nebon'),
            'description' => __('Set sidebar position for your blog page. Left, Right, or No sidebar.', 'nebon'),
            'section' => 'blog_post',
            'type' => 'select',
            'choices' => array(
                'no' => __('No Sidebar', 'nebon'),
                'left' => __('Left Sidebar', 'nebon'),
                'right' => __('Right Sidebar', 'nebon'),
            ),
        ));

        // Sidebar Blog
        $wp_customize->add_setting('sidebar_blog', array(
            'transport' => 'refresh',
            'default' => 'choose_one',
            'sanitize_callback' => [$this, 'sanitize_sidebar_choice'],
        ));
        $wp_customize->add_control('sidebar_blog', array(
            'label' => __('Sidebar select display in blog', 'nebon'),
            'description' => __('Choose a sidebar to display.', 'nebon'),
            'section' => 'blog_post',
            'type' => 'select',
            'choices' => $this->get_sidebar_widgets(),
            'active_callback' => function ($control) {
                return $control->manager->get_setting('sidebar_blog_position')->value() !== 'no';
            },
        ));

        // Blog Default Style
        $wp_customize->add_setting('blog_default_style', array(
            'transport' => 'refresh',
            'default' => $this->get_blog_default_style(),
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control('blog_default_style', array(
            'label' => __('Blog/Archive Default style', 'nebon'),
            'description' => __('List: Arrange posts in a grid format with one item per row. <br/> Grid: Arrange posts in a grid format with multiple items per row', 'nebon'),
            'section' => 'blog_post',
            'type' => 'select',
            'choices' => $this->get_blog_styles()
        ));

        // General Blog Pagination
        $wp_customize->add_setting('general_blog_pagination', array(
            'transport' => 'refresh',
            'default' => 'load_more_btn',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control('general_blog_pagination', array(
            'label' => __('Blog pagination', 'nebon'),
            'description' => __('Choose a style to active display', 'nebon'),
            'section' => 'blog_post',
            'type' => 'select',
            'choices' => array(
                'pagination' => __('Pagination', 'nebon'),
            ),
        ));

        // // Blog Show Number Filter
        // $wp_customize->add_setting('blog_show_number_filter', array(
        //     'transport' => 'refresh',
        //     'default' => 'off',
        //     'sanitize_callback' => 'sanitize_text_field',
        // ));
        // $wp_customize->add_control('blog_show_number_filter', array(
        //     'label' => __('Show number filter', 'nebon'),
        //     'description' => __('Show/hide type filter(list/grid) on blog page..', 'nebon'),
        //     'section' => 'blog_post',
        //     'type' => 'radio',
        //     'choices' => array(
        //         'on' => __('On', 'nebon'),
        //         'off' => __('Off', 'nebon'),
        //     ),
        // ));

        // // General Show Number Filter Title
        // $wp_customize->add_setting('general_show_number_filter_title', array(
        //     'transport' => 'refresh',
        //     'sanitize_callback' => 'sanitize_text_field',
        //     'default' => ''
        // ));
        // $wp_customize->add_control('general_show_number_filter_title', array(
        //     'label' => __('Title', 'nebon'),
        //     'section' => 'blog_post',
        //     'type' => 'text',
        //     'active_callback' => function ($control) {
        //         return $control->manager->get_setting('blog_show_number_filter')->value() === 'on';
        //     },
        // ));

        // // General Show Number Filter Title Repeater
        // $wp_customize->add_setting('general_show_number_filter_title_repeater', array(
        //     'transport' => 'refresh',
        //     'sanitize_callback' => 'sanitize_text_field',
        //     'default' => ''
        // ));
        // $wp_customize->add_control(new \Customizer_Repeater(
        //     $wp_customize,
        //     'general_show_number_filter_title_repeater',
        //     array(
        //         'label' => __('Title Repeater', 'nebon'),
        //         'section' => 'blog_post',
        //         'customizer_repeater_title_control' => true,
        //         'active_callback' => function ($control) {
        //             return $control->manager->get_setting('blog_show_number_filter')->value() === 'on';
        //         },
        //     )
        // ));

        // // General Show Number Filter Number
        // $wp_customize->add_setting('general_show_number_filter_number', array(
        //     'transport' => 'refresh',
        //     'default' => '',
        //     'sanitize_callback' => 'absint',
        // ));
        // $wp_customize->add_control('general_show_number_filter_number', array(
        //     'label' => __('Number', 'nebon'),
        //     'description' => __('Add custom list number to filter on the blog page.', 'nebon'),
        //     'section' => 'blog_post',
        //     'type' => 'number',
        //     'active_callback' => function ($control) {
        //         return $control->manager->get_setting('blog_show_number_filter')->value() === 'on';
        //     },
        // ));

        // // General Show Number Filter Number Repeater
        // $wp_customize->add_setting('general_show_number_filter_number_repeater', array(
        //     'transport' => 'refresh',
        //     'default' => '',
        //     'sanitize_callback' => 'sanitize_text_field',
        // ));
        // $wp_customize->add_control(new \Customizer_Repeater(
        //     $wp_customize,
        //     'general_show_number_filter_number_repeater',
        //     array(
        //         'label' => __('Number Repeater', 'nebon'),
        //         'description' => __('Add custom list number to filter on the blog page.', 'nebon'),
        //         'section' => 'blog_post',
        //         'customizer_repeater_text_control' => true,
        //         'active_callback' => function ($control) {
        //             return $control->manager->get_setting('blog_show_number_filter')->value() === 'on';
        //         },
        //     )
        // ));

        // // Blog Show Type Filter
        // $wp_customize->add_setting('blog_show_type_filter', array(
        //     'transport' => 'refresh',
        //     'default' => 'off',
        //     'sanitize_callback' => 'sanitize_text_field',
        // ));
        // $wp_customize->add_control('blog_show_type_filter', array(
        //     'label' => __('Show type filter', 'nebon'),
        //     'description' => __('Show/hide type filter(list/grid) on blog page.', 'nebon'),
        //     'section' => 'blog_post',
        //     'type' => 'radio',
        //     'choices' => array(
        //         'on' => __('On', 'nebon'),
        //         'off' => __('Off', 'nebon'),
        //     ),
        // ));

        // General Post Thumbnail Default
        $wp_customize->add_setting('general_post_thumbnail_default', array(
            'default' => '',
            'transport' => 'refresh',
            'sanitize_callback' => 'esc_url_raw',
        ));
        $wp_customize->add_control(new WP_Customize_Upload_Control(
            $wp_customize,
            'general_post_thumbnail_default',
            array(
                'label' => __('Post Thumbnail Default', 'nebon'),
                'description' => __('Choose post thumbnail default.', 'nebon'),
                'section' => 'blog_post',
            )
        ));

        // Blog List Item Style
        $wp_customize->add_setting('blog_list_item_style', array(
            'default' => $this->get_blog_list_item_default_style(),
            'transport' => 'refresh',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control('blog_list_item_style', array(
            'label' => __('Blog List item style', 'nebon'),
            'description' => __('Choose a style to active display', 'nebon'),
            'type' => 'select',
            'section' => 'blog_post_list_section',
            'choices' => $this->get_blog_list_item_styles()
        ));

        // Blog List Item Size
        $wp_customize->add_setting('blog_list_item_size', array(
            'default' => '',
            'transport' => 'refresh',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control('blog_list_item_size', array(
            'label' => __('Custom Post List thumbnail size', 'nebon'),
            'description' => __('Enter size thumbnail to crop. [width]x[height]. Example is 900x600.', 'nebon'),
            'type' => 'text',
            'section' => 'blog_post_list_section',
        ));

        // Blog Grid Columns
        $wp_customize->add_setting('blog_grid_columns', array(
            'transport' => 'refresh',
            'default' => 2,
            'sanitize_callback' => 'absint',
        ));
        $wp_customize->add_control('blog_grid_columns', array(
            'label' => __('Grid columns', 'nebon'),
            'description' => __('Choose number of columns each row', 'nebon'),
            'type' => 'select',
            'section' => 'blog_post_grid_section',
            'choices' => array(
                '2' => __('2 columns', 'nebon'),
                '3' => __('3 columns ', 'nebon'),
            ),
        ));

        // Blog Grid Item Style
        // $wp_customize->add_setting('blog_grid_item_style', array(
        //     'transport' => 'refresh',
        //     'default' => $this->get_blog_grid_item_default_style(),
        //     'sanitize_callback' => 'sanitize_text_field',
        // ));
        // $wp_customize->add_control('blog_grid_item_style', array(
        //     'label' => __('Grid item style', 'nebon'),
        //     'description' => __('Choose a style to active display', 'nebon'),
        //     'type' => 'select',
        //     'section' => 'blog_post_grid_section',
        //     'choices' => $this->get_blog_grid_item_styles()
        // ));

        // Blog Grid Item Size
        $wp_customize->add_setting('blog_grid_item_size', array(
            'default' => '',
            'transport' => 'refresh',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control('blog_grid_item_size', array(
            'label' => __('Custom grid thumbnail size', 'nebon'),
            'description' => __('Enter size thumbnail to crop. [width]x[height]. Example is 327x482.', 'nebon'),
            'type' => 'text',
            'section' => 'blog_post_grid_section',
        ));

        // Blog Grid Excerpt Length
        $wp_customize->add_setting('blog_grid_excerpt_length', array(
            'transport' => 'refresh',
            'default' => 28,
            'sanitize_callback' => 'absint',
        ));
        $wp_customize->add_control('blog_grid_excerpt_length', array(
            'label' => __('Grid excerpt text content length', 'nebon'),
            'description' => __('Enter number of character want to get from excerpt content. Default is 0(hidden). Example is 80. Note: This value only apply for items style can be show excerpt.', 'nebon'),
            'type' => 'number',
            'section' => 'blog_post_grid_section',
        ));

        // Blog Grid Display Style
        $wp_customize->add_setting('blog_grid_display_style', array(
            'transport' => 'refresh',
            'default' => 'default',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control('blog_grid_display_style', array(
            'label' => __('Grid display', 'nebon'),
            'description' => __('Choose a style to active display', 'nebon'),
            'type' => 'select',
            'section' => 'blog_post_grid_section',
            'choices' => array(
                'default' => __('Default', 'nebon'),
                'masory' => __('masory', 'nebon')
            )
        ));

        // Sidebar Single Post
        $wp_customize->add_setting('sidebar_single_post', array(
            'transport' => 'refresh',
            'default' => 'left',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control('sidebar_single_post', array(
            'label' => __('Sidebar Single Post Position', 'nebon'),
            'description' => __('Set sidebar position for your post detail page. Left, Right, or No sidebar.', 'nebon'),
            'type' => 'select',
            'section' => 'post_detail_section',
            'choices' => array(
                'left' => __('Left Sidebar', 'nebon'),
                'right' => __('Right Sidebar', 'nebon'),
                'no_sidebar' => __('No Sidebar', 'nebon'),
            )
        ));

        // Sidebar Select Display
        $wp_customize->add_setting('sidebar_select_display', array(
            'transport' => 'refresh',
            'default' => 'choose_one',
            'sanitize_callback' => [$this, 'sanitize_sidebar_choice'],
        ));
        $wp_customize->add_control('sidebar_select_display', array(
            'label' => __('Sidebar select display in single post', 'nebon'),
            'description' => __('Choose a sidebar to display.', 'nebon'),
            'type' => 'select',
            'section' => 'post_detail_section',
            'choices' => $this->get_sidebar_widgets(),
            'active_callback' => function ($control) {
                return $control->manager->get_setting('sidebar_single_post')->value() !== 'no_sidebar';
            },
        ));

        // Show Thumbnail/Media (fix key name with slash)
        $wp_customize->add_setting('show_thumbnail_media', array(
            'default' => 'off',
            'transport' => 'refresh',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control('show_thumbnail_media', array(
            'label' => __('Show featured image ', 'nebon'),
            'description' => __('Show/hide featured image on post detail (standard post).', 'nebon'),
            'type' => 'radio',
            'section' => 'post_detail_section',
            'choices' => array(
                'on' => __('on', 'nebon'),
                'off' => __('off', 'nebon'),
            ),
            'active_callback' => function ($control) {
                return $control->manager->get_setting('sidebar_single_post')->value() == 'no_sidebar';
            },
        ));

        // Show Meta Data
        // $wp_customize->add_setting('show_meta_data', array(
        //     'default' => 'off',
        //     'transport' => 'refresh',
        //     'sanitize_callback' => 'sanitize_text_field',
        // ));
        // $wp_customize->add_control('show_meta_data', array(
        //     'label' => __('Show meta data', 'nebon'),
        //     'description' => __('Show/hide meta data(author, date, comments, categories, tags) on post detail.', 'nebon'),
        //     'type' => 'radio',
        //     'section' => 'post_detail_section',
        //     'choices' => array(
        //         'on' => __('on', 'nebon'),
        //         'off' => __('off', 'nebon'),
        //     )
        // ));

          // Show Share Box (Post only)
        $wp_customize->add_setting('show_share_box', array(
            'default'           => false,
            'transport'         => 'refresh',
            'sanitize_callback' => 'rest_sanitize_boolean',
        ));

        $wp_customize->add_control('show_share_box', array(
            'label'       => __('Show share box on Post', 'nebon'),
            'description' => __('Enable or disable social share box on single posts.', 'nebon'),
            'section'     => 'post_detail_section',
            'type'        => 'checkbox',
        ));


        // List Share Social
        $wp_customize->add_setting('list_share_social', array(
            'default' => array(
                'instagram',
                'facebook',
                'tiktok',
                'twitter',
            ),
            'sanitize_callback' => 't888_sanitize_list_share_social',
            'transport' => 'refresh',
        ));
        $wp_customize->add_control(new WP_Customize_Multiple_Checkbox_Control(
            $wp_customize,
            'list_share_social',
            array(
                'label' => __('List social share', 'nebon'),
                'description' => 'List social share in posts',
                'section' => 'post_detail_section',
                'type' => 'multiple-checkbox',
                'choices' => array(
                    'facebook' => __('Facebook', 'nebon'),
                    'pinterest' => __('Pinterest', 'nebon'),
                    'instagram' => __('Instagram', 'nebon'),
                    'youtube' => __('YouTube', 'nebon'),
                    'twitter' => __('X (twitter)', 'nebon'),
                    'linkedin' => __('LinkedIn', 'nebon'),
                    'whatsapp' => __('WhatsApp', 'nebon'),
                    'telegram' => __('Telegram', 'nebon'),
                    'email' => __('Email', 'nebon'),
                ),
            )
        ));

        // Show Author Box
        // $wp_customize->add_setting('show_author_box', array(
        //     'default' => 'off',
        //     'transport' => 'refresh',
        //     'sanitize_callback' => 'sanitize_text_field',
        // ));
        // $wp_customize->add_control('show_author_box', array(
        //     'label' => __('Show author box', 'nebon'),
        //     'description' => __('Show/hide author box on post detail.', 'nebon'),
        //     'type' => 'radio',
        //     'section' => 'post_detail_section',
        //     'choices' => array(
        //         'on' => __('on', 'nebon'),
        //         'off' => __('off', 'nebon'),
        //     )
        // ));

        // Show Navigation Post
        $wp_customize->add_setting('show_navigation_post', array(
            'default' => 'on',
            'transport' => 'refresh',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control('show_navigation_post', array(
            'label' => __('Show navigation post', 'nebon'),
            'description' => __('Show/hide navigation to next post or previous post on the post detail.', 'nebon'),
            'type' => 'radio',
            'section' => 'post_detail_section',
            'choices' => array(
                'on' => __('on', 'nebon'),
                'off' => __('off', 'nebon'),
            )
        ));

        // Show Related Post
        $wp_customize->add_setting('show_related_post', array(
            'default' => 'off',
            'transport' => 'refresh',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control('show_related_post', array(
            'label' => __('Show related post', 'nebon'),
            'description' => __('Show/hide related post on the post detail.', 'nebon'),
            'type' => 'radio',
            'section' => 'post_detail_section',
            'choices' => array(
                'on' => __('on', 'nebon'),
                'off' => __('off', 'nebon'),
            )
        ));

        // Related Title
        $wp_customize->add_setting('related_title', array(
            'default' => '',
            'transport' => 'refresh',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control('related_title', array(
            'label' => __('Related title', 'nebon'),
            'description' => __('Enter title of related section.', 'nebon'),
            'type' => 'text',
            'section' => 'post_detail_section',
            'active_callback' => function ($control) {
                return $control->manager->get_setting('show_related_post')->value() === 'on';
            },
        ));

        // Related Post Heading Icon
        $wp_customize->add_setting('related_post_heading_icon', array(
            'transport' => 'refresh',
            'default' => 'las la-rainbow',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control('related_post_heading_icon', array(
            'label' => __('Related Products Heading Icon', 'nebon'),
            'type' => 'text',
            'section' => 'post_detail_section',
            'description' => __('Enter Line Awesome icon class, e.g. las la-rainbow', 'nebon'),
            'active_callback' => function ($control) {
                return $control->manager->get_setting('show_related_post')->value() === 'on';
            },
        ));

        // Related Num Post
        $wp_customize->add_setting('related_num_post', array(
            'default' => '',
            'transport' => 'refresh',
            'sanitize_callback' => 'absint',
        ));
        $wp_customize->add_control('related_num_post', array(
            'label' => __('Related number post', 'nebon'),
            'description' => __('Enter number of related post to display.', 'nebon'),
            'type' => 'number',
            'section' => 'post_detail_section',
            'active_callback' => function ($control) {
                return $control->manager->get_setting('show_related_post')->value() === 'on';
            },
        ));

        // Related Custom Number
        // $wp_customize->add_setting('related_custom_number', array(
        //     'default' => '',
        //     'transport' => 'refresh',
        //     'sanitize_callback' => 'sanitize_text_field',
        // ));
        // $wp_customize->add_control('related_custom_number', array(
        //     'label' => __('Related custom number item responsive', 'nebon'),
        //     'description' => __('Enter item for screen width(px) format is width:value and separate values by ",". Example is 0:2,600:3,1000:4. Default is auto.', 'nebon'),
        //     'type' => 'text',
        //     'section' => 'post_detail_section',
        //     'active_callback' => function ($control) {
        //         return $control->manager->get_setting('show_related_post')->value() === 'on';
        //     },
        // ));

        // Related Item Style
        // $wp_customize->add_setting('related_item_style', array(
        //     'default' => '',
        //     'transport' => 'refresh',
        //     'sanitize_callback' => 'sanitize_text_field',
        // ));
        // $wp_customize->add_control('related_item_style', array(
        //     'label' => __('Related item style', 'nebon'),
        //     'description' => __('Need to be checked', 'nebon'),
        //     'type' => 'text',
        //     'section' => 'post_detail_section',
        //     'active_callback' => function ($control) {
        //         return $control->manager->get_setting('show_related_post')->value() === 'on';
        //     },
        // ));
    }

    public function add_shop_product_settings($wp_customize)
    {
        // ===== SHOP GENERAL SETTINGS =====

        // Sidebar Position WooCommerce page
        $wp_customize->add_setting('sidebar_position_woo_page_general', array(
            'transport' => 'refresh',
            'default' => 'no_sidebar',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control('sidebar_position_woo_page_general', array(
            'label' => __('Sidebar Position WooCommerce page', 'nebon'),
            'description' => __('Set sidebar position for your woocommerce page(Shop, Checkout, Cart, My Account, Product category/tag/taxonomy page...). Left, Right, or No sidebar.', 'nebon'),
            'type' => 'select',
            'choices' => array(
                'no_sidebar' => __('No Sidebar', 'nebon'),
                'left' => __('Left Sidebar', 'nebon'),
                'right' => __('Right Sidebar', 'nebon'),
            ),
            'section' => 'setting_general_shop_section',
        ));

        // Sidebar Select WooCommerce page
        $wp_customize->add_setting('sidebar_select_woo_page_general', array(
            'transport' => 'refresh',
            'default' => 'choose_one',
            'sanitize_callback' => [$this, 'sanitize_sidebar_choice'],
        ));
        $wp_customize->add_control('sidebar_select_woo_page_general', array(
            'label' => __('Sidebar select WooCommerce page', 'nebon'),
            'description' => __('Choose one style of sidebar for WooCommerce page', 'nebon'),
            'type' => 'select',
            'choices' => $this->get_sidebar_widgets(),
            'section' => 'setting_general_shop_section',
            'active_callback' => function ($control) {
                return $control->manager->get_setting('sidebar_position_woo_page_general')->value() !== 'no_sidebar';
            },
        ));

        // Shop Default Item Style
        $wp_customize->add_setting('shop_default_item_style_general', array(
            'transport' => 'refresh',
            'default' => 'list',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control('shop_default_item_style_general', array(
            'label' => __('Shop Default Item Style', 'nebon'),
            'description' => __('Choose a style to active display', 'nebon'),
            'type' => 'select',
            'choices' => array(
                'list' => __('List', 'nebon'),
                'grid' => __('Grid', 'nebon'),
            ),
            'section' => 'setting_general_shop_section',
        ));

        // Gap Products
        $wp_customize->add_setting('gap_products_general', array(
            'transport' => 'refresh',
            'default' => '30',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control('gap_products_general', array(
            'label' => __('Gap Products', 'nebon'),
            'description' => __('Choose space. The space between the items on the shop page.', 'nebon'),
            'type' => 'select',
            'choices' => array(
                '0' => __('0', 'nebon'),
                '5' => __('5', 'nebon'),
                '10' => __('10', 'nebon'),
                '15' => __('15', 'nebon'),
                '20' => __('20', 'nebon'),
                '25' => __('25', 'nebon'),
                '30' => __('30', 'nebon'),
            ),
            'section' => 'setting_general_shop_section'
        ));

        // Product Number
        $wp_customize->add_setting('product_number_general', array(
            'transport' => 'refresh',
            'default' => 12,
            'sanitize_callback' => 'absint',
        ));
        $wp_customize->add_control('product_number_general', array(
            'label' => __('Product Number', 'nebon'),
            'description' => __('Enter number product to display per page. Default is 12.', 'nebon'),
            'type' => 'number',
            'section' => 'setting_general_shop_section'
        ));

        // Product New in Days
        $wp_customize->add_setting('product_new_in_days_general', array(
            'transport' => 'refresh',
            'sanitize_callback' => 'sanitize_text_field',
            'default' => '30',
        ));
        $wp_customize->add_control('product_new_in_days_general', array(
            'label' => __('Product new in(days)', 'nebon'),
            'description' => __('Enter number to set time for product is new. Unit day. Default is 30.', 'nebon'),
            'type' => 'text',
            'section' => 'setting_general_shop_section'
        ));

        // Shop Pagination (Pagination vs Load more)
        $wp_customize->add_setting('shop_pagination_general', array(
            'default'           => 'pagination', // pagination | loadmore
            'transport'         => 'refresh',
            'sanitize_callback' => function ($value) {
                $allowed = array('pagination', 'loadmore');
                return in_array($value, $allowed, true) ? $value : 'pagination';
            },
        ));

        $wp_customize->add_control('shop_pagination_general', array(
            'label'       => __('Shop pagination', 'nebon'),
            'description' => __('Choose how products navigation is displayed', 'nebon'),
            'type'        => 'select',
            'choices'     => array(
                'pagination' => __('Pagination', 'nebon'),
                'loadmore'   => __('Load More (enable with shop Ajax turn on)', 'nebon'),
            ),
            'section'     => 'setting_general_shop_section',
        ));

        // Shop Ajax Filter
        $wp_customize->add_setting('shop_ajax_general', array(
            'transport' => 'refresh',
            'default' => 'off',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control('shop_ajax_general', array(
            'label' => __('Shop Ajax Filter', 'nebon'),
            'description' => __('Enable ajax process for your shop page.', 'nebon'),
            'type' => 'radio',
            'choices' => array(
                'on' => __('on', 'nebon'),
                'off' => __('off', 'nebon'),
            ),
            'section' => 'setting_general_shop_section'
        ));

        // Thumbnail Animation
        $wp_customize->add_setting('thumbnail_animation_general', array(
            'transport' => 'refresh',
            'default' => 'choose_one',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control('thumbnail_animation_general', array(
            'label' => __('Thumbnail animation', 'nebon'),
            'description' => __('Choose a animation.', 'nebon'),
            'type' => 'select',
            'choices' => $this->get_product_thumb_animation(),
            'section' => 'setting_general_shop_section'
        ));

        // Number Filter
        $wp_customize->add_setting('num_filter_general', array(
            'transport' => 'refresh',
            'default' => 'off',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control('num_filter_general', array(
            'label' => __('Show number filter', 'nebon'),
            'description' => __('Show/hide items per page filter on shop page.', 'nebon'),
            'type' => 'radio',
            'choices' => array(
                'on' => __('on', 'nebon'),
                'off' => __('off', 'nebon'),
            ),
            'section' => 'setting_general_shop_section'
        ));

        // Show Type Filter
        $wp_customize->add_setting('show_type_filter_general', array(
            'transport' => 'refresh',
            'default' => 'off',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control('show_type_filter_general', array(
            'label' => __('Show shop style filter', 'nebon'),
            'description' => __('Show/hide shop style filter (Grid/List Display) on shop page.', 'nebon'),
            'type' => 'radio',
            'choices' => array(
                'on' => __('on', 'nebon'),
                'off' => __('off', 'nebon'),
            ),
            'section' => 'setting_general_shop_section'
        ));

        // Show Custom Ordering Dropdown
        $wp_customize->add_setting('show_custom_ordering_dropdown', array(
            'transport' => 'refresh',
            'default' => 'on',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control('show_custom_ordering_dropdown', array(
            'label' => __('Show custom ordering dropdown', 'nebon'),
            'description' => __('Show/hide custom ordering dropdown on shop page.', 'nebon'),
            'type' => 'radio',
            'choices' => array(
                'on' => __('on', 'nebon'),
                'off' => __('off', 'nebon'),
            ),
            'section' => 'setting_general_shop_section'
        ));

        // Custom List Thumbnail Size
        $wp_customize->add_setting('custom_list_thumbnail_size', array(
            'transport' => 'refresh',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control('custom_list_thumbnail_size', array(
            'label' => __('Custom list thumbnail size', 'nebon'),
            'description' => __('Enter size thumbnail to crop. [width]x[height]. Example is 327x248.', 'nebon'),
            'type' => 'text',
            'section' => 'list_settings_shop_section',
        ));

        // Shop List Item Style
        $wp_customize->add_setting('shop_list_item_style', array(
            'transport' => 'refresh',
            'default' => '',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control('shop_list_item_style', array(
            'label' => __('Shop List item style', 'nebon'),
            'description' => __('Choose a style to active display', 'nebon'),
            'type' => 'select',
            'choices' => $this->get_product_list_style(),
            'section' => 'list_settings_shop_section',
        ));

        // Grid Column
        $wp_customize->add_setting('grid_column_grid_setting', array(
            'transport' => 'refresh',
            'default' => '3',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control('grid_column_grid_setting', array(
            'label' => __('Grid column', 'nebon'),
            'description' => __('Choose a style to active display', 'nebon'),
            'type' => 'select',
            'choices' => array(
                '2' => __('2 columns', 'nebon'),
                '3' => __('3 columns', 'nebon'),
                '4' => __('4 columns', 'nebon'),
                '5' => __('5 columns', 'nebon'),
            ),
            'section' => 'grid_settings_shop_section',
        ));

        // Custom Grid Thumbnail Size
        $wp_customize->add_setting('custom_grid_grid_setting', array(
            'transport' => 'refresh',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control('custom_grid_grid_setting', array(
            'label' => __('Custom grid thumbnail size', 'nebon'),
            'description' => __('Enter size thumbnail to crop. [width]x[height]. Example is 327x482.', 'nebon'),
            'type' => 'text',
            'section' => 'grid_settings_shop_section',
        ));

        // Grid Item Style
        $wp_customize->add_setting('grid_item_grid_setting', array(
            'transport' => 'refresh',
            'default' => '',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control('grid_item_grid_setting', array(
            'label' => __('Grid item style', 'nebon'),
            'description' => __('Choose a style to active display', 'nebon'),
            'type' => 'select',
            'choices' => $this->get_product_grid_style(),
            'section' => 'grid_settings_shop_section',
        ));

        // Grid Display
        // $wp_customize->add_setting('grid_display_grid_setting', array(
        //     'transport' => 'refresh',
        //     'default' => 'masanory',
        //     'sanitize_callback' => 'sanitize_text_field',
        // ));
        // $wp_customize->add_control('grid_display_grid_setting', array(
        //     'label' => __('Grid display', 'nebon'),
        //     'description' => __('Choose a style to active display', 'nebon'),
        //     'type' => 'select',
        //     'choices' => array(
        //         'masanory' => __('masanory', 'nebon'),
        //     ),
        //     'section' => 'grid_settings_shop_section',
        // ));

        // Cart Display
        $wp_customize->add_setting('cart_display_advanced', array(
            'transport' => 'refresh',
            'default' => 'default',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control('cart_display_advanced', array(
            'label' => __('Cart display', 'nebon'),
            'description' => __('Choose a style to active display', 'nebon'),
            'type' => 'select',
            'choices' => array(
                'default' => __('Default', 'nebon'),
            ),
            'section' => 'advanced_settings_shop_section',
        ));

        // Checkout Display
        $wp_customize->add_setting('checkout_display_advanced', array(
            'transport' => 'refresh',
            'default' => 'default',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control('checkout_display_advanced', array(
            'label' => __('Checkout display', 'nebon'),
            'description' => __('Choose a style to active display', 'nebon'),
            'type' => 'select',
            'choices' => array(
                'default' => __('Default', 'nebon'),
            ),
            'section' => 'advanced_settings_shop_section',
        ));

        // Append Content Before Shop
        $wp_customize->add_setting('append_content_before_shop', array(
            'transport' => 'refresh',
            'default' => 'choose_one',
            'sanitize_callback' => 'absint',
        ));
        $wp_customize->add_control('append_content_before_shop', array(
            'label' => __('Append content before Woocommerce page', 'nebon'),
            'description' => __('Choose a mega page content append to before main content of page/post.', 'nebon'),
            'type' => 'select',
            'choices' => self::_tech888f_list_post_type('mega_item', false),
            'section' => 'advanced_settings_shop_section',
        ));

        // Append Content After Shop
        $wp_customize->add_setting('append_content_after_shop', array(
            'transport' => 'refresh',
            'default' => 'choose_one',
            'sanitize_callback' => 'absint',
        ));
        $wp_customize->add_control('append_content_after_shop', array(
            'label' => __('Append content after Woocommerce page', 'nebon'),
            'description' => __('Choose a mega page content append to after main content of page/post.', 'nebon'),
            'type' => 'select',
            'choices' => self::_tech888f_list_post_type('mega_item', false),
            'section' => 'advanced_settings_shop_section',
        ));

        // ===== PRODUCT SETTINGS =====

        // Product Detail Style
        $wp_customize->add_setting('product_detail_style_general', array(
            'transport' => 'refresh',
            'default' => 'normal',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control('product_detail_style_general', array(
            'label' => __('Product detail style', 'nebon'),
            'description' => __('Choose a style to active display', 'nebon'),
            'type' => 'select',
            'choices' => array(
                'normal' => __('Default style (swiper)', 'nebon'),
                'sticky' => __('Fixed info', 'nebon'),
            ),
            'section' => 'product_setting_general',
        ));

        // Product Tab Style
        $wp_customize->add_setting('product_tab_style_general', array(
            'transport' => 'refresh',
            'default' => 'tab_style_horizontal',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control('product_tab_style_general', array(
            'label' => __('Product tab style', 'nebon'),
            'description' => __('Choose a style to display', 'nebon'),
            'type' => 'select',
            'choices' => array(
                'tab_style_horizontal' => __('Horizontal', 'nebon'),
                'tab_style_accordion' => __('Accordion', 'nebon'),
            ),
            'section' => 'product_setting_general',
        ));

        // Show Excerpt
        // $wp_customize->add_setting('show_excerp', array(
        //     'transport' => 'refresh',
        //     'default' => 'on',
        //     'sanitize_callback' => 'sanitize_text_field',
        // ));
        // $wp_customize->add_control('show_excerp', array(
        //     'label' => __('Show excerpt', 'nebon'),
        //     'type' => 'radio',
        //     'choices' => array(
        //         'on' => __('On', 'nebon'),
        //         'off' => __('Off', 'nebon'),
        //     ),
        //     'section' => 'product_setting_general',
        // ));

        // Show Sticky Add to Cart
        $wp_customize->add_setting('show_sticky_add_to_cart', array(
            'transport' => 'refresh',
            'default' => 'off',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control('show_sticky_add_to_cart', array(
            'label' => __('Show sticky add to cart (Simple Product only)', 'nebon'),
            'type' => 'radio',
            'choices' => array(
                'on' => __('On', 'nebon'),
                'off' => __('Off', 'nebon'),
            ),
            'section' => 'product_setting_general',
        ));

        // Show User Guide
        $wp_customize->add_setting('show_user_guide', array(
            'transport' => 'refresh',
            'default' => 'on',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control('show_user_guide', array(
            'label' => __('Show user guide', 'nebon'),
            'type' => 'radio',
            'choices' => array(
                'on' => __('On', 'nebon'),
                'off' => __('Off', 'nebon'),
            ),
            'section' => 'product_setting_extra_display',
        ));

        // Show User Guide Label
        $wp_customize->add_setting('show_user_guide_label', array(
            'default' => __('User guide', 'nebon'),
            'transport' => 'refresh',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control('show_user_guide_label', array(
            'label' => __('Label: User guide', 'nebon'),
            'type' => 'text',
            'section' => 'product_setting_extra_display',
            'active_callback' => function ($control) {
                return $control->manager->get_setting('show_user_guide')->value() === 'on';
            },
        ));

        // Show Shipping
        $wp_customize->add_setting('show_shipping', array(
            'transport' => 'refresh',
            'default' => 'on',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control('show_shipping', array(
            'label' => __('Show shipping', 'nebon'),
            'type' => 'radio',
            'choices' => array(
                'on' => __('On', 'nebon'),
                'off' => __('Off', 'nebon'),
            ),
            'section' => 'product_setting_extra_display',
        ));

        // Show Shipping Label
        $wp_customize->add_setting('show_shipping_label', array(
            'default' => __('Shipping', 'nebon'),
            'transport' => 'refresh',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control('show_shipping_label', array(
            'label' => __('Label: Shipping', 'nebon'),
            'type' => 'text',
            'section' => 'product_setting_extra_display',
            'active_callback' => function ($control) {
                return $control->manager->get_setting('show_shipping')->value() === 'on';
            },
        ));

        // Shipping Popup Title
        $wp_customize->add_setting('shipping_popup_title', array(
            'default' => __('NEBON FREE SHIPPING:', 'nebon'),
            'transport' => 'refresh',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control('shipping_popup_title', array(
            'label' => __('Popup Title', 'nebon'),
            'type' => 'text',
            'section' => 'product_setting_extra_display',
            'active_callback' => function ($control) {
                return $control->manager->get_setting('show_shipping')->value() === 'on';
            },
        ));

        // Shipping Popup Item 1 Title
        $wp_customize->add_setting('shipping_popup_item1_title', array(
            'default' => __('DELIVERY', 'nebon'),
            'transport' => 'refresh',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control('shipping_popup_item1_title', array(
            'label' => __('Item 1 - Title', 'nebon'),
            'type' => 'text',
            'section' => 'product_setting_extra_display',
            'active_callback' => function ($control) {
                return $control->manager->get_setting('show_shipping')->value() === 'on';
            },
        ));

        // Shipping Popup Item 1 Content
        $wp_customize->add_setting('shipping_popup_item1_content', array(
            'default' => __('Delivery of the Products ordered by the Client is possible in all countries...', 'nebon'),
            'transport' => 'refresh',
            'sanitize_callback' => 'wp_kses_post',
        ));
        $wp_customize->add_control('shipping_popup_item1_content', array(
            'label' => __('Item 1 - Content', 'nebon'),
            'type' => 'textarea',
            'section' => 'product_setting_extra_display',
            'active_callback' => function ($control) {
                return $control->manager->get_setting('show_shipping')->value() === 'on';
            },
        ));

        // Shipping Popup Item 2 Title
        $wp_customize->add_setting('shipping_popup_item2_title', array(
            'default' => __('DELIVERY TIMES', 'nebon'),
            'transport' => 'refresh',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control('shipping_popup_item2_title', array(
            'label' => __('Item 2 - Title', 'nebon'),
            'type' => 'text',
            'section' => 'product_setting_extra_display',
            'active_callback' => function ($control) {
                return $control->manager->get_setting('show_shipping')->value() === 'on';
            },
        ));

        // Shipping Popup Item 2 Content
        $wp_customize->add_setting('shipping_popup_item2_content', array(
            'default' => __('The purchased Products will be shipped by Colissimo...', 'nebon'),
            'transport' => 'refresh',
            'sanitize_callback' => 'wp_kses_post',
        ));
        $wp_customize->add_control('shipping_popup_item2_content', array(
            'label' => __('Item 2 - Content', 'nebon'),
            'type' => 'textarea',
            'section' => 'product_setting_extra_display',
            'active_callback' => function ($control) {
                return $control->manager->get_setting('show_shipping')->value() === 'on';
            },
        ));

        // Show Share
        $wp_customize->add_setting('show_share', array(
            'transport' => 'refresh',
            'default' => 'on',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control('show_share', array(
            'label' => __('Show share', 'nebon'),
            'type' => 'radio',
            'choices' => array(
                'on' => __('On', 'nebon'),
                'off' => __('Off', 'nebon'),
            ),
            'section' => 'product_setting_extra_display',
        ));

        // Show Share Label
        $wp_customize->add_setting('show_share_label', array(
            'default' => __('Share', 'nebon'),
            'transport' => 'refresh',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control('show_share_label', array(
            'label' => __('Label: Share', 'nebon'),
            'type' => 'text',
            'section' => 'product_setting_extra_display',
            'active_callback' => function ($control) {
                return $control->manager->get_setting('show_share')->value() === 'on';
            },
        ));

        // Show Latest Products
        $wp_customize->add_setting('show_latest_products', array(
            'transport' => 'refresh',
            'default' => 'on',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control('show_latest_products', array(
            'label' => __('Show latest products', 'nebon'),
            'type' => 'radio',
            'choices' => array(
                'on' => __('on', 'nebon'),
                'off' => __('off', 'nebon'),
            ),
            'section' => 'product_setting_extra_display',
        ));
        $wp_customize->add_setting('latest_products_heading_title', array(
            'transport' => 'refresh',
            'default' => __('Latest Products', 'nebon'),
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control('latest_products_heading_title', array(
            'label' => __('Latest Products Heading Title', 'nebon'),
            'type' => 'text',
            'section' => 'product_setting_extra_display',
            'active_callback' => function () {
                return get_theme_mod('show_latest_products', 'on') === 'on';
            },
        ));

        // Show Upsell Products
        $wp_customize->add_setting('show_upsell_product_extra_display', array(
            'transport' => 'refresh',
            'default' => 'on',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control('show_upsell_product_extra_display', array(
            'label' => __('Show upsell products', 'nebon'),
            'type' => 'radio',
            'choices' => array(
                'on' => __('on', 'nebon'),
                'off' => __('off', 'nebon'),
            ),
            'section' => 'product_setting_extra_display',
        ));
        $wp_customize->add_setting('upsell_products_heading_title', array(
            'transport' => 'refresh',
            'default' => __('You May Also Like', 'nebon'),
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control('upsell_products_heading_title', array(
            'label' => __('Upsell Products Heading Title', 'nebon'),
            'type' => 'text',
            'section' => 'product_setting_extra_display',
            'active_callback' => function () {
                return get_theme_mod('show_upsell_product_extra_display', 'on') === 'on';
            },
        ));

        // Show Related Products
        $wp_customize->add_setting('show_related_products_extra_display', array(
            'transport' => 'refresh',
            'default' => 'on',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control('show_related_products_extra_display', array(
            'label' => __('Show related products', 'nebon'),
            'type' => 'radio',
            'choices' => array(
                'on' => __('on', 'nebon'),
                'off' => __('off', 'nebon'),
            ),
            'section' => 'product_setting_extra_display',
        ));

        // Related Products Heading Title
        $wp_customize->add_setting('related_products_heading_title', array(
            'transport' => 'refresh',
            'default' => __('You May Also Like', 'nebon'),
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control('related_products_heading_title', array(
            'label' => __('Related Products Heading Title', 'nebon'),
            'type' => 'text',
            'section' => 'product_setting_extra_display',
            'active_callback' => function () {
                return get_theme_mod('show_related_products_extra_display', 'on') === 'on';
            },
        ));

        // Related Products Heading Icon
        // $wp_customize->add_setting('related_products_heading_icon', array(
        //     'transport' => 'refresh',
        //     'default' => 'las la-rainbow',
        //     'sanitize_callback' => 'sanitize_text_field',
        // ));
        // $wp_customize->add_control('related_products_heading_icon', array(
        //     'label' => __('Related Products Heading Icon', 'nebon'),
        //     'type' => 'text',
        //     'section' => 'product_setting_extra_display',
        //     'description' => __('Enter Line Awesome icon class, e.g. las la-star', 'nebon'),
        // ));

        // Single Number
        $wp_customize->add_setting('single_number_extra_display', array(
            'transport' => 'refresh',
            'default' => 6,
            'sanitize_callback' => 'absint',
        ));
        $wp_customize->add_control('single_number_extra_display', array(
            'label' => __('Show Single Number', 'nebon'),
            'type' => 'number',
            'section' => 'product_setting_extra_display',
        ));

        // Show Single Size
        // $wp_customize->add_setting('show_single_size_extra_display', array(
        //     'transport' => 'refresh',
        //     'sanitize_callback' => 'sanitize_text_field',
        // ));
        // $wp_customize->add_control('show_single_size_extra_display', array(
        //     'label' => __('Show Single Size', 'nebon'),
        //     'description' => __('Custom size for related,upsell products. Enter size thumbnail to crop. [width]x[height]. Example is 300x300.', 'nebon'),
        //     'type' => 'text',
        //     'section' => 'product_setting_extra_display',
        // ));

        // Single Item Style
        // $wp_customize->add_setting('single_item_style_extra_display', array(
        //     'transport' => 'refresh',
        //     'default' => '',
        //     'sanitize_callback' => 'sanitize_text_field',
        // ));
        // $wp_customize->add_control('single_item_style_extra_display', array(
        //     'label' => __('Single related,upsell item style', 'nebon'),
        //     'description' => __('Choose a style to active display', 'nebon'),
        //     'type' => 'select',
        //     'choices' => $this->get_single_product_style(),
        //     'section' => 'product_setting_extra_display',
        // ));

        // Image Safe Checkout Repeater
        $wp_customize->add_setting('image_safe_checkout_repeater', array(
            'default' => '[]',
            'sanitize_callback' => 'wp_kses_post', // Changed from customizer_repeater_sanitize
            'transport' => 'refresh',
        ));
        $wp_customize->add_control(new \Customizer_Repeater(
            $wp_customize,
            'image_safe_checkout_repeater',
            array(
                'label' => __('Image safe check out', 'nebon'),
                'section' => 'product_setting_extra_display',
                'priority' => 160,
                'customizer_repeater_image_only_control' => true,
            )
        ));

        // Append Content Before Product Page
        $wp_customize->add_setting('append_content_before_product_page', array(
            'transport' => 'refresh',
            'default' => 'choose_one',
            'sanitize_callback' => 'absint',
        ));
        $wp_customize->add_control('append_content_before_product_page', array(
            'label' => __('Append content before product page', 'nebon'),
            'description' => __('Choose a mega page content append to before single product.', 'nebon'),
            'type' => 'select',
            'choices' => self::_tech888f_list_post_type('mega_item', false),
            'section' => 'product_setting_advanced',
        ));

        // Append Content Before Product Tab
        $wp_customize->add_setting('append_content_before_product_tab', array(
            'transport' => 'refresh',
            'default' => 'choose_one',
            'sanitize_callback' => 'absint',
        ));
        $wp_customize->add_control('append_content_before_product_tab', array(
            'label' => __('Append content before product tab', 'nebon'),
            'description' => __('Choose a mega page content append to before product tab.', 'nebon'),
            'type' => 'select',
            'choices' => self::_tech888f_list_post_type('mega_item', false),
            'section' => 'product_setting_advanced',
        ));

        // Append Content After Product Tab
        $wp_customize->add_setting('append_content_after_product_tab', array(
            'transport' => 'refresh',
            'default' => 'choose_one',
            'sanitize_callback' => 'absint',
        ));
        $wp_customize->add_control('append_content_after_product_tab', array(
            'label' => __('Append content after product tab', 'nebon'),
            'description' => __('Choose a mega page content append to after product tab.', 'nebon'),
            'type' => 'select',
            'choices' => self::_tech888f_list_post_type('mega_item', false),
            'section' => 'product_setting_advanced',
        ));

        // Append Content After Product Page
        $wp_customize->add_setting('append_content_after_product_page', array(
            'transport' => 'refresh',
            'default' => 'choose_one',
            'sanitize_callback' => 'absint',
        ));
        $wp_customize->add_control('append_content_after_product_page', array(
            'label' => __('Append content after product page', 'nebon'),
            'description' => __('Choose a mega page content append to after single product.', 'nebon'),
            'type' => 'select',
            'choices' => self::_tech888f_list_post_type('mega_item', false),
            'section' => 'product_setting_advanced',
        ));
    }
    function t888f_sanitize_size($value)
    {
        $value = trim($value);
        return preg_match('/^\d{2,5}x\d{2,5}$/', $value) ? $value : '';
    }
    function t888f_parse_size($value)
    {
        if (!$value) return null;
        if (preg_match('/^(\d{2,5})x(\d{2,5})$/', $value, $m)) {
            return [(int)$m[1], (int)$m[2]];
        }
        return null;
    }

    /**
     * Register customizer settings and controls.
     * 
     * @param WP_Customize_Manager $wp_customize The customizer manager object.
     */
    public function t888f_customize_register($wp_customize)
    {

        $this->add_panels($wp_customize);

        $this->add_sections($wp_customize);

        $this->add_header_settings($wp_customize);

        $this->add_footer_settings($wp_customize);

        $this->add_typography_settings($wp_customize);

        $this->add_layout_settings($wp_customize);

        $this->add_breadcrumb_settings($wp_customize);

        $this->add_color_settings($wp_customize);

        $this->add_menu_settings($wp_customize);

        $this->add_other_settings($wp_customize);

        $this->add_blog_post_settings($wp_customize);

        $this->add_shop_product_settings($wp_customize);

        $this->add_upload_font_settings($wp_customize);
    }
}
Customizer_Settings::get_instance();
