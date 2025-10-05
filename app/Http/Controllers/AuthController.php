<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request){
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|in:admin,employee',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'roles' => $validated['role'],
        ]);

        Auth::login($user);

        return response()->json(['message' => 'Registration and logged in successfully']);
    }

    public function login(Request $request){
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if(Auth::attempt($credentials)){
            $request->session()->regenerate();
            return response()->json(['message' => 'Login successfull']);
        }

        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['message' => 'Logout successful']);
    }

    public function me(){
        return response()->json(Auth::user());
    }
}
