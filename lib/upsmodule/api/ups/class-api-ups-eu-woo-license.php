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
 * License.php - The core plugin class.
 * 
 * This is used to get license of UPS in the current version of the plugin
 */

class Ups_Eu_Woo_License 
{
	private $_post_code = 'post_code';
	/**
	* @author	United Parcel Service of America, Inc. <noreply@ups.com>
	* ups_eu_woo_license_access_1
	*/
    public function ups_eu_woo_license_access_1($data, $developerLicenseNumber) {
        $request = new \stdClass();
		//S data 
        //UPS Security
		$request->UPSSecurity = [
            "UsernameToken" => [
                "Username" => "nousername", //nousername
                "Password" => "nopassword" //nopassword
            ],
            "ServiceAccessToken" => [
                "AccessLicenseNumber" => "nokey" //nokey
            ]
		];
		//Access License Agreement Request
        $request->AccessLicenseAgreementRequest = [
            "Request" => [
                "RequestOption" => "", //RequestOption
                "TransactionReference" => [
                    "CustomerContext" => "CutomerContext", //CutomerContext
                    "TransactionIdentifier" => "" //TransactionIdentifier
                ]
            ],
            "DeveloperLicenseNumber" => $developerLicenseNumber, //developerLicenseNumber
            "AccessLicenseProfile" => $data //AccessLicenseProfile
        ];
		//End
		return $request;
    }
	/**
	* @author	United Parcel Service of America, Inc. <noreply@ups.com>
	* ups_eu_woo_license_access_2
	*/
    public function ups_eu_woo_license_access_2($data, $upsSecurity){
		//post_code
        $post_code = html_entity_decode($data[$this->_post_code]);
        //postcode
		$postcode = preg_replace('/[^a-zA-Z0-9]/s', '', $post_code);
		//data
        $data[$this->_post_code] = $postcode;
        //request
        $request = new \stdClass();
		//UPS Security
        $request->UPSSecurity = $upsSecurity;
		//S Access License Request
        $request->AccessLicenseRequest = [
            "Request" => [
                "RequestOption" => "",
                "TransactionReference" => [
                    "CustomerContext" => "CutomerContext", //CutomerContext
                    "TransactionIdentifier" => ""
                ]
            ],
            "CompanyName" => $data['company'], //CompanyName
            "Address" => [ //Address
                "AddressLine1" => $data['address_1'],
                "AddressLine2" => $data['address_2'],
                "AddressLine3" => $data['address_3'],
                "City" => $data['city'],
                "StateProvinceCode" => $data['province_code'],
                "PostalCode" => $data[$this->_post_code],
                "CountryCode" => $data['country_code'],
            ],
            "PrimaryContact" => [ //PrimaryContact
                "Name" => $data['customer_name'],
                "Title" => $data['title'],
                "EMailAddress" => $data['email'],
                "PhoneNumber" => $data['phone_number'],
                "FaxNumber" => $data['fax'],
            ],
            "SecondaryContact" => [ //SecondaryContact
                "Name" => $data['customer_name'],
                "Title" => $data['title'],
                "EMailAddress" => $data['email'],
                "PhoneNumber" => $data['phone_number'],
                "FaxNumber" => $data['fax'],
            ],
            "CompanyURL" => $_SERVER['SERVER_NAME'],
            "DeveloperLicenseNumber" => $data['developerLicenseNumber'],
            "AccessLicenseProfile" => [
                "CountryCode" => $data['country_code'],
                "LanguageCode" => $data['language_code'],
                "AccessLicenseText" => $data['accessLicenseText']
            ],
            "ClientSoftwareProfile" => [
                "SoftwareInstaller" => "Opencart",
                "SoftwareProductName" => "Opencart Module",
                "SoftwareProvider" => "Opencart",
                "SoftwareVersionNumber" => $data['version']
            ]
        ];
		//E Access License Request
		return $request;
    }
}
