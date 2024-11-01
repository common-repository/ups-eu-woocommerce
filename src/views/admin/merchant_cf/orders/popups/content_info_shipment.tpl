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
        <table class="info-shipment">
            <tbody>
                <tr>
                    <td colspan="2" class="text-center">
                        <h2 class="title-order">{$dataObject->lang['Shipment']} #{$dataObject->order->shipment_shipment_number}</h2>

                        <p style="margin: 4px 0">{$dataObject->order->order_date}, {$dataObject->order->order_time}</p>
                        <p style="margin: 4px 0; color:red">{$dataObject->order->shipment_status}</p>
                    </td>
                </tr>
                <tr>
                    <td width="40%"><b>{$dataObject->lang['Order #ID reference']}:</b></td>
                    <td width="60%">{$dataObject->order->order_id_magento}</td>
                </tr>
                <tr>
                    <td width="40%"><b>{$dataObject->lang['Tracking number']}:</b></td>
                    <td width="60%">{$dataObject->order->tracking_number}</td>
                </tr>
                <tr>
                    <td width="40%"><b>{$dataObject->lang['Customer']}:</b></td>
                    <td width="60%">{stripslashes($dataObject->order->customer_name|escape:'htmlall':'UTF-8')}</td>
                </tr>
                <tr>
                    <td><b>{$dataObject->lang['product']}:</b></td>
                    <td>
                        {foreach $dataObject->order->product as $product} 
                            <span class="">
                                {$product['qty']} x {stripslashes($product['name']|escape:'htmlall':'UTF-8')}
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
                    <td>
                        {stripslashes($dataObject->order->shipment_phone|escape:'htmlall':'UTF-8')}
                    </td>
                </tr>
                <tr>
                    <td><b>{$dataObject->lang['email']}:</b></td>
                    <td>
                        {stripslashes($dataObject->order->shipment_email|escape:'htmlall':'UTF-8')}
                    </td>
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
                    <td><b>{$dataObject->lang['Package details']}:</b></td>
                    <td>
                        {stripslashes($dataObject->order->package_detail|escape:'htmlall':'UTF-8')}
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
                    <td>{$dataObject->order->shipment_order_value}</td>
                </tr>
                <tr>
                    <td><b>{$dataObject->lang['Estimated Shipping Fee']}:</b></td>
                    <td>{$dataObject->order->currency_code}{$dataObject->order->shipment_shipping_fee}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Modal footer -->
    <div class="modal-footer">
        <button type="button" class="button button-primary"  data-dismiss="modal">{$dataObject->lang['btn_ok']}</button>
    </div>

</div>

<script type="text/javascript">
    sync_ups_shipping_update();
</script>    