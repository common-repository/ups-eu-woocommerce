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

class Ups_Eu_Woo_Get_Token_Entity
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

    public $UPSSecurity;

    public function ups_eu_woo_create_metadata($data)
    {
        $metadata = new \stdClass();
        $metadata->{$this->MerchantKey} = $data->{$this->MerchantKey};
        $metadata->{$this->WebstoreUrl} = $data->{$this->WebstoreUrl};
        $metadata->{$this->WebstoreUpsServiceLinkSecurityToken} = $data->{$this->WebstoreUpsServiceLinkSecurityToken};
        $metadata->{$this->WebstorePlatform} = $data->{$this->WebstorePlatform};
        $metadata->{$this->WebstorePlatformVersion} = $data->{$this->WebstorePlatformVersion};
        $metadata->{$this->UpsReadyPluginName} = $data->{$this->UpsReadyPluginName};
        $metadata->{$this->UpsReadyPluginVersion} = $data->{$this->UpsReadyPluginVersion};
        $this->WebstoreMetadata = $metadata;
    }

    public function ups_eu_woo_create_ups_security($license)
    {
        $this->UPSSecurity = $license;
    }
}
