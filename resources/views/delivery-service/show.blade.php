<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Delivery Service') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h1 class="text-2xl font-bold mb-2">Delivery Service - {{ $service->id }}</h1>
                <hr class="mb-6" />

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Service Name</label>
                        <input type="text" name="name" class="form-input w-full border border-gray-300 rounded px-3 py-2" value="{{ $service->name }}" readonly>
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Price (Rp)</label>
                        <input type="text" name="price" class="form-input w-full border border-gray-300 rounded px-3 py-2" value="{{ number_format($service->price, 0, ',', '.') }}" readonly>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Estimation Days</label>
                        <input type="text" name="estimation_days" class="form-input w-full border border-gray-300 rounded px-3 py-2" value="{{ $service->estimation_days }} hari"
                            readonly>
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Status</label>
                        <span class="px-3 py-2 rounded-full text-sm font-semibold {{ $service->is_active ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800' }}">
                            {{ $service->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                </div>

                @if (auth()->user()->hasRole('admin'))
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Created At</label>
                        <input type="text" name="created_at" class="form-input w-full border border-gray-300 rounded px-3 py-2" value="{{ $service->created_at }}"
                            readonly>
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Updated At</label>
                        <input type="text" name="updated_at" class="form-input w-full border border-gray-300 rounded px-3 py-2" value="{{ $service->updated_at }}"
                            readonly>
                    </div>
                </div>
                @endif

                <div class="mt-6 flex gap-2">
                    @if (auth()->user()->hasRole('admin'))
                    <a href="{{ route('delivery-service.edit', $service->id) }}"
                        class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600 text-sm font-medium">Edit</a>
                    @endif
                    <a href="{{ route('delivery-service') }}"
                        class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700 text-sm font-medium">Back</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
