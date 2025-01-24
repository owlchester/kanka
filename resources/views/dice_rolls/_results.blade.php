<?php $r = $entity->child->diceRollResults()->with('creator')->orderBy('created_at', 'DESC')->paginate(); ?>

<div class="flex gap-2 items-center">
    <h4 class="grow">{{ __('dice_rolls.index.actions.results') }}</h4>
    @can('view', $entity)
        <a href="{{ route('dice_rolls.roll', [$campaign, 'dice_roll' => $entity->child]) }}" class="btn2 btn-sm">
            <x-icon class="plus" /> {{ __('dice_rolls.results.actions.add') }}
        </a>
    @endcan
</div>

<x-box :padding="false">
<table id="dice-rolls-results" class="table table-hover">
    <thead><tr>
        <th>{{ __('dice_rolls.results.fields.creator') }}</th>
        <th>{{ __('dice_rolls.results.fields.result') }}</th>
        <th>{{ __('dice_rolls.results.fields.date') }}</th>
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
                @can('delete', $entity)
                    <x-form method="DELETE" :action="['dice_rolls.destroy_roll', $campaign, $entity->child, $relation->id]">
                        <button class="btn2 btn-xs btn-error btn-outline" data-title="{{ __('crud.remove') }}" data-toggle="tooltip">
                            <x-icon class="trash" />
                        </button>
                    </x-form>
                @endcan
            </td>
        </tr>
    @endforeach
    </tbody></table>
</x-box>
@if ($r->hasPages())
    <div class="text-right">
        {{ $r->fragment('tab_relation')->links() }}
    </div>
@endif

