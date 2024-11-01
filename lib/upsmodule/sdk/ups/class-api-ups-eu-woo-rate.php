<?php

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
 * Rate.php - The core plugin class.
 *
 * This is used to get rate's shipping.
 */

class Ups_Eu_Woo_Rate
{
    public function ups_eu_woo_rate_get_rates($data, $upsSecurity)
    {
        include_once("entities/class-api-ups-eu-woo-request-entity.php");
        include_once("entities/class-api-ups-eu-woo-ship-entity.php");
        $request_entity = new Ups_Eu_Woo_Request_Entity();
        $ship_entity = new Ups_Eu_Woo_Ship_Entity();

        $request_entity->setTransactionReference("track");
        $request_entity->setRequestOption($data->request_option);

        $ship_entity->setRate($data);

        $request = new \stdClass();
        $request->UPSSecurity = $upsSecurity;

        $request->RateRequest = new \stdClass();
        $request->RateRequest->Request = new \stdClass();
        $request->RateRequest->Request = $request_entity->Request;
        $request->RateRequest->Shipment = new \stdClass();
        $request->RateRequest->Shipment = $ship_entity->Shipment;

//        $ship_entity->setCountryInEU($request, $data);

        $shipment_total_weight = 0;
        $shipment_total_code = "";
        $shipment_total_description = "";

        $package = $ship_entity->setPackage(
            $shipment_total_weight,
            $shipment_total_code,
            $shipment_total_description,
            $data
        );

        $ship_entity->setAlternateDeliveryAddressOfRate($request, $data);

        $shipment_total = new \stdClass();
        $shipment_total->code = $shipment_total_code;
        $shipment_total->description = $shipment_total_description;
        $shipment_total->weight = substr(sprintf('%0.4f', $shipment_total_weight), 0, 6);

        $ship_entity->setTimeInTransit($request, $data, $shipment_total);

        $ship_entity->setAccessorialOfRate($request, $package, $data);

        $request->RateRequest->Shipment->Package = $package;

        return  $request;
    }
}
