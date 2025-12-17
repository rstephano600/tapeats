<?php

namespace App\Http\Controllers\menu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Food;
use App\Models\Supplier;

class MenuController extends Controller
{
    // Show all foods to customers
    public function index()
    {
        $foods = Food::with(['supplier.user'])
            ->where('available', true)
            ->paginate(12);

        return view('customer.food.index', compact('foods'));
    }

    // Show foods for a specific supplier
    public function supplierFoods($supplierId)
    {
        $supplier = Supplier::with('user')->findOrFail($supplierId);

        $foods = Food::where('business_id', $supplierId)
            ->where('available', true)
            ->get();

        return view('customer.food.supplier_foods', compact('supplier', 'foods'));
    }


    public function show($id)
    {
        $food = Food::with('supplierBusiness')->findOrFail($id);
        return view('customer.food.show', compact('food'));
    }
}
