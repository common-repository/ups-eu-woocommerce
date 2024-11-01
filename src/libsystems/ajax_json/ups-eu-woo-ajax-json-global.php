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
 * ups-eu-woo-ajax-json-global.php - The core plugin class.
 *
 * This is used to define the common class.
 */

include_once(dirname(__FILE__, 3) . '/ups-eu-woo-autoloader.php');
new \UpsEuWoocommerce\Ups_Eu_Woo_Main_Autoloader('Ups_Eu_Woo_Global_Ajax_Json');

class Ups_Eu_Woo_Global_Ajax_Json implements Ups_Eu_Woo_Interfaces_Ajax_Json
{

    protected $package_error;

    public function __construct()
    {
        $this->package_error = __(
            "Package: Some of the data you entered were not valid. Please check again.",
            \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain
        );
    }

    protected function ups_eu_woo_add_array($array)
    {
        $array_return = [];
        foreach ($array as $key => $value) {
            if (!empty($value)) {
                $array_return[] = $value;
            }
        }
        return $array_return;
    }

    protected function _get_package_status($trackingNumber)
    {
        $upsapi_shipment = new \UpsEuWoocommerce\libsystems\api_ups\Ups_Eu_Woo_Shipments_Api_Ups();
        $data = new \stdClass();
        $data->tracking_number = $trackingNumber;
        $trackingResponse = json_decode($upsapi_shipment->ups_eu_woo_call_api_status_shipment($data));

        if ($trackingResponse && (!isset($trackingResponse->Fault))) {
            $shipmentPackageActivity = new \stdClass();

            if (is_array($trackingResponse->TrackResponse->Shipment->Package)) {
                foreach ($trackingResponse->TrackResponse->Shipment->Package as $item) {
                    if ($item->TrackingNumber == $trackingNumber) {
                        $shipmentPackageActivity = $item->Activity;
                        break;
                    }
                }
            } else {
                $shipmentPackageActivity = $trackingResponse->TrackResponse->Shipment->Package->Activity;
            }

            $trackingStatus = $this->_get_tracking_status_code($shipmentPackageActivity);

            if ($trackingStatus != null) {
                return $trackingStatus->Description;
            }
        }

        return '';
    }

    protected function _get_tracking_status_code($shipmentPackageActivity)
    {
        if (is_array($shipmentPackageActivity) && isset($shipmentPackageActivity)) {
            $keyRecentestDate = 0;
            $shipmentPackageActivityDateTime = strtotime($shipmentPackageActivity[0]->Date . ' '
                . $shipmentPackageActivity[0]->Time);
            foreach ($shipmentPackageActivity as $key => $item) {
                $itemTime = strtotime($item->Date . ' ' . $item->Time);
                if ($shipmentPackageActivityDateTime < $itemTime) {
                    $shipmentPackageActivityDateTime = $itemTime;
                    $keyRecentestDate = $key;
                }
            }
            return $shipmentPackageActivity[$keyRecentestDate]->Status;
        } else {
            return $shipmentPackageActivity->Status;
        }
        return null;
    }
}
