<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Delivery') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                <form action="{{ route('delivery.store') }}" method="POST">
                    @csrf

                    <input type="hidden" name="order_id" value="{{ $order->id }}">

                    <div class="mb-4">
                        <label for="order_id" class="block text-gray-700 font-semibold mb-2">Order ID</label>
                        <input type="text" id="order_id" value="{{ $order->id }}" readonly
                            class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-100" />
                    </div>

                    <div class="mb-4">
                        <label for="name" class="block text-gray-700 font-semibold mb-2">Menu Name</label>
                        <input type="text" id="name" value="{{ $order->name }}" readonly
                            class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-100" />
                    </div>

                    <div class="mb-4">
                        <label for="quantity" class="block text-gray-700 font-semibold mb-2">Quantity</label>
                        <input type="text" id="quantity" value="{{ $order->quantity }}" readonly
                            class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-100" />
                    </div>

                    <div class="mb-4">
                        <label for="delivery_service_id" class="block text-gray-700 font-semibold mb-2">Service Name</label>
                        <select name="delivery_service_id" id="delivery_service_id" required
                            class="w-full border border-gray-300 rounded px-3 py-2">
                            <option value="">-- Select Delivery Service --</option>
                            @foreach($services as $service)
                                <option value="{{ $service->id }}" {{ old('delivery_service_id') == $service->id ? 'selected' : '' }}>
                                    {{ $service->name }} (Rp{{ number_format($service->price, 0, ',', '.') }} - {{ $service->estimation_days }} hari)
                                </option>
                            @endforeach
                        </select>
                        @error('delivery_service_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="delivery_address" class="block text-gray-700 font-semibold mb-2">Delivery Address</label>
                        <textarea name="delivery_address" id="delivery_address" rows="3" required
                            class="w-full border border-gray-300 rounded px-3 py-2">{{ old('delivery_address') }}</textarea>
                        @error('delivery_address')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="delivery_status" class="block text-gray-700 font-semibold mb-2">Delivery Status</label>
                        <select name="delivery_status" id="delivery_status" required
                            class="w-full border border-gray-300 rounded px-3 py-2">
                            <option value="">-- Select Status --</option>
                            <option value="pending" {{ old('delivery_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="in_transit" {{ old('delivery_status') == 'in_transit' ? 'selected' : '' }}>In Transit</option>
                            <option value="delivered" {{ old('delivery_status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
                            <option value="cancelled" {{ old('delivery_status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                        @error('delivery_status')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end gap-2">
                        <a href="{{ route('menu') }}"
                            class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 text-sm font-medium">
                            Cancel
                        </a>
                        <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm font-medium">
                            Create Delivery
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>