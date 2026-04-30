<?php

namespace App\Services;

use App\Models\Property;
use Illuminate\Http\Request;

class PropertySearchService
{
    public function apply(Request $request)
    {
        $query = Property::with('images')
            ->where('status', 'active');

        if ($request->filled('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        if ($request->filled('purpose')) {
            $query->where('purpose', $request->purpose);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        return $query;
    }
}
