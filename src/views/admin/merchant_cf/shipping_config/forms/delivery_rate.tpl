<div class="pt-3 pb-3 pr-4 pl-2 pl-lg-4" id="container_focus_show">
    <form method="POST" id="form_delivery-rate" action="{$dataObject->action_form}">

        {if $dataObject->check_save_success eq 1}
            {* <div class="notice notice-success is-dismissible">
            <ul>
            <li>{$dataObject->lang["save_success"]}</li>
            </ul>
            <button type="button" class="notice-dismiss">
            <span class="screen-reader-text"></span>
            </button>
            </div>*}
        {else}
            {if $dataObject->check_validate_all eq 1}
                <div class="form-group notice-error settings-error notice is-dismissible">
                    {if $dataObject->mess_duplicate_flat_rate}
                        <ul>
                            <li>{$dataObject->mess_duplicate_flat_rate["msg_error"]}.</li>
                        </ul>
                    {else}
                        <ul>
                            <li>{$dataObject->lang['validate_error']}</li>
                        </ul>
                    {/if}
                    <button type="button" class="notice-dismiss">
                        <span class="screen-reader-text"></span>
                    </button>
                </div>
            {/if}
        {/if}
        <div class="ups-config-delivery-area">
            <div class="row pl-4 pl-lg-0">
                <div class="col-lg-3 col-xl-2 col-first-fix align-self-start p-lg-0">
                    <label class="w-100 text-left text-md-right label-fix--">{$dataObject->lang["currency"]}</label>
                </div>
                <div class="col-lg-4 col-mid-fix pr-sm-0 pr-2">
                    <input tabindex="0" type="text" disabled="disabled" value="{stripslashes($dataObject->get_woocommerce_currency|escape:'htmlall':'UTF-8')}"/>
                </div>
            </div>
            {if $dataObject->isCountryCode eq 'US'}
            <div class="row mb-4 mt-4">
                <div class="col">
                    {$dataObject->lang["subtext_1_us"]}
                </div>
            </div>
            {/if}
            {if $dataObject->DELIVERY_TO_ACCESS_POINT eq "1"}
                <div class="row mb-4 mt-4">
                    <div class="col">
                        <strong class="form-group col-12 mb-3 pl-0">{$dataObject->lang["type_ship_AP"]}</strong>
                    </div>
                </div>
                {foreach $dataObject->services as $itemService}
                    {if $itemService->service_type eq 'AP'}
                        <div class="row pl-4 pl-lg-0" id="itemTypeServiceShiiping_{$itemService->id}">
                            <div class="col-12 pr-0">
                                <div class="row form-group">
                                    <div class="col-lg-2 col-first-fix col-xl-1 mb-3 mb-lg-0 align-self-start p-lg-0 text-left text-md-right">

                                        <label class="w-100 d-none d-lg-block text-center mb-0" style="height: 21px;">&nbsp;</label>
                                        <label class="label-fix--" for="typeSelect_{$itemService->id}">
                                            {$dataObject->lang[$itemService->service_key]}
                                        </label>
                                    </div>
                                    <div class="col-lg-2 col-mid-fix align-self-start mb-3 mb-xl-0">
                                        <label class="w-100 d-none d-lg-block mb-0" style="height:18px;">&nbsp;</label>
                                        <select class="w-100" name="select_type[{$itemService->id}][type]" id='_typeSelect_{$itemService->id}' onchange="deliveryRate.changeTypeService({$itemService->id}, this.value);">
                                            {foreach $dataObject->get_type_rate as $key=>$value}
                                                <option {if $dataObject->select_type[$itemService->id]["type"] eq $key }selected="selected"{/if} value="{$key}">{$value}</option>
                                            {/foreach}
                                        </select>
                                    </div>
                                    <div class="col-lg col-last-fix col-xl-8 pl-0  pl-2 pr-3">
                                        <div class="_containerFlat">
                                            {if $dataObject->delivery_rate_flat[$itemService->id]}
                                                {assign var=numberIndex value=0}
                                                {foreach $dataObject->delivery_rate_flat[$itemService->id] as $item}
                                                    <div class="row {if $numberIndex > 0} mb-2{/if} mb-sm-3" id="id_delivery_{$item["id"]}">
                                                        <div class="col-lg-3 form-inline {if $numberIndex > 0} mb-3 mb-lg-0 {/if} pr-0">
                                                            <div class="row w-100">
                                                                <div class="col-12 col-lg-auto pl-0 pr-0">
                                                                    {if $numberIndex eq 0}
                                                                        <label class="col-12" style="height: 22px;">&nbsp;</label>
                                                                    {else}
                                                                        <label class="d-none d-md-block col-12" style="height: 3px;">&nbsp;</label>
                                                                    {/if}
                                                                    <label class="pr-0 pb-1 mb-0">
                                                                        <span class="w-100 pl-4 pl-lg-0 text-left text-lg-right ">
                                                                            <i onclick="deliveryRate.addFlatRate({$itemService->id});" class="fa fa-plus-circle mr-2"></i>
                                                                        </span>
                                                                    </label>
                                                                </div>
                                                                <div class="col w-100 pl-2 pl-lg-0 pr-0">
                                                                    {if $numberIndex eq 0}
                                                                        <div class="w-100 pl-0">
                                                                            <label class="w-100 text-center">
                                                                                <small>
                                                                                    {$dataObject->lang["country"]}
                                                                                </small>
                                                                            </label>
                                                                        </div>
                                                                    {/if}
                                                                    <div>
                                                            
                                                                        <select  class="w-100"  name="delivery_rate_flat[{$itemService->id}][{$item['id']
                                                                                }][rate_country]" value="{stripslashes($item['rate_country']|escape:'htmlall':'UTF-8')}"   autocomplete="off"/>
                                                                            <option value="all">All Country</option>
                                                                            {foreach $dataObject->country_list as $key=>$value}
                                                                                {if $item['rate_country'] == $key}
                                                                                    <option value={$key} selected>{$value}</option>
                                                                                {else}
                                                                                    <option value={$key}>{$value}</option>
                                                                                {/if}
                                                                            {/foreach}
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-2 form-inline pr-0">
                                                            <div class="row w-100  align-items-center">
                                                                <div class="col pl-5 pl-lg-0 pr-0">
                                                                    {if $numberIndex eq 0}
                                                                        <div class="w-100 pl-0">
                                                                            <label class="w-100 text-center"><small>{$dataObject->lang["rule"]}</small></label>
                                                                        </div>
                                                                    {/if}
                                                                    <div>
                                                                        <select name="delivery_rate_flat[{$itemService->id}][{$item['id']
                                                                                }][rate_rule]" value="{stripslashes($item['rate_rule']|escape:'htmlall':'UTF-8')
                                                                                }"   autocomplete="off"/>
                                                                            {if $item['rate_rule'] == "wb"}
                                                                                <option value="wb"selected>Weight Based</option>
                                                                                <option value="ov">Order Value</option>
                                                                            {else}
                                                                                <option value="wb">Weight Based</option>
                                                                                <option value="ov" selected>Order Value</option>
                                                                            {/if}
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 form-inline pr-0">
                                                            <div class="row w-100  align-items-center">
                                                                <div class="col pl-5 pl-lg-0 pr-0">
                                                                    {if $numberIndex eq 0}
                                                                        <div class="w-100 pl-0">
                                                                            <label class="w-100 text-center"><small>{$dataObject->lang["minimum_order_value"]}</small></label>
                                                                        </div>
                                                                    {/if}
                                                                    <div>
                                                                        <input  class="{if $item['validate'] ne '1'}{if isset($item['validate']['min_order_value'])}formValidate {/if}{/if}"  name="delivery_rate_flat[{$itemService->id}][{$item['id']
                                                                                }][min_order_value]" value="{stripslashes($item['min_order_value']|escape:'htmlall':'UTF-8')
                                                                                }"  type="text" autocomplete="off"/>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 form-inline pr-0">
                                                            <div class="row w-100  align-items-center">
                                                                <div class="col pl-5 pl-lg-0 pr-0">
                                                                    {if $numberIndex eq 0}
                                                                        <div class="w-100 pl-0">
                                                                            <label class="w-100 text-center"><small>{$dataObject->lang["delivery_rates"]}</small></label>
                                                                        </div>
                                                                    {/if}
                                                                    <div>
                                                                        <input  class="{if $item['validate'] ne '1'}{if isset($item['validate']['delivery_rate'])}formValidate{/if}{/if}" type="text" autocomplete="off"  name="delivery_rate_flat[{$itemService->id}][{$item['id']}][delivery_rate]" value="{stripslashes($item['delivery_rate']|escape:'htmlall':'UTF-8')
                                                                                }" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-12 col-lg-auto pl-lg-0">
                                                                    <label class="d-none d-md-block col-12 pl-2 pr-2" style="height: 10px;">&nbsp;</label>
                                                                    <label class="pr-0 pb-1 mt-1 mt-md-0">
                                                                        {if $numberIndex ne 0}
                                                                            <span class="w-100 pl-4 pl-lg-0 text-left text-lg-right ">

                                                                                <i onclick="deliveryRate.removeFlatRate('id_delivery_{$item["id"]}');" class = "fa fa-minus-circle text-danger ml-lg-2"></i>

                                                                            </span>
                                                                        {/if}
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <input type="hidden" name="delivery_rate_flat[{$itemService->id}][{$item['id']}][rate_type]" value="1"/>
                                                        <input type="hidden" name="delivery_rate_flat[{$itemService->id}][{$item['id']}][service_id]" value="{stripslashes($item['service_id']|escape:'htmlall':'UTF-8')}"/>
                                                        <input type="hidden" name="delivery_rate_flat[{$itemService->id}][{$item['id']}][id]" value="{stripslashes($item['id']|escape:'htmlall':'UTF-8')}"/>
                                                    </div>
                                                    {$numberIndex = $numberIndex +1}
                                                {/foreach}
                                            {else}
                                                <div class="row">
                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label class="w-80 text-center">&nbsp;</label>
                                                            <div>
                                                                <i onclick="deliveryRate.addFlatRate({$itemService->id});" class="fa fa-plus-circle mr-2"></i>
                                                                <select  class="w-100"  name="delivery_rate_flat[{$itemService->id}][{$item['id']
                                                                                }][rate_country]" value="{stripslashes($item['rate_country']|escape:'htmlall':'UTF-8')}"   autocomplete="off"/>
                                                                    <option value="all">All Country</option>
                                                                    {foreach $dataObject->country_list as $key=>$value}
                                                                        {if $item['rate_country'] == $key}
                                                                            <option value={$key} selected>{$value}</option>
                                                                        {else}
                                                                            <option value={$key}>{$value}</option>
                                                                        {/if}
                                                                    {/foreach}
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label class="w-80 text-center">&nbsp;</label>
                                                            <div>
                                                                <i onclick="deliveryRate.addFlatRate({$itemService->id});" class="fa fa-plus-circle mr-2"></i>
                                                                <select  name="delivery_rate_flat[{$itemService->id}][{$item['id']
                                                                    }][rate_rule]" value="{stripslashes($item['rate_rule']|escape:'htmlall':'UTF-8')}"   autocomplete="off"/>
                                                                    {if $item['rate_rule'] == "wb"}
                                                                        <option value="wb"selected>Weight Based</option>
                                                                        <option value="ov">Order Value</option>
                                                                    {else}
                                                                        <option value="wb">Weight Based</option>
                                                                        <option value="ov" selected>Order Value</option>
                                                                    {/if}
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label class="w-80 text-center">&nbsp;</label>
                                                            <div>
                                                                <i onclick="deliveryRate.addFlatRate({$itemService->id});" class="fa fa-plus-circle mr-2"></i>
                                                                <input class="w-80 mr-4 "   name="delivery_rate_flat[{$itemService->id}][empty_{$itemService->id}][min_order_value]" value="0"  type="text" autocomplete="off"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label class="w-80 text-center">&nbsp;</label>
                                                            <div>
                                                                <input  class="w-80 mr-4 "   type="text" autocomplete="off"  name="delivery_rate_flat[{$itemService->id}][empty_{$itemService->id}][delivery_rate]" value="0" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" name="delivery_rate_flat[{$itemService->id}][empty_{$itemService->id}][rate_type]" value="1"/>
                                                    <input type="hidden" name="delivery_rate_flat[{$itemService->id}][empty_{$itemService->id}][service_id]" value="{stripslashes($itemService->id|escape:'htmlall':'UTF-8')}"/>
                                                    <input type="hidden" name="delivery_rate_flat[{$itemService->id}][empty_{$itemService->id}][id]" value="empty_{stripslashes($itemService->id|escape:'htmlall':'UTF-8')}"/>
                                                </div>
                                            {/if}
                                        </div>
                                        <div class="_containerRealTime" style="display: none;">
                                            <div class="row ml-2">
                                                <div class="col-11 form-block pl-0 pr-0">
                                                    <label class="w-100 d-none d-lg-block mb-0">&nbsp;</label>
                                                    <div class="col-12 form-inline pl-lg-0 pr-0">
                                                        <label class="col-auto text-left pl-0 pr-1">{$dataObject->lang["delivery_date_is"]}</label>

                                                        {assign var=valueDelivery value=$dataObject->delivery_rate_real_time[$itemService->id]["delivery_rate"]}

                                                        <input name="delivery_rate_real_time[{$itemService->id}][delivery_rate]" class="w100-xs text-right {if $dataObject->mess_duplicate_flat_rate eq ''}{if $dataObject->delivery_rate_real_time[$itemService->id]['validate'] ne '1'}{if isset($dataObject->delivery_rate_real_time[$itemService->id]['validate']['delivery_rate'])}formValidate{/if}{/if}{/if}"  value="{stripslashes($valueDelivery|escape:'htmlall':'UTF-8')}" type="text" style="width: 100px!important;" autocomplete="off"/>

                                                        <label class="ml-1">{$dataObject->lang["of_UPS_shipping_rates"]}</label>
                                                        <input type="hidden" name="delivery_rate_real_time[{$itemService->id}][rate_type]" value="2"/>
                                                        <input type="hidden" name="delivery_rate_real_time[{$itemService->id}][service_id]" value="{stripslashes($itemService->id|escape:'htmlall':'UTF-8')}"/>
                                                        <input type="hidden" name="delivery_rate_real_time[{$itemService->id}][id]" value="{if $dataObject->delivery_rate_real_time[$itemService->id]['id']}{stripslashes($dataObject->delivery_rate_real_time[$itemService->id]['id']|escape:'htmlall':'UTF-8')}{/if}"/>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row _containerRealTime_small_des" style="display: none;">
                                    <div class="col-lg-2">
                                    </div>
                                    <div class="col-md-8 col">
                                        <small class="pl-2 pl-lg-0  ml-5 ml-lg-0 text-left form-text text-muted">{if $dataObject->isCountryCode neq 'US'}{$dataObject->lang["subtext_1"]}{/if}</small>
                                        {* <small class="pl-2 pl-lg-0  ml-5 ml-lg-0 text-left form-text text-muted">{$dataObject->lang["subtext_2"]}</small> *}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br/>
                    {/if}
                {/foreach}
            {/if}
            {if $dataObject->DELIVERY_TO_SHIPPING_ADDRESS eq "1"}
                <div class="row mb-4 mt-4">
                    <div class="col">
                        <strong class="form-group col-12 mb-3 pl-0">{$dataObject->lang["type_ship_Add"]}</strong>
                    </div>
                </div>
                {foreach $dataObject->services as $itemService}
                    {if $itemService->service_type eq 'ADD'}
                        <div class="row pl-4 pl-lg-0" id="itemTypeServiceShiiping_{stripslashes($itemService->id|escape:'htmlall':'UTF-8')}">
                            <div class="col-12 pr-0">
                                <div class="row form-group">
                                    <div class="col-lg-2 col-first-fix col-xl-1  mb-3 mb-lg-0 align-self-start p-lg-0 text-left text-md-right">
                                        <label class="w-100 d-none d-lg-block text-center mb-0" style="height: 21px;">&nbsp;</label>
                                        <label class="label-fix--" for="typeSelect_{$itemService->id}">
                                            {$dataObject->lang[$itemService->service_key]}
                                        </label>
                                    </div>
                                    <div class="col-lg-2 col-mid-fix align-self-start mb-3 mb-xl-0">
                                        <label class="w-100 d-none d-lg-block mb-0" style="height: 18px;">&nbsp;</label>
                                        <select class="w-100" name="select_type[{$itemService->id}][type]" id="_typeSelect_{stripslashes($itemService->id|escape:'htmlall':'UTF-8')}" onchange="deliveryRate.changeTypeService({stripslashes($itemService->id|escape:'htmlall':'UTF-8')}, this.value);">
                                            {foreach $dataObject->get_type_rate as $key=>$value}
                                                <option {if $dataObject->select_type[$itemService->id]["type"] eq $key}selected="selected"{/if} value="{$key}">{$value}</option>
                                            {/foreach}
                                        </select>
                                    </div>

                                    <div class="col col-last-fix col-xl-8 pl-0 pl-2 pr-3">
                                        <div class="_containerFlat">
                                            {if $dataObject->delivery_rate_flat[$itemService->id]}
                                                {assign var=numberIndex value=0}
                                                {foreach $dataObject->delivery_rate_flat[$itemService->id] as $item}
                                                    <div class="row {if $numberIndex > 0} mb-2{/if} mb-sm-3" id="id_delivery_{$item["id"]}">
                                                        <div class="col-lg-3 form-inline {if $numberIndex > 0} mb-3 mb-lg-0 {/if} pr-0">
                                                            <div class="row w-100">
                                                                <div class="col-12 col-lg-auto pl-0 pr-0">
                                                                    {if $numberIndex eq 0}
                                                                        <label class="col-12" style="height: 22px;">&nbsp;</label>
                                                                    {else}
                                                                        <label class="d-none d-md-block col-12" style="height: 3px;">&nbsp;</label>
                                                                    {/if}
                                                                    <label class="pr-0 pb-1 mb-0">
                                                                        <span class="w-100 pl-4 pl-lg-0 text-left text-lg-right ">
                                                                            <i onclick="deliveryRate.addFlatRate({stripslashes($itemService->id|escape:'htmlall':'UTF-8')});" class="fa fa-plus-circle mr-2"></i>
                                                                        </span>
                                                                    </label>
                                                                </div>
                                                                <div class="col w-100 pl-2 pl-lg-0 pr-0">
                                                                    {if $numberIndex eq 0}
                                                                        <div class="w-100 pl-0">
                                                                            <label class="w-100 text-center">
                                                                                <small>
                                                                                    {$dataObject->lang["country"]}
                                                                                </small>
                                                                            </label>
                                                                        </div>
                                                                    {/if}
                                                                    <div>
                                                                        <select  class="w-100"  name="delivery_rate_flat[{$itemService->id}][{$item['id']
                                                                                }][rate_country]" value="{stripslashes($item['rate_country']|escape:'htmlall':'UTF-8')}"   autocomplete="off"/>
                                                                            <option value="all">All Country</option>
                                                                            {foreach $dataObject->country_list as $key=>$value}
                                                                                {if $item['rate_country'] == $key}
                                                                                    <option value={$key} selected>{$value}</option>
                                                                                {else}
                                                                                    <option value={$key}>{$value}</option>
                                                                                {/if}
                                                                            {/foreach}
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-2 form-inline pr-0">
                                                            <div class="row w-100  align-items-center">
                                                                <div class="col pl-5 pl-lg-0 pr-0">
                                                                    {if $numberIndex eq 0}
                                                                        <div class="w-100 pl-0">
                                                                            <label class="w-100 text-center"><small>{$dataObject->lang["rule"]}</small></label>
                                                                        </div>
                                                                    {/if}
                                                                    <div>
                                                                        <select  name="delivery_rate_flat[{$itemService->id}][{$item['id']
                                                                                }][rate_rule]" value="{stripslashes($item['rate_rule']|escape:'htmlall':'UTF-8')
                                                                                }"   autocomplete="off"/>
                                                                            {if $item['rate_rule'] == "wb"}
                                                                                <option value="wb"selected>Weight Based</option>
                                                                                <option value="ov">Order Value</option>
                                                                            {else}
                                                                                <option value="wb">Weight Based</option>
                                                                                <option value="ov" selected>Order Value</option>
                                                                            {/if}
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 form-inline pr-0">
                                                            <div class="row w-100  align-items-center">
                                                                <div class="col pl-5 pl-lg-0 pr-0">
                                                                    {if $numberIndex eq 0}
                                                                        <div class="w-100 pl-0">
                                                                            <label class="w-100 text-center"><small>{$dataObject->lang["minimum_order_value"]}</small></label>
                                                                        </div>
                                                                    {/if}
                                                                    <div>
                                                                        <input  class="{if $item['validate'] ne '1'}{if isset($item['validate']['min_order_value'])}formValidate {/if}{/if}"  name="delivery_rate_flat[{$itemService->id}][{$item['id']
                                                                                }][min_order_value]" value="{stripslashes($item['min_order_value']|escape:'htmlall':'UTF-8')
                                                                                }"  type="text" autocomplete="off"/>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 form-inline pr-0">
                                                            <div class="row w-100  align-items-center">
                                                                <div class="col pl-5 pl-lg-0 pr-0">
                                                                    {if $numberIndex eq 0}
                                                                        <div class="w-100 pl-0">
                                                                            <label class="w-100 text-center"><small>{$dataObject->lang["delivery_rates"]}</small></label>
                                                                        </div>
                                                                    {/if}
                                                                    <div>
                                                                        <input  class="{if $item['validate'] ne '1'}{if isset($item['validate']['delivery_rate'])}formValidate{/if}{/if}" type="text" autocomplete="off"  name="delivery_rate_flat[{$itemService->id}][{$item['id']}][delivery_rate]" value="{stripslashes($item['delivery_rate']|escape:'htmlall':'UTF-8')
                                                                                }" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-12 col-lg-auto pl-lg-0">
                                                                    <label class="d-none d-md-block col-12 pl-2 pr-2" style="height: 10px;">&nbsp;</label>
                                                                    <label class="pr-0 pb-1 mt-1 mt-md-0">
                                                                        {if $numberIndex ne 0}
                                                                            <span class="w-100 pl-4 pl-lg-0 text-left text-lg-right ">

                                                                                <i onclick="deliveryRate.removeFlatRate('id_delivery_{$item["id"]}');" class = "fa fa-minus-circle text-danger ml-lg-2"></i>

                                                                            </span>
                                                                        {/if}
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <input type="hidden" name="delivery_rate_flat[{$itemService->id}][{$item['id']}][rate_type]" value="1"/>
                                                        <input type="hidden" name="delivery_rate_flat[{$itemService->id}][{$item['id']}][service_id]" value="{stripslashes($item['service_id']|escape:'htmlall':'UTF-8')}"/>
                                                        <input type="hidden" name="delivery_rate_flat[{$itemService->id}][{$item['id']}][id]" value="{stripslashes($item['id']|escape:'htmlall':'UTF-8')}"/>
                                                    </div>
                                                    {$numberIndex = $numberIndex +1}
                                                {/foreach}
                                            {else}
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label class="w-80 text-center">&nbsp;</label>
                                                            <div>
                                                                <i onclick="deliveryRate.addFlatRate({stripslashes($itemService->id|escape:'htmlall':'UTF-8')});" class="fa fa-plus-circle mr-2"></i>
                                                                <input class="w-80 mr-4 " title="{$dataObject->lang['placeholder_min_order_value']}"  name="delivery_rate_flat[{$itemService->id}][empty_{$itemService->id}][min_order_value]" value="0"  type="text" autocomplete="off"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label class="w-80 text-center">&nbsp;</label>
                                                            <div>
                                                                <input  class="w-80 mr-4 "  title="{$dataObject->lang['placeholder_delivery_rate']}"  type="text" autocomplete="off"  name="delivery_rate_flat[{$itemService->id}][empty_{$itemService->id}][delivery_rate]" value="0" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" name="delivery_rate_flat[{$itemService->id}][empty_{$itemService->id}][rate_type]" value="1"/>
                                                    <input type="hidden" name="delivery_rate_flat[{$itemService->id}][empty_{$itemService->id}][service_id]" value="{stripslashes($itemService->id|escape:'htmlall':'UTF-8')}"/>
                                                    <input type="hidden" name="delivery_rate_flat[{$itemService->id}][empty_{$itemService->id}][id]" value="empty_{stripslashes($itemService->id|escape:'htmlall':'UTF-8')}"/>
                                                </div>
                                            {/if}
                                        </div>
                                        <div class="_containerRealTime" style="display: none;">
                                            <div class="row ml-2">
                                                <div class="col-11 form-block pl-0 pr-0">
                                                    <label class="w-100 d-none d-lg-block mb-0">&nbsp;</label>
                                                    <div class="col-12 form-inline pl-lg-0 pr-0">
                                                        <label class="col-auto text-left pl-0 pr-1">{$dataObject->lang["delivery_date_is"]}</label>
                                                        {assign var=valueDelivery value=$dataObject->delivery_rate_real_time[$itemService->id]["delivery_rate"]}
                                                        <input  name="delivery_rate_real_time[{$itemService->id}][delivery_rate]" class="w100-xs text-right {if $dataObject->mess_duplicate_flat_rate eq ''}{if $dataObject->delivery_rate_real_time[$itemService->id]['validate'] ne '1'}{if isset($dataObject->delivery_rate_real_time[$itemService->id]['validate']['delivery_rate'])}formValidate{/if}{/if}{/if}"  value="{if isset($valueDelivery)}{if $valueDelivery eq 'error'}{else}{stripslashes($valueDelivery|escape:'htmlall':'UTF-8')}{/if}{else}100{/if}" type="text" style="width: 100px!important;" autocomplete="off"/>
                                                        <label class="ml-1">{$dataObject->lang["of_UPS_shipping_rates"]}</label>
                                                        <input type="hidden" name="delivery_rate_real_time[{$itemService->id}][rate_type]" value="2"/>
                                                        <input type="hidden" name="delivery_rate_real_time[{$itemService->id}][service_id]" value="{stripslashes($itemService->id|escape:'htmlall':'UTF-8')}"/>
                                                        <input type="hidden" name="delivery_rate_real_time[{$itemService->id}][id]" value="{if $dataObject->delivery_rate_real_time[$itemService->id]['id']}{stripslashes($dataObject->delivery_rate_real_time[$itemService->id]['id']|escape:'htmlall':'UTF-8')}{/if}"/>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row _containerRealTime_small_des" style="display: none;">
                                    <div class="col-lg-2">
                                    </div>
                                    <div class="col-md-8 col">
                                        <small class="pl-2 pl-lg-0  ml-5 ml-lg-0 text-left form-text text-muted">{if $dataObject->isCountryCode neq 'US'}{$dataObject->lang["subtext_1"]}{/if}</small>
                                        {*  <small class="pl-2 pl-lg-0  ml-5 ml-lg-0 text-left form-text text-muted">{$dataObject->lang["subtext_2"]}</small> *}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br/>
                    {/if}
                {/foreach}
            {/if}
            <div class="row mb-4 mt-4">
                <div class="col">
                    <strong class="form-group col-12 mb-3 pl-0">{$dataObject->lang["type_flat_rate"]}</strong>
                </div>
            </div>
            <div class="row pl-4 pl-lg-0">
                <div class="col-lg-3 col-xl-2 col-first-fix align-self-start p-lg-0">
                    <label class="w-100 text-left text-md-right label-fix--">{$dataObject->lang["type_flat_rate_txt"]}</label>
                </div>
                <div class="col-lg-4 col-mid-fix pr-sm-0 pr-2">
                <label class="switch">
                    <input {if $dataObject->ups_flat_cal_discount}checked="true"{/if} name="ups_flat_cal_discount" type="checkbox" id="confirm-cod-2">
                    <span class="slider round"></span>            
                </label>
                <label class="ml-1" id="label-confirm-cod-2">{$dataObject->lang["Yes"]}</label>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <button type="button" class="button button-primary btn-save">{$dataObject->lang["btn_save"]}</button>
                    <button type="button" class="button button-primary pull-right btn-next">{$dataObject->lang["btn_next"]}</button>
                    <input type="hidden" id="btn_controller" name="btn_controller" value=""/>
                </div>
            </div>
        </div>
    </form>
