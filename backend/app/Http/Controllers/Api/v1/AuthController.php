<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\Api\v1\Auth\LoginRequest;

class AuthController
{
    public function login(LoginRequest $request)
    {
        if (!auth()->attempt($request->validated())) {
            return response()->json([
                'message' => 'Неверный логин или пароль.',
            ], 401);
        }

        $user = $request->user();
        $user->tokens()->delete();

        return response()->json([
            'access_token' => $user->createToken('auth_token')->plainTextToken,
            'token_type' => 'Bearer',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ],
        ]);
    }
}
