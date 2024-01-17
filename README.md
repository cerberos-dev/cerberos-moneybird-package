# Moneybird PHP Clien

PHP Client for the [Moneybird API](https://developer.moneybird.com/). This client lets you integrate with Moneybird, for example by:

- Creating and sending invoices
- Creating and updating contact
- Uploading incoming invoices of purchases
- Create manual journal bookings

## Usage

You need to have to following credentials and information ready. You can get this from your Moneybird account.

- Client ID
- Client Secret
- Callback URL

You need to be able to store some data locally:

- The three credentials mentioned above
- Authorizationcode
- Accesstoken

### Authorization code

If you have no authorization code yet, you will need this first. The client supports fetching the authorization code as follows.

```php
<?php

require __DIR__ . '/vendor/autoload.php';

$connection = new \Cerberos\Financials\Moneybird\Connection();
$connection->setRedirectUrl('REDIRECTURL');
$connection->setClientId('CLIENTID');
$connection->setClientSecret('CLIENTSECRET');
$connection->redirectForAuthorization();
```

This will perform a redirect to Moneybird at which you can login and authorize the app for a specific Moneybird administration.
After login, Moneybird will redirect you to the callback URL with request param "code" which you should save as the authorization code.

### Setting the administration ID

Most methods require you to set the Administration ID to fetch the correct data. You can get the Administration ID from the URL at MoneyBird, but you can also list the administrations your user has access to running the following method after connecting. In the code samples below there's an example on how to set the first administrations from the results of the call below:

```php
$administrations = $moneybird->administration()->getAll();
```
