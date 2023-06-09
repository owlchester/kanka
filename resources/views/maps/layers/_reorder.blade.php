<h3 class="">
    {{ __('maps/layers.reorder.title') }}
</h3>
{!! Form::open([
    'route' => ['maps.layers.reorder-save', 'map' => $model],
    'method' => 'POST',
]) !!}
    <div class="box-entity-story-reorder">
        <div class="element-live-reorder sortable-elements">
            @foreach($rows as $layer)
                <div class="element bg-base-200" data-id="{{ $layer->id }}">
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
        <button class="btn2 btn-primary btn-block">
            {{ __('maps/layers.reorder.save') }}
        </button>
    </div>
{!! Form::close() !!}
