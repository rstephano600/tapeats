<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Food;
use App\Models\Supplier;
class CartController extends Controller
{
    public function addToCart(Request $request, $foodId)
{
    $food = Food::findOrFail($foodId);

    $cart = session()->get('cart', []);

    if (isset($cart[$foodId])) {
        $cart[$foodId]['quantity']++;
    } else {
        $cart[$foodId] = [
            'name' => $food->food_name,
            'price' => $food->price,
            'quantity' => 1,
            'supplier_id' => $food->supplier_id,
            'business_id' => $food->business_id,
        ];
    }

    session()->put('cart', $cart);

    return back()->with('success', 'Item added to cart!');
}

public function viewCart()
{
    $cart = session()->get('cart', []);
    return view('customer.cart.index', compact('cart'));
}

public function removeItem($foodId)
{
    $cart = session()->get('cart', []);

    if (isset($cart[$foodId])) {
        unset($cart[$foodId]);
        session()->put('cart', $cart);
    }

    return back()->with('success', 'Item removed.');
}
}

