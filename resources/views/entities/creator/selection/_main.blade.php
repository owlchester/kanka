<a href="#" class="p-2 quick-creator-selection" data-toggle="entity-creator" data-url="{{ route('entity-creator.form', ['type' => $plural]) }}" data-entity-type="{{ $singular }}">
    <i class="{{ $icon }}"></i>
    <span>{{ __('entities.' . $singular) }}</span>
</a>
