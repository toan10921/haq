<?php

/**
 * Created by khangtrinh.
 * User: khangtrinh
 * Date: 13/06/2024
 * Time: 04:20 PM
 */

namespace Elementor;

// if (!defined('ABSPATH')) {
//     exit; // Exit if accessed directly
// }

class T888_List_Post extends T888_Widget_Base
{
    /**
     * Get widget name.
     */
    public function get_name()
    {
        return 't888-list-post';
    }

    /**
     * Get widget title.
     */
    public function get_title()
    {
        return __('List Post', 'nebon');
    }

    /**
     * Get widget icon.
     */
    public function get_icon()
    {
        return 'fas fa-list-alt';
    }
    /**
     * Add script depends.
     *
     * Register new script to enqueue by the handler.
     *
     * @since 1.9.0
     * @access public
     *
     * @param string $handler Depend script handler.
     */
    public function get_script_depends()
    {
        return [];
    }

    /**
     * Add style depends.
     *
     * Register new style to enqueue by the handler.
     *
     * @since 1.9.0
     * @access public
     *
     * @param string $handler Depend style handler.
     */
    public function get_style_depends()
    {
        return ['elementor-t888-list-post'];
    }
    /**
     * Get widget categories.
     */
    public function get_categories()
    {
        return ['t888-elements'];
    }

