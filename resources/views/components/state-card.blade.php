@props([
    'label',
    'value',
    'trend' => null, //Up or Down
    'change' => null,
    'iconImg',
    'iconBg' => 'bg-purple-50',
    'iconColor' => 'text-purple-600',
])
<div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-start justify-between">
      <div>
          <p class="text-sm font-medium text-gray-500">{{  $label }}</p>
        <p class="text-3xl font-bold text-gray-800 mt-2">{{  $value }}</p>
            <p class="text-xs text-green-500 font-medium mt-2 flex items-center">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            @if($trend === 'up')
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18">
                </path>
            @else
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18">
                </path>
            @endif
            </svg>
            {{  $change  }}
        </p>
    </div>
    <div class="p-3 {{ $iconBg }}rounded-lg {{ $iconColor }}">
        {{  $icon }}
    </div>
</div>