<?php
namespace Elementor;

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

class T888_Footer_Features extends T888_Widget_Base
{

	public function get_name()
	{
		return 't888-footer-features';
	}

	public function get_title()
	{
		return esc_html__('Footer Features', 'nebon');
	}

	public function get_icon()
	{
		return 'eicon-info-box';
	}

	public function get_categories()
	{
		return ['t888-elements'];
	}

	protected function _register_controls()
	{

		$this->start_controls_section(
			'section_content',
		[
			'label' => esc_html__('Features', 'nebon'),
		]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'title',
		[
			'label' => esc_html__('Title', 'nebon'),
			'type' => Controls_Manager::TEXT,
			'default' => esc_html__('100% VEGAN', 'nebon'),
			'label_block' => true,
		]
		);

		$repeater->add_control(
			'description',
		[
			'label' => esc_html__('Description', 'nebon'),
			'type' => Controls_Manager::TEXTAREA,
			'default' => esc_html__('Ethically human sourced stem cell cultures proven to be the most effective for all skin types.', 'nebon'),
		]
		);

		$repeater->add_control(
			'icon_type',
		[
			'label' => esc_html__('Icon Type', 'nebon'),
			'type' => Controls_Manager::SELECT,
			'default' => 'icon',
			'options' => [
				'icon' => esc_html__('Icon', 'nebon'),
				'image' => esc_html__('Image', 'nebon'),
			],
		]
		);

		$repeater->add_control(
			'icon',
		[
			'label' => esc_html__('Icon', 'nebon'),
			'type' => Controls_Manager::ICONS,
			'default' => [
				'value' => 'fas fa-check',
				'library' => 'solid',
			],
			'condition' => [
				'icon_type' => 'icon',
			],
		]
		);

		$repeater->add_control(
			'image',
		[
			'label' => esc_html__('Image', 'nebon'),
			'type' => Controls_Manager::MEDIA,
			'condition' => [
				'icon_type' => 'image',
			],
		]
		);

		$this->add_control(
			'items',
		[
			'label' => esc_html__('Feature Items', 'nebon'),
			'type' => Controls_Manager::REPEATER,
			'fields' => $repeater->get_controls(),
			'default' => [
				[
					'title' => esc_html__('100% VEGAN', 'nebon'),
				],
				[
					'title' => esc_html__('CRUELTY-FREE', 'nebon'),
				],
				[
					'title' => esc_html__('NO HARSH INGREDIENTS', 'nebon'),
				],
			],
			'title_field' => '{{{ title }}}',
		]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style',
		[
			'label' => esc_html__('Style', 'nebon'),
			'tab' => Controls_Manager::TAB_STYLE,
		]
		);

		$this->add_responsive_control(
			'padding',
		[
			'label' => esc_html__('Padding', 'nebon'),
			'type' => Controls_Manager::DIMENSIONS,
			'size_units' => ['px', 'em', '%'],
			'selectors' => [
				'{{WRAPPER}} .footer-features-widget' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		]
		);

		$this->add_control(
			'bg_color',
		[
			'label' => esc_html__('Background Color', 'nebon'),
			'type' => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .footer-features-widget' => 'background-color: {{VALUE}}',
			],
		]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
		[
			'name' => 'title_typography',
			'label' => esc_html__('Title Typography', 'nebon'),
			'selector' => '{{WRAPPER}} .feature-item h4',
		]
		);

		$this->add_control(
			'title_color',
		[
			'label' => esc_html__('Title Color', 'nebon'),
			'type' => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .feature-item h4' => 'color: {{VALUE}}',
			],
		]
		);

		$this->add_responsive_control(
			'title_margin',
		[
			'label' => esc_html__('Title Margin Bottom', 'nebon'),
			'type' => Controls_Manager::SLIDER,
			'selectors' => [
				'{{WRAPPER}} .feature-item h4' => 'margin-bottom: {{SIZE}}{{UNIT}};',
			],
		]
		);

		$this->add_control(
			'hr_desc',
		[
			'type' => Controls_Manager::DIVIDER,
		]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
		[
			'name' => 'desc_typography',
			'label' => esc_html__('Description Typography', 'nebon'),
			'selector' => '{{WRAPPER}} .feature-item p',
		]
		);

		$this->add_control(
			'desc_color',
		[
			'label' => esc_html__('Description Color', 'nebon'),
			'type' => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .feature-item p' => 'color: {{VALUE}}',
			],
		]
		);

		$this->add_control(
			'hr_icon',
		[
			'type' => Controls_Manager::DIVIDER,
		]
		);

		$this->add_control(
			'icon_color',
		[
			'label' => esc_html__('Icon Color', 'nebon'),
			'type' => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .feature-item i' => 'color: {{VALUE}}',
				'{{WRAPPER}} .feature-item svg' => 'fill: {{VALUE}}',
			],
		]
		);

		$this->add_responsive_control(
			'icon_size',
		[
			'label' => esc_html__('Icon Size', 'nebon'),
			'type' => Controls_Manager::SLIDER,
			'size_units' => ['px', 'em'],
			'range' => [
				'px' => [
					'min' => 0,
					'max' => 100,
				],
			],
			'selectors' => [
				'{{WRAPPER}} .feature-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
				'{{WRAPPER}} .feature-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				'{{WRAPPER}} .feature-icon img' => 'width: {{SIZE}}{{UNIT}};',
			],
		]
		);

		$this->add_responsive_control(
			'icon_spacing',
		[
			'label' => esc_html__('Spacing between Icon & Content', 'nebon'),
			'type' => Controls_Manager::SLIDER,
			'selectors' => [
				'{{WRAPPER}} .feature-item' => 'gap: {{SIZE}}{{UNIT}};',
			],
		]
		);

		$this->add_responsive_control(
			'icon_alignment_vertical',
		[
			'label' => esc_html__('Icon Vertical Alignment', 'nebon'),
			'type' => Controls_Manager::CHOOSE,
			'options' => [
				'flex-start' => [
					'title' => esc_html__('Top', 'nebon'),
					'icon' => 'eicon-v-align-top',
				],
				'center' => [
					'title' => esc_html__('Middle', 'nebon'),
					'icon' => 'eicon-v-align-middle',
				],
				'flex-end' => [
					'title' => esc_html__('Bottom', 'nebon'),
					'icon' => 'eicon-v-align-bottom',
				],
			],
			'selectors' => [
				'{{WRAPPER}} .feature-item' => 'align-items: {{VALUE}};',
			],
		]
		);

		$this->add_control(
			'hr_layout',
		[
			'type' => Controls_Manager::DIVIDER,
		]
		);

		$this->add_responsive_control(
			'items_gap',
		[
			'label' => esc_html__('Gap between Items', 'nebon'),
			'type' => Controls_Manager::SLIDER,
			'selectors' => [
				'{{WRAPPER}} .features-list' => 'gap: {{SIZE}}{{UNIT}};',
			],
		]
		);

		$this->add_responsive_control(
			'inner_max_width',
		[
			'label' => esc_html__('Inner Container Max Width', 'nebon'),
			'type' => Controls_Manager::SLIDER,
			'size_units' => ['px', '%'],
			'range' => [
				'px' => [
					'min' => 200,
					'max' => 1600,
				],
			],
			'selectors' => [
				'{{WRAPPER}} .footer-features-inner' => 'max-width: {{SIZE}}{{UNIT}};',
			],
		]
		);

		$this->end_controls_section();
	}

	protected function render()
	{
		parent::render();
		$settings = $this->get_settings_for_display();
		tech888f_get_template_elementor_widget('t888-footer-features', '', $settings, true);
	}
}
