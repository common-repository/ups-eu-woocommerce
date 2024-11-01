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
 * Manage.php - The core plugin class.
 *
 * This is used to define and call to UPS Plugin Manager's API.
 */

class Ups_Eu_Woo_Manage
{
    private static $common;
    private static $registration;
    private static $open_account;
    private static $license;
    private static $convert;

    /**
     * @author    United Parcel Service of America, Inc. <noreply@ups.com>
     * 0. list Object
     */
    public function ups_eu_woo_api_list_object()
    {
        $object = new \stdClass();
        $object->dev = 'DEV';
        $object->check = 'check';
        $object->message = 'message';

        $object->registration = 'Ups_Eu_Woo_Registration';
        $object->open_account = 'Ups_Eu_Woo_Open_Account';
        $object->convert = 'Ups_Eu_Woo_ConvertToASCII';
        $object->license = 'Ups_Eu_Woo_License';
        $object->common = 'Ups_Eu_Woo_Common';

        return $object;
    }

    private function ups_eu_woo_api_load_library($class_name)
    {
        $constants = $this->ups_eu_woo_api_list_object();
        switch ($class_name) {
            case $constants->license:
                if (empty(self::$license)) {
                    include_once('pm/tools/class-api-ups-eu-woo-license.php');
                    self::$license = new Ups_Eu_Woo_License();
                }
                break;
            case $constants->registration:
                if (empty(self::$registration)) {
                    include_once('pm/tools/class-api-ups-eu-woo-registration.php');
                    self::$registration = new Ups_Eu_Woo_Registration();
                }
                break;
            case $constants->open_account:
                if (empty(self::$open_account)) {
                    include_once('pm/tools/class-api-ups-eu-woo-open-account.php');
                    self::$open_account = new Ups_Eu_Woo_Open_Account();
                }
                break;
            case $constants->convert:
                if (empty(self::$convert)) {
                    include_once('common/class-api-ups-eu-woo-convert-to-ascii.php');
                    self::$convert = new Ups_Eu_Woo_ConvertToASCII();
                }
                break;
            case $constants->common:
                if (empty(self::$common)) {
                    include_once("class-api-ups-eu-woo-common.php");
                    self::$common = new Ups_Eu_Woo_Common();
                }
                break;
            default:
                break;
        }
    }

    /**
     * Manage handShake
     *
     * @param object $data //The data
     *
     * @return data
     */
    public function ups_eu_woo_api_handshake($data)
    {
        include_once("pm/tools/class-api-ups-eu-woo-hand-shake.php");
        $handle_handshake = new Ups_Eu_Woo_Hand_Shake();
        $method_name = 'SecurityService/Handshake';
        $token = '';
        $request = $handle_handshake->ups_eu_woo_create_request_hand_shake($data);
        $response = $this->ups_eu_woo_send_request_to_manage($request, $method_name, $token, 0);
        $json_data = json_decode($response);
        //Response
        if (!empty($json_data->data)) {
            $result = $json_data->data;
        } else {
            $result = '';
        }
        return $result;
    }

    /**
     * Manage registeredPluginToken
     *
     * @param object $data //The data
     * @param array $license //The license
     *
     * @return data
     */
    public function ups_eu_woo_api_registered_plugin_token($data, $license)
    {
        include_once("pm/tools/class-api-ups-eu-woo-registered-token.php");
        $handle_registered_token = new Ups_Eu_Woo_Registered_Token();
        $method_name = 'SecurityService/RegisteredPluginToken';
        $token = '';
        $ups_security = $this->get_license_api($license);
        $request = $handle_registered_token->ups_eu_woo_create_request_registered_token($data, $ups_security);
        $response = $this->ups_eu_woo_send_request_to_manage($request, $method_name, $token, 0);
        $json_data = json_decode($response);
        //Response
        if (!empty($json_data->data)) {
            $result = $json_data->data;
        } else {
            $result = '';
        }
        return $result;
    }

    /**
     * Manage getUpsBingMapsKey
     *
     * @param object $token //The data
     *
     * @return data
     */
    public function ups_eu_woo_api_get_ups_bing_maps_key($token)
    {
        $method_name = 'SecurityService/UpsBingMapsKey';
        $response = $this->ups_eu_woo_send_request_to_manage('', $method_name, $token, 0);
        return json_decode($response);
    }

    /**
     * @author    United Parcel Service of America, Inc. <noreply@ups.com>
     * 1. ups_eu_woo_license_access_1
     */
    public function ups_eu_woo_api_termcondition($data)
    {
        $constants = $this->ups_eu_woo_api_list_object();
        $this->ups_eu_woo_api_load_library($constants->license);
        $this->ups_eu_woo_api_load_library($constants->common);
        $apiName = "UpsReadyProvider/License";
        $developerLicenseNumber = Ups_Eu_Woo_Common::$UPS_EU_WOO_DEVELOPER_LICENSE_NUMBER;
        $request = self::$license->ups_eu_woo_create_request_access1($data, $developerLicenseNumber);
        $response = $this->ups_eu_woo_send_request_to_manage($request, $apiName, $data->upsmodule_token, 0);
        $jsonData =  json_decode($response);
        $accessLicenseText = '';
        if (isset($jsonData->AccessLicenseAgreementResponse->AccessLicenseText)) {
            $accessLicenseText = $jsonData->AccessLicenseAgreementResponse->AccessLicenseText;
        }
        return $accessLicenseText;
    }

