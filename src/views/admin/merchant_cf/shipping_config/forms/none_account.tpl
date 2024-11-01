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
    {if is_array($dataObject->validate) && !empty($dataObject->validate)  }
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
<div class="ups-config-account-area">
    <div class="ups-payment">
        <div class="form-group">
            <span>{$dataObject->lang['infor_more_account']}</span>
        </div>
        {* <div class="form-group">
            <strong class="title3">{$dataObject->lang['infor_more_account_note']}</strong>
        </div> *}
        <form method="POST" action="{$dataObject->action_form}" id="fm-start-new-acc">
            <div style="background: #e9e9e9;">
                <h3 style="text-align: center; padding: 10px;">Step 1: Account Linking</h3>
            </div>
            <div style="padding: 0px 20px 0px 20px;">
                <div class="form-group">
                    <strong class="title3">{$dataObject->lang["form_title1"]}</strong>
                </div>
                <div class="_containWithAccountPass xl-fix-none-account">
                    <div class="form-group form-checkbox">
                        <label for="have-account-with-accpass">
                            <input type="radio" id="have-account-with-accpass" value="4"
                                   {if $dataObject->form->account_type == 4}checked{/if} name="account_type"/>
                            <b> {$dataObject->lang['have_ups_acc_with_accpass']}
                            </b>
                        </label>
                    </div>

                    <div class="form-group form-content row {if $dataObject->form->account_type != 4}d-none{/if}">
                        <div class="col-sm-12 col-xl-6 center">
                            <div class="form-group row more-info-area">
                                <label for="start-new-acc-with-account-name" class="col-sm-3 left-fix text-sm-right label-fix strong">
                                    {$dataObject->lang['account_name']}:<i class="text-danger">*</i>
                                </label>
                                <div class="col-sm-8 right-fix">
                                    <input type="text" autocomplete="off" maxlength="35" name="have_with_accpass[ups_account_name]" value="{if $dataObject->form->account_type eq "4"}{stripslashes($dataObject->form->ups_account_name|escape:'htmlall':'UTF-8')}{/if}" class="width-with-tooltip {if isset($dataObject->validate["ups_account_name"])}formValidate{/if}" id="start-new-acc-with-account-name">
                                    <a tabindex=-1 class="" data-toggle="tooltip" data-placement="top" title="{$dataObject->lang['tooltip_account_name']}" href="javascript:;"><i class="fa fa-question-circle"></i></a>
                                </div>
                            </div>
                            <div class="form-group row more-info-area">
                                <label for="start-new-acc-with-account-no" class="col-sm-3 left-fix text-sm-right label-fix strong">
                                    {$dataObject->lang['account_number']}:<i class="text-danger">*</i>
                                </label>
                                <div class="col-sm-8 right-fix">
                                    <input type="text" autocomplete="off" name="have_with_accpass[ups_account_number]" maxlength="6" value="{if $dataObject->form->account_type eq "4"}{stripslashes($dataObject->form->ups_account_number|escape:'htmlall':'UTF-8')}{/if}" class="width-with-tooltip {if isset($dataObject->validate["ups_account_number"])}formValidate{/if}" id="start-new-acc-with-account-no">
                                    <a tabindex=-1 class="" data-toggle="tooltip" data-placement="top" title="{$dataObject->lang['tooltip_account_number']}" href="javascript:;"><i class="fa fa-question-circle"></i></a>
                                </div>
                            </div>
                            <div class="form-group row more-info-area">
                                <label for="start-new-acc-with-account-user" class="col-sm-3 left-fix text-sm-right label-fix strong">
                                    {$dataObject->lang['account_username']}:<i class="text-danger">*</i>
                                </label>
                                <div class="col-sm-8 right-fix">
                                    <input type="text" maxlength="35" autocomplete="off" name="have_with_accpass[ups_account_u_name]" value="{if $dataObject->form->account_type eq "4"}{stripslashes($dataObject->form->ups_account_u_name|escape:'htmlall':'UTF-8')}{/if}" class="width-with-tooltip {if isset($dataObject->validate["ups_account_u_name"])}formValidate{/if}" id="start-new-acc-with-account-user">
                                    <a tabindex=-1 class="" data-toggle="tooltip" data-placement="top" title="{$dataObject->lang['tooltip_account_username']}" href="javascript:;"><i class="fa fa-question-circle"></i></a>
                                </div>
                            </div>
                            <div class="form-group row more-info-area">
                                <label for="start-new-acc-with-account-pwd" class="col-sm-3 left-fix text-sm-right label-fix strong">
                                    {$dataObject->lang['account_password']}:<i class="text-danger">*</i>
                                </label>
                                <div class="col-sm-8 right-fix">
                                    <input type="password" style="width: 90%;" autocomplete="off" name="have_with_accpass[ups_account_password]" maxlength="35" class="width-with-tooltip {if isset($dataObject->validate["ups_account_password"])}formValidate{/if}"  id="start-new-acc-with-account-pwd">
                                    <a tabindex=-1 class="" data-toggle="tooltip" data-placement="top" title="{$dataObject->lang['tooltip_account_password']}" href="javascript:;"><i class="fa fa-question-circle"></i></a>
                                </div>
                            </div>
                            {* <div class="form-group row more-info-area" style="margin-bottom: 0px;">
                                <label for="start-new-acc-with-account-access" class="col-sm-3 left-fix text-sm-right label-fix strong">
                                    {$dataObject->lang['account_access']}:<i class="text-danger">*</i>
                                </label>
                                <div class="col-sm-8 right-fix">
                                    <input type="password" style="width: 90%;" autocomplete="off" name="have_with_accpass[ups_account_access]" maxlength="35" class="width-with-tooltip {if isset($dataObject->validate["ups_account_access"])}formValidate{/if}"  id="start-new-acc-with-account-access">
                                    <a tabindex=-1 class="" data-toggle="tooltip" data-placement="top" title="{$dataObject->lang['tooltip_account_access']}" href="javascript:;"><i class="fa fa-question-circle"></i></a>
                                </div>
                            </div> *}
                        </div>
                        {* <div class="row-pull des_footer_none_acc"> *}
                        {* <div class="useful-info">
                            <p><b>Useful Info:-</b><br>
                                <span>{$dataObject->lang['des_footer_access_key']}</span>
                                <span style="color:#1e91cf;">
                                    <br>
                                    <
                                    <a target="_blank" style="color:#1e91cf;" href="{$dataObject->lang['des_footer_access_link']}">
                                        {$dataObject->lang['des_footer_access_link']}
                                    </a>
                                    >
                                </span>
                            </p>
                        </div> *}
                    </div>
                </div>
                <div class="_containNoHaveAccount  xl-fix-none-account">
                    <div class="form-group form-checkbox">
                        <label for="start-new-acc-not-have-account">
                            <input type="radio" id="start-new-acc-not-have-account" {if $dataObject->form->account_type == 3}checked{/if}  value="3"  name="account_type"/>
                            <b> {$dataObject->lang['not_have_ups_acc']}</b>
                            {if ($dataObject->lang['countryCode'] == 'US')}
                                <i><a href="https://www.ups.com/assets/resources/media/en_US/CP3_US.pdf" target="_blank">See UPS Terms of Service</a></i>
                            {/if}
                        </label>
                    </div>
                    <div class="form-group form-content row {if $dataObject->form->account_type != 3}d-none{/if}">
                        {if ($dataObject->lang['countryCode'] == "US")}
                            <div class="form-group row">
                                <small class="form-text text-muted pl-4">
                                    {$dataObject->lang['ups_account_vatnumber_notes']}
                                </small>
                            </div>
                        {/if}
                        <div class="col-sm-12 col-xl-6 left" style="padding: 50px 0;">
                            <div class="form-group row more-info-area">
                                <label for="hadnoaccount_number_vat" class="col-sm-5 left-fix text-sm-right label-fix strong">
                                    {$dataObject->lang['ups_account_vatnumber']}:
                                </label>
                                <div class="col-sm-7 right-fix">
                                    <input type="text" maxlength="15" autocomplete="off" name="ups_account_vatnumber" value="{if $dataObject->form->ups_account_vatnumber}{stripslashes($dataObject->form->ups_account_vatnumber|escape:'htmlall':'UTF-8')}{/if}" class="width-with-tooltip" id="hadnoaccount_number_vat"/>
                                </div>

                            </div><br>
                            {if ($dataObject->lang['countryCode'] != "US")}
                                <div class="form-group row more-info-area">
                                    <label for="hadnoaccount_acc_promocode" class="col-sm-5 left-fix text-sm-right label-fix strong">
                                        {$dataObject->lang['ups_account_promocode']}:
                                    </label>
                                    <div class="col-sm-7 right-fix">
                                        <input type="text" maxlength="9" autocomplete="off" name="ups_account_promocode"  value="{if $dataObject->form->ups_account_promocode}{$dataObject->form->ups_account_promocode}{/if}" class="width-with-tooltip "  id="hadnoaccount_acc_promocode"/>
                                    </div>
                                </div>
                            {/if}
                        </div>
                        <div class="useful-info">
                            <p>
                                <b>Useful Info:-</b><br>
                                <span>{$dataObject->lang['des_footer1']}</span><br>
                                <span>{$dataObject->lang['des_footer2']}</span><br>
                                <span>{$dataObject->lang['des_footer3']}</span><br>
                                <span style="color:#1e91cf;">
                                    <
                                    <a target="_blank" style="color:#1e91cf;" href="{$dataObject->lang['des_footer4_link']}">
                                        {$dataObject->lang['des_footer4_link']}
                                    </a>
                                    >
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="_containHadAccount xl-fix-none-account">
                    {* <div class="form-group form-checkbox">
                        <label for="start-new-acc-have-account">
                            <input type="radio" id="start-new-acc-have-account"
                                   {if $dataObject->form->account_type == 1}checked{/if} value="1" name="account_type"/>
                            <b> {$dataObject->lang['have_ups_acc_with_invoice']}</b>
                        </label>
                    </div> *}
                    <div class="form-group form-content {if $dataObject->form->account_type != 1}d-none{/if}">
                        <div class="form-group row">
                            <small class="form-text text-muted pl-4">
                                {$dataObject->lang['have_ups_acc_with_invoice_title']}
                            </small>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-sm-12 col-xl-6 left">
                                <div class="form-group row form-group row more-info-area">
                                    <label for="start-new-acc-account-name" class="col-sm-3 left-fix text-sm-right label-fix strong">
                                        {$dataObject->lang['account_name']}:<i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-8 right-fix">
                                        <input type="text" autocomplete="off" maxlength="35" name="have_with_invoice[ups_account_name]" value="{if $dataObject->form->account_type eq "1"}{stripslashes($dataObject->form->ups_account_name|escape:'htmlall':'UTF-8')}{/if}"  class="width-with-tooltip {if $dataObject->form->account_type eq "1"}{if isset($dataObject->validate["ups_account_name"])}formValidate{/if}{/if}" id="start-new-acc-account-name">
                                        <a tabindex=-1 class="" data-toggle="tooltip" data-placement="top" title="{$dataObject->lang['tooltip_account_name']}" href="javascript:;"><i class="fa fa-question-circle"></i></a>
                                    </div>
                                </div>

                                <div class="form-group row more-info-area">
                                    <label for="account-number" class="col-sm-3 left-fix text-sm-right label-fix strong">
                                        {$dataObject->lang['account_number']}:<i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-8 right-fix">
                                        <input type="text" autocomplete="off" name="have_with_invoice[ups_account_number]" maxlength="6"  value="{if $dataObject->form->account_type eq "1"}{$dataObject->form->ups_account_number}{/if}"  class="width-with-tooltip {if $dataObject->form->account_type eq "1"}{if isset($dataObject->validate["ups_account_number"])}formValidate{/if}{/if}" id="start-new-acc-account-number">
                                        <a tabindex=-1 class="" data-toggle="tooltip" data-placement="top" title="{$dataObject->lang['tooltip_account_number']}" href="javascript:;"><i class="fa fa-question-circle"></i></a>
                                    </div>
                                </div>

                                <div class="form-group row more-info-area">
                                    <label for="invoice-number" class="col-sm-3 left-fix text-sm-right label-fix strong">
                                        {$dataObject->lang['invoice_number']}:<i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-8 right-fix">
                                        <input type="text" maxlength="15" autocomplete="off" name="have_with_invoice[ups_invoice_number]" value="{if $dataObject->form->account_type eq "1"}{stripslashes($dataObject->form->ups_invoice_number|escape:'htmlall':'UTF-8')}{/if}"  class="width-with-tooltip {if $dataObject->form->account_type eq "1"}{if isset($dataObject->validate["ups_invoice_number"])}formValidate{/if}{/if}" id="start-new-acc-invoice-number">
                                        <a tabindex=-1 class="" data-toggle="tooltip" data-placement="top" title="{$dataObject->lang['tooltip_invoice_number']}" href="javascript:;"><i class="fa fa-question-circle"></i></a>
                                    </div>
                                </div>

                                {if ($dataObject->lang['countryCode'] == "US")}
                                    <div class="form-group row more-info-area">
                                        <label for="start-new-acc-control-id" class="col-sm-3 left-fix text-sm-right label-fix strong">
                                            {$dataObject->lang['control id']}:<i class="text-danger">*</i>
                                        </label>
                                        <div class="col-sm-8 right-fix">
                                            <input id="had_acc_ups_invoice_number" maxlength="15" type="text" autocomplete="off" name="have_with_invoice[ups_control_id]" value="{stripslashes($dataObject->form->ups_control_id|escape:'htmlall':'UTF-8')}"  class="width-with-tooltip {if $dataObject->form->account_type eq "1"}{if isset($dataObject->validate["ups_control_id"])}formValidate{/if}{/if}" id="start-new-acc-control-id">
                                        </div>
                                    </div>
                                {/if}

                                <div class="form-group row more-info-area">
                                    <label for="invoice-amount" class="col-sm-3 left-fix text-sm-right label-fix strong">
                                        {$dataObject->lang['invoice_amount']}:<i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-8 right-fix">
                                        <input type="text" autocomplete="off" name="have_with_invoice[ups_invoice_amount]" maxlength="19" value="{if $dataObject->form->account_type eq "1"}{$dataObject->form->ups_invoice_amount}{/if}" class="width-with-tooltip {if $dataObject->form->account_type eq "1"}{if isset($dataObject->validate["ups_invoice_amount"])}formValidate{/if}{/if}" id="start-new-acc-invoice-amount">
                                        <a tabindex=-1 class="" data-toggle="tooltip" data-placement="top" title="{$dataObject->lang['tooltip_invoice_amount']}" href="javascript:;"><i class="fa fa-question-circle"></i></a>
                                    </div>
                                </div>

                                <div class="form-group row more-info-area">
                                    <label for="invoice-amount" class="col-sm-3 left-fix text-sm-right label-fix strong">
                                        {$dataObject->lang['currency']}:<i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-8 right-fix">
                                        <select name="have_with_invoice[ups_currency]" class="width-with-tooltip {if 'ups_currency'|array_key_exists:$dataObject->validate}formValidate{/if}"  id="start-new-acc-invoice-currency">
                                            {html_options options=$dataObject->currency_list selected=$dataObject->form->ups_currency}
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row more-info-area">
                                    <label for="invoice-date" class="col-sm-3 left-fix text-sm-right label-fix strong">
                                        {$dataObject->lang['invoice_date']}:<i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-8 right-fix">
                                        <input type="text" readonly="true" name="have_with_invoice[ups_invoice_date]" value="{$dataObject->form->ups_invoice_date}" class="width-with-tooltip {if $dataObject->form->account_type eq "1"}{if isset($dataObject->validate["ups_invoice_date"])}formValidate{/if}{/if}" id="had_acc_ups_invoice_date">
                                        <a tabindex=-1 class="" data-toggle="tooltip" data-placement="top" title="{$dataObject->lang['tooltip_invoice_date']}" href="javascript:;"><i class="fa fa-question-circle"></i></a>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="_containWithOutAccount  xl-fix-none-account">
                    {* <div class="form-group form-checkbox">
                        <label for="have-account-without-invoice">
                            <input type="radio" id="have-account-without-invoice" value="2"
                                   {if $dataObject->form->account_type == 2}checked{/if}  name="account_type"/>
                            <b> {$dataObject->lang['have_ups_acc_without_invoice']}
                            </b></label>
                    </div> *}

                    <div class="form-group form-content row {if $dataObject->form->account_type != 2}d-none{/if}">
                        <div class="col-sm-12 col-xl-6 left">
                            <div class="form-group row more-info-area">
                                <label for="start-new-acc-account-name-without-invoice" class="col-sm-3 left-fix text-sm-right label-fix strong">
                                    {$dataObject->lang['account_name']}:<i class="text-danger">*</i>
                                </label>
                                <div class="col-sm-8 right-fix">
                                    <input type="text" maxlength="35" autocomplete="off" name="have_without_invoice[ups_account_name]" value="{if $dataObject->form->account_type eq "2"}{stripslashes($dataObject->form->ups_account_name|escape:'htmlall':'UTF-8')}{/if}" class="width-with-tooltip {if $dataObject->form->account_type eq "2"}{if isset($dataObject->validate["ups_account_name"])}formValidate{/if}{/if}" id="start-new-acc-account-name-without-invoice">
                                    <a tabindex=-1 class="" data-toggle="tooltip" data-placement="top" title="{$dataObject->lang['tooltip_account_name']}" href="javascript:;"><i class="fa fa-question-circle"></i></a>
                                </div>

                            </div>
                            <div class="form-group row more-info-area">
                                <label for="account-number" class="col-sm-3 left-fix text-sm-right label-fix strong">
                                    {$dataObject->lang['account_number']}:<i class="text-danger">*</i>
                                </label>
                                <div class="col-sm-8 right-fix">
                                    <input type="text" autocomplete="off" name="have_without_invoice[ups_account_number]" maxlength="6" value="{if $dataObject->form->account_type eq "2"}{$dataObject->form->ups_account_number}{/if}" class="width-with-tooltip {if $dataObject->form->account_type eq "2"}{if isset($dataObject->validate["ups_account_number"])}formValidate{/if}{/if}"  id="start-new-acc-account-number-without-invoice">
                                    <a tabindex=-1 class="" data-toggle="tooltip" data-placement="top" title="{$dataObject->lang['tooltip_account_number']}" href="javascript:;"><i class="fa fa-question-circle"></i></a>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div style="background: #e9e9e9;">
                <h3 style="text-align: center; padding: 10px;">Step 2: Merchant Details and Pickup Address</h3>
            </div>
            <div style="padding: 0px 20px 0px 20px;">
                <div class="form-group row">
                    <div class="col-sm-12 col-xl-6 pr-xl-0 xl-fix-none-account">
                        <div class="form-group row">
                            <label for="account-title" class="col-sm-3 left-fix text-sm-right label-fix strong">
                                {$dataObject->lang["title"]}:<i class="text-danger">*</i>
                            </label>
                            {$language_countries = ['pl_PL','de_DE','fr_BE','fr_FR','nl_BE','es_ES','it_IT','nl_NL']}
                            {$language_code = strtolower(substr(get_locale(), 0, 2))}
                            {$key_code_lang = $language_code|cat: "_"|cat: $dataObject->lang['countryCode']}
                            {$account_tiles = ['Mr', 'Miss', 'Mrs', 'Ms']}
                            {if (in_array($language_code, ['pl','de','nl']))}
                                {$account_tiles = ['Mr', 'Mrs']}
                            {/if}
                            {if (in_array($language_code, ['it','es']))}
                                {$account_tiles = ['Mr', 'Miss', 'Mrs']}
                            {/if}
                            {if ($dataObject->lang['countryCode'] == 'US')}
                                {$account_tiles = ['Mr', 'Miss', 'Mrs', 'Ms']}
                            {/if}
                            {if ($dataObject->lang['countryCode'] == 'PL')}
                                {if ($language_code == 'pl')}
                                    {$account_tiles = ['Mr', 'Mrs']}
                                {else}
                                    {$account_tiles = ['Mr', 'Miss', 'Mrs', 'Ms']}
                                {/if}
                            {/if}
                            <div class="col-sm-9 right-fix">
                                <select id="account-title" name="title"  value="{$dataObject->form->title}"  class="width-with-tooltip">
                                    {foreach $account_tiles as $title_item}
                                    {$item_title_small = strtolower($title_item)}
                                        <option {if $dataObject->form->title eq $item_title_small}selected{/if} value={$title_item}>{$dataObject->lang[$item_title_small]}</option>
                                    {/foreach}
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="business-name" class="col-sm-3 left-fix text-sm-right label-fix strong">
                                {$dataObject->lang["full_name"]}:<i class="text-danger">*</i>
                            </label>
                            <div class="col-sm-9 right-fix">
                                <input name="fullname" maxlength="35" value="{stripslashes($dataObject->form->fullname|escape:'htmlall':'UTF-8')}"  class="width-with-tooltip {if isset($dataObject->validate["fullname"])}formValidate{/if}"  type="text" autocomplete="off" id="start-new-acc-business-name">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="company-name" class="col-sm-3 left-fix text-sm-right label-fix strong">
                                {$dataObject->lang["company"]}:<i class="text-danger">*</i>
                            </label>
                            <div class="col-sm-9 right-fix">
                                <input name="company" maxlength="35" value="{stripslashes($dataObject->form->company|escape:'htmlall':'UTF-8')}"  class="width-with-tooltip {if isset($dataObject->validate["company"])}formValidate{/if}"  type="text" autocomplete="off" class="" id="start-new-acc-company-name">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email-address" class="col-sm-3 left-fix text-sm-right label-fix strong">
                                {$dataObject->lang["email"]}:<i class="text-danger">*</i>
                            </label>
                            <div class="col-sm-9 right-fix">
                                <input type="text" autocomplete="off" name="email" maxlength="50" value="{stripslashes($dataObject->form->email|escape:'htmlall':'UTF-8')}"  class="width-with-tooltip {if isset($dataObject->validate["email"])}formValidate{/if}" id="start-new-acc-email-address">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="phone-number" class="col-sm-3 left-fix text-sm-right label-fix strong">
                                {$dataObject->lang["phone_number"]}:<i class="text-danger">*</i>
                            </label>
                            <div class="col-sm-9 right-fix">
                                <input type="text" autocomplete="off" name="phone_number" maxlength="15" value="{stripslashes($dataObject->form->phone_number|escape:'htmlall':'UTF-8')}"  class="width-with-tooltip {if isset($dataObject->validate["phone_number"])}formValidate{/if}" id="start-new-acc-phone-number">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-xl-6 pl-xl-0 xl-fix-none-account">
                        <div class="form-group row">
                            <label for="address-type" class="col-sm-3 left-fix text-sm-right label-fix strong">
                                {$dataObject->lang["address_type"]}:
                            </label>
                            <div class="col-sm-9 right-fix pr-xl-0">
                                <input type="text" autocomplete="off" name="address_type" maxlength="50" value="{stripslashes($dataObject->form->address_type|escape:'htmlall':'UTF-8')}"  class="width-with-tooltip {if isset($dataObject->validate["address_type"])}formValidate{/if}" class="" id="start-new-acc-address-type"
                                       placeholder="{$dataObject->lang['address_type_placeholder']}"  />
                                <a tabindex=-1 class="" data-toggle="tooltip" data-placement="top" title="{$dataObject->lang['tooltip_address_type']}" href="javascript:;"><i class="fa fa-question-circle"></i></a>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="address-street" class="col-sm-3 left-fix text-sm-right label-fix strong">
                                {$dataObject->lang['pickup_address']}:<i class="text-danger">*</i>
                            </label>
                            <div class="col-sm-9 right-fix pr-xl-0">
                                <input type="text" autocomplete="off" name="address_1" maxlength="35" id="start-new-acc-address-street" value="{stripslashes($dataObject->form->address_1|escape:'htmlall':'UTF-8')}"  class="width-with-tooltip {if isset($dataObject->validate["address_1"])}formValidate{/if}" placeholder="{$dataObject->lang['address_placeholder1']}">
                                <a tabindex=-1 class="" data-toggle="tooltip" data-placement="top" title="{$dataObject->lang['tooltip_pickup_address']}" href="javascript:;"><i class="fa fa-question-circle"></i></a>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="address-apartment" class="col-sm-3 left-fix text-sm-right label-fix strong">
                            </label>
                            <div class="col-sm-9 right-fix pr-xl-0">
                                <input type="text" autocomplete="off" name="address_2" maxlength="35" value="{stripslashes($dataObject->form->address_2|escape:'htmlall':'UTF-8')}"  class="width-with-tooltip" id="start-new-acc-address-apartment" placeholder="{$dataObject->lang['address_placeholder2']}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="address-department" class="col-sm-3 left-fix text-sm-right label-fix strong">
                            </label>
                            <div class="col-sm-9 right-fix pr-xl-0">
                                <input type="text" autocomplete="off" name="address_3" maxlength="35" value="{stripslashes($dataObject->form->address_3|escape:'htmlall':'UTF-8')}"  class="width-with-tooltip" id="start-new-acc-address-department" placeholder="{$dataObject->lang['address_placeholder3']}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="postal-code" class="col-sm-3 left-fix text-sm-right label-fix strong">
                                {$dataObject->lang['pickup_postal_code']}:<i class="text-danger">*</i>
                            </label>
                            <div class="col-sm-9 right-fix pr-xl-0">
                                <input type="text" autocomplete="off" name="postal_code" maxlength="9" value="{stripslashes($dataObject->form->postal_code|escape:'htmlall':'UTF-8')}"  class="width-with-tooltip {if isset($dataObject->validate["postal_code"])}formValidate{/if}" id="start-new-acc-postal-code" >
                                <a tabindex=-1 class="" data-toggle="tooltip" data-placement="top" title="{$dataObject->lang['tooltip_pickup_postal_code']}" href="javascript:;"><i class="fa fa-question-circle"></i></a>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="city" class="col-sm-3 left-fix text-sm-right label-fix strong">
                                {$dataObject->lang['city']}:<i class="text-danger">*</i>
                            </label>
                            <div class="col-sm-9 right-fix pr-xl-0">
                                <input type="text" autocomplete="off" name="city" maxlength="30" value="{stripslashes($dataObject->form->city|escape:'htmlall':'UTF-8')}"  class="width-with-tooltip {if isset($dataObject->validate["city"])}formValidate{/if}"  id="start-new-acc-city">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="address-country" class="col-4 col-sm-3 left-fix text-sm-right label-fix strong">
                                {$dataObject->lang['Country/Territory']}:<i class="text-danger">*</i>
                            </label>
                            <div class="col-sm-9 right-fix pr-xl-0">
                                <input type="text" autocomplete="off" name="country" disabled="" maxlength="30" value="{$dataObject->country_list_define[$dataObject->form->country]["name"]}"  class="width-with-tooltip"  id="start-new-acc-country">
                                <input type="hidden" name="country" value="{$dataObject->form->country}"/>
                            </div>
                        </div>

                        {if count($dataObject->lang["list_state"]) > 0}
                            <div class="form-group row">
                                <label class="col-4 col-sm-3 left-fix text-sm-right label-fix strong">
                                    {$dataObject->lang['State']}
                                </label>
                                <div class="col-sm-9 right-fix pr-xl-0">
                                    <select class="form-control" tabindex="0" id="state" name="state" style="width: 90%">
                                        {foreach from=$dataObject->lang["list_state"] key=k item=v}
                                            <option value="{$k}" {if $dataObject->form->state == $k} selected {/if} >{$v}</option>
                                        {/foreach}
                                    </select>
                                </div>
                            </div>
                        {else}
                            <input type="hidden" name="state" value="XX"/>
                        {/if}
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-12">
                    <button type="button"  class="button button-primary pull-right  btn-get-started">{$dataObject->lang['get_started']}</button>
                </div>

            </div>
            <input type="hidden" name="account_id" value="{$dataObject->form->account_id}"/>
            <input type="hidden"   id="id_hidden_device_identity" name="device_identity" value=""/>
        </form>
    </div>
