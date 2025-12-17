<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function checkout()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) return redirect()->route('cart.view')->with('error', 'Cart is empty.');
        return view('customer.cart.checkout', compact('cart'));
    }

    public function placeOrder(Request $request)
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) return redirect()->route('cart.view')->with('error', 'Cart is empty.');

        // All items already restricted to single supplier/business in CartController
        $first = reset($cart);

        $total = collect($cart)->sum(function($i){ return $i['price'] * $i['quantity']; });

        $order = Order::create([
            'customer_id' => Auth::id(),
            'supplier_id' => $first['supplier_id'],
            'business_id' => $first['business_id'],
            'total_amount' => $total,
            'status' => 'pending',
        ]);

        foreach($cart as $foodId => $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'food_id' => $foodId,
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }

        // Clear cart
        session()->forget('cart');

        return redirect()->route('customer.orders')->with('success', 'Order placed successfully.');
    }

    // Customer order list
    public function myOrders()
    {
        $orders = Order::where('customer_id', Auth::id())->with('items.food')->orderBy('created_at','desc')->get();
        return view('customer.orders.index', compact('orders'));
    }

    public function viewOrder($id)
{
    $order = Order::where('customer_id', Auth::id())
        ->with('items.food')
        ->findOrFail($id);

    return view('customer.orders.view', compact('order'));
}

}


