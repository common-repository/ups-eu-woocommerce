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
 * This is used to verify license of plugin manager in the current version of the plugin
 */

class Ups_Eu_Woo_Manage_License
{
    private $urlManage = 'https://plugins-management-api.fsoft.com.vn/api/';
    /**
    * 1. VerifyMerchant
    */
    public function verifyMerchant($data, $urlVerifyMerchant)
    {
        $urlVerifyMerchant = $urlManage . 'Merchant/VerifyMerchant';
        $request = [
            "UPSSecurity" => [
                "Username" => "TuChu0103",
                "Password" => "T!@#052018"
            ],
            "ServiceAccessToken" => [
                "AccessLicenseNumber" => "0D46678E86A9D038"
            ]
        ];
        $data = json_encode($request);
        return $data;
    }
}
