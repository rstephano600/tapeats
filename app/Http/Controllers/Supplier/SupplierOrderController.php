<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Order;

class SupplierOrderController extends Controller
{
    // List all orders for this supplier
    public function index()
    {
        $supplierId = Auth::user()->id;

        $orders = Order::with('customer', 'items.food')
            ->where('supplier_id', $supplierId)
            ->latest()
            ->paginate(10);

        return view('supplier.orders.index', compact('orders'));
    }

    // View single order
    public function show($id)
    {
        $order = Order::with('customer', 'items.food')
            ->where('supplier_id', Auth::id())
            ->findOrFail($id);

        return view('supplier.orders.show', compact('order'));
    }

    // Update order status
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,preparing,ready,delivered,rejected'
        ]);

        $order = Order::where('supplier_id', Auth::id())->findOrFail($id);

        $order->status = $request->status;
        $order->save();

        return back()->with('success', 'Order status updated!');
    }
}
