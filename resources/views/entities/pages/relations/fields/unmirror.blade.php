<div class="col-span-2 bg-base-200 rounded-2xl p-4 border-left-">
    <h4 class="text-lg">{{ __('entities/relations.linked.label') }}</h4>
    <p class="mb-4">{!! __('entities/relations.linked.helper', [
        'link' => '<a href="' . $relation->target->url() . '" data-toggle="tooltip-ajax" data-id="' . $relation->target_id . '" data-url="' . route('entities.tooltip', [$campaign, $relation->target->id]) . "\" class=\"text-link\">" . $relation->target->name . '</a>'
        ]) !!}</p>
    <x-forms.field field="unmirror" :helper="__('entities/relations.linked.unmirror-helper')">
        <input type="hidden" name="unmirror" value="0" />
        <x-checkbox
            :text="__('entities/relations.linked.break')">
            <input type="checkbox" name="unmirror" value="1" @if (old('unmirror', false)) checked="checked" @endif />
        </x-checkbox>
    </x-forms.field>
</div>
