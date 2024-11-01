<?php

namespace UpsEuWoocommerce\models\entities;

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
 * ups-eu-woo-model-entity-delivery-rates.php - The core plugin class.
 *
 * This is used to define the DeliveryRates Entity.
 */

include_once(dirname(__FILE__, 3) . '/ups-eu-woo-autoloader.php');
new \UpsEuWoocommerce\Ups_Eu_Woo_Main_Autoloader('Ups_Eu_Woo_Delivery_Rates_Entity');

class Ups_Eu_Woo_Delivery_Rates_Entity extends \UpsEuWoocommerce\models\Ups_Eu_Woo_Data_Base
{
    /* List colum name in table [delivery_rate] database */

    public $col_id = "id";
    public $col_service_id = "service_id";
    public $col_rate_type = "rate_type";
    public $col_min_order_value = "min_order_value";
    public $col_delivery_rate = "delivery_rate";
    public $col_rate_country = "rate_country";
    public $col_rate_rule = "rate_rule";
    public $var_validate = "validate";
    public $var_is_show_error = "is_show_error";
    public $var_realtime = "realtime";
    public $var_pattern = '/^\d+(\.\d{1,2})?$/';
    public $var_delivery_rate_invalid = "delivery_rate invalid";

    /* value type */
    public $str_flat_rate = "flat_rate"; // 1: flat_rate
    public $str_real_time = "real_time"; // 2: real_time
    public $select_type = "select_type";
    public $delivery_rate_flat = "delivery_rate_flat";
    public $delivery_rate_real_time = "delivery_rate_real_time";
    public $ups_flat_cal_discount = "ups_flat_cal_discount";
}
