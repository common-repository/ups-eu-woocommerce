<div class="row mb-2 mb-4 mb-lg-3" id="fallback_rate_#_$@ID_FALLBACK_RATE@$#">
    <div class="col-lg-7 form-inline  mb-3 mb-lg-0 pr-0">
        <div class="row w-100">
            <div class="col-12 col-lg-auto pl-0 pr-0">
                <label class="d-none d-md-block col-12" style="height: 3px;">&nbsp;</label>
                {*
                <label class="pr-0 pb-1 mb-0 d-no">
                    <span class="w-100 pl-4 pl-lg-0 text-left text-lg-right ">
                        <i onclick="fallbackRate.addRow();" class="fa fa-plus-circle mr-2"></i>
                    </span>
                </label>
                *}
            </div>
            <div class="col w-100 pl-5 pl-lg-0 pr-0">
                <div>
                    <select name="fallback_rate[#_$@ID_FALLBACK_RATE@$#][service_id]" class="w-100 w-lg-50" onchange="fallbackRate.removeFormValidate('#_$@ID_FALLBACK_RATE@$#', 'service_id');">
                        {foreach $list_data_service as $itemService}
                            <option value="{$itemService->id}">{$lang[$itemService->service_key]}</option>
                        {/foreach}
                    </select>
                </div>
            </div> 
        </div>                                                        
    </div>
    <div class="col-lg-5 form-inline pr-0">
        <div class="row w-100  align-items-center">   
            <div class="col pl-5 pl-lg-0 pr-0">                
                <div>
                    <input name="fallback_rate[#_$@ID_FALLBACK_RATE@$#][fallback_rate]" value="0" type="text" autocomplete="off" onclick="fallbackRate.removeFormValidate('#_$@ID_FALLBACK_RATE@$#', 'fallback_rate');" />
                </div>
            </div> 
            <div class="col-sm-12 col-lg-auto pl-lg-0">
                <label class="d-none d-md-block col-12  pl-2 pr-2" style="height: 10px;">&nbsp;</label>                                                                 
                <label class="pr-0 pb-1  mt-1 mt-md-0">                
                    <span class="w-100 pl-4 pl-lg-0 text-left text-lg-right ">                         
                        <i onclick="fallbackRate.removeRow('fallback_rate_#_$@ID_FALLBACK_RATE@$#');" class = "fa fa-minus-circle text-danger ml-lg-2"> </i>
                    </span>               
                </label>
            </div>
        </div>
    </div>
    <input type="hidden" name="fallback_rate[#_$@ID_FALLBACK_RATE@$#][id]" value="#_$@ID_FALLBACK_RATE@$#"/>
</div>