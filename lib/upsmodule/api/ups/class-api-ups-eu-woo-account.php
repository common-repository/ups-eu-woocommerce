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

class Ups_Eu_Woo_Account
{
    private $_post_code = 'post_code';
    private $_ups_invoice_date = 'ups_invoice_date';
    private $_ups_account_name = 'ups_account_name';
    private $_AccountName = 'AccountName';
    private $_ups_account_number = 'ups_account_number';
    private $_AccountNumber = 'AccountNumber';
    private $_country_code = 'country_code';
    private $_CountryCode = 'CountryCode';
    private $_PostalCode = 'PostalCode';
    private $_Request = 'Request';
    private $_TransactionReference = 'TransactionReference';
    private $_CustomerContext = 'CustomerContext';
    private $_Username = 'Username';
    private $pass_username_data = 'Password';
    private $_CompanyName = 'CompanyName';
    private $_EndUserIPAddress = 'EndUserIPAddress';
    private $_EmailAddress = 'EmailAddress';
    private $_DeviceIdentity = 'DeviceIdentity';
    private $_REMOTE_ADDR = 'REMOTE_ADDR';
    private $_BillingAddress = 'BillingAddress';
    private $_PickupAddress = 'PickupAddress';
    private $_EndUserInformation = 'EndUserInformation';
    private $_ContactName = 'ContactName';
    private $_StreetAddress = 'StreetAddress';
    private $_Phone = 'Phone';
    private $_Number = 'Number';
    private $_address_2 = 'address_2';
    private $_address_3 = 'address_3';
    private $_address_1 = 'address_1';
    private $_Title = 'Title';
    private $_PhoneNumber = 'PhoneNumber';
    private $_email = 'email';
    private $_Locale = 'Locale';
    private $_AccessLicenseProfile = 'AccessLicenseProfile';
    private $_LanguageCode = 'LanguageCode';
    private $_PromoCode = 'PromoCode';

    private function ups_eu_woo_account_generate_ups_id() {
        //prefix
        $prefix = 'FPTWooco';
        //key
        $key = $prefix . mt_rand(0, 99999);
        return $key;
    }

