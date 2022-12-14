<div class="modal-body entity-creator-body-{{ $type }}">
    @include('partials.modals.close')

    @include('entities.creator.header.header')
    <div class="quick-creator-body">
        @if ($templates->isEmpty())
            <div class="alert alert-info">
                <a href="//docs.kanka.io/en/latest/guides/templates.html" target="_blank">
                    <i class="fa-solid fa-external-link"></i> {{ __('helpers.entity_templates.link') }}
                </a>
            </div>
        @else
            <ul>
                @foreach ($templates as $template)
                    <li>
                        <a href="{{ route($type . '.create', ['copy' => $template->entity_id, 'template' => true]) }}" class="new-entity-from-template" data-entity-type="{{ $type }}">
                            {{ $template->name  }}
                        </a>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>

    <div class="quick-creator-loading p-8 text-center" style="display: none">
        <i class="fa-solid fa-spinner fa-spin" aria-hidden="true"></i>
    </div>
</div>
