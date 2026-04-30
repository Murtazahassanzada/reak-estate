<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function store($id)
    {
        $user = Auth::user();

        $property = Property::findOrFail($id);

        // ✅ toggle حرفه‌ای
        if ($user->favorites()->where('property_id', $id)->exists()) {

            $user->favorites()->detach($id);

            return back()->with('success', 'Removed from saved');
        }

        $user->favorites()->attach($id);

        return back()->with('success', 'Saved successfully');
    }
}