{if isset($dataObject->data->info_rateShopAP)}
    {if $dataObject->data->info_rateShopAP->check_api_response eq "ok"}
        {if $dataObject->data->info_rateShopAP->list_services}
            <table>
                <tr>
                    <td style="width: 40px;">
                        <img class="ups_img_logo"  src="{$img_url}UPS_logo.svg" alt="ups shipping"/>
                    </td>
                    <td class="_text">
                        <strong class="upsShippingTitleADD">{$dataObject->lang["option1"]}</strong>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <div class="notice_add">
                            {$dataObject->lang["option1_des"]}
                        </div>
                    </td>
                </tr>
            </table>
            <ul class="list-unstyled">
                {foreach $dataObject->data->info_rateShopAP->list_services as $item_service}
                    <li>
                        {if isset($dataObject->data->RateTimeInTransit[$item_service->Service->ID_Local])}
                            {assign var=itemRateTimeInTransit value=$dataObject->data->RateTimeInTransit[$item_service->Service->ID_Local]}
                            {if $itemRateTimeInTransit->custom->time_in_transit}
                                <table>
                                    <tr>
                                        <td style="width: 33px;">
                                            <input {if $item_service->Service->ID_Local eq $dataObject->data->min_total_price_service->id_service}checked="checked"{/if}
                                                   onclick="__upsMapShipping.func.checkout_update('{$item_service->Service->ID_Local}', 'AP', '{$itemRateTimeInTransit->custom->monetary_value}');"
                                                   name="ups_shipping_service_all" value="{$item_service->Service->ID_Local}" data-service-key="{$item_service->Service->Description}" type="radio"/>
                                        </td>
                                        <td>
                                            {if isset($dataObject->lang[$item_service->Service->Description])}
                                                <strong>{$dataObject->lang[$item_service->Service->Description]}</strong>
                                            {/if}
                                        </td>
                                        <td class="_item_right">
                                            {if isset($itemRateTimeInTransit->custom)}
                                                <strong id="ups_service_id_{$item_service->Service->ID_Local}">{$itemRateTimeInTransit->custom->monetary_value_fomart}</strong>
                                            {/if}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td colspan="2">
                                            {if $dataObject->CUT_OFF_TIME ne 24}
                                                {if isset($itemRateTimeInTransit->custom->time_in_transit) && $itemRateTimeInTransit->custom->time_in_transit != "N/A"}
                                                    <span class="content_shipping_service">({$itemRateTimeInTransit->custom->time_in_transit})</span>
                                                {/if}
                                            {/if}
                                        </td>
                                    </tr>
                                </table>
                            {/if}
                        {/if}
                    </li>
                {/foreach}
            </ul>
        {/if}
    {/if}
{/if}
