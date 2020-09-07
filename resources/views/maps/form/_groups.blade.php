<?php
/**
 * @var \App\Models\MapGroup $group
 * @var \App\Models\Map $model
 * @var \App\Services\CampaignService $campaign
 */
?>
@if (!isset($model) || empty($model->image))
    <div class="alert alert-warning">
        <p>{{ __('maps.helpers.missing_image') }}</p>
    </div>
@else
    <?php $groups = $model->groups()->ordered()->paginate(); ?>
    <p class="help-block">
        {{ __('maps/groups.helper.amount', ['amount' => $campaign->campaign()->maxMapLayers()]) }}
        @if (!$campaign->campaign()->boosted())
            {!! __('maps/groups.helper.boosted_campaign', ['boosted' => link_to_route('front.features', __('crud.boosted_campaigns'), '#boost'), 'amount' => \App\Models\Campaign::LAYER_COUNT_MAX])!!}
        @endif
    </p>

    <table class="table table-condensed">
    <thead>
    <tr>
        <th>{{ __('crud.fields.name') }}</th>
        <th>{{ __('maps/groups.fields.position') }}</th>
        <th>{{ __('maps/groups.fields.is_shown') }}</th>
        <th>{{ __('crud.fields.visibility') }}</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    @foreach ($groups as $group)
        <tr>
            <td>{{ $group->name }}</td>
            <td>{{ $group->position }}</td>
            <td>@if($group->is_shown) <i class="fas fa-check"></i> @endif</td>
            <td>
                @include('cruds.partials.visibility', ['model' => $group])
            </td>
            <td class="text-right">
                <a href="{{ route('maps.map_groups.edit', [$model, $group]) }}" class="btn btn-primary btn-xs"
                   title="{{ __('crud.edit') }}"
                   data-toggle="ajax-modal" data-target="#entity-modal"
                   data-url="{{ route('maps.map_groups.edit', [$model, $group]) }}"
                >
                    <i class="fa fa-pencil"></i>
                </a>

                <a href="#" class="btn btn-xs btn-danger delete-confirm" data-toggle="modal" data-name="{{ $group->name }}"
                        data-target="#delete-confirm" data-delete-target="delete-form-group-{{ $group->id }}"
                        title="{{ __('crud.remove') }}">
                    <i class="fa fa-trash" aria-hidden="true"></i>
                </a>
            </td>
        </tr>
    @endforeach

    </tbody>
    </table>

    <div class="pull-right">
        {{ $groups->links() }}
    </div>

    @if ($groups->count() < $campaign->campaign()->maxMapLayers())
    <a href="{{ route('maps.map_groups.create', ['map' => $model]) }}" class="btn btn-primary btn-sm"
       data-toggle="ajax-modal" data-target="#entity-modal"
       data-url="{{ route('maps.map_groups.create', ['map' => $model]) }}"
    >
        <i class="fas fa-plus"></i> {{ __('maps/groups.actions.add') }}
    </a>
    @endif

@endif

@if (!empty($groups))
@section('modals')
    @parent
    @foreach ($groups as $group)
        {!! Form::open(['method' => 'DELETE', 'route' => ['maps.map_groups.destroy', $model, $group], 'style '=> 'display:inline', 'id' => 'delete-form-group-' . $group->id]) !!}
        {!! Form::close() !!}
    @endforeach
@endsection
@endif
