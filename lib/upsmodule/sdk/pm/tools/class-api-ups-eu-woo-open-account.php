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
 * Account.php - The core plugin class.
 *
 * This is used to register account in the current version of the plugin
 */

class Ups_Eu_Woo_Open_Account
{
    public function ups_eu_woo_api_account_open_account($data)
    {
        include_once("entities/class-api-ups-eu-woo-request-entity.php");
        include_once("entities/class-api-ups-eu-woo-base-entity.php");
        include_once("entities/class-api-ups-eu-woo-account-entity.php");
        include_once("entities/class-api-ups-eu-woo-address-entity.php");
        $request_entity = new Ups_Eu_Woo_Pm_Request_Entity();
        $base_entity = new Ups_Eu_Woo_Base_Entity();
        $account_entity = new Ups_Eu_Woo_Pm_Account_Entity();
        $address_entity = new Ups_Eu_Woo_Address_Entity();

        $request_entity->setTransactionReference();
        $request_entity->setRequestOption("N");
        $request_entity->setLocaleOpenAccount($data);

        $base_entity->setEndUserInformation($data);

        $address_entity->setAddress2($data);
        $address_entity->setBillingAddress($data);
        $address_entity->setPickupAddress($data);

        $account_entity->setAccountCharacteristics();
        $account_entity->setPickupInformation();

        //request
        $request = new \stdClass();
        $request->UPSSecurity = (object) [];
        $request->OpenAccountRequest = new \stdClass();
        $countryCode = $address_entity->PickupAddress->CountryCode;
        if (empty($countryCode)) {
            $countryCode = $address_entity->BillingAddress->CountryCode;
        }
        $localeCountry = $request_entity->Locale;
        $countryCode = strtoupper($countryCode);
        if ($countryCode == 'US') {
            $localeCountry = 'en_' . $countryCode;
        }
        $request->OpenAccountRequest->{$account_entity->Locale} = $localeCountry;

        $request->OpenAccountRequest->{$account_entity->CustomerServiceCode} = ($localeCountry == 'en_US') ? '01' : '02';
        $request->OpenAccountRequest->{$account_entity->Request} = $request_entity->Request;

        $request->OpenAccountRequest->AccountCharacteristics = $account_entity->AccountCharacteristics;
        $request->OpenAccountRequest->EndUserInformation = $base_entity->EndUserInformation;
        $request->OpenAccountRequest->BillingAddress = $address_entity->BillingAddress;
        $request->OpenAccountRequest->PickupAddress = $address_entity->PickupAddress;
        $request->OpenAccountRequest->PickupInformation = $account_entity->PickupInformation;
        return $request;
    }

    public function ups_eu_woo_account_check_success_api($response_data)
    {
        //check_api
        $check_api = [];
        //check Code
        if (isset($response_data->Code)) {
            //check_api[]
            $check_api[] = [
                "Code" => $response_data->Code, //
                "Description" => $response_data->Description, //
            ];
            //check_api
            $check_api = json_decode(json_encode($check_api));
        } else {
            //check_api
            $check_api = $response_data;
        };
        //error_message
        $error_message = [];
        //success_api
        $success_api = 0;
        //code_success
        $code_success = ["010", "012", "040", "042"];   //"045"
        //check check_api
        foreach ($check_api as $key => $value) {
            //check $value->Code
            if (in_array((string)$value->Code, $code_success)) {
                $success_api++;
            } else {
                //error_message
                $error_message[] = $value->Description;
            }
        }
        //check success_api
        if ($success_api > 0) {
            $check = true;
            $error_message = '';
        } else {
            $check = false;
            $error_message = implode(", ", $error_message);
        }
        return [$check, $error_message];
    }
}
