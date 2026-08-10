<?php
namespace Elementor;

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

class T888_Footer_Social_Payment extends T888_Widget_Base
{
	public function get_name()
	{
		return 't888-footer-social-payment';
	}

	public function get_title()
	{
		return esc_html__('Footer Social & Payment', 'nebon');
	}

	public function get_icon()
	{
		return 'eicon-social-icons';
	}

	public function get_categories()
	{
		return ['t888-elements'];
	}

	protected function _register_controls()
	{
		$this->start_controls_section(
			'section_social',
		[
			'label' => esc_html__('Social Media', 'nebon'),
		]
		);

		$this->add_control(
			'social_title',
		[
			'label' => esc_html__('Social Title', 'nebon'),
			'type' => Controls_Manager::TEXT,
			'default' => 'FOLLOW US:',
		]
		);

		$repeater_social = new Repeater();

		$repeater_social->add_control(
			'social_icon',
		[
			'label' => esc_html__('Icon', 'nebon'),
			'type' => Controls_Manager::ICONS,
		]
		);

		$repeater_social->add_control(
			'social_link',
		[
			'label' => esc_html__('Link', 'nebon'),
			'type' => Controls_Manager::URL,
		]
		);

		$this->add_control(
			'social_items',
		[
			'label' => esc_html__('Social Links', 'nebon'),
			'type' => Controls_Manager::REPEATER,
			'fields' => $repeater_social->get_controls(),
			'default' => [
				['social_icon' => ['value' => 'fab fa-facebook-f', 'library' => 'brands']],
				['social_icon' => ['value' => 'fab fa-pinterest-p', 'library' => 'brands']],
				['social_icon' => ['value' => 'fab fa-instagram', 'library' => 'brands']],
				['social_icon' => ['value' => 'fab fa-youtube', 'library' => 'brands']],
			],
		]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_payment',
		[
			'label' => esc_html__('Payment Methods', 'nebon'),
		]
		);

		$this->add_control(
			'payment_title',
		[
			'label' => esc_html__('Payment Title', 'nebon'),
			'type' => Controls_Manager::TEXT,
			'default' => 'PAYMENT METHODS:',
		]
		);

		$this->add_control(
			'payment_image',
		[
			'label' => esc_html__('Payment Image', 'nebon'),
			'type' => Controls_Manager::MEDIA,
		]
		);

		$this->end_controls_section();
	}

	protected function render()
	{
		parent::render();
		$settings = $this->get_settings_for_display();
		tech888f_get_template_elementor_widget('t888-footer-social-payment', '', $settings, true);
	}
}
