<?php namespace UpsEuWoocommerce\models\entities;

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
 * ups-eu-woo-model-entity-roles-capabilities.php - The core plugin class.
 *
 * This is used to define the RolesCapabilities Entity.
 */

include_once(dirname(__FILE__, 3) . '/ups-eu-woo-autoloader.php');
new \UpsEuWoocommerce\Ups_Eu_Woo_Main_Autoloader('Ups_Eu_Woo_Roles_Capabilities_Entity');

class Ups_Eu_Woo_Roles_Capabilities_Entity extends Ups_Eu_Woo_Systems_Entity
{
    /* roles */

    public $role_ups_logistician = "ups_logistician";
    public $role_ups_logistician_title = "UPS Logistician";
    public $role_shop_manager = "shop_manager";
    public $role_shop_manager_title = "Shop Manager";
    public $role_administrator = "administrator";

    /* Capabilities */
    public $cap_manage_ups_module_settings = "manage_ups_module_settings";
    public $cap_manage_ups_shipments = "manage_ups_shipments";
    public $cap_manage_woocommerce = "manage_woocommerce";
    public $cap_read = "read";

    public function check_permision_module_settings()
    {
        if (current_user_can($this->cap_manage_ups_module_settings)) {
            return true;
        }
        if (current_user_can($this->role_administrator)) {
            return true;
        }
        return false;
    }

    public function check_permision_shipments()
    {
        if (current_user_can($this->cap_manage_ups_shipments)) {
            return true;
        }
        if (current_user_can($this->role_administrator)) {
            return true;
        }
        return false;
    }

    public function ups_eu_woo_activated_plugin()
    {
        remove_role($this->role_ups_logistician);
        $add_role_logistician = add_role(
            $this->role_ups_logistician,
            $this->role_ups_logistician_title,
            [
            $this->cap_read => true,
            $this->cap_manage_ups_module_settings => true,
            $this->cap_manage_ups_shipments => true,
            $this->cap_manage_woocommerce => true
            ]
        );
        $role_shop_manager = get_role($this->role_shop_manager);
        if ($role_shop_manager !== null) {
            $role_shop_manager->remove_cap($this->cap_manage_ups_module_settings);
            $role_shop_manager->add_cap($this->cap_manage_ups_module_settings);
            $role_shop_manager->remove_cap($this->cap_manage_ups_shipments);
            $role_shop_manager->add_cap($this->cap_manage_ups_shipments);
        }
        $role_administrator = get_role($this->role_administrator);
        if ($role_administrator !== null) {
            $role_administrator->remove_cap($this->cap_manage_ups_module_settings);
            $role_administrator->add_cap($this->cap_manage_ups_module_settings);
            $role_administrator->remove_cap($this->cap_manage_ups_shipments);
            $role_administrator->add_cap($this->cap_manage_ups_shipments);
        }
    }

    public function ups_eu_woo_deactivated_plugin()
    {
        remove_role($this->role_ups_logistician);
        $role_shop_manager = get_role($this->role_shop_manager);
        if ($role_shop_manager !== null) {
            $role_shop_manager->remove_cap($this->cap_manage_ups_module_settings);
            $role_shop_manager->remove_cap($this->cap_manage_ups_shipments);
        }
        $role_administrator = get_role($this->role_administrator);
        if ($role_administrator !== null) {
            $role_administrator->remove_cap($this->cap_manage_ups_module_settings);
            $role_administrator->remove_cap($this->cap_manage_ups_shipments);
        }
    }
}