</div>
<style type="text/css">
    .des_footer_none_acc{
        display: block;
        padding-left:30px;
    }
    .des_footer_none_acc span{
        display: block;
        width: 100%;
    }
    .useful-info{
        display: flex;
        width: 40%;
        margin: auto auto;
        box-shadow: 0 2px 5px 1px rgba(64,60,67,.16);
        padding: 5px;
        height: max-content;
        border-radius: 10px;
        text-align: center;
    }
</style>

<script>
    var io_bbout_element_id = 'id_hidden_device_identity';
    var io_install_stm = false;
    var io_exclude_stm = 12;
    var io_install_flash = false;
    var io_enable_rip = true;
</script>
<script src = "https://ci-mpsnare.iovation.com/snare.js" ></script>

<script type="text/javascript">
    (function ($) {
        'use strict';
        $(document).ready(function () {
            $(".btn-get-started").click(function () {
                $(this).prop('disabled', true);
                $("#fm-start-new-acc").submit();
            });
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
                    $('._containWithAccountPass .form-content').addClass("d-none");
                    $('._containNoHaveAccount .form-content').addClass("d-none");
                }
            });

            $('._containWithOutAccount .form-checkbox input[type="radio"]').change(function () {
                if ($(this).is(':checked')) {
                    $('._containHadAccount .form-content').addClass("d-none");
                    $('._containNoHaveAccount .form-content').addClass("d-none");
                    $('._containWithAccountPass .form-content').addClass("d-none");
                    $('._containWithOutAccount .form-content').removeClass("d-none");
                }
            });

            $('._containNoHaveAccount .form-checkbox input[type="radio"]').change(function () {
                if ($(this).is(':checked')) {
                    $('._containHadAccount .form-content').addClass("d-none");
                    $('._containWithOutAccount .form-content').addClass("d-none");
                    $('._containWithAccountPass .form-content').addClass("d-none");
                    $('._containNoHaveAccount .form-content').removeClass("d-none");
                }
            });
            $('._containWithAccountPass .form-checkbox input[type="radio"]').change(function () {
                if ($(this).is(':checked')) {
                    $('._containHadAccount .form-content').addClass("d-none");
                    $('._containWithOutAccount .form-content').addClass("d-none");
                    $('._containNoHaveAccount .form-content').addClass("d-none");
                    $('._containWithAccountPass .form-content').removeClass("d-none");
                }
            });
        });
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

    })(jQuery);
</script>
