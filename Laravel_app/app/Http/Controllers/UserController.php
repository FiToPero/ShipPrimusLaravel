<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Http;
use App\Models\Token;
use App\Actions\CreateTokenAction;
use App\Actions\RefreshTokenAction;

class UserController extends Controller
{
    public function getToken(UserRequest $request)
    {
        $body = $request->validated();
    

        $response = Http::post('https://sandbox-api.shipprimus.com/api/v1/login', $body);

        $token = $response->json('data.accessToken');
        
        $tokenData = decodeJWT($token);

        if(validateToken($tokenData['expiration'])) {
            CreateTokenAction::run($body, $token, $tokenData);
        } else {
            RefreshTokenAction::run($token, $body);
        }


        return response()->json($tokenData);
    }


}