</div>
<style>
    ._containerFlat i.fa{
        color: #00aff0;
        font-size: 15px;
    }

</style>
<script type="text/javascript">
    (function ($) {
        'use strict';
        var deliveryRate ={};
        deliveryRate.guid = function () {
            function s4() {
                return Math.floor((1 + Math.random()) * 0x10000)
                        .toString(16)
                        .substring(1);
            }
            return s4() + s4() + '-' + s4() + '-' + s4() + '-' + s4() + '-' + s4() + s4() + s4();
        };
        deliveryRate.addFlatRate = function (idService) {
            var html = (object_json_javascript.element_flat_rate || "") + "";
            if (html.length > 0) {
                html = deliveryRate.replace(html, idService);
                $("#itemTypeServiceShiiping_" + idService + " div._containerFlat").append(html);
            }
        };
        deliveryRate.replace = function (html, idService) {
            var idDelivery = deliveryRate.guid();
            var tmp = html.split("$@ID_SERVICE@$");
            var html1 = tmp.join(idService);
            var tmp2 = html1.split("#_$@ID_DELIVERY_RATE@$#");
            var html2 = tmp2.join(idDelivery);
            return html2;
        };
        deliveryRate.removeFlatRate = function (id) {
            $("div").remove("#" + id);
        };
        deliveryRate.changeTypeService = function (idService, type) {
            switch (type) {
                case "1":
                    $("#itemTypeServiceShiiping_" + idService + " div._containerFlat").show();
                    $("#itemTypeServiceShiiping_" + idService + " div._containerRealTime_small_des").hide();
                    $("#itemTypeServiceShiiping_" + idService + " div._containerRealTime").hide();
                    break;
                case "2":
                    $("#itemTypeServiceShiiping_" + idService + " div._containerRealTime").show();
                    $("#itemTypeServiceShiiping_" + idService + " div._containerFlat").hide();
                    $("#itemTypeServiceShiiping_" + idService + " div._containerRealTime_small_des").show();
                    break;
                default:
                    break;
            }

        };

        $(document).ready(function () {
            $(".btn-save").click(function () {
                $(this).prop('disabled', true);
                $("#btn_controller").val("save");
                $("#form_delivery-rate").submit();
            });
            $(".btn-next").click(function () {
                $(this).prop('disabled', true);
                $("#btn_controller").val("next");
                $("#form_delivery-rate").submit();
            });
            window.deliveryRate = deliveryRate;
            {foreach $dataObject->select_type as $key=>$item}
                deliveryRate.changeTypeService('{$key}', '{$item["type"]}');
            {/foreach}
        });
    })(jQuery);
</script>
