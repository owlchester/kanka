<div class="entity-creator-body-{{ $entityType->code }}">

    @include('entities.creator.header.header')
    <div class="quick-creator-body">
        @if ($templates->isEmpty())
            <p class="">
                <a href="//docs.kanka.io/en/latest/guides/archetypes.html" target="_blank">
                    <x-icon class="link" />
                    {{ __('entries/archetypes.helpers.how') }}
                </a>
            </p>
        @else
            <ul>
                @foreach ($templates as $template)
                    <li>
                        @if ($entityType->isCustom())

                            <a href="{{ route('entities.create', [$campaign, $entityType, 'copy' => $template->id, 'template' => true]) }}" class="new-entity-from-template" data-entity-type="{{ $entityType->plural() }}">
                                {{ $template->name  }}
                            </a>
                        @else
                        <a href="{{ route($entityType->pluralCode() . '.create', [$campaign, 'copy' => $template->id, 'template' => true]) }}" class="new-entity-from-template" data-entity-type="{{ $entityType->plural() }}">
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
