<?php namespace UpsEuWoocommerce\models;

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
 * ups-eu-woo-model-options.php - The core plugin class.
 *
 * This is used to define the Ups_Eu_Woo_Model_Options Model.
 */

require_once(dirname(__FILE__, 2) . '/ups-eu-woo-autoloader.php');
new \UpsEuWoocommerce\Ups_Eu_Woo_Main_Autoloader('Ups_Eu_Woo_Model_Options');

class Ups_Eu_Woo_Model_Options
{
    private $_code = "code";
    private $_name = "name";
    private $_regex = "regex";
    /**
    * arr Release
    * PL, GB, FR, DE, ES, IT, NL, BE
    */
    const release = ['PL', 'FR', 'GB', 'DE', 'ES', 'IT', 'NL', 'BE', 'AT', 'BG', 'HR', 'CY', 'CZ', 'DK', 'EE', 'FI', 'GR', 'HU', 'IE', 'LV', 'LT', 'LU', 'MT', 'PT',  'RO', 'SK', 'SI', 'SE', 'NO', 'RS', 'CH', 'IS', 'JE', 'TR'];

    /*
     * Name function: ups_eu_woo_get_currency_list
     * Params: empty
     * Return: type array
     * * */

    public function ups_eu_woo_get_currency_list()
    {
        return [
            "AED" => "Arab Emirates Dirham",
            "ARS" => "Argentina Peso",
            "AUD" => "Australian Dollar",
            "BBD" => "Barbados Dollar",
            "BHD" => "Bahrain Dinar",
            "BRL" => "Brazilian Real",
            "BYN" => "Belarus Ruble",
            "CAD" => "Canadian Dollar",
            "CHF" => "Swiss Franc",
            "CLP" => "Chilean Peso",
            "CNY" => "China Renminbi Yuan",
            "COP" => "Colombian Peso",
            "CRC" => "Costa Rican Colon",
            "CZK" => "Czech Koruna",
            "DKK" => "Danish Kroner",
            "DOP" => "Dom Rep Peso",
            "EUR" => "Euro",
            "GBP" => "Pound Sterling",
            "HKD" => "Hong Kong Dollar",
            "HUF" => "Hungarian Forint",
            "IDR" => "Indonesian Rupiah",
            "INR" => "Indian Rupee",
            "JPY" => "Japanese Yen",
            "KWD" => "Kuwait Dinar",
            "KRW" => "Korean Won",
            "KZT" => "Kazakhstan Tenge",
            "MAD" => "Morocco Dirham",
            "MOP" => "Macau Pataca",
            "MXN" => "Mexican Peso",
            "MYR" => "Malaysian Ringgit",
            "NGN" => "Nigerian Naira",
            "NOK" => "Norway Kroner",
            "NZD" => "New Zealand Dollar",
            "PAB" => "Panamanian Balboa",
            "PHP" => "Philippine Peso",
            "PLN" => "Polish Zloty",
            "RON" => "Romanian Leu",
            "RUB" => "Russia Ruble",
            "SEK" => "Swedish Kroner",
            "SGD" => "Singapore Dollar",
            "THB" => "Thailand Baht",
            "TRY" => "Turkey",
            "TWD" => "Taiwan Dollar",
            "VND" => "Vietnam đồng",
            "UAH" => "Ukraine Hyrvnya",
            "USD" => "U.S. Dollar",
            "ZAR" => "South African Rand",
            "ISK" => "Iceland Krona"
        ];
    }
    /**
     * Ups_Eu_Woo_Model_Options get_country_code_list
     *
     * @return array
     */
    public function get_country_code_list()
    {
        return [
            'BE' => [50.844391, 4.35609],
            'NL' => [52.373055, 4.892222],
            'FR' => [48.85717, 2.3414],
            'ES' => [40.42028, -3.70577],
            'PL' => [52.2356, 21.01037],
            'IT' => [41.903221, 12.49565],
            'DE' => [52.516041, 13.37691],
            'GB' => [51.50632, -0.12714],
            'US' => [47.411297, -120.556267],
            'AT' => [48.210033, 16.363449],
            'BG' => [42.698334, 23.319941],
            'HR' => [45.815399, 15.966568],
            'CY' => [35.095192, 33.203430],
            'CZ' => [50.073658, 14.418540],
            'DK' => [55.676098, 12.568337],
            'EE' => [59.379913, 28.191261],
            'FI' => [60.192059, 24.945831],
            'GR' => [37.983810, 23.727539],
            'HU' => [47.497913, 19.040236],
            'IE' => [53.350140, 6.266155],
            'LV' => [56.946285, 24.105078],
            'LT' => [54.687157, 25.279652],
            'LU' => [49.611622, 6.131935],
            'MT' => [35.917973, 14.409943],
            'PT' => [38.736946, -9.142685],
            'RO' => [44.439663, 26.096306],
            'SK' => [48.148598, 17.107748],
            'SI' => [46.056946, 14.505751],
            'SE' => [59.334591, 18.063240],
            'NO' => [61.665609, 9.688318],
            'RS' => [44.012368, 20.921124],
            'CH' => [46.748412, 8.095468],
            'IS' => [64.137137, -20.325936],
            'JE' => [49.226937, -2.145567],
            'TR' => [38.770222, 35.288987]
        ];
    }
    /*
     * Name function: get_country_list
     * Params: empty
     * Return: type array
     * * */

