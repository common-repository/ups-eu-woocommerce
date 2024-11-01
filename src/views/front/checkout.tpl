<div style="display: none;" class="ups_eu_woocommerce_container" id='ups_eu_woocommerce_container_e_shopper'>
    <table class="ups_table_main">
        {if ($dataObject->lang['countryCode'] == "US")}
            <tr>
                <td colspan="2">
                    <div class="ups_shipping_container_address">

                    </div>
                </td>
            </tr>
        {/if}
        <tr>
            <td colspan="2">
                <div class="ups_shipping_container_ap">

                </div>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <div {if $dataObject->DELIVERY_TO_ACCESS_POINT ne 1}style="display: none;"{/if} class="show_bing_map_container">
                    <table id="show_message_error_ups_shipping_focus">
                        <tr>
                            <td colspan="2">
                                <strong class="upsShippingSearchAP">{$dataObject->lang["search_access_point"]}</strong>
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: left;">
                                {$dataObject->lang["Near"]}:
                            </td>
                            <td style="text-align: right;">
                                <span class="click_example" onclick="__upsMapShipping.func.update_textbox_search();">
                                    {$dataObject->lang["use_my_delivery_address"]}
                                </span>
                            </td>
                        </tr>

                        <tr class="show_message_error_ups_shipping" style="display: none;">
                            <td colspan="2">
                                <table>
                                    <tr>
                                        <td>
                                            <span class="content" style="padding:6px;"></span>
                                        </td>
                                        <td>
                                            <span  class="close" onclick="__upsMapShipping.func.hide_mess_error();">×</span>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <table class="box_search_locator">
                                    <tr>
                                        <td class="_left">
                                            <input  id="ups_shipping_text_search" maxlength="250" type="text" class="" placeholder="{$dataObject->lang["placehoder_text_search"]}" /><br/>
                                        </td>
                                        <td valign="top" class="_right">
                                            <span onclick="__upsMapShipping.func.search_locator();" class="ups_search_bing_map button button-primary">{$dataObject->lang["Search"]}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <input type="text" id="ups_seach_show_contries_show_text"  disabled="true" value="{$dataObject->country_list[$dataObject->country]["name"]}" />
                                            <input type="hidden" id="ups_shipping_select_search_country" value="{$dataObject->country}"/>
                                            <br/>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="min-height: 300px;">
                                <div id="upsMyMapShipping" style="position:relative;width:100%;height:300px!important;"></div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <div class="ups_shipping_container_bing_map">

                                </div>
                            </td>
                        </tr>
                    </table>

                </div>
            </td>
        </tr>
        {if ($dataObject->lang['countryCode'] != "US")}
            <tr>
                <td colspan="2">
                    <div class="ups_shipping_container_address">

                    </div>
                </td>
            </tr>
        {/if}
    </table>
    <input type="hidden" ups_form='ups_shipping' ups_name='ups_eu_woocommerce_key' class="input-hidden" name="ups_eu_woocommerce_key" value="{$dataObject->ups_eu_woocommerce_key}"/>
</div>
<div id="upsShipping_loadingDiv" style="display: none;"><img alt="Loading..." src="{$img_url}loader-1.gif"/>Please wait...</div>

