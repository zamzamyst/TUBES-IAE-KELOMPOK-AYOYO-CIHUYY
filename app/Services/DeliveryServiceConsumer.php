<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Exception;

/**
 * DeliveryServiceConsumer
 * 
 * Example service showing how consumer modules (Tracking, Order)
 * should integrate with the DeliveryService Provider API.
 * 
 * This service should be used by any module that needs delivery service data.
 */
class DeliveryServiceConsumer
{
    private string $baseUrl = 'http://localhost/api/v1';
    private int $timeout = 5;

    /**
     * Get all active delivery services from provider
     * 
     * @return array
     * @throws Exception
     */
    public function getAllServices(): array
    {
        try {
            $response = Http::timeout($this->timeout)
                ->get($this->baseUrl . '/delivery-services');

            if ($response->successful()) {
                return $response->json('data', []);
            }

            throw new Exception('Failed to fetch delivery services: ' . $response->status());
        } catch (Exception $e) {
            // Log error and return empty array for graceful degradation
            \Log::error('DeliveryServiceConsumer error: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Get specific delivery service by ID
     * 
     * @param int $serviceId
     * @return array|null
     */
    public function getServiceById(int $serviceId): ?array
    {
        try {
            $response = Http::timeout($this->timeout)
                ->get($this->baseUrl . '/delivery-services/' . $serviceId);

            if ($response->successful()) {
                return $response->json();
            }

            if ($response->notFound()) {
                \Log::warning("Delivery service not found: ID {$serviceId}");
                return null;
            }

            throw new Exception('Failed to fetch delivery service: ' . $response->status());
        } catch (Exception $e) {
            \Log::error('DeliveryServiceConsumer error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Get service with fallback/caching strategy
     * 
     * @param int $serviceId
     * @return array|null
     */
    public function getServiceWithCache(int $serviceId): ?array
    {
        $cacheKey = "delivery_service_{$serviceId}";
        $cachedService = \Cache::get($cacheKey);

        if ($cachedService) {
            return $cachedService;
        }

        $service = $this->getServiceById($serviceId);

        if ($service) {
            // Cache for 1 hour
            \Cache::put($cacheKey, $service, now()->addHour());
        }

        return $service;
    }

    /**
     * Get filtered services (only active)
     * 
     * @return array
     */
    public function getActiveServices(): array
    {
        $services = $this->getAllServices();

        return array_filter($services, function ($service) {
            return $service['is_active'] === true;
        });
    }

    /**
     * Calculate delivery cost and estimation
     * Useful for Order module when creating orders
     * 
     * @param int $serviceId
     * @return array|null Returns array with 'cost' and 'estimation_days' or null
     */
    public function getDeliveryEstimate(int $serviceId): ?array
    {
        $service = $this->getServiceWithCache($serviceId);

        if (!$service) {
            return null;
        }

        return [
            'cost' => $service['price'],
            'estimation_days' => $service['estimation_days'],
            'service_name' => $service['name'],
        ];
    }
}
