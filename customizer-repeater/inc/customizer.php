<?php
function customizer_repeater_register($wp_customize)
{
	// Use WordPress function for loading class files
	$control_file = get_template_directory() . '/customizer-repeater/class/customizer-repeater-control.php';

	if (file_exists($control_file)) {
		require_once $control_file;
	}
}
add_action('customize_register', 'customizer_repeater_register');

function customizer_repeater_sanitize($input)
{
	$input_decoded = json_decode($input, true);

	if (!empty($input_decoded)) {
		foreach ($input_decoded as $boxk => $box) {
			foreach ($box as $key => $value) {

				$input_decoded[$boxk][$key] = wp_kses_post($value);
			}
		}
		return json_encode($input_decoded);
	}
	return $input;
}
