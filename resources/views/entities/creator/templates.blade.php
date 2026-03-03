<x-dialog.header>
    @if (isset($origin))
        <div class="sm:w-80 text-left">{{ __('entities.creator.modes.default') }}</div>
    @endif
</x-dialog.header>
<article class="p-4 md:px-6">

<div class="entity-creator-body-{{ $entityType->code }}">

    @include('entities.creator.header.header')
    <div class="quick-creator-body">
        @if ($templates->isEmpty())
            <p class="">
                <a href="//docs.kanka.io/en/latest/guides/archetypes.html" class="text-link">
                    <x-icon class="link" />
                    {{ __('entries/archetypes.helpers.how') }}
                </a>
            </p>
        @else
            <ul class="flex flex-col gap-1 mt-4">
                @foreach ($templates as $template)
                    <li class="border border-base-200 rounded-xl px-4 py-2">
                        @if ($entityType->isCustom())
                            <a
                                href="{{ route('entities.create', [$campaign, $entityType, 'copy' => $template->id, 'template' => true]) }}"
                                class="new-entity-from-template text-link w-full"
                                data-entity-type="{{ $entityType->plural() }}">
                                {{ $template->name  }}
                            </a>
                        @else
                            <a
                                href="{{ route($entityType->pluralCode() . '.create', [$campaign, 'copy' => $template->id, 'template' => true]) }}"
                                class="new-entity-from-template  text-link  w-full"
                                data-entity-type="{{ $entityType->plural() }}">
                                {{ $template->name  }}
                            </a>
                        @endif
                    </li>
                @endforeach
            </ul>
        @endif
    </div>

    <div class="quick-creator-loading p-8 text-center text-lg" style="display: none">
        <x-icon class="load" />
    </div>
</div>

</article>
