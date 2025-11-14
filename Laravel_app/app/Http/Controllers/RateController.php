<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Token;
use App\Actions\GetFormattedRatesAction;

class RateController extends Controller
{
    public function getRates(Request $request)
    {
        $token = Token::where('username', '=', $request->username)->value('access_token');

      
        $response = Http::withToken($token)
            ->get('https://sandbox-api.shipprimus.com/api/v1/database/vendor/contract/'.env('VENDOR_ID').'/rate', $request->params);


        $formattedResponse = GetFormattedRatesAction::run($response['data']['results']);

        return response()->json($formattedResponse);
    }

    public function getRatesMinimum(Request $request)
    {
        $token = Token::where('username', '=', $request->username)->value('access_token');

        $response = Http::withToken($token)
            ->get('https://sandbox-api.shipprimus.com/api/v1/database/vendor/contract/'.env('VENDOR_ID').'/rate', $request->params);


        $formattedResponse = GetFormattedRatesAction::run($response['data']['results']);

        $cheapestRates = getCheapestRatesByServiceLevel($formattedResponse);

        return response()->json($cheapestRates);
    }
        

   



}
