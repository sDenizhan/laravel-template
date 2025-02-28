<?php

namespace App\Listeners;

use App\Events\CountryCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CountryCreatedListener
{
    public function handle(CountryCreated $event): void
    {

    }

    public function createLog(CountryCreated $event)
    {

    }
}
