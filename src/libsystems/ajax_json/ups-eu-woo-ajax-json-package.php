<?php namespace UpsEuWoocommerce\libsystems\ajax_json;

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
 * ups-eu-woo-ajax-json-package.php - The core plugin class.
 *
 * This is used to define some methods to get informations of Package.
 */

include_once(dirname(__FILE__, 3) . '/ups-eu-woo-autoloader.php');
new \UpsEuWoocommerce\Ups_Eu_Woo_Main_Autoloader('Ups_Eu_Woo_Package_Ajax_Json');

class Ups_Eu_Woo_Package_Ajax_Json extends Ups_Eu_Woo_Global_Ajax_Json
{
    /*
     * Name function: __construct
     * Params:
     *  @domain: type string
     * Return: type void
     * * */

    public function __construct()
    {
        /* call parent construct */
        parent::__construct();
    }

    public function ups_eu_woo_validate_product_dimension_ajax()
    {
        $dataObject = new \stdClass();
        $model_fallback_rates = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Fallback_Rates();

        $data_post = $_REQUEST;
        $product_dimension = $data_post['product_dimension'] ?? null;
        $fallback_rates = $data_post['fallback_rate']?? null;
        
        $all_error_message = [];
        if (is_array($product_dimension) || is_object($product_dimension)){
            foreach ($product_dimension as $key => $item) {
                list($error_items, $error_message) = $this->ups_eu_woo_validate_package($item);
                $dataObject->product_dimension = new \stdClass();
                if (!empty($error_items)) {
                    $dataObject->product_dimension->$key = $error_items;
                    $all_error_message = array_merge($all_error_message, $error_message);
                } else {
                    @$dataObject->product_dimension->$key = true;
                }
            };
        }
        $serviceIdList = [];
        $errorFallbackRateItems = [];
        if (is_array($fallback_rates) || is_object($fallback_rates)){
            foreach ($fallback_rates as $key => $item) {
                $model_fallback_rates->ups_eu_woo_merge_array($item);
                if (!$model_fallback_rates->ups_eu_woo_validate()) {
                    $errorFallbackRateItems[] = $model_fallback_rates->col_fallback_rate;
                }
                if (in_array($model_fallback_rates->col_service_id, $serviceIdList)) {
                    $errorFallbackRateItems[] = $model_fallback_rates->col_service_id;
                }
                $dataObject->fallback_rate = new \stdClass();
                if (!empty($errorFallbackRateItems)) {
                    $dataObject->fallback_rate->$key = $errorFallbackRateItems;
                    $all_error_message[] = __("Some of the data you entered were not valid. Please check again.", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain);
                } else {
                    @$dataObject->fallback_rate->$key = true;
                }
                $serviceIdList[] = $model_fallback_rates->col_service_id;
            }
        }
        $dataObject->error_message = array_unique($all_error_message);
        
        return $dataObject;
    }

    public function ups_eu_woo_validate_default_package_ajax()
    {
        $dataObject = new \stdClass();
        $model_package = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Package_Default();
        $data_post = $_REQUEST;
        $data_package_item = $data_post['list_id_package'];
        if (is_array($data_package_item) || is_object($data_package_item)){
            foreach ($data_package_item as $key => $item) {
                $dataObject->$key = $model_package->ups_eu_woo_check_package($item);
            }
        }
        return $dataObject;
    }

