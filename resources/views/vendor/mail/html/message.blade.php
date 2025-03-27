@props([
    'layout' => 'user',
])
<x-mail::layout :layout="$layout">

{{-- Body --}}
{{ $slot }}

</x-mail::layout>
