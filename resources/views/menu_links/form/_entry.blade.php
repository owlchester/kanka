<?php /**
 * @var \App\Models\MenuLink $model
 * @var \App\Services\EntityService $entityService
 * @var \App\Services\CampaignService $campaign
 * @var \App\Services\SidebarService $sidebar
 */

$campaign = CampaignLocalization::getCampaign(false);
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
<div class="row">
    <div class="col-md-6">
        @include('cruds.fields.name', ['trans' => 'menu_links'])
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label class="control-label">{{ __('entities/links.fields.icon') }}</label>

            @if($campaignService->campaign()->boosted())
                {!! Form::text(
                    'icon',
                    null,
                    [
                        'placeholder' => 'fa-solid fa-users',
                        'class' => 'form-control',
                        'maxlength' => 45
                    ]
                ) !!}
                <p class="help-block">
                    {!! __('entities/links.helpers.icon', [
                        'fontawesome' => link_to(config('fontawesome.search'), 'FontAwesome', ['target' => '_blank'])
                    ]) !!}
                </p>
            @else
                @subscriber()
                <p class="help-block">
                    {!! __('callouts.booster.pitches.icon', ['boosted-campaign' => link_to_route('settings.boost', __('concept.boosted-campaign'), ['campaign' => $campaignService->campaign()])]) !!}
                </p>
                @else
                    <p class="help-block">
                        {!! __('callouts.booster.pitches.icon', ['boosted-campaign' => link_to_route('front.boosters', __('concept.boosted-campaign'))]) !!}
                    </p>
                @endsubscriber

            @endif
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label class="control-label">
                {{ __('menu_links.fields.position') }}
                <i class="fa-solid fa-question-circle hidden-xs hidden-sm" title="{!! __('entities/links.helpers.parent') !!}" data-toggle="tooltip"></i>
            </label>
            @if ($campaignService->campaign()->boosted())
                {{ Form::select('parent', $sidebar->campaign($campaign)->availableParents(), (empty($model) || empty($model->parent) ? 'menu_links' : $model->parent), ['class' => 'form-control']) }}

                <p class="help-block visible-xs visible-sm">
                    {!! __('entities/links.helpers.parent') !!}
                </p>
            @else
                @subscriber()
                    <p class="help-block">
                        {!! __('callouts.booster.pitches.link-parent', ['boosted-campaign' => link_to_route('settings.boost', __('concept.boosted-campaign'), ['campaign' => $campaignService->campaign()])]) !!}
                    </p>
                @else
                    <p class="help-block">
                        {!! __('callouts.booster.pitches.link-parent', ['boosted-campaign' => link_to_route('front.boosters', __('concept.boosted-campaign'))]) !!}
                    </p>
                @endsubscriber
            @endif
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="config[class]">
                {{ __('dashboard.widgets.fields.class') }}
                <i class="fa-solid fa-question-circle hidden-xs hidden-sm" data-toggle="tooltip" title="{{ __('dashboard.widgets.helpers.class') }}"></i>
            </label>
            @if ($campaignService->campaign()->boosted())
                {!! Form::text('css', null, ['class' => 'form-control', 'id' => 'config[class]', 'maxlength' => 45]) !!}
                <p class="help-block visible-xs visible-sm">
                    {{ __('dashboard.widgets.helpers.class') }}
                </p>
            @else
                @subscriber()
                    <p class="help-block">
                        {!! __('callouts.booster.pitches.element-class', ['boosted-campaign' => link_to_route('settings.boost', __('concept.boosted-campaign'), ['campaign' => $campaignService->campaign()])]) !!}
                    </p>
                @else
                    <p class="help-block">
                        {!! __('callouts.booster.pitches.element-class', ['boosted-campaign' => link_to_route('front.boosters', __('concept.boosted-campaign'))]) !!}
                    </p>
                @endsubscriber
            @endif
        </div>
    </div>
    <div class="col-md-6">
        {!! Form::hidden('is_active', 0) !!}
            <label>
                {!! __('menu_links.fields.active') !!}
                <i class="fa-solid fa-question-circle hidden-xs hidden-sm" data-toggle="tooltip" title="{{ __('menu_links.helpers.active') }}"></i>
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
</div>

<hr />

<h4>{{ __('menu_links.fields.selector') }}</h4>
<p class="help-block">{{ __('menu_links.helpers.selector') }}</p>

<div class="box box-solid">
    <div class="box-body">
        <div class="menu-link-selector" id="quick-link-selector">
            <a class="btn btn-app @if($isEntity) btn-active @endif" data-type="entity">
                <i class="ra ra-tower"></i>
                {{ __('menu_links.fields.entity') }}
                <span class="badge bg-blue">
                    <i class="fa-solid fa-check"></i>
                </span>
            </a>
            <a class="btn btn-app @if($isList) btn-active @endif" data-type="list">
                <i class="fa-solid fa-th-list"></i>
                {{ __('crud.fields.type') }}
                <span class="badge bg-blue">
                    <i class="fa-solid fa-check"></i>
                </span>
            </a>
            <a class="btn btn-app @if($isRandom) btn-active @endif" data-type="random">
                <i class="fa-solid fa-question"></i>
                {{ __('menu_links.fields.random') }}
                <span class="badge bg-blue">
                    <i class="fa-solid fa-check"></i>
                </span>
            </a>
            <a class="btn btn-app @if($isDashboard) btn-active @endif" data-type="dashboard">
                <i class="fa-solid fa-th-large"></i>
                {{ __('menu_links.fields.dashboard') }}
                <span class="badge bg-blue">
                    <i class="fa-solid fa-check"></i>
                </span>
            </a>
        </div>
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
</div>

@includeWhen(auth()->user()->isAdmin(), 'cruds.fields.privacy_callout')

