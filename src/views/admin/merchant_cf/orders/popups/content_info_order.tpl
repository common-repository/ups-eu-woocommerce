<!-- Modal Header -->
<div class="modal-header">
    <h4 id="modal-title-0" class="modal-title" data-role="title">
        <b style="opacity: 0;">.</b>
    </h4>
    <button type="button" class="close" data-dismiss="modal">&times;</button>
</div>

<!-- Modal body -->
<div class="modal-body">
    <div class="info-order">
        <table style="">
            <tbody>
                <tr>
                    <td colspan="2">
                        <h2 class="title-order">{$dataObject->lang['Order']} #{$dataObject->order->order_id_magento}</h2>
                        <p class="text-center">{$dataObject->order->order_date}, {$dataObject->order->order_time}</p>
                    </td>
                </tr>
                <tr>
                    <td width="40%"><b>{$dataObject->lang['Customer']}:</b></td>
                    <td width="60%">{$dataObject->order->customer_name}</td>
                </tr>
                <tr>
                    <td><b>{$dataObject->lang['product']}:</b></td>
                    <td>
                        {foreach $dataObject->order->product as $product} 
                            <span class="">
                                {$product['qty']} x {$product['name']}
                            </span>
                            <br/>
                        {/foreach}                        
                    </td>
                </tr>
                <tr>
                    <td><b>{$dataObject->lang['address']}:</b></td>
                    <td>
                        {$dataObject->order->add_address_all}
                    </td>
                </tr>
                <tr>
                    <td><b>{$dataObject->lang['phone_number']}:</b></td>
                    <td>{$dataObject->order->woo_billing['phone']}</td>
                </tr>
                <tr>
                    <td><b>{$dataObject->lang['email']}:</b></td>
                    <td>{$dataObject->order->woo_billing['email']}</td>
                </tr>
                <tr>
                    <td><b>{$dataObject->lang['Shipping service']}:</b></td>
                    <td>{$dataObject->order->shipping_service_text}</td>
                </tr>
                <tr>
                    <td><b>{$dataObject->lang['Access Point']}:</b></td>
                    <td>
                        {$dataObject->order->ap_address_all}
                    </td>
                </tr>
                <tr>
                    <td><b>{$dataObject->lang['Accessorial Service']}:</b></td>
                    <td>
                        {$dataObject->order->accessorial_service_text}
                    </td>
                </tr>
                <tr>
                    <td><b>{$dataObject->lang['Orders value']}:</b></td>
                    <td>{$dataObject->order->total_paid_currency}</td>
                </tr>
                <tr>
                    <td><b>{$dataObject->lang['Payment status']}:</b></td>
                    <td>{$dataObject->order->woo_order_status}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Modal footer -->
    <div class="modal-footer">
        <button type="button" class="button button-primary"  data-dismiss="modal">{$dataObject->lang['btn_ok']}</button>
    </div>

</div>