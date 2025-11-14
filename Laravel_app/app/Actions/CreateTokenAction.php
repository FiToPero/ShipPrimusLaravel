<?php

namespace App\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use App\Models\Token;

class CreateTokenAction
{
    use AsAction;

    public function handle($body, $token, $tokenData)
    {
        Token::create([
            'username' => $body['username'],
            'password' => $body['password'],
            'access_token' => $token,
            'issued_at' => $tokenData['issued_at'],
            'expiration' => $tokenData['expiration'],
        ]);
    }
}
