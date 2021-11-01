@inject('entityService', 'App\Services\EntityService')
<?php
$entityTypes = ['' => '', 'any' => __('menu_links.random_types.any')];
foreach ($entityService->getEnabledEntities($campaign->campaign()) as $entity) {
    $entityTypes[$entity] = __('entities.' . \Illuminate\Support\Str::plural($entity));
}
?>
<p class="help-block">{!! __('menu_links.helpers.random', [
]) !!}</p>


<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>{{ __('menu_links.fields.random_type') }}</label>
            {!! Form::select('random_entity_type', $entityTypes, FormCopy::field('random_entity_type')->string(), ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::tags(
                    'tag_id',
                    [
                        'model' => isset($model) ? $model : null,
                        'enableNew' => false,
                    ]
                ) !!}
            <input type="hidden" name="save_tags" value="1" />
        </div>

    </div>
</div>

