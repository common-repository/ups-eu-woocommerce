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

    public function ups_eu_woo_locator_load_address($data, $upsSecurity) {
        //$request
        $request = new \stdClass();
        //$request AccessRequest
        $request->AccessRequest = [
            "AccessLicenseNumber" => $upsSecurity['ServiceAccessToken']['AccessLicenseNumber'], //AccessLicenseNumber
            "Username" => $upsSecurity['UsernameToken']['Username'], //Username
            "Password" => $upsSecurity['UsernameToken']['Password'] //Password
        ];
        //$request LocatorRequest
        $request->LocatorRequest = [
            "Request" => [
                "RequestAction" => "Locator",
                "RequestOption" => "64",
                "TransactionReference" => ""
            ],
            "OriginAddress" => [
                "PhoneNumber" => "",
                "AddressKeyFormat" => [
                    "SingleLineAddress" => $data['fullAddress'],
                    "CountryCode" => $data['countryCode']
                ]
            ],
            "Translate" => [
                // 'en-US'
                "Locale" => $data['Locale'],
            ],
            "UnitOfMeasurement" => [
                // 'KM'
                "Code" => $data['UnitOfMeasurement']
            ],
            "LocationSearchCriteria" => [
                "MaximumListSize" => $data['MaximumListSize'],
                "SearchRadius" => $data['nearby']
            ]
        ];
        return $request;
    }

}
