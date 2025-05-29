<div {{ $attributes->merge(['class' => "text-neutral-content help-block"]) }}>
    @if (!empty($text))
        <p>{!! $text !!}</p>
    @endif
    @if (!empty($slot))
        <p>{!! $slot !!}</p>
    @endif

    @if (!empty($docs))
        <a href="{{ $docs }}" class="">
            <x-icon class="link" />
            {{ __('crud.helpers.learn_more', ['documentation' => __('footer.documentation')]) }}
        </a>
    @endif
</div>
