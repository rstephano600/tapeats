<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
{
    $request->validate([
        'name'     => 'required|string|max:255',
        'email'    => 'required|email|unique:users',
        'password' => 'required|confirmed|min:6',
        'role'     => 'required|in:admin,supplier,customer,deliver'
    ]);

    // 1️⃣ Clean name
    $cleanName = strtolower(str_replace(' ', '', $request->name));

    // 2️⃣ Your app short name
    $app = "TE";

    // 3️⃣ Year + random number
    $date = date('Y');
    $rand = rand(100, 999);

    // 4️⃣ Generate username
    $username = "{$cleanName}-{$app}-{$date}-{$rand}";

    // 5️⃣ Ensure it's unique
    while (User::where('username', $username)->exists()) {
        $rand = rand(100, 999);
        $username = "{$cleanName}-{$app}-{$date}-{$rand}";
    }

    // 6️⃣ Create user WITH username
    User::create([
        'name'     => $request->name,
        'username' => $username, // REQUIRED 🔥🔥
        'email'    => $request->email,
        'password' => Hash::make($request->password),
        'role'     => $request->role,
    ]);

    return redirect()->route('login')
        ->with('success', 'Account created! Your username: ' . $username);
}

}
