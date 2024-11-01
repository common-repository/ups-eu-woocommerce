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
 * ups-eu-woo-model-entity-orders.php - The core plugin class.
 *
 * This is used to define the Orders Entity.
 */

include_once(dirname(__FILE__, 3) . '/ups-eu-woo-autoloader.php');
new \UpsEuWoocommerce\Ups_Eu_Woo_Main_Autoloader('Ups_Eu_Woo_Orders_Entity');

class Ups_Eu_Woo_Orders_Entity extends \UpsEuWoocommerce\models\Ups_Eu_Woo_Data_Base
{
    /* List colum name in table [orders] database */

    public $col_id = "id";
    public $col_order_id_magento = "order_id_magento";
    public $col_shipping_service = "shipping_service";
    public $col_accessorial_service = "accessorial_service";
    public $col_shipment_id = "shipment_id";
    public $col_status = "status";
    public $col_ap_name = "ap_name";
    public $col_ap_address1 = "ap_address1";
    public $col_ap_address2 = "ap_address2";
    public $col_ap_address3 = "ap_address3";
    public $col_ap_state = "ap_state";
    public $col_ap_postcode = "ap_postcode";
    public $col_ap_city = "ap_city";
    public $col_ap_country = "ap_country";
    public $col_quote_id = "quote_id";
    public $col_cod = "cod";
    public $col_location_id = "location_id";
    public $col_access_point_id = "access_point_id";
    public $col_package_type = "package_type";
    public $col_woo_tmp_order_date = "woo_tmp_order_date";
    public $col_date_created = "date_created";
    public $col_date_update = "date_update";
    public $var_shipment = "shipment";
    public $var_info_shipment = "info_shipment";
    public $var_type_get_data = "type_get_data";
    public $var_limit = "limit";
    public $var_order = "order";
    public $var_conditions = "conditions";
    public $var_table = "table";
    public $var_left_join = "LEFT JOIN";
    public $var_type = "type";
    public $var_id_shipment = "id_shipment";
    public $var_order_id = "order_id";
    public $var_service_name = "service_name";
    public $var_order_date = "order_date";
    public $var_order_time = "order_time";
    public $var_delivery_address = "delivery_address";
    public $var_shipping_fee = "shipping_fee";
    public $var_billing = "billing";
    public $var_cancelled = "cancelled";
    public $var_address_1 = "address_1";
    public $var_address_2 = "address_2";

    public $order_ids = "order_ids";
    public $textbox_export_order_ids = "textbox_export_order_ids";
    public $sort_by = "sort_by";
    public $sort_type = "sort_type";
    /* export key label */
    public $Order_ID = "Order ID";
    public $Order_Date = "Order Date";
    public $Order_Time = "Order Time";
    public $COD = "COD";
    public $COD_Amount = "COD Amount";
    public $COD_Currency = "COD Currency";
    public $Currency_State = "Order Status";
    public $Total_Paid = "Total Paid";
    public $Total_Products = "Total Products";
    public $Shipping_Service = "Shipping Service";
    public $Accessorials_Service = "Accessorials Service";
    public $Product_Name = "Product Name";
    public $Merchant_UPSaccount_Number = "Merchant UPSaccount Number";

    public $Customer_Last_Name = "Customer Last Name";
    public $Customer_First_Name = "Customer First Name";

    public $Customer_Address_line_1 = "Customer Address line 1";
    public $Customer_Address_line_2 = "Customer Address line 2";
    public $Customer_Address_line_3 = "Customer Address line 3";
    public $Customer_PostalCode = "Customer PostalCode";
    public $Customer_Phone = "Customer Phone";
    public $Customer_City = "Customer City";
    public $Customer_StateOrProvince = "Customer StateOrProvince";
    public $Customer_Country = "Customer Country";
    public $Customer_Email = "Customer Email";

    public $Key_Customer_Address_line_1 = "Customer_Address_line_1";
    public $Key_Customer_Address_line_2 = "Customer_Address_line_2";
    public $Key_Customer_Address_line_3 = "Customer_Address_line_3";
    public $Key_Customer_PostalCode = "Customer_PostalCode";
    public $Key_Customer_Phone = "Customer_Phone";
    public $Key_Customer_City = "Customer_City";
    public $Key_Customer_StateOrProvince = "Customer_StateOrProvince";
    public $Key_Customer_Country = "Customer_Country";
    public $Key_Customer_Email = "Customer_Email";

