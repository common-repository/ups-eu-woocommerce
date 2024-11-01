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
 * ups-eu-woo-lang-open-orders.php - The core plugin class.
 *
 * This is used to load the OpenOrders's languages.
 */

include_once(dirname(__FILE__, 3) . '/ups-eu-woo-autoloader.php');
new \UpsEuWoocommerce\Ups_Eu_Woo_Main_Autoloader('Ups_Eu_Woo_Open_Orders_Language');

class Ups_Eu_Woo_Open_Orders_Language extends Ups_Eu_Woo_Common_Language
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
        /* Addition lang*/
        $page_lang = [
            "Order" => __("Order", $this->domain),
            "Create Single Shipments" => __("Create Single Shipments", $this->domain),
            "Create Batch Shipments" => __("Create Batch Shipments", $this->domain),
            "Export All Orders" => __("Export All Orders", $this->domain),
            "Export Orders" => __("Export Orders", $this->domain),
            "Archive Orders" => __("Archive Orders", $this->domain),
            "COD Amount" => __("COD Amount", $this->domain),
            'COD Currency' => __("COD Currency", $this->domain),
            'Total Paid' => __("Total Paid", $this->domain),
            'Total Products' => __("Total Products", $this->domain),
            'Accessorials Service' => __("Accessorials Service", $this->domain),
            'Product Name' => __("Product Name", $this->domain),
            'Merchant UPSaccount Number' => __("Merchant UPSaccount Number", $this->domain),
            'Customer' => __("Customer", $this->domain),
            'Customer Last Name' => __("Customer Last Name", $this->domain),
            'Customer First Name' => __("Customer First Name", $this->domain),
            'Customer Phone' => __("Customer Phone", $this->domain),
            'Currency State' => __("Currency State", $this->domain),
            "Warning - Archiving orders will move your orders in the Archive tab and you can no longer process these orders. Click 'OK' to continue, 'Cancel' to go back to the screen" => __("Warning - Archiving orders will move your orders in the Archive tab and you can no longer process these orders. Click 'OK' to continue, 'Cancel' to go back to the screen", $this->domain),
            'Access Point' => __("Access Point", $this->domain),
            'Accessorial Service' => __("Accessorial Service", $this->domain),
            'Order volume' => __("Order volume", $this->domain),
            'Orders value' => __("Order value", $this->domain),
            'Payment status' => __("Payment status", $this->domain),
            'Archiving Orders' => __("Archiving Orders", $this->domain),
            //create shipment
            'Process Shipment' => __('Process Shipment', $this->domain),
            'Ship From' => __('Ship From', $this->domain),
            'Ship To' => __('Ship To', $this->domain),
            'Name' => __('Name', $this->domain),
            'City' => __('City', $this->domain),
            'State' => __('State', $this->domain),
            'Country' => __('Country/Territory', $this->domain),
            'Note: Insufficient or incorrect address may increase the shipping fee' => __('Note: Insufficient or incorrect address may increase the shipping fee', $this->domain),
            'Accessorial service' => __('Accessorial service', $this->domain),
            'Accessorial service note' => __('Accessorial service note', $this->domain),
            'Packaging' => __('Packaging', $this->domain),
            'Package' => __('Package', $this->domain),
            'Custom Package' => __('Custom Package', $this->domain),
            'Package #' => __('Package #', $this->domain),
            'Add package' => __('Add package', $this->domain),
            'View estimated shipping fee and delivery date' => __('View estimated shipping fee and delivery date', $this->domain),
            'Cancel Editing' => __('Cancel Editing', $this->domain),
            'Edit' => __('Edit', $this->domain),
            'Create Shipment' => __('Create Shipment', $this->domain),
            'Orders to be processed' => __('Orders to be processed', $this->domain)
        ];
        return array_merge($lang_common, $page_lang);
    }
}
