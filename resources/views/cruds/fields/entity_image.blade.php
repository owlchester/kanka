<label>
    {{ __('fields.gallery-image.title') }}
</label>
@if ($campaign->superboosted())
    @php
    $preset = null;
    if (isset($model) && $model->entity && $model->entity->image_uuid) {
        $preset = $model->entity->image;
    } else {
        $preset = FormCopy::field('image')->entity()->select();
    }
    @endphp

    <p class="help-block">
        {{ __('fields.gallery-image.description') }}
    </p>
    <x-grid type="3/4">
        <div class="col-span-3">
            <x-forms.foreign
                :campaign="$campaign"
                name="entity_image_uuid"
                :allowClear="true"
                :route="route('images.find', $campaign)"
                :label="__('crud.fields.image')"
                :placeholder="__('fields.gallery.placeholder')"
                :selected="$preset">
            </x-forms.foreign>
        </div>
            @if (!empty($model->entity) && !empty($model->entity->image_uuid) && !empty($model->entity->image))
                <div class="preview-v2">
                    <a class="h-28 cover-background relative inline-block w-full text-white bg-red-900/50 hover:bg-red-900/90" href="{{ route('campaign.gallery.index', ['folder_id' => $model->entity->image->folder_id]) }}" style="background-image: url('{{ $model->entity->image->getUrl(240,112) }}')" title="{{ $model->name }}">
                    </a>
                </div>
            @endif
    </x-grid>
    @if (!empty($model->entity) && !empty($model->entity->image_uuid) && empty($model->entity->image))
        <input type="hidden" name="entity_image_uuid" value="{{ $model->entity->image_uuid }}" />
    @endif
@else
    @include('cruds.fields.helpers.superboosted', ['key' => 'fields.gallery-image.boosted-description'])
@endif
