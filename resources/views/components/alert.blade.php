@php $unique = 'alert-' . uniqid(); @endphp
<div class="alert alert-{{ $type }} {!! $class ?? null !!} border-0 rounded p-4 flex shadow-xs gap-2 items-center
@if ($dismissible) opacity-100 duration-150 transition-opacity {{ $unique }} @endif"
     @if ($id) id="{{ $id }}" @endif
@if ($hidden) style="display: none" @endif>
    <div class="grow">
        {!! $slot !!}
    </div>
    @if ($dismissible)
    <div class="flex-none">
        <button type="button" class="text-xl opacity-50 hover:opacity-100 focus:opacity-100 cursor-pointer text-decoration-none" data-dismisses=".{{ $unique }}" aria-label="{{ __('Close') }}">
            <x-icon class="fa-regular fa-circle-xmark" />
            <span class="sr-only">{{ __('Close') }}</span>
    </div>
    @endif
</div>
