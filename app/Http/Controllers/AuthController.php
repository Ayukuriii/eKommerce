<?php

namespace App\Http\Controllers;

use App\Enums\UserRoleEnum;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.index');
    }

    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username'],
            'email' => ['required', 'email', 'unique:users,email'],
            'phone_number' => ['required', 'numeric', 'unique:users,phone_number'],
            'password' => ['required', 'min:6', 'confirmed'],
            'password_confirmation' => ['required', 'min:6']
        ]);

        if ($request->password !== $request->password_confirmation) {
            return 'pasword tidak match!';
        }
        $validatedData['role'] = UserRoleEnum::ADMIN->value;

        User::create($validatedData);

        return to_route('auth.index')->with('success', 'Account created successfully!');
    }

    public function show()
    {
        $user = auth()->user();
        return view('admin.profile.index', compact('user'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('admin.profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        // dd($request->all()); 
        $user = User::find(auth()->id());
        $validatedData = $request->validate([
            'name' => ['nullable', 'string', 'max:255'],
            'username' => ['nullable', 'string', 'max:255', 'unique:users,username,' . auth()->id()],
            'email' => ['nullable', 'email'],
            'phone_number' => ['nullable', 'numeric'],
            'password' => ['required']
        ]);

        if (!Hash::check($validatedData['password'], $user->password)) {
            return back()->with('failed', 'Incorrect Credentials');
        }

        $user->update($validatedData);
        return to_route('auth.profile')->with('success', 'Profile updated successfully');
    }

    public function login(Request $request)
    {
        // dd($request);
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        if (!Auth::attempt($credentials)) {
            return back()->withErrors([
                'email' => 'Your provided credentials do not match in our records.',
            ])->onlyInput('email');
        }

        return to_route('dashboard')->with('success', 'You have successfully logged in!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return to_route('auth.login')->withSuccess('You have logged out successfully!');
    }
}
