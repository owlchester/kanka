{{ csrf_field() }}
@inject('campaignService', 'App\Services\CampaignService')
<x-grid>
    <div class="field-name required">
        <label>{{ __('entities/links.fields.name') }}</label>
        {!! Form::text(
            'name',
            null,
            [
                'placeholder' => __('entities/links.placeholders.name'),
                'class' => 'form-control',
                'maxlength' => 45
            ]
        ) !!}
    </div>
    <div class="field-url required">
        <label>{{ __('entities/links.fields.url') }}</label>
        {!! Form::text(
            'metadata[url]',
            null,
            [
                'placeholder' => __('entities/links.placeholders.url'),
                'class' => 'form-control',
                'maxlength' => 255
            ]
        ) !!}
    </div>

    @include('cruds.fields.icon', ['placeholder' => 'fa-brands fa-d-and-d-beyond, ra ra-aura'])
    @include('cruds.fields.visibility_id', ['model' => $entity ?? null])
</x-grid>
<input type="hidden" name="type_id" value="{{ \App\Models\EntityAsset::TYPE_LINK }}" />
