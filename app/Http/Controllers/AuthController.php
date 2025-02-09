<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function index()
    {
        return view('login.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required|min:5|max:255'
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if ($user->role === 'admin') {
                return redirect()->intended('dashboard');
            } elseif ($user->role === 'kasir') {
                return redirect()->intended('pesanan');
            }
        }

        return back()->with('loginError', 'Login Failed');

        // $user = User::where('username', $credentials['username'])->first();

        // if($user && Hash::check($credentials['password'], $user->password)) {
        //     // return $user;
        //     if($user->role === 'admin') {
        //         return redirect()->intended('/dashboard');
        //     } elseif($user->role === 'kasir') {
        //         return view('cashier.kasir');
        //     }
        // }

        // return back()->withErrors(['username' => 'Login gagal. Cek username dan password kembali']);

    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
