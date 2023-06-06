<?php /** @var \App\Models\Entity $entity
 * @var \App\Models\Relation $relation
 */

$options = [
    '' => __('entities/relations.options.relations'),
    'only_relations' => __('entities/relations.options.only_relations'),
    'related' => __('entities/relations.options.related'),
    'mentions' => __('entities/relations.options.mentions'),
];

?>
@if(!$campaignService->campaign()->boosted())
    <x-cta :campaign="$campaignService->campaign()">
        <p>{{ __('entities/relations.call-to-action') }}</p>
    </x-cta>
    <?php return ?>
@endif

{!! Form::open([
    'route' => ['entities.relations.index', $entity],
    'method' => 'GET',
]) !!}
    <div class="join mb-5 w-full">
        {!! Form::select('option', $options, $option, ['class' => 'form-control join-item']) !!}
        <input type="submit" value="{{ __('entities/relations.options.show') }}" class="btn2 btn-primary join-item" />
    </div>
{!! Form::hidden('mode', 'map') !!}
{!! Form::close() !!}

<x-box css="box box-solid box-entity-relations box-entity-relations-explorer">
    <div class="loading text-center" id="spinner">
        <i class="fa-solid fa-spinner fa-spin fa-4x" aria-hidden="true"></i>
    </div>
    <div id="cy" class="cy" style="display: none;" data-url="{{ route('entities.relations_map', [$entity, 'option' => $option]) }}"></div>
</x-box>
