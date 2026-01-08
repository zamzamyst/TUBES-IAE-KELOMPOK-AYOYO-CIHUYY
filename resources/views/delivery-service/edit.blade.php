<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Delivery Service') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h1 class="text-2xl font-bold mb-4">Delivery Service - {{ $service->id }}</h1>
                <hr class="mb-6" />

                <form action="{{ route('delivery-service.update', $service->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Service Name</label>
                            <input type="text" name="name" class="w-full border rounded px-3 py-2"
                                placeholder="Service Name" value="{{ old('name', $service->name) }}">
                            @error('name')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Price (Rp)</label>
                            <input type="number" name="price" class="w-full border rounded px-3 py-2"
                                placeholder="Price" value="{{ old('price', $service->price) }}" step="0.01">
                            @error('price')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Estimation Days</label>
                            <input type="number" name="estimation_days" class="w-full border rounded px-3 py-2"
                                placeholder="Estimation Days" value="{{ old('estimation_days', $service->estimation_days) }}">
                            @error('estimation_days')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Status</label>
                            <label class="flex items-center">
                                <input type="checkbox" name="is_active" value="1" 
                                    class="w-4 h-4 text-blue-600 rounded" {{ old('is_active', $service->is_active) ? 'checked' : '' }} />
                                <span class="ml-2 text-gray-700 font-semibold">Active</span>
                            </label>
                        </div>
                    </div>

                    <div class="flex gap-2">
                        <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm font-medium">
                            Update Service
                        </button>
                        <a href="{{ route('delivery-service') }}"
                            class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700 text-sm font-medium">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
