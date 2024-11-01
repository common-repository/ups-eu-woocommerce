<div id="error-notice"></div>
<div id="warning-notice"></div>
<div id="error-dimension"></div>
<div class="card-body" id="container_focus_show">
    <div class="ups-config-package-area">
        <div class="form-group">
            <small class="form-text form-group">
                {$dataObject->lang['PlsEnterPackage']}
            </small>
            <div class="xl-fix-success-account" id="package_setting_option1">
                <div class="col-12">
                    <div class="form-group form-checkbox mb-0">
                        <label for="have-account">
                            <input type="radio" value="1" id="have-account" name="configs[PACKAGE_SETTING_OPTION]" {if intval($dataObject->configs->PACKAGE_SETTING_OPTION) == 1}checked="true"{/if}>
                            <strong>{$dataObject->lang["PackageSettingOption1"]}</strong>
                        </label>
                    </div>
                    <div class="form-group form-content {if intval($dataObject->configs->PACKAGE_SETTING_OPTION) != 1}d-none{/if}">
                        <div class="form-group row">
                            <small class="form-text pls-message-default-package">
                                {$dataObject->lang["PlsMessageDefaultPackage"]}
                            </small>
                            <small class="form-text form-group pls-note-default-package">
                                {$dataObject->lang["PlsNoteDefaultPackage"]}
                            </small>
                            <div class="default-package-form">
                                <div id="default_package">
                                    <div class="package-item form-group-package d-none mb-3">
                                        <div class="package-field-item">
                                            <input type="text" autocomplete="off" value="" name="package-item-add">
                                        </div>
                                        <div class="clearfix space-width"></div>
                                        <div class="package-field">
                                            <input type="text" autocomplete="off" value="0.00" class="package-length" name="length">
                                        </div>
                                        <div class="clearfix space-width"></div>
                                        <div class="package-field">
                                            <input type="text" autocomplete="off" value="0.00" class="package-width" name="width">
                                        </div>
                                        <div class="clearfix space-width"></div>
                                        <div class="package-field">
                                            <input type="text" autocomplete="off" value="0.00" class="package-height" name="height">
                                        </div>
                                        <div class="clearfix space-width"></div>
                                        <div class="package-field unit-dimension-field">
                                            <select class="col-sm-12" name="unit-dimension">
                                                {if ($dataObject->lang['countryCode'] == "US")}
                                                    {* <option value="inch">Inch</option> *}
                                                    <option value="cm">Cm</option>
                                                {else}
                                                    <option value="cm">Cm</option>
                                                    {* <option value="inch">Inch</option> *}
                                                {/if}
                                            </select>
                                        </div>
                                        <div class="clearfix space-width"></div>
                                        <div class="package-field weight-field">
                                            <input type="text" autocomplete="off" value="0.00" class="package-weight" name="weight">
                                        </div>
                                        <div class="clearfix space-width"></div>
                                        <div class="package-field weight-option">
                                            <select class="col-sm-12" name="unit-weight">
                                                {if ($dataObject->lang['countryCode'] == "US")}
                                                    {* <option value="lbs">Pounds</option> *}
                                                    <option value="kgs">Kg</option>
                                                {else}
                                                    <option value="kgs">Kg</option>
                                                    {* <option value="lbs">Pounds</option> *}
                                                {/if}
                                            </select>
                                        </div>
                                        <div class="clearfix space-width"></div>
                                        <div class="remove-package-layout hidden" style="margin-top: 6px;">
                                            <span class="remove-default-package">
                                                <i class="fa fa-minus-circle text-danger ml-lg-2"> </i>
                                            </span>
                                        </div>
                                    </div>
                                    {$json_data = []}
                                    {foreach $dataObject->packages as $key=>$itemPackage}
                                        <div class="package-item form-group-package remove-row-package mb-3">
                                            <div class="package-field-item">
                                                <label class="w-100 text-center{if (0 != $key)} d-none{/if}">
                                                    <small>{$dataObject->lang["NumberItemsOrder"]}</small>
                                                    <o class="red-color">*</o>
                                                </label>
                                                <input type="text" autocomplete="off" value="{$itemPackage->package_item}" name="package-item-add">
                                            </div>
                                            <div class="clearfix space-width"></div>
                                            <div class="package-field">
                                                <label class="w-100 text-center{if (0 != $key)} d-none{/if}">
                                                    <small>{$dataObject->lang["Length"]}</small>
                                                    <o class="red-color">*</o>
                                                </label>
                                                <input type="text" autocomplete="off" value="{$itemPackage->length|string_format:"%.2f"}" class="package-length" name="length">
                                            </div>
                                            <div class="clearfix space-width"></div>
                                            <div class="package-field">
                                                <label class="w-100 text-center{if (0 != $key)} d-none{/if}">
                                                    <small>{$dataObject->lang["Width"]}</small>
                                                    <o class="red-color">*</o>
                                                </label>
                                                <input type="text" autocomplete="off" value="{$itemPackage->width|string_format:"%.2f"}" class="package-width" name="width">
                                            </div>
                                            <div class="clearfix space-width"></div>
                                            <div class="package-field">
                                                <label class="w-100 text-center{if (0 != $key)} d-none{/if}">
                                                    <small>{$dataObject->lang["Height"]}</small>
                                                    <o class="red-color">*</o>
                                                </label>
                                                <input type="text" autocomplete="off" value="{$itemPackage->height|string_format:"%.2f"}" class="package-height" name="height">
                                            </div>
                                            <div class="clearfix space-width"></div>
                                            <div class="package-field unit-dimension-field">
                                                <label class="w-100 text-center{if (0 != $key)} d-none{/if}">
                                                    <small></small>
                                                    <o  class="red-color"><br /></o>
                                                </label>
                                                <select class="col-sm-12" name="unit-dimension">
                                                    {if ($dataObject->lang['countryCode'] == "US")}
                                                        {* <option value="inch" {if ($itemPackage->unit_dimension == 'inch')}selected{/if}>Inch</option> *}
                                                        <option value="cm" {if ($itemPackage->unit_dimension == 'cm')}selected{/if}>Cm</option>
                                                    {else}
                                                        <option value="cm" {if ($itemPackage->unit_dimension == 'cm')}selected{/if}>Cm</option>
                                                        {* <option value="inch" {if ($itemPackage->unit_dimension == 'inch')}selected{/if}>Inch</option> *}
                                                    {/if}
                                                </select>
                                            </div>
                                            <div class="clearfix space-width"></div>
                                            <div class="package-field weight-field">
                                                <label class="w-100 text-center{if (0 != $key)} d-none{/if}">
                                                    <small>{$dataObject->lang["Weight"]}</small>
                                                    <o class="red-color">*</o>
                                                </label>
                                                <input type="text" autocomplete="off" value="{$itemPackage->weight|string_format:"%.2f"}" class="package-weight" name="weight">
                                            </div>
                                            <div class="clearfix space-width"></div>
                                            <div class="package-field weight-option">
                                                <label class="w-100 text-center{if (0 != $key)} d-none{/if}">
                                                    <small></small>
                                                    <o  class="red-color"><br /></o>
                                                </label>
                                                <select class="col-sm-12" name="unit-weight">
                                                    {if ($dataObject->lang['countryCode'] == "US")}
                                                        {* <option value="lbs" {if ($itemPackage->unit_weight == 'lbs')}selected{/if}>Pounds</option> *}
                                                        <option value="kgs" {if ($itemPackage->unit_weight == 'kgs')}selected{/if}>Kg</option>
                                                    {else}
                                                        <option value="kgs" {if ($itemPackage->unit_weight == 'kgs')}selected{/if}>Kg</option>
                                                        {* <option value="lbs" {if ($itemPackage->unit_weight == 'lbs')}selected{/if}>Pounds</option> *}
                                                    {/if}
                                                </select>
                                            </div>
                                            <div class="clearfix space-width"></div>
                                            <div class="remove-package-layout{if (0 == $key)} d-none{/if}" style="margin-top: 6px;">
                                                <span class="remove-default-package">
                                                    <i class="fa fa-minus-circle text-danger ml-lg-2"> </i>
                                                </span>
                                            </div>
                                        </div>
                                    {/foreach}
                                </div>
                                <div class="form-group-package">
                                <span class="w-100 text-left" id="btn_add_package">
                                    <i class="fa fa-plus-circle mr-2"></i>
                                    <a href="javascript:;" >{$dataObject->lang["AddNewPackage"]}</a>
                                </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="xl-fix-success-account mt-2" id="package_setting_option2">
                <div class="col-12">
                    <div class="form-group form-checkbox">
                        <label for="have-account-without-invoice">
                            <input type="radio" value="2" id="have-account-without-invoice" name="configs[PACKAGE_SETTING_OPTION]" {if intval($dataObject->configs->PACKAGE_SETTING_OPTION) == 2}checked="true"{/if}>
                            <strong>{$dataObject->lang["PackageSettingOption2"]}</strong>
                        </label>
                        {* <small class="form-text pls-warning-rate-package {if intval($dataObject->configs->PACKAGE_SETTING_OPTION) != 2}d-none{/if}">
                            {$dataObject->lang["PackageSettingOption2Note"]}.
                        </small> *}
                    </div>
                    <div class="form-group form-content {if intval($dataObject->configs->PACKAGE_SETTING_OPTION) != 2}d-none{/if}">
                        <div class="col-sm-12 left">
                            <div class="form-group row">
                                <label class="children-width-1 col-sm-5 left-fix col-lg-3 strong text-sm-right label-fix" for="include_dimensions">{$dataObject->lang["currency"]}</label>
                                <div class="col-2 col-lg-1">
                                    <input tabindex="0" type="text" disabled="disabled" value="{stripslashes($dataObject->get_woocommerce_currency|escape:'htmlall':'UTF-8')}"/>
                                </div>
                            </div>
                            {* <div class="form-group row">
                                <label class="children-width-1 col-sm-5 left-fix col-lg-3 strong text-sm-right label-fix" for="include_dimensions">{$dataObject->lang["IncludeDimensionsSetting"]}</label>
                                <div class="col-12 col-lg-7">
                                    <label class="switch">
                                        <input name="configs[ITEM_LEVEL_RATING_INCLUDE_DIMENSIONS]" type="checkbox" id="include_dimensions"{if intval($dataObject->configs->ITEM_LEVEL_RATING_INCLUDE_DIMENSIONS) == 1} checked="true"{/if} >
                                        <span class="slider round"></span>
                                    </label>
                                    <label id="label_include_dimensions" class="h6 font-weight-normal">
                                        {if intval($dataObject->configs->ITEM_LEVEL_RATING_INCLUDE_DIMENSIONS) == 1}
                                            {$dataObject->lang["Yes"]}
                                        {else}
                                            {$dataObject->lang["No"]}
                                        {/if}
                                    </label>
                                    <small class="form-text text-muted font-italic mt-0">
                                        {$dataObject->lang["IncludeDimensionsSettingNote"]}
                                    </small>
                                </div>
                            </div> *}
                            <div class="form-group row">
                                <label class="children-width-1 col-sm-5 left-fix col-lg-3 strong text-sm-right label-fix" for="choose_pack_algo">{$dataObject->lang["choosePack"]}</label>
                                <div class="col-2 col-lg-1">
                                    <select name="choose_pack_algo" id="choose_pack_algo">
                                        <option value="3" {if $dataObject->UPS_PACK_ALGO == 3}selected{/if}>Box based packing</option>
                                        <option value="2" {if $dataObject->UPS_PACK_ALGO == 2}selected{/if}>Weight based packing</option>
                                        <option value="1" {if $dataObject->UPS_PACK_ALGO == 1}selected{/if}>Individual packing</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row {if $dataObject->UPS_PACK_ALGO == 3}d-none{/if}" id="pack_weg_sec">
                                <label class="children-width-1 col-sm-5 left-fix col-lg-3 strong text-sm-right label-fix" for="choose_pack_weg_unit">{$dataObject->lang["wegUnitPack"]}</label>
                                <div class="col-2 col-lg-1">
                                    <select name="choose_pack_weg_unit" id="choose_pack_weg_unit">
                                        {if ($dataObject->lang['countryCode'] == "US")}
                                            {* <option value="lbs" {if $dataObject->UPS_PACK_WEG_UNIT == "lbs"}selected{/if}>Pounds</option> *}
                                            <option value="kgs" {if $dataObject->UPS_PACK_WEG_UNIT == "kgs"}selected{/if}>Kg</option>
                                        {else}
                                            <option value="kgs" {if $dataObject->UPS_PACK_WEG_UNIT == "kgs"}selected{/if}>Kg</option>
                                            {* <option value="lbs" {if $dataObject->UPS_PACK_WEG_UNIT == "lbs"}selected{/if}>Pounds</option> *}
                                        {/if}
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row {if $dataObject->UPS_PACK_ALGO != 1}d-none{/if}" id="pack_dim_sec">
                                <label class="children-width-1 col-sm-5 left-fix col-lg-3 strong text-sm-right label-fix" for="choose_pack_dim_unit">{$dataObject->lang["dimUnitPack"]}</label>
                                <div class="col-2 col-lg-1">
                                    <select name="choose_pack_dim_unit" id="choose_pack_dim_unit">
                                        {if ($dataObject->lang['countryCode'] == "US")}
                                            {* <option value="inch" {if $dataObject->UPS_PACK_DIM_UNIT == "inch"}selected{/if}>Inch</option> *}
                                            <option value="cm" {if $dataObject->UPS_PACK_DIM_UNIT == "cm"}selected{/if}>Cm</option>
                                        {else}
                                            <option value="cm" {if $dataObject->UPS_PACK_DIM_UNIT == "cm"}selected{/if}>Cm</option>
                                            {* <option value="inch" {if $dataObject->UPS_PACK_DIM_UNIT == "inch"}selected{/if}>Inch</option> *}
                                        {/if}
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row {if $dataObject->UPS_PACK_ALGO != 2}d-none{/if}" id="weight_based_sec">
                                <label class="children-width-1 col-sm-5 left-fix col-lg-3 strong text-sm-right label-fix" for="max_weight_per_pack">{$dataObject->lang["maxWeightPack"]}</label>
                                <div class="col-2 col-lg-1">
                                    <input type="text" autocomplete="off" name="max_weight_per_pack" id="max_weight_per_pack" value="{$dataObject->UPS_PACK_MAX_WEIGHT|string_format:"%.2f"}">
                                </div>
                            </div>
                            <div class="form-group {if $dataObject->UPS_PACK_ALGO != 3}d-none{/if}" id="box_based_sec">
                                <div class="row">
                                    <label class="children-width-1 col-sm-5 left-fix col-lg-3 strong text-sm-right label-fix">{$dataObject->lang["PackageDimensionText"]}:</label>
                                </div>
                                <div class="row">
                                    <div class="col-2"></div>
                                    <div class="col-10">
                                        <div id="product_dimension">
                                            <div class="product-dimension-item form-group-package remove-product-dimension-row mb-3 d-none">
                                                <div class="package-field package-name-item">
                                                    <label class="w-100 text-center">
                                                        <small>{$dataObject->lang["Name"]}</small><o class="red-color">*</o>
                                                    </label>
                                                    <input type="text" autocomplete="off" value="" class="package-name" name="package-name">
                                                </div>
                                                <div class="clearfix space-width"></div>
                                                <div class="package-field">
                                                    <label class="w-100 text-center">
                                                        <small>{$dataObject->lang["Length"]}</small><o class="red-color">*</o>
                                                    </label>
                                                    <input type="text" autocomplete="off" value="0.00" class="package-length" name="length">
                                                </div>
                                                <div class="clearfix space-width"></div>
                                                <div class="package-field">
                                                    <label class="w-100 text-center">
                                                        <small>{$dataObject->lang["Width"]}</small><o class="red-color">*</o>
                                                    </label>
                                                    <input type="text" autocomplete="off" value="0.00" class="package-width" name="width">
                                                </div>
                                                <div class="clearfix space-width"></div>
                                                <div class="package-field">
                                                    <label class="w-100 text-center">
                                                        <small>{$dataObject->lang["Height"]}</small><o class="red-color">*</o>
                                                    </label>
                                                    <input type="text" autocomplete="off" value="0.00" class="package-height" name="height">
                                                </div>
                                                <div class="clearfix space-width"></div>
                                                <div class="package-field unit-dimension-field">
                                                    <label class="w-100 text-center">
                                                        <small></small><o class="red-color"><br></o>
                                                    </label>
                                                    <select class="col-sm-12" name="unit-dimension">
                                                        {if ($dataObject->lang['countryCode'] == "US")}
                                                            {* <option value="inch">Inch</option> *}
                                                            <option value="cm">Cm</option>
                                                        {else}
                                                            <option value="cm">Cm</option>
                                                            {* <option value="inch">Inch</option> *}
                                                        {/if}
                                                    </select>
                                                </div>
                                                <div class="clearfix space-width"></div>
                                                <div class="package-field max-weight-field">
                                                    <label class="w-100 text-center">
                                                        <small>{$dataObject->lang["MaxWeight"]}</small><o class="red-color">*</o>
                                                    </label>
                                                    <input type="text" autocomplete="off" value="0.00" class="package-weight" name="weight">
                                                </div>
                                                <div class="clearfix space-width"></div>
                                                <div class="package-field weight-option">
                                                    <label class="w-100 text-center">
                                                        <small></small><o class="red-color"><br></o>
                                                    </label>
                                                    <select class="col-sm-12" name="unit-weight">
                                                        {if ($dataObject->lang['countryCode'] == "US")}
                                                            {* <option value="lbs">Pounds</option> *}
                                                            <option value="kgs">Kg</option>
                                                        {else}
                                                            <option value="kgs">Kg</option>
                                                            {* <option value="lbs">Pounds</option> *}
                                                        {/if}
                                                    </select>
                                                </div>
                                                <div class="clearfix space-width"></div>
                                                <div class="remove-package-layout hidden" style="margin-top: 6px;">
                                                    <span class="remove-product-dimension">
                                                        <i class="fa fa-minus-circle text-danger ml-lg-2"> </i>
                                                    </span>
                                                </div>
                                            </div>
                                            {$firstRowFlg = true}
                                            {foreach $dataObject->list_data_product_dimension as $key=>$itemPackage}
                                                <div class="product-dimension-item form-group-package remove-product-dimension-row mb-3">
                                                    <div class="package-field package-name-item">
                                                        <label class="w-100 text-center{if $firstRowFlg != true} d-none{/if}">
                                                            <small>{$dataObject->lang["Name"]}</small><o class="red-color">*</o>
                                                        </label>
                                                        <input type="text" autocomplete="off" value="{$itemPackage->package_name}" class="package-name" name="package-name">
                                                    </div>
                                                    <div class="clearfix space-width"></div>
                                                    <div class="package-field">
                                                        <label class="w-100 text-center{if $firstRowFlg != true} d-none{/if}">
                                                            <small>{$dataObject->lang["Length"]}</small><o class="red-color">*</o>
                                                        </label>
                                                        <input type="text" autocomplete="off" value="{$itemPackage->length|string_format:"%.2f"}" class="package-length" name="length">
                                                    </div>
                                                    <div class="clearfix space-width"></div>
                                                    <div class="package-field">
                                                        <label class="w-100 text-center{if $firstRowFlg != true} d-none{/if}">
                                                            <small>{$dataObject->lang["Width"]}</small><o class="red-color">*</o>
                                                        </label>
                                                        <input type="text" autocomplete="off" value="{$itemPackage->width|string_format:"%.2f"}" class="package-width" name="width">
                                                    </div>
                                                    <div class="clearfix space-width"></div>
                                                    <div class="package-field">
                                                        <label class="w-100 text-center{if $firstRowFlg != true} d-none{/if}">
                                                            <small>{$dataObject->lang["Height"]}</small><o class="red-color">*</o>
                                                        </label>
                                                        <input type="text" autocomplete="off" value="{$itemPackage->height|string_format:"%.2f"}" class="package-height" name="height">
                                                    </div>
                                                    <div class="clearfix space-width"></div>
                                                    <div class="package-field unit-dimension-field">
                                                        <label class="w-100 text-center{if $firstRowFlg != true} d-none{/if}">
                                                            <small></small><o class="red-color"><br></o>
                                                        </label>
                                                        <select class="col-sm-12" name="unit-dimension">
                                                            {if ($dataObject->lang['countryCode'] == "US")}
                                                                {* <option value="inch" {if ($itemPackage->unit_dimension == 'inch')}selected{/if}>Inch</option> *}
                                                                <option value="cm" {if ($itemPackage->unit_dimension == 'cm')}selected{/if}>Cm</option>
                                                            {else}
                                                                <option value="cm" {if ($itemPackage->unit_dimension == 'cm')}selected{/if}>Cm</option>
                                                                {* <option value="inch" {if ($itemPackage->unit_dimension == 'inch')}selected{/if}>Inch</option> *}
                                                            {/if}
                                                        </select>
                                                    </div>
                                                    <div class="clearfix space-width"></div>
                                                    <div class="package-field max-weight-field">
                                                        <label class="w-100 text-center{if $firstRowFlg != true} d-none{/if}">
                                                            <small>{$dataObject->lang["MaxWeight"]}</small><o class="red-color">*</o>
                                                        </label>
                                                        <input type="text" autocomplete="off" value="{$itemPackage->weight|string_format:"%.2f"}" class="package-weight" name="weight">
                                                    </div>
                                                    <div class="clearfix space-width"></div>
                                                    <div class="package-field weight-option">
                                                        <label class="w-100 text-center{if $firstRowFlg != true} d-none{/if}">
                                                            <small></small><o class="red-color"><br></o>
                                                        </label>
                                                        <select class="col-sm-12" name="unit-weight">
                                                            {if ($dataObject->lang['countryCode'] == "US")}
                                                                {* <option value="lbs" {if ($itemPackage->unit_weight == 'lbs')}selected{/if}>Pounds</option> *}
                                                                <option value="kgs" {if ($itemPackage->unit_weight == 'kgs')}selected{/if}>Kg</option>
                                                            {else}
                                                                <option value="kgs" {if ($itemPackage->unit_weight == 'kgs')}selected{/if}>Kg</option>
                                                                {* <option value="lbs" {if ($itemPackage->unit_weight == 'lbs')}selected{/if}>Pounds</option> *}
                                                            {/if}
                                                        </select>
                                                    </div>
                                                    <div class="clearfix space-width"></div>
                                                    <div class="remove-package-layout{if $firstRowFlg == true} d-none{/if}" style="margin-top: 6px;">
                                                    <span class="remove-product-dimension">
                                                        <i class="fa fa-minus-circle text-danger ml-lg-2"> </i>
                                                    </span>
                                                    </div>
                                                </div>
                                                {$firstRowFlg = false}
                                            {/foreach}
                                        </div>
                                        <div class="row form-inline form-group-package">
                                            <div class="row w-100" id="btn_add_product_dimension">
                                                <div class="col-12 col-lg-auto pl-0 pr-0">
                                                    <label class="d-none d-md-block col-12" style="height: 3px;">&nbsp;</label>
                                                    <label class="pr-0 pb-1 mb-0">
                                                                <span class="w-100 pl-4 pl-lg-0 text-left text-lg-right ">
                                                                    <i class="fa fa-plus-circle mr-2"></i>
                                                                </span>
                                                    </label>
                                                </div>
                                                <label class="label-color">{$dataObject->lang["AddNewPackage2"]}</label>
                                            </div>
                                        </div>
                                        {* <div class="row form-inline form-group-package">
                                            <small class="form-text text-muted font-italic mt-0">
                                                {$dataObject->lang["AddNewPackageNote"]}
                                            </small>
                                        </div> *}
                                    </div>
                                </div>
                            </div>
                            {if intval($dataObject->configs->DELIVERY_TO_SHIPPING_ADDRESS) == 1}
                                <div class="form-group">
                                    <div class="row">
                                        <label class="children-width-1 col-sm-5 left-fix col-lg-3 strong text-sm-right label-fix">{$dataObject->lang["FallbackRate"]}:</label>
                                        <div class="col-lg-7 col-xl-6 pl-0  pr-3">
                                            <div id="fallback_rate" style="display: block; margin-top: 15px;">
                                                <div class="row mb-3 backup-rate-item d-none">
                                                    <div class="col-lg-7 form-inline  pr-0">
                                                        <div class="row w-100 align-items-center">
                                                            <div class="col-12 col-lg-auto pl-0 pr-0 mark-add">
                                                                <label class="d-none d-md-block col-12" style="height: 3px;">&nbsp;</label>
                                                            </div>
                                                            <div class="col w-100 align-items-center pl-5 pl-lg-0 pr-0">
                                                                <div class="w-100 pl-0 header-label mb-3">
                                                                    <label class="w-100 text-center"><small>{$dataObject->lang["ServiceName"]}</small>
                                                                    </label>
                                                                </div>
                                                                <div>
                                                                    <select name="service_id" class="w-100 w-lg-50">
                                                                        {foreach $dataObject->list_data_service as $itemService}
                                                                            <option {if $itemFallbackRate->service_id == $itemService->id}selected{/if} value="{$itemService->id}">{$dataObject->lang[$itemService->service_key]}</option>
                                                                        {/foreach}
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-5 form-inline pr-0">
                                                        <div class="row w-100  align-items-center">
                                                            <div class="col pl-5 pl-lg-0 pr-0">
                                                                <div class="w-100 pl-0 header-label mb-3">
                                                                    <label class="w-100 text-center"><small>{$dataObject->lang["PackageRate"]}</small></label>
                                                                </div>
                                                                <div>
                                                                    <input name="fallback_rate" value="0.00" type="text" autocomplete="off">
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12 col-lg-auto pl-lg-0">
                                                                <label class="d-none d-md-block col-12  pr-2" style="height: 10px;">&nbsp;</label>
                                                                <label class="btn-remove-backup-rate pr-0 pb-1  mt-1 mt-md-0 d-none">
                                                                        <span class="w-100 pl-4 pl-lg-0 text-left text-lg-right ">
                                                                            <i class="fa fa-minus-circle text-danger ml-lg-2"> </i>
                                                                        </span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" name="fallback_rate_id" value="">
                                                </div>
                                                {$firstRowFlg = true}
                                                {foreach $dataObject->list_data_fallback_rate as $itemFallbackRate}
                                                    <div class="row mb-3 backup-rate-item">
                                                        <div class="col-lg-7 form-inline {if $firstRowFlg != true}mb-3 mb-lg-0{/if} pr-0">
                                                            <div class="row w-100 align-items-center">
                                                                <div class="col-12 col-lg-auto pl-0 pr-0 mark-add">
                                                                    <label class="d-none d-md-block col-12" style="height: 3px;">&nbsp;</label>
                                                                </div>
                                                                <div class="col w-100 align-items-center pl-5 pl-lg-0 pr-0">
                                                                    {if $firstRowFlg == true}
                                                                        <div class="w-100 pl-0 header-label mb-3">
                                                                            <label class="w-100 text-center"><small>{$dataObject->lang["ServiceName"]}</small>
                                                                            </label>
                                                                        </div>
                                                                    {/if}
                                                                    <div>
                                                                        <select name="service_id" class="w-100 w-lg-50">
                                                                            {foreach $dataObject->list_data_service as $itemService}
                                                                                <option {if $itemFallbackRate->service_id == $itemService->id}selected{/if} value="{$itemService->id}">{$dataObject->lang[$itemService->service_key]}</option>
                                                                            {/foreach}
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-5 form-inline pr-0">
                                                            <div class="row w-100  align-items-center">
                                                                <div class="col pl-5 pl-lg-0 pr-0">
                                                                    {if $firstRowFlg == true}
                                                                        <div class="w-100 pl-0 header-label mb-3">
                                                                            <label class="w-100 text-center"><small>{$dataObject->lang["PackageRate"]}</small></label>
                                                                        </div>
                                                                    {/if}
                                                                    <div>
                                                                        <input name="fallback_rate" value="{$itemFallbackRate->fallback_rate|string_format:"%.2f"}" type="text" autocomplete="off" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-12 col-lg-auto pl-lg-0">
                                                                    <label class="d-none d-md-block col-12  pr-2" style="height: 10px;">&nbsp;</label>
                                                                    <label class="btn-remove-backup-rate pr-0 pb-1  mt-1 mt-md-0 {if $firstRowFlg == true}d-none{/if}">
                                                                        <span class="w-100 pl-4 pl-lg-0 text-left text-lg-right ">
                                                                            <i class="fa fa-minus-circle text-danger ml-lg-2"> </i>
                                                                        </span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <input type="hidden" name="fallback_rate_id" value="{if isset($itemFallbackRate->id)}{$itemFallbackRate->id}{/if}"/>
                                                    </div>
                                                    {$firstRowFlg = false}
                                                {/foreach}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-5 col-lg-3"></div>
                                        <div class="col-12 col-lg-7">
                                            <div class="form-inline">
                                                <div class="row w-100" id="add-backup-rate">
                                                    <div class="col-12 col-lg-auto pl-0 pr-0">
                                                        <label class="d-none d-md-block col-12" style="height: 3px;">&nbsp;</label>
                                                        <label class="pr-0 pb-1 mb-0">
                                                                <span class="w-100 pl-4 pl-lg-0 text-left text-lg-right ">
                                                                    <i class="fa fa-plus-circle mr-2"></i>
                                                                </span>
                                                        </label>
                                                    </div>
                                                    <label class="label-color">{$dataObject->lang["AddFallbackRate"]}</label>
                                                </div>
                                            </div>
                                            <small class="form-text text-muted font-italic mt-0">
                                                {$dataObject->lang["AddFallbackRateNote"]}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            {/if}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <button type="button" value="{$dataObject->btn_save}" class="button button-primary btn-save">{$dataObject->lang["btn_save"]}</button>
                        <button type="button" value="{$dataObject->btn_next}" class="button button-primary pull-right btn-next">{$dataObject->lang["btn_next"]}</button>
                    </div>
                </div>
            </div>
            <input type="hidden" id="countryCode" value="{$dataObject->country_code}">
        </div>
        <form id="form_package_setting" enctype='application/json' method="POST" action="{$dataObject->action_form}">
            <input type="hidden" id="btn_controller" name="btn_controller" value="">
            <input type="hidden" name="package_setting_option" value="">
            <input type="hidden" name="include_dimension_setting" value="">
            <input type="hidden" name="package_dimension" value="">
            <input type="hidden" name="pack_algo" value="">
            <input type="hidden" name="max_pac_weig" value="">
            <input type="hidden" name="dim_unit" value="">
            <input type="hidden" name="weg_unit" value="">
            <input type="hidden" name="backup_rate" value="">
        </form>
    </div>
