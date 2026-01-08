<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Delivery;
use App\Models\Order;
use App\Models\DeliveryService;
use DB;

class DeliveryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $deliveries = Delivery::with(['order', 'deliveryService'])->orderBy('created_at', 'DESC')->get();

        return view('delivery.index', compact('deliveries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($order_id)
    {
        $order = Order::findOrFail($order_id);
        
        // Check if delivery already exists for this order
        if ($order->delivery) {
            return redirect()->route('delivery.show', $order->delivery->id)
                ->with('info', 'Delivery sudah ada untuk order ini.');
        }

        $services = DeliveryService::active()->get();

        return view('delivery.create', compact('order', 'services'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'required|integer',
            'delivery_service_id' => 'required|integer',
            'delivery_address' => 'required|string',
            'delivery_status' => 'required|in:pending,in_transit,delivered,cancelled',
        ]);

        // Check if order exists in mysql_order
        if (!DB::connection('mysql_order')->table('orders')->where('id', $validated['order_id'])->exists()) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'The selected order is invalid.');
        }

        // Check if delivery already exists for this order
        if (DB::connection('mysql_delivery')->table('deliveries')->where('order_id', $validated['order_id'])->exists()) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'A delivery already exists for this order.');
        }

        // Check if delivery service exists in mysql_delivery
        if (!DB::connection('mysql_delivery')->table('delivery_services')->where('id', $validated['delivery_service_id'])->exists()) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'The selected delivery service is invalid.');
        }

        $delivery = Delivery::create($validated);

        return redirect()->route('delivery')->with('success', 'Delivery berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $delivery = Delivery::with(['order', 'tracking', 'deliveryService'])->findOrFail($id);

        return view('delivery.show', compact('delivery'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $delivery = Delivery::with('order')->findOrFail($id);
        $services = DeliveryService::active()->get();

        return view('delivery.edit', compact('delivery', 'services'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $delivery = Delivery::findOrFail($id);

        $validated = $request->validate([
            'delivery_service_id' => 'required|exists:delivery_services,id',
            'delivery_address' => 'required|string',
            'delivery_status' => 'required|in:pending,in_transit,delivered,cancelled',
        ]);

        $delivery->update($validated);
        
        return redirect()->route('delivery')->with('success', 'Delivery berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Check if user is admin
        if (!auth()->user()->hasRole('admin')) {
            return redirect()->route('delivery')->with('error', 'Hanya admin yang dapat menghapus delivery!');
        }

        $delivery = Delivery::findOrFail($id);
        $delivery->delete();

        return redirect()->route('delivery')->with('success', 'Delivery berhasil dihapus!');
    }
}
