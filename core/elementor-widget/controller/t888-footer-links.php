<?php
namespace Elementor;

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

class T888_Footer_Links extends T888_Widget_Base
{
	public function get_name()
	{
		return 't888-footer-links';
	}

	public function get_title()
	{
		return esc_html__('Footer Links Group', 'nebon');
	}

	public function get_icon()
	{
		return 'eicon-columns';
	}

	public function get_categories()
	{
		return ['t888-elements'];
	}

	protected function _register_controls()
	{
		$this->register_column_controls('1', esc_html__('OUR SERVICE', 'nebon'));
		$this->register_column_controls('2', esc_html__('INFORMATION', 'nebon'));
		$this->register_column_controls('3', esc_html__('MY ACCOUNT', 'nebon'));
	}

	private function register_column_controls($id, $default_title)
	{
		$this->start_controls_section(
			'section_col' . $id,
		[
			'label' => esc_html__('Column ', 'nebon') . $id,
		]
		);

		$this->add_control(
			'title' . $id,
		[
			'label' => esc_html__('Title', 'nebon'),
			'type' => Controls_Manager::TEXT,
			'default' => $default_title,
		]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'text',
		[
			'label' => esc_html__('Link Text', 'nebon'),
			'type' => Controls_Manager::TEXT,
			'default' => esc_html__('Link Text', 'nebon'),
			'label_block' => true,
		]
		);

		$repeater->add_control(
			'link',
		[
			'label' => esc_html__('Link URL', 'nebon'),
			'type' => Controls_Manager::URL,
			'placeholder' => esc_html__('https://your-link.com', 'nebon'),
		]
		);

		$this->add_control(
			'links' . $id,
		[
			'label' => esc_html__('Links List', 'nebon'),
			'type' => Controls_Manager::REPEATER,
			'fields' => $repeater->get_controls(),
			'default' => [
				[
					'text' => esc_html__('Example Link', 'nebon'),
					'link' => ['url' => '#'],
				],
			],
			'title_field' => '{{{ text }}}',
		]
		);

		$this->end_controls_section();
	}

	protected function render()
	{
		parent::render();
		$settings = $this->get_settings_for_display();
		tech888f_get_template_elementor_widget('t888-footer-links', '', $settings, true);
	}
}
