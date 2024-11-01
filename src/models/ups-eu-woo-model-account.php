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
 * ups-eu-woo-model-account.php - The core plugin class.
 *
 * This is used to define the Account Model.
 */

include_once(dirname(__FILE__, 2) . '/ups-eu-woo-autoloader.php');
new \UpsEuWoocommerce\Ups_Eu_Woo_Main_Autoloader('Ups_Eu_Woo_Model_Account');

class Ups_Eu_Woo_Model_Account extends entities\Ups_Eu_Woo_Account_Entity implements Ups_Eu_Woo_Interfaces
{
    /* define variable */

    private $table_name = "";
    private $key_id;
    /* ------------atributes fields---------------- */
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
    public $state;
    public $account_type;
    public $ups_account_name;
    public $ups_account_number;
    public $ups_account_u_name;
    public $ups_account_password;
    public $ups_account_access;
    public $ups_invoice_number;
    public $ups_control_id;
    public $ups_invoice_amount;
    public $ups_currency;
    public $ups_invoice_date;
    public $account_default;
    public $device_identity;
    public $ups_account_vatnumber;
    public $ups_account_promocode;

    /* patterns */
    private $patterns_validate;
    public $val_company_error_msg;
    public $val_account_number_error_msg;

    /*
     * Name function: __construct
     * Params: emtpy
     * Return: void
     * * */

    public function __construct()
    {
        parent::__construct();
        global $wpdb;
        $this->table_name = "{$wpdb->prefix}{$this->prefix_ups}account";
        $this->key_id = $this->col_account_id;
        $this->patterns_validate = [
            $this->col_phone_number => "/[^0-9]/",
            $this->col_postal_code => "/[^A-Za-z0-9]/",
        ];
        $this->val_company_error_msg = __("Company is required", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain);
        $this->val_account_number_error_msg = __("Account number is not valid", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain);
    }
    /*
     * Name function: ups_eu_woo_convert_to_array
     * Params: empty
     * Return: type array object
     * * */

    public function ups_eu_woo_convert_to_array()
    {
        $tmpArray = [];
        $tmpArray[$this->col_account_id] = $this->account_id;
        $tmpArray[$this->col_title] = $this->title;
        $tmpArray[$this->col_fullname] = $this->fullname;
        $tmpArray[$this->col_company] = $this->company;
        $tmpArray[$this->col_email] = $this->email;
        $tmpArray[$this->col_phone_number] = $this->phone_number;
        $tmpArray[$this->col_address_type] = $this->address_type;
        $tmpArray[$this->col_address_1] = $this->address_1;
        $tmpArray[$this->col_address_2] = $this->address_2;
        $tmpArray[$this->col_address_3] = $this->address_3;
        $tmpArray[$this->col_postal_code] = $this->postal_code;
        $tmpArray[$this->col_city] = $this->city;
        $tmpArray[$this->col_country] = $this->country;
        $tmpArray[$this->col_state] = $this->state;
        $tmpArray[$this->col_account_type] = $this->account_type;
        $tmpArray[$this->col_ups_account_name] = $this->ups_account_name;
        $tmpArray[$this->col_ups_account_number] = $this->ups_account_number;
        $tmpArray[$this->col_ups_account_u_name] = $this->ups_account_u_name;
        $tmpArray[$this->col_ups_account_password] = $this->ups_account_password;
        // $tmpArray[$this->col_ups_account_access] = $this->ups_account_access;
        $tmpArray[$this->col_ups_invoice_number] = $this->ups_invoice_number;
        $tmpArray[$this->col_ups_control_id] = $this->col_ups_control_id;
        $tmpArray[$this->col_ups_invoice_amount] = $this->ups_invoice_amount;
        $tmpArray[$this->col_ups_currency] = $this->ups_currency;
        $tmpArray[$this->col_ups_invoice_date] = $this->ups_invoice_date;
        $tmpArray[$this->col_account_default] = $this->account_default;
        $tmpArray[$this->col_device_identity] = $this->device_identity;
        $tmpArray[$this->col_ups_account_promocode] = $this->ups_account_promocode;
        $tmpArray[$this->col_ups_account_vatnumber] = $this->ups_account_vatnumber;
        return $tmpArray;
    }
    /*
     * Name function: ups_eu_woo_get_all
     * Params: empty
     * Return: type array object
     * * */

    public function ups_eu_woo_get_all()
    {
        return $this->ups_eu_woo_base_get_all($this->table_name);
    }
    /*
     * Name function: save
     * Params: empty
     * Return: type boolean
     * * */

