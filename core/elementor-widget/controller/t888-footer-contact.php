<?php
namespace Elementor;

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

class T888_Footer_Contact extends T888_Widget_Base
{
	public function get_name()
	{
		return 't888-footer-contact';
	}

	public function get_title()
	{
		return esc_html__('Footer Contact Info', 'nebon');
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
			'label' => esc_html__('Content', 'nebon'),
		]
		);



		$this->add_control(
			'logo_text',
		[
			'label' => esc_html__('Logo Text (Fallback)', 'nebon'),
			'type' => Controls_Manager::TEXT,
			'default' => 'NEBON',
		]
		);

		$this->add_control(
			'address',
		[
			'label' => esc_html__('Address', 'nebon'),
			'type' => Controls_Manager::TEXTAREA,
			'default' => '208 St, New York City/NY 47FT, United States',
		]
		);

		$this->add_control(
			'phone_label',
		[
			'label' => esc_html__('Phone Label', 'nebon'),
			'type' => Controls_Manager::TEXT,
			'default' => 'Call Us: +1 - 2880 - 6789',
		]
		);

		$this->add_control(
			'email',
		[
			'label' => esc_html__('Email', 'nebon'),
			'type' => Controls_Manager::TEXT,
			'default' => 'atachesale@gmail.com',
		]
		);

		$this->add_control(
			'hotline',
		[
			'label' => esc_html__('Hotline Number', 'nebon'),
			'type' => Controls_Manager::TEXT,
			'default' => '(01) 998 788 886',
		]
		);

		$this->add_control(
			'app_store_link',
		[
			'label' => esc_html__('App Store Link', 'nebon'),
			'type' => Controls_Manager::URL,
			'placeholder' => esc_html__('https://your-link.com', 'nebon'),
		]
		);

		$this->add_control(
			'google_play_link',
		[
			'label' => esc_html__('Google Play Link', 'nebon'),
			'type' => Controls_Manager::URL,
			'placeholder' => esc_html__('https://your-link.com', 'nebon'),
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

		$this->add_control(
			'text_color',
		[
			'label' => esc_html__('Text Color', 'nebon'),
			'type' => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .footer-contact-info' => 'color: {{VALUE}}',
			],
		]
		);

		$this->end_controls_section();
	}

	protected function render()
	{
		parent::render();
		$settings = $this->get_settings_for_display();
		tech888f_get_template_elementor_widget('t888-footer-contact', '', $settings, true);
	}
}
