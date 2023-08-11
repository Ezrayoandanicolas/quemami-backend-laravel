<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Stmt\Catch_;
use Validator;

class LoginController extends Controller
{
    public function login(Request $request) {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required|min:8',
            ]);

            if($validator->fails()) {
                $response = [
                    'status' => false,
                    'type' => 'error',
                    'data' => $validator->errors(),
                ];

                return response()->json($response, 200);
            }

            if (!Auth::attempt($request->only(['email', 'password']))) {
                return response()->json([
                    'status' => false,
                    'type' => 'error',
                    'data' => 'Email & password does not match with out record.',
                ], 401);
            }

            $user = User::where('email', $request->email)->first();

            return response()->json([
                'status' => true,
                'type' => 'success',
                'token' => $user->createToken('API E-Kasir')->plainTextToken
            ], 200);
        } catch (Throwable $e) {
            return response()->json([
                'status' => false,
                'type' => 'error',
                'data' => $e->getMessate(),
            ], 500);
        }
    }
}