    /**
     * @author    United Parcel Service of America, Inc. <noreply@ups.com>
     * 1. ups_eu_woo_api_get_ups_id
     */
    public function ups_eu_woo_api_get_ups_id($token)
    {
        $apiName = 'SecurityService/MyUpsID';
        $response = $this->ups_eu_woo_send_request_to_manage("", $apiName, $token, 0);
        $result =  json_decode($response);
        return $result;
    }

    /**
     * @author    United Parcel Service of America, Inc. <noreply@ups.com>
     * 2. Create Account Default
     */
    public function ups_eu_woo_api_registration($data)
    {
        $constants = $this->ups_eu_woo_api_list_object();
        if ($data->account_type == 4) {
            $upsapi_shipment = new \UpsEuWoocommerce\libsystems\api_ups\Ups_Eu_Woo_Shipments_Api_Ups();
            $trk_data = new \stdClass();
            $trk_data->tracking_number = "";

            $license_data = new \stdClass();
            $license_data->Username = $data->ups_account_u_name;
            $license_data->Password = $data->ups_account_password;
            $license_data->AccessLicenseNumber = $data->ups_account_access;

            $trackingResponse = json_decode($upsapi_shipment->ups_eu_woo_call_api_status_shipment_acc_verify($trk_data, $license_data));
            $arrayResponse  = [];
            if (empty($trackingResponse)) {
                $arrayResponse[$constants->check] = false;
                $arrayResponse[$constants->message] = "Empty response found while verifying Account.";
                return $arrayResponse;
            } elseif (isset($trackingResponse->Fault->detail->Errors->ErrorDetail->PrimaryErrorCode->Code)) {
                $err_code = $trackingResponse->Fault->detail->Errors->ErrorDetail->PrimaryErrorCode->Code;
                $err_arr = array("250002","250003");
                if (empty($err_code)) {
                    $arrayResponse[$constants->check] = false;
                    $arrayResponse[$constants->message] = "Unfamiliar response found while verifying Account.";
                    return $arrayResponse;
                } elseif (in_array($err_code, $err_arr)) {
                    $arrayResponse[$constants->check] = false;
                    $arrayResponse[$constants->message] = $trackingResponse->Fault->detail->Errors->ErrorDetail->PrimaryErrorCode->Description;
                    return $arrayResponse;
                } else {
                    $arrayResponse[$constants->check] = true;
                    $arrayResponse['username'] = $data->myUpsID;
                    $arrayResponse['password'] = $data->ups_account_password;
                    return $arrayResponse;
                }
            } else {
                $arrayResponse[$constants->check] = false;
                $arrayResponse[$constants->message] = "Unhandled response found while verifying Account.";
                return $arrayResponse;
            }
        }
        $this->ups_eu_woo_api_load_library($constants->registration);
        $this->ups_eu_woo_api_load_library($constants->convert);
        $apiName = 'UpsReadyProvider/Registration';
        //address_1
        $data->address_1 = $this->resetup_address($data->address_1);
        $data->address_2 = $this->resetup_address($data->address_2);
        $data->address_3 = $this->resetup_address($data->address_3);
        $data->phone_number = $this->resetup_phone_number($data->phone_number);
        $data->post_code = $this->resetup_postal_code($data->post_code);
        //Convert data input to Ascii
        self::$convert->ups_eu_woo_convert_transliterator($data);
        $response = self::$registration->ups_eu_woo_api_account_registration($data);
        //Call Curl
        $responseData = $this->ups_eu_woo_send_request_to_manage($response->request, $apiName, $data->upsmodule_token, 0);
        $arrayResponse  = [];
        $json = json_decode($responseData);
        if (isset($data->account_type) && $data->account_type == 3) {
            if (isset($json->RegisterResponse->Response->ResponseStatus->Code) &&
            $json->RegisterResponse->Response->ResponseStatus->Code == 1) {
                $arrayResponse[$constants->check] = $json->RegisterResponse->Response->ResponseStatus->Code;
                $arrayResponse['description'] = $json->RegisterResponse->Response->ResponseStatus->Description;
                $check_api_response = self::$registration->ups_eu_woo_account_check_success_api($json->RegisterResponse->ShipperAccountStatus);
                $arrayResponse[$constants->message] = $check_api_response[1];
            } else {
                $arrayResponse[$constants->check] = false;
                $arrayResponse[$constants->message] =
                    $json->Fault->detail->Errors->ErrorDetail->PrimaryErrorCode->Description;
            }
        } else {
            if (isset($json->RegisterResponse->Response->ResponseStatus->Code) &&
            $json->RegisterResponse->Response->ResponseStatus->Code == 1) {
                $check_api_response = self::$registration->ups_eu_woo_account_check_success_api($json->RegisterResponse->ShipperAccountStatus);
                $arrayResponse[$constants->check] = $check_api_response[0];
                $arrayResponse[$constants->message] = $check_api_response[1];
            } else {
                $arrayResponse[$constants->check] = false;
                if (isset($json->error->message)) {
                    $arrayResponse[$constants->message] = $json->error->message;
                } else {
                    $arrayResponse[$constants->message] =
                        $json->Fault->detail->Errors->ErrorDetail->PrimaryErrorCode->Description;
                }
            }
        }
        $arrayResponse['username'] = $response->username;
        $arrayResponse['password'] = $response->password;
        return $arrayResponse;
    }

