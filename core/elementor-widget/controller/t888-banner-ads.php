<?php
namespace Elementor;

if (!defined('ABSPATH')) {
    exit;
}

class T888_Banner_Ads extends T888_Widget_Base
{
    public function get_name()
    {
        return 't888-banner-ads';
    }

    public function get_title()
    {
        return __('Banner Ads', 'nebon');
    }

    public function get_icon()
    {
        return 'eicon-banner';
    }

    public function get_categories()
    {
        return ['t888-elements'];
    }

    protected function _register_controls()
    {
        // ── Banner Background & General ─────────────────────────────────────
        $this->start_controls_section('general_section', [
            'label' => __('Banner Background & General', 'nebon'),
            'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);

        $this->add_responsive_control('banner_height', [
            'label' => __('Min Height', 'nebon'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['px', 'vh', '%'],
            'range' => [
                'px' => ['min' => 100, 'max' => 1000],
            ],
            'selectors' => [
                '{{WRAPPER}} .t888-banner-ads-wrap' => 'min-height: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->add_control('bg_color', [
            'label' => __('Background Color', 'nebon'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .t888-banner-ads-wrap' => 'background-color: {{VALUE}};',
            ],
        ]);

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'bg_image',
                'label' => __('Background', 'nebon'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .t888-banner-ads-wrap',
            ]
        );

        $this->add_responsive_control('banner_padding', [
            'label' => __('Banner Padding', 'nebon'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%', 'em'],
            'selectors' => [
                '{{WRAPPER}} .t888-banner-ads-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->add_responsive_control('banner_radius', [
            'label' => __('Border Radius', 'nebon'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} .t888-banner-ads-wrap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->add_control('banner_overflow', [
            'label' => __('Overflow', 'nebon'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'visible',
            'options' => [
                'visible' => __('Visible', 'nebon'),
                'hidden' => __('Hidden', 'nebon'),
                'auto' => __('Auto', 'nebon'),
                'scroll' => __('Scroll', 'nebon'),
            ],
            'selectors' => [
                '{{WRAPPER}} .t888-banner-ads-wrap' => 'overflow: {{VALUE}};',
            ],
        ]);

        $this->end_controls_section();

        // ── Banner Items (Repeater) ──────────────────────────────────────────
        $this->start_controls_section('elements_section', [
            'label' => __('Banner Items', 'nebon'),
            'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);

        $item = new \Elementor\Repeater();

        // ── Item Type ──
        $item->add_control('item_type', [
            'label' => __('Item Type', 'nebon'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'text',
            'options' => [
                'text' => __('Text / HTML', 'nebon'),
                'image' => __('Image', 'nebon'),
                'button' => __('Button', 'nebon'),
            ],
        ]);

        // ── Text ──
        $item->add_control('text_content', [
            'label' => __('Content', 'nebon'),
            'type' => \Elementor\Controls_Manager::WYSIWYG,
            'default' => __('Sale 50% Off!', 'nebon'),
            'condition' => ['item_type' => 'text'],
        ]);
        $item->add_control('text_color', [
            'label' => __('Text Color', 'nebon'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} {{CURRENT_ITEM}} .ad-text-el' => 'color: {{VALUE}};',
                '{{WRAPPER}} {{CURRENT_ITEM}} .ad-text-el *' => 'color: {{VALUE}};',
            ],
            'condition' => ['item_type' => 'text'],
        ]);
        $item->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'text_typography',
                'label' => __('Typography', 'nebon'),
                'selector' => '{{WRAPPER}} {{CURRENT_ITEM}} .ad-text-el, {{WRAPPER}} {{CURRENT_ITEM}} .ad-text-el *',
                'condition' => ['item_type' => 'text'],
            ]
        );

        // ── Image ──
        $item->add_control('image', [
            'label' => __('Image', 'nebon'),
            'type' => \Elementor\Controls_Manager::MEDIA,
            'condition' => ['item_type' => 'image'],
        ]);
        $item->add_responsive_control('image_width', [
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
        $item->add_responsive_control('image_height', [
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
        $item->add_control('image_object_fit', [
            'label' => __('Object Fit', 'nebon'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => '',
            'options' => [
                '' => __('Default', 'nebon'),
                'fill' => __('Fill', 'nebon'),
                'cover' => __('Cover', 'nebon'),
                'contain' => __('Contain', 'nebon'),
            ],
            'selectors' => [
                '{{WRAPPER}} {{CURRENT_ITEM}} .ad-img-el img' => 'object-fit: {{VALUE}};',
            ],
            'condition' => ['item_type' => 'image'],
        ]);
        $item->add_responsive_control('image_border_radius', [
            'label' => __('Border Radius', 'nebon'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} {{CURRENT_ITEM}} .ad-img-el img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
            'condition' => ['item_type' => 'image'],
        ]);
        $item->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'image_box_shadow',
                'selector' => '{{WRAPPER}} {{CURRENT_ITEM}} .ad-img-el img',
                'condition' => ['item_type' => 'image'],
            ]
        );
        $item->add_group_control(
            \Elementor\Group_Control_Css_Filter::get_type(),
            [
                'name' => 'image_css_filters',
                'selector' => '{{WRAPPER}} {{CURRENT_ITEM}} .ad-img-el img',
                'condition' => ['item_type' => 'image'],
            ]
        );

        // Image Positioning
        $item->add_control('image_position', [
            'label' => __('Position', 'nebon'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'relative',
            'options' => [
                'relative' => __('Default', 'nebon'),
                'absolute' => __('Absolute', 'nebon'),
            ],
            'selectors' => [
                '{{WRAPPER}} {{CURRENT_ITEM}} .ad-img-el' => 'position: {{VALUE}};',
            ],
            'condition' => ['item_type' => 'image'],
        ]);
        $item->add_responsive_control('image_offset_x', [
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
            'condition' => ['item_type' => 'image', 'image_position' => 'absolute'],
        ]);
        $item->add_responsive_control('image_offset_y', [
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
            'condition' => ['item_type' => 'image', 'image_position' => 'absolute'],
        ]);
        $item->add_control('image_zindex', [
            'label' => __('Z-Index', 'nebon'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'selectors' => [
                '{{WRAPPER}} {{CURRENT_ITEM}} .ad-img-el' => 'z-index: {{VALUE}};',
            ],
            'condition' => ['item_type' => 'image', 'image_position' => 'absolute'],
        ]);

        // Image link
        $item->add_control('link', [
            'label' => __('Link', 'nebon'),
            'type' => \Elementor\Controls_Manager::URL,
            'condition' => ['item_type' => ['button', 'image']],
        ]);

        // ── Button ──
        $item->add_control('button_text', [
            'label' => __('Button Text', 'nebon'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => __('Shop Now', 'nebon'),
            'condition' => ['item_type' => 'button'],
        ]);
        $item->add_control('button_color', [
            'label' => __('Button Text Color', 'nebon'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} {{CURRENT_ITEM}} .ad-btn' => 'color: {{VALUE}};',
            ],
            'condition' => ['item_type' => 'button'],
        ]);
        $item->add_control('button_bg_color', [
            'label' => __('Button Background', 'nebon'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} {{CURRENT_ITEM}} .ad-btn' => 'background-color: {{VALUE}};',
            ],
            'condition' => ['item_type' => 'button'],
        ]);
        $item->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'button_typography',
                'label' => __('Button Typography', 'nebon'),
                'selector' => '{{WRAPPER}} {{CURRENT_ITEM}} .ad-btn',
                'condition' => ['item_type' => 'button'],
            ]
        );
        $item->add_responsive_control('button_padding', [
            'label' => __('Button Padding', 'nebon'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%', 'em'],
            'selectors' => [
                '{{WRAPPER}} {{CURRENT_ITEM}} .ad-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
            'condition' => ['item_type' => 'button'],
        ]);
        $item->add_responsive_control('button_border_radius', [
            'label' => __('Button Border Radius', 'nebon'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} {{CURRENT_ITEM}} .ad-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
            'condition' => ['item_type' => 'button'],
        ]);

        // ── Shared: Margin & Alignment ──
        $item->add_responsive_control('item_margin', [
            'label' => __('Margin', 'nebon'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%', 'em'],
            'selectors' => [
                '{{WRAPPER}} {{CURRENT_ITEM}}' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
            'separator' => 'before',
        ]);
        $item->add_responsive_control('item_align', [
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

        // ── Shared: Absolute Positioning (Banner overlay mode) ──
        $item->add_control('pos_heading', [
            'label' => __('Positioning (Overlay Mode)', 'nebon'),
            'type' => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
        ]);
        $item->add_control('position', [
            'label' => __('Position Type', 'nebon'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'relative',
            'options' => [
                'relative' => __('Relative (Flow)', 'nebon'),
                'absolute' => __('Absolute (Overlay)', 'nebon'),
            ],
            'selectors' => [
                '{{WRAPPER}} {{CURRENT_ITEM}}' => 'position: {{VALUE}};',
            ],
        ]);
        $item->add_responsive_control('pos_x', [
            'label' => __('Horizontal (Left)', 'nebon'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['px', '%', 'vw'],
            'range' => [
                'px' => ['min' => -800, 'max' => 1500],
                '%' => ['min' => -150, 'max' => 150],
            ],
            'selectors' => ['{{WRAPPER}} {{CURRENT_ITEM}}' => 'left: {{SIZE}}{{UNIT}}; right: auto;'],
            'condition' => ['position' => 'absolute'],
        ]);
        $item->add_responsive_control('pos_y', [
            'label' => __('Vertical (Top)', 'nebon'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['px', '%', 'vh'],
            'range' => [
                'px' => ['min' => -800, 'max' => 1500],
                '%' => ['min' => -150, 'max' => 150],
            ],
            'selectors' => ['{{WRAPPER}} {{CURRENT_ITEM}}' => 'top: {{SIZE}}{{UNIT}}; bottom: auto;'],
            'condition' => ['position' => 'absolute'],
        ]);
        $item->add_control('item_zindex', [
            'label' => __('Z-Index', 'nebon'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'selectors' => ['{{WRAPPER}} {{CURRENT_ITEM}}' => 'z-index: {{VALUE}};'],
            'condition' => ['position' => 'absolute'],
        ]);
        $item->add_responsive_control('transform_scale', [
            'label' => __('Scale', 'nebon'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [''],
            'range' => ['' => ['min' => 0.1, 'max' => 5, 'step' => 0.1]],
            'selectors' => ['{{WRAPPER}} {{CURRENT_ITEM}}' => 'transform: scale({{SIZE}});'],
        ]);

        $this->add_control('banner_items', [
            'label' => __('Items', 'nebon'),
            'type' => \Elementor\Controls_Manager::REPEATER,
            'fields' => $item->get_controls(),
            'title_field' => '{{{ item_type }}}',
        ]);

        $this->end_controls_section();
    }

    protected function render()
    {
        parent::render();
        $settings = $this->get_element_settings();
        tech888f_get_template_elementor_widget('t888-banner-ads', 't888-banner-ads', $settings, true);
    }
}
