<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Tracking') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h1 class="text-2xl font-bold mb-2">Tracking - {{ $tracking->id }}</h1>
                <hr class="mb-6" />

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Tracking ID</label>
                        <input type="text" class="form-input w-full" value="{{ $tracking->id }}" readonly>
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Delivery ID</label>
                        <input type="text" class="form-input w-full" value="{{ $tracking->delivery_id }}" readonly>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Order ID</label>
                        <input type="text" class="form-input w-full"
                            value="{{ $tracking->delivery->order_id ?? '-' }}" readonly>
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Menu Name</label>
                        <input type="text" class="form-input w-full"
                            value="{{ $tracking->delivery->order->name ?? '-' }}" readonly>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div class="md:col-span-2">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Coordinates</label>
                        <input type="text" class="form-input w-full bg-blue-50 font-mono text-lg"
                            value="{{ $tracking->formatted_coordinates }}" readonly>
                        <p class="text-sm text-gray-500 mt-1">Latitude: {{ $tracking->latitude }} | Longitude:
                            {{ $tracking->longitude }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Created At</label>
                        <input type="text" class="form-input w-full" value="{{ $tracking->created_at }}" readonly>
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Updated At</label>
                        <input type="text" class="form-input w-full" value="{{ $tracking->updated_at }}" readonly>
                    </div>
                </div>

                <hr class="my-6">

                <!-- Delivery Section -->
                @if ($tracking->delivery)
                    <h3 class="text-lg font-bold mb-4">Delivery Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Delivery ID</label>
                            <input type="text" class="form-input w-full" value="{{ $tracking->delivery->id }}"
                                readonly>
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Delivery Status</label>
                            <input type="text" class="form-input w-full"
                                value="{{ $tracking->delivery->formatted_status }}" readonly>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div class="md:col-span-2">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Delivery Address</label>
                            <textarea class="form-input w-full" rows="3" readonly>{{ $tracking->delivery->delivery_address }}</textarea>
                        </div>
                    </div>

                    <a href="{{ route('delivery.show', $tracking->delivery->id) }}"
                        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm inline-block mb-6">
                        View Delivery Details
                    </a>

                    <hr class="my-6">

                    <!-- Order Information Section -->
                    @if ($tracking->delivery->order)
                        <h3 class="text-lg font-bold mb-4">Order Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Order ID</label>
                                <input type="text" class="form-input w-full"
                                    value="{{ $tracking->delivery->order->id }}" readonly>
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Menu Code</label>
                                <input type="text" class="form-input w-full"
                                    value="{{ $tracking->delivery->order->menu_code }}" readonly>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Menu Name</label>
                                <input type="text" class="form-input w-full"
                                    value="{{ $tracking->delivery->order->name }}" readonly>
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Price</label>
                                <input type="text" class="form-input w-full"
                                    value="Rp {{ number_format($tracking->delivery->order->price, 0, ',', '.') }}"
                                    readonly>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Quantity</label>
                                <input type="text" class="form-input w-full"
                                    value="{{ $tracking->delivery->order->quantity }}" readonly>
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Total</label>
                                <input type="text" class="form-input w-full"
                                    value="Rp {{ number_format($tracking->delivery->order->price * $tracking->delivery->order->quantity, 0, ',', '.') }}"
                                    readonly>
                            </div>
                        </div>

                        @if ($tracking->delivery->order->notes)
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div class="md:col-span-2">
                                    <label class="block text-gray-700 text-sm font-bold mb-2">Notes</label>
                                    <textarea class="form-input w-full" rows="3" readonly>{{ $tracking->delivery->order->notes }}</textarea>
                                </div>
                            </div>
                        @endif

                        <a href="{{ route('order.show', $tracking->delivery->order->id) }}"
                            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm font-medium inline-block">
                            View Order Details
                        </a>
                    @endif
                @endif

                <hr class="my-6">

                <div class="flex justify-end gap-2">
                    <a href="{{ route('tracking') }}"
                        class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 text-sm font-medium">
                        Back to List
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