    /*
     * Name function: validate
     * Params: empty
     * Return: type array or false
     * * */
    private function ups_eu_woo_validate_package($package_dimension)
    {
        $domain = \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain;
        $message = [
            "errorWeightPackageMaximum" => __("Error! Maximum allowable per package weight is 70.00 kgs or 154.32 lbs.", $domain),
            "errorUSWeightPackageMaximum" => __("Error! Maximum allowable weight per package weight is 150lbs.", $domain),
            "errorDimension" => __("Error! Package exceeds the maximum allowable size of 400 cm or 157.48 inches (the maximum allowable size calculation = length + 2 * width + 2 * height).", $domain),
            "errorUSDimension" => __("Error! Package exceeds the maximum allowable size of 165 inches (the maximum allowable size calculation = length + 2 * width + 2 * height).", $domain),
            "errorUSLongestSide" => __("Error! Maximum allowable package length is 108 inches.", $domain),
            "errorCommonMassage" => __("Some of the data you entered were not valid. Please check again.", $domain),
        ];

        $error_items = [];
        $error_message = [];

        $model_config = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Config();
        // Validate package length
        if (!$this->ups_eu_woo_is_float($package_dimension['length'])) {
            $error_items[] = 'length';
            $error_message[] = $message['errorCommonMassage'];
        }
        if (!$this->ups_eu_woo_is_float($package_dimension['width'])) {
            $error_items[] = 'width';
            $error_message[] = $message['errorCommonMassage'];
        }
        // validate package height
        if (!$this->ups_eu_woo_is_float($package_dimension['height'])) {
            $error_items[] = 'height';
            $error_message[] = $message['errorCommonMassage'];
        }
        // Validate package weight
        if (!$this->ups_eu_woo_is_float($package_dimension['weight'])) {
            $error_items[] = 'weight';
            $error_message[] = $message['errorCommonMassage'];
        }
        // Validate weight value
        $max_weight = 154.32;
        $weight_error = $message['errorWeightPackageMaximum'];

        if ($model_config->ups_eu_woo_get_by_key($model_config->COUNTRY_CODE) === true && 'US' == $model_config->value) {
            $max_weight = 150;
            $weight_error = $message['errorUSWeightPackageMaximum'];
            list ($longest_items, $longest_side) = $this->ups_eu_woo_get_longest_side($package_dimension);
            if ($package_dimension['unit_dimension'] == 'inch' && $longest_side > 108) {
                $error_items = array_merge($error_items, $longest_items);
                $error_message[] = $message['errorUSLongestSide'];
            }
        }
        if (($package_dimension['unit_weight'] == 'kgs' && $package_dimension['weight'] > 70)
            || ($package_dimension['unit_weight'] == 'lbs') && $package_dimension['weight'] > $max_weight) {
            $error_items[] = 'weight';
            $error_message[] = $weight_error;
        }
        // Validate dimension
        $dimension = $package_dimension['length']*1 + ($package_dimension['width'] * 2) + ($package_dimension['height'] * 2);
        $max_limit = 157.48;
        $dimension_error = $message['errorDimension'];
        if ($model_config->ups_eu_woo_get_by_key($model_config->COUNTRY_CODE) === true) {
            if ('US' == $model_config->value) {
                $max_limit = 165;
                $dimension_error = $message['errorUSDimension'];
            }
        }
        if (($package_dimension['unit_dimension'] == 'cm' && $dimension > 400)
            || ($package_dimension['unit_dimension'] == 'inch' && $dimension > $max_limit)) {
            $error_message[] = $dimension_error;
        }
        return [$error_items, $error_message];
    }

    /*
     * Name function: ups_eu_woo_is_numeric
     * Params:
     *  @number: type string
     * Return: type boolean
     * * */
    private function ups_eu_woo_is_float($number)
    {
        // Check number is not empty
        if (empty($number)) {
            return false;
        }
        // Check format float
        if (preg_match('/^\d+(\.\d{1,2})?$/', $number) != 1) {
            return false;
        }
        // Check number in range
        if ($number < 0.01 || $number > 9999.99) {
            return false;
        }
        return true;
    }

    /*
     * Name function: ups_eu_woo_is_numeric
     * Params:
     *  @number: type string
     * Return: type boolean
     * * */
    private function ups_eu_woo_get_longest_side($package_dimension)
    {
        $longestItems[] = 'length';
        $longestSide = $package_dimension['length'];
        if ($package_dimension['length'] < $package_dimension['width']) {
            $longestSide = $package_dimension['width'];
            $longestItems = [];
            $longestItems[] = 'width';
        } elseif ($package_dimension['length'] = $package_dimension['width']) {
            $longestItems[] =  'width';
        }
        if ($longestSide < $package_dimension['height']) {
            $longestSide = $package_dimension['height'];
            $longestItems = [];
            $longestItems[] = 'height';
        } elseif ($longestSide = $package_dimension['height']) {
            $longestItems[] = 'height';
        }

        return [$longestItems, $longestSide];
    }
}
