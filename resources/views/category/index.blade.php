<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center" x-data="{create: false}">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Product Category') }}
            </h2>
        </div>
    </x-slot>

    <x-toast />

    <div class="py-12" x-data="{ editingCategory: null }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="bg-white shadow rounded-lg overflow-hidden">
                        <div class="mb-6 rounded-lg border border-gray-200 bg-white p-4 shadow-sm">
                            <form action="{{ route('categories.store') }}" method="POST" class="flex items-end gap-4">
                                @csrf
                                <div class="flex-1">
                                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                                        placeholder="New category name"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        required>
                                    @error('name')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="flex items-center gap-2 pb-2">
                                    <input type="checkbox" name="is_active" id="is_active" value="1" checked
                                        class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                    <label for="is_active" class="text-sm text-gray-600">Active</label>
                                </div>

                                <button type="submit"
                                    class="inline-flex items-center gap-1.5 rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 4.5v15m7.5-7.5h-15" />
                                    </svg>
                                    Add Category
                                </button>
                            </form>
                        </div>
                        <x-table :headers="['Name', 'Status', 'Created At']">
                            @forelse ($categories as $category)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                        {{ $category->name }}
                                    </td>
                                    <td class="px-6 py-4 text-sm">
                                        @php
                                            $roleColors = [
                                                '1' => 'bg-blue-100 text-blue-700',
                                                '0' => 'bg-yellow-100 text-yellow-700',
                                            ];
                                            $colorClass = $roleColors[$category->is_active] ?? 'bg-gray-100 text-gray-700';
                                        @endphp
                                        <span class="px-2 py-1 rounded-full text-xs font-medium {{ $colorClass }}">
                                            {{  $category->is_active == 1 ? 'Active' : 'No Active' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        {{ $category->created_at->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-3">
                                        <button type="button" @click="editingCategory = {
                                                    id: {{ $category->id }},
                                                    name: @js($category->name),
                                                    is_active: {{ $category->is_active ? 'true' : 'false' }},
                                                    updateUrl: '{{ route('categories.update', $category) }}'
                                                    }" class="text-indigo-600 hover:text-indigo-900">
                                            Edit
                                        </button>
                                        <form action="{{ route('categories.destroy', $category) }}" method="POST"
                                            class="inline"
                                            onsubmit="return confirm('Delete this category? This cannot be undone.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-8 text-center text-sm text-gray-500">
                                        No product category.
                                    </td>
                                </tr>
                            @endforelse
                        </x-table>
                    </div>

                    <div class="mt-6">
                        {{ $categories->links() }}
                    </div>
{{-- Edit modal --}}
                    <div x-show="editingCategory !== null" x-cloak
                        class="fixed inset-0 z-50 flex items-center justify-center px-4">
                        {{-- Backdrop --}}
                        <div x-show="editingCategory !== null" x-transition:enter="ease-out duration-200"
                            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                            x-transition:leave="ease-in duration-150" x-transition:leave-start="opacity-100"
                            x-transition:leave-end="opacity-0" class="fixed inset-0 bg-black/40"
                            @click="editingCategory = null"></div>

                        {{-- Panel --}}
                        <div x-show="editingCategory !== null" x-transition:enter="ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="ease-in duration-150" x-transition:leave-start="opacity-100 scale-100"
                            x-transition:leave-end="opacity-0 scale-95"
                            class="relative bg-white rounded-lg shadow-xl w-full max-w-md p-6"
                            @keydown.escape.window="editingCategory = null">
                            <h2 class="text-lg font-semibold text-gray-900 mb-4">Edit Category</h2>

                            <template x-if="editingCategory !== null">
                                <form :action="editingCategory.updateUrl" method="POST" class="space-y-4">
                                    @csrf
                                    @method('PUT')

                                    <div>
                                        <label for="edit_name"
                                            class="block text-sm font-medium text-gray-700">Name</label>
                                        <input type="text" name="name" id="edit_name" x-model="editingCategory.name"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                            required>
                                    </div>

                                    <div class="flex items-center gap-2">
                                        <input type="checkbox" name="is_active" id="edit_is_active" value="1"
                                            x-model="editingCategory.is_active"
                                            class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                        <label for="edit_is_active" class="text-sm text-gray-700">Active</label>
                                    </div>

                                    <div class="flex justify-end gap-3 pt-2">
                                        <button type="button" @click="editingCategory = null"
                                            class="rounded-md border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                                            Cancel
                                        </button>
                                        <button type="submit"
                                            class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-500">
                                            Save Changes
                                        </button>
                                    </div>
                                </form>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</x-app-layout>