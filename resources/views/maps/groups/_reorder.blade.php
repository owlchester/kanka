
<h3 class="">
    {{ __('maps/groups.reorder.title') }}
</h3>
<x-form :action="['maps.groups.reorder-save', $campaign, 'map' => $model]">
<div class="box-entity-story-reorder flex flex-col gap-5">
    <div class="element-live-reorder sortable-elements flex flex-col gap-1">
        @foreach($groups as $group)
            <x-reorder.child :id="$group->id">
                <input type="hidden" name="group[]" value="{{ $group->id }}" />
                <div class="dragger">
                    <x-icon class="fa-regular fa-sort" />
                </div>
                <div class="overflow-hidden grow flex flex-no-wrap items-center">
                    <span class="truncate">{!! $group->name !!}</span>
                </div>
            </x-reorder.child>
        @endforeach
    </div>
    <button class="btn2 btn-primary btn-block">
        {{ __('maps/groups.reorder.save') }}
    </button>
</div>
</x-form>
