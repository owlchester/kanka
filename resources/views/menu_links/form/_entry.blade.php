<?php /**
 * @var \App\Models\MenuLink $model
 * @var \App\Services\EntityService $entityService
 * @var \App\Services\CampaignService $campaign
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

<div class="row">
    <div class="col-md-6">
        @include('cruds.fields.name', ['trans' => 'menu_links'])
    </div>
    <div class="col-md-6">

        <div class="form-group">
            <label class="control-label">{{ __('entities/links.fields.icon') }}</label>

            @if($campaign->campaign()->boosted())
                {!! Form::text(
                    'icon',
                    null,
                    [
                        'placeholder' => 'fa fa-users',
                        'class' => 'form-control',
                        'maxlength' => 45
                    ]
                ) !!}
                <p class="help-block">
                    {!! __('entities/links.helpers.icon', [
                        'fontawesome' => link_to('https://fontawesome.com/search?m=free&s=solid', 'FontAwesome', ['target' => '_blank'])
                    ]) !!}
                </p>
            @else
                @include('partials.boosted')
            @endif
        </div>
    </div>
</div>

<h4>{{ __('menu_links.fields.selector') }}</h4>
<p class="help-block">{{ __('menu_links.helpers.selector') }}</p>

<div class="box box-solid">
    <div class="box-body">
        <div class="menu-link-selector" id="quick-link-selector">
            <a class="btn btn-app @if($isEntity) btn-active @endif" data-type="entity">
                <i class="ra ra-tower"></i>
                {{ __('menu_links.fields.entity') }}
                <span class="badge bg-blue">
                    <i class="fa fa-check"></i>
                </span>
            </a>
            <a class="btn btn-app @if($isList) btn-active @endif" data-type="list">
                <i class="fa fa-th-list"></i>
                {{ __('menu_links.fields.type') }}
                <span class="badge bg-blue">
                    <i class="fa fa-check"></i>
                </span>
            </a>
            <a class="btn btn-app @if($isRandom) btn-active @endif" data-type="random">
                <i class="fa fa-question"></i>
                {{ __('menu_links.fields.random') }}
                <span class="badge bg-blue">
                    <i class="fa fa-check"></i>
                </span>
            </a>
            <a class="btn btn-app @if($isDashboard) btn-active @endif" data-type="dashboard">
                <i class="fa fa-th-large"></i>
                {{ __('menu_links.fields.dashboard') }}
                <span class="badge bg-blue">
                    <i class="fa fa-check"></i>
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

@include('cruds.fields.private2')

