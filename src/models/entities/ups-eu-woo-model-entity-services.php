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
 * ups-eu-woo-model-entity-services.php - The core plugin class.
 *
 * This is used to define the Services Entity.
 */

include_once(dirname(__FILE__, 3) . '/ups-eu-woo-autoloader.php');
new \UpsEuWoocommerce\Ups_Eu_Woo_Main_Autoloader('Ups_Eu_Woo_Services_Entity');

class Ups_Eu_Woo_Services_Entity extends \UpsEuWoocommerce\models\Ups_Eu_Woo_Data_Base
{
    /* List colum name in table [service] database */

    public $col_id = "id";
    public $col_country_code = "country_code";
    public $col_service_type = "service_type";
    public $col_service_key = "service_key";
    public $col_service_key_delivery = "service_key_delivery";
    public $col_service_key_val = "service_key_val";
    public $col_service_name = "service_name";
    public $col_rate_code = "rate_code";
    public $col_tin_t_code = "tin_t_code";
    public $col_service_selected = "service_selected";
    public $col_service_symbol = "service_symbol";
    /* value default */
    public $value_service_type_ap = "AP";
    public $value_service_type_add = "ADD";
    public $ups_services = "ups_services";
    public $configs = "configs";
    public $service_id = "service_id";
    public $LocationID = "LocationID";
}
