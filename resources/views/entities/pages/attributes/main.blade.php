<x-tutorial code="attributes" doc="https://docs.kanka.io/en/latest/features/attributes.html">
    <p>{!! __('entities/attributes.tutorial', [
        'hp' => '<code>HP</code>',
        'str' => '<code>STR</code>',
        'pop' => '<code>Population</code>',
    ]) !!}</p>
</x-tutorial>

@include('entities.pages.attributes.render')

<input type="hidden" name="live-attribute-config" data-live="{{ route('entities.attributes.live.edit', [$campaign, $entity]) }}" />