    /**
     * Register controls.
     */
    protected function _register_controls()
    {
        $this->start_controls_section(
            'section_content',
        [
            'label' => __('List Post', 'nebon'),
        ]
        );

        $this->add_control(
            'style',
        [
            'label' => __('Style', 'nebon'),
            'type' => Controls_Manager::SELECT,
            'options' => [
                'style1' => __('Standard', 'nebon'),
                'style2' => __('List', 'nebon'),
                'style3' => __('Grid', 'nebon'),
                'style4' => __('Masonry', 'nebon'),
                'style5' => __('Grid 2', 'nebon'),
                'style6' => __('Featured Overlay', 'nebon'),
                'style7' => __('Split Post Card', 'nebon'),
                'style8' => __('Post Card Grid', 'nebon'),
            ]
        ]
        );

        $this->add_control(
            'posts_per_page',
        [
            'label' => __('Number of Posts', 'nebon'),
            'type' => Controls_Manager::NUMBER,
            'min' => 1,
            'max' => 50,
            'default' => 6,
        ]
        );

        $this->add_control(
            'post_categories',
        [
            'label' => __('Select Categories', 'nebon'),
            'type' => Controls_Manager::SELECT2,
            'multiple' => true,
            'options' => $this->get_categories_options(),
            'label_block' => true,
        ]
        );

        $this->add_control(
            'order_by',
        [
            'label' => __('Order By', 'nebon'),
            'type' => Controls_Manager::SELECT,
            'default' => 'date',
            'options' => [
                'date' => __('Date', 'nebon'),
                'title' => __('Title', 'nebon'),
                'rand' => __('Random', 'nebon'),
            ],
        ]
        );

        $this->add_control(
            'order',
        [
            'label' => __('Order', 'nebon'),
            'type' => Controls_Manager::SELECT,
            'default' => 'DESC',
            'options' => [
                'ASC' => __('Ascending', 'nebon'),
                'DESC' => __('Descending', 'nebon'),
            ],
        ]
        );

        $this->add_control(
            'columns',
        [
            'label' => __('Columns (for Grid Styles)', 'nebon'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => '2',
            'options' => [
                '1' => __('1 Column', 'nebon'),
                '2' => __('2 Columns', 'nebon'),
                '3' => __('3 Columns', 'nebon'),
                '4' => __('4 Columns', 'nebon'),
            ],
            'condition' => [
                'style' => ['style3', 'style4', 'style5', 'style6', 'style7'],
            ],
        ]
        );

        $this->add_responsive_control(
            'style8_columns',
        [
            'label' => __('Columns', 'nebon'),
            'type' => Controls_Manager::SELECT,
            'default' => '3',
            'tablet_default' => '2',
            'mobile_default' => '1',
            'options' => [
                '1' => __('1 Column', 'nebon'),
                '2' => __('2 Columns', 'nebon'),
                '3' => __('3 Columns', 'nebon'),
                '4' => __('4 Columns', 'nebon'),
            ],
            'selectors' => [
                '{{WRAPPER}} .blog-wrap.grid-style8 .posts-wrap' => '--t888-style8-columns: {{VALUE}};',
            ],
            'condition' => [
                'style' => 'style8',
            ],
        ]
        );

        $this->add_control(
            'gutter_spacing',
        [
            'label' => __('Gutter Spacing Masonry', 'nebon'),
            'type' => Controls_Manager::SELECT,
            'default' => 'gutter-20',
            'options' => [
                'gutter-5' => '5px',
                'gutter-10' => '10px',
                'gutter-15' => '15px',
                'gutter-20' => '20px',
                'gutter-25' => '25px',
                'gutter-30' => '30px',
            ],
            'condition' => [
                'style' => 'style4',
            ],
        ]

        );

        $this->add_control(
            'excerpt_length',
        [
            'label' => __('Excerpt Length (Words)', 'nebon'),
            'type' => Controls_Manager::NUMBER,
            'default' => 50,
            'condition' => [
                'style' => ['style5', 'style6', 'style7'],
            ],
        ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_thumb',
        [
            'label' => __('Thumbnail', 'nebon'),
            'tab' => Controls_Manager::TAB_STYLE,
            'condition' => [
                'style' => 'style5',
            ],
        ]
        );

        $this->add_responsive_control(
            'thumb_padding',
        [
            'label' => __('Thumbnail Padding', 'nebon'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', '%'],
            'selectors' => [
                '{{WRAPPER}} .grid-style5-item .post-thumb' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]
        );

        $this->add_control(
            'thumb_border_radius',
        [
            'label' => __('Border Radius', 'nebon'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px', '%'],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 100,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .grid-style5-item .post-thumb img' => 'border-radius: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .grid-style5-item .post-thumb-link' => 'border-radius: {{SIZE}}{{UNIT}};',
            ],
        ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_date',
        [
            'label' => __('Date Badge', 'nebon'),
            'tab' => Controls_Manager::TAB_STYLE,
            'condition' => [
                'style' => 'style5',
            ],
        ]
        );

        $this->add_control(
            'date_bg_color',
        [
            'label' => __('Background Color', 'nebon'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .grid-style5-item .post-date-badge' => 'background-color: {{VALUE}} !important',
            ],
        ]
        );

        $this->add_responsive_control(
            'date_position_bottom',
        [
            'label' => __('Bottom Offset', 'nebon'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px', '%'],
            'range' => [
                'px' => ['min' => -100, 'max' => 200],
            ],
            'selectors' => [
                '{{WRAPPER}} .grid-style5-item .post-date-badge' => 'bottom: {{SIZE}}{{UNIT}} !important',
            ],
        ]
        );

        $this->add_responsive_control(
            'date_position_left',
        [
            'label' => __('Left Offset', 'nebon'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px', '%'],
            'range' => [
                'px' => ['min' => -100, 'max' => 200],
            ],
            'selectors' => [
                '{{WRAPPER}} .grid-style5-item .post-date-badge' => 'left: {{SIZE}}{{UNIT}} !important',
            ],
        ]
        );

        $this->end_controls_section();

        // Style Tab
        $this->start_controls_section(
            'section_style_title',
        [
            'label' => __('Title', 'nebon'),
            'tab' => Controls_Manager::TAB_STYLE,
            'condition' => [
                'style' => 'style5',
            ],
        ]
        );

        $this->add_control(
            'title_color',
        [
            'label' => __('Color', 'nebon'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .grid-style5-item .post-title a' => 'color: {{VALUE}}',
            ],
        ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
        [
            'name' => 'title_typography',
            'selector' => '{{WRAPPER}} .grid-style5-item .post-title',
        ]
        );

        $this->add_responsive_control(
            'title_margin',
        [
            'label' => __('Margin', 'nebon'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', '%'],
            'selectors' => [
                '{{WRAPPER}} .grid-style5-item .post-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_meta',
        [
            'label' => __('Meta (Author)', 'nebon'),
            'tab' => Controls_Manager::TAB_STYLE,
            'condition' => [
                'style' => 'style5',
            ],
        ]
        );

        $this->add_control(
            'meta_color',
        [
            'label' => __('Color', 'nebon'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .grid-style5-item .post-meta .author' => 'color: {{VALUE}}',
            ],
        ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
        [
            'name' => 'meta_typography',
            'selector' => '{{WRAPPER}} .grid-style5-item .post-meta .author',
        ]
        );

        $this->add_responsive_control(
            'meta_margin',
        [
            'label' => __('Margin', 'nebon'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', '%'],
            'selectors' => [
                '{{WRAPPER}} .grid-style5-item .post-meta' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_excerpt',
        [
            'label' => __('Excerpt', 'nebon'),
            'tab' => Controls_Manager::TAB_STYLE,
            'condition' => [
                'style' => 'style5',
            ],
        ]
        );

        $this->add_control(
            'excerpt_color',
        [
            'label' => __('Color', 'nebon'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .grid-style5-item .post-excerpt p' => 'color: {{VALUE}}',
            ],
        ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
        [
            'name' => 'excerpt_typography',
            'selector' => '{{WRAPPER}} .grid-style5-item .post-excerpt p',
        ]
        );

        $this->add_responsive_control(
            'excerpt_margin',
        [
            'label' => __('Margin', 'nebon'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', '%'],
            'selectors' => [
                '{{WRAPPER}} .grid-style5-item .post-excerpt' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]
        );

        $this->add_responsive_control(
            'excerpt_line_clamp',
        [
            'label' => __('Line Clamp', 'nebon'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range' => [
                'px' => [
                    'min' => 1,
                    'max' => 10,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .grid-style5-item .post-excerpt' => '-webkit-line-clamp: {{SIZE}};',
            ],
        ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_readmore',
        [
            'label' => __('Read More', 'nebon'),
            'tab' => Controls_Manager::TAB_STYLE,
            'condition' => [
                'style' => 'style5',
            ],
        ]
        );

        $this->add_control(
            'readmore_color',
        [
            'label' => __('Color', 'nebon'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .grid-style5-item .read-more' => 'color: {{VALUE}}',
            ],
        ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
        [
            'name' => 'readmore_typography',
            'selector' => '{{WRAPPER}} .grid-style5-item .read-more',
        ]
        );

        $this->add_responsive_control(
            'readmore_margin',
        [
            'label' => __('Margin', 'nebon'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', '%'],
            'selectors' => [
                '{{WRAPPER}} .grid-style5-item .read-more' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_card',
        [
            'label' => __('Card Box', 'nebon'),
            'tab' => Controls_Manager::TAB_STYLE,
            'condition' => [
                'style' => 'style5',
            ],
        ]
        );

        $this->add_control(
            'card_bg_color',
        [
            'label' => __('Background Color', 'nebon'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .grid-style5-item .grid-style5-card' => 'background-color: {{VALUE}}',
            ],
        ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
        [
            'name' => 'card_border',
            'selector' => '{{WRAPPER}} .grid-style5-item .grid-style5-card',
        ]
        );

        $this->add_responsive_control(
            'card_padding',
        [
            'label' => __('Content Padding', 'nebon'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', '%'],
            'selectors' => [
                '{{WRAPPER}} .grid-style5-item .post-info' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
        [
            'name' => 'card_box_shadow',
            'selector' => '{{WRAPPER}} .grid-style5-item .grid-style5-card',
        ]
        );

        $this->end_controls_section();
    }
    private function get_categories_options()
    {
        $terms = get_terms([
            'taxonomy' => 'category',
            'hide_empty' => false,
        ]);

        $options = [];
        if (!is_wp_error($terms)) {
            foreach ($terms as $term) {
                $options[$term->term_id] = $term->name;
            }
        }
        return $options;
    }


    /**
     * Render widget output on the frontend.
     */
    protected function render()
    {
        parent::render();
        $settings = $this->get_settings_for_display();
        $style = isset($settings['style']) ? $settings['style'] : 'style1';
        tech888f_get_template_elementor_widget('t888-list-post', $style, $settings, true);
    }
}
