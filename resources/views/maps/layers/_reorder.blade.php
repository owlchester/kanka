{!! Form::open([
    'route' => ['maps.layers.reorder-save', [$campaign, 'map' => $model]],
    'method' => 'POST',
]) !!}
    <div class="box box-solid box-entity-story-reorder">
        <div class="box-header with-border">
            <h3 class="box-title">
                {{ __('maps/layers.reorder.title') }}
            </h3>
        </div>
        <div class="box-body">

            <div class="element-live-reorder sortable-elements">
                @foreach($rows as $layer)
                    <div class="element" data-id="{{ $layer->id }}">
                        {!! Form::hidden('layer[]', $layer->id) !!}
                        <div class="dragger pr-3">
                            <span class="fa-solid fa-ellipsis-v"></span>
                        </div>
                        <div class="name overflow-hidden flex-grow">
                            {!! $layer->name !!}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="box-footer">
            <button class="btn btn-primary btn-block">
                {{ __('maps/layers.reorder.save') }}
            </button>
        </div>
    </div>
{!! Form::close() !!}
