<?php namespace UpsEuWoocommerce\libsystems\ajax_json;

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
 * ups-eu-woo-ajax-json-shipcancel.php - The core plugin class.
 *
 * This is used to define some methods to handle the Cancel Shipment.
 */

include_once(dirname(__FILE__, 3) . '/ups-eu-woo-autoloader.php');
new \UpsEuWoocommerce\Ups_Eu_Woo_Main_Autoloader('Ups_Eu_Woo_ShipCancel_Ajax_Json');

class Ups_Eu_Woo_ShipCancel_Ajax_Json extends Ups_Eu_Woo_ShipBase_Ajax_Json
{
    /*
     * Name function: __construct
     * Params:
     *  @domain: type string
     * Return: type void
     * * */

    public function __construct()
    {
        /* call parent construct */
        parent::__construct();
    }

    public function ups_eu_woo_config_cancel_shipment()
    {
        $router_url = new \UpsEuWoocommerce\models\bases\Ups_Eu_Woo_Router_Url();
        $jsonObject = new \stdClass();
        $jsonObject->code = "";
        $listShipmentNumber = "";
        if ($router_url->ups_eu_woo_check_method_post() === true) {
            if (array_key_exists('listShipmentNumber', $_REQUEST)) {
                $listShipmentNumber = $_REQUEST['listShipmentNumber'];
            }
        }
        $cancel = $this->ups_eu_woo_cancel_shipment_item($listShipmentNumber);
        if ($cancel->check) {
            $jsonObject->code = "200";
        } else {
            $jsonObject->code = "";
            $jsonObject->message = $cancel->message;
        }
        return $jsonObject;
    }

    private function ups_eu_woo_cancel_shipment_item($listShipmentNumbers)
    {
        $shipmentNumbers = explode(',', $listShipmentNumbers);
        $trackingModel = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Tracking();
        $shipmentModel = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Shipments();
        $ordersModel = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Orders();
        $shipments = [];
        $cancelShipmentList = [];
        $result = new \stdClass();
        $result->check = true;
        $result->message = "";

        foreach ($shipmentNumbers as $key2 => $shipmentNumber) {
            // get tracking list from shipment number
            $conditions = ["`shipment_number` = '{$shipmentNumber}'"];
            $trackingList = $trackingModel->get_list_data_by_condition($conditions);

            if (!empty($trackingList)) {
                // call cancel shipment API
                $cancel_shipment_api = $this->ups_eu_woo_cancel_shipment_api($shipmentNumber);
                if ($cancel_shipment_api->check) {
                    //update Status Cancel Shipment ( in table wp_ups_shipping_orders)
                    foreach ($trackingList as $key => $trackingItem) {
                        $shipment_data = new \stdClass();
                        $shipment_data->tracking_number = $trackingItem->tracking_number;
                        $shipment_data->shipment_status = 'processing_in_progress';
                        $shipments[] = $shipment_data;
                        $ordersModel->ups_eu_woo_update_all(['status' => 1], ["order_id_magento = {$trackingItem->order_id}"]);
                    }
                    if (!in_array($shipmentNumber, $cancelShipmentList)) {
                        $cancelShipmentList[] = $shipmentNumber;
                    }
                    //cancel Status order in Woocommerce
                    $shipmentModel->ups_eu_woo_cancel_order_shipmment_woo($trackingItem->order_id);
                    //delete tracking by shipment number from wp_ups_shipping_tracking
                    $trackingModel->ups_eu_woo_delete_all(["shipment_number='{$trackingItem->shipment_number}'"]);
                    //delete shipment by shipment number from wp_ups_shipping_shipments
                    $shipmentModel->ups_eu_woo_delete_all(["shipment_number='{$trackingItem->shipment_number}'"]);
                } else {
                    $result->check = false;
                    $result->message = $cancel_shipment_api->message;
                }
            }
        }
        if (!empty($shipments)) {
            $shipments = array_unique($shipments, SORT_REGULAR);
            call_user_func_array(
                [
                new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Retry_Api(),
                "ups_eu_woo_update_shipments_status"
                ],
                [
                $shipments
                ]
            );
        }
        return $result;
    }

    private function ups_eu_woo_cancel_shipment_api($shipmentNumber)
    {
        $data = new \stdClass();
        $data->shipment_number = $shipmentNumber;
        $upsapi_shipment = new \UpsEuWoocommerce\libsystems\api_ups\Ups_Eu_Woo_Shipments_Api_Ups();
        $shipmentResponse = json_decode($upsapi_shipment->ups_eu_woo_call_api_cancel_shipment($data));
        $result = new \stdClass();
        $result->check = true;
        $result->message = "";

        if (!empty($shipmentResponse->VoidShipmentResponse)) {
            $shipmentStatusCode = $shipmentResponse->VoidShipmentResponse->Response->ResponseStatus->Code;
            if ($shipmentStatusCode == '1') {
                return $result;
            }
        } else {
            $shipmentFaultCode = $shipmentResponse->Fault->detail->Errors->ErrorDetail->PrimaryErrorCode->Code;
            if ($shipmentFaultCode !== "190117") {
                $result->check = false;
                $result->message = $shipmentResponse->Fault->detail->Errors->ErrorDetail->PrimaryErrorCode->Description;
            }
        }
        return $result;
    }
}
