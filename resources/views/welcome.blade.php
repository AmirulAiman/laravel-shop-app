<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Shopping App') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <script src="https://cdn.tailwindcss.com"></script>
            <script>
                tailwind.config = {
                    darkMode: 'media',
                    theme: {
                        extend: {
                            fontFamily: {
                                sans: ['Instrument Sans', 'sans-serif'],
                            },
                        }
                    }
                }
            </script>
        @endif
    </head>
    <body class="bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 font-sans min-h-screen flex flex-col transition-colors duration-200">
        
        <!-- Header / Navigation -->
        <header class="w-full bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700 shadow-sm sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
                <!-- Brand Logo / Title -->
                <div class="flex items-center space-x-2">
                    <a href="{{ url('/') }}" class="text-2xl font-bold tracking-tight text-indigo-600 dark:text-indigo-400 flex items-center">
                        <svg class="h-8 w-8 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        <span>{{ config('app.name', 'ShoppingApp') }}</span>
                    </a>
                </div>

                <!-- Navigation Auth Buttons -->
                @if (Route::has('login'))
                    <nav class="flex items-center gap-4">
                        @auth
                            <a
                                href="{{ url('/dashboard') }}"
                                class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                            >
                                {{ __('Dashboard') }}
                            </a>
                        @else
                            <a
                                href="{{ route('login') }}"
                                class="text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition duration-150"
                            >
                                {{ __('Log in') }}
                            </a>

                            @if (Route::has('register'))
                                <a
                                    href="{{ route('register') }}"
                                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                                >
                                    {{ __('Register') }}
                                </a>
                            @endif
                        @endauth
                    </nav>
                @endif
            </div>
        </header>

        <!-- Main Body -->
        <main class="flex-1 w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            
            <!-- Hero Header Section -->
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h1 class="text-4xl font-extrabold tracking-tight text-gray-900 dark:text-white sm:text-5xl md:text-6xl">
                    <span class="block">{{ __('Welcome to our Store') }}</span>
                    <span class="block text-indigo-600 dark:text-indigo-400 mt-2">{{ __('Find Your Perfect Products') }}</span>
                </h1>
                <p class="mt-4 text-base text-gray-500 dark:text-gray-400 sm:text-lg md:text-xl">
                    {{ __('Browse our curated catalog of high-quality products. Easy ordering and fast shipping guaranteed.') }}
                </p>
            </div>

            <!-- Product Grid -->
            <div>
                <h2 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white mb-8 border-b border-gray-200 dark:border-gray-700 pb-4">
                    {{ __('Featured Products') }}
                </h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                    @forelse ($products as $product)
                        <div class="flex flex-col bg-white dark:bg-gray-800 rounded-lg shadow-sm hover:shadow-md hover:-translate-y-1 border border-gray-100 dark:border-gray-700 overflow-hidden transition-all duration-300">
                            <!-- Product Image -->
                            <div class="aspect-square w-full relative overflow-hidden bg-gray-50 dark:bg-gray-900 group">
                                <img src="{{ $product->image_path ? asset('storage/' . $product->image_path) : asset('images/products/default.png') }}" 
                                     alt="{{ $product->name }}" 
                                     class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                                     onerror="this.src='https://placehold.co/400x400?text=No+Image';">
                                
                                @if ($product->stock === 0)
                                    <div class="absolute inset-0 bg-black/40 flex items-center justify-center">
                                        <span class="px-3 py-1 bg-red-600 text-white text-xs font-bold uppercase rounded-md tracking-wider shadow">
                                            {{ __('Sold Out') }}
                                        </span>
                                    </div>
                                @endif
                            </div>

                            <!-- Product Content -->
                            <div class="p-5 flex-1 flex flex-col">
                                <!-- Category Name -->
                                <div class="mb-2">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-medium bg-indigo-50 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 border border-indigo-100 dark:border-indigo-800/50">
                                        {{ $product->category->name ?? __('General') }}
                                    </span>
                                </div>

                                <!-- Title -->
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2 line-clamp-1">
                                    {{ $product->name }}
                                </h3>

                                <!-- Description -->
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-4 line-clamp-2">
                                    {{ $product->description ?? __('No description available.') }}
                                </p>

                                <!-- Price / Stock / CTA -->
                                <div class="mt-auto pt-4 border-t border-gray-50 dark:border-gray-700/50 flex items-center justify-between">
                                    <div>
                                        <span class="text-2xl font-bold text-gray-900 dark:text-white">
                                            ${{ number_format($product->price, 2) }}
                                        </span>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                            @if ($product->stock > 0)
                                                <span class="text-green-600 dark:text-green-400 font-semibold">{{ $product->stock }} {{ __('in stock') }}</span>
                                            @else
                                                <span class="text-red-500 font-semibold">{{ __('Out of stock') }}</span>
                                            @endif
                                        </p>
                                    </div>
                                    <button class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 disabled:bg-gray-400 text-white rounded-md text-sm font-semibold transition duration-150 shadow-sm" {{ $product->stock === 0 ? 'disabled' : '' }}>
                                        {{ __('Add to Cart') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full py-20 text-center">
                            <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                            <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">{{ __('No products found') }}</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ __('Check back later for new arrivals.') }}</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-white dark:bg-gray-800 border-t border-gray-100 dark:border-gray-700 mt-auto">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 text-center text-sm text-gray-500 dark:text-gray-400">
                &copy; {{ date('Y') }} {{ config('app.name', 'ShoppingApp') }}. All rights reserved.
            </div>
        </footer>

    </body>
</html>
