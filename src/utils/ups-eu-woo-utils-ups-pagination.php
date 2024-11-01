<?php namespace UpsEuWoocommerce\utils;

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
 * ups-eu-woo-utils-ups-pagination.php - The core plugin class.
 *
 * This is used to handle the Ups_Eu_Woo_Ups_Pagination.
 */

include_once(dirname(__FILE__, 2) . '/ups-eu-woo-autoloader.php');
new \UpsEuWoocommerce\Ups_Eu_Woo_Main_Autoloader('Ups_Eu_Woo_Ups_Pagination');

class Ups_Eu_Woo_Ups_Pagination extends \UpsEuWoocommerce\libsystems\Ups_Eu_Woo_Pagination
{

    public $resultsPerPage = 50;
    private $page_key = '__page';
    private $var_str_sort_by = 'sort_by';
    private $var_str_sort_type = 'sort_type';
    private $var_str_REQUEST_URI = 'REQUEST_URI';
    private $var_str_limit = 'limit';
    private $var_str_order = 'order';

    public function ups_eu_woo_build_lists($page)
    {
        $object_pagination = new \stdClass();
        $data = new \stdClass();
        $model_orders = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Orders();

        $currentPage = 0;
        if (!empty($_REQUEST[$this->page_key])) {
            $currentPage = intval(strip_tags($_REQUEST[$this->page_key]));
        }
        $order = [];
        if (array_key_exists($this->var_str_sort_by, $_REQUEST)) {
            $order = [
                $_REQUEST[$this->var_str_sort_by] => $_REQUEST[$this->var_str_sort_type]
            ];
        }
        $status = $model_orders->ups_eu_woo_get_status_order($page);
        $object_pagination->total = $model_orders->ups_eu_woo_count_data($page, $status);
        $object_pagination->url_open_orders = $this->ups_eu_woo_remove_param($_SERVER[$this->var_str_REQUEST_URI], $this->page_key);
        $object_pagination->currentPage = $currentPage;
        $object_pagination->resultsPerPage = $this->resultsPerPage;
        $object_pagination->html_pagination = $this->ups_eu_woo_paging(
            $object_pagination->total,
            $object_pagination->url_open_orders,
            $object_pagination->currentPage,
            $object_pagination->resultsPerPage
        );

        $data->list_main = $model_orders->ups_eu_woo_pagination_list_data($page, [
            'limit' => [$this->resultsPerPage, $currentPage],
            'order' => $order
        ]);
        $object_pagination->list_data = $data;

        return $object_pagination;
    }

    public function ups_eu_woo_remove_param($url, $param)
    {
        $url = preg_replace('/(&|\?)' . preg_quote($param) . '=[^&]*$/', '', $url);
        $url = preg_replace('/(&|\?)' . preg_quote($param) . '=[^&]*&/', '$1', $url);
        return $url;
    }

    public function ups_eu_woo_build_lists_logs_api()
    {
        $object_pagination = new \stdClass();
        $data = new \stdClass();
        $model_logs_api = new \UpsEuWoocommerce\models\Ups_Eu_Woo_Model_Logs_Api();

        $currentPage = 0;
        if (!empty($_REQUEST[$this->page_key])) {
            $currentPage = intval(strip_tags($_REQUEST[$this->page_key]));
        }
        $order = [];

        if (array_key_exists($this->var_str_sort_by, $_REQUEST)) {
            $order = [
                $_REQUEST[$this->var_str_sort_by] => $_REQUEST[$this->var_str_sort_type]
            ];
        }
        $object_pagination->total = $model_logs_api->ups_eu_woo_count_data();
        $object_pagination->url_about_logs_api = $this->ups_eu_woo_remove_param($_SERVER[$this->var_str_REQUEST_URI], $this->page_key);
        $object_pagination->currentPage = $currentPage;
        $object_pagination->resultsPerPage = $this->resultsPerPage;
        $object_pagination->html_pagination = $this->ups_eu_woo_paging(
            $object_pagination->total,
            $object_pagination->url_about_logs_api,
            $object_pagination->currentPage,
            $object_pagination->resultsPerPage
        );
        $data->list_main = $model_logs_api->ups_eu_woo_pagination_list_data([
            $this->var_str_limit => [$this->resultsPerPage, $currentPage],
            $this->var_str_order => $order
        ]);
        $object_pagination->list_data = $data;

        return $object_pagination;
    }
}
