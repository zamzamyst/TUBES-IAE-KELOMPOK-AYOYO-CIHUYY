<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Menu') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h1 class="text-2xl font-bold mb-2">Menu - {{ $menu->id }}</h1>
                <hr class="mb-6" />

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Name</label>
                        <input type="text" name="title" class="form-input w-full" value="{{ $menu->name }}" readonly>
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Price</label>
                        <input type="text" name="price" class="form-input w-full" value="{{ $menu->price }}" readonly>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Menu Code</label>
                        <input type="text" name="menu_code" class="form-input w-full" value="{{ $menu->menu_code }}"
                            readonly>
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                        <textarea name="description" class="form-input w-full" rows="3"
                            readonly>{{ $menu->description }}</textarea>
                    </div>
                </div>

                @if (auth()->user()->hasRole('admin') | auth()->user()->hasRole('seller'))
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Created At</label>
                        <input type="text" name="created_at" class="form-input w-full" value="{{ $menu->created_at }}"
                            readonly>
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Updated At</label>
                        <input type="text" name="updated_at" class="form-input w-full" value="{{ $menu->updated_at }}"
                            readonly>
                    </div>
                </div>
                @endif

                <div class="flex gap-2 mt-6">
                    <a href="{{ route('menu') }}" 
                        class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 text-sm font-medium">
                        Back to List
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>