<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('List Menu') }}
            </h2>
            @if (auth()->user()->hasRole('admin') | auth()->user()->hasRole('seller'))
            <a href="{{ route('menu.create') }}"
                class="inline-block bg-[#881a14] text-white px-4 py-2 rounded hover:bg-[#6f1611]">
                Add Menu
            </a>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (Session::has('success'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ Session::get('success') }}
            </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <table class="min-w-full divide-y divide-gray-200 border border-gray-300">
                    <thead class="bg-[#881a14] text-white text-center font-bold">
                        <tr>
                            <th class="px-4 py-2">No.</th>
                            <th class="px-4 py-2">Menu Code</th>
                            <th class="px-4 py-2">Title</th>
                            <th class="px-4 py-2">Price</th>
                            <th class="px-4 py-2">Description</th>
                            <th class="px-4 py-2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($menu->count() > 0)
                        @foreach ($menu as $rs)
                        <tr class="border-t text-center">
                            <td class="px-4 py-2 align-middle">{{ $loop->iteration }}</td>
                            <td class="px-4 py-2 align-middle">{{ $rs->menu_code }}</td>
                            <td class="px-4 py-2 align-middle">{{ $rs->name }}</td>
                            <td class="px-4 py-2 align-middle">Rp {{ number_format($rs->price, 0, ',', '.') }}</td>
                            <td class="px-4 py-2 align-middle">{{ $rs->description }}</td>
                            <td class="px-4 py-2 align-middle">
                                <div class="flex justify-center gap-2 flex-wrap">
                                    <a href="{{ route('menu.show', $rs->id) }}"
                                        class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-800 text-sm font-medium inline-block">Detail</a>

                                    @if (auth()->user()->hasRole('seller') | auth()->user()->hasRole('admin'))
                                    <a href="{{ route('menu.edit', $rs->id) }}"
                                        class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600 text-sm font-medium inline-block">Edit</a>
                                    <form action="{{ route('menu.destroy', $rs->id) }}" method="POST"
                                        onsubmit="return confirm('Delete?')" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 text-sm font-medium">
                                            Delete
                                        </button>
                                    </form>
                                    @endif

                                    @if (auth()->user()->hasRole('admin')) 
                                    <a href="{{ route('order.create', $rs->menu_code) }}"
                                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm font-medium inline-block">Order</a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="6" class="text-center py-4">Menu not found</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>