<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Token;

class UserController extends Controller
{
    public function getToken()
    {
        $body = [
            'username' => 'testDemo',
            'password' => '1234',
        ];

        $response = Http::post('https://sandbox-api.shipprimus.com/api/v1/login', $body);

        $token = $response->json('data.accessToken');
        
        $tokenData = $this->decodeJWT($token);

        Token::create([
            'access_token' => $token,
            'issued_at' => $tokenData['issued_at'],
            'expiration' => $tokenData['expiration'],
            'is_valid' => $tokenData['expiration_valid'],
        ]);

        return response()->json($tokenData);
    }
    
    public function decodeJWT(string $token): array
    {
        $parts = explode('.', $token);
        
        if (count($parts) !== 3) {
            return ['error' => 'Invalid JWT format'];
        }
          
        // payload
        $payload = json_decode(base64_decode($parts[1]), true);
        
        $issuedAt = $payload['iat'] ?? null;
        $jti = $payload['jti'] ?? null;
        $issuer = $payload['iss'] ?? null;
        $expiration = $payload['exp'] ?? null;
        $legacy = $payload['legacy'] ?? null;

        $expirationValid = $this->validateToken($expiration);
        
        return [
            'issued_at' => $issuedAt,
            'jti' => $jti,
            'issuer' => $issuer,
            'expiration' => $expiration,
            'legacy' => $legacy,
            'expiration_valid' => $expirationValid,
        ];
    }

    public function validateToken(int $expiration): bool
    {
        $currentTime = time();
        $resp = $expiration > $currentTime;
        return $resp;
    }


}
