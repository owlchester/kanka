<?php /** @var \App\Models\Entity $entity
 * @var \App\Models\Relation $relation
 */

$options = [
    '' => __('entities/relations.options.relations'),
    'related' => __('entities/relations.options.related'),
    'mentions' => __('entities/relations.options.mentions'),
];

?>
@if(!$campaign->campaign()->boosted())

    <div class="visu-teaser text-center">
        <a href="{{ route('front.pricing', '#boost') }}" target="_blank">
            {!! __('entities/relations.teaser') !!}
        </a>
    </div>
    <?php return ?>
@endif

{!! Form::open([
    'route' => ['entities.relations.index', $entity],
    'method' => 'GET',
]) !!}
<div class="box box-solid">
    <div class="box-body">
        <div class="input-group">
            {!! Form::select('option', $options, $option, ['class' => 'form-control']) !!}
            <div class="input-group-btn">

                <input type="submit" value="{{ __('entities/relations.options.show') }}" class="btn btn-primary" />
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}

<div class="box box-solid box-entity-relations box-entity-relations-explorer">
    <div class="box-body">
    <div class="loading text-center" id="spinner">
        <i class="fa fa-spinner fa-spin fa-4x"></i>
    </div>
    <div id="cy" class="cy" style="display: none;" data-url="{{ route('entities.relations_map', [$entity, 'option' => $option]) }}"></div>

    </div>
</div>
