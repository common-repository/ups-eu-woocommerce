<?php

namespace UpsEuWoocommerce\models;

/**
 * Description of Account
 *
 * @author ThinTV
 */
class Account extends DataBase implements Interfaces
{

    private $table_name = "";
    private $key_id = "account_id";
    //------------atributes fields----------------
    public $account_id;
    public $title;
    public $fullname;
    public $company;
    public $email;
    public $phone_number;
    public $address_type;
    public $address_1;
    public $address_2;
    public $address_3;
    public $postal_code;
    public $city;
    public $country;
    public $account_type;
    public $ups_account_name;
    public $ups_account_number;
    public $ups_invoice_number;
    public $ups_invoice_amount;
    public $ups_currency;
    public $ups_invoice_date;
    public $account_default;
    public $device_identity;

    function __construct()
    {
        parent::__construct();
        global $wpdb;
        $this->table_name = "{$wpdb->prefix}{$this->prefix_ups}account";
    }

    function convert_to_array()
    {
        $tmpArray = [];
        $tmpArray["account_id"] = $this->account_id;
        $tmpArray["title"] = $this->title;
        $tmpArray["fullname"] = $this->fullname;
        $tmpArray["company"] = $this->company;
        $tmpArray["email"] = $this->email;
        $tmpArray["phone_number"] = $this->phone_number;
        $tmpArray["address_type"] = $this->address_type;
        $tmpArray["address_1"] = $this->address_1;
        $tmpArray["address_2"] = $this->address_2;
        $tmpArray["address_3"] = $this->address_3;
        $tmpArray["postal_code"] = $this->postal_code;
        $tmpArray["city"] = $this->city;
        $tmpArray["country"] = $this->country;
        $tmpArray["account_type"] = $this->account_type;
        $tmpArray["ups_account_name"] = $this->ups_account_name;
        $tmpArray["ups_account_number"] = $this->ups_account_number;
        $tmpArray["ups_invoice_number"] = $this->ups_invoice_number;
        $tmpArray["ups_invoice_amount"] = $this->ups_invoice_amount;
        $tmpArray["ups_currency"] = $this->ups_currency;
        $tmpArray["ups_invoice_date"] = $this->ups_invoice_date;
        $tmpArray["account_default"] = $this->account_default;
        $tmpArray["device_identity"] = $this->device_identity;
        return $tmpArray;
    }

    function get_all()
    {
        return $this->_get_all($this->table_name);
    }

    function save()
    {
        $dataArray = $this->convert_to_array();
        $check_save_id = $this->_save($dataArray, $this->table_name, $this->key_id);
        if ($check_save_id > 0) {
            $this->{$this->key_id} = $check_save_id;
            return true;
        }
        return false;
    }

    function get_by_id($id)
    {
        $id = intval($id);
        if ($id > 0) {
            $result_array = $this->_get_by_id($id, $this->table_name, $this->key_id);
            $this->_convert_array_to_object($result_array, $this);
            return $this;
        }
        return false;
    }

    function delete($id)
    {
        $id = intval($id);
        if ($id > 0) {
            return $this->_delete($id, $this->table_name, $this->key_id);
        }
        return false;
    }

    public function get_list_data_by_condition($conditions = [], $limit = 'all')
    {
        return $this->_get_list_data_by_condition($this->table_name, $conditions, $limit);
    }

