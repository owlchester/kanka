<div class="modal-body entity-creator-body-{{ $type }}">
    @include('partials.modals.close')

    <div class="quick-creator-header">
        <div class="grid grid-cols-2 gap-1">
            <div>
                <div class="qq-mode">
                    {{ __('Templates') }}
                </div>
                <div class="qq-entity-type">
                    {{ __($type . '.create.title') }}
                </div>
            </div>
            <div class="qq-toggles text-right flex justify-content-end">
                <div class="qq-mode-toggle @if (empty($mode)) active @endif" data-mode="single" data-url="{{ route('entity-creator.form', ['type' => $type]) }}">
                    <i class="fa-regular fa-user" aria-hidden="true"></i>
                </div>
                <div class="qq-mode-toggle @if ($mode == 'bulk') active @endif" data-mode="bulk" data-url="{{ route('entity-creator.form', ['type' => $type, 'mode' => 'bulk']) }}">
                    <i class="fa-solid fa-users" aria-hidden="true"></i>
                </div>
                <div class="qq-mode-toggle @if ($mode == 'templates') active @endif" data-mode="templates" data-url="{{ route('entity-creator.form', ['type' => $type, 'mode' => 'templates']) }}">
                    <i class="fa-solid fa-shield" aria-hidden="true"></i>
                </div>
            </div>
        </div>
    </div>
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

    <div class="quick-creator-loading" style="display: none">
        <i class="fa-solid fa-spinner fa-spin" aria-hidden="true"></i>
    </div>
</div>
