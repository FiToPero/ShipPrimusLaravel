<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Token;

class RateController extends Controller
{
    public function getRates()
    {
        $username = 'testDemo';
        $token = Token::where('username', '=', $username)->value('access_token');

        $params = [
            'originCity' => 'KEY LARGO',
            'originState' => 'FL',
            'originZipcode' => '33037',
            'originCountry' => 'US',
            'destinationCity' => 'LOS ANGELES',
            'destinationState' => 'CA',
            'destinationZipcode' => '90001',
            'destinationCountry' => 'US',
            'UOM' => 'US',
            'freightInfo' => json_encode([
                [
                    'qty' => 1,
                    'weight' => 100,
                    'weightType' => 'each',
                    'length' => 40,
                    'width' => 40,
                    'height' => 40,
                    'class' => 100,
                    'hazmat' => 0,
                    'commodity' => '',
                    'dimType' => 'PLT',
                    'stack' => false
                ]
            ])
        ];

        $response = Http::withToken($token)
            ->get('https://sandbox-api.shipprimus.com/api/v1/database/vendor/contract/'.env('VENDOR_ID').'/rate', $params);


        $formattedResponse = array_map(function ($result) {
            return [
                "CARRIER" => $result['name'],
                "SERVICE LEVEL" => $result['serviceLevel'],
                "RATE TYPE" => $result['rateType'],
                "TOTAL" => $result['total'],
                "TRANSIT TIME" => $result['transitDays']
            ];
        }, $response['data']['results']);


        return response()->json($formattedResponse);
    }

    public function getRatesMinimum()
    {
        $username = 'testDemo';
        $token = Token::where('username', '=', $username)->value('access_token');

        $params = [
            'originCity' => 'KEY LARGO',
            'originState' => 'FL',
            'originZipcode' => '33037',
            'originCountry' => 'US',
            'destinationCity' => 'LOS ANGELES',
            'destinationState' => 'CA',
            'destinationZipcode' => '90001',
            'destinationCountry' => 'US',
            'UOM' => 'US',
            'freightInfo' => json_encode([
                [
                    'qty' => 1,
                    'weight' => 100,
                    'weightType' => 'each',
                    'length' => 40,
                    'width' => 40,
                    'height' => 40,
                    'class' => 100,
                    'hazmat' => 0,
                    'commodity' => '',
                    'dimType' => 'PLT',
                    'stack' => false
                ]
            ])
        ];

        $response = Http::withToken($token)
            ->get('https://sandbox-api.shipprimus.com/api/v1/database/vendor/contract/'.env('VENDOR_ID').'/rate', $params);


        $formattedResponse = array_map(function ($result) {
            return [
                "CARRIER" => $result['name'],
                "SERVICE LEVEL" => $result['serviceLevel'],
                "RATE TYPE" => $result['rateType'],
                "TOTAL" => $result['total'],
                "TRANSIT TIME" => $result['transitDays']
            ];
        }, $response['data']['results']);

        $cheapestRates = $this->getCheapestRatesByServiceLevel($formattedResponse);

        return response()->json($cheapestRates);
    }
        

    private function getCheapestRatesByServiceLevel(array $formattedResponse)
    {
            // Aquí almacenaremos el mínimo por cada serviceLevel
        $cheapest = [];

        foreach ($formattedResponse as $item) {

            // La clave de agrupación
            $serviceLevel = $item['SERVICE LEVEL'];

            // Si aún no guardamos ninguno para ese serviceLevel, lo guardamos
            if (!isset($cheapest[$serviceLevel])) {
                $cheapest[$serviceLevel] = $item;
                continue;
            }

            // Si encontramos un total más bajo, reemplazamos
            if ($item['TOTAL'] < $cheapest[$serviceLevel]['TOTAL']) {
                $cheapest[$serviceLevel] = $item;
            }
        }

        return array_values($cheapest);
    
    }



}
