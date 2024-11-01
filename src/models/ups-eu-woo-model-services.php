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
 * ups-eu-woo-model-services.php - The core plugin class.
 *
 * This is used to define the Ups_Eu_Woo_Model_Services Model.
 */

require_once(dirname(__FILE__, 2) . '/ups-eu-woo-autoloader.php');
new \UpsEuWoocommerce\Ups_Eu_Woo_Main_Autoloader('Ups_Eu_Woo_Model_Services');

class Ups_Eu_Woo_Model_Services extends entities\Ups_Eu_Woo_Services_Entity implements Ups_Eu_Woo_Interfaces
{
    private $table_name = "";
    private $key_id = "id";
    //------------atributes fields----------------
    public $id;
    public $country_code;
    public $service_type;
    public $service_key;
    public $service_key_delivery;
    public $service_key_val;
    public $service_name;
    public $rate_code;
    public $tin_t_code;
    public $service_selected;
    public $service_symbol;

    /*
     * Name function: __construct
     * Params: empty
     * Return: void
     * * */

    public function __construct()
    {
        parent::__construct();
        global $wpdb;
        $this->table_name = "{$wpdb->prefix}{$this->prefix_ups}services";
        $this->key_id = $this->col_id;
    }
    /*
     * Name function: ups_eu_woo_convert_to_array
     * Params: empty
     * Return: type array
     * * */

    public function ups_eu_woo_convert_to_array()
    {
        $tmpArray = [];
        $tmpArray[$this->col_id] = $this->id;
        $tmpArray[$this->col_country_code] = $this->country_code;
        $tmpArray[$this->col_service_type] = $this->service_type;
        $tmpArray[$this->col_service_key] = $this->service_key;
        $tmpArray[$this->col_service_key_delivery] = $this->service_key_delivery;
        $tmpArray[$this->col_service_key_val] = $this->service_key_val;
        $tmpArray[$this->col_service_name] = $this->service_name;
        $tmpArray[$this->col_rate_code] = $this->rate_code;
        $tmpArray[$this->col_tin_t_code] = $this->tin_t_code;
        $tmpArray[$this->col_service_selected] = $this->service_selected;
        $tmpArray[$this->col_service_symbol] = $this->service_symbol;
        return $tmpArray;
    }
    /*
     * Name function: save
     * Params: empty
     * Return: type boolean
     * * */

    public function ups_eu_woo_save()
    {
        /* check validate */
        if ($this->ups_eu_woo_validate() === true) {
            /* convert data to array */
            $dataArray = $this->ups_eu_woo_convert_to_array();
            /* save data to database */
            $check_save_id = $this->ups_eu_woo_base_save($dataArray, $this->table_name, $this->key_id);
            if ($check_save_id > 0) {
                /* set id after save it */
                $this->{$this->key_id} = $check_save_id;
                return true;
            }
            return false;
        }
        return false;
    }
    /*
     * Name function: ups_eu_woo_get_by_id
     * Params:
     *  @id: type int
     * Return: type boolean
     * * */

    public function ups_eu_woo_get_by_id($id)
    {
        $id = intval($id);
        if ($id > 0) {
            /* get data by id */
            $result_array = $this->ups_eu_woo_base_get_by_id($id, $this->table_name, $this->key_id);
            /* convert result data from array to object */
            $this->ups_eu_woo_base_convert_array_to_object($result_array, $this);
            return $this;
        }
        return false;
    }

    /*
     * Name function: ups_eu_woo_get_all
     * Params:
     *  @id: type int
     * Return: type array
     * * */
    public function ups_eu_woo_get_all()
    {
        return (array)$this->ups_eu_woo_base_get_all($this->table_name);
    }

    /*
     * Name function: get_list_data_by_condition
     * Params:
     *  @conditions: type array
     *  @limit: type string
     * Return: type array object or false
     * * */

    public function get_list_data_by_condition($conditions = [], $limit = 'all')
    {
        // Format conditions
        $conditionsFormat = [];
        foreach ($conditions as $key => $value) {
            $conditionsFormat[] = "`$key` = '$value'";
        }
        // Select and sort list service
        if (isset($conditions['country_code'])) {
            $result_services = [];
            if (isset($conditions['service_type'])) {
                $sorted_services = $this->ups_eu_woo_get_sorted_services($conditions['country_code'], $conditions['service_type']);
            } else {
                $sorted_services_ap = $this->ups_eu_woo_get_sorted_services($conditions['country_code'], 'AP');
                $sorted_services_add = $this->ups_eu_woo_get_sorted_services($conditions['country_code'], 'ADD');
                $sorted_services = array_merge($sorted_services_ap, $sorted_services_add);
            }
            $list_services = $this->ups_eu_woo_base_get_list_data_by_condition($this->table_name, $conditionsFormat, $limit);
            if (is_array($list_services) && !empty($list_services)
                && is_array($sorted_services) && !empty($sorted_services)) {
                foreach ($sorted_services as $service_key) {
                    $index = array_search($service_key, array_column($list_services, 'service_key'));
                    if ($index !== false) {
                        $result_services[] = $list_services[$index];
                    }
                }
            }
            return $result_services;
        } else {
            return $this->ups_eu_woo_base_get_list_data_by_condition($this->table_name, $conditionsFormat, $limit);
        }
    }
    /*
     * Name function: delete
     * Params:
     *  @id: int
     * Return: boolean
     * * */

    public function ups_eu_woo_delete($id)
    {
        $id = intval($id);
        if ($id > 0) {
            return $this->ups_eu_woo_base_delete($id, $this->table_name, $this->key_id);
        }
        return false;
    }
    /*
     * Name function: validate
     * Params: empty
     * Return: type array or false
     * * */

    public function ups_eu_woo_validate()
    {
        $tmpValidate = [];
        /* check validate country code is empty  */
        if (empty($this->country_code)) {
            $tmpValidate[$this->col_country_code][$this->msg_error] = __(
                "country_code is empty",
                \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain
            );
        }
        /* check validate service type is empty  */
        if (empty($this->service_type)) {
            $tmpValidate[$this->col_service_type][$this->msg_error] = __(
                "service_type is empty",
                \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain
            );
        }
        /* check validate service key is empty  */
        if (empty($this->service_key)) {
            $tmpValidate[$this->col_service_key][$this->msg_error] = __(
                "service_key is empty",
                \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain
            );
        }
        $result = true;
        if (count($tmpValidate) > 0) {
            $result = $tmpValidate;
        }
        return $result;
    }
    /*
     * Name function: ups_eu_woo_merge_array
     * Params:
     *  @data: type array
     * Return: type object
     * * */

    public function ups_eu_woo_merge_array($data)
    {
        $this->ups_eu_woo_base_convert_array_to_object($data, $this);
    }
    /*
     * Name function: ups_eu_woo_check_existing
     * Params:
     *  @conditions: type array
     * Return: type boolean
     * * */

    public function ups_eu_woo_check_existing($conditions = [])
    {
        return $this->ups_eu_woo_base_check_existing($this->table_name, $conditions);
    }
    /*
     * Name function: ups_eu_woo_check_validate_existing_list
     * Params:
     *  @service_type: type string
     *  @list_service: type array
     * Return: type boolean
     * * */

    private function ups_eu_woo_check_validate_existing_list($service_type = "AP", $list_service = array())
    {
        foreach ($list_service as $item) {
            if ($item && "{$item["{$this->col_service_type}"]}" === "{$service_type}") {
                if (!empty($item["{$this->col_service_selected}"])) {
                    $item["{$this->col_service_selected}"] = $item["{$this->col_service_selected}"];
                } else {
                    $item["{$this->col_service_selected}"] = "";
                }
                if ($item["{$this->col_service_selected}"] === "on") {
                    return true;
                }
            }
        }
        return false;
    }
    /*
     * Name function: ups_eu_woo_check_validate_before_save
     * Params:
     *  @DELIVERY_TO_ACCESS_POINT: type int
     *  @DELIVERY_TO_SHIPPING_ADDRESS: type int
     *  @list_service:type array
     * Return: type boolean
     * * */

    public function ups_eu_woo_check_validate_before_save($DELIVERY_TO_ACCESS_POINT, $DELIVERY_TO_SHIPPING_ADDRESS, $list_service)
    {
        $check_ap = true;
        $check_add = true;
        /* check delivery to access point and shipping to address is not equal 1 */
        if ($DELIVERY_TO_ACCESS_POINT !== 1 && $DELIVERY_TO_SHIPPING_ADDRESS !== 1) {
            return false;
        }
        /* check delivery to AP */
        if ($DELIVERY_TO_ACCESS_POINT === 1) {
            $check_ap = $this->ups_eu_woo_check_validate_existing_list("AP", $list_service);
        }
        /* validate AP list exist false */
        if ($check_ap === false) {
            return false;
        }
        /* check shipping to ADD */
        if ($DELIVERY_TO_SHIPPING_ADDRESS === 1) {
            $check_add = $this->ups_eu_woo_check_validate_existing_list("ADD", $list_service);
        }
        return $check_add;
    }
    /*
     * Name function: ups_eu_woo_check_show_service
     * Params:
     *  @list_service:type array
     *  @id_service: type int
     * Return: type boolean
     * * */

    private function ups_eu_woo_check_show_service($list_service, $id_service)
    {
        foreach ($list_service as $item) {
            if ($item) {
                if (intval($item["{$this->col_id}"]) === intval($id_service)) {
                    if (!empty($item["{$this->col_service_selected}"])) {
                        $item["{$this->col_service_selected}"] = $item["{$this->col_service_selected}"];
                    } else {
                        $item["{$this->col_service_selected}"] = "";
                    }
                    if ($item["{$this->col_service_selected}"] === "on") {
                        return true;
                    }
                }
            }
        }
        return false;
    }
    /*
     * Name function: ups_eu_woo_get_type_by_rate_code
     * Params:
     *  @rate_code:type int
     * Return: type string
     * * */

    public function ups_eu_woo_get_type_by_rate_code($rate_code)
    {
        $result = $this->ups_eu_woo_base_get_list_data_by_condition($this->table_name, ["{$this->col_rate_code}" => $rate_code], 1);
        $tmp_service_type = "";
        if ($result) {
            $tmp_service_type = $result[0]->service_type;
        }
        return $tmp_service_type;
    }
    /*
     * Name function: ups_eu_woo_get_type_by_id
     * Params:
     *  @id:type int
     * Return: type string
     * * */

    public function ups_eu_woo_get_type_by_id($id)
    {
        /* get list shipping service by conditions */
        $result = $this->ups_eu_woo_base_get_list_data_by_condition($this->table_name, ["{$this->col_id}" => $id], 1);
        /* Assigned variable is empty */
        $str_tmp = "";
        if ($result) {
            $str_tmp = $result[0]->service_type;
        }
        return $str_tmp;
    }

    /*
     * Name function: ups_eu_woo_get_list_by_service_type
     * Params:
     *  $country_code: string country code
     *  $service_type: string service type
     * Return: array list services
     * * */

    public function ups_eu_woo_get_list_by_service_type($country_code, $service_type)
    {
        $result_services = [];
        $sorted_services = $this->ups_eu_woo_get_sorted_services($country_code, $service_type);
        $list_services = $this->get_list_data_by_condition(
            [
                $this->col_country_code => $country_code,
                $this->col_service_type => $service_type
            ]
        );
        if (is_array($list_services) && !empty($list_services)
            && is_array($sorted_services) && !empty($sorted_services)) {
            foreach ($sorted_services as $service_key) {
                $index = array_search($service_key, array_column($list_services, 'service_key'));
                if ($index !== false) {
                    $result_services[] = $list_services[$index];
                }
            }
        }
        return $result_services;
    }
    /*
     * Name function: ups_eu_woo_init_params
     * Params:
     *  @model_config:type object classs
     *  @country_code: type string
     *  @dataObject: type object
     *  @configs: type object
     *  @ups_services: type string
     * Return: void
     * * */

