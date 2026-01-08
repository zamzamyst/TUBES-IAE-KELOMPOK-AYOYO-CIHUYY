<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('List Delivery') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (Session::has('success'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ Session::get('success') }}
            </div>
            @endif

            @if (Session::has('error'))
            <div class="mb-4 font-medium text-sm text-red-600">
                {{ Session::get('error') }}
            </div>
            @endif

            @if (Session::has('info'))
            <div class="mb-4 font-medium text-sm text-blue-600">
                {{ Session::get('info') }}
            </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <table class="min-w-full divide-y divide-gray-200 border border-gray-300">
                    <thead class="bg-[#881a14] text-white text-center font-bold">
                        <tr>
                            <th class="px-4 py-2">No.</th>
                            <th class="px-4 py-2">Order ID</th>
                            <th class="px-4 py-2">Menu Name</th>
                            <th class="px-4 py-2">Service Name</th>
                            <th class="px-4 py-2">Delivery Address</th>
                            <th class="px-4 py-2">Status</th>
                            <th class="px-4 py-2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($deliveries->count() > 0)
                        @foreach ($deliveries as $rs)
                        <tr class="border-t text-center">
                            <td class="px-4 py-2 align-middle">{{ $loop->iteration }}</td>
                            <td class="px-4 py-2 align-middle">{{ $rs->order_id }}</td>
                            <td class="px-4 py-2 align-middle">{{ $rs->order->name ?? '-' }}</td>
                            <td class="px-4 py-2 align-middle">{{ $rs->deliveryService->name ?? '-' }}</td>
                            <td class="px-4 py-2 align-middle">{{ Str::limit($rs->delivery_address, 30) }}</td>
                            <td class="px-4 py-2 align-middle">
                                <span class="px-2 py-1 rounded text-black font-semibold text-xs {{ $rs->status_badge }}">
                                    {{ $rs->formatted_status }}
                                </span>
                            </td>
                            <td class="px-4 py-2 align-middle">
                                <div class="flex justify-center gap-2 flex-wrap">
                                    <a href="{{ route('delivery.show', $rs->id) }}"
                                        class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-800 text-sm font-medium inline-block">Detail</a>

                                    <a href="{{ route('delivery.edit', $rs->id) }}"
                                        class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600 text-sm font-medium inline-block">Edit</a>
                                        
                                        @if (auth()->user()->hasRole('admin'))
                                        <form action="{{ route('delivery.destroy', $rs->id) }}" method="POST"
                                            onsubmit="return confirm('Hapus delivery ini?')" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 text-sm font-medium">
                                                Delete
                                            </button>
                                        </form>
                                        @endif
                                        
                                    @if(!$rs->tracking)
                                    <a href="{{ route('tracking.create', $rs->id) }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm font-medium inline-block">Create Tracking</a>
                                    @else
                                    <a href="{{ route('tracking.show', $rs->tracking->id) }}"
                                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm font-medium inline-block">
                                        View Tracking
                                    </a>
                                    @endif

                                </div>
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="6" class="text-center py-4">Belum ada delivery</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>