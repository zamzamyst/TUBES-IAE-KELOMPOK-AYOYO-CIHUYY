<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Order') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h1 class="text-2xl font-bold mb-2">Order - {{ $order->id }}</h1>
                <hr class="mb-6" />

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Name</label>
                        <input type="text" name="title" class="form-input w-full" value="{{ $order->name }}" readonly>
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Price</label>
                        <input type="text" name="price" class="form-input w-full" value="{{ $order->price }}" readonly>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Menu Code</label>
                        <input type="text" name="menu_code" class="form-input w-full" value="{{ $order->menu_code }}"
                            readonly>
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Quantity</label>
                        <input type="text" name="menu_code" class="form-input w-full" value="{{ $order->quantity }}"
                            readonly>
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                        <textarea name="description" class="form-input w-full" rows="3"
                            readonly>{{ $order->notes }}</textarea>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Created At</label>
                        <input type="text" name="created_at" class="form-input w-full" value="{{ $order->created_at }}"
                            readonly>
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Updated At</label>
                        <input type="text" name="updated_at" class="form-input w-full" value="{{ $order->updated_at }}"
                            readonly>
                    </div>
                </div>

                <hr class=\"my-6\">

                <!-- Delivery Section -->
                @if($order->delivery)
                <div class=\"p-4 bg-blue-50 rounded\">
                    <h4 class=\"font-bold text-blue-800 mb-2\">Delivery Information</h4>
                    <p class=\"text-gray-700 mb-2\">Status: 
                        <span class=\"px-2 py-1 rounded text-white text-xs {{ $order->delivery->status_badge }}\">
                            {{ $order->delivery->formatted_status }}
                        </span>
                    </p>
                    <p class=\"text-gray-700 mb-3\">Address: {{ Str::limit($order->delivery->delivery_address, 50) }}</p>
                    <a href="{{ route('delivery.show', $order->delivery->id) }}" 
                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm font-medium inline-block">
                        View Delivery Details
                    </a>
                </div>
                @else
                <div class="p-4 bg-yellow-50 rounded">
                    <h4 class="font-bold text-yellow-800 mb-2">No Delivery Yet</h4>
                    <p class="text-gray-700 mb-3">This order doesn't have a delivery assigned yet.</p>
                    @if(auth()->user()->hasRole('seller') || auth()->user()->hasRole('admin'))
                    <a href="{{ route('delivery.create', $order->id) }}" 
                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm font-medium inline-block">
                        Create Delivery
                    </a>
                    @endif
                </div>
                @endif

                <div class="flex justify-end gap-2 mt-6">
                    <a href="{{ route('order') }}" 
                        class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 text-sm font-medium inline-block">
                        Back to List
                    </a>
                    @if(auth()->user()->hasRole('seller') || auth()->user()->hasRole('admin'))
                    <a href="{{ route('order.edit', $order->id) }}" 
                        class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600 text-sm font-medium inline-block">
                        Edit Order
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>