<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Fisherfolk;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class StatsController extends Controller
{
    /**
     * Get overall summary statistics.
     */
    public function summary(): JsonResponse
    {
        $data = [
            'total_fisherfolk' => Fisherfolk::count(),
            'male_count' => Fisherfolk::where('sex', 'Male')->count(),
            'female_count' => Fisherfolk::where('sex', 'Female')->count(),
            'distinct_barangays' => Fisherfolk::distinct('address')->count('address'),
        ];

        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => 'Summary statistics retrieved successfully',
        ]);
    }

    /**
     * Get count of fisherfolk per barangay.
     */
    public function barangay(): JsonResponse
    {
        $data = Fisherfolk::select('address', DB::raw('count(*) as count'))
            ->groupBy('address')
            ->orderBy('count', 'desc')
            ->get()
            ->map(function ($item) {
                return [
                    'barangay' => $item->address,
                    'count' => $item->count,
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => 'Barangay statistics retrieved successfully',
        ]);
    }

    /**
     * Get gender distribution.
     */
    public function gender(): JsonResponse
    {
        $data = Fisherfolk::select('sex', DB::raw('count(*) as count'))
            ->groupBy('sex')
            ->get()
            ->map(function ($item) {
                return [
                    'gender' => $item->sex,
                    'count' => $item->count,
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => 'Gender statistics retrieved successfully',
        ]);
    }

    /**
     * Get age group distribution.
     */
    public function ageGroup(): JsonResponse
    {
        $fisherfolk = Fisherfolk::all();
        
        $ageGroups = [
            '18-25' => 0,
            '26-35' => 0,
            '36-45' => 0,
            '46-55' => 0,
            '56-65' => 0,
            '66+' => 0,
        ];

        foreach ($fisherfolk as $person) {
            $ageGroup = $person->getAgeGroup();
            $ageGroups[$ageGroup]++;
        }

        $data = collect($ageGroups)->map(function ($count, $group) {
            return [
                'age_group' => $group,
                'count' => $count,
            ];
        })->values();

        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => 'Age group statistics retrieved successfully',
        ]);
    }

    /**
     * Get count per activity category.
     */
    public function category(): JsonResponse
    {
        $stats = DB::table('fisherfolk')
            ->selectRaw('
                SUM(boat_owneroperator) as boat_owner_count,
                SUM(capture_fishing) as capture_fishing_count,
                SUM(gleaning) as gleaning_count,
                SUM(vendor) as vendor_count,
                SUM(fish_processing) as fish_processing_count,
                SUM(aquaculture) as aquaculture_count
            ')
            ->first();

        $data = [
            ['category' => 'Boat Owner/Operator', 'count' => $stats->boat_owner_count],
            ['category' => 'Capture Fishing', 'count' => $stats->capture_fishing_count],
            ['category' => 'Gleaning', 'count' => $stats->gleaning_count],
            ['category' => 'Vendor', 'count' => $stats->vendor_count],
            ['category' => 'Fish Processing', 'count' => $stats->fish_processing_count],
            ['category' => 'Aquaculture', 'count' => $stats->aquaculture_count],
        ];

        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => 'Category statistics retrieved successfully',
        ]);
    }

    /**
     * Get barangay-category cross-analysis.
     */
    public function barangayCategory(): JsonResponse
    {
        $barangays = Fisherfolk::select('address')
            ->distinct()
            ->orderBy('address')
            ->pluck('address');

        $data = [];

        foreach ($barangays as $barangay) {
            $stats = DB::table('fisherfolk')
                ->where('address', $barangay)
                ->selectRaw('
                    SUM(boat_owneroperator) as boat_owner,
                    SUM(capture_fishing) as capture,
                    SUM(gleaning) as gleaning,
                    SUM(vendor) as vendor,
                    SUM(fish_processing) as processing,
                    SUM(aquaculture) as aquaculture
                ')
                ->first();

            $data[] = [
                'barangay' => $barangay,
                'boat_owner' => $stats->boat_owner,
                'capture_fishing' => $stats->capture,
                'gleaning' => $stats->gleaning,
                'vendor' => $stats->vendor,
                'fish_processing' => $stats->processing,
                'aquaculture' => $stats->aquaculture,
            ];
        }

        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => 'Barangay-category statistics retrieved successfully',
        ]);
    }
}
