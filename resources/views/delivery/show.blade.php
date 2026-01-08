<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Delivery') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h1 class="text-2xl font-bold mb-2">Delivery - {{ $delivery->id }}</h1>
                <hr class="mb-6" />

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Delivery ID</label>
                        <input type="text" class="form-input w-full" value="{{ $delivery->id }}" readonly>
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Order ID</label>
                        <input type="text" class="form-input w-full" value="{{ $delivery->order_id }}" readonly>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Menu Name</label>
                        <input type="text" class="form-input w-full" value="{{ $delivery->order->name ?? '-' }}"
                            readonly>
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Quantity</label>
                        <input type="text" class="form-input w-full" value="{{ $delivery->order->quantity ?? '-' }}"
                            readonly>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Delivery Address</label>
                        <textarea class="form-input w-full" rows="3" readonly>{{ $delivery->delivery_address }}</textarea>
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Status</label>
                        <input type="text" class="form-input w-full" value="{{ $delivery->formatted_status }}"
                            readonly>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Service Name</label>
                        <input type="text" class="form-input w-full" value="{{ $delivery->deliveryService->name ?? '-' }}" readonly>
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Service Price</label>
                        <input type="text" class="form-input w-full" 
                            value="Rp{{ number_format($delivery->deliveryService->price ?? 0, 0, ',', '.') }}" readonly>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Estimation Days</label>
                        <input type="text" class="form-input w-full" value="{{ $delivery->deliveryService->estimation_days ?? '-' }} hari" readonly>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Created At</label>
                        <input type="text" class="form-input w-full" value="{{ $delivery->created_at }}" readonly>
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Updated At</label>
                        <input type="text" class="form-input w-full" value="{{ $delivery->updated_at }}" readonly>
                    </div>
                </div>

                <hr class="my-6">

                <!-- Tracking Section -->
                @if ($delivery->tracking)
                    <div class="p-4 bg-blue-50 rounded">
                        <h4 class="font-bold text-blue-800 mb-2">Tracking Information</h4>
                        <p class="text-gray-700 mb-3">Coordinates: {{ $delivery->tracking->formatted_coordinates }}</p>
                        <a href="{{ route('tracking.show', $delivery->tracking->id) }}"
                            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm inline-block">
                            View Tracking Details
                        </a>
                    </div>
                @else
                    <div class="p-4 bg-yellow-50 rounded">
                        <h4 class="font-bold text-yellow-800 mb-2">No Tracking Yet</h4>
                        <p class="text-gray-700 mb-3">This delivery doesn't have tracking assigned yet.</p>
                        <a href="{{ route('tracking.create', $delivery->id) }}"
                            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm font-medium inline-block">
                            Create Tracking
                        </a>
                    </div>

                    <hr class="my-6">

                    <div class="flex justify-end gap-2">
                        <a href="{{ route('delivery') }}"
                            class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 text-sm font-medium">
                            Back to List
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
