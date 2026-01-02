<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Mail\PasswordMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    // Register
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'phone' => 'required|digits:10|unique:users',
            'password' => 'required|min:6',
        ]);

        $password = $validated['password'] ?? Str::random(6);
    
        // Create user
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => bcrypt($password),
            'role' => 'customer',
            'status' => 'active',
        ]);

    
        // ⛔ User inactive case skip (fresh user is active)
        // ✔ Auto Login (Create Sanctum token)
        $token = $user->createToken('user-token')->plainTextToken;

        // Send password email (SMTP)
        Mail::to($user->email)->send(new PasswordMail($user->name, $password));
    
        return response()->json([
            'message' => 'Registration successful',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user
        ], 201);
    }
    

    // Login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages(['email' => ['Invalid credentials.']]);
        }

        if ($user->status !== 'active') {
            return response()->json(['error' => 'Account is inactive'], 403);
        }

        if ($user->role !== 'customer') {
            return response()->json(['error' => 'Access denied.'], 403);
        }

        $token = $user->createToken('user-token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user
        ]);
    }

    // Logout
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out successfully']);
    }

    // Get logged user
    public function user(Request $request)
    {
        return response()->json($request->user());
    }
}
