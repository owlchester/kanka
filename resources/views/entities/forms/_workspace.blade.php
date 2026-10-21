@php
    $workspaceTab = str_replace('form-', '', request()->get('tab', 'entry'));
    if (in_array($workspaceTab, ['premium', 'permission'])) {
        $workspaceTab = $workspaceTab === 'premium' ? 'entry' : 'permissions';
    }
    $workspaceTabs = [
        'entry' => __('entries/workspace.overview'),
    ];
    if ($entityType->isCharacter() && $campaign->enabled('organisations')) {
        $workspaceTabs['organisations'] = \App\Facades\Module::plural(config('entities.ids.organisation'), __('entities.organisations'));
    }
    if ($entityType->isMap()) {
        $workspaceTabs['settings'] = __('maps.panels.settings');
    }
    if ($entityType->isStandardCode('calendar')) {
        $workspaceTabs += [
            'calendar' => __('entries/workspace.settings'),
            'months' => __('calendars.panels.months'),
            'weeks' => __('calendars.panels.weeks'),
            'moons' => __('calendars.fields.moons'),
            'seasons' => __('calendars.fields.seasons'),
        ];
    }
    if ($tabAttributes) {
        $workspaceTabs['attributes'] = __('entries/tabs.properties');
    }
    if ($tabPermissions) {
        $workspaceTabs['permissions'] = __('crud.tabs.permissions');
    }
    $workspaceCopy = $creating && (!empty($source) || !empty(old('copy_source_id'))) && ($tabCopy ?? false);
    if ($workspaceCopy) {
        $workspaceTabs['copy'] = __('crud.forms.copy_options');
    }
    if (!array_key_exists($workspaceTab, $workspaceTabs)) {
        $workspaceTab = 'entry';
    }
@endphp

<div class="entry-workspace nav-tabs-custom bg-base-100 rounded-xl" data-workspace-tab="{{ $workspaceTab }}">
    <div class="entry-workspace-toolbar sticky top-12 z-10 bg-base-100 flex flex-wrap items-center justify-between gap-3 px-4 py-3 md:px-6">
        <div class="flex items-center gap-2 text-sm text-neutral-content">
            <x-icon :class="$entityType->icon()" />
            <span>{{ $creating ? __('crud.titles.new', ['module' => $entityType->name()]) : $entityType->name() }}</span>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ $creating ? route('entities.index', [$campaign, $entityType]) : route('entities.show', [$campaign, $entity]) }}" class="btn2 btn-ghost btn-sm">
                {{ __('crud.cancel') }}
            </a>
            @includeWhen(auth()->user()->can('admin', $campaign), 'cruds.fields.entity-permission')
            @include('cruds.fields.save', ['disableCancel' => true, 'target' => 'entity-form', 'model' => $creating ? null : $entity, 'stealth' => !$creating])
        </div>
    </div>

    <header class="entry-workspace-identity flex flex-col gap-5 px-4 py-6 md:px-8 md:py-8">
        <div class="flex items-start gap-4 md:gap-6">
            <div class="entry-workspace-portrait shrink-0">
                @include('cruds.fields.image-gallery', ['new' => true, 'size' => $entityType->isMap() ? 'map' : null])
            </div>
            <div class="entry-workspace-name grow min-w-0">
                @include('cruds.fields.entity-name', ['model' => $creating ? ($source ?? null) : $entity])
            </div>
        </div>
    </header>

    <div class="px-4 md:px-8 overflow-x-auto entry-workspace-navigation">
        <ul class="nav-tabs flex items-stretch" role="tablist">
            @foreach ($workspaceTabs as $target => $label)
                <li role="presentation" class="tab-{{ $target }} {{ $workspaceTab === $target ? 'active' : '' }}">
                    <a href="#form-{{ $target }}" aria-controls="form-{{ $target }}">{{ $label }}</a>
                </li>
            @endforeach
        </ul>
    </div>

    <div class="tab-content">
        <div class="tab-pane {{ $workspaceTab === 'entry' ? 'active' : '' }}" id="form-entry">
            @include('entities.forms._writing')
        </div>
        @if ($entityType->isCharacter())
        @if ($campaign->enabled('organisations'))
            <div class="tab-pane {{ $workspaceTab === 'organisations' ? 'active' : '' }}" id="form-organisations">
                @include('characters.form._organisations')
            </div>
        @endif
        @else
            @includeIf($entityType->pluralCode() . '.form._panes')
        @endif
        @if ($tabAttributes)
            <div class="tab-pane {{ $workspaceTab === 'attributes' ? 'active' : '' }}" id="form-attributes">
                @include('cruds.forms._attributes')
            </div>
        @endif
        @if ($tabPermissions)
            <div class="tab-pane {{ $workspaceTab === 'permissions' ? 'active' : '' }}" id="form-permissions">
                @include('cruds.forms._permission')
            </div>
        @endif
        @if ($workspaceCopy)
            <div class="tab-pane {{ $workspaceTab === 'copy' ? 'active' : '' }}" id="form-copy">
                @include('cruds.forms._copy')
            </div>
        @endif
    </div>
</div>

@section('scripts')
    @parent
    @vite('resources/js/forms/entry-workspace.js')
    @if ($entityType->isCharacter())
        @vite('resources/js/forms/character.js')
    @endif
@endsection
