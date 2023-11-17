<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    # Membuat fitur Register
    public function register(Request $request)
    {

        // memvalidasi inputan
        $validated = $request->validate([
            "name" => "required",
            "email" => "required|email",
            "password" => "required"
        ]);

        $input = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password'])

        ];

        # Menginsert data ke table user
        $user = User::create($input);
        $data = [
            'message' => 'User is created successfully'
        ];
        # Mengirim response JSON|
        return response()->json($data, 201);
    }

    # Membuat fitur Login
    public function login(Request $request)
    {
        # Menangkap input user
        $input = [
            'email' => $request->email,
            'password' => $request->password
        ];
        # Melakukan autentikasi

        if (Auth::attempt($input)) {
            # Membuat token
            $token = Auth::user()->createToken('auth_token');
            $data = [
                'message' => 'Login successfully',
                'token' => $token->plainTextToken
            ];
            # Mengembalikan response JSON
            return response()->json($data, 200);
        } else {
            $data = [
                'message' => 'Username or Password is wrong'
            ];
            return response()->json($data, 401);
        }
    }
}
