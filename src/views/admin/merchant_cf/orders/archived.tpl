<br/>
<div class="row" tabindex="0">
<form method="POST" action="{$dataObject->action_form}" id="form-archivedOrder" style="width: 100%">
    <div class="col-md-12 row-btn">
        <button id="btn_update_archive_order" type="button" class="button button-primary" disabled="disabled">{$dataObject->lang["Un-Archived Orders"]}</button>
    </div>
    <div class="col-md-12" style="overflow-x: auto;">
        <table class="table table-hover table-bordered tbl-open-orders">
            <thead>
                <tr>
                    <th class="text-center align-middle" scope="col" style="width: 50px">                        
                        <input type="checkbox" id="check-all-archivedOrder" {if !$dataObject->pagination->list_data->list_main}disabled="disabled"{/if}/>
                    </th> 
                    <th class="page-sort  text-center align-middle" field-sort="order_id" scope="col">
                        {$dataObject->lang["Order ID"]}
                        <a href="javascript:;" class="fa icon-sort fa-sort-none"></a>
                    </th>
                    <th class="page-sort  text-center align-middle" field-sort="order_date" scope="col">
                        {$dataObject->lang["order_date"]}
                        <a href="javascript:;" class="fa icon-sort fa-sort-none"></a>
                    </th>
                    <th class="page-sort  text-center align-middle" field-sort="order_time" scope="col">
                        {$dataObject->lang["order_time"]}
                        <a href="javascript:;" class="fa icon-sort fa-sort-none"></a>
                    </th>
                    <th class=" text-center align-middle"  scope="col">
                        {$dataObject->lang["product"]}
                        <a href="javascript:;" class="fa icon-sort fa-sort-none" ></a>
                    </th>
                    <th class="page-sort  text-center align-middle" field-sort="delivery_address" scope="col">
                        {$dataObject->lang["Delivery Address"]}
                        <a href="javascript:;" class="fa icon-sort fa-sort-none" ></a>
                    </th>
                    <th class="page-sort  text-center align-middle" field-sort="shipping_service" scope="col">
                        {$dataObject->lang["shipping_service"]}
                        <a href="javascript:;" class="fa icon-sort fa-sort-none" ></a>
                    </th>
                    <th class="page-sort text-center align-middle" field-sort="cod" scope="col"  style="width: 70px">
                        {$dataObject->lang["COD"]}
                        <a href="javascript:;" class="fa icon-sort fa-sort-none" ></a>
                    </th>
                </tr>
            </thead>
            <tbody>
                {if $dataObject->pagination->list_data->list_main}
                    {foreach $dataObject->pagination->list_data->list_main as $item_order} 
                        <tr>                  
                            <td class="text-center align-middle">
                                <input class="checkbox-item" type="checkbox" name="" value="{$item_order->order_id_magento}" data-id="{$item_order->order_id_magento}"/>
                            </td>                    
                            <td scope="row" class="clickInfo text-center align-middle">
                                {$item_order->order_id_magento}
                            </td>
                            <td class="clickInfo text-center align-middle">
                                {$item_order->order_date}
                            </td>
                            <td class="clickInfo text-center align-middle">
                                {$item_order->order_time}
                            </td>
                            <td class="clickInfo align-middle">
                                {assign var="count" value=0}
                                {foreach $item_order->product as $product}                                     
                                    <!-- {$count++} -->
                                    {if ($count <= 3)}
                                        <span class="">
                                            {$product['qty']} x {$product['name']}
                                        </span> 
                                        <br/> 
                                    {/if}

                                    {if ($count > 3)} 
                                        ...
                                        {break}
                                    {/if}
                                {/foreach}
                            </td>
                            <td class="clickInfo align-middle">
                                {$item_order->delivery_address}  
                            </td>
                            <td class="clickInfo align-middle">
                                {$item_order->shipping_service_text}
                            </td>
                            <td class="clickInfo text-center align-middle">
                                {if ($item_order->cod)}
                                    <img src="{$img_url}checked.png" />
                                {else}
                                    <span style="display: block;width: 100%;text-align:center;opacity: 1;"class="close">×</span>
                                {/if}
                            </td>
                        </tr>
                    {/foreach}
                {else}
                    <tr>
                        <td colspan="8" class="text-center">
                            <p>{$dataObject->lang["We could not find any records"]}</p>
                        </td>
                    </tr>
                {/if}                
            </tbody>
        </table>
    </div>
</form>
    <div class="col-md-12">
        {$dataObject->pagination->html_pagination}
    </div>
</div>

<div class="modal fade" id="ups-modal-un-archived" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">{$dataObject->lang["Un-Archiving Orders"]}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        {$dataObject->lang["titleAccessUnArchiving"]}
      </div>
      <div class="modal-footer">
        <button type="button" class="button button-secondary btn-cancel" data-dismiss="modal">{$dataObject->lang["btn_cancel"]}</button>
        <button type="button" class="button button-primary btn-confirm-message" id="btn_ok_archive_order">{$dataObject->lang["btn_ok"]}</button>
      </div>
    </div>
  </div>
</div>

{include file='admin/merchant_cf/orders/popups/main.tpl'} 

<script type="text/javascript">
    (function ($) {
        'use strict';
        $(document).ready(function () {

            $("table.tbl-open-orders tr td.clickInfo").click(function () {
                $('#loadingDiv').show();
                var order_id = $(this).parents('tr').find('.checkbox-item').data('id');
                $.ajax({
                    type: "POST",
                    url: '{$dataObject->router_url->url_ajax_json}&method=info-order',
                    data: "info_type_order=archived_order&id_order=" + order_id,
                    success: function (data)
                    {
                        $('#popupModalMain').modal('show');
                        $('#popupModalMain div.modal-content').html(data.html);
                        $('#loadingDiv').hide();
                    },
                    error: function (data)
                    {
                        location.reload();
                    }
                });
            });

            $(".checkbox-item").click(function () {
                if ($('.checkbox-item:checked').length > 0) {
                    $("#btn_export_order").prop('disabled', false);
                    $("#btn_update_archive_order").prop('disabled', false);
                
                    if ($('.checkbox-item:checked').length === $('.checkbox-item').length) {
                        $('#check-all-archivedOrder').prop('checked', true);
                    } else {
                        $('#check-all-archivedOrder').prop('checked', false);
                    }
                } else {
                    $('#check-all-archivedOrder').prop('checked', false);
                }
            });

            $('#check-all-archivedOrder').click(function () {
                $('.checkbox-item').prop('checked', $(this).prop('checked'));
                if ($(this).prop('checked')) {
                    $("#btn_update_archive_order").prop('disabled', false);
                } else {
                    $("#btn_update_archive_order").prop('disabled', true);
                }
            });

            $("#btn_update_archive_order").click(function() {
                $("#ups-modal-un-archived").modal('show');
            });

            $("#btn_ok_archive_order").click(function() {
                var archivedOrder = [];
                $('.checkbox-item:checked').each(function () {
                    archivedOrder.push($(this).val());
                });

                archivedOrder.sort();
                var id_archived = archivedOrder.toString();

                $('#loadingDiv').show();
                $.ajax({
                    type: "POST",
                    url: '{$dataObject->action_form}',
                    data: "id_archived=" + id_archived,
                    success: function (data)
                    {
                        location.reload();
                    },
                    error: function (data)
                    {
                        location.reload();
                    }
                });
            });
        });
    }
    )(jQuery);
</script>
