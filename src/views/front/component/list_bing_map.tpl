{if isset($dataObject->data->init_params_Locator["MaximumListSize"])}
    {if $dataObject->data->init_params_Locator["MaximumListSize"] ne "1"}
        {if isset($dataObject->data->info_locator->list_locator)}
            <strong class="resultSearch">{$dataObject->lang["results_search"]}</strong>
            <div class="ups_list_locator">
                {assign var=index value=0}
                {foreach $dataObject->data->info_locator->list_locator as $item_locator} 
                    {if isset($item_locator->AddressKeyFormat)}
                        {assign var=itemAddressKeyFormat value=$item_locator->AddressKeyFormat}
                        {assign var=LocationID value=$item_locator->LocationID}
                        {if isset($itemAddressKeyFormat)}
                            <div class="itemContainerListLocator">
                                <table class="ups_table_item">
                                    <tr>
                                        {assign var=indexTitle value=$index+1}
                                        <td class="show_left">
                                            <b>{$indexTitle}) {if isset($itemAddressKeyFormat->ConsigneeName)}{$itemAddressKeyFormat->ConsigneeName}{/if}</b>
                                            <span>
                                                {if isset($itemAddressKeyFormat->AddressLine)}
                                                    {$itemAddressKeyFormat->AddressLine},  
                                                {/if}
                                                {if isset($itemAddressKeyFormat->PoliticalDivision2)}
                                                    {$itemAddressKeyFormat->PoliticalDivision2}, 
                                                {/if}
                                                {if isset($itemAddressKeyFormat->PostcodePrimaryLow)}
                                                    {$itemAddressKeyFormat->PostcodePrimaryLow}
                                                {/if}
                                            </span>
                                            <span>{$dataObject->lang["operating_hours"]}:</span>
                                            <table class="listItemCalendar">
                                                <tr>
                                                    <td style="width: 115px;"></td>
                                                    <td style="width: 80px;text-align: left;"><b>{$dataObject->lang["Open"]}</b></td>
                                                    <td style="width: 80px;text-align: left;"><b>{$dataObject->lang["btn_close"]}</b></td>
                                                </tr>
                                                {if $dataObject->day_of_week_by_locator[$LocationID]}
                                                    {foreach $dataObject->day_of_week_by_locator[$LocationID] as $item_operating_hours} 
                                                        <tr class="lineTop">
                                                            <td style="text-align: left;vertical-align: middle!important;">
                                                                {$item_operating_hours->date_name}
                                                            </td>
                                                            {if $item_operating_hours->type eq "normal"}
                                                                {if $item_operating_hours->show_open_hours}
                                                                    <td style="text-align: left;vertical-align: middle!important;">{$item_operating_hours->show_open_hours}</td>
                                                                    <td style="text-align: left;vertical-align: middle!important;">{$item_operating_hours->show_close_hours}</td>    
                                                                {else}
                                                                    <td style="text-align: left;vertical-align: middle!important;">
                                                                        {$dataObject->lang["Closed"]}
                                                                    </td>
                                                                    <td></td>
                                                                {/if}
                                                            {else}
                                                                {if $item_operating_hours->type eq "array"}
                                                                    <td style="text-align: left;vertical-align: middle!important;">
                                                                        <ul class="ups_list_hours">
                                                                            {foreach $item_operating_hours->list_array_open_hours as $key=> $item_hours} 
                                                                                <li>
                                                                                    {$item_hours}
                                                                                </li>
                                                                            {/foreach}
                                                                        </ul>
                                                                    </td>
                                                                    <td style="text-align: left;vertical-align: middle!important;">
                                                                        <ul class="ups_list_hours">
                                                                            {foreach $item_operating_hours->list_array_close_hours as $key=> $item_hours_close} 
                                                                                <li>
                                                                                    {$item_hours_close}
                                                                                </li>
                                                                            {/foreach}
                                                                        </ul>
                                                                    </td>
                                                                {else}
                                                                    {if $item_operating_hours->type eq "Open24HoursIndicator"}
                                                                        <td style="text-align: left;vertical-align: middle!important;">
                                                                            {$item_operating_hours->title_open24h}    
                                                                        </td>
                                                                        <td></td>
                                                                    {/if}
                                                                {/if}
                                                            {/if}
                                                        </tr>    
                                                    {/foreach}
                                                {/if}
                                            </table>
                                        </td>
                                        <td class="show_right">
                                            <img src="{$img_url}location.png"/>
                                            <span>{$item_locator->Distance->Value}{if ($dataObject->lang['countryCode'] == "US")} Miles {else} {$item_locator->Distance->UnitOfMeasurement->Code} {/if}</span>
                                            <span onclick="__upsMapShipping.func.MoveLocation('{$index}', '{$LocationID}', 'ups_click_select_{$index}');" id="ups_click_select_{$index}" class="ups_click_select">
                                                {$dataObject->lang["Select"]}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr class="ups_show_mobile">
                                        <td style="text-align: center;" colspan="2" >
                                            <img src="{$img_url}location.png"/>
                                            <span>{$item_locator->Distance->Value}{if ($dataObject->lang['countryCode'] == "US")} Miles {else} {$item_locator->Distance->UnitOfMeasurement->Code} {/if}</span>
                                            <span onclick="__upsMapShipping.func.MoveLocation('{$index}', '{$LocationID}', 'ups_click_select_moblie{$index}');"  id="ups_click_select_moblie{$index}" class="ups_click_select">
                                                {$dataObject->lang["Select"]}
                                            </span>
                                        </td>
                                    </tr>
                                    {assign var=index value=$index+1}
                                </table>
                            </div>
                        {/if}
                    {/if}
                {/foreach}
            </div>
        {/if}
    {/if}
{/if}
<style type="text/css">  
    @media screen and (max-width: 576px) {
    }
</style>