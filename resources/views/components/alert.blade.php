{{-- <div> --}}
<!-- Simplicity is an acquired taste. - Katharine Gerould -->
{{-- </div> --}}

@props([
'type' => 'info', // 'info', 'success', 'warning', 'error'
'message' // message to display
])

@php
// $baseClasses = 'px-4 py-2 rounded-md transition-colors duration-200 flex items-center';

// Définition des classes selon le type
$colors = match($type) {
'success' => 'bg-green-100 border-green-500 text-green-700',
'warning' => 'bg-yellow-100 border-yellow-500 text-yellow-800',
'error' => 'bg-red-100 border-red-500 text-red-800',
'default' => 'bg-blue-100 border-blue-500 text-blue-800',
};
@endphp

<div {{ $attributes->merge([
    'class' => "border-1-4 p-4 {$colors} rounded-md"
])}} role="alert">
    <p>{{ $message }}</p>
</div>
