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
 * ups-eu-woo-model-entity-systems.php - The core plugin class.
 *
 * This is used to define the Systems Entity.
 */

require_once(dirname(__FILE__, 3) . '/ups-eu-woo-autoloader.php');
new \UpsEuWoocommerce\Ups_Eu_Woo_Main_Autoloader('Ups_Eu_Woo_Systems_Entity');

class Ups_Eu_Woo_Systems_Entity extends Ups_Eu_Woo_Language_Entity
{
    /* api plugin manager */

    public $btn_controller_next = "next";
    public $btn_controller_save = "save";
    public $btn_controller_verify = "verify";
    public $btn_controller_remove = "remove";
    /* key */
    public $var_time_format = "time_format";
    public $var_date_format = "date_format";
    public $btn_controller = "btn_controller";
    public $btn_controller_all = "all";
    public $ups_plugin_name = "ups-eu-woocommerce";
    public $bootstrap_lib = "ups-eu-woocommerce-boostrap";
    public $fontawesome_lib = "ups-eu-woocommerce-fontawesome";
    public $datepicker_lib = "ups-eu-woocommerce_datepicker";
    public $handle = "handle";
    public $jquery = "jquery";
    public $src = "src";
    public $deps = "deps";
    public $textbox_checked_ids = "textbox_checked_ids";
    public $textbox_tracking_ids = "textbox_tracking_ids";
    public $label_option = "label_option";
    public $method = "method";
    /* libsystems InfoAjaxJson */
    public $id_order = "id_order";
    public $info_type_order = "info_type_order";
    public $trackId = "trackId";
    /* libsystems AjaxJson */
    public $match_all = "/^.+$/";
    public $amp_key = "&amp;amp;";
    public $AlternateDeliveryAddress = "AlternateDeliveryAddress";
    public $Name = "Name";
    public $AttentionName = "AttentionName";
    public $Address = "Address";
    public $AddressLine = "AddressLine";
    public $City = "City";
    public $StateProvinceCode = "StateProvinceCode";
    public $PostalCode = "PostalCode";
    public $CountryCode = "CountryCode";
    public $Package = "Package";
    public $Dimensions = "Dimensions";
    public $UnitOfMeasurement = "UnitOfMeasurement";
    public $Code = "Code";
    public $Description = "Description";
    public $Length = "Length";
    public $Width = "Width";
    public $Height = "Height";
    public $PackageWeight = "PackageWeight";
    public $Weight = "Weight";
    public $Packaging = "Packaging";
    public $PackagingType = "PackagingType";
    public $ShippingType = "ShippingType";
    public $CurrencyCode = "CurrencyCode";
    public $MonetaryValue = "MonetaryValue";
    public $currency_code = "currency_code";
    public $Shipper = "Shipper";
    public $ShipperNumber = "ShipperNumber";
    public $Phone = "Phone";
    public $Number = "Number";
    public $ShipTo = "ShipTo";
    public $Email = "Email";
    public $ShipFrom = "ShipFrom";
    public $Service = "Service";
    public $PaymentInformation = "PaymentInformation";
    public $ShipmentCharge = "ShipmentCharge";
    public $Type = "Type";
    public $BillShipper = "BillShipper";
    public $AccountNumber = "AccountNumber";
    public $Typerate = "Typerate";
    public $Request = "Request";
    public $RequestOption = "RequestOption";
    public $DeliveryTimeInformation = "DeliveryTimeInformation";
    public $Pickup = "Pickup";
    public $PaymentDetails = "PaymentDetails";
    public $InvoiceLineTotal = "InvoiceLineTotal";
    public $Date = "Date";
    public $timestamp = 'timestamp';
}
