<?php

namespace App\Metrics;

use Illuminate\Support\Facades\Facade;
use Prometheus\CollectorRegistry;

class Prometheus extends Facade
{
    protected static function getFacadeAccessor()
    {
        return CollectorRegistry::class;
    }
}
