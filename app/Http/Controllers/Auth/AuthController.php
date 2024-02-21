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

        return response($this->getAuthenticatedUserResponse($user));
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

        return response($this->getAuthenticatedUserResponse(auth()->user()));
    }

    private function getAuthenticatedUserResponse($user)
    {
        $tokenObject = $user->createToken('authToken');
        $accessToken = $tokenObject->accessToken;
        $expiresIn = $tokenObject->token->expires_at->diffInMinutes(Carbon::now());

        return ['user' => $user, 'access_token' => ['token' => $accessToken, 'expires_in' => $expiresIn]];
    }
}
