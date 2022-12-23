<a href="#" class="p-2 quick-creator-selection flex overflow-hidden items-center" data-toggle="entity-creator" data-url="{{ route('entity-creator.form', ['type' => $plural]) }}" data-entity-type="{{ $singular }}">
    <i class="{{ $icon }} mr-2 text-sm"></i>
    <span class="overflow-hidden">{{ __('entities.' . $singular) }}</span>
</a>
