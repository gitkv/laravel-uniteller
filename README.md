Laravel Uniteller
===================

[![Build Status](https://travis-ci.org/tmconsulting/uniteller-php-sdk.svg?branch=0.2.0)](https://travis-ci.org/tmconsulting/uniteller-php-sdk)

Laravel / Lumen package for integration with Uniteller payment processing.
The package is based on [tmconsulting/uniteller-php-sdk/](https://github.com/tmconsulting/uniteller-php-sdk/).

Requires:
* Laravel / Lumen >=5.5
* PHP >= 7.1
* tmconsulting/uniteller-php-sdk


Installation
------------
* Run:
```code
composer require "gitkv/laravel-uniteller"
```

Configuration
-------------
### Laravel:
Add service provider to /config/app.php:
```php
'providers' => [
    gitkv\Uniteller\LaravelServiceProvider::class
],
'aliases' => [
    'Uniteller' => gitkv\Uniteller\Facade\Uniteller::class,
],
```

Publish `config/uniteller.php`
```bash
php artisan vendor:publish --provider="gitkv\Uniteller\LaravelServiceProvider" --tag=config
```

### Lumen:
Register service provider to /bootstrap/app.php:
```php
$app->register(gitkv\Uniteller\LumenServiceProvider::class);
```

Copy config file `/vendor/gitkv/laravel-uniteller/config/uniteller.php` to `/config/app.php`
```bash
cp vendor/gitkv/laravel-uniteller/config/uniteller.php config/app.php
```


Usage
-----
#### Method "Pay":
```php
<?php
use gitkv\Uniteller\Facade\Uniteller;
use Tmconsulting\Uniteller\Payment\PaymentBuilder;

$builder = (new PaymentBuilder())
    ->setOrderIdp('invoice_number')
    ->setSubtotalP(10)
    ->setCustomerIdp('customer_id');

$redirectUrl = Uniteller::pay($builder);
```

or, if need redirect

```php
Uniteller::pay($builder, false);
```

#### Method "Recurrent Pay":
```php
<?php
use gitkv\Uniteller\Facade\Uniteller;
use Tmconsulting\Uniteller\Recurrent\RecurrentBuilder;

$builder = (new RecurrentBuilder())
    ->setOrderIdp(mt_rand(10000, 99999))
    ->setSubtotalP(15)
    ->setParentOrderIdp(00000) // order id of any past payment
    ->setParentShopIdp($uniteller->getShopId()); // optional

$result = Uniteller::recurrentPay($builder);
```

#### Method "Receive results":
```php
<?php
use gitkv\Uniteller\Facade\Uniteller;

$result = Uniteller::receiveResult($orderIdp);
```

#### Method "Cancel":
```php
<?php
use gitkv\Uniteller\Facade\Uniteller;
use Tmconsulting\Uniteller\Cancel\CancelBuilder;

$builder = (new CancelBuilder())->setBillNumber('RRN Number, (12 digits)');
$result = Uniteller::cancel($builder);
```

#### Method "Verify Signature":
```php
<?php
use gitkv\Uniteller\Facade\Uniteller;

if (! Uniteller::verifySignature('signature_from_post_params', ['all_parameters_from_post'])) {
    return 'invalid_signature';
}
```

#### Callback event:
The package determines the default routing for processing the order status change.
Default: `[APP_URL]/uniteller/callback`
You need to specify this router in the settings of the billing uniteller.

If the order is successfully paid, the uniteller will make a POST request to your application.
The query data will be validated (`Uniteller::verifySignature`), and upon success the event `gitkv\Uniteller\Events\UnitellerCallbackEvent`
You only need to create an event listener and change the order status in your application.

`UnitellerCallbackListener.php`:
```php
<?php
namespace App\Listeners;


use gitkv\Uniteller\Events\UnitellerCallbackEvent;

class UnitellerCallbackListener {

    public function __construct() {
        //
    }

    public function handle(UnitellerCallbackEvent $event) {
        $payload = $event->getPayload();
        
        //your code here...
    }
}
```
