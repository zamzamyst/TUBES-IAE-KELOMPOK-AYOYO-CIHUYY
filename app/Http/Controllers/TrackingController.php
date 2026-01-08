<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tracking;
use App\Models\Delivery;
use DB;

class TrackingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $trackings = Tracking::with(['delivery.order'])->orderBy('created_at', 'DESC')->get();

        return view('tracking.index', compact('trackings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($delivery_id)
    {
        $delivery = Delivery::with('order')->findOrFail($delivery_id);
        
        // Check if tracking already exists for this delivery
        if ($delivery->tracking) {
            return redirect()->route('tracking.show', $delivery->tracking->id)
                ->with('info', 'Tracking sudah ada untuk delivery ini.');
        }

        return view('tracking.create', compact('delivery'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'delivery_id' => 'required|integer',
        ]);

        // Check if delivery exists in mysql_delivery
        if (!DB::connection('mysql_delivery')->table('deliveries')->where('id', $request->delivery_id)->exists()) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'The selected delivery is invalid.');
        }

        // Check if tracking already exists for this delivery
        if (DB::connection('mysql_tracking')->table('trackings')->where('delivery_id', $request->delivery_id)->exists()) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'A tracking already exists for this delivery.');
        }

        // Generate random coordinates within Indonesia
        $coordinates = Tracking::generateRandomCoordinates();

        $tracking = Tracking::create([
            'delivery_id' => $request->delivery_id,
            'latitude' => $coordinates['latitude'],
            'longitude' => $coordinates['longitude'],
        ]);

        return redirect()->route('tracking')->with('success', 'Tracking berhasil ditambahkan dengan koordinat acak!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $tracking = Tracking::with(['delivery.order'])->findOrFail($id);

        return view('tracking.show', compact('tracking'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $tracking = Tracking::with(['delivery.order'])->findOrFail($id);

        return view('tracking.edit', compact('tracking'));
    }

    /**
     * Update the specified resource in storage.
     * Special behavior: If tracking doesn't exist, create it. Otherwise, update coordinates.
     */
    public function update(Request $request, string $id)
    {
        $tracking = Tracking::find($id);

        if (!$tracking) {
            // If tracking doesn't exist, behave like create
            $request->validate([
                'delivery_id' => 'required|integer',
            ]);

            // Check if delivery exists in mysql_delivery
            if (!DB::connection('mysql_delivery')->table('deliveries')->where('id', $request->delivery_id)->exists()) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'The selected delivery is invalid.');
            }

            // Check if tracking already exists for this delivery
            if (DB::connection('mysql_tracking')->table('trackings')->where('delivery_id', $request->delivery_id)->exists()) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'A tracking already exists for this delivery.');
            }

            $coordinates = Tracking::generateRandomCoordinates();

            $tracking = Tracking::create([
                'delivery_id' => $request->delivery_id,
                'latitude' => $coordinates['latitude'],
                'longitude' => $coordinates['longitude'],
            ]);

            return redirect()->route('tracking')->with('success', 'Tracking berhasil dibuat dengan koordinat baru!');
        }

        // If tracking exists, update with new random coordinates
        $coordinates = Tracking::generateRandomCoordinates();

        $tracking->update([
            'latitude' => $coordinates['latitude'],
            'longitude' => $coordinates['longitude'],
        ]);
        
        return redirect()->route('tracking')->with('success', 'Koordinat tracking berhasil diperbarui!');
    }

    /**
     * Alternative update method by delivery_id for easier access
     */
    public function updateByDelivery(Request $request, string $delivery_id)
    {
        $delivery = Delivery::findOrFail($delivery_id);
        $tracking = $delivery->tracking;

        if (!$tracking) {
            // Create new tracking if doesn't exist
            $coordinates = Tracking::generateRandomCoordinates();

            $tracking = Tracking::create([
                'delivery_id' => $delivery_id,
                'latitude' => $coordinates['latitude'],
                'longitude' => $coordinates['longitude'],
            ]);

            return redirect()->route('tracking.show', $tracking->id)
                ->with('success', 'Tracking berhasil dibuat dengan koordinat baru!');
        }

        // Update existing tracking with new coordinates
        $coordinates = Tracking::generateRandomCoordinates();

        $tracking->update([
            'latitude' => $coordinates['latitude'],
            'longitude' => $coordinates['longitude'],
        ]);

        return redirect()->route('tracking.show', $tracking->id)
            ->with('success', 'Koordinat tracking berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Check if user is admin
        if (!auth()->user()->hasRole('admin')) {
            return redirect()->route('tracking')->with('error', 'Hanya admin yang dapat menghapus tracking!');
        }

        $tracking = Tracking::findOrFail($id);
        $tracking->delete();

        return redirect()->route('tracking')->with('success', 'Tracking berhasil dihapus!');
    }
}
