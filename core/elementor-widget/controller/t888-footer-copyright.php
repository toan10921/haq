<?php
namespace Elementor;

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

class T888_Footer_Copyright extends T888_Widget_Base
{
	public function get_name()
	{
		return 't888-footer-copyright';
	}

	public function get_title()
	{
		return esc_html__('Footer Copyright', 'nebon');
	}

	public function get_icon()
	{
		return 'eicon-copyright';
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
			'label' => esc_html__('Copyright', 'nebon'),
		]
		);

		$this->add_control(
			'copyright_text',
		[
			'label' => esc_html__('Copyright Text', 'nebon'),
			'type' => Controls_Manager::TEXTAREA,
			'default' => '© 2025 - Nebon. All Rights Reserved.',
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
				'{{WRAPPER}} .footer-copyright p' => 'color: {{VALUE}}',
			],
		]
		);

		$this->end_controls_section();
	}

	protected function render()
	{
		parent::render();
		$settings = $this->get_settings_for_display();
		tech888f_get_template_elementor_widget('t888-footer-copyright', '', $settings, true);
	}
}
