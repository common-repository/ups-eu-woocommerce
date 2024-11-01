{if $dataObject->mess_error_call_api}
    <div class="form-group notice-error settings-error notice is-dismissible">
        <ul>
            <li>{$dataObject->mess_error_call_api}</li>
        </ul>
        <button type="button" class="notice-dismiss">
            <span class="screen-reader-text"></span>
        </button>
    </div>
{else}
    {if is_array($dataObject->validate) && !empty($dataObject->validate)}
        <div class="form-group notice-error settings-error notice is-dismissible">
            <ul>
                {if (array_key_exists('mess_error_show', $dataObject->validate))}
                    <li>{$dataObject->lang[$dataObject->validate['mess_error_show']]}</li>
                    {else}
                    <li>{$dataObject->lang['validate_error']}</li>
                {/if}
            </ul>
            <button type="button" class="notice-dismiss">
                <span class="screen-reader-text"></span>
            </button>
        </div>
    {/if}
{/if}
{if $dataObject->lang["MSG_OPENACCOUNT_STATUS"] == 1}
    <div class="form-group notice-success settings-success notice is-dismissible">
        <ul>
            <li>{$dataObject->lang["MSG_OPENACCOUNT"]}</li>
        </ul>
        <button type="button" class="notice-dismiss">
            <span class="screen-reader-text"></span>
        </button>
    </div>
{elseif $dataObject->lang["MSG_OPENACCOUNT_STATUS"] == 2}
    <div class="form-group notice-error settings-error notice is-dismissible">
        <ul>
            <li>{$dataObject->lang["MSG_OPENACCOUNT"]}</li>
        </ul>
        <button type="button" class="notice-dismiss">
            <span class="screen-reader-text"></span>
        </button>
    </div>
{/if}
{if $dataObject->reset_acc_status == 3}
    <div class="form-group notice-success settings-success notice is-dismissible">
        <ul>
            <li>{$dataObject->reset_acc_msg}</li>
        </ul>
        <button type="button" class="notice-dismiss">
            <span class="screen-reader-text"></span>
        </button>
    </div>
{elseif $dataObject->reset_acc_status == 4}
    <div class="form-group notice-error settings-error notice is-dismissible">
        <ul>
            <li>{$dataObject->reset_acc_msg}</li>
        </ul>
        <button type="button" class="notice-dismiss">
            <span class="screen-reader-text"></span>
        </button>
    </div>
{/if}
<div class="card-body ups-config-account-area" id="container_focus_show">
    <div class="form-group ups-payment">
        <div class="row">
            <div class="col-md-12">
                <form method="POST" id="form_account"  action="{$dataObject->action_form}">
                    <div class="form-group">
                        <span>{$dataObject->lang['infor_more_account']}</span>
                    </div>
                    <div class="form-group">
                        <h6>{$dataObject->lang['your_ups_profile']}</h6>
                    </div>
                    <div class="form-group xl-fix-success-account row ml-0 mr-0">
                        <div class="col-sm-12 col-md-6 left pr-md-0">
                            <div class="form-group mb-0 row">
                                <label for="business-name" class="parent-width-1 col-sm-4 left-fix strong text-sm-right">
                                    {$dataObject->lang["full_name_success"]}:
                                </label>
                                <label class="col-sm-8 right-fix">
                                    {stripslashes($dataObject->default_account["fullname"]|escape:'htmlall':'UTF-8')}
                                </label>
                            </div>
                            <div class="form-group mb-0 row">
                                <label for="company-name" class="col-sm-4 left-fix strong text-sm-right">
                                    {$dataObject->lang["company"]}:
                                </label>
                                <label class="col-sm-8 right-fix">
                                    {stripslashes($dataObject->default_account["company"]|escape:'htmlall':'UTF-8')}
                                </label>
                            </div>
                            <div class="form-group mb-0 row">
                                <label for="email-address" class="col-sm-4 left-fix strong text-sm-right">
                                    {$dataObject->lang["email"]}:
                                </label>
                                <label class="col-sm-8 right-fix">
                                    {stripslashes($dataObject->default_account["email"]|escape:'htmlall':'UTF-8')}
                                </label>
                            </div>
                            <div class="form-group mb-0 row">
                                <label for="phone-number" class="col-sm-4 left-fix strong text-sm-right">
                                    {$dataObject->lang["phone_number"]}:
                                </label>
                                <label class="col-sm-8 right-fix">
                                    {stripslashes($dataObject->default_account["phone_number"]|escape:'htmlall':'UTF-8')}
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 right pl-md-0">
                            <div class="form-group mb-0 row">
                                <label for="address-street" class="col-sm-4 left-fix strong text-sm-right">
                                    {$dataObject->lang['pickup_address']}:
                                </label>
                                <label class="col-sm-8 right-fix">
                                    <span class="text-nowrap">
                                        {stripslashes($dataObject->default_account["address_1"]|escape:'htmlall':'UTF-8')}
                                    </span><br/>
                                    <span class="text-nowrap">
                                        {stripslashes($dataObject->default_account["address_2"]|escape:'htmlall':'UTF-8')}
                                    </span><br/>
                                    <span class="text-nowrap">
                                        {stripslashes($dataObject->default_account["address_3"]|escape:'htmlall':'UTF-8')}
                                    </span>
                                </label>
                            </div>
                            <div class="form-group mb-0 row">
                                <label for="postal-code" class="col-sm-4 left-fix strong text-sm-right">
                                    {$dataObject->lang['pickup_postal_code']}:
                                </label>

                                <label class="col-sm-2 right-fix pr-sm-0">
                                    {$dataObject->default_account["postal_code"]}
                                </label>
                            </div>
                            <div class="form-group mb-0 row">
                                <label for="postal-code" class="col-sm-4 left-fix strong text-sm-right">
                                    {$dataObject->lang['city']}:
                                </label>
                                <label class="col-sm-2 right-fix pr-sm-0">
                                    {stripslashes($dataObject->default_account["city"]|escape:'htmlall':'UTF-8')}
                                </label>
                            </div>
                            <div class="form-group mb-0 row">
                                <label for="address-country" class="col-4 col-sm-4 left-fix strong text-sm-right">
                                    {$dataObject->lang['Country/Territory']}:
                                </label>
                                <label for="address-country" class="col-sm-2 right-fix pr-sm-0">
                                    {if $dataObject->default_account["country"]}
                                    {$dataObject->country_list_define[$dataObject->default_account["country"]]["name"]}{/if}
                                </label>
                            </div>
                            {if $dataObject->default_account["state"] != 'XX'}
                                <div class="form-group mb-0 row">
                                    <label for="postal-code" class="col-sm-4 left-fix strong text-sm-right">
                                        {$dataObject->lang['State']}:
                                    </label>
                                    <label class="col-sm-2 right-fix pr-sm-0">
                                        {$dataObject->default_account["state"]}
                                    </label>
                                </div>
                            {/if}
                        </div>
                    </div>

                    <div class="change_user_pass">
                        <div class="row-pull">
                            <div class="form-group mb-3">
                                <a href="javascript:;" onclick="account.showResetSlider();">
                                    Change username and password
                                    <i class="fa fa-chevron-circle-down" id="resetAccIcon"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="change_user_pass_container" {if !$dataObject->validate}style="display: none;"{/if}>
                        <div class="col-sm-12 left">
                            <div class="form-group row">
                                <label for="reset-name" class="children-width-1 col-sm-5 left-fix col-lg-3 strong text-sm-right label-fix" style="padding-right: 0px;">
                                    {$dataObject->lang["reset_name"]}:
                                </label>
                                <div class="col-sm-7 right-fix col-lg-9 col-xl-6">
                                    <input type="text" autocomplete="off" name="reset_name" maxlength="50" value="" class="width-with-tooltip {if isset($dataObject->validate["reset_name"])}formValidate{/if}"  id="form_address_type" placeholder="{$dataObject->lang['reset_name_des']}"  />
                                    <a tabindex=-1 class="" data-toggle="tooltip" data-placement="top" title="{$dataObject->lang['tooltip_reset_name']}" href="javascript:;"><i class="fa fa-question-circle"></i></a>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="reset-pass" class="children-width-1 col-sm-5 left-fix col-lg-3 strong text-sm-right label-fix" style="padding-right: 0px;">
                                    {$dataObject->lang["reset_pass"]}:
                                </label>
                                <div class="col-sm-7 right-fix col-lg-9 col-xl-6">
                                    <input type="text" autocomplete="off" name="reset_pass" maxlength="50" value="" class="width-with-tooltip {if isset($dataObject->validate["reset_pass"])}formValidate{/if}"  id="form_address_type" placeholder="{$dataObject->lang['reset_pass_des']}"  />
                                    <a tabindex=-1 class="" data-toggle="tooltip" data-placement="top" title="{$dataObject->lang['tooltip_reset_pass']}" href="javascript:;"><i class="fa fa-question-circle"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="">
                        <button type="button" class="button button-primary btn-reset-pass mb-3" {if !$dataObject->validate}style="display: none;"{/if}>{$dataObject->lang["procced_change"]}</button>
                    </div>

                    <div class="form-group">
                        <h6>{$dataObject->lang['your_payment_profile']}</h6>
                    </div>

                    <div class="ups-payment form-group row">
                        {foreach $dataObject->list_accouts as $item}
                            <div class="{if (count($dataObject->list_accouts) > 3)}col-md-3{else}col-md-4{/if} col-sm-6 col-xs-12">
                                <div class=""><strong>{stripslashes($item->address_type|escape:'htmlall':'UTF-8')}</strong></div>
                                <div  class="text-nowrap font-italic"><span>{$dataObject->lang["account_number"]}: </span> {$item->ups_account_number}</div>
                                <div  class="text-nowrap font-italic"><span>{$dataObject->lang["pickup_postal_code"]}: </span> {$item->postal_code}</div>
                                <div  class="font-italic"><span>{$dataObject->lang['Country/Territory']}: </span>{$dataObject->country_list_define[$item->country]["name"]}</div>

                                {if  $item->account_default ne "1"}<a href="javascript:;" onclick="account.confirm('{$item->account_id}');">{$dataObject->lang["remove"]}</a>{/if}
                            </div>
                        {/foreach}
                    </div>

                    <div class="add_account_number">
                        <div class="row-pull">
                            <div class="form-group mb-1">
                                <a href="javascript:;" onclick="account.showSlider();">
                                    <i class="fa fa-plus-circle"></i>
                                    {$dataObject->lang['add_another_account_number']}
                                </a>
                            </div>
                        </div>
                    </div>

                    <div  class="__contanierAdd" {if !$dataObject->validate}style="display: none;"{/if}>
                        <div class="row-pull">
                            <small class="form-text text-muted pl-3 mb-2">
                                {$dataObject->lang['des1']}
                            </small>
                        </div>
                        <div class="row-pull">
                            <small class="form-text text-muted pl-3 mb-2">
                                {$dataObject->lang['infor_more_account_note']}
                            </small>
                        </div>
                        <div class="_infoAccount xl-fix-success-account">
                            <div class="col-sm-12 left">
                                <div class="form-group row">
                                    <label for="address-type" class="children-width-1 col-sm-5 left-fix col-lg-3 strong text-sm-right label-fix">
                                        {$dataObject->lang["address_type"]}:
                                    </label>
                                    <div class="col-sm-7 right-fix col-lg-9 col-xl-6">
                                        <input type="text" autocomplete="off" name="address_type" maxlength="50" value="{stripslashes($dataObject->form->address_type|escape:'htmlall':'UTF-8')}"  class="width-with-tooltip {if isset($dataObject->validate["address_type"])}formValidate{/if}"  id="form_address_type" placeholder="{$dataObject->lang['address_type_des']}"  />
                                        <a tabindex=-1 class="" data-toggle="tooltip" data-placement="top" title="{$dataObject->lang['tooltip_address_type']}" href="javascript:;"><i class="fa fa-question-circle"></i></a>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="name" class="children-width-1 col-sm-5 left-fix col-lg-3 strong text-sm-right label-fix">
                                        {$dataObject->lang["account_name"]}:<i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-7 right-fix col-lg-9 col-xl-6">
                                        <input type="text" autocomplete="off" name="ups_account_name" maxlength="35" value="{stripslashes($dataObject->form->ups_account_name|escape:'htmlall':'UTF-8')}"   class="width-with-tooltip {if isset($dataObject->validate["ups_account_name"])}formValidate{/if}"  id="form_company"/>
                                        <a tabindex=-1 class="" data-toggle="tooltip" data-placement="top" title="{$dataObject->lang['tooltip_account_name']}" href="javascript:;"><i class="fa fa-question-circle"></i></a>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="address-form_address_1" class="children-width-1 col-sm-5 left-fix col-lg-3 strong text-sm-right label-fix">
                                        {$dataObject->lang['pickup_address']}:<i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-7 right-fix col-lg-9 col-xl-6">
                                        <input type="text" autocomplete="off" name="address_1" maxlength="35" id="form_address_1" value="{stripslashes($dataObject->form->address_1|escape:'htmlall':'UTF-8')}"  class="width-with-tooltip {if isset($dataObject->validate["address_1"])}formValidate{/if}" placeholder="{$dataObject->lang['address_des']}">
                                        <a tabindex=-1 class="" data-toggle="tooltip" data-placement="top" title="{$dataObject->lang['tooltip_pickup_address']}" href="javascript:;"><i class="fa fa-question-circle"></i></a>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="address-apartment" class="children-width-1 col-sm-5 left-fix col-lg-3 strong text-sm-right label-fix">
                                    </label>
                                    <div class="col-sm-7 right-fix col-lg-9 col-xl-6">
                                        <input type="text" autocomplete="off" name="address_2" maxlength="35" value="{stripslashes($dataObject->form->address_2|escape:'htmlall':'UTF-8')}"  class="width-with-tooltip" id="form_address_2" placeholder="{$dataObject->lang['address_des1']}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="address-department" class="children-width-1 col-sm-5 left-fix col-lg-3 strong text-sm-right label-fix">
                                    </label>
                                    <div class="col-sm-7 right-fix col-lg-9 col-xl-6">
                                        <input type="text" autocomplete="off" name="address_3" maxlength="35" value="{stripslashes($dataObject->form->address_3|escape:'htmlall':'UTF-8')}"  class="width-with-tooltip " id="form_address_3" placeholder="{$dataObject->lang['address_des2']}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="postal_code" class="children-width-1 col-sm-5 left-fix col-lg-3 strong text-sm-right label-fix">
                                        {$dataObject->lang['pickup_postal_code']}:<i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-7 right-fix col-lg-9 col-xl-6">
                                        <input type="text" autocomplete="off" maxlength="9" name="postal_code" value="{stripslashes($dataObject->form->postal_code|escape:'htmlall':'UTF-8')}"  class="width-with-tooltip {if isset($dataObject->validate["postal_code"])}formValidate{/if}" id="form_postal_code" />
                                        <a tabindex=-1 class="" data-toggle="tooltip" data-placement="top" title="{$dataObject->lang['tooltip_pickup_postal_code']}" href="javascript:;"><i class="fa fa-question-circle"></i></a>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="city" class="children-width-1 col-sm-5 left-fix col-lg-3 strong text-sm-right label-fix">
                                        {$dataObject->lang['city']}:<i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-7 right-fix col-lg-9 col-xl-6">
                                        <input type="text" autocomplete="off" name="city" maxlength="30" value="{stripslashes($dataObject->form->city|escape:'htmlall':'UTF-8')}"  class="width-with-tooltip {if isset($dataObject->validate["city"])}formValidate{/if}"  id="form_city">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="form_country" class="children-width-1 col-sm-5 left-fix col-lg-3 strong text-sm-right label-fix">
                                        {$dataObject->lang['Country/Territory']}:
                                    </label>
                                    <div class="col-sm-7 right-fix col-lg-9 col-xl-6">
                                        <input type="text" autocomplete="off" value="{stripslashes($dataObject->country_list_define[$dataObject->form->country]['name']|escape:'htmlall':'UTF-8')}"   id="form_country" class="width-with-tooltip {if isset($dataObject->validate["country"])}formValidate{/if}"  disabled=""/>
                                        <input type="hidden" name="country" value="{stripslashes($dataObject->form->country|escape:'htmlall':'UTF-8')}"/>
                                    </div>
                                </div>

                                {if count($dataObject->lang["list_state"]) > 0}
                                    <div class="form-group row">
                                        <label for="state" class="children-width-1 col-sm-5 left-fix col-lg-3 strong text-sm-right label-fix">
                                            {$dataObject->lang['State']}
                                        </label>
                                        <div class="col-sm-7 right-fix col-lg-9 col-xl-6">
                                            <select class="form-control" tabindex="0" id="state" name="state" style="width: 90%">
                                                {foreach from=$dataObject->lang["list_state"] key=k item=v}
                                                    <option value="{$k}" {if $dataObject->form->state == $k} selected {/if}>{$v}</option>
                                                {/foreach}
                                            </select>
                                        </div>
                                    </div>
                                {else}
                                    <input type="hidden" name="state" value="XX"/>
                                {/if}

                                <div class="form-group row">
                                    <label for="form_phone_number" class="children-width-1 col-sm-5 left-fix col-lg-3 strong text-sm-right label-fix">
                                        {$dataObject->lang['phone']}:<i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-7 right-fix col-lg-9 col-xl-6">
                                        <input type="text" autocomplete="off" maxlength="15" value="{stripslashes($dataObject->form->phone_number|escape:'htmlall':'UTF-8')}" name="phone_number" class="width-with-tooltip {if isset($dataObject->validate["phone_number"])}formValidate{/if}"  id="form_phone_number"/>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="_containHadAccount xl-fix-success-account">
                            <div class="col-12">
                                <div class="form-group form-checkbox mb-0">
                                    <label for="have-account">
                                        <input type="radio" {if $dataObject->form->account_type eq "1"}checked="true"{/if} value="1" id="have-account" name="account_type"/>
                                        <strong> {$dataObject->lang['have_account_1']}</strong>
                                    </label>
                                </div>
                                <div class="form-group form-content {if $dataObject->form->account_type != 1}d-none{/if}">
                                    <div class="form-group row">
                                        <small class="form-text text-muted pl-4 mt-0">
                                            {$dataObject->lang['have_account_1_pls']}
                                        </small>
                                    </div>
                                    <div class="form-group row mb-0">
                                        <div class="col-sm-12 left">
                                            <div class="form-group row more-info-area">
                                                <label for="account-number" class="children-width-1 col-sm-5 left-fix col-lg-3 strong text-sm-right label-fix">
                                                    {$dataObject->lang['account_number']}:<i class="text-danger">*</i>
                                                </label>
                                                <div class="col-sm-7 right-fix col-lg-9 col-xl-6">
                                                    <input id="had_acc_ups_account_number" type="text" autocomplete="off" name="have_with_invoice[ups_account_number]" maxlength="6"  value="{if $dataObject->form->account_type eq '1'}{stripslashes($dataObject->form->ups_account_number|escape:'htmlall':'UTF-8')}{/if}"  class="width-with-tooltip {if $dataObject->form->account_type eq '1'}{if isset($dataObject->validate['ups_account_number'])}formValidate{/if}{/if}" id="start-new-acc-account-number">
                                                    <a tabindex=-1 class="" data-toggle="tooltip" data-placement="top" title="{$dataObject->lang['tooltip_account_number']}" href="javascript:;"><i class="fa fa-question-circle"></i></a>
                                                </div>
                                            </div>

                                            <div class="form-group row more-info-area">
                                                <label for="invoice-number" class="children-width-1 col-sm-5 left-fix col-lg-3 strong text-sm-right label-fix">
                                                    {$dataObject->lang['invoice_number']}:<i class="text-danger">*</i>
                                                </label>
                                                <div class="col-sm-7 right-fix col-lg-9 col-xl-6">
                                                    <input id="had_acc_ups_invoice_number" maxlength="15" type="text" autocomplete="off" name="have_with_invoice[ups_invoice_number]" value="{stripslashes($dataObject->form->ups_invoice_number|escape:'htmlall':'UTF-8')}"  class="width-with-tooltip {if $dataObject->form->account_type eq "1"}{if isset($dataObject->validate["ups_invoice_number"])}formValidate{/if}{/if}" id="start-new-acc-invoice-number">
                                                    <a tabindex=-1 class="" data-toggle="tooltip" data-placement="top" title="{$dataObject->lang['tooltip_invoice_number']}" href="javascript:;"><i class="fa fa-question-circle"></i></a>
                                                </div>
                                            </div>

                                            {if $dataObject->default_account["state"] != 'XX'}
                                                <div class="form-group row more-info-area">
                                                    <label for="invoice-number" class="children-width-1 col-sm-5 left-fix col-lg-3 strong text-sm-right label-fix">
                                                        {$dataObject->lang['control id']}:<i class="text-danger">*</i>
                                                    </label>
                                                    <div class="col-sm-7 right-fix col-lg-9 col-xl-6">
                                                        <input id="had_acc_ups_invoice_number" maxlength="15" type="text" autocomplete="off" name="have_with_invoice[ups_control_id]" value="{stripslashes($dataObject->form->ups_control_id|escape:'htmlall':'UTF-8')}"  class="width-with-tooltip {if $dataObject->form->account_type eq "1"}{if isset($dataObject->validate["ups_control_id"])}formValidate{/if}{/if}" id="start-new-acc-control-id">
                                                    </div>
                                                </div>
                                            {/if}

                                            <div class="form-group row more-info-area">
                                                <label for="invoice-amount" class="children-width-1 col-sm-5 left-fix col-lg-3 strong text-sm-right label-fix">
                                                    {$dataObject->lang['invoice_amount']}:<i class="text-danger">*</i>
                                                </label>
                                                <div class="col-sm-7 right-fix col-lg-9 col-xl-6">
                                                    <input type="text" autocomplete="off" name="have_with_invoice[ups_invoice_amount]" maxlength="19" value="{if $dataObject->form->account_type eq '1'}{stripslashes($dataObject->form->ups_invoice_amount|escape:'htmlall':'UTF-8')}{/if}" class="width-with-tooltip {if $dataObject->form->account_type eq '1'}{if isset($dataObject->validate['ups_invoice_amount'])}formValidate{/if}{/if}" id="start-new-acc-invoice-amount">
                                                    <a tabindex=-1 class="" data-toggle="tooltip" data-placement="top" title="{$dataObject->lang['tooltip_invoice_amount']}" href="javascript:;"><i class="fa fa-question-circle"></i></a>
                                                </div>
                                            </div>


                                            <div class="form-group row more-info-area">
                                                <label for="invoice-currency" class="children-width-1 col-sm-5 left-fix col-lg-3 strong text-sm-right label-fix">
                                                    {$dataObject->lang['currency']}:<i class="text-danger">*</i>
                                                </label>
                                                <div class="col-sm-7 right-fix col-lg-9 col-xl-6">
                                                    <select style="width: 90%;" name="have_with_invoice[ups_currency]" class="width-with-tooltip"  id="start-new-acc-invoice-currency">
                                                        {html_options options=$dataObject->currency_list selected=$dataObject->form->ups_currency}
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-12 left">
                                            <div class="clearfix"></div>
                                            <div class="form-group row more-info-area">
                                                <label for="invoice-date" class="children-width-1 col-sm-5 left-fix col-lg-3 strong text-sm-right label-fix">
                                                    {$dataObject->lang['invoice_date']}:<i class="text-danger">*</i>
                                                </label>
                                                <div class="col-sm-7 right-fix col-lg-9 col-xl-6">
                                                    <input id="had_acc_ups_invoice_date" type="text" readonly="true" autocomplete="off" name="have_with_invoice[ups_invoice_date]" value="{stripslashes($dataObject->form->ups_invoice_date|escape:'htmlall':'UTF-8')}" class= "width-with-tooltip {if $dataObject->form->account_type eq "1"}{if isset($dataObject->validate["ups_invoice_date"])}formValidate{/if}{/if}" id="start-new-acc-invoice-date">
                                                    <a data-toggle="tooltip" data-placement="top" title="{$dataObject->lang['tooltip_invoice_date']}" href="javascript:;"><i class="fa fa-question-circle"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="_containWithOutAccount xl-fix-success-account mt-2">
                            <div class="col-12">
                                <div class="form-group form-checkbox">
                                    <label for="have-account-without-invoice">
                                        <input type="radio" value="2" id="have-account-without-invoice" name="account_type" {if $dataObject->form->account_type != 1}checked="true"{/if} />
                                        <strong>{$dataObject->lang['have_account_without_invoice']}</strong>
                                    </label>
                                </div>

                                <div class="form-group row form-content {if $dataObject->form->account_type == 1}d-none{/if}">
                                    <div class="col-sm-12 left">
                                        <div class="form-group row more-info-area">
                                            <label for="account-number" class="children-width-1 col-sm-5 left-fix col-lg-3 strong text-sm-right label-fix">
                                                {$dataObject->lang['account_number']}:<i class="text-danger">*</i>
                                            </label>
                                            <div class="col-sm-7 right-fix col-lg-9 col-xl-6">
                                                <input type="text" autocomplete="off" name="have_without_invoice[ups_account_number]" maxlength="6" value="{if $dataObject->form->account_type eq '2'}{stripslashes($dataObject->form->ups_account_number|escape:'htmlall':'UTF-8')}{/if}" class="width-with-tooltip {if $dataObject->form->account_type eq '2'}{if isset($dataObject->validate['ups_account_number'])}formValidate{/if}{/if}"  id="without_acc_ups_account_number">
                                                <a tabindex=-1 class="" data-toggle="tooltip" data-placement="top" title="{$dataObject->lang['tooltip_account_number']}" href="javascript:;"><i class="fa fa-question-circle"></i></a>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <button type="button" class="button button-primary btn-verify-account" {if !$dataObject->validate}style="display: none;"{/if}>{$dataObject->lang["verify"]}</button>
                        <button type="button" class="button button-primary pull-right btn-shipping-config-next">{$dataObject->lang["btn_next"]}</button>
                        <input type="hidden" id="btn_controller" name="btn_controller" value=""/>
                        <input type="hidden" id="id_remove" name="id_remove" value=""/>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>
