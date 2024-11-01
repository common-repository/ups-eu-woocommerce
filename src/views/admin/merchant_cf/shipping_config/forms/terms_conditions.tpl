<div class="ups-full-width">
    <!-- <h6 class="card-header">UPS Terms and Conditions</h6> -->

    <form method="POST" id="form_term_conditions" action="{$dataObject->action_form}">      
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <h6  id="term-condition-title">{$dataObject->lang["UPSTermsAndConditions"]}</h6>
                    {if $dataObject->message_call_api_error}
                        <div class="form-group notice-error settings-error notice is-dismissible"> 
                            <ul>
                                <li>{$dataObject->message_call_api_error}</li>
                            </ul>
                            <button type="button" class="notice-dismiss">
                                <span class="screen-reader-text"></span>
                            </button>
                        </div>
                    {/if}
                    {if !$dataObject->message_call_api_error}
                        <div {if $dataObject->message_call_api_error}disabled="disabled"{/if} class="ups-term">
                            <div class="column one-column" id="content-print" >{$dataObject->access_license_text}</div>
                        </div>
                    {/if}
                </div>
            </div>
            {if !$dataObject->message_call_api_error}
                <div class="col-12">
                    <div class="form-group">        
                        <input tabindex="0" type="checkbox" name="agree-term-and-usage" id="agree-term-and-usage" required="">
                        <label class="label-fix-mb-3" for="agree-term-and-usage">{$dataObject->lang["agree_term_condition"]}</label>
                    </div>
                </div>
                <div class="col-12">
                    <div class="">
                        <button  tabindex="0" disabled="disabled" type="button" id='btn-continue' class="button button-secondary">{$dataObject->lang["btn_continue"]}</button>
                        <a  tabindex="0" id="btn-print" class="button button-primary pull-right" href="javascript:">{$dataObject->lang["btn_print"]}</a>
                    </div>
                    <input type="hidden" name="access_license_text" id='access_license_text' value=""/>
                </div>
            {/if}
        </div>
    </form>
</div>

{include file='admin/merchant_cf/common/confirm_modal.tpl'}

<style type="text/css">
    #content-print.column.one-column{
        display: block;
        font-family: monospace;
        white-space: pre-line;
    }
    .ups-term{
        max-height: 500px;
        overflow: auto;
        border: 1px solid rgba(0,0,0,.125);
        padding: 10px;  
    }
    .modal-body {
		overflow-y: auto;
		max-height: 686px;
	}
    .ups-shipping-container .label-fix-mb-3 {
        display: inline;
    }
</style>

<script type="text/javascript">
    {if isset($dataObject->object_json_javascript)}
    var object_json_javascript = eval({$dataObject->object_json_javascript});
    {/if}

    (function ($) {
        'use strict';
        $(document).ready(function () {
            $("#content-print").attr("tabindex", 0).focus();
            $("#btn-continue").click(function () {
                $(this).prop('disabled', true);
                $("#form_term_conditions").submit();
            });
            $("#access_license_text").val(object_json_javascript.access_license_text || "");

            {if $dataObject->access_license_text != ''}
                $("#btn-print").on("click", function () {
                    var termConditionTitle = $("#term-condition-title").text();
                    var termConditionContent = $("#content-print").html();
                    var popupContent = '';
                    //popupContent += '<img src="'+$('#image_print_1').attr('src')+'">';
                    popupContent += '<h2>' + termConditionTitle + '</h2>';
                    popupContent += '<div>' + termConditionContent + '</div>';
                    var printWindow = window.open('', '', 'height=800,width=1000,scrollbars=yes,resizable');
                    printWindow.document.write('<html><head><title>' + termConditionTitle + '</title>');
                    printWindow.document.write('</head><body style="text-align: left;">');
                    printWindow.document.write(popupContent);
                    printWindow.document.write('</body></html>');
                    printWindow.document.close();
                    printWindow.print();
                });
                $("#agree-term-and-usage").change(function () {
                    if ($(this).prop('checked')) {
                        $('#btn-continue').removeAttr('disabled').addClass('button-primary').removeClass('button-secondary');
                    } else {
                        $('#btn-continue').attr('disabled', 'disabled').addClass('button-secondary').removeClass('button-primary');
                    }
                });
            {/if}
        });
    })(jQuery);
</script>