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
 * Currency.php - The core plugin class.
 *
 * This is used to define the Currency Model.
 */

class Ups_Eu_Woo_Currency
{
    /* Declaration variable private */

    private static $data_currency;

    /*
     * Name function: __construct
     * Params: empty
     * Return: void
     * * */

    public function __construct($model_config)
    {
        if (empty(self::$data_currency)) {
            /* get list currency data */
            self::$data_currency = $this->ups_eu_woo_int_currency();
            if (self::$data_currency === false) {
                /* setup currency data */
                $data_currency = false;
                if ($model_config->ups_eu_woo_get_by_key($model_config->CURRENCY_DATA) === true) {
                    $data_currency = $model_config->value;
                }
                if ($data_currency !== false) {
                    self::$data_currency = json_decode(base64_decode($data_currency));
                }
            } else {
                /* set currency key and value */
                if ($model_config->ups_eu_woo_get_by_key($model_config->CURRENCY_DATA) !== true) {
                    $model_config->key = $model_config->CURRENCY_DATA;
                }
                $model_config->value = base64_encode(json_encode(self::$data_currency));
                /* save currency config */
                $model_config->ups_eu_woo_save();
            }
        }
    }
    /*
     * Name function: ups_eu_woo_int_currency
     * Params: empty
     * Return: type obeject or false
     * * */

    public function ups_eu_woo_int_currency()
    {
        try {
            $prev_prev_file_name = date("Ymd", strtotime("-2 days"));
            $prev_file_name = date("Ymd", strtotime("-1 days"));
            $now_file_name = date("Ymd");
            $file_path_prev_prev = plugin_dir_path(__FILE__) . '../../' . $prev_prev_file_name. '.txt';
            $file_path_prev = plugin_dir_path(__FILE__) . '../../' . $prev_file_name. '.txt';
            $file_path = plugin_dir_path(__FILE__) . '../../' . $now_file_name. '.txt';
            if (file_exists($file_path_prev_prev)) {//delete the old file
                unlink($file_path_prev_prev);
            }
            $content_currency = '';
            if (file_exists($file_path)) {// lay gia tri api
                $content_currency = file_get_contents($file_path);
            }
            if (!file_exists($file_path) || empty($content_currency)) {// hom nay chua chay api
                $i = 0;
                $response = '';
                while ($i < 3 && empty($response)) {// excute 3 times
                    $response = $this->ups_eu_woo_call_pm_currency();
                    $i++;
                }
                if (empty($response)) {// khong lay dc gia tri api
                    if (file_exists($file_path_prev)) {// lay gia tri api truoc 1 ngay
                        $content_currency = file_get_contents($file_path_prev);
                        $json_object = json_decode($content_currency);
                        return $json_object;
                    }
                } else {// lay dc gia tri api
                    $content = json_encode($response);
                    $open = fopen($file_path, "w");
                    $write = fputs($open, $content);
                    fclose($open);
                    return $response;
                }
            } else {// da co ngay hom nay
                $json_object = json_decode($content_currency);
                return $json_object;
            }
        } catch (Exception $ex) {
            return false;
        }
    }

    /*
     * Name function: ups_eu_woo_call_pm_currency
     * Params:
     *  @from_currency: type string
     *  @to_currencecy: type string
     *  @amount: type f
     *
     * * */
    function ups_eu_woo_call_pm_currency()
    {
        $upsapi_manage = new \UpsEuWoocommerce\libsystems\api_ups\Ups_Eu_Woo_Manage_Api_Ups();
        $response = $upsapi_manage->ups_eu_woo_currency_plugin();
        if ($response !== null && intval($response->success) === 1) {
            return $response;
        }
    }

    /*
     * Name function: ups_eu_woo_convert_currency
     * Params:
     *  @from_currency: type string
     *  @to_currencecy: type string
     *  @amount: type f
     *
     * * */

    public function ups_eu_woo_convert_currency($from_currency, $to_currency, $amount)
    {
        if (class_exists('WOOCS')){
            return $amount;
        }
        if (self::$data_currency === false) {
            return false;
        }
        /* get from_currency need to convert */
        $from_currency = trim(strtoupper($from_currency));
        /* get to_currency need to convert */
        $to_currency = trim(strtoupper($to_currency));

        $object_currency = self::$data_currency->quotes;
        if (is_object($object_currency)) {
            $name_currency_from = "USD{$from_currency}";
            $name_currency_to = "USD{$to_currency}";
            /* check and add value currency from */
            $value_currency_from = '';
            if($name_currency_from == "USDUSD"){
                $value_currency_from = "1";
            }else{
                if (empty($object_currency->{$name_currency_from})) {
                    return false;
                }
                $value_currency_from = $object_currency->{$name_currency_from};
            }
            /* check and add value currency to */
            $value_currency_to = '';
            if($name_currency_to == "USDUSD"){
                $value_currency_to = "1";
            }else{
                if (empty($object_currency->{$name_currency_to})) {
                    return false;
                }
                $value_currency_to = $object_currency->{$name_currency_to};
            }
            /* build convert */
            $results = ($value_currency_to / $value_currency_from) * $amount;
            return round($results, 2);
        }
        return false;
    }
}
