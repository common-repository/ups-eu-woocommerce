{include file='admin/merchant_cf/common/header.tpl'}
<div class="ups-full-width">


    <div class="accordion" id="accordion-shipping-config">
        <!-- ACCOUNT -->
        {if $dataObject->page == 'success_account' || $dataObject->page == 'none_account'}
            <div class="ups-config ups-default-border ups-config-account current-step" data-target="#collapse-account" id="accordion_container_account" tabindex="0">
                <div class="card-header title-tab p-0" id="heading-account">
                    <h5 class="mb-0 _upsTitle">
                        <table>
                            <tr>
                                <td>
                                    <i class="fa fa-user"></i>
                                </td>
                                <td>
                                    {$dataObject->lang["sc_block1"]}
                                </td>
                            </tr>
                        </table>
                    </h5>
                </div>
                <div>#container_form_account#</div>
            </div>
        {/if}
        <!-- SHIPPING SERVICES -->
        {if $dataObject->page == 'shipping_service'}
            <div class="ups-config ups-default-border ups-config-shipping" data-target="#collapse-shipping-service" id="accordion_container_shipping_service" tabindex="0">
                <div class="card-header title-tab p-0" id="heading-shipping-service">
                    <h5 class="mb-0 _upsTitle">
                        <table>
                            <tr>
                                <td>
                                    <i class="fa fa-truck"></i>
                                </td>
                                <td>
                                    {$dataObject->lang["sc_block2"]}
                                </td>
                            </tr>
                        </table>
                    </h5>
                </div>
                <div>#container_form_shipping_service#</div>
            </div>
        {/if}
        <!-- CASH ON DELIVERY -->
        {if $dataObject->page == 'cod'}
            <div class="ups-config ups-default-border ups-config-COD" data-target="#collapse-cod" id="accordion_container_cod" tabindex="0">
                <div class="card-header title-tab p-0" id="heading-cod">
                    <h5 class="mb-0 _upsTitle">
                        <table>
                            <tr>
                                <td>
                                    <i class="fa fa-money"></i>
                                </td>
                                <td>
                                    {$dataObject->lang["Collect on Delivery (COD)"]}
                                </td>
                            </tr>
                        </table>
                    </h5>
                </div>
                <div>#container_form_cod#</div>
            </div>
        {/if}
        <!--  Accessorial Services -->
        {if $dataObject->page == 'accessorial_services'}
            <div class="ups-config ups-default-border ups-config-accessorial-services" data-target="#collapse-accessorial-services" id="accordion_container_accessorial_services" tabindex="0">
                <div class="card-header title-tab p-0" id="heading-cod">
                    <h5 class="mb-0 _upsTitle">
                        <table>
                            <tr>
                                <td>
                                    <i class="fa fa-plus-circle "></i>
                                </td>
                                <td>
                                    {$dataObject->lang["sc_block4"]}
                                </td>
                            </tr>
                        </table>
                    </h5>
                </div>
                <div>#container_form_accessorial_services#</div>
            </div>
        {/if}
        <!--  Package Dimensions -->
        {if $dataObject->page == 'package_dimension'}
            <div class="ups-config ups-default-border ups-config-package-dimension" data-target="#collapse-package-dimension" id="accordion_container_package_dimension" tabindex="0">
                <div class="card-header title-tab p-0" id="heading-package-dimension">
                    <h5 class="mb-0 _upsTitle">
                        <table>
                            <tr>
                                <td>
                                    <i class="fa fa-archive"></i>
                                </td>
                                <td>
                                    {$dataObject->lang["sc_block5"]}
                                </td>
                            </tr>
                        </table>
                    </h5>
                </div>
                <div>#container_form_package_dimension#</div>
            </div>
        {/if}
        <!--  Delivery Rates -->
        {if $dataObject->page == 'delivery_rate'}
            <div class="ups-config ups-default-border ups-config-delivery-rate" data-target="#collapse-delivery-rate" id="accordion_container_delivery_rate"  tabindex="0">
                <div class="card-header title-tab p-0" id="heading-delivery-rate">
                    <h5 class="mb-0 _upsTitle">
                        <table>
                            <tr>
                                <td>
                                    {$dataObject->lang["sc_block6"]}
                                </td>
                            </tr>
                        </table>

                    </h5>
                </div>
                <div>#container_form_delivery_rate#</div>
            </div>
        {/if}
        <!--  Billing Preference -->
        {if $dataObject->page == 'billing_preference'}
            <div class="ups-config ups-default-border ups-config-billing-preference" data-target="#collapse-billing-preference" id="accordion_container_billing_preference" tabindex="0">
                <div  class="card-header title-tab p-0" id="heading-billing_preference">
                    <h5 class="mb-0 _upsTitle">
                        <table>
                            <tr>
                                <td>
                                    <i class="fa fa-credit-card-alt"></i>
                                </td>
                                <td>
                                    {$dataObject->lang["sc_block7"]}
                                </td>
                            </tr>
                        </table>
                    </h5>
                </div>
                <div>#container_form_billing_preference#</div>
            </div>
            {if $dataObject->action_form eq $dataObject->links_form->url_billing_preference}
                <div class="text-right">
                    <form method="POST" action="{$dataObject->action_form}" id="form-submit">
                        <input type="hidden" name="btn_controller" value="complete"/>
                        <button type="submit" id="button-submit" class="button button-primary btn-next">{$dataObject->lang["sc_block7"]}</button>
                    </form>
                </div>
            {/if}
        {/if}
    </div>    

</div>
{include file='admin/merchant_cf/common/footer.tpl'}
<style type="text/css">  
    .accordion .ups-config .card-header p-0{
        border : none;
    }
    .accordion .ups-config .collapse{
        border-top: 1px solid rgba(0,0,0,.125);
    }
    .accordion .ups-config{    
        margin-bottom: 10px;
    }
</style>
<script type="text/javascript">
    {if isset($dataObject->object_json_javascript)}
    var object_json_javascript = eval({$dataObject->object_json_javascript});
    {/if}

    (function ($) {
        'use strict';
        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip();
    {*            window.location.hash = '#' + $("#container_focus_show").parent().parent().attr("id");*}
        });

        $("#button-submit").click(function () {
            $(this).prop('disabled', true);
            $("#form-submit").submit();
        });
    })(jQuery);
</script>
