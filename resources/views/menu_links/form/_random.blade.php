@inject('entityService', 'App\Services\EntityService')
<?php
$entityTypes = ['' => '', 'any' => __('menu_links.random_types.any')];
$entities = $entityService->campaign($campaignService->campaign())->getEnabledEntitiesSorted(false);
$entityTypes = array_merge($entityTypes, $entities);
?>
<p class="help-block">{!! __('menu_links.helpers.random', [
]) !!}</p>

<x-grid>
    <div class="form-group">
        <label>{{ __('menu_links.fields.random_type') }}</label>
        {!! Form::select('random_entity_type', $entityTypes, FormCopy::field('random_entity_type')->string(), ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        <input type="hidden" name="save_tags" value="1" />
        <x-forms.tags
            :model="$model ?? null">
        </x-forms.tags>
    </div>
</x-grid>
