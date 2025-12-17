<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SupplierAuthController extends Controller
{
    public function showRegisterForm()
    {
        return view('supplier.auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'business_name' => 'required|string|max:255',
            'region' => 'required|string|max:255',
        ]);

        // Create User
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'supplier',
        ]);

        // Create Supplier Profile
        Supplier::create([
            'user_id' => $user->id,
            'business_name' => $request->business_name,
            'business_type' => $request->business_type,
            'region' => $request->region,
            'phone_number' => $request->phone_number,
            'description' => $request->description,
        ]);

        auth()->login($user);

        return redirect()->route('supplier.dashboard');
    }
}
