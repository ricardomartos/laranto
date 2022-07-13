<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Method for logging in a user.
     *
     * @param Request $request
     * @return JsonResponse
     *
     */
    public function login(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'status', false,
                'message' => 'Unauthorized',
                'data' => ''
            ], 401);
        }

        // delete all previous tokens
        $request->user()->tokens()->delete();

        // gets token that need to be submitted in header
        $token = $request->user()->createToken('token')->plainTextToken;

        return response()->json([
            'status' => true,
            'message' => 'Token',
            'data' => $token,
        ]);

    }
}