    public function ups_eu_woo_save()
    {
        /* format phone_number with pattern */
        $this->phone_number = preg_replace($this->patterns_validate[$this->col_phone_number], "", $this->phone_number);
        /* format postal_code with pattern */
        $this->postal_code = $this->postal_code;
        /* convert data to array */
        $dataArray = $this->ups_eu_woo_convert_to_array();
        /* save data to database */
        if (isset($dataArray['ups_account_password'])) {
            unset($dataArray['ups_account_password']);
        }
        if (isset($dataArray['col_ups_account_password'])) {
            unset($dataArray['col_ups_account_password']);
        }
        if (isset($dataArray['ups_account_u_name'])) {
            unset($dataArray['ups_account_u_name']);
        }
        if (isset($dataArray['ups_account_access'])) {
            unset($dataArray['ups_account_access']);
        }
        $check_save_id = $this->ups_eu_woo_base_save($dataArray, $this->table_name, $this->key_id);
        if ($check_save_id > 0) {
            /* set key id after save it */
            $this->{$this->key_id} = $check_save_id;
            return true;
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
            /* convert data from array to object */
            $this->ups_eu_woo_base_convert_array_to_object($result_array, $this);
            return $this;
        }
        return false;
    }
    /*
     * Name function: delete
     * Params:
     * @id: type int
     * Return: type boolean
     * * */

    public function ups_eu_woo_delete($id)
    {
        $id = intval($id);
        if ($id > 0) {
            /* delete account by id */
            return $this->ups_eu_woo_base_delete($id, $this->table_name, $this->key_id);
        }
        return false;
    }
    /*
     * Name function: get_list_data_by_condition
     * Params:
     *  @conditions: tyype array
     *  @limit: type string
     * Return: type array object
     * * */

    public function get_list_data_by_condition($conditions = [], $limit = 'all')
    {
        /* get list data by condition */
        return $this->ups_eu_woo_base_get_list_data_by_condition($this->table_name, $conditions, $limit);
    }
    /*
     * Name function: validate
     * Params:
     *  @account_type: type string
     *  @type_default: type boolean
     * Return: void
     * * */