    public function ups_eu_woo_init_params($model_config, $country_code, &$dataObject, $configs, $ups_services)
    {
        $dataObject->configs = new \stdClass();
        $dataObject->us_default = 1;
        $dataObject->us_country = strtolower($country_code);
        if ('us' != $dataObject->us_country) {
            $dataObject->us_default = 0;
        }
        // Get list service accept point
        $dataObject->list_data_acceptpoint  = $this->get_list_data_by_condition(
            [
                $this->col_country_code => $country_code,
                $this->col_service_type => 'AP'
            ]
        );

        // Get list service address delivery
        $dataObject->list_data_address_delivery  = $this->get_list_data_by_condition(
            [
                $this->col_country_code => $country_code,
                $this->col_service_type => 'ADD'
            ]
        );
        // has selected services then not us default
        foreach ($dataObject->list_data_acceptpoint as $item) {
            if (intval($item->service_selected) == 1) {
                $dataObject->us_default = 0;
                break;
            }
        }
        // has selected services then not us default
        foreach ($dataObject->list_data_address_delivery as $item) {
            if (intval($item->service_selected) == 1) {
                $dataObject->us_default = 0;
                break;
            }
        }

        if ($dataObject->mess_dont_check === "") {
            $dataObject->configs->DELIVERY_TO_ACCESS_POINT = "";
            if ($model_config->ups_eu_woo_get_by_key($model_config->DELIVERY_TO_ACCESS_POINT) === true) {
                $dataObject->configs->DELIVERY_TO_ACCESS_POINT = $model_config->value;
            }

            /* Set NUMBER_OF_ACCESS_POINT_AVAIABLE */
            $dataObject->configs->NUMBER_OF_ACCESS_POINT_AVAIABLE = "";
            if ($model_config->ups_eu_woo_get_by_key($model_config->NUMBER_OF_ACCESS_POINT_AVAIABLE) === true) {
                $dataObject->configs->NUMBER_OF_ACCESS_POINT_AVAIABLE = $model_config->value;
            }

            if (empty($dataObject->configs->NUMBER_OF_ACCESS_POINT_AVAIABLE)) {
                $dataObject->configs->NUMBER_OF_ACCESS_POINT_AVAIABLE = 5;
            }

            /* Set DISPLAY_ALL_ACCESS_POINT_IN_RANGE */
            $dataObject->configs->DISPLAY_ALL_ACCESS_POINT_IN_RANGE = "";
            if ($model_config->ups_eu_woo_get_by_key($model_config->DISPLAY_ALL_ACCESS_POINT_IN_RANGE) === true) {
                $dataObject->configs->DISPLAY_ALL_ACCESS_POINT_IN_RANGE = $model_config->value;
            }
            if (empty($dataObject->configs->DISPLAY_ALL_ACCESS_POINT_IN_RANGE)) {
                $dataObject->configs->DISPLAY_ALL_ACCESS_POINT_IN_RANGE = 10;
            }

            /* Set CHOOSE_ACCOUNT_NUMBER_AP */
            $dataObject->configs->CHOOSE_ACCOUNT_NUMBER_AP = "";
            if ($model_config->ups_eu_woo_get_by_key($model_config->CHOOSE_ACCOUNT_NUMBER_AP) === true) {
                $dataObject->configs->CHOOSE_ACCOUNT_NUMBER_AP = $model_config->value;
            }

            /* Set SET_DEFAULT */
            $dataObject->configs->SET_DEFAULT = "";
            if ($model_config->ups_eu_woo_get_by_key($model_config->SET_DEFAULT) === true) {
                $dataObject->configs->SET_DEFAULT = $model_config->value;
            }
            if ($dataObject->configs->SET_DEFAULT === "") {
                $dataObject->configs->SET_DEFAULT = 1;
            }

            /* Set AP_AS_SHIPTO */
            $dataObject->configs->AP_AS_SHIPTO = "";
            if ($model_config->ups_eu_woo_get_by_key($model_config->AP_AS_SHIPTO) === true) {
                $dataObject->configs->AP_AS_SHIPTO = $model_config->value;
            }
            if ($dataObject->configs->AP_AS_SHIPTO === "") {
                $dataObject->configs->AP_AS_SHIPTO = 0;
            }

            /* Set ADULT_SIGNATURE */
            $dataObject->configs->ADULT_SIGNATURE = "";
            if ($model_config->ups_eu_woo_get_by_key($model_config->ADULT_SIGNATURE) === true) {
                $dataObject->configs->ADULT_SIGNATURE = $model_config->value;
            }
            if ($dataObject->configs->ADULT_SIGNATURE === "") {
                $dataObject->configs->ADULT_SIGNATURE = 0;
            }

            /* Set DELIVERY_TO_SHIPPING_ADDRESS */
            $dataObject->configs->DELIVERY_TO_SHIPPING_ADDRESS = "";
            if ($model_config->ups_eu_woo_get_by_key($model_config->DELIVERY_TO_SHIPPING_ADDRESS) === true) {
                $dataObject->configs->DELIVERY_TO_SHIPPING_ADDRESS = $model_config->value;
            }
            /* Set CHOOSE_ACCOUNT_NUMBER_ADD */
            $dataObject->configs->CHOOSE_ACCOUNT_NUMBER_ADD = "";
            if ($model_config->ups_eu_woo_get_by_key($model_config->CHOOSE_ACCOUNT_NUMBER_ADD) === true) {
                $dataObject->configs->CHOOSE_ACCOUNT_NUMBER_ADD = $model_config->value;
            }

            /* Set CUT_OFF_TIME */
            if ($model_config->ups_eu_woo_get_by_key($model_config->CUT_OFF_TIME) === true) {
                $dataObject->configs->CUT_OFF_TIME = $model_config->value;
            } else {
                $dataObject->configs->CUT_OFF_TIME = "17";
            }
            if (strlen($dataObject->configs->CUT_OFF_TIME) < 2) {
                $dataObject->configs->CUT_OFF_TIME = trim("17");
            } else {
                $dataObject->configs->CUT_OFF_TIME = trim($dataObject->configs->CUT_OFF_TIME);
            }

            /* Set CUT_OFF_TIME */
            $dataObject->ACCEPT_SHIPPING_SERVICE = "";
            if ($model_config->ups_eu_woo_get_by_key($model_config->ACCEPT_SHIPPING_SERVICE) === true) {
                $dataObject->ACCEPT_SHIPPING_SERVICE = $model_config->value;
            }
        } else {
            foreach ($dataObject->list_data_acceptpoint as &$item) {
                if ($this->ups_eu_woo_check_show_service($ups_services, $item->id) === true) {
                    $item->service_selected = 1;
                } else {
                    $item->service_selected = 0;
                }
            }
            foreach ($dataObject->list_data_address_delivery as &$item) {
                if ($this->ups_eu_woo_check_show_service($ups_services, $item->id) === true) {
                    $item->service_selected = 1;
                } else {
                    $item->service_selected = 0;
                }
            }

            /* Set DELIVERY_TO_ACCESS_POINT */
            if (array_key_exists($model_config->DELIVERY_TO_ACCESS_POINT, $configs)) {
                $dataObject->configs->DELIVERY_TO_ACCESS_POINT = $configs[$model_config->DELIVERY_TO_ACCESS_POINT];
            } else {
                $dataObject->configs->DELIVERY_TO_ACCESS_POINT = 0;
            }

            /* Set NUMBER_OF_ACCESS_POINT_AVAIABLE */
            if (array_key_exists($model_config->NUMBER_OF_ACCESS_POINT_AVAIABLE, $configs)) {
                $dataObject->configs->NUMBER_OF_ACCESS_POINT_AVAIABLE = $configs[$model_config->NUMBER_OF_ACCESS_POINT_AVAIABLE];
            } else {
                $dataObject->configs->NUMBER_OF_ACCESS_POINT_AVAIABLE = 0;
            }

            /* Set DISPLAY_ALL_ACCESS_POINT_IN_RANGE */
            if (array_key_exists($model_config->DISPLAY_ALL_ACCESS_POINT_IN_RANGE, $configs)) {
                $dataObject->configs->DISPLAY_ALL_ACCESS_POINT_IN_RANGE = $configs[$model_config->DISPLAY_ALL_ACCESS_POINT_IN_RANGE];
            } else {
                $dataObject->configs->DISPLAY_ALL_ACCESS_POINT_IN_RANGE = 0;
            }

            /* Set CHOOSE_ACCOUNT_NUMBER_AP */
            if (array_key_exists($model_config->CHOOSE_ACCOUNT_NUMBER_AP, $configs)) {
                $dataObject->configs->CHOOSE_ACCOUNT_NUMBER_AP = $configs[$model_config->CHOOSE_ACCOUNT_NUMBER_AP];
            } else {
                $dataObject->configs->CHOOSE_ACCOUNT_NUMBER_AP = 0;
            }

            /* Set SET_DEFAULT */
            if (array_key_exists($model_config->SET_DEFAULT, $configs)) {
                $dataObject->configs->SET_DEFAULT = $configs[$model_config->SET_DEFAULT];
            } else {
                $dataObject->configs->SET_DEFAULT = 0;
            }

            /* Set ADULT_SIGNATURE */
            if (array_key_exists($model_config->ADULT_SIGNATURE, $configs)) {
                $dataObject->configs->ADULT_SIGNATURE = $configs[$model_config->ADULT_SIGNATURE];
            } else {
                $dataObject->configs->ADULT_SIGNATURE = 0;
            }

            /* Set DELIVERY_TO_SHIPPING_ADDRESS */
            if (array_key_exists($model_config->DELIVERY_TO_SHIPPING_ADDRESS, $configs)) {
                $dataObject->configs->DELIVERY_TO_SHIPPING_ADDRESS = $configs[$model_config->DELIVERY_TO_SHIPPING_ADDRESS];
            } else {
                $dataObject->configs->DELIVERY_TO_SHIPPING_ADDRESS = 0;
            }

            /* Set CHOOSE_ACCOUNT_NUMBER_ADD */
            if (array_key_exists($model_config->CHOOSE_ACCOUNT_NUMBER_ADD, $configs)) {
                $dataObject->configs->CHOOSE_ACCOUNT_NUMBER_ADD = $configs[$model_config->CHOOSE_ACCOUNT_NUMBER_ADD];
            } else {
                $dataObject->configs->CHOOSE_ACCOUNT_NUMBER_ADD = 0;
            }

            /* Set CUT_OFF_TIME */
            if (array_key_exists($model_config->CUT_OFF_TIME, $configs)) {
                $dataObject->configs->CUT_OFF_TIME = $configs[$model_config->CUT_OFF_TIME];
            } else {
                $dataObject->configs->CUT_OFF_TIME = 0;
            }
            if (empty($configs[$model_config->ACCEPT_SHIPPING_SERVICE])) {
                $dataObject->ACCEPT_SHIPPING_SERVICE = 0;
            } else {
                $dataObject->ACCEPT_SHIPPING_SERVICE = 1;
            }
        }

        /** handling show */
        $isShowNoteApExpedited  = false;
        $isShowNoteADDExpedited = false;
        $isShowNoteApExpeditedUSToUS  = false;
        $isShowNoteApExpeditedUSToInternational  = false;
        $isShowNoteADDExpeditedUSToUS = false;
        $isShowNoteADDExpeditedUSToInternational = false;
        $isCountryCode = '';

        $arrServiceKeyAp = [
            'UPS_SP_SERV_PL_AP_EXPEDITED',
            'UPS_SP_SERV_GB_AP_EXPEDITED',
            'UPS_SP_SERV_DE_AP_EXPEDITED',
            'UPS_SP_SERV_ES_AP_EXPEDITED',
            'UPS_SP_SERV_IT_AP_EXPEDITED',
            'UPS_SP_SERV_FR_AP_EXPEDITED',
            'UPS_SP_SERV_NL_AP_EXPEDITED',
            'UPS_SP_SERV_BE_AP_EXPEDITED',
            'UPS_SP_SERV_AT_AP_EXPEDITED',
            'UPS_SP_SERV_BG_AP_EXPEDITED',
            'UPS_SP_SERV_HR_AP_EXPEDITED',
            'UPS_SP_SERV_CY_AP_EXPEDITED',
            'UPS_SP_SERV_CZ_AP_EXPEDITED',
            'UPS_SP_SERV_DK_AP_EXPEDITED',
            'UPS_SP_SERV_EE_AP_EXPEDITED',
            'UPS_SP_SERV_FI_AP_EXPEDITED',
            'UPS_SP_SERV_GR_AP_EXPEDITED',
            'UPS_SP_SERV_HU_AP_EXPEDITED',
            'UPS_SP_SERV_IE_AP_EXPEDITED',
            'UPS_SP_SERV_LV_AP_EXPEDITED',
            'UPS_SP_SERV_LT_AP_EXPEDITED',
            'UPS_SP_SERV_LU_AP_EXPEDITED',
            'UPS_SP_SERV_MT_AP_EXPEDITED',
            'UPS_SP_SERV_PT_AP_EXPEDITED',
            'UPS_SP_SERV_RO_AP_EXPEDITED',
            'UPS_SP_SERV_SK_AP_EXPEDITED',
            'UPS_SP_SERV_SI_AP_EXPEDITED',
            'UPS_SP_SERV_SE_AP_EXPEDITED',
            'UPS_SP_SERV_NO_AP_EXPEDITED',
            'UPS_SP_SERV_RS_AP_EXPEDITED',
            'UPS_SP_SERV_CH_AP_EXPEDITED',
            'UPS_SP_SERV_IS_AP_EXPEDITED',
            'UPS_SP_SERV_JE_AP_EXPEDITED',
            'UPS_SP_SERV_TR_AP_EXPEDITED',
        ];

        $arrServiceKeyAdd = [
            'UPS_SP_SERV_PL_ADD_EXPEDITED',
            'UPS_SP_SERV_GB_ADD_EXPEDITED',
            'UPS_SP_SERV_DE_ADD_EXPEDITED',
            'UPS_SP_SERV_ES_ADD_EXPEDITED',
            'UPS_SP_SERV_IT_ADD_EXPEDITED',
            'UPS_SP_SERV_FR_ADD_EXPEDITED',
            'UPS_SP_SERV_NL_ADD_EXPEDITED',
            'UPS_SP_SERV_BE_ADD_EXPEDITED',
            'UPS_SP_SERV_AT_ADD_EXPEDITED',
            'UPS_SP_SERV_BG_ADD_EXPEDITED',
            'UPS_SP_SERV_HR_ADD_EXPEDITED',
            'UPS_SP_SERV_CY_ADD_EXPEDITED',
            'UPS_SP_SERV_CZ_ADD_EXPEDITED',
            'UPS_SP_SERV_DK_ADD_EXPEDITED',
            'UPS_SP_SERV_EE_ADD_EXPEDITED',
            'UPS_SP_SERV_FI_ADD_EXPEDITED',
            'UPS_SP_SERV_GR_ADD_EXPEDITED',
            'UPS_SP_SERV_HU_ADD_EXPEDITED',
            'UPS_SP_SERV_IE_ADD_EXPEDITED',
            'UPS_SP_SERV_LV_ADD_EXPEDITED',
            'UPS_SP_SERV_LT_ADD_EXPEDITED',
            'UPS_SP_SERV_LU_ADD_EXPEDITED',
            'UPS_SP_SERV_MT_ADD_EXPEDITED',
            'UPS_SP_SERV_PT_ADD_EXPEDITED',
            'UPS_SP_SERV_RO_ADD_EXPEDITED',
            'UPS_SP_SERV_SK_ADD_EXPEDITED',
            'UPS_SP_SERV_SI_ADD_EXPEDITED',
            'UPS_SP_SERV_SE_ADD_EXPEDITED',
            'UPS_SP_SERV_NO_ADD_EXPEDITED',
            'UPS_SP_SERV_RS_ADD_EXPEDITED',
            'UPS_SP_SERV_CH_ADD_EXPEDITED',
            'UPS_SP_SERV_IS_ADD_EXPEDITED',
            'UPS_SP_SERV_JE_ADD_EXPEDITED',
            'UPS_SP_SERV_TR_ADD_EXPEDITED',
        ];

        $arrServiceKeyApUSToInternational = [
            'UPS_SP_SERV_US_AP_STANDARD',
            'UPS_SP_SERV_US_AP_EXPRESS_WORLDWIDE_SAVER',
            'UPS_SP_SERV_US_AP_EXPRESS_WORLDWIDE_EXPEDITED',
            'UPS_SP_SERV_US_AP_EXPRESS_WORLDWIDE_EXPRESS',
            'UPS_SP_SERV_US_AP_EXPRESS_WORLDWIDE_EXPRESS_PLUS'
        ];

        $arrServiceKeyApUSToUS = [
            'UPS_SP_SERV_US_AP_GROUND',
            'UPS_SP_SERV_US_AP_3_DAY_SELECT',
            'UPS_SP_SERV_US_AP_2ND_DAY_AIR',
            'UPS_SP_SERV_US_AP_2ND_DAY_AIR_AM',
            'UPS_SP_SERV_US_AP_NEXT_DAY_AIR_SAVER',
            'UPS_SP_SERV_US_AP_NEXT_DAY_AIR',
            'UPS_SP_SERV_US_AP_NEXT_DAY_AIR_EARLY'
        ];

        $arrServiceKeyAddUSToInternational = [
            'UPS_SP_SERV_US_ADD_STANDARD',
            'UPS_SP_SERV_US_ADD_EXPRESS_WORLDWIDE_SAVER',
            'UPS_SP_SERV_US_ADD_EXPRESS_WORLDWIDE_EXPEDITED',
            'UPS_SP_SERV_US_ADD_EXPRESS_WORLDWIDE_EXPRESS',
            'UPS_SP_SERV_US_ADD_EXPRESS_WORLDWIDE_EXPRESS_PLUS'
        ];

        $arrServiceKeyAddUSToUS = [
            'UPS_SP_SERV_US_ADD_GROUND',
            'UPS_SP_SERV_US_ADD_3_DAY_SELECT',
            'UPS_SP_SERV_US_ADD_2ND_DAY_AIR',
            'UPS_SP_SERV_US_ADD_2ND_DAY_AIR_AM',
            'UPS_SP_SERV_US_ADD_NEXT_DAY_AIR_SAVER',
            'UPS_SP_SERV_US_ADD_NEXT_DAY_AIR',
            'UPS_SP_SERV_US_ADD_NEXT_DAY_AIR_EARLY'
        ];

        foreach ($dataObject->list_data_acceptpoint as &$value) {
            if (in_array($value->service_key, $arrServiceKeyAp)) {
                $isShowNoteApExpedited = $value->service_key;
            }
        }
        foreach ($dataObject->list_data_address_delivery as &$value) {
            if (in_array($value->service_key, $arrServiceKeyAdd)) {
                $isShowNoteADDExpedited = $value->service_key;
            }
        }

        $dataObject->isShowNoteApExpedited = $isShowNoteApExpedited;
        $dataObject->isShowNoteADDExpedited = $isShowNoteADDExpedited;
        $dataObject->isShowNoteApExpeditedUSToUS = $arrServiceKeyApUSToUS;
        $dataObject->isShowNoteApExpeditedUSToInternational = $arrServiceKeyApUSToInternational;
        $dataObject->isShowNoteADDExpeditedUSToUS = $arrServiceKeyAddUSToUS;
        $dataObject->isShowNoteADDExpeditedUSToInternational = $arrServiceKeyAddUSToInternational;
        $dataObject->isCountryCode = $country_code;
    }
    /*
     * Name function: ups_eu_woo_get_price_service
     * Params:
     *  @service_id:type int
     *  @$api_monetary_value: type float
     *  @$total_order: type float
     *  @$api_currency_code: type string
     *  @$currency_shop: type string
     *  @$config_currency_opnecart: type string
     * Return: type string
     * * */

