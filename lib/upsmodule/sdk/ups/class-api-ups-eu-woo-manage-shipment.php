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

class Ups_Eu_Woo_Manage_Shipment
{
    public function ups_eu_woo_create_shipments($data, $upsSecurity)
    {
        include_once("entities/class-api-ups-eu-woo-request-entity.php");
        include_once("entities/class-api-ups-eu-woo-ship-entity.php");
        $request_entity = new Ups_Eu_Woo_Request_Entity();
        $ship_entity = new Ups_Eu_Woo_Ship_Entity();

        $request_entity->setRequestOption("validate", "", "1801");

        $ship_entity->setShipment($data);

        $request = new \stdClass();
        $request->UPSSecurity = $upsSecurity;

        $request->ShipmentRequest = new \stdClass();
        $request->ShipmentRequest->Request = new \stdClass();
        $request->ShipmentRequest->Request = $request_entity->Request;
        $request->ShipmentRequest->Shipment = new \stdClass();
        $request->ShipmentRequest->Shipment = $ship_entity->Shipment;

        $package = $ship_entity->setPackageShipment($data);

        $request->ShipmentRequest->Shipment->Package = $package;

//        $ship_entity->setCountryInEU($request, $data, "Shipment");

        $ship_entity->setInvoiceLineTotal($request, $data);
        $Notification = [];
        $ship_entity->setAccessorialOfShipment($request, $Notification, $data);

        if ($data->shipping_type == 'AP') {
            $ship_entity->setNotification($data, $Notification, "012");
            $request->ShipmentRequest->Shipment->ShipmentIndicationType = new \stdClass();
            $request->ShipmentRequest->Shipment->ShipmentIndicationType->Code = "01";
            $ship_entity->setAlternateDeliveryAddress($data->alternate_delivery_address);
            $request->ShipmentRequest->Shipment->AlternateDeliveryAddress = $ship_entity->AlternateDeliveryAddress;
        }
        $request->ShipmentRequest->Shipment->ShipmentServiceOptions->Notification = $Notification;

        return  $request;
    }

    /**
     * Print Label
     */
    public function ups_eu_woo_label_recovery($data, $upsSecurity)
    {
        include_once("entities/class-api-ups-eu-woo-ship-entity.php");
        $ship_entity = new Ups_Eu_Woo_Ship_Entity();

        $ship_entity->setRequestOption();
        $ship_entity->setLabelSpecification($data->label_option);
        $ship_entity->setTranslate();

        $request = new \stdClass();
        $request->UPSSecurity = $upsSecurity;

        $request->LabelRecoveryRequest = new \stdClass();
        $request->LabelRecoveryRequest->RequestOption = $ship_entity->RequestOption;
        $request->LabelRecoveryRequest->LabelSpecification = $ship_entity->LabelSpecification;
        $request->LabelRecoveryRequest->Translate = $ship_entity->Translate;
        $request->LabelRecoveryRequest->{$ship_entity->TrackingNumber} = $data->tracking_number;

        return $request;
    }
}
