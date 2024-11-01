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
 * ups-eu-woo-model-entity-accessorial.php - The core plugin class.
 *
 * This is used to define the Accessorial Entity.
 */

include_once(dirname(__FILE__, 3) . '/ups-eu-woo-autoloader.php');
new \UpsEuWoocommerce\Ups_Eu_Woo_Main_Autoloader('Ups_Eu_Woo_Accessorial_Entity');

class Ups_Eu_Woo_Accessorial_Entity extends \UpsEuWoocommerce\models\Ups_Eu_Woo_Data_Base
{
    /* List colum name in table [accessorial] database */

    public $col_id = "id";
    public $col_accessorial_key = "accessorial_key";
    public $col_accessorial_name = "accessorial_name";
    public $col_accessorial_code = "accessorial_code";
    public $col_show_config = "show_config";
    public $col_show_shipping = "show_shipping";

    //list key
    public $key_accessorial_services = "accessorial_services";
    public $UPS_ACSRL_ACCESS_POINT_COD = "UPS_ACSRL_ACCESS_POINT_COD";
    public $UPS_ACSRL_TO_HOME_COD = "UPS_ACSRL_TO_HOME_COD";
    public $ASC = "ASC";
}
