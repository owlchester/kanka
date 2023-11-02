@php
$preset = null;
if (isset($model) && $model->entity && $model->entity->header_uuid) {
    $preset = $model->entity->header;
} else {
    $preset = FormCopy::field('header')->entity()->select();
}
@endphp
<x-forms.field
    field="header-gallery"
    :label="__('fields.gallery-header.description')">
    <x-grid type="3/4">
        <div class="col-span-3">
            <x-forms.foreign
                :campaign="$campaign"
                name="entity_header_uuid"
                :allowClear="true"
                :route="route('images.find', $campaign)"
                :label="__('crud.fields.image')"
                :placeholder="__('fields.gallery.placeholder')"
                :selected="$preset">
            </x-forms.foreign>
        </div>

        <div class="preview">
            @if (!empty($model->entity) && !empty($model->entity->header_uuid) && !empty($model->entity->header))
                @include('cruds.fields._image_preview', [
                    'image' => $model->entity->header->getUrl(80, null, 'header_image'),
                    'title' => $model->name,
                ])
            @endif
        </div>
    </x-grid>
</x-forms.field>

@if (!empty($model->entity) && !empty($model->entity->image_uuid) && empty($model->entity->image))
    <input type="hidden" name="entity_image_uuid" value="{{ $model->entity->image_uuid }}" />
@endif
