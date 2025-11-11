<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{
    public function getToken()
    {
        $body = [
            'username' => 'testDemo',
            'password' => '1234',
        ];

        $response = Http::post('https://sandbox-api.shipprimus.com/api/v1/login', $body);

        // Guardar la respuesta en variables
        $status = $response->status();
        $responseJson = null;
        try {
            $responseJson = $response->json();
        } catch (\Exception $e) {
            $responseJson = ['raw' => $response->body()];
        }

        return response()->json([
            'request_body' => $body,
            'status' => $status,
            'response' => $responseJson,
        ]);
    }
}
