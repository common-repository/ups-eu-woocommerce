<?php namespace UpsEuWoocommerce\models\entities;

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
 * ups-eu-woo-model-entity-api-request.php - The core plugin class.
 *
 * This is used to define the ApiRequest Entity.
 */

include_once(dirname(__FILE__, 3) . '/ups-eu-woo-autoloader.php');
new \UpsEuWoocommerce\Ups_Eu_Woo_Main_Autoloader('Ups_Eu_Woo_Api_Request_Entity');

class Ups_Eu_Woo_Api_Request_Entity extends \UpsEuWoocommerce\models\Ups_Eu_Woo_Data_Base
{
    /* Params locator */

    public $Locale = "Locale";
    public $UnitOfMeasurement = "UnitOfMeasurement";
    public $MaximumListSize = "MaximumListSize";
    public $nearby = "nearby";
    public $countryCode = "countryCode";
}
