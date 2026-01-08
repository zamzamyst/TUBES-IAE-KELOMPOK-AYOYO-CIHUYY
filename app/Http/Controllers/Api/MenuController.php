<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;

class MenuController extends Controller
{
    public function index()
    {
    
    // Fungsi untuk Menampilkan Data Menu (All) via API
    $menu = Menu::latest()->get();

        if ($menu->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'Data Menu tidak tersedia!',
            ], 404);

        } else {
            return response()->json([
                'status' => true,
                'message' => 'Data Menu berhasil ditemukan!',
                'data' => $menu
            ], 200);
        }
    }

    // Fungsi untuk Menampilkan Data Menu (By $id) via API
    public function show($id)
    {
        $menu = Menu::find($id);
        
        if ($menu) {
            return response()->json([
                'status' => true,
                'message' => 'Data Menu (ID: ' . $menu->id . ') berhasil ditemukan!',
                'data' => $menu
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Data Menu (ID: ' . $id . ') tidak ditemukan!',
            ], 404);
        }
    }
}
