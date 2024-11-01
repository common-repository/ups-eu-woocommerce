{include file='admin/merchant_cf/common/inline_js_css/all_css.tpl'}
{include file='admin/merchant_cf/common/inline_js_css/all_js.tpl'}
<div class="container-fluid ups-shipping-container">
	<div class="pl-0 mb-2">
        <div class="ups-header-title">
            <a class="img-logo">
                <img src="{$img_url}UPS_logo.svg" class="rounded d-inline" alt="ups shipping"/>
            </a>
            {if (isset($dataObject->title)) }
                <h1 class="ups-header align-middle d-inline">{$dataObject->lang[$dataObject->title]}</h1>
            {else}
                <h1 class="ups-header align-middle d-inline">{$dataObject->lang["UpsShippingModule"]}</h1>
            {/if}
        </div>
    </div>
	 
    
    {include file='admin/merchant_cf/common/alert_modal.tpl'}
    {include file='admin/merchant_cf/common/message_modal.tpl'}
    {include file='admin/merchant_cf/common/confirm_modal.tpl'}