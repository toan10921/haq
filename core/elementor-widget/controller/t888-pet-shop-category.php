<?php
namespace Elementor;

class T888_Pet_Shop_Category extends T888_Widget_Base
{
    public function get_name()
    {
        return 't888-pet-shop-category';
    }

    public function get_title()
    {
        return __('Pet Shop Category Block', 'nebon');
    }

    public function get_icon()
    {
        return 'eicon-price-table';
    }

    public function get_categories()
    {
        return ['t888-elements'];
    }

    /* public function get_script_depends()
    {
        return [];
    } */

    public function get_style_depends()
    {
        return ['elementor-t888-pet-shop-category'];
    }

    protected function _register_controls()
    {
        $this->start_controls_section(
            'section_banner',
            [
                'label' => __('Left Banner settings', 'nebon'),
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => __('Title', 'nebon'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('DOG SHOP', 'nebon'),
            ]
        );

        $this->add_control(
            'bg_color',
            [
                'label' => __('Background Color', 'nebon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#41a8c0',
            ]
        );

        $this->add_control(
            'bg_image',
            [
                'label' => __('Background Image (Optional)', 'nebon'),
                'type' => \Elementor\Controls_Manager::MEDIA,
            ]
        );

        $this->add_control(
            'pet_image',
            [
                'label' => __('Pet Image', 'nebon'),
                'type' => \Elementor\Controls_Manager::MEDIA,
            ]
        );

        $this->add_control(
            'subtitle_top',
            [
                'label' => __('Subtitle Top', 'nebon'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('BEST QUALITY', 'nebon'),
            ]
        );

        $this->add_control(
            'subtitle_bottom',
            [
                'label' => __('Subtitle Bottom', 'nebon'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('PET ACCESSORIES', 'nebon'),
            ]
        );

        $this->add_control(
            'discount_top',
            [
                'label' => __('Discount Text Top', 'nebon'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('UP TO', 'nebon'),
            ]
        );

        $this->add_control(
            'discount_bottom',
            [
                'label' => __('Discount Text Bottom', 'nebon'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('50% OFF', 'nebon'),
            ]
        );

        $this->add_control(
            'show_button',
            [
                'label' => __('Show Button', 'nebon'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'button_text',
            [
                'label' => __('Button Text', 'nebon'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('SHOP NOW', 'nebon'),
                'condition' => [
                    'show_button' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'button_link',
            [
                'label' => __('Button Link', 'nebon'),
                'type' => \Elementor\Controls_Manager::URL,
                'default' => [
                    'url' => '#',
                ],
                'condition' => [
                    'show_button' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_products',
            [
                'label' => __('Products Grid', 'nebon'),
            ]
        );

        $products = get_posts([
            'post_type'   => 'product',
            'post_status' => 'publish',
            'numberposts' => 200, 
        ]);
        
        $options = [];
        foreach ($products as $p) {
            $options[$p->ID] = '#' . $p->ID . ' - ' . $p->post_title;
        }

        $this->add_control(
            'products',
            [
                'label'       => __('Select exactly 5 products for best layout', 'nebon'),
                'type'        => \Elementor\Controls_Manager::SELECT2,
                'options'     => $options,
                'multiple'    => true,
                'label_block' => true,
            ]
        );

        $this->add_control(
            'show_badge_sale',
            [
                'label' => __('Show Sale Badge', 'nebon'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_badge_new',
            [
                'label' => __('Show New Badge', 'nebon'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_badge_hot',
            [
                'label' => __('Show Hot Badge', 'nebon'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_brands',
            [
                'label' => __('Brands Logos', 'nebon'),
            ]
        );

        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
            'brand_logo',
            [
                'label' => __('Brand Logo', 'nebon'),
                'type' => \Elementor\Controls_Manager::MEDIA,
            ]
        );
        $repeater->add_control(
            'brand_link',
            [
                'label' => __('Brand Link', 'nebon'),
                'type' => \Elementor\Controls_Manager::URL,
                'default' => [
                    'url' => '#',
                ],
            ]
        );

        $this->add_control(
            'brands',
            [
                'label' => __('Brand Logos (5 recommended)', 'nebon'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'title_field' => 'Brand Item',
            ]
        );

        $this->end_controls_section();

        // STYLE TAB
        $this->start_controls_section(
            'section_style_banner',
            [
                'label' => __('Banner Style', 'nebon'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => __('Title Typography', 'nebon'),
                'selector' => '{{WRAPPER}} .shop-category-banner .banner-title',
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => __('Title Color', 'nebon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .shop-category-banner .banner-title' => 'color: {{VALUE}};',
                ],
            ]
        );
        
        $this->add_control(
            'title_bg_color',
            [
                'label' => __('Title Background Color', 'nebon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .shop-category-banner .banner-title' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'title_margin',
            [
                'label' => __('Title Margin', 'nebon'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .shop-category-banner .banner-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'subtitle_typography',
                'label' => __('Subtitle Typography', 'nebon'),
                'selector' => '{{WRAPPER}} .shop-category-banner .subtitle',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'subtitle_color',
            [
                'label' => __('Subtitle Color', 'nebon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .shop-category-banner .subtitle' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'subtitle_margin',
            [
                'label' => __('Subtitle Margin', 'nebon'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .shop-category-banner .subtitle' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'discount_top_typography',
                'label' => __('Discount Top Typography', 'nebon'),
                'selector' => '{{WRAPPER}} .shop-category-banner .discount-top',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'discount_top_color',
            [
                'label' => __('Discount Top Color', 'nebon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .shop-category-banner .discount-top' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'discount_top_margin',
            [
                'label' => __('Discount Top Margin', 'nebon'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .shop-category-banner .discount-top' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'discount_bottom_typography',
                'label' => __('Discount Bottom Typography', 'nebon'),
                'selector' => '{{WRAPPER}} .shop-category-banner .discount-bottom',
            ]
        );

        $this->add_control(
            'discount_bottom_color',
            [
                'label' => __('Discount Bottom Color', 'nebon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .shop-category-banner .discount-bottom' => 'color: {{VALUE}};',
                ],
            ]
        );
        
        $this->add_control(
            'discount_bottom_margin',
            [
                'label' => __('Discount Bottom Margin', 'nebon'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .shop-category-banner .discount-bottom' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        
        $this->add_control(
            'banner_padding',
            [
                'label' => __('Banner Padding', 'nebon'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .shop-category-banner .banner-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'before',
            ]
        );
        
        $this->end_controls_section();

        // BUTTON STYLE TAB
        $this->start_controls_section(
            'section_style_button',
            [
                'label' => __('Button Style', 'nebon'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'btn_padding',
            [
                'label' => __('Button Padding', 'nebon'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .shop-category-banner .banner-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        
        $this->add_control(
            'btn_margin',
            [
                'label' => __('Button Margin', 'nebon'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .shop-category-banner .banner-btn' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'button_typography',
                'label' => __('Button Typography', 'nebon'),
                'selector' => '{{WRAPPER}} .shop-category-banner .banner-btn',
                'separator' => 'before',
            ]
        );

        $this->start_controls_tabs('button_style_tabs');

        $this->start_controls_tab(
            'button_normal_tab',
            [
                'label' => __('Normal', 'nebon'),
            ]
        );

        $this->add_control(
            'button_text_color',
            [
                'label' => __('Text Color', 'nebon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .shop-category-banner .banner-btn' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_bg_color',
            [
                'label' => __('Background Color', 'nebon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .shop-category-banner .banner-btn' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'button_hover_tab',
            [
                'label' => __('Hover', 'nebon'),
            ]
        );

        $this->add_control(
            'button_text_color_hover',
            [
                'label' => __('Text Color', 'nebon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .shop-category-banner .banner-btn:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_bg_color_hover',
            [
                'label' => __('Background Color', 'nebon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .shop-category-banner .banner-btn:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        // PRODUCT BOX TAB
        $this->start_controls_section(
            'section_style_product_box',
            [
                'label' => __('Product Box', 'nebon'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'product_box_bg',
            [
                'label' => __('Background Color', 'nebon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .grid-product-item' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'product_box_margin',
            [
                'label' => __('Margin', 'nebon'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .grid-product-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        
        $this->add_control(
            'product_box_border_color',
            [
                'label' => __('Border Color', 'nebon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .grid-product-item' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        // PRODUCT CONTENT TAB
        $this->start_controls_section(
            'section_style_product_content',
            [
                'label' => __('Product Content', 'nebon'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'product_title_typography',
                'label' => __('Title Typography', 'nebon'),
                'selector' => '{{WRAPPER}} .product-title a',
            ]
        );

        $this->add_control(
            'product_title_color',
            [
                'label' => __('Title Color', 'nebon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .product-title a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'product_title_color_hover',
            [
                'label' => __('Title Hover Color', 'nebon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .product-title a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'product_title_margin',
            [
                'label' => __('Title Margin', 'nebon'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .product-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'product_price_typography',
                'label' => __('Price Typography', 'nebon'),
                'selector' => '{{WRAPPER}} .product-price',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'product_price_color',
            [
                'label' => __('Price Color', 'nebon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .product-price' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'product_price_margin',
            [
                'label' => __('Price Margin', 'nebon'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .product-price' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // BADGES TAB
        $this->start_controls_section(
            'section_style_badges',
            [
                'label' => __('Badges', 'nebon'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'badge_typography',
                'label' => __('Badge Typography', 'nebon'),
                'selector' => '{{WRAPPER}} .product-badge',
            ]
        );

        $this->add_control(
            'badge_padding',
            [
                'label' => __('Badge Padding', 'nebon'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .product-badge' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; width: auto; height: auto;',
                ],
            ]
        );
        $this->add_control(
            'badge_border_radius',
            [
                'label' => __('Border Radius', 'nebon'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .product-badge' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'badge_margin',
            [
                'label' => __('Badge Margin', 'nebon'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .product-badge' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // BUTTON HOVER ACTIONS
        $this->start_controls_section(
            'section_style_action_btns',
            [
                'label' => __('Hover Action Buttons', 'nebon'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'action_btn_bg',
            [
                'label' => __('Background Color', 'nebon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .hover-actions-group .action-btn' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'action_btn_color',
            [
                'label' => __('Icon Color', 'nebon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .hover-actions-group .action-btn a, {{WRAPPER}} .hover-actions-group .action-btn' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'action_btn_bg_hover',
            [
                'label' => __('Hover Background Color', 'nebon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .hover-actions-group .action-btn:hover, {{WRAPPER}} .hover-actions-group .action-btn.wishlist-btn:hover' => 'background-color: {{VALUE}}; border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'action_btn_color_hover',
            [
                'label' => __('Hover Icon Color', 'nebon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .hover-actions-group .action-btn:hover a, {{WRAPPER}} .hover-actions-group .action-btn:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        parent::render();
        $settings = $this->get_element_settings();
        tech888f_get_template_elementor_widget('t888-pet-shop-category', 't888-pet-shop-category', $settings, true);
    }
}
