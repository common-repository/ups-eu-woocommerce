<div class="card-body" id="container_focus_show">
    <form method="POST" action="{$dataObject->action_form}">
        <h6>{$dataObject->lang["describe1"]}</h6>
        <p class="text-muted ml-2">{$dataObject->lang["describe2"]}</p>

        <h6 class="mt-3">{$dataObject->lang["describe3"]}</h6>
        <div class="ml-2">
            <p class="text-muted">{$dataObject->lang["describe4"]}</p>

            <a type="submit" class="button button-primary" href="https://www.ups.com/dropoff" target="_blank"><b>{$dataObject->lang["describe5"]}</b></a>

        </div>        

        <div class="ml-2 mt-3">
            <p class="text-muted">{$dataObject->lang["describe7"]}</p>
            {if $dataObject->lang["checkShowButton"] == 'PL'}
                <a type="submit" class="button button-primary" href="{$dataObject->plugin_url_ups}/uploads/config/PickUpRegistration{$dataObject->language}.pdf" target="_blank"><b>{$dataObject->lang["PrintForm"]}</b></a>
            {/if}
        </div>     

        <div class="ml-2 mt-3">
            <p class="text-muted">{$dataObject->lang["describe14"]}</p>
            {if $dataObject->lang["checkShowButton"] == 'PL'}
                <a type="submit" class="button button-primary" href="{$dataObject->plugin_url_ups}/uploads/config/CODRegistration{$dataObject->language}.pdf" target="_blank""><b>{$dataObject->lang["PrintForm"]}</b></a>
            {/if}
        </div>
        <h6>{$dataObject->lang["describe15"]}</h6>
        
        <p class="text-muted ml-2">{$dataObject->lang["describe16"]}        
        <p class="text-muted ml-2">{$dataObject->lang["describe17"]}</p>
        </form>
    </form>
</div>