<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        // کارت‌ها
        $totalProperties = Property::count();
         $activeProperties = Property::where('status', 'approved')->count();
        //$activeProperties = Property::where('status', 'Active')->count(); // حروف بزرگ با جدول مطابقت داشته باشد
        $deletedProperties = Property::onlyTrashed()->count();

        // گزارش ماهانه
     $monthlyReport = Property::withTrashed()
    ->select(
        DB::raw('MONTH(created_at) as month'),
        DB::raw('COUNT(*) as added'),
        DB::raw('SUM(CASE WHEN deleted_at IS NOT NULL THEN 1 ELSE 0 END) as deleted'),
        DB::raw('SUM(CASE WHEN status = "Active" AND deleted_at IS NULL THEN 1 ELSE 0 END) as active')
    )
    ->groupBy('month')
    ->get();

        return view('report', compact(
            'totalProperties',
            'activeProperties',
            'deletedProperties',
            'monthlyReport'
        ));
    }
}
