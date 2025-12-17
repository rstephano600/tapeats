<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
{
    $request->validate([
        'login'    => 'required',   // can be username or email
        'password' => 'required'
    ]);

    $login_type = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

    $credentials = [
        $login_type => $request->login,
        'password'  => $request->password,
    ];

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();

        // Redirect according to ROLE
        switch (Auth::user()->role) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'supplier':
                return redirect()->route('supplier.dashboard');
            case 'customer':
                return redirect()->route('customer.dashboard');
            case 'deliver':
                return redirect()->route('deliver.dashboard');
            default:
                return redirect()->route('home');
        }
    }

    return back()->withErrors([
        'login' => 'Invalid login credentials.',
    ]);
}

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        return redirect()->route('login');
    }
}
