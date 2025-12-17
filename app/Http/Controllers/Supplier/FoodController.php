<?php

namespace App\Http\Controllers\supplier;

use App\Http\Controllers\Controller;
use App\Models\Food;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FoodController extends Controller
{
    // List all foods for logged-in supplier
    public function index()
    {
        $businesses = Supplier::where('user_id', Auth::id())->get();

        $foods = Food::where('supplier_id', Auth::id())->with('supplierBusiness')->get();

        return view('supplier.foods.index', compact('foods', 'businesses'));
    }

    // Show form
    public function create()
    {
        $businesses = Supplier::where('user_id', Auth::id())->get();

        return view('supplier.foods.create', compact('businesses'));
    }

    // Save food
    public function store(Request $request)
    {
        $request->validate([
            'business_id' => 'required',
            'food_name' => 'required',
            'price' => 'required|numeric',
            'image' => 'nullable|image|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('foods', 'public');
        }

        Food::create([
            'supplier_id' => Auth::id(),
            'business_id' => $request->business_id,
            'food_name' => $request->food_name,
            'category' => $request->category,
            'price' => $request->price,
            'image' => $imagePath,
            'description' => $request->description,
        ]);

        return redirect()->route('supplier.foods.index')->with('success', 'Food added successfully!');
    }
public function show($id)
    {
        $food = Food::with('supplierBusiness')->findOrFail($id);
        return view('supplier.foods.show', compact('food'));
    }
    // Edit
    public function edit($id)
    {
        $food = Food::findOrFail($id);

        $businesses = Supplier::where('user_id', Auth::id())->get();

        return view('supplier.foods.edit', compact('food', 'businesses'));
    }

    // Update
    public function update(Request $request, $id)
    {
        $food = Food::findOrFail($id);

        $request->validate([
            'food_name' => 'required',
            'price' => 'required|numeric',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $food->image = $request->file('image')->store('foods', 'public');
        }

        $food->update([
            'business_id' => $request->business_id,
            'food_name' => $request->food_name,
            'category' => $request->category,
            'price' => $request->price,
            'description' => $request->description,
        ]);

        return redirect()->route('supplier.foods.index')->with('success', 'Food updated successfully!');
    }

public function supplierFoods($supplierId)
{
    $supplier = Supplier::findOrFail($supplierId);

    $foods = Food::where('business_id', $supplierId)
        ->where('available', true)
        ->get();

    return view('customer.food.supplier_foods', compact('supplier', 'foods'));
}



    // Delete
    public function destroy($id)
    {
        Food::findOrFail($id)->delete();

        return redirect()->back()->with('success', 'Food deleted successfully!');
    }
}
