<?php

namespace App\Http\Controllers;

use App\Models\Fisherfolk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FisherfolkController extends Controller
{
    /**
     * Display a listing of fisherfolk.
     */
    public function index(Request $request)
    {
        $query = Fisherfolk::query();

        // Search functionality
        if ($request->has('search') && $request->search) {
            $query->search($request->search);
        }

        // Filter by barangay
        if ($request->has('barangay') && $request->barangay) {
            $query->byBarangay($request->barangay);
        }

        // Filter by sex
        if ($request->has('sex') && $request->sex) {
            $query->bySex($request->sex);
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'date_registered');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        // Pagination
        $fisherfolk = $query->paginate(15);

        // Get unique barangays for filter dropdown
        $barangays = Fisherfolk::distinct('address')
            ->orderBy('address')
            ->pluck('address');

        return view('fisherfolk.index', compact('fisherfolk', 'barangays'));
    }

    /**
     * Show the form for creating a new fisherfolk.
     */
    public function create()
    {
        return view('fisherfolk.create');
    }

    /**
     * Store a newly created fisherfolk in database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_number' => 'required|string|max:50|unique:fisherfolk,id_number',
            'full_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date|before:today',
            'address' => 'required|string|max:255',
            'sex' => 'required|in:Male,Female',
            'contact_number' => 'nullable|string|max:20',
            'rsbsa' => 'nullable|string|max:50',
            'image' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'signature' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'boat_owneroperator' => 'boolean',
            'capture_fishing' => 'boolean',
            'gleaning' => 'boolean',
            'vendor' => 'boolean',
            'fish_processing' => 'boolean',
            'aquaculture' => 'boolean',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $imageName = $validated['id_number'] . '.' . strtoupper($request->file('image')->getClientOriginalExtension());
            $request->file('image')->storeAs('uploads', $imageName, 'public');
            $validated['image'] = $imageName;
        }

        // Handle signature upload
        if ($request->hasFile('signature')) {
            $signatureName = $validated['id_number'] . '_signature.' . strtoupper($request->file('signature')->getClientOriginalExtension());
            $request->file('signature')->storeAs('uploads', $signatureName, 'public');
            $validated['signature'] = $signatureName;
        }

        // Convert checkbox values
        $validated['boat_owneroperator'] = $request->has('boat_owneroperator');
        $validated['capture_fishing'] = $request->has('capture_fishing');
        $validated['gleaning'] = $request->has('gleaning');
        $validated['vendor'] = $request->has('vendor');
        $validated['fish_processing'] = $request->has('fish_processing');
        $validated['aquaculture'] = $request->has('aquaculture');

        Fisherfolk::create($validated);

        return redirect()->route('fisherfolk.index')
            ->with('success', 'Fisherfolk record created successfully!');
    }

    /**
     * Display the specified fisherfolk.
     */
    public function show(string $id)
    {
        $fisherfolk = Fisherfolk::findOrFail($id);
        return view('fisherfolk.show', compact('fisherfolk'));
    }

    /**
     * Show the form for editing the specified fisherfolk.
     */
    public function edit(string $id)
    {
        $fisherfolk = Fisherfolk::findOrFail($id);
        return view('fisherfolk.edit', compact('fisherfolk'));
    }

    /**
     * Update the specified fisherfolk in database.
     */
    public function update(Request $request, string $id)
    {
        $fisherfolk = Fisherfolk::findOrFail($id);

        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date|before:today',
            'address' => 'required|string|max:255',
            'sex' => 'required|in:Male,Female',
            'contact_number' => 'nullable|string|max:20',
            'rsbsa' => 'nullable|string|max:50',
            'image' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'signature' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'boat_owneroperator' => 'boolean',
            'capture_fishing' => 'boolean',
            'gleaning' => 'boolean',
            'vendor' => 'boolean',
            'fish_processing' => 'boolean',
            'aquaculture' => 'boolean',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($fisherfolk->image) {
                Storage::disk('public')->delete('uploads/' . $fisherfolk->image);
            }
            
            $imageName = $fisherfolk->id_number . '.' . strtoupper($request->file('image')->getClientOriginalExtension());
            $request->file('image')->storeAs('uploads', $imageName, 'public');
            $validated['image'] = $imageName;
        }

        // Handle signature upload
        if ($request->hasFile('signature')) {
            // Delete old signature
            if ($fisherfolk->signature) {
                Storage::disk('public')->delete('uploads/' . $fisherfolk->signature);
            }
            
            $signatureName = $fisherfolk->id_number . '_signature.' . strtoupper($request->file('signature')->getClientOriginalExtension());
            $request->file('signature')->storeAs('uploads', $signatureName, 'public');
            $validated['signature'] = $signatureName;
        }

        // Convert checkbox values
        $validated['boat_owneroperator'] = $request->has('boat_owneroperator');
        $validated['capture_fishing'] = $request->has('capture_fishing');
        $validated['gleaning'] = $request->has('gleaning');
        $validated['vendor'] = $request->has('vendor');
        $validated['fish_processing'] = $request->has('fish_processing');
        $validated['aquaculture'] = $request->has('aquaculture');

        $fisherfolk->update($validated);

        return redirect()->route('fisherfolk.index')
            ->with('success', 'Fisherfolk record updated successfully!');
    }

    /**
     * Remove the specified fisherfolk from database.
     */
    public function destroy(string $id)
    {
        $fisherfolk = Fisherfolk::findOrFail($id);

        // Delete associated files
        if ($fisherfolk->image) {
            Storage::disk('public')->delete('uploads/' . $fisherfolk->image);
        }
        if ($fisherfolk->signature) {
            Storage::disk('public')->delete('uploads/' . $fisherfolk->signature);
        }

        $fisherfolk->delete();

        return redirect()->route('fisherfolk.index')
            ->with('success', 'Fisherfolk record deleted successfully!');
    }
}
