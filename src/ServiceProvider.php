<?php

namespace JustPhoenix\LaravelNbsExchangeRates;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use JustPhoenix\NbsExchangeRates\Driver\SoapXmlDriver;
use JustPhoenix\NbsExchangeRates\NbsClient;

final class ServiceProvider extends BaseServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/nbs-exchange-rates.php', 'nbs-exchange-rates');

        $this->app->singleton(NbsClient::class, function () {
            $cfg = config('nbs-exchange-rates');

            // only soap-xml implemented here; easy to add more
            $options = $cfg['soap']['options'] ?? [];
            if (!empty($cfg['soap']['wsdl'])) {
                $options['wsdl'] = $cfg['soap']['wsdl'];
            }

            return new NbsClient(new SoapXmlDriver($options));
        });
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/nbs-exchange-rates.php' => config_path('nbs-exchange-rates.php'),
        ], 'nbs-exchange-rates-config');

        $this->publishes([
            __DIR__.'/../database/migrations/2026_01_31_000001_create_exchange_rates_table.php' =>
                database_path('migrations/2026_01_31_000001_create_exchange_rates_table.php'),
        ], 'nbs-exchange-rates-migrations');

        if ($this->app->runningInConsole()) {
            $this->commands([
                Console\FetchRatesCommand::class,
            ]);
        }
    }
}
