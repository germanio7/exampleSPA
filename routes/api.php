<?php

use App\Models\User;
use Illuminate\Http\Request;
use Faker\Provider\UserAgent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return abort(403, 'Las credenciales no coinciden...');
    }

    $user->tokens()->delete();

    $token = $user->createToken('authToken')->plainTextToken;

    return response($token);
});

Route::post('logout', function (Request $request) {
    $user = User::where('email', $request->email)->first();
    if ($user) {
        $user->tokens()->delete();
    }
    Auth::logout();
    return redirect('/');
});
