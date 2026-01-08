<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\DeliveryServiceResource;
use App\Http\Resources\DeliveryServiceCollection;
use App\Models\DeliveryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DeliveryServiceController extends Controller
{
    /**
     * Public endpoint: Get all active delivery services
     * 
     * @return DeliveryServiceCollection
     */
    public function index(): DeliveryServiceCollection
    {
        $services = DeliveryService::active()
            ->latest()
            ->get();

        return new DeliveryServiceCollection($services);
    }

    /**
     * Public endpoint: Get specific delivery service
     * 
     * @param  int  $id
     * @return DeliveryServiceResource|JsonResponse
     */
    public function show(int $id)
    {
        $service = DeliveryService::active()->find($id);

        if (!$service) {
            return response()->json([
                'message' => 'Delivery service not found',
            ], 404);
        }

        return new DeliveryServiceResource($service);
    }

    /**
     * Protected endpoint: Create new delivery service
     * Required permission: manage_delivery_services
     * 
     * @param  Request  $request
     * @return DeliveryServiceResource|JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        // Check permission
        if (!auth()->check() || !auth()->user()->hasPermissionTo('manage_delivery_services')) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 403);
        }

        $validated = $request->validate([
            'name' => 'required|string|unique:delivery_services',
            'price' => 'required|numeric|min:0',
            'estimation_days' => 'required|integer|min:1',
            'is_active' => 'boolean',
        ]);

        $service = DeliveryService::create($validated);

        return response()->json(
            new DeliveryServiceResource($service),
            201
        );
    }

    /**
     * Protected endpoint: Update delivery service
     * Required permission: manage_delivery_services
     * 
     * @param  Request  $request
     * @param  int  $id
     * @return DeliveryServiceResource|JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        // Check permission
        if (!auth()->check() || !auth()->user()->hasPermissionTo('manage_delivery_services')) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 403);
        }

        $service = DeliveryService::find($id);

        if (!$service) {
            return response()->json([
                'message' => 'Delivery service not found',
            ], 404);
        }

        $validated = $request->validate([
            'name' => 'sometimes|string|unique:delivery_services,name,' . $id,
            'price' => 'sometimes|numeric|min:0',
            'estimation_days' => 'sometimes|integer|min:1',
            'is_active' => 'sometimes|boolean',
        ]);

        $service->update($validated);

        return response()->json(
            new DeliveryServiceResource($service),
            200
        );
    }

    /**
     * Protected endpoint: Delete delivery service
     * Required permission: manage_delivery_services
     * 
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        // Check permission
        if (!auth()->check() || !auth()->user()->hasPermissionTo('manage_delivery_services')) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 403);
        }

        $service = DeliveryService::find($id);

        if (!$service) {
            return response()->json([
                'message' => 'Delivery service not found',
            ], 404);
        }

        $service->delete();

        return response()->json([
            'message' => 'Delivery service deleted successfully',
        ], 200);
    }
}
