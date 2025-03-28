<div {{ $attributes->merge(['class' => "text-neutral-content help-block"]) }}>
    @if (!empty($text))
        <p>{!! $text !!}</p>
    @endif
    @if (!empty($slot))
        <p>{!! $slot !!}</p>
    @endif

    @if (!empty($docs))
        <a href="{{ $docs }}" target="_blank" class="">
            <i class="fa-solid fa-external-link" aria-hidden="true"></i>
            {{ __('crud.helpers.learn_more', ['documentation' => __('footer.documentation')]) }}
        </a>
    @endif
</div>
