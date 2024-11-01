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
 * ups-eu-woo-model-entity-shipments.php - The core plugin class.
 *
 * This is used to define the Shipments Entity.
 */

include_once(dirname(__FILE__, 3) . '/ups-eu-woo-autoloader.php');
new \UpsEuWoocommerce\Ups_Eu_Woo_Main_Autoloader('Ups_Eu_Woo_Shipments_Entity');

class Ups_Eu_Woo_Shipments_Entity extends \UpsEuWoocommerce\models\Ups_Eu_Woo_Data_Base
{
    /* List colum name in table [shipments] database */
    public $col_id = "id";
    public $col_shipment_number = "shipment_number";
    public $col_create_date = "create_date";
    public $col_status = "status";
    public $col_cod = "cod";
    public $col_shipping_fee = "shipping_fee";
    public $col_order_value = "order_value";
    public $col_accessorial_service = "accessorial_service";
    public $col_shipping_service = "shipping_service";
    public $col_name = "name";
    public $col_address1 = "address1";
    public $col_address2 = "address2";
    public $col_address3 = "address3";
    public $col_state = "state";
    public $col_postcode = "postcode";
    public $col_city = "city";
    public $col_country = "country";
    public $col_phone = "phone";
    public $col_email = "email";
    public $col_access_point_id = "access_point_id";
    public $col_order_selected = "order_selected";

    /* list key */
    public $TrackingNumber = "TrackingNumber";
    public $LabelShipment = "LabelShipment";
}
