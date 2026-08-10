<?php
namespace Elementor;

class T888_Pet_Product_Carousel extends T888_Widget_Base
{
    public function get_name()
    {
        return 't888-pet-product-carousel';
    }

    public function get_title()
    {
        return __('Pet Product Carousel', 'nebon');
    }

    public function get_icon()
    {
        return 'eicon-posts-carousel';
    }

    public function get_categories()
    {
        return ['t888-elements'];
    }

    public function get_script_depends()
    {
        return ['elementor-t888-pet-product-carousel', 'swiper'];
    }

    public function get_style_depends()
    {
        return ['elementor-t888-pet-product-carousel', 'e-swiper'];
    }

    protected function _register_controls()
    {
        $this->start_controls_section(
            'section_content',
            [
                'label' => __('Content', 'nebon'),
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => __('Title', 'nebon'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('MOST POPULAR', 'nebon'),
            ]
        );

        $sale_products = get_posts([
            'post_type'   => 'product',
            'post_status' => 'publish',
            'numberposts' => 200, // Show a large amount of products to select
        ]);
        
        $options = [];
        foreach ($sale_products as $p) {
            $options[$p->ID] = '#' . $p->ID . ' - ' . $p->post_title;
        }

        $this->add_control(
            'sale_products',
            [
                'label'       => __('Select products to display', 'nebon'),
                'type'        => \Elementor\Controls_Manager::SELECT2,
                'options'     => $options,
                'multiple'    => true,
                'label_block' => true,
            ]
        );

        $this->add_control(
            'columns',
            [
                'label' => __('Carousel Columns', 'nebon'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '5',
                'options' => [
                    '3' => '3 Columns',
                    '4' => '4 Columns',
                    '5' => '5 Columns',
                    '6' => '6 Columns',
                ],
            ]
        );

        $this->end_controls_section();

        // ========== STYLE TAB ========== //

        // --- Header Style --- //
        $this->start_controls_section(
            'header_style_section',
            [
                'label' => __('Header Style', 'nebon'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'header_margin_bottom',
            [
                'label' => __('Header Margin Bottom (px)', 'nebon'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .pet-product-header' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => __('Title Color', 'nebon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .pet-product-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => __('Title Typography', 'nebon'),
                'selector' => '{{WRAPPER}} .pet-product-title',
            ]
        );

        $this->add_responsive_control(
            'title_margin',
            [
                'label' => __('Title Margin Right (px)', 'nebon'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .pet-product-title' => 'margin-right: {{SIZE}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->end_controls_section();


        // --- Navigation Arrows --- //
        $this->start_controls_section(
            'nav_style_section',
            [
                'label' => __('Navigation Arrows', 'nebon'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'nav_bg_color',
            [
                'label' => __('Background Color', 'nebon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .header-nav button' => 'background-color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_control(
            'nav_color',
            [
                'label' => __('Arrow Color', 'nebon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .header-nav button' => 'color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_responsive_control(
            'nav_size',
            [
                'label' => __('Arrow Box Size (px)', 'nebon'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 20,
                        'max' => 60,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .header-nav button' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; padding: 0 !important; display: inline-flex; align-items: center; justify-content: center;',
                ],
            ]
        );

        $this->end_controls_section();

        // --- Product Box Style --- //
        $this->start_controls_section(
            'product_box_style_section',
            [
                'label' => __('Product Box', 'nebon'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'box_padding',
            [
                'label' => __('Padding', 'nebon'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .grid-product-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'box_border',
                'label' => __('Border', 'nebon'),
                'selector' => '{{WRAPPER}} .grid-product-item',
            ]
        );

        $this->add_responsive_control(
            'box_border_radius',
            [
                'label' => __('Border Radius', 'nebon'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .grid-product-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'box_shadow',
                'label' => __('Box Shadow', 'nebon'),
                'selector' => '{{WRAPPER}} .grid-product-item',
            ]
        );

        $this->add_control(
            'box_bg_color',
            [
                'label' => __('Background Color', 'nebon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .grid-product-item' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        // --- Image Style --- //
        $this->start_controls_section(
            'image_style_section',
            [
                'label' => __('Product Image', 'nebon'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'image_padding',
            [
                'label' => __('Image Padding', 'nebon'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .product-thumbnail' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // --- Badges Style --- //
        $this->start_controls_section(
            'badges_style_section',
            [
                'label' => __('Badges', 'nebon'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'badge_width',
            [
                'label' => __('Badge Size (px)', 'nebon'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => ['min' => 10, 'max' => 100],
                ],
                'selectors' => [
                    '{{WRAPPER}} .product-badge' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; display: flex; align-items: center; justify-content: center;',
                ],
            ]
        );

        $this->add_responsive_control(
            'badge_border_radius',
            [
                'label' => __('Border Radius', 'nebon'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .product-badge' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
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

        $this->add_responsive_control(
            'badge_top_position',
            [
                'label' => __('Top Position (px)', 'nebon'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => ['px' => ['min' => -50, 'max' => 100]],
                'selectors' => [
                    '{{WRAPPER}} .product-badges-wrap' => 'top: {{SIZE}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->add_responsive_control(
            'badge_left_position',
            [
                'label' => __('Left Position (px)', 'nebon'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => ['px' => ['min' => -50, 'max' => 100]],
                'selectors' => [
                    '{{WRAPPER}} .product-badges-wrap' => 'left: {{SIZE}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'badge_typography',
                'label' => __('Typography', 'nebon'),
                'selector' => '{{WRAPPER}} .product-badge',
            ]
        );

        $this->add_control(
            'new_badge_bg',
            [
                'label' => __('New Badge BG Color', 'nebon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .product-badge.new' => 'background-color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_control(
            'new_badge_color',
            [
                'label' => __('New Badge Text Color', 'nebon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .product-badge.new' => 'color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_control(
            'sale_badge_bg',
            [
                'label' => __('Sale Badge BG Color', 'nebon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .product-badge.sale' => 'background-color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_control(
            'sale_badge_color',
            [
                'label' => __('Sale Badge Text Color', 'nebon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .product-badge.sale' => 'color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->end_controls_section();

        // --- Content Style (Title, Rating, Price) --- //
        $this->start_controls_section(
            'content_style_section',
            [
                'label' => __('Product Content', 'nebon'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'content_padding',
            [
                'label' => __('Content Padding', 'nebon'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .product-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'content_align',
            [
                'label' => __('Alignment', 'nebon'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => ['title' => __('Left', 'nebon'), 'icon' => 'eicon-text-align-left'],
                    'center' => ['title' => __('Center', 'nebon'), 'icon' => 'eicon-text-align-center'],
                    'right' => ['title' => __('Right', 'nebon'), 'icon' => 'eicon-text-align-right'],
                ],
                'selectors' => [
                    '{{WRAPPER}} .product-content' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        // Heading: TITLE
        $this->add_control(
            'heading_title_style',
            [
                'label' => __('Title', 'nebon'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'title_color_box',
            [
                'label' => __('Title Color', 'nebon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .product-title a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'title_hover_color',
            [
                'label' => __('Title Hover Color', 'nebon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .product-title a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography_box',
                'label' => __('Title Typography', 'nebon'),
                'selector' => '{{WRAPPER}} .product-title',
            ]
        );
        
        $this->add_responsive_control(
            'title_spacing',
            [
                'label' => __('Title Margin Bottom', 'nebon'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => ['px' => ['max' => 50]],
                'selectors' => [
                    '{{WRAPPER}} .product-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // Heading: RATING
        $this->add_control(
            'heading_rating_style',
            [
                'label' => __('Rating Stars', 'nebon'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'rating_color',
            [
                'label' => __('Star Color', 'nebon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .product-rating .star-rating' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .product-rating .star-rating::before' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .product-rating .star-rating span::before' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'rating_size',
            [
                'label' => __('Star Size (px)', 'nebon'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => ['px' => ['min' => 10, 'max' => 30]],
                'selectors' => [
                    '{{WRAPPER}} .product-rating .star-rating' => 'font-size: {{SIZE}}{{UNIT}}; display: inline-block;',
                ],
            ]
        );

        $this->add_responsive_control(
            'rating_spacing',
            [
                'label' => __('Rating Margin Bottom', 'nebon'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => ['px' => ['max' => 50]],
                'selectors' => [
                    '{{WRAPPER}} .product-rating' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // Heading: PRICE
        $this->add_control(
            'heading_price_style',
            [
                'label' => __('Price', 'nebon'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'price_typography',
                'label' => __('Price Typography', 'nebon'),
                'selector' => '{{WRAPPER}} .product-price, {{WRAPPER}} .product-price .amount',
            ]
        );

        $this->add_control(
            'current_price_color',
            [
                'label' => __('Current/Sale Price Color', 'nebon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .product-price' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .product-price ins' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .product-price ins .amount' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .product-price > .amount' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'old_price_color',
            [
                'label' => __('Old/Regular Price Color', 'nebon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .product-price del' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .product-price del .amount' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'price_gap',
            [
                'label' => __('Gap between Old & New price (px)', 'nebon'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => ['px' => ['max' => 30]],
                'selectors' => [
                    '{{WRAPPER}} .product-price del' => 'margin-left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        parent::render();
        $settings = $this->get_element_settings();
        tech888f_get_template_elementor_widget('t888-pet-product-carousel', 't888-pet-product-carousel', $settings, true);
    }
}
