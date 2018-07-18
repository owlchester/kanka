<?php $r = $model->diceRollResults()->with('creator')->orderBy('created_at', 'DESC')->paginate(); ?>
<p class="export-hidden">{{ trans('dice_rolls.results.hint') }}</p>
<p class="export-{{ $r->count() === 0 ? 'visible export-hidden' : 'visible' }}">{{ trans('dice_rolls.show.tabs.results') }}</p>

<table id="dice-rolls-results" class="table table-hover {{ ($r->count() === 0 ? 'export-hidden' : '') }}">
    <tbody><tr>
        <th>{{ trans('dice_rolls.results.fields.creator') }}</th>
        <th>{{ trans('dice_rolls.results.fields.result') }}</th>
        <th>{{ trans('dice_rolls.results.fields.date') }}</th>
        <th class="pull-right">
            @can('roll', $model)
                <a href="{{ route('dice_rolls.roll', ['dice_roll' => $model]) }}" class="btn btn-primary btn-sm">
                    <i class="fa fa-plus"></i> {{ trans('dice_rolls.results.actions.add') }}
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
                    <i class="fa fa-trash" aria-hidden="true"></i> {{ trans('crud.remove') }}
                </button>
                {!! Form::close() !!}
                @endcan
            </td>
        </tr>
    @endforeach
    </tbody></table>

{{ $r->fragment('tab_relation')->links() }}
