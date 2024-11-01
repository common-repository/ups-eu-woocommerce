<br/>
<form action="exportCSV" method="post" id="form_export_csv" class="hidden">
    <input type="hidden" value='' name='textbox_export_order_ids'/>
</form>

<div class="row ups_btn_cotroller" tabindex="0">
    <div class="col-md-12 row-btn">
        <button type="button" id='create_single_shipment' class="button button-primary" disabled>{$dataObject->lang["Create Single Shipments"]}</button>
        <button type="button"  id='create_batch_shipment' class="button button-primary" disabled>{$dataObject->lang["Create Batch Shipments"]}</button>
        <button type="button" id='btn_export_all_order' class="button button-primary" {if !$dataObject->pagination->list_data->list_main}disabled{/if}>{$dataObject->lang["Export All Orders"]}</button>
        <button id="btn_export_order" type="button" class="button button-primary" disabled>{$dataObject->lang["Export Orders"]}</button>
        <button id="btn_update_archive_order" type="button" class="button button-primary" disabled>{$dataObject->lang["Archive Orders"]}</button>
    </div>
    <div class="col-md-12" style="overflow-x: auto;">
        <table class="table table-hover table-bordered tbl-open-orders">
            <thead>
                <tr>
                    <th   class="text-center align-middle" scope="col" style="width: 50px">
                        <input type="checkbox" name="" id="check-all-order" {if !$dataObject->pagination->list_data->list_main}disabled="disabled"{/if}/>
                    </th>
                    <th class="page-sort text-center align-middle" field-sort="order_id" default-sort = "up" scope="col">
                        {$dataObject->lang["Order ID"]}
                        <a href="javascript:;" class="icon-sort fa fa-sort-none" ></a>
                    </th>
                    <th class="page-sort text-center align-middle" field-sort="order_date" scope="col">
                        {$dataObject->lang["order_date"]}
                        <a href="javascript:;" class="icon-sort fa fa-sort-none" ></a>
                    </th>
                    <th  class="page-sort  text-center align-middle" field-sort="order_time" scope="col">
                        {$dataObject->lang["order_time"]}
                        <a href="javascript:;" class="icon-sort fa fa-sort-none"></a>
                    </th>
                    <th class="text-center align-middle" scope="col">
                        {$dataObject->lang["product"]}
                    </th>
                    <th class="page-sort text-center align-middle" field-sort="delivery_address" scope="col">
                        {$dataObject->lang["Delivery Address"]}
                        <a href="javascript:;" class="icon-sort fa fa-sort-none"></a>
                    </th>
                    <th  class="page-sort  text-center align-middle" field-sort="service_name" scope="col">
                        {$dataObject->lang["shipping_service"]}
                        <a href="javascript:;" class="icon-sort fa fa-sort-none"></a>
                    </th>
                    <th class="page-sort text-nowrap text-center align-middle" field-sort="cod" scope="col"  style="width: 70px">
                        {$dataObject->lang["COD"]}
                        <a href="javascript:;" class="icon-sort fa fa-sort-none"></a>
                    </th>
                </tr>
            </thead>
            <tbody>
                {if $dataObject->pagination->list_data->list_main}
                    {foreach $dataObject->pagination->list_data->list_main as $item_order}
                        <tr>
                            <td class="text-center align-middle">
                                <input class="checkbox-item" type="checkbox" name="" id="order-{$item_order->order_id_magento}" data-id="{$item_order->order_id_magento}" service="{$item_order->service_type}"/>
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
                                {if $item_order->shipping_method_id eq 'ups_eu_shipping'}
                                    {$item_order->shipping_service_text}
                                {else}
                                    {$item_order->default_shipping}
                                {/if}
                                {* {foreach $item_order->accessorial_service as $item_service}
                                <span class="">
                                {$item_service}
                                </span>
                                <br/>
                                {/foreach} *}
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
    <div class="col-md-12">
        {$dataObject->pagination->html_pagination}
    </div>
</div>

<form action="{$dataObject->action_form}" method="post" id="form-btn_export_order" class="d-none">
    <input type="submit" value='export-one-orders' name='btn_controller'/>
    <input type="hidden" value='' name=''/>
</form>


{include file='admin/merchant_cf/orders/popups/main.tpl'}

