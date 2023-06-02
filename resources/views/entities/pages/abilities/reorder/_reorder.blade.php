<?php /** @var \App\Models\TimelineEra[] $abilities */?>
{!! Form::open([
        'route' => ['entities.entity_abilities.reorder-save', $entity],
        'method' => 'POST',
    ]) !!}
<x-box css="box-entity-story-reorder">
    @foreach($parents as $key => $parent)
        <div class="element-live-reorder">
            <div class="element">
                <div class="name overflow-hidden flex-grow">
                    @if ($key === "")
                        {{ __('entities/abilities.reorder.parentless') }}
                    @else
                        {{ $parent[0]->ability->ability?->name }}
                    @endif
                </div>
                <div class="children sortable-elements">
                    @foreach($parent as $ability)
                        <div class="element" data-id="{{ $ability->id }}">
                            {!! Form::hidden('ability[]', $ability->id) !!}
                            <div class="dragger pr-3">
                                <span class="fa-solid fa-sort" aria-hidden="true"></span>
                            </div>
                            <div class="name">
                                {!! $ability->ability->name !!}
                                <span class="text-sm">
                                    {!! $ability->ability->type!!}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endforeach

    <button class="btn btn-primary btn-block">
        {{ __('crud.save') }}
    </button>
</x-box>
{!! Form::close() !!}
