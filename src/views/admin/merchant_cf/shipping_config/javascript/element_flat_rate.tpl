<div class="row mb-2 mb-4 mb-lg-3" id="id_delivery_#_$@ID_DELIVERY_RATE@$#"> 
    <div class="col-lg-3 form-inline  mb-3 mb-lg-0 pr-0">  
        <div class="row w-100">
            <div class="col-12 col-lg-auto pl-0 pr-0">                
                <label class="d-none d-md-block col-12" style="height: 3px;">&nbsp;</label>   
                <label class="pr-0 pb-1 mb-0">
                    <span class="w-100 pl-4 pl-lg-0 text-left text-lg-right ">
                        <i onclick="deliveryRate.addFlatRate('$@ID_SERVICE@$');" class="fa fa-plus-circle mr-2"></i>
                    </span>
                </label>
            </div>
            <div class="col w-100 pl-5 pl-lg-0 pr-0">               
                <div>         
                    <select class="w-100" name="delivery_rate_flat[$@ID_SERVICE@$][#_$@ID_DELIVERY_RATE@$#][rate_country]" autocomplete="off">
                        <option value="all">All Country</option>
                        {foreach $country_list as $key=>$value}
                        <option value={$key}>{$value}</option> 
                        {/foreach}
                    </select>
                </div>
            </div> 
        </div>                                                        
    </div>
    <div class="col-lg-2 form-inline pr-0"> 
        <div class="row w-100  align-items-center">   
            <div class="col pl-5 pl-lg-0 pr-0">                
                <div>
                    <select name="delivery_rate_flat[$@ID_SERVICE@$][#_$@ID_DELIVERY_RATE@$#][rate_rule]"  autocomplete="off" >
                        <option value="ov">Order Value</option>
                        <option value="wb">Weight Based</option>
                    </select>
                </div>
            </div> 
        </div>
    </div>
    <div class="col-lg-3 form-inline pr-0"> 
        <div class="row w-100  align-items-center">   
            <div class="col pl-5 pl-lg-0 pr-0">                
                <div>
                     <input  name="delivery_rate_flat[$@ID_SERVICE@$][#_$@ID_DELIVERY_RATE@$#][min_order_value]" value="0" type="text" autocomplete="off"/>
                </div>
            </div> 
        </div>
    </div>
    <div class="col-lg-3 form-inline pr-0"> 
        <div class="row w-100  align-items-center">   
            <div class="col pl-5 pl-lg-0 pr-0">                
                <div>
                    <input name="delivery_rate_flat[$@ID_SERVICE@$][#_$@ID_DELIVERY_RATE@$#][delivery_rate]" value="0" type="text" autocomplete="off" />
                </div>
            </div> 
            <div class="col-sm-12 col-lg-auto pl-lg-0">
                <label class="d-none d-md-block col-12  pl-2 pr-2" style="height: 10px;">&nbsp;</label>                                                                 
                <label class="pr-0 pb-1  mt-1 mt-md-0">                
                    <span class="w-100 pl-4 pl-lg-0 text-left text-lg-right ">                         
                        <i onclick="deliveryRate.removeFlatRate('id_delivery_#_$@ID_DELIVERY_RATE@$#');" class = "fa fa-minus-circle text-danger ml-lg-2"> </i>                    
                    </span>               
                </label>
            </div>
        </div>
    </div>    
    <input type="hidden" name="delivery_rate_flat[$@ID_SERVICE@$][#_$@ID_DELIVERY_RATE@$#][rate_type]" value="1"/>
    <input type="hidden" name="delivery_rate_flat[$@ID_SERVICE@$][#_$@ID_DELIVERY_RATE@$#][service_id]" value="$@ID_SERVICE@$"/>
    <input type="hidden" name="delivery_rate_flat[$@ID_SERVICE@$][#_$@ID_DELIVERY_RATE@$#][id]" value="#_$@ID_DELIVERY_RATE@$#"/>
</div>