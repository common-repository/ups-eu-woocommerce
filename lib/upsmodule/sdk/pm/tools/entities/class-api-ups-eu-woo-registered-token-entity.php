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

class Ups_Eu_Woo_Registered_Token_Entity
{
    public $WebstoreMetadata;
    public $MerchantKey = "MerchantKey";
    public $WebstoreUrl = "WebstoreUrl";
    public $WebstoreUpsServiceLinkSecurityToken = "WebstoreUpsServiceLinkSecurityToken";
    public $WebstorePlatform = "WebstorePlatform";
    public $WebstorePlatformVersion = "WebstorePlatformVersion";
    public $UpsReadyPluginName = "UpsReadyPluginName";
    public $UpsReadyPluginVersion = "UpsReadyPluginVersion";

    public $VerboseResponseSecurityKey = "VerboseResponseSecurityKey";
    public $WebstoreUpsServiceLinkUrl = "WebstoreUpsServiceLinkUrl";
}
