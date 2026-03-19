<x-dialog.header>
    {{ $title ?? __('concept.premium-feature') }}
</x-dialog.header>
<x-dialog.article class="max-w-xl">
    <x-grid type="1/1">
        <p>{!! $pitch !!}</p>

        @if (isset($doc))
            <p>
                <a
                    href="https://docs.kanka.io/en/latest/{{ $doc }}" class="link text-link">
                    <x-icon class="fa-regular fa-book" />
                    {{ __('general.documentation') }}
                </a>
            </p>
        @endif
    </x-grid>
</x-dialog.article>
<x-premium-cta-footer :campaign="$campaign" />
