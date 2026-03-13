<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function register(RegisterRequest $request): JsonResponse
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password
        ]);

        // $token = $user->createToken('auth_token')->plainTextToken;

        return $this->successResponse([
            'user' => $user,
            // 'access_token' => $token,
            // 'token_type' => 'Bearer',
        ], 'Utilisateur enregistré avec succès', 201);
    }

    public function login(Request $request)
    {
        $request->validate( [
            'email'    => 'required|email|string',
            'password' => 'required|string',
        ]);
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json('not working');
        }

        $token = $user->createToken('auth_token');

        // return $this->successResponse([
        //     'user' => $user,
        //     'access_token' => $token,
        //     'token_type' => 'Bearer',
        //     'status' => 'Connexion réussie'
        // ]);
        return response()->json([
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer',
            'status' => 'Connexion réussie'
        ]);
    }


    public function logout(Request $request): JsonResponse
    {

        $request->user()->currentAccessToken()->delete();

        return $this->successResponse(null, 'Déconnexion réussie');
    }

    public function me(Request $request): JsonResponse
    {
        return $this->successResponse($request->user(), 'Infos utilisateur récupérées');
    }
}
