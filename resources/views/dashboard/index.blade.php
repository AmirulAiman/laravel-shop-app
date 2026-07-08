<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Metric Cards -->
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