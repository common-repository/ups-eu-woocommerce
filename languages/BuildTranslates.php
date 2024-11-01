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
 * BuildTranslates.php - The core plugin class.
 *
 * This is used to build translate language file in the current version of the plugin
 */

class BuildTranslates
{
    private $file_pot_main;
    private $file_translate_old;
    private $file_translate_new;
    private $key_msgid = 'msgid ';
    private $value_msgstr = 'msgstr ';
    private $list_key_value = [];

    /*
     * Name function: _convert_file_to_array
     * Params: empty
     * Return: void
     * * */

    private function _convert_file_to_array()
    {
        $file = fopen("{$this->file_translate_old}", "r");
        $tmp_key_msgid = "";
        $tmp_value_msgstr = "";
        while (!feof($file)) {
            $string = trim(fgets($file));
            if (strlen($string) > 0) {
                if (strpos("abc_{$string}", "{$this->key_msgid}") === 4) {
                    $tmp_key_msgid = $string;
                    $tmp_value_msgstr = '';
                }
                if (strpos("abc_{$string}", "{$this->value_msgstr}") === 4) {
                    $tmp_value_msgstr = $string;
                }
                if (strlen($tmp_key_msgid) > 0) {
                    if (strlen($tmp_value_msgstr)) {
                        $this->list_key_value["{$tmp_key_msgid}"] = "{$tmp_value_msgstr}";
                        $tmp_key_msgid = '';
                        $tmp_value_msgstr = '';
                    }
                }
            }
        }
        fclose($file);
    }
    /*
     * Name function: execute
     * Params:
     *  @file_pot_main: type stirng
     *  @file_translate_old: type string
     *  @file_translate_new: type string
     * Return: void
     * * */

    public function execute($file_pot_main, $file_translate_old, $file_translate_new)
    {
        $this->file_pot_main = $file_pot_main;
        $this->file_translate_old = $file_translate_old;
        $this->file_translate_new = $file_translate_new;

        $this->_convert_file_to_array();
        file_put_contents($this->file_translate_new, "");
        $file = fopen("{$this->file_pot_main}", "r");
        $tmp_key_msgid = "";
        $tmp_value_msgstr = "";
        while (!feof($file)) {
            $string = trim(fgets($file));
            if (strlen($string) > 0) {
                if (strpos("abc_{$string}", "{$this->key_msgid}") === 4) {
                    $tmp_key_msgid = $string;
                    $tmp_value_msgstr = '';
                }
                if (strpos("abc_{$string}", "{$this->value_msgstr}") === 4) {
                    $tmp_value_msgstr = $string;
                }
                if (strlen($tmp_key_msgid) > 0) {
                    if (strlen($tmp_value_msgstr)) {
                        $string = empty($this->list_key_value["{$tmp_key_msgid}"]) ? $string : $this->list_key_value["{$tmp_key_msgid}"];
                        $tmp_key_msgid = '';
                        $tmp_value_msgstr = '';
                    }
                }
            }
            file_put_contents($this->file_translate_new, "{$string}\n", FILE_APPEND);
        }
        fclose($file);
        echo "\ndone!!!!!!\n";
    }
}

/* Build translate pl_PL */
$BuildTranslates = new BuildTranslates();
$file_pot_main = dirname(__FILE__) . "/ups-eu-woocommerce.pot";
$file_translate_old = dirname(__FILE__) . "/pl_PL/ups-eu-woocommerce-pl_PL.po";
$file_translate_new = dirname(__FILE__) . "/pl_PL/ups-eu-woocommerce-pl_PL_New.po";
$BuildTranslates->execute($file_pot_main, $file_translate_old, $file_translate_new);
/* Build translate en_GB */
$file_pot_main = dirname(__FILE__) . "/ups-eu-woocommerce.pot";
$file_translate_old = dirname(__FILE__) . "/en_GB/ups-eu-woocommerce-en_GB.po";
$file_translate_new = dirname(__FILE__) . "/en_GB/ups-eu-woocommerce-en_GB_New.po";
$BuildTranslates->execute($file_pot_main, $file_translate_old, $file_translate_new);
/* Build translate en_US */
$file_pot_main = dirname(__FILE__) . "/ups-eu-woocommerce.pot";
$file_translate_old = dirname(__FILE__) . "/en_US/ups-eu-woocommerce-en_US.po";
$file_translate_new = dirname(__FILE__) . "/en_US/ups-eu-woocommerce-en_US_New.po";
$BuildTranslates->execute($file_pot_main, $file_translate_old, $file_translate_new);
/* Build translate de_DE */
$file_pot_main = dirname(__FILE__) . "/ups-eu-woocommerce.pot";
$file_translate_old = dirname(__FILE__) . "/en_US/ups-eu-woocommerce-de_DE.po";
$file_translate_new = dirname(__FILE__) . "/en_US/ups-eu-woocommerce-de_DE_New.po";
$BuildTranslates->execute($file_pot_main, $file_translate_old, $file_translate_new);