    public function get_country_list()
    {
        $data = [
            /* Belgium */
            "BE" => [
                $this->_code => "BE",
                $this->_name => __("Belgium", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain),
                $this->_regex => "/^([[:alnum:]]{2})\s([[:alnum:]]{3,4})?$/",
            ]
        ];
        /* Français */
        if (in_array("FR", self::release)) {
            $data["FR"] = [
                $this->_code => "FR",
                $this->_name => __("France", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain),
                $this->_regex => "/^([[:alnum:]]{2})\s([[:alnum:]]{3,4})?$/",
            ];
        }
        /* Deutsch */
        if (in_array("DE", self::release)) {
            $data["DE"] = [
                $this->_code => "DE",
                $this->_name => __("Germany", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain),
                $this->_regex => "/^([[:alnum:]]{2})\s([[:alnum:]]{3,4})?$/",
            ];
        }
        /* Italiano */
        if (in_array("IT", self::release)) {
            $data["IT"] = [
                $this->_code => "IT",
                $this->_name => __("Italy", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain),
                $this->_regex => "/^([[:alnum:]]{2})\s([[:alnum:]]{3,4})?$/",
            ];
        }
        /* Nederlands */
        if (in_array("NL", self::release)) {
            $data["NL"] = [
                $this->_code => "NL",
                $this->_name => __("Netherlands", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain),
                $this->_regex => "/^([[:alnum:]]{2})\s([[:alnum:]]{3,4})?$/",
            ];
        }
        /* Poland */
        if (in_array("PL", self::release)) {
            $data["PL"] = [
                $this->_code => "PL",
                $this->_name => __("Poland", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain),
                $this->_regex => "/^([0-9]{2})-([0-9]{3,4})?$/",
            ];
        }
        /* Español */
        if (in_array("ES", self::release)) {
            $data["ES"] = [
                $this->_code => "ES",
                $this->_name => __("Spain", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain),
                $this->_regex => "/^([[:alnum:]]{2})\s([[:alnum:]]{3,4})?$/",
            ];
        }
        /* United Kingdom */
        if (in_array("GB", self::release)) {
            $data["GB"] = [
                $this->_code => "GB",
                $this->_name => __("United Kingdom", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain),
                $this->_regex => "/^([[:alnum:]]{2})\s([[:alnum:]]{3,4})?$/",
            ];
        }
        /* United States */
        if (in_array("US", self::release)) {
            $data["US"] = [
                $this->_code => "US",
                $this->_name => __("United States", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain),
                $this->_regex => "/^([[:alnum:]]{2})\s([[:alnum:]]{3,4})?$/",
            ];
        }
        /* Austria */
        if (in_array("AT", self::release)) {
            $data["AT"] = [
                $this->_code => "AT",
                $this->_name => __(" Austria", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain),
                $this->_regex => "/^([[:alnum:]]{2})\s([[:alnum:]]{3,4})?$/",
            ];
        }
        // /* Bulgaria */
        // if (in_array("BG", self::release)) {
        //     $data["BG"] = [
        //         $this->_code => "BG",
        //         $this->_name => __(" Bulgaria", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain),
        //         $this->_regex => "/^([[:alnum:]]{2})\s([[:alnum:]]{3,4})?$/",
        //     ];
        // }
        // /* Croatia */
        // if (in_array("HR", self::release)) {
        //     $data["HR"] = [
        //         $this->_code => "HR",
        //         $this->_name => __(" Croatia", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain),
        //         $this->_regex => "/^([[:alnum:]]{2})\s([[:alnum:]]{3,4})?$/",
        //     ];
        // }
        // /* Cyprus */
        // if (in_array("CY", self::release)) {
        //     $data["CY"] = [
        //         $this->_code => "CY",
        //         $this->_name => __(" Cyprus", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain),
        //         $this->_regex => "/^([[:alnum:]]{2})\s([[:alnum:]]{3,4})?$/",
        //     ];
        // }
        /* CzechRepublic */
        if (in_array("CZ", self::release)) {
            $data["CZ"] = [
                $this->_code => "CZ",
                $this->_name => __(" CzechRepublic", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain),
                $this->_regex => "/^([[:alnum:]]{2})\s([[:alnum:]]{3,4})?$/",
            ];
        }
        /* Denmark */
        if (in_array("DK", self::release)) {
            $data["DK"] = [
                $this->_code => "DK",
                $this->_name => __(" Denmark", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain),
                $this->_regex => "/^([[:alnum:]]{2})\s([[:alnum:]]{3,4})?$/",
            ];
        }
        // /* Estonia */
        // if (in_array("EE", self::release)) {
        //     $data["EE"] = [
        //         $this->_code => "EE",
        //         $this->_name => __(" Estonia", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain),
        //         $this->_regex => "/^([[:alnum:]]{2})\s([[:alnum:]]{3,4})?$/",
        //     ];
        // }
        /* Finland */
        if (in_array("FI", self::release)) {
            $data["FI"] = [
                $this->_code => "FI",
                $this->_name => __(" Finland", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain),
                $this->_regex => "/^([[:alnum:]]{2})\s([[:alnum:]]{3,4})?$/",
            ];
        }
        /* Greece */
        if (in_array("GR", self::release)) {
            $data["GR"] = [
                $this->_code => "GR",
                $this->_name => __(" Greece", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain),
                $this->_regex => "/^([[:alnum:]]{2})\s([[:alnum:]]{3,4})?$/",
            ];
        }
        /* Hungary */
        if (in_array("HU", self::release)) {
            $data["HU"] = [
                $this->_code => "HU",
                $this->_name => __(" Hungary", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain),
                $this->_regex => "/^([[:alnum:]]{2})\s([[:alnum:]]{3,4})?$/",
            ];
        }
        /* Ireland */
        if (in_array("IE", self::release)) {
            $data["IE"] = [
                $this->_code => "IE",
                $this->_name => __(" Ireland", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain),
                $this->_regex => "/^([[:alnum:]]{2})\s([[:alnum:]]{3,4})?$/",
            ];
        }
        // /* Latvia */
        // if (in_array("LV", self::release)) {
        //     $data["LV"] = [
        //         $this->_code => "LV",
        //         $this->_name => __(" Latvia", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain),
        //         $this->_regex => "/^([[:alnum:]]{2})\s([[:alnum:]]{3,4})?$/",
        //     ];
        // }
        // /* Lithuania */
        // if (in_array("LT", self::release)) {
        //     $data["LT"] = [
        //         $this->_code => "LT",
        //         $this->_name => __(" Lithuania", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain),
        //         $this->_regex => "/^([[:alnum:]]{2})\s([[:alnum:]]{3,4})?$/",
        //     ];
        // }
        /* Luxembourg */
        if (in_array("LU", self::release)) {
            $data["LU"] = [
                $this->_code => "LU",
                $this->_name => __(" Luxembourg", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain),
                $this->_regex => "/^([[:alnum:]]{2})\s([[:alnum:]]{3,4})?$/",
            ];
        }
        // /* Malta */
        // if (in_array("MT", self::release)) {
        //     $data["MT"] = [
        //         $this->_code => "MT",
        //         $this->_name => __(" Malta", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain),
        //         $this->_regex => "/^([[:alnum:]]{2})\s([[:alnum:]]{3,4})?$/",
        //     ];
        // }
        /* Portugal */
        if (in_array("PT", self::release)) {
            $data["PT"] = [
                $this->_code => "PT",
                $this->_name => __(" Portugal", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain),
                $this->_regex => "/^([[:alnum:]]{2})\s([[:alnum:]]{3,4})?$/",
            ];
        }
        /* Romania */
        if (in_array("RO", self::release)) {
            $data["RO"] = [
                $this->_code => "RO",
                $this->_name => __(" Romania", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain),
                $this->_regex => "/^([[:alnum:]]{2})\s([[:alnum:]]{3,4})?$/",
            ];
        }
        // /* Slovakia */
        // if (in_array("SK", self::release)) {
        //     $data["SK"] = [
        //         $this->_code => "SK",
        //         $this->_name => __(" Slovakia", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain),
        //         $this->_regex => "/^([[:alnum:]]{2})\s([[:alnum:]]{3,4})?$/",
        //     ];
        // }
        /* Slovenia */
        if (in_array("SI", self::release)) {
            $data["SI"] = [
                $this->_code => "SI",
                $this->_name => __(" Slovenia", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain),
                $this->_regex => "/^([[:alnum:]]{2})\s([[:alnum:]]{3,4})?$/",
            ];
        }
        /* Sweden */
        if (in_array("SE", self::release)) {
            $data["SE"] = [
                $this->_code => "SE",
                $this->_name => __(" Sweden", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain),
                $this->_regex => "/^([[:alnum:]]{2})\s([[:alnum:]]{3,4})?$/",
            ];
        }
        /* Norway  */
        if (in_array("NO", self::release)) {
            $data["NO"] = [
                $this->_code => "NO",
                $this->_name => __("Norway", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain),
                $this->_regex => "/^([[:alnum:]]{2})\s([[:alnum:]]{3,4})?$/",
            ];
        }
        // /* Serbia  */
        // if (in_array("RS", self::release)) {
        //     $data["RS"] = [
        //         $this->_code => "RS",
        //         $this->_name => __("Serbia", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain),
        //         $this->_regex => "/^([[:alnum:]]{2})\s([[:alnum:]]{3,4})?$/",
        //     ];
        // }
        /* Switzerland  */
        if (in_array("CH", self::release)) {
            $data["CH"] = [
                $this->_code => "CH",
                $this->_name => __("Switzerland", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain),
                $this->_regex => "/^([[:alnum:]]{2})\s([[:alnum:]]{3,4})?$/",
            ];
        }
        /* Iceland */
        if (in_array("IS", self::release)) {
            $data["IS"] = [
                $this->_code => "IS",
                $this->_name => __("Iceland", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain),
                $this->_regex => "/^([[:alnum:]]{2})\s([[:alnum:]]{3,4})?$/",
            ];
        }
        /* Jersey */
        if (in_array("JE", self::release)) {
            $data["JE"] = [
                $this->_code => "JE",
                $this->_name => __("Jersey", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain),
                $this->_regex => "/^([[:alnum:]]{2})\s([[:alnum:]]{3,4})?$/",
            ];
        }
        /* Turkey  */
        if (in_array("TR", self::release)) {
            $data["TR"] = [
                $this->_code => "TR",
                $this->_name => __("Turkey", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain),
                $this->_regex => "/^([[:alnum:]]{2})\s([[:alnum:]]{3,4})?$/",
            ];
        }
        return $data;
    }
    /*
     * Name function: country_list_define
     * Params: empty
     * Return: type array
     * * */

