<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Carts') }}
        </h2>
    </x-slot>
    
    <x-toast />

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Image</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Name</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Category</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Price</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Quantity</th>
                            </tr>
                        </thead>
                        <form action="{{ route('checkout.review') }}" method="get" id="checkout-form"></form>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @if (!$cart || $cart->items->isEmpty())
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center text-sm text-gray-500">
                                        No item in cart.
                                    </td>
                                </tr>
                            @else
                                @forelse ($cart->items as $item)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <input type="checkbox" name="selected[]" value="{{ $item->id }}"
                                                form="checkout-form" class="h-5 w-5 text-indigo-600 rounded">
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <img src="{{ $item->product->image_path ? asset('storage/' . $item->product->image_path) : asset('images/products/default.png') }}"
                                                alt="{{ $item->product->name }}"
                                                class="w-12 h-12 object-cover rounded-md shadow-sm border border-gray-100"
                                                onerror="this.src='https://placehold.co/100x100?text=No+Image';">
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $item->product->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $item->product->category->name ?? 'No category' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $item->product->price }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <div class="flex items-center gap-4">
                                                {{-- Update quantity --}}
                                                <form action="{{ route('carts.update', $item) }}" method="post"
                                                    class="flex items-center gap-2">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="number" name="quantity" value="{{ $item->quantity }}" min="1"
                                                        class="w-16 border-gray-300 rounded-md text-sm">
                                                    <button type="submit" class="text-sm text-indigo-600 hover:underline">
                                                        Update
                                                    </button>
                                                </form>

                                                <p class="w-20 text-right font-medium">
                                                    RM {{ number_format($item->product->price * $item->quantity, 2) }}
                                                </p>

                                                {{-- Remove item --}}
                                                <form action="{{ route('carts.destroy', $item) }}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-sm text-red-600 hover:underline">
                                                        Remove
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-8 text-center text-sm text-gray-500">
                                            No item in cart.
                                        </td>
                                    </tr>
                                @endforelse

                            @endif
                        </tbody>
                    </table>
                    @if ($cart && !$cart->items->isEmpty())
                        <form action="#" method="post">
                            @csrf
                            <div class="mt-6 flex justify-between items-center">
                                <p class="text-lg font-bold">
                                    Total:
                                    RM
                                    {{ number_format($cart->items->sum(fn($item) => $item->product->price * $item->quantity), 2) }}
                                </p>
                                <button type="submit" form="checkout-form"
                                    class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md text-sm font-semibold">
                                    Checkout
                                </button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>