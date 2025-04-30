<div>
    @props([
    'href' => '#',
    'active' => false,
    'icon' => null,
    'iconPosition' => 'left'
    ])

    @php
    $baseClasses = 'px-4 py-2 rounded-md transition-colors duration-200 flex items-center';
    $activeClasses = 'bg-blue-800 text-white';
    $inactiveClasses = 'text-blue-100 hover:bg-blue-700 hover:text-white';
    @endphp
    <a href="{{$href}}" {{ $attributes ->merge(['class' => $baseClasses . ' ' . ($active ? $activeClasses : $inactiveClasses)])}}>

        @if($icon && $iconPosition === 'left')
        <x-icon :name="$icon" class="mr-2 w-5 h-5"/>
        @endif
        {{$slot}}
        @if($icon && $iconPosition === 'right')
        <x-icon :name="$icon" class="ml-2 w-5 h-5"/>
        @endif
    </a>

</div>
