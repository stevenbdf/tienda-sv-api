<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $type_guard = false;
        if(Admin::whereEmail($request->email)->first()){
            $type_guard='admins';
        }else if(User::whereEmail($request->email)->first()){
            $type_guard='users';
        }
        if ($type_guard!=false && Auth::guard($type_guard)->attempt($credentials)) {
            $request->session()->regenerate();
            return response()->json(['message' => 'Login successful'], 200);
        }
        return response()->json(['message' => 'Credentials incorrect'], 401);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->json(['message' => 'logged out'], 401);
    }

}