</div>
<div class="modal fade" id="ups-modal-alert" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ups-modal-alert-title">{$dataObject->lang["Warning"]}</h5>
        <button type="button" class="close" id="model_btn_close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="ups-modal-alert-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="button button-secondary btn-cancel" id="model_btn_cancel" data-dismiss="modal">{$dataObject->lang["btn_cancel"]}</button>
        <button type="button" class="button button-primary" id="modal_btn_ok" data-dismiss="modal">{$dataObject->lang["btn_ok"]}</button>
      </div>
    </div>
  </div>
</div>
<style type="text/css">
    #wpbody select,
    .ups-shipping-container input[type="text"],
    .ups-shipping-container input[type="number"]{
        height: 28px;
    }
    .ups-shipping-container input[type="number"] {
        width: 100%;
    }
    .form-group-package {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-wrap: wrap;
        flex-wrap: wrap;
        margin-right: 15px;
        margin-left: 15px;
    }
    .package-height {
         width: 15%;
    }
    .red-color {
        color: red;
    }
    .pls-message-default-package {
        padding-left: 45px;
    }
    .pls-warning-rate-package {
        padding-left: 25px;
        font-style: italic;
        color: #6c757d!important;
    }
    .pls-note-default-package {
        padding-left: 45px;
        font-style: italic;
        color: #6c757d!important;
    }
    .space-width {
        width: 1%;
    }
    .default-package-form {
        width: 100%;
        padding-left: 45px;
    }
    .mark-add {
        padding-top: 10px;
    }

    .label-color {
        color: #007bff;
    }

    .package-field {
        width: 10%;
    }
    .package-field-item {
        width: calc(30 * 0.45rem + 2px);
    }
    .package-name-item {
        width: calc(25 * 0.45rem + 2px);
    }

    @media  only screen and (max-width:768px) {
        #wpbody select,
        .ups-shipping-container input[type="text"],
        .ups-shipping-container input[type="number"]{
            margin-bottom: 5px;
        }
        .package-height {
            width: 15%;
        }
        .weight-field {
            width: 12%;
        }
        .max-weight-field {
            width: 16.5%;
        }
    }
    @media only screen and  (min-width:769px) and (max-width:1024px) {
        #wpbody select,
        .ups-shipping-container input[type="text"],
        .ups-shipping-container input[type="number"]{
            margin-bottom: 5px;
        }
        .package-height {
            width: 15%;
        }
        .weight-field {
            width: 12%;
        }
        .max-weight-field {
            width: 16.5%;
        }
    }
    @media only screen and (min-width:1025px) and (max-width:1280px) {
        #wpbody select,
        .ups-shipping-container input[type="text"],
        .ups-shipping-container input[type="number"]{
            margin-bottom: 5px;
        }
        .package-height {
            width: 15%;
        }
        .weight-field {
            width: 12%;
        }
        .max-weight-field {
            width: 16.5%;
        }
        .space-width {
            width: 2% !important;
        }
    }
    @media  only screen and (min-width:1281px) and (max-width:1366px) {
        #wpbody select,
        .ups-shipping-container input[type="text"],
        .ups-shipping-container input[type="number"]{
            margin-bottom: 5px;
        }
        .package-height {
            width: 15%;
        }
        .weight-field {
            width: 12%;
        }
        .max-weight-field {
            width: 16.5%;
        }

    }
    /* For 1366 Resolution */
    @media only screen and (min-width: 1367px) and (max-width: 1920px) {
        .package-height {
            width: 15%;
        }
        .package-weight {
            width: 18.5%;
        }
        .weight-field {
            width: 12%;
        }
        .max-weight-field {
            width: 16.5%;
        }
    }
    @media only screen and (min-width: 1921px) {
        .form-group-package {
            margin-left: 140px!important;
        }
    }
    i.fa{
        color: #00aff0;
        font-size: 15px;
    }
