<table class="table_ups_shipping_options" id="table_ups_shipping_options_{$dataObject->method_id}">
    <tr>
        <td style="width: 40px;">
            <img style="width:27pt!important;" class="ups_img_logo" src="{$img_url}UPS_logo.svg" alt="ups shipping"/>
        </td>
        <td>
            <div class="_upsHeaderContent">
                {$dataObject->format_price_shipping}
            </div>
        </td>
    </tr>
</table>
<style type="text/css">  
    table.woocommerce-checkout-review-order-table .product-name{
        width: auto!important;
    }
</style>