    public function ups_eu_woo_validate($account_type = null, $type_default = true)
    {
        /* define variable */
        global $wpdb;
        $tmpValidate = [];
        $mess_error_show = '';
        $pattern = "/^[\D]*$/";
        /* This case  none_account */
        if ($type_default === true) {
            /* check title */
            if (empty($this->title)) {
                $tmpValidate[$this->col_title][$this->msg_error] = __(
                    "Title is required",
                    \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain
                );
            }
            /* check fullname */
            if (empty($this->fullname)) {
                $tmpValidate[$this->col_fullname][$this->msg_error] = __(
                    "Fullname is required",
                    \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain
                );
            } else {
                /* check fullname value with pattern */
                // if (!preg_match($pattern, $this->fullname)) {
                //     $tmpValidate[$this->fullname][$this->msg_error] = __(
                //         "Fullname is required",
                //         \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain
                //     );
                // }
            }
            /* check email */
            if (empty($this->email)) {
                $tmpValidate[$this->col_email][$this->msg_error] = __(
                    "Email is required",
                    \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language ::$domain
                );
            } else {
                /* check email value with pattern */
                if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
                    $tmpValidate[$this->col_email][$this->msg_error] = __(
                        "Email is not valid",
                        \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain
                    );
                }
            }
            /* check company */
            if (empty($this->company)) {
                $tmpValidate[$this->col_company][$this->msg_error] = $this->val_company_error_msg;
            } else {
                /* check company value with pattern */
                // if (!preg_match($pattern, $this->company)) {
                //     $tmpValidate["company"][$this->msg_error] = $this->val_company_error_msg;
                // }
            }
        }
        /* apply all case ,check phone name */
        if (empty($this->phone_number)) {
            $tmpValidate[$this->col_phone_number][$this->msg_error] = __(
                "Phone number is required",
                \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language:: $domain
            );
        }
        /* check address 1 */
        if (empty($this->address_1)) {
            $tmpValidate[$this->col_address_1][$this->msg_error] = __(
                "Address is required",
                \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language:: $domain
            );
        }
        /* check postal code */
        if (empty($this->postal_code)) {
            $tmpValidate[$this->col_postal_code][$this->msg_error] = __(
                "Postal code is required",
                \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language:: $domain
            );
        }
        /* check city */
        if (empty($this->city)) {
            $tmpValidate[$this->col_city][$this->msg_error] = __(
                "City is required",
                \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain
            );
        } else {
            /* check city value with pattern */
            // if (!preg_match($pattern, $this->city)) {
            //     $tmpValidate[$this->col_city][$this->msg_error] = $this->val_company_error_msg;
            // }
        }
        /* sanitize contry  from  selected combox */
        $this->country = sanitize_text_field($this->country);
        /* lang of colum account name */
        $lang_ups_account_name_requied = __("Account name is required", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain);
        $lang_ups_account_name_valid = __("Account name is not valid", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain);
        $lang_ups_account_password_requied = __("Account password is required", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain);
        $lang_ups_account_username_requied = __("Account username is required", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain);
        $lang_ups_account_access_requied = __("Access Key is required", \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain);
        switch ($this->account_type) {
            case 1:
                /* check account name */
                if (empty($this->ups_account_name)) {
                    $tmpValidate[$this->col_ups_account_name][$this->msg_error] = $lang_ups_account_name_requied;
                }
                /* check aps_account_number */
                if (empty($this->ups_account_number)) {
                    /* set error message if account number is empty */
                    $tmpValidate[$this->col_ups_account_number][$this->msg_error] = __(
                        "Account number is required",
                        \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain
                    );
                } elseif (!preg_match("/[A-Za-z0-9]{6}/", $this->ups_account_number)) {
                    /* check value ups_account_number with pattern */
                    $tmpValidate[$this->col_ups_account_number][$this->msg_error] = $this->val_account_number_error_msg;
                } else {
                    /* check existing account in system */
                    $check_existing = $this->check_account_number_existing($this->ups_account_number);
                    if ($check_existing) {
                        /* check account number duplicate */
                        $tmpValidate[$this->col_ups_account_number][$this->msg_error] = __(
                            "The Account Number existed",
                            \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain
                        );
                        $mess_error_show = $tmpValidate[$this->col_ups_account_number][$this->msg_error];
                    }
                }
                /* check ups invoice number */
                if (empty($this->ups_invoice_number)) {
                    /* set error message if ups_invoice_number is empty */
                    $tmpValidate[$this->col_ups_invoice_number][$this->msg_error] = __(
                        "Invoice number is required",
                        \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain
                    );
                } else {
                    /* check value ups_invoice_number with pattern */
                    if (!preg_match("/^[^-\s][\w\s-]+$/", $this->ups_invoice_number)) {
                        /* set error message if ups_invoice_number is not match pattern */
                        $tmpValidate[$this->ups_invoice_number][$this->msg_error] = $this->val_account_number_error_msg;
                    }
                }
                /* check ups control id */
                if (empty($this->ups_control_id) && $this->country == 'US') {
                    /* set error message if ups_control_id is empty */
                    $tmpValidate[$this->col_ups_control_id][$this->msg_error] = __(
                        "Control id is required",
                        \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain
                    );
                }
                /* check ups invoice amount */
                if ($this->ups_invoice_amount === "") {
                    /* set error message if ups_invoice_amount is empty */
                    $tmpValidate[$this->col_ups_invoice_amount][$this->msg_error] = __(
                        "Invoice amount is required",
                        \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain
                    );
                } else {
                    /* check value ups_invoice_amount with pattern */
                    if (!preg_match("/^[0-9]+\.?[0-9]*$/", $this->ups_invoice_amount)) {
                        /* set error message if ups_invoice_amount is not match pattern */
                        $tmpValidate[$this->col_ups_invoice_amount][$this->msg_error] = __(
                            "Invoice amount is not valid",
                            \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain
                        );
                    }
                }
                /* check ups currency */
                if (empty($this->ups_currency)) {
                    /* set error message if ups_currency is empty */
                    $tmpValidate[$this->col_ups_currency][$this->msg_error] = __(
                        "Currency is required",
                        \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain
                    );
                }
                /* check ups invoice date */
                if (empty($this->ups_invoice_date)) {
                    /* set error message if ups_invoice_date is empty */
                    $tmpValidate[$this->col_ups_invoice_date][$this->msg_error] = __(
                        "Invoice date is required",
                        \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain
                    );
                }
                break;
            case 2:
                /* check ups account name */
                if (empty($this->ups_account_name)) {
                    $tmpValidate[$this->col_ups_account_name][$this->msg_error] = $lang_ups_account_name_requied;
                }
                /* check ups account number */
                if (empty($this->ups_account_number)) {
                    /* set error message if ups_account_number is empty */
                    $tmpValidate[$this->col_ups_account_number][$this->msg_error] = __(
                        "Account number is required",
                        \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain
                    );
                } elseif (!preg_match("/[A-Za-z0-9]{6}/", $this->ups_account_number)) {
                    /* set error message if ups_account_number is not match pattern */
                    $tmpValidate[$this->col_ups_account_number][$this->msg_error] = $this->val_account_number_error_msg;
                } else {
                    /* check ups_account_number exist */
                    $check_existing = $this->check_account_number_existing($this->ups_account_number);
                    if ($check_existing) {
                        /* set error message if ups_account_number is existed */
                        $tmpValidate[$this->col_ups_account_number][$this->msg_error] = __(
                            "The Account Number existed",
                            \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain
                        );
                        $mess_error_show = $tmpValidate[$this->col_ups_account_number][$this->msg_error];
                    }
                }
                break;
            case 3:
                break;
            case 4:
                /* check ups account name */
                if (empty($this->ups_account_name)) {
                    $tmpValidate[$this->col_ups_account_name][$this->msg_error] = $lang_ups_account_name_requied;
                }
                /* check ups account number */
                if (empty($this->ups_account_number)) {
                    /* set error message if ups_account_number is empty */
                    $tmpValidate[$this->col_ups_account_number][$this->msg_error] = __(
                        "Account number is required",
                        \UpsEuWoocommerce\utils\Ups_Eu_Woo_Utils_Language::$domain
                    );
                } elseif (!preg_match("/[A-Za-z0-9]{6}/", $this->ups_account_number)) {
                    /* set error message if ups_account_number is not match pattern */
                    $tmpValidate[$this->col_ups_account_number][$this->msg_error] = $this->val_account_number_error_msg;
                }
                /* check ups account username */
                if (empty($this->ups_account_u_name)) {
                    $tmpValidate[$this->col_ups_account_u_name][$this->msg_error] = $lang_ups_account_username_requied;
                }
                /* check ups account password */
                if (empty($this->ups_account_password)) {
                    $tmpValidate[$this->col_ups_account_password][$this->msg_error] = $lang_ups_account_password_requied;
                }
                /* check ups account accesskey */
                // if (empty($this->ups_account_access)) {
                //     $tmpValidate[$this->col_ups_account_access][$this->msg_error] = $lang_ups_account_access_requied;
                // }
                
                break;
            default:
                break;
        }
        /* check validate and set message error */
        if (count($tmpValidate) == 1 && $mess_error_show != '') {
            $tmpValidate['mess_error_show'] = $mess_error_show;
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
     * Return: void
     * * */

    public function ups_eu_woo_merge_array($data)
    {
        /* convert data array to object */
        $this->ups_eu_woo_base_convert_array_to_object($data, $this);
        /* format ups_invoice_date */
        $this->ups_invoice_date = preg_replace(
            "/([0-9]{2})\/([0-9]{2})\/([0-9]{2,4})/",
            "$3-$1-$2",
            $this->ups_invoice_date
        );
        $this->address_type = stripslashes($this->address_type);
        $this->ups_account_name = stripslashes($this->ups_account_name);
        $this->fullname = stripslashes($this->fullname);
        $this->company = stripslashes($this->company);
        $this->city = stripslashes($this->city);
        $this->email = stripslashes($this->email);
        $this->address_1 = stripslashes($this->address_1);
        $this->address_2 = stripslashes($this->address_2);
        $this->address_3 = stripslashes($this->address_3);
        $this->ups_account_number = stripslashes($this->ups_account_number);
        $this->ups_account_password = stripslashes($this->ups_account_password);
        $this->postal_code = stripslashes($this->postal_code);
        $this->ups_invoice_number = stripslashes($this->ups_invoice_number);
        if ($this->country == 'US') {
            $this->ups_control_id = stripslashes($this->ups_control_id);
        }
        $this->phone_number = stripslashes($this->phone_number);
        $this->ups_account_promocode = stripslashes($this->ups_account_promocode);
        $this->ups_account_vatnumber = stripslashes($this->ups_account_vatnumber);
    }
    /*
     * Name function: check_exiting
     * Params: empty
     * Return: type object
     * * */

    public function ups_eu_woo_check_existing()
    {
        return $this->ups_eu_woo_base_check_existing($this->table_name);
    }
    /*
     * Name function: ups_eu_woo_get_default_account
     * Params: empty
     * Return: type boolean
     *
     * * */

    public function ups_eu_woo_get_default_account()
    {
        /* get list data by condition */
        $list_data = $this->get_list_data_by_condition(["`{$this->col_account_default}` = 1"]);
        /* check list data value is empty or not */
        if (count($list_data) > 0) {
            return (array) $list_data[0];
        }
        return false;
    }
    /*
     * Name function: check_account_number_existing
     * Params:
     *  @ups_account_number: type string
     * Return: object
     * * */

    public function check_account_number_existing($ups_account_number)
    {
        /* check exist account number */
        return $this->ups_eu_woo_base_check_existing(
            $this->table_name,
            [
                "ups_account_number = '{$ups_account_number}'"]
        );
    }
    /*
     * Name function: ups_eu_woo_get_table_name
     * Params: empty
     * Return: type stirng
     * * */

    public function ups_eu_woo_get_table_name()
    {
        return $this->table_name;
    }
}
