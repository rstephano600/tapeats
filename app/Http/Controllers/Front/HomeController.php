<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supplier;

class HomeController extends Controller
{
    public function index()
    {
        // Show only verified suppliers (optional)
        $suppliers = Supplier::where('is_verified', true)->get();

        return view('home', compact('suppliers'));
    }
}