    private function ups_eu_woo_account_generate_pass($length) {
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

    public function ups_eu_woo_api_account_registration($data, $upsSecurity) {
        //Username
        $Username = $this->ups_eu_woo_account_generate_ups_id();
        //Password
        $Password = $this->ups_eu_woo_account_generate_pass(26);
        //get client ip
        $ipclinent = $this->ups_eu_woo_account_get_client_ip();
        //_post_code
        $data[$this->_post_code] = str_replace('-', '', $data[$this->_post_code]);
        //check _ups_invoice_date
        if (!empty($data[$this->_ups_invoice_date])) {
            //_ups_invoice_date
            $data[$this->_ups_invoice_date] = str_replace('-', '', $data[$this->_ups_invoice_date]);
        }
        //request
        $request = new \stdClass();
        $request->UPSSecurity = $upsSecurity;
        //$data['account_type']
        switch ($data['account_type']) {
        case 1:
            //ShipperAccount
            $ShipperAccount = $this->ups_eu_woo_account_data_option_01($data);
            break;
        case 2:
            //ShipperAccount
            $ShipperAccount = [
                $this->_AccountName => html_entity_decode($data[$this->_ups_account_name]),
                $this->_AccountNumber => $data[$this->_ups_account_number],
                $this->_CountryCode => $data[$this->_country_code],
                $this->_PostalCode => $data[$this->_post_code]
            ];
            break;
        default:
            //ShipperAccount
            $ShipperAccount = [];
            break;
        }

        //Address
        $addressLine = [$data[$this->_address_1], $data[$this->_address_2], $data[$this->_address_3]];
        $address = [];
        //check addressLine
        foreach ($addressLine as $key => $value) {
            //check value
            if ($value != "") {
                array_push($address, $value);
            }
        }

        $device_identity = '';
        if (!empty($data['device_identity'])) {
            $device_identity = $data['device_identity'];
        }

        //RegisterRequest
        $request->RegisterRequest = [
            $this->_Request => [
                'RequestOption' => 'N', //RequestOption
                $this->_TransactionReference => [
                    $this->_CustomerContext => $this->_CustomerContext //_CustomerContext
                ]
            ],
            $this->_Username => $Username, //Username
            $this->pass_username_data => $Password, //Password
            $this->_CompanyName => $data['company'], //company
            'CustomerName' => $data['customer_name'], //customer_name
            $this->_EndUserIPAddress => $ipclinent, //_EndUserIPAddress
            $this->_Title => $data['title'], //title
            'Address' => [
                'AddressLine' => $address, //AddressLine
                'City' => $data['city'], //City
                'StateProvinceCode' => 'XX', //StateProvinceCode
                $this->_PostalCode => $data[$this->_post_code], //_PostalCode
                $this->_CountryCode => $data[$this->_country_code] //_CountryCode
            ],
            $this->_PhoneNumber => $data['phone_number'], //_PhoneNumber
            $this->_EmailAddress => $data[$this->_email], //_EmailAddress
            'NotificationCode' => '01', //NotificationCode
            $this->_DeviceIdentity => $device_identity,
            'SuggestUsernameIndicator' => 'N', //SuggestUsernameIndicator
            'ShipperAccount' => $ShipperAccount //ShipperAccount
        ];

        $response = array();
        //response['username']
        $response['username'] = $Username;
        //response['password']
        $response['password'] = $Password;
        //response['request']
        $response['request'] = $request;
        return $response;
    }

    public function ups_eu_woo_account_get_client_ip() {
        //ipaddress
        $ipaddress = $_SERVER[$this->_REMOTE_ADDR];
        //check HTTP_CLIENT_IP
        if (isset($_SERVER['HTTP_CLIENT_IP'])) {
            //ipaddress
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        } else if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            //ipaddress
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else if (isset($_SERVER['HTTP_X_FORWARDED'])) {
            //ipaddress
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        } else if (isset($_SERVER['HTTP_FORWARDED_FOR'])) {
            //ipaddress
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        } else if (isset($_SERVER['HTTP_FORWARDED'])) {
            //ipaddress
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        } else if (isset($_SERVER[$this->_REMOTE_ADDR])) {
            //ipaddress
            $ipaddress = $_SERVER[$this->_REMOTE_ADDR];
        } else {
            //ipaddress
            $ipaddress = 'UNKNOWN';
        }
        //check ipaddress
        if (filter_var($ipaddress, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
            $ipaddress = '127.0.0.1';
        }
        return $ipaddress;
    }

    public function ups_eu_woo_api_account_registration_success($data, $upsSecurity) {
        //_post_code
        $data[$this->_post_code] = str_replace('-', '', $data[$this->_post_code]);
        //check _ups_invoice_date
        if (!empty($data[$this->_ups_invoice_date])) {
            //_ups_invoice_date
            $data[$this->_ups_invoice_date] = str_replace('-', '', $data[$this->_ups_invoice_date]);
        }
        //$data['account_type']
        switch ($data['account_type']) {
        case 1:
            //ShipperAccount
            $ShipperAccount = $this->ups_eu_woo_account_data_option_01($data);
            break;
        case 2:
            //ShipperAccount
            $ShipperAccount = [
                $this->_AccountName => html_entity_decode($data[$this->_ups_account_name]),
                $this->_AccountNumber => $data[$this->_ups_account_number],
                $this->_CountryCode => $data[$this->_country_code],
                $this->_PostalCode => $data[$this->_post_code]
            ];
            break;
        default:
            //ShipperAccount
            $ShipperAccount = [];
            break;
        }
        //request
        $request = new \stdClass();
        $request->UPSSecurity = $upsSecurity;
        $request->ManageAccountRequest = [
            $this->_Request => [
                $this->_TransactionReference => [
                    $this->_CustomerContext => $this->_CustomerContext //_CustomerContext
                ]
            ],
            $this->_Username => $upsSecurity['UsernameToken'][$this->_Username], //_Username
            $this->pass_username_data => $upsSecurity['UsernameToken'][$this->pass_username_data], //pass_username_data
            'ShipperAccount' => $ShipperAccount //ShipperAccount
        ];
        return $request;
    }

    public function ups_eu_woo_account_data_option_01($data) {
        $ShipperAccount = [
            $this->_AccountName => html_entity_decode($data[$this->_ups_account_name]), //_AccountName
            $this->_AccountNumber => $data[$this->_ups_account_number], //_ups_account_number
            $this->_CountryCode => $data[$this->_country_code], //_country_code
            $this->_PostalCode => $data[$this->_post_code], //_post_code
            'InvoiceInfo' => [
                'InvoiceNumber' => $data['ups_invoice_number'], //ups_invoice_number
                'InvoiceDate' => $data[$this->_ups_invoice_date], //_ups_invoice_date
                'CurrencyCode' => $data['ups_currency'], //ups_currency
                'InvoiceAmount' => $data['ups_invoice_amount'] //ups_invoice_amount
            ]
        ];
        return $ShipperAccount;
    }

    public function ups_eu_woo_api_account_open_account($data, $upsSecurity) {
        //Password
        $Password = $this->ups_eu_woo_account_generate_pass(26);
        //get client ip
        $ipclinent = $this->ups_eu_woo_account_get_client_ip();
        //_BillingAddress _PostalCode
        $data[$this->_BillingAddress][$this->_PostalCode] =
            str_replace('-', '', $data[$this->_BillingAddress][$this->_PostalCode]);
        //_PickupAddress _PostalCode
        $data[$this->_PickupAddress][$this->_PostalCode] =
            str_replace('-', '', $data[$this->_PickupAddress][$this->_PostalCode]);
        //Address
        $addressLine = [$data[$this->_address_1], $data[$this->_address_2], $data[$this->_address_3]];
        $address = [];
        //check addressLine
        foreach ($addressLine as $key => $value) {
            //value
            if ($value != "") {
                array_push($address, $value);
            }
        }

        //request
        $request = new \stdClass();
        $request->UPSSecurity = $upsSecurity;
        $request->OpenAccountRequest = [
            $this->_Locale => $data[$this->_Locale], //_Locale
            'CustomerServiceCode' => '02', //CustomerServiceCode
            $this->_Request => [
                $this->_TransactionReference => [
                    $this->_CustomerContext => '', //_CustomerContext
                    'TransactionIdentifier' => '' //TransactionIdentifier
                ]
            ],
            'AccountCharacteristics' => [
                'CustomerClassification' => [
                    'Code' => '01' //Code
                ]
            ],
            $this->_EndUserInformation => [
                $this->_EndUserIPAddress => $this->ups_eu_woo_account_get_client_ip(), //_EndUserIPAddress
                'EndUserEmail' => $data[$this->_email], //EndUserEmail
                'EndUserMyUPSID' => [
                    $this->_Username => $data[$this->_EndUserInformation][$this->_Username], //_Username
                ],
                'VatTaxID' => $data[$this->_EndUserInformation]['VatTaxID'], //VatTaxID
                $this->_DeviceIdentity => $data[$this->_EndUserInformation][$this->_DeviceIdentity] //_DeviceIdentity
            ],
            $this->_BillingAddress => [
                $this->_ContactName => substr($data[$this->_BillingAddress][$this->_ContactName], 0, 20),
                $this->_CompanyName => substr($data[$this->_BillingAddress][$this->_CompanyName], 0, 30),
                $this->_StreetAddress => substr($data[$this->_BillingAddress][$this->_StreetAddress], 0, 30),
                'City' => $data[$this->_BillingAddress]['City'],
                $this->_CountryCode => $data[$this->_BillingAddress][$this->_CountryCode],
                $this->_PostalCode => $data[$this->_BillingAddress][$this->_PostalCode],
                $this->_Phone => [
                    $this->_Number => $data[$this->_BillingAddress][$this->_Phone][$this->_Number]
                ]
            ],
            $this->_PickupAddress => [
                $this->_ContactName => substr($data[$this->_PickupAddress][$this->_ContactName], 0, 20),
                $this->_CompanyName => substr($data[$this->_PickupAddress][$this->_CompanyName], 0, 30),
                $this->_StreetAddress => substr($data[$this->_PickupAddress][$this->_StreetAddress], 0, 30),
                'City' => $data[$this->_PickupAddress]['City'],
                $this->_CountryCode => $data[$this->_PickupAddress][$this->_CountryCode],
                $this->_PostalCode => $data[$this->_PickupAddress][$this->_PostalCode],
                $this->_Phone => [
                    $this->_Number => $data[$this->_PickupAddress][$this->_Phone][$this->_Number]
                ],
                $this->_EmailAddress => $data[$this->_PickupAddress][$this->_EmailAddress]
            ],
            'PickupInformation' => [
                'PickupOption' => [
                    'Code' => '08'
                ]
            ]
        ];
        return $request;
    }

    public function ups_eu_woo_account_check_success_api($response_data) {
        //check_api
        $check_api = [];
        //check Code
        if(isset($response_data->Code)){
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

    public function ups_eu_woo_account_license($data, $upsSecurity) {
        //Username
        $Username = $this->ups_eu_woo_account_generate_ups_id();
        //Password
        $Password = $this->ups_eu_woo_account_generate_pass(26);
        //get client ip
        $ipclinent = $this->ups_eu_woo_account_get_client_ip();
        //request
        $request = new \stdClass();
        $request->UPSSecurity = $upsSecurity;
        $request->AccessLicenseRequest = [
            $this->_Request => [
                'RequestOption' => '',
                'TransactionReference' => [
                    'CustomerContext' => 'CutomerContext',
                    'TransactionIdentifier' => ''
                ]
            ],
            'CompanyName' =>  $data[$this->_CompanyName],
            //Address
            'Address' => [
                'AddressLine1' => $data[$this->_address_1], //Username
                'AddressLine2' => $data[$this->_address_2], //VatTaxID
                'AddressLine3' => $data[$this->_address_3], //DeviceIdentity
                'City' => $data['city'], //City
                'StateProvinceCode' => 'XX', //StateProvinceCode
                'PostalCode' => $data[$this->_post_code], //PostalCode
                $this->_CountryCode => $data[$this->_country_code] //CountryCode
            ],
            //PrimaryContact
            'PrimaryContact' => [
                'Name' => $data['customer_name'], //Name
                $this->_Title => $data['title'], //Title
                'EMailAddress' => $data[$this->_email], //EMailAddress
                $this->_PhoneNumber => $data['phone_number'], //PhoneNumber
                'FaxNumber' => '' //FaxNumber
            ],
            //SecondaryContact
            'SecondaryContact' => [
                'Name' => 'Test', //Name
                $this->_Title => 'Mr', //Title
                'EMailAddress' => 'admin@mail.com', //EMailAddress
                $this->_PhoneNumber => '090909090', //PhoneNumber
            ],
            'CompanyURL' => $this->ups_eu_woo_account_get_client_ip(),
            'DeveloperLicenseNumber' => 'ED466785DB641E6C',
            $this->_AccessLicenseProfile => [
                $this->_CountryCode => $data[$this->_country_code],
                $this->_LanguageCode => $data[$this->_AccessLicenseProfile][$this->_LanguageCode],
                'AccessLicenseText' => $data[$this->_AccessLicenseProfile]['AccessLicenseText']
            ],
            'ClientSoftwareProfile' => [
                'SoftwareInstaller' => 'Opencart',
                'SoftwareProductName' => 'Opencart Module',
                'SoftwareProvider' => 'Opencart',
                'SoftwareVersionNumber' => '3.0.0.0'
            ]
        ];
        return $request;
    }

    public function ups_eu_woo_api_account_promo_discount_agreement($data, $upsSecurity) {
        //Username
        $Username = $this->ups_eu_woo_account_generate_ups_id();
        //Password
        $Password = $this->ups_eu_woo_account_generate_pass(26);
        //get client ip
        $ipclinent = $this->ups_eu_woo_account_get_client_ip();
        //request
        $request = new \stdClass();
        $request->UPSSecurity = $upsSecurity;
        $request->PromoDiscountAgreementRequest = [
            $this->_PromoCode => $data[$this->_PromoCode],
            $this->_Locale => [
                $this->_LanguageCode => $data[$this->_AccessLicenseProfile][$this->_LanguageCode],
                $this->_CountryCode => $data[$this->_country_code]
            ],
        ];
        return $request;
    }

    public function ups_eu_woo_api_account_promo($data, $upsSecurity) {
        //Username
        $Username = $this->ups_eu_woo_account_generate_ups_id();
        //Password
        $Password = $this->ups_eu_woo_account_generate_pass(26);
        //get client ip
        $ipclinent = $this->ups_eu_woo_account_get_client_ip();
        //request
        $request = new \stdClass();
        $request->UPSSecurity = $upsSecurity;
        $request->PromoDiscountRequest = [
            $this->_CountryCode => [
                'AgreementAcceptanceCode' => $data['checkAcceptanceCode'],
                $this->_PromoCode => $data[$this->_PromoCode],
                $this->_Locale => [
                    $this->_LanguageCode => $data[$this->_AccessLicenseProfile][$this->_LanguageCode],
                    $this->_CountryCode => $data[$this->_country_code]
                ]
            ],
            'AccountInfo' => [
                $this->_AccountNumber => $data[$this->_AccountNumber],
                //'AccountNotNeededIndicator' => $data['AccountNotNeededIndicator']
            ],
        ];
        return $request;
    }
}
