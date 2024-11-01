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
 * ups-eu-woo-model-entity-fallback-rates.php - The core plugin class.
 *
 * This is used to define the DeliveryRates Entity.
 */

include_once(dirname(__FILE__, 3) . '/ups-eu-woo-autoloader.php');
new \UpsEuWoocommerce\Ups_Eu_Woo_Main_Autoloader('Ups_Eu_Woo_Fallback_Rates_Entity');

class Ups_Eu_Woo_Fallback_Rates_Entity extends \UpsEuWoocommerce\models\Ups_Eu_Woo_Data_Base
{
    /* List colum name in table [fallback_rate] database */

    public $col_id = "id";
    public $col_service_type = "service_type";
    public $col_service_id = "service_id";
    public $col_fallback_rate = "fallback_rate";
    public $var_pattern = '/^\d+(\.\d{1,2})?$/';
    public $var_fallback_rate_empty = "fallback_rate empty";
    public $var_fallback_rate_invalid = "fallback_rate invalid";
    public $var_service_id_empty = "service_type is empty";
    public $var_service_id_invalid = "service_id is invalid";

    /* value type */
    public $fallback_rate_data = "fallback_rate";
}
