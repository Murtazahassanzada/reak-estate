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
    // USER PANEL
    // ===============================


public function index(Request $request)
{
    $query = Property::with('images')
        ->where('user_id', Auth::id());

    // 🔍 فیلتر location
 if ($request->filled('location')) {
    $query->where('location', 'like', '%' . $request->location . '%');
}

if ($request->filled('type')) {
    $query->where('type', $request->type);
}

    // 👇 این خیلی مهمه (pagination حفظ میشه)
    $properties = $query->latest()->paginate(9);

    return view('user', compact('properties'));
}

    // ===============================
    // STORE PROPERTY
    // ===============================
public function store(StorePropertyRequest $request)
{
    try {

        // ✅ 1. گرفتن دیتا
        $data = $request->validated();
        $data['user_id'] = Auth::id();
        $data['approval_status'] = 'pending'; // 👈 مهم

        // ✅ 2. ذخیره property
        $property = Property::create($data);

        // ✅ 3. آپلود تصاویر
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $img) {

                $name = Str::uuid() . '.' . $img->extension();
                $img->storeAs('properties', $name, 'public');

                $property->images()->create([
                    'image' => $name
                ]);
            }
        }

        // ✅ 4. ارسال نوتیفیکیشن به ادمین‌ها
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

        // ✅ 5. برگشت با پیام موفقیت
        return back()->with('success', __('property.submitted'));

    } catch (\Exception $e) {

        \Log::error('Property store error: ' . $e->getMessage());

        return back()->with('error', 'Something went wrong');
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
    // DASHBOARD (MAIN)
    // ===============================
public function dashboard(Request $request)
{
    $query = Property::with('images');

    // ❌ این دو خط را حذف کن
    // $query->where('approval_status', PropertyStatus::APPROVED)
    //       ->where('status', 'active');

    // optional filters (search box)
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

    return view('dashboard', [
        'properties' => $properties,

        'totalProperties' => Property::count(), // 👈 همه

        'forSale' => Property::where('purpose', 'sale')->count(),

        'forRent' => Property::where('purpose', 'rent')->count(),

        'customers' => User::where('role','user')->count(),
    ]);
}

    // ===============================
    // SEARCH
    // ===============================
public function search(Request $request, PropertySearchService $search)
{
    $properties = $search->apply($request)
        ->with('images')
        ->where('status', 'approved') // ✅ فقط همین
        ->latest()
        ->paginate(9)
        ->withQueryString();

    return view('dashboard', [
        'properties' => $properties,

        'totalProperties' => Property::where('status', 'approved')->count(),

        'forSale' => Property::where('purpose', 'sale')
            ->where('status', 'approved')
            ->count(),

        'forRent' => Property::where('purpose', 'rent')
            ->where('status', 'approved')
            ->count(),

        'customers' => User::where('role','user')->count(),
    ]);
}
    // ===============================
    // COMPARE
    // ===============================
    public function compare(Request $request)
    {
        $ids = explode(',', $request->ids ?? '');

        $properties = Property::with('images')
            ->whereIn('id', $ids)
            ->where('status', 'approved')
            ->get();

        return view('compare', compact('properties'));
    }

    // ===============================
    // UPDATE
    // ===============================
    public function update(Request $request, $id)
    {
        $property = Property::where('user_id', auth()->id())
            ->findOrFail($id);

        $property->update([
            ...$request->only([
                'title','description','location','price',
                'bedrooms','bathrooms','area','type','purpose'
            ]),
          'status' => 'pending'
        ]);

        // upload images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $img) {

                $name = Str::uuid() . '.' . $img->extension();
                $img->storeAs('properties', $name, 'public');

                $property->images()->create([
                    'image' => $name
                ]);
            }
        }

        // notify admins
     $admins = User::admins()->get();

        foreach ($admins as $admin) {
            Notification::create([
                'user_id' => $admin->id,
                'type' => 'property',
                'title' => __('notifications.property_updated'),
                'body' => Auth::user()->name . ' updated a property',
                'property_id' => $property->id,
            ]);
        }

        return back()->with('success', __('property.updated_pending'));
    }

    // ===============================
    // DELETE PROPERTY
    // ===============================
    public function destroy($id)
    {
        $property = Property::where('user_id', auth()->id())
            ->findOrFail($id);

        foreach ($property->images as $img) {
            Storage::disk('public')->delete('properties/' . $img->image);
        }

        $property->delete();

        return back()->with('success', __('property.deleted'));
    }

    // ===============================
    // DELETE IMAGE
    // ===============================
    public function deleteImage($id)
    {
        $image = PropertyImage::findOrFail($id);

        Storage::disk('public')->delete('properties/'.$image->image);
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
        'customers' => \App\Models\User::where('role','user')->count(),
    ]);
}
}
