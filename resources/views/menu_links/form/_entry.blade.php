<?php /**
 * @var \App\Models\MenuLink $model
 * @var \App\Services\EntityService $entityService
 * @var \App\Services\CampaignService $campaign
 */

$tab = empty($model) || old('entity_id') || $model->entity_id ? 'entity' : 'type';
?>

<div class="row">
    <div class="col-md-6">
@include('cruds.fields.name', ['trans' => 'menu_links'])
    </div>
    <div class="col-md-6">
@include('cruds.fields.position', ['trans' => 'menu_links'])
    </div>

@if($campaign->campaign()->boosted())
    <div class="col-md-6">
<div class="form-group">
    <label>{{ __('entities/links.fields.icon') }}</label>
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
            'fontawesome' => link_to('https://fontawesome.com/icons?d=gallery', 'FontAwesome', ['target' => '_blank'])
        ]) !!}
    </p>
</div>
    </div>
@endif
</div>

@include('cruds.fields.private')
