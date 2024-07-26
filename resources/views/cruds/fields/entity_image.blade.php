
@php
$preset = null;
$name = 'entity_image_uuid';

if (isset($bulk)) {
    $name = 'entity_image';
}
if (isset($model) && $model->entity && $model->entity->image_uuid) {
    $preset = $model->entity->image;
} else {
    $preset = FormCopy::field('image')->entity()->select();
}
@endphp
@if(!isset($bulk))
    <x-helper>
        {{ __('fields.gallery-image.description') }}
    </x-helper>
@endif
<x-grid type="{{ isset($bulk) ? '1-1' : '3/4' }}">
    <div class="col-span-3">
        <x-forms.foreign
            field="image-gallery"
            :campaign="$campaign"
            :name="$name"
            :allowClear="true"
            :route="route('images.find', $campaign)"
            :label="__('crud.fields.image')"
            :placeholder="__('fields.gallery.placeholder')"
            :selected="$preset">
        </x-forms.foreign>
    </div>
        @if (!isset($bulk) && !empty($model->entity) && !empty($model->entity->image_uuid) && !empty($model->entity->image))
            <div class="preview-v2">
                <a class="h-28 cover-background relative inline-block w-full text-white bg-red-900/50 hover:bg-red-900/90" href="{{ route('gallery', [$campaign, 'folder_id' => $model->entity->image->folder_id]) }}" style="background-image: url('{{ $model->entity->image->getUrl(240,112) }}')" title="{{ $model->name }}">
                </a>
            </div>
        @endif
</x-grid>
@if (!empty($model->entity) && !empty($model->entity->image_uuid) && empty($model->entity->image))
    <input type="hidden" name="entity_image_uuid" value="{{ $model->entity->image_uuid }}" />
@endif
