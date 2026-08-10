<?php
namespace Elementor;

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

class T888_Footer_Newsletter extends T888_Widget_Base
{

	public function get_name()
	{
		return 't888-footer-newsletter';
	}

	public function get_title()
	{
		return esc_html__('Footer Newsletter', 'nebon');
	}

	public function get_icon()
	{
		return 'eicon-mail';
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
			'label' => esc_html__('Content', 'nebon'),
		]
		);

		$this->add_control(
			'title',
		[
			'label' => esc_html__('Title', 'nebon'),
			'type' => Controls_Manager::TEXT,
			'default' => esc_html__('SUBSCRIBE TO OUR NEWSLETTER', 'nebon'),
			'label_block' => true,
		]
		);

		$this->add_control(
			'description',
		[
			'label' => esc_html__('Description', 'nebon'),
			'type' => Controls_Manager::TEXTAREA,
			'default' => esc_html__('Register to receive newsletters to be updated about the latest activities of the store..', 'nebon'),
		]
		);

		$this->add_control(
			'image',
		[
			'label' => esc_html__('Choose Image (Left)', 'nebon'),
			'type' => Controls_Manager::MEDIA,
			'default' => [
				'url' => Utils::get_placeholder_image_src(),
			],
		]
		);

		$this->add_control(
			'bg_pattern',
		[
			'label' => esc_html__('Background Pattern (Right)', 'nebon'),
			'type' => Controls_Manager::MEDIA,
		]
		);

		$this->add_control(
			'placeholder',
		[
			'label' => esc_html__('Input Placeholder', 'nebon'),
			'type' => Controls_Manager::TEXT,
			'default' => esc_html__('Enter your Email ID', 'nebon'),
		]
		);

		$this->add_control(
			'button_text',
		[
			'label' => esc_html__('Button Text', 'nebon'),
			'type' => Controls_Manager::TEXT,
			'default' => esc_html__('SUBMIT NOW', 'nebon'),
		]
		);

		$this->end_controls_section();

		// STYLE TAB
		$this->start_controls_section(
			'section_style_general',
		[
			'label' => esc_html__('General Style', 'nebon'),
			'tab' => Controls_Manager::TAB_STYLE,
		]
		);

		$this->add_control(
			'bg_color',
		[
			'label' => esc_html__('Background Color', 'nebon'),
			'type' => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .footer-newsletter-widget' => 'background-color: {{VALUE}} !important',
			],
		]
		);

		$this->add_responsive_control(
			'section_padding',
		[
			'label' => esc_html__('Section Padding', 'nebon'),
			'type' => Controls_Manager::DIMENSIONS,
			'selectors' => [
				'{{WRAPPER}} .footer-newsletter-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_image',
		[
			'label' => esc_html__('Image Style (Left)', 'nebon'),
			'tab' => Controls_Manager::TAB_STYLE,
		]
		);

		$this->add_responsive_control(
			'image_width',
		[
			'label' => esc_html__('Image Width', 'nebon'),
			'type' => Controls_Manager::SLIDER,
			'selectors' => [
				'{{WRAPPER}} .newsletter-image' => 'width: {{SIZE}}{{UNIT}};',
			],
		]
		);

		$this->add_responsive_control(
			'image_left_offset',
		[
			'label' => esc_html__('Horizontal Position', 'nebon'),
			'type' => Controls_Manager::SLIDER,
			'range' => [
				'px' => ['min' => -300, 'max' => 300],
			],
			'selectors' => [
				'{{WRAPPER}} .newsletter-image' => 'left: {{SIZE}}{{UNIT}};',
			],
		]
		);

		$this->add_responsive_control(
			'image_bottom_offset',
		[
			'label' => esc_html__('Vertical Offset (Popout)', 'nebon'),
			'type' => Controls_Manager::SLIDER,
			'range' => [
				'px' => ['min' => -200, 'max' => 200],
			],
			'selectors' => [
				'{{WRAPPER}} .newsletter-image img' => 'transform: translateY({{SIZE}}{{UNIT}});',
			],
		]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_pattern',
		[
			'label' => esc_html__('Pattern Style (Right)', 'nebon'),
			'tab' => Controls_Manager::TAB_STYLE,
		]
		);

		$this->add_responsive_control(
			'pattern_width',
		[
			'label' => esc_html__('Pattern Width', 'nebon'),
			'type' => Controls_Manager::SLIDER,
			'size_units' => ['px', '%'],
			'selectors' => [
				'{{WRAPPER}} .footer-newsletter-paw-bg' => 'width: {{SIZE}}{{UNIT}};',
			],
		]
		);

		$this->add_responsive_control(
			'pattern_right_offset',
		[
			'label' => esc_html__('Horizontal Position (Right)', 'nebon'),
			'type' => Controls_Manager::SLIDER,
			'range' => [
				'px' => ['min' => -300, 'max' => 300],
			],
			'selectors' => [
				'{{WRAPPER}} .footer-newsletter-paw-bg' => 'right: {{SIZE}}{{UNIT}};',
			],
		]
		);

		$this->add_responsive_control(
			'pattern_top_offset',
		[
			'label' => esc_html__('Vertical Position (Top)', 'nebon'),
			'type' => Controls_Manager::SLIDER,
			'range' => [
				'px' => ['min' => -100, 'max' => 100],
			],
			'selectors' => [
				'{{WRAPPER}} .footer-newsletter-paw-bg' => 'top: {{SIZE}}{{UNIT}};',
			],
		]
		);

		$this->add_responsive_control(
			'pattern_popout_offset',
		[
			'label' => esc_html__('Vertical Offset (Popout)', 'nebon'),
			'type' => Controls_Manager::SLIDER,
			'range' => [
				'px' => ['min' => -200, 'max' => 200],
			],
			'selectors' => [
				'{{WRAPPER}} .footer-newsletter-paw-bg' => 'margin-top: {{SIZE}}{{UNIT}};',
			],
		]
		);

		$this->add_control(
			'pattern_opacity',
		[
			'label' => esc_html__('Opacity', 'nebon'),
			'type' => Controls_Manager::SLIDER,
			'range' => [
				'px' => ['min' => 0, 'max' => 1, 'step' => 0.1],
			],
			'selectors' => [
				'{{WRAPPER}} .footer-newsletter-paw-bg' => 'opacity: {{SIZE}};',
			],
		]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_typography',
		[
			'label' => esc_html__('Typography & Spacing', 'nebon'),
			'tab' => Controls_Manager::TAB_STYLE,
		]
		);

		$this->add_responsive_control(
			'content_left_margin',
		[
			'label' => esc_html__('Space to Left Image', 'nebon'),
			'type' => Controls_Manager::SLIDER,
			'selectors' => [
				'{{WRAPPER}} .footer-newsletter-content' => 'margin-left: {{SIZE}}{{UNIT}};',
			],
		]
		);

		$this->add_control(
			'heading_title',
		[
			'label' => esc_html__('Title', 'nebon'),
			'type' => Controls_Manager::HEADING,
			'separator' => 'before',
		]
		);

		$this->add_control(
			'title_color',
		[
			'label' => esc_html__('Color', 'nebon'),
			'type' => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .footer-newsletter-content h2' => 'color: {{VALUE}} !important',
			],
		]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
		[
			'name' => 'title_typography',
			'selector' => '{{WRAPPER}} .footer-newsletter-content h2',
		]
		);

		$this->add_responsive_control(
			'title_margin',
		[
			'label' => esc_html__('Margin Bottom', 'nebon'),
			'type' => Controls_Manager::SLIDER,
			'selectors' => [
				'{{WRAPPER}} .footer-newsletter-content h2' => 'margin-bottom: {{SIZE}}{{UNIT}};',
			],
		]
		);

		$this->add_control(
			'heading_desc',
		[
			'label' => esc_html__('Description', 'nebon'),
			'type' => Controls_Manager::HEADING,
			'separator' => 'before',
		]
		);

		$this->add_control(
			'desc_color',
		[
			'label' => esc_html__('Color', 'nebon'),
			'type' => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .footer-newsletter-content p' => 'color: {{VALUE}} !important',
			],
		]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
		[
			'name' => 'desc_typography',
			'selector' => '{{WRAPPER}} .footer-newsletter-content p',
		]
		);

		$this->add_responsive_control(
			'desc_margin',
		[
			'label' => esc_html__('Margin Bottom', 'nebon'),
			'type' => Controls_Manager::SLIDER,
			'selectors' => [
				'{{WRAPPER}} .footer-newsletter-content p' => 'margin-bottom: {{SIZE}}{{UNIT}};',
			],
		]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_form',
		[
			'label' => esc_html__('Form & Button', 'nebon'),
			'tab' => Controls_Manager::TAB_STYLE,
		]
		);

		$this->add_responsive_control(
			'form_max_width',
		[
			'label' => esc_html__('Form Global Max Width', 'nebon'),
			'type' => Controls_Manager::SLIDER,
			'selectors' => [
				'{{WRAPPER}} .newsletter-form' => 'max-width: {{SIZE}}{{UNIT}};',
			],
		]
		);

		$this->add_responsive_control(
			'form_gap',
		[
			'label' => esc_html__('Gap between Input & Button', 'nebon'),
			'type' => Controls_Manager::SLIDER,
			'size_units' => ['px'],
			'range' => [
				'px' => ['min' => 0, 'max' => 100],
			],
			'selectors' => [
				'{{WRAPPER}} .form-group' => 'gap: {{SIZE}}{{UNIT}};',
			],
		]
		);

		$this->add_control(
			'heading_input',
		[
			'label' => esc_html__('Input Settings', 'nebon'),
			'type' => Controls_Manager::HEADING,
			'separator' => 'before',
		]
		);

		$this->add_responsive_control(
			'input_width',
		[
			'label' => esc_html__('Input Width', 'nebon'),
			'type' => Controls_Manager::SLIDER,
			'size_units' => ['px', '%'],
			'range' => [
				'px' => ['min' => 100, 'max' => 1000],
				'%' => ['min' => 10, 'max' => 100],
			],
			'selectors' => [
				'{{WRAPPER}} .newsletter-form input' => 'width: {{SIZE}}{{UNIT}}; flex: none;',
			],
		]
		);

		$this->add_control(
			'input_bg_color',
		[
			'label' => esc_html__('Input Background', 'nebon'),
			'type' => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .newsletter-form input' => 'background-color: {{VALUE}}',
			],
		]
		);

		$this->add_responsive_control(
			'input_padding',
		[
			'label' => esc_html__('Input Padding', 'nebon'),
			'type' => Controls_Manager::DIMENSIONS,
			'selectors' => [
				'{{WRAPPER}} .newsletter-form input' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		]
		);

		$this->add_responsive_control(
			'input_border_radius',
		[
			'label' => esc_html__('Input Border Radius', 'nebon'),
			'type' => Controls_Manager::DIMENSIONS,
			'selectors' => [
				'{{WRAPPER}} .newsletter-form input' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		]
		);

		$this->add_control(
			'heading_button',
		[
			'label' => esc_html__('Button Settings', 'nebon'),
			'type' => Controls_Manager::HEADING,
			'separator' => 'before',
		]
		);

		$this->add_responsive_control(
			'button_width',
		[
			'label' => esc_html__('Button Width', 'nebon'),
			'type' => Controls_Manager::SLIDER,
			'size_units' => ['px', '%'],
			'range' => [
				'px' => ['min' => 50, 'max' => 500],
				'%' => ['min' => 10, 'max' => 100],
			],
			'selectors' => [
				'{{WRAPPER}} .newsletter-form button' => 'width: {{SIZE}}{{UNIT}}; flex: none;',
			],
		]
		);

		$this->add_control(
			'button_bg_color',
		[
			'label' => esc_html__('Button Background', 'nebon'),
			'type' => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .newsletter-form button' => 'background-color: {{VALUE}}',
			],
		]
		);

		$this->add_responsive_control(
			'button_padding',
		[
			'label' => esc_html__('Button Padding', 'nebon'),
			'type' => Controls_Manager::DIMENSIONS,
			'selectors' => [
				'{{WRAPPER}} .newsletter-form button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		]
		);

		$this->add_responsive_control(
			'button_border_radius',
		[
			'label' => esc_html__('Button Border Radius', 'nebon'),
			'type' => Controls_Manager::DIMENSIONS,
			'selectors' => [
				'{{WRAPPER}} .newsletter-form button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		]
		);

		$this->end_controls_section();
	}

	protected function render()
	{
		parent::render();
		$settings = $this->get_settings_for_display();
		tech888f_get_template_elementor_widget('t888-footer-newsletter', '', $settings, true);
	}
}