    /**
     * @author    United Parcel Service of America, Inc. <noreply@ups.com>
     * 3 ups_eu_woo_license_access_2
     */
    public function ups_eu_woo_api_access_2($data)
    {
        $constants = $this->ups_eu_woo_api_list_object();
        $this->ups_eu_woo_api_load_library($constants->license);
        $this->ups_eu_woo_api_load_library($constants->convert);
        $this->ups_eu_woo_api_load_library($constants->common);

        $apiName = 'UpsReadyProvider/License';
        $data->developer_license_number = Ups_Eu_Woo_Common::$UPS_EU_WOO_DEVELOPER_LICENSE_NUMBER;
        $data->address_1 = $this->resetup_address($data->address_1);
        $data->address_2 = $this->resetup_address($data->address_2);
        $data->address_3 = $this->resetup_address($data->address_3);
        $data->phone_number = $this->resetup_phone_number($data->phone_number);
        $data->post_code = $this->resetup_postal_code($data->post_code);
        //Convert data input to Ascii
        self::$convert->ups_eu_woo_convert_transliterator($data);
        $request = self::$license->ups_eu_woo_create_request_access2($data);

        $response = $this->ups_eu_woo_send_request_to_manage($request, $apiName, $data->upsmodule_token, 0);
        return $response;
    }
    public function ups_eu_woo_api_access_2_rest($data)
    {
        $constants = $this->ups_eu_woo_api_list_object();
        $this->ups_eu_woo_api_load_library($constants->license);
        $this->ups_eu_woo_api_load_library($constants->convert);
        $this->ups_eu_woo_api_load_library($constants->common);

        $apiName = 'License';
        $data->developer_license_number = Ups_Eu_Woo_Common::$UPS_EU_WOO_DEVELOPER_LICENSE_NUMBER;
        $data->address_1 = $this->resetup_address($data->address_1);
        $data->address_2 = $this->resetup_address($data->address_2);
        $data->address_3 = $this->resetup_address($data->address_3);
        $data->phone_number = $this->resetup_phone_number($data->phone_number);
        $data->post_code = $this->resetup_postal_code($data->post_code);
        //Convert data input to Ascii
        self::$convert->ups_eu_woo_convert_transliterator($data);
        $request = self::$license->ups_eu_woo_create_request_access2($data);
        $request->UPSSecurity->UsernameToken = new \stdClass();
        $request->UPSSecurity->UsernameToken->Username = $data->ups_account_u_name;
        $request->UPSSecurity->UsernameToken->Password = $data->ups_account_password;
        $request->UPSSecurity->ServiceAccessToken = new \stdClass();
        $request->UPSSecurity->ServiceAccessToken->AccessLicenseNumber = $data->developer_license_number;

        $response = $this->ups_eu_woo_send_request_to_manage($request, $apiName, $data->upsmodule_token, 2);
        return $response;
    }

    /**
     * @author    United Parcel Service of America, Inc. <noreply@ups.com>
     * 4.1 Open Account
     */

    public function ups_eu_woo_api_open_account($data)
    {
        $constants = $this->ups_eu_woo_api_list_object();
        $this->ups_eu_woo_api_load_library($constants->open_account);
        $this->ups_eu_woo_api_load_library($constants->convert);

        $apiName = 'UpsReadyProvider/OpenAccount';
        //Convert data input to Ascii
        self::$convert->ups_eu_woo_convert_transliterator($data);
        //resetup data (address, phone number, postal code)
        $request =  self::$open_account->ups_eu_woo_api_account_open_account($data);
        $response = $this->ups_eu_woo_send_request_to_manage($request, $apiName, $data->upsmodule_token, 0);
        return $response;
    }

    /**
     * @author    United Parcel Service of America, Inc. <noreply@ups.com>
     * Name function: ups_eu_woo_api_verify_merchant
     * Params: $license
     * Return: Token Key/False
     */
    public function ups_eu_woo_api_verify_merchant($data)
    {
        $url = 'Merchant/VerifyMerchant';
        $upsSecurity = $this->get_license_api($data);
        $request = new \stdClass();
        $request->UPSSecurity = $upsSecurity;
        $response = $this->ups_eu_woo_send_request_to_manage($request, $url, $data->upsmodule_token);
        $json_data = json_decode($response);
        //Response
        if (isset($json_data->data)) {
            return $json_data->data;
        } else {
            return false;
        }
    }

