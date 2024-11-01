{include file='admin/merchant_cf/common/header.tpl'}
<div class="ups-full-width">
    <!-- <h5 class="card-header">UPS Terms and Conditions</h5> -->
    <div class="accordion" id="accordion-shipping-config">
        <!-- ACCOUNT -->
        <div class="ups-config ups-default-border ups-config-account current-step" data-target="#collapse-account">
            <div class="card-header title-tab p-0" id="heading-account">
                <h5 class="mb-0 _upsTitle">
                    <table>
                        <tr>
                            <td>
                                {$dataObject->lang["title_about_logs_api"]}
                            </td>
                        </tr>
                    </table>
                </h5>
            </div>
            <div id="collapse-account" class="show" aria-labelledby="heading-account" data-parent="#accordion-shipping-config">
                <div class="card-body">
                    <div class="heder_about_page">
                        <div class="col-md-12">
                            <h2>{$dataObject->lang["version_title"]}</h2>
                            <ul>
                                <li>
                                    <span>{$dataObject->lang["plugin_version"]}</span><br/>
                                </li>
                                <li>
                                    <span>{$dataObject->lang["plugin_release_date"]}</span><br/>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-12">
                            <h2>{$dataObject->lang["changelog"]}</h2>
                            <ul>
                                <li>
                                    <span>
                                        {$dataObject->lang["minor_bug_fixes"]}
                                    </span>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-12">
                            <h2>{$dataObject->lang["platfrom_capatibility"]}</h2>
                            <ul>
                                <li>
                                    <span>{$dataObject->lang["compatible"]}</span>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-12">
                            <h2>{$dataObject->lang["back_link"]}</h2>
                            <ul>
                                <li>
                                    <span>
                                        {$dataObject->urlSupport}
                                    </span>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-12">
                            <h2>{$dataObject->lang["Support_information"]}</h2>
                            <ul>
                                <li>
                                    <span>{$dataObject->lang["Support_information_1"]}</span>
                                    <ul class="ul_dot">
                                    {$dataObject->lang["Support_information_2"]}
                                    </ul>
                                </li>
                            </ul>

                        </div>
                        <div class="col-md-12">
                            <form method="POST">
                                <h2>{$dataObject->lang["dwnld_log"]}</h2>
                                <ul>
                                    <li>
                                        <span>{$dataObject->lang["dwnld_info"]}</span>
                                        &nbsp <button type="submit" name="downloadlog" id="download" class="btn btn-primary ">Download Log</button>
                                    </li>
                                </ul>
                            </form>
                        </div>
                    </div>
                    <style>
                        ul.ul_dot li{
                            list-style-type: disc;
                            margin-left: 15px;
                        }
                    </style>
                    <br/>
                </div>
            </div>
        </div>
    </div>
</div>

{include file='admin/merchant_cf/common/footer.tpl'}
<style type="text/css">
    .accordion .ups-config .collapse{
        border-top: 1px solid rgba(0,0,0,.125);
    }
    .accordion .ups-config{
        margin-bottom: 10px;
    }
</style>
