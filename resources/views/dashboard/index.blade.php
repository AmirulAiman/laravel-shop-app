<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <x-toast />

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(Auth::user()->role == 'admin')
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <x-state-card label="Total Users" :value="number_format($totalUsers)"
                        change="Total {{ $totalNewUsers }} this weeks" trend="up">
                        <x-slot:icon>
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                </path>
                            </svg>
                        </x-slot:icon>
                    </x-state-card>
                    <x-state-card label="Total Customers" :value="number_format($totalCustomers)"
                        change="Total {{ $totalNewCustomers }} this weeks" trend="up">
                        <x-slot:icon>
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                </path>
                            </svg>
                        </x-slot:icon>
                    </x-state-card>
                    <x-state-card label="Total Sellers" :value="number_format($totalSellers)"
                        change="Total {{ $totalNewSellers }} this weeks" trend="up">
                        <x-slot:icon>
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                        </x-slot:icon>
                    </x-state-card>
                    <x-state-card label="Total Products" :value="number_format($totalProducts)"
                        change="Total {{ $totalNewUsers }} this weeks" trend="up">
                        <x-slot:icon>
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                </path>
                            </svg>
                        </x-slot:icon>
                    </x-state-card>
                </div>
            @endif
            {{-- Recent Order --}}
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 mt-4">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Recent Orders</h3>
                </div>
                <div class="overflow-x-auto">
                    <x-table :headers="['Order ID', 'Customer', 'Item', 'Amount', 'Status']">
                        @forelse ($orders as $order)
                            @foreach ($order->items as $item)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        ODR-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $order->user->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $item->product->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        RM {{ number_format($order->total_price, 2) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <x-status-badge :status="$item->status"></x-status-badge>
                                    </td>
                                    @if(Auth::user()->isAdmin())
                                        <td x-data="{open:false, selected: '{{ $item->status }}'}"
                                            class="px-6 py-4 whitespace-nowrap text-sm">
                                            <button @click="open = true"
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium hover:opacity-80 bg-blue-500 text-gray-300">
                                                {{ __('Update Status') }}
                                            </button>
                                            <div x-show="open" x-cloak
                                                class="fixed inset-0 bg-black/40 flex items-center justify-center z-50"
                                                @click.self="open = false">
                                                <div class="bg-white rounded-lg shadow-lg p-6 w-80">
                                                    <h3 class="text-sm font-semibold text-gray-900 mb-4">Update Order Status</h3>

                                                    <form method="POST" action="{{ route('dashboard.update', $item->id) }}">
                                                        @csrf
                                                        @method('PATCH')

                                                        <select name="status" x-model="selected"
                                                            class="w-full border-gray-300 rounded-md text-sm mb-4">
                                                            <option value="pending">Pending</option>
                                                            <option value="processing">Processing</option>
                                                            <option value="shipped">Shipped</option>
                                                        </select>

                                                        <div class="flex justify-end gap-2">
                                                            <button type="button" @click="open = false"
                                                                class="px-3 py-1.5 text-sm text-gray-600">
                                                                Cancel
                                                            </button>
                                                            <button type="submit"
                                                                class="px-3 py-1.5 text-sm bg-indigo-600 text-white rounded-md">
                                                                Confirm
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    @elseif(Auth::user()->isCustomer() && $item->status == 'shipped'))
                                        <td x-data="{open:false, selected: '{{ $item->status }}'}"
                                            class="px-6 py-4 whitespace-nowrap text-sm">
                                            <button @click="open = true"
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium hover:opacity-80 bg-blue-500 text-gray-300">
                                                {{ __('Update Status') }}
                                            </button>
                                            <div x-show="open" x-cloak
                                                class="fixed inset-0 bg-black/40 flex items-center justify-center z-50"
                                                @click.self="open = false">
                                                <div class="bg-white rounded-lg shadow-lg p-6 w-80">
                                                    <h3 class="text-sm font-semibold text-gray-900 mb-4">Update Order Status</h3>

                                                    <form method="POST" action="{{ route('dashboard.update', $item->id) }}">
                                                        @csrf
                                                        @method('PATCH')

                                                        <select name="status" x-model="selected"
                                                            class="w-full border-gray-300 rounded-md text-sm mb-4">
                                                            <option value="delivered">Delivered</option>
                                                            <option value="cancelled">Cancelled</option>
                                                        </select>

                                                        <div class="flex justify-end gap-2">
                                                            <button type="button" @click="open = false"
                                                                class="px-3 py-1.5 text-sm text-gray-600">
                                                                Cancel
                                                            </button>
                                                            <button type="submit"
                                                                class="px-3 py-1.5 text-sm bg-indigo-600 text-white rounded-md">
                                                                Confirm
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    @endif

                                </tr>
                            @endforeach
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">No orders found.
                                </td>
                            </tr>
                        @endforelse
                    </x-table>
                </div>
            </div>
        </div>


    </div>
</x-app-layout>