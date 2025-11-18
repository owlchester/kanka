<div {{ $attributes->merge(['class' => "text-neutral-content help-block flex flex-col gap-2"]) }}>
    {!! $slot !!}

    @if (!empty($docs))
        <a href="https://docs.kanka.io/en/latest/{{ $docs }}" class="">
            <x-icon class="fa-regular fa-book" />
            @if (empty($doc))
            {{ __('general.documentation') }}
            @else
            {!! $doc !!}
            @endif
        </a>
    @endif
</div>