    function validate($account_type = null, $type_default = true)
    {
        global $wpdb;
        $tmpValidate = [];
        $mess_error_show = '';
        $this->title = sanitize_text_field($this->title);

        if ($type_default === true) {
            if (empty($this->title)) {
                $tmpValidate["title"]["msg_error"] = __("Title is required", \UpsEuWoocommerce\utils\Language::$domain);
            }

            $this->fullname = $wpdb->_escape($this->fullname);
            if (empty($this->fullname)) {
                $tmpValidate["fullname"]["msg_error"] = __("Fullname is required", \UpsEuWoocommerce\utils\Language::$domain);
            } else {
                if (!preg_match("/^[\D]*$/", $this->fullname)) {
                    $tmpValidate["fullname"]["msg_error"] = __("Fullname is required", \UpsEuWoocommerce\utils\Language::$domain);
                }
            }

            if (empty($this->email)) {
                $tmpValidate["email"]["msg_error"] = __("Email is required", \UpsEuWoocommerce\utils\Language::$domain);
            } elseif (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
                $tmpValidate["email"]["msg_error"] = __("Email is not valid", \UpsEuWoocommerce\utils\Language::$domain);
            }
            $this->company = sanitize_text_field($this->company);
            if ($type_default === true) {
                if (empty($this->company)) {
                    $tmpValidate["company"]["msg_error"] = __("Company is required", \UpsEuWoocommerce\utils\Language::$domain);
                } else {
                    if (!preg_match("/^[\D]*$/", $this->company)) {
                        $tmpValidate["company"]["msg_error"] = __("Company is required", \UpsEuWoocommerce\utils\Language::$domain);
                    }
                }
            }
        }

        $this->phone_number = sanitize_text_field($this->phone_number);
        if (empty($this->phone_number)) {
            $tmpValidate["phone_number"]["msg_error"] = __("Phone number is required", \UpsEuWoocommerce\utils\Language::$domain);
        } elseif (!preg_match("/^[0|\+][0-9]+/", $this->phone_number)) {
            $tmpValidate["phone_number"]["msg_error"] = __("Phone number is not valid", \UpsEuWoocommerce\utils\Language::$domain);
        }

        $this->address_type = $wpdb->_escape($this->address_type);

        $this->address_1 = sanitize_text_field($this->address_1);
        if (empty($this->address_1)) {
            $tmpValidate["address_1"]["msg_error"] = __("Address is required", \UpsEuWoocommerce\utils\Language::$domain);
        }
        $this->address_2 = sanitize_text_field($this->address_2);
        $this->address_3 = sanitize_text_field($this->address_3);
        $this->postal_code = sanitize_text_field($this->postal_code);
        if (empty($this->postal_code)) {
            $tmpValidate["postal_code"]["msg_error"] = __("Postal code is required", \UpsEuWoocommerce\utils\Language::$domain);
        } else {
            $options = new \UpsEuWoocommerce\models\Options();
            $country_list = $options->get_country_list();
            $model_config = new \UpsEuWoocommerce\models\Config();
            $country_code_saved = ($model_config->get_by_key("COUNTRY_CODE") === true) ? $model_config->value : "";
            if ($country_list[$country_code_saved] == "" ||
                    !preg_match($country_list[$country_code_saved]['regex'], $this->postal_code)) {
                $tmpValidate["postal_code"]["msg_error"] = __("Postal code is not valid", \UpsEuWoocommerce\utils\Language::$domain);
            }
        }
        $this->city = sanitize_text_field($this->city);
        if (empty($this->city)) {
            $tmpValidate["city"]["msg_error"] = __("City is required", \UpsEuWoocommerce\utils\Language::$domain);
        } else {
            if (!preg_match("/^[\D]*$/", $this->city)) {
                $tmpValidate["city"]["msg_error"] = __("Company is required", \UpsEuWoocommerce\utils\Language::$domain);
            }
        }
        $this->country = sanitize_text_field($this->country);
        $this->account_type = sanitize_text_field($this->account_type);

        $this->ups_account_name = $wpdb->_escape($this->ups_account_name);

        // if ($type_default === true) {
        if (empty($this->ups_account_name)) {
            $tmpValidate["ups_account_name"]["msg_error"] = __("Account name is required", \UpsEuWoocommerce\utils\Language::$domain);
        } elseif (!preg_match("/^[\D]*$/", $this->ups_account_name)) {
            $tmpValidate["ups_account_name"]["msg_error"] = __("Account name is not valid", \UpsEuWoocommerce\utils\Language::$domain);
        }
        // }
        switch ($this->account_type) {
            case 1:
                $this->ups_account_number = sanitize_text_field($this->ups_account_number);
                if (empty($this->ups_account_number)) {
                    $tmpValidate["ups_account_number"]["msg_error"] = __("Account number is required", \UpsEuWoocommerce\utils\Language::$domain);
                } elseif (!preg_match("/[A-Za-z0-9]{6}/", $this->ups_account_number)) {
                    $tmpValidate["ups_account_number"]["msg_error"] = __("Account number is not valid", \UpsEuWoocommerce\utils\Language::$domain);
                } else {
                    $check_existing = $this->check_account_number_existing($this->ups_account_number);
                    if ($check_existing) {
                        $tmpValidate["ups_account_number"]["msg_error"] = __("The Account Number existed", \UpsEuWoocommerce\utils\Language::$domain);
                        $mess_error_show = $tmpValidate["ups_account_number"]["msg_error"];
                    }
                }

                $this->ups_invoice_number = sanitize_text_field($this->ups_invoice_number);
                if (empty($this->ups_invoice_number)) {
                    $tmpValidate["ups_invoice_number"]["msg_error"] = __("Invoice number is required", \UpsEuWoocommerce\utils\Language::$domain);
                } elseif (!preg_match("/^[^-\s][\w\s-]+$/", $this->ups_invoice_number)) {
                    $tmpValidate["ups_invoice_number"]["msg_error"] = __("Account number is not valid", \UpsEuWoocommerce\utils\Language::$domain);
                }

                $this->ups_invoice_amount = sanitize_text_field($this->ups_invoice_amount);
                if ($this->ups_invoice_amount === "") {
                    $tmpValidate["ups_invoice_amount"]["msg_error"] = __("Invoice amount is required", \UpsEuWoocommerce\utils\Language::$domain);
                } elseif (!preg_match("/^[0-9]+\.?[0-9]*$/", $this->ups_invoice_amount)) {
                    $tmpValidate["ups_invoice_amount"]["msg_error"] = __("Invoice amount is not valid", \UpsEuWoocommerce\utils\Language::$domain);
                }

                $this->ups_currency = sanitize_text_field($this->ups_currency);
                if (empty($this->ups_currency)) {
                    $tmpValidate["ups_currency"]["msg_error"] = __("Currency is required", \UpsEuWoocommerce\utils\Language::$domain);
                }
                $this->ups_invoice_date = sanitize_text_field($this->ups_invoice_date);
                if (empty($this->ups_invoice_date)) {
                    $tmpValidate["ups_invoice_date"]["msg_error"] = __("Invoice date is required", \UpsEuWoocommerce\utils\Language::$domain);
                }
                break;
            case 2:
                $this->ups_account_number = sanitize_text_field($this->ups_account_number);
                if (empty($this->ups_account_number)) {
                    $tmpValidate["ups_account_number"]["msg_error"] = __("Account number is required", \UpsEuWoocommerce\utils\Language::$domain);
                } elseif (!preg_match("/[A-Za-z0-9]{6}/", $this->ups_account_number)) {
                    $tmpValidate["ups_account_number"]["msg_error"] = __("Account number is not valid", \UpsEuWoocommerce\utils\Language::$domain);
                } else {
                    $check_existing = $this->check_account_number_existing($this->ups_account_number);
                    if ($check_existing) {
                        $tmpValidate["ups_account_number"]["msg_error"] = __("The Account Number existed", \UpsEuWoocommerce\utils\Language::$domain);
                        $mess_error_show = $tmpValidate["ups_account_number"]["msg_error"];
                    }
                }
                break;
        }
        //check duplicate ups_account_number
        // $check_duplicate = $this->get_list_data_by_condition(["`ups_account_number` = '{$this->ups_account_number}'"]);
        // if (!empty($check_duplicate)) {
        //     if (count($check_duplicate) > 0) {
        //         $tmpValidate["ups_account_number"]["msg_error"] = __("Account number is not valid", \UpsEuWoocommerce\utils\Language::$domain);
        //     }
        // }

        if (count($tmpValidate) == 1 && $mess_error_show != '') {
            $tmpValidate['mess_error_show'] = $mess_error_show;
        }

        return (count($tmpValidate) > 0) ? $tmpValidate : true;
    }

    public function merge_array($data)
    {
        $this->_convert_array_to_object($data, $this);
        $this->ups_invoice_date = preg_replace("/([0-9]{2})\/([0-9]{2})\/([0-9]{2,4})/", "$3-$1-$2", $this->ups_invoice_date);
        $this->address_type = stripslashes($this->address_type);
        $this->ups_account_name = stripslashes($this->ups_account_name);
        $this->fullname = stripslashes($this->fullname);
    }

    public function check_existing()
    {
        return $this->_check_existing($this->table_name);
    }

    public function get_default_account()
    {
        $list_data = $this->get_list_data_by_condition(["`account_default` = 1"]);
        if (count($list_data) > 0) {
            return (array) $list_data[0];
        }
        return false;
    }

    public function check_account_number_existing($ups_account_number)
    {
        return $this->_check_existing($this->table_name, ["ups_account_number = '{$ups_account_number}'"]);
    }
}
