<br/>

<form action="{$dataObject->action_form}" method="post" id="form-submit-shipment" class="d-none">
    <input type="hidden" value='' name='btn_controller'/>
    <input type="hidden" value='' name='textbox_checked_ids'/>
    <input type="hidden" value='' name='textbox_tracking_ids'/>
    <input type="hidden" value='' name='label_option'/>
</form>
<style>
    #shipments > div > a {
        width: 100% !important;
    }
    .dropdown-item {
        font-size: 13px;
    }
</style>

<div class="row" tabindex="0">
    <div class="col-md-12 row-pull" style="margin-bottom: 20px;">
        <div class="alert alert-primary" id="tracking-agree-term">
            {$dataObject->lang["By_selecting_any_order"]}
        </div>
        {if !empty($dataObject->label_err)}
            <div class="alert alert-danger">
                {$dataObject->label_err}
            </div>
        {/if}
{*        <button id="printLabel" type="button" class="button button-primary" aria-haspopup="true" aria-expanded="false" disabled>*}
{*            {$dataObject->lang["Print Label"]}*}
{*        </button>*}
        <button id="printLabel" type="button" class="button button-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" disabled>
            {$dataObject->lang["Print Label"]}
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <button class="dropdown-item" id="printLabelPDF">
                {$dataObject->lang["Download PDF Label"]}
            </button>
            <button class="dropdown-item" id="printLabelZPL" href="#">
                {$dataObject->lang["Download ZPL Label"]}
            </button>
        </div>
        <button id="export-all-shipments" type="button" class="button button-primary" disabled>{$dataObject->lang["Export Shipment Data"]}</button>
        <button id="cancelShipment" type="button" class="button button-primary" disabled>{$dataObject->lang["Cancel Shipments"]}</button>
    </div>

    <div class="col-md-12" style="overflow-x: auto;">
        <table class="table table-bordered table-hover tbl-open-orders" id="tbl-shipments">
            <thead>
                <tr>
                    <th   class=" text-center align-middle" scope="col"  style="width: 50px">
                        <input type="checkbox" name="" id="selectAll" {if !$dataObject->pagination->list_data->list_main}disabled="disabled"{/if}/>
                    </th>
                    <th class="page-sort text-center align-middle" field-sort="id_shipment" scope="col">
                        {$dataObject->lang["ID Shipment"]}
                        <a href="javascript:;" class="fa icon-sort fa-sort-none" ></a>
                    </th>
                    <th class="page-sort text-center align-middle" field-sort="tracking_number" scope="col">
                        {$dataObject->lang["Tracking Number"]}
                        <a href="javascript:;" class="fa icon-sort fa-sort-none" ></a>
                    </th>
                    <th class="page-sort text-center align-middle" field-sort="order_id" scope="col">
                        {$dataObject->lang["Order ID"]}
                        <a href="javascript:;" class="fa icon-sort fa-sort-none"></a>
                    </th>
                    <th class="page-sort  text-center align-middle" field-sort="order_date" scope="col">
                        {$dataObject->lang["Date"]}
                        <a href="javascript:;" class="fa icon-sort fa-sort-none"></a>
                    </th>
                    <th class="page-sort text-center align-middle" field-sort="order_time" scope="col">
                        {$dataObject->lang["Time"]}
                        <a href="javascript:;" class="fa icon-sort fa-sort-none"></a>
                    </th>
                    <th class="page-sort  text-center align-middle" field-sort="delivery_address" scope="col">
                        {$dataObject->lang["Delivery Address"]}
                        <a href="javascript:;" class="fa icon-sort fa-sort-none"></a>
                    </th>
                    <th class="page-sort text-center align-middle" field-sort="shipping_fee" scope="col">
                        {$dataObject->lang["Estimated Shipping Fee"]}
                        <a href="javascript:;" class="fa icon-sort fa-sort-none"></a>
                    </th>
                </tr>
            </thead>
            <tbody>
                {if $dataObject->pagination->list_data->list_main}
                    {foreach $dataObject->pagination->list_data->list_main as $item_order}
                        <tr>
                            <td class="text-center align-middle">
                                <input class="selectAll" type="checkbox" name="" id="order-{$item_order->order_id_magento}" data-id="{$item_order->order_id_magento}" shipmentNumber="{$item_order->shipment_shipment_number}" trackId="{$item_order->shipping_tracking_id}"/>
                            </td>
                            <td scope="row" class="clickInfo text-center align-middle">
                                {$item_order->shipment_shipment_number}
                            </td>
                            <td class="clickInfo text-center align-middle">
                                {$item_order->tracking_number}
                            </td>
                            <td class="clickInfo text-center align-middle">
                                {$item_order->order_id_magento}
                            </td>
                            <td class="clickInfo text-center align-middle">
                                {$item_order->order_date}
                            </td>
                            <td class="clickInfo text-center align-middle">
                                {$item_order->order_time}
                            </td>
                            <td class="clickInfo align-middle">
                                {$item_order->delivery_address}
                            </td>
                            <td class="clickInfo align-middle text-center">
                                {$item_order->currency_code} {number_format($item_order->shipment_shipping_fee, 2)}
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
    <div class="col-md-12">
        {$dataObject->pagination->html_pagination}
    </div>
