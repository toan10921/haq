<?php

namespace Elementor;

use T888Core\ShopProductTrait;

class T888_Product_Tabs extends T888_Widget_Base
{

    use ShopProductTrait;
    public function get_name()
    {
        return 't888-product-tabs';
    }

    public function get_title()
    {
        return __('Product Tabs', 'nebon');
    }

    public function get_icon()
    {
        return 'eicon-tabs';
    }

    public function get_categories()
    {
        return ['t888-elements'];
    }

    public function get_script_depends()
    {
        return ['elementor-t888-product-tabs', 'swiper'];
    }

    public function get_style_depends()
    {
        return ['elementor-t888-product-tabs', 'e-swiper'];
    }
    public function enque_scripts()
    {
        parent::enque_scripts();

        wp_localize_script('elementor-t888-product-tabs', 'my_ajax_object', [
            'ajax_url' => admin_url('admin-ajax.php'),
        ]);
    }
    protected function _register_controls()
    {

        $this->start_controls_section('section_filter', [
            'label' => __('Product Filter Options', 'nebon'),
        ]);
        $this->add_control(
            'title',
            [
                'label' => __('Title', 'nebon'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Our Products', 'nebon'),
            ]
        );

        $this->add_control('tab_layout_style', [
            'label' => __('Tab Layout Style', 'nebon'),
            'type' => Controls_Manager::SELECT,
            'default' => 'horizontal',
            'options' => [
                'horizontal' => __('Horizontal (Tabs on Top)', 'nebon'),
                'vertical' => __('Vertical (Tabs on Left)', 'nebon'),
            ],
            'description' => __('Choose how tabs are displayed.', 'nebon'),
        ]);

        $this->add_control('vertical_nav_title', [
            'label' => __('Vertical Nav Title', 'nebon'),
            'type' => Controls_Manager::TEXT,
            'default' => __('Pets Food', 'nebon'),
            'condition' => [
                'tab_layout_style' => 'vertical',
            ],
            'description' => __('Enter a title for the vertical tab navigation sidebar.', 'nebon'),
        ]);

        $this->add_control('style', [
            'label' => __('Select Style', 'nebon'),
            'type' => Controls_Manager::SELECT,
            'default' => 'style1',
            'options' => [
                'style1' => __('Style 1 - Products List SlideShow', 'nebon'),
                'style2' => __('Style 2 - Products List Load Loadmore', 'nebon'),
                'style3' => __('Style 3 Slider 2', 'nebon'),
                'style4' => __('Style 4 Slider 3', 'nebon'),
                'style5' => __('Style 5 - Cart Cross Sell', 'nebon'),
                'style6' => __('Style 6 - Product Grid', 'nebon')
            ],
        ]);

        $this->add_control('product_limit', [
            'label' => __('Number of Products per Tab', 'nebon'),
            'type' => Controls_Manager::NUMBER,
            'default' => 6,
            'min' => 1,
            'description' => __('Enter the number of products to display per tab.', 'nebon'),
            'condition' => [
                'style!' => 'style6',
            ],
        ]);

        $this->add_control('style6_use_preset_tabs', [
            'label' => __('Style 6: Use Preset Tabs', 'nebon'),
            'type' => Controls_Manager::SWITCHER,
            'label_on' => __('Yes', 'nebon'),
            'label_off' => __('No', 'nebon'),
            'return_value' => 'yes',
            'default' => 'yes',
            'condition' => [
                'style' => 'style6',
            ],
        ]);

        $this->add_control('style6_tab_label_featured', [
            'label' => __('Style 6 Tab Label: Featured', 'nebon'),
            'type' => Controls_Manager::TEXT,
            'default' => __('Featured', 'nebon'),
            'condition' => [
                'style' => 'style6',
                'style6_use_preset_tabs' => 'yes',
            ],
        ]);

        $this->add_control('style6_tab_label_bestsellers', [
            'label' => __('Style 6 Tab Label: Best Sellers', 'nebon'),
            'type' => Controls_Manager::TEXT,
            'default' => __('Best Sellers', 'nebon'),
            'condition' => [
                'style' => 'style6',
                'style6_use_preset_tabs' => 'yes',
            ],
        ]);

        $this->add_control('style6_tab_label_new_arrival', [
            'label' => __('Style 6 Tab Label: New Arrival', 'nebon'),
            'type' => Controls_Manager::TEXT,
            'default' => __('New Arrival', 'nebon'),
            'condition' => [
                'style' => 'style6',
                'style6_use_preset_tabs' => 'yes',
            ],
        ]);

        $this->add_control('style6_show_tab_arrows', [
            'label' => __('Style 6: Show Tab Arrows', 'nebon'),
            'type' => Controls_Manager::SWITCHER,
            'label_on' => __('Yes', 'nebon'),
            'label_off' => __('No', 'nebon'),
            'return_value' => 'yes',
            'default' => 'yes',
            'condition' => [
                'style' => 'style6',
            ],
        ]);

        $this->add_control('style6_enable_time_filter', [
            'label' => __('Style 6: Enable Time Filter', 'nebon'),
            'type' => Controls_Manager::SWITCHER,
            'label_on' => __('Yes', 'nebon'),
            'label_off' => __('No', 'nebon'),
            'return_value' => 'yes',
            'default' => 'no',
            'description' => __('Show a time filter (The Week / The Month / The Year) on the right side of the tab bar.', 'nebon'),
            'condition' => [
                'style' => 'style6',
            ],
        ]);

        $this->add_control('style6_time_filter_label_week', [
            'label' => __('Style 6: Label – The Week', 'nebon'),
            'type' => Controls_Manager::TEXT,
            'default' => __('The Week', 'nebon'),
            'condition' => [
                'style' => 'style6',
                'style6_enable_time_filter' => 'yes',
            ],
        ]);

        $this->add_control('style6_time_filter_label_month', [
            'label' => __('Style 6: Label – The Month', 'nebon'),
            'type' => Controls_Manager::TEXT,
            'default' => __('The Month', 'nebon'),
            'condition' => [
                'style' => 'style6',
                'style6_enable_time_filter' => 'yes',
            ],
        ]);

        $this->add_control('style6_time_filter_label_year', [
            'label' => __('Style 6: Label – The Year', 'nebon'),
            'type' => Controls_Manager::TEXT,
            'default' => __('The Year', 'nebon'),
            'condition' => [
                'style' => 'style6',
                'style6_enable_time_filter' => 'yes',
            ],
        ]);

        $this->add_control('style6_product_style', [
            'label' => __('Style 6: Product Card Style', 'nebon'),
            'type' => Controls_Manager::SELECT,
            'default' => 'pet-category',
            'options' => [
                'pet-category' => __('Style 1 – Pet Category Card (Default)', 'nebon'),
                'standard' => __('Style 2 – Standard Grid Card', 'nebon'),
            ],
            'description' => __('Style 1: custom pet-category card (image + title + price). Style 2: standard WooCommerce grid card (title, rating, price).', 'nebon'),
            'condition' => [
                'style' => 'style6',
            ],
        ]);

        $this->add_control('style6_enable_center_product', [

            'label' => __('Style 6: Center Large Product', 'nebon'),
            'type' => Controls_Manager::SWITCHER,
            'label_on' => __('Yes', 'nebon'),
            'label_off' => __('No', 'nebon'),
            'return_value' => 'yes',
            'default' => 'no',
            'condition' => [
                'style' => 'style6',
            ],
            'description' => __('Make a center product span 2 rows and the middle column. (Auto set to 5 columns and 2 rows)', 'nebon'),
        ]);

        $this->add_control('style6_grid_columns', [
            'label' => __('Style 6: Grid Columns', 'nebon'),
            'type' => Controls_Manager::SELECT,
            'default' => '4',
            'options' => [
                '2' => __('2 Columns', 'nebon'),
                '3' => __('3 Columns', 'nebon'),
                '4' => __('4 Columns', 'nebon'),
                '5' => __('5 Columns', 'nebon'),
                '6' => __('6 Columns', 'nebon'),
            ],
            'condition' => [
                'style' => 'style6',
                'style6_enable_center_product!' => 'yes',
            ],
        ]);

        $this->add_control('style6_grid_rows', [
            'label' => __('Style 6: Grid Rows', 'nebon'),
            'type' => Controls_Manager::NUMBER,
            'min' => 1,
            'max' => 12,
            'step' => 1,
            'description' => __('Set rows for Style 6 grid. Leave empty to use Number of Products per Tab.', 'nebon'),
            'condition' => [
                'style' => 'style6',
                'style6_enable_center_product!' => 'yes',
            ],
        ]);

        $this->add_control('style6_show_badge_sale', [
            'label' => __('Style 6: Show Sale Badge', 'nebon'),
            'type' => Controls_Manager::SWITCHER,
            'label_on' => __('Yes', 'nebon'),
            'label_off' => __('No', 'nebon'),
            'return_value' => 'yes',
            'default' => 'no',
            'condition' => [
                'style' => 'style6',
            ],
        ]);

        $this->add_control('style6_show_badge_new', [
            'label' => __('Style 6: Show New Badge', 'nebon'),
            'type' => Controls_Manager::SWITCHER,
            'label_on' => __('Yes', 'nebon'),
            'label_off' => __('No', 'nebon'),
            'return_value' => 'yes',
            'default' => 'no',
            'condition' => [
                'style' => 'style6',
            ],
        ]);

        $this->add_control('style6_show_badge_hot', [
            'label' => __('Style 6: Show Hot Badge', 'nebon'),
            'type' => Controls_Manager::SWITCHER,
            'label_on' => __('Yes', 'nebon'),
            'label_off' => __('No', 'nebon'),
            'return_value' => 'yes',
            'default' => 'no',
            'condition' => [
                'style' => 'style6',
            ],
        ]);

        $this->add_control('style6_grid_gap', [
            'label' => __('Style 6: Grid Gap (px)', 'nebon'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 50,
                    'step' => 1,
                ],
            ],
            'default' => [
                'size' => 0,
                'unit' => 'px',
            ],
            'selectors' => [
                '{{WRAPPER}} .t888-product-tabs-wrapper.style6 .product-item' => 'padding: calc({{SIZE}}{{UNIT}} / 2);',
                '{{WRAPPER}} .t888-product-tabs-wrapper.style6 .products.grid' => 'margin: calc(-{{SIZE}}{{UNIT}} / 2);',
            ],
            'condition' => [
                'style' => 'style6',
            ],
        ]);

        $this->add_control('style6_background_color', [
            'label' => __('Style 6: Background Color', 'nebon'),
            'type' => Controls_Manager::COLOR,
            'default' => '#ffffff',
            'condition' => [
                'style' => 'style6',
            ],
        ]);

        $this->add_control('style6_show_title', [
            'label' => __('Style 6: Show Title', 'nebon'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'default' => 'yes',
            'condition' => ['style' => 'style6'],
        ]);

        $this->add_control(
            'style6_tabs_background_color',
            [
                'label' => __('Style 6:Tab Background Color', 'nebon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .t888-style6-head' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .t888-product-tabs-nav' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'style' => 'style6'
                ]
            ]
        );

        $this->add_responsive_control(
            'tabs_margin',
            [
                'label' => __('Style 6:Tab Margin', 'nebon'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .t888-style6-head' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'style' => 'style6',
                ],
            ]
        );

        $this->add_responsive_control(
            'tab_min_height',
            [
                'label' => __('Style 6:Tab Min Height', 'nebon'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 20,
                        'max' => 200,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .t888-style6-head' => 'min-height: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'style' => 'style6',
                ],
            ]
        );

        $this->add_control('product_thumb_animation', [
            'label' => __('Thumbnail Animation', 'nebon'),
            'type' => Controls_Manager::SELECT,
            'default' => 'none',
            'options' => $this->get_product_thumb_animation(),
            'description' => __('Choose the animation effect for product thumbnails.', 'nebon'),
        ]);

        // Prepare options
        $product_categories = get_terms([
            'taxonomy' => 'product_cat',
            'hide_empty' => false,
        ]);
        $categories_options = [];
        if (!empty($product_categories) && !is_wp_error($product_categories)) {
            foreach ($product_categories as $cat) {
                $categories_options[$cat->term_id] = $cat->name;
            }
        }

        $repeater = new \Elementor\Repeater();

        $repeater->add_control('tab_title_normal', [
            'label' => __('Tab Title', 'nebon'),
            'type' => Controls_Manager::TEXT,
            'default' => __('New Products', 'nebon'),

        ]);


        $repeater->add_control('tab_filter_mode', [
            'label' => __('Filter Mode', 'nebon'),
            'type' => Controls_Manager::SELECT,
            'default' => 'categories',
            'options' => [
                'categories' => __('Product Categories', 'nebon'),
                'products' => __('Individual Products', 'nebon'),
            ],

        ]);

        $repeater->add_control('tab_categories', [
            'label' => __('Categories (for this tab)', 'nebon'),
            'type' => Controls_Manager::SELECT2,
            'multiple' => true,
            'label_block' => true,
            'options' => $categories_options,
            'condition' => [
                'tab_filter_mode' => 'categories',
            ],
        ]);

        $repeater->add_control('tab_products', [
            'label' => __('Products (for this tab)', 'nebon'),
            'type' => Controls_Manager::SELECT2,
            'multiple' => true,
            'label_block' => true,
            'options' => $this->get_products_options(),
            'condition' => [
                'tab_filter_mode' => 'products',
            ],
        ]);

        $repeater->add_control('product_filter', [
            'label' => __('Product Type', 'nebon'),
            'type' => Controls_Manager::SELECT,
            'default' => 'new',
            'options' => [
                'new' => __('New', 'nebon'),
                'bestsellers' => __('Bestsellers', 'nebon'),
                'popular' => __('Popular', 'nebon'),
                'featured' => __('Featured', 'nebon'),
                'week' => __('The Week', 'nebon'),
                'month' => __('The Month', 'nebon'),
                'year' => __('The Year', 'nebon'),
            ],
        ]);

        $this->add_control('tabs', [
            'label' => __('Tabs', 'nebon'),
            'type' => Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls(),
            'title_field' => '{{{ tab_title_normal }}}',
            'condition' => [
                'style' => ['style1', 'style2', 'style3', 'style5', 'style6'],
            ],
        ]);

        $repeater_style4 = new \Elementor\Repeater();

        $repeater_style4->add_control('tab_title', [
            'label' => __('Tab Title', 'nebon'),
            'type' => Controls_Manager::TEXT,
            'default' => __('Special Products', 'nebon'),
        ]);

        $repeater_style4->add_control('tab_special_product', [
            'label' => __('Countdown Product (first item)', 'nebon'),
            'type' => Controls_Manager::SELECT,
            'label_block' => true,
            'options' => $this->get_countdown_products_options(),
        ]);
        $repeater_style4->add_control(
            'infinitive_sale',
            [
                'label' => __('Infinite Deal (Auto loop 10 days)', 'nebon'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'nebon'),
                'label_off' => __('No', 'nebon'),
                'return_value' => 'yes',
                'default' => '',
            ]
        );

        $repeater_style4->add_control('tab_products', [
            'label' => __('Products (for this tab)', 'nebon'),
            'type' => Controls_Manager::SELECT2,
            'multiple' => true,
            'label_block' => true,
            'options' => $this->get_products_options(),
            'description' => __('Remaining products displayed after the first one.', 'nebon'),
        ]);

        $this->add_control('style4_tabs', [
            'label' => __('Tabs for Style 4', 'nebon'),
            'type' => Controls_Manager::REPEATER,
            'fields' => $repeater_style4->get_controls(),
            'title_field' => '{{{ tab_title }}}',
            'condition' => [
                'style' => 'style4',
            ],
        ]);

        $this->end_controls_section();

        // Ad Box Section for Vertical Layout Style 6
        $this->start_controls_section('section_vertical_ad', [
            'label' => __('Vertical Ad Settings (Style 6)', 'nebon'),
            'condition' => [
                'tab_layout_style' => 'vertical',
                'style' => 'style6',
            ],
        ]);

        $this->add_control('style6_enable_ad_box', [
            'label' => __('Enable Middle Ad Box', 'nebon'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'default' => 'no',
        ]);

        $ad_item = new \Elementor\Repeater();
        $ad_item->add_control('item_type', [
            'label' => __('Item Type', 'nebon'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'text',
            'options' => [
                'text' => __('Text / HTML', 'nebon'),
                'image' => __('Image', 'nebon'),
                'button' => __('Button', 'nebon'),
            ],
        ]);
        $ad_item->add_control('text_content', [
            'label' => __('Content', 'nebon'),
            'type' => \Elementor\Controls_Manager::WYSIWYG,
            'default' => __('Ad Text', 'nebon'),
            'condition' => ['item_type' => 'text'],
        ]);
        $ad_item->add_control('text_color', [
            'label' => __('Text Color', 'nebon'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} {{CURRENT_ITEM}} .ad-text-el' => 'color: {{VALUE}};',
                '{{WRAPPER}} {{CURRENT_ITEM}} .ad-text-el *' => 'color: {{VALUE}};',
            ],
            'condition' => ['item_type' => 'text'],
        ]);
        $ad_item->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'text_typography',
                'label' => __('Typography', 'nebon'),
                'selector' => '{{WRAPPER}} {{CURRENT_ITEM}} .ad-text-el, {{WRAPPER}} {{CURRENT_ITEM}} .ad-text-el *',
                'condition' => ['item_type' => 'text'],
            ]
        );
        $ad_item->add_control('image', [
            'label' => __('Image', 'nebon'),
            'type' => \Elementor\Controls_Manager::MEDIA,
            'condition' => ['item_type' => 'image'],
        ]);
        $ad_item->add_responsive_control('image_width', [
            'label' => __('Width', 'nebon'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['px', '%', 'vw'],
            'range' => [
                '%' => ['min' => 1, 'max' => 100],
                'px' => ['min' => 1, 'max' => 1000],
            ],
            'selectors' => [
                '{{WRAPPER}} {{CURRENT_ITEM}} .ad-img-el img' => 'width: {{SIZE}}{{UNIT}};',
            ],
            'condition' => ['item_type' => 'image'],
        ]);
        $ad_item->add_responsive_control('image_height', [
            'label' => __('Height', 'nebon'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['px', 'vh', '%'],
            'range' => [
                'px' => ['min' => 1, 'max' => 1000],
                'vh' => ['min' => 1, 'max' => 100],
            ],
            'selectors' => [
                '{{WRAPPER}} {{CURRENT_ITEM}} .ad-img-el img' => 'height: {{SIZE}}{{UNIT}};',
            ],
            'condition' => ['item_type' => 'image'],
        ]);
        $ad_item->add_control('image_object_fit', [
            'label' => __('Object Fit', 'nebon'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'condition' => ['item_type' => 'image'],
            'options' => [
                '' => __('Default', 'nebon'),
                'fill' => __('Fill', 'nebon'),
                'cover' => __('Cover', 'nebon'),
                'contain' => __('Contain', 'nebon'),
            ],
            'default' => '',
            'selectors' => [
                '{{WRAPPER}} {{CURRENT_ITEM}} .ad-img-el img' => 'object-fit: {{VALUE}};',
            ],
        ]);
        $ad_item->add_responsive_control('image_border_radius', [
            'label' => __('Border Radius', 'nebon'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} {{CURRENT_ITEM}} .ad-img-el img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
            'condition' => ['item_type' => 'image'],
        ]);
        $ad_item->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'image_box_shadow',
                'selector' => '{{WRAPPER}} {{CURRENT_ITEM}} .ad-img-el img',
                'condition' => ['item_type' => 'image'],
            ]
        );
        $ad_item->add_group_control(
            \Elementor\Group_Control_Css_Filter::get_type(),
            [
                'name' => 'image_css_filters',
                'selector' => '{{WRAPPER}} {{CURRENT_ITEM}} .ad-img-el img',
                'condition' => ['item_type' => 'image'],
            ]
        );
        $ad_item->add_control('image_position', [
            'label' => __('Position', 'nebon'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'relative',
            'options' => [
                'relative' => __('Default', 'nebon'),
                'absolute' => __('Absolute', 'nebon'),
            ],
            'condition' => ['item_type' => 'image'],
            'selectors' => [
                '{{WRAPPER}} {{CURRENT_ITEM}} .ad-img-el' => 'position: {{VALUE}};',
            ],
        ]);
        $ad_item->add_responsive_control('image_offset_x', [
            'label' => __('Horizontal Offset', 'nebon'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['px', '%'],
            'range' => [
                'px' => ['min' => -1000, 'max' => 1000],
                '%' => ['min' => -100, 'max' => 100],
            ],
            'selectors' => [
                '{{WRAPPER}} {{CURRENT_ITEM}} .ad-img-el' => 'left: {{SIZE}}{{UNIT}}; right: auto;',
            ],
            'condition' => [
                'item_type' => 'image',
                'image_position' => 'absolute',
            ],
        ]);
        $ad_item->add_responsive_control('image_offset_y', [
            'label' => __('Vertical Offset', 'nebon'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['px', '%'],
            'range' => [
                'px' => ['min' => -1000, 'max' => 1000],
                '%' => ['min' => -100, 'max' => 100],
            ],
            'selectors' => [
                '{{WRAPPER}} {{CURRENT_ITEM}} .ad-img-el' => 'top: {{SIZE}}{{UNIT}}; bottom: auto;',
            ],
            'condition' => [
                'item_type' => 'image',
                'image_position' => 'absolute',
            ],
        ]);
        $ad_item->add_control('image_zindex', [
            'label' => __('Z-Index', 'nebon'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'selectors' => [
                '{{WRAPPER}} {{CURRENT_ITEM}} .ad-img-el' => 'z-index: {{VALUE}};',
            ],
            'condition' => [
                'item_type' => 'image',
                'image_position' => 'absolute',
            ],
        ]);

        $ad_item->add_control('link', [
            'label' => __('Link', 'nebon'),
            'type' => \Elementor\Controls_Manager::URL,
            'condition' => ['item_type' => ['button', 'image']],
        ]);
        $ad_item->add_control('button_text', [
            'label' => __('Button Text', 'nebon'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => __('Shop Now', 'nebon'),
            'condition' => ['item_type' => 'button'],
        ]);
        $ad_item->add_control('button_color', [
            'label' => __('Button Text Color', 'nebon'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} {{CURRENT_ITEM}} .ad-btn' => 'color: {{VALUE}};',
            ],
            'condition' => ['item_type' => 'button'],
        ]);
        $ad_item->add_control('button_bg_color', [
            'label' => __('Button Background', 'nebon'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} {{CURRENT_ITEM}} .ad-btn' => 'background-color: {{VALUE}};',
            ],
            'condition' => ['item_type' => 'button'],
        ]);
        $ad_item->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'button_typography',
                'label' => __('Button Typography', 'nebon'),
                'selector' => '{{WRAPPER}} {{CURRENT_ITEM}} .ad-btn',
                'condition' => ['item_type' => 'button'],
            ]
        );
        $ad_item->add_responsive_control('button_padding', [
            'label' => __('Button Padding', 'nebon'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%', 'em'],
            'selectors' => [
                '{{WRAPPER}} {{CURRENT_ITEM}} .ad-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
            'condition' => ['item_type' => 'button'],
        ]);
        $ad_item->add_responsive_control('item_margin', [
            'label' => __('Margin', 'nebon'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%', 'em'],
            'selectors' => [
                '{{WRAPPER}} {{CURRENT_ITEM}}' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);
        $ad_item->add_responsive_control('item_align', [
            'label' => __('Alignment', 'nebon'),
            'type' => \Elementor\Controls_Manager::CHOOSE,
            'options' => [
                'left' => ['title' => __('Left', 'nebon'), 'icon' => 'eicon-text-align-left'],
                'center' => ['title' => __('Center', 'nebon'), 'icon' => 'eicon-text-align-center'],
                'right' => ['title' => __('Right', 'nebon'), 'icon' => 'eicon-text-align-right'],
            ],
            'selectors' => [
                '{{WRAPPER}} {{CURRENT_ITEM}}' => 'text-align: {{VALUE}};',
                '{{WRAPPER}} {{CURRENT_ITEM}} .ad-img-el' => 'margin-left: {{VALUE == "center" ? "auto" : (VALUE == "right" ? "auto" : "0")}}; margin-right: {{VALUE == "center" ? "auto" : (VALUE == "left" ? "auto" : "0")}};',
            ],
        ]);

        $this->add_control('style6_ad_items', [
            'label' => __('Ad Blocks', 'nebon'),
            'type' => \Elementor\Controls_Manager::REPEATER,
            'fields' => $ad_item->get_controls(),
            'title_field' => '{{{ item_type }}}',
            'condition' => ['style6_enable_ad_box' => 'yes'],
        ]);

        $this->add_control('style6_ad_box_bg', [
            'label' => __('Ad Box Background', 'nebon'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .t888-vertical-ad-box' => 'background-color: {{VALUE}};',
            ],
            'condition' => ['style6_enable_ad_box' => 'yes'],
        ]);

        $this->add_responsive_control('style6_ad_box_width', [
            'label' => __('Ad Box Max Width', 'nebon'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['px', '%'],
            'range' => [
                'px' => ['min' => 100, 'max' => 600],
                '%' => ['min' => 10, 'max' => 50],
            ],
            'default' => ['size' => 280, 'unit' => 'px'],
            'selectors' => [
                '{{WRAPPER}} .t888-vertical-ad-box' => 'flex: 0 0 {{SIZE}}{{UNIT}}; max-width: {{SIZE}}{{UNIT}};',
            ],
            'condition' => ['style6_enable_ad_box' => 'yes'],
        ]);

        $this->add_responsive_control('style6_ad_box_padding', [
            'label' => __('Ad Box Padding', 'nebon'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%', 'em'],
            'selectors' => [
                '{{WRAPPER}} .t888-vertical-ad-box' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
            'condition' => ['style6_enable_ad_box' => 'yes'],
        ]);

        $this->add_responsive_control('style6_ad_box_margin', [
            'label' => __('Ad Box Margin', 'nebon'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%', 'em'],
            'selectors' => [
                '{{WRAPPER}} .t888-vertical-ad-box' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
            'condition' => ['style6_enable_ad_box' => 'yes'],
        ]);

        $this->end_controls_section();

        // ── Vertical Layout: Product Item Styling ──────────────────────────
        $this->start_controls_section('section_vertical_product_style', [
            'label' => __('Vertical Layout: Product Item Styling', 'nebon'),
            'condition' => [
                'tab_layout_style' => 'vertical',
            ],
        ]);

        $this->add_control('vertical_product_style_heading', [
            'label' => __('Product Item Padding', 'nebon'),
            'type'  => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
        ]);

        $this->add_responsive_control('vertical_product_padding', [
            'label'      => __('Padding', 'nebon'),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%', 'em'],
            'selectors'  => [
                '{{WRAPPER}} .t888-product-tabs-wrapper.vertical-layout .product-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                '{{WRAPPER}} .t888-product-tabs-wrapper.vertical-layout .t888-product-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->add_control('vertical_product_border_heading', [
            'label'     => __('Product Item Border', 'nebon'),
            'type'      => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
        ]);

        $this->add_control('vertical_product_border_style', [
            'label'   => __('Border Style', 'nebon'),
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => '',
            'options' => [
                ''       => __('Default', 'nebon'),
                'none'   => __('None', 'nebon'),
                'solid'  => __('Solid', 'nebon'),
                'dashed' => __('Dashed', 'nebon'),
                'dotted' => __('Dotted', 'nebon'),
                'double' => __('Double', 'nebon'),
            ],
            'selectors' => [
                '{{WRAPPER}} .t888-product-tabs-wrapper.vertical-layout .product-item' => 'border-style: {{VALUE}};',
                '{{WRAPPER}} .t888-product-tabs-wrapper.vertical-layout .t888-product-card' => 'border-style: {{VALUE}};',
            ],
        ]);

        
        $this->add_responsive_control('vertical_product_border_width', [
            'label'      => __('Border Width', 'nebon'),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px'],
            'selectors'  => [
                '{{WRAPPER}} .t888-product-tabs-wrapper.vertical-layout .product-item' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                '{{WRAPPER}} .t888-product-tabs-wrapper.vertical-layout .t888-product-card' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
            'condition' => [
                'vertical_product_border_style!' => ['', 'none'],
            ],
        ]);

        $this->add_control('vertical_product_border_color', [
            'label'     => __('Border Color', 'nebon'),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .t888-product-tabs-wrapper.vertical-layout .product-item' => 'border-color: {{VALUE}};',
                '{{WRAPPER}} .t888-product-tabs-wrapper.vertical-layout .t888-product-card' => 'border-color: {{VALUE}};',
            ],
            'condition' => [
                'vertical_product_border_style!' => ['', 'none'],
            ],
        ]);

        $this->add_responsive_control('vertical_product_border_radius', [
            'label'      => __('Border Radius', 'nebon'),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors'  => [
                '{{WRAPPER}} .t888-product-tabs-wrapper.vertical-layout .product-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                '{{WRAPPER}} .t888-product-tabs-wrapper.vertical-layout .t888-product-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->add_control('vertical_product_hover_shadow_heading', [
            'label'     => __('Product Item Hover Shadow', 'nebon'),
            'type'      => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
        ]);

        $this->add_control('vertical_product_enable_hover_shadow', [
            'label'        => __('Enable Hover Shadow', 'nebon'),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'label_on'     => __('Yes', 'nebon'),
            'label_off'    => __('No', 'nebon'),
            'return_value' => 'yes',
            'default'      => 'no',
        ]);

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name'      => 'vertical_product_hover_shadow',
                'label'     => __('Box Shadow on Hover', 'nebon'),
                'selector'  => '{{WRAPPER}} .t888-product-tabs-wrapper.vertical-layout .product-item:hover, {{WRAPPER}} .t888-product-tabs-wrapper.vertical-layout .t888-product-card:hover',
                'condition' => [
                    'vertical_product_enable_hover_shadow' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control('vertical_product_hover_transition', [
            'label'      => __('Transition Duration (s)', 'nebon'),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['s'],
            'range'      => [
                's' => ['min' => 0, 'max' => 2, 'step' => 0.05],
            ],
            'default'    => ['size' => 0.3, 'unit' => 's'],
            'selectors'  => [
                '{{WRAPPER}} .t888-product-tabs-wrapper.vertical-layout .product-item' => 'transition: box-shadow {{SIZE}}{{UNIT}}, border-color {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .t888-product-tabs-wrapper.vertical-layout .t888-product-card' => 'transition: box-shadow {{SIZE}}{{UNIT}}, border-color {{SIZE}}{{UNIT}};',
            ],
            'condition'  => [
                'vertical_product_enable_hover_shadow' => 'yes',
            ],
        ]);

        $this->end_controls_section();
    }



    private function get_products_options()
    {
        $args = [
            'post_type' => 'product',
            'posts_per_page' => -1,
            'post_status' => 'publish',
        ];
        $query = new \WP_Query($args);
        $options = [];

        foreach ($query->posts as $post) {
            $options[$post->ID] = $post->post_title;
        }

        return $options;
    }
    private function get_countdown_products_options()
    {
        $args = [
            'post_type' => 'product',
            'posts_per_page' => -1,
            'post_status' => 'publish',
            'meta_query' => [
                [
                    'key' => '_sale_price_dates_to',
                    'value' => time(),
                    'compare' => '>',
                    'type' => 'NUMERIC',
                ],
            ],
        ];

        $query = new \WP_Query($args);
        $options = [];

        foreach ($query->posts as $post) {
            $options[$post->ID] = $post->post_title;
        }

        return $options;
    }

    protected function render()
    {
        parent::render();
        $settings = $this->get_element_settings();
        $style = isset($settings['style']) ? $settings['style'] : 'style1';

        tech888f_get_template_elementor_widget('t888-product-tabs', $style, $settings, true);
    }


}
