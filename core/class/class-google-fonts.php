<?php

/**
 * Created by Visual Studio Code.
 * User: toanngo92
 * Date: 2/2/2019
 * Time: 7:33 PM
 */

namespace T888Core;

if (!class_exists('GoogleFont')) {
    class GoogleFont
    {
        static function _init() {}

        static function getAllFonts()
        {
            $url = 'https://www.googleapis.com/webfonts/v1/webfonts?key=1';
            $response = wp_remote_get($url);
            if (is_wp_error($response)) {
                return false;
            }
            $body = wp_remote_retrieve_body($response);
            $data = json_decode($body);
            return $data;
        }


        static function generateFontUrl($fonts)
        {
            $link = '';
            // default fonts for theme

            if (empty($fonts)) {
                $fonts = array(
                    0 => 'Philosopher:ital,wght@0,400;0,700;1,400;1,700',
                    1 => 'Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900'
                );
            }
            


            if (!empty($fonts)) {
                $link = 'https://fonts.googleapis.com/css2?family=';
                foreach ($fonts as $k => $font) {
                    if ($k > 0) {
                        $link .= '&family=';
                    }
                    $link .= $font;
                    if ($k == count($fonts) - 1) {
                        $link .= '&display=swap';
                    }
                }
            }
            return $link;
        }


        static function getFontHtml($fonts = null)
        {
            $link = self::generateFontUrl($fonts);
?>
            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link href="<?php echo esc_url($link); ?>" rel="stylesheet">
<?php
        }
    }
}

GoogleFont::_init();
