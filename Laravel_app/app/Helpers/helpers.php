<?php

if (!function_exists('getCheapestRatesByServiceLevel')) {
    function getCheapestRatesByServiceLevel(array $formattedResponse): array
    {
        //Here we will store the minimum for each serviceLevel. 
        $cheapest = [];

        foreach ($formattedResponse as $item) {

            // The grouping key
            $serviceLevel = $item['SERVICE LEVEL'];

            // If we haven't saved any for that serviceLevel yet, save it
            if (!isset($cheapest[$serviceLevel])) {
                $cheapest[$serviceLevel] = $item;
                continue;
            }

            // If we find a lower total, replace it
            if ($item['TOTAL'] < $cheapest[$serviceLevel]['TOTAL']) {
                $cheapest[$serviceLevel] = $item;
            }
        }

        return array_values($cheapest);
    }
}

if (!function_exists('decodeJWT')) {
    function decodeJWT(string $token): array
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
        
        return [
            'issued_at' => $issuedAt,
            'jti' => $jti,
            'issuer' => $issuer,
            'expiration' => $expiration,
            'legacy' => $legacy,
        ];
    }
}

if (!function_exists('validateToken')) {
    function validateToken(?int $expiration): bool
    {
        $currentTime = time();
        $resp = $expiration > $currentTime;
        return $resp;
    }
}