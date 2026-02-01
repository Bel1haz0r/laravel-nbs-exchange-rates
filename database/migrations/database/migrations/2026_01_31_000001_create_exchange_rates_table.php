<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('exchange_rates', function (Blueprint $table) {
            $table->id();
            $table->date('rate_date')->index();
            $table->string('currency', 3)->index();
            $table->unsignedSmallInteger('unit')->default(1);

            // store as string decimals to avoid float issues
            $table->string('middle', 32)->nullable();
            $table->string('buying', 32)->nullable();
            $table->string('selling', 32)->nullable();

            $table->timestamps();

            $table->unique(['rate_date', 'currency'], 'exchange_rates_date_currency_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exchange_rates');
    }
};
