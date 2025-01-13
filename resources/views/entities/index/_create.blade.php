<div class="join">
    <a href="{{  $entityType->createRoute($campaign) }}" class="btn2 btn-primary join-item btn-new-entity" data-entity-type="{{ $entityType->code }}"
       aria-label="Create {!!$entityType->name() !!}">
        <x-icon class="plus" />
        <span class="hidden md:inline">{!! $entityType->name() !!}</span>
    </a>
    <div class="dropdown">
        <button type="button" class="btn2 btn-primary join-item" data-dropdown aria-expanded="false" aria-label="Create from template" aria-haspopup="menu" aria-controls="templates-submenu">
            <x-icon class="fa-solid fa-caret-down" />
            <span class="sr-only">{{ __('crud.actions.actions') }}</span>
        </button>
        <div class="dropdown-menu hidden" role="menu" id="templates-submenu">
            @if (auth()->user()->can('useTemplates', $campaign) && $templates->isNotEmpty())
                @foreach ($templates as $entityTemplate)
                    <x-dropdowns.item
                        :link="$entityType->createRoute($campaign, ['copy' => $entityTemplate->entity_id, 'template' => true])"
                        css="new-entity-from-template" icon="fa-solid fa-star">
                        {{ $entityTemplate->name  }}
                    </x-dropdowns.item>
                @endforeach
                <hr class="m-0" />
            @endif
            <x-dropdowns.item link="https://docs.kanka.io/en/latest/guides/templates.html" target="_blank" icon="fa-solid fa-external-link">
                    {{ __('helpers.entity_templates.link') }}
            </x-dropdowns.item>
        </div>
    </div>
</div>
