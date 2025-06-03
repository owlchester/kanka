<h3 class="">
    {{ __('maps/layers.reorder.title') }}
</h3>
<x-form :action="['maps.layers.reorder-save', $campaign, 'map' => $model]">
<div class="box-entity-story-reorder flex flex-col gap-5">
    <div class="element-live-reorder sortable-elements flex flex-col gap-1">
        @foreach($rows as $layer)
            <x-reorder.child :id="$layer->id">
                <input type="hidden" name="layer[]" value="{{ $layer->id }}" />
                <div class="dragger">
                    <x-icon class="fa-regular fa-sort" />
                </div>
                <div class="overflow-hidden grow flex flex-no-wrap items-center gap-2">
                    <span class="truncate">{!! $layer->name !!}</span>
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
</x-form>
