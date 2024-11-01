<?php

/**
 * _USER_TECHNICAL_AGREEMENT
 * 
 * @category  ups-shipping-for-woocommerce
 * @package   UPS Shipping and UPS Access Point™ : Official Plugin For WooCommerce
 * @author    United Parcel Service of America, Inc. <noreply@ups.com>
 * @license   This work is Licensed under the Apache License, version 2.0
 * https://www.apache.org/licenses/LICENSE-2.0
 * @copyright (c) 2019, United Parcel Service of America, Inc., all rights reserved
 * @link      https://www.ups.com/pl/en/services/technology-integration/ecommerce-plugins.page
 * 
 * _LICENSE_TAG
 *
 * ConvertToASCII.php - The core plugin class.
 * 
 * This is used to convert to ascii characters in the current version of the plugin
 */

class Ups_Eu_Woo_ConvertToASCII
{
    /**
     * Normalize non-ASCII characters to ASCII counterparts where possible.
     * @author	United Parcel Service of America, Inc. <noreply@ups.com>
     * @param string $str
     * @return string
     */
    private function ups_eu_woo_convert_squash_characters($str) {
        static $normalizeChars = null;
        if ($normalizeChars === null) {
            $normalizeChars = array(
                'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'Ae',
                'Ā'=>'A','Ă'=>'A','Ą'=>'A',
                'Ç'=>'C','Ć'=>'C','Ĉ'=>'C','Ċ'=>'C','Č'=>'C',
                'Đ'=>'D',
                'È'=>'E', 'É'=>'E', 'Ê'=>'E', 'Ë'=>'E',
                'Ē'=>'E','Ĕ'=>'E','Ė'=>'E','Ę'=>'E','Ě'=>'E',
                'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I',
                'Ð'=>'Dj',
                'Ñ'=>'N',
                'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O',
                'Ù'=>'U', 'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U',
                'Ý'=>'Y',
                'Þ'=>'B',
                'ß'=>'Ss',
                'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'ae',
                'ā'=>'a','ă'=>'a','ą'=>'a',
                'ç'=>'c','ć'=>'c','ĉ'=>'c','ċ'=>'c','č'=>'c',
                'đ'=>'d',
                'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e',
                'ē'=>'e','ĕ'=>'e','ė'=>'e','ę'=>'e','ě'=>'e',
                'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i',
                'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o',
                'ù'=>'u', 'ú'=>'u', 'û'=>'u',
                'ņ'=>'n',
                'ý'=>'y',
                'þ'=>'b',
                'ÿ'=>'y',
                'Š'=>'S', 'š'=>'s', 'ś' => 's',
                'Ž'=>'Z', 'ž'=>'z',
                'ƒ'=>'f',
                'Ĝ'=>'G', 'ğ'=>'g', 'Ġ'=>'G', 'ġ'=>'g', 'Ģ'=>'G', 'ģ'=>'g',
                'Ĥ'=>'H', 'ĥ'=>'h', 'Ħ'=>'H', 'ħ'=>'h',
                'Ĩ'=>'I', 'ĩ'=>'i', 'Ī'=>'I', 'ī'=>'i', 'Ĭ'=>'I', 'ĭ'=>'i', 'Į'=>'I', 'į'=>'i', 'İ'=>'I', 'ı'=>'i',
                'Ĳ'=>'IJ', 'ĳ'=>'ij',
                'Ĵ'=>'j', 'ĵ'=>'j',
                'Ķ'=>'K', 'ķ'=>'k', 'ĸ'=>'k',
                'Ĺ'=>'L', 'ĺ'=>'l', 'Ļ'=>'L', 'ļ'=>'l', 'Ľ'=>'L', 'ľ'=>'l', 'Ŀ'=>'L', 'ŀ'=>'l', 'Ł'=>'L', 'ł'=>'l',
                'Ń'=>'N', 'ń'=>'n', 'Ņ'=>'N', 'ņ'=>'n', 'Ň'=>'N', 'ň'=>'n', 'ŉ'=>'n', 'Ŋ'=>'N', 'ŋ'=>'n',
                'Ō'=>'O', 'ō'=>'o', 'Ŏ'=>'O', 'ŏ'=>'o', 'Ő'=>'O', 'ő'=>'o', 'Œ'=>'OE', 'œ'=>'oe',
                'Ŕ'=>'R', 'ŕ'=>'r', 'Ŗ'=>'R', 'ŗ'=>'r', 'Ř'=>'R', 'ř'=>'r',
                'Ś'=>'S', 'ś'=>'s', 'Ŝ'=>'S', 'ŝ'=>'s', 'Ş'=>'S', 'ş'=>'s', 'Š'=>'S', 'š'=>'s',
                'Ţ'=>'T', 'ţ'=>'t', 'Ť'=>'T', 'ť'=>'t', 'Ŧ'=>'T', 'ŧ'=>'t',
                'Ũ'=>'U', 'ũ'=>'u', 'Ū'=>'U', 'ū'=>'u', 'Ŭ'=>'U', 'ŭ'=>'u', 'Ů'=>'U', 'ů'=>'u', 'Ű'=>'U', 'ű'=>'u',
                'Ų'=>'U', 'ų'=>'u',
                'Ŵ'=>'W', 'ŵ'=>'w',
                'Ŷ'=>'Y', 'ŷ'=>'y',
                'Ź'=>'Z', 'ź'=>'z', 'Ż'=>'Z', 'ż'=>'z', 'Ž'=>'Z', 'ž'=>'z', 'ſ'=>'f',
            );
        }
        return strtr($str, $normalizeChars);
    }
    /**
     * Convert all fields in $item to ASCII.
     *
     * Do this by first normalizing the characters (á -> a, ñ -> n, etc.). If any
     * non-ASCII characters remain, replace with a default value.
     * @author	United Parcel Service of America, Inc. <noreply@ups.com>
     * @param array|object $item Array or object containing fields to convert
     * @param array|object $template Contains template fields
     * @param string $default Value to use when field not present in $template
     * @param array $ignore Optional list of fields to ignore.
     * @return not return
     */
    public function ups_eu_woo_convert_transliterator(&$item, array $ignore=null) {
        if (is_array($item)) {
            foreach ($item as $field => &$value) {
                if (is_array($value)) {
                    $this->ups_eu_woo_convert_transliterator($value);
                } else {
                    // Skip fields in the $ignore array.
                    if ($ignore && in_array($field, $ignore)) {
                        continue;
                    }
                    $this->ups_eu_woo_convert_str_replace_string($value);
                }
            }
        } else {
            $this->ups_eu_woo_convert_str_replace_string($item);
        }
    }

    /**
     * replace all fields in $item to ASCII.
     *
     * Do this by first normalizing the characters (á -> a, ñ -> n, etc.). If any
     * non-ASCII characters remain, replace with a default value.
     * @author	United Parcel Service of America, Inc. <noreply@ups.com>
     * @param $value
     * @param array|object $item Array or object containing fields to convert
     * @param array|object $template Contains template fields
     * @param string $default Value to use when field not present in $template
     * @param array $ignore Optional list of fields to ignore.
     * @return $value
     */
    public function ups_eu_woo_convert_str_replace_string(&$value, $template=null, $default='') {
        // Normalize non-ASCII characters with ASCII counterparts.
        $default = $value;
        $value = $this->ups_eu_woo_convert_squash_characters($value);
        // Replace fields that contain non-ASCII characters with a default.
        if (iconv('UTF-8', 'ASCII//TRANSLIT', $value) !== $value) {
            // If template is provided, use the template field, if set.
            if ($template) {
                if (is_object($template)) {
                    $value = $template;
                } elseif (is_array($template) && isset($template)) {
                    $value = $template;
                } else {
                    $value = $default;
                }
            } else {
                $value = $default;
            }
        }
        return $value;
    }
}
?>
