<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserProfileController extends Controller
{
    public function me(Request $request)
    {
        $user = $request->user();

        return response()->json(['user' => $user]);
    }

    public function update(Request $request)
    {
        $user = $request->user();

        $validatedData = $request->validate([
            'name' => ['nullable', 'string', 'max:255'],
            'username' => ['nullable', 'string', 'max:255', 'unique:users,username'],
            'email' =>  ['nullable', 'email', 'unique:users,email'],
            'phone_number' => ['nullable', 'numeric', 'unique:users,phone_number'],
            'password' => ['required', 'min:6']
        ]);

        if (!Hash::check($validatedData['password'], $user->password)) {
            return response()->json(['message' => 'Credentials does not match with our records!']);
        }

        $user->update($validatedData);

        return response()->json(['message' => 'Profile updated successfully']);
    }
}
