<div class="card-body" id="container_focus_show">
    <div class="ups-config-accessorial-services"> 
        <div class="form-group ups-payment">       		   			
            <form method="POST" id="form_accessorial_services" action="{$dataObject->action_form}" class=""  role="form">
                <div class="col-md-12"> 
                    <div class="form-group text-muted">
                        <p>{$dataObject->lang["des"]}</p>
                    </div>   

                    {foreach $dataObject->list_option_accessorials as $option_accessorials} 
                        {$disabled = (!$dataObject->cod_is_available && $option_accessorials->accessorial_key|in_array:['UPS_ACSRL_ACCESS_POINT_COD', 'UPS_ACSRL_TO_HOME_COD']) ? true : false}
                        <div>
                            <label class="{if $disabled} text-muted{/if}">
                                <input 
                                    name="accessorial_services[{$option_accessorials->accessorial_key}]" 
                                    type="checkbox" 
                                    {if $disabled} disabled{/if}
                                    {if $option_accessorials->show_shipping eq "1"}checked="true"{/if} /> 
                            {if isset($dataObject->lang[$option_accessorials->accessorial_key])}{$dataObject->lang[$option_accessorials->accessorial_key]}{/if}
                        </label>
                    </div>
                {/foreach}    

                <div class="">
                    <button type="button" class="button button-primary btn-save pull-right">{$dataObject->lang["btn_save"]}</button>
                    {* <button type="button" class="button button-primary pull-right btn-next">{$dataObject->lang["btn_next"]}</button> *}

                    <input type="hidden" id="btn_controller" name="btn_controller" value=""/>
                </div>                    
        </form>		
    </div>    
</div>
</div>
</div>

<script type="text/javascript">
    (function ($) {
        'use strict';
        $(document).ready(function () {
            $("input[name='accessorial_services[UPS_ACSRL_SIGNATURE_REQUIRED]']").click(function () {
                if ($(this).is(':checked')) {
                    $("input[name='accessorial_services[UPS_ACSRL_ADULT_SIG_REQUIRED]']").removeAttr('checked');
                }
            });

            $("input[name='accessorial_services[UPS_ACSRL_ADULT_SIG_REQUIRED]']").click(function () {
                if ($(this).is(':checked')) {
                    $("input[name='accessorial_services[UPS_ACSRL_SIGNATURE_REQUIRED]']").removeAttr('checked');
                }
            });

            $(".btn-save").click(function () {
                $(this).prop('disabled', true);
                $("#btn_controller").val("save");
                $("#form_accessorial_services").submit();
            });
            $(".btn-next").click(function () {
                $(this).prop('disabled', true);
                $("#btn_controller").val("next");
                $("#form_accessorial_services").submit();
            });
        });
    })(jQuery);
</script>



