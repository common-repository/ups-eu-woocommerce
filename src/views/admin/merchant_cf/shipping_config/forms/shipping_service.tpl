{if $dataObject->mess_dont_check}
    <div class="form-group notice-error settings-error notice is-dismissible">
        <ul>
            <li>{$dataObject->mess_dont_check}</li>
        </ul>
        <button type="button" class="notice-dismiss">
            <span class="screen-reader-text"></span>
        </button>
    </div>
{/if}
<div class="col-md-12">
    <div class="form-group">
        <br/>
        <label>{$dataObject->lang["description"]}</label>
    </div>
</div>
<div class="card-body" id="container_focus_show">
    <form id="form_shipping_service" method="POST" action="{$dataObject->action_form}">
        <div id="ap_check_err" style="width: 90%;margin-left: 50px;display: none;"></div>
        <div class="col-12 row">
            <div class="col-12 col-lg-5 text-lg-right">
                <label><strong>{$dataObject->lang["section1"]}</strong></label>
            </div>
            <div class="col-12 col-lg-7">
                <label class="switch">
                    <input onclick="shippingService.clickSlider1();" {if $dataObject->configs->DELIVERY_TO_ACCESS_POINT || $dataObject->us_default eq '1'}checked="true"{/if} id="DELIVERY_TO_ACCESS_POINT" name="configs[DELIVERY_TO_ACCESS_POINT]" type="checkbox" name="deliToAP">
                    <span class="slider round"></span>
                </label>
                <label id="lable-DELIVERY_TO_ACCESS_POINT" class="h6 font-weight-normal">
                    {if $dataObject->configs->DELIVERY_TO_ACCESS_POINT}
                        {$dataObject->lang["Yes"]}
                    {else}
                        {$dataObject->lang["No"]}
                    {/if}
                </label>
                <div class="">
                    <small class="form-text text-muted font-italic mt-0">
                        {$dataObject->lang["section1_des"]}
                    </small>
                </div>
            </div>
        </div>
        <div class="mt-4" id="DELIVERY_TO_ACCESS_POINT_container" {if !$dataObject->configs->DELIVERY_TO_ACCESS_POINT}style="display: none;"{/if}>
            <div class="col-12 row">
                <div class="col-12 col-lg-5 text-lg-right">
                    <label for="defaultDeliMethod">{$dataObject->lang["section1_options"]}</label>
                </div>
                <div class="col-12 col-lg-7">
                    <label class="switch">
                        <input  {if intval($dataObject->configs->SET_DEFAULT) == 1 && $dataObject->us_default eq "0"}checked="true"{/if} name="configs[SET_DEFAULT]"  type="checkbox" id="defaultDeliMethod">
                        <span class="slider round"></span>
                    </label>
                    <label id="lable-defaultDeliMethod" class="h6 font-weight-normal">
                        {if intval($dataObject->configs->SET_DEFAULT) == 1 && $dataObject->us_default eq "0"}
                            {$dataObject->lang["Yes"]}
                        {else}
                            {$dataObject->lang["No"]}
                        {/if}
                    </label>
                </div>
            </div>
            <div class="col-12 row mt-4">
                <div class="col-12 col-lg-5 text-lg-right">
                    <label for="APasShipTo">{$dataObject->lang["ap_as_shipto"]}</label>
                </div>
                <div class="col-12 col-lg-7">
                    <label class="switch">
                        <input  {if intval($dataObject->configs->AP_AS_SHIPTO) == 1}checked="true"{/if} name="configs[AP_AS_SHIPTO]"  type="checkbox" id="APasShipTo">
                        <span class="slider round"></span>
                    </label>
                    <label id="lable-APasShipTo" class="h6 font-weight-normal">
                        {if intval($dataObject->configs->AP_AS_SHIPTO) == 1}
                            {$dataObject->lang["Yes"]}
                        {else}
                            {$dataObject->lang["No"]}
                        {/if}
                    </label>
                </div>
            </div>
            <div class="col-12 row mt-4">
                <div class="col-12 col-lg-5 text-lg-right">
                    <label><strong>{$dataObject->lang["section1_select"]}:</strong></label>
                </div>
                <div class="col-12 col-lg-7 pt-1">
                    {foreach $dataObject->list_data_acceptpoint as $itemacceptpoint}
                        <div class="mb-1">
                            <label class="{if ($itemacceptpoint->service_key == 'UPS_SP_SERV_PL_AP_EXPEDITED')} mb-0 {/if} text-nowrap" >
                                <input type="checkbox" {if $itemacceptpoint->service_selected eq "1" || ($dataObject->us_default eq "1")}checked="true"{/if} name="ups_services[{$itemacceptpoint->id}][service_selected]" />
                                {$dataObject->lang[$itemacceptpoint->service_key]}
                                {if (in_array($itemacceptpoint->service_key, $dataObject->isShowNoteApExpeditedUSToUS))}
                                    {' (to US)'}
                                {/if}
                                {if (in_array($itemacceptpoint->service_key, $dataObject->isShowNoteApExpeditedUSToInternational))}
                                    {' (to international)'}
                                {/if}
                            </label>
                            <input type="hidden" name="ups_services[{$itemacceptpoint->id}][id]" value="{$itemacceptpoint->id}"/>
                            <input type="hidden" name="ups_services[{$itemacceptpoint->id}][service_type]" value="{$itemacceptpoint->service_type}"/>
                            {if ($itemacceptpoint->service_key == $dataObject->isShowNoteApExpedited)}
                                <div>
                                    <label class="small text-muted font-italic">
                                        {$dataObject->lang["UPS_Expedited_Des"]}
                                    </label>
                                </div>
                            {/if}
                        </div>
                    {/foreach}
                </div>
            </div>
            <div class="col-12 row mt-4">
                <div class="col-12 col-lg-5 text-lg-right">
                    <label><strong>{$dataObject->lang["section1_select2"]}:</strong></label>
                </div>
                <div class="col-12 col-lg-7">
                </div>
            </div>
            {if $dataObject->us_country eq 'us'}
            <div class="col-12 row">
                <div class="col-12 col-lg-5 text-lg-right">
                    <label for="defaultAdultSignature">{$dataObject->lang["section1_adult_signature"]}</label>
                </div>
                <div class="col-12 col-lg-7">
                    <label class="switch">
                        <input  {if intval($dataObject->configs->ADULT_SIGNATURE) == 1}checked="true"{/if} name="configs[ADULT_SIGNATURE]" type="checkbox" id="defaultAdultSignature">
                        <span class="slider round"></span>
                    </label>
                    <label id="lable-defaultAdultSignature" class="h6 font-weight-normal">
                        {if intval($dataObject->configs->ADULT_SIGNATURE) == 1}
                            {$dataObject->lang["Yes"]}
                        {else}
                            {$dataObject->lang["No"]}
                        {/if}
                    </label>
                </div>
            </div>
            {/if}
            <div class="col-12 row mt-3">
                <div class="col-12 col-lg-5 text-lg-right">
                    <label>{$dataObject->lang["section1_select2_numberAP"]}: </label>
                </div>
                <div class="col-12 col-lg-7">
                    <select name="configs[NUMBER_OF_ACCESS_POINT_AVAIABLE]" class="w-75 w-lg-50">
                        {for $valueIndex=3 to 10}
                            <option {if $valueIndex eq $dataObject->configs->NUMBER_OF_ACCESS_POINT_AVAIABLE}selected{/if} value="{$valueIndex}">{$valueIndex}</option>
                        {/for}
                    </select>
                </div>
            </div>

            <div class="col-12 row mt-3">
                <div class="col-12 col-lg-5 text-lg-right">
                    <label>{$dataObject->lang["section1_select2_range"]}:</label>
                </div>
                <div class="col-12 col-lg-7">
                    <select name="configs[DISPLAY_ALL_ACCESS_POINT_IN_RANGE]" class="w-75 w-lg-50">
                        {foreach $dataObject->configs->list_data_range as $value}
                            <option {if $value eq $dataObject->configs->DISPLAY_ALL_ACCESS_POINT_IN_RANGE}selected{/if} value="{$value}">{$value}</option>
                        {/foreach}
                    </select>
                    <div>
                        <label class="small text-muted font-italic">{$dataObject->lang["section1_select2_range_des"]} </label>
                    </div>

                </div>
            </div>

            <div class="col-12 row mt-4">
                <div class="col-12 col-lg-5 text-lg-right">
                    <label><strong>{$dataObject->lang["section1_select2_account"]}</strong></label>
                </div>
                <div class="col-12 col-lg-7">
                    <select name="configs[CHOOSE_ACCOUNT_NUMBER_AP]" class="w-75 w-lg-50">
                        {foreach $dataObject->list_data_account as $item}
                            <option {if $item->account_id eq $dataObject->configs->CHOOSE_ACCOUNT_NUMBER_AP}selected{/if} value="{$item->account_id}">{stripslashes($item->address_type|escape:'htmlall':'UTF-8')} (#{stripslashes($item->ups_account_number|escape:'htmlall':'UTF-8')})</option>
                        {/foreach}
                    </select>

                </div>
            </div>
        </div>

        <div class="col-12 row mt-4">
            <div class="col-12 col-lg-5 text-lg-right"></div>
            <div class="col-12 col-lg-7">
                <hr class="hr-shipping">
            </div>
        </div>


        <div class="col-12 row mt-4">
            <div class="col-12 col-lg-5 text-lg-right">
                <label><strong>{$dataObject->lang["section2"]}</strong></label>
            </div>
            <div class="col-12 col-lg-7">
                <label class="switch">
                    <input id="DELIVERY_TO_SHIPPING_ADDRESS" onclick="shippingService.clickSlider2();" type="checkbox"  {if $dataObject->configs->DELIVERY_TO_SHIPPING_ADDRESS || $dataObject->us_default eq "1"}checked="true"{/if} name="configs[DELIVERY_TO_SHIPPING_ADDRESS]">
                    <span class="slider round"></span>
                </label>

                <label id="lable-DELIVERY_TO_SHIPPING_ADDRESS" class="h6 font-weight-normal">
                    {if $dataObject->configs->DELIVERY_TO_SHIPPING_ADDRESS}
                        {$dataObject->lang["Yes"]}
                    {else}
                        {$dataObject->lang["No"]}
                    {/if}
                </label>
                <div class="">
                    <small class="form-text text-muted font-italic mt-0">
                        {$dataObject->lang["section2_des"]}
                    </small>
                </div>
            </div>
        </div>

        <div id="DELIVERY_TO_SHIPPING_ADDRESS_container" {if !$dataObject->configs->DELIVERY_TO_SHIPPING_ADDRESS}style='display: none;'{/if}>
            <div class="col-12 row mt-4">
                <div class="col-12 col-lg-5 text-lg-right">
                    <label><strong>{$dataObject->lang["section2_select"]}:</strong></label>
                </div>
                <div class="col-12 col-lg-7 pt-1">
                    {foreach $dataObject->list_data_address_delivery as $itemdelivery}
                        <div class="mb-1">
                            <label class="{if ($itemdelivery->service_key == 'UPS_SP_SERV_PL_ADD_EXPEDITED')} mb-0 {/if} text-nowrap">
                                <input type="checkbox" {if $itemdelivery->service_selected eq "1" || $dataObject->us_default eq "1"}checked="true"{/if} name="ups_services[{$itemdelivery->id}][service_selected]" />
                                {$dataObject->lang[$itemdelivery->service_key]}
                                 {if (in_array($itemdelivery->service_key, $dataObject->isShowNoteADDExpeditedUSToUS))}
                                    {' (to US)'}
                                {/if}
                                {if (in_array($itemdelivery->service_key, $dataObject->isShowNoteADDExpeditedUSToInternational))}
                                    {' (to international)'}
                                {/if}
                            </label>
                            <input type="hidden" name="ups_services[{$itemdelivery->id}][id]" value="{$itemdelivery->id}"/>
                            <input type="hidden" name="ups_services[{$itemdelivery->id}][service_type]" value="{$itemdelivery->service_type}"/>
                            {if ($itemdelivery->service_key == $dataObject->isShowNoteADDExpedited)}
                                <div>
                                    <label class="small text-muted font-italic">
                                        {$dataObject->lang["UPS_Expedited_Des"]}
                                    </label>
                                </div>

                            {/if}
                        </div>
                    {/foreach}
                </div>
            </div>

            <div class="col-12 row mt-4">
                <div class="col-12 col-lg-5 text-lg-right">
                    <label><strong>{$dataObject->lang["section2_choose"]}</strong></label>
                </div>
                <div class="col-12 col-lg-7">
                    <select name="configs[CHOOSE_ACCOUNT_NUMBER_ADD]" class="w-75 w-lg-50">
                        {foreach $dataObject->list_data_account as $item}
                            <option {if $item->account_id eq $dataObject->configs->CHOOSE_ACCOUNT_NUMBER_ADD}selected{/if} value="{$item->account_id}">{stripslashes($item->address_type|escape:'htmlall':'UTF-8')} (#{stripslashes($item->ups_account_number|escape:'htmlall':'UTF-8')})</option>
                        {/foreach}
                    </select>

                </div>
            </div>

        </div>

        <div class="col-12 row mt-4">
            <div class="col-12 col-lg-5 text-lg-right"></div>
            <div class="col-12 col-lg-7">
                <hr class="hr-shipping">
            </div>
        </div>

        <div class="col-12 row mt-4">
                <div class="col-12 col-lg-5 text-lg-right">
                    <label><strong>{$dataObject->lang["packing_type"]}</strong></label>
                </div>
                <div class="col-12 col-lg-7">
                    <select name="ups_package_type" class="w-75 w-lg-50">
                         {if $dataObject->ups_package_type == "01"}
                            <option value="01"selected>Letter/Envolope</option>
                            <option value="02">Box</option>
                        {else}
                            <option value="01">Letter/Envolope</option>
                            <option value="02"selected>Box</option>
                        {/if}
                    </select>

                </div>
        </div>

        <div class="col-12 row mt-4">
            <div class="col-12 col-lg-5 text-lg-right"></div>
            <div class="col-12 col-lg-7">
                <hr class="hr-shipping">
            </div>
        </div>

        <div class="col-12 row mt-4">
            <div class="col-12 col-lg-5 text-lg-right">
                <label><strong>{$dataObject->lang["section2_cutofftime"]}</strong></label>
            </div>
            <div class="col-12 col-lg-7">
                <select name="configs[CUT_OFF_TIME]" class="w-75 w-lg-50">
                    {foreach $dataObject->configs->list_time_day as $key=>$value}
                        <option {if $key eq $dataObject->configs->CUT_OFF_TIME}selected{/if} value="{$key}">{$value}</option>
                    {/foreach}
                </select>
                <small class="form-text text-muted font-italic">
                {if $dataObject->isCountryCode eq 'US'}
                    {$dataObject->lang["section2_muted_1_us"]}
                    <br>
                    {$dataObject->lang["section2_muted_2_us"]}
                {else}
                    {$dataObject->lang["section2_muted_1"]}
                    <br><br>
                    {$dataObject->lang["section2_muted_2"]}
                    <br><br>
                    {$dataObject->lang["section2_muted_3"]}
                {/if}
                </small>
            </div>
        </div>

        <br/>
        <div class="">
            <button type="button" class="button button-primary btn-save">{$dataObject->lang["btn_save"]}</button>
            {* {if $dataObject->ACCEPT_SHIPPING_SERVICE eq "1"} *}
            <button type="button" class="button button-primary pull-right btn-next">{$dataObject->lang["btn_next"]}</button>
            {* {/if} *}
            <input type="hidden" id="btn_controller" name="btn_controller" value=""/>
            <input type="hidden" id="selected_country" name="selected_country" value="{$dataObject->isCountryCode}"/>
            <input type="hidden" id="us_default" name="us_default" value="{$dataObject->us_default}"/>
        </div>
    </form>
</div>
<div id="upsShipping_loadingDiv" style="display: none;"><img alt="Loading..." src="{$img_url}loader-1.gif"/>Please wait...</div>
<style type="text/css">
    #upsShipping_loadingDiv{
        position: fixed;
        width: 100%;
        z-index: 9999999;
        background-color: #000;
        opacity: .5;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
    }
    #upsShipping_loadingDiv img{
        left: 50%;
        position: absolute;
        top: 50%;
        
    }