<script type="text/javascript">
    (function ($) {
        'use strict';
        $(document).ready(function () {
            //get list order
            var list_order = [];
            var list_order_data = [];
            var order_id_checked = 0;
            var ship_from = [];
            var ship_to = [];
            var list_ship_to = [];
            var accessorial_service = [];
            var create_package = [];
            var shipping_type = [];
            var edit_flag = 0;
            var cod = 0;
            var order_value = 0;
            var order_selected_data = [];
            var list_account = {};
            var list_state = {$dataObject->list_state};
            var create_batch_flag = false;
            var create_batch_list_order = "";
            var check_create_batch = false;
            var info_shipto = "";

            function getPackageSelect() {
                create_package = [];
                var package_custom = [];
                $('.package-add-row').each(function () {
                    if ($(this).find('select[id="select-package"]').val() === "custom_package") {
                        var weight = $(this).find('input[name="weight"]').val();
                        var unit_weight = $(this).find('select[name="unit-weight"]').val();
                        var length = $(this).find('input[name="length"]').val();
                        var width = $(this).find('input[name="width"]').val();
                        var height = $(this).find('input[name="height"]').val();
                        var unit_dimension = $(this).find('select[name="unit-dimension"]').val();
                        var package_item = $(this).find('select[name="package_item"]').val();
                        package_custom = {
                            'weight': weight,
                            'unit_weight': unit_weight,
                            'length': length,
                            'width': width,
                            'height': height,
                            'unit_dimension': unit_dimension,
                            'package_item': package_item
                        };
                        create_package.push(package_custom);
                    } else {
                        create_package.push($(this).find('select[id="select-package"]').val());
                    }
                });
            }

            $(document).on('click', '#create_single_shipment', function () {
                $('.close').attr('id', 'close-create-shipment');
                list_order = [];
                list_account = {};
                edit_flag = 0;
                $('.checkbox-item:checked').each(function () {
                    list_order.push($(this).data('id'));
                });
                list_order.sort();
                if (list_order.length == 1) {
                    var id_order = list_order[0];
                } else {
                    var id_order = list_order.toString();
                }

                $('#loadingDiv').show();
                $.ajax({
                    type: "POST",
                    url: '{$dataObject->router_url->url_ajax_json}&method=create-single-shipment',
                    data: "list_id_orders=" + id_order,
                    success: function (data)
                    {
                        list_account = data.list_account;
                        list_order_data = data.order_detail;
                        info_shipto = data.address_text;
                        if (list_order_data.id) {
                            order_value = list_order_data.total_price;
                        } else {
                            order_value = list_order_data.order_value;
                        }
                        if(list_order_data.total_paid){
                            order_value = list_order_data.total_paid;
                        }
                        $('#popupModalMain').modal('show');
                        $('#popupModalMain div.modal-content').html(data.html);
                        showCreateAccessorialAndShippingService(data.order_detail, list_order[0]);
                        addShipTo(data.order_detail, info_shipto);
                        getAccountInfo($(".create-account").val());
                        $('#loadingDiv').hide();
                    },
                    error: function (data)
                    {
                        location.reload();
                    }
                }).done(sync_ups_shipping_update());
            });

            $(document).on('click', '#create_batch_shipment', function () {
                list_order = [];
                list_account = {};
                edit_flag = 0;
                create_batch_flag = true;
                $('.checkbox-item:checked').each(function () {
                    list_order.push($(this).data('id'));
                });
                list_order.sort();
                var id_order = list_order.toString();

                $('#loadingDiv').show();
                $.ajax({
                    type: "POST",
                    url: '{$dataObject->router_url->url_ajax_json}&method=create-batch-shipment',
                    data: "list_id_orders=" + id_order,
                    success: function (data)
                    {
                        list_account = data.list_account;
                        $('#popupModalMain').modal('show');
                        $('#popupModalMain div.modal-content').html(data.html);
                        getAccountInfo(data.account_default_id);
                        $('.close').attr('id', 'close-before-create-batch');
                        $('#list-order-detail').html(data.list_order);
                        $('#loadingDiv').hide();
                    },
                    error: function (data)
                    {
                        location.reload();
                    }
                }).done(sync_ups_shipping_update());
            });

            $(document).on('click', '#btn-create-batch', function () {
                $('#btn-create-batch').attr("disabled", true);
                $('#loadingDiv').show();
                $.ajax({
                    type: "POST",
                    url: '{$dataObject->router_url->url_ajax_json}&method=exec-create-batch-shipment',
                    data: {
                        'ship_from': ship_from,
                        'idorder': list_order
                    },
                    dataType: 'json',
                    success: function (data)
                    {
                        check_create_batch = true;
                        create_batch_list_order = data.list_error;
                        list_order = data.list_order;
                        $('.close').removeAttr('id');
                        $('.close').attr('id', 'close-create-batch');
                        $('#list-order-detail').html(data.result);
                        $('#loadingDiv').hide();
                    },
                    error: function (data)
                    {
                        location.reload();
                    }
                });
            });

            $(document).on('change', 'select[name=editCountry]', function () {
                if ($(this).val()) {
                    var countryCode = $(this).val();
                    showState(countryCode, list_state, '');
                }
            });

            function showCreateAccessorialAndShippingService(data, key) {
                $("#shipping-service-create").html('');
                $("#accessorial-service").html('');
                shipping_type = [];
                accessorial_service = [];
                var type_service = '';
                if (typeof data.accessorial_service === "undefined") {
                    var accessorial_array = data[key].accessorial_service;

                    $.each(accessorial_array, function (key1, value) {
                        $("#accessorial-service").append("<p>" + value + "</p>");
                    });
                    $("#shipping-service-create").html(data[key].shipping_service_text);
                    shipping_type.push(data[key].service_type, data[key].rate_code, data[key].shipping_service, data[key].service_name);

                    //set default account from shipping service config.
                    (data[key].service_type === "AP") ? $(".create-account").val("{$dataObject->account_default['ap']}") : $(".create-account").val("{$dataObject->account_default['add']}");
                    if (data[key].accessorial_cod) {
                        $("#accessorial-service").append("<p>" + data[key].accessorial_cod + "</p>");
                    }
                    cod = (data[key].cod === "1") ? 1 : 0;
                } else {
                    var accessorial_array = data.accessorial_service;

                    $.each(accessorial_array, function (key, value) {
                        $("#accessorial-service").append("<p>" + value + "</p>");
                    });
                    $("#shipping-service-create").html(data.shipping_service_text);
                    shipping_type.push(data.service_type, data.rate_code, data.shipping_service, data.service_name);
                    (data.service_type === "AP") ? $(".create-account").val("{$dataObject->account_default['ap']}") : $(".create-account").val("{$dataObject->account_default['add']}");
                    if (data.accessorial_cod) {
                        $("#accessorial-service").append("<p>" + data.accessorial_cod + "</p>");
                    }
                    cod = (data.cod === "1") ? 1 : 0;
                }
                accessorial_service = accessorial_array;
            }

            //edit shipment
            $(document).on('click', '#btn-edit-shipment', function () {
                $("#rating").html('');
                hideMessage();
                edit_flag = 1;
                order_id_checked = $('input[type=radio][name=create-ship-to-checked]:checked').val();
                fillShipToAddressValue(order_id_checked);
                checkedShippingService(order_id_checked);
                checkedAccessorialService(order_id_checked);
                showEditShipmentToAddressInfo(order_id_checked);
                checkedSignatureAccessorial();
                getPackageSelect();
            });

            $(document).on('click', '#btn-cancel-edit', function () {
                $("#rating").html('');
                $(".remove-row-package").remove();
                hideMessage();
                clearContent();
                $('#popupModalMain').modal('hide');
                edit_flag = 0;
                $('.close').removeAttr('id');
            });

            $(document).on('click', '#close-create-shipment', function () {
                $(this).removeAttr('id');
                $("#rating").html('');
                $(".remove-row-package").remove();
                hideMessage();
                clearContent();
                $('#popupModalMain').modal('hide');
                edit_flag = 0;
                create_batch_flag = false;
            });

            $(document).on('click', '#close-before-create-batch', function () {
                $(this).removeAttr('id');
                create_batch_flag = false;
                check_create_batch = false;
                create_batch_list_order = "";
            });

            $(document).on('click', '#close-create-batch', function () {
                $(this).removeAttr('id');
                create_batch_flag = false;
                check_create_batch = false;
                create_batch_list_order = "";
                location.reload();
            });

            function clearContent() {
                $('#btn-edit-shipment').addClass('primary').removeClass('hidden');
                $('#btn-cancel-edit').addClass('hidden');
                $('#create-ship-to').removeClass('hidden');
                $('#edit-ship-to').addClass('hidden');
                $('#shipping-service-create').removeClass('hidden');
                $('#accessorial-service').removeClass('hidden');
                $('#edit-accessorial-service').addClass('hidden');
                $('#note-us-accessorial').removeClass('hidden');
                if (!$('#edit-shipping-service-to-ap').hasClass('hidden')) {
                    $('#edit-shipping-service-to-ap').addClass('hidden');
                }
                if (!$('#edit-shipping-service-to-add').hasClass('hidden')) {
                    $('#edit-shipping-service-to-add').addClass('hidden');
                }
                var form = document.getElementById('form-create-shipment');
                form.reset();
                clearMakedBorderRed('all');
                //clear state
                if (!$('.showListState').hasClass('hidden'))
                    $('.showListState').addClass('hidden');
                $('select[name=editState]').html('');
            }

            function clearMakedBorderRed(option) {
                switch (option) {
                    case 'shipto':
                        var editInput = $('#edit-ship-to').find('input.formValidate');
                        editInput.each(function () {
                            $(this).removeClass('formValidate');
                        });
                        break;
                    case 'package':
                        var packageInput = $('.add-package').find('input.formValidate');
                        packageInput.each(function () {
                            $(this).removeClass('formValidate');
                        });
                        break;
                    default:
                        var formInput = $('#form-create-shipment').find('input.formValidate');
                        formInput.each(function () {
                            $(this).removeClass('formValidate');
                        });
                        break;
                }
            }

            function fillShipToAddressValue(order_id_checked) {
                if (order_id_checked === undefined) {
                    order_selected_data = list_order_data;
                    if (order_selected_data['service_type'] !== 'undefined' && order_selected_data['service_type'] == "ADD") {
                        if (order_selected_data.woo_shipping['state']) {
                            showState(order_selected_data.woo_shipping['country'], list_state, order_selected_data.woo_shipping['state']);
                        }
                        $('#btn-cancel-edit').removeClass('hidden');
                        $('#create-ship-to').addClass('hidden');
                        $('#edit-ship-to').removeClass('hidden');
                        $('input[name="editName"]').val(order_selected_data.woo_shipping['first_name'] + ' ' + order_selected_data.woo_shipping['last_name']);
                        if (order_selected_data.woo_shipping['address_1'])
                            $('input[name="editAddressLine1"]').val(order_selected_data.woo_shipping['address_1']);
                        else
                            $('input[name="editAddressLine1"]').val();
                        if (order_selected_data.woo_shipping['address_2'])
                            $('input[name="editAddressLine2"]').val(order_selected_data.woo_shipping['address_2']);
                        else
                            $('input[name="editAddressLine2"]').val();
                        $('input[name="editPostalCode"]').val(order_selected_data.woo_shipping['postcode']);
                        $('input[name="editCity"]').val(order_selected_data.woo_shipping['city']);
                        $('select[name=editCountry]').val(order_selected_data.woo_shipping['country']);
                        $('input[name="editPhone"]').val(order_selected_data.phone);
                        $('input[name="editEmail"]').val(order_selected_data.email);
                    }
                } else {
                    order_selected_data = list_order_data[order_id_checked];
                    if (order_selected_data['service_type'] !== 'undefined' && order_selected_data['service_type'] == "ADD") {
                        if (order_selected_data.woo_shipping['state']) {
                            showState(order_selected_data.woo_shipping['country'], list_state, order_selected_data.woo_shipping['state']);
                        }
                        $('#btn-cancel-edit').removeClass('hidden');
                        $('#create-ship-to').addClass('hidden');
                        $('#edit-ship-to').removeClass('hidden');
                        $('input[name="editName"]').val(order_selected_data.woo_shipping['first_name'] + ' ' + order_selected_data.woo_shipping['last_name']);
                        if (order_selected_data.woo_shipping['address_1'])
                            $('input[name="editAddressLine1"]').val(order_selected_data.woo_shipping['address_1']);
                        else
                            $('input[name="editAddressLine1"]').val();
                        if (order_selected_data.woo_shipping['address_2'])
                            $('input[name="editAddressLine2"]').val(order_selected_data.woo_shipping['address_2']);
                        else
                            $('input[name="editAddressLine2"]').val();
                        $('input[name="editPostalCode"]').val(order_selected_data.woo_shipping['postcode']);
                        $('input[name="editCity"]').val(order_selected_data.woo_shipping['city']);
                        $('select[name=editCountry]').val(order_selected_data.woo_shipping['country']);
                        $('input[name="editPhone"]').val(order_selected_data.phone);
                        $('input[name="editEmail"]').val(order_selected_data.email);
                    }
                }
                $('#btn-edit-shipment').removeClass('primary').addClass('hidden');
            }

            function checkedShippingService(order_id_checked) {
                if (order_id_checked === undefined) {
                    order_selected_data = list_order_data;
                    $('input[type=radio][id="' + order_selected_data['shipping_service'] + '"]').prop('checked', true);
                } else {
                    order_selected_data = list_order_data[order_id_checked];
                    $('input[type=radio][id="' + order_selected_data['shipping_service'] + '"]').prop('checked', true);
                }
            }

            function checkedAccessorialService(order_id_checked) {
                var listAccessorial = {};
                if (order_id_checked === undefined) {
                    order_selected_data = list_order_data;
                    if (typeof order_selected_data['accessorial_service'] !== 'undefined') {
                        listAccessorial = order_selected_data['accessorial_service'];
                        for (var key in listAccessorial) {
                            $('input[value="' + key + '"]').prop('checked', true);
                            if (key == 'UPS_ACSRL_STATURDAY_DELIVERY' && order_selected_data['service_key'].indexOf('SAT_DELI') > -1) {
                                $('input[value="' + key + '"]').attr("disabled", true);
                            }
                        }
                        if (order_selected_data['cod'] === "1") {

                            if (order_selected_data['service_type'] == "ADD") {
                                $('input[value="UPS_ACSRL_TO_HOME_COD"]').prop('checked', true);
                            } else {
                                $('input[value="UPS_ACSRL_ACCESS_POINT_COD"]').prop('checked', true);
                            }
                        }
                    }
                } else {
                    order_selected_data = list_order_data[order_id_checked];
                    if (typeof order_selected_data['accessorial_service'] !== 'undefined') {
                        listAccessorial = order_selected_data['accessorial_service'];
                        for (var key in listAccessorial) {
                            $('input[value="' + key + '"]').prop('checked', true);
                            if (key == 'UPS_ACSRL_STATURDAY_DELIVERY' && order_selected_data['service_key'].indexOf('SAT_DELI') > -1) {
                                $('input[value="' + key + '"]').attr("disabled", true);
                            }
                        }
                        if (order_selected_data['cod'] === "1") {
                            if (order_selected_data['service_type'] == "ADD") {
                                $('input[value="UPS_ACSRL_TO_HOME_COD"]').prop('checked', true);
                            } else {
                                $('input[value="UPS_ACSRL_ACCESS_POINT_COD"]').prop('checked', true);
                            }
                        }
                    }
                }
            }

            //Auto check and disable saturday delivery accessorial
            $(document).on('change', 'input[type=radio][name="optradio"]', function () {
                var service_key = $('input[type=radio][name="optradio"]:checked').val();
                if (service_key.indexOf('SAT_DELI') > -1) {
                    $('input[value="UPS_ACSRL_STATURDAY_DELIVERY"]').prop("checked", true);
                    $('input[value="UPS_ACSRL_STATURDAY_DELIVERY"]').attr("disabled", true);
                } else {
                  $('input[value="UPS_ACSRL_STATURDAY_DELIVERY"]').attr("disabled", false);
                }
            });

            function checkedSignatureAccessorial() {
                var signature = $('#edit-accessorial-service').find('input[type=checkbox][value="UPS_ACSRL_SIGNATURE_REQUIRED"]');
                var adultSignature = $('#edit-accessorial-service').find('input[type=checkbox][value="UPS_ACSRL_ADULT_SIG_REQUIRED"]');
                $(signature).change(function () {
                    if ($(this).prop("checked")) {
                        adultSignature.prop("checked", false);
                    }
                });
                $(adultSignature).change(function () {
                    if ($(this).prop("checked")) {
                        signature.prop("checked", false);
                    }
                });
            }

            function showEditShipmentToAddressInfo(order_id_checked) {
                $('#shipping-service-create').addClass('hidden');
                $('#note-us-accessorial').addClass('hidden');
                $('#accessorial-service').addClass('hidden');
                if (order_id_checked === undefined) {
                    order_selected_data = list_order_data;
                    if (typeof order_selected_data['service_type'] !== 'undefined' && order_selected_data['service_type'] === 'AP') {
                        $('#edit-shipping-service-to-ap').removeClass('hidden');
                        $('input[type=checkbox][value="UPS_ACSRL_TO_HOME_COD"]').parent().parent().addClass('hidden');
                        $('input[type=checkbox][value="UPS_ACSRL_ACCESS_POINT_COD"]').parent().removeClass('hidden');
                    } else if (typeof order_selected_data['service_type'] !== 'undefined' && order_selected_data['service_type'] === 'ADD') {
                        $('#edit-shipping-service-to-add').removeClass('hidden');
                        $('input[type=checkbox][value="UPS_ACSRL_ACCESS_POINT_COD"]').parent().addClass('hidden');
                        $('input[type=checkbox][value="UPS_ACSRL_TO_HOME_COD"]').parent().parent().removeClass('hidden');
                    }
                    else{
                        $('#edit-shipping-service-to-add').removeClass('hidden');
                        $('input[type=checkbox][value="UPS_ACSRL_ACCESS_POINT_COD"]').parent().addClass('hidden');
                        $('input[type=checkbox][value="UPS_ACSRL_TO_HOME_COD"]').parent().parent().removeClass('hidden');
                    }
                } else {
                    order_selected_data = list_order_data[order_id_checked];
                    if (typeof order_selected_data['service_type'] !== 'undefined' && order_selected_data['service_type'] === 'AP') {
                        $('#edit-shipping-service-to-ap').removeClass('hidden');
                        $('input[type=checkbox][value="UPS_ACSRL_TO_HOME_COD"]').parent().parent().addClass('hidden');
                        $('input[type=checkbox][value="UPS_ACSRL_ACCESS_POINT_COD"]').parent().removeClass('hidden');
                    } else if (typeof order_selected_data['service_type'] !== 'undefined' && order_selected_data['service_type'] === 'ADD') {
                        $('#edit-shipping-service-to-add').removeClass('hidden');
                        $('input[type=checkbox][value="UPS_ACSRL_ACCESS_POINT_COD"]').parent().addClass('hidden');
                        $('input[type=checkbox][value="UPS_ACSRL_TO_HOME_COD"]').parent().parent().removeClass('hidden');
                    }
                }
                $('#edit-accessorial-service').removeClass('hidden');

            }

            //check
            function addNewShipTo() {
                var shipTo = [];
                var name = $('input[name="editName"]').val();
                var state = $('select[name=editState]').val();
                var address1 = $('input[name="editAddressLine1"]').val();
                var address2 = $('input[name="editAddressLine2"]').val();
                var address3 = $('input[name="editAddressLine3"]').val();
                var postcode = $('input[name="editPostalCode"]').val();
                var city = $('input[name="editCity"]').val();
                var country_code = $('select[name="editCountry"]').val();
                var email = $('input[name="editEmail"]').val();
                var phone = $('input[name="editPhone"]').val();
                if (!state)
                    state = '';
                shipTo.push(name, state, phone, address1, address2, address3, city, postcode, country_code, email);
                return shipTo;
            }

            function addNewShippingService(order_id_checked) {
                var shippingService = [];
                if (order_id_checked) {
                    order_selected_data = list_order_data[order_id_checked];
                } else {
                    order_selected_data = list_order_data;
                }
              
                if (order_selected_data['service_type'] == "AP") {
                    var checkedShippingService = $('#edit-shipping-service-to-ap').find('input[type=radio]:checked');
                } else {
                    var checkedShippingService = $('#edit-shipping-service-to-add').find('input[type=radio]:checked');
                }
                var id = checkedShippingService.attr("id");
                var service_type = checkedShippingService.attr("service-type");
                if (!service_type) {
                    service_type = order_selected_data['service_type'];
                }
                var rate_code = checkedShippingService.attr("data-rateCode");
                var servicename = checkedShippingService.attr("service-name");
                shippingService.push(service_type, rate_code, id, servicename);
                return shippingService;
            }

            function addNewAccessorial() {
                var accessorial = {};
                var listCheckedAccessorial = $('#edit-accessorial-service').find('input[type=checkbox]:checked');
                var accessorialKey = '';
                var accessorialName = '';
                listCheckedAccessorial.each(function () {
                    accessorialKey = $(this).val();
                    accessorialName = $(this).parent().text().trim();
                    if (accessorialKey !== 'UPS_ACSRL_ACCESS_POINT_COD' && accessorialKey !== 'UPS_ACSRL_TO_HOME_COD')
                        accessorial[accessorialKey] = accessorialName;
                });
                return accessorial;
            }

            function addNewCOD() {
                var apCODChecked = $('#edit-accessorial-service').find('input[type=checkbox][value="UPS_ACSRL_ACCESS_POINT_COD"]').prop("checked");
                var addCODChecked = $('#edit-accessorial-service').find('input[type=checkbox][value="UPS_ACSRL_TO_HOME_COD"]').prop("checked");
                if (apCODChecked || addCODChecked)
                    return 1;
                else
                    return 0;
            }

            function showState(country_code, list_state, stateselected) {
                if ($('.showListState').hasClass('hidden')) {
                    $('.showListState').removeClass('hidden');
                }

                var listStateOfCountry = list_state[country_code];

                var showListStateValue = '';
                for (var key in listStateOfCountry) {
                    showListStateValue = showListStateValue + '<option value="' + key + '">' + listStateOfCountry[key] + '</option>';
                }

                if (showListStateValue.length == 0) {
                    if (!$('.showListState').hasClass('hidden')) {
                        $('.showListState').addClass('hidden');
                    }
                    $('select[name=editState]').html('');
                } else {
                    $('select[name=editState]').html(showListStateValue);
                    if (stateselected) {
                        $('select[name=editState]').val(stateselected);
                    }
                }
            }
            //end edit shipment

            //create shipment
            $(document).on('change', 'input[type=radio][name="create-ship-to-checked"]', function () {
                var order_selected = $('input[type=radio][name="create-ship-to-checked"]:checked').val();
                showCreateAccessorialAndShippingService(list_order_data, order_selected);
                ship_to = [];
                if (shipping_type[0] === 'AP') {
                    ship_to.push(list_ship_to[order_selected].ap_name, list_ship_to[order_selected].ap_state, list_ship_to[order_selected].phone, list_ship_to[order_selected].ap_address1, list_ship_to[order_selected].ap_address2, list_ship_to[order_selected].ap_address3, list_ship_to[order_selected].ap_city, list_ship_to[order_selected].ap_postcode, list_ship_to[order_selected].ap_country, list_ship_to[order_selected].email);
                } else {
                    var address_name = list_ship_to[order_selected].woo_shipping.first_name + ' ' + list_ship_to[order_selected].woo_shipping.last_name;
                    ship_to.push(address_name, list_ship_to[order_selected].woo_shipping.state, list_ship_to[order_selected].phone, list_ship_to[order_selected].woo_shipping.address_1, list_ship_to[order_selected].woo_shipping.address_2, '', list_ship_to[order_selected].woo_shipping.city, list_ship_to[order_selected].woo_shipping.postcode, list_ship_to[order_selected].woo_shipping.country, list_ship_to[order_selected].email);
                }
                if (edit_flag) {
                    checkedShippingService(order_selected);
                    $('#edit-accessorial-service').find('input[type=checkbox]:checked').prop('checked', false);
                    checkedAccessorialService(order_selected);
                }
            });

            $(document).on('click', '#btn-create-shipment', function () {
                hideMessage();
                getPackageSelect();
                var order_selected = $('input[type=radio][name="create-ship-to-checked"]:checked').val();
                if (edit_flag) {
                    shipping_type = addNewShippingService(order_selected);
                    accessorial_service = addNewAccessorial();
                    cod = addNewCOD();
                    if (order_selected) {
                        order_selected_data = list_order_data[order_selected];
                        if (order_selected_data['service_type'] !== 'undefined' && order_selected_data['service_type'] == "ADD") {
                            ship_to = addNewShipTo();
                        }
                    } else {
                        order_selected_data = list_order_data;
                        if (order_selected_data['service_type'] !== 'undefined' && order_selected_data['service_type'] == "ADD") {
                            ship_to = addNewShipTo();
                        }
                    }
                } else {
                    if (order_selected) {
                        order_selected_data = list_order_data[order_selected];
                    } else {
                        order_selected_data = list_order_data;
                    }
                }
                $('#btn-create-shipment').attr("disabled", true);
                $('#loadingDiv').show();
                $.ajax({
                    type: "POST",
                    url: '{$dataObject->router_url->url_ajax_json}&method=create-shipment',
                    data: {
                        'ship_from': ship_from,
                        'ship_to': ship_to,
                        'shipping_type': shipping_type,
                        'package': create_package,
                        'accessorial_service': accessorial_service,
                        'idorder': list_order,
                        'cod': cod,
                        'order_value': order_value,
                        'order_selected': order_selected_data,
                        'edit_shipment': edit_flag
                    },
                    dataType: 'json',
                    success: function (data)
                    {
                        hideMessage();
                        if (data.check) {
                            clearMakedBorderRed('all');
                            location.reload();
                        } else {
                            $('#btn-create-shipment').removeAttr("disabled");
                            if (edit_flag) {
                                $(".btn-cancel-edit").removeAttr("disabled");
                            } else {
                                $(".btn-edit-shipment").removeAttr("disabled");
                            }
                            showMessage(data.message, false);
                            var list_error = data.result;
                            if (data.validate[0]) {
                                clearMakedBorderRed('shipto');
                                markErrorPackage(list_error);
                            } else if (data.validate[1]) {
                                clearMakedBorderRed('package');
                                markErrorEditShipto(list_error);
                            } else {
                                markErrorEditShipto(list_error[0]);
                                markErrorPackage(list_error[1]);
                            }
                        }
                        $('#loadingDiv').hide();
                    },
                    error: function (data)
                    {
                        $('#loadingDiv').hide();
                        $('#btn-create-shipment').removeAttr("disabled");
                        (edit_flag) ? $(".btn-cancel-edit").removeAttr("disabled") : $(".btn-edit-shipment").removeAttr("disabled");
                        showMessage('{$dataObject->lang["error_api_try_again"]}', false);
                    }
                });
            });

            function markErrorEditShipto(list_error) {
                if (list_error) {
                    var index = 0;
                    $('#edit-ship-to').find('input[data-type="required"]').each(function () {
                        var name = $(this).attr("name");
                        addClassError($(this).parent(), name, list_error[index]);
                        index++;
                    });
                }
            }

            function markErrorPackage(list_error) {
                if (list_error) {
                    var index = 0;
                    $(".add-package").find(".package-add-row").each(function () {
                        if (list_error[index]) {
                            addClassError(this, 'weight', list_error[index]["package-weight"]);
                            addClassError(this, 'length', list_error[index]["package-length"]);
                            addClassError(this, 'width', list_error[index]["package-width"]);
                            addClassError(this, 'height', list_error[index]["package-height"]);
                        }
                        index = index + 1;
                    });
                }
            }

            function clearMarkErrorEditShipto() {

            }

            function clearMarkErrorPackage() {

            }

            $(document).on('click', '#api-rating-view-estimated-shipping-fee', function () {
                $("#rating").html('');
                hideMessage();
                getPackageSelect();
                var order_selected = $('input[type=radio][name="create-ship-to-checked"]:checked').val();
                if (edit_flag) {
                    shipping_type = addNewShippingService(order_selected);
                    accessorial_service = addNewAccessorial();
                    cod = addNewCOD();
                    if (order_selected) {
                        order_selected_data = list_order_data[order_selected];
                        if (order_selected_data['service_type'] !== 'undefined' && order_selected_data['service_type'] == "ADD") {
                            ship_to = addNewShipTo();
                        }
                    } else {
                        order_selected_data = list_order_data;
                        if (order_selected_data['service_type'] !== 'undefined' && order_selected_data['service_type'] == "ADD") {
                            ship_to = addNewShipTo();
                        }
                    }
                } else {
                    if (order_selected) {
                        order_selected_data = list_order_data[order_selected];
                    } else {
                        order_selected_data = list_order_data;
                    }
                }

                $('#loadingDiv').show();
                $.ajax({
                    type: "POST",
                    url: '{$dataObject->router_url->url_ajax_json}&method=estimated-shipping-fee',
                    data: {
                        'ship_from': ship_from,
                        'ship_to': ship_to,
                        'shipping_type': shipping_type,
                        'package': create_package,
                        'accessorial_service': accessorial_service,
                        'idorder': list_order,
                        'cod': cod,
                        'order_value': order_value,
                        'order_selected': order_selected_data,
                        'edit_shipment': edit_flag
                    },
                    dataType: 'json',
                    success: function (data)
                    {
                        hideMessage();
                        if (data.check) {
                            clearMakedBorderRed('all');
                            $(".add-package").find(".package-add-row input").removeClass("formValidate");
                            $("#rating").text(data.result['time_in_transit'] + ' ' + data.result['monetary_value'] + ' ' + data.result['currency_code']);
                        } else {
                            showMessage(data.message, false);
                            var list_error = data.result;
                            if (data.validate[0]) {
                                clearMakedBorderRed('shipto');
                                markErrorPackage(list_error);
                            } else if (data.validate[1]) {
                                clearMakedBorderRed('package');
                                markErrorEditShipto(list_error);
                            } else {
                                markErrorEditShipto(list_error[0]);
                                markErrorPackage(list_error[1]);
                            }
                        }
                        $('#loadingDiv').hide();
                    },
                    error: function (data)
                    {
                        $('#loadingDiv').hide();
                        showMessage('{$dataObject->lang["error_api_try_again"]}', false);
                    }
                });
            });

            //Add Ship To:
            function addShipTo(data, info_shipto) {
                ship_to = [];
                list_ship_to = [];
                if (typeof data.id !== "undefined") {       //single order.
                    if (data.service_type == 'AP') {
                        var html_data = data.ap_address_text;
                        ship_to.push(data.ap_name, data.ap_state, data.phone, data.ap_address1, data.ap_address2, data.ap_address3, data.ap_city, data.ap_postcode, data.ap_country, data.email);
                    } else {
                        var address_name = data.woo_shipping.first_name + ' ' + data.woo_shipping.last_name;
                        var html_data = data.add_address_text;
                        ship_to.push(address_name, data.woo_shipping.state, data.phone, data.woo_shipping.address_1, data.woo_shipping.address_2, '', data.woo_shipping.city, data.woo_shipping.postcode, data.woo_shipping.country, data.email);
                    }
                    $("#create-ship-to").html(html_data);
                } else {
                    var check = "";
                    $("#create-ship-to").html('');
                    list_ship_to = data;
                    var index = 0;
                    $.each(list_order, function (key, value) {
                        var html_data = info_shipto;
                        var temp_data = "";
                        if (index == 0) {
                            check = 'checked';
                        } else {
                            check = '';
                        }
                        var shipto_data = list_ship_to[value];
                        temp_data = html_data.split("#_$@CHECK@$#");
                        html_data = temp_data.join(check);
                        temp_data = html_data.split("#_$@RADIO_VALUE@$#");
                        html_data = temp_data.join(value);
                        if (shipto_data.service_type == 'AP') {
                            temp_data = html_data.split("#_$@ADDRESS_TEXT@$#");
                            html_data = temp_data.join(shipto_data.ap_address_text);
                            if (index == 0) {
                                ship_to.push(shipto_data.ap_name, shipto_data.ap_state, shipto_data.phone, shipto_data.ap_address1, shipto_data.ap_address2, shipto_data.ap_address3, shipto_data.ap_city, shipto_data.ap_postcode, shipto_data.ap_country, shipto_data.email);
                            }
                        } else {
                            var address_name = shipto_data.woo_shipping.first_name + ' ' + shipto_data.woo_shipping.last_name;
                            temp_data = html_data.split("#_$@ADDRESS_TEXT@$#");
                            html_data = temp_data.join(shipto_data.add_address_text);
                            if (index == 0) {
                                ship_to.push(address_name, shipto_data.woo_shipping.state, shipto_data.phone, shipto_data.woo_shipping.address_1, shipto_data.woo_shipping.address_2, '', shipto_data.woo_shipping.city, shipto_data.woo_shipping.postcode, shipto_data.woo_shipping.country, shipto_data.email);
                            }
                        }
                        $("#create-ship-to").append(html_data);
                        index++;
                    });
                }
            }

            function getAccountInfo(id) {
                $("#rating").html('');
                hideMessage();
                var selected_account = {};
                var account_company = '';
                if (typeof list_account[0] !== 'undefined' && typeof list_account[0].company !== 'undefined') {
                    account_company = list_account[0].company;
                }
                list_account.forEach(function (item) {
                    if (item['account_id'] === id) {
                        selected_account = item;
                    }
                });

                if (selected_account.account_info && !create_batch_flag) {
                    $('#create-ship-from').html(selected_account.account_info);
                }

                var name = "";
                if (selected_account.account_id !== "1") {
                    name = selected_account.ups_account_name;
                } else {
                    name = selected_account.fullname;
                }

                ship_from = [];
                ship_from.push(name, account_company, selected_account.ups_account_number, selected_account.phone_number, selected_account.address_1, selected_account.address_2, selected_account.address_3, selected_account.city, selected_account.postal_code, selected_account.country, selected_account.state);
            }

            $(document).on("change", "select[name='createAccount']", function () {
                $("#rating").html('');
                hideMessage();
                getAccountInfo($(this).val());
                if (create_batch_flag && check_create_batch) {
                    $('#list-order-detail').html(create_batch_list_order);
                    if (create_batch_list_order) {
                        $('#btn-create-batch').removeAttr("disabled");
                    }
                }
            });

            function showMessage(message, check) {
                if (check) {
                    $(".create-shipment-show-message").html('');
                    $(".create-shipment-show-message").addClass("hidden");
                } else {
                    var message_text = '<ul class="create-shipment-list-message"><li class="create-shipment-message">' + message + '</li></ul>' +
                            '<button type="button" class="notice-dismiss" id="clear-message"></button>';
                    $(".create-shipment-show-message").html(message_text);
                    $(".create-shipment-show-message").removeClass("hidden");
                    var scroll_height = $('#create-single-shipment')[0].scrollHeight;
                    $('#create-single-shipment').scrollTop(scroll_height);
                }
            }

            function hideMessage() {
                $(".create-shipment-show-message").html('');
                $(".create-shipment-show-message").addClass("hidden");
            }

            function addClassError(element, name, check) {
                if (!check) {
                    $(element).find('input[name="' + name + '"]').addClass("formValidate");
                } else {
                    $(element).find('input[name="' + name + '"]').removeClass("formValidate");
                }
            }

            $(document).on('click', "#add-package", function () {
                $("#rating").html('');
                var html = $(".package-add-row").html();
                var add_package_format = $('<div class="package-add-row remove-row-package">' + html + '</div>');
                add_package_format.find('.remove-package-layout').removeClass('hidden');
                add_package_format.find('#custom-package').addClass('hidden');
                $(".add-package").append(add_package_format);
                loadAutoIncement();
            });

            $(document).on('click', '.remove-row', function () {
                $("#rating").html('');
                $(this).parents(".remove-row-package").remove();
                loadAutoIncement();
            });

            $(document).on("change", "#select-package", function () {
                $("#rating").html('');
                hideMessage();
                $(this).parents('.package-add-row').find('input').removeClass('formValidate');
                if (this.value == 'custom_package') {
                    $(this).parents('.package-add-row').find("#custom-package").removeClass('hidden');
                } else {
                    $(this).parents('.package-add-row').find("#custom-package").addClass('hidden');
                    $(this).parents('#custom-package').find('input').val('');
                }
            });

            function loadAutoIncement() {
                $('.add-package').find('.label-auto-increment').each(function (index) {
                    $(this).find('o').html(index + 1);
                });
            }

            $(document).on("click", "#clear-message", function () {
                hideMessage();
            });
            //end create shipment

            $("table.tbl-open-orders tr td.clickInfo").click(function () {
                $('#loadingDiv').show();
                var order_id = $(this).parents('tr').find('.checkbox-item').data('id');
                $.ajax({
                    type: "POST",
                    url: '{$dataObject->router_url->url_ajax_json}&method=info-order',
                    data: "info_type_order=open_order&id_order=" + order_id,
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

            //selected all
            $('#check-all-order').click(function () {
                $('.checkbox-item').prop('checked', $(this).prop('checked'));
                if ($(this).prop('checked'))
                {
                    $("#btn_export_order").prop('disabled', false);
                    $("#btn_update_archive_order").prop('disabled', false);
                    $("#create_batch_shipment").prop('disabled', false);
                    // $(".tbl-open-orders>tbody>tr").each(function() {
                    //     $(this).addClass('selected');
                    // })
                    checkButtonSingleBatch();
                }
                else
                {
                    $("#btn_export_order").prop('disabled', true);
                    $("#btn_update_archive_order").prop('disabled', true);
                    $("#create_batch_shipment").prop('disabled', true);
                    $("#create_single_shipment").prop('disabled', true);
                    // $(".tbl-open-orders>tbody>tr").each(function() {
                    //     $(this).removeClass('selected');
                    // })
                }
            });

            function checkButtonSingleBatch() {
                var listService = [];
                $(".checkbox-item:checked").each(function () {
                    listService.push($(this).attr('service'));
                })
                var AP = 0;
                var ADD = 0;
                $.each(listService, function (key, value) {
                    if (value == 'AP') {
                        AP++;
                    } else {
                        ADD++;
                    }
                });
                if (parseInt(AP) > 0 && parseInt(ADD) > 0) {
                    $("#create_single_shipment").prop('disabled', true);
                } else {
                    $("#create_single_shipment").prop('disabled', false);
                }
            }

            $(".checkbox-item").click(function () {
                if ($('.checkbox-item:checked').length > 0) {
                    $("#btn_export_order").prop('disabled', false);
                    $("#btn_update_archive_order").prop('disabled', false);
                    if ($('.checkbox-item:checked').length == 1) {
                        $("#create_single_shipment").prop('disabled', false);
                        $("#create_batch_shipment").prop('disabled', true);
                    } else {
                        $("#create_batch_shipment").prop('disabled', false);
                    }
                    if ($('.checkbox-item:checked').length === $('.checkbox-item').length) {
                        $('#check-all-order').prop('checked', true);
                    } else {
                        $('#check-all-order').prop('checked', false);
                    }
                    checkButtonSingleBatch();
                }
                else {
                    $('#check-all-order').prop('checked', false);
                    $("#btn_export_order").prop('disabled', true);
                    $("#btn_update_archive_order").prop('disabled', true);
                    $("#create_batch_shipment").prop('disabled', true);
                    $("#create_single_shipment").prop('disabled', true);
                }
            });


            function export_order(orderIds) {
                $('#form_export_csv').find('input[name=textbox_export_order_ids]').val(orderIds);
                var param = new Object();
                param.page = "ups-eu-woocommerce-export_csv";
                var action = repalceParams(param, window.location.href);
                $('#form_export_csv').attr('action', action);
                $('#form_export_csv').submit();
            }
            //export data
            $('#btn_export_order').click(function () {
                var orderIds = [];
                $('.checkbox-item:checked').each(function () {
                    orderIds.push($(this).attr('data-id'));
                });
                export_order(orderIds);

            });
            //export all data
            $('#btn_export_all_order').click(function () {
                export_order('all');
            });


            //archive orders
            //action show modal confirm DELETE
            $(document).on('click', '#btn_update_archive_order', function () {
                //get url from attribute of a element
                var param = new Object();
                var orderIds = [];
                $('.checkbox-item:checked').each(function () {
                    orderIds.push($(this).attr('data-id'));
                });

                param.order_ids = orderIds;
                param.btn_controller = 'set_archive_order';
                var url = repalceParams(param, window.location.href);

                $('#loadingDiv').show();
                $.post(url, function () {
                    location.reload();
                });

                // set url to button DELETE
                $('.btn-confirm-message').attr('url', url);
                $('.btn-confirm-message').attr('type-confirm', 'set_archive_order');

                // show modal
                // var mess = "{$dataObject->lang["Warning - Archiving orders will move your orders in the Archive tab and you can no longer process these orders. Click 'OK' to continue, 'Cancel' to go back to the screen"]}";
                // alertMessage(mess, "{$dataObject->lang['Archiving Orders']}");

            });
            //action click button DELETE package
            $(document).on('click', '.btn-confirm-message', function () {
                var type_confirm = $(this).attr('type-confirm');
                var url = $(this).attr('url');
                $.post(url, function () {
                    location.reload();
                });
            });
        });
    }
    )(jQuery);
</script>