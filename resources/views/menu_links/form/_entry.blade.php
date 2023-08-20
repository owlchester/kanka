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

    <div class="field-icon">
        <label class="control-label">{{ __('entities/links.fields.icon') }}</label>

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
    </div>

    <div class="field-position">
        <label class="control-label">
            {{ __('menu_links.fields.position') }}
            <i class="fa-solid fa-question-circle hidden-xs hidden-sm" data-title="{!! __('entities/links.helpers.parent') !!}" data-toggle="tooltip"></i>
        </label>
        @if ($campaign->boosted())
            {{ Form::select('parent', $sidebar->campaign($campaign)->availableParents(), (empty($model) || empty($model->parent) ? 'menu_links' : $model->parent), ['class' => 'form-control']) }}

            <p class="help-block visible-xs visible-sm">
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
    </div>
    <div class="field-class">
        <label for="config[class]">
            {{ __('dashboard.widgets.fields.class') }}
            <i class="fa-solid fa-question-circle hidden-xs hidden-sm" data-toggle="tooltip" data-title="{{ __('dashboard.widgets.helpers.class') }}"></i>
        </label>
        @if ($campaign->boosted())
            {!! Form::text('css', null, ['class' => 'form-control', 'id' => 'config[class]', 'maxlength' => 45]) !!}
            <p class="help-block visible-xs visible-sm">
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
    </div>

    <div class="field-active">
        {!! Form::hidden('is_active', 0) !!}
            <label>
                {!! __('menu_links.fields.active') !!}
                <i class="fa-solid fa-question-circle hidden-xs hidden-sm" data-toggle="tooltip" data-title="{{ __('menu_links.helpers.active') }}"></i>
            </label>

        <div class="checkbox my-1">
            <label>
            {!! Form::checkbox('is_active', 1, isset($model) ? $model->is_active : 1) !!}
            {{ __('menu_links.visibilities.is_active') }}
            </label>
        </div>
        <div class="help-block visible-xs visible-sm">
            {{ __('menu_links.helpers.active') }}
        </div>
    </div>
</x-grid>

<hr />

<h4>{{ __('menu_links.fields.selector') }}</h4>
<p class="help-block">{{ __('menu_links.helpers.selector') }}</p>

<div class="field-target">
    <label>{{ __('menu_links.fields.target') }}</label>
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
</div>
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

