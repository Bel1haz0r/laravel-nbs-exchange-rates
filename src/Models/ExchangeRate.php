<?php

namespace JustPhoenix\LaravelNbsExchangeRates\Models;

use Illuminate\Database\Eloquent\Model;

final class ExchangeRate extends Model
{
    protected $table = 'exchange_rates';

    protected $fillable = [
        'rate_date','currency','unit','middle','buying','selling'
    ];

    protected $casts = [
        'rate_date' => 'date',
    ];
}
