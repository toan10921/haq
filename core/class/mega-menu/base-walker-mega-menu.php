<?php
namespace T888Core;
class Base_Walker_Nav_Menu extends \Walker_Nav_Menu
{

    /**
     * Add HTML attribute
     * @param string $value
     * @param bool $echo
     * @param string $attr
     * @return string|void
     */
    public static function _tech888f_add_html_attr($value, $echo = false, $attr = 'style')
    {
        $output = '';
        if (!empty($attr)) {
            $output = $attr . '="' . $value . '"';
        }
        if ($echo) echo apply_filters('tech888f_output_content', $output);
        else return $output;
    }
}
