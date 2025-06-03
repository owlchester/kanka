<div {{ $attributes->merge(['class' => "text-neutral-content help-block flex flex-col gap-2"]) }}>
    {!! $slot !!}

    @if (!empty($docs))
        <a href="https://docs.kanka.io/en/latest/{{ $docs }}" class="">
            <x-icon class="fa-regular fa-book" />
            {{ __('general.documentation') }}
        </a>
    @endif
</div>
