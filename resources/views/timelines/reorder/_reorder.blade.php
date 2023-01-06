<?php /** @var \App\Models\TimelineEra[] $eras */?>
{!! Form::open([
        'route' => ['timelines.reorder-save', $timeline],
        'method' => 'POST',
    ]) !!}
<div class="box box-solid box-entity-story-reorder">
    <div class="box-header">
        <h3 class="box-title">
            {{ __('timelines.reorder.title') }}
        </h3>
    </div>
    <div class="box-body">
        <div class="element-live-reorder sortable-elements">
            @foreach($eras as $era)
                <div class="element" data-id="{{ $era->id }}">
                    {!! Form::hidden('timeline_era[]', $era->id) !!}
                    <div class="dragger">
                        <span class="fa-solid fa-sort"></span>
                    </div>
                    <div class="name">
                        {!! $era->name !!}
                        <span class="text-sm">
                            {!! $era->ages()!!}
                        </span>
                    </div>

                    @if (!$era->orderedElements->isEmpty())
                    <div class="sortable-elements children">
                        @foreach ($era->orderedElements as $element)
                            @if ($element->invisibleEntity())
                                @continue
                            @endif
                            <div class="element" data-id="element-{{ $element->id }}">
                                {!! Form::hidden('timeline_element[' . $era->id . '][]', $element->id) !!}
                                <div class="dragger rounded-icon">
                                    {!! $element->htmlIcon() !!}
                                </div>
                                <div class="name">
                                    {!! $element->htmlName() !!}
                                    @if (isset($element->date))<span class="text-sm">({{ $element->date }})</span>@endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
    <div class="box-footer">

        <button class="btn btn-primary btn-block">
            {{ __('crud.save') }}
        </button>

    </div>
</div>
{!! Form::close() !!}
