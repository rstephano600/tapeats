<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Food;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class OrderController2 extends Controller
{
    // Define the delivery fees (matching frontend logic)
    private const DELIVERY_FEES = [
        'Dar es Salaam' => 5000.00,
        'Dodoma' => 8000.00, // Example fee
        'Arusha' => 7500.00, // Example fee
        'Mwanza' => 9000.00, // Example fee
        // ... add all other regions as necessary
        'Other' => 10000.00, // Default fee
    ];

    /**
     * Handle the order submission from the frontend.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // 1. Validation
        try {
            $validatedData = $request->validate([
                'full_name' => 'required|string|max:255',
                'phone' => 'required|string|max:20',
                'address' => 'required|string|max:500',
                'region' => 'required|string|max:100',
                'payment_method' => 'required|in:cash,mobile_money',
                'notes' => 'nullable|string|max:1000',
                'cart' => 'required|array|min:1',
                // Validate individual cart items
                'cart.*.id' => 'required|exists:foods,id', // food_id
                'cart.*.quantity' => 'required|integer|min:1',
            ]);
        } catch (ValidationException $e) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $e->errors()], 422);
        }

        // 2. Initial Setup and Integrity Checks
        $cart = $validatedData['cart'];
        
        // Ensure all items belong to the same supplier (as enforced by frontend JS)
        $firstItem = $cart[0];
        $supplierId = $firstItem['supplier_id']; // This is the user_id of the supplier
        $businessId = $firstItem['business_id']; // This is the id of the supplier (business)

        // Retrieve actual food prices and check availability/integrity
        $foodIds = collect($cart)->pluck('id');
        $foods = Food::whereIn('id', $foodIds)->get()->keyBy('id');

        $subtotal = 0;
        $orderItemsData = [];
        
        foreach ($cart as $item) {
            $food = $foods->get($item['id']);

            // Critical integrity check: Food must exist and be available
            if (!$food || !$food->available) {
                return response()->json([
                    'success' => false,
                    'message' => "Order failed. Item '{$item['name']}' is unavailable or not found."
                ], 400);
            }

            $itemPrice = $food->price; // Use the price stored in the database, not the client-side price
            $itemSubtotal = $itemPrice * $item['quantity'];
            $subtotal += $itemSubtotal;

            $orderItemsData[] = [
                'food_id' => $food->id,
                'quantity' => $item['quantity'],
                'price' => $itemPrice,
            ];
        }
        
        // 3. Calculate Fees
        $deliveryFee = self::DELIVERY_FEES[$validatedData['region']] ?? self::DELIVERY_FEES['Other'];
        $totalAmount = $subtotal + $deliveryFee;
        
        // 4. Database Transaction
        DB::beginTransaction();

        try {
            // A. Create the main Order record
            $order = Order::create([
                'customer_id' => Auth::id(), // Assumes the user is logged in
                'supplier_id' => $supplierId,
                'business_id' => $businessId,
                'customer_name' => $validatedData['full_name'],
                'customer_phone' => $validatedData['phone'],
                'delivery_address' => $validatedData['address'],
                'delivery_region' => $validatedData['region'],
                'special_instructions' => $validatedData['notes'],
                'payment_method' => $validatedData['payment_method'],
                'subtotal_amount' => $subtotal,
                'delivery_fee' => $deliveryFee,
                'total_amount' => $totalAmount,
                'status' => 'pending', // Initial status
            ]);

            // B. Create the Order Items
            foreach ($orderItemsData as $itemData) {
                $order->items()->create($itemData);
            }

            DB::commit();

            // 5. Success Response
            return response()->json([
                'success' => true,
                'message' => 'Order placed successfully!',
                'order_id' => $order->id,
                'redirect' => route('orders.show', $order->id) // Assuming you have a route like this
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            // Log the error for internal debugging
            \Log::error('Order placement failed: ' . $e->getMessage());
            
            // 6. Failure Response
            return response()->json([
                'success' => false,
                'message' => 'A server error occurred while processing your order.'
            ], 500);
        }
    }

public function foodsBySupplier($supplierId)
    {
        // 1. Fetch the Supplier/Business details or fail (404)
        $supplier = Business::findOrFail($supplierId);

        // 2. Fetch only the foods associated with this supplier
        // Ensure the foreign key is correctly named 'supplier_id'
        $foods = Food::where('supplier_id', $supplierId)
                     ->where('is_available', true) 
                     ->get();

        // 3. CRITICAL: Return the Blade VIEW, passing the data
        return view('menu.supplier_menu', [
            'supplier' => $supplier,
            'foods' => $foods,
        ]);
        
        // --- AVOID THIS (It returns raw data, causing your current issue) ---
        // return $foods; 
        // return $supplier->foods;
    }
}