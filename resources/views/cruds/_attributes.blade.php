@inject('attributeService', 'App\Services\AttributeService')
<?php
/**
 * @var \App\Services\AttributeService $attributeService
 * @var \App\Models\MiscModel $model
 */
$layout = $model->entity->attributes()->where(['name' => '_layout'])->first();
if ($layout) {
    $template = $attributeService->communityTemplate($layout->value);
    $marketplaceTemplate = $attributeService->marketplaceTemplate($layout->value, $campaign->campaign());
}
?>

@can('attribute', [$model, 'add'])
    <p class="text-right">
        <a class="btn btn-primary" href="{{ route('entities.attributes.template', $model->entity) }}" data-toggle="ajax-modal" data-target="#entity-modal" data-url="{{ route('entities.attributes.template', $model->entity) }}">
            <i class="fa fa-copy"></i> <span class="hidden-xs hidden-sm">{{ trans('crud.attributes.actions.apply_template') }}</span>
        </a>

        <a href="{{ route('entities.attributes.edit', ['entity' => $model->entity]) }}" class="btn btn-primary">
            <i class="fa fa-list"></i> <span class="hidden-xs hidden-sm">{{ trans('crud.attributes.actions.manage') }}</span>
        </a>
    </p>
@endcan

@if (!empty($template))
    @include($template->view())
@elseif (!empty($marketplaceTemplate))
    @include('cruds.attributes.marketplace_template', ['plugin' => $marketplaceTemplate])
@else
    @include('cruds.partials.attributes', [
        'attributes' => $model->entity->attributes()->with('entity')->order(request()->get('order'), 'default_order')->get()
    ])
@endif
