<div class="join">
    <a href="{{ route($route . '.create', $campaign) }}" class="btn2 btn-primary join-item btn-new-entity" data-entity-type="{{ $name }}" aria-label="Create {!! $singular !!}">
        <x-icon class="plus"></x-icon>
        <span class="hidden md:inline">{!! $singular !!}</span>
    </a>
    @if(!in_array($name, ['menu_links', 'relations']))
        <div class="dropdown">
            <button type="button" class="btn2 btn-primary join-item dropdown-toggle" data-toggle="dropdown" aria-expanded="false" aria-label="Create from template" aria-haspopup="menu" aria-controls="templates-submenu">
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu dropdown-menu-right" role="menu" id="templates-submenu">
                @if ($templates->isNotEmpty())
                    @foreach ($templates as $entityTemplate)
                        <li>
                            <a href="{{ route($route . '.create', [$campaign, 'copy' => $entityTemplate->entity_id, 'template' => true]) }}" class="new-entity-from-template" data-entity-type="{{ $name }}">
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
