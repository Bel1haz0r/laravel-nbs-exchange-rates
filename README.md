
# Laravel NBS Exchange Rates Wrapper

Laravel integration layer for `yourvendor/nbs-exchange-rates`.

Adds:

- Service Provider
- Config file
- Artisan command
- Optional database migration
- Eloquent model

---

## Requirements

- Laravel 10+
- PHP 8.1+
- ext-soap

---

## Installation
Add private repository
```bash
composer config --global repositories.justphoenix composer https://packages.justphoenix.io
```

Install the package
```bash
composer require justphoenix/laravel-nbs-exchange-rates
```
## Publish configuration
```php
php artisan vendor:publish --tag=nbs-exchange-rates-config
```

## Run migration
```php
php artisan migrate
```

## .env file
```php
NBS_WSDL=https://webservices.nbs.rs/CommunicationOfficeService1_0/ExchangeRateXmlService.asmx?WSDL
NBS_USER=<your username>
NBS_PASS=<your password>
```

## Usage
```php
use YourVendor\NbsExchangeRates\NbsClient;

public function handle(NbsClient $client)
{
$rates = $client->getCurrent();
}
```

## Artisan commands
```php
php artisan nbs:rates:fetch
```
For a specific date:
```php
php artisan nbs:rates:fetch --date=2026-01-01
```
Fetch and store in DB:
```php
php artisan nbs:rates:fetch --store=1
```

## Scheduling (Recommended)
```php
$schedule->command('nbs:rates:fetch --store=1')->dailyAt('08:15');
```