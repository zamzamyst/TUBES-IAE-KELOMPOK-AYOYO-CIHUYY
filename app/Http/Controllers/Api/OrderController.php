<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;


class OrderController extends Controller
{
    // Fungsi untuk Menampilkan Data Order (All) via API
    public function index()
    {
        $orders = Order::latest()->get();

        if ($orders->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'Data Order tidak tersedia!',
            ], 404);
        } else {
            return response()->json([
                'status' => true,
                'message' => 'Data Order berhasil ditemukan!',
                'data' => $orders
            ], 200);
        }
    }

    // Fungsi untuk Menampilkan Data Order (By $id) via API
    public function show($id)
    {
        $order = Order::find($id);
        
        if ($order) {
            return response()->json([
                'status' => true,
                'message' => 'Data Order (ID: ' . $order->id . ') berhasil ditemukan!',
                'data' => $order
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Data Order (ID: ' . $id . ') tidak ditemukan!',
            ], 404);
        }
    }
}
