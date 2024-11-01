<?php namespace UpsEuWoocommerce\libsystems\lang;

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
 * ups-eu-woo-lang-shipments.php - The core plugin class.
 *
 * This is used to load the Shipment's languages.
 */

include_once(dirname(__FILE__, 3) . '/ups-eu-woo-autoloader.php');
new \UpsEuWoocommerce\Ups_Eu_Woo_Main_Autoloader('Ups_Eu_Woo_Shipments_Language');

class Ups_Eu_Woo_Shipments_Language extends Ups_Eu_Woo_Common_Language
{

    protected $list_lang;

    /*
     * Name function: __construct
     * Params:
     *  @domain: type string
     * Return: type void
     * * */

    public function __construct($domain)
    {
        parent::__construct($domain);
    }
    /*
     * Name function: ups_eu_woo_load_lang
     * Params: empty
     * Return: type array
     * * */

    public function ups_eu_woo_load_lang()
    {
        /* Get load lang common */
        $lang_common = parent::ups_eu_woo_load_lang();
        /* Additions lang */
        $page_lang = [
            "Print Label" => __("Print Label", $this->domain),
            "Download PDF Label" => __("Download PDF Label", $this->domain),
            "Download ZPL Label" => __("Download ZPL Label", $this->domain),
            "Export Shipment Data" => __("Export Shipment Data", $this->domain),
            "Cancel Shipments" => __("Cancel Shipments", $this->domain),
            "ID Shipment" => __("ID Shipment", $this->domain),
            "Tracking Number" => __("Tracking Number", $this->domain),
            "Date" => __("Date", $this->domain),
            "Time" => __("Time", $this->domain),
            "Shipment ID" => __("Shipment ID", $this->domain),
            "Tracking number" => __("Tracking number", $this->domain),
            "deliveryStatus" => __("deliveryStatus", $this->domain),
            "CODAmount" => __("CODAmount", $this->domain),
            "CODCurrency" => __("CODCurrency", $this->domain),
            "Estimated shipping fee" => __("Estimated shipping fee", $this->domain),
            "Estimated Shipping Fee" => __("Estimated Shipping Fee", $this->domain),
            "Accessorials" => __("Accessorials", $this->domain),
            "Order date" => __("Order date", $this->domain),
            "Order value" => __("Order value", $this->domain),
            "Shipping fee" => __("Shipping fee", $this->domain),
            "Package details" => __("Package details", $this->domain),
            "Product details" => __("Product details", $this->domain),
            "Customer name" => __("Customer name", $this->domain),
            "Customer Phone no" => __("Customer Phone no", $this->domain),
            "LabelShipment" => __("LabelShipment", $this->domain),
            "Cancel Shipment(s)" => __("Cancel Shipment(s)", $this->domain),
            "Are you sure you want to cancel selected shipment(s)?" => __("Are you sure you want to cancel selected shipment(s)?", $this->domain),
            "Shipment" => __("Shipment", $this->domain),
            "Order #ID reference" => __("Order #ID reference", $this->domain),
            "UPS Tracking Terms and Conditions" => __("UPS Tracking Terms and Conditions", $this->domain),
            'tracking_term_des' => __('NOTICE: The UPS package tracking systems accessed via this service (the “Tracking Systems”) and tracking information obtained through this service (the “Information”) is the private property of UPS. UPS authorizes you to use the Tracking Systems solely to track shipments tendered by or for you to UPS for delivery and for no other purpose. Without limitation, you are not authorized to make the Information available on any web site or otherwise reproduce, distribute, copy, store, use or sell the Information for commercial gain without the express written consent of UPS. This is a personal service, thus your right to use the Tracking Systems or Information is non-assignable. Any access or use that is inconsistent with these terms is unauthorized and strictly prohibited.', $this->domain),
            'By_selecting_any_order' => __('By selecting any order in this shipment tab, I agree to the <a href="javascript:">Terms and Conditions</a>.', $this->domain),
            "Shipment canceled" => __("Shipment canceled", $this->domain),
            "hard_code_api_the_shipment_was_not_voided" => __("We are unable to void this shipment at this time. You may attempt to void the shipment later. However you will not be billed for this shipment provided that you do not use the shipping label", $this->domain),
        ];
        return array_merge($lang_common, $page_lang);
    }
}
