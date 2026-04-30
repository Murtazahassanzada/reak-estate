<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\Notification;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Http\Requests\StorePropertyRequest;
use App\Http\Requests\UpdatePropertyRequest;

class PropertyController extends Controller
{
   public function index()
{
    $properties = Property::with('images','user')

        ->when(request('search'), fn($q) =>
            $q->where('title', 'like', '%' . request('search') . '%')
        )

        ->when(request('status'), fn($q) =>
            $q->where('status', request('status'))
        )

        ->when(request('location'), fn($q) =>
            $q->where('location', 'like', '%' . request('location') . '%')
        )

        ->when(request('type'), fn($q) =>
            $q->where('type', request('type'))
        )

        ->when(request('purpose'), fn($q) =>
            $q->where('purpose', request('purpose'))
        )

    
->latest()
->paginate(10);

    return view('admin.properties.index', compact('properties'));
}

    // =========================
    // STORE (Admin create property)
    // =========================
    public function store(StorePropertyRequest $request)
    {
        DB::transaction(function () use ($request) {

            $property = Property::create([
                ...$request->validated(),
                'user_id' => Auth::id(),
             'status' => 'approved',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
            ]);

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {

                    $imageName = Str::uuid() . '.' . $image->extension();
                    $image->storeAs('properties', $imageName, 'public');

                    $property->images()->create([
                        'image' => $imageName
                    ]);
                }
            }
        });

        return back()->with('success', 'Property created and sent for approval');
    }

    // =========================
    // UPDATE
    // =========================
    public function update(UpdatePropertyRequest $request, Property $property)
    {
        DB::transaction(function () use ($request, $property) {

            $property->update([
                ...$request->validated(),
               'status' => 'approved', // دوباره review
            ]);

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {

                    $imageName = Str::uuid() . '.' . $image->extension();
                    $image->storeAs('properties', $imageName, 'public');

                    $property->images()->create([
                        'image' => $imageName
                    ]);
                }
            }
        });

        return back()->with('success', 'Property updated and sent for review');
    }

    // =========================
    // APPROVE
    // =========================
    public function approve(Property $property)
    {
        $property->update([
           'status' => 'approved',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
            'rejection_reason' => null,
        ]);

        Notification::create([
            'user_id' => $property->user_id,
            'type' => 'property',
            'title' => 'Property Approved 🎉',
            'body' => 'Your property "' . $property->title . '" is now live.',
            'property_id' => $property->id,
        ]);

        return back()->with('success', 'Approved successfully');
    }

    // =========================
    // REJECT
    // =========================
    public function reject(Request $request, Property $property)
    {
        $request->validate([
            'reason' => 'required|string|max:500'
        ]);

        $property->update([
          'status' => 'rejected',
            'rejection_reason' => $request->reason,
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);

        Notification::create([
            'user_id' => $property->user_id,
            'type' => 'property',
            'title' => 'Property Rejected ❌',
            'body' => 'Reason: ' . $request->reason,
            'property_id' => $property->id,
        ]);

        return back()->with('success', 'Rejected successfully');
    }

    // =========================
    // DELETE IMAGE
    // =========================
    public function deleteImage($id)
    {
        $image = \App\Models\PropertyImage::findOrFail($id);

        if (Storage::disk('public')->exists('properties/' . $image->image)) {
            Storage::disk('public')->delete('properties/' . $image->image);
        }

        $image->delete();

        return back()->with('success', 'Image deleted');
    }
public function destroy($id)
{
    $property = Property::findOrFail($id);
    $property->delete();

    return redirect()->route('properties.index')
        ->with('success', 'با موفقیت حذف شد');
}
    // =========================
    // TRASH
    // =========================
    public function trash()
    {
        return view('admin.properties.trash', [
            'properties' => Property::onlyTrashed()->paginate(10)
        ]);
    }

    public function restore($id)
    {
        Property::onlyTrashed()->findOrFail($id)->restore();
        return back()->with('success', 'Restored');
    }

    public function forceDelete($id)
    {
        $property = Property::onlyTrashed()->findOrFail($id);

        DB::transaction(function () use ($property) {

            foreach ($property->images as $img) {
                Storage::disk('public')->delete('properties/' . $img->image);
            }

            $property->forceDelete();
        });

        return back()->with('success', 'Permanently deleted');
    }
}
