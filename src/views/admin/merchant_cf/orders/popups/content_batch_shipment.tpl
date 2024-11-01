<!-- Modal Header -->
<div class="modal-header">
    <h4 class="modal-title">{$dataObject->lang["Process Shipment"]}</h4>
    <button type="button" class="close" data-dismiss="modal">&times;</button>
</div>

<!-- Modal body -->
<div class="modal-body">
    <form method="post" class="col-sm-offset-1" id="form-create-batch" action="">
        <div class="form-group row">
            <label class="col-2" id="account-label"><b>{$dataObject->lang["account_number"]}</b></label>
            <div class="col-10" id="account-select-list">
                <select class="create-account col-12" name="createAccount">
                    {foreach $dataObject->list_account as $item}
                        <option value="{$item->account_id}">{stripslashes($item->address_type|escape:'htmlall':'UTF-8')} (#{stripslashes($item->ups_account_number|escape:'htmlall':'UTF-8')})</option>
                    {/foreach}
                </select>
            </div>
        </div>
    
        <div class="form-group row">
            <label class="col-12"><b>{$dataObject->lang["Orders to be processed"]}:</b></label>
            <div class="col-12">
                <div name="listOrders" id="list-order-detail"></div>
            </div>
        </div>
    </form>

    <!-- Modal footer -->
    <div class="modal-footer">
        <button type="button" class="button button-primary" id="btn-create-batch">{$dataObject->lang["Create Shipment"]}</button>
    </div>
</div>
<style type="text/css">
    #list-order-detail {
        border: 1px solid #ddd;
        height: 345px;
        overflow-y: scroll;
    }

    #account-label {
        padding-right: 0px;
    }
</style>