</div>

{include file='admin/merchant_cf/orders/popups/main.tpl'}

<script type="text/javascript">

    (function ($) {
        'use strict';
        $(document).ready(function () {

            var title_cancel_shipmnet = "{$dataObject->lang['Cancel Shipment(s)']}";
            var message_cancel_shipment = "";
            var listChecked = [];
            var listShipmentNumber = [];
            var listTrackingId = [];

            $('#selectAll').click(function () {
                $('.selectAll').prop('checked', $(this).prop('checked'));
                if ($(this).prop('checked'))
                {
                    $("#printLabel").prop('disabled', false);
                    $("#export-all-shipments").prop('disabled', false);
                    $("#cancelShipment").prop('disabled', false);
                    // $(".table-hover>tbody>tr").each(function() {
                    //     $(this).addClass('selected');
                    // })
                    checkselected();
                }
                else {
                    $("#printLabel").prop('disabled', true);
                    $("#export-all-shipments").prop('disabled', true);
                    $("#cancelShipment").prop('disabled', true);
                    // $(".table-hover>tbody>tr").each(function() {
                    //     $(this).addClass('selected');
                    // })
                }
            });

            $(".selectAll").click(function () {
                if ($('.selectAll:checked').length > 0) {
                    $("#printLabel").prop('disabled', false);
                    $("#export-all-shipments").prop('disabled', false);
                    $("#cancelShipment").prop('disabled', true);
                    if ($('.selectAll:checked').length === $('.selectAll').length) {
                        $('#selectAll').prop('checked', true);
                    } else {
                        $('#selectAll').prop('checked', false);
                    }
                } else {
                    $('#selectAll').prop('checked', false);
                    $("#printLabel").prop('disabled', true);
                    $("#export-all-shipments").prop('disabled', true);
                    $("#cancelShipment").prop('disabled', true);
                }
            });

            $('.table-hover tbody tr').click(function () {
                checkselected();
            });

            function checkselected() {
                listChecked = [];
                //listTracking = [];
                //cancelShipmentList = [];
                listTrackingId = [];
                listShipmentNumber = [];
                $(".selectAll:checked").each(function () {
                    var id = $(this).data('id');
                    listChecked.push(id);
                    //listTracking.push($(this).attr("data-id"));
                    listShipmentNumber.push($(this).attr("shipmentNumber"));
                    listTrackingId.push($(this).attr("trackId"));
                    //cancelShipmentList.push($(this).attr("shipmentNumber"))
                })
                if (listChecked.length == 0) {
                    $("#export-all-shipments").prop("disabled", true);
                    $("#printLabel").prop("disabled", true);
                    $("#cancelShipment").prop("disabled", true);
                } else {
                    $("#export-all-shipments").prop("disabled", false);
                    $("#printLabel").prop("disabled", false);
                    $("#cancelShipment").prop("disabled", false);
                }
            }

            $("table.tbl-open-orders tr td.clickInfo").click(function () {
                $('#loadingDiv').show();
                var order_id = $(this).parents('tr').find('.selectAll').data('id');
                var trackId = $(this).parents('tr').find('.selectAll').attr('trackId');
                $.ajax({
                    type: "POST",
                    url: '{$dataObject->router_url->url_ajax_json}&method=info-shipment',
                    data: "info_type_order=info_shipment&id_order=" + order_id + "&trackId=" + trackId,
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
                }).done(sync_ups_shipping_update());
            });


            //export all shipment
            $("#export-all-shipments").click(function () {
                checkselected();
                $('#form-submit-shipment').find('input[name=btn_controller]').val('export-shipments-csv');
                $('#form-submit-shipment').find('input[name=textbox_checked_ids]').val(listChecked);
                $('#form-submit-shipment').find('input[name=textbox_tracking_ids]').val(listTrackingId);
                $("#form-submit-shipment").submit();
            });

            // Print label format PDF
            // $("#printLabel").click(function () {
            //     checkselected();
            //     $('#form-submit-shipment').find('input[name=btn_controller]').val('print-label');
            //     $('#form-submit-shipment').find('input[name=textbox_checked_ids]').val(listShipmentNumber);
            //     $('#form-submit-shipment').find('input[name=label_option]').val('PDF');
            //     $("#form-submit-shipment").submit();
            // });

            // Print label format PDF
            $("#printLabelPDF").click(function () {
                checkselected();
                $('#form-submit-shipment').find('input[name=btn_controller]').val('print-label');
                $('#form-submit-shipment').find('input[name=textbox_checked_ids]').val(listShipmentNumber);
                $('#form-submit-shipment').find('input[name=label_option]').val('PDF');
                $("#form-submit-shipment").submit();
            });

            // Print label format ZPL
            $("#printLabelZPL").click(function () {
                checkselected();
                $('#form-submit-shipment').find('input[name=btn_controller]').val('print-label');
                $('#form-submit-shipment').find('input[name=textbox_checked_ids]').val(listShipmentNumber);
                $('#form-submit-shipment').find('input[name=label_option]').val('ZPL');
                $("#form-submit-shipment").submit();
            });

            $("#cancelShipment").click(function () {
                // show modal
                message_cancel_shipment = "{$dataObject->lang['Are you sure you want to cancel selected shipment(s)?']}";
                $("#ups-message-modal .btn-cancel").show();
                $("#ups-message-modal .btn-confirm-message").show();
                alertMessage(message_cancel_shipment, title_cancel_shipmnet);
            });

            $(".btn-confirm-message").click(function () {
                checkselected();
                // $('#form-submit-shipment').find('input[name=btn_controller]').val('cancel-shipment');
                // $('#form-submit-shipment').find('input[name=textbox_checked_ids]').val(listShipmentNumber);
                // $("#form-submit-shipment").submit();
                $('#loadingDiv').show();

                $.ajax({
                    type: "POST",
                    url: '{$dataObject->router_url->url_ajax_json}&method=cancel-shipment',
                    data: "method=cancel-shipment&listShipmentNumber=" + listShipmentNumber,
                    success: function (data)
                    {
                        $('#loadingDiv').hide();
                        if (data.code == '200') {
                            hideAlertMessage();
                            message_cancel_shipment = "{$dataObject->lang['Shipment canceled']}";
                            alertMessage(message_cancel_shipment, title_cancel_shipmnet);
                            $("#ups-message-modal .btn-cancel").hide();
                            $("#ups-message-modal .btn-confirm-message").removeClass("btn-confirm-message");
                            $("div#ups-message-modal .button-primary,div#ups-message-modal .close").attr("onclick", "location.reload();");
                        } else {
                            message_cancel_shipment = data.message;
                            var mess_api = data.message || "";
                            var check_api = mess_api.trim().toLowerCase();
                            if (check_api === 'the shipment was not voided') {
                                message_cancel_shipment = '{$dataObject->lang['hard_code_api_the_shipment_was_not_voided']}';
                            }
                            alertMessage(message_cancel_shipment, title_cancel_shipmnet);
                            $("#ups-message-modal .btn-cancel").hide();
                            $("#ups-message-modal .btn-confirm-message").hide();
                        }
                    },
                    error: function (data)
                    {
                        location.reload();
                    }
                });
            });

            $("#tracking-agree-term a").click(function () {
                // show modal
                var label_mess_1 = "{$dataObject->lang['UPS Tracking Terms and Conditions']}";
                var mess_1 = "{$dataObject->lang['tracking_term_des']}";
                alertConfirm(mess_1, label_mess_1);
            });
        });
    }
    )(jQuery);
</script>
