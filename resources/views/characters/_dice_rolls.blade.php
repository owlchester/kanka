<?php $r = $model->diceRolls()->paginate(); ?>
<p class="export-hidden">{{ trans('characters.dice_rolls.hint') }}</p>
<p class="export-{{ $r->count() === 0 ? 'visible export-hidden' : 'visible' }}">{{ trans('characters.show.tabs.dice_rolls') }}</p>

<table id="character-dice-rolls" class="table table-hover {{ ($r->count() === 0 ? 'export-hidden' : '') }}">
    <tbody><tr>
        <th class="avatar"></th>
        <th>{{ trans('dice_rolls.fields.name') }}</th>
        <th>{{ trans('dice_rolls.fields.parameters') }}</th>
        <th>{{ trans('dice_rolls.fields.rolls') }}</th>
        <th>&nbsp;</th>
    </tr>
    @foreach ($r as $item)
        <tr>
            <td>
                <a class="entity-image" style="background-image: url('{{ $item->getImageUrl(40) }}');" title="{{ $item->name }}" href="{{ route('items.show', $item->id) }}"></a>
            </td>
            <td>
                <a href="{{ route('dice_rolls.show', $item->id) }}" data-toggle="tooltip" title="{{ $item->tooltip() }}">{{ $item->name }}</a>
            </td>
            <td>{{ $item->parameters }}</td>
            <td>{{ $item->diceRollResults()->count() }}</td>
            <td class="text-right">
                <a href="{{ route('dice_rolls.show', $item) }}" class="btn btn-xs btn-default">
                    <i class="fa fa-eye"></i> {{ trans('crud.view') }}
                </a>
                @can('update', $item)
                    <a href="{{ route('dice_rolls.edit', $item) }}" class="btn btn-xs btn-primary">
                        <i class="fa fa-edit"></i> {{ trans('crud.edit') }}
                    </a>
                @endcan
            </td>
        </tr>
    @endforeach
    </tbody></table>

{{ $r->fragment('tab_dice_rolls')->links() }}
