{if $dataObject->account_name}
    <b>{stripslashes($dataObject->account_name|escape:'htmlall':'UTF-8')}</b><br>
{/if}
{if $dataObject->address_1}
    {stripslashes($dataObject->address_1|escape:'htmlall':'UTF-8')}<br>
{/if}
{if $dataObject->address_2}
    {stripslashes($dataObject->address_2|escape:'htmlall':'UTF-8')}<br>
{/if}
{if $dataObject->address_3}
    {stripslashes($dataObject->address_3|escape:'htmlall':'UTF-8')}<br>
{/if}
{if $dataObject->city}
    {stripslashes($dataObject->city|escape:'htmlall':'UTF-8')}<br>
{/if}
{if $dataObject->postal_code}
    {stripslashes($dataObject->postal_code|escape:'htmlall':'UTF-8')}<br>
{/if}
{if $dataObject->country}
    {stripslashes($dataObject->country|escape:'htmlall':'UTF-8')}<br>
{/if}
{if $dataObject->phone_number}
    {stripslashes($dataObject->phone_number|escape:'htmlall':'UTF-8')}
{/if}
