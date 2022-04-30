<?php $r = $model->diceRollResults()->with('creator')->orderBy('created_at', 'DESC')->paginate(); ?>


<table id="dice-rolls-results" class="table table-hover">
    <tbody><tr>
        <th>{{ trans('dice_rolls.results.fields.creator') }}</th>
        <th>{{ trans('dice_rolls.results.fields.result') }}</th>
        <th>{{ trans('dice_rolls.results.fields.date') }}</th>
        <th class="pull-right">
            @can('roll', $model)
                <a href="{{ route('dice_rolls.roll', ['dice_roll' => $model]) }}" class="btn btn-primary btn-sm">
                    <i class="fa-solid fa-plus"></i> {{ trans('dice_rolls.results.actions.add') }}
                </a>
            @endcan
        </th>
    </tr>
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
                <button class="btn btn-xs btn-danger">
                    <i class="fa-solid fa-trash" aria-hidden="true"></i> {{ trans('crud.remove') }}
                </button>
                {!! Form::close() !!}
                @endcan
            </td>
        </tr>
    @endforeach
    </tbody></table>

{{ $r->fragment('tab_relation')->links() }}
