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

class Ups_Eu_Woo_Promo_Discount
{
    public function ups_eu_woo_api_account_promo_discount_agreement($data, $upsSecurity)
    {
        include_once("entities/class-api-ups-eu-woo-request-entity.php");
        $request_entity = new Ups_Eu_Woo_Request_Entity();

        $request_entity->setLocale($data);
        //request
        $request = new \stdClass();
        $request->UPSSecurity = $upsSecurity;
        $request->PromoDiscountAgreementRequest->PromoCode = $data->promo_code;
        $request->PromoDiscountAgreementRequest->Locale = $request_entity->Locale;

        return $request;
    }

    public function ups_eu_woo_api_account_promo($data, $upsSecurity)
    {
        //request
        include_once("entities/class-api-ups-eu-woo-account-entity.php");
        $account_entity = new Ups_Eu_Woo_Account_Entity();

        $account_entity->setCountryCodeInfo($data);
        $account_entity->setAccountInfo($data);

        //request
        $request = new \stdClass();
        $request->UPSSecurity = $upsSecurity;
        $request->PromoDiscountRequest = $account_entity->CountryCodeInfo;
        $request->PromoDiscountRequest->AccountInfo = $account_entity->AccountInfo;

        return $request;
    }
}
