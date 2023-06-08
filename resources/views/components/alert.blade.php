<div class="alert alert-{{ $type }} {!! $class ?? null !!} mb-5 border-0 rounded p-4 flex shadow-xs gap-2 items-center
@if ($dismissible) alert-dismissable @endif "
@if ($id) id="{{ $id }}" @endif
@if ($hidden) style="display: none" @endif>
    <div class="grow">
        {!! $slot !!}
    </div>
    @if ($dismissible)
    <div class="flex-none">
        <x-dialog.close dismiss="alert"></x-dialog.close>
    </div>
    @endif
</div>
