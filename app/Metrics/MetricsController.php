<?php

namespace App\Metrics;

use Prometheus\RenderTextFormat;

class MetricsController
{
    public function __invoke()
    {
        $formatter = new RenderTextFormat();
        return response(
            $formatter->render(Prometheus::getMetricFamilySamples()),
            200,
            ['Content-Type' => RenderTextFormat::MIME_TYPE]
        );
    }
}