    /**
     * @author    United Parcel Service of America, Inc. <noreply@ups.com>
     * Name function: ups_eu_woo_api_update_merchant_status
     * Params: $data is {token,merchantKey,status,accountNumber=null}
     * Return: $response
     */
    public function ups_eu_woo_api_update_merchant_status($data)
    {
        $url = 'Merchant/UpdateMerchantStatus';
        $request = new \stdClass();
        $request->merchantKey = $data->merchant_key;
        if (isset($data->account_number)) {
            $request->accountNumber = $data->account_number;
        }
        //Activated    10
        //Deactivated 20
        //Uninstalled 30
        $request->status = $data->status;
        //dataFormat
        $dataFormat = [];
        $dataFormat[] = $request;
        $response = $this->ups_eu_woo_send_request_to_manage($dataFormat, $url, $data->upsmodule_token);
        return json_decode($response);
    }

    /**
     * @author    United Parcel Service of America, Inc. <noreply@ups.com>
     * Name function: ups_eu_woo_api_transfer_accessorials
     * Params: $data is {token,merchantKey,accessorials}
     * Return: $response
     */
    public function ups_eu_woo_api_transfer_accessorials($data)
    {
        $url = 'Merchant/TransferAccessorials';
        $accessorials = $data->accessorials;
        //set Data
        $request = new \stdClass();
        $request->merchantKey = $data->merchant_key;
        if (!empty($accessorials)) {
            foreach ($accessorials as $item) {
                $accessorial_items = new \stdClass();
                $accessorial_items->key = $item->accessorial_key;
                $accessorial_items->name = $item->accessorial_name;
                $request->accessorials[] = $accessorial_items;
            }
        }
        //data Format
        $dataFormat[] = $request;
        $response = $this->ups_eu_woo_send_request_to_manage($dataFormat, $url, $data->upsmodule_token);
        return json_decode($response);
    }

    /**
     * @author    United Parcel Service of America, Inc. <noreply@ups.com>
     * Name function: ups_eu_woo_api_transfer_default_package
     * Params: $data is {token,merchantKey,package:{name,weight,weightUnit,length,width,height,dimensionUnit}}
     * Return: $response
     */
    public function ups_eu_woo_api_transfer_default_package($data)
    {
        $package = $data->package;
        $packageDimension = [];
        if ($package->package_setting_option == 1) {
            // Set data for default package dimensions
            $url = 'Merchant/TransferDefaultPackage';
            foreach ($package->package_default_list as $package_default) {
                // Set package item
                $defaultPackage = new stdClass();
                $defaultPackage->merchantKey = $data->merchant_key;
                $defaultPackage->name = $package_default->package_name;
                $defaultPackage->weight = $package_default->weight;
                $defaultPackage->weightUnit = $this->transfer($package_default->unit_weight);
                $defaultPackage->length = $package_default->length;
                $defaultPackage->width = $package_default->width;
                $defaultPackage->height = $package_default->height;
                $defaultPackage->dimensionUnit = $package_default->unit_dimension;
                $defaultPackage->packageItem = $package_default->package_item;
                // Add item to request
                $packageDimension[] = $defaultPackage;
            }
        } else {
            // Set data for product dimensions
            $url = 'Merchant/TransferDefaultPackageRate';
            $productDimension = new stdClass();
            $productDimension->merchantKey = $data->merchant_key;
            $productDimension->includeDimensionsInRating = $package->item_level_rating_include_dimensions === true ? 1 : 0;
            foreach ($package->fallback_rates_list as $fallback_rate) {
                // Set package item
                $backupRate = new stdClass();
                $backupRate->serviceKey = $fallback_rate->service_key;
                $backupRate->rate = floatval($fallback_rate->fallback_rate);
                // Add item to request
                $productDimension->backupRate[] = $backupRate;
            }
            $packageDimension[] = $productDimension;
        }
        // Send request
        $response = $this->ups_eu_woo_send_request_to_manage($packageDimension, $url, $data->upsmodule_token);
        return json_decode($response);
    }

    /**
     * @author    United Parcel Service of America, Inc. <noreply@ups.com>
     * Name function: ups_eu_woo_api_transfer_delivery_rates
     * Params: $data is {token,merchantKey,deliveryService}
     * Return: $response
     */
    public function ups_eu_woo_api_transfer_delivery_rates($data)
    {
        $url = 'Merchant/TransferDeliveryRates';
        $request = new \stdClass();
        $request->merchantKey = $data->merchant_key;
        //data
        $deliveryService = $data->delivery_service;
        //Set delivery Rates
        if (!empty($deliveryService)) {
            foreach ($deliveryService as $item) {
                $arr_delivery = $this->ups_eu_woo_delivery_service($item);
                $request->deliveryRates[] = $arr_delivery;
            }
        }
        //dataFormat
        $dataFormat[] = $request;
        $response = $this->ups_eu_woo_send_request_to_manage($dataFormat, $url, $data->upsmodule_token);
        return json_decode($response);
    }