<style type="text/css">

    ul.ups_list_hours li{
        list-style: none;
        display: block;
        margin: 0;
    }
    ul.ups_list_hours{
        margin: 0;
    }
    #ups_seach_show_contries_show_text{
        width: 100%!important;
    }
    table.table_ups_shipping_options{
        border-collapse:initial!important;
    }
    table.table_ups_shipping_options,table.table_ups_shipping_options tr,table.table_ups_shipping_options tr td{
        margin: 0!important;
        padding: 0!important;
        border:unset !important;
    }
    ._upsHeaderContent span.__totalPrice{
        font-weight: bold;
    }
    .upsShippingTitleADD,.upsShippingTitleAP{
        display: block;
        padding-bottom: 10px;
    }
    table.box_search_locator tr td._right{
        text-align: right;
    }
    table.box_search_locator tr td._left{
        padding-right: 5px;
    }
    .click_example{
        color: #23a1d1!important;
        cursor: pointer;
    }
    table.ups_table_header{
        border-collapse:inherit!important;
    }
    table.ups_table_header td._logoFrontEnd{
        vertical-align: middle!important;
        text-align: right;
        padding: 0!important;
    }
    table.ups_table_header td._logoFrontEnd img{
        height: 35px!important;
        float: left;
    }
    table.ups_table_header td._text{
        padding: 0!important;
        vertical-align: middle!important;
        text-align: left;
    }
    table.ups_table_header td._text b{
        font-size: 20px;
    }
    div.ups_eu_woocommerce_container  ul.list-unstyled{
        margin: 0!important;
        padding: 0!important;
    }
    div.ups_eu_woocommerce_container  ul.list-unstyled li{
        display: block;
        list-style: none;
        padding-left: 10px;
        margin-top: 5px;
    }
    div.ups_eu_woocommerce_container  ul.list-unstyled li table{
        margin: 0!important;
    }
    div.ups_eu_woocommerce_container  ul.list-unstyled li table tr td{
        padding: 3px!important;
        border:unset!important;
    }
    div.ups_eu_woocommerce_container  ul.list-unstyled li table tr td._item_right{
        padding-right: 15px!important;
        text-align: right;
    }
    .checkout.woocommerce-checkout.processing {
        background-position: center center;
        background-repeat: no-repeat;
    }
    #upsShipping_loadingDiv{
        position: fixed;
        width: 100%;
        z-index: 9999999;
        background-color: #000;
        opacity: .5;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
    }
    #upsShipping_loadingDiv img{
        left: 50%;
        position: absolute;
        top: 50%;
        height: 5%;
    }
    .ups_search_bing_map{
        background-color:  lightgrey!important;
        color: white;
        cursor: pointer;
        width: 118px;
        border: solid 1px #343a40;
        border-radius: 4px;
        color: #343a40;
        float: right;
        padding-top: 10px;
        padding-bottom: 10px;
        text-align: center;
    }
    table.ups_table_main tr{
        border: none!important;
    }
    table.ups_table_main td{
        border: none!important;
    }
    .upsShippingSearchAP{
        display: block;
    }
    .ups_eu_woocommerce_container table{
        margin: 0!important;
        width: 100%;
    }

    .show_message_error_ups_shipping table{
        color: #a94442;
        background-color: #f2dede;
        border-color: #ebccd1;
        padding-left: 5px;
        padding-right: 5px;
        border-radius: 5px;
        line-height: 20px;
        min-height: 40px!important;
        margin-bottom: 15px!important;
        margin-top: 15px!important;
    }
    .show_message_error_ups_shipping span.content{
        padding-left: 15px;
    }
    .show_message_error_ups_shipping span.content,.show_message_error_ups_shipping span.close{
        display: block;
    }
    .show_message_error_ups_shipping span.close{
        cursor: pointer;
    }

    #ups_shipping_text_search{
        width: 100%!important;
    }
    #ups_shipping_text_search::-webkit-input-placeholder { /* Chrome/Opera/Safari */
        font-style: italic;
        opacity: .7;
    }
    #ups_shipping_text_search::-moz-placeholder { /* Firefox 19+ */
        font-style: italic;
        opacity: .7;
    }
    #ups_shipping_text_search:-ms-input-placeholder { /* IE 10+ */
        font-style: italic;
        opacity: .7;
    }
    #ups_shipping_text_search:-moz-placeholder { /* Firefox 18- */
        font-style: italic;
        opacity: .7;
    }
    div.show_bing_map_container  table tr td, div.ups_shipping_container_ap table tr td,div.ups_shipping_container_address table tr td{
        padding: 0;
        border:unset !important;
    }
    span.content_shipping_service{
        font-size: 0.9rem;
    }
    .ups_img_logo{
        height: 27pt!important;
    }
    .ups_eu_woocommerce_container{
        margin-bottom: .75rem;
        background-color: #fff;
        border-radius: 5px;
        border: 1px solid rgba(0,0,0,.125);
        padding-left:  15px;
        padding-right: 15px;
        padding-top: 5px;
        padding-bottom:  5px;
        box-shadow: 2px 2px 8px 0 rgba(0,0,0,.2);
    }
    .show_bing_map_container{
        padding: 15px;
        border: 1px solid rgba(0,0,0,.125);
    }
    .ups_list_locator{
        box-shadow: 2px 2px 8px 0 rgba(0,0,0,.2);
    }
    .resultSearch{
        display: block;
        padding-top: 10px;
    }
    .ups_click_select{
        margin: auto;
        padding-top: 10px;
        padding-bottom: 10px;
        text-align:center;
        cursor: pointer;
        font-weight: normal!important;
        border:solid 1px  #343a40;;
        border-radius: .25rem;
        background-color: lightgrey;
        color: black;
    }
    .__ups_active{
        color: #343a40;
        background-color: paleturquoise;
    }
    table.ups_table_item{
        margin: 0!important;
    }
    table.ups_table_item td.show_right{
        vertical-align: top;
        text-align: center;
        width: 130px!important;
    }
    table.ups_table_item td.show_right img,table.ups_table_item td.show_right span,table.ups_table_item td.show_right button{
        display: block;
    }
    table.ups_table_item td.show_right img{
        margin: auto;
    }
    table.ups_table_item td.show_left{
        text-align: left;
        padding-right: 10px;
    }
    table.ups_table_item td.show_left b,table.ups_table_item td.show_left span{
        display: block;
    }
    table.listItemCalendar{
        display: block;
        width: auto!important;
        margin-left: 10px!important;
    }
    table.listItemCalendar tr.lineTop{
        {*        border-top: 1px solid #ccc!important;*}
    }
    table.ups_table_item td.show_left b,table.ups_table_item td.show_left span{
        display: block;
    }
    div.itemContainerListLocator{
        display: block;
        padding: 5px;
        margin-bottom: 10px;
        margin-top: 10px;
    }
    table tr.ups_show_mobile{
        display: none;
    }
    @media screen and (max-width: 576px) {
        .show_bing_map_container{
            padding: 3px!important;
        }

        div.itemContainerListLocator{
            padding: 0!important;
        }

        table.ups_table_item td.show_right{
            width: 75px!important;
        }

        .ups_eu_woocommerce_container table{
            display: block!important;
        }

        table.ups_table_item td.show_right{
            display: none!important;
        }

        table tr.ups_show_mobile{
            display: block;
        }

        tr.ups_show_mobile img
        ,tr.ups_show_mobile span
        ,tr.ups_show_mobile button{
            display: block;
        }
        tr.ups_show_mobile img{
            margin: auto;
        }
    }
    @media only screen and (max-width: 300px) {
        .ups_search_bing_map {
            width: 50px;
            border-radius: 4px;
            padding-top: 5px;
            padding-bottom: 5px;
        }
    }
</style>
<script type="text/javascript">
    if(!window.jQuery)
    {
        var script1 = document.createElement('script');
        script1.type = "text/javascript";
        script1.src = "{$dataObject->base_url}js/jquery-migrate.min.js";
        document.getElementsByTagName('head')[0].appendChild(script1);

        var script = document.createElement('script');
        script.type = "text/javascript";
        script.src = "{$dataObject->base_url}js/jquery.min.js";
        document.getElementsByTagName('head')[0].appendChild(script);
    }
</script>
<script type="text/javascript">
    <!--
    {if isset($dataObject->_javascript_ups_eu_woocommerce)}
    var _javascript_ups_eu_woocommerce = eval({$dataObject->_javascript_ups_eu_woocommerce});
    {/if}
    (function ($) {
        var __upsMapShipping =  new Object();
        __upsMapShipping.func =  new Object();
        __upsMapShipping.ups_shipping = '{$dataObject->lang["ups_shipping"]}';
        __upsMapShipping.select_one = '{$dataObject->lang["one_select"]}';
        var delivery_access_point = parseInt('{$dataObject->DELIVERY_TO_ACCESS_POINT}');
        /**-----------INIT PARAMS FOR BING MAP----------------**/
        __upsMapShipping.ups_map;
        __upsMapShipping.infobox;
        __upsMapShipping.ListLocations;
        __upsMapShipping.allowCountries = [];
        __upsMapShipping.pushpinInfos = [];
        __upsMapShipping.checkShowUPS = false;
        __upsMapShipping.haveUPS = false;
        __upsMapShipping.infoboxLayer;
        __upsMapShipping.pinLayer;
        __upsMapShipping.img_url = '{$img_url}';
        __upsMapShipping.credentials = '{$dataObject->map_credentials}';
        __upsMapShipping.url_frontend_api_json = '{$dataObject->router_url->url_frontend_api_json}';
        __upsMapShipping.ups_eu_woocommerce_key = '{$dataObject->ups_eu_woocommerce_key}';
        __upsMapShipping.ups_addressFirstQuery = new Object();
        __upsMapShipping.ups_searchManager;
        __upsMapShipping.ups_repeat_map = 0;
        __upsMapShipping.check_show_again = false;
        __upsMapShipping.check_show_load_first = true;
        __upsMapShipping.contry_code_default_config = '{$dataObject->country}';

        __upsMapShipping.addressfirst_lat_value = '{$dataObject->country_code_list[$dataObject->lang['countryCode']][0]}';
        __upsMapShipping.addressfirst_long_value = '{$dataObject->country_code_list[$dataObject->lang['countryCode']][1]}';

        __upsMapShipping.addressfirst_lat = '';
        __upsMapShipping.addressfirst_long = '';

    {literal}
        __upsMapShipping.func.GetMap = function () {
            __upsMapShipping.ups_map = new Microsoft.Maps.Map('#upsMyMapShipping', {});
            /**Create an infobox at the center of the map but don't show it.**/
            __upsMapShipping.infobox = new Microsoft.Maps.Infobox(__upsMapShipping.ups_map.getCenter(), {title: 'Ups map center', description: 'decripsion ups map center', visible: false});
            /**Assign the infobox to a map instance.**/
            __upsMapShipping.infobox.setMap(__upsMapShipping.ups_map);
            __upsMapShipping.infoboxLayer = new Microsoft.Maps.EntityCollection();
            __upsMapShipping.pinLayer = new Microsoft.Maps.EntityCollection();
            __upsMapShipping.infoboxLayer.push(__upsMapShipping.infobox);
            if (__upsMapShipping.addressfirst_lat.length > 0) {
                __upsMapShipping.ups_map.setView({
                    center: new Microsoft.Maps.Location(__upsMapShipping.addressfirst_lat, __upsMapShipping.addressfirst_long)
                });
            } else {
                __upsMapShipping.ups_map.setView({
                    center: new Microsoft.Maps.Location(__upsMapShipping.addressfirst_lat_value, __upsMapShipping.addressfirst_long_value), zoom: 8
                });
            }
        };

        __upsMapShipping.func.geo_code_query = function (query) {
            if (!__upsMapShipping.ups_searchManager) {
                if (delivery_access_point != 0 && Microsoft.Maps) {
                    Microsoft.Maps.loadModule('Microsoft.Maps.Search', function () {
                        __upsMapShipping.ups_searchManager = new Microsoft.Maps.Search.SearchManager(__upsMapShipping.ups_map);
                        __upsMapShipping.func.geo_code_query(query);
                    });
                }
            } else {
                var searchRequest = {
                    where: query,
                    callback: function (r) {
                        if (r && r.results && r.results.length > 0) {
                            __upsMapShipping.ups_addressFirstQuery.lat = r.results[0].location.latitude;
                            __upsMapShipping.ups_addressFirstQuery.lng = r.results[0].location.longitude;
                            __upsMapShipping.ups_addressFirstQuery.title = "";
                            __upsMapShipping.ups_addressFirstQuery.description = query;
                            __upsMapShipping.ups_addressFirstQuery.icon = __upsMapShipping.img_url + 'address.png';
                            var map_address = new Microsoft.Maps.Location(__upsMapShipping.ups_addressFirstQuery.lat, __upsMapShipping.ups_addressFirstQuery.lng);
                            var pin = new Microsoft.Maps.Pushpin(map_address, {icon: __upsMapShipping.ups_addressFirstQuery.icon, width: '20px', height: '20px'});
                            pin.Title = __upsMapShipping.ups_addressFirstQuery.title;
                            pin.Description = __upsMapShipping.ups_addressFirstQuery.description;
                            __upsMapShipping.pinLayer.push(pin);
                            Microsoft.Maps.Events.addHandler(pin, 'click', __upsMapShipping.func.displayInfobox);
                        }
                    },
                    errorCallback: function (e) {
                        console.log("string query not found");
                    }
                };
                __upsMapShipping.ups_searchManager.geocode(searchRequest);
            }
        };

        __upsMapShipping.func.geo_code_query2 = function (query, coutryCode) {
            if (!__upsMapShipping.ups_searchManager) {
                if (delivery_access_point != 0 && Microsoft.Maps) {
                    Microsoft.Maps.loadModule('Microsoft.Maps.Search', function () {
                        __upsMapShipping.ups_searchManager = new Microsoft.Maps.Search.SearchManager(__upsMapShipping.ups_map);
                        __upsMapShipping.func.geo_code_query2(query, coutryCode);
                    });
                }
            } else {
                var searchRequest = {
                    where: query,
                    callback: function (r) {
                        if (r && r.results && r.results.length > 0) {
                            for (var index in r.results) {
                                var item = r.results[index];
                                if (item && item.entityType == "CountryRegion") {
                                    __upsMapShipping.addressfirst_lat = item.location.latitude;
                                    __upsMapShipping.addressfirst_long = item.location.longitude;
                                    break;
                                }
                            }
                            if (__upsMapShipping.ups_map) {
                                __upsMapShipping.ups_map.setView({
                                    center: new Microsoft.Maps.Location(__upsMapShipping.addressfirst_lat, __upsMapShipping.addressfirst_long)
                                });
                            }
                        }
                    },
                    includeCountryIso2: coutryCode,
                    errorCallback: function (e) {
                        if (__upsMapShipping.ups_repeat_map < 5) {
                            __upsMapShipping.ups_repeat_map += 1;
                            __upsMapShipping.func.geo_code_query2(query, coutryCode);
                        }
                    }
                };
                __upsMapShipping.ups_searchManager.geocode(searchRequest);
            }
        };

        __upsMapShipping.func.update_bing_map = function (info_locator, MaximumListSize) {
            __upsMapShipping.func.remove_pushpin();
            __upsMapShipping.pushpinInfos = [];
            if (info_locator.check === false) {
                return;
            }
            if (Number(MaximumListSize) === 1) {
                var tmpObject = {};
                tmpObject.lat = info_locator.Geocode.Latitude || 0;
                tmpObject.lng = info_locator.Geocode.Longitude || 0;
                tmpObject.title = info_locator.AddressKeyFormat.ConsigneeName;
                tmpObject.text = 1;
                tmpObject.description = info_locator.AddressKeyFormat.AddressLine + ' ' + info_locator.AddressKeyFormat.CountryCode + ' ' + info_locator.AddressKeyFormat.PoliticalDivision2 + ' ' + info_locator.AddressKeyFormat.PostcodePrimaryLow;
                tmpObject.icon = __upsMapShipping.img_url + 'address.png';
                __upsMapShipping.pushpinInfos[0] = tmpObject;
                return;
            } else {
                var list_locator = info_locator.list_locator || [];
                var index = 0;
                if (list_locator.length > 0) {
                    for (var key in list_locator) {
                        var item = list_locator[key];
                        if (item) {
                            if (item.Geocode && item.AddressKeyFormat) {
                                var tmpObject = {};
                                tmpObject.lat = item.Geocode.Latitude || 0;
                                tmpObject.lng = item.Geocode.Longitude || 0;
                                tmpObject.title = item.AddressKeyFormat.ConsigneeName;
                                tmpObject.text = '' + (index + 1);
                                tmpObject.description = item.AddressKeyFormat.AddressLine + ' ' + item.AddressKeyFormat.CountryCode + ' ' + item.AddressKeyFormat.PoliticalDivision2 + ' ' + item.AddressKeyFormat.PostcodePrimaryLow;
                                tmpObject.icon = __upsMapShipping.img_url + 'red_pin.png';
                                __upsMapShipping.pushpinInfos[index] = tmpObject;
                                index++;
                            }
                        }
                    }
                    var stringSearch = __upsMapShipping.dataShippingTo.ups_shipping_text_search || ""
                    stringSearch += ", " + $("#ups_seach_show_contries_show_text").val();
                    __upsMapShipping.func.geo_code_query(stringSearch);
                }
            }
            __upsMapShipping.ListLocations = [];
            for (var i = 0; i < __upsMapShipping.pushpinInfos.length; i++) {
                __upsMapShipping.ListLocations[i] = new Microsoft.Maps.Location(__upsMapShipping.pushpinInfos[i].lat, __upsMapShipping.pushpinInfos[i].lng);
                var pin = new Microsoft.Maps.Pushpin(__upsMapShipping.ListLocations[i], {icon: __upsMapShipping.pushpinInfos[i].icon, width: '20px', height: '20px', text: __upsMapShipping.pushpinInfos[i].text});
                pin.Title = __upsMapShipping.pushpinInfos[i].title;
                pin.Description = __upsMapShipping.pushpinInfos[i].description;
                __upsMapShipping.pinLayer.push(pin);
                Microsoft.Maps.Events.addHandler(pin, 'click', __upsMapShipping.func.displayInfobox);
            }
            __upsMapShipping.ups_map.entities.push(__upsMapShipping.pinLayer);
            __upsMapShipping.ups_map.entities.push(__upsMapShipping.infoboxLayer);
            if (__upsMapShipping.ListLocations.length > 0) {
                var bestview = Microsoft.Maps.LocationRect.fromLocations(__upsMapShipping.ListLocations);
                __upsMapShipping.ups_map.setView({center: bestview.center, zoom: 10});
            } else {
                __upsMapShipping.ups_map.setView({
                    center: new Microsoft.Maps.Location(__upsMapShipping.addressfirst_lat_value, __upsMapShipping.addressfirst_long_value), zoom: 8
                });
            }
        };

        __upsMapShipping.func.remove_pushpin = function () {
            if (delivery_access_point != 0) {
                if (__upsMapShipping && __upsMapShipping.ups_map && __upsMapShipping.ups_map.entities) {
                    for (var i = __upsMapShipping.ups_map.entities.getLength() - 1; i >= 0; i--) {
                        var pushpin = __upsMapShipping.ups_map.entities.get(i);
                        if (pushpin instanceof Microsoft.Maps.Pushpin) {
                            __upsMapShipping.ups_map.entities.removeAt(i);
                        }
                    }
                    __upsMapShipping.pinLayer.clear();
                    __upsMapShipping.infoboxLayer.clear();
                    __upsMapShipping.pushpinInfos = [];
                }
            }
        };
        __upsMapShipping.func.displayInfobox = function (e) {
            __upsMapShipping.infobox.setOptions({title: e.target.Title, description: e.target.Description, visible: true, offset: new Microsoft.Maps.Point(0, 25)});
            __upsMapShipping.infobox.setLocation(e.target.getLocation());
        };
        __upsMapShipping.func.hideInfobox = function (e) {
            __upsMapShipping.infobox.setOptions({visible: false});
        };
        __upsMapShipping.func.MoveLocation = function (index, LocationID, idClick) {
            __upsMapShipping.ups_map.setView({
                center: new Microsoft.Maps.Location(__upsMapShipping.ListLocations[index].latitude, __upsMapShipping.ListLocations[index].longitude)
            });
            var dataFormUps = {};
            dataFormUps.ups_eu_woocommerce_key = __upsMapShipping.ups_eu_woocommerce_key;
            dataFormUps.service_id = __upsMapShipping.selected_shipping_service_type_ap_id;
            dataFormUps.LocationID = LocationID;
            $("#upsShipping_loadingDiv").show();
            $(".ups_click_select").removeClass("__ups_active");
            $("#" + idClick).addClass("__ups_active");
            $.ajax({
                type: "POST",
                dataType: 'json',
                url: __upsMapShipping.url_frontend_api_json + '&method=checkout_update&' + $.param(dataFormUps),
                success: function (data)
                {
                    $("#upsShipping_loadingDiv").hide();
                    $("#ups_shipping_click").prop('disabled', false);
                    $('#place_order').prop("disabled", false);
                    __upsMapShipping.selected_shipping_service = true;
                    $(document.body).trigger("update_checkout");
                    jQuery(document.body).trigger("update_checkout");
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    $("#upsShipping_loadingDiv").hide();
                }
            });

        }; {/literal}
        /**-----------insit map--------**/
        __upsMapShipping.is_loading = false;
        __upsMapShipping.is_loading_search = false;
        __upsMapShipping.changed_data = '';
        __upsMapShipping.changed_data_searchlocation = '';

        __upsMapShipping.selected_shipping_service = false;
        __upsMapShipping.selected_shipping_service_type_ap_id = '';
        __upsMapShipping.selectedRadioChecked = 0;
        __upsMapShipping.ship_to_different_address_checkbox = false;
        __upsMapShipping.dataShippingTo = new Object();
        __upsMapShipping.countryCode = "{$dataObject->lang['countryCode']}";


        __upsMapShipping.func.hide_mess_error = function () {
            $(".show_message_error_ups_shipping").hide();
        };
        __upsMapShipping.func.get_changed_data = function (dataShippingTo) {
            var billing_state = dataShippingTo.billing_state || "";
            return dataShippingTo.billing_address_1 + dataShippingTo.billing_address_2 + dataShippingTo.billing_country + dataShippingTo.billing_city + billing_state + dataShippingTo.billing_postcode + dataShippingTo.MaximumListSize + dataShippingTo.get_cart_total;
        };
        
        __upsMapShipping.func.checkout_update = function (service_id, type_service, total) {

            if (type_service === 'AP') {
                $(".show_bing_map_container").show();
                $('#place_order').prop("disabled", true);
                __upsMapShipping.selected_shipping_service_type_ap_id = service_id;
                __upsMapShipping.selected_shipping_service = false;
            } else {
                $(".show_bing_map_container").hide();
                $('#place_order').prop("disabled", false);
            }
            var dataFormUps = new Object();
            dataFormUps.ups_eu_woocommerce_key = '{$dataObject->ups_eu_woocommerce_key}';
            dataFormUps.service_id = service_id;
            $("#upsShipping_loadingDiv").show();
            $.ajax({
                type: "POST",
                dataType: 'json',
                url: '{$dataObject->router_url->url_frontend_api_json}&method=checkout_update&' + $.param(dataFormUps),
                success: function (data)
                {
                    $("#upsShipping_loadingDiv").hide();
                    $("#ups_shipping_click").prop('disabled', false);

                    if (data.data.service_type === 'AP') {
                        
                        if($(".ups_click_select.__ups_active").attr('id')){
                            $('#place_order').prop("disabled", false);
                            $(".show_message_error_ups_shipping").hide();
                            $('#ups_click_select_0').trigger('click');
                        }else{
                            $(".show_message_error_ups_shipping span.content").html("{$dataObject->lang['location_search_before']}");
                            $(".show_message_error_ups_shipping").show();
                        }
                        __upsMapShipping.selected_shipping_service_type_ap_id = data.data.id;
                        __upsMapShipping.selected_shipping_service = false;
                    } else {
                        __upsMapShipping.selected_shipping_service = true;
                        $('#place_order').prop("disabled", false);

                    }

                    $(document.body).trigger("update_checkout");
                    jQuery(document.body).trigger("update_checkout");
                    $(document.body).on('updated_checkout', function() {
                        // if ($("ul#shipping_method li:first-child").find("label > span").length > 1) {
                        //     $("ul#shipping_method li:first-child").find("label > span").remove();
                        // }
                        // var label_length = $("ul#shipping_method li input[type='radio']").length;
                        // var label_hidden = $("ul#shipping_method li input[type='hidden']").length;
                        // if (0 == label_length) {
                        //     if ( 1 == label_hidden ) {
                        //         var value     = $("ul#shipping_method li input[type='hidden']").attr("value");
                        //         var arrValue  = value.split(":");
                        //         if (arrValue[0] == 'ups_eu_shipping') {
                        //             $("ul#shipping_method li input[type='hidden']").parent().find("label > span").remove();
                        //             var textLB = $("ul#shipping_method li input[type='hidden']").parent().find("label").text().replace(":", "");
                        //             $("ul#shipping_method li input[type='hidden']").parent().find("label").text(textLB);
                        //         }
                        //     }
                        // } else {
                        //     $("ul#shipping_method li input[type='radio']").each(function () {
                        //         var value     = $(this).attr("value");
                        //         var arrValue  = value.split(":");
                        //         if (arrValue[0] == 'ups_eu_shipping') {
                        //             $(this).parent().find("label > span").remove();
                        //             var textLB = $(this).parent().find("label").text().replace(":", "");
                        //             $(this).parent().find("label").text(textLB);
                        //         }
                        //     });
                        // }
                        if (__upsMapShipping.countryCode == 'US') {
                            var payment_obj = $("#payment").find("input[value='cod']");
                            if (payment_obj) {
                                if (type_service == 'AP') {
                                    payment_obj.parent().hide();
                                    $("#payment").find("input").not("input[value='cod']").first().click();
                                } else {
                                    payment_obj.parent().show();
                                }
                            }
                        }
                    });
                    $(document.body).trigger("updated_checkout");
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    $("#upsShipping_loadingDiv").hide();
                }
            });
        };
        __upsMapShipping.func.valide_call_ajax = function (dataShippingTo) {
            if (dataShippingTo.billing_address_1.length <= 0) {
                return false;
            }
            if (dataShippingTo.billing_country.length <= 0 && $('.country_to_state').val().length <= 0) {
                return false;
            }
            if (dataShippingTo.billing_city.length <= 0) {
                return false;
            }
            // if (dataShippingTo.billing_postcode.length <= 0) {
            //     return false;
            // }
            if (dataShippingTo.MaximumListSize === 1) {
                var dataNew = __upsMapShipping.func.get_changed_data(dataShippingTo);
                if (__upsMapShipping.changed_data !== dataNew) {
                    __upsMapShipping.changed_data = dataNew;
                    return true;
                }
                return false;
            } else {
                return true;
            }

        };
        __upsMapShipping.func.update_show_error_search_locator = function (strError) {
            __upsMapShipping.selected_shipping_service = false;
            __upsMapShipping.func.remove_pushpin();
            $(".ups_shipping_container_bing_map").html("");
            $(".show_message_error_ups_shipping span.content").html(strError);
            $(".show_message_error_ups_shipping").show();
            //haivt8
            $('html,body').animate({
                scrollTop: $("#ups_eu_woocommerce_container_e_shopper").offset().top
            }, 'slow');
        };
        __upsMapShipping.func.search_locator = function () {
            var textSearch = $("#ups_shipping_text_search").val() || '';
            $(".show_message_error_ups_shipping").hide();
            if (textSearch.length <= 0) {
                __upsMapShipping.func.update_show_error_search_locator(_javascript_ups_eu_woocommerce.lang.mes_adddress_is_required || "");
                __upsMapShipping.changed_data_searchlocation = "";
                return;
            }
            if (__upsMapShipping.is_loading_search === true)
                return;
            /**--------------------LOAD  PARAMS CALL API----------------**/
            __upsMapShipping.func.init_shipping_to();
            __upsMapShipping.dataShippingTo.MaximumListSize = 5;

            if (__upsMapShipping.changed_data_searchlocation !== __upsMapShipping.dataShippingTo.ups_shipping_text_search) {

                __upsMapShipping.func.remove_pushpin();
                __upsMapShipping.selected_shipping_service = false;
                $(".ups_shipping_container_bing_map").html("");

                __upsMapShipping.changed_data_searchlocation = __upsMapShipping.dataShippingTo.ups_shipping_text_search;
                __upsMapShipping.is_loading_search = true;
                $("#upsShipping_loadingDiv").show();
                $.ajax({
                    type: "POST",
                    dataType: 'json',
                    url: '{$dataObject->router_url->url_frontend_api_json}&method=search_locator&' + $.param(__upsMapShipping.dataShippingTo),
                    success: function (data)
                    {
                        $("#upsShipping_loadingDiv").hide();
                        __upsMapShipping.is_loading_search = false;

                        if (data && data.data && data.data.check_api_all === true) {
                            if (data.data.api_message_error) {
                                /* error*/
                                if (data.data.api_message_error.ErrorDescription) {
                                    __upsMapShipping.func.update_show_error_search_locator(data.data.api_message_error.ErrorDescription || "");
                                    return false;
                                }
                            } else {
                                /* success*/
                                if (data.data.info_locator) {
                                    $(".ups_shipping_container_bing_map").html(data.data.html.html_bing_map);
                                    __upsMapShipping.func.update_bing_map(data.data.info_locator, data.data.input_params_ajax.MaximumListSize);
                                    $('#ups_click_select_0').trigger('click');
                                }
                            }
                        }
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        __upsMapShipping.is_loading_search = false;
                    }
                });
            }

        };
        __upsMapShipping.func.update_countries_show = function () {
            if (__upsMapShipping.ship_to_different_address_checkbox) {
                $("#ups_shipping_select_search_country").val($("form[name='checkout'] select[name='shipping_country'] option:selected").val());
                $("#ups_seach_show_contries_show_text").val($("form[name='checkout'] select[name='shipping_country'] option:selected").text());
            } else {
                $("#ups_shipping_select_search_country").val($("form[name='checkout'] select[name='billing_country'] option:selected").val());
                $("#ups_seach_show_contries_show_text").val($("form[name='checkout'] select[name='billing_country'] option:selected").text());
            }
            var textCountry = $('#billing_country').parent().text();
            if ($('.country_to_state') && $('.country_to_state').val().length > 0 && textCountry.indexOf("Select a country") < 0) {
                $("#ups_shipping_select_search_country").val($('.country_to_state').val());
                $("#ups_seach_show_contries_show_text").val(textCountry);
            }
        };

        __upsMapShipping.func.checkout_load_ups_shipping = function () {
         
            __upsMapShipping.func.init_shipping_to();
            __upsMapShipping.dataShippingTo.MaximumListSize = 1;
            if (__upsMapShipping.is_loading === true) {
                return;
            }

            // remove shipping fee
            // if (jQuery("ul#shipping_method li:first-child").find("label > span").length > 0) {
            //     jQuery("ul#shipping_method li:first-child").find("label > span").remove();
            // }
            $("ul#shipping_method li input[type='radio']").each(function () {
                var value     = $(this).attr("value");
                var arrValue  = value.split(":");
                if (arrValue[0] == 'ups_eu_shipping') {
                    __upsMapShipping.haveUPS = true;
                    // $(this).parent().find("label > span").remove();
                    // var textLB = $(this).parent().find("label").text().replace(":", "");
                    // $(this).parent().find("label").text(textLB);
                }
            });
            /**--------------------LOAD  PARAMS CALL API----------------**/
            if (__upsMapShipping.check_show_again === true && __upsMapShipping.haveUPS) {
                $(".ups_eu_woocommerce_container").show();
            }

            if (__upsMapShipping.func.valide_call_ajax(__upsMapShipping.dataShippingTo) === true) {
                __upsMapShipping.is_loading = true;
                $("#upsShipping_loadingDiv").show();
                $(".show_bing_map_container").hide();
                //console.log('{$dataObject->router_url->url_frontend_api_json}&method=checkout_load&' + $.param(__upsMapShipping.dataShippingTo));
                $.ajax({
                    type: "POST",
                    dataType: 'json',
                    url: '{$dataObject->router_url->url_frontend_api_json}&method=checkout_load&' + $.param(__upsMapShipping.dataShippingTo),
                    success: function (data)
                    {
                        if (data.data && data.data.array_country_codes) {
                            __upsMapShipping.allowCountries = data.data.array_country_codes;
                        }
                        $("#upsShipping_loadingDiv").hide();
                        __upsMapShipping.is_loading = false;
                        if (data && data.data && data.data.check_api_all === true) {
                            var checkRateTime = data.data.RateTimeInTransit || false;
                            if (checkRateTime !== false) {
                                __upsMapShipping.checkShowUPS = true;
                                $(".ups_shipping_container_ap").html(data.data.html.html_AP);
                                $(".ups_shipping_container_address").html(data.data.html.html_ADD);

                                var inforService = false;
                                if (data.data.RateTimeInTransit[data.data.min_total_price_service.id_service]) {
                                    if (data.data.RateTimeInTransit[data.data.min_total_price_service.id_service].custom) {
                                        inforService = data.data.RateTimeInTransit[data.data.min_total_price_service.id_service].custom;
                                    }
                                }
                                if (inforService) {
                                    $("#shipping_method").find("li").show();
                                    __upsMapShipping.func.checkout_update(data.data.min_total_price_service.id_service, data.data.min_total_price_service.service_type, inforService.monetary_value);
                                }
                                $(".ups_shipping_container_bing_map").html(data.data.html.html_bing_map);
                                __upsMapShipping.func.update_bing_map(data.data.info_locator, data.data.input_params_ajax.MaximumListSize);


                                if (data.data.min_total_price_service.service_type === 'AP') {
                                    __upsMapShipping.selected_shipping_service_type_ap_id = data.data.min_total_price_service.id_service;
                                    __upsMapShipping.selected_shipping_service = false;

                                    $(".show_bing_map_container").show();
                                    $('.click_example').trigger('click');
                                    __upsMapShipping.func.search_locator();
                                } else {
                                    $(".show_bing_map_container").hide();
                                    __upsMapShipping.selected_shipping_service = true;
                                }

                                var label_length = $("ul#shipping_method li input[type='radio']").length;
                                var label_hidden = $("ul#shipping_method li input[type='hidden']").length;
                                if (0 == label_length) {
                                    if ( 1 == label_hidden ) {
                                        var value     = $("ul#shipping_method li input[type='hidden']").attr("value");
                                        var arrValue  = value.split(":");
                                        if (arrValue[0] == 'ups_eu_shipping' && inforService != false) {
                                            $(".ups_eu_woocommerce_container").show();
                                        }
                                    }
                                } else {
                                    $("ul#shipping_method li input[type='radio']").each(function () {
                                        var value     = $(this).attr("value");
                                        var arrValue  = value.split(":");
                                        if (arrValue[0] == 'ups_eu_shipping' && $(this).is(":checked") && inforService != false) {
                                            $(".ups_eu_woocommerce_container").show();
                                        }
                                    });
                                }

                                __upsMapShipping.check_show_again = true;
                                __upsMapShipping.func.update_countries_show();
                                __upsMapShipping.func.geo_code_query2(__upsMapShipping.contry_code_default_config, __upsMapShipping.contry_code_default_config);
                                return false;
                            } else {
                                __upsMapShipping.checkShowUPS = false;
                                $(".ups_eu_woocommerce_container").hide();
                                __upsMapShipping.check_show_again = false;
                                $("table.table_ups_shipping_options").parent().hide();
                                __upsMapShipping.selectedRadioChecked = 0;
                                __upsMapShipping.check_show_load_first = false;
                            }
                        } else {
                            __upsMapShipping.checkShowUPS = false;
                        }
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        __upsMapShipping.checkShowUPS = false;
                        $("#upsShipping_loadingDiv").hide();
                        __upsMapShipping.is_loading = false;
                        $(".ups_eu_woocommerce_container").hide();
                        __upsMapShipping.check_show_again = false;
                        $("table.table_ups_shipping_options").parent().hide();
                        __upsMapShipping.selectedRadioChecked = 0;
                        __upsMapShipping.check_show_load_first = false;
                    }
                });
            }
        };
        
        __upsMapShipping.func.init_shipping_to = function () {
            __upsMapShipping.ship_to_different_address_checkbox =  $("#ship-to-different-address-checkbox").prop("checked");
            if (__upsMapShipping.ship_to_different_address_checkbox) {
                /**-----------------THIS CASE  SHIPPING  TO IS SET--------------------------**/
                __upsMapShipping.dataShippingTo.billing_address_1 = $("form[name='checkout'] input[type='text'][name='shipping_address_1']").val() || '';
                __upsMapShipping.dataShippingTo.billing_address_2 = $("form[name='checkout'] input[type='text'][name='shipping_address_2']").val() || '';
                __upsMapShipping.dataShippingTo.billing_country = $("form[name='checkout'] select[name='shipping_country']").val() || $("form[name='checkout'] input[name='shipping_country']").val();
                __upsMapShipping.dataShippingTo.billing_city = $("form[name='checkout'] input[type='text'][name='shipping_city']").val() || '';
                __upsMapShipping.dataShippingTo.billing_postcode = $("form[name='checkout'] input[type='text'][name='shipping_postcode']").val() || '';
                __upsMapShipping.dataShippingTo.billing_state = $("form[name='checkout'] select[name='shipping_state']").val() || '';
                __upsMapShipping.dataShippingTo.billing_name_state = $("form[name='checkout'] select[name='shipping_state']").find("option[value='"+ __upsMapShipping.dataShippingTo.billing_state +"']").text() || '';
            } else {
                /**-------------------------SHIPPING TO DONT SET, GET BILLING ADDRESS----------**/
                __upsMapShipping.dataShippingTo.billing_address_1 = $("form[name='checkout'] input[type='text'][name='billing_address_1']").val() || '';
                __upsMapShipping.dataShippingTo.billing_address_2 = $("form[name='checkout'] input[type='text'][name='billing_address_2']").val() || '';
                __upsMapShipping.dataShippingTo.billing_country = $("form[name='checkout'] select[name='billing_country']").val() || $("form[name='checkout'] input[name='billing_country']").val();
                __upsMapShipping.dataShippingTo.billing_city = $("form[name='checkout'] input[type='text'][name='billing_city']").val() || '';
                __upsMapShipping.dataShippingTo.billing_postcode = $("form[name='checkout'] input[type='text'][name='billing_postcode']").val() || '';
                __upsMapShipping.dataShippingTo.billing_state = $("form[name='checkout'] select[name='billing_state']").val() || '';
                __upsMapShipping.dataShippingTo.billing_name_state = $("form[name='checkout'] select[name='billing_state']").find("option[value='"+ __upsMapShipping.dataShippingTo.billing_state +"']").text() || '';
            }
            // if ($('.country_to_state') && $('.country_to_state').val().length > 0) {
            //     __upsMapShipping.dataShippingTo.billing_country = $('.country_to_state').val();
            // }
            __upsMapShipping.dataShippingTo.billing_phone = $("form[name='checkout'] input[type='tel'][name='billing_phone']").val() || "";
            //__upsMapShipping.dataShippingTo.billing_email = $("form[name='checkout'] input[type='email'][name='billing_email']").val().replace("@", "&") || "";

            __upsMapShipping.dataShippingTo.get_cart_total = '{$dataObject->get_cart_total}';
            __upsMapShipping.dataShippingTo.get_woocommerce_currency_symbol = '{$dataObject->get_woocommerce_currency_symbol}';
            __upsMapShipping.dataShippingTo.get_woocommerce_currency = '{$dataObject->get_woocommerce_currency}';
            __upsMapShipping.dataShippingTo.ups_shipping_text_search = $("#ups_shipping_text_search").val();
            __upsMapShipping.dataShippingTo.ups_shipping_select_search_country = $("#ups_shipping_select_search_country").val() || '';
            __upsMapShipping.dataShippingTo.ups_eu_woocommerce_key = '{$dataObject->ups_eu_woocommerce_key}';
            __upsMapShipping.dataShippingTo.selectedService = $("form[name='checkout'] input[name='ups_shipping_service_all']:checked").data('service-key');
        };
        __upsMapShipping.func.update_textbox_search = function () {
            var tmp = [];
            if (__upsMapShipping.dataShippingTo.billing_address_1.length > 0) {
                tmp.push(__upsMapShipping.dataShippingTo.billing_address_1);
            }
            if (__upsMapShipping.dataShippingTo.billing_address_2.length > 0) {
                tmp.push(__upsMapShipping.dataShippingTo.billing_address_2);
            }
            if (__upsMapShipping.dataShippingTo.billing_city.length > 0) {
                tmp.push(__upsMapShipping.dataShippingTo.billing_city);
            }
            if (__upsMapShipping.dataShippingTo.billing_state.length > 0) {
                tmp.push(__upsMapShipping.dataShippingTo.billing_name_state);
            }
            if (__upsMapShipping.dataShippingTo.billing_postcode.length > 0) {
                tmp.push(__upsMapShipping.dataShippingTo.billing_postcode);
            }
            $("#ups_shipping_text_search").val(tmp.join(","));
            __upsMapShipping.func.update_countries_show();

        };
        __upsMapShipping.func.loadmap = function () {
            if (delivery_access_point != 0) {
                $.getScript("{$dataObject->router_url->url_api_map_bing_com}?key={$dataObject->map_credentials}&callback=GetMap")
                    .done(function (script, textStatus) {
                        if (Microsoft) {
                        {* console.log("Load map is success");*}
                        } else {
                            __upsMapShipping.func.loadmap();
                        }
                    })
                    .fail(function (jqxhr, settings, exception) {
                        if (!Microsoft) {
                            __upsMapShipping.func.loadmap();
                        }
                    });
            }
        };

        
        $(document).ready(function () {
         __upsMapShipping.func.checkout_load_ups_shipping();
            /*---------event focusout SHIPPING TO ADDRESS---------  */
            var shipping_country_api;
            var shipping_address_1_api;
            var billing_address_2_api;
            var shipping_city_api;
            var shipping_postcode_api;
            var billing_address_1_api;
            var billing_country_api;
            var billing_city_api;
            var billing_postcode_api;
            var hidden_repeat_one = 0;
            
            $("#ship-to-different-address-checkbox").click(function () {
                __upsMapShipping.ship_to_different_address_checkbox = $(this).prop("checked");
                var current_country = $('#billing_country').val();
                if (__upsMapShipping.allowCountries) {
                    var check_country = __upsMapShipping.allowCountries.indexOf(current_country);
                    if (check_country > -1 || __upsMapShipping.allowCountries.length == 0) {
                        __upsMapShipping.func.checkout_load_ups_shipping();
                    }
                }
            });
            {if $dataObject->ups_flat_cal_discount == true}
                $(this).ajaxComplete(function(event, xhr, settings) {
                    var url = settings.url;
                    if (url.includes('/?wc-ajax=apply_coupon') || url.includes('/?wc-ajax=remove_coupon')) {
                        location.reload();

                        // var current_country = $('#billing_country').val();
                        // if (__upsMapShipping.allowCountries) {
                        //    var check_country = __upsMapShipping.allowCountries.indexOf(current_country);
                        //    if (check_country > -1 || __upsMapShipping.allowCountries.length == 0) {
                        //        __upsMapShipping.func.checkout_load_ups_shipping();
                        //    }
                        // }
                    }
                    
                });
            {/if}
            $("form[name='checkout'] select[name='shipping_country']").focusout(function () {
                if ($(this).val() != shipping_country_api) {
                    var current_country = $('#billing_country').val();
                    if (__upsMapShipping.allowCountries) {
                        var check_country = __upsMapShipping.allowCountries.indexOf(current_country);
                        if (check_country > -1 || __upsMapShipping.allowCountries.length == 0) {
                            __upsMapShipping.func.checkout_load_ups_shipping();
                        }
                    }
                }
            });
            $("form[name='checkout'] select[name='shipping_country']").focusin(function () {
                shipping_country_api = $(this).val();
            });

            $("form[name='checkout'] input[type='text'][name='shipping_address_1']").focusout(function () {
                if ($(this).val() != shipping_address_1_api) {
                    var current_country = $('#billing_country').val();
                    if (__upsMapShipping.allowCountries) {
                        var check_country = __upsMapShipping.allowCountries.indexOf(current_country);
                        if (check_country > -1 || __upsMapShipping.allowCountries.length == 0) {
                            __upsMapShipping.func.checkout_load_ups_shipping();
                        }
                    }
                }
            });
            $("form[name='checkout'] input[type='text'][name='shipping_address_1']").focusin(function () {
                shipping_address_1_api = $(this).val();
            });

            $("form[name='checkout'] input[type='text'][name='billing_address_2']").focusout(function () {
                if ($(this).val() != billing_address_2_api) {
                    var current_country = $('#billing_country').val();
                    if (__upsMapShipping.allowCountries) {
                        var check_country = __upsMapShipping.allowCountries.indexOf(current_country);
                        if (check_country > -1 || __upsMapShipping.allowCountries.length == 0) {
                            __upsMapShipping.func.checkout_load_ups_shipping();
                        }
                    }
                }
            });
            $("form[name='checkout'] input[type='text'][name='billing_address_2']").focusin(function () {
                billing_address_2_api = $(this).val();
            });

            $("form[name='checkout'] input[type='text'][name='shipping_city']").focusout(function () {
                if ($(this).val() != shipping_city_api) {
                    var current_country = $('#billing_country').val();
                    if (__upsMapShipping.allowCountries) {
                        var check_country = __upsMapShipping.allowCountries.indexOf(current_country);
                        if (check_country > -1 || __upsMapShipping.allowCountries.length == 0) {
                            __upsMapShipping.func.checkout_load_ups_shipping();
                        }
                    }
                }
            });
            $("form[name='checkout'] input[type='text'][name='shipping_city']").focusin(function () {
                shipping_city_api = $(this).val();
            });

            $("form[name='checkout'] input[type='text'][name='shipping_postcode']").focusout(function () {
                if ($(this).val() != shipping_postcode_api) {
                    var current_country = $('#billing_country').val();
                    if (__upsMapShipping.allowCountries) {
                        var check_country = __upsMapShipping.allowCountries.indexOf(current_country);
                        if (check_country > -1 || __upsMapShipping.allowCountries.length == 0) {
                            __upsMapShipping.func.checkout_load_ups_shipping();
                        }
                    }
                }
            });
            $("form[name='checkout'] input[type='text'][name='shipping_postcode']").focusin( function () {
                shipping_postcode_api = $(this).val();
            });

            /**---------event focusout BILLING ADDDRESS---------  **/
            $("form[name='checkout'] input[type='text'][name='billing_address_1']").focusout(function () {
                if ($(this).val() != billing_address_1_api) {
                    var current_country = $('#billing_country').val();
                    if (__upsMapShipping.allowCountries) {
                        var check_country = __upsMapShipping.allowCountries.indexOf(current_country);
                        if (check_country > -1 || __upsMapShipping.allowCountries.length == 0) {
                            __upsMapShipping.func.checkout_load_ups_shipping();
                        }
                    }
                }
            });
            $("form[name='checkout'] input[type='text'][name='billing_address_1']").focusin(function () {
               billing_address_1_api = $(this).val();
            });

            $("form[name='checkout'] select[name='billing_country']").change(function () {
                var current_country = $(this).val();
                if (__upsMapShipping.allowCountries) {
                    var check_country = __upsMapShipping.allowCountries.indexOf(current_country);
                    if (check_country > -1 || __upsMapShipping.allowCountries.length == 0) {
                        __upsMapShipping.func.checkout_load_ups_shipping();
                    }
                }
            });

            $("form[name='checkout'] select[name='billing_state']").change(function () {
                var current_country = $('#billing_country').val();
                if (__upsMapShipping.allowCountries) {
                    var check_country = __upsMapShipping.allowCountries.indexOf(current_country);
                    if (check_country > -1 || __upsMapShipping.allowCountries.length == 0) {
                        __upsMapShipping.func.checkout_load_ups_shipping();
                    }
                }
            });

            $("form[name='checkout'] input[type='text'][name='billing_city']").focusout(function () {
                if ($(this).val() != billing_city_api) {
                    var current_country = $('#billing_country').val();
                    if (__upsMapShipping.allowCountries) {
                        var check_country = __upsMapShipping.allowCountries.indexOf(current_country);
                        if (check_country > -1 || __upsMapShipping.allowCountries.length == 0) {
                            __upsMapShipping.func.checkout_load_ups_shipping();
                        }
                    }
                }
            });
            $("form[name='checkout'] input[type='text'][name='billing_city']").focusin(function () {
                billing_city_api = $(this).val();
            });

            $("form[name='checkout'] input[type='text'][name='billing_postcode']").focusout(function () {
                if ($(this).val() != billing_postcode_api) {
                    var current_country = $('#billing_country').val();
                    if (__upsMapShipping.allowCountries) {
                        var check_country = __upsMapShipping.allowCountries.indexOf(current_country);
                        if (check_country > -1 || __upsMapShipping.allowCountries.length == 0) {
                            __upsMapShipping.func.checkout_load_ups_shipping();
                        }
                    }
                }
            });
            $("form[name='checkout'] input[type='text'][name='billing_postcode']").focusin(function () {
                billing_postcode_api = $(this).val();
            });

            /*---------------------THE END----------------------------------------------------*/
            $('form[name="checkout"] [name="woocommerce_checkout_place_order"]').click( function (e) {
                var stop_form = false;
                if (__upsMapShipping.selectedRadioChecked != 0 || ($("ul#shipping_method li label").html().trim() == __upsMapShipping.ups_shipping && __upsMapShipping.checkShowUPS)) {
                    if (__upsMapShipping.selected_shipping_service === true) {
                        return true;
                    } else {
                        if (!$(".show_bing_map_container").is(":hidden") && !$(".ups_eu_woocommerce_container").is(":hidden")) {
                            __upsMapShipping.func.update_show_error_search_locator(_javascript_ups_eu_woocommerce.lang.mes_error_selected || "");
                            return false;
                        }
                    }
                }
                $("ul#shipping_method li input").each(function () {
                    var value     = $(this).attr("value");
                    var ups_checked     = ($(this).prop("checked") || ($("ul#shipping_method li label").html().trim() == __upsMapShipping.ups_shipping));
                    var arrValue  = value.split(":");
                    if (arrValue[0] == 'ups_eu_shipping' && ups_checked && !$(".show_bing_map_container").is(":hidden") && !__upsMapShipping.selected_shipping_service && !$(".ups_eu_woocommerce_container").is(":hidden")) {
                        $('.woocommerce-NoticeGroup').remove();
                        $('form[name="checkout"]').prepend('<div class="woocommerce-NoticeGroup woocommerce-NoticeGroup-checkout"><ul class="woocommerce-error" role="alert"><li>No shipping method has been selected. Please double check your address, or contact us if you need any help.</li></ul></div>');
                        $('html,body').animate({
                            scrollTop: $(".woocommerce").offset().top
                        }, 'slow');
                        stop_form = true;
                        return false;
                    }
                });
                if (stop_form) {
                    e.preventDefault();
                    return false;
                }
            });

            window.__upsMapShipping = __upsMapShipping;
            window.GetMap = __upsMapShipping.func.GetMap;
            __upsMapShipping.func.loadmap();
            jQuery(document.body).on('updated_checkout', function () {
                __upsMapShipping.selectedRadioChecked = 0;
                if (!__upsMapShipping.checkShowUPS) {
                    $("ul#shipping_method li input").each(function () {
                        var value     = $(this).attr("value");
                        var arrValue  = value.split(":");
                        if (arrValue[0] == 'ups_eu_shipping' || ($("ul#shipping_method li label").html() == __upsMapShipping.ups_shipping)) {
                            $(this).parent().hide();
                        }
                    });
                } else {
                    $("ul#shipping_method li").show();
                }
                $("ul#shipping_method li input[type='radio']").each(function () {
                    var id = $(this).attr("id") || "";
                    var value = $(this).attr("value") || "";
                    if (id.indexOf("_ups_eu_shipping") > 0) {
                        if ($(this).prop("checked")) {
                            __upsMapShipping.selectedRadioChecked = value.replace(":", "_");
                            __upsMapShipping.func.checkout_load_ups_shipping();
                            return false;
                        }
                    } else {
                        //$(".show_bing_map_container").hide();
                        $(".ups_eu_woocommerce_container").hide();
                    }
                });
                if ($("input[type='hidden'][class='shipping_method']")) {
                    var id = $("input[type='hidden'][class='shipping_method']").attr("id") || "";
                    var value = $("input[type='hidden'][class='shipping_method']").val() || "";
                    if (("__" + value).indexOf("ups_eu_shipping:") > 0 && hidden_repeat_one == 0) {
                        __upsMapShipping.selectedRadioChecked = value.replace(":", "_");
                        hidden_repeat_one += 1;
                        __upsMapShipping.func.checkout_load_ups_shipping();
                        return;
                    }
                    if (hidden_repeat_one > 0 && __upsMapShipping.checkShowUPS == true) {
                        $(".ups_eu_woocommerce_container").show();
                    }
                }
                if (__upsMapShipping.check_show_load_first === false && __upsMapShipping.checkShowUPS == false) {
                    $("table.table_ups_shipping_options").parent().hide();
                }
            });
        });
        
    })(jQuery);
    //--></script>