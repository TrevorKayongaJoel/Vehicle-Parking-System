<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ParkingRecord;
use caborn\Carbon;




class ParkingReportController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->input('filter', 'daily'); // 'daily' or 'monthly'
        $format = $filter === 'monthly' ? '%Y-%m' : '%Y-%m-%d';
    
        $reports = \App\Models\ParkingRecord::whereNotNull('check_out_time')
            ->selectRaw("strftime('$format', check_in_time) as period, COUNT(*) as total_checkins, SUM(fee) as total_revenue")
            ->groupBy('period')
            ->orderByDesc('period')
            ->get();
    
        return inertia('Admin/ParkingReports', [
            'reports' => $reports,
            'filter' => $filter
        ]);
    }
    
}
