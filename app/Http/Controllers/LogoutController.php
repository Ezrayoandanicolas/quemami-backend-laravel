<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

class LogoutController extends Controller
{
    public function logout(Request $request) {
        try {
            // Get bearer token from the request
            $accessToken = $request->bearerToken();

            // Get access token from database
            $token = PersonalAccessToken::findToken($accessToken);

            // Revoke token
            $token->delete();

            $response = [
                'status' => true,
                'type' => 'success',
                'data' => 'Berhasil Logout!',
            ];
            return response()->json($response, 200);
        } catch (Throwable $e) {
            return response()->json([
                'status' => false,
                'type' => 'error',
                'data' => $e->getMessate(),
            ], 500);
        }
    }
}
