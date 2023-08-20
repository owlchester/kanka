<?php /** @var \App\Models\TimelineEra[] $abilities */?>
{!! Form::open([
        'route' => ['entities.entity_abilities.reorder-save', $campaign, $entity],
        'method' => 'POST',
    ]) !!}
<div class="box-entity-story-reorder w-max-4xl">
    @foreach($parents as $key => $parent)
        <div class="element-live-reorder">
            <div class="element bg-base-200">
                <div class="name overflow-hidden flex-grow">
                    @if ($key === "")
                        {{ __('entities/abilities.reorder.parentless') }}
                    @else
                        {{ $parent[0]->ability->ability?->name }}
                    @endif
                </div>
                <div class="children sortable-elements">
                    @foreach($parent as $ability)
                        <div class="element bg-base-100" data-id="{{ $ability->id }}">
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

    <button class="btn2 btn-primary btn-block">
        {{ __('crud.save') }}
    </button>
</div>
{!! Form::close() !!}
