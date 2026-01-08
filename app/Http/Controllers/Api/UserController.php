<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    // Fungsi untuk Menampilkan Data User (All) via API
    public function index()
    {
        $users = User::latest()->get();

        if ($users->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'Data User tidak tersedia!',
            ], 404);
        } else {
            return response()->json([
                'status' => true,
                'message' => 'Data User berhasil ditemukan!',
                'data' => $users
            ], 200);
        }
    }

    // Fungsi untuk Menampilkan Data User (By $id) via API
    public function show($id)
    {
        $user = User::find($id);
        
        if ($user) {
            return response()->json([
                'status' => true,
                'message' => 'Data User (ID: ' . $user->id . ') berhasil ditemukan!',
                'data' => $user
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Data User (ID: ' . $id . ') tidak ditemukan!',
            ], 404);
        }
    }
}