    /**
     * @author    United Parcel Service of America, Inc. <noreply@ups.com>
     * Name function: ups_eu_woo_api_transfer_merchant_info_by_user
     * Params: $data is {token,merchantKey,account_list,platform,package,status}
     * Return: $response
     */
    public function ups_eu_woo_api_transfer_merchant_info_by_user($data)
    {
        $url = 'Merchant/TransferMerchantInfo';
        $request = [];
        //Acount List
        $account_list = $data->account_list;
        $package = $data->package;
        $platform = $data->platform;
        $status = $data->status;
        //Info Account
        if (!empty($account_list)) {
            foreach ($account_list as $item) {
                $object_account = new \stdClass();
                $object_account = $this->ups_eu_woo_object_account($data, $item, $package, $platform, $status);
                $request[] = $object_account;
            }
        }
        //dataFormat
        $dataFormat = $request;
        $response = $this->ups_eu_woo_send_request_to_manage($dataFormat, $url, $data->upsmodule_token);
        return json_decode($response);
    }

    /**
     * @author    United Parcel Service of America, Inc. <noreply@ups.com>
     * Name function: ups_eu_woo_api_transfer_merchant_info
     * Params: $data is {token,merchantKey,accessorials,account_list,platform,package,service,deliveryService}
     * Return: $response
     */
    public function ups_eu_woo_api_transfer_merchant_info($data)
    {
        $url = 'Merchant/TransferMerchantInfo';
        $request = [];
        //Acount List
        $account_list = $data->account_list;
        $accessorials = $data->accessorials;
        $package = $data->package;
        $platform = $data->platform;
        //Total accessorials
        // accessorial
        $arr_accessorials = [];
        if (!empty($accessorials)) {
            foreach ($accessorials as $item) {
                $accessorial_items = new \stdClass();
                $accessorial_items->key = $item->accessorial_key;
                $accessorial_items->name = $item->accessorial_name;
                $arr_accessorials[] = $accessorial_items;
            }
        }
        //service
        $shipping_service = $data->service;
        $arr_shipping_services = [];
        if (!empty($shipping_service)) {
            foreach ($shipping_service as $item) {
                $data_service = $this->ups_eu_woo_data_service($item);
                $arr_shipping_services[] = $data_service;
            }
        }
        //arrDeliveryRates
        $deliveryService = $data->delivery_service;
        $arr_delivery_rates = [];
        if (!empty($deliveryService)) {
            foreach ($deliveryService as $item) {
                $arr_delivery = $this->ups_eu_woo_delivery_service($item);
                $arr_delivery_rates[] = $arr_delivery;
            }
        }
        //Info Account
        if (!empty($account_list)) {
            foreach ($account_list as $item) {
                $object_account = new \stdClass();
                $object_account = $this->ups_eu_woo_object_account($data, $item, $package, $platform, 10);
                $object_account->accessorials = $arr_accessorials;
                $object_account->shippingServices = $arr_shipping_services;
                $object_account->deliveryRates = $arr_delivery_rates;

                $request[] = $object_account;
            }
        }
        $response = $this->ups_eu_woo_send_request_to_manage($request, $url, $data->upsmodule_token);
        return json_decode($response);
    }

    /**
     * @author    United Parcel Service of America, Inc. <noreply@ups.com>
     * Name function: ups_eu_woo_delivery_service
     * Params: $items is {rate_type,delivery_rate,rate_code,service_key_delivery,min_order_value,service_name}
     * Return: $array is service data
     */
    public function ups_eu_woo_delivery_service($items)
    {
        $item = (object) $items;
        if ($item->service_type == 'AP') {
            $service_type = 10;
        } else {
            $service_type = 20;
        }
        //AP
        if ($item->rate_type == 'flat_rate') {
            $delivery_type = 10;
            $realtime_value = 0;
            $delivery_rate = $item->delivery_rate;
        } else {//ADD
            $delivery_type = 20;
            $realtime_value = $item->delivery_rate;
            $delivery_rate = 0;
        }
        //Service Name
        $service_name = $this->ups_eu_woo_format_service_name($item->rate_code, $item->service_key_delivery, $item->service_name);
        //Response Data
        $response = new \stdClass();
        $response->key = $item->service_key_delivery;
        $response->deliveryType = $delivery_type;
        $response->serviceType = $service_type;
        $response->serviceCode = $item->rate_code;
        $response->serviceName = $service_name;
        $response->minimumOrderValue = $item->min_order_value;
        $response->deliveryValue = $delivery_rate;
        $response->realtimeValue = $realtime_value;
        return $response;
    }

