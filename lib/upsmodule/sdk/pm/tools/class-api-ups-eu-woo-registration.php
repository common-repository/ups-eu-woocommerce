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

class Ups_Eu_Woo_Registration
{
    private function ups_eu_woo_account_generate_pass($length)
    {
        //characters
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        //charactersLength
        $charactersLength = strlen($characters);
        //randomString
        $randomString = '';
        //check $i
        for ($i = 0; $i < $length; $i++) {
            //randomString
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function ups_eu_woo_api_account_registration($data)
    {
        include_once("entities/class-api-ups-eu-woo-request-entity.php");
        include_once("entities/class-api-ups-eu-woo-base-entity.php");
        include_once("entities/class-api-ups-eu-woo-account-entity.php");
        include_once("entities/class-api-ups-eu-woo-address-entity.php");
        $request_entity = new Ups_Eu_Woo_Pm_Request_Entity();
        $base_entity = new Ups_Eu_Woo_Base_Entity();
        $account_entity = new Ups_Eu_Woo_Pm_Account_Entity();
        $address_entity = new Ups_Eu_Woo_Address_Entity();

        $request_entity->setTransactionReference(false);
        $request_entity->setRequestOption("N");

        $address_entity->setAddress2($data);

        $account_entity->setShipperAccount($data);

        //Username
        $Username = $data->myUpsID;
        //Password
        $Password = ($data->account_type == 4) ? $data->ups_account_password : $this->ups_eu_woo_account_generate_pass(26);

        //ipclinent
        $ipclinent = $base_entity->ups_eu_woo_account_get_client_ip();
        //"EndUserIPAddress":"2.30.29.26, 2.30.29.26"
        $last_index_ip = strpos($ipclinent, ",");
        if ($last_index_ip > -1) {
            $ipArray = explode(",", $ipclinent);
            $countIP = count($ipArray);
            if ($countIP > 0) {
                $ipclinent = trim($ipArray[0]);
            }
        }

        //request
        $request = new \stdClass();
        $request->UPSSecurity = (object) [];
        $request->RegisterRequest = new \stdClass();
        $request->RegisterRequest->Request = $request_entity->Request;

        $request->RegisterRequest->Username = $Username;
        $request->RegisterRequest->Password = $Password;
        $request->RegisterRequest->CompanyName = $data->company;
        $request->RegisterRequest->CustomerName = $data->customer_name;
        $request->RegisterRequest->EndUserIPAddress = $ipclinent;
        $request->RegisterRequest->Title = $data->title;
        $request->RegisterRequest->Address = $address_entity->Address;
        $request->RegisterRequest->PhoneNumber = $data->phone_number;
        $request->RegisterRequest->EmailAddress = $data->email;
        $request->RegisterRequest->NotificationCode = "01";
        $request->RegisterRequest->DeviceIdentity = (!empty($data->device_identity)) ? $data->device_identity : '';
        $request->RegisterRequest->SuggestUsernameIndicator = "N";
        $request->RegisterRequest->ShipperAccount = $account_entity->ShipperAccount;

        $response = new \stdClass();
        //response->username
        $response->username = $Username;
        //response->password
        $response->password = $Password;
        //response->request
        $response->request = $request;
        return $response;
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
