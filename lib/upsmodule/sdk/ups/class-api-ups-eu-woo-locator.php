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
 * Locator.php - The core plugin class.
 *
 * This is used to get location shipping in Bing map.
 */

class Ups_Eu_Woo_Locator
{
    public function ups_eu_woo_locator_load_address($data, $upsSecurity)
    {
        include_once("entities/class-api-ups-eu-woo-locator-entity.php");
        include_once("entities/class-api-ups-eu-woo-request-entity.php");
        include_once("entities/class-api-ups-eu-woo-address-entity.php");
        $locator_entity = new Ups_Eu_Woo_Locator_Entity();
        $request_entity = new Ups_Eu_Woo_Request_Entity();
        $address_entity = new Ups_Eu_Woo_Address_Entity();

        $locator_entity->setAccessRequest($upsSecurity);
        $locator_entity->setTranslate($data);
        $locator_entity->setUnitOfMeasurement($data);
        $locator_entity->setLocationSearchCriteria($data);

        $request_entity->setTransactionReference("null");
        $request_entity->setRequestOption("64", "Locator");

        $address_entity->setOriginAddress($data);

        //request
        $request = new \stdClass();
        $request->AccessRequest = $locator_entity->AccessRequest;

        $request->LocatorRequest = new \stdClass();
        $request->LocatorRequest->Request = $request_entity->Request;
        $request->LocatorRequest->OriginAddress = $address_entity->OriginAddress;
        $request->LocatorRequest->Translate = $locator_entity->Translate;
        $request->LocatorRequest->UnitOfMeasurement = $locator_entity->UnitOfMeasurement;
        $request->LocatorRequest->LocationSearchCriteria = $locator_entity->LocationSearchCriteria;

        return $request;
    }
}
