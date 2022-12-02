<?php /** @var \App\Models\TimelineEra[] $abilities */?>
{!! Form::open([
        'route' => ['abilities.reorder-save', $entity],
        'method' => 'POST',
    ]) !!}
<div class="box box-solid box-entity-story-reorder">
    <div class="box-header">
        <h3 class="box-title">
            {{ __('abilities.reorder.title') }}
        </h3>
    </div>
    <div class="box-body">

    @foreach($parents as $key => $parent)

        <h3 class="box-title">
            @if ($key === "")
                {{ __('abilities.reorder.parentless') }}
            @else
                {{ $parent[0]->ability->ability->name }}
            @endif
        </h3>
        <div class="element-live-reorder sortable-elements">
            @foreach($parent as $ability)
                <div class="element" data-id="{{ $ability->id }}">
                    {!! Form::hidden('ability[]', $ability->id) !!}
                    <div class="dragger">
                        <span class="fa-solid fa-sort"></span>
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
    @endforeach

    </div>
    <div class="box-footer">

        <button class="btn btn-primary btn-block">
            {{ __('crud.save') }}
        </button>

    </div>
</div>
{!! Form::close() !!}
