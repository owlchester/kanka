<?php
/**
 * @var \App\Models\TimelineEra $era
 * @var \App\Models\Timeline $model
 * @var \App\Services\CampaignService $campaign
 */
?>

@if (!isset($model))
    <x-alert type="warning">
        {{ __('timelines/eras.helpers.eras') }}
    </x-alert>
@else
    <p class="help-block">
        {{ __('timelines/eras.helpers.primary') }}
    </p>

    <table class="table table-condensed">
    <thead>
    <tr>
        <th>{{ __('crud.fields.name') }}</th>
        <th>{{ __('timelines/eras.fields.abbreviation') }}</th>
        <th>{{ __('timelines/eras.fields.start_year') }}</th>
        <th>{{ __('timelines/eras.fields.end_year') }}</th>
        <th>{{ __('timelines/eras.fields.is_collapsed') }}</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    <?php $eras = $model->eras()->ordered()->paginate(); ?>
    @foreach ($eras as $era)
        <tr>
            <td>{{ $era->name }}</td>
            <td>{{ $era->abbreviation }}</td>
            <td>{{ $era->start_year }}</td>
            <td>{{ $era->end_year }}</td>
            <td>
                @if($era->is_collapsed)
                    <i class="fa-solid fa-check-circle" title="{{ __('timelines/eras.helpers.is_collapsed') }}" data-toggle="tooltip"></i>
                @endif
            </td>
            <td class="text-right">
                <a href="{{ route('timelines.timeline_eras.edit', [$model, $era]) }}" class="btn btn-primary btn-xs"
                   title="{{ __('crud.edit') }}"
                   data-toggle="ajax-modal" data-target="#large-modal"
                   data-url="{{ route('timelines.timeline_eras.edit', [$model, $era]) }}"
                   data-backdrop="static"
                >
                    <x-icon class="pencil"></x-icon>
                </a>

                <a href="#" class="btn btn-xs btn-danger delete-confirm" data-toggle="modal" data-name="{{ $era->name }}"
                        data-target="#delete-confirm" data-delete-target="delete-form-era-{{ $era->id }}"
                        title="{{ __('crud.remove') }}">
                    <x-icon class="trash"></x-icon>
                </a>
            </td>
        </tr>
    @endforeach

    </tbody>
    </table>

    <div class="pull-right">
        {{ $eras->links() }}
    </div>

    <a href="{{ route('timelines.timeline_eras.create', ['timeline' => $model]) }}" class="btn2 btn-primary btn-sm"
       data-toggle="ajax-modal" data-target="#large-modal"
       data-url="{{ route('timelines.timeline_eras.create', ['timeline' => $model]) }}"
       data-backdrop="static"
    >
        <x-icon class="plus"></x-icon> {{ __('timelines/eras.actions.add') }}
    </a>

    <hr />

    <div class="field-revert">
        {!! Form::hidden('revert_order', 0) !!}
        <label>{!! Form::checkbox('revert_order') !!}
            {{ __('timelines.fields.reverse_order') }}
        </label>

        <p class="help-block">
            {!! __('timelines.helpers.reverse_order') !!}
        </p>
    </div>


@if (!empty($eras))
@section('modals')
    @parent
    @foreach ($eras as $era)
        {!! Form::open(['method' => 'DELETE', 'route' => ['timelines.timeline_eras.destroy', $model, $era], 'style '=> 'display:inline', 'id' => 'delete-form-era-' . $era->id]) !!}
        {!! Form::close() !!}
    @endforeach
@endsection
@endif

@endif


@section('scripts')
    @parent
    @vite(['resources/js/timeline.js', resources/js/ajax-subforms.js'])
@endsection
