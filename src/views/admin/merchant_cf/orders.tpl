{include file='admin/merchant_cf/common/header.tpl'}
<div class="ups-full-width">
    <div class="open-oders">
        <ul tabindex="0" class="nav  nav-pills nav-tabs" role="tablist">
            <li class="nav-item ">
                <a id="_tab_open_orders" class="nav-link @#open_orders_active#@"  href="{$dataObject->router_url->url_open_orders}">
                    {$dataObject->lang["open_order"]}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link @#shipments_active#@"  href="{$dataObject->router_url->url_shipments}">
                    {$dataObject->lang["shipments"]}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link @#archived_orders_active#@"  href="{$dataObject->router_url->url_archived_orders}">
                    {$dataObject->lang["archived_orders"]}
                </a>
            </li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content-open-order">
            <div id="open_orders" class="tab-pane @#open_orders_active#@">
                @#open_orders_content#@
            </div>
            <div class="tab-pane @#shipments_active#@" id="shipments">
                @#shipments_content#@
            </div>
            <div id="archived_orders" class="tab-pane @#archived_orders_active#@">
                @#archived_orders_content#@
            </div>
        </div>
    </div>
</div>
{include file='admin/merchant_cf/common/footer.tpl'}
<style type="text/css">
    div.ups_btn_cotroller button{
        margin-top: 5px!important;
    }
    .ml-10{
        margin-left: 10px;
    }
    .open-oders .tab-content-open-order .ship-detail{
        border: 1px solid #ccc;
        max-width: 500px;
        padding: 15px;
    }
    .open-oders .row-btn {
        margin-bottom: 20px;
    }
    .info-order {
        margin: auto 10%;
    }
    .tab-content-open-order{
        display: block!important;
    }
    .info-order table{
        width: 100%;
    }
    .info-order .title-order {
        font-size: 20px;
        color: red;
        text-align: center;
        font-weight: bold;
        margin-top: 0;
        margin-bottom: 5px;
    }
    .open-oders select {
        height: calc(2.25rem + 2px);
    }
    #open_orders table tr,
    #archived_orders table tr{
        vertical-align: text-top;
    }
    .nav-tabs {
        outline: none;
    }
</style>
<script type="text/javascript">
    {if isset($dataObject->object_json_javascript)}
    var object_json_javascript = eval({$dataObject->object_json_javascript});
    {/if}
    (function ($) {
        'use strict';
        $(document).ready(function () {
            $("a.nav-link.active").focus();
        });
    })(jQuery);
</script>
