<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Enums\UserRoleEnum;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notifications\Admin\NewUserNotification;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username'],
            'email' => ['required', 'email', 'unique:users,email'],
            'phone_number' => ['required', 'numeric', 'unique:users,phone_number'],
            'password' => ['required', 'min:6', 'confirmed'],
            'password_confirmation' => ['required', 'min:6']
        ]);

        if ($validatedData['password'] !== $validatedData['password_confirmation']) {
            return response()->json(['message' => 'Credentials does not match!']);
        }

        $user = User::create($validatedData);
        // notify admins
        $admins = User::where('role', UserRoleEnum::ADMIN->value)->get();
        foreach ($admins as $admin) {
            $admin->notify(new NewUserNotification($user));
        }

        return response()->json(['message' => 'Account created successfully!']);
    }

    public function login(Request $request)
    {
        $validatedData = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        if (!auth()->attempt($validatedData)) {
            return response()->json([
                'error' => 'Invalid Credential',
            ], 401);
        }

        $user = User::where('email', $request->email)->first();
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'message' => 'You have successfully logged in',
            'access_token' => $token,
            'token_type' => 'Bearer'
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'You have successfully logged out!'
        ]);
    }
}