    public function ups_eu_woo_get_price_service(
        $service_id,
        $api_monetary_value,
        $total_order,
        $api_currency_code,
        $currency_shop,
        $config_currency_opnecart
    ) {
        $model_currency = new Ups_Eu_Woo_Currency(new Ups_Eu_Woo_Model_Config());
        $model_delivery_rates = new Ups_Eu_Woo_Delivery_Rates();

        $api_monetary_value = floatval($api_monetary_value);

        //$all_plugins = apply_filters('active_plugins', get_option('active_plugins'));
        //$check_plugin_currency = array_search('woo-currency/wcu.php', $all_plugins,false);
        //if ($check_plugin_currency) {
        $options = get_option('wcu_options');
        if (!empty($options['options']['convert_checkout'])) {

            $api_monetary_value_convert = $api_monetary_value;
        } else {
            $api_monetary_value_convert = $model_currency->ups_eu_woo_convert_currency(
                $api_currency_code,
                $config_currency_opnecart,
                $api_monetary_value
            );
        }

        $total_order = floatval($total_order);
        $total_order_convert = $model_currency->ups_eu_woo_convert_currency(
            $api_currency_code,
            $config_currency_opnecart,
            $total_order
        );
        /* weight based order value base flate rate*/
        $shipping_country =WC()->customer->get_shipping_country();
        $session_pack = \WC()->session->get('package_type');
        $total_weight = 0;
        if (isset($session_pack[0])) {
            foreach ($session_pack as $key => $s_pack) {
                $total_weight += isset($s_pack->weight) ? $s_pack->weight : 0;
            }
        } elseif (isset($session_pack['weight'])) {
            $total_weight = $session_pack['weight'];
        }
        $list_delivery_by_service = $model_delivery_rates->ups_eu_woo_get_min_max_delivery_by_service_id($service_id);
        $price = 0;
        
        if (count($list_delivery_by_service) === 1) {
            $item_delivery = $list_delivery_by_service[0];
            switch ($item_delivery->rate_type) {
                case 1:
                    if (!empty($item_delivery->rate_country) && !empty($item_delivery->rate_rule)) {
                        if($item_delivery->rate_country == $shipping_country){
                            if($item_delivery->rate_rule == "ov"){
                                $check_val = $total_order;
                            }elseif($item_delivery->rate_rule == "wb"){
                                $check_val = $total_weight;
                            }else{
                                break;
                            }
                            if($item_delivery->min_order_value >= $check_val){
                                $price = $item_delivery->delivery_rate;
                                break;
                            }else{
                                break;
                            }                               
                        } elseif($item_delivery->rate_country == "all" ){
                            if($item_delivery->rate_rule == "ov"){
                                $check_val = $total_order;
                            }elseif($item_delivery->rate_rule == "wb"){
                                $check_val = $total_weight;
                            }else{
                                break;
                            }
                            if($item_delivery->min_order_value >= $check_val){
                                $price = $item_delivery->delivery_rate;
                                break;
                            }else{
                                break;
                            }    
                        } else{
                            break;
                        }
                    } else {
                        $price = $this->ups_eu_woo_get_price($item_delivery, $total_order_convert);
                        break;  
                    }
                case 2:
                    
                    $price = (floatval($item_delivery->delivery_rate) * $api_monetary_value_convert) / 100;
                    break;
                default:
                    break;
            }
        } else {
            $con_found = false;
            $last_threshold = 0;
            foreach ($list_delivery_by_service as $item_delivery) {
                if (!empty(array_column($list_delivery_by_service, "rate_country"))  && !empty(array_column($list_delivery_by_service,"rate_rule"))) {
                    if($item_delivery->rate_country == $shipping_country){
                    
                        if($item_delivery->rate_rule == "ov"){
                            $check_val = $total_order;
                        }elseif($item_delivery->rate_rule == "wb"){
                            $check_val = $total_weight;
                        }else{
                            continue;
                        }

                        if(($item_delivery->min_order_value >= $check_val) && ($last_threshold == 0 || $last_threshold >= $item_delivery->min_order_value)){
                            $price = $item_delivery->delivery_rate;
                            $con_found = true;
                            $last_threshold = $item_delivery->min_order_value;
                        }   
                    }elseif($item_delivery->rate_country == "all" ){
                    
                        if($item_delivery->rate_rule == "ov"){
                            $check_val = $total_order;
                        }elseif($item_delivery->rate_rule == "wb"){
                            $check_val = $total_weight;
                        }else{
                            continue;
                        }
                        
                        if(!$con_found && ($item_delivery->min_order_value >= $check_val) && ($last_threshold == 0 || $last_threshold >= $item_delivery->min_order_value)){
                            $price = $item_delivery->delivery_rate;
                            $last_threshold = $item_delivery->min_order_value;
                        }   
                    } 
                } else {
                    if ($total_order <= $item_delivery->min_order_value) {
                        $price = $item_delivery->delivery_rate;
                        break;
                    }else{
                        break;
                    } 
                }
            }       
            
        }
        // $price_tax = $this->tax_calculation($price);
        $price_convert = $model_currency->ups_eu_woo_convert_currency($config_currency_opnecart, $currency_shop, $price);
        return $price_convert;
    }
    /*
    tax calculation
    */
    public function tax_calculation($price)
    {
        $zones = \WC_Shipping_Zones::get_zones();
        $shipping_methods = array_column( $zones, 'shipping_methods' );
        $tax_status ='None';
       
        if (!empty($shipping_methods) && isset($shipping_methods[0])) {
            foreach ( $shipping_methods[0] as $key => $class ) {
                if ((string)$class->id == "ups_eu_shipping" && isset($class->instance_settings['tax_status'])) {
                    $tax_status = !empty($class->instance_settings['tax_status']) ? $class->instance_settings['tax_status'] : "None";
                }
            }
        }
        
        $controler = new \UpsEuWoocommerce\controllers\admin\Ups_Eu_Woo_Config_Account();
        $ups_country = $controler->ups_eu_woo_config_account();
        $country_code = $ups_country->list_accouts;
        $tax_country = '';
        foreach($country_code as $country_code){
            if ($country_code->account_default == 1) {
                $tax_country = $country_code->country;
            }
        }
        if(!empty($tax_status) && $tax_status != "None"){
            $taxes = ($tax_status != 'None') ? \WC_Tax::get_rates_for_tax_class( $tax_status) : [];
            $tax_rate = 0;
            $country_found = false;
            $tax_rate_found = false;
            foreach($taxes as $taxe){
                if (!$country_found && !$tax_rate_found && empty($taxe->tax_rate_country)&& $taxe->tax_rate_shipping == 1){
                    $tax_rate = $taxe->tax_rate;
                    $tax_rate_found = true;
                } elseif (!$country_found && ($taxe->tax_rate_country == $tax_country)&& ($taxe->tax_rate_shipping == 1)) {
                    $tax_rate = $taxe->tax_rate;
                    $country_found = true;
                    $tax_rate_found = true;
                    break;
                }
            }
            $tax = $price * $tax_rate/100;
            $price = $price + $tax;
        }
        return $price;
    }
    /*
     * Name function: ups_eu_woo_get_price
     * Params:
     *  @$item_delivery:type object
     *  @$total_order_convert: type float
     * Return: type string
     * * */

