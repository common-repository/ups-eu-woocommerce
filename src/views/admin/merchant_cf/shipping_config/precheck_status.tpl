{include file='admin/merchant_cf/common/header.tpl'}
<div class="align-center" style="margin-top:40px;">
    <table class="grid-table js-grid-table table" align="center" style="width: 50%; border: 1px solid #FDD204;">
        <tr style="background-color: #FDD204;">
            <th>Settings</th>
            <th style="text-align:center;">Status</th>
        </tr>
        <tr>
            <td>SSL ON</td>
            <td align="center">{$dataObject->ssl}</td>
        </tr>
        <tr>
            <td>Maintenance mode OFF</td>
            <td align="center">{$dataObject->maintainance}</td>
        </tr>
        <tr>
            <td>https://fa-ecptools-prd.azurewebsites.net</td>
            <td align="center">{$dataObject->url1}</td>
        </tr>
        <tr>
            <td>https://onlinetools.ups.com/ </td>
            <td align="center">{$dataObject->url2}</td>
        </tr>
        <tr>
            <td>https://fa-ecpanalytics-prd.azurewebsites.net </td>
            <td align="center">{$dataObject->url3}</td>
        </tr>
    </table>
 </div>
{include file='admin/merchant_cf/common/footer.tpl'}