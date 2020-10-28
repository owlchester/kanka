<?php
/**
 * @var \App\Models\MapLayer $layer
 * @var \App\Models\Map $model
 * @var \App\Services\CampaignService $campaign
 */
?>
@if (!isset($model) || empty($model->image))
    <div class="alert alert-warning">
        <p>{{ __('maps.helpers.missing_image') }}</p>
    </div>
@else
    <?php $layers = $model->layers()->ordered()->paginate(); ?>
    <p class="help-block">
        {{ __('maps/layers.helper.amount', ['amount' => $campaign->campaign()->maxMapLayers()]) }}
        @if (!$campaign->campaign()->boosted())
            {!! __('maps/layers.helper.boosted_campaign', ['boosted' => link_to_route('front.features', __('crud.boosted_campaigns'), '#boost'), 'amount' => \App\Models\Campaign::LAYER_COUNT_MAX])!!}
        @endif
    </p>

    <table class="table table-condensed">
    <thead>
    <tr>
        <th>{{ __('crud.fields.name') }}</th>
        <th>{{ __('maps/layers.fields.position') }}</th>
        <th>{{ __('maps/layers.fields.type') }}</th>
        <th>{{ __('crud.fields.visibility') }}</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    @foreach ($layers as $layer)
        <tr>
            <td>{{ $layer->name }}</td>
            <td>{{ $layer->position }}</td>
            <td>{{ __('maps/layers.short_types.' . $layer->typeName()) }}</td>
            <td>
                @include('cruds.partials.visibility', ['model' => $layer])
            </td>
            <td class="text-right">
                <a href="{{ route('maps.map_layers.edit', [$model, $layer]) }}" class="btn btn-primary btn-xs"
                   title="{{ __('crud.edit') }}"
                   data-toggle="ajax-modal" data-target="#entity-modal"
                   data-url="{{ route('maps.map_layers.edit', [$model, $layer]) }}"
                >
                    <i class="fa fa-pencil"></i>
                </a>

                <a href="#" class="btn btn-xs btn-danger delete-confirm" data-toggle="modal" data-name="{{ $layer->name }}"
                        data-target="#delete-confirm" data-delete-target="delete-form-layer-{{ $layer->id }}"
                        title="{{ __('crud.remove') }}">
                    <i class="fa fa-trash" aria-hidden="true"></i>
                </a>
            </td>
        </tr>
    @endforeach

    </tbody>
    </table>

    <div class="pull-right">
        {{ $layers->links() }}
    </div>

    @if ($layers->count() < $campaign->campaign()->maxMapLayers())
    <a href="{{ route('maps.map_layers.create', ['map' => $model]) }}" class="btn btn-primary btn-sm"
       data-toggle="ajax-modal" data-target="#entity-modal"
       data-url="{{ route('maps.map_layers.create', ['map' => $model]) }}"
    >
        <i class="fas fa-plus"></i> {{ __('maps/layers.actions.add') }}
    </a>
    @endif

@endif

@if (!empty($layers))
@section('modals')
    @parent
    @foreach ($layers as $layer)
        {!! Form::open(['method' => 'DELETE', 'route' => ['maps.map_layers.destroy', $model, $layer], 'style '=> 'display:inline', 'id' => 'delete-form-layer-' . $layer->id]) !!}
        {!! Form::close() !!}
    @endforeach
@endsection
@endif
