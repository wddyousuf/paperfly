# wddyousuf/paperfly
## _a package for Paperfly Courier Integration for Laravel Developer._

## Step 1

```sh
composer require wddyousuf/paperfly
php artisan vendor:publish --provider=Wddyousuf\Paperfly\PaperflyServiceProvider
php artisan config:cache
```
This will create a courier.php in the config/ directory. Set your desired provider as default_provider and fill up the necessary environment variable of that provider.

## Step 2

Set .env configuration 
```sh
COURIER_USERNAME="XXXXXXXX"
COURIER_PASSWORD="XXXXXXXXXX"
COURIER_API_KEY="Paperfly_~La?Rj73FcLm"
COURIER_PROVIDER="PAPERFLY"
```

## Sample Code For Requesting a Pick Up

```sh
use Wddyousuf\Paperfly\Facades\PaperflyCourier;

$OrderInformation=[
    "OrderNo" => "111111",
    "MerchantName" => "Mr. X",
    "MerchantAddress" => "Test",
    "MerchantThana" => "Dhanmondi",
    "MerchantDistrict" => "Dhaka",
    "MerchantPhone" => "017xxxxx",
    "SizeWeight" => "standard",
    "productDetails" => "Usb Fan",
    "packagePrice" => "0",
    "deliveryType" => "regular",
    "CustomerName" => "Mr. Y",
    "CustomerAddress" => "Road 27, Dhanmondi",
    "CustomerThana" => "Adabor",
    "CustomerDistrict" => "Dhaka",
    "CustomerPhone" => "017xxxxx",
    "max_weight" => "10",
];
$response = PaperflyCourier::sendRequest($OrderInformation);

//Collect Thana list from paperfly
//Collect District list from paperfly
// max_weight is only for weight Enabled Pickup Request
//If Thana and District doesn't match with paperfly list,It will occur error
```

## Sample Code For Tracking an Order

```sh
use Wddyousuf\Paperfly\Facades\PaperflyCourier;

$orderId='XXXXXXX';
$response = PaperflyCourier::trackOrder($orderId);
```

## Sample Code For Invoice

```sh
use Wddyousuf\Paperfly\Facades\PaperflyCourier;

$orderId='XXXXXXX';
$response = PaperflyCourier::courierInvoice($orderId);
```

## Sample Code For Cancel Order

```sh
use Wddyousuf\Paperfly\Facades\PaperflyCourier;

$orderId='XXXXXXX';
$response = PaperflyCourier::CourierOrderCancel($orderId);
```

## License

MIT


If you feel something is missing then make a issue regarding that. Your can pull reques. If you want to contribute in this library, then you are highly welcome to do that....
