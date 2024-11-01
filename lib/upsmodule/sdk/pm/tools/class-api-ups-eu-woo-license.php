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

class Ups_Eu_Woo_License
{
    public function ups_eu_woo_create_request_access1($data, $developerLicenseNumber)
    {
        include_once("entities/class-api-ups-eu-woo-request-entity.php");
        $request_entity = new Ups_Eu_Woo_Pm_Request_Entity();
        $request_entity->setTransactionReference();
        $request_entity->setRequestOption();
        $request_entity->setAccessLicenseProfile($data);

        $request = new \stdClass();
        $request->UPSSecurity = (object) [];

        $request->AccessLicenseAgreementRequest = new \stdClass();
        $request->AccessLicenseAgreementRequest->Request = $request_entity->Request;
        $request->AccessLicenseAgreementRequest->DeveloperLicenseNumber = $developerLicenseNumber;
        $request->AccessLicenseAgreementRequest->AccessLicenseProfile = $request_entity->AccessLicenseProfile;

        return $request;
    }

    public function ups_eu_woo_create_request_access2($data)
    {
        include_once("entities/class-api-ups-eu-woo-request-entity.php");
        include_once("entities/class-api-ups-eu-woo-base-entity.php");
        include_once("entities/class-api-ups-eu-woo-address-entity.php");
        $request_entity = new Ups_Eu_Woo_Pm_Request_Entity();
        $base_entity = new Ups_Eu_Woo_Base_Entity();
        $address_entity = new Ups_Eu_Woo_Address_Entity();

        //post_code
        $post_code = html_entity_decode($data->post_code);
        //postcode
        $postcode  = $post_code;
        //data
        $data->post_code = $postcode;

        $request_entity->setTransactionReference();
        $request_entity->setRequestOption();
        $request_entity->setAccessLicenseProfile($data);

        $address_entity->setAddress($data);
        $base_entity->setPrimaryContact($data);
        //$base_entity->setSecondaryContact($data);
        $base_entity->setClientSoftwareProfile($data);

        //request
        $request = new \stdClass();
        //UPS Security
        $request->UPSSecurity = (object) [];
        $request->AccessLicenseRequest = new \stdClass();
        $request->AccessLicenseRequest->Request = $request_entity->Request;
        $request->AccessLicenseRequest->CompanyName = $data->company;
        $request->AccessLicenseRequest->Address = $address_entity->Address;
        $request->AccessLicenseRequest->PrimaryContact = $base_entity->PrimaryContact;
        //$request->AccessLicenseRequest->SecondaryContact = $base_entity->SecondaryContact;
        $request->AccessLicenseRequest->CompanyURL = $_SERVER['SERVER_NAME'];
        $request->AccessLicenseRequest->DeveloperLicenseNumber = $data->developer_license_number;
        $request->AccessLicenseRequest->AccessLicenseProfile = $request_entity->AccessLicenseProfile;
        $request->AccessLicenseRequest->ClientSoftwareProfile = $base_entity->ClientSoftwareProfile;

        return $request;
    }
}
