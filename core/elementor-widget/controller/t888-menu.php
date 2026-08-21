<?php

namespace Elementor;

class T888_Menu extends T888_Widget_Base
{
    public function get_name()
    {
        return 't888-menu';
    }

    public function get_title()
    {
        return __('Navigation Menu', 'nebon');
    }

    public function get_icon()
    {
        return 'eicon-nav-menu';
    }

    public function get_categories()
    {
        return ['t888-elements'];
    }

    public function get_style_depends()
    {
        return [];
    }

    public function get_script_depends()
    {
        return [];
    }

    protected function _register_controls()
    {
        // Content Section
        $this->start_controls_section(
            'section_menu_content',
            [
                'label' => __('Menu Content', 'nebon'),
            ]
        );

        // Get all menus
        $menus = wp_get_nav_menus();
        $menu_options = [];

        foreach ($menus as $menu) {
            $menu_options[$menu->term_id] = $menu->name;
        }

        if (empty($menu_options)) {
            $menu_options[''] = __('No menus found', 'nebon');
        }

        $this->add_control(
            'menu_id',
            [
                'label' => __('Select Menu', 'nebon'),
                'type' => Controls_Manager::SELECT,
                'options' => $menu_options,
                'default' => '',
                'description' => __('Choose the WordPress menu to display. Style 5 always uses this selected menu; other styles may use the assigned location below.', 'nebon'),
            ]
        );

        $this->add_control(
            'menu_location',
            [
                'label' => __('Menu Location', 'nebon'),
                'type' => Controls_Manager::SELECT,
                'options' => $this->get_all_menu_locations(),
                'default' => '',
                'description' => __('Optional location fallback. In Style 5 it is used only when Select Menu is empty.', 'nebon'),
            ]
        );

        $this->add_control(
            'menu_location_categories_mobile',
            [
                'label' => __('Category Menu Location (for Categories Tab in Mobile)', 'nebon'),
                'type' => Controls_Manager::SELECT,
                'options' => $this->get_all_menu_locations(),
                'default' => '',
                'description' => __('Select the theme location to display the category menu in mobile view.', 'nebon'),
                'condition' => [
                    'style' => 'style3',
                ],
            ]
        );

        $this->add_control(
            'category_menu_id',
            [
                'label' => __('Category Menu (for Categories Tab in Mobile)', 'nebon'),
                'type' => Controls_Manager::SELECT,
                'options' => $menu_options,
                'default' => '',
                'description' => __('Choose a specific category menu for the Categories tab in mobile view. If a category menu location is selected above and has a menu assigned, that location will override this selection.', 'nebon'),
                'condition' => [
                    'style' => 'style3',
                ],
            ]
        );

        $this->add_control(
            'style',
            [
                'label' => __('Style', 'nebon'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'style1' => __('Style 1 - Header 1,2,3', 'nebon'),
                    'style2' => __('Style 2 - Header 4', 'nebon'),
                    'style3' => __('Style 3 - Mobile menu', 'nebon'),
                    'style4' => __('Style 4 - Vertical category menu', 'nebon'),
                    'style5' => __('Style 5 - Top line navigation', 'nebon'),
                ],
                'default' => 'style1',
            ]
        );

        $style5_repeater = new Repeater();

        $this->add_control(
            'style5_source',
            [
                'label' => __('Style 5 Menu Source', 'nebon'),
                'type' => Controls_Manager::SELECT,
                'default' => 'custom',
                'options' => [
                    'custom' => __('Custom Items', 'nebon'),
                    'wordpress' => __('WordPress Menu (Recommended)', 'nebon'),
                ],
                'condition' => [
                    'style' => 'style5-custom-legacy',
                ],
            ]
        );

        $this->add_control(
            'style5_menu_id',
            [
                'label' => __('Select WordPress Menu', 'nebon'),
                'type' => Controls_Manager::SELECT,
                'options' => $menu_options,
                'default' => '',
                'description' => __('Build unlimited nested levels in Appearance > Menus, then select that menu here.', 'nebon'),
                'condition' => [
                    'style' => 'style5-custom-legacy',
                    'style5_source' => 'wordpress',
                ],
            ]
        );

        $style5_repeater->add_control(
            'item_label',
            [
                'label' => __('Menu Label', 'nebon'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Menu Item', 'nebon'),
                'label_block' => true,
            ]
        );

        $style5_repeater->add_control(
            'item_link',
            [
                'label' => __('Link', 'nebon'),
                'type' => Controls_Manager::URL,
                'placeholder' => 'https://your-link.com',
                'default' => [
                    'url' => '#',
                ],
            ]
        );

        $style5_repeater->add_control(
            'item_active',
            [
                'label' => __('Active Item', 'nebon'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'nebon'),
                'label_off' => __('No', 'nebon'),
                'return_value' => 'yes',
                'default' => '',
            ]
        );

        $style5_repeater->add_control(
            'submenu_items',
            [
                'label' => __('Submenu Items', 'nebon'),
                'type' => Controls_Manager::TEXTAREA,
                'rows' => 8,
                'placeholder' => "Shop | /shop\n> Products | /products\n> Product Details | /product-details\n>> Product Manual | /manual",
                'description' => __('One item per line: Label | URL. Add > at the start for a child, >> for a grandchild, and so on.', 'nebon'),
            ]
        );

        $this->add_control(
            'style5_items',
            [
                'label' => __('Menu Items', 'nebon'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $style5_repeater->get_controls(),
                'default' => [
                    [
                        'item_label' => __('Home', 'nebon'),
                        'item_link' => ['url' => '#'],
                        'item_active' => 'yes',
                    ],
                    [
                        'item_label' => __('About', 'nebon'),
                        'item_link' => ['url' => '#'],
                        'submenu_items' => __('Our Story', 'nebon') . ' | #',
                    ],
                    [
                        'item_label' => __('Pages', 'nebon'),
                        'item_link' => ['url' => '#'],
                        'submenu_items' => __('Shop', 'nebon') . ' | #',
                    ],
                    [
                        'item_label' => __('Elements', 'nebon'),
                        'item_link' => ['url' => '#'],
                        'submenu_items' => __('Gallery', 'nebon') . ' | #',
                    ],
                    [
                        'item_label' => __('Blog', 'nebon'),
                        'item_link' => ['url' => '#'],
                        'submenu_items' => __('Latest Posts', 'nebon') . ' | #',
                    ],
                    [
                        'item_label' => __('Contact', 'nebon'),
                        'item_link' => ['url' => '#'],
                        'submenu_items' => __('Contact Us', 'nebon') . ' | #',
                    ],
                ],
                'title_field' => '{{{ item_label }}}',
                'condition' => [
                    'style' => 'style5-custom-legacy',
                    'style5_source' => 'custom',
                ],
            ]
        );

        $this->add_control(
            'style4_label',
            [
                'label' => __('Style 4 Label', 'nebon'),
                'type' => Controls_Manager::TEXT,
                'default' => __('SHOP BY CATEGORY', 'nebon'),
                'label_block' => true,
                'condition' => [
                    'style' => 'style4',
                ],
            ]
        );

        $this->add_control(
            'style4_icon_class',
            [
                'label' => __('Style 4 Icon Class', 'nebon'),
                'type' => Controls_Manager::TEXT,
                'default' => 'las la-bars',
                'placeholder' => 'las la-bars',
                'description' => __('CSS class for the icon (example: "las la-bars"). Leave empty to hide the icon.', 'nebon'),
                'condition' => [
                    'style' => 'style4',
                ],
            ]
        );

        $this->add_control(
            'style4_expand_trigger',
            [
                'label' => __('Style 4 Expand Trigger (Non-home)', 'nebon'),
                'type' => Controls_Manager::SELECT,
                'default' => 'hover',
                'options' => [
                    'hover' => __('Hover', 'nebon'),
                    'click' => __('Click', 'nebon'),
                ],
                'description' => __('On the homepage the vertical menu stays expanded. On other pages it expands by this trigger.', 'nebon'),
                'condition' => [
                    'style' => 'style4',
                ],
            ]
        );

        $this->add_control(
            'style4_color_scheme',
            [
                'label' => __('Style 4 Color Scheme', 'nebon'),
                'type' => Controls_Manager::SELECT,
                'default' => 'default',
                'options' => [
                    'default' => __('Default Home3', 'nebon'),
                    'yellow-black' => __('Home2', 'nebon'),
                ],
                'condition' => [
                    'style' => 'style4',
                ],
            ]
        );

        $this->add_control(
            'style4_extra_content_style',
            [
                'label' => __('Style 4 Extra Content', 'nebon'),
                'type' => Controls_Manager::SELECT,
                'default' => 'none',
                'options' => [
                    'none' => __('None', 'nebon'),
                    'banner-h3' => __('Banner - Style H3', 'nebon'),
                    'text-h2' => __('Text List - Style H2', 'nebon'),
                ],
                'condition' => [
                    'style' => 'style4',
                ],
            ]
        );

        $this->add_control(
            'style4_banner_eyebrow',
            [
                'label' => __('Banner Eyebrow', 'nebon'),
                'type' => Controls_Manager::TEXT,
                'default' => __('STARTS NOW', 'nebon'),
                'condition' => [
                    'style' => 'style4',
                    'style4_extra_content_style' => 'banner-h3',
                ],
            ]
        );

        $this->add_control(
            'style4_banner_percent',
            [
                'label' => __('Banner Percent', 'nebon'),
                'type' => Controls_Manager::TEXT,
                'default' => '50%',
                'condition' => [
                    'style' => 'style4',
                    'style4_extra_content_style' => 'banner-h3',
                ],
            ]
        );

        $this->add_control(
            'style4_banner_title',
            [
                'label' => __('Banner Title', 'nebon'),
                'type' => Controls_Manager::TEXT,
                'default' => __('HOLIDAY SALE', 'nebon'),
                'condition' => [
                    'style' => 'style4',
                    'style4_extra_content_style' => 'banner-h3',
                ],
            ]
        );

        $this->add_control(
            'style4_banner_link_text',
            [
                'label' => __('Banner Button Text', 'nebon'),
                'type' => Controls_Manager::TEXT,
                'default' => __('SHOP NOW', 'nebon'),
                'condition' => [
                    'style' => 'style4',
                    'style4_extra_content_style' => 'banner-h3',
                ],
            ]
        );

        $this->add_control(
            'style4_banner_link',
            [
                'label' => __('Banner Button Link', 'nebon'),
                'type' => Controls_Manager::URL,
                'placeholder' => 'https://your-link.com',
                'default' => [
                    'url' => '',
                ],
                'condition' => [
                    'style' => 'style4',
                    'style4_extra_content_style' => 'banner-h3',
                ],
            ]
        );

        $this->add_control(
            'style4_banner_background',
            [
                'label' => __('Banner Background Image', 'nebon'),
                'type' => Controls_Manager::MEDIA,
                'condition' => [
                    'style' => 'style4',
                    'style4_extra_content_style' => 'banner-h3',
                ],
            ]
        );

        $repeater = new Repeater();
        $repeater->add_control(
            'text',
            [
                'label' => __('Text', 'nebon'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Special Products', 'nebon'),
                'label_block' => true,
            ]
        );
        $repeater->add_control(
            'link',
            [
                'label' => __('Link', 'nebon'),
                'type' => Controls_Manager::URL,
                'placeholder' => 'https://your-link.com',
                'default' => [
                    'url' => '',
                ],
            ]
        );

        $this->add_control(
            'style4_text_links',
            [
                'label' => __('Text Links', 'nebon'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'text' => __('Special Products', 'nebon'),
                    ],
                    [
                        'text' => __('Featured Products', 'nebon'),
                    ],
                ],
                'title_field' => '{{{ text }}}',
                'condition' => [
                    'style' => 'style4',
                    'style4_extra_content_style' => 'text-h2',
                ],
            ]
        );

        $this->end_controls_section();
    }

    public function get_all_menu_locations()
    {
        $locations = get_registered_nav_menus();
        $location_options = [];

        foreach ($locations as $location => $description) {
            $location_options[$location] = $description;
        }

        return $location_options;
    }
    protected function render()
    {
        parent::render();
        $settings = $this->get_settings_for_display();
        $settings['widget_id'] = $this->get_id();

        $style = isset($settings['style']) ? $settings['style'] : 'style1';
        if ($style === 'style3') {
            $settings['main_menu_id'] = $settings['menu_id'] ?? '';
            $settings['category_menu_id'] = $settings['category_menu_id'] ?? '';
        }
        tech888f_get_template_elementor_widget('t888-menu', $style, $settings, true);
    }
}
