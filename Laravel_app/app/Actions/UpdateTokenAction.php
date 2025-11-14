<?php

namespace App\Actions;

use Lorisleiva\Actions\Concerns\AsAction;

class UpdateTokenAction
{
    use AsAction;

    public function handle($token, $body)
    {
        $tokenData = decodeJWT($token);

        Token::update()([
            'access_token' => $token,
            'issued_at' => $tokenData['issued_at'],
            'expiration' => $tokenData['expiration'],
        ])->where('username', '=', $body['username']);
    }
}
