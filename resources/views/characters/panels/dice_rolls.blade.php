<table class="table no-border table-condensed table-hover">
@foreach ($model->diceRolls as $r)
        <tr>
            <td class="avatar">
                <a class="entity-image" style="background-image: url('{{ $r->getImageUrl(true) }}');" title="{{ $r->name }}" href="{{ route('dice_rolls.show', $r->id) }}"></a>
            </td>
            <td>
                <a href="{{ route('dice_rolls.show', $r->id) }}" data-toggle="tooltip" title="{{ $r->tooltip() }}" class="entity-name">
                    {{ $r->name }}
                </a>
                <span class="label label-primary pull-right" data-toggle="tooltip" title="{{ trans('dice_rolls.fields.rolls') }}">{{ $r->diceRollResults()->count() }}</span>
            </td>
        </tr>
@endforeach
</table>
