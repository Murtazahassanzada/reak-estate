<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;
use App\Models\User;
use App\Events\NotificationCreated;


class PropertyController extends Controller
{
    public function store(Request $request)
    {
        // ✅ VALIDATION (clean + production-safe)
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'location'    => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
            'bedrooms'    => 'required|integer|min:0',
            'bathrooms'   => 'required|integer|min:0',
            'area'        => 'required|integer|min:0',
            'type'        => 'required|string',
            'purpose'     => 'required|string',
        ]);

        // ✅ CREATE PROPERTY (always pending like Bayut workflow)
        $property = Property::create([
            ...$data,
            'user_id' => Auth::id(),
          'status' => 'pending',
        ]);

        // ✅ NOTIFY ALL ADMINS (not only one admin → enterprise correct)
     $admins = User::admins()->get();

        foreach ($admins as $admin) {

            $notification = Notification::create([
                'user_id'     => $admin->id,
                'type'        => 'property',
                'title'       => 'New Property Pending Review',
                'body'        => Auth::user()->name . ' submitted a new property for approval.',
                'property_id' => $property->id,
            ]);

            // optional safe event trigger
            try {
                event(new NotificationCreated($notification));
            } catch (\Throwable $e) {
                \Log::error('Notification event failed: ' . $e->getMessage());
            }
        }

        return back()->with('success', 'Property submitted for admin approval');
    }
}
