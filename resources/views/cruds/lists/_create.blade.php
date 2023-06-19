<div class="join">
    <a href="{{ route($route . '.create') }}" class="btn2 btn-primary join-item btn-new-entity" data-entity-type="{{ $name }}">
        <x-icon class="plus"></x-icon>
        <span class="hidden-xs hidden-sm">{!! $singular !!}</span>
    </a>
    @if(!in_array($name, ['menu_links', 'relations']))
        <div class="dropdown">
            <button type="button" class="btn2 btn-primary join-item dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu dropdown-menu-right">
                @if ($templates->isNotEmpty())
                    @foreach ($templates as $entityTemplate)
                        <li>
                            <a href="{{ route($route . '.create', ['copy' => $entityTemplate->entity_id, 'template' => true]) }}" class="new-entity-from-template" data-entity-type="{{ $name }}">
                                <i class="fa-solid fa-star" aria-hidden="true"></i> {{ $entityTemplate->name  }}</span>
                            </a>
                        </li>
                    @endforeach
                    <li class="divider"></li>
                @endif
                <li>
                    <a href="//docs.kanka.io/en/latest/guides/templates.html" target="_blank">
                        <i class="fa-solid fa-external-link"></i> {{ __('helpers.entity_templates.link') }}
                    </a>
                </li>
            </ul>
        </div>
    @endif
</div>
