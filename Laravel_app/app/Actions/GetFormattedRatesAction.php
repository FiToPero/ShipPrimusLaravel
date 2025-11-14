<?php

namespace App\Actions;

use Lorisleiva\Actions\Concerns\AsAction;

class GetFormattedRatesAction
{
    use AsAction;

    public function handle($response)
    {
        $formatted = array_map(function ($result) {
            return [
                "CARRIER" => $result['name'],
                "SERVICE LEVEL" => $result['serviceLevel'],
                "RATE TYPE" => $result['rateType'],
                "TOTAL" => $result['total'],
                "TRANSIT TIME" => $result['transitDays']
            ];
        }, $response);

        return $formatted;
    }
}
