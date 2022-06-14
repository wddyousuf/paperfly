# wddyousuf/paperfly
## _a package for Paperfly Courier Integration for Laravel Developer._

## Installation

```sh
composer require wddyousuf/paperfly
php artisan vendor:publish --provider=Wddyousuf\Paperfly\PaperflyServiceProvider
php artisan config:cache
```
This will create a courier.php in the config/ directory. Set your desired provider as default_provider and fill up the necessary environment variable of that provider.
