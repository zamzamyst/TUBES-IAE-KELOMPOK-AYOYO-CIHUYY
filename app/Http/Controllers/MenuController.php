<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use DB;

class MenuController extends Controller
{
    /**
         * Display a listing of the resource.
         */
    public function index()
    {
        $menu = Menu::orderBy('created_at', 'DESC')->get();

        return view('menu.index', compact('menu'));
    }

    /**
         * Show the form for creating a new resource.
         */
    public function create()
    {
        return view('menu.create');
    }

    /**
         * Store a newly created resource in storage.
         */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'menu_code' => 'required|string|max:50',
            'name' => 'required|string|max:100',
            'price' => 'required|numeric',
            'description' => 'required|string'
        ]);

        // Check for duplicate menu_code manually
        if (DB::connection('mysql_menu')->table('menus')->where('menu_code', $validated['menu_code'])->exists()) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Menu code already exists!');
        }

        Menu::create($validated);

        return redirect()->route('menu')->with('success', 'Menu berhasil ditambahkan!');
    }

    /**
         * Display the specified resource.
         */
    public function show(string $id)
    {
        $menu = Menu::findOrFail($id);

        return view('menu.show', compact('menu'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $menu = Menu::findOrFail($id);

        return view('menu.edit', compact('menu'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $menu = Menu::findOrFail($id);

        $validated = $request->validate([
            'menu_code' => 'required|string|max:50',
            'name' => 'required|string|max:100',
            'price' => 'required|numeric',
            'description' => 'required|string'
        ]);

        // Check for duplicate menu_code manually (excluding current record)
        if (DB::connection('mysql_menu')->table('menus')->where('menu_code', $validated['menu_code'])->where('id', '!=', $id)->exists()) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Menu code already exists!');
        }

        $menu->update($validated);

        return redirect()->route('menu')->with('success', 'Menu updated successfully');
    }

    /**
         * Remove the specified resource from storage.
         */
    public function destroy(string $id)
    {
        $menu = Menu::find($id);

        if (!$menu) {
            return redirect()
                ->route('menu')
                ->with('error', 'Menu not found');
        }

        $menu->delete();

        return redirect()
            ->route('menu')
            ->with('success', 'Menu deleted successfully');
    }
}