<?php

namespace App\Http\Controllers;

use App\Models\Fisherfolk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display the dashboard.
     */
    public function index()
    {
        // Summary statistics
        $totalFisherfolk = Fisherfolk::count();
        $maleCount = Fisherfolk::where('sex', 'Male')->count();
        $femaleCount = Fisherfolk::where('sex', 'Female')->count();
        $distinctBarangays = Fisherfolk::distinct('address')->count('address');
        
        // Activity categories count
        $categoriesCount = DB::table('fisherfolk')
            ->selectRaw('
                SUM(boat_owneroperator) as boat_owner,
                SUM(capture_fishing) as capture,
                SUM(gleaning) as gleaning,
                SUM(vendor) as vendor,
                SUM(fish_processing) as processing,
                SUM(aquaculture) as aquaculture
            ')
            ->first();

        // Recent fisherfolk
        $recentFisherfolk = Fisherfolk::orderBy('date_registered', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'totalFisherfolk',
            'maleCount',
            'femaleCount',
            'distinctBarangays',
            'categoriesCount',
            'recentFisherfolk'
        ));
    }
}
