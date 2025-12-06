<?php

namespace App\Http\Controllers;

use App\Models\Fisherfolk;
use App\Models\FisherfolkRenewal;
use App\Models\FisherfolkStatusHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display the dashboard.
     */
    public function index()
    {
        $currentYear = Carbon::now()->year;
        
        // Current month boundaries
        $currentMonthStart = Carbon::now()->startOfMonth();
        $currentMonthEnd = Carbon::now()->endOfMonth();
        
        // Previous month boundaries
        $previousMonthStart = Carbon::now()->subMonth()->startOfMonth();
        $previousMonthEnd = Carbon::now()->subMonth()->endOfMonth();

        // ============================================
        // REGISTRATION STATS FOR CURRENT YEAR
        // ============================================
        
        // New Registrations: Fisherfolk registered in current year (first time registration)
        $newRegistrationsThisYear = Fisherfolk::whereYear('date_registered', $currentYear)->count();
        
        // Renewals: Count of renewals in current year
        $renewalsThisYear = FisherfolkRenewal::where('renewal_year', $currentYear)->count();
        
        // Inactive: Fisherfolk marked as inactive
        $inactiveCount = Fisherfolk::where('status', 'inactive')->count();
        
        // Total Registered (Active) for current year: new + renewed (unique fisherfolk who are active)
        // This is the sum of newly registered this year + those who renewed this year
        $totalActiveThisYear = $newRegistrationsThisYear + $renewalsThisYear;
        
        // For comparison - last year stats
        $lastYear = $currentYear - 1;
        $newRegistrationsLastYear = Fisherfolk::whereYear('date_registered', $lastYear)->count();
        $renewalsLastYear = FisherfolkRenewal::where('renewal_year', $lastYear)->count();
        
        // Calculate year-over-year changes
        $registrationStats = [
            'total' => [
                'count' => $totalActiveThisYear,
                'change' => $this->calculatePercentageChange(
                    $newRegistrationsLastYear + $renewalsLastYear,
                    $totalActiveThisYear
                ),
            ],
            'new' => [
                'count' => $newRegistrationsThisYear,
                'change' => $this->calculatePercentageChange($newRegistrationsLastYear, $newRegistrationsThisYear),
            ],
            'renewed' => [
                'count' => $renewalsThisYear,
                'change' => $this->calculatePercentageChange($renewalsLastYear, $renewalsThisYear),
            ],
            'inactive' => [
                'count' => $inactiveCount,
                // For inactive, we compare with last month's inactive count
                'change' => ['value' => 0, 'direction' => 'neutral'],
            ],
        ];

        // ============================================
        // OVERALL TOTALS
        // ============================================
        $totalRegistered = Fisherfolk::count();
        $maleCount = Fisherfolk::where('sex', 'Male')->count();
        $femaleCount = Fisherfolk::where('sex', 'Female')->count();

        // Activity category totals (current)
        $activityStats = [
            'capture_fishing' => [
                'label' => 'Capture Fishing',
                'icon' => 'fish',
                'count' => Fisherfolk::where('capture_fishing', true)->count(),
                'color' => 'info'
            ],
            'aquaculture' => [
                'label' => 'Aquaculture',
                'icon' => 'ripple',
                'count' => Fisherfolk::where('aquaculture', true)->count(),
                'color' => 'secondary'
            ],
            'gleaning' => [
                'label' => 'Gleaning',
                'icon' => 'basket',
                'count' => Fisherfolk::where('gleaning', true)->count(),
                'color' => 'success'
            ],
            'fish_processing' => [
                'label' => 'Fish Processing',
                'icon' => 'tools-kitchen-2',
                'count' => Fisherfolk::where('fish_processing', true)->count(),
                'color' => 'warning'
            ],
            'vendor' => [
                'label' => 'Fish Vending',
                'icon' => 'shopping-cart',
                'count' => Fisherfolk::where('vendor', true)->count(),
                'color' => 'error'
            ],
            'boat_owner' => [
                'label' => 'Boat Owner/Operator',
                'icon' => 'sailboat',
                'count' => Fisherfolk::where('boat_owneroperator', true)->count(),
                'color' => 'primary'
            ],
        ];

        // Count registered THIS month
        $thisMonthTotal = Fisherfolk::whereBetween('date_registered', [$currentMonthStart, $currentMonthEnd])->count();
        
        // This month activity counts
        $thisMonthActivities = [
            'capture_fishing' => Fisherfolk::where('capture_fishing', true)->whereBetween('date_registered', [$currentMonthStart, $currentMonthEnd])->count(),
            'aquaculture' => Fisherfolk::where('aquaculture', true)->whereBetween('date_registered', [$currentMonthStart, $currentMonthEnd])->count(),
            'gleaning' => Fisherfolk::where('gleaning', true)->whereBetween('date_registered', [$currentMonthStart, $currentMonthEnd])->count(),
            'fish_processing' => Fisherfolk::where('fish_processing', true)->whereBetween('date_registered', [$currentMonthStart, $currentMonthEnd])->count(),
            'vendor' => Fisherfolk::where('vendor', true)->whereBetween('date_registered', [$currentMonthStart, $currentMonthEnd])->count(),
            'boat_owner' => Fisherfolk::where('boat_owneroperator', true)->whereBetween('date_registered', [$currentMonthStart, $currentMonthEnd])->count(),
        ];

        // Count registered LAST month
        $lastMonthTotal = Fisherfolk::whereBetween('date_registered', [$previousMonthStart, $previousMonthEnd])->count();
        
        // Last month activity counts
        $lastMonthActivities = [
            'capture_fishing' => Fisherfolk::where('capture_fishing', true)->whereBetween('date_registered', [$previousMonthStart, $previousMonthEnd])->count(),
            'aquaculture' => Fisherfolk::where('aquaculture', true)->whereBetween('date_registered', [$previousMonthStart, $previousMonthEnd])->count(),
            'gleaning' => Fisherfolk::where('gleaning', true)->whereBetween('date_registered', [$previousMonthStart, $previousMonthEnd])->count(),
            'fish_processing' => Fisherfolk::where('fish_processing', true)->whereBetween('date_registered', [$previousMonthStart, $previousMonthEnd])->count(),
            'vendor' => Fisherfolk::where('vendor', true)->whereBetween('date_registered', [$previousMonthStart, $previousMonthEnd])->count(),
            'boat_owner' => Fisherfolk::where('boat_owneroperator', true)->whereBetween('date_registered', [$previousMonthStart, $previousMonthEnd])->count(),
        ];

        // Calculate percentage changes
        $totalChange = $this->calculatePercentageChange($lastMonthTotal, $thisMonthTotal);
        
        // Calculate activity changes
        foreach ($activityStats as $key => &$stat) {
            $stat['change'] = $this->calculatePercentageChange($lastMonthActivities[$key], $thisMonthActivities[$key]);
        }
        
        // Activity categories count (for charts)
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
            'totalRegistered',
            'maleCount',
            'femaleCount',
            'activityStats',
            'categoriesCount',
            'recentFisherfolk',
            'totalChange',
            'thisMonthTotal',
            'registrationStats',
            'currentYear'
        ));
    }

    /**
     * Calculate percentage change between two values.
     * Returns an array with 'value' (percentage) and 'direction' (up/down/neutral)
     */
    private function calculatePercentageChange($oldValue, $newValue): array
    {
        if ($oldValue == 0 && $newValue == 0) {
            return ['value' => 0, 'direction' => 'neutral'];
        }
        
        if ($oldValue == 0) {
            // If there was nothing last month but something this month, show 100% increase
            return ['value' => 100, 'direction' => 'up'];
        }

        $change = (($newValue - $oldValue) / $oldValue) * 100;
        
        return [
            'value' => round(abs($change), 1),
            'direction' => $change > 0 ? 'up' : ($change < 0 ? 'down' : 'neutral')
        ];
    }
}