    public $AlternateDeliveryAddressIndicator = "AlternateDeliveryAddressIndicator";
    public $UPSAccessPointID = "UPSAccessPointID";

    public $Access_Point_Address_line_1 = "Access Point Address line 1";
    public $Access_Point_Address_line_2 = "Access Point Address line 2";
    public $Access_Point_Address_line_3 = "Access Point Address line 3";
    public $Access_Point_City = "Access Point City";
    public $Access_Point_StateOrProvince = "Access Point StateOrProvince";
    public $Access_Point_PostalCode = "Access Point PostalCode";
    public $Access_Point_Country = "Access Point Country";

    public $Key_Access_Point_Address_line_1 = "Access_Point_Address_line_1";
    public $Key_Access_Point_Address_line_2 = "Access_Point_Address_line_2";
    public $Key_Access_Point_Address_line_3 = "Access_Point_Address_line_3";
    public $Key_Access_Point_City = "Access_Point_City";
    public $Key_Access_Point_StateOrProvince = "Access_Point_StateOrProvince";
    public $Key_Access_Point_PostalCode = "Access_Point_PostalCode";
    public $Key_Access_Point_Country = "Access_Point_Country";

    /* shipment export */
    public $Shipment_ID = "Shipment ID";
    public $Date = "Date";
    public $Time = "Time";
    public $Tracking_number = "Tracking number";
    public $deliveryStatus = "deliveryStatus";
    public $CODAmount = "CODAmount";
    public $CODCurrency = "CODCurrency";
    public $Estimated_shipping_fee = "Estimated shipping fee";
    public $Shipping_service = "Shipping service";
    public $Accessorials = "Accessorials";
    public $Order_value = "Order value";
    public $Shipping_fee = "Shipping fee";

    public $Package_details = "Package details";
    public $Product_details = "Product details";
    public $Customer_name = "Customer name";
    public $Customer_Phone_no = "Customer Phone no";

    public $Key_Package_details = "Package_details";
    public $Key_Product_details = "Product_details";
    public $Key_Customer_name = "Customer_name";
    public $Key_Customer_Phone_no = "Customer_Phone_no";
    /* export data key */
    public $data = "date";
    public $cod_amount = "cod_amount";
    public $cod_currency = "cod_currency";
    public $currency_state = "currency_state";
    public $total_paid = "total_paid";
    public $total_product = "total_product";
    public $list_product = "list_product";
    public $merchant_ups_account_number = "merchant_ups_account_number";

    public $customer_last_name = "customer_last_name";
    public $customer_first_name = "customer_first_name";
    public $customer_address_1 = "customer_address_1";
    public $customer_address_2 = "customer_address_2";
    public $customer_address_3 = "customer_address_3";
    public $customer_postal_code = "customer_postal_code";
    public $customer_phone = "customer_phone";
    public $customer_city = "customer_city";
    public $customer_state_or_province = "customer_state_or_province";
    public $customer_country = "customer_country";
    public $customer_email = "customer_email";

    public $last_name = "last_name";
    public $first_name = "first_name";
    public $postcode = "postcode";
    public $phone = "phone";
    public $city = "city";
    public $state = "state";
    public $country = "country";
    public $email = "email";
    public $alternaet_delivery_address_indicator = "alternaet_delivery_address_indicator";
    public $tracking_number = "tracking_number";
    public $delivery_status = "delivery_status";
    public $estimated_shipping_fee = "estimated_shipping_fee";
    public $accessorials = "accessorials";
    public $order_value = "order_value";
    public $woo_shipping = "woo_shipping";
    public $ship_from = "ship_from";
    public $ship_to = "ship_to";
    public $shipping_type = "shipping_type";
    public $package = "package";
    public $edit_shipment = "edit_shipment";
    public $order_selected = "order_selected";
    public $idorder = "idorder";
    public $space_key = "&nbsp";
    public $html_br = "<br>";
}
