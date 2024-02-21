<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;

class AuthController extends Controller
{

    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        $validatedData['password'] = bcrypt($request->password);

        $user = User::create($validatedData);
        $user->save();

        $tokenObject = $user->createToken('authToken');
        $accessToken = $tokenObject->accessToken;

        $expiresIn = $tokenObject->token->expires_at->diffInMinutes(Carbon::now());

        return response(['user' => $user, 'access_token' => $accessToken, 'expires_in' => $expiresIn]);
    }

    public function login(Request $request)
    {
        $loginData = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (!auth()->attempt($loginData)) {
            return response(['message' => 'Invalid credentials'], 401);
        }

        $user = auth()->user();

        $tokenObject = $user->createToken('authToken');
        $accessToken = $tokenObject->accessToken;

        $expiresIn = $tokenObject->token->expires_at->diffInMinutes(Carbon::now());

        return response(['user' => $user, 'access_token' => $accessToken, 'expires_in' => $expiresIn]);
    }
}
