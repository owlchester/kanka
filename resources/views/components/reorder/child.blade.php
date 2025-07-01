<div {{ $attributes->merge(['class' => 'element bg-base-100 hover:bg-base-200 p-2 transition-all duration-150 rounded-xl flex items-center gap-2']) }} data-id="{{ $id }}">
    {!! $slot !!}
</div>
