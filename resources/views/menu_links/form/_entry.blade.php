<?php /**
 * @var \App\Models\MenuLink $model
 * @var \App\Services\EntityService $entityService
 * @var \App\Services\SidebarService $sidebar
 */

$tab = empty($model) || old('entity_id') || $model->entity_id ? 'entity' : 'type';

$isEntity = $isDashboard = $isRandom = $isList = false;
if (isset($model)) {
    if ($model->isDashboard()) {
        $isDashboard = true;
    } elseif ($model->isEntity()) {
        $isEntity = true;
    } elseif ($model->isList()) {
        $isList = true;
    } elseif ($model->isRandom()) {
        $isRandom = true;
    }
}
?>
@inject('sidebar', 'App\Services\SidebarService')
<x-grid>
    @include('cruds.fields.name', ['trans' => 'menu_links'])

    <x-forms.field field="icon" :label="__('entities/links.fields.icon')">
        @if($campaign->boosted())
            {!! Form::text(
                'icon',
                null,
                [
                    'placeholder' => 'fa-solid fa-users',
                    'class' => 'form-control',
        'data-paste' => 'fontawesome',
                    'maxlength' => 45
                ]
            ) !!}
            <p class="help-block">
                {!! __('entities/links.helpers.icon', [
                    'fontawesome' => link_to(config('fontawesome.search'), 'FontAwesome', ['target' => '_blank']),
                    'rpgawesome' => link_to('https://nagoshiashumari.github.io/Rpg-Awesome/', 'RPGAwesome', ['target' => '_blank']),
                    'docs' => link_to('https://docs.kanka.io/en/latest/articles/available-icons.html', __('footer.documentation', ['target' => '_blank']))
                ]) !!}
            </p>
        @else
            @subscriber()
            <p class="help-block">
                {!! __('callouts.booster.pitches.icon', ['boosted-campaign' => link_to_route('settings.premium', __('concept.premium-campaign'), ['campaign' => $campaign])]) !!}
            </p>
            @else
                <p class="help-block">
                    {!! __('callouts.booster.pitches.icon', ['boosted-campaign' => link_to('https://kanka.io/premium', __('concept.premium-campaign'))]) !!}
                </p>
            @endsubscriber

        @endif
    </x-forms.field>

    <x-forms.field
        field="position"
        :label="__('menu_links.fields.position')"
        :tooltip="true"
        :helper="__('entities/links.helpers.parent')">
        @if ($campaign->boosted())
            {{ Form::select('parent', $sidebar->campaign($campaign)->availableParents(), (empty($model) || empty($model->parent) ? 'menu_links' : $model->parent), ['class' => 'form-control']) }}

            <p class="text-neutral-content md:hidden">
                {!! __('entities/links.helpers.parent') !!}
            </p>
        @else
            @subscriber()
                <p class="help-block">
                    {!! __('callouts.booster.pitches.link-parent', ['boosted-campaign' => link_to_route('settings.premium', __('concept.premium-campaign'), ['campaign' => $campaign])]) !!}
                </p>
            @else
                <p class="help-block">
                    {!! __('callouts.booster.pitches.link-parent', ['boosted-campaign' => link_to('https://kanka.io/premium', __('concept.premium-campaign'))]) !!}
                </p>
            @endsubscriber
        @endif
    </x-forms.field>

    <x-forms.field
        field="class"
        :label="__('dashboard.widgets.fields.class')"
        :tooltip="true"
        :helper="__('dashboard.widgets.helpers.class')"
    >
        @if ($campaign->boosted())
            {!! Form::text('css', null, ['class' => 'form-control', 'id' => 'config[class]', 'maxlength' => 45]) !!}
            <p class="text-neutral-content md:hidden">
                {{ __('dashboard.widgets.helpers.class') }}
            </p>
        @else
            @subscriber()
                <p class="help-block">
                    {!! __('callouts.booster.pitches.element-class', ['boosted-campaign' => link_to_route('settings.premium', __('concept.premium-campaign'), ['campaign' => $campaign])]) !!}
                </p>
            @else
                <p class="help-block">
                    {!! __('callouts.booster.pitches.element-class', ['boosted-campaign' => link_to('https://kanka.io/premium', __('concept.premium-campaign'))]) !!}
                </p>
            @endsubscriber
        @endif
    </x-forms.field>

    <x-forms.field field="active" :label="__('menu_links.fields.active')" :tooltip="true" :helper="__('menu_links.helpers.active')">
        {!! Form::hidden('is_active', 0) !!}

        <label class="text-neutral-content cursor-pointer flex gap-2">
            {!! Form::checkbox('is_active', 1, isset($model) ? $model->is_active : 1) !!}
            <span>{{ __('menu_links.visibilities.is_active') }}</span>
        </label>

    </x-forms.field>
</x-grid>

<hr />

<h4>{{ __('menu_links.fields.selector') }}</h4>
<p class="help-block">{{ __('menu_links.helpers.selector') }}</p>

<x-forms.field field="target" :label="__('menu_links.fields.target')">
    <select name="type" class="form-control" id="quick-link-selector">
        <option value="">Choose an option</option>
        <option value="entity" @if($isEntity) selected="selected" @endif data-target="#quick-link-entity">
            {{ __('menu_links.fields.entity') }}
        </option>
        <option value="type" @if($isList) selected="selected" @endif data-target="#quick-link-list">
            {{ __('crud.fields.type') }}
        </option>
        <option value="random" @if($isRandom) selected="selected" @endif data-target="#quick-link-random">
            {{ __('menu_links.fields.random') }}
        </option>
        <option value="dashboard" @if($isDashboard) selected="selected" @endif data-target="#quick-link-dashboard">
            {{ __('menu_links.fields.dashboard') }}
        </option>
    </select>
</x-forms.field>
<div>
    <div class="quick-link-subform" id="quick-link-entity" @if($isEntity) @else style="display: none" @endif>
        @include('menu_links.form._entity')
    </div>
    <div class="quick-link-subform" id="quick-link-list" @if($isList) @else style="display: none" @endif>
        @include('menu_links.form._type')
    </div>
    <div class="quick-link-subform" id="quick-link-random" @if($isRandom) @else style="display: none" @endif>
        @include('menu_links.form._random')
    </div>
    <div class="quick-link-subform" id="quick-link-dashboard" @if($isDashboard) @else style="display: none" @endif>
        @include('menu_links.form._dashboard')
    </div>
</div>

<hr />
@includeWhen(auth()->user()->isAdmin(), 'cruds.fields.privacy_callout')

