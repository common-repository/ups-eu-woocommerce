<div class="card select-country-form">
    <h6 class="card-header">{$dataObject->lang["CountrySetting"]}</h6>
    <div class="card-body">
        <form method="POST" id="form_country" action="{$dataObject->action_form}">
            <label  class="card-title w-100 text-center">{$dataObject->lang["PleaseSelectYourCountry"]}</label>
            <div class="form-group text-center">                              
                <select tabindex="0" id="select-country" name="country-code">
                    {foreach from=$dataObject->country_list key=k item=v}
                        <option value="{$k}">{$v["name"]}</option>
                    {/foreach}
                </select>
            </div>
            <div class="text-center">
                <button tabindex="1" id="btn_continue" type="submit" class="button button-primary">{$dataObject->lang["btn_continue"]}</button>
            </div>
        </form>
    </div>
    <div class="card-footer text-muted">    
    </div>
</div>
<style type="text/css">  
    .select-country-form{
        margin-top: 10%;
    }
</style>
<script type="text/javascript">
    (function ($) {
        'use strict';
        $(document).ready(function () {
            $("#btn_continue").click(function () {
                $(this).prop('disabled', true);
                $("#form_country").submit();
            });
        });
    })(jQuery);
</script>