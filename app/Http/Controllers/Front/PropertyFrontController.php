<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\User;

class PropertyFrontController extends Controller
{
    // ===============================
    // 1️⃣ Show all properties (User page)
    // ===============================
    public function index()
    {
        $properties = Property::latest()->get();
        return view('user', compact('properties'));
    }

    // ===============================
    // 2️⃣ Show single property (View page)
    // ===============================
    public function show($id)
    {
        $property = Property::with('images')->findOrFail($id);
        return view('view', compact('property'));
    }

    // ===============================
    // 3️⃣ Search properties (Dashboard)
    // ===============================
 public function search(Request $request)
{
    $query = Property::query();

    $query->where('status', 'active');

    if ($request->filled('location')) {
        $query->where('location', 'like', '%' . $request->location . '%');
    }

    if ($request->filled('purpose')) {
        $query->where('purpose', $request->purpose);
    }

    if ($request->filled('type')) {
        $query->where('type', $request->type);
    }

    $properties = $query->latest()->get();

    // اگر user لاگین است
    if (auth()->check() && auth()->user()->role == 'user') {
        return view('user', compact('properties'));
    }

    // اگر عمومی
    return view('dashboard', [
        'properties' => $properties,
        'totalProperties' => Property::count(),
        'forSale' => Property::where('purpose','sale')->count(),
        'forRent' => Property::where('purpose','rent')->count(),
        'customers' => User::count()
    ]);
}

    // ===============================
    // 4️⃣ Compare properties
    // ===============================
/*public function compare(Request $request)
    {
        $ids = explode(',', $request->ids);
        $properties = Property::whereIn('id', $ids)->get();
        return view('compare', compact('properties'));
    }*/
        public function compare(Request $request)
{
    if (!$request->has('ids')) {
        return redirect()->route('user.panel');
    }

    $ids = explode(',', $request->ids);

    $properties = Property::with('images')
        ->whereIn('id', $ids)
        ->get();

    return view('compare', compact('properties'));
}

    // ===============================
    // 5️⃣ Dashboard (Default + Search)
    // ===============================
    public function dashboard(Request $request)
    {
        //dd($request->all());
        $query = Property::query();

        // فقط active
        $query->where('status', 'active');

        // location
        if ($request->filled('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        // purpose: sale / rent
        if ($request->filled('purpose')) {
            $query->where('purpose', $request->purpose);
        }

        // type: house / villa / apartment
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        //$properties = $query->latest()->get();
        $properties = $query->latest()->paginate(6);
        return view('dashboard', [
            'properties' => $properties,
            'totalProperties' => Property::count(),
            'forSale' => Property::where('purpose','sale')->count(),
            'forRent' => Property::where('purpose','rent')->count(),
            'customers' => User::count()
        ]);
    }

    // ===============================
    // 6️⃣ User properties (Front)
    // ===============================
    public function properties()
    {
        $properties = Property::latest()->get();
        return view('user', compact('properties'));
    }
}