<input type="hidden" id="confirm_remove_account" value="{$dataObject->lang["confirm_remove_account"]}">
<input type="hidden" id="remove_account" value="{$dataObject->lang["RemoveAccount"]}">

<style>
</style>
<script type="text/javascript">
    (function ($) {
        'use strict';
        $(document).ready(function () {
            $("#had_acc_ups_invoice_date").datepicker({
                format: 'mm/dd/yyyy',
                orientation: "top",
                language: "en",
                templates: {
                    leftArrow: ' ',
                    rightArrow: ' '
                },
                autoclose: true
            });
            $('._containHadAccount .form-checkbox input[type="radio"]').change(function () {
                if ($(this).is(':checked')) {
                    $('._containHadAccount .form-content').removeClass("d-none");
                    $('._containWithOutAccount .form-content').addClass("d-none");
                }
            });
            $('._containWithOutAccount .form-checkbox input[type="radio"]').change(function () {
                if ($(this).is(':checked')) {
                    $('._containHadAccount .form-content').addClass("d-none");
                    $('._containWithOutAccount .form-content').removeClass("d-none");
                }
            });
        });
        var account ={};
        account.confirm = function (id) {
            $(".btn-confirm-message").attr("data-id", id);
            alertMessage($("#confirm_remove_account").val(), $("#remove_account").val());
        }
        $(document).on('click', '.btn-confirm-message', function () {
            var id = $(this).data('id');
            $("#btn_controller").val("remove");
            $("#id_remove").val(id);
            $(this).prop('disabled', true);
            $("#form_account").submit();
        });

        account.showSlider = function () {
            $(".__contanierAdd").slideToggle("show");
            $(".btn-verify-account").slideToggle("show");
        };
        $(document).ready(function () {
            $(".btn-verify-account").click(function () {
                $(this).prop('disabled', true);
                $("#btn_controller").val("verify");
                $("#form_account").submit();
            });
            $(".btn-shipping-config-next").click(function () {
                $(this).prop('disabled', true);
                $("#btn_controller").val("next");
                $("#form_account").submit();
            });
            $(".btn-reset-pass").click(function () {
                $(this).prop('disabled', true);
                $("#btn_controller").val("pwd_reset");
                $("#form_account").submit();
            });
            window.account = account;
        });

        account.showResetSlider = function () {
            // var cont_state = $(".change_user_pass_container").is(":hidden");
            // console.log(cont_state)
            if ($(".change_user_pass_container").is(":hidden")) {
                $("#resetAccIcon").attr('class', 'fa fa-chevron-circle-up');
            } else {
                $("#resetAccIcon").attr('class', 'fa fa-chevron-circle-down');
            }
            $(".btn-reset-pass").slideToggle("show");
            $(".change_user_pass_container").slideToggle("show");
        };

        {literal}
            jQuery(document).ready(function(jQuery) {
                setTimeout(function() {
                    if (typeof jQuery.datepicker != "undefined") {
                        if (typeof jQuery.datepicker.setDefaults != "undefined") {
                            jQuery.datepicker.setDefaults({"closeText":"Close", "currentText":"Today", "dateFormat":"mm/dd/yy"});
                        }
                    }
                }, 200);
            });
        {/literal}
    }
    )(jQuery);
</script>