</style>

<script type="text/javascript">
    var package_dimension_list = [];
    var backup_rate_list = [];
    var error_check = true;
    var error_message = [];
    var warning_check = true;
    var warning_message = [];
    var package_check_class = '';
    var package_item_value = '';
    var pack_algo = '';
    var countryCode = "{$dataObject->country_code}";

    /** handling package warning and error > 70 */
    var errorWeightPackageMaximum       = "{$dataObject->lang["errorWeightPackageMaximum"]}";
    var errorUSWeightPackageMaximum     = "{$dataObject->lang["errorUSWeightPackageMaximum"]}";
    var errorDimension                  = "{$dataObject->lang["errorDimension"]}";
    var errorUSDimension                = "{$dataObject->lang["errorUSDimension"]}";
    var errorPlsInputAtLeastOne         = "{$dataObject->lang['PlsInputAtLeastOne']}";
    var warningWeightPackageMaximum     = "{$dataObject->lang["warningWeightPackageMaximum"]}";
    var warningUSWeightPackageMaximum   = "{$dataObject->lang["warningUSWeightPackageMaximum"]}";
    var warningDimensionLang            = "{$dataObject->lang["warningDimension"]}";
    var warningUSDimensionLang          = "{$dataObject->lang["warningUSDimension"]}";
    var warningUSLongestSide            = "{$dataObject->lang["warningUSLongestSide"]}";
    var errorUSLongestSide              = "{$dataObject->lang["errorUSLongestSide"]}";
    var errorCommonMassage              = "{$dataObject->lang["errorCommonMassage"]}";
    var errorDuplicateMassage           = "{$dataObject->lang["errorDuplicateMassage"]}";

    (function ($) {
        'use strict';
        $(document).ready(function () {
            $('#choose_pack_algo').change(function(){
                if ($(this).val() == "1") {
                    $('#pack_dim_sec').removeClass("d-none");
                    $('#pack_weg_sec').removeClass("d-none");
                    $('#weight_based_sec').addClass("d-none");
                    $('#box_based_sec').addClass("d-none");
                } else if ($(this).val() == "2") {
                    $('#weight_based_sec').removeClass("d-none");
                    $('#pack_weg_sec').removeClass("d-none");
                    $('#box_based_sec').addClass("d-none");
                    $('#pack_dim_sec').addClass("d-none");
                } else if ($(this).val() == "3") {
                    $('#weight_based_sec').addClass("d-none");
                    $('#box_based_sec').removeClass("d-none");
                    $('#pack_dim_sec').addClass("d-none");
                    $('#pack_weg_sec').addClass("d-none");
                }
            })

            // enable button SAVE on EDIT PACKAGE modal
            $(document).on('keypress keyup change paste ', '.modal form input, .modal form select', function () {
                $(this).parents('form').find('.button').removeClass('disabled');
            });

            var formEdit;
            var type_package = $("input[name='configs[PACKAGE_SETTING_OPTION]']:checked").val();
            var includeDimensionSetting = $("input[name='configs[ITEM_LEVEL_RATING_INCLUDE_DIMENSIONS]']").prop('checked') ? 1 : 0 ;
            var isShippingAddress = "{$dataObject->configs->DELIVERY_TO_SHIPPING_ADDRESS}";

            $("#include_dimensions").change(function () {
                if ($(this).prop('checked')) {
                    $("#label_include_dimensions").text('{$dataObject->lang["Yes"]}');
                    includeDimensionSetting = 1;
                } else {
                    $("#label_include_dimensions").text('{$dataObject->lang["No"]}');
                    includeDimensionSetting = 0;
                }
            });

            $('#package_setting_option1 .form-checkbox input[type="radio"]').change(function () {
                if ($(this).is(':checked')) {
                    $('#package_setting_option1 .form-content').removeClass("d-none");
                    $('#package_setting_option2 .form-content').addClass("d-none");
                    $('#package_setting_option2 .form-text').addClass("d-none");
                }
            });
            $('#package_setting_option2 .form-checkbox input[type="radio"]').change(function () {
                if ($(this).is(':checked')) {
                    $('#package_setting_option1 .form-content').addClass("d-none");
                    $('#package_setting_option2 .form-content').removeClass("d-none");
                    $('#package_setting_option2 .form-text').removeClass("d-none");
                }
            });

            $(document).on('click', '#fallback_rate input, #fallback_rate select, #product_dimension input, #default_package input, #max_weight_per_pack', function () {
                $(this).removeClass('formValidate warningValidate');
            });

            //action click to close notice error
            $(document).on('click', '.notice-dismiss', function () {
                $(this).parents('.notice-error').addClass('d-none');
            });

            $(document).on('click', "#btn_add_package", function () {
                var html = $(".package-item").html();
                var add_package_format = $('<div class="package-item form-group-package remove-row-package mb-3">' + html + '</div>');
                add_package_format.find('.remove-package-layout').removeClass('hidden');
                add_package_format.find('label').addClass('d-none');
                add_package_format.find(".formValidate").removeClass("formValidate");
                $("#default_package").append(add_package_format);
            });

            $(document).on('click', '.remove-default-package', function () {
                $(this).parents(".remove-row-package").remove();
            });

            $(document).on('click', "#btn_add_product_dimension", function () {
                var html = $(".product-dimension-item").html();
                var add_package_format = $('<div class="product-dimension-item form-group-package remove-product-dimension-row mb-3">' + html + '</div>');
                add_package_format.find('.remove-package-layout').removeClass('hidden');
                add_package_format.find('label').remove();
                add_package_format.find(".formValidate").removeClass("formValidate");
                $("#product_dimension").append(add_package_format);
            });

            $(document).on('click', '.remove-product-dimension', function () {
                $(this).parents(".remove-product-dimension-row").remove();
            });

            $(document).on('click', "#add-backup-rate", function () {
                var html = $(".backup-rate-item").html();
                var add_backup_rate_format = $('<div class="row mb-3 backup-rate-item">' + html + '</div>');
                add_backup_rate_format.find('.btn-remove-backup-rate').removeClass('d-none');
                add_backup_rate_format.find('.header-label').remove();
                add_backup_rate_format.find(".formValidate").removeClass("formValidate");
                $("#fallback_rate").append(add_backup_rate_format);
            });

            $(document).on('click', '.btn-remove-backup-rate', function () {
                $(this).parents(".backup-rate-item").remove();
            });

            $('#modal_btn_ok').click(function () {
                submitForm();
            });

            $('#model_btn_close, #model_btn_cancel').click(function () {
                $('#error-notice div').remove();
            });

            $("input[name='configs[PACKAGE_SETTING_OPTION]']").change(function(){
                type_package = $(this).val();
            });

            //action click button
            $(".btn-save, .btn-next").click(function () {
                $("#btn_controller").val($(this).val());
                submitPackageDimensionSetting();
            });

            function submitPackageDimensionSetting() {
                package_item_value = '';
                error_check = true;
                error_message = [];
                warning_check = true;
                warning_message = [];
                removeValidateClass();
                if (2 == type_package) {
                    pack_algo = $("#choose_pack_algo").val();
                    backup_rate_list = getBackupRateList();
                    if (pack_algo == 3) {
                        package_check_class = 'product-dimension-item';
                        package_dimension_list = getPackageDimensionList();
                        validatePackageDimension();
                        validateBackupRate();
                        if (error_check === true) {
                            $.ajax({
                                type: "POST",
                                url: '{$dataObject->links_form->url_ajax_json}&method=validate-product-dimension',
                                data: {
                                    'package_setting_option': type_package,
                                    'include_dimension_setting': includeDimensionSetting,
                                    'product_dimension': package_dimension_list,
                                    'fallback_rate': backup_rate_list
                                },
                                dataType: 'json',
                                success: function (data) {
                                    var check = true;
                                    $.each(data.product_dimension, function (rowIndex, val) {
                                        if (true != val) {
                                            $.each(val, function (key, rowItem) {
                                                addFormValidate(rowIndex, rowItem);
                                            })
                                            check = false;
                                        }
                                    });
                                    error_check = check;
                                    error_message = data.error_message;
                                    displayResult();
                                },
                                error: function (data) {
                                    error_check = false;
                                    error_message.errorPlsInputAtLeastOne = errorPlsInputAtLeastOne;
                                    displayResult();
                                }
                            });
                        } else {
                            displayResult();
                        }
                    } else if (pack_algo == 2){
                        var max_weight_val = $("#max_weight_per_pack").val();
                        var pack_weg_unit = $("#choose_pack_weg_unit").val();
                        error_check = checkErrorWeight(countryCode, max_weight_val, pack_weg_unit);
                        if (!error_check) {
                            $('#max_weight_per_pack').addClass('formValidate');
                        }
                        validateBackupRate();
                        if (error_check === true) {
                            //write values to hidden submit elements
                            $('#form_package_setting input[name="max_pac_weig"]').val(max_weight_val);
                            $('#form_package_setting input[name="weg_unit"]').val(pack_weg_unit);
                            displayResult();//trigger hidden form submit
                        } else {
                            displayResult();
                        }
                    } else if (pack_algo == 1){
                        validateBackupRate();
                        if (error_check === true) {
                            var pack_dim_unit = $("#choose_pack_dim_unit").val();
                            var pack_weg_unit = $("#choose_pack_weg_unit").val();
                            $('#form_package_setting input[name="dim_unit"]').val(pack_dim_unit);
                            $('#form_package_setting input[name="weg_unit"]').val(pack_weg_unit);
                            displayResult();
                        } else {
                            displayResult();
                        }
                    } else {
                        error_check = false;
                        error_message.errorCommon = errorCommonMassage;
                        displayResult();
                    }
                    
                } else {
                    package_check_class = 'package-item';
                    package_dimension_list = getPackageDimensionList();
                    validatePackageDimension();
                    if (error_check === true) {
                        $.ajax({
                            type: "POST",
                            url: '{$dataObject->links_form->url_ajax_json}&method=validate-default-package',
                            data: {
                                'list_id_package': package_dimension_list,
                                'type_package': type_package
                            },
                            dataType: 'json',
                            success: function (data)
                            {
                                if (data.length > 0) {
                                    $.each(data, function (key, val) {
                                        key = 1*key;
                                        if (true != val && val[0]) {
                                            addFormValidate(key, 'package-item-add');
                                            error_check = false;
                                            error_message.errorPackageItem = val[0].package_item.msg_error;
                                        }
                                    });
                                }
                                displayResult();
                            },
                            error: function (data)
                            {
                                error_check = false;
                                error_message.errorPlsInputAtLeastOne = errorPlsInputAtLeastOne;
                                displayResult();
                            }
                        });
                    } else {
                        displayResult();
                    }
                }
            }

            function displayResult() {
                if (error_check === true) {
                    if (warning_check === false) {
                        var message = Object.values(warning_message).join('</li><li>');
                        message = '<ul><li>' + message + '</li></ul>';
                        $('#ups-modal-alert-body').html(message);
                        $('#ups-modal-alert').modal('show');
                    } else {
                        submitForm();
                    }
                } else {
                    var message = Object.values(error_message).join('</li><li>');
                    showError(message);
                }
            }

            function submitForm() {
                $(this).prop('disabled', true);
                $('#form_package_setting input[name="package_setting_option"]').val(type_package);
                $('#form_package_setting input[name="include_dimension_setting"]').val(includeDimensionSetting);
                $('#form_package_setting input[name="pack_algo"]').val(pack_algo);
                $('#form_package_setting input[name="package_dimension"]').val(JSON.stringify(package_dimension_list));
                $('#form_package_setting input[name="backup_rate"]').val(JSON.stringify(backup_rate_list));
                $('#form_package_setting').submit();
            }

            function validatePackageDimension() {
                var listPackageName = [];
                $.each(package_dimension_list, function (index, item) {
                    // Check error item
                    var checkPackageItem = true;
                    var checkPackageName = true;
                    if (package_check_class === 'package-item') {
                        checkPackageItem = checkErrorPackageItem(item.package_item, index);
                    } else {
                        checkPackageName = checkErrorPackageName(item.package_name, index, listPackageName);
                        listPackageName.push(item.package_name);
                    }
                    var checkErrSide = checkErrorSide(countryCode, item.unit_dimension, item.length, item.width, item.height, index);
                    var checkErrWeight = checkErrorWeight(countryCode, item.weight, item.unit_weight, index);
                    var checkErrDimension = checkErrorDimension(countryCode, item.unit_dimension, item.length, item.width, item.height, index);
                    // Check warning
                    if (!checkPackageItem || !checkPackageName || !checkErrSide || !checkErrWeight || !checkErrDimension) {
                        error_check = false;
                    } else {
                        var chkWarningSide = checkWarningSide(countryCode, item.unit_dimension, item.length, item.width, item.height, index);
                        var chkWarningWeight = checkWarningWeight(countryCode, item.weight, item.unit_weight, index);
                        var chkWarningDimension = checkWarningDimension(countryCode, item.unit_dimension, item.length, item.width, item.height, index);
                        if (!chkWarningSide || !chkWarningWeight || !chkWarningDimension ) {
                            warning_check = false;
                        }
                    }
                });
            }

            function validateBackupRate() {
                var checkServiceId = true;
                var checkRate = true;
                var serviceIds = [];
                $.each(backup_rate_list, function (index, item) {
                    if (serviceIds.indexOf(item.service_id) > -1) {
                        checkServiceId = false;
                        addFormValidateFallbackRate(index, 'service_id');
                    }
                    serviceIds.push(item.service_id);
                    checkRate = checkFloatRange(item.fallback_rate, 0);
                    if (checkRate == false) {
                        addFormValidateFallbackRate(index, 'fallback_rate');
                    }
                });
                if (!checkServiceId || !checkRate) {
                    error_check = false;
                    error_message.errorCommon = errorCommonMassage;
                }
            }

            function checkErrorPackageItem(package_item, index) {
                var check = true;
                if (0 >= package_item || isNaN(package_item)) {
                    check = false;
                    error_message.errorCommon = errorCommonMassage;
                }
                if (package_item_value.indexOf(package_item) > -1) {
                    check = false
                    error_message.errorDuplicate = errorDuplicateMassage;
                } else {
                    package_item_value += ', ' + package_item;
                }
                if (check === false) {
                    addFormValidate(index, 'package-item-add');
                }
                return check;
            }

            function checkErrorPackageName(packageName, index, listPackageName) {
                var check = true;
                if (packageName === '') {
                    check = false;
                    error_message.errorCommon = errorCommonMassage;
                } else if (listPackageName.indexOf(packageName) > -1) {
                    check = false;
                    error_message.errorDuplicate = errorDuplicateMassage;
                }
                if (check === false) {
                    addFormValidate(index, 'package-name');
                }
                return check;
            }

            function checkWarningWeight(countryCode, weightPackage, unitWeight, index) {
                var maxWeightPackage = 0;
                var warningWeightPackage = 0;
                var check_warning = true;
                if (unitWeight == 'kgs') {
                    maxWeightPackage = 70;
                    warningWeightPackage = 20;
                } else {
                    maxWeightPackage = 154.324;
                    warningWeightPackage = 44.09;
                }
                if ('US' == countryCode) {
                    maxWeightPackage = 150;
                    warningWeightPackage = 44;
                }
                weightPackage = 1*parseFloat(weightPackage);
                if (weightPackage > warningWeightPackage && weightPackage <= maxWeightPackage) {
                    var warning_note = warningWeightPackageMaximum;
                    if ('US' == countryCode) {
                        warning_note = warningUSWeightPackageMaximum;
                    }
                    check_warning = false;
                    addWarningValidate(index, 'weight');
                    warning_message.warningWeightPackageMaximum = warning_note;
                }
                return check_warning;
            }

            function checkErrorWeight(countryCode, weightPackage, unitWeight, index="") {
                var maxWeightPackage = 0;
                var check = true;
                if (unitWeight == 'kgs') {
                    maxWeightPackage = 70;
                } else {
                    maxWeightPackage = 154.324;
                }
                if ('US' == countryCode) {
                    maxWeightPackage = 150;
                }
                if (0 >= weightPackage || isNaN(weightPackage)) {
                    check = false;
                    error_message.errorCommon = errorCommonMassage;
                }
                if (weightPackage > maxWeightPackage) {
                    var error_note = errorWeightPackageMaximum;
                    if ('US' == countryCode) {
                        error_note = errorUSWeightPackageMaximum;
                    }
                    check = false;
                    error_message.errorWeightPackageMaximum = error_note;
                }
                if (check === false && index != "") {
                    addFormValidate(index, 'weight');
                }
                return check;
            }

            function checkErrorDimension(countryCode, unitDimension, dimensionLength, dimensionWidth, dimensionHeight, index) {
                var maxDimension     = 0;
                var check = true;
                if (unitDimension == 'cm') {
                    maxDimension     = 400;
                } else {
                    maxDimension     = 157.48;
                    if ('US' == countryCode) {
                        maxDimension     = 165;
                    }
                }
                if (!checkFloatRange(dimensionLength, 0.01)) {
                    addFormValidate(index, 'length');
                    check = false;
                }
                if (!checkFloatRange(dimensionWidth, 0.01)) {
                    addFormValidate(index, 'width');
                    check = false;
                }
                if (!checkFloatRange(dimensionHeight, 0.01)) {
                    addFormValidate(index, 'height');
                    check = false;
                }
                if (check === true) {
                    var calculation = (1 * dimensionLength) + (2 * dimensionWidth) + (2 * dimensionHeight);
                    if (calculation > maxDimension) {
                        var error_note = errorDimension;
                        if ('US' == countryCode) {
                            error_note = errorUSDimension;
                        }
                        check = false;
                        error_message.errorDimension = error_note;
                        addFormValidate(index, 'dimension');
                    }
                } else {
                    error_message.errorCommon = errorCommonMassage;
                }
                return check;
            }

            function checkWarningDimension(countryCode, unitDimension, dimensionLength, dimensionWidth, dimensionHeight, index) {
                var maxDimension     = 0;
                var warningDimension = 0;
                var check = true;
                if (unitDimension == 'cm') {
                    maxDimension     = 400;
                    warningDimension = 330;
                } else {
                    maxDimension     = 157.48;
                    warningDimension = 129.92;
                }
                if ('US' == countryCode) {
                    maxDimension     = 165;
                    warningDimension = 130;
                }
                if (dimensionLength != "" && dimensionWidth != "" && dimensionHeight != "") {
                    var calculation = dimensionLength*1 + (2 * dimensionWidth) + (2 * dimensionHeight);
                    if (calculation > warningDimension && calculation <= maxDimension) {
                        var warning_note = warningDimensionLang;
                        if ('US' == countryCode) {
                            warning_note = warningUSDimensionLang;
                        }
                        check = false;
                        addWarningValidate(index, 'dimension');
                        warning_message.warningDimension = warning_note;
                    }
                }
                return check;
            }

            function checkErrorSide(countryCode, unitDimension, dimensionLength, dimensionWidth, dimensionHeight, index) {
                var maxDimension     = 108;
                var check = true;
                if ('US' == countryCode && 'inch' == unitDimension) {
                    if (dimensionLength != "" && dimensionWidth != "" && dimensionHeight != "") {
                        if (dimensionLength > maxDimension || dimensionWidth > maxDimension || dimensionHeight > maxDimension) {
                            check = false;
                            error_message.errorUSLongestSide = errorUSLongestSide;
                        }
                        if (dimensionLength > maxDimension) {
                            addFormValidate(index, 'side_length');
                        }
                        if (dimensionWidth > maxDimension) {
                            addFormValidate(index, 'side_width');
                        }
                        if (dimensionHeight > maxDimension) {
                            addFormValidate(index, 'side_height');
                        }
                    }
                }
                return check;
            }

            function checkWarningSide(countryCode, unitDimension, dimensionLength, dimensionWidth, dimensionHeight, index) {
                var maxDimension     = 108;
                var warningDimension = 38;
                var check = true;
                if ('US' == countryCode && 'inch' == unitDimension) {
                    if (dimensionLength != "" && dimensionWidth != "" && dimensionHeight != "") {
                        if (((dimensionLength > warningDimension && dimensionLength <= maxDimension)
                            || (dimensionWidth > warningDimension && dimensionWidth <= maxDimension)
                            || (dimensionHeight > warningDimension && dimensionHeight <= maxDimension))
                        ) {
                            check = false;
                            warning_message.warningUSLongestSide = warningUSLongestSide;
                        }

                        if (dimensionLength > warningDimension && dimensionLength <= maxDimension) {
                            addWarningValidate(index, 'side_length');
                        }
                        if (dimensionWidth > warningDimension && dimensionWidth <= maxDimension) {
                            addWarningValidate(index, 'side_width');
                        }
                        if (dimensionHeight > warningDimension && dimensionHeight <= maxDimension) {
                            addWarningValidate(index, 'side_height');
                        }
                    }
                }
                return check;
            }

            function checkFloatRange(chkValue, min) {
                if (isNaN (chkValue) || chkValue.trim() === '') {
                    return false;
                }
                var integerPartLength = 4;
                var fractionPartLength = 2;
                var maxValue = 9999.99;
                var separateIndex = chkValue.indexOf('.');
                if(separateIndex != -1) {
                    var integerPart = chkValue.substring(0, separateIndex);
                    var fractionPart = chkValue.substring(separateIndex + 1);
                    if(integerPart.length <= 0 || integerPart.length > integerPartLength) {
                        return false;
                    }
                    if(fractionPart.length > fractionPartLength) {
                        return false;
                    }
                }
                if(parseFloat(chkValue) < min || parseFloat(chkValue) > maxValue) {
                    return false;
                }
                return true;
            }

            function getPackageDimensionList() {
                var package_dimension_list = [];
                var package_custom = [];
                $('.' + package_check_class).each(function () {
                    if (!$(this).hasClass("d-none")) {
                        var weight = $(this).find('input[name="weight"]').val();
                        var unit_weight = $(this).find('select[name="unit-weight"]').val();
                        var length = $(this).find('input[name="length"]').val();
                        var width = $(this).find('input[name="width"]').val();
                        var height = $(this).find('input[name="height"]').val();
                        var unit_dimension = $(this).find('select[name="unit-dimension"]').val();
                        package_custom = {
                            'weight': weight,
                            'unit_weight': unit_weight,
                            'length': length,
                            'width': width,
                            'height': height,
                            'unit_dimension': unit_dimension
                        };
                        if (package_check_class === 'package-item') {
                            var package_item = $(this).find('input[name="package-item-add"]').val();
                            package_custom.package_item = package_item;
                        } else {
                            var package_name = $(this).find('input[name="package-name"]').val();
                            package_custom.package_name = package_name;
                        }
                        package_dimension_list.push(package_custom);
                    }
                });
                return package_dimension_list;
            }

            function getBackupRateList() {
                var backup_rate_list = [];
                $('.backup-rate-item').each(function () {
                    if (!$(this).hasClass("d-none")) {
                        var service_id = $(this).find('select[name="service_id"]').val();
                        var fallback_rate = $(this).find('input[name="fallback_rate"]').val();
                        var backup_rate_item = {
                            'service_id': service_id,
                            'fallback_rate': fallback_rate
                        };
                        backup_rate_list.push(backup_rate_item);
                    }
                });
                return backup_rate_list;
            }

            function showError(errorMsg) {
                $('#error-notice').html('').append('<div class="form-group notice-error settings-error notice is-dismissible"><ul><li>'
                    + errorMsg
                    + '</li></ul><button type="button" class="notice-dismiss"><span class="screen-reader-text"></span></button></div>');
            }

            function addFormValidate(index, text) {
                var number = index + 2;
                var childItem = $('.' + package_check_class + ':nth-child(' + number + ')');
                console.log(childItem);
                //number++;
                if ('dimension' == text) {
                    childItem.find('input[name="length"]').addClass('formValidate');
                    childItem.find('input[name="width"]').addClass('formValidate');
                    childItem.find('input[name="height"]').addClass('formValidate');
                } else if ('side_length' == text) {
                    childItem.find('input[name="length"]').addClass('formValidate');
                } else if ('side_width' == text) {
                    childItem.find('input[name="width"]').addClass('formValidate');
                } else if ('side_height' == text) {
                    childItem.find('input[name="height"]').addClass('formValidate');
                } else {
                    childItem.find('input[name="' + text + '"]').addClass('formValidate');
                }
            }

            function addFormValidateFallbackRate(index, text) {
                var number = index + 2;
                var childItem = $('.backup-rate-item:nth-child(' + number + ')');
                childItem.find('select[name="' + text + '"], input[name="' + text + '"]').addClass('formValidate');
            }

            function addWarningValidate(index, text) {
                index++;
                var number = index + 1;
                var childItem = $('.' + package_check_class + ':nth-child(' + number + ')');
                //number++;
                if ('dimension' == text) {
                    childItem.find('input[name="length"]').addClass('warningValidate');
                    childItem.find('input[name="width"]').addClass('warningValidate');
                    childItem.find('input[name="height"]').addClass('warningValidate');
                } else if ('side_length' == text) {
                    childItem.find('input[name="length"]').addClass('warningValidate');
                } else if ('side_width' == text) {
                    childItem.find('input[name="width"]').addClass('warningValidate');
                } else if ('side_height' == text) {
                    childItem.find('input[name="height"]').addClass('warningValidate');
                } else {
                    childItem.find('input[name="' + text + '"]').addClass('warningValidate');
                }
            }

            function removeValidateClass() {
                $('#default_package').find('input').removeClass('formValidate warningValidate');
                $('#product_dimension').find('input').removeClass('formValidate warningValidate');
                $('#fallback_rate').find('input, select').removeClass('formValidate warningValidate');
                $('#max_weight_per_pack').removeClass('formValidate');
            }
        });
    })(jQuery);
</script>
