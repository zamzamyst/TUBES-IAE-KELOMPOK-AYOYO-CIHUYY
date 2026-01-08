<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Delivery Service') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                <form action="{{ route('delivery-service.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label for="name" class="block text-gray-700 font-semibold mb-2">Service Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}"
                            class="w-full border border-gray-300 rounded px-3 py-2" placeholder="e.g., Express" />
                        @error('name')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="price" class="block text-gray-700 font-semibold mb-2">Price (Rp)</label>
                        <input type="number" name="price" id="price" value="{{ old('price') }}"
                            class="w-full border border-gray-300 rounded px-3 py-2" placeholder="0" step="0.01" />
                        @error('price')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="estimation_days" class="block text-gray-700 font-semibold mb-2">Estimation Days</label>
                        <input type="number" name="estimation_days" id="estimation_days" value="{{ old('estimation_days') }}"
                            class="w-full border border-gray-300 rounded px-3 py-2" placeholder="0" />
                        @error('estimation_days')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="is_active" class="flex items-center">
                            <input type="checkbox" name="is_active" id="is_active" value="1" 
                                class="w-4 h-4 text-blue-600 rounded" {{ old('is_active') ? 'checked' : '' }} />
                            <span class="ml-2 text-gray-700 font-semibold">Active</span>
                        </label>
                    </div>

                    <div class="flex gap-2">
                        <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm font-medium">
                            Add Service
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