    /**
     * @author    United Parcel Service of America, Inc. <noreply@ups.com>
     * Name function: ups_eu_woo_object_account
     * Params: $merchantKey, $package, $platform, $status, $items is account data
     * Return: $object is account data
     */
    public function ups_eu_woo_object_account($data, $items, $package, $platform, $status)
    {
        $object = new \stdClass();
        $item = (object) $items;

        $checkPostalCode = html_entity_decode($item->post_code);
        $postcode = preg_replace('/[^a-zA-Z0-9]/s', '', $checkPostalCode);

        //Account Info
        $object->merchantKey = $data->merchant_key;
        $object->accountNumber = $item->ups_account_number;
        $object->joiningDate = $data->joining_date;
        $object->website = $data->website;
        $object->currencyCode = $item->currency_code;
        $object->status = $status;
        $object->platform = $platform;
        $object->version = $data->version;

        $object->postalCode = $postcode;
        $object->city = $item->city;
        $object->country = $item->country;
        $object->isFirstAccount = (bool) $item->account_default;

        //Package Dimension
        $packageObject = $this->ups_eu_woo_object_package($package);
        foreach ($packageObject as $property => $value) {
            $object->$property = $value;
        }
        return $object;
    }

    /**
     * @author    United Parcel Service of America, Inc. <noreply@ups.com>
     * Name function: ups_eu_woo_object_package
     * Params: $package is package dimension setting
     * Return: $object is package setting info
     */
    public function ups_eu_woo_object_package($package)
    {
        $object = new stdClass();
        // Set data for default package dimensions
        if ($package->package_setting_option == 1) {
            foreach ($package->package_default_list as $package_default) {
                // Set package item
                $packageItem = new stdClass();
                $packageItem->option = intval($package->package_setting_option);
                $packageItem->name = $package_default->package_name;
                $packageItem->weight = floatval($package_default->weight);
                $packageItem->weightUnit = $this->transfer($package_default->unit_weight);
                $packageItem->length = floatval($package_default->length);
                $packageItem->width = floatval($package_default->width);
                $packageItem->height = floatval($package_default->height);
                $packageItem->dimensionUnit = $package_default->unit_dimension;
                $packageItem->packageItem = intval($package_default->package_item);
                $packageItem->includeDimensionsInRating = 0;
                $packageItem->serviceKey = '';
                $packageItem->rate = 0;
                // Add item to request
                $object->packageDimension[] = $packageItem;
            }
            // Set data for product dimensions
        } elseif ($package->package_setting_option == 2) {
            foreach ($package->fallback_rates_list as $fallback_rate) {
                $packageItem = new stdClass();
                // Set package item
                $packageItem->option = intval($package->package_setting_option);
                $packageItem->name = '';
                $packageItem->weight = 0;
                $packageItem->weightUnit = '';
                $packageItem->length = 0;
                $packageItem->width = 0;
                $packageItem->height = 0;
                $packageItem->dimensionUnit = '';
                $packageItem->packageItem = 1;
                $packageItem->includeDimensionsInRating = $package->item_level_rating_include_dimensions === true ? 1 : 0;
                $packageItem->serviceKey = $fallback_rate->service_key;
                $packageItem->rate = floatval($fallback_rate->fallback_rate);
                // Add item to request
                $object->packageDimension[] = $packageItem;
            }
        }
        return $object;
    }

    /**
     * @author    United Parcel Service of America, Inc. <noreply@ups.com>
     * Name function: ups_eu_woo_api_transfer_shipping_services
     * Params: $data is {token,merchantKey,deliveryService}
     * Return: $response
     */
    public function ups_eu_woo_api_transfer_shipping_services($data)
    {
        $url = 'Merchant/TransferShippingServices';
        $request = new \stdClass();
        $request->merchantKey = $data->merchant_key;
        //service
        $shipping_service = $data->delivery_service;
        if (!empty($shipping_service)) {
            foreach ($shipping_service as $item) {
                $data_service = $this->ups_eu_woo_data_service($item);
                $request->shippingServices[] = $data_service;
            }
        }
        //dataFormat
        $dataFormat = [];
        $dataFormat[] = $request;
        $response = $this->ups_eu_woo_send_request_to_manage($dataFormat, $url, $data->upsmodule_token);
        return json_decode($response);
    }

    /**
     * @author    United Parcel Service of America, Inc. <noreply@ups.com>
     * Name function: ups_eu_woo_data_service
     * Params: $items is {service_type,service_name,service_key,service_key_val,rate_code}
     * Return: $data is service data
     */
    public function ups_eu_woo_data_service($items)
    {
        $item = (object) $items;
        if ($item->service_type == 'AP') {
            $service_type = 10;
        } else {
            $service_type = 20;
        }
        $data = new \stdClass();
        $data->key = $item->service_key;
        $data->serviceType = $service_type;
        $data->name = $this->ups_eu_woo_format_service_name($item->service_key_val, $item->service_key, $item->service_name);
        $data->code = $item->service_key_val;

        return $data;
    }

