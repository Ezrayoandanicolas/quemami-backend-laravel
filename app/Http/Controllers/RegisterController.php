<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Stmt\Catch_;
use Validator;

class RegisterController extends Controller
{
    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|string',
            'email' => 'required|email',
            'password' => 'required|min:8',
            'c_password' => 'required|same:password',
        ]);

        if($validator->fails()) {
            $response = [
                'status' => false,
                'type' => 'error',
                'data' => $validator->errors(),
            ];

            return response()->json($response, 200);
        }

        $data = $request->all();
        $data['password'] = bcrypt($data['password']);

        try {
            // Create Users
            $user = User::create($data);
            $msg = [
                'status' => true,
                'type' => 'success',
                'data' => $user
            ];

            return response()->json($msg, 200);
        } Catch (Throwable $e) {
            $msg = [
                'status' => false,
                'type' => 'error',
                'data' => $e
            ];

            return response()->json($msg, 200);
        }
    }
}
