<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Delivery;

class DeliveryController extends Controller
{
    // Fungsi untuk Menampilkan Data Delivery (All) via API
    public function index()
    {
        $deliveries = Delivery::with(['order', 'tracking'])->latest()->get();

        if ($deliveries->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'Data Delivery tidak tersedia!',
            ], 404);
        } else {
            return response()->json([
                'status' => true,
                'message' => 'Data Delivery berhasil ditemukan!',
                'data' => $deliveries
            ], 200);
        }
    }

    // Fungsi untuk Menampilkan Data Delivery (By ID) via API
    public function show($id) 
    {
        $delivery = Delivery::with(['order', 'tracking'])->find($id);
        
        if ($delivery) {
            return response()->json([
                'status' => true,
                'message' => 'Data Delivery (ID: ' . $delivery->id . ') berhasil ditemukan!',
                'data' => $delivery
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Data Delivery (ID: ' . $id . ') tidak ditemukan!',
            ], 404);
        }
    }

    // Fungsi untuk Membuat Data Delivery Baru via API
    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'required|exists:orders,id|unique:deliveries,order_id',
            'delivery_address' => 'required|string',
            'delivery_status' => 'required|in:pending,in_transit,delivered,cancelled',
        ]);

        $delivery = Delivery::create($validated);
        $delivery->load(['order', 'tracking']);

        return response()->json([
            'status' => true,
            'message' => 'Data Delivery berhasil ditambahkan!',
            'data' => $delivery
        ], 201);
    }

    // Fungsi untuk Mengupdate Data Delivery via API
    public function update(Request $request, $id)
    {
        $delivery = Delivery::find($id);

        if (!$delivery) {
            return response()->json([
                'status' => false,
                'message' => 'Data Delivery (ID: ' . $id . ') tidak ditemukan!',
            ], 404);
        }

        $validated = $request->validate([
            'delivery_address' => 'required|string',
            'delivery_status' => 'required|in:pending,in_transit,delivered,cancelled',
        ]);

        $delivery->update($validated);
        $delivery->load(['order', 'tracking']);

        return response()->json([
            'status' => true,
            'message' => 'Data Delivery (ID: ' . $delivery->id . ') berhasil diperbarui!',
            'data' => $delivery
        ], 200);
    }

    // Fungsi untuk Menghapus Data Delivery via API
    public function destroy($id)
    {
        $delivery = Delivery::find($id);

        if (!$delivery) {
            return response()->json([
                'status' => false,
                'message' => 'Data Delivery (ID: ' . $id . ') tidak ditemukan!',
            ], 404);
        }

        $delivery->delete();

        return response()->json([
            'status' => true,
            'message' => 'Data Delivery (ID: ' . $id . ') berhasil dihapus!',
        ], 200);
    }
}
