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

class Ups_Eu_Woo_Void_Shipment
{
    public function ups_eu_woo_cancel_shipment($data, $upsSecurity)
    {
        include_once("entities/class-api-ups-eu-woo-request-entity.php");
        include_once("entities/class-api-ups-eu-woo-ship-entity.php");
        $request_entity = new Ups_Eu_Woo_Request_Entity();
        $ship_entity = new Ups_Eu_Woo_Ship_Entity();

        $request_entity->setTransactionReference("track");
        $request_entity->setRequestOption("NULL");

        $ship_entity->setVoidShipment($data);

        $request = new \stdClass();
        $request->UPSSecurity = $upsSecurity;

        $request->VoidShipmentRequest = new \stdClass();
        $request->VoidShipmentRequest->Request = $request_entity->Request;
        $request->VoidShipmentRequest->VoidShipment = $ship_entity->VoidShipment;
        
        return $request;
    }
}
