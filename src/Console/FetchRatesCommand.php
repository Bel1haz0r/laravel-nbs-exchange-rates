<?php

namespace JustPhoenix\LaravelNbsExchangeRates\Console;

use Illuminate\Console\Command;
use JustPhoenix\NbsExchangeRates\Enum\RateType;
use JustPhoenix\NbsExchangeRates\NbsClient;
use JustPhoenix\LaravelNbsExchangeRates\Models\ExchangeRate;

final class FetchRatesCommand extends Command
{
    protected $signature = 'nbs:rates:fetch {--date=} {--type=middle} {--store=1}';
    protected $description = 'Fetch NBS exchange rates (optionally store in DB).';

    public function handle(NbsClient $client): int
    {
        $type = match (strtolower((string)$this->option('type'))) {
            'middle' => RateType::MIDDLE,
            'effective' => RateType::EFFECTIVE,
            default => RateType::MIDDLE,
        };

        $dateOpt = $this->option('date');
        if ($dateOpt) {
            $date = new \DateTimeImmutable((string)$dateOpt);
            $list = $client->getByDate($date, $type);
        } else {
            $list = $client->getCurrent($type);
        }

        $this->info("Date: ".$list->date->format('Y-m-d')." | rates: ".count($list->rates));

        if ((int)$this->option('store') === 1) {
            foreach ($list->rates as $r) {
                ExchangeRate::updateOrCreate(
                    ['rate_date' => $list->date->format('Y-m-d'), 'currency' => $r->currencyCode],
                    ['unit' => $r->unit, 'middle' => $r->middle, 'buying' => $r->buying, 'selling' => $r->selling]
                );
            }
            $this->info("Stored/updated.");
        }

        return self::SUCCESS;
    }
}
