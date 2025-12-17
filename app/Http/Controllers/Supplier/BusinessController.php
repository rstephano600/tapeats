<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BusinessController extends Controller
{
    // Show all businesses of logged-in supplier
    public function index()
    {
        $businesses = Supplier::where('user_id', Auth::id())->get();

        return view('supplier.business.index', compact('businesses'));
    }

    // Show create form
    public function create()
    {
        return view('supplier.business.create');
    }

    // Store new business
    public function store(Request $request)
    {
        $request->validate([
            'business_name' => 'required|string|max:255',
            'business_type' => 'nullable|string|max:255',
            'phone_number'  => 'nullable|string|max:20',
            'address'       => 'nullable|string',
            'region'        => 'nullable|string|max:255',
            'logo'          => 'nullable|image|max:2048',
            'description'   => 'nullable|string'
        ]);

        // Handle logo upload
        $logoPath = null;
        if ($request->hasFile('logo')) {
    $logoPath = $request->file('logo')->store('logos', 'public');
    $supplier->logo = $logoPath;
    $supplier->save();
}


        Supplier::create([
            'user_id'       => Auth::id(),
            'business_name' => $request->business_name,
            'business_type' => $request->business_type,
            'phone_number'  => $request->phone_number,
            'address'       => $request->address,
            'region'        => $request->region,
            'logo'          => $logoPath,
            'description'   => $request->description,
            'is_verified'   => false, // default
        ]);

        return redirect()->route('business.index')
            ->with('success', 'Business registered successfully!');
    }

    // Show edit form
    public function edit($id)
    {
        $business = Supplier::where('user_id', Auth::id())->findOrFail($id);

        return view('supplier.business.edit', compact('business'));
    }

    // Update business data
    public function update(Request $request, $id)
    {
        $business = Supplier::where('user_id', Auth::id())->findOrFail($id);

        $request->validate([
            'business_name' => 'required|string|max:255',
            'business_type' => 'nullable|string|max:255',
            'phone_number'  => 'nullable|string|max:20',
            'address'       => 'nullable|string',
            'region'        => 'nullable|string|max:255',
            'logo'          => 'nullable|image|max:2048',
            'description'   => 'nullable|string'
        ]);

        // If updating logo
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
            $business->logo = $logoPath;
        }

        // Update fields
        $business->business_name = $request->business_name;
        $business->business_type = $request->business_type;
        $business->phone_number  = $request->phone_number;
        $business->address       = $request->address;
        $business->region        = $request->region;
        $business->description   = $request->description;

        $business->save();

        return redirect()->route('business.index')
            ->with('success', 'Business updated successfully!');
    }

    // Delete a business
    public function destroy($id)
    {
        $business = Supplier::where('user_id', Auth::id())->findOrFail($id);

        $business->delete();

        return redirect()->route('business.index')
            ->with('success', 'Business deleted successfully!');
    }

    // ADMIN: verify business
    public function verify($id)
    {
        $business = Supplier::findOrFail($id);
        $business->is_verified = true;
        $business->save();

        return back()->with('success', 'Business verified successfully!');
    }

    // ADMIN: unverify business
    public function unverify($id)
    {
        $business = Supplier::findOrFail($id);
        $business->is_verified = false;
        $business->save();

        return back()->with('success', 'Business unverified successfully!');
    }

    public function pending()
{
    // Get all NOT VERIFIED businesses
    $suppliers = Supplier::with('user')->where('is_verified', false)->get();

    return view('admin.suppliers.pending', compact('suppliers'));
}


}