    public function country_list_define()
    {
        $data = [
            /* Belgium */
            "BE" => [
                $this->_code => "BE",
                $this->_name => __("Belgium", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain),
                $this->_regex => "/^([[:alnum:]]{2})\s([[:alnum:]]{3,4})?$/",
            ]
        ];
        /* Français */
        if (in_array("FR", self::release)) {
            $data["FR"] = [
                $this->_code => "FR",
                $this->_name => __("France", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain),
                $this->_regex => "/^([[:alnum:]]{2})\s([[:alnum:]]{3,4})?$/",
            ];
        }

        /* Deutsch */
        if (in_array("DE", self::release)) {
            $data["DE"] = [
                $this->_code => "DE",
                $this->_name => __("Germany", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain),
                $this->_regex => "/^([[:alnum:]]{2})\s([[:alnum:]]{3,4})?$/",
            ];
        }

        /* Italiano */
        if (in_array("IT", self::release)) {
            $data["IT"] = [
                $this->_code => "IT",
                $this->_name => __("Italy", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain),
                $this->_regex => "/^([[:alnum:]]{2})\s([[:alnum:]]{3,4})?$/",
            ];
        }

        /* Nederlands */
        if (in_array("NL", self::release)) {
            $data["NL"] = [
                $this->_code => "NL",
                $this->_name => __("Netherlands", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain),
                $this->_regex => "/^([[:alnum:]]{2})\s([[:alnum:]]{3,4})?$/",
            ];
        }
        /* Poland */
        if (in_array("PL", self::release)) {
            $data["PL"] = [
                $this->_code => "PL",
                $this->_name => __("Poland", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain),
                $this->_regex => "/^([0-9]{2})-([0-9]{3,4})?$/",
            ];
        }
        /* Español */
        if (in_array("ES", self::release)) {
            $data["ES"] = [
                $this->_code => "ES",
                $this->_name => __("Spain", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain),
                $this->_regex => "/^([[:alnum:]]{2})\s([[:alnum:]]{3,4})?$/",
            ];
        }
        /* United Kingdom */
        if (in_array("GB", self::release)) {
            $data["GB"] = [
                $this->_code => "GB",
                $this->_name => __("United Kingdom", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain),
                $this->_regex => "/^([[:alnum:]]{2})\s([[:alnum:]]{3,4})?$/",
            ];
        }
        /* United States */
        if (in_array("US", self::release)) {
            $data["US"] = [
                $this->_code => "US",
                $this->_name => __("United States", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain),
                $this->_regex => "/^([[:alnum:]]{2})\s([[:alnum:]]{3,4})?$/",
            ];
        }
        /* Austria */
        if (in_array("AT", self::release)) {
            $data["AT"] = [
                $this->_code => "AT",
                $this->_name => __(" Austria", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain),
                $this->_regex => "/^([[:alnum:]]{2})\s([[:alnum:]]{3,4})?$/",
            ];
        }
        // /* Bulgaria */
        // if (in_array("BG", self::release)) {
        //     $data["BG"] = [
        //         $this->_code => "BG",
        //         $this->_name => __(" Bulgaria", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain),
        //         $this->_regex => "/^([[:alnum:]]{2})\s([[:alnum:]]{3,4})?$/",
        //     ];
        // }
        // /* Croatia */
        // if (in_array("HR", self::release)) {
        //     $data["HR"] = [
        //         $this->_code => "HR",
        //         $this->_name => __(" Croatia", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain),
        //         $this->_regex => "/^([[:alnum:]]{2})\s([[:alnum:]]{3,4})?$/",
        //     ];
        // }
        // /* Cyprus */
        // if (in_array("CY", self::release)) {
        //     $data["CY"] = [
        //         $this->_code => "CY",
        //         $this->_name => __(" Cyprus", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain),
        //         $this->_regex => "/^([[:alnum:]]{2})\s([[:alnum:]]{3,4})?$/",
        //     ];
        // }
        /* CzechRepublic */
        if (in_array("CZ", self::release)) {
            $data["CZ"] = [
                $this->_code => "CZ",
                $this->_name => __(" CzechRepublic", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain),
                $this->_regex => "/^([[:alnum:]]{2})\s([[:alnum:]]{3,4})?$/",
            ];
        }
        /* Denmark */
        if (in_array("DK", self::release)) {
            $data["DK"] = [
                $this->_code => "DK",
                $this->_name => __(" Denmark", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain),
                $this->_regex => "/^([[:alnum:]]{2})\s([[:alnum:]]{3,4})?$/",
            ];
        }
        // /* Estonia */
        // if (in_array("EE", self::release)) {
        //     $data["EE"] = [
        //         $this->_code => "EE",
        //         $this->_name => __(" Estonia", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain),
        //         $this->_regex => "/^([[:alnum:]]{2})\s([[:alnum:]]{3,4})?$/",
        //     ];
        // }
        /* Finland */
        if (in_array("FI", self::release)) {
            $data["FI"] = [
                $this->_code => "FI",
                $this->_name => __(" Finland", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain),
                $this->_regex => "/^([[:alnum:]]{2})\s([[:alnum:]]{3,4})?$/",
            ];
        }
        /* Greece */
        if (in_array("GR", self::release)) {
            $data["GR"] = [
                $this->_code => "GR",
                $this->_name => __(" Greece", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain),
                $this->_regex => "/^([[:alnum:]]{2})\s([[:alnum:]]{3,4})?$/",
            ];
        }
        /* Hungary */
        if (in_array("HU", self::release)) {
            $data["HU"] = [
                $this->_code => "HU",
                $this->_name => __(" Hungary", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain),
                $this->_regex => "/^([[:alnum:]]{2})\s([[:alnum:]]{3,4})?$/",
            ];
        }
        /* Ireland */
        if (in_array("IE", self::release)) {
            $data["IE"] = [
                $this->_code => "IE",
                $this->_name => __(" Ireland", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain),
                $this->_regex => "/^([[:alnum:]]{2})\s([[:alnum:]]{3,4})?$/",
            ];
        }
        // /* Latvia */
        // if (in_array("LV", self::release)) {
        //     $data["LV"] = [
        //         $this->_code => "LV",
        //         $this->_name => __(" Latvia", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain),
        //         $this->_regex => "/^([[:alnum:]]{2})\s([[:alnum:]]{3,4})?$/",
        //     ];
        // }
        // /* Lithuania */
        // if (in_array("LT", self::release)) {
        //     $data["LT"] = [
        //         $this->_code => "LT",
        //         $this->_name => __(" Lithuania", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain),
        //         $this->_regex => "/^([[:alnum:]]{2})\s([[:alnum:]]{3,4})?$/",
        //     ];
        // }
        /* Luxembourg */
        if (in_array("LU", self::release)) {
            $data["LU"] = [
                $this->_code => "LU",
                $this->_name => __(" Luxembourg", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain),
                $this->_regex => "/^([[:alnum:]]{2})\s([[:alnum:]]{3,4})?$/",
            ];
        }
        // /* Malta */
        // if (in_array("MT", self::release)) {
        //     $data["MT"] = [
        //         $this->_code => "MT",
        //         $this->_name => __(" Malta", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain),
        //         $this->_regex => "/^([[:alnum:]]{2})\s([[:alnum:]]{3,4})?$/",
        //     ];
        // }
        /* Portugal */
        if (in_array("PT", self::release)) {
            $data["PT"] = [
                $this->_code => "PT",
                $this->_name => __(" Portugal", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain),
                $this->_regex => "/^([[:alnum:]]{2})\s([[:alnum:]]{3,4})?$/",
            ];
        }
        /* Romania */
        if (in_array("RO", self::release)) {
            $data["RO"] = [
                $this->_code => "RO",
                $this->_name => __(" Romania", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain),
                $this->_regex => "/^([[:alnum:]]{2})\s([[:alnum:]]{3,4})?$/",
            ];
        }
        // /* Slovakia */
        // if (in_array("SK", self::release)) {
        //     $data["SK"] = [
        //         $this->_code => "SK",
        //         $this->_name => __(" Slovakia", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain),
        //         $this->_regex => "/^([[:alnum:]]{2})\s([[:alnum:]]{3,4})?$/",
        //     ];
        // }
        /* Slovenia */
        if (in_array("SI", self::release)) {
            $data["SI"] = [
                $this->_code => "SI",
                $this->_name => __(" Slovenia", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain),
                $this->_regex => "/^([[:alnum:]]{2})\s([[:alnum:]]{3,4})?$/",
            ];
        }
        /* Sweden */
        if (in_array("SE", self::release)) {
            $data["SE"] = [
                $this->_code => "SE",
                $this->_name => __(" Sweden", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain),
                $this->_regex => "/^([[:alnum:]]{2})\s([[:alnum:]]{3,4})?$/",
            ];
        }
        /* Norway  */
        if (in_array("NO", self::release)) {
            $data["NO"] = [
                $this->_code => "NO",
                $this->_name => __("Norway", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain),
                $this->_regex => "/^([[:alnum:]]{2})\s([[:alnum:]]{3,4})?$/",
            ];
        }
        // /* Serbia  */
        // if (in_array("RS", self::release)) {
        //     $data["RS"] = [
        //         $this->_code => "RS",
        //         $this->_name => __("Serbia", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain),
        //         $this->_regex => "/^([[:alnum:]]{2})\s([[:alnum:]]{3,4})?$/",
        //     ];
        // }
        /* Switzerland  */
        if (in_array("CH", self::release)) {
            $data["CH"] = [
                $this->_code => "CH",
                $this->_name => __("Switzerland", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain),
                $this->_regex => "/^([[:alnum:]]{2})\s([[:alnum:]]{3,4})?$/",
            ];
        }
        /* Iceland */
        if (in_array("IS", self::release)) {
            $data["IS"] = [
                $this->_code => "IS",
                $this->_name => __("Iceland", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain),
                $this->_regex => "/^([[:alnum:]]{2})\s([[:alnum:]]{3,4})?$/",
            ];
        }
        /* Jersey */
        if (in_array("JE", self::release)) {
            $data["JE"] = [
                $this->_code => "JE",
                $this->_name => __("Jersey", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain),
                $this->_regex => "/^([[:alnum:]]{2})\s([[:alnum:]]{3,4})?$/",
            ];
        }
        /* Turkey  */
        if (in_array("TR", self::release)) {
            $data["TR"] = [
                $this->_code => "TR",
                $this->_name => __("Turkey", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain),
                $this->_regex => "/^([[:alnum:]]{2})\s([[:alnum:]]{3,4})?$/",
            ];
        }
        return $data;
    }
    /*
     * Name function: get_country_name
     * Params:
     *  @country_code: type string
     * Return: type string
     * * */

