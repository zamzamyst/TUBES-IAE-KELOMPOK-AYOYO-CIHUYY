<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DeliveryService;
use DB;

class DeliveryServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = DeliveryService::orderBy('created_at', 'DESC')->get();

        return view('delivery-service.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('delivery-service.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
            'estimation_days' => 'required|integer|min:0',
            'is_active' => 'boolean'
        ]);

        // Check for duplicate name manually
        if (DB::connection('mysql_delivery')->table('delivery_services')->where('name', $validated['name'])->exists()) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Service name already exists!');
        }

        DeliveryService::create($validated);

        return redirect()->route('delivery-service')->with('success', 'Layanan pengiriman berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $service = DeliveryService::findOrFail($id);

        return view('delivery-service.show', compact('service'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $service = DeliveryService::findOrFail($id);

        return view('delivery-service.edit', compact('service'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $service = DeliveryService::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
            'estimation_days' => 'required|integer|min:0',
            'is_active' => 'boolean'
        ]);

        // Check for duplicate name manually (excluding current record)
        if (DB::connection('mysql_delivery')->table('delivery_services')->where('name', $validated['name'])->where('id', '!=', $id)->exists()) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Service name already exists!');
        }

        $service->update($validated);

        return redirect()->route('delivery-service')->with('success', 'Layanan pengiriman berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Check if user is admin
        if (!auth()->user()->hasRole('admin')) {
            return redirect()->route('delivery-service')->with('error', 'Hanya admin yang dapat menghapus layanan pengiriman!');
        }

        $service = DeliveryService::findOrFail($id);
        $service->delete();

        return redirect()->route('delivery-service')->with('success', 'Layanan pengiriman berhasil dihapus!');
    }
}