</style>
<script type="text/javascript">
    (function ($) {
        'use strict';
        var shippingService ={};
        var selected_country = $("#selected_country").val();
        var us_default = $("#us_default").val();
        if ((1 == us_default)) {
            $("#lable-DELIVERY_TO_ACCESS_POINT").text('{$dataObject->lang["Yes"]}');
            $("#DELIVERY_TO_ACCESS_POINT_container").slideToggle("show");
            $("#lable-DELIVERY_TO_SHIPPING_ADDRESS").text('{$dataObject->lang["Yes"]}');
            $("#DELIVERY_TO_SHIPPING_ADDRESS_container").slideToggle("show");
            $("#lable-defaultDeliMethod").text('{$dataObject->lang["No"]}');
        }
        $("#defaultAdultSignature").change(function () {
            if ($(this).prop('checked')) {
                $("#lable-defaultAdultSignature").text('{$dataObject->lang["Yes"]}');

            } else {
                $("#lable-defaultAdultSignature").text('{$dataObject->lang["No"]}');
            }
        });

        $("#defaultDeliMethod").change(function () {
            if ($(this).prop('checked')) {
                $("#lable-defaultDeliMethod").text('{$dataObject->lang["Yes"]}');

            } else {
                $("#lable-defaultDeliMethod").text('{$dataObject->lang["No"]}');
            }
        });
        $("#APasShipTo").change(function () {
            if ($(this).prop('checked')) {
                $("#lable-APasShipTo").text('{$dataObject->lang["Yes"]}');
            } else {
                $("#lable-APasShipTo").text('{$dataObject->lang["No"]}');
            }
        });

        shippingService.clickSlider1 = function () {
            $("#ap_check_err").hide();
            if ($("#DELIVERY_TO_ACCESS_POINT").prop('checked')) {
                $("#upsShipping_loadingDiv").show();
                $.ajax({
                    type: "POST",
                    url: '{$dataObject->links_form->url_ajax_json}&method=check-ap',
                    data: {},
                    dataType: 'json',
                    success: function (data) {
                        $("#upsShipping_loadingDiv").hide();
                        if (data.status != "success") {
                            var ap_check_html = '<p style="color:red;background-color: #fde1c0;text-align: center;border-radius: 5px;">Failed to enable AP service. '+data.status+' Contact support.</p>';
                            $("#ap_check_err").html(ap_check_html);
                            $("#ap_check_err").show();
                            $("#DELIVERY_TO_ACCESS_POINT").prop("checked", false);
                            $("#lable-DELIVERY_TO_ACCESS_POINT").text('{$dataObject->lang["No"]}');
                        } else if (data.status == "success"){
                            var ap_check_html = '<p style="color:green;background-color:#91f091;text-align: center;border-radius: 5px;">AP service enabled.</p>';
                            $("#ap_check_err").html(ap_check_html);
                            $("#ap_check_err").show();
                            $("#lable-DELIVERY_TO_ACCESS_POINT").text('{$dataObject->lang["Yes"]}');
                            $("#DELIVERY_TO_ACCESS_POINT_container").slideToggle("show");
                        } else {
                            var ap_check_html = '<p style="color:red;background-color: #fde1c0;text-align: center;border-radius: 5px;">Failed to enable AP service. Contact support.</p>';
                            $("#ap_check_err").html(ap_check_html);
                            $("#ap_check_err").show();
                            $("#DELIVERY_TO_ACCESS_POINT").prop("checked", false);
                            $("#lable-DELIVERY_TO_ACCESS_POINT").text('{$dataObject->lang["No"]}');
                        }
                    },
                    error: function (data) {
                        var ap_check_html = '<p style="color:red;background-color: #fde1c0;text-align: center;border-radius: 5px;">Failed to enable AP service. Unknown Error. Contact support.</p>';
                        $("#ap_check_err").html(ap_check_html);
                        $("#ap_check_err").show();
                        $("#DELIVERY_TO_ACCESS_POINT").prop("checked", false);
                        $("#lable-DELIVERY_TO_ACCESS_POINT").text('{$dataObject->lang["No"]}');
                    }
                });
            } else {
                $("#lable-DELIVERY_TO_ACCESS_POINT").text('{$dataObject->lang["No"]}');
                $("#DELIVERY_TO_ACCESS_POINT_container").slideToggle("hide");
            }
        };
        shippingService.clickSlider2 = function () {
            if ($("#DELIVERY_TO_SHIPPING_ADDRESS").prop('checked') || (1 == us_default)) {
                $("#lable-DELIVERY_TO_SHIPPING_ADDRESS").text('{$dataObject->lang["Yes"]}');
                $("#DELIVERY_TO_SHIPPING_ADDRESS_container").slideToggle("show");
            } else {
                $("#lable-DELIVERY_TO_SHIPPING_ADDRESS").text('{$dataObject->lang["No"]}');
                $("#DELIVERY_TO_SHIPPING_ADDRESS_container").slideToggle("hide");
            }
        };

        $(document).ready(function () {
            $(".btn-save").click(function () {
                $(this).prop('disabled', true);
                $("#btn_controller").val("save");
                $("#form_shipping_service").submit();
            });
            $(".btn-next").click(function () {
                $(this).prop('disabled', true);
                $("#btn_controller").val("next");
                $("#form_shipping_service").submit();
            });
            window.shippingService = shippingService;
        });
    }
    )(jQuery);
</script>
