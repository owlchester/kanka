{!! Form::open([
        'route' => ['timeline-eras.reorder-save', $timeline],
        'method' => 'POST',
    ]) !!}
<div class="box box-solid box-entity-story-reorder">
    <div class="box-header">
        <h3 class="box-title">
            {{ __('timelines/eras.reorder.title') }}
        </h3>
    </div>
    <div class="box-body">
        <div class="element-live-reorder">
            @foreach($eras as $era)
                <div class="element" data-id="{{ $era->id }}">
                    {!! Form::hidden('timeline_era[]', $era->id) !!}
                    <div class="dragger">
                        <span class="fa-solid fa-ellipsis-v visible-md visible-lg"></span>
                        <div class="visible-xs visible-sm">
                            <span class="fa-solid fa-arrow-up"></span><br />
                            <span class="fa-solid fa-arrow-down"></span>
                        </div>
                    </div>
                    <div class="name">
                        {!! $era->name !!}
                        <span class="text-sm">
                                {!! $era->ages()!!}
                            </span>
                    </div>
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
