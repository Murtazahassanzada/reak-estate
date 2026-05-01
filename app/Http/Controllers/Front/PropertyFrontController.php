<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\PropertyImage;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use App\Services\PropertySearchService;
use App\Http\Requests\StorePropertyRequest;

class PropertyFrontController extends Controller
{
    // ===============================
    // USER PANEL (لیست ملک‌های کاربر، بدون فیلتر status)
    // ===============================
public function index(Request $request)
{
    $query = Property::with('images')
        ->where('status', 'approved');

    // SEARCH
    if ($request->filled('location')) {
        $query->where('location', 'like', '%' . $request->location . '%');
    }

    if ($request->filled('type')) {
        $query->where('type', $request->type);
    }

    if ($request->filled('purpose')) {
        $query->where('purpose', $request->purpose);
    }

    // ALL APPROVED PROPERTIES
    $properties = $query
        ->latest()
        ->paginate(9)
        ->withQueryString();

    // USER FAVORITES
    $favorites = auth()->user()
        ->favorites()
        ->with('images')
        ->get();

    return view('user', compact(
        'properties',
        'favorites'
    ));
}
    // ===============================
    // STORE PROPERTY (JSON response)
    // ===============================
   public function store(StorePropertyRequest $request)
{
    try {
        $data = $request->validated();
        $data['user_id'] = Auth::id();
        $data['status'] = 'pending';

        $property = Property::create($data);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $img) {
                $name = Str::uuid() . '.' . $img->extension();
                $img->storeAs('properties', $name, 'public');
                $property->images()->create(['image' => $name]);
            }
        }

        // نوتیفیکیشن به ادمین‌ها
        $admins = User::admins()->get();
        foreach ($admins as $admin) {
            Notification::create([
                'user_id' => $admin->id,
                'type' => 'property',
                'title' => 'New Property Submitted',
                'body' => Auth::user()->name . ' added a new property',
                'property_id' => $property->id,
                'is_read' => false,
            ]);
        }

        // ✅ فقط این قسمت تغییر کرد
        return redirect()->back()
            ->with('success', 'Property submitted for approval');

    } catch (\Exception $e) {
        \Log::error('Property store error: ' . $e->getMessage());

        // ✅ این هم تغییر شد
        return redirect()->back()
            ->with('error', 'Something went wrong');
    }
}

    // ===============================
    // SHOW PROPERTY
    // ===============================
    public function show($id)
    {
        $property = Property::with('images')->findOrFail($id);
        return view('view', compact('property'));
    }

    // ===============================
    // DASHBOARD (صفحه اصلی عمومی - فقط approved)
    // ===============================
    public function dashboard(Request $request)
    {
        $query = Property::with('images')->where('status', 'approved');

        if ($request->filled('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }
        if ($request->filled('purpose')) {
            $query->where('purpose', $request->purpose);
        }
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $properties = $query->latest()->paginate(9)->withQueryString();

        // آمارها فقط برای properties تأیید شده
        return view('dashboard', [
            'properties' => $properties,
            'totalProperties' => Property::where('status', 'approved')->count(),
            'forSale' => Property::where('purpose', 'sale')->where('status', 'approved')->count(),
            'forRent' => Property::where('purpose', 'rent')->where('status', 'approved')->count(),
            'customers' => User::where('role', 'user')->count(),
        ]);
    }

    // ===============================
    // SEARCH
    // ===============================
    public function search(Request $request, PropertySearchService $search)
    {
        $properties = $search->apply($request)
            ->with('images')
            ->where('status', 'approved')
            ->latest()
            ->paginate(9)
            ->withQueryString();

        return view('dashboard', [
            'properties' => $properties,
            'totalProperties' => Property::where('status', 'approved')->count(),
            'forSale' => Property::where('purpose', 'sale')->where('status', 'approved')->count(),
            'forRent' => Property::where('purpose', 'rent')->where('status', 'approved')->count(),
            'customers' => User::where('role', 'user')->count(),
        ]);
    }

    // ===============================
    // COMPARE
    // ===============================
public function compare(Request $request)
{
    $ids = $request->compare; // 👈 اینو تغییر بده

    if (!$ids || count($ids) < 2) {
        return back()->with('error', 'حداقل دو ملک انتخاب کنید');
    }

    $properties = Property::with('images')
        ->whereIn('id', $ids)
        ->where('status', 'approved')
        ->get();

    return view('compare', compact('properties'));
}

    // ===============================
    // UPDATE PROPERTY (JSON response)
    // ===============================
public function update(Request $request, $id)
{
    $property = Property::where('user_id', auth()->id())->findOrFail($id);

    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'location' => 'required|string',
        'price' => 'required|numeric',
        'bedrooms' => 'required|integer',
        'bathrooms' => 'required|integer',
        'area' => 'required|integer',
        'type' => 'required|string',
        'purpose' => 'required|string',
        'images.*' => 'nullable|image|max:2048'
    ]);

    $property->update($validated);
    $property->update(['status' => 'pending']); // پس از ویرایش دوباره نیاز به تایید

    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $img) {
            $name = Str::uuid() . '.' . $img->extension();
            $img->storeAs('properties', $name, 'public');
            $property->images()->create(['image' => $name]);
        }
    }

    // نوتیفیکیشن به ادمین‌ها
    $admins = User::admins()->get();
    foreach ($admins as $admin) {
        Notification::create([
            'user_id' => $admin->id,
            'type' => 'property',
            'title' => 'Property Updated',
            'body' => Auth::user()->name . ' updated a property',
            'property_id' => $property->id,
        ]);
    }

    // ✅ فقط این قسمت تغییر کرد
    return redirect()->back()
        ->with('success', 'Property updated and sent for approval');
}

    // ===============================
    // DELETE PROPERTY (JSON response)
    // ===============================
   public function destroy($id)
{
    $property = Property::where('user_id', auth()->id())->findOrFail($id);

    foreach ($property->images as $img) {
        Storage::disk('public')->delete('properties/' . $img->image);
    }

    $property->delete();

    return redirect()->route('user.panel')
        ->with('success', 'Property deleted successfully');
}

    // ===============================
    // DELETE IMAGE (AJAX)
    // ===============================
    public function deleteImage($id)
    {
        $image = PropertyImage::findOrFail($id);
        Storage::disk('public')->delete('properties/' . $image->image);
        $image->delete();
        return response()->json(['success' => true]);
    }

    // ===============================
    // SET MAIN IMAGE
    // ===============================
    public function setMainImage($id)
    {
        $image = PropertyImage::findOrFail($id);
        $image->property->images()->update(['is_main' => false]);
        $image->update(['is_main' => true]);
        return response()->json(['success' => true]);
    }

    // ===============================
    // PROPERTIES LIST (برای نمایش عمومی)
    // ===============================
public function about()
{
    $stats = [
        'properties' => \App\Models\Property::count(),
        'customers' => \App\Models\User::where('role', 'user')->count(),
        'agents' => \App\Models\User::where('role', 'admin')->count(),
    ];

    return view('about', compact('stats'));
}

    public function properties()
    {
        $properties = Property::where('status', 'approved')
            ->latest()
            ->paginate(9);

        return view('user', [
            'properties' => $properties,
            'totalProperties' => Property::where('status', 'approved')->count(),
            'forSale' => Property::where('purpose', 'sale')->where('status', 'approved')->count(),
            'forRent' => Property::where('purpose', 'rent')->where('status', 'approved')->count(),
            'customers' => User::where('role', 'user')->count(),
        ]);
    }
}
