<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Menu') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h1 class="text-2xl font-bold mb-4">Menu - {{ $menu->id }}</h1>
                <hr class="mb-6" />

                <form action="{{ route('menu.update', $menu->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Name</label>
                            <input type="text" name="name" class="w-full border rounded px-3 py-2"
                                placeholder="Name" value="{{ old('name', $menu->name) }}">
                            @error('name')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Menu Code</label>
                            <input type="text" name="menu_code" class="w-full border rounded px-3 py-2"
                                placeholder="Menu Code" value="{{ old('menu_code', $menu->menu_code) }}">
                            @error('menu_code')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Price</label>
                            <input type="text" name="price" class="w-full border rounded px-3 py-2"
                                placeholder="Price" value="{{ old('price', $menu->price) }}">
                            @error('price')
                                <div class="text-red-500 text-sm mt-1">Isi harga dengan nilai yang valid!</div>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                            <textarea name="description" class="w-full border rounded px-3 py-2" placeholder="Description" rows="3">{{ old('description', $menu->description) }}</textarea>
                            @error('description')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="flex justify-end gap-2">
                        <a href="{{ route('menu') }}"
                            class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 text-sm font-medium">
                            Back to List
                        </a>
                        <button type="submit"
                            class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600 text-sm font-medium">
                            Update
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
