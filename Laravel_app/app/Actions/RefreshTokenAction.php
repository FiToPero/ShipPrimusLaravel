<?php

namespace App\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use App\Actions\UpdateTokenAction;

class RefreshTokenAction
{
    use AsAction;

    public function handle($oldToken)
    {
        $body = [
            'token' => $oldToken,
        ];
        $response = Http::post('https://sandbox-api.shipprimus.com/api/v1/refreshtoken', $body);

        UpdateTokenAction::run($response->json('data.accessToken'), $body);
        
    }
}
