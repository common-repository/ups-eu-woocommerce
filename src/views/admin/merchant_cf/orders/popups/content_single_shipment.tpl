<!-- Modal Header -->
<style>
    .tooltip {
        z-index: 10000 !important;
    }
</style>
<div class="modal-header">
    <h4 class="modal-title">{$dataObject->lang["Process Shipment"]}</h4>
    <button type="button" class="close" data-dismiss="modal">&times;</button>
</div>

<!-- Modal body -->
<div class="modal-body" id="create-single-shipment">
    <form method="post" class="col-sm-offset-1" id="form-create-shipment" action="">
        <div class="form-group row">
            <label class="col-2" id="account-label"><b>{$dataObject->lang["account_number"]}</b></label>
            <div class="col-10" id="account-select-list">
                <select class="create-account col-12" name="createAccount">
                    {foreach $dataObject->list_account as $item}
                        <option value="{$item->account_id}">{stripslashes($item->address_type|escape:'htmlall':'UTF-8')} (#{stripslashes($item->ups_account_number|escape:'htmlall':'UTF-8')})</option>
                    {/foreach}
                </select>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-6">
                <p><b>{$dataObject->lang["Ship From"]}</b></p>
                <div class="col-11 mx-auto" id="create-ship-from"></div>
            </div>
            <div class="col-md-6">
                <p><b>{$dataObject->lang["Ship To"]}</b></p>
                <div class="col-11 mx-auto" id="create-ship-to"></div>

                <div class="col-11 mx-auto hidden" id="edit-ship-to">
                    <div class="form-group row">
                        <label for="colFormLabel" class="col-5 col-form-label"><b>{$dataObject->lang["Name"]}</b></label>
                        <div class="col-7" id="input-field">
                            <input type="text" class="col-sm-12" maxlength="100" id="edit-name" name="editName" data-type="required">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="colFormLabel" class="col-5 col-form-label"><b>{$dataObject->lang["address"]}</b></label>
                        <div class="col-7" id="input-field">
                            <input type="text" class="col-sm-12" maxlength="50" id="edit-address1" name="editAddressLine1" data-type="required">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="colFormLabel" class="col-5 col-form-label"></label>
                        <div class="col-7" id="input-field">
                            <input type="text" class="col-sm-12" maxlength="50" id="edit-address2" name="editAddressLine2">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="colFormLabel" class="col-5 col-form-label"></label>
                        <div class="col-7" id="input-field">
                            <input type="text" class="col-sm-12" maxlength="50" id="edit-address3" name="editAddressLine3">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="colFormLabel" class="col-5 col-form-label" id="postal-code-label"><b>{$dataObject->lang["postal_code"]}</b></label>
                        <div class="col-7" id="input-field">
                            <input type="text" class="col-sm-12" id="edit-postcode" name="editPostalCode" data-type="required">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="colFormLabel" class="col-5 col-form-label"><b>{$dataObject->lang["City"]}</b></label>
                        <div class="col-7" id="input-field">
                            <input type="text" class="col-sm-12" maxlength="30" id="edit-city" name="editCity" data-type="required">
                        </div>
                    </div>
                    <div class="form-group row showListState hidden">
                        <label for="colFormLabel" class="col-5 col-form-label"><b>{$dataObject->lang["State"]}</b></label>
                        <div class="col-7" id="input-field">
                            <select id="edit-state" name="editState" class="select col-sm-12"></select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="colFormLabel" class="col-5 col-form-label"><b>{$dataObject->lang["Country/Territory"]}</b></label>
                        <div class="col-7" id="input-field">
                            <select id="edit-country" name="editCountry" class="select col-sm-12">
                                {if (!empty($dataObject->list_country))}
                                    {foreach $dataObject->list_country as $key => $value}
                                        <option value="{$key}">{$value}</option>
                                    {/foreach}
                                {/if}
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="colFormLabel" class="col-5 col-form-label"><b>{$dataObject->lang["email"]}</b></label>
                        <div class="col-7" id="input-field">
                            <input type="email" class="col-sm-12" maxlength="100" id="edit-email" name="editEmail" data-type="required">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="colFormLabel" class="col-5 col-form-label" id="phone-number-label"><b>{$dataObject->lang["phone_number"]}</b></label>
                        <div class="col-7" id="input-field">
                            <input type="text" class="col-sm-12" maxlength="15" id="edit-phone" name="editPhone" data-type="required">
                        </div>
                    </div>
                    <div class="form-group row">
                        <span class="col-12" id="note-field" style="color: red"><i>{$dataObject->lang["Note: Insufficient or incorrect address may increase the shipping fee"]}</i></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-3"><b>{$dataObject->lang["Shipping service"]}:</b></label>
            <label class="col-sm-9" id="shipping-service-create"></label>
            <div class="col-sm-9 hidden" id="edit-shipping-service-to-ap">
                {if !empty($dataObject->services_to_ap)}
                    {foreach $dataObject->services_to_ap as $value}
                        <div class="col-sm-12">
                            <label class="form-check-label clear-font" for="{$value->id}">
                                <input name="optradio" type="radio" id="{$value->id}" value="{$value->service_key}" data-rateCode="{$value->rate_code}" service-name="{stripslashes($value->service_name|escape:'htmlall':'UTF-8')}" service-type="{$value->service_type}">
                                {$dataObject->lang[$value->service_key]}
                            </label>
                        </div>
                    {/foreach}
                {/if}
            </div>
            <div class="col-sm-9 hidden" id="edit-shipping-service-to-add">
                {if !empty($dataObject->services_to_add)}
                    {foreach $dataObject->services_to_add as $value}
                        <div class="col-sm-12">
                            <label class="form-check-label clear-font" for="{$value->id}">
                                <input name="optradio" type="radio" id="{$value->id}" value="{$value->service_key}" data-rateCode="{$value->rate_code}" service-name="{stripslashes($value->service_name|escape:'htmlall':'UTF-8')} service-type="{$value->service_type}">
                                {stripslashes($dataObject->lang[$value->service_key]|escape:'htmlall':'UTF-8')}
                            </label>
                        </div>
                    {/foreach}
                {/if}
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-3"><b>{$dataObject->lang["Accessorial service"]}: </b></label>
            <label class="col-sm-9" id="accessorial-service"></label>
            {if ($dataObject->lang['countryCode'] == "US")}
                <div class="col-sm-12 font-italic" id="note-us-accessorial" style="position: absolute; padding-top: 20px; left: 15px">
                    <span>{$dataObject->lang["Accessorial service note"]}</span>
                </div>
            {/if}
            <div class="col-sm-9 hidden" id="edit-accessorial-service">
                {foreach $dataObject->list_accessorials as $key => $accessorial}
                    <div class="col-sm-12">
                        <label  for="accessorial-{$accessorial->id}" class="form-check-label clear-font">
                            <input type="checkbox" id="accessorial-{$accessorial->id}" name="{$accessorial->id}" value="{$accessorial->accessorial_key}">
                            {stripslashes($accessorial->accessorial_name|escape:'htmlall':'UTF-8')}
                        </label>
                        {if ($dataObject->lang['countryCode'] == "US")}
                            {if ($accessorial->accessorial_key == "UPS_ACSRL_ADDITIONAL_HADING")}
                                <a tabindex=-1 class="" data-toggle="tooltip" data-placement="top" title="{$dataObject->lang["Additional Handling note"]}" href="javascript:;"><i class="fa fa-question-circle"></i></a>
                            {/if}
                            {if ($accessorial->accessorial_key == "UPS_ACSRL_RESIDENTIAL_ADDRESS")}
                                <a tabindex=-1 class="" data-toggle="tooltip" data-placement="top" title="{$dataObject->lang["Residential Address note"]}" href="javascript:;"><i class="fa fa-question-circle"></i></a>
                            {/if}
                            {if ($accessorial->accessorial_key == "UPS_ACSRL_TO_HOME_COD")}
                                <a tabindex=-1 class="" data-toggle="tooltip" data-placement="top" title="{$dataObject->lang["To Home COD note"]}" href="javascript:;"><i class="fa fa-question-circle"></i></a>
                            {/if}
                        {/if}
                    </div>
                {/foreach}
            </div>
        </div>
        <label><b>{$dataObject->lang["Packaging"]}</b></label>

        <div class="add-package">
            {$item_no = 1}
            {foreach $dataObject->list_package as $item}
                <div class="package-add-row remove-row-package">
                    <div class="form-group row">
                        <label class="col-sm-2 label-auto-increment" id="control-label">{$dataObject->lang["Package #"]}<o>{$item_no}</o></label>
                        <div class="col-sm-10">
                            <div class="form-group row">
                                <div class="col-sm-11">
                                    <select class="col-sm-12" id="select-package">
                                        {* {stripslashes($item->package_name|escape:'htmlall':'UTF-8')} *}
                                        <option value="{$item|@json_encode|escape:'html'}"> ({if isset($item->length) && isset($item->width) && isset($item->height)} {$item->length}x{$item->width}x{$item->height} {if ($item->unit_dimension == 'cm')} cm, {else} inch, {/if} {/if} {$item->weight} {if ($item->unit_weight == 'kgs')} Kg{else} Pounds{/if})</option>
                                        <option value="custom_package">{$dataObject->lang["Custom Package"]}</option>
                                    </select>
                                </div>
                                <div class="col-sm-1 remove-package-layout{if $item_no == 1} hidden{/if}">
                                    <div id="remove-package" class="remove-row"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row hidden" id="custom-package">
                        <label class="col-sm-2"> </label>

                        <div class="col-sm-10">
                            <div class="form-group row">

                                <div class="weight-field">
                                    <input type="text" autocomplete="off" class="package-weight" name="weight">
                                    <span class="label-create-package">{$dataObject->lang["Weight"]}</span><o style="color: red">*</o></span>
                                </div>

                                <div class="weight-option">
                                    <select class="col-sm-12" name="unit-weight">
                                        {if ($dataObject->lang['countryCode'] == "US")}
                                            <option value="lbs">Pounds</option>
                                            <option value="kgs">Kg</option>
                                        {else}
                                            <option value="kgs">Kg</option>
                                            <option value="lbs">Pounds</option>
                                        {/if}
                                    </select>
                                </div>

                                <div class="package-field">
                                    <input type="text" autocomplete="off" class="package-length" name="length">
                                    <span class="label-create-package">{$dataObject->lang["Length"]}</span><o style="color: red">*</o></span>
                                </div>
                                <div class="package-field">
                                    <input type="text" autocomplete="off" class="package-width" name="width">
                                    <span class="label-create-package">{$dataObject->lang["Width"]}</span><o style="color: red">*</o></span>
                                </div>
                                <div class="package-field">
                                    <input type="text" autocomplete="off" class="package-height" name="height">
                                    <span class="label-create-package">{$dataObject->lang["Height"]}</span><o style="color: red">*</o></span>
                                </div>

                                <div class="unit-dimension-field">
                                    <select class="col-sm-12" name="unit-dimension">
                                        {if ($dataObject->lang['countryCode'] == "US")}
                                            <option value="inch">Inch</option>
                                            <option value="cm">Cm</option>
                                        {else}
                                            <option value="cm">Cm</option>
                                            <option value="inch">Inch</option>
                                        {/if}
                                    </select>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                {$item_no = $item_no + 1}
            {/foreach}
        </div>


        <div class="form-group row">

            <div class="col-12">
                <a href="javascript:;" id="add-package">{$dataObject->lang["Add package"]}</a>
            </div>

            <div class="col-12 row">
                <div class="col-md-6 col-sm-8">
                    <a href="javascript:;" id="api-rating-view-estimated-shipping-fee">{$dataObject->lang["View estimated shipping fee and delivery date"]}</a>
                </div>
                <div class="col-md-6 col-sm-4" id="rating"></div>
            </div>

        </div>

        <div class="notice-error notice is-dismissible col-12 create-shipment-show-message hidden"></div>
    </form>

    <!-- Modal footer -->
    <div class="modal-footer">
        <button type="button" class="button button-primary" id="btn-edit-shipment" >{$dataObject->lang["Edit"]}</button>
        <button type="button" class="button button-primary hidden" id="btn-cancel-edit">{$dataObject->lang["Cancel Editing"]}</button>
        <button type="button" class="button button-primary" id="btn-create-shipment">{$dataObject->lang["Create Shipment"]}</button>
    </div>

</div>
<style type="text/css">
    .modal-body {
        overflow-y: scroll;
        max-height: 668px;
    }

    #account-select-list {
        padding-right: 29px;
    }

    #input-field {
        padding-right: 0px;
        padding-left: 5px;
    }

    #note-field {
        padding-right: 0px;
        padding-left: 15px;
    }

    #input-field input {
        padding: 3px 5px 3px 5px;
    }

    #control-label {
        padding-left: 34px;
    }

    #postal-code-label {
        padding-right: 0px;
    }

    #phone-number-label {
        padding-right: 5px;
    }

    #account-label {
        padding-right: 0px;
    }

    .add-package .form-group {
        margin-bottom: 5px;
    }

    .weight-field {
        width: 14%;
        margin-left: 10px;
        padding-right: 0;
        padding-left: 5px;
        float: left;
    }

    .weight-option {
        width: 14%;
        margin-left: 5px;
        float: left;
    }

    .package-field {
        width: 14%;
        margin-left: 5px;
        padding-right: 0;
        float: left;
    }

    .unit-dimension-field {
        width: 14%;
        margin-left: 5px;
        padding-right: 1px;
        float: left;
    }

    .label-create-package {
        opacity: 0.8;
    }

    #add-package {
        padding-left:20px;
        outline:none;
        box-shadow:none;
    }

    #add-package:focus {
        padding-left:20px;
        outline: 1px solid #5b9dd9;
        box-shadow:none;
    }

    #api-rating-view-estimated-shipping-fee {
        outline:none;
        box-shadow:none;
    }

    #api-rating-view-estimated-shipping-fee:focus {
        outline: 1px solid #5b9dd9;
        box-shadow:none;
    }

    #remove-package {
        width:20px;
        cursor: pointer;
    }

    .create-shipment-show-message {
        margin-left: 0px;
        margin-right: 0px;
    }
</style>
<script type="text/javascript">
    (function ($) {
        'use strict';
        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });
    })(jQuery);
</script>
