
<x-grid type="1/1">
    @include('cruds.fields.image', ['imageRequired' => false, 'model' => $model])

    @includeWhen($campaign->boosted(), 'cruds.fields.entity_image')
</x-grid>
