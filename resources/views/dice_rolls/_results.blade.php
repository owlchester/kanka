<?php $r = $model->diceRollResults()->with('creator')->orderBy('created_at', 'DESC')->paginate(); ?>

<div class="box-header">
    <h3 class="box-title">{{ __('dice_rolls.index.actions.results') }}</h3>
    <div class="box-tools">
        @can('roll', $model)
            <a href="{{ route('dice_rolls.roll', ['dice_roll' => $model]) }}" class="btn btn-box-tool">
                <i class="fa-solid fa-plus"></i> {{ trans('dice_rolls.results.actions.add') }}
            </a>
        @endcan
    </div>
</div>
<div class="box-body">
<table id="dice-rolls-results" class="table table-hover">
    <thead><tr>
        <th>{{ trans('dice_rolls.results.fields.creator') }}</th>
        <th>{{ trans('dice_rolls.results.fields.result') }}</th>
        <th>{{ trans('dice_rolls.results.fields.date') }}</th>
        <th class="text-right">

        </th>
    </tr></thead><tbody>
    @foreach ($r as $relation)
        <tr>
            <td>
                {{ $relation->creator->name }}
            </td>
            <td>{{ $relation->results }}</td>
            <td>{{ $relation->updated_at->diffForHumans() }}</td>
            <td class="text-right">
                @can('delete', $model)
                {!! Form::open(['method' => 'DELETE','route' => ['dice_rolls.destroy_roll', $model, $relation->id],'style'=>'display:inline']) !!}
                <button class="btn btn-xs btn-danger" title="{{ __('crud.remove') }}" data-toggle="tooltip">
                    <i class="fa-solid fa-trash" aria-hidden="true"></i>
                </button>
                {!! Form::close() !!}
                @endcan
            </td>
        </tr>
    @endforeach
    </tbody></table>
</div>
@if ($r->hasPages())
    <div class="box-footer text-right">
        {{ $r->fragment('tab_relation')->links() }}
    </div>
@endif

