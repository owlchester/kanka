<div class="entity-creator-body-{{ $type }}">

    @include('entities.creator.header.header')
    <div class="quick-creator-body">
        @if ($templates->isEmpty())
            <p class="">
                <a href="//docs.kanka.io/en/latest/guides/templates.html" target="_blank">
                    <i class="fa-solid fa-external-link"></i> {{ __('helpers.entity_templates.link') }}
                </a>
            </p>
        @else
            <ul>
                @foreach ($templates as $template)
                    <li>
                        <a href="{{ route($type . '.create', [$campaign, 'copy' => $template->id, 'template' => true]) }}" class="new-entity-from-template" data-entity-type="{{ $type }}">
                            {{ $template->name  }}
                        </a>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>

    <div class="quick-creator-loading p-8 text-center text-lg" style="display: none">
        <x-icon class="load" />
    </div>
</div>