    private function ups_eu_woo_get_price($item_delivery, $total_order_convert)
    {
         
        $min_order_value = 0;
        if (!empty($item_delivery->min_order_value)) {
            $min_order_value = $item_delivery->min_order_value;
        }
        switch ($item_delivery->min_order_value) {
            case 0:
                $price = $item_delivery->delivery_rate;
                break;
            default:
                if ($total_order_convert <= $item_delivery->min_order_value) {
                    $price = $item_delivery->delivery_rate;
                } else {
                    $price = 0;
                }
                break;
        }

        return $price;
    }
    /*
     * Name function: ups_eu_woo_get_table_name
     * Params: empty
     * Return: type string
     * * */

    public function ups_eu_woo_get_table_name()
    {
        return $this->table_name;
    }

    /**
     * Name function: ups_eu_woo_get_sorted_services
     * UPS <noreply@ups.com>
     *
     * @param $country_code Country Code
     * @param $service_type Service Type
     *
     * @return string|array $services
     */
    public function ups_eu_woo_get_sorted_services($country_code = null, $service_type = null)
    {
        $services = [];

        $services['PL']['AP'][] = 'UPS_SP_SERV_PL_AP_AP_ECONOMY';
        $services['PL']['AP'][] = 'UPS_SP_SERV_PL_AP_STANDARD';
        $services['PL']['AP'][] = 'UPS_SP_SERV_PL_AP_STANDARD_SAT_DELI';
        $services['PL']['AP'][] = 'UPS_SP_SERV_PL_AP_EXPEDITED';
        $services['PL']['AP'][] = 'UPS_SP_SERV_PL_AP_EXPRESS_SAVER';
        $services['PL']['AP'][] = 'UPS_SP_SERV_PL_AP_EXPRESS';
        $services['PL']['AP'][] = 'UPS_SP_SERV_PL_AP_EXPRESS_SAT_DELI';
        $services['PL']['AP'][] = 'UPS_SP_SERV_PL_AP_EXPRESS_PLUS';

        $services['PL']['ADD'][] = 'UPS_SP_SERV_PL_ADD_STANDARD';
        $services['PL']['ADD'][] = 'UPS_SP_SERV_PL_ADD_STANDARD_SAT_DELI';
        $services['PL']['ADD'][] = 'UPS_SP_SERV_PL_ADD_EXPEDITED';
        $services['PL']['ADD'][] = 'UPS_SP_SERV_PL_ADD_EXPRESS_SAVER';
        $services['PL']['ADD'][] = 'UPS_SP_SERV_PL_ADD_EXPRESS';
        $services['PL']['ADD'][] = 'UPS_SP_SERV_PL_ADD_EXPRESS_SAT_DELI';
        $services['PL']['ADD'][] = 'UPS_SP_SERV_PL_ADD_EXPRESS_PLUS';

        $services['GB']['AP'][] = 'UPS_SP_SERV_GB_AP_STANDARD';
        $services['GB']['AP'][] = 'UPS_SP_SERV_GB_AP_STANDARD_SAT_DELI';
        $services['GB']['AP'][] = 'UPS_SP_SERV_GB_AP_EXPEDITED';
        $services['GB']['AP'][] = 'UPS_SP_SERV_GB_AP_WW_SAVER';
        $services['GB']['AP'][] = 'UPS_SP_SERV_GB_AP_EXPRESS';
        $services['GB']['AP'][] = 'UPS_SP_SERV_GB_AP_EXPRESS_SAT_DELI';
        $services['GB']['AP'][] = 'UPS_SP_SERV_GB_AP_WW_EXPRESS_PLUS';

        $services['GB']['ADD'][] = 'UPS_SP_SERV_GB_ADD_STANDARD';
        $services['GB']['ADD'][] = 'UPS_SP_SERV_GB_ADD_STANDARD_SAT_DELI';
        $services['GB']['ADD'][] = 'UPS_SP_SERV_GB_ADD_EXPEDITED';
        $services['GB']['ADD'][] = 'UPS_SP_SERV_GB_ADD_WW_SAVER';
        $services['GB']['ADD'][] = 'UPS_SP_SERV_GB_ADD_EXPRESS';
        $services['GB']['ADD'][] = 'UPS_SP_SERV_GB_ADD_EXPRESS_SAT_DELI';
        $services['GB']['ADD'][] = 'UPS_SP_SERV_GB_ADD_WW_EXPRESS_PLUS';

        $services['FR']['AP'][] = 'UPS_SP_SERV_FR_AP_AP_ECONOMY';
        $services['FR']['AP'][] = 'UPS_SP_SERV_FR_AP_STANDARD';
        $services['FR']['AP'][] = 'UPS_SP_SERV_FR_AP_STANDARD_SAT_DELI';
        $services['FR']['AP'][] = 'UPS_SP_SERV_FR_AP_EXPEDITED';
        $services['FR']['AP'][] = 'UPS_SP_SERV_FR_AP_EXPRESS_SAVER';
        $services['FR']['AP'][] = 'UPS_SP_SERV_FR_AP_EXPRESS';
        $services['FR']['AP'][] = 'UPS_SP_SERV_FR_AP_EXPRESS_SAT_DELI';
        $services['FR']['AP'][] = 'UPS_SP_SERV_FR_AP_EXPRESS_PLUS';

        $services['FR']['ADD'][] = 'UPS_SP_SERV_FR_ADD_STANDARD';
        $services['FR']['ADD'][] = 'UPS_SP_SERV_FR_ADD_STANDARD_SAT_DELI';
        $services['FR']['ADD'][] = 'UPS_SP_SERV_FR_ADD_EXPEDITED';
        $services['FR']['ADD'][] = 'UPS_SP_SERV_FR_ADD_EXPRESS_SAVER';
        $services['FR']['ADD'][] = 'UPS_SP_SERV_FR_ADD_EXPRESS';
        $services['FR']['ADD'][] = 'UPS_SP_SERV_FR_ADD_EXPRESS_SAT_DELI';
        $services['FR']['ADD'][] = 'UPS_SP_SERV_FR_ADD_EXPRESS_PLUS';

        $services['DE']['AP'][] = 'UPS_SP_SERV_DE_AP_STANDARD';
        $services['DE']['AP'][] = 'UPS_SP_SERV_DE_AP_STANDARD_SAT_DELI';
        $services['DE']['AP'][] = 'UPS_SP_SERV_DE_AP_EXPRESS_12H';
        $services['DE']['AP'][] = 'UPS_SP_SERV_DE_AP_EXPEDITED';
        $services['DE']['AP'][] = 'UPS_SP_SERV_DE_AP_EXPRESS_SAVER';
        $services['DE']['AP'][] = 'UPS_SP_SERV_DE_AP_EXPRESS_MIDDAY';
        $services['DE']['AP'][] = 'UPS_SP_SERV_DE_AP_EXPRESS';
        $services['DE']['AP'][] = 'UPS_SP_SERV_DE_AP_EXPRESS_SAT_DELI';
        $services['DE']['AP'][] = 'UPS_SP_SERV_DE_AP_EXPRESS_PLUS';

        $services['DE']['ADD'][] = 'UPS_SP_SERV_DE_ADD_STANDARD';
        $services['DE']['ADD'][] = 'UPS_SP_SERV_DE_ADD_STANDARD_SAT_DELI';
        $services['DE']['ADD'][] = 'UPS_SP_SERV_DE_ADD_EXPRESS_12H';
        $services['DE']['ADD'][] = 'UPS_SP_SERV_DE_ADD_EXPEDITED';
        $services['DE']['ADD'][] = 'UPS_SP_SERV_DE_ADD_EXPRESS_SAVER';
        $services['DE']['ADD'][] = 'UPS_SP_SERV_DE_ADD_EXPRESS_MIDDAY';
        $services['DE']['ADD'][] = 'UPS_SP_SERV_DE_ADD_EXPRESS';
        $services['DE']['ADD'][] = 'UPS_SP_SERV_DE_ADD_EXPRESS_SAT_DELI';
        $services['DE']['ADD'][] = 'UPS_SP_SERV_DE_ADD_EXPRESS_PLUS';

        $services['ES']['AP'][] = 'UPS_SP_SERV_ES_AP_STANDARD';
        $services['ES']['AP'][] = 'UPS_SP_SERV_ES_AP_STANDARD_SAT_DELI';
        $services['ES']['AP'][] = 'UPS_SP_SERV_ES_AP_EXPEDITED';
        $services['ES']['AP'][] = 'UPS_SP_SERV_ES_AP_EXPRESS_SAVER';
        $services['ES']['AP'][] = 'UPS_SP_SERV_ES_AP_EXPRESS';
        $services['ES']['AP'][] = 'UPS_SP_SERV_ES_AP_EXPRESS_SAT_DELI';
        $services['ES']['AP'][] = 'UPS_SP_SERV_ES_AP_EXPRESS_PLUS';

        $services['ES']['ADD'][] = 'UPS_SP_SERV_ES_ADD_STANDARD';
        $services['ES']['ADD'][] = 'UPS_SP_SERV_ES_ADD_STANDARD_SAT_DELI';
        $services['ES']['ADD'][] = 'UPS_SP_SERV_ES_ADD_EXPEDITED';
        $services['ES']['ADD'][] = 'UPS_SP_SERV_ES_ADD_EXPRESS_SAVER';
        $services['ES']['ADD'][] = 'UPS_SP_SERV_ES_ADD_EXPRESS';
        $services['ES']['ADD'][] = 'UPS_SP_SERV_ES_ADD_EXPRESS_SAT_DELI';
        $services['ES']['ADD'][] = 'UPS_SP_SERV_ES_ADD_EXPRESS_PLUS';

        $services['IT']['AP'][] = 'UPS_SP_SERV_IT_AP_STANDARD';
        $services['IT']['AP'][] = 'UPS_SP_SERV_IT_AP_STANDARD_SAT_DELI';
        $services['IT']['AP'][] = 'UPS_SP_SERV_IT_AP_EXPEDITED';
        $services['IT']['AP'][] = 'UPS_SP_SERV_IT_AP_EXPRESS_SAVER';
        $services['IT']['AP'][] = 'UPS_SP_SERV_IT_AP_EXPRESS';
        $services['IT']['AP'][] = 'UPS_SP_SERV_IT_AP_EXPRESS_SAT_DELI';
        $services['IT']['AP'][] = 'UPS_SP_SERV_IT_AP_EXPRESS_PLUS';

        $services['IT']['ADD'][] = 'UPS_SP_SERV_IT_ADD_STANDARD';
        $services['IT']['ADD'][] = 'UPS_SP_SERV_IT_ADD_STANDARD_SAT_DELI';
        $services['IT']['ADD'][] = 'UPS_SP_SERV_IT_ADD_EXPEDITED';
        $services['IT']['ADD'][] = 'UPS_SP_SERV_IT_ADD_EXPRESS_SAVER';
        $services['IT']['ADD'][] = 'UPS_SP_SERV_IT_ADD_EXPRESS';
        $services['IT']['ADD'][] = 'UPS_SP_SERV_IT_ADD_EXPRESS_SAT_DELI';
        $services['IT']['ADD'][] = 'UPS_SP_SERV_IT_ADD_EXPRESS_PLUS';

        $services['NL']['AP'][] = 'UPS_SP_SERV_NL_AP_AP_ECONOMY';
        $services['NL']['AP'][] = 'UPS_SP_SERV_NL_AP_STANDARD';
        $services['NL']['AP'][] = 'UPS_SP_SERV_NL_AP_STANDARD_SAT_DELI';
        $services['NL']['AP'][] = 'UPS_SP_SERV_NL_AP_EXPEDITED';
        $services['NL']['AP'][] = 'UPS_SP_SERV_NL_AP_EXPRESS_SAVER';
        $services['NL']['AP'][] = 'UPS_SP_SERV_NL_AP_EXPRESS';
        $services['NL']['AP'][] = 'UPS_SP_SERV_NL_AP_EXPRESS_SAT_DELI';
        $services['NL']['AP'][] = 'UPS_SP_SERV_NL_AP_EXPRESS_PLUS';

        $services['NL']['ADD'][] = 'UPS_SP_SERV_NL_ADD_STANDARD';
        $services['NL']['ADD'][] = 'UPS_SP_SERV_NL_ADD_STANDARD_SAT_DELI';
        $services['NL']['ADD'][] = 'UPS_SP_SERV_NL_ADD_EXPEDITED';
        $services['NL']['ADD'][] = 'UPS_SP_SERV_NL_ADD_EXPRESS_SAVER';
        $services['NL']['ADD'][] = 'UPS_SP_SERV_NL_ADD_EXPRESS';
        $services['NL']['ADD'][] = 'UPS_SP_SERV_NL_ADD_EXPRESS_SAT_DELI';
        $services['NL']['ADD'][] = 'UPS_SP_SERV_NL_ADD_EXPRESS_PLUS';

        $services['BE']['AP'][] = 'UPS_SP_SERV_BE_AP_AP_ECONOMY';
        $services['BE']['AP'][] = 'UPS_SP_SERV_BE_AP_STANDARD';
        $services['BE']['AP'][] = 'UPS_SP_SERV_BE_AP_STANDARD_SAT_DELI';
        $services['BE']['AP'][] = 'UPS_SP_SERV_BE_AP_EXPEDITED';
        $services['BE']['AP'][] = 'UPS_SP_SERV_BE_AP_EXPRESS_SAVER';
        $services['BE']['AP'][] = 'UPS_SP_SERV_BE_AP_EXPRESS';
        $services['BE']['AP'][] = 'UPS_SP_SERV_BE_AP_EXPRESS_SAT_DELI';
        $services['BE']['AP'][] = 'UPS_SP_SERV_BE_AP_EXPRESS_PLUS';

        $services['BE']['ADD'][] = 'UPS_SP_SERV_BE_ADD_STANDARD';
        $services['BE']['ADD'][] = 'UPS_SP_SERV_BE_ADD_STANDARD_SAT_DELI';
        $services['BE']['ADD'][] = 'UPS_SP_SERV_BE_ADD_EXPEDITED';
        $services['BE']['ADD'][] = 'UPS_SP_SERV_BE_ADD_EXPRESS_SAVER';
        $services['BE']['ADD'][] = 'UPS_SP_SERV_BE_ADD_EXPRESS';
        $services['BE']['ADD'][] = 'UPS_SP_SERV_BE_ADD_EXPRESS_SAT_DELI';
        $services['BE']['ADD'][] = 'UPS_SP_SERV_BE_ADD_EXPRESS_PLUS';

        $services['US']['AP'][] = 'UPS_SP_SERV_US_AP_GROUND';
        $services['US']['AP'][] = 'UPS_SP_SERV_US_AP_3_DAY_SELECT';
        $services['US']['AP'][] = 'UPS_SP_SERV_US_AP_2ND_DAY_AIR';
        $services['US']['AP'][] = 'UPS_SP_SERV_US_AP_2ND_DAY_AIR_AM';
        $services['US']['AP'][] = 'UPS_SP_SERV_US_AP_NEXT_DAY_AIR_SAVER';
        $services['US']['AP'][] = 'UPS_SP_SERV_US_AP_NEXT_DAY_AIR';
        $services['US']['AP'][] = 'UPS_SP_SERV_US_AP_NEXT_DAY_AIR_EARLY';
        $services['US']['AP'][] = 'UPS_SP_SERV_US_AP_STANDARD';
        $services['US']['AP'][] = 'UPS_SP_SERV_US_AP_EXPRESS_WORLDWIDE_EXPEDITED';
        $services['US']['AP'][] = 'UPS_SP_SERV_US_AP_EXPRESS_WORLDWIDE_SAVER';
        $services['US']['AP'][] = 'UPS_SP_SERV_US_AP_EXPRESS_WORLDWIDE_EXPRESS';
        $services['US']['AP'][] = 'UPS_SP_SERV_US_AP_EXPRESS_WORLDWIDE_EXPRESS_PLUS';

        $services['US']['ADD'][] = 'UPS_SP_SERV_US_ADD_GROUND';
        $services['US']['ADD'][] = 'UPS_SP_SERV_US_ADD_3_DAY_SELECT';
        $services['US']['ADD'][] = 'UPS_SP_SERV_US_ADD_2ND_DAY_AIR';
        $services['US']['ADD'][] = 'UPS_SP_SERV_US_ADD_2ND_DAY_AIR_AM';
        $services['US']['ADD'][] = 'UPS_SP_SERV_US_ADD_NEXT_DAY_AIR_SAVER';
        $services['US']['ADD'][] = 'UPS_SP_SERV_US_ADD_NEXT_DAY_AIR';
        $services['US']['ADD'][] = 'UPS_SP_SERV_US_ADD_NEXT_DAY_AIR_EARLY';
        $services['US']['ADD'][] = 'UPS_SP_SERV_US_ADD_STANDARD';
        $services['US']['ADD'][] = 'UPS_SP_SERV_US_ADD_EXPRESS_WORLDWIDE_EXPEDITED';
        $services['US']['ADD'][] = 'UPS_SP_SERV_US_ADD_EXPRESS_WORLDWIDE_SAVER';
        $services['US']['ADD'][] = 'UPS_SP_SERV_US_ADD_EXPRESS_WORLDWIDE_EXPRESS';
        $services['US']['ADD'][] = 'UPS_SP_SERV_US_ADD_EXPRESS_WORLDWIDE_EXPRESS_PLUS';

        $services['AT']['AP'][] = 'UPS_SP_SERV_AT_AP_AP_ECONOMY';
        $services['AT']['AP'][] = 'UPS_SP_SERV_AT_AP_STANDARD';
        $services['AT']['AP'][] = 'UPS_SP_SERV_AT_AP_STANDARD_SAT_DELI';
        $services['AT']['AP'][] = 'UPS_SP_SERV_AT_AP_EXPEDITED';
        $services['AT']['AP'][] = 'UPS_SP_SERV_AT_AP_EXPRESS_SAVER';
        $services['AT']['AP'][] = 'UPS_SP_SERV_AT_AP_EXPRESS';
        $services['AT']['AP'][] = 'UPS_SP_SERV_AT_AP_EXPRESS_SAT_DELI';
        $services['AT']['AP'][] = 'UPS_SP_SERV_AT_AP_EXPRESS_PLUS';

        $services['AT']['ADD'][] = 'UPS_SP_SERV_AT_ADD_STANDARD';
        $services['AT']['ADD'][] = 'UPS_SP_SERV_AT_ADD_STANDARD_SAT_DELI';
        $services['AT']['ADD'][] = 'UPS_SP_SERV_AT_ADD_EXPEDITED';
        $services['AT']['ADD'][] = 'UPS_SP_SERV_AT_ADD_EXPRESS_SAVER';
        $services['AT']['ADD'][] = 'UPS_SP_SERV_AT_ADD_EXPRESS';
        $services['AT']['ADD'][] = 'UPS_SP_SERV_AT_ADD_EXPRESS_SAT_DELI';
        $services['AT']['ADD'][] = 'UPS_SP_SERV_AT_ADD_EXPRESS_PLUS';

        $services['BG']['AP'][] = 'UPS_SP_SERV_BG_AP_AP_ECONOMY';
        $services['BG']['AP'][] = 'UPS_SP_SERV_BG_AP_STANDARD';
        $services['BG']['AP'][] = 'UPS_SP_SERV_BG_AP_STANDARD_SAT_DELI';
        $services['BG']['AP'][] = 'UPS_SP_SERV_BG_AP_EXPEDITED';
        $services['BG']['AP'][] = 'UPS_SP_SERV_BG_AP_EXPRESS_SAVER';
        $services['BG']['AP'][] = 'UPS_SP_SERV_BG_AP_EXPRESS';
        $services['BG']['AP'][] = 'UPS_SP_SERV_BG_AP_EXPRESS_SAT_DELI';
        $services['BG']['AP'][] = 'UPS_SP_SERV_BG_AP_EXPRESS_PLUS';

        $services['BG']['ADD'][] = 'UPS_SP_SERV_BG_ADD_STANDARD';
        $services['BG']['ADD'][] = 'UPS_SP_SERV_BG_ADD_STANDARD_SAT_DELI';
        $services['BG']['ADD'][] = 'UPS_SP_SERV_BG_ADD_EXPEDITED';
        $services['BG']['ADD'][] = 'UPS_SP_SERV_BG_ADD_EXPRESS_SAVER';
        $services['BG']['ADD'][] = 'UPS_SP_SERV_BG_ADD_EXPRESS';
        $services['BG']['ADD'][] = 'UPS_SP_SERV_BG_ADD_EXPRESS_SAT_DELI';
        $services['BG']['ADD'][] = 'UPS_SP_SERV_BG_ADD_EXPRESS_PLUS';

        $services['HR']['AP'][] = 'UPS_SP_SERV_HR_AP_AP_ECONOMY';
        $services['HR']['AP'][] = 'UPS_SP_SERV_HR_AP_STANDARD';
        $services['HR']['AP'][] = 'UPS_SP_SERV_HR_AP_STANDARD_SAT_DELI';
        $services['HR']['AP'][] = 'UPS_SP_SERV_HR_AP_EXPEDITED';
        $services['HR']['AP'][] = 'UPS_SP_SERV_HR_AP_EXPRESS_SAVER';
        $services['HR']['AP'][] = 'UPS_SP_SERV_HR_AP_EXPRESS';
        $services['HR']['AP'][] = 'UPS_SP_SERV_HR_AP_EXPRESS_SAT_DELI';
        $services['HR']['AP'][] = 'UPS_SP_SERV_HR_AP_EXPRESS_PLUS';

        $services['HR']['ADD'][] = 'UPS_SP_SERV_HR_ADD_STANDARD';
        $services['HR']['ADD'][] = 'UPS_SP_SERV_HR_ADD_STANDARD_SAT_DELI';
        $services['HR']['ADD'][] = 'UPS_SP_SERV_HR_ADD_EXPEDITED';
        $services['HR']['ADD'][] = 'UPS_SP_SERV_HR_ADD_EXPRESS_SAVER';
        $services['HR']['ADD'][] = 'UPS_SP_SERV_HR_ADD_EXPRESS';
        $services['HR']['ADD'][] = 'UPS_SP_SERV_HR_ADD_EXPRESS_SAT_DELI';
        $services['HR']['ADD'][] = 'UPS_SP_SERV_HR_ADD_EXPRESS_PLUS';

        $services['CY']['AP'][] = 'UPS_SP_SERV_CY_AP_AP_ECONOMY';
        $services['CY']['AP'][] = 'UPS_SP_SERV_CY_AP_STANDARD';
        $services['CY']['AP'][] = 'UPS_SP_SERV_CY_AP_STANDARD_SAT_DELI';
        $services['CY']['AP'][] = 'UPS_SP_SERV_CY_AP_EXPEDITED';
        $services['CY']['AP'][] = 'UPS_SP_SERV_CY_AP_EXPRESS_SAVER';
        $services['CY']['AP'][] = 'UPS_SP_SERV_CY_AP_EXPRESS';
        $services['CY']['AP'][] = 'UPS_SP_SERV_CY_AP_EXPRESS_SAT_DELI';
        $services['CY']['AP'][] = 'UPS_SP_SERV_CY_AP_EXPRESS_PLUS';

        $services['CY']['ADD'][] = 'UPS_SP_SERV_CY_ADD_STANDARD';
        $services['CY']['ADD'][] = 'UPS_SP_SERV_CY_ADD_STANDARD_SAT_DELI';
        $services['CY']['ADD'][] = 'UPS_SP_SERV_CY_ADD_EXPEDITED';
        $services['CY']['ADD'][] = 'UPS_SP_SERV_CY_ADD_EXPRESS_SAVER';
        $services['CY']['ADD'][] = 'UPS_SP_SERV_CY_ADD_EXPRESS';
        $services['CY']['ADD'][] = 'UPS_SP_SERV_CY_ADD_EXPRESS_SAT_DELI';
        $services['CY']['ADD'][] = 'UPS_SP_SERV_CY_ADD_EXPRESS_PLUS';

        $services['CZ']['AP'][] = 'UPS_SP_SERV_CZ_AP_AP_ECONOMY';
        $services['CZ']['AP'][] = 'UPS_SP_SERV_CZ_AP_STANDARD';
        $services['CZ']['AP'][] = 'UPS_SP_SERV_CZ_AP_STANDARD_SAT_DELI';
        $services['CZ']['AP'][] = 'UPS_SP_SERV_CZ_AP_EXPEDITED';
        $services['CZ']['AP'][] = 'UPS_SP_SERV_CZ_AP_EXPRESS_SAVER';
        $services['CZ']['AP'][] = 'UPS_SP_SERV_CZ_AP_EXPRESS';
        $services['CZ']['AP'][] = 'UPS_SP_SERV_CZ_AP_EXPRESS_SAT_DELI';
        $services['CZ']['AP'][] = 'UPS_SP_SERV_CZ_AP_EXPRESS_PLUS';

        $services['CZ']['ADD'][] = 'UPS_SP_SERV_CZ_ADD_STANDARD';
        $services['CZ']['ADD'][] = 'UPS_SP_SERV_CZ_ADD_STANDARD_SAT_DELI';
        $services['CZ']['ADD'][] = 'UPS_SP_SERV_CZ_ADD_EXPEDITED';
        $services['CZ']['ADD'][] = 'UPS_SP_SERV_CZ_ADD_EXPRESS_SAVER';
        $services['CZ']['ADD'][] = 'UPS_SP_SERV_CZ_ADD_EXPRESS';
        $services['CZ']['ADD'][] = 'UPS_SP_SERV_CZ_ADD_EXPRESS_SAT_DELI';
        $services['CZ']['ADD'][] = 'UPS_SP_SERV_CZ_ADD_EXPRESS_PLUS';

        $services['DK']['AP'][] = 'UPS_SP_SERV_DK_AP_AP_ECONOMY';
        $services['DK']['AP'][] = 'UPS_SP_SERV_DK_AP_STANDARD';
        $services['DK']['AP'][] = 'UPS_SP_SERV_DK_AP_STANDARD_SAT_DELI';
        $services['DK']['AP'][] = 'UPS_SP_SERV_DK_AP_EXPEDITED';
        $services['DK']['AP'][] = 'UPS_SP_SERV_DK_AP_EXPRESS_SAVER';
        $services['DK']['AP'][] = 'UPS_SP_SERV_DK_AP_EXPRESS';
        $services['DK']['AP'][] = 'UPS_SP_SERV_DK_AP_EXPRESS_SAT_DELI';
        $services['DK']['AP'][] = 'UPS_SP_SERV_DK_AP_EXPRESS_PLUS';

        $services['DK']['ADD'][] = 'UPS_SP_SERV_DK_ADD_STANDARD';
        $services['DK']['ADD'][] = 'UPS_SP_SERV_DK_ADD_STANDARD_SAT_DELI';
        $services['DK']['ADD'][] = 'UPS_SP_SERV_DK_ADD_EXPEDITED';
        $services['DK']['ADD'][] = 'UPS_SP_SERV_DK_ADD_EXPRESS_SAVER';
        $services['DK']['ADD'][] = 'UPS_SP_SERV_DK_ADD_EXPRESS';
        $services['DK']['ADD'][] = 'UPS_SP_SERV_DK_ADD_EXPRESS_SAT_DELI';
        $services['DK']['ADD'][] = 'UPS_SP_SERV_DK_ADD_EXPRESS_PLUS';

        $services['EE']['AP'][] = 'UPS_SP_SERV_EE_AP_AP_ECONOMY';
        $services['EE']['AP'][] = 'UPS_SP_SERV_EE_AP_STANDARD';
        $services['EE']['AP'][] = 'UPS_SP_SERV_EE_AP_STANDARD_SAT_DELI';
        $services['EE']['AP'][] = 'UPS_SP_SERV_EE_AP_EXPEDITED';
        $services['EE']['AP'][] = 'UPS_SP_SERV_EE_AP_EXPRESS_SAVER';
        $services['EE']['AP'][] = 'UPS_SP_SERV_EE_AP_EXPRESS';
        $services['EE']['AP'][] = 'UPS_SP_SERV_EE_AP_EXPRESS_SAT_DELI';
        $services['EE']['AP'][] = 'UPS_SP_SERV_EE_AP_EXPRESS_PLUS';

        $services['EE']['ADD'][] = 'UPS_SP_SERV_EE_ADD_STANDARD';
        $services['EE']['ADD'][] = 'UPS_SP_SERV_EE_ADD_STANDARD_SAT_DELI';
        $services['EE']['ADD'][] = 'UPS_SP_SERV_EE_ADD_EXPEDITED';
        $services['EE']['ADD'][] = 'UPS_SP_SERV_EE_ADD_EXPRESS_SAVER';
        $services['EE']['ADD'][] = 'UPS_SP_SERV_EE_ADD_EXPRESS';
        $services['EE']['ADD'][] = 'UPS_SP_SERV_EE_ADD_EXPRESS_SAT_DELI';
        $services['EE']['ADD'][] = 'UPS_SP_SERV_EE_ADD_EXPRESS_PLUS';

        $services['FI']['AP'][] = 'UPS_SP_SERV_FI_AP_AP_ECONOMY';
        $services['FI']['AP'][] = 'UPS_SP_SERV_FI_AP_STANDARD';
        $services['FI']['AP'][] = 'UPS_SP_SERV_FI_AP_STANDARD_SAT_DELI';
        $services['FI']['AP'][] = 'UPS_SP_SERV_FI_AP_EXPEDITED';
        $services['FI']['AP'][] = 'UPS_SP_SERV_FI_AP_EXPRESS_SAVER';
        $services['FI']['AP'][] = 'UPS_SP_SERV_FI_AP_EXPRESS';
        $services['FI']['AP'][] = 'UPS_SP_SERV_FI_AP_EXPRESS_SAT_DELI';
        $services['FI']['AP'][] = 'UPS_SP_SERV_FI_AP_EXPRESS_PLUS';

        $services['FI']['ADD'][] = 'UPS_SP_SERV_FI_ADD_STANDARD';
        $services['FI']['ADD'][] = 'UPS_SP_SERV_FI_ADD_STANDARD_SAT_DELI';
        $services['FI']['ADD'][] = 'UPS_SP_SERV_FI_ADD_EXPEDITED';
        $services['FI']['ADD'][] = 'UPS_SP_SERV_FI_ADD_EXPRESS_SAVER';
        $services['FI']['ADD'][] = 'UPS_SP_SERV_FI_ADD_EXPRESS';
        $services['FI']['ADD'][] = 'UPS_SP_SERV_FI_ADD_EXPRESS_SAT_DELI';
        $services['FI']['ADD'][] = 'UPS_SP_SERV_FI_ADD_EXPRESS_PLUS';

        $services['GR']['AP'][] = 'UPS_SP_SERV_GR_AP_AP_ECONOMY';
        $services['GR']['AP'][] = 'UPS_SP_SERV_GR_AP_STANDARD';
        $services['GR']['AP'][] = 'UPS_SP_SERV_GR_AP_STANDARD_SAT_DELI';
        $services['GR']['AP'][] = 'UPS_SP_SERV_GR_AP_EXPEDITED';
        $services['GR']['AP'][] = 'UPS_SP_SERV_GR_AP_EXPRESS_SAVER';
        $services['GR']['AP'][] = 'UPS_SP_SERV_GR_AP_EXPRESS';
        $services['GR']['AP'][] = 'UPS_SP_SERV_GR_AP_EXPRESS_SAT_DELI';
        $services['GR']['AP'][] = 'UPS_SP_SERV_GR_AP_EXPRESS_PLUS';

        $services['GR']['ADD'][] = 'UPS_SP_SERV_GR_ADD_STANDARD';
        $services['GR']['ADD'][] = 'UPS_SP_SERV_GR_ADD_STANDARD_SAT_DELI';
        $services['GR']['ADD'][] = 'UPS_SP_SERV_GR_ADD_EXPEDITED';
        $services['GR']['ADD'][] = 'UPS_SP_SERV_GR_ADD_EXPRESS_SAVER';
        $services['GR']['ADD'][] = 'UPS_SP_SERV_GR_ADD_EXPRESS';
        $services['GR']['ADD'][] = 'UPS_SP_SERV_GR_ADD_EXPRESS_SAT_DELI';
        $services['GR']['ADD'][] = 'UPS_SP_SERV_GR_ADD_EXPRESS_PLUS';

        $services['HU']['AP'][] = 'UPS_SP_SERV_HU_AP_AP_ECONOMY';
        $services['HU']['AP'][] = 'UPS_SP_SERV_HU_AP_STANDARD';
        $services['HU']['AP'][] = 'UPS_SP_SERV_HU_AP_STANDARD_SAT_DELI';
        $services['HU']['AP'][] = 'UPS_SP_SERV_HU_AP_EXPEDITED';
        $services['HU']['AP'][] = 'UPS_SP_SERV_HU_AP_EXPRESS_SAVER';
        $services['HU']['AP'][] = 'UPS_SP_SERV_HU_AP_EXPRESS';
        $services['HU']['AP'][] = 'UPS_SP_SERV_HU_AP_EXPRESS_SAT_DELI';
        $services['HU']['AP'][] = 'UPS_SP_SERV_HU_AP_EXPRESS_PLUS';

        $services['HU']['ADD'][] = 'UPS_SP_SERV_HU_ADD_STANDARD';
        $services['HU']['ADD'][] = 'UPS_SP_SERV_HU_ADD_STANDARD_SAT_DELI';
        $services['HU']['ADD'][] = 'UPS_SP_SERV_HU_ADD_EXPEDITED';
        $services['HU']['ADD'][] = 'UPS_SP_SERV_HU_ADD_EXPRESS_SAVER';
        $services['HU']['ADD'][] = 'UPS_SP_SERV_HU_ADD_EXPRESS';
        $services['HU']['ADD'][] = 'UPS_SP_SERV_HU_ADD_EXPRESS_SAT_DELI';
        $services['HU']['ADD'][] = 'UPS_SP_SERV_HU_ADD_EXPRESS_PLUS';

        $services['IE']['AP'][] = 'UPS_SP_SERV_IE_AP_AP_ECONOMY';
        $services['IE']['AP'][] = 'UPS_SP_SERV_IE_AP_STANDARD';
        $services['IE']['AP'][] = 'UPS_SP_SERV_IE_AP_STANDARD_SAT_DELI';
        $services['IE']['AP'][] = 'UPS_SP_SERV_IE_AP_EXPEDITED';
        $services['IE']['AP'][] = 'UPS_SP_SERV_IE_AP_EXPRESS_SAVER';
        $services['IE']['AP'][] = 'UPS_SP_SERV_IE_AP_EXPRESS';
        $services['IE']['AP'][] = 'UPS_SP_SERV_IE_AP_EXPRESS_SAT_DELI';
        $services['IE']['AP'][] = 'UPS_SP_SERV_IE_AP_EXPRESS_PLUS';

        $services['IE']['ADD'][] = 'UPS_SP_SERV_IE_ADD_STANDARD';
        $services['IE']['ADD'][] = 'UPS_SP_SERV_IE_ADD_STANDARD_SAT_DELI';
        $services['IE']['ADD'][] = 'UPS_SP_SERV_IE_ADD_EXPEDITED';
        $services['IE']['ADD'][] = 'UPS_SP_SERV_IE_ADD_EXPRESS_SAVER';
        $services['IE']['ADD'][] = 'UPS_SP_SERV_IE_ADD_EXPRESS';
        $services['IE']['ADD'][] = 'UPS_SP_SERV_IE_ADD_EXPRESS_SAT_DELI';
        $services['IE']['ADD'][] = 'UPS_SP_SERV_IE_ADD_EXPRESS_PLUS';

        $services['LV']['AP'][] = 'UPS_SP_SERV_LV_AP_AP_ECONOMY';
        $services['LV']['AP'][] = 'UPS_SP_SERV_LV_AP_STANDARD';
        $services['LV']['AP'][] = 'UPS_SP_SERV_LV_AP_STANDARD_SAT_DELI';
        $services['LV']['AP'][] = 'UPS_SP_SERV_LV_AP_EXPEDITED';
        $services['LV']['AP'][] = 'UPS_SP_SERV_LV_AP_EXPRESS_SAVER';
        $services['LV']['AP'][] = 'UPS_SP_SERV_LV_AP_EXPRESS';
        $services['LV']['AP'][] = 'UPS_SP_SERV_LV_AP_EXPRESS_SAT_DELI';
        $services['LV']['AP'][] = 'UPS_SP_SERV_LV_AP_EXPRESS_PLUS';

        $services['LV']['ADD'][] = 'UPS_SP_SERV_LV_ADD_STANDARD';
        $services['LV']['ADD'][] = 'UPS_SP_SERV_LV_ADD_STANDARD_SAT_DELI';
        $services['LV']['ADD'][] = 'UPS_SP_SERV_LV_ADD_EXPEDITED';
        $services['LV']['ADD'][] = 'UPS_SP_SERV_LV_ADD_EXPRESS_SAVER';
        $services['LV']['ADD'][] = 'UPS_SP_SERV_LV_ADD_EXPRESS';
        $services['LV']['ADD'][] = 'UPS_SP_SERV_LV_ADD_EXPRESS_SAT_DELI';
        $services['LV']['ADD'][] = 'UPS_SP_SERV_LV_ADD_EXPRESS_PLUS';

        $services['LT']['AP'][] = 'UPS_SP_SERV_LT_AP_AP_ECONOMY';
        $services['LT']['AP'][] = 'UPS_SP_SERV_LT_AP_STANDARD';
        $services['LT']['AP'][] = 'UPS_SP_SERV_LT_AP_STANDARD_SAT_DELI';
        $services['LT']['AP'][] = 'UPS_SP_SERV_LT_AP_EXPEDITED';
        $services['LT']['AP'][] = 'UPS_SP_SERV_LT_AP_EXPRESS_SAVER';
        $services['LT']['AP'][] = 'UPS_SP_SERV_LT_AP_EXPRESS';
        $services['LT']['AP'][] = 'UPS_SP_SERV_LT_AP_EXPRESS_SAT_DELI';
        $services['LT']['AP'][] = 'UPS_SP_SERV_LT_AP_EXPRESS_PLUS';

        $services['LT']['ADD'][] = 'UPS_SP_SERV_LT_ADD_STANDARD';
        $services['LT']['ADD'][] = 'UPS_SP_SERV_LT_ADD_STANDARD_SAT_DELI';
        $services['LT']['ADD'][] = 'UPS_SP_SERV_LT_ADD_EXPEDITED';
        $services['LT']['ADD'][] = 'UPS_SP_SERV_LT_ADD_EXPRESS_SAVER';
        $services['LT']['ADD'][] = 'UPS_SP_SERV_LT_ADD_EXPRESS';
        $services['LT']['ADD'][] = 'UPS_SP_SERV_LT_ADD_EXPRESS_SAT_DELI';
        $services['LT']['ADD'][] = 'UPS_SP_SERV_LT_ADD_EXPRESS_PLUS';

        $services['LU']['AP'][] = 'UPS_SP_SERV_LU_AP_AP_ECONOMY';
        $services['LU']['AP'][] = 'UPS_SP_SERV_LU_AP_STANDARD';
        $services['LU']['AP'][] = 'UPS_SP_SERV_LU_AP_STANDARD_SAT_DELI';
        $services['LU']['AP'][] = 'UPS_SP_SERV_LU_AP_EXPEDITED';
        $services['LU']['AP'][] = 'UPS_SP_SERV_LU_AP_EXPRESS_SAVER';
        $services['LU']['AP'][] = 'UPS_SP_SERV_LU_AP_EXPRESS';
        $services['LU']['AP'][] = 'UPS_SP_SERV_LU_AP_EXPRESS_SAT_DELI';
        $services['LU']['AP'][] = 'UPS_SP_SERV_LU_AP_EXPRESS_PLUS';

        $services['LU']['ADD'][] = 'UPS_SP_SERV_LU_ADD_STANDARD';
        $services['LU']['ADD'][] = 'UPS_SP_SERV_LU_ADD_STANDARD_SAT_DELI';
        $services['LU']['ADD'][] = 'UPS_SP_SERV_LU_ADD_EXPEDITED';
        $services['LU']['ADD'][] = 'UPS_SP_SERV_LU_ADD_EXPRESS_SAVER';
        $services['LU']['ADD'][] = 'UPS_SP_SERV_LU_ADD_EXPRESS';
        $services['LU']['ADD'][] = 'UPS_SP_SERV_LU_ADD_EXPRESS_SAT_DELI';
        $services['LU']['ADD'][] = 'UPS_SP_SERV_LU_ADD_EXPRESS_PLUS';

        $services['MT']['AP'][] = 'UPS_SP_SERV_MT_AP_AP_ECONOMY';
        $services['MT']['AP'][] = 'UPS_SP_SERV_MT_AP_STANDARD';
        $services['MT']['AP'][] = 'UPS_SP_SERV_MT_AP_STANDARD_SAT_DELI';
        $services['MT']['AP'][] = 'UPS_SP_SERV_MT_AP_EXPEDITED';
        $services['MT']['AP'][] = 'UPS_SP_SERV_MT_AP_EXPRESS_SAVER';
        $services['MT']['AP'][] = 'UPS_SP_SERV_MT_AP_EXPRESS';
        $services['MT']['AP'][] = 'UPS_SP_SERV_MT_AP_EXPRESS_SAT_DELI';
        $services['MT']['AP'][] = 'UPS_SP_SERV_MT_AP_EXPRESS_PLUS';

        $services['MT']['ADD'][] = 'UPS_SP_SERV_MT_ADD_STANDARD';
        $services['MT']['ADD'][] = 'UPS_SP_SERV_MT_ADD_STANDARD_SAT_DELI';
        $services['MT']['ADD'][] = 'UPS_SP_SERV_MT_ADD_EXPEDITED';
        $services['MT']['ADD'][] = 'UPS_SP_SERV_MT_ADD_EXPRESS_SAVER';
        $services['MT']['ADD'][] = 'UPS_SP_SERV_MT_ADD_EXPRESS';
        $services['MT']['ADD'][] = 'UPS_SP_SERV_MT_ADD_EXPRESS_SAT_DELI';
        $services['MT']['ADD'][] = 'UPS_SP_SERV_MT_ADD_EXPRESS_PLUS';

        $services['PT']['AP'][] = 'UPS_SP_SERV_PT_AP_AP_ECONOMY';
        $services['PT']['AP'][] = 'UPS_SP_SERV_PT_AP_STANDARD';
        $services['PT']['AP'][] = 'UPS_SP_SERV_PT_AP_STANDARD_SAT_DELI';
        $services['PT']['AP'][] = 'UPS_SP_SERV_PT_AP_EXPEDITED';
        $services['PT']['AP'][] = 'UPS_SP_SERV_PT_AP_EXPRESS_SAVER';
        $services['PT']['AP'][] = 'UPS_SP_SERV_PT_AP_EXPRESS';
        $services['PT']['AP'][] = 'UPS_SP_SERV_PT_AP_EXPRESS_SAT_DELI';
        $services['PT']['AP'][] = 'UPS_SP_SERV_PT_AP_EXPRESS_PLUS';

        $services['PT']['ADD'][] = 'UPS_SP_SERV_PT_ADD_STANDARD';
        $services['PT']['ADD'][] = 'UPS_SP_SERV_PT_ADD_STANDARD_SAT_DELI';
        $services['PT']['ADD'][] = 'UPS_SP_SERV_PT_ADD_EXPEDITED';
        $services['PT']['ADD'][] = 'UPS_SP_SERV_PT_ADD_EXPRESS_SAVER';
        $services['PT']['ADD'][] = 'UPS_SP_SERV_PT_ADD_EXPRESS';
        $services['PT']['ADD'][] = 'UPS_SP_SERV_PT_ADD_EXPRESS_SAT_DELI';
        $services['PT']['ADD'][] = 'UPS_SP_SERV_PT_ADD_EXPRESS_PLUS';

        $services['RO']['AP'][] = 'UPS_SP_SERV_RO_AP_AP_ECONOMY';
        $services['RO']['AP'][] = 'UPS_SP_SERV_RO_AP_STANDARD';
        $services['RO']['AP'][] = 'UPS_SP_SERV_RO_AP_STANDARD_SAT_DELI';
        $services['RO']['AP'][] = 'UPS_SP_SERV_RO_AP_EXPEDITED';
        $services['RO']['AP'][] = 'UPS_SP_SERV_RO_AP_EXPRESS_SAVER';
        $services['RO']['AP'][] = 'UPS_SP_SERV_RO_AP_EXPRESS';
        $services['RO']['AP'][] = 'UPS_SP_SERV_RO_AP_EXPRESS_SAT_DELI';
        $services['RO']['AP'][] = 'UPS_SP_SERV_RO_AP_EXPRESS_PLUS';

        $services['RO']['ADD'][] = 'UPS_SP_SERV_RO_ADD_STANDARD';
        $services['RO']['ADD'][] = 'UPS_SP_SERV_RO_ADD_STANDARD_SAT_DELI';
        $services['RO']['ADD'][] = 'UPS_SP_SERV_RO_ADD_EXPEDITED';
        $services['RO']['ADD'][] = 'UPS_SP_SERV_RO_ADD_EXPRESS_SAVER';
        $services['RO']['ADD'][] = 'UPS_SP_SERV_RO_ADD_EXPRESS';
        $services['RO']['ADD'][] = 'UPS_SP_SERV_RO_ADD_EXPRESS_SAT_DELI';
        $services['RO']['ADD'][] = 'UPS_SP_SERV_RO_ADD_EXPRESS_PLUS';

        $services['SK']['AP'][] = 'UPS_SP_SERV_SK_AP_AP_ECONOMY';
        $services['SK']['AP'][] = 'UPS_SP_SERV_SK_AP_STANDARD';
        $services['SK']['AP'][] = 'UPS_SP_SERV_SK_AP_STANDARD_SAT_DELI';
        $services['SK']['AP'][] = 'UPS_SP_SERV_SK_AP_EXPEDITED';
        $services['SK']['AP'][] = 'UPS_SP_SERV_SK_AP_EXPRESS_SAVER';
        $services['SK']['AP'][] = 'UPS_SP_SERV_SK_AP_EXPRESS';
        $services['SK']['AP'][] = 'UPS_SP_SERV_SK_AP_EXPRESS_SAT_DELI';
        $services['SK']['AP'][] = 'UPS_SP_SERV_SK_AP_EXPRESS_PLUS';

        $services['SK']['ADD'][] = 'UPS_SP_SERV_SK_ADD_STANDARD';
        $services['SK']['ADD'][] = 'UPS_SP_SERV_SK_ADD_STANDARD_SAT_DELI';
        $services['SK']['ADD'][] = 'UPS_SP_SERV_SK_ADD_EXPEDITED';
        $services['SK']['ADD'][] = 'UPS_SP_SERV_SK_ADD_EXPRESS_SAVER';
        $services['SK']['ADD'][] = 'UPS_SP_SERV_SK_ADD_EXPRESS';
        $services['SK']['ADD'][] = 'UPS_SP_SERV_SK_ADD_EXPRESS_SAT_DELI';
        $services['SK']['ADD'][] = 'UPS_SP_SERV_SK_ADD_EXPRESS_PLUS';

        $services['SI']['AP'][] = 'UPS_SP_SERV_SI_AP_AP_ECONOMY';
        $services['SI']['AP'][] = 'UPS_SP_SERV_SI_AP_STANDARD';
        $services['SI']['AP'][] = 'UPS_SP_SERV_SI_AP_STANDARD_SAT_DELI';
        $services['SI']['AP'][] = 'UPS_SP_SERV_SI_AP_EXPEDITED';
        $services['SI']['AP'][] = 'UPS_SP_SERV_SI_AP_EXPRESS_SAVER';
        $services['SI']['AP'][] = 'UPS_SP_SERV_SI_AP_EXPRESS';
        $services['SI']['AP'][] = 'UPS_SP_SERV_SI_AP_EXPRESS_SAT_DELI';
        $services['SI']['AP'][] = 'UPS_SP_SERV_SI_AP_EXPRESS_PLUS';

        $services['SI']['ADD'][] = 'UPS_SP_SERV_SI_ADD_STANDARD';
        $services['SI']['ADD'][] = 'UPS_SP_SERV_SI_ADD_STANDARD_SAT_DELI';
        $services['SI']['ADD'][] = 'UPS_SP_SERV_SI_ADD_EXPEDITED';
        $services['SI']['ADD'][] = 'UPS_SP_SERV_SI_ADD_EXPRESS_SAVER';
        $services['SI']['ADD'][] = 'UPS_SP_SERV_SI_ADD_EXPRESS';
        $services['SI']['ADD'][] = 'UPS_SP_SERV_SI_ADD_EXPRESS_SAT_DELI';
        $services['SI']['ADD'][] = 'UPS_SP_SERV_SI_ADD_EXPRESS_PLUS';

        $services['SE']['AP'][] = 'UPS_SP_SERV_SE_AP_AP_ECONOMY';
        $services['SE']['AP'][] = 'UPS_SP_SERV_SE_AP_STANDARD';
        $services['SE']['AP'][] = 'UPS_SP_SERV_SE_AP_STANDARD_SAT_DELI';
        $services['SE']['AP'][] = 'UPS_SP_SERV_SE_AP_EXPEDITED';
        $services['SE']['AP'][] = 'UPS_SP_SERV_SE_AP_EXPRESS_SAVER';
        $services['SE']['AP'][] = 'UPS_SP_SERV_SE_AP_EXPRESS';
        $services['SE']['AP'][] = 'UPS_SP_SERV_SE_AP_EXPRESS_SAT_DELI';
        $services['SE']['AP'][] = 'UPS_SP_SERV_SE_AP_EXPRESS_PLUS';

        $services['SE']['ADD'][] = 'UPS_SP_SERV_SE_ADD_STANDARD';
        $services['SE']['ADD'][] = 'UPS_SP_SERV_SE_ADD_STANDARD_SAT_DELI';
        $services['SE']['ADD'][] = 'UPS_SP_SERV_SE_ADD_EXPEDITED';
        $services['SE']['ADD'][] = 'UPS_SP_SERV_SE_ADD_EXPRESS_SAVER';
        $services['SE']['ADD'][] = 'UPS_SP_SERV_SE_ADD_EXPRESS';
        $services['SE']['ADD'][] = 'UPS_SP_SERV_SE_ADD_EXPRESS_SAT_DELI';
        $services['SE']['ADD'][] = 'UPS_SP_SERV_SE_ADD_EXPRESS_PLUS';

        $services['NO']['AP'][] = 'UPS_SP_SERV_NO_AP_AP_ECONOMY';
        $services['NO']['AP'][] = 'UPS_SP_SERV_NO_AP_STANDARD';
        $services['NO']['AP'][] = 'UPS_SP_SERV_NO_AP_STANDARD_SAT_DELI';
        $services['NO']['AP'][] = 'UPS_SP_SERV_NO_AP_EXPEDITED';
        $services['NO']['AP'][] = 'UPS_SP_SERV_NO_AP_EXPRESS_SAVER';
        $services['NO']['AP'][] = 'UPS_SP_SERV_NO_AP_EXPRESS';
        $services['NO']['AP'][] = 'UPS_SP_SERV_NO_AP_EXPRESS_SAT_DELI';
        $services['NO']['AP'][] = 'UPS_SP_SERV_NO_AP_EXPRESS_PLUS';

        $services['NO']['ADD'][] = 'UPS_SP_SERV_NO_ADD_STANDARD';
        $services['NO']['ADD'][] = 'UPS_SP_SERV_NO_ADD_STANDARD_SAT_DELI';
        $services['NO']['ADD'][] = 'UPS_SP_SERV_NO_ADD_EXPEDITED';
        $services['NO']['ADD'][] = 'UPS_SP_SERV_NO_ADD_EXPRESS_SAVER';
        $services['NO']['ADD'][] = 'UPS_SP_SERV_NO_ADD_EXPRESS';
        $services['NO']['ADD'][] = 'UPS_SP_SERV_NO_ADD_EXPRESS_SAT_DELI';
        $services['NO']['ADD'][] = 'UPS_SP_SERV_NO_ADD_EXPRESS_PLUS';

        $services['RS']['AP'][] = 'UPS_SP_SERV_RS_AP_AP_ECONOMY';
        $services['RS']['AP'][] = 'UPS_SP_SERV_RS_AP_STANDARD';
        $services['RS']['AP'][] = 'UPS_SP_SERV_RS_AP_STANDARD_SAT_DELI';
        $services['RS']['AP'][] = 'UPS_SP_SERV_RS_AP_EXPEDITED';
        $services['RS']['AP'][] = 'UPS_SP_SERV_RS_AP_EXPRESS_SAVER';
        $services['RS']['AP'][] = 'UPS_SP_SERV_RS_AP_EXPRESS';
        $services['RS']['AP'][] = 'UPS_SP_SERV_RS_AP_EXPRESS_SAT_DELI';
        $services['RS']['AP'][] = 'UPS_SP_SERV_RS_AP_EXPRESS_PLUS';

        $services['RS']['ADD'][] = 'UPS_SP_SERV_RS_ADD_STANDARD';
        $services['RS']['ADD'][] = 'UPS_SP_SERV_RS_ADD_STANDARD_SAT_DELI';
        $services['RS']['ADD'][] = 'UPS_SP_SERV_RS_ADD_EXPEDITED';
        $services['RS']['ADD'][] = 'UPS_SP_SERV_RS_ADD_EXPRESS_SAVER';
        $services['RS']['ADD'][] = 'UPS_SP_SERV_RS_ADD_EXPRESS';
        $services['RS']['ADD'][] = 'UPS_SP_SERV_RS_ADD_EXPRESS_SAT_DELI';
        $services['RS']['ADD'][] = 'UPS_SP_SERV_RS_ADD_EXPRESS_PLUS';

        $services['CH']['AP'][] = 'UPS_SP_SERV_CH_AP_AP_ECONOMY';
        $services['CH']['AP'][] = 'UPS_SP_SERV_CH_AP_STANDARD';
        $services['CH']['AP'][] = 'UPS_SP_SERV_CH_AP_STANDARD_SAT_DELI';
        $services['CH']['AP'][] = 'UPS_SP_SERV_CH_AP_EXPEDITED';
        $services['CH']['AP'][] = 'UPS_SP_SERV_CH_AP_EXPRESS_SAVER';
        $services['CH']['AP'][] = 'UPS_SP_SERV_CH_AP_EXPRESS';
        $services['CH']['AP'][] = 'UPS_SP_SERV_CH_AP_EXPRESS_SAT_DELI';
        $services['CH']['AP'][] = 'UPS_SP_SERV_CH_AP_EXPRESS_PLUS';

        $services['CH']['ADD'][] = 'UPS_SP_SERV_CH_ADD_STANDARD';
        $services['CH']['ADD'][] = 'UPS_SP_SERV_CH_ADD_STANDARD_SAT_DELI';
        $services['CH']['ADD'][] = 'UPS_SP_SERV_CH_ADD_EXPEDITED';
        $services['CH']['ADD'][] = 'UPS_SP_SERV_CH_ADD_EXPRESS_SAVER';
        $services['CH']['ADD'][] = 'UPS_SP_SERV_CH_ADD_EXPRESS';
        $services['CH']['ADD'][] = 'UPS_SP_SERV_CH_ADD_EXPRESS_SAT_DELI';
        $services['CH']['ADD'][] = 'UPS_SP_SERV_CH_ADD_EXPRESS_PLUS';

        $services['IS']['AP'][] = 'UPS_SP_SERV_IS_AP_AP_ECONOMY';
        $services['IS']['AP'][] = 'UPS_SP_SERV_IS_AP_STANDARD';
        $services['IS']['AP'][] = 'UPS_SP_SERV_IS_AP_STANDARD_SAT_DELI';
        $services['IS']['AP'][] = 'UPS_SP_SERV_IS_AP_EXPEDITED';
        $services['IS']['AP'][] = 'UPS_SP_SERV_IS_AP_EXPRESS_SAVER';
        $services['IS']['AP'][] = 'UPS_SP_SERV_IS_AP_EXPRESS';
        $services['IS']['AP'][] = 'UPS_SP_SERV_IS_AP_EXPRESS_SAT_DELI';
        $services['IS']['AP'][] = 'UPS_SP_SERV_IS_AP_EXPRESS_PLUS';

        $services['IS']['ADD'][] = 'UPS_SP_SERV_IS_ADD_STANDARD';
        $services['IS']['ADD'][] = 'UPS_SP_SERV_IS_ADD_STANDARD_SAT_DELI';
        $services['IS']['ADD'][] = 'UPS_SP_SERV_IS_ADD_EXPEDITED';
        $services['IS']['ADD'][] = 'UPS_SP_SERV_IS_ADD_EXPRESS_SAVER';
        $services['IS']['ADD'][] = 'UPS_SP_SERV_IS_ADD_EXPRESS';
        $services['IS']['ADD'][] = 'UPS_SP_SERV_IS_ADD_EXPRESS_SAT_DELI';
        $services['IS']['ADD'][] = 'UPS_SP_SERV_IS_ADD_EXPRESS_PLUS';

        $services['JE']['AP'][] = 'UPS_SP_SERV_JE_AP_AP_ECONOMY';
        $services['JE']['AP'][] = 'UPS_SP_SERV_JE_AP_STANDARD';
        $services['JE']['AP'][] = 'UPS_SP_SERV_JE_AP_STANDARD_SAT_DELI';
        $services['JE']['AP'][] = 'UPS_SP_SERV_JE_AP_EXPEDITED';
        $services['JE']['AP'][] = 'UPS_SP_SERV_JE_AP_EXPRESS_SAVER';
        $services['JE']['AP'][] = 'UPS_SP_SERV_JE_AP_EXPRESS';
        $services['JE']['AP'][] = 'UPS_SP_SERV_JE_AP_EXPRESS_SAT_DELI';
        $services['JE']['AP'][] = 'UPS_SP_SERV_JE_AP_EXPRESS_PLUS';

        $services['JE']['ADD'][] = 'UPS_SP_SERV_JE_ADD_STANDARD';
        $services['JE']['ADD'][] = 'UPS_SP_SERV_JE_ADD_STANDARD_SAT_DELI';
        $services['JE']['ADD'][] = 'UPS_SP_SERV_JE_ADD_EXPEDITED';
        $services['JE']['ADD'][] = 'UPS_SP_SERV_JE_ADD_EXPRESS_SAVER';
        $services['JE']['ADD'][] = 'UPS_SP_SERV_JE_ADD_EXPRESS';
        $services['JE']['ADD'][] = 'UPS_SP_SERV_JE_ADD_EXPRESS_SAT_DELI';
        $services['JE']['ADD'][] = 'UPS_SP_SERV_JE_ADD_EXPRESS_PLUS';

        $services['TR']['AP'][] = 'UPS_SP_SERV_TR_AP_AP_ECONOMY';
        $services['TR']['AP'][] = 'UPS_SP_SERV_TR_AP_STANDARD';
        $services['TR']['AP'][] = 'UPS_SP_SERV_TR_AP_STANDARD_SAT_DELI';
        $services['TR']['AP'][] = 'UPS_SP_SERV_TR_AP_EXPEDITED';
        $services['TR']['AP'][] = 'UPS_SP_SERV_TR_AP_EXPRESS_SAVER';
        $services['TR']['AP'][] = 'UPS_SP_SERV_TR_AP_EXPRESS';
        $services['TR']['AP'][] = 'UPS_SP_SERV_TR_AP_EXPRESS_SAT_DELI';
        $services['TR']['AP'][] = 'UPS_SP_SERV_TR_AP_EXPRESS_PLUS';

        $services['TR']['ADD'][] = 'UPS_SP_SERV_TR_ADD_STANDARD';
        $services['TR']['ADD'][] = 'UPS_SP_SERV_TR_ADD_STANDARD_SAT_DELI';
        $services['TR']['ADD'][] = 'UPS_SP_SERV_TR_ADD_EXPEDITED';
        $services['TR']['ADD'][] = 'UPS_SP_SERV_TR_ADD_EXPRESS_SAVER';
        $services['TR']['ADD'][] = 'UPS_SP_SERV_TR_ADD_EXPRESS';
        $services['TR']['ADD'][] = 'UPS_SP_SERV_TR_ADD_EXPRESS_SAT_DELI';
        $services['TR']['ADD'][] = 'UPS_SP_SERV_TR_ADD_EXPRESS_PLUS';
        
        if (empty($country_code)) {
            return $services;
        } elseif (empty($service_type)) {
            return $services[$country_code];
        } else {
            return $services[$country_code][$service_type];
        }
    }
}
