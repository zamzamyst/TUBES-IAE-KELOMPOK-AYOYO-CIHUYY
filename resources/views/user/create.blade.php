<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                <form action="{{ route('user.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label for="menu_code" class="block text-gray-700 font-semibold mb-2">Menu Code</label>
                        <input type="text" name="menu_code" id="menu_code" value="{{ $user->menu_code }}" readonly
                            class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-100" />
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2">Name</label>
                        <input type="text" value="{{ $user->name }}" readonly
                            class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-100" />
                        <input type="hidden" name="name" value="{{ $user->name }}">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2">Price</label>
                        <input type="text" value="Rp {{ number_format($user->price, 0, ',', '.') }}" readonly
                            class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-100" />
                        <input type="hidden" name="price" value="{{ $user->price }}">
                    </div>

                    <div class="mb-4">
                        <label for="quantity" class="block text-gray-700 font-semibold mb-2">Quantity</label>
                        <input type="number" name="quantity" id="quantity" value="{{ old('quantity', 1) }}" min="1"
                            required class="w-full border border-gray-300 rounded px-3 py-2" />
                    </div>

                    <div class="mb-4">
                        <label for="notes" class="block text-gray-700 font-semibold mb-2">Notes</label>
                        <textarea name="notes" id="notes" rows="3"
                            class="w-full border border-gray-300 rounded px-3 py-2">{{ old('notes') }}</textarea>
                    </div>

                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm font-medium">
                        Order Now
                    </button>
                </form>
                
            </div>
        </div>
    </div>
</x-app-layout>