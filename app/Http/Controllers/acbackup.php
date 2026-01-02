<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function loginForm() {
        return view('auth.login');
    }

    public function login(Request $request) {
        // 1. Validate the input
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|min:5',
    ]);

    // 2. Attempt to find the user
    $user = User::where('email', $request->email)->first();

    // 3. Check if user exists and password matches using bcrypt
    if ($user && Hash::check($request->password, $user->password)) {
        Auth::login($user); // Login the user
        return redirect()->intended('/dashboard');
    }

    // 4. Failed authentication
    return back()->withErrors([
        'email' => 'Invalid credentials or user does not exist.',
    ])->withInput();
    }

    public function logout(Request $request) {
        Auth::logout();
        return redirect('/');
    }
}