    /**
     * @author    United Parcel Service of America, Inc. <noreply@ups.com>
     * Name function: ups_eu_woo_api_transfer_shipments
     * Params: $data is {token,merchantKey,accountNumber,shipmentId,fee,revenue,address,postalCode,city,country,
     * serviceType,serviceCode,serviceName,isCashOnDelivery,products}
     * Return: $response
     */
    public function ups_eu_woo_api_transfer_shipments($data)
    {
        $url = 'Shipment/TransferShipments';
        if (strtolower($data->service_type) == 'ap') {
            $service_type = 10;
        } else {
            $service_type = 20;
        }
        $request = new \stdClass();
        $request->merchantKey = $data->merchant_key;
        //create data API
        $request->accountNumber = $data->account_number;
        $request->shipmentId = $data->shipment_id;
        $request->fee = $data->fee;
        $request->revenue = $data->revenue;
        $request->orderDate = $data->order_date;
        $request->address = $data->address;
        $request->postalCode = $data->postal_code;
        $request->city = $data->city;
        $request->country = $data->country;
        $request->serviceType = $service_type;
        $request->serviceCode = $data->service_code;
        $request->serviceName = $this->ups_eu_woo_format_service_name($data->service_code, $data->service_key, $data->service_name);
        $request->isCashOnDelivery = $data->is_cash_on_delivery;
        $request->products = $data->products;
        //accessorials
        $accessorials = $data->accessorials;
        if (!empty($accessorials)) {
            foreach ($accessorials as $items) {
                $accessorial_items = new \stdClass();
                $accessorial_items->name = $items;
                $request->accessorials[] = $accessorial_items;
            }
        }
        //packages
        $packages = $data->packages;
        if (!empty($packages)) {
            foreach ($packages as $item) {
                $package_items = new \stdClass();
                $package_items->trackingNumber = $item->tracking_number;
                $package_items->shipmentStatus = $data->status;
                $package_items->weight = (float) $item->package_weight->weight;
                $package_items->weightUnit = $this->transfer(strtolower($item->package_weight->code));
                $package_items->length = (float) $item->dimension->length;
                $package_items->width = (float) $item->dimension->width;
                $package_items->height = (float) $item->dimension->height;
                $package_items->dimensionUnit = strtolower($item->dimension->code);

                $request->packages[] = $package_items;
            }
        }
        //dataFormat
        $dataFormat = [];
        $dataFormat[] = $request;
        $response = $this->ups_eu_woo_send_request_to_manage($dataFormat, $url, $data->upsmodule_token);
        return json_decode($response);
    }

    /**
     * @author    United Parcel Service of America, Inc. <noreply@ups.com>
     * Name function: ups_eu_woo_format_service_name
     * @param $rate_code
     * @param $service_key
     * @param $service_name
     * @return string
     */
    private function ups_eu_woo_format_service_name($rate_code, $service_key, $service_name)
    {
        if (intval($rate_code) === 70) {
            $service_name = 'UPS Access Point™ Economy';
        } elseif (intval($rate_code) === 11) {
            if (strpos($service_key, 'SAT_DELI')) {
                $service_name = 'UPS® Standard - Saturday Delivery';
            } else {
                $service_name = 'UPS® Standard';
            }
        } elseif (intval($rate_code) === 7 && strpos($service_key, 'SAT_DELI')) {
            $service_name = 'UPS Express® - Saturday Delivery';
        } else {
            $service_name = $service_name . '®';
        }

        return $service_name;
    }

    /**
     * @author    United Parcel Service of America, Inc. <noreply@ups.com>
     * Name function: ups_eu_woo_api_update_shipment_status
     * Params: $data is {token,merchantKey,shipment:{shipmentId,shipmentStatus}}
     * Return: $response
     */
    public function ups_eu_woo_api_update_shipment_status($data)
    {
        $url = 'Shipment/UpdateShipmentStatus';
        $request = new \stdClass();

        $shipment = $data->shipment;
        //dataFormat
        $dataFormat = [];
        //shipment
        if (!empty($shipment)) {
            foreach ($shipment as $item) {
                $shipment_items = new \stdClass();
                $shipment_items->trackingNumber = $item->tracking_number;
                $shipment_items->shipmentStatus = $item->shipment_status;
                $dataFormat[] = $shipment_items;
            }
        }
        //Call API
        $response = $this->ups_eu_woo_send_request_to_manage($dataFormat, $url, $data->upsmodule_token);
        return json_decode($response);
    }

    /**
     * @author    United Parcel Service of America, Inc. <noreply@ups.com>
     * Name function: ups_eu_woo_api_upgrade_plugin_version
     * Params: $data is {token,merchantKey}
     * Return: $response
     */
    public function ups_eu_woo_api_upgrade_plugin_version($data)
    {
        $url = 'Merchant/UpgradePluginVersion';
        $dataFormat = new \stdClass();
        $dataFormat->merchantKey = $data->merchant_key;
        $dataFormat->version = \UpsEuWoocommerce\Ups_Eu_Woo_Main::$version;
        $request = [];
        $request[] = $dataFormat;
        //Call API
        $response = $this->ups_eu_woo_send_request_to_manage($request, $url, $data->upsmodule_token);
        return json_decode($response);
    }

