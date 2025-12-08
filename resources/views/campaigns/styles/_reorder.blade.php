<x-form :action="['campaign_styles.reorder-save', $campaign]">
<div class="flex flex-col gap-5">
    <h3 class="text-xl">
        {{ __('campaigns/styles.reorder.title') }}
    </h3>
    <div class="box-entity-story-reorder flex flex-col gap-5">
        <div class="element-live-reorder sortable-elements flex flex-col gap-1">
            @foreach($reorderStyles as $style)
                <x-reorder.child :id="$style->id">
                    <input type="hidden" name="style[]" value="{{ $style->id }}"/>
                    <div class="">
                        <span class="fa-regular fa-ellipsis-v"></span>
                    </div>
                    <div class="name overflow-hidden grow">
                        {!! $style->name !!}
                    </div>
                    <div class="self-end">
                        @if ($style->is_enabled) <x-icon class="fa-solid fa-check-circle" />@endif
                    </div>
                </x-reorder.child>
            @endforeach
        </div>
        <div class="">
            <button class="btn2 btn-primary btn-block">
                {{ __('campaigns/styles.reorder.save') }}
            </button>
        </div>
    </div>
</div>
</x-form>
