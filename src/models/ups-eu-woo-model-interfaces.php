<?php namespace UpsEuWoocommerce\models;

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
 * ups-eu-woo-model-interfaces.php - The core plugin class.
 *
 * This is used to define the Interfaces Model.
 */

interface Ups_Eu_Woo_Interfaces
{
    /*
     * Name function: save
     * Params: empty
     * Return: type boolean
     * * */

    public function ups_eu_woo_save();
    /*
     * Name function: ups_eu_woo_get_by_id
     * Params:
     *  @id: type int
     * Return: type object class
     * * */

    public function ups_eu_woo_get_by_id($id);
    /*
     * Name function: delete
     * Params:
     *  @id: type int
     * Return: type boolean
     * * */

    public function ups_eu_woo_delete($id);
    /*
     * Name function: validate
     * Params: empty
     * Return: type array or false
     * * */

    public function ups_eu_woo_validate();
    /*
     * Name function: get_list_data_by_condition
     * Params:
     *  @conditions: type array
     *  @limit: type string
     * Return: type array object
     * * */

    public function get_list_data_by_condition($conditions = [], $limit = '');
    /*
     * Name function: ups_eu_woo_merge_array
     * Params:
     *  @data: type array
     * Return: type object class
     * * */

    public function ups_eu_woo_merge_array($data);
    /*
     * Name function: ups_eu_woo_check_existing
     * Params: empty
     * Return: type boolean
     * * */

    public function ups_eu_woo_check_existing();
    /*
     * Name function: ups_eu_woo_get_table_name
     * Params: empty
     * Return: type string
     * * */

    public function ups_eu_woo_get_table_name();
}
