<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Review Your Order
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
                <div class="lg:col-span-2">

                    <div class="bg-white border border-[#D8D5CE] rounded-t-lg shadow-sm">

                        {{-- Receipt head --}}
                        <div class="px-6 sm:px-8 pt-8 pb-6 border-b border-dashed border-[#D8D5CE]">
                            <p class="font-mono text-xs tracking-widest text-[#1F6D5A] uppercase mb-1">
                                Order Preview &middot; Not Yet Charged
                            </p>
                            <h3 class="font-sans text-lg font-semibold text-[#1A1A1A]">
                                {{ $items->count() }} {{ Str::plural('item', $items->count()) }} selected
                            </h3>
                        </div>

                        <ul class="divide-y divide-dashed divide-[#D8D5CE]">
                            @foreach ($items as $cartItem)
                                <li class="px-6 sm:px-8 py-5 flex gap-4 items-center">

                                    {{-- thumbnail --}}
                                    <div class="w-16 h-16 shrink-0 rounded-md bg-[#F0EEE9] border border-[#D8D5CE] overflow-hidden flex items-center justify-center">
                                        @if ($cartItem->product->image_path ?? false)
                                            <img src="{{ Storage::url($cartItem->product->image_path) }}"
                                                 alt="{{ $cartItem->product->name }}"
                                                 class="w-full h-full object-cover">
                                        @else
                                            <span class="font-mono text-[10px] text-gray-400">NO IMG</span>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="font-sans text-sm font-medium text-[#1A1A1A] truncate">
                                            {{ $cartItem->product->name }}
                                        </p>
                                        <p class="font-mono text-xs text-gray-500 mt-1">
                                            {{ $cartItem->quantity }} &times; RM {{ number_format($cartItem->product->price, 2) }}
                                        </p>
                                    </div>

                                    {{-- line total --}}
                                    <div class="font-mono text-sm text-[#1A1A1A] tabular-nums">
                                        RM {{ number_format($cartItem->quantity * $cartItem->product->price, 2) }}
                                    </div>
                                </li>
                            @endforeach
                        </ul>

                    </div>
                    <div class="relative h-4 overflow-hidden">
                        <div class="absolute inset-x-0 top-0 h-4 bg-white border-x border-[#D8D5CE]"
                             style="mask-image: radial-gradient(circle 7px at 16px 0, transparent 7px, black 7.5px);
                                    -webkit-mask-image: radial-gradient(circle 7px at 16px 0, transparent 7px, black 7.5px);
                                    mask-repeat: repeat-x; -webkit-mask-repeat: repeat-x;
                                    mask-size: 32px 16px; -webkit-mask-size: 32px 16px;">
                        </div>
                    </div>

                    <p class="font-mono text-xs text-gray-400 text-center mt-2">
                        Everything look right? Confirm on the right to place your order.
                    </p>
                </div>
                <div class="lg:col-span-1 lg:sticky lg:top-8">
                    <div class="bg-white border border-[#D8D5CE] rounded-lg shadow-sm p-6 sm:p-8">

                        <h3 class="font-sans text-sm font-semibold text-[#1A1A1A] uppercase tracking-wide mb-5">
                            Order Summary
                        </h3>

                        <dl class="space-y-3 font-mono text-sm">
                            <div class="flex justify-between text-gray-600">
                                <dt>Subtotal</dt>
                                <dd class="tabular-nums">RM {{ number_format($total, 2) }}</dd>
                            </div>
                            <div class="flex justify-between text-gray-600">
                                <dt>Shipping</dt>
                                <dd class="tabular-nums text-[#1F6D5A]">Free</dd>
                            </div>
                        </dl>

                        <div class="border-t border-dashed border-[#D8D5CE] mt-4 pt-4 flex justify-between items-baseline">
                            <dt class="font-sans text-sm font-medium text-[#1A1A1A]">Total</dt>
                            <dd class="font-mono text-xl font-semibold text-[#1A1A1A] tabular-nums">
                                RM {{ number_format($total, 2) }}
                            </dd>
                        </div>

                        <form method="POST" action="{{ route('checkout.store') }}" class="mt-6">
                            @csrf
                            @foreach ($items as $cartItem)
                                <input type="hidden" name="item_ids[]" value="{{ $cartItem->id }}">
                            @endforeach

                            <button type="submit"
                                class="w-full bg-[#1F6D5A] hover:bg-[#195a4a] text-white font-sans font-medium text-sm py-3 rounded-md transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#1F6D5A]">
                                Confirm &amp; Place Order
                            </button>
                        </form>

                        <a href="{{ route('carts.index') }}"
                           class="block text-center font-sans text-xs text-gray-500 hover:text-gray-700 mt-4">
                            &larr; Back to cart
                        </a>
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>