    public function get_country_name($country_code)
    {
        $country_name = '';
        $country = new \WC_Countries();
        /* get list country in woocommerce */
        $list_country = $country->get_countries();
        if (isset($list_country[$country_code])) {
            $country_name = $list_country[$country_code];
        }
        return $country_name;
    }
    /*
     * Name function: get_state_name
     * Params:
     *  @country_code: type string
     *  @state_code: type string
     * Return: type string
     * * */

    public function get_state_name($country_code, $state_code)
    {
        $state_name = '';
        $country = new \WC_Countries();
        /* get list state in woocommerce */
        $list_state = $country->get_states($country_code);
        if (isset($list_state[$state_code])) {
            $state_name = $list_state[$state_code];
        }
        return $state_name;
    }
    /*
     * Name function: get_unit_weight_list
     * Params: empty
     * Return: type array
     * * */

    public function get_unit_weight_list()
    {
        return [
            "kgs" => __("Kg", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain),
            "lbs" => __("Pounds", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain),
        ];
    }
    /*
     * Name function: get_unit_dimension_list
     * Params: empty
     * Return: type array
     * * */

    public function get_unit_dimension_list()
    {
        return [
            "cm" => __("Cm", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain),
            "inch" => __("Inch", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain),
        ];
    }
    /*
     * Name function: get_type_rate
     * Params: empty
     * Return: type array
     * * */

