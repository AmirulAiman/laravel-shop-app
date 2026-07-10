@props(['headers' => []])

<div class="overflow-x-auto">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="border-b border-gray-200">
                @foreach ($headers as $header)
                    <th class="py-3 px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        {{ $header }}
                    </th>
                @endforeach
                @if(Auth::user()->role == 'admin')
                    <th>Update</th>
                @endif
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            {{ $slot }}
        </tbody>
    </table>
</div>