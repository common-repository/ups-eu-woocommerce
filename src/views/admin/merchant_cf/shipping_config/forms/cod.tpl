<div class="card-body" id="container_focus_show">
    <div class="ups-config-cod"> 
        <div class="form-group ups-payment">       	
            <form method="POST" id='form_cod' action="{$dataObject->action_form}" class="form-inline"  role="form">
                <div class="col-sm-12"> 				
                    <div class="form-group">
                        {if $dataObject->cod_is_available}
                            <table class="cod_header">
                                <tr>
                                    <td>
                                        <img style="width: 33px;" src="{$img_url}cod_check_mark.png" class="rounded d-inline" alt="ups shipping"/>&nbsp;
                                    </td>
                                    <td style="vertical-align: bottom;">
                                        <b>
                                            {$dataObject->lang["des1_installed"]}    
                                        </b>
                                    </td>
                                </tr>
                            </table>
                            <p>
                                <b>
                                    {$dataObject->lang["des1_installed_1"]}
                                </b>
                            </p>
                        {else}
                            <table class="cod_header">
                                <tr>
                                    <td>
                                        <img style="width: 33px;" src="{$img_url}cod_cross_mark.png" class="rounded d-inline" alt="ups shipping"/>&nbsp;
                                    </td>
                                    <td style="vertical-align: bottom;">
                                        <b>
                                            {$dataObject->lang["des1_not_install_yet"]}   
                                        </b>
                                    </td>
                                </tr>
                            </table>
                            <p>
                                <b>
                                    {$dataObject->lang["des1_installed_1"]}
                                </b>
                            </p>
                            <p>
                                {$dataObject->lang["des1_not_install_yet_2"]}
                            </p>
                        {/if}
                    </div>		
                    {if ($dataObject->lang['countryCode'] != "US")}	  	
                        <div class="form-group pb-1  mt-4">
                            <label class="mr-2"><strong>{$dataObject->lang["des6"]}</strong></label>           
                            <label class="switch">
                                <input {if $dataObject->ups_accept_cod}checked="true"{/if} name="ups_accept_cod" type="checkbox" id="confirm-cod-2">
                                <span class="slider round"></span>              
                            </label>
                            <label class="ml-1" id="label-confirm-cod-2">{if $dataObject->ups_accept_cod}{$dataObject->lang["Yes"]}{else}{$dataObject->lang["No"]}{/if}</label>
                        </div>          
                        <div class="form-group">
                            <strong class="strong mt-0 mb-2">
                                {$dataObject->lang['des5']}                        
                            </strong>
                        </div>
        
                    {/if}
                </div>			
                <div class="col-sm-12 text-right">
                    <button  id='btn_next' type="button" class="button button-primary btn-next">{$dataObject->lang["btn_next"]}</button>
                </div>
            </form>		
        </div>    
    </div>
</div>
<style type="text/css">
    .card-body .text-muted{
        margin-top: 10px;
        font-style: italic;
    }
    .card-body p{
        padding: 0;
        margin-bottom: 0;
    }
    .card-body button.btn-next{
        margin-top: 10px;
    }
    table.cod_header{
        display: block;
        width: 100%;
    }
</style>

<script type="text/javascript">
    (function ($) {
        'use strict';
        $(document).ready(function () {
            $("#btn_next").click(function () {
                $(this).prop('disabled', true);
                $("#form_cod").submit();
            });

            $("#confirm-cod-2").change(function () {
                if ($(this).prop('checked')) {
                    $("#label-confirm-cod-2").text('{$dataObject->lang["Yes"]}');

                } else {
                    $("#label-confirm-cod-2").text('{$dataObject->lang["No"]}');
                }
            });
        });
    }
    )(jQuery);
</script>