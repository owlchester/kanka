<h3 class="">
    {{ __('maps/layers.reorder.title') }}
</h3>
{!! Form::open([
    'route' => ['maps.layers.reorder-save', $campaign, 'map' => $model],
    'method' => 'POST',
]) !!}
<div class="box-entity-story-reorder flex flex-col gap-5">
    <div class="element-live-reorder sortable-elements flex flex-col gap-1">
        @foreach($rows as $layer)
            <x-reorder.child :id="$layer->id">
                <input type="hidden" name="layer[]" value="{{ $layer->id }}" />
                <div class="dragger pr-3">
                    <span class="fa-solid fa-ellipsis-v"></span>
                </div>
                <div class="name overflow-hidden grow">
                    {!! $layer->name !!}
                    <span class="text-neutral-content text-xs">
                        ({{ __('maps/layers.short_types.' . $layer->typeName()) }})
                    </span>
                </div>
            </x-reorder.child>
        @endforeach
    </div>
    <button class="btn2 btn-primary btn-block">
        {{ __('maps/layers.reorder.save') }}
    </button>
</div>
{!! Form::close() !!}
