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
 * ups-eu-woo-model-entity-log-frontend.php - The core plugin class.
 *
 * This is used to define the LogFrontend Entity.
 */

include_once(dirname(__FILE__, 3) . '/ups-eu-woo-autoloader.php');
new \UpsEuWoocommerce\Ups_Eu_Woo_Main_Autoloader('Ups_Eu_Woo_Log_Frontend_Entity');

class Ups_Eu_Woo_Log_Frontend_Entity extends \UpsEuWoocommerce\models\Ups_Eu_Woo_Data_Base
{
    /* List colum name in table [log_frontend] database */
    public $col_id = "id";
    public $col_ups_eu_woocommerce_key = "ups_eu_woocommerce_key";
    public $col_content_encode_json = "content_encode_json";
    public $col_date_created = "date_created";
}
