{if isset($dataObject->data->info_rateShopADD)}
    {if $dataObject->data->info_rateShopADD->list_services}
        <table>
            <tr>
                <td style="width: 40px;">
                    <img class="ups_img_logo" src="{$img_url}UPS_logo.svg" alt="ups shipping"/>
                </td>
                <td class="_text">
                    <strong class="upsShippingTitleADD">{$dataObject->lang["option2"]}</strong>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <div class="notice_add">
                        {$dataObject->lang["option2_des"]}
                    </div>
                </td>
            </tr>
        </table>
        <ul class="list-unstyled">
            {foreach $dataObject->data->info_rateShopADD->list_services as $item_service}
                <li>
                    {if isset($dataObject->data->RateTimeInTransit[$item_service->service_id])}
                        {assign var=itemRateTimeInTransit value=$dataObject->data->RateTimeInTransit[$item_service->service_id]}
                        {if $itemRateTimeInTransit->custom->time_in_transit}
                            <table>
                                <tr>
                                    <td style="width: 33px;">
                                        <input {if $item_service->service_id eq $dataObject->data->min_total_price_service->id_service}checked="checked"{/if} onclick="__upsMapShipping.func.checkout_update('{$item_service->service_id}', 'ADD', '{$itemRateTimeInTransit->custom->monetary_value}');" name="ups_shipping_service_all" value="{$item_service->service_id}" type="radio"/>
                                    </td>
                                    <td>
                                        {if isset($itemRateTimeInTransit->custom->service_name)}
                                            <strong>{$itemRateTimeInTransit->custom->service_name}</strong>
                                        {/if}
                                    </td>
                                    <td class="_item_right">
                                        {if isset($itemRateTimeInTransit->custom)}
                                            <strong id="ups_service_id_{$item_service->service_id}">{$itemRateTimeInTransit->custom->monetary_value_fomart}</strong>
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
