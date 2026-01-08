<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Tracking') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                <form method="POST" action="{{ route('tracking.store') }}">
                    @csrf
                    <input type="hidden" name="delivery_id" value="{{ $delivery->id }}">

                    <div class="mb-4">
                        <label for="delivery_id" class="block text-gray-700 font-semibold mb-2">Delivery ID</label>
                        <input type="text" id="delivery_id" value="{{ $delivery->id }}" readonly
                            class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-100" />
                    </div>

                    <div class="mb-4">
                        <label for="order_id" class="block text-gray-700 font-semibold mb-2">Order ID</label>
                        <input type="text" id="order_id" value="{{ $delivery->order_id }}" readonly
                            class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-100" />
                    </div>

                    <div class="mb-4">
                        <label for="name" class="block text-gray-700 font-semibold mb-2">Menu Name</label>
                        <input type="text" id="name" value="{{ $delivery->order->name ?? '-' }}" readonly
                            class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-100" />
                    </div>

                    <div class="mb-4">
                        <label for="address" class="block text-gray-700 font-semibold mb-2">Delivery Address</label>
                        <textarea id="address" rows="3" readonly
                            class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-100">{{ $delivery->delivery_address }}</textarea>
                    </div>

                    <div class="mb-6 p-4 bg-blue-50 border-l-4 border-blue-500 rounded">
                        <p class="text-gray-700 font-semibold mb-2">Coordinates will be generated automatically</p>
                        <p class="text-gray-600 text-sm">Random coordinates will be created within Indonesia bounds (Latitude: -11 to 6, Longitude: 95 to 141)</p>
                    </div>

                    @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded">
                        <ul class="list-disc list-inside text-red-600">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm font-medium">
                        Track Now
                    </button>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>