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

class Ups_Eu_Woo_Registered_Token
{
    public function ups_eu_woo_create_request_registered_token($data, $license)
    {
        include_once("entities/class-api-ups-eu-woo-get-token-entity.php");
        $handshake = new Ups_Eu_Woo_Get_Token_Entity();
        $handshake->ups_eu_woo_create_metadata($data);
        $handshake->ups_eu_woo_create_ups_security($license);
        $request = new \stdClass();
        $request->WebstoreMetadata = $handshake->WebstoreMetadata;
        $request->UPSSecurity = $handshake->UPSSecurity;
        return $request;
    }
}
