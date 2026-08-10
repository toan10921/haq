<?php

namespace Elementor;

class T888_Product_Info extends T888_Widget_Base
{
	public function get_name()
	{
		return 't888-product-info';
	}

	public function get_title()
	{
		return __('Product Info Card', 'nebon');
	}

	public function get_icon()
	{
		return 'eicon-product-images';
	}

	public function get_categories()
	{
		return ['t888-elements'];
	}

	public function get_style_depends()
	{
		return ['elementor-t888-product-info'];
	}

	protected function _register_controls()
	{
		$this->start_controls_section(
			'section_content',
			[
				'label' => __('Content', 'nebon'),
			]
		);

		$products = get_posts([
			'post_type' => 'product',
			'post_status' => 'publish',
			'numberposts' => 200,
		]);

		$options = [];
		foreach ($products as $p) {
			$options[$p->ID] = '#' . $p->ID . ' - ' . $p->post_title;
		}

		$this->add_control(
			'product_id',
			[
				'label' => __('Select Product', 'nebon'),
				'type' => Controls_Manager::SELECT2,
				'options' => $options,
				'multiple' => false,
				'label_block' => true,
			]
		);

		$this->add_control(
			'show_badge_sale',
			[
				'label' => __('Show Sale Badge', 'nebon'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_badge_new',
			[
				'label' => __('Show New Badge', 'nebon'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_badge_hot',
			[
				'label' => __('Show Hot Badge', 'nebon'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style',
			[
				'label' => __('Card Style', 'nebon'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'card_max_width',
			[
				'label' => __('Card Max Width', 'nebon'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px', '%'],
				'range' => [
					'px' => ['min' => 180, 'max' => 700],
					'%' => ['min' => 20, 'max' => 100],
				],
				'selectors' => [
					'{{WRAPPER}} .t888-product-info-products' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'card_padding',
			[
				'label' => __('Card Padding', 'nebon'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px'],
				'selectors' => [
					'{{WRAPPER}} .t888-product-info-products > .grid-product-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'accent_color',
			[
				'label' => __('Accent Color', 'nebon'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .t888-product-info-products > .grid-product-item::before' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .t888-product-info-products .product-price' => 'color: {{VALUE}};',
					'{{WRAPPER}} .t888-product-info-products .hover-actions-group .wishlist-btn' => 'background-color: {{VALUE}} !important; border-color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_responsive_control(
			'title_font_size',
			[
				'label' => __('Title Font Size', 'nebon'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => ['min' => 10, 'max' => 40],
				],
				'selectors' => [
					'{{WRAPPER}} .t888-product-info-products .product-title' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'price_font_size',
			[
				'label' => __('Price Font Size', 'nebon'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => ['min' => 12, 'max' => 56],
				],
				'selectors' => [
					'{{WRAPPER}} .t888-product-info-products .product-price' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render()
	{
		parent::render();
		$settings = $this->get_element_settings();
		tech888f_get_template_elementor_widget('t888-product-info', false, $settings, true);
	}
}


