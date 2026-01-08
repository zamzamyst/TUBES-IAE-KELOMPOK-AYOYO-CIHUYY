<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tracking;
use App\Models\Delivery;

class TrackingController extends Controller
{
    // Fungsi untuk Menampilkan Data Tracking (All) via API
    public function index()
    {
        $trackings = Tracking::with(['delivery.order'])->latest()->get();

        if ($trackings->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'Data Tracking tidak tersedia!',
            ], 404);
        } else {
            return response()->json([
                'status' => true,
                'message' => 'Data Tracking berhasil ditemukan!',
                'data' => $trackings
            ], 200);
        }
    }

    // Fungsi untuk Menampilkan Data Tracking (By ID) via API
    public function show($id)
    {
        $tracking = Tracking::with(['delivery.order'])->find($id);
        
        if ($tracking) {
            return response()->json([
                'status' => true,
                'message' => 'Data Tracking (ID: ' . $tracking->id . ') berhasil ditemukan!',
                'data' => $tracking
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Data Tracking (ID: ' . $id . ') tidak ditemukan!',
            ], 404);
        }
    }

    // Fungsi untuk Membuat Data Tracking Baru via API
    public function store(Request $request)
    {
        $request->validate([
            'delivery_id' => 'required|exists:deliveries,id|unique:trackings,delivery_id',
        ]);

        // Generate random coordinates within Indonesia bounds
        $coordinates = Tracking::generateRandomCoordinates();

        $tracking = Tracking::create([
            'delivery_id' => $request->delivery_id,
            'latitude' => $coordinates['latitude'],
            'longitude' => $coordinates['longitude'],
        ]);

        $tracking->load(['delivery.order']);

        return response()->json([
            'status' => true,
            'message' => 'Data Tracking berhasil ditambahkan dengan koordinat acak!',
            'data' => $tracking
        ], 201);
    }

    // Fungsi untuk Mengupdate Data Tracking via API
    // Special behavior: If tracking doesn't exist, create it. Otherwise, update coordinates.
    public function update(Request $request, $id)
    {
        $tracking = Tracking::find($id);

        if (!$tracking) {
            // If tracking doesn't exist, behave like create
            $request->validate([
                'delivery_id' => 'required|exists:deliveries,id|unique:trackings,delivery_id',
            ]);

            $coordinates = Tracking::generateRandomCoordinates();

            $tracking = Tracking::create([
                'delivery_id' => $request->delivery_id,
                'latitude' => $coordinates['latitude'],
                'longitude' => $coordinates['longitude'],
            ]);

            $tracking->load(['delivery.order']);

            return response()->json([
                'status' => true,
                'message' => 'Data Tracking berhasil dibuat dengan koordinat baru!',
                'data' => $tracking
            ], 201);
        }

        // If tracking exists, update with new random coordinates
        $coordinates = Tracking::generateRandomCoordinates();

        $tracking->update([
            'latitude' => $coordinates['latitude'],
            'longitude' => $coordinates['longitude'],
        ]);

        $tracking->load(['delivery.order']);

        return response()->json([
            'status' => true,
            'message' => 'Koordinat tracking berhasil diperbarui!',
            'data' => $tracking
        ], 200);
    }

    // Fungsi untuk Mengupdate Tracking berdasarkan Delivery ID via API
    public function updateByDelivery(Request $request, $delivery_id)
    {
        $delivery = Delivery::find($delivery_id);

        if (!$delivery) {
            return response()->json([
                'status' => false,
                'message' => 'Data Delivery (ID: ' . $delivery_id . ') tidak ditemukan!',
            ], 404);
        }

        $tracking = $delivery->tracking;

        if (!$tracking) {
            // Create new tracking if doesn't exist
            $coordinates = Tracking::generateRandomCoordinates();

            $tracking = Tracking::create([
                'delivery_id' => $delivery_id,
                'latitude' => $coordinates['latitude'],
                'longitude' => $coordinates['longitude'],
            ]);

            $tracking->load(['delivery.order']);

            return response()->json([
                'status' => true,
                'message' => 'Data Tracking berhasil dibuat dengan koordinat baru!',
                'data' => $tracking
            ], 201);
        }

        // Update existing tracking with new coordinates
        $coordinates = Tracking::generateRandomCoordinates();

        $tracking->update([
            'latitude' => $coordinates['latitude'],
            'longitude' => $coordinates['longitude'],
        ]);

        $tracking->load(['delivery.order']);

        return response()->json([
            'status' => true,
            'message' => 'Koordinat tracking berhasil diperbarui!',
            'data' => $tracking
        ], 200);
    }

    // Fungsi untuk Menghapus Data Tracking via API
    public function destroy($id)
    {
        $tracking = Tracking::find($id);

        if (!$tracking) {
            return response()->json([
                'status' => false,
                'message' => 'Data Tracking (ID: ' . $id . ') tidak ditemukan!',
            ], 404);
        }

        $tracking->delete();

        return response()->json([
            'status' => true,
            'message' => 'Data Tracking (ID: ' . $id . ') berhasil dihapus!',
        ], 200);
    }
}
