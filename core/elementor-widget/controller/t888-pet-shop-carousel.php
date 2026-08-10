<?php
namespace Elementor;

class T888_Pet_Shop_Carousel extends T888_Widget_Base
{
    public function get_name()
    {
        return 't888-pet-shop-carousel';
    }

    public function get_title()
    {
        return __('Pet Shop Carousel', 'nebon');
    }

    public function get_icon()
    {
        return 'eicon-products';
    }

    public function get_categories()
    {
        return ['t888-elements'];
    }

    public function get_script_depends()
    {
        return ['elementor-t888-pet-shop-carousel', 'swiper'];
    }

    public function get_style_depends()
    {
        return ['elementor-t888-pet-shop-carousel', 'e-swiper'];
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
                'type' => Controls_Manager::TEXT,
                'default' => __('DOG SHOP', 'nebon'),
            ]
        );

        $this->add_control(
            'product_style',
            [
                'label' => __('Select Style', 'nebon'),
                'type' => Controls_Manager::SELECT,
                'default' => 'style6',
                'options' => [
                    'style1' => __('Style 1 - Products List SlideShow', 'nebon'),
                    'style2' => __('Style 2 - Products List Load Loadmore', 'nebon'),
                    'style3' => __('Style 3 Slider 2', 'nebon'),
                    'style4' => __('Style 4 Slider 3', 'nebon'),
                    'style5' => __('Style 5 - Cart Cross Sell', 'nebon'),
                    'style6' => __('Style 6 - Product Grid', 'nebon'),
                ],
            ]
        );

        $this->add_control(
            'style6_show_tab_arrows',
            [
                'label' => __('Style 6: Show Tab Arrows', 'nebon'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'nebon'),
                'label_off' => __('No', 'nebon'),
                'return_value' => 'yes',
                'default' => 'yes',
                'condition' => [
                    'product_style' => 'style6',
                ],
            ]
        );

        $this->add_control(
            'style6_product_style',
            [
                'label' => __('Style 6: Product Card Style', 'nebon'),
                'type' => Controls_Manager::SELECT,
                'default' => 'pet-category',
                'options' => [
                    'pet-category' => __('Style 1 - Pet Category Card (Default)', 'nebon'),
                    'standard' => __('Style 2 - Standard Grid Card', 'nebon'),
                ],
                'description' => __('Style 1: custom pet card. Style 2: standard WooCommerce grid card.', 'nebon'),
                'condition' => [
                    'product_style' => 'style6',
                ],
            ]
        );

        $repeater = new Repeater();
        $repeater->add_control(
            'label',
            [
                'label' => __('Menu Label', 'nebon'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Dog Dry Food', 'nebon'),
                'label_block' => true,
            ]
        );
        $repeater->add_control(
            'tab_products',
            [
                'label' => __('Select products for this tab', 'nebon'),
                'type' => Controls_Manager::SELECT2,
                'options' => [],
                'multiple' => true,
                'label_block' => true,
            ]
        );

        $products = get_posts([
            'post_type' => 'product',
            'post_status' => 'publish',
            'numberposts' => 200,
        ]);

        $options = [];
        foreach ($products as $product_post) {
            $options[$product_post->ID] = '#' . $product_post->ID . ' - ' . $product_post->post_title;
        }

        $repeater->update_control(
            'tab_products',
            [
                'options' => $options,
            ]
        );

        $this->add_control(
            'menu_items',
            [
                'label' => __('Header Tabs', 'nebon'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'title_field' => '{{{ label }}}',
                'default' => [
                    ['label' => __('Dog Dry Food', 'nebon')],
                    ['label' => __('Dog Grain Free Food', 'nebon')],
                    ['label' => __('Dog Human Grade Food', 'nebon')],
                    ['label' => __('Dog Wet Food', 'nebon')],
                    ['label' => __('Puppy Food', 'nebon')],
                    ['label' => __('Dog Food Repeat Delivery', 'nebon')],
                ],
            ]
        );

        $this->add_control(
            'products',
            [
                'label' => __('Select products to display', 'nebon'),
                'type' => Controls_Manager::SELECT2,
                'options' => $options,
                'multiple' => true,
                'label_block' => true,
                'description' => __('Default product list shown initially and used as fallback for tabs without products.', 'nebon'),
            ]
        );

        $this->add_control(
            'columns',
            [
                'label' => __('Carousel Columns', 'nebon'),
                'type' => Controls_Manager::SELECT,
                'default' => '6',
                'options' => [
                    '4' => __('4 Columns', 'nebon'),
                    '5' => __('5 Columns', 'nebon'),
                    '6' => __('6 Columns', 'nebon'),
                ],
            ]
        );

        $this->add_control(
            'autoplay',
            [
                'label' => __('Autoplay Slide', 'nebon'),
                'type' => Controls_Manager::SWITCHER,
                'default' => '',
            ]
        );

        $this->add_control(
            'autoplay_delay',
            [
                'label' => __('Autoplay Delay (seconds)', 'nebon'),
                'type' => Controls_Manager::NUMBER,
                'default' => 5,
                'min' => 1,
                'condition' => [
                    'autoplay' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'show_badges',
            [
                'label' => __('Show Product Badges', 'nebon'),
                'type' => Controls_Manager::SWITCHER,
                'default' => '',
            ]
        );

        $this->add_control(
            'style6_show_badge_sale',
            [
                'label' => __('Style 6: Show Sale Badge', 'nebon'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'nebon'),
                'label_off' => __('No', 'nebon'),
                'return_value' => 'yes',
                'default' => 'yes',
                'condition' => [
                    'product_style' => 'style6',
                ],
            ]
        );

        $this->add_control(
            'style6_show_badge_new',
            [
                'label' => __('Style 6: Show New Badge', 'nebon'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'nebon'),
                'label_off' => __('No', 'nebon'),
                'return_value' => 'yes',
                'default' => 'yes',
                'condition' => [
                    'product_style' => 'style6',
                ],
            ]
        );

        $this->add_control(
            'style6_show_badge_hot',
            [
                'label' => __('Style 6: Show Hot Badge', 'nebon'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'nebon'),
                'label_off' => __('No', 'nebon'),
                'return_value' => 'yes',
                'default' => 'yes',
                'condition' => [
                    'product_style' => 'style6',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style',
            [
                'label' => __('Style', 'nebon'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'border_color',
            [
                'label' => __('Border Color', 'nebon'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .t888-pet-shop-carousel-module' => 'border-top-color: {{VALUE}};'
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        parent::render();
        $settings = $this->get_element_settings();
        tech888f_get_template_elementor_widget('t888-pet-shop-carousel', 't888-pet-shop-carousel', $settings, true);
    }
}
