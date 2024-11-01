{include file='admin/merchant_cf/common/header.tpl'}
<div class="ups-full-width">
    <!-- <h5 class="card-header">UPS Terms and Conditions</h5> -->
    <div class="accordion" id="accordion-shipping-config">
        <!-- ACCOUNT -->
        <div class="ups-config ups-default-border ups-config-account current-step" data-target="#collapse-account">
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
            <div id="collapse-account" class="show" aria-labelledby="heading-account" data-parent="#accordion-shipping-config">
                <div class="card-body">
                    {include file='admin/merchant_cf/shipping_config/forms/none_account.tpl'} 
                </div>
            </div>
        </div>
    </div>
</div>

{include file='admin/merchant_cf/common/footer.tpl'}
<style type="text/css">  
    .accordion .ups-config .collapse{
        border-top: 1px solid rgba(0,0,0,.125);
    }
    .accordion .ups-config{    
        margin-bottom: 10px;
    }
</style>
<script type="text/javascript">
    (function ($) {
        'use strict';
        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });
    })(jQuery);
</script>