    public function get_type_rate()
    {
        return [
            "1" => __("Flat rates", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain),
            "2" => __("Real time shipping rates", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain),
        ];
    }
    /*
     * Name function: list_time_day
     * Params: empty
     * Return: type array
     * * */

    public function list_time_day()
    {
        $list_time_day = [];
        /* set start time day */
        $list_time_day['00'] = "12 AM";
        for ($i = 1; $i <= 23; $i++) {
            if ($i < 12) {
                /* set time day am */
                $list_time_day[substr("00{$i}", -2)] = "{$i} AM";
            } else {
                /* set time day pm */
                $pm = $i - 12;
                if ($pm === 0) {
                    $list_time_day[substr("00{$i}", -2)] = "{$i} PM";
                } else {
                    $list_time_day[substr("00{$i}", -2)] = "{$pm} PM";
                }
            }
        }
        $list_time_day[24] = __("Disable", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain);
        return $list_time_day;
    }
    /*
     * Name function: translate_country_name_en_US
     * Params:
     *  @country_code: type string
     * Return: type string
     * * */

    public function translate_country_name_en_US($country_code = 'US')
    {
        /* switch locale to en_US */
        switch_to_locale('en_US');
        /* translate country with en_US language */
        $translation = '';
        if (isset(\WC()->countries->countries["{$country_code}"])) {
            $translation = \WC()->countries->countries["{$country_code}"];
        }
        /* restore previous locale */
        restore_previous_locale();
        return $translation;
    }
    /*
     * Name function: translate_state_name_en_US
     * Params:
     *  @country_code: type string
     *  @state_code: type string
     * Return: type string
     * * */

    public function translate_state_name_en_US($country_code = 'US', $state_code = 'AK')
    {
        /* switch locale to en_US */
        switch_to_locale('en_US');
        /* translate state with en_US language */
        $translation = '';
        if (isset(\WC()->countries->states[$country_code][$state_code])) {
            $translation = \WC()->countries->states[$country_code][$state_code];
        }
        /* restore previous locale */
        restore_previous_locale();
        return $translation;
    }
}
