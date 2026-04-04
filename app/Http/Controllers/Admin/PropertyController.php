<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Http\Requests\StorePropertyRequest;
use App\Http\Requests\UpdatePropertyRequest;

class PropertyController extends Controller
{
  use AuthorizesRequests;
    public function index()
    {
        $properties = Property::with('user')

            ->when(request('search'), function ($query) {
                $query->where('title', 'like', '%' . request('search') . '%');
            })

            ->when(request('status'), function ($query) {
                $query->where('status', request('status'));
            })

            ->when(request('location'), function ($query) {
                $query->where('location', 'like', '%' . request('location') . '%');
            })

            ->when(request('type'), function ($query) {
                $query->where('type', request('type'));
            })

            ->when(request('purpose'), function ($query) {
                $query->where('purpose', request('purpose'));
            })

            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('admin.properties.index', compact('properties'));
    }


    public function store(StorePropertyRequest $request)
    {
        $property = Property::create($request->validated() + [
            'user_id' => Auth::id(),
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

        return redirect()->route('properties.index')
            ->with('success', 'Property Added Successfully');
    }


    public function update(UpdatePropertyRequest $request, Property $property)
    {
        $this->authorize('update', $property);

        $property->update($request->validated());

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imageName = Str::uuid() . '.' . $image->extension();
                $image->storeAs('properties', $imageName, 'public');

                $property->images()->create([
                    'image' => $imageName
                ]);
            }
        }

        return redirect()->route('properties.index')
            ->with('success', 'Property Updated Successfully');
    }


    public function destroy(Property $property)
    {
        $this->authorize('delete', $property);

        foreach ($property->images as $image) {
            if (Storage::disk('public')->exists('properties/' . $image->image)) {
                Storage::disk('public')->delete('properties/' . $image->image);
            }
            $image->delete();
        }

        $property->delete();

        return redirect()->back()
            ->with('success', 'Property deleted successfully');
    }


    public function deleteImage($id)
    {
        $image = \App\Models\PropertyImage::findOrFail($id);

        $this->authorize('delete', $image->property);

        if (Storage::disk('public')->exists('properties/' . $image->image)) {
            Storage::disk('public')->delete('properties/' . $image->image);
        }

        $image->delete();

        return back()->with('success', 'Image deleted successfully');
    }


    public function trash()
    {
        $properties = Property::onlyTrashed()->paginate(5);
        return view('admin.properties.trash', compact('properties'));
    }


    public function restore($id)
    {
        Property::onlyTrashed()->findOrFail($id)->restore();
        return back()->with('success', 'Property restored successfully');
    }


    public function forceDelete($id)
    {
        $property = Property::onlyTrashed()->findOrFail($id);

        $this->authorize('delete', $property);

        foreach ($property->images as $image) {
            Storage::disk('public')->delete('properties/' . $image->image);
        }

        $property->forceDelete();

        return back()->with('success', 'Property permanently deleted');
    }

}
