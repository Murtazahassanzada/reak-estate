<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\User;
use App\Models\Report;
use App\Models\Contact;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProperties = Property::count();
        $totalUsers = User::count();
        $totalReports = Report::count();
        $totalContacts = Contact::count();

        // ✅ NEW STATS
        $forSale = Property::where('purpose','sale')->count();
        $forRent = Property::where('purpose','rent')->count();
        $customers = User::where('role','user')->count();

        // ✅ latest properties
        $properties = Property::latest()->take(6)->get();

        return view('admin.dashboard', compact(
            'totalProperties',
            'totalUsers',
            'totalReports',
            'totalContacts',
            'forSale',
            'forRent',
            'customers',
            'properties'
        ));
    }
}