    /**
     * @author    United Parcel Service of America, Inc. <noreply@ups.com>
     * Name function: ups_eu_woo_api_currency_plugin
     * Params: $data is {token,merchantKey}
     * Return: $response
     */
    public function ups_eu_woo_api_currency_plugin($data)
    {
        $url = 'ExchangeRates/getRates';
        $dataFormat = new \stdClass();
        $dataFormat->merchantKey = $data->merchant_key;
        $dataFormat->fileName = date("Ymd");
        $request = [];
        $request[] = $dataFormat;
        //Call API
        $response = $this->ups_eu_woo_send_request_to_manage($request, $url, $data->upsmodule_token);
        return json_decode($response);
    }

    /**
     * @author    United Parcel Service of America, Inc. <noreply@ups.com>
     * Name function: ups_eu_woo_send_request_to_manage
     * Params: $request_data, $url, $token
     * Return: $response
     */
    public function ups_eu_woo_send_request_to_manage($request_data, $url, $token, $option = 1)
    {
        $constants = $this->ups_eu_woo_api_list_object();
        $this->ups_eu_woo_api_load_library($constants->common);
        $response = self::$common->call_api_to_plugin_manager($request_data, $url, $token, $option);
        return $response;
    }

    /**
     * Manage ups_eu_woo_api_manage_save_error_log
     *
     * @param object $data request data
     * @param string $token token access api
     *
     * @return object response from api
     */
    public function ups_eu_woo_api_manage_save_error_log($data, $token)
    {
        $url = 'Merchant/WriteLogger';
        $request[] = $data;
        //Call API
        $response = $this->ups_eu_woo_send_request_to_manage($request, $url, $token);
        return json_decode($response);
    }

    /**
     * @author    United Parcel Service of America, Inc. <noreply@ups.com>
     * Name function: get_license_api
     * Params: $license
     * Return: $response
     */
    public function get_license_api($license)
    {
        $constants = $this->ups_eu_woo_api_list_object();
        $this->ups_eu_woo_api_load_library($constants->common);
        $response = self::$common->get_license($license);
        return $response;
    }

    /**
     * @author    United Parcel Service of America, Inc. <noreply@ups.com>
     * Name function: resetup_address
     * Params: $address_line
     * Return: split address data to 35 characters and clear some decode key
     */
    private function resetup_address($address_line)
    {
        if (!empty($address_line) && is_array($address_line)) {
            foreach ($address_line as $key => $value) {
                $add = str_replace(['amp;', '&lt;', '&gt;'], ['', '<', '>'], $value);
                $address_line[$key] = $this->string_split($add);
            }
        } else {
            $address = str_replace(['amp;', '&lt;', '&gt;'], ['', '<', '>'], $address_line);
            $address_line = $this->string_split($address);
        }
        return $address_line;
    }

    /**
     * @author    United Parcel Service of America, Inc. <noreply@ups.com>
     * Name function: string_split
     * Params: $string
     * Return: split string data to 35 characters
     */
    private function string_split($string)
    {
        $str_decode = utf8_decode($string);
        if (strlen($str_decode) > 35) {
            $result = utf8_encode(substr($str_decode, 0, 35));
        } else {
            $result = $string;
        }
        return $result;
    }

    /**
     * @author    United Parcel Service of America, Inc. <noreply@ups.com>
     * Name function: resetup_phone_number
     * Params: $phone_number
     * Return: get only number in phone number data
     */
    private function resetup_phone_number($phone_number)
    {
        $pattern = '/\D/';
        $phone_number = preg_replace($pattern, '', $phone_number);
        return $phone_number;
    }

    /**
     * @author    United Parcel Service of America, Inc. <noreply@ups.com>
     * Name function: resetup_postal_code
     * Params: $postal_code
     * Return: postal code data after clear special key
     */
    private function resetup_postal_code($postal_code)
    {
        $pattern = '/[^A-Za-z0-9]/';
        $postal_code = str_replace(['amp;', '&lt;', '&gt;'], ['', '<', '>'], $postal_code);
        $postal_code_new = preg_replace($pattern, '', $postal_code);
        return $postal_code;
    }

    /**
     * @author    United Parcel Service of America, Inc. <noreply@ups.com>
     * Name function: transfer
     * Params: $key is lbs/kgs
     * Return: $response
     */
    function transfer($key)
    {
        $array = [];
        $array['lbs'] = 'Pounds';
        $array['kgs'] = 'Kg';
        if (isset($array[$key])) {
            return $array[$key];
        } else {
            return $key;
        }
    }

    /**
     * @author    United Parcel Service of America, Inc. <noreply@ups.com>
     * Name function: get_information_all
     * Params: $col_url, $col_request, $col_response
     * Return: data info of url,request,response
     */
    public function get_information_all($col_url, $col_request, $col_response)
    {
        $constants = $this->ups_eu_woo_api_list_object();
        $this->ups_eu_woo_api_load_library($constants->common);
        $api_info = self::$common->get_api_info();
        return [
            "{$col_url}" => $api_info->uri,
            "{$col_request}" => $api_info->request,
            "{$col_response}" => $api_info->response
        ];
    }
}
