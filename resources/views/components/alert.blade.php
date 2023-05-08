<div class="alert alert-{{ $type }} {!! $class ?? null !!} mb-5 border-0 rounded p-4 flex shadow-xs gap-2
@if ($dismissible) alert-dismissable @endif "
@if ($id) id="{{ $id }}" @endif
@if ($hidden) style="display: none" @endif>
    <div class="grow">
        {!! $slot !!}
    </div>
    @if ($dismissible)
    <div class="flex-none">
        <x-icon class="fa-solid fa-times"></x-icon>
        <span class="sr-only">{{ __('crud.click_modal.close') }}</span>
    </div>
    @endif
</div>
