{if $dataObject->name}
    {stripslashes($dataObject->name|escape:'htmlall':'UTF-8')}<br>
{/if}
{if $dataObject->address1}
    {stripslashes($dataObject->address1|escape:'htmlall':'UTF-8')}<br>
{/if}
{if $dataObject->address2}
    {stripslashes($dataObject->address2|escape:'htmlall':'UTF-8')}<br>
{/if}
{if $dataObject->address3}
    {stripslashes($dataObject->address3|escape:'htmlall':'UTF-8')}<br>
{/if}
{if $dataObject->city}
    {stripslashes($dataObject->city|escape:'htmlall':'UTF-8')}<br>
{/if}
{if $dataObject->state}
    {stripslashes($dataObject->state|escape:'htmlall':'UTF-8')},
{/if}
{if $dataObject->postcode}
    {stripslashes($dataObject->postcode|escape:'htmlall':'UTF-8')}<br>
{/if}
{if $dataObject->country}
    {stripslashes($dataObject->country|escape:'htmlall':'UTF-8')}
{